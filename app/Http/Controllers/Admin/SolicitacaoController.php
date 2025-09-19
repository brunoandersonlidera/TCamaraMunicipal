<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SolicitacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Solicitacao::query();

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('email', 'like', "%{$busca}%")
                  ->orWhere('assunto', 'like', "%{$busca}%")
                  ->orWhere('protocolo', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'created_at');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        $solicitacoes = $query->paginate(15)->withQueryString();

        // Estatísticas
        $estatisticas = [
            'total' => Solicitacao::count(),
            'pendentes' => Solicitacao::where('status', 'pendente')->count(),
            'em_andamento' => Solicitacao::where('status', 'em_andamento')->count(),
            'respondidas' => Solicitacao::where('status', 'respondida')->count(),
            'arquivadas' => Solicitacao::where('status', 'arquivada')->count(),
        ];

        // Tipos de solicitação
        $tipos = [
            'informacao' => 'Solicitação de Informação',
            'documento' => 'Solicitação de Documento',
            'esclarecimento' => 'Pedido de Esclarecimento',
            'reclamacao' => 'Reclamação',
            'sugestao' => 'Sugestão',
            'outros' => 'Outros'
        ];

        // Status disponíveis
        $statusOptions = [
            'pendente' => 'Pendente',
            'em_andamento' => 'Em Andamento',
            'respondida' => 'Respondida',
            'arquivada' => 'Arquivada'
        ];

        return view('admin.solicitacoes.index', compact(
            'solicitacoes', 
            'estatisticas', 
            'tipos', 
            'statusOptions'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitacao $solicitacao)
    {
        // Marcar como visualizada se ainda não foi
        if (!$solicitacao->visualizada_em) {
            $solicitacao->update(['visualizada_em' => now()]);
        }

        $tipos = [
            'informacao' => 'Solicitação de Informação',
            'documento' => 'Solicitação de Documento',
            'esclarecimento' => 'Pedido de Esclarecimento',
            'reclamacao' => 'Reclamação',
            'sugestao' => 'Sugestão',
            'outros' => 'Outros'
        ];

        return view('admin.solicitacoes.show', compact('solicitacao', 'tipos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solicitacao $solicitacao)
    {
        $tipos = [
            'informacao' => 'Solicitação de Informação',
            'documento' => 'Solicitação de Documento',
            'esclarecimento' => 'Pedido de Esclarecimento',
            'reclamacao' => 'Reclamação',
            'sugestao' => 'Sugestão',
            'outros' => 'Outros'
        ];

        $statusOptions = [
            'pendente' => 'Pendente',
            'em_andamento' => 'Em Andamento',
            'respondida' => 'Respondida',
            'arquivada' => 'Arquivada'
        ];

        return view('admin.solicitacoes.edit', compact('solicitacao', 'tipos', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solicitacao $solicitacao)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pendente,em_andamento,respondida,arquivada',
            'observacoes_internas' => 'nullable|string|max:2000',
            'resposta' => 'nullable|string|max:5000',
            'arquivo_resposta' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ], [
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
            'observacoes_internas.max' => 'As observações internas não podem ter mais de 2000 caracteres.',
            'resposta.max' => 'A resposta não pode ter mais de 5000 caracteres.',
            'arquivo_resposta.file' => 'O arquivo de resposta deve ser um arquivo válido.',
            'arquivo_resposta.mimes' => 'O arquivo deve ser do tipo: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX.',
            'arquivo_resposta.max' => 'O arquivo não pode ser maior que 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dados = $request->only(['status', 'observacoes_internas', 'resposta']);

        // Upload do arquivo de resposta
        if ($request->hasFile('arquivo_resposta')) {
            // Remover arquivo anterior se existir
            if ($solicitacao->arquivo_resposta) {
                Storage::disk('public')->delete($solicitacao->arquivo_resposta);
            }

            $arquivo = $request->file('arquivo_resposta');
            $nomeArquivo = time() . '_resposta_' . $arquivo->getClientOriginalName();
            $caminhoArquivo = $arquivo->storeAs('solicitacoes/respostas', $nomeArquivo, 'public');
            
            $dados['arquivo_resposta'] = $caminhoArquivo;
            $dados['nome_arquivo_resposta'] = $arquivo->getClientOriginalName();
            $dados['tamanho_arquivo_resposta'] = $arquivo->getSize();
        }

        // Definir data de resposta se status for 'respondida'
        if ($request->status === 'respondida' && $solicitacao->status !== 'respondida') {
            $dados['respondida_em'] = now();
        }

        // Definir data de arquivamento se status for 'arquivada'
        if ($request->status === 'arquivada' && $solicitacao->status !== 'arquivada') {
            $dados['arquivada_em'] = now();
        }

        $solicitacao->update($dados);

        return redirect()->route('admin.solicitacoes.show', $solicitacao)
            ->with('success', 'Solicitação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitacao $solicitacao)
    {
        // Remover arquivos se existirem
        if ($solicitacao->arquivo_resposta) {
            Storage::disk('public')->delete($solicitacao->arquivo_resposta);
        }

        $solicitacao->delete();

        return redirect()->route('admin.solicitacoes.index')
            ->with('success', 'Solicitação excluída com sucesso!');
    }

    /**
     * Alterar status da solicitação
     */
    public function updateStatus(Request $request, Solicitacao $solicitacao)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pendente,em_andamento,respondida,arquivada',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $dados = ['status' => $request->status];

        // Definir timestamps específicos
        if ($request->status === 'respondida' && $solicitacao->status !== 'respondida') {
            $dados['respondida_em'] = now();
        }

        if ($request->status === 'arquivada' && $solicitacao->status !== 'arquivada') {
            $dados['arquivada_em'] = now();
        }

        $solicitacao->update($dados);

        return redirect()->back()
            ->with('success', 'Status da solicitação atualizado com sucesso!');
    }

    /**
     * Responder solicitação
     */
    public function responder(Request $request, Solicitacao $solicitacao)
    {
        $validator = Validator::make($request->all(), [
            'resposta' => 'required|string|max:5000',
            'arquivo_resposta' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ], [
            'resposta.required' => 'A resposta é obrigatória.',
            'resposta.max' => 'A resposta não pode ter mais de 5000 caracteres.',
            'arquivo_resposta.file' => 'O arquivo de resposta deve ser um arquivo válido.',
            'arquivo_resposta.mimes' => 'O arquivo deve ser do tipo: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX.',
            'arquivo_resposta.max' => 'O arquivo não pode ser maior que 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dados = [
            'resposta' => $request->resposta,
            'status' => 'respondida',
            'respondida_em' => now(),
        ];

        // Upload do arquivo de resposta
        if ($request->hasFile('arquivo_resposta')) {
            // Remover arquivo anterior se existir
            if ($solicitacao->arquivo_resposta) {
                Storage::disk('public')->delete($solicitacao->arquivo_resposta);
            }

            $arquivo = $request->file('arquivo_resposta');
            $nomeArquivo = time() . '_resposta_' . $arquivo->getClientOriginalName();
            $caminhoArquivo = $arquivo->storeAs('solicitacoes/respostas', $nomeArquivo, 'public');
            
            $dados['arquivo_resposta'] = $caminhoArquivo;
            $dados['nome_arquivo_resposta'] = $arquivo->getClientOriginalName();
            $dados['tamanho_arquivo_resposta'] = $arquivo->getSize();
        }

        $solicitacao->update($dados);

        return redirect()->route('admin.solicitacoes.show', $solicitacao)
            ->with('success', 'Resposta enviada com sucesso!');
    }

    /**
     * Download do arquivo de resposta
     */
    public function downloadResposta(Solicitacao $solicitacao)
    {
        if (!$solicitacao->arquivo_resposta || !Storage::disk('public')->exists($solicitacao->arquivo_resposta)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download(
            $solicitacao->arquivo_resposta,
            $solicitacao->nome_arquivo_resposta ?? 'resposta.pdf'
        );
    }

    /**
     * Arquivar solicitação
     */
    public function arquivar(Solicitacao $solicitacao)
    {
        $solicitacao->update([
            'status' => 'arquivada',
            'arquivada_em' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Solicitação arquivada com sucesso!');
    }

    /**
     * Desarquivar solicitação
     */
    public function desarquivar(Solicitacao $solicitacao)
    {
        $solicitacao->update([
            'status' => 'pendente',
            'arquivada_em' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Solicitação desarquivada com sucesso!');
    }

    /**
     * Obter estatísticas das solicitações
     */
    public function estatisticas()
    {
        $estatisticas = [
            'total' => Solicitacao::count(),
            'pendentes' => Solicitacao::where('status', 'pendente')->count(),
            'em_andamento' => Solicitacao::where('status', 'em_andamento')->count(),
            'respondidas' => Solicitacao::where('status', 'respondida')->count(),
            'arquivadas' => Solicitacao::where('status', 'arquivada')->count(),
            'nao_visualizadas' => Solicitacao::whereNull('visualizada_em')->count(),
            'tempo_medio_resposta' => $this->calcularTempoMedioResposta(),
            'por_tipo' => Solicitacao::selectRaw('tipo, COUNT(*) as total')
                ->groupBy('tipo')
                ->pluck('total', 'tipo')
                ->toArray(),
            'por_mes' => Solicitacao::selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
                ->groupBy('ano', 'mes')
                ->orderBy('ano', 'desc')
                ->orderBy('mes', 'desc')
                ->limit(12)
                ->get()
                ->toArray(),
        ];

        return response()->json($estatisticas);
    }

    /**
     * Calcular tempo médio de resposta em dias
     */
    private function calcularTempoMedioResposta()
    {
        $solicitacoesRespondidas = Solicitacao::whereNotNull('respondida_em')->get();
        
        if ($solicitacoesRespondidas->isEmpty()) {
            return 0;
        }

        $totalDias = $solicitacoesRespondidas->sum(function ($solicitacao) {
            return $solicitacao->created_at->diffInDays($solicitacao->respondida_em);
        });

        return round($totalDias / $solicitacoesRespondidas->count(), 1);
    }
}