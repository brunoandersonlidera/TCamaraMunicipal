<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EsicUsuario;
use App\Models\OuvidoriaManifestacao;
use App\Models\CartaServico;
use App\Models\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard principal
     */
    public function index(Request $request)
    {
        $periodo = $request->get('periodo', '30'); // últimos 30 dias por padrão
        $dataInicio = now()->subDays($periodo);

        // Estatísticas gerais
        $estatisticas = [
            'usuarios' => [
                'total' => EsicUsuario::count(),
                'ativos' => EsicUsuario::whereNotNull('email_verified_at')->count(),
                'novos_periodo' => EsicUsuario::where('created_at', '>=', $dataInicio)->count(),
                'crescimento' => $this->calcularCrescimento(
                    EsicUsuario::where('created_at', '>=', $dataInicio)->count(),
                    EsicUsuario::where('created_at', '>=', $dataInicio->copy()->subDays($periodo))
                              ->where('created_at', '<', $dataInicio)->count()
                ),
            ],
            'manifestacoes' => [
                'total' => OuvidoriaManifestacao::count(),
                'abertas' => OuvidoriaManifestacao::where('status', 'aberta')->count(),
                'em_andamento' => OuvidoriaManifestacao::where('status', 'em_andamento')->count(),
                'respondidas' => OuvidoriaManifestacao::where('status', 'respondida')->count(),
                'novas_periodo' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)->count(),
                'prazo_vencido' => OuvidoriaManifestacao::where('prazo_resposta', '<', now())
                                                       ->whereNotIn('status', ['respondida', 'fechada'])
                                                       ->count(),
                'tempo_medio_resposta' => OuvidoriaManifestacao::whereNotNull('respondida_em')
                                                              ->where('created_at', '>=', $dataInicio)
                                                              ->selectRaw('AVG(DATEDIFF(respondida_em, created_at)) as media')
                                                              ->value('media'),
            ],
            'ouvidores' => [
                'total' => \App\Models\User::ouvidores()->count(),
                'ativos' => \App\Models\User::ouvidores()->active()->count(),
                'com_manifestacoes' => \App\Models\User::ouvidores()->has('manifestacoesResponsavel')->count(),
            ],
            'cartas_servico' => [
                'total' => CartaServico::count(),
                'ativas' => CartaServico::where('ativo', true)->count(),
                'em_revisao' => CartaServico::where('ativo', false)->count(),
            ],
        ];

        // Gráficos de manifestações por período
        $manifestacoesPorDia = $this->getManifestacoesPorPeriodo($dataInicio, 'day');
        $manifestacoesPorTipo = $this->getManifestacoesPorTipo($dataInicio);
        $manifestacoesPorStatus = $this->getManifestacoesPorStatus();

        // Manifestações recentes
        $manifestacoesRecentes = OuvidoriaManifestacao::with(['usuario', 'ouvidorResponsavel'])
                                                     ->orderBy('created_at', 'desc')
                                                     ->limit(10)
                                                     ->get();

        // Usuários recentes
        $usuariosRecentes = EsicUsuario::orderBy('created_at', 'desc')
                                      ->limit(10)
                                      ->get();

        // Alertas e notificações
        $alertas = $this->getAlertas();

        // Performance dos ouvidores
        $performanceOuvidores = $this->getPerformanceOuvidores($dataInicio);

        return view('admin.dashboard.index', compact(
            'estatisticas',
            'manifestacoesPorDia',
            'manifestacoesPorTipo',
            'manifestacoesPorStatus',
            'manifestacoesRecentes',
            'usuariosRecentes',
            'alertas',
            'performanceOuvidores',
            'periodo'
        ));
    }

    /**
     * Relatórios detalhados
     */
    public function relatorios(Request $request)
    {
        $tipo = $request->get('tipo', 'geral');
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        switch ($tipo) {
            case 'manifestacoes':
                return $this->relatorioManifestacoes($dataInicio, $periodo);
            case 'usuarios':
                return $this->relatorioUsuarios($dataInicio, $periodo);
            case 'ouvidores':
                return $this->relatorioOuvidores($dataInicio, $periodo);
            case 'performance':
                return $this->relatorioPerformance($dataInicio, $periodo);
            default:
                return $this->relatorioGeral($dataInicio, $periodo);
        }
    }

    /**
     * Exportar dados
     */
    public function exportar(Request $request)
    {
        $tipo = $request->get('tipo', 'manifestacoes');
        $formato = $request->get('formato', 'csv');
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        switch ($tipo) {
            case 'manifestacoes':
                return $this->exportarManifestacoes($formato, $dataInicio);
            case 'usuarios':
                return $this->exportarUsuarios($formato, $dataInicio);
            default:
                return back()->with('error', 'Tipo de exportação não suportado.');
        }
    }

    /**
     * Calcular crescimento percentual
     */
    private function calcularCrescimento($atual, $anterior)
    {
        if ($anterior == 0) {
            return $atual > 0 ? 100 : 0;
        }
        
        return round((($atual - $anterior) / $anterior) * 100, 1);
    }

    /**
     * Manifestações por período
     */
    private function getManifestacoesPorPeriodo($dataInicio, $agrupamento = 'day')
    {
        $formato = $agrupamento === 'day' ? '%Y-%m-%d' : '%Y-%m';
        
        return OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                  ->selectRaw("DATE_FORMAT(created_at, '{$formato}') as periodo, COUNT(*) as total")
                                  ->groupBy('periodo')
                                  ->orderBy('periodo')
                                  ->get()
                                  ->mapWithKeys(function ($item) {
                                      return [$item->periodo => $item->total];
                                  });
    }

    /**
     * Manifestações por tipo
     */
    private function getManifestacoesPorTipo($dataInicio)
    {
        return OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                  ->selectRaw('tipo, COUNT(*) as total')
                                  ->groupBy('tipo')
                                  ->pluck('total', 'tipo');
    }

    /**
     * Manifestações por status
     */
    private function getManifestacoesPorStatus()
    {
        return OuvidoriaManifestacao::selectRaw('status, COUNT(*) as total')
                                  ->groupBy('status')
                                  ->pluck('total', 'status');
    }

    /**
     * Alertas do sistema
     */
    private function getAlertas()
    {
        $alertas = [];

        // Manifestações com prazo vencido
        $prazoVencido = OuvidoriaManifestacao::where('prazo_resposta', '<', now())
                                           ->whereNotIn('status', ['respondida', 'fechada'])
                                           ->count();
        
        if ($prazoVencido > 0) {
            $alertas[] = [
                'tipo' => 'danger',
                'titulo' => 'Manifestações com Prazo Vencido',
                'mensagem' => "{$prazoVencido} manifestação(ões) estão com prazo de resposta vencido.",
                'link' => route('admin.ouvidoria-manifestacoes.index', ['prazo_vencido' => 1]),
            ];
        }

        // Manifestações próximas do vencimento (3 dias)
        $proximoVencimento = OuvidoriaManifestacao::where('prazo_resposta', '<=', now()->addDays(3))
                                                 ->where('prazo_resposta', '>=', now())
                                                 ->whereNotIn('status', ['respondida', 'fechada'])
                                                 ->count();

        if ($proximoVencimento > 0) {
            $alertas[] = [
                'tipo' => 'warning',
                'titulo' => 'Manifestações Próximas do Vencimento',
                'mensagem' => "{$proximoVencimento} manifestação(ões) vencem em até 3 dias.",
                'link' => route('admin.ouvidoria-manifestacoes.index', ['proximo_vencimento' => 1]),
            ];
        }

        // Usuários não verificados
        $usuariosNaoVerificados = EsicUsuario::whereNull('email_verified_at')->count();
        
        if ($usuariosNaoVerificados > 10) {
            $alertas[] = [
                'tipo' => 'info',
                'titulo' => 'Usuários Não Verificados',
                'mensagem' => "{$usuariosNaoVerificados} usuários ainda não verificaram o e-mail.",
                'link' => route('admin.esic.usuarios.index', ['status' => 'inativo']),
            ];
        }

        return $alertas;
    }

    /**
     * Performance dos ouvidores
     */
    private function getPerformanceOuvidores($dataInicio)
    {
        return \App\Models\User::ouvidores()
                     ->active()
                     ->withCount([
                         'manifestacoesResponsavel as manifestacoes_count',
                         'manifestacoesResponsavel as manifestacoes_periodo' => function ($query) use ($dataInicio) {
                             $query->where('created_at', '>=', $dataInicio);
                         },
                         'manifestacoesResponsavel as manifestacoes_respondidas' => function ($query) {
                             $query->where('status', 'respondida');
                         }
                     ])
                     ->get()
                     ->map(function ($ouvidor) {
                         $tempoMedioResposta = $ouvidor->manifestacoesResponsavel()
                                                     ->whereNotNull('data_resposta')
                                                     ->selectRaw('AVG(DATEDIFF(data_resposta, created_at)) as media')
                                                     ->value('media');

                         return [
                             'ouvidor' => $ouvidor,
                             'total_manifestacoes' => $ouvidor->manifestacoes_count,
                             'manifestacoes_periodo' => $ouvidor->manifestacoes_periodo,
                             'manifestacoes_respondidas' => $ouvidor->manifestacoes_respondidas,
                             'taxa_resposta' => $ouvidor->manifestacoes_count > 0 
                                              ? round(($ouvidor->manifestacoes_respondidas / $ouvidor->manifestacoes_count) * 100, 1)
                                              : 0,
                             'tempo_medio_resposta' => $tempoMedioResposta ? round($tempoMedioResposta, 1) : 0,
                         ];
                     });
    }

    /**
     * Relatório geral
     */
    private function relatorioGeral($dataInicio, $periodo)
    {
        $dados = [
            'periodo' => $periodo,
            'data_inicio' => $dataInicio,
            'resumo' => [
                'usuarios_cadastrados' => EsicUsuario::where('created_at', '>=', $dataInicio)->count(),
                'manifestacoes_recebidas' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)->count(),
                'manifestacoes_respondidas' => OuvidoriaManifestacao::where('respondida_em', '>=', $dataInicio)->count(),
                'tempo_medio_resposta' => OuvidoriaManifestacao::whereNotNull('respondida_em')
                                                              ->where('created_at', '>=', $dataInicio)
                                                              ->selectRaw('AVG(DATEDIFF(respondida_em, created_at)) as media')
                                                              ->value('media'),
            ],
            'por_tipo' => $this->getManifestacoesPorTipo($dataInicio),
            'por_status' => $this->getManifestacoesPorStatus(),
            'evolucao_diaria' => $this->getManifestacoesPorPeriodo($dataInicio, 'day'),
        ];

        return view('admin.dashboard.relatorios.geral', compact('dados'));
    }

    /**
     * Relatório de manifestações
     */
    private function relatorioManifestacoes($dataInicio, $periodo)
    {
        $manifestacoes = OuvidoriaManifestacao::with(['usuario', 'ouvidorResponsavel'])
                                            ->where('created_at', '>=', $dataInicio)
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(50);

        $estatisticas = [
            'total' => $manifestacoes->total(),
            'por_tipo' => $this->getManifestacoesPorTipo($dataInicio),
            'por_status' => $this->getManifestacoesPorStatus(),
            'tempo_medio_resposta' => OuvidoriaManifestacao::whereNotNull('respondida_em')
                                                          ->where('created_at', '>=', $dataInicio)
                                                          ->selectRaw('AVG(DATEDIFF(respondida_em, created_at)) as media')
                                                          ->value('media'),
        ];

        return view('admin.dashboard.relatorios.manifestacoes', compact(
            'manifestacoes', 'estatisticas', 'periodo'
        ));
    }

    /**
     * Relatório de usuários
     */
    private function relatorioUsuarios($dataInicio, $periodo)
    {
        $usuarios = EsicUsuario::withCount('manifestacoes')
                              ->where('created_at', '>=', $dataInicio)
                              ->orderBy('created_at', 'desc')
                              ->paginate(50);

        $estatisticas = [
            'total_cadastrados' => $usuarios->total(),
            'verificados' => EsicUsuario::where('created_at', '>=', $dataInicio)
                                       ->whereNotNull('email_verified_em')
                                       ->count(),
            'com_manifestacoes' => EsicUsuario::where('created_at', '>=', $dataInicio)
                                             ->has('manifestacoes')
                                             ->count(),
            'por_escolaridade' => EsicUsuario::where('created_at', '>=', $dataInicio)
                                            ->whereNotNull('escolaridade')
                                            ->selectRaw('escolaridade, COUNT(*) as total')
                                            ->groupBy('escolaridade')
                                            ->pluck('total', 'escolaridade'),
        ];

        return view('admin.dashboard.relatorios.usuarios', compact(
            'usuarios', 'estatisticas', 'periodo'
        ));
    }

    /**
     * Relatório de ouvidores
     */
    private function relatorioOuvidores($dataInicio, $periodo)
    {
        $performance = $this->getPerformanceOuvidores($dataInicio);

        return view('admin.dashboard.relatorios.ouvidores', compact(
            'performance', 'periodo'
        ));
    }

    /**
     * Relatório de performance
     */
    private function relatorioPerformance($dataInicio, $periodo)
    {
        $dados = [
            'periodo' => $periodo,
            'data_inicio' => $dataInicio,
            'kpis' => [
                'taxa_resposta_geral' => $this->calcularTaxaResposta($dataInicio),
                'tempo_medio_resposta' => $this->calcularTempoMedioResposta($dataInicio),
                'satisfacao_usuario' => $this->calcularSatisfacaoUsuario($dataInicio),
                'cumprimento_prazo' => $this->calcularCumprimentoPrazo($dataInicio),
            ],
            'evolucao_mensal' => $this->getEvolucaoMensal(),
            'performance_ouvidores' => $this->getPerformanceOuvidores($dataInicio),
        ];

        return view('admin.dashboard.relatorios.performance', compact('dados'));
    }

    /**
     * Exportar manifestações
     */
    private function exportarManifestacoes($formato, $dataInicio)
    {
        $manifestacoes = OuvidoriaManifestacao::with(['usuario', 'ouvidorResponsavel'])
                                            ->where('created_at', '>=', $dataInicio)
                                            ->get();

        if ($formato === 'csv') {
            return $this->exportarCSV($manifestacoes, 'manifestacoes');
        }

        // TODO: Implementar outros formatos (Excel, PDF)
        return back()->with('error', 'Formato não suportado.');
    }

    /**
     * Exportar usuários
     */
    private function exportarUsuarios($formato, $dataInicio)
    {
        $usuarios = EsicUsuario::where('created_at', '>=', $dataInicio)->get();

        if ($formato === 'csv') {
            return $this->exportarCSV($usuarios, 'usuarios');
        }

        return back()->with('error', 'Formato não suportado.');
    }

    /**
     * Exportar para CSV
     */
    private function exportarCSV($dados, $tipo)
    {
        $filename = "{$tipo}_" . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($dados, $tipo) {
            $file = fopen('php://output', 'w');
            
            if ($tipo === 'manifestacoes') {
                fputcsv($file, [
                    'Protocolo', 'Tipo', 'Assunto', 'Status', 'Prioridade',
                    'Usuário', 'E-mail', 'Ouvidor', 'Data Criação', 'Data Resposta'
                ]);

                foreach ($dados as $item) {
                    fputcsv($file, [
                        $item->protocolo,
                        $item->tipo,
                        $item->assunto,
                        $item->status,
                        $item->prioridade,
                        $item->usuario->nome,
                        $item->usuario->email,
                        $item->ouvidorResponsavel?->user->name ?? 'Não atribuído',
                        $item->created_at->format('d/m/Y H:i'),
                        $item->data_resposta?->format('d/m/Y H:i') ?? 'Não respondida',
                    ]);
                }
            } elseif ($tipo === 'usuarios') {
                fputcsv($file, [
                    'Nome', 'E-mail', 'CPF', 'Telefone', 'Verificado', 'Data Cadastro'
                ]);

                foreach ($dados as $item) {
                    fputcsv($file, [
                        $item->nome,
                        $item->email,
                        $item->cpf_formatado,
                        $item->telefone,
                        $item->email_verified_at ? 'Sim' : 'Não',
                        $item->created_at->format('d/m/Y H:i'),
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calcular taxa de resposta
     */
    private function calcularTaxaResposta($dataInicio)
    {
        $total = OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)->count();
        $respondidas = OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                          ->whereIn('status', ['respondida', 'fechada'])
                                          ->count();

        return $total > 0 ? round(($respondidas / $total) * 100, 1) : 0;
    }

    /**
     * Calcular tempo médio de resposta
     */
    private function calcularTempoMedioResposta($dataInicio)
    {
        return OuvidoriaManifestacao::whereNotNull('respondida_em')
                                  ->where('created_at', '>=', $dataInicio)
                                  ->selectRaw('AVG(DATEDIFF(respondida_em, created_at)) as media')
                                  ->value('media') ?? 0;
    }

    /**
     * Calcular satisfação do usuário
     */
    private function calcularSatisfacaoUsuario($dataInicio)
    {
        // TODO: Implementar sistema de avaliação
        return 0;
    }

    /**
     * Calcular cumprimento de prazo
     */
    private function calcularCumprimentoPrazo($dataInicio)
    {
        $total = OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                    ->whereNotNull('data_resposta')
                                    ->count();
        
        $noPrazo = OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                      ->whereNotNull('data_resposta')
                                      ->whereRaw('data_resposta <= prazo_resposta')
                                      ->count();

        return $total > 0 ? round(($noPrazo / $total) * 100, 1) : 0;
    }

    /**
     * Evolução mensal
     */
    private function getEvolucaoMensal()
    {
        return OuvidoriaManifestacao::selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
                                  ->where('created_at', '>=', now()->subMonths(12))
                                  ->groupBy('ano', 'mes')
                                  ->orderBy('ano')
                                  ->orderBy('mes')
                                  ->get()
                                  ->mapWithKeys(function ($item) {
                                      return ["{$item->ano}-{$item->mes}" => $item->total];
                                  });
    }
}
