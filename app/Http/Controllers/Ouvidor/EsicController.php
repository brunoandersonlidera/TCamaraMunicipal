<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use App\Models\EsicSolicitacao;
use App\Models\EsicMovimentacao;
use App\Models\EsicMensagem;
use App\Mail\EsicResposta;
use App\Mail\EsicTramitacao as EsicTramitacaoMail;
use App\Mail\EsicMensagemOuvidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        // Ouvidores podem ver todas as solicitações E-SIC
        $query = EsicSolicitacao::with(['user', 'responsavel']);

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
                  ->orWhereHas('user', function ($q) use ($busca) {
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
        // Ouvidores podem acessar qualquer solicitação E-SIC

        $solicitacao->load([
            'user', 
            'responsavel', 
            'movimentacoes.usuario',
            'mensagens' => function($query) {
                $query->orderBy('created_at', 'asc');
            },
            'mensagens.usuario'
        ]);

        // Marcar mensagens do cidadão como lidas pelo ouvidor
        $solicitacao->mensagens()
            ->where('tipo_remetente', 'cidadao')
            ->where('lida', false)
            ->update(['lida' => true, 'data_leitura' => now()]);

        return view('ouvidor.esic.show', compact('solicitacao'));
    }

    /**
     * Responde a uma solicitação e-SIC
     */
    public function responder(Request $request, EsicSolicitacao $solicitacao)
    {
        try {
            \Log::info('=== MÉTODO RESPONDER CHAMADO ===');
            \Log::info('Iniciando resposta E-SIC', [
                'solicitacao_id' => $solicitacao->id,
                'responsavel_id' => $solicitacao->responsavel_id,
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'method' => $request->method(),
                'url' => $request->url(),
                'headers' => $request->headers->all()
            ]);

        // Ouvidores podem responder qualquer solicitação E-SIC

        try {
            $request->validate([
                'resposta' => 'required|string|min:10',
                'status' => 'required|in:respondida,parcialmente_respondida,finalizada',
                'anexos.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx'
            ]);
            \Log::info('Validação passou, iniciando transação');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        }

        DB::transaction(function () use ($request, $solicitacao) {
            \Log::info('Dentro da transação, atualizando solicitação');
            
            // Atualizar solicitação
            $solicitacao->update([
                'resposta' => $request->resposta,
                'status' => $request->status,
                'data_resposta' => now()
            ]);

            \Log::info('Solicitação atualizada com sucesso', [
                'id' => $solicitacao->id,
                'status' => $request->status
            ]);

            // Mapear status da resposta para status da movimentação
            $statusMapping = [
                'respondida' => 'respondida',
                'parcialmente_respondida' => 'parcialmente_atendida',
                'finalizada' => 'finalizada'
            ];

            $statusMovimentacao = $statusMapping[$request->status] ?? 'respondida';

            // Adicionar movimentação com a resposta completa
            $descricaoMovimentacao = "Resposta enviada pelo responsável:\n\n" . $request->resposta;
            
            $movimentacao = EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'status' => $statusMovimentacao,
                'descricao' => $descricaoMovimentacao,
                'data_movimentacao' => now(),
                'ip_usuario' => request()->ip()
            ]);

            \Log::info('Movimentação criada com sucesso', [
                'movimentacao_id' => $movimentacao->id,
                'status' => $statusMovimentacao
            ]);

            // Processar anexos se houver
            if ($request->hasFile('anexos')) {
                $anexosResposta = $solicitacao->anexos_resposta ?? [];
                
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                    $caminho = $arquivo->storeAs('esic/respostas/' . $solicitacao->protocolo, $nomeArquivo, 'public');
                    
                    $anexosResposta[] = [
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tipo' => 'resposta',
                        'tamanho' => $arquivo->getSize(),
                        'mime_type' => $arquivo->getMimeType(),
                        'data_upload' => now()->toDateTimeString()
                    ];
                }
                
                $solicitacao->update(['anexos_resposta' => $anexosResposta]);
            }
        });

        // Enviar email de resposta para o cidadão
        try {
            $solicitacao->load(['user', 'responsavel']);
            Mail::to($solicitacao->user->email)->send(new EsicResposta($solicitacao));
            
            \Log::info('E-mail de resposta enviado com sucesso');
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email de resposta E-SIC: ' . $e->getMessage());
        }

            \Log::info('Transação concluída com sucesso');

            return redirect()->route('ouvidor.esic.show', $solicitacao)
                ->with('success', 'Resposta enviada com sucesso!');
        } catch (\Exception $e) {
            \Log::error('ERRO GERAL NO MÉTODO RESPONDER', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('ouvidor.esic.show', $solicitacao)
                ->with('error', 'Erro ao enviar resposta: ' . $e->getMessage());
        }
    }

    /**
     * Altera o status de uma solicitação e-SIC
     */
    public function alterarStatus(Request $request, EsicSolicitacao $solicitacao)
    {
        // Ouvidores podem alterar qualquer solicitação E-SIC

        $request->validate([
            'status' => 'required|in:pendente,em_analise,aguardando_informacoes,informacoes_recebidas,respondida,parcialmente_atendida,finalizada,negada,arquivada',
            'observacoes' => 'nullable|string|max:500'
        ]);

        $statusAnterior = $solicitacao->status;
        
        // Mapear status da solicitação para status da movimentação
        $statusMapping = [
            'pendente' => 'aberta',
            'em_analise' => 'em_analise',
            'aguardando_informacoes' => 'aguardando_informacoes',
            'informacoes_recebidas' => 'informacoes_recebidas',
            'respondida' => 'respondida',
            'negada' => 'negada',
            'parcialmente_atendida' => 'parcialmente_atendida',
            'finalizada' => 'finalizada',
            'arquivada' => 'arquivada'
        ];

        $statusMovimentacao = $statusMapping[$request->status] ?? 'em_analise';
        
        DB::transaction(function () use ($request, $solicitacao, $statusAnterior, $statusMovimentacao) {
            $solicitacao->update([
                'status' => $request->status
            ]);

            // Adicionar movimentação
            $tramitacao = EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'status' => $statusMovimentacao,
                'descricao' => "Status alterado de '{$statusAnterior}' para '{$request->status}'" . ($request->observacoes ? '. ' . $request->observacoes : ''),
                'data_movimentacao' => now(),
                'ip_usuario' => request()->ip()
            ]);

            // Enviar email de tramitação para o cidadão
            try {
                $solicitacao->load(['user', 'responsavel']);
                $tramitacao->load('usuario');
                $tramitacao->status_anterior = $statusAnterior;
                $tramitacao->status_atual = $request->status;
                Mail::to($solicitacao->user->email)->send(new EsicTramitacaoMail($solicitacao, $tramitacao));
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar email de tramitação E-SIC: ' . $e->getMessage());
            }
        });

        return redirect()->back()->with('success', 'Status alterado com sucesso!');
    }

    /**
     * Adiciona uma tramitação à solicitação e-SIC
     */
    public function adicionarTramitacao(Request $request, EsicSolicitacao $solicitacao)
    {
        // Ouvidores podem tramitar qualquer solicitação E-SIC

        $request->validate([
            'acao' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        // Mapear status da solicitação para status da movimentação
        $statusMapping = [
            'pendente' => 'aberta',
            'em_analise' => 'em_analise',
            'respondida' => 'respondida',
            'negada' => 'negada',
            'parcialmente_atendida' => 'parcialmente_atendida',
            'recurso' => 'recurso_solicitado',
            'finalizada' => 'finalizada'
        ];

        $statusMovimentacao = $statusMapping[$solicitacao->status] ?? 'em_analise';

        $tramitacao = EsicMovimentacao::create([
            'esic_solicitacao_id' => $solicitacao->id,
            'usuario_id' => Auth::id(),
            'status' => $statusMovimentacao,
            'descricao' => $request->acao . ': ' . $request->descricao . ($request->observacoes ? '. ' . $request->observacoes : ''),
            'data_movimentacao' => now(),
            'ip_usuario' => request()->ip()
        ]);

        // Enviar email de tramitação para o cidadão
        try {
            $solicitacao->load(['user', 'responsavel']);
            $tramitacao->load('usuario');
            Mail::to($solicitacao->user->email)->send(new EsicTramitacaoMail($solicitacao, $tramitacao));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email de tramitação E-SIC: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Tramitação adicionada com sucesso!');
    }

    /**
     * Arquiva uma solicitação e-SIC
     */
    public function arquivar(Request $request, EsicSolicitacao $solicitacao)
    {
        // Ouvidores podem arquivar qualquer solicitação E-SIC

        $request->validate([
            'motivo' => 'required|string|max:500'
        ]);

        DB::transaction(function () use ($request, $solicitacao) {
            $solicitacao->update([
                'status' => 'arquivada',
                'arquivada_em' => now(),
                'arquivada_por' => Auth::id()
            ]);

            // Adicionar movimentação
            EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'status' => 'arquivada',
                'descricao' => 'Solicitação arquivada' . ($request->motivo ? ': ' . $request->motivo : ''),
                'data_movimentacao' => now(),
                'ip_usuario' => request()->ip()
            ]);
        });

        return redirect()->route('ouvidor.esic.index')
            ->with('success', 'Solicitação arquivada com sucesso!');
    }

    /**
     * Solicita a finalização de uma solicitação e-SIC
     */
    public function solicitarFinalizacao(Request $request, EsicSolicitacao $solicitacao)
    {
        // Ouvidores podem finalizar qualquer solicitação E-SIC

        // Verificar se a solicitação pode ser finalizada
        if (!$solicitacao->podeSerFinalizada()) {
            return back()->with('error', 'Esta solicitação não pode ser finalizada no status atual.');
        }

        // Verificar se já não está aguardando encerramento
        if ($solicitacao->aguardandoEncerramento()) {
            return back()->with('error', 'Esta solicitação já está aguardando encerramento.');
        }

        $request->validate([
            'mensagem_finalizacao' => 'required|string|min:10|max:2000'
        ]);

        DB::transaction(function () use ($request, $solicitacao) {
            // Solicitar finalização
            $solicitacao->solicitarFinalizacao();

            // Adicionar movimentação
            $tramitacao = EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'status' => 'finalizacao_solicitada',
                'descricao' => 'Finalização solicitada ao cidadão: ' . $request->mensagem_finalizacao,
                'data_movimentacao' => now(),
                'ip_usuario' => request()->ip()
            ]);

            // Enviar email de tramitação para o cidadão
            try {
                $solicitacao->load(['user', 'responsavel']);
                $tramitacao->load('usuario');
                $tramitacao->status_anterior = $solicitacao->status;
                $tramitacao->status_atual = 'finalizacao_solicitada';
                Mail::to($solicitacao->user->email)->send(new \App\Mail\EsicTramitacao($solicitacao, $tramitacao));
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar email de finalização E-SIC: ' . $e->getMessage());
            }
        });

        return redirect()->route('ouvidor.esic.show', $solicitacao)
            ->with('success', 'Solicitação de finalização enviada ao cidadão com sucesso! O prazo para encerramento automático é de 10 dias corridos.');
    }

    /**
     * Enviar mensagem do ouvidor para o cidadão
     */
    public function enviarMensagem(Request $request, EsicSolicitacao $solicitacao)
    {
        // Ouvidores podem enviar mensagens em qualquer solicitação E-SIC

        $request->validate([
            'mensagem' => 'required|string|min:1|max:2000',
            'tipo_comunicacao' => 'required|in:mensagem,resposta_oficial,comunicacao_interna',
            'canal_comunicacao' => 'required|in:sistema,telefone,whatsapp,email,presencial,carta,outro',
            'telefone_contato' => 'nullable|string|max:20',
            'email_contato' => 'nullable|email|max:255',
            'observacoes_canal' => 'nullable|string|max:500',
            'interna' => 'boolean',
            'anexos.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,txt'
        ]);

        try {
            // Processar anexos se houver
            $anexos = [];
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                    $caminhoArquivo = $arquivo->storeAs('esic/mensagens', $nomeArquivo, 'public');
                    
                    $anexos[] = [
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminhoArquivo,
                        'tamanho' => $arquivo->getSize(),
                        'tipo' => $arquivo->getMimeType()
                    ];
                }
            }

            // Determinar se é comunicação interna
            $isInterna = $request->boolean('interna', false) || $request->tipo_comunicacao === 'comunicacao_interna';

            // Criar a mensagem
            $mensagem = EsicMensagem::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'usuario_id' => Auth::id(),
                'tipo_remetente' => EsicMensagem::TIPO_OUVIDOR,
                'tipo_comunicacao' => $request->tipo_comunicacao,
                'mensagem' => $request->mensagem,
                'canal_comunicacao' => $request->canal_comunicacao,
                'telefone_contato' => $request->telefone_contato,
                'email_contato' => $request->email_contato,
                'observacoes_canal' => $request->observacoes_canal,
                'anexos' => $anexos,
                'lida' => false,
                'interna' => $isInterna,
                'ip_usuario' => $request->ip()
            ]);

            // Criar movimentação para histórico se não for mensagem interna
            if (!$isInterna) {
                $descricaoMovimentacao = 'Nova mensagem enviada pelo ouvidor';
                if ($request->canal_comunicacao !== 'sistema') {
                    $descricaoMovimentacao .= ' via ' . $mensagem->getCanalFormatado();
                }
                $descricaoMovimentacao .= ': ' . \Illuminate\Support\Str::limit($request->mensagem, 100);

                EsicMovimentacao::create([
                    'esic_solicitacao_id' => $solicitacao->id,
                    'usuario_id' => Auth::id(),
                    'status' => $solicitacao->status,
                    'descricao' => $descricaoMovimentacao,
                    'data_movimentacao' => now(),
                    'ip_usuario' => $request->ip()
                ]);

                // Enviar e-mail para o solicitante sobre a nova mensagem
                try {
                    $solicitacao->load(['user']);
                    Mail::to($solicitacao->user->email)->send(new EsicMensagemOuvidor($solicitacao, $mensagem));
                    
                    \Log::info('E-mail de nova mensagem enviado com sucesso', [
                        'solicitacao_id' => $solicitacao->id,
                        'mensagem_id' => $mensagem->id,
                        'email_destinatario' => $solicitacao->user->email
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Erro ao enviar e-mail de nova mensagem E-SIC: ' . $e->getMessage(), [
                        'solicitacao_id' => $solicitacao->id,
                        'mensagem_id' => $mensagem->id,
                        'error' => $e->getMessage()
                    ]);
                    // Não interrompe o fluxo se o e-mail falhar
                }
            }

            $tipoMensagem = $isInterna ? 'interna' : 'pública';
            return back()->with('success', "Mensagem {$tipoMensagem} enviada com sucesso!");

        } catch (\Exception $e) {
            \Log::error('Erro ao enviar mensagem E-SIC (Ouvidor): ' . $e->getMessage());
            return back()->with('error', 'Erro ao enviar mensagem. Tente novamente.');
        }
    }

    /**
     * Download de anexo de mensagem (para ouvidor)
     */
    public function downloadAnexoMensagem($mensagemId)
    {
        try {
            $mensagem = EsicMensagem::with('solicitacao')->findOrFail($mensagemId);
            $solicitacao = $mensagem->solicitacao;
            
            // Ouvidores podem acessar anexos de qualquer solicitação E-SIC

            $anexos = $mensagem->anexos ?? [];
            $nomeArquivo = request()->get('arquivo');
            
            if (!$nomeArquivo) {
                abort(400, 'Nome do arquivo não especificado.');
            }
            
            // Procurar o anexo pelo nome original
            $anexoEncontrado = null;
            foreach ($anexos as $anexo) {
                if ($anexo['nome_original'] === $nomeArquivo) {
                    $anexoEncontrado = $anexo;
                    break;
                }
            }
            
            if (!$anexoEncontrado) {
                abort(404, 'Anexo não encontrado.');
            }

            $caminhoCompleto = storage_path('app/public/' . $anexoEncontrado['caminho']);

            if (!file_exists($caminhoCompleto)) {
                abort(404, 'Arquivo não encontrado no sistema de arquivos.');
            }

            return response()->download($caminhoCompleto, $anexoEncontrado['nome_original']);

        } catch (\Exception $e) {
            \Log::error('Erro ao fazer download de anexo (Ouvidor): ' . $e->getMessage());
            abort(404, 'Arquivo não encontrado.');
        }
    }
}