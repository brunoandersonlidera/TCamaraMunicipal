<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use App\Models\OuvidoriaManifestacao;
use App\Models\EsicSolicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ouvidor']);
    }

    /**
     * Página principal de relatórios
     */
    public function index()
    {
        return view('ouvidor.relatorios.index');
    }

    /**
     * Relatório de manifestações
     */
    public function manifestacoes(Request $request)
    {
        $request->validate([
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'status' => 'nullable|string',
            'tipo_id' => 'nullable|exists:ouvidoria_tipos,id',
            'formato' => 'nullable|in:html,pdf,excel'
        ]);

        $dataInicio = $request->data_inicio ? Carbon::parse($request->data_inicio) : Carbon::now()->subMonth();
        $dataFim = $request->data_fim ? Carbon::parse($request->data_fim) : Carbon::now();

        $query = OuvidoriaManifestacao::with(['tipo', 'cidadao', 'ouvidorResponsavel'])
            ->where('ouvidor_responsavel_id', Auth::id())
            ->whereBetween('created_at', [$dataInicio, $dataFim]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
        }

        $manifestacoes = $query->orderBy('created_at', 'desc')->get();

        // Estatísticas
        $stats = [
            'total' => $manifestacoes->count(),
            'por_status' => $manifestacoes->groupBy('status')->map->count(),
            'por_tipo' => $manifestacoes->groupBy('tipo.nome')->map->count(),
            'tempo_medio_resposta' => $this->calcularTempoMedioResposta($manifestacoes),
            'vencidas' => $manifestacoes->where('prazo_resposta', '<', now())->count(),
            'no_prazo' => $manifestacoes->where('prazo_resposta', '>', now())->count()
        ];

        $formato = $request->formato ?? 'html';

        switch ($formato) {
            case 'pdf':
                return $this->gerarPdfManifestacoes($manifestacoes, $stats, $dataInicio, $dataFim);
            case 'excel':
                return $this->gerarExcelManifestacoes($manifestacoes, $stats, $dataInicio, $dataFim);
            default:
                return view('ouvidor.relatorios.manifestacoes', compact('manifestacoes', 'stats', 'dataInicio', 'dataFim'));
        }
    }

    /**
     * Relatório de solicitações e-SIC
     */
    public function esic(Request $request)
    {
        $request->validate([
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'status' => 'nullable|string',
            'formato' => 'nullable|in:html,pdf,excel'
        ]);

        $dataInicio = $request->data_inicio ? Carbon::parse($request->data_inicio) : Carbon::now()->subMonth();
        $dataFim = $request->data_fim ? Carbon::parse($request->data_fim) : Carbon::now();

        $query = EsicSolicitacao::with(['cidadao', 'responsavel'])
            ->where('responsavel_id', Auth::id())
            ->whereBetween('created_at', [$dataInicio, $dataFim]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $solicitacoes = $query->orderBy('created_at', 'desc')->get();

        // Estatísticas
        $stats = [
            'total' => $solicitacoes->count(),
            'por_status' => $solicitacoes->groupBy('status')->map->count(),
            'tempo_medio_resposta' => $this->calcularTempoMedioRespostaEsic($solicitacoes),
            'vencidas' => $solicitacoes->where('prazo_resposta', '<', now())->count(),
            'no_prazo' => $solicitacoes->where('prazo_resposta', '>', now())->count()
        ];

        $formato = $request->formato ?? 'html';

        switch ($formato) {
            case 'pdf':
                return $this->gerarPdfEsic($solicitacoes, $stats, $dataInicio, $dataFim);
            case 'excel':
                return $this->gerarExcelEsic($solicitacoes, $stats, $dataInicio, $dataFim);
            default:
                return view('ouvidor.relatorios.esic', compact('solicitacoes', 'stats', 'dataInicio', 'dataFim'));
        }
    }

    /**
     * Relatório de performance do ouvidor
     */
    public function performance(Request $request)
    {
        $request->validate([
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'formato' => 'nullable|in:html,pdf,excel'
        ]);

        $dataInicio = $request->data_inicio ? Carbon::parse($request->data_inicio) : Carbon::now()->subMonth();
        $dataFim = $request->data_fim ? Carbon::parse($request->data_fim) : Carbon::now();

        // Dados de manifestações
        $manifestacoes = OuvidoriaManifestacao::where('ouvidor_responsavel_id', Auth::id())
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->get();

        // Dados de e-SIC
        $esicSolicitacoes = EsicSolicitacao::where('responsavel_id', Auth::id())
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->get();

        $stats = [
            'manifestacoes' => [
                'total' => $manifestacoes->count(),
                'respondidas' => $manifestacoes->where('status', 'respondida')->count(),
                'finalizadas' => $manifestacoes->where('status', 'finalizada')->count(),
                'vencidas' => $manifestacoes->where('prazo_resposta', '<', now())->count(),
                'tempo_medio' => $this->calcularTempoMedioResposta($manifestacoes)
            ],
            'esic' => [
                'total' => $esicSolicitacoes->count(),
                'respondidas' => $esicSolicitacoes->where('status', 'respondida')->count(),
                'finalizadas' => $esicSolicitacoes->where('status', 'finalizada')->count(),
                'vencidas' => $esicSolicitacoes->where('prazo_resposta', '<', now())->count(),
                'tempo_medio' => $this->calcularTempoMedioRespostaEsic($esicSolicitacoes)
            ]
        ];

        // Calcular índices de performance
        $performance = [
            'taxa_resposta_manifestacoes' => $manifestacoes->count() > 0 ? 
                round(($stats['manifestacoes']['respondidas'] / $manifestacoes->count()) * 100, 2) : 0,
            'taxa_resposta_esic' => $esicSolicitacoes->count() > 0 ? 
                round(($stats['esic']['respondidas'] / $esicSolicitacoes->count()) * 100, 2) : 0,
            'taxa_cumprimento_prazo_manifestacoes' => $manifestacoes->count() > 0 ? 
                round((($manifestacoes->count() - $stats['manifestacoes']['vencidas']) / $manifestacoes->count()) * 100, 2) : 0,
            'taxa_cumprimento_prazo_esic' => $esicSolicitacoes->count() > 0 ? 
                round((($esicSolicitacoes->count() - $stats['esic']['vencidas']) / $esicSolicitacoes->count()) * 100, 2) : 0
        ];

        $formato = $request->formato ?? 'html';

        switch ($formato) {
            case 'pdf':
                return $this->gerarPdfPerformance($stats, $performance, $dataInicio, $dataFim);
            case 'excel':
                return $this->gerarExcelPerformance($stats, $performance, $dataInicio, $dataFim);
            default:
                return view('ouvidor.relatorios.performance', compact('stats', 'performance', 'dataInicio', 'dataFim'));
        }
    }

    /**
     * Calcular tempo médio de resposta para manifestações
     */
    private function calcularTempoMedioResposta($manifestacoes)
    {
        $respondidas = $manifestacoes->whereNotNull('respondida_em');
        
        if ($respondidas->isEmpty()) {
            return 0;
        }

        $totalDias = $respondidas->sum(function ($manifestacao) {
            return Carbon::parse($manifestacao->created_at)->diffInDays(Carbon::parse($manifestacao->respondida_em));
        });

        return round($totalDias / $respondidas->count(), 1);
    }

    /**
     * Calcular tempo médio de resposta para e-SIC
     */
    private function calcularTempoMedioRespostaEsic($solicitacoes)
    {
        $respondidas = $solicitacoes->whereNotNull('respondida_em');
        
        if ($respondidas->isEmpty()) {
            return 0;
        }

        $totalDias = $respondidas->sum(function ($solicitacao) {
            return Carbon::parse($solicitacao->created_at)->diffInDays(Carbon::parse($solicitacao->respondida_em));
        });

        return round($totalDias / $respondidas->count(), 1);
    }

    /**
     * Gerar PDF para manifestações (placeholder)
     */
    private function gerarPdfManifestacoes($manifestacoes, $stats, $dataInicio, $dataFim)
    {
        // Implementar geração de PDF
        return response()->json(['message' => 'Funcionalidade de PDF em desenvolvimento']);
    }

    /**
     * Gerar Excel para manifestações (placeholder)
     */
    private function gerarExcelManifestacoes($manifestacoes, $stats, $dataInicio, $dataFim)
    {
        // Implementar geração de Excel
        return response()->json(['message' => 'Funcionalidade de Excel em desenvolvimento']);
    }

    /**
     * Gerar PDF para e-SIC (placeholder)
     */
    private function gerarPdfEsic($solicitacoes, $stats, $dataInicio, $dataFim)
    {
        // Implementar geração de PDF
        return response()->json(['message' => 'Funcionalidade de PDF em desenvolvimento']);
    }

    /**
     * Gerar Excel para e-SIC (placeholder)
     */
    private function gerarExcelEsic($solicitacoes, $stats, $dataInicio, $dataFim)
    {
        // Implementar geração de Excel
        return response()->json(['message' => 'Funcionalidade de Excel em desenvolvimento']);
    }

    /**
     * Gerar PDF para performance (placeholder)
     */
    private function gerarPdfPerformance($stats, $performance, $dataInicio, $dataFim)
    {
        // Implementar geração de PDF
        return response()->json(['message' => 'Funcionalidade de PDF em desenvolvimento']);
    }

    /**
     * Gerar Excel para performance (placeholder)
     */
    private function gerarExcelPerformance($stats, $performance, $dataInicio, $dataFim)
    {
        // Implementar geração de Excel
        return response()->json(['message' => 'Funcionalidade de Excel em desenvolvimento']);
    }
}