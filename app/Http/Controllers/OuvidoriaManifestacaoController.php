<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaManifestacao;
use App\Models\OuvidoriaMovimentacao;
use App\Models\ManifestacaoAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OuvidoriaManifestacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OuvidoriaManifestacao::with(['ouvidorResponsavel', 'anexos']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        if ($request->filled('ouvidor_id')) {
            $query->where('ouvidor_responsavel_id', $request->ouvidor_id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('assunto', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('protocolo', 'like', "%{$busca}%")
                  ->orWhere('nome_manifestante', 'like', "%{$busca}%")
                  ->orWhere('email_manifestante', 'like', "%{$busca}%");
            });
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'created_at');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        $manifestacoes = $query->paginate(15);

        // Estatísticas para dashboard
        $estatisticas = [
            'total' => OuvidoriaManifestacao::count(),
            'novas' => OuvidoriaManifestacao::where('status', 'nova')->count(),
            'em_andamento' => OuvidoriaManifestacao::where('status', 'em_andamento')->count(),
            'respondidas' => OuvidoriaManifestacao::where('status', 'respondida')->count(),
            'concluidas' => OuvidoriaManifestacao::where('status', 'concluida')->count(),
            'prazo_vencido' => OuvidoriaManifestacao::where('prazo_resposta', '<', now())
                                                   ->whereNotIn('status', ['respondida', 'concluida', 'cancelada'])
                                                   ->count(),
        ];

        $ouvidores = \App\Models\User::ouvidores()->active()->get();

        return view('admin.ouvidoria-manifestacoes.index', compact(
            'manifestacoes', 'estatisticas', 'ouvidores'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ouvidores = \App\Models\User::ouvidores()->active()->get();
        return view('admin.ouvidoria-manifestacoes.create', compact('ouvidores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome_manifestante' => 'required_unless:manifestacao_anonima,1|string|max:255',
            'email_manifestante' => 'required_unless:manifestacao_anonima,1|email|max:255',
            'telefone_manifestante' => 'nullable|string|max:20',
            'tipo' => 'required|in:reclamacao,sugestao,elogio,denuncia,ouvidoria_geral',
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'manifestacao_anonima' => 'boolean',
            'anexos.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif',
        ], [
            'nome_manifestante.required_unless' => 'O nome é obrigatório para manifestações não anônimas.',
            'email_manifestante.required_unless' => 'O e-mail é obrigatório para manifestações não anônimas.',
            'email_manifestante.email' => 'O e-mail deve ter um formato válido.',
            'tipo.required' => 'O tipo da manifestação é obrigatório.',
            'assunto.required' => 'O assunto é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'anexos.*.max' => 'Cada arquivo deve ter no máximo 10MB.',
            'anexos.*.mimes' => 'Apenas arquivos PDF, DOC, DOCX, JPG, JPEG, PNG e GIF são permitidos.',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $isAnonima = $request->boolean('manifestacao_anonima');

            // Criar manifestação
            $manifestacao = OuvidoriaManifestacao::create([
                'nome_manifestante' => $isAnonima ? null : $request->nome_manifestante,
                'email_manifestante' => $isAnonima ? null : $request->email_manifestante,
                'telefone_manifestante' => $isAnonima ? null : $request->telefone_manifestante,
                'tipo' => $request->tipo,
                'assunto' => $request->assunto,
                'descricao' => $request->descricao,
                'prioridade' => $request->prioridade,
                'manifestacao_anonima' => $isAnonima,
                'status' => 'nova',
                'prazo_resposta' => now()->addDays(20), // 20 dias úteis conforme lei
                'ip_origem' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Processar anexos
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeOriginal = $arquivo->getClientOriginalName();
                    $nomeArquivo = Str::uuid() . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('ouvidoria/manifestacoes/' . $manifestacao->id, $nomeArquivo, 'private');

                    ManifestacaoAnexo::create([
                        'manifestacao_id' => $manifestacao->id,
                        'nome_original' => $nomeOriginal,
                        'nome_arquivo' => $nomeArquivo,
                        'caminho_arquivo' => $caminho,
                        'tipo_mime' => $arquivo->getMimeType(),
                        'extensao' => $arquivo->getClientOriginalExtension(),
                        'tamanho_bytes' => $arquivo->getSize(),
                        'tipo_anexo' => 'manifestacao',
                        'hash_arquivo' => hash_file('sha256', $arquivo->getRealPath()),
                        'ip_upload' => $request->ip(),
                    ]);
                }
            }

            // Atribuir automaticamente a um ouvidor (round-robin)
            $ouvidor = \App\Models\User::ouvidores()
                                      ->active()
                                      ->where('pode_responder_manifestacoes', true)
                                      ->orderBy('updated_at')
                                      ->first();

            if ($ouvidor) {
                $manifestacao->update([
                    'ouvidor_responsavel_id' => $ouvidor->id,
                    'data_atribuicao' => now(),
                ]);

                $ouvidor->touch(); // Atualiza o updated_at para controle round-robin

                // Criar movimentação de atribuição
                OuvidoriaMovimentacao::create([
                    'ouvidoria_manifestacao_id' => $manifestacao->id,
                    'usuario_id' => auth()->id(),
                    'status' => 'em_andamento',
                    'descricao' => "Manifestação atribuída automaticamente ao ouvidor {$ouvidor->nome}",
                    'data_movimentacao' => now(),
                ]);

                $manifestacao->update(['status' => 'em_andamento']);
            }

            // Enviar email de confirmação para manifestante (se não for anônima)
            if (!$isAnonima && $manifestacao->email_manifestante) {
                // TODO: Implementar envio de email de confirmação
                // Mail::to($manifestacao->email_manifestante)->send(new ManifestacaoRegistrada($manifestacao));
            }

            DB::commit();

            return redirect()->route('admin.ouvidoria-manifestacoes.show', $manifestacao)
                           ->with('success', 'Manifestação criada com sucesso! Protocolo: ' . $manifestacao->protocolo);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao criar manifestação: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OuvidoriaManifestacao $manifestacao)
    {
        $manifestacao->load(['ouvidorResponsavel', 'anexos', 'movimentacoes.usuario']);
        
        $ouvidores = \App\Models\User::ouvidores()->active()->get();
        
        return view('admin.ouvidoria-manifestacoes.show', compact('manifestacao', 'ouvidores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OuvidoriaManifestacao $manifestacao)
    {
        $ouvidores = \App\Models\User::ouvidores()->active()->get();
        return view('admin.ouvidoria-manifestacoes.edit', compact('manifestacao', 'ouvidores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:nova,em_andamento,respondida,concluida,cancelada',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'ouvidor_responsavel_id' => 'nullable|exists:ouvidores,id',
            'observacoes_internas' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos.',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $dadosAntigos = $manifestacao->toArray();
        $statusAnterior = $manifestacao->status;

        $manifestacao->update($request->only([
            'status', 'prioridade', 'ouvidor_responsavel_id', 'observacoes_internas'
        ]));

        // Se mudou o ouvidor responsável
        if ($request->ouvidor_responsavel_id != $dadosAntigos['ouvidor_responsavel_id']) {
            $manifestacao->update(['data_atribuicao' => now()]);
            
            if ($request->ouvidor_responsavel_id) {
                $ouvidor = \App\Models\User::find($request->ouvidor_responsavel_id);
                $ouvidor->touch(); // Atualiza o updated_at para controle round-robin

                // Criar movimentação de reatribuição
                OuvidoriaMovimentacao::create([
                    'ouvidoria_manifestacao_id' => $manifestacao->id,
                    'usuario_id' => auth()->id(),
                    'status' => $request->status,
                    'descricao' => "Manifestação reatribuída para o ouvidor {$ouvidor->name}",
                    'data_movimentacao' => now(),
                ]);
            }
        }

        // Se mudou o status
        if ($request->status != $statusAnterior) {
            // Criar movimentação de mudança de status
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'usuario_id' => auth()->id(),
                'status' => $request->status,
                'descricao' => "Status alterado de {$statusAnterior} para {$request->status}",
                'data_movimentacao' => now(),
            ]);

            // Se mudou o status para respondida ou concluída
            if (in_array($request->status, ['respondida', 'concluida']) && 
                !in_array($statusAnterior, ['respondida', 'concluida'])) {
                
                $manifestacao->update(['data_resposta' => now()]);
            }
        }

        return back()->with('success', 'Manifestação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OuvidoriaManifestacao $manifestacao)
    {
        try {
            // Remove anexos físicos
            foreach ($manifestacao->anexos as $anexo) {
                if (Storage::disk('private')->exists($anexo->caminho)) {
                    Storage::disk('private')->delete($anexo->caminho);
                }
            }

            $manifestacao->delete();

            return redirect()->route('admin.ouvidoria-manifestacoes.index')
                           ->with('success', 'Manifestação excluída com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir manifestação: ' . $e->getMessage());
        }
    }

    /**
     * Responder manifestação
     */
    public function responder(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        $validator = Validator::make($request->all(), [
            'resposta' => 'required|string',
            'anexos.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif',
        ], [
            'resposta.required' => 'A resposta é obrigatória.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $statusAnterior = $manifestacao->status;

            // Verificar se o usuário logado é um ouvidor com permissão para responder
            $user = auth()->user();
            if (!$user->canResponderManifestacoes()) {
                throw new \Exception('Usuário não tem permissão para responder manifestações.');
            }

            // Atualizar manifestação
            $manifestacao->update([
                'resposta' => $request->resposta,
                'respondida_em' => now(),
                'status' => 'respondida',
                'respondida_por' => $user->id,
            ]);

            // Criar movimentação de resposta
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'usuario_id' => auth()->id(),
                'status' => 'respondida',
                'descricao' => 'Manifestação respondida pelo ouvidor',
                'data_movimentacao' => now(),
            ]);

            // Processar anexos da resposta
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeOriginal = $arquivo->getClientOriginalName();
                    $nomeArquivo = Str::uuid() . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('ouvidoria/manifestacoes/' . $manifestacao->id . '/respostas', $nomeArquivo, 'private');

                    ManifestacaoAnexo::create([
                        'manifestacao_id' => $manifestacao->id,
                        'usuario_id' => auth()->id(),
                        'nome_original' => $nomeOriginal,
                        'nome_arquivo' => $nomeArquivo,
                        'caminho_arquivo' => $caminho,
                        'tipo_mime' => $arquivo->getMimeType(),
                        'extensao' => $arquivo->getClientOriginalExtension(),
                        'tamanho_bytes' => $arquivo->getSize(),
                        'tipo_anexo' => 'resposta',
                        'hash_arquivo' => hash_file('sha256', $arquivo->getRealPath()),
                        'ip_upload' => $request->ip(),
                    ]);
                }
            }

            // Enviar email de notificação (se não for anônima)
            if (!$manifestacao->manifestacao_anonima && $manifestacao->email_manifestante) {
                // TODO: Implementar envio de email de resposta
                // Mail::to($manifestacao->email_manifestante)->send(new ManifestacaoRespondida($manifestacao));
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Resposta enviada com sucesso!'
                ]);
            }

            return back()->with('success', 'Resposta enviada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao enviar resposta: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erro ao enviar resposta: ' . $e->getMessage());
        }
    }

    /**
     * Download de anexo
     */
    public function downloadAnexo(ManifestacaoAnexo $anexo)
    {
        // Verificar se o usuário tem permissão (apenas usuários autenticados podem baixar anexos)
        if (!auth()->check()) {
            abort(403, 'Você precisa estar logado para acessar este arquivo.');
        }

        if (!Storage::disk('private')->exists($anexo->caminho)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('private')->download($anexo->caminho, $anexo->nome_original);
    }

    /**
     * Relatórios
     */
    public function relatorios(Request $request)
    {
        $periodo = $request->get('periodo', '30'); // últimos 30 dias por padrão
        $dataInicio = now()->subDays($periodo);

        $estatisticas = [
            'total_periodo' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)->count(),
            'por_tipo' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                              ->selectRaw('tipo, COUNT(*) as total')
                                              ->groupBy('tipo')
                                              ->pluck('total', 'tipo'),
            'por_status' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                                ->selectRaw('status, COUNT(*) as total')
                                                ->groupBy('status')
                                                ->pluck('total', 'status'),
            'tempo_medio_resposta' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                                          ->whereNotNull('data_resposta')
                                                          ->selectRaw('AVG(DATEDIFF(data_resposta, created_at)) as media')
                                                          ->value('media'),
            'prazo_vencido' => OuvidoriaManifestacao::where('prazo_resposta', '<', now())
                                                   ->whereNotIn('status', ['respondida', 'fechada'])
                                                   ->count(),
        ];

        return view('admin.ouvidoria.relatorios', compact('estatisticas', 'periodo'));
    }

    /**
     * Tramitação interna da manifestação
     */
    public function tramitacao(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        $validator = Validator::make($request->all(), [
            'observacoes' => 'required|string|max:1000',
            'setor_destino' => 'nullable|string|max:255',
            'prioridade' => 'nullable|in:normal,alta,urgente',
        ], [
            'observacoes.required' => 'As observações da tramitação são obrigatórias.',
            'observacoes.max' => 'As observações não podem exceder 1000 caracteres.',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Atualizar observações internas da manifestação
            $observacoesAtuais = $manifestacao->observacoes_internas ?? '';
            $novaObservacao = '[' . now()->format('d/m/Y H:i') . '] ' . auth()->user()->name . ': ' . $request->observacoes;
            
            if ($request->setor_destino) {
                $novaObservacao .= ' (Encaminhado para: ' . $request->setor_destino . ')';
            }
            
            if ($request->prioridade && $request->prioridade !== 'normal') {
                $novaObservacao .= ' [Prioridade: ' . strtoupper($request->prioridade) . ']';
            }
            
            $observacoesAtualizadas = $observacoesAtuais ? $observacoesAtuais . "\n\n" . $novaObservacao : $novaObservacao;
            
            $manifestacao->update([
                'observacoes_internas' => $observacoesAtualizadas,
            ]);

            // Criar movimentação de tramitação
            $descricaoMovimentacao = 'Tramitação interna: ' . $request->observacoes;
            if ($request->setor_destino) {
                $descricaoMovimentacao .= ' (Encaminhado para: ' . $request->setor_destino . ')';
            }

            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'usuario_id' => auth()->id(),
                'status' => $manifestacao->status,
                'descricao' => $descricaoMovimentacao,
                'data_movimentacao' => now(),
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tramitação registrada com sucesso!'
                ]);
            }

            return back()->with('success', 'Tramitação registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao registrar tramitação: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erro ao registrar tramitação: ' . $e->getMessage());
        }
    }

    /**
     * Arquivar/desarquivar manifestação
     */
    public function archive(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        try {
            $isArchived = $manifestacao->status === 'arquivada';
            
            if ($isArchived) {
                // Desarquivar - voltar para status anterior ou 'em_andamento'
                $novoStatus = 'em_andamento';
                $descricao = 'Manifestação desarquivada';
                $manifestacao->update(['status' => $novoStatus]);
            } else {
                // Arquivar
                $manifestacao->arquivar(auth()->id());
                $descricao = 'Manifestação arquivada';
            }

            // Criar movimentação
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'usuario_id' => auth()->id(),
                'status' => $manifestacao->status,
                'descricao' => $descricao,
                'data_movimentacao' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => $descricao . ' com sucesso!',
                'status' => $manifestacao->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar solicitação: ' . $e->getMessage()
            ], 500);
        }
    }
}
