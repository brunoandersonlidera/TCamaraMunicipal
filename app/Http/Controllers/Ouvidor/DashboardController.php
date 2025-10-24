<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use App\Models\OuvidoriaManifestacao;
use App\Models\EsicSolicitacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ouvidor']);
    }

    /**
     * Display the ouvidor dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Estatísticas principais
        $stats = $this->getStatistics($user);
        
        // Manifestações recentes atribuídas ao ouvidor
        $manifestacoesRecentes = $this->getRecentManifestacoes($user);
        
        // Solicitações E-SIC (se tiver permissão)
        $solicitacoesEsic = $this->getSolicitacoesEsic($user);
        
        // Alertas de prazo
        $alertasPrazo = $this->getAlertasPrazo($user);
        
        // Gráficos de performance
        $chartData = $this->getChartData($user);

        return view('ouvidor.dashboard', compact(
            'stats',
            'manifestacoesRecentes',
            'solicitacoesEsic',
            'alertasPrazo',
            'chartData'
        ));
    }

    /**
     * Get main statistics for the ouvidor
     */
    private function getStatistics($user, $period = null)
    {
        $stats = [];

        // Helper para aplicar filtro de período
        $applyPeriod = function ($query, $period, $dateField = 'created_at') {
            if (!$period || $period === 'all') return $query;
            $now = Carbon::now();
            switch ($period) {
                case 'today':
                    $start = $now->copy()->startOfDay();
                    $end = $now->copy()->endOfDay();
                    break;
                case '7d':
                    $start = $now->copy()->subDays(7)->startOfDay();
                    $end = $now->copy()->endOfDay();
                    break;
                case '30d':
                    $start = $now->copy()->subDays(30)->startOfDay();
                    $end = $now->copy()->endOfDay();
                    break;
                case 'month':
                    $start = $now->copy()->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    break;
                default:
                    return $query;
            }
            return $query->whereBetween($dateField, [$start, $end]);
        };

        // Manifestações de Ouvidoria
        $baseManifestacoes = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id);
        $baseManifestacoes = $applyPeriod($baseManifestacoes, $period, 'created_at');
        
        $stats['manifestacoes'] = [
            'total' => (clone $baseManifestacoes)->count(),
            'pendentes' => (clone $baseManifestacoes)->where('status', 'pendente')->count(),
            'em_andamento' => (clone $baseManifestacoes)->where('status', 'em_andamento')->count(),
            'respondidas' => (clone $baseManifestacoes)->where('status', 'respondida')->count(),
            'finalizadas' => (clone $baseManifestacoes)->where('status', 'finalizada')->count(),
        ];

        // Solicitações E-SIC (se tiver permissão)
        if ($user->canResponderEsic()) {
            $baseEsic = EsicSolicitacao::where('responsavel_id', $user->id);
            $baseEsic = $applyPeriod($baseEsic, $period, 'created_at');
            
            $stats['esic'] = [
                'total' => (clone $baseEsic)->count(),
                'pendentes' => (clone $baseEsic)->where('status', 'pendente')->count(),
                'em_andamento' => (clone $baseEsic)->where('status', 'em_andamento')->count(),
                'respondidas' => (clone $baseEsic)->where('status', 'respondida')->count(),
            ];
        }

        // Performance do mês atual
        $inicioMes = Carbon::now()->startOfMonth();
        $fimMes = Carbon::now()->endOfMonth();

        $stats['performance'] = [
            'respondidas_mes' => OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
                ->where('status', 'respondida')
                ->whereBetween('updated_at', [$inicioMes, $fimMes])
                ->count(),
            'tempo_medio_resposta' => $this->getTempoMedioResposta($user),
            'prazo_vencido' => $this->getPrazoVencido($user),
            'proximo_vencimento' => $this->getProximoVencimento($user),
        ];

        // Adicionar performance E-SIC se tiver permissão
        if ($user->canResponderEsic()) {
            $stats['performance']['esic_respondidas_mes'] = EsicSolicitacao::where('responsavel_id', $user->id)
                ->where('status', 'respondida')
                ->whereBetween('updated_at', [$inicioMes, $fimMes])
                ->count();
            $stats['performance']['esic_prazo_vencido'] = $this->getEsicPrazoVencido($user);
            $stats['performance']['esic_proximo_vencimento'] = $this->getEsicProximoVencimento($user);
        }

        return $stats;
    }

    /**
     * Get recent manifestações assigned to the ouvidor
     */
    private function getRecentManifestacoes($user)
    {
        return OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get E-SIC solicitações if user has permission
     */
    private function getSolicitacoesEsic($user)
    {
        if (!$user->canResponderEsic()) {
            return collect();
        }

        return EsicSolicitacao::where('responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get deadline alerts
     */
    private function getAlertasPrazo($user)
    {
        $alertas = [];

        // Manifestações próximas ao vencimento (3 dias)
        $proximoVencimento = Carbon::now()->addDays(3);
        
        $manifestacoesVencendo = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<=', $proximoVencimento)
            ->where('prazo_resposta', '>', Carbon::now())
            ->get();

        foreach ($manifestacoesVencendo as $manifestacao) {
            $alertas[] = [
                'tipo' => 'manifestacao',
                'titulo' => 'Manifestação próxima ao vencimento',
                'descricao' => "Protocolo #{$manifestacao->protocolo} vence em " . 
                              Carbon::parse($manifestacao->prazo_resposta)->diffForHumans(),
                'urgencia' => 'warning',
                'link' => route('ouvidor.manifestacoes.show', $manifestacao->id)
            ];
        }

        // Manifestações vencidas
        $manifestacoesVencidas = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<', Carbon::now())
            ->get();

        foreach ($manifestacoesVencidas as $manifestacao) {
            $alertas[] = [
                'tipo' => 'manifestacao',
                'titulo' => 'Manifestação vencida',
                'descricao' => "Protocolo #{$manifestacao->protocolo} venceu " . 
                              Carbon::parse($manifestacao->prazo_resposta)->diffForHumans(),
                'urgencia' => 'danger',
                'link' => route('ouvidor.manifestacoes.show', $manifestacao->id)
            ];
        }

        // Solicitações E-SIC próximas ao vencimento (se tiver permissão)
        if ($user->canResponderEsic()) {
            $esicVencendo = EsicSolicitacao::where('responsavel_id', $user->id)
                ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
                ->where('data_limite_resposta', '<=', $proximoVencimento)
                ->where('data_limite_resposta', '>', Carbon::now())
                ->get();

            foreach ($esicVencendo as $solicitacao) {
                $alertas[] = [
                    'tipo' => 'esic',
                    'titulo' => 'Solicitação E-SIC próxima ao vencimento',
                    'descricao' => "Protocolo #{$solicitacao->protocolo} vence em " . 
                                  Carbon::parse($solicitacao->data_limite_resposta)->diffForHumans(),
                    'urgencia' => 'warning',
                    'link' => route('ouvidor.esic.show', $solicitacao->id)
                ];
            }

            // Solicitações E-SIC vencidas
            $esicVencidas = EsicSolicitacao::where('responsavel_id', $user->id)
                ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
                ->where('data_limite_resposta', '<', Carbon::now())
                ->get();

            foreach ($esicVencidas as $solicitacao) {
                $alertas[] = [
                    'tipo' => 'esic',
                    'titulo' => 'Solicitação E-SIC vencida',
                    'descricao' => "Protocolo #{$solicitacao->protocolo} venceu " . 
                                  Carbon::parse($solicitacao->data_limite_resposta)->diffForHumans(),
                    'urgencia' => 'danger',
                    'link' => route('ouvidor.esic.show', $solicitacao->id)
                ];
            }
        }

        return collect($alertas);
    }

    /**
     * Get chart data for performance visualization
     */
    private function getChartData($user)
    {
        // Dados dos últimos 6 meses
        $meses = [];
        $manifestacoesPorMes = [];
        $respondidasPorMes = [];

        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $inicioMes = $mes->copy()->startOfMonth();
            $fimMes = $mes->copy()->endOfMonth();

            $meses[] = $mes->format('M/Y');
            
            $totalMes = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
                ->whereBetween('created_at', [$inicioMes, $fimMes])
                ->count();
                
            $respondidasMes = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
                ->where('status', 'respondida')
                ->whereBetween('updated_at', [$inicioMes, $fimMes])
                ->count();

            $manifestacoesPorMes[] = $totalMes;
            $respondidasPorMes[] = $respondidasMes;
        }

        return [
            'meses' => $meses,
            'manifestacoes' => $manifestacoesPorMes,
            'respondidas' => $respondidasPorMes,
        ];
    }

    /**
     * Calculate average response time
     */
    private function getTempoMedioResposta($user)
    {
        $manifestacoes = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->where('status', 'respondida')
            ->whereNotNull('respondida_em')
            ->get();

        if ($manifestacoes->isEmpty()) {
            return 0;
        }

        $totalDias = 0;
        foreach ($manifestacoes as $manifestacao) {
            $dataInicio = Carbon::parse($manifestacao->created_at);
            $dataResposta = Carbon::parse($manifestacao->respondida_em);
            $totalDias += $dataInicio->diffInDays($dataResposta);
        }

        return round($totalDias / $manifestacoes->count(), 1);
    }

    /**
     * Get count of overdue manifestações
     */
    private function getPrazoVencido($user)
    {
        return OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<', Carbon::now())
            ->count();
    }

    /**
     * Get count of manifestações expiring soon
     */
    private function getProximoVencimento($user)
    {
        $proximoVencimento = Carbon::now()->addDays(3);
        
        return OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<=', $proximoVencimento)
            ->where('prazo_resposta', '>', Carbon::now())
            ->count();
    }

    /**
     * Get count of overdue E-SIC solicitações
     */
    private function getEsicPrazoVencido($user)
    {
        return EsicSolicitacao::where('responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
            ->where('data_limite_resposta', '<', Carbon::now())
            ->count();
    }

    /**
     * Get count of E-SIC solicitações expiring soon
     */
    private function getEsicProximoVencimento($user)
    {
        $proximoVencimento = Carbon::now()->addDays(3);
        
        return EsicSolicitacao::where('responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
            ->where('data_limite_resposta', '<=', $proximoVencimento)
            ->where('data_limite_resposta', '>', Carbon::now())
            ->count();
    }

    /**
     * API: Obter estatísticas atualizadas
     */
    public function getStats(Request $request)
    {
        $user = Auth::user();
        $stats = $this->getStatistics($user, $request->query('period'));
        return response()->json($stats);
    }

    /**
     * API: Obter dados de performance para gráfico
     */
    public function getPerformanceData(Request $request)
    {
        $user = Auth::user();
        $data = $this->getChartData($user);
        // Ajustar formato esperado pelo JS (labels/recebidas/respondidas)
        return response()->json([
            'labels' => $data['meses'] ?? [],
            'recebidas' => $data['manifestacoes'] ?? [],
            'respondidas' => $data['respondidas'] ?? [],
        ]);
    }

    /**
     * API: Obter dados de status para gráfico
     */
    public function getStatusData()
    {
        $user = Auth::user();
        $statusData = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $labels = [];
        $data = [];
        $colors = [
            'pendente' => '#ffc107',
            'em_andamento' => '#007bff',
            'respondida' => '#28a745',
            'finalizada' => '#6c757d'
        ];

        foreach ($statusData as $item) {
            $labels[] = ucfirst(str_replace('_', ' ', $item->status));
            $data[] = $item->total;
        }

        // Também retornar métricas agregadas esperadas pelo JS antigo
        $aggregates = [
            'pendentes' => $statusData->where('status', 'pendente')->sum('total'),
            'em_andamento' => $statusData->where('status', 'em_andamento')->sum('total'),
            'respondidas' => $statusData->where('status', 'respondida')->sum('total'),
            'finalizadas' => $statusData->where('status', 'finalizada')->sum('total'),
            'vencidas' => $this->getPrazoVencido($user),
        ];

        return response()->json(array_merge($aggregates, [
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => array_values($colors)
            ]]
        ]));
    }

    /**
     * API: Obter dados de tipo para gráfico
     */
    public function getTipoData()
    {
        $user = Auth::user();
        $tipoData = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        $labels = [];
        $data = [];

        foreach ($tipoData as $item) {
            $labels[] = ucfirst($item->tipo);
            $data[] = $item->total;
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => [
                    '#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#fd7e14'
                ]
            ]]
        ]);
    }

    /**
     * API: Obter notificações
     */
    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = [];

        // Manifestações vencidas
        $vencidas = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<', Carbon::now())
            ->count();

        if ($vencidas > 0) {
            $notifications[] = [
                'id' => 1,
                'title' => 'Manifestações vencidas',
                'message' => "{$vencidas} manifestação(ões) com prazo vencido",
                'type' => 'danger',
                'time' => 'Agora',
                'read' => false
            ];
        }

        // Manifestações próximas ao vencimento
        $proximoVencimento = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<=', Carbon::now()->addDays(3))
            ->where('prazo_resposta', '>', Carbon::now())
            ->count();

        if ($proximoVencimento > 0) {
            $notifications[] = [
                'id' => 2,
                'title' => 'Prazo vencendo',
                'message' => "{$proximoVencimento} manifestação(ões) com prazo vencendo em 3 dias",
                'type' => 'warning',
                'time' => 'Hoje',
                'read' => false
            ];
        }

        // Solicitações E-SIC vencidas (se tiver permissão)
        if ($user->canResponderEsic()) {
            $esicVencidas = EsicSolicitacao::where('responsavel_id', $user->id)
                ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
                ->where('data_limite_resposta', '<', Carbon::now())
                ->count();

            if ($esicVencidas > 0) {
                $notifications[] = [
                    'id' => 3,
                    'title' => 'Solicitações E-SIC vencidas',
                    'message' => "{$esicVencidas} solicitação(ões) E-SIC com prazo vencido",
                    'type' => 'danger',
                    'time' => 'Agora',
                    'read' => false
                ];
            }

            // Solicitações E-SIC próximas ao vencimento
            $esicProximoVencimento = EsicSolicitacao::where('responsavel_id', $user->id)
                ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
                ->where('data_limite_resposta', '<=', Carbon::now()->addDays(3))
                ->where('data_limite_resposta', '>', Carbon::now())
                ->count();

            if ($esicProximoVencimento > 0) {
                $notifications[] = [
                    'id' => 4,
                    'title' => 'E-SIC com prazo vencendo',
                    'message' => "{$esicProximoVencimento} solicitação(ões) E-SIC com prazo vencendo em 3 dias",
                    'type' => 'warning',
                    'time' => 'Hoje',
                    'read' => false
                ];
            }
        }

        return response()->json($notifications);
    }

    /**
     * API: Marcar notificação como lida
     */
    public function markNotificationAsRead($id)
    {
        // Implementar lógica para marcar notificação como lida
        return response()->json(['success' => true]);
    }

    /**
     * API: Buscar manifestações
     */
    public function searchManifestacoes(Request $request)
    {
        $user = Auth::user();
        $query = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('protocolo', 'like', "%{$search}%")
                  ->orWhere('assunto', 'like', "%{$search}%")
                  ->orWhere('nome_cidadao', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('tipo') && $request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        $manifestacoes = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($manifestacoes);
    }
}