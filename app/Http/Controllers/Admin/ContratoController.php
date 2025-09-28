<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\TipoContrato;
use App\Models\ContratoAditivo;
use App\Models\ContratoFiscalizacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contrato::with('tipoContrato');

        // Filtros
        if ($request->filled('tipo_contrato_id')) {
            $query->where('tipo_contrato_id', $request->tipo_contrato_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ano')) {
            $query->where('ano_referencia', $request->ano);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('objeto', 'like', "%{$search}%")
                  ->orWhere('contratado', 'like', "%{$search}%");
            });
        }

        $contratos = $query->orderBy('created_at', 'desc')->paginate(15);
        $tiposContrato = TipoContrato::ativos()->orderBy('nome')->get();
        $anos = Contrato::selectRaw('DISTINCT ano_referencia')->orderBy('ano_referencia', 'desc')->pluck('ano_referencia');

        // Calcular estatísticas
        $estatisticas = [
            'total' => Contrato::count(),
            'ativos' => Contrato::where('status', 'ativo')->count(),
            'vencidos' => Contrato::whereRaw('(data_fim_atual IS NOT NULL AND data_fim_atual < NOW()) OR (data_fim_atual IS NULL AND data_fim < NOW())')->count(),
            'valor_total' => Contrato::sum('valor_atual')
        ];

        return view('admin.contratos.index', compact('contratos', 'tiposContrato', 'anos', 'estatisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposContrato = TipoContrato::ativos()->orderBy('nome')->get();
        return view('admin.contratos.create', compact('tiposContrato'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Processar valores monetários formatados
        $data = $request->all();
        
        // Converter valores monetários de formato brasileiro para decimal
        if (isset($data['valor_inicial'])) {
            $data['valor_inicial'] = $this->convertMoneyToDecimal($data['valor_inicial']);
        }
        
        if (isset($data['valor_atual']) && !empty($data['valor_atual'])) {
            $data['valor_atual'] = $this->convertMoneyToDecimal($data['valor_atual']);
        } else {
            // Se valor_atual estiver vazio, usar valor_inicial
            $data['valor_atual'] = $data['valor_inicial'] ?? 0;
        }

        $validator = Validator::make($data, [
            'tipo_contrato_id' => 'required|exists:tipo_contratos,id',
            'numero' => 'required|string|max:255|unique:contratos,numero',
            'processo' => 'nullable|string|max:255',
            'objeto' => 'required|string',
            'contratado' => 'required|string|max:255',
            'cnpj_cpf_contratado' => 'nullable|string|max:20',
            'valor_inicial' => 'required|numeric|min:0',
            'valor_atual' => 'required|numeric|min:0',
            'data_assinatura' => 'required|date',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'data_fim_atual' => 'nullable|date',
            'status' => 'required|in:ativo,suspenso,encerrado,rescindido',
            'observacoes' => 'nullable|string',
            'publico' => 'boolean',
            'ano_referencia' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'arquivo_contrato' => 'nullable|file|mimes:pdf,doc,docx|max:10240' // 10MB
        ], [
            'tipo_contrato_id.required' => 'O tipo de contrato é obrigatório.',
            'numero.required' => 'O número do contrato é obrigatório.',
            'numero.unique' => 'Já existe um contrato com este número.',
            'objeto.required' => 'O objeto do contrato é obrigatório.',
            'contratado.required' => 'O nome do contratado é obrigatório.',
            'valor_inicial.required' => 'O valor inicial é obrigatório.',
            'valor_atual.required' => 'O valor atual é obrigatório.',
            'data_assinatura.required' => 'A data de assinatura é obrigatória.',
            'data_inicio.required' => 'A data de início é obrigatória.',
            'data_fim.required' => 'A data de fim é obrigatória.',
            'data_fim.after' => 'A data de fim deve ser posterior à data de início.',
            'status.required' => 'O status é obrigatório.',
            'ano_referencia.required' => 'O ano de referência é obrigatório.',
            'arquivo_contrato.mimes' => 'O arquivo deve ser PDF, DOC ou DOCX.',
            'arquivo_contrato.max' => 'O arquivo não pode ser maior que 10MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data['publico'] = $request->has('publico');

        // Upload do arquivo
        if ($request->hasFile('arquivo_contrato')) {
            $arquivo = $request->file('arquivo_contrato');
            $nomeOriginal = $arquivo->getClientOriginalName();
            $nomeArquivo = time() . '_' . Str::slug(pathinfo($nomeOriginal, PATHINFO_FILENAME)) . '.' . $arquivo->getClientOriginalExtension();
            
            $arquivo->storeAs('contratos', $nomeArquivo, 'public');
            
            $data['arquivo_contrato'] = $nomeArquivo;
            $data['arquivo_contrato_original'] = $nomeOriginal;
        }

        Contrato::create($data);

        return redirect()->route('admin.contratos.index')
            ->with('success', 'Contrato criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contrato $contrato)
    {
        $contrato->load(['tipoContrato', 'aditivos', 'fiscalizacoes']);
        return view('admin.contratos.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contrato $contrato)
    {
        $tiposContrato = TipoContrato::ativos()->orderBy('nome')->get();
        return view('admin.contratos.edit', compact('contrato', 'tiposContrato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contrato $contrato)
    {
        // Processar valores monetários formatados
        $data = $request->all();
        
        // Converter valores monetários de formato brasileiro para decimal
        if (isset($data['valor_inicial'])) {
            $data['valor_inicial'] = $this->convertMoneyToDecimal($data['valor_inicial']);
        }
        
        if (isset($data['valor_atual']) && !empty($data['valor_atual'])) {
            $data['valor_atual'] = $this->convertMoneyToDecimal($data['valor_atual']);
        } else {
            // Se valor_atual estiver vazio, usar valor_inicial
            $data['valor_atual'] = $data['valor_inicial'] ?? 0;
        }
        
        // Garantir que status e ano_referencia estejam definidos
        if (!isset($data['status']) || empty($data['status'])) {
            $data['status'] = $contrato->status ?? 'ativo';
        }
        
        if (!isset($data['ano_referencia']) || empty($data['ano_referencia'])) {
            $data['ano_referencia'] = $contrato->ano_referencia ?? date('Y');
        }

        $validator = Validator::make($data, [
            'tipo_contrato_id' => 'required|exists:tipo_contratos,id',
            'numero' => 'required|string|max:255|unique:contratos,numero,' . $contrato->id,
            'processo' => 'nullable|string|max:255',
            'objeto' => 'required|string',
            'contratado' => 'required|string|max:255',
            'cnpj_cpf_contratado' => 'nullable|string|max:20',
            'valor_inicial' => 'required|numeric|min:0',
            'valor_atual' => 'required|numeric|min:0',
            'data_assinatura' => 'required|date',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'data_fim_atual' => 'nullable|date',
            'status' => 'required|in:ativo,suspenso,encerrado,rescindido',
            'observacoes' => 'nullable|string',
            'publico' => 'boolean',
            'ano_referencia' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'arquivo_contrato' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ], [
            'tipo_contrato_id.required' => 'O tipo de contrato é obrigatório.',
            'numero.required' => 'O número do contrato é obrigatório.',
            'numero.unique' => 'Já existe um contrato com este número.',
            'objeto.required' => 'O objeto do contrato é obrigatório.',
            'contratado.required' => 'O nome do contratado é obrigatório.',
            'valor_inicial.required' => 'O valor inicial é obrigatório.',
            'valor_atual.required' => 'O valor atual é obrigatório.',
            'data_assinatura.required' => 'A data de assinatura é obrigatória.',
            'data_inicio.required' => 'A data de início é obrigatória.',
            'data_fim.required' => 'A data de fim é obrigatória.',
            'data_fim.after' => 'A data de fim deve ser posterior à data de início.',
            'status.required' => 'O status é obrigatório.',
            'ano_referencia.required' => 'O ano de referência é obrigatório.',
            'arquivo_contrato.mimes' => 'O arquivo deve ser PDF, DOC ou DOCX.',
            'arquivo_contrato.max' => 'O arquivo não pode ser maior que 10MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data['publico'] = $request->has('publico');

        // Upload do novo arquivo
        if ($request->hasFile('arquivo_contrato')) {
            // Remove o arquivo anterior se existir
            if ($contrato->arquivo_contrato && Storage::disk('public')->exists('contratos/' . $contrato->arquivo_contrato)) {
                Storage::disk('public')->delete('contratos/' . $contrato->arquivo_contrato);
            }

            $arquivo = $request->file('arquivo_contrato');
            $nomeOriginal = $arquivo->getClientOriginalName();
            $nomeArquivo = time() . '_' . Str::slug(pathinfo($nomeOriginal, PATHINFO_FILENAME)) . '.' . $arquivo->getClientOriginalExtension();
            
            $arquivo->storeAs('contratos', $nomeArquivo, 'public');
            
            $data['arquivo_contrato'] = $nomeArquivo;
            $data['arquivo_contrato_original'] = $nomeOriginal;
        }

        $contrato->update($data);

        return redirect()->route('admin.contratos.index')
            ->with('success', 'Contrato atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contrato $contrato)
    {
        // Remove o arquivo se existir
        if ($contrato->arquivo_contrato && Storage::disk('public')->exists('contratos/' . $contrato->arquivo_contrato)) {
            Storage::disk('public')->delete('contratos/' . $contrato->arquivo_contrato);
        }

        $contrato->delete();

        return redirect()->route('admin.contratos.index')
            ->with('success', 'Contrato excluído com sucesso!');
    }

    /**
     * Converte valor monetário formatado (ex: 5.000,00) para decimal (ex: 5000.00)
     */
    private function convertMoneyToDecimal($value)
    {
        if (empty($value)) {
            return 0;
        }
        
        // Remove espaços e caracteres não numéricos exceto vírgula e ponto
        $value = preg_replace('/[^\d,.]/', '', $value);
        
        // Se contém vírgula, assume formato brasileiro (1.000,00)
        if (strpos($value, ',') !== false) {
            // Remove pontos (separadores de milhares) e substitui vírgula por ponto
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }
        
        return (float) $value;
    }

    /**
     * Download do arquivo do contrato
     */
    public function downloadArquivo(Contrato $contrato)
    {
        if (!$contrato->arquivo_contrato || !Storage::disk('public')->exists('contratos/' . $contrato->arquivo_contrato)) {
            return redirect()->back()->with('error', 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download(
            'contratos/' . $contrato->arquivo_contrato,
            $contrato->arquivo_contrato_original ?? $contrato->arquivo_contrato
        );
    }

    /**
     * Remove arquivo do contrato
     */
    public function removeArquivo(Contrato $contrato)
    {
        if ($contrato->arquivo_contrato && Storage::disk('public')->exists('contratos/' . $contrato->arquivo_contrato)) {
            Storage::disk('public')->delete('contratos/' . $contrato->arquivo_contrato);
        }

        $contrato->update([
            'arquivo_contrato' => null,
            'arquivo_contrato_original' => null
        ]);

        return redirect()->back()->with('success', 'Arquivo removido com sucesso!');
    }

    /**
     * Gerenciar aditivos do contrato
     */
    public function aditivos(Contrato $contrato)
    {
        $aditivos = $contrato->aditivos()->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contratos.aditivos.index', compact('contrato', 'aditivos'));
    }

    /**
     * Armazenar novo aditivo do contrato
     */
    public function storeAditivo(Request $request, Contrato $contrato)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|string|max:255',
            'tipo' => 'required|in:prazo,valor,valor_prazo',
            'objeto' => 'required|string',
            'valor_aditivo' => 'nullable|numeric|min:0',
            'prazo_adicional_dias' => 'nullable|integer|min:0',
            'data_assinatura' => 'required|date',
            'data_inicio_vigencia' => 'nullable|date',
            'data_fim_vigencia' => 'nullable|date',
            'justificativa' => 'required|string',
            'observacoes' => 'nullable|string',
            'arquivo_aditivo' => 'nullable|file|mimes:pdf|max:10240',
            'publico' => 'boolean'
        ], [
            'numero.required' => 'O número do aditivo é obrigatório.',
            'tipo.required' => 'O tipo do aditivo é obrigatório.',
            'objeto.required' => 'O objeto do aditivo é obrigatório.',
            'data_assinatura.required' => 'A data de assinatura é obrigatória.',
            'justificativa.required' => 'A justificativa é obrigatória.',
            'arquivo_aditivo.mimes' => 'O arquivo deve ser um PDF.',
            'arquivo_aditivo.max' => 'O arquivo não pode ser maior que 10MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Erro ao criar aditivo. Verifique os dados informados.');
        }

        $data = $request->all();
        $data['contrato_id'] = $contrato->id;
        $data['publico'] = $request->has('publico');

        // Processar upload do arquivo PDF
        if ($request->hasFile('arquivo_aditivo')) {
            $arquivo = $request->file('arquivo_aditivo');
            $nomeArquivo = time() . '_aditivo_' . $contrato->numero . '_' . $data['numero'] . '.pdf';
            $caminhoArquivo = $arquivo->storeAs('contratos/aditivos', $nomeArquivo, 'public');
            $data['arquivo_aditivo'] = $nomeArquivo;
            $data['arquivo_aditivo_original'] = $arquivo->getClientOriginalName();
        }

        // Converter valor monetário se fornecido
        if (isset($data['valor_aditivo']) && !empty($data['valor_aditivo'])) {
            $data['valor_aditivo'] = $this->convertMoneyToDecimal($data['valor_aditivo']);
        } else {
            // Para aditivos que não envolvem valor (prazo), definir como 0
            $data['valor_aditivo'] = 0;
        }

        $aditivo = ContratoAditivo::create($data);

        // Atualizar campos do contrato baseado no tipo do aditivo
        $contratoAtualizado = false;
        
        // Atualizar data de fim se for aditivo de prazo
        if (in_array($data['tipo'], ['prazo', 'valor_prazo'])) {
            if (!empty($data['data_fim_vigencia'])) {
                // Usar a data específica do aditivo
                $contrato->data_fim_atual = $data['data_fim_vigencia'];
                $contratoAtualizado = true;
            } elseif (!empty($data['prazo_adicional_dias'])) {
                // Calcular nova data baseada no prazo adicional
                $dataBase = $contrato->data_fim_atual ?? $contrato->data_fim;
                $novaDataFim = \Carbon\Carbon::parse($dataBase)->addDays($data['prazo_adicional_dias']);
                $contrato->data_fim_atual = $novaDataFim->format('Y-m-d');
                $contratoAtualizado = true;
            }
        }
        
        // Atualizar valor se for aditivo de valor
        if (in_array($data['tipo'], ['valor', 'valor_prazo']) && !empty($data['valor_aditivo'])) {
            $contrato->valor_atual = ($contrato->valor_atual ?? $contrato->valor_inicial) + $data['valor_aditivo'];
            $contratoAtualizado = true;
        }

        // Adicionar observações na transparência baseado no tipo do aditivo
        $observacoesTransparencia = [];
        
        if (in_array($data['tipo'], ['prazo', 'valor_prazo']) && !empty($data['prazo_adicional_dias'])) {
            $observacoesTransparencia[] = "Aditivo de prazo: {$data['prazo_adicional_dias']} dias adicionais";
        }
        
        if (in_array($data['tipo'], ['valor', 'valor_prazo']) && !empty($data['valor_aditivo'])) {
            $valorFormatado = 'R$ ' . number_format($data['valor_aditivo'], 2, ',', '.');
            $observacoesTransparencia[] = "Aditivo de valor: {$valorFormatado}";
        }

        // Atualizar observações do contrato para transparência
        if (!empty($observacoesTransparencia)) {
            $novaObservacao = implode(' | ', $observacoesTransparencia);
            $observacoesAtuais = $contrato->observacoes_transparencia ?? '';
            
            if (!empty($observacoesAtuais)) {
                $contrato->observacoes_transparencia = $observacoesAtuais . ' | ' . $novaObservacao;
            } else {
                $contrato->observacoes_transparencia = $novaObservacao;
            }
            $contratoAtualizado = true;
        }

        // Salvar alterações no contrato se houver
        if ($contratoAtualizado) {
            $contrato->save();
        }

        return redirect()->route('admin.contratos.show', $contrato)
            ->with('success', 'Aditivo criado com sucesso!');
    }



    /**
     * Armazenar nova fiscalização do contrato
     */
    public function storeFiscalizacao(Request $request, Contrato $contrato)
    {
        $validator = Validator::make($request->all(), [
            'numero_relatorio' => 'nullable|string|max:255',
            'data_fiscalizacao' => 'required|date',
            'data_fim_vigencia' => 'nullable|date|after_or_equal:data_fiscalizacao',
            'fiscal_responsavel' => 'required|string|max:255',
            'numero_portaria' => 'nullable|string|max:255',
            'data_portaria' => 'nullable|date',
            'tipo_fiscalizacao' => 'required|in:rotina,especial,denuncia,auditoria',
            'objeto_fiscalizacao' => 'required|string',
            'observacoes_encontradas' => 'required|string',
            'status_execucao' => 'required|in:conforme,nao_conforme,parcialmente_conforme',
            'recomendacoes' => 'nullable|string',
            'providencias_adotadas' => 'nullable|string',
            'prazo_regularizacao' => 'nullable|date|after:data_fiscalizacao',
            'status_regularizacao' => 'nullable|in:pendente,em_andamento,regularizado,nao_aplicavel',
            'arquivo_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'publico' => 'boolean'
        ], [
            'data_fiscalizacao.required' => 'A data da fiscalização é obrigatória.',
            'fiscal_responsavel.required' => 'O fiscal responsável é obrigatório.',
            'tipo_fiscalizacao.required' => 'O tipo de fiscalização é obrigatório.',
            'objeto_fiscalizacao.required' => 'O objeto da fiscalização é obrigatório.',
            'observacoes_encontradas.required' => 'As observações encontradas são obrigatórias.',
            'status_execucao.required' => 'O status de execução é obrigatório.',
            'data_fim_vigencia.after_or_equal' => 'A data fim da vigência deve ser posterior ou igual à data da fiscalização.',
            'prazo_regularizacao.after' => 'O prazo de regularização deve ser posterior à data da fiscalização.',
            'arquivo_pdf.mimes' => 'O arquivo deve ser um PDF.',
            'arquivo_pdf.max' => 'O arquivo PDF não pode ser maior que 10MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Erro ao criar fiscalização. Verifique os dados informados.');
        }

        $data = $request->all();
        $data['contrato_id'] = $contrato->id;

        // Processar upload do PDF
        if ($request->hasFile('arquivo_pdf')) {
            $arquivo = $request->file('arquivo_pdf');
            $nomeOriginal = $arquivo->getClientOriginalName();
            $nomeArquivo = time() . '_' . Str::slug(pathinfo($nomeOriginal, PATHINFO_FILENAME)) . '.pdf';
            
            // Salvar arquivo
            $arquivo->storeAs('contratos/fiscalizacoes/pdfs', $nomeArquivo, 'public');
            
            $data['arquivo_pdf'] = $nomeArquivo;
            $data['arquivo_pdf_original'] = $nomeOriginal;
        }

        // Definir valores padrão
        $data['publico'] = $request->has('publico') ? true : false;
        $data['status_regularizacao'] = $data['status_regularizacao'] ?? 'nao_aplicavel';

        ContratoFiscalizacao::create($data);

        return redirect()->route('admin.contratos.show', $contrato)
            ->with('success', 'Fiscalização criada com sucesso!');
    }

    /**
     * Visualizar aditivo específico
     */
    public function showAditivo(Contrato $contrato, ContratoAditivo $aditivo)
    {
        // Verificar se o aditivo pertence ao contrato
        if ($aditivo->contrato_id !== $contrato->id) {
            abort(404);
        }

        return view('admin.contratos.aditivos.show', compact('contrato', 'aditivo'));
    }

    /**
     * Editar aditivo
     */
    public function editAditivo(Contrato $contrato, ContratoAditivo $aditivo)
    {
        // Verificar se o aditivo pertence ao contrato
        if ($aditivo->contrato_id !== $contrato->id) {
            abort(404);
        }

        return view('admin.contratos.aditivos.edit', compact('contrato', 'aditivo'));
    }

    /**
     * Atualizar aditivo
     */
    public function updateAditivo(Request $request, Contrato $contrato, ContratoAditivo $aditivo)
    {
        // Verificar se o aditivo pertence ao contrato
        if ($aditivo->contrato_id !== $contrato->id) {
            abort(404);
        }

        // Processar valores monetários formatados
        $data = $request->all();
        
        // Converter valor monetário de formato brasileiro para decimal
        if (isset($data['valor_aditivo']) && !empty($data['valor_aditivo'])) {
            $data['valor_aditivo'] = $this->convertMoneyToDecimal($data['valor_aditivo']);
        } else {
            $data['valor_aditivo'] = 0;
        }

        $validator = Validator::make($data, [
            'numero' => 'required|string|max:255',
            'tipo' => 'required|in:valor,prazo,valor_prazo',
            'objeto' => 'required|string',
            'valor_aditivo' => 'nullable|numeric|min:0',
            'prazo_adicional_dias' => 'nullable|integer|min:0',
            'data_assinatura' => 'required|date',
            'data_inicio_vigencia' => 'nullable|date',
            'data_fim_vigencia' => 'nullable|date',
            'justificativa' => 'required|string',
            'observacoes' => 'nullable|string',
            'arquivo_aditivo' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'publico' => 'boolean'
        ], [
            'numero.required' => 'O número do aditivo é obrigatório.',
            'tipo.required' => 'O tipo do aditivo é obrigatório.',
            'objeto.required' => 'O objeto do aditivo é obrigatório.',
            'data_assinatura.required' => 'A data de assinatura é obrigatória.',
            'justificativa.required' => 'A justificativa é obrigatória.',
            'arquivo_aditivo.mimes' => 'O arquivo deve ser PDF, DOC ou DOCX.',
            'arquivo_aditivo.max' => 'O arquivo não pode ser maior que 10MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Erro ao atualizar aditivo. Verifique os dados informados.');
        }

        // Upload do arquivo se fornecido
        if ($request->hasFile('arquivo_aditivo')) {
            // Remover arquivo anterior se existir
            if ($aditivo->arquivo_aditivo && Storage::exists('contratos/aditivos/' . $aditivo->arquivo_aditivo)) {
                Storage::delete('contratos/aditivos/' . $aditivo->arquivo_aditivo);
            }

            $arquivo = $request->file('arquivo_aditivo');
            $nomeArquivo = time() . '_' . Str::slug(pathinfo($arquivo->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->storeAs('contratos/aditivos', $nomeArquivo);
            
            $data['arquivo_aditivo'] = $nomeArquivo;
            $data['arquivo_aditivo_original'] = $arquivo->getClientOriginalName();
        }

        $aditivo->update($data);

        return redirect()->route('admin.contratos.show', $contrato)
            ->with('success', 'Aditivo atualizado com sucesso!');
    }

    /**
     * Excluir aditivo
     */
    public function destroyAditivo(Contrato $contrato, ContratoAditivo $aditivo)
    {
        // Verificar se o aditivo pertence ao contrato
        if ($aditivo->contrato_id !== $contrato->id) {
            abort(404);
        }

        // Remover arquivo se existir
        if ($aditivo->arquivo_aditivo && Storage::exists('contratos/aditivos/' . $aditivo->arquivo_aditivo)) {
            Storage::delete('contratos/aditivos/' . $aditivo->arquivo_aditivo);
        }

        $aditivo->delete();

        return redirect()->route('admin.contratos.show', $contrato)
            ->with('success', 'Aditivo excluído com sucesso!');
    }

    /**
     * Download do arquivo do aditivo
     */
    public function downloadAditivo(Contrato $contrato, ContratoAditivo $aditivo)
    {
        // Verificar se o aditivo pertence ao contrato
        if ($aditivo->contrato_id !== $contrato->id) {
            abort(404);
        }

        if (!$aditivo->arquivo_aditivo || !Storage::exists('contratos/aditivos/' . $aditivo->arquivo_aditivo)) {
            return redirect()->back()->with('error', 'Arquivo não encontrado.');
        }

        $nomeOriginal = $aditivo->arquivo_aditivo_original ?? $aditivo->arquivo_aditivo;
        
        return Storage::download('contratos/aditivos/' . $aditivo->arquivo_aditivo, $nomeOriginal);
    }

    /**
     * Download do PDF da fiscalização (área administrativa)
     */
    public function downloadFiscalizacaoPdf(Contrato $contrato, ContratoFiscalizacao $fiscalizacao)
    {
        // Verificar se a fiscalização pertence ao contrato
        if ($fiscalizacao->contrato_id !== $contrato->id) {
            abort(404);
        }

        if (!$fiscalizacao->arquivo_pdf || !Storage::disk('public')->exists('contratos/fiscalizacoes/pdfs/' . $fiscalizacao->arquivo_pdf)) {
            return redirect()->back()->with('error', 'Arquivo PDF não encontrado.');
        }

        $nomeOriginal = $fiscalizacao->arquivo_pdf_original ?? $fiscalizacao->arquivo_pdf;
        
        return Storage::disk('public')->download('contratos/fiscalizacoes/pdfs/' . $fiscalizacao->arquivo_pdf, $nomeOriginal);
    }

    /**
     * Download público do PDF da fiscalização
     */
    public function downloadFiscalizacaoPdfPublico(Contrato $contrato, ContratoFiscalizacao $fiscalizacao)
    {
        // Verificar se a fiscalização pertence ao contrato
        if ($fiscalizacao->contrato_id !== $contrato->id) {
            abort(404);
        }

        // Verificar se o PDF é público
        if (!$fiscalizacao->publico) {
            abort(403, 'Este documento não está disponível para acesso público.');
        }

        if (!$fiscalizacao->arquivo_pdf || !Storage::disk('public')->exists('contratos/fiscalizacoes/pdfs/' . $fiscalizacao->arquivo_pdf)) {
            abort(404, 'Arquivo PDF não encontrado.');
        }

        $nomeOriginal = $fiscalizacao->arquivo_pdf_original ?? $fiscalizacao->arquivo_pdf;
        
        return Storage::disk('public')->download('contratos/fiscalizacoes/pdfs/' . $fiscalizacao->arquivo_pdf, $nomeOriginal);
    }
}
