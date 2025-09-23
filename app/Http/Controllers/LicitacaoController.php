<?php

namespace App\Http\Controllers;

use App\Models\Licitacao;
use App\Models\LicitacaoDocumento;
use App\Models\Modalidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LicitacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Licitacao::with(['documentos']);

        // Filtro por ano
        if ($request->filled('ano')) {
            $query->where('ano_referencia', $request->ano);
        }

        // Filtro por modalidade
        if ($request->filled('modalidade')) {
            $query->where('modalidade', $request->modalidade);
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Busca por texto
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('numero_processo', 'like', "%{$busca}%")
                  ->orWhere('objeto', 'like', "%{$busca}%")
                  ->orWhere('vencedor', 'like', "%{$busca}%");
            });
        }

        $licitacoes = $query->orderBy('data_abertura', 'desc')->paginate(15);

        // Obter anos para filtro
        $anos = Licitacao::selectRaw('DISTINCT ano_referencia')
                         ->orderBy('ano_referencia', 'desc')
                         ->pluck('ano_referencia');

        // Obter modalidades para filtro
        $modalidades = Licitacao::selectRaw('DISTINCT modalidade')
                                ->orderBy('modalidade')
                                ->pluck('modalidade');

        return view('admin.licitacoes.index', compact('licitacoes', 'anos', 'modalidades'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_processo' => 'required|string|max:50|unique:licitacoes',
            'numero_edital' => 'nullable|string|max:50',
            'modalidade' => 'required|string|max:100',
            'tipo' => 'required|string|max:100',
            'objeto' => 'required|string|max:1000',
            'descricao_detalhada' => 'nullable|string',
            'valor_estimado' => 'required|numeric|min:0',
            'data_abertura' => 'required|date',
            'local_abertura' => 'nullable|string|max:255',
            'responsavel' => 'nullable|string|max:255',
            'ano_referencia' => 'required|integer|min:2020|max:2030',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:publicado,em_andamento,homologado,deserto,fracassado,cancelado',
            'documentos' => 'nullable|array',
            'documentos.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,txt|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $licitacao = Licitacao::create($request->only([
            'numero_processo', 'numero_edital', 'modalidade', 'tipo', 'objeto', 
            'descricao_detalhada', 'valor_estimado', 'data_abertura', 'local_abertura', 
            'responsavel', 'ano_referencia', 'observacoes', 'status'
        ]));

        // Processar documentos
        if ($request->has('documentos')) {
            $this->processarDocumentos($licitacao, $request->input('documentos'));
        }

        return redirect()->route('admin.licitacoes.index')
                        ->with('success', 'Licitação cadastrada com sucesso!');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Licitacao $licitacao)
    {
        $validator = Validator::make($request->all(), [
            'numero_processo' => 'required|string|max:50|unique:licitacoes,numero_processo,' . $licitacao->id,
            'numero_edital' => 'nullable|string|max:50',
            'modalidade' => 'required|string|max:100',
            'tipo' => 'required|string|max:100',
            'objeto' => 'required|string|max:1000',
            'descricao_detalhada' => 'nullable|string',
            'valor_estimado' => 'required|numeric|min:0',
            'data_abertura' => 'required|date',
            'local_abertura' => 'nullable|string|max:255',
            'responsavel' => 'nullable|string|max:255',
            'ano_referencia' => 'required|integer|min:2020|max:2030',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:publicado,em_andamento,homologado,deserto,fracassado,cancelado',
            'documentos' => 'nullable|array',
            'documentos.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,txt|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $licitacao->update($request->only([
            'numero_processo', 'numero_edital', 'modalidade', 'tipo', 'objeto', 
            'descricao_detalhada', 'valor_estimado', 'data_abertura', 'local_abertura', 
            'responsavel', 'ano_referencia', 'observacoes', 'status'
        ]));

        // Processar novos documentos
        if ($request->has('documentos')) {
            $this->processarDocumentos($licitacao, $request->input('documentos'));
        }

        return redirect()->route('admin.licitacoes.index')
                        ->with('success', 'Licitação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Licitacao $licitacao)
    {
        // Remover todos os documentos associados
        foreach ($licitacao->documentos as $documento) {
            $caminhoArquivo = 'licitacoes/documentos/' . $documento->arquivo;
            if (Storage::disk('public')->exists($caminhoArquivo)) {
                Storage::disk('public')->delete($caminhoArquivo);
            }
            $documento->delete();
        }

        $licitacao->delete();

        return redirect()->route('admin.licitacoes.index')
                        ->with('success', 'Licitação excluída com sucesso!');
    }

    /**
     * Processar upload de documentos
     */
    private function processarDocumentos(Licitacao $licitacao, $documentos)
    {
        if (!$documentos) {
            return;
        }

        foreach ($documentos as $index => $documento) {
            // Se for um array com dados do formulário
            if (is_array($documento) && isset($documento['arquivo'])) {
                $arquivo = $documento['arquivo'];
                $nomeArquivo = time() . '_' . $index . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
                $caminhoArquivo = $arquivo->storeAs('licitacoes/documentos', $nomeArquivo, 'public');

                LicitacaoDocumento::create([
                    'licitacao_id' => $licitacao->id,
                    'nome' => $documento['nome'] ?? $arquivo->getClientOriginalName(),
                    'descricao' => $documento['descricao'] ?? null,
                    'arquivo' => $nomeArquivo,
                    'arquivo_original' => $arquivo->getClientOriginalName(),
                    'tipo_mime' => $arquivo->getMimeType(),
                    'tamanho' => $arquivo->getSize(),
                    'tipo_documento' => $documento['tipo_documento'] ?? 'outros',
                    'publico' => isset($documento['publico']) ? true : false,
                    'ordem' => $index + 1
                ]);
            }
            // Se for apenas um arquivo (compatibilidade com versão anterior)
            elseif (is_object($documento)) {
                $nomeArquivo = time() . '_' . $index . '_' . Str::random(10) . '.' . $documento->getClientOriginalExtension();
                $caminhoArquivo = $documento->storeAs('licitacoes/documentos', $nomeArquivo, 'public');

                LicitacaoDocumento::create([
                    'licitacao_id' => $licitacao->id,
                    'nome' => $documento->getClientOriginalName(),
                    'arquivo' => $nomeArquivo,
                    'arquivo_original' => $documento->getClientOriginalName(),
                    'tipo_mime' => $documento->getMimeType(),
                    'tamanho' => $documento->getSize(),
                    'tipo_documento' => 'outros',
                    'publico' => true,
                    'ordem' => $index + 1
                ]);
            }
        }
    }

    /**
     * Exibir licitação com documentos
     */
    public function show(Licitacao $licitacao)
    {
        $licitacao->load('documentos');
        return view('admin.licitacoes.show', compact('licitacao'));
    }

    /**
     * Editar licitação com documentos
     */
    public function edit(Licitacao $licitacao)
    {
        // Modalidades disponíveis baseadas no seeder
        $modalidades = [
            'Pregão Eletrônico',
            'Pregão Presencial', 
            'Tomada de Preços',
            'Concorrência',
            'Convite',
            'Dispensa',
            'Inexigibilidade'
        ];

        $licitacao->load('documentos');

        return view('admin.licitacoes.edit', compact('licitacao', 'modalidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Modalidades disponíveis baseadas no seeder
        $modalidades = [
            'Pregão Eletrônico',
            'Pregão Presencial', 
            'Tomada de Preços',
            'Concorrência',
            'Convite',
            'Dispensa',
            'Inexigibilidade'
        ];
        
        return view('admin.licitacoes.create', compact('modalidades'));
    }

    /**
     * Download de documento
     */
    public function downloadDocumento(LicitacaoDocumento $documento)
    {
        $caminhoArquivo = 'licitacoes/documentos/' . $documento->arquivo;
        
        if (!Storage::disk('public')->exists($caminhoArquivo)) {
            abort(404, 'Arquivo não encontrado');
        }

        return Storage::disk('public')->download(
            $caminhoArquivo,
            $documento->arquivo_original
        );
    }

    /**
     * Excluir documento específico
     */
    public function excluirDocumento(LicitacaoDocumento $documento)
    {
        $caminhoArquivo = 'licitacoes/documentos/' . $documento->arquivo;
        
        if (Storage::disk('public')->exists($caminhoArquivo)) {
            Storage::disk('public')->delete($caminhoArquivo);
        }

        $licitacaoId = $documento->licitacao_id;
        $documento->delete();

        return redirect()->route('admin.licitacoes.edit', $licitacaoId)
                        ->with('success', 'Documento excluído com sucesso!');
    }
}
