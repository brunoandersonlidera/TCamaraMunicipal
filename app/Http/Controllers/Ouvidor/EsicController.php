<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use App\Models\EsicSolicitacao;
use App\Models\EsicTramitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EsicController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ouvidor']);
    }

    /**
     * Lista as solicitações e-SIC do ouvidor
     */
    public function index(Request $request)
    {
        $query = EsicSolicitacao::with(['cidadao', 'responsavel'])
            ->where('responsavel_id', Auth::id());

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('prazo')) {
            switch ($request->prazo) {
                case 'vencidas':
                    $query->where('prazo_resposta', '<', now());
                    break;
                case 'vencendo':
                    $query->whereBetween('prazo_resposta', [now(), now()->addDays(3)]);
                    break;
                case 'no_prazo':
                    $query->where('prazo_resposta', '>', now()->addDays(3));
                    break;
            }
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('protocolo', 'like', "%{$busca}%")
                  ->orWhere('assunto', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhereHas('cidadao', function ($q) use ($busca) {
                      $q->where('name', 'like', "%{$busca}%")
                        ->orWhere('email', 'like', "%{$busca}%");
                  });
            });
        }

        $solicitacoes = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('ouvidor.esic.index', compact('solicitacoes'));
    }

    /**
     * Exibe uma solicitação e-SIC específica
     */
    public function show(EsicSolicitacao $solicitacao)
    {
        // Verificar se o ouvidor tem acesso a esta solicitação
        if ($solicitacao->responsavel_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para acessar esta solicitação.');
        }

        $solicitacao->load(['cidadao', 'responsavel', 'tramitacoes.usuario', 'anexos']);

        return view('ouvidor.esic.show', compact('solicitacao'));
    }

    /**
     * Responde a uma solicitação e-SIC
     */
    public function responder(Request $request, EsicSolicitacao $solicitacao)
    {
        // Verificar se o ouvidor tem acesso a esta solicitação
        if ($solicitacao->responsavel_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para responder esta solicitação.');
        }

        $request->validate([
            'resposta' => 'required|string|min:10',
            'status' => 'required|in:respondida,parcialmente_respondida,finalizada',
            'anexos.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx'
        ]);

        DB::transaction(function () use ($request, $solicitacao) {
            // Atualizar solicitação
            $solicitacao->update([
                'resposta' => $request->resposta,
                'status' => $request->status,
                'respondida_em' => now(),
                'respondida_por' => Auth::id()
            ]);

            // Adicionar tramitação
            EsicTramitacao::create([
                'solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'acao' => 'resposta',
                'descricao' => 'Resposta enviada pelo responsável',
                'observacoes' => $request->resposta
            ]);

            // Processar anexos se houver
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                    $caminho = $arquivo->storeAs('esic/respostas', $nomeArquivo, 'public');
                    
                    $solicitacao->anexos()->create([
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tipo' => 'resposta',
                        'tamanho' => $arquivo->getSize(),
                        'mime_type' => $arquivo->getMimeType()
                    ]);
                }
            }
        });

        return redirect()->route('ouvidor.esic.show', $solicitacao)
            ->with('success', 'Resposta enviada com sucesso!');
    }

    /**
     * Altera o status de uma solicitação e-SIC
     */
    public function alterarStatus(Request $request, EsicSolicitacao $solicitacao)
    {
        // Verificar se o ouvidor tem acesso a esta solicitação
        if ($solicitacao->responsavel_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para alterar esta solicitação.');
        }

        $request->validate([
            'status' => 'required|in:nova,em_andamento,respondida,parcialmente_respondida,finalizada,negada,arquivada',
            'observacoes' => 'nullable|string|max:500'
        ]);

        DB::transaction(function () use ($request, $solicitacao) {
            $statusAnterior = $solicitacao->status;
            
            $solicitacao->update([
                'status' => $request->status
            ]);

            // Adicionar tramitação
            EsicTramitacao::create([
                'solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'acao' => 'alteracao_status',
                'descricao' => "Status alterado de '{$statusAnterior}' para '{$request->status}'",
                'observacoes' => $request->observacoes
            ]);
        });

        return redirect()->back()->with('success', 'Status alterado com sucesso!');
    }

    /**
     * Adiciona uma tramitação à solicitação e-SIC
     */
    public function adicionarTramitacao(Request $request, EsicSolicitacao $solicitacao)
    {
        // Verificar se o ouvidor tem acesso a esta solicitação
        if ($solicitacao->responsavel_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para tramitar esta solicitação.');
        }

        $request->validate([
            'acao' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        EsicTramitacao::create([
            'solicitacao_id' => $solicitacao->id,
            'usuario_id' => Auth::id(),
            'acao' => $request->acao,
            'descricao' => $request->descricao,
            'observacoes' => $request->observacoes
        ]);

        return redirect()->back()->with('success', 'Tramitação adicionada com sucesso!');
    }

    /**
     * Arquiva uma solicitação e-SIC
     */
    public function arquivar(Request $request, EsicSolicitacao $solicitacao)
    {
        // Verificar se o ouvidor tem acesso a esta solicitação
        if ($solicitacao->responsavel_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para arquivar esta solicitação.');
        }

        $request->validate([
            'motivo' => 'required|string|max:500'
        ]);

        DB::transaction(function () use ($request, $solicitacao) {
            $solicitacao->update([
                'status' => 'arquivada',
                'arquivada_em' => now(),
                'arquivada_por' => Auth::id()
            ]);

            // Adicionar tramitação
            EsicTramitacao::create([
                'solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'acao' => 'arquivamento',
                'descricao' => 'Solicitação arquivada',
                'observacoes' => $request->motivo
            ]);
        });

        return redirect()->route('ouvidor.esic.index')
            ->with('success', 'Solicitação arquivada com sucesso!');
    }
}