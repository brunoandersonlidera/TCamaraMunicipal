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
    private function getStatistics($user)
    {
        $stats = [];

        // Manifestações de Ouvidoria
        $manifestacoesQuery = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id);
        
        $stats['manifestacoes'] = [
            'total' => $manifestacoesQuery->count(),
            'pendentes' => $manifestacoesQuery->where('status', 'pendente')->count(),
            'em_andamento' => $manifestacoesQuery->where('status', 'em_andamento')->count(),
            'respondidas' => $manifestacoesQuery->where('status', 'respondida')->count(),
            'finalizadas' => $manifestacoesQuery->where('status', 'finalizada')->count(),
        ];

        // Solicitações E-SIC (se tiver permissão)
        if ($user->canResponderEsic()) {
            $esicQuery = EsicSolicitacao::where('responsavel_id', $user->id);
            
            $stats['esic'] = [
                'total' => $esicQuery->count(),
                'pendentes' => $esicQuery->where('status', 'pendente')->count(),
                'em_andamento' => $esicQuery->where('status', 'em_andamento')->count(),
                'respondidas' => $esicQuery->where('status', 'respondida')->count(),
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
     * API: Obter estatísticas atualizadas
     */
    public function getStats()
    {
        $user = Auth::user();
        $stats = $this->getStatistics($user);
        return response()->json($stats);
    }

    /**
     * API: Obter dados de performance para gráfico
     */
    public function getPerformanceData()
    {
        $user = Auth::user();
        $data = $this->getChartData($user);
        return response()->json($data);
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

        return response()->json([
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => array_values($colors)
            ]]
        ]);
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