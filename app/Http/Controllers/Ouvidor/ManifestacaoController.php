<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use App\Models\OuvidoriaManifestacao;
use App\Models\OuvidoriaMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManifestacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ouvidor']);
    }

    /**
     * Lista as manifestações do ouvidor
     */
    public function index(Request $request)
    {
        // Todos os ouvidores ativos têm acesso a todas as manifestações
        $query = OuvidoriaManifestacao::with(['ouvidorResponsavel']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
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
                  ->orWhereHas('user', function ($q) use ($busca) {
                      $q->where('name', 'like', "%{$busca}%")
                        ->orWhere('email', 'like', "%{$busca}%");
                  });
            });
        }

        $manifestacoes = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('ouvidor.manifestacoes.index', compact('manifestacoes'));
    }

    /**
     * Exibe uma manifestação específica
     */
    public function show(OuvidoriaManifestacao $manifestacao)
    {
        // Todos os ouvidores ativos têm acesso a todas as manifestações
        $manifestacao->load(['ouvidorResponsavel', 'movimentacoes.usuario', 'anexos']);

        return view('ouvidor.manifestacoes.show', compact('manifestacao'));
    }

    /**
     * Responde a uma manifestação
     */
    public function responder(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        // Todos os ouvidores ativos podem responder qualquer manifestação

        $request->validate([
            'resposta' => 'required|string|min:10',
            'status' => 'required|in:respondida,em_analise,em_tramitacao,finalizada',
            'anexos.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png'
        ]);

        DB::transaction(function () use ($request, $manifestacao) {
            // Atualizar manifestação
            $manifestacao->update([
                'resposta' => $request->resposta,
                'status' => $request->status,
                'respondida_em' => now(),
                'respondida_por' => Auth::id()
            ]);

            // Preparar descrição da movimentação
            $descricao = 'Resposta enviada pelo ouvidor';
            if ($request->filled('observacoes_internas')) {
                $descricao .= "\n\nObservações Internas: " . $request->observacoes_internas;
            }
            if ($request->filled('resposta')) {
                $descricao .= "\n\nResposta: " . Str::limit($request->resposta, 200);
            }

            // Adicionar movimentação
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'usuario_id' => Auth::id(),
                'status' => $request->status,
                'descricao' => $descricao,
                'data_movimentacao' => now(),
            ]);

            // Processar anexos se houver
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                    $caminho = $arquivo->storeAs('ouvidoria/respostas', $nomeArquivo, 'public');
                    
                    $manifestacao->anexos()->create([
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

        return redirect()->route('ouvidor.manifestacoes.show', $manifestacao)
            ->with('success', 'Resposta enviada com sucesso!');
    }

    /**
     * Altera o status de uma manifestação
     */
    public function alterarStatus(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        \Log::info('Método alterarStatus chamado', [
            'manifestacao_id' => $manifestacao->id,
            'status_atual' => $manifestacao->status,
            'novo_status' => $request->status,
            'observacoes' => $request->observacoes
        ]);

        $request->validate([
            'status' => 'required|in:nova,em_analise,em_tramitacao,aguardando_informacoes,respondida,finalizada,arquivada',
            'observacoes' => 'nullable|string|max:500'
        ]);

        try {
            DB::transaction(function () use ($request, $manifestacao) {
                $statusAnterior = $manifestacao->status;
                
                // Atualizar status usando método do modelo para manter histórico
                $manifestacao->alterarStatus($request->status, $request->observacoes, Auth::id());

                // Registrar movimentação de alteração de status
                OuvidoriaMovimentacao::create([
                    'ouvidoria_manifestacao_id' => $manifestacao->id,
                    'usuario_id' => Auth::id(),
                    'status' => $request->status,
                    'descricao' => "Status alterado de '{$statusAnterior}' para '{$request->status}'",
                    'data_movimentacao' => now(),
                    'ip_usuario' => request()->ip()
                ]);
            });

            return redirect()->back()->with('success', 'Status alterado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao alterar status da manifestação: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }

    /**
     * Atribui uma manifestação a outro ouvidor
     */
    public function atribuir(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        // Todos os ouvidores ativos podem reatribuir qualquer manifestação

        $request->validate([
            'ouvidor_id' => 'required|exists:users,id',
            'observacoes' => 'nullable|string|max:500'
        ]);

        DB::transaction(function () use ($request, $manifestacao) {
            $ouvidorAnterior = $manifestacao->ouvidorResponsavel->name ?? 'Não atribuído';
            $novoOuvidor = \App\Models\User::find($request->ouvidor_id);

            $manifestacao->update([
                'ouvidor_responsavel_id' => $request->ouvidor_id
            ]);

            // Registrar movimentação de reatribuição
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'usuario_id' => Auth::id(),
                'status' => $manifestacao->status,
                'descricao' => "Manifestação reatribuída de '{$ouvidorAnterior}' para '{$novoOuvidor->name}'",
                'data_movimentacao' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Manifestação reatribuída com sucesso!');
    }

    /**
     * Adiciona uma tramitação à manifestação
     */
    public function adicionarTramitacao(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        // Todos os ouvidores ativos podem tramitar qualquer manifestação

        $request->validate([
            'acao' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        OuvidoriaMovimentacao::create([
            'ouvidoria_manifestacao_id' => $manifestacao->id,
            'usuario_id' => Auth::id(),
            'status' => $manifestacao->status,
            'descricao' => $request->acao . ' - ' . $request->descricao . ($request->observacoes ? ' | Observações: ' . $request->observacoes : ''),
            'data_movimentacao' => now(),
        ]);

        return redirect()->back()->with('success', 'Tramitação adicionada com sucesso!');
    }

    /**
     * Arquiva uma manifestação
     */
    public function arquivar(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        // Todos os ouvidores ativos podem arquivar qualquer manifestação

        $request->validate([
            'motivo' => 'required|string|max:500'
        ]);

        DB::transaction(function () use ($request, $manifestacao) {
            // Alterar status para arquivada usando método do modelo para manter histórico
            $manifestacao->arquivar(Auth::id());

            // Registrar movimentação de arquivamento
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'usuario_id' => Auth::id(),
                'status' => 'arquivada',
                'descricao' => 'Manifestação arquivada: ' . $request->motivo,
                'data_movimentacao' => now(),
            ]);
        });

        return redirect()->route('ouvidor.manifestacoes.index')
            ->with('success', 'Manifestação arquivada com sucesso!');
    }
}