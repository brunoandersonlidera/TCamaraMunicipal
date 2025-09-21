<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaManifestacao;
use App\Models\EsicUsuario;
use App\Models\Ouvidor;
use App\Models\ManifestacaoAnexo;
use App\Models\Notificacao;
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
        $query = OuvidoriaManifestacao::with(['usuario', 'ouvidorResponsavel', 'anexos']);

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
                  ->orWhereHas('usuario', function ($userQuery) use ($busca) {
                      $userQuery->where('nome', 'like', "%{$busca}%")
                               ->orWhere('email', 'like', "%{$busca}%");
                  });
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
            'abertas' => OuvidoriaManifestacao::where('status', 'aberta')->count(),
            'em_andamento' => OuvidoriaManifestacao::where('status', 'em_andamento')->count(),
            'respondidas' => OuvidoriaManifestacao::where('status', 'respondida')->count(),
            'fechadas' => OuvidoriaManifestacao::where('status', 'fechada')->count(),
            'prazo_vencido' => OuvidoriaManifestacao::where('prazo_resposta', '<', now())
                                                   ->whereNotIn('status', ['respondida', 'fechada'])
                                                   ->count(),
        ];

        $ouvidores = Ouvidor::with('user')->get();

        return view('admin.ouvidoria-manifestacoes.index', compact(
            'manifestacoes', 'estatisticas', 'ouvidores'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ouvidores = Ouvidor::with('user')->where('ativo', true)->get();
        return view('admin.ouvidoria-manifestacoes.create', compact('ouvidores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_nome' => 'required|string|max:255',
            'usuario_email' => 'required|email|max:255',
            'usuario_telefone' => 'nullable|string|max:20',
            'usuario_endereco' => 'nullable|string|max:500',
            'tipo' => 'required|in:reclamacao,sugestao,elogio,denuncia,solicitacao',
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,normal,alta,urgente',
            'anonima' => 'boolean',
            'anexos.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif',
        ], [
            'usuario_nome.required' => 'O nome é obrigatório.',
            'usuario_email.required' => 'O e-mail é obrigatório.',
            'usuario_email.email' => 'O e-mail deve ter um formato válido.',
            'tipo.required' => 'O tipo da manifestação é obrigatório.',
            'assunto.required' => 'O assunto é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'anexos.*.max' => 'Cada arquivo deve ter no máximo 10MB.',
            'anexos.*.mimes' => 'Apenas arquivos PDF, DOC, DOCX, JPG, JPEG, PNG e GIF são permitidos.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Buscar ou criar usuário
            $usuario = EsicUsuario::where('email', $request->usuario_email)->first();
            
            if (!$usuario) {
                $usuario = EsicUsuario::create([
                    'nome' => $request->usuario_nome,
                    'email' => $request->usuario_email,
                    'telefone' => $request->usuario_telefone,
                    'endereco' => $request->usuario_endereco,
                    'email_verified_at' => now(), // Auto-verificado para manifestações administrativas
                ]);
            }

            // Criar manifestação
            $manifestacao = OuvidoriaManifestacao::create([
                'usuario_id' => $usuario->id,
                'protocolo' => OuvidoriaManifestacao::gerarProtocolo(),
                'tipo' => $request->tipo,
                'assunto' => $request->assunto,
                'descricao' => $request->descricao,
                'prioridade' => $request->prioridade,
                'anonima' => $request->boolean('anonima'),
                'status' => 'aberta',
                'prazo_resposta' => now()->addDays(20), // 20 dias úteis conforme lei
            ]);

            // Processar anexos
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeOriginal = $arquivo->getClientOriginalName();
                    $nomeArquivo = Str::uuid() . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('manifestacoes/' . $manifestacao->id, $nomeArquivo, 'private');

                    ManifestacaoAnexo::create([
                        'manifestacao_id' => $manifestacao->id,
                        'usuario_id' => $usuario->id,
                        'nome_original' => $nomeOriginal,
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tamanho' => $arquivo->getSize(),
                        'tipo_mime' => $arquivo->getMimeType(),
                        'hash_arquivo' => hash_file('sha256', $arquivo->getRealPath()),
                        'publico' => false,
                    ]);
                }
            }

            // Atribuir automaticamente a um ouvidor (round-robin)
            $ouvidor = Ouvidor::where('ativo', true)
                             ->orderBy('ultima_atribuicao')
                             ->first();

            if ($ouvidor) {
                $manifestacao->update([
                    'ouvidor_responsavel_id' => $ouvidor->id,
                    'data_atribuicao' => now(),
                ]);

                $ouvidor->update(['ultima_atribuicao' => now()]);

                // Criar notificação para o ouvidor
                Notificacao::criarNotificacao(
                    $ouvidor->user,
                    'nova_manifestacao',
                    [
                        'titulo' => 'Nova Manifestação Atribuída',
                        'mensagem' => "Uma nova manifestação ({$manifestacao->protocolo}) foi atribuída a você.",
                        'manifestacao_id' => $manifestacao->id,
                        'canal' => 'email',
                        'prioridade' => $manifestacao->prioridade,
                    ]
                );
            }

            // Criar notificação para o usuário
            Notificacao::criarNotificacao(
                $usuario,
                'nova_manifestacao',
                [
                    'titulo' => 'Manifestação Registrada',
                    'mensagem' => "Sua manifestação foi registrada com o protocolo {$manifestacao->protocolo}.",
                    'manifestacao_id' => $manifestacao->id,
                    'canal' => 'email',
                ]
            );

            DB::commit();

            return redirect()->route('admin.ouvidoria.manifestacoes.show', $manifestacao)
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
        $manifestacao->load(['usuario', 'ouvidorResponsavel.user', 'anexos', 'respostas']);
        
        $ouvidores = Ouvidor::with('user')->where('ativo', true)->get();
        
        return view('admin.ouvidoria-manifestacoes.show', compact('manifestacao', 'ouvidores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OuvidoriaManifestacao $manifestacao)
    {
        $ouvidores = Ouvidor::with('user')->where('ativo', true)->get();
        return view('admin.ouvidoria-manifestacoes.edit', compact('manifestacao', 'ouvidores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OuvidoriaManifestacao $manifestacao)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:aberta,em_andamento,respondida,fechada,cancelada',
            'prioridade' => 'required|in:baixa,normal,alta,urgente',
            'ouvidor_responsavel_id' => 'nullable|exists:ouvidores,id',
            'observacoes_internas' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dadosAntigos = $manifestacao->toArray();

        $manifestacao->update($request->only([
            'status', 'prioridade', 'ouvidor_responsavel_id', 'observacoes_internas'
        ]));

        // Se mudou o ouvidor responsável
        if ($request->ouvidor_responsavel_id != $dadosAntigos['ouvidor_responsavel_id']) {
            $manifestacao->update(['data_atribuicao' => now()]);
            
            if ($request->ouvidor_responsavel_id) {
                $ouvidor = Ouvidor::find($request->ouvidor_responsavel_id);
                $ouvidor->update(['ultima_atribuicao' => now()]);

                // Notificar novo ouvidor
                Notificacao::criarNotificacao(
                    $ouvidor->user,
                    'manifestacao_encaminhada',
                    [
                        'titulo' => 'Manifestação Encaminhada',
                        'mensagem' => "A manifestação {$manifestacao->protocolo} foi encaminhada para você.",
                        'manifestacao_id' => $manifestacao->id,
                        'canal' => 'email',
                        'prioridade' => $manifestacao->prioridade,
                    ]
                );
            }
        }

        // Se mudou o status para respondida ou fechada
        if (in_array($request->status, ['respondida', 'fechada']) && 
            !in_array($dadosAntigos['status'], ['respondida', 'fechada'])) {
            
            $manifestacao->update(['data_resposta' => now()]);

            // Notificar usuário
            Notificacao::criarNotificacao(
                $manifestacao->usuario,
                'resposta_manifestacao',
                [
                    'titulo' => 'Manifestação Respondida',
                    'mensagem' => "Sua manifestação {$manifestacao->protocolo} foi respondida.",
                    'manifestacao_id' => $manifestacao->id,
                    'canal' => 'email',
                ]
            );
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

            return redirect()->route('admin.ouvidoria.manifestacoes.index')
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
            // Atualizar manifestação
            $manifestacao->update([
                'resposta' => $request->resposta,
                'data_resposta' => now(),
                'status' => 'respondida',
                'respondida_por' => auth()->id(),
            ]);

            // Processar anexos da resposta
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeOriginal = $arquivo->getClientOriginalName();
                    $nomeArquivo = Str::uuid() . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('manifestacoes/' . $manifestacao->id . '/respostas', $nomeArquivo, 'private');

                    ManifestacaoAnexo::create([
                        'manifestacao_id' => $manifestacao->id,
                        'usuario_id' => auth()->id(),
                        'nome_original' => $nomeOriginal,
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tamanho' => $arquivo->getSize(),
                        'tipo_mime' => $arquivo->getMimeType(),
                        'hash_arquivo' => hash_file('sha256', $arquivo->getRealPath()),
                        'publico' => true, // Anexos de resposta são públicos para o usuário
                        'descricao' => 'Anexo da resposta',
                    ]);
                }
            }

            // Notificar usuário
            Notificacao::criarNotificacao(
                $manifestacao->usuario,
                'resposta_manifestacao',
                [
                    'titulo' => 'Manifestação Respondida',
                    'mensagem' => "Sua manifestação {$manifestacao->protocolo} foi respondida.",
                    'manifestacao_id' => $manifestacao->id,
                    'canal' => 'email',
                ]
            );

            DB::commit();

            return back()->with('success', 'Resposta enviada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao enviar resposta: ' . $e->getMessage());
        }
    }

    /**
     * Download de anexo
     */
    public function downloadAnexo(ManifestacaoAnexo $anexo)
    {
        // Verificar permissões
        $user = auth()->user();
        
        if (!$anexo->podeSerVisualizadoPor($user)) {
            abort(403, 'Você não tem permissão para acessar este arquivo.');
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
}
