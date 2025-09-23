<?php

namespace App\Http\Controllers;

use App\Models\EsicSolicitacao;
use App\Models\EsicMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EsicController extends Controller
{
    /**
     * Página pública do E-SIC com estatísticas e opções de cadastro/login
     */
    public function publicIndex()
    {
        $estatisticas = [
            'total_solicitacoes' => EsicSolicitacao::count(),
            'solicitacoes_mes' => EsicSolicitacao::whereMonth('created_at', now()->month)->count(),
            'solicitacoes_ano' => EsicSolicitacao::whereYear('created_at', now()->year)->count(),
            'tempo_medio_resposta' => $this->calcularTempoMedioResposta(),
            'taxa_atendimento' => $this->calcularTaxaAtendimento(),
            'solicitacoes_por_categoria' => $this->getSolicitacoesPorCategoria(),
            'solicitacoes_por_mes' => $this->getSolicitacoesPorMes()
        ];

        return view('esic.public-index', compact('estatisticas'));
    }

    /**
     * Dashboard do usuário autenticado
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $minhasSolicitacoes = EsicSolicitacao::where('email_solicitante', $user->email)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $estatisticasUsuario = [
            'total_solicitacoes' => EsicSolicitacao::where('email_solicitante', $user->email)->count(),
            'pendentes' => EsicSolicitacao::where('email_solicitante', $user->email)->where('status', 'pendente')->count(),
            'respondidas' => EsicSolicitacao::where('email_solicitante', $user->email)->where('status', 'respondida')->count(),
            'em_analise' => EsicSolicitacao::where('email_solicitante', $user->email)->where('status', 'em_analise')->count()
        ];

        return view('esic.dashboard', compact('minhasSolicitacoes', 'estatisticasUsuario'));
    }

    /**
     * Listar todas as solicitações do usuário
     */
    public function minhasSolicitacoes()
    {
        $user = auth()->user();
        
        $solicitacoes = EsicSolicitacao::where('email_solicitante', $user->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('esic.minhas-solicitacoes', compact('solicitacoes'));
    }

    /**
     * Página de estatísticas públicas
     */
    public function estatisticas()
    {
        // Dados gerais
        $totalSolicitacoes = EsicSolicitacao::count();
        $solicitacoesMes = EsicSolicitacao::whereMonth('created_at', now()->month)->count();
        $solicitacoesAno = EsicSolicitacao::whereYear('created_at', now()->year)->count();
        $tempoMedioResposta = $this->calcularTempoMedioResposta();
        $taxaAtendimento = $this->calcularTaxaAtendimento();
        
        // Dados para gráficos
        $solicitacoesPorCategoria = $this->getSolicitacoesPorCategoria();
        $solicitacoesPorMes = $this->getSolicitacoesPorMes();
        $solicitacoesPorStatus = $this->getSolicitacoesPorStatus();

        return view('esic.estatisticas', compact(
            'totalSolicitacoes',
            'solicitacoesMes', 
            'solicitacoesAno',
            'tempoMedioResposta',
            'taxaAtendimento',
            'solicitacoesPorCategoria',
            'solicitacoesPorMes',
            'solicitacoesPorStatus'
        ));
    }

    /**
     * Exibir formulário de nova solicitação
     */
    public function create()
    {
        return view('esic.create');
    }

    /**
     * Armazenar nova solicitação (usuário autenticado)
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validator = Validator::make($request->all(), [
            'telefone_solicitante' => 'nullable|string|max:20',
            'endereco_solicitante' => 'nullable|string|max:500',
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string|max:5000',
            'categoria' => 'required|in:' . implode(',', array_keys(EsicSolicitacao::getCategorias())),
            'forma_recebimento' => 'required|in:' . implode(',', array_keys(EsicSolicitacao::getFormasRecebimento())),
            'anexos.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,txt',
            'aceita_termos' => 'required|accepted'
        ], [
            'assunto.required' => 'O assunto é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'categoria.required' => 'A categoria é obrigatória.',
            'forma_recebimento.required' => 'A forma de recebimento é obrigatória.',
            'anexos.*.max' => 'Cada arquivo deve ter no máximo 10MB.',
            'anexos.*.mimes' => 'Tipos de arquivo permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG, TXT.',
            'aceita_termos.accepted' => 'Você deve aceitar os termos de uso.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Criar solicitação usando dados do usuário autenticado
            $solicitacao = EsicSolicitacao::create([
                'protocolo' => $this->gerarProtocolo(),
                'nome_solicitante' => $user->name,
                'email_solicitante' => $user->email,
                'cpf_solicitante' => $user->cpf ?? '',
                'telefone_solicitante' => $request->telefone_solicitante ?? $user->telefone,
                'endereco_solicitante' => $request->endereco_solicitante ?? $user->endereco,
                'assunto' => $request->assunto,
                'descricao' => $request->descricao,
                'categoria' => $request->categoria,
                'forma_recebimento' => $request->forma_recebimento,
                'status' => EsicSolicitacao::STATUS_ABERTA,
                'data_solicitacao' => now(),
                'ip_solicitante' => $request->ip(),
                'user_id' => $user->id
            ]);

            // Upload de anexos
            if ($request->hasFile('anexos')) {
                $anexos = [];
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeArquivo = time() . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('esic/anexos/' . $solicitacao->protocolo, $nomeArquivo, 'public');
                    
                    $anexos[] = [
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tamanho' => $arquivo->getSize(),
                        'tipo' => $arquivo->getMimeType()
                    ];
                }
                $solicitacao->update(['anexos' => $anexos]);
            }

            // Registrar movimentação inicial
            EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'status' => EsicSolicitacao::STATUS_ABERTA,
                'descricao' => 'Solicitação registrada no sistema',
                'usuario_id' => null,
                'data_movimentacao' => now()
            ]);

            // Enviar e-mail de confirmação
            $this->enviarEmailConfirmacao($solicitacao);

            return redirect()->route('esic.dashboard')
                ->with('success', 'Solicitação registrada com sucesso! Protocolo: ' . $solicitacao->protocolo)
                ->with('protocolo', $solicitacao->protocolo);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao registrar solicitação. Tente novamente.')->withInput();
        }
    }

    /**
     * Consultar solicitação por protocolo
     */
    public function consultar(Request $request)
    {
        $solicitacao = null;

        if ($request->has('protocolo') && !empty($request->protocolo)) {
            $protocolo = preg_replace('/\D/', '', $request->protocolo);
            $solicitacao = EsicSolicitacao::where('protocolo', $protocolo)->first();

            if (!$solicitacao) {
                return back()->with('error', 'Protocolo não encontrado.');
            }

            // Carregar movimentações
            $solicitacao->load(['movimentacoes' => function($query) {
                $query->orderBy('data_movimentacao', 'desc');
            }]);
        }

        return view('esic.consultar', compact('solicitacao'));
    }

    /**
     * Exibir detalhes da solicitação (para administradores)
     */
    public function show($id)
    {
        $solicitacao = EsicSolicitacao::with(['responsavel', 'movimentacoes.usuario'])
            ->findOrFail($id);

        return view('admin.esic.show', compact('solicitacao'));
    }

    /**
     * Atualizar status da solicitação (para administradores)
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', array_keys(EsicSolicitacao::getStatus())),
            'observacao' => 'nullable|string|max:1000',
            'resposta' => 'nullable|string|max:5000',
            'anexos_resposta.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,txt'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $solicitacao = EsicSolicitacao::findOrFail($id);
            
            // Atualizar status
            $solicitacao->update([
                'status' => $request->status,
                'resposta' => $request->resposta,
                'data_resposta' => $request->status === EsicSolicitacao::STATUS_RESPONDIDA ? now() : null,
                'responsavel_id' => auth()->id()
            ]);

            // Upload de anexos da resposta
            if ($request->hasFile('anexos_resposta')) {
                $anexosResposta = $solicitacao->anexos_resposta ?? [];
                
                foreach ($request->file('anexos_resposta') as $arquivo) {
                    $nomeArquivo = time() . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('esic/respostas/' . $solicitacao->protocolo, $nomeArquivo, 'public');
                    
                    $anexosResposta[] = [
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tamanho' => $arquivo->getSize(),
                        'tipo' => $arquivo->getMimeType(),
                        'data_upload' => now()->toDateTimeString()
                    ];
                }
                
                $solicitacao->update(['anexos_resposta' => $anexosResposta]);
            }

            // Registrar movimentação
            EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'status' => $request->status,
                'descricao' => $request->observacao ?: 'Status atualizado para: ' . $solicitacao->getStatusFormatado(),
                'usuario_id' => auth()->id(),
                'data_movimentacao' => now()
            ]);

            // Enviar e-mail de notificação
            if ($request->status === EsicSolicitacao::STATUS_RESPONDIDA) {
                $this->enviarEmailResposta($solicitacao);
            }

            return back()->with('success', 'Status atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar status. Tente novamente.');
        }
    }

    /**
     * Download de anexo
     */
    public function downloadAnexo($protocolo, $arquivo)
    {
        $solicitacao = EsicSolicitacao::where('protocolo', $protocolo)->firstOrFail();
        
        $caminhoArquivo = 'esic/anexos/' . $protocolo . '/' . $arquivo;
        
        if (!Storage::disk('public')->exists($caminhoArquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($caminhoArquivo);
    }

    /**
     * Download de anexo da resposta
     */
    public function downloadAnexoResposta($protocolo, $arquivo)
    {
        $solicitacao = EsicSolicitacao::where('protocolo', $protocolo)->firstOrFail();
        
        $caminhoArquivo = 'esic/respostas/' . $protocolo . '/' . $arquivo;
        
        if (!Storage::disk('public')->exists($caminhoArquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($caminhoArquivo);
    }

    /**
     * Calcular tempo médio de resposta
     */
    private function calcularTempoMedioResposta()
    {
        $solicitacoesRespondidas = EsicSolicitacao::where('status', EsicSolicitacao::STATUS_RESPONDIDA)
            ->whereNotNull('data_resposta')
            ->get();

        if ($solicitacoesRespondidas->isEmpty()) {
            return 0;
        }

        $totalDias = 0;
        foreach ($solicitacoesRespondidas as $solicitacao) {
            $totalDias += $solicitacao->data_solicitacao->diffInDays($solicitacao->data_resposta);
        }

        return round($totalDias / $solicitacoesRespondidas->count(), 1);
    }

    /**
     * Calcular taxa de atendimento
     */
    private function calcularTaxaAtendimento()
    {
        $total = EsicSolicitacao::count();
        
        if ($total === 0) {
            return 0;
        }

        $atendidas = EsicSolicitacao::whereIn('status', [
            EsicSolicitacao::STATUS_RESPONDIDA,
            EsicSolicitacao::STATUS_FINALIZADA
        ])->count();

        return round(($atendidas / $total) * 100, 1);
    }

    /**
     * Obter solicitações por categoria para gráficos
     */
    private function getSolicitacoesPorCategoria()
    {
        $categorias = EsicSolicitacao::getCategorias();
        $dados = [];

        foreach ($categorias as $key => $nome) {
            $dados[] = [
                'categoria' => $nome,
                'total' => EsicSolicitacao::where('categoria', $key)->count()
            ];
        }

        return $dados;
    }

    /**
     * Obter solicitações por mês para gráficos
     */
    private function getSolicitacoesPorMes()
    {
        $dados = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $data = now()->subMonths($i);
            $dados[] = [
                'mes' => $data->format('M/Y'),
                'total' => EsicSolicitacao::whereYear('created_at', $data->year)
                    ->whereMonth('created_at', $data->month)
                    ->count()
            ];
        }

        return $dados;
    }

    /**
     * Obter solicitações por status para gráficos
     */
    private function getSolicitacoesPorStatus()
    {
        $status = [
            'pendente' => 'Pendente',
            'em_analise' => 'Em Análise',
            'respondida' => 'Respondida',
            'finalizada' => 'Finalizada',
            'negada' => 'Negada'
        ];

        $dados = [];
        foreach ($status as $key => $nome) {
            $dados[] = [
                'status' => $nome,
                'total' => EsicSolicitacao::where('status', $key)->count()
            ];
        }

        return $dados;
    }

    /**
     * Enviar e-mail de confirmação
     */
    private function enviarEmailConfirmacao($solicitacao)
    {
        try {
            // Implementar envio de e-mail
            // Mail::to($solicitacao->email_solicitante)->send(new EsicConfirmacao($solicitacao));
        } catch (\Exception $e) {
            // Log do erro
        }
    }

    /**
     * Enviar e-mail de resposta
     */
    private function enviarEmailResposta($solicitacao)
    {
        try {
            // Implementar envio de e-mail
            // Mail::to($solicitacao->email_solicitante)->send(new EsicResposta($solicitacao));
        } catch (\Exception $e) {
            // Log do erro
        }
    }

    /**
     * Exibir página sobre o E-SIC
     */
    public function sobre()
    {
        return view('esic.sobre');
    }

    /**
     * Exibir página de perguntas frequentes
     */
    public function faq()
    {
        $faqs = [
            [
                'pergunta' => 'O que é o E-SIC?',
                'resposta' => 'O E-SIC (Sistema Eletrônico do Serviço de Informação ao Cidadão) é um sistema que permite a qualquer pessoa, física ou jurídica, encaminhar pedidos de acesso à informação para órgãos e entidades do Poder Público.'
            ],
            [
                'pergunta' => 'Quem pode fazer solicitações?',
                'resposta' => 'Qualquer pessoa, física ou jurídica, pode solicitar informações aos órgãos públicos. Não é necessário apresentar motivos para a solicitação.'
            ],
            [
                'pergunta' => 'Qual o prazo para resposta?',
                'resposta' => 'O prazo para resposta é de até 20 dias, prorrogável por mais 10 dias mediante justificativa expressa.'
            ],
            [
                'pergunta' => 'Como acompanhar minha solicitação?',
                'resposta' => 'Você pode acompanhar sua solicitação através do número de protocolo fornecido no momento do cadastro, utilizando a opção "Consultar Solicitação".'
            ],
            [
                'pergunta' => 'Posso anexar documentos à minha solicitação?',
                'resposta' => 'Sim, é possível anexar documentos que complementem sua solicitação. Os formatos aceitos são: PDF, DOC, DOCX, JPG, JPEG, PNG e TXT, com tamanho máximo de 10MB por arquivo.'
            ],
            [
                'pergunta' => 'E se eu não concordar com a resposta?',
                'resposta' => 'Caso não concorde com a resposta ou não a receba no prazo, você pode apresentar recurso no prazo de 10 dias a contar do seu recebimento.'
            ]
        ];

        return view('esic.faq', compact('faqs'));
    }
}