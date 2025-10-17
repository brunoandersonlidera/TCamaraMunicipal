<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EsicUsuario;
use App\Models\OuvidoriaManifestacao;
use App\Models\CartaServico;
use App\Models\Notificacao;
use App\Models\Vereador;
use App\Models\Sessao;
use App\Models\ProjetoLei;
use App\Models\Documento;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of available reports.
     */
    public function index()
    {
        $relatorios = [
            'geral' => [
                'titulo' => 'Relatório Geral',
                'descricao' => 'Visão geral de todas as atividades do sistema',
                'icone' => 'fas fa-chart-bar',
                'rota' => 'admin.relatorios.geral'
            ],
            'manifestacoes' => [
                'titulo' => 'Manifestações',
                'descricao' => 'Relatório detalhado das manifestações de ouvidoria',
                'icone' => 'fas fa-comments',
                'rota' => 'admin.relatorios.manifestacoes'
            ],
            'usuarios' => [
                'titulo' => 'Usuários E-SIC',
                'descricao' => 'Relatório de usuários cadastrados no sistema E-SIC',
                'icone' => 'fas fa-users',
                'rota' => 'admin.relatorios.usuarios'
            ],
            'ouvidores' => [
                'titulo' => 'Ouvidores',
                'descricao' => 'Performance e atividades dos ouvidores',
                'icone' => 'fas fa-user-tie',
                'rota' => 'admin.relatorios.ouvidores'
            ],
            'sessoes' => [
                'titulo' => 'Sessões',
                'descricao' => 'Relatório das sessões da câmara municipal',
                'icone' => 'fas fa-gavel',
                'rota' => 'admin.relatorios.sessoes'
            ],
            'projetos' => [
                'titulo' => 'Projetos de Lei',
                'descricao' => 'Relatório dos projetos de lei tramitados',
                'icone' => 'fas fa-file-alt',
                'rota' => 'admin.relatorios.projetos'
            ],
            'documentos' => [
                'titulo' => 'Documentos',
                'descricao' => 'Relatório dos documentos publicados',
                'icone' => 'fas fa-folder-open',
                'rota' => 'admin.relatorios.documentos'
            ],
            'noticias' => [
                'titulo' => 'Notícias',
                'descricao' => 'Relatório das notícias publicadas',
                'icone' => 'fas fa-newspaper',
                'rota' => 'admin.relatorios.noticias'
            ]
        ];

        return view('admin.relatorios.index', compact('relatorios'));
    }

    /**
     * Relatório geral do sistema
     */
    public function geral(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $dados = [
            'periodo' => $periodo,
            'data_inicio' => $dataInicio,
            'resumo' => [
                'usuarios_cadastrados' => EsicUsuario::where('created_at', '>=', $dataInicio)->count(),
                'manifestacoes_recebidas' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)->count(),
                'manifestacoes_respondidas' => OuvidoriaManifestacao::where('respondida_em', '>=', $dataInicio)->count(),
                'sessoes_realizadas' => Sessao::where('data_sessao', '>=', $dataInicio)->count(),
                'projetos_apresentados' => ProjetoLei::where('created_at', '>=', $dataInicio)->count(),
                'documentos_publicados' => Documento::where('created_at', '>=', $dataInicio)->count(),
                'noticias_publicadas' => Noticia::where('data_publicacao', '>=', $dataInicio)->count(),
            ],
            'estatisticas' => [
                'total_usuarios' => EsicUsuario::count(),
                'total_manifestacoes' => OuvidoriaManifestacao::count(),
                'total_ouvidores' => \App\Models\User::ouvidores()->count(),
                'total_vereadores' => Vereador::count(),
                'total_sessoes' => Sessao::count(),
                'total_projetos' => ProjetoLei::count(),
                'total_documentos' => Documento::count(),
                'total_noticias' => Noticia::count(),
            ]
        ];

        return view('admin.relatorios.geral', compact('dados'));
    }

    /**
     * Relatório de manifestações
     */
    public function manifestacoes(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $manifestacoes = OuvidoriaManifestacao::with(['usuario', 'ouvidor'])
                                             ->where('created_at', '>=', $dataInicio)
                                             ->orderBy('created_at', 'desc')
                                             ->paginate(50);

        $estatisticas = [
            'total' => $manifestacoes->total(),
            'respondidas' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                                 ->whereNotNull('respondida_em')
                                                 ->count(),
            'pendentes' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                               ->whereNull('respondida_em')
                                               ->count(),
            'por_tipo' => OuvidoriaManifestacao::where('created_at', '>=', $dataInicio)
                                              ->selectRaw('tipo, COUNT(*) as total')
                                              ->groupBy('tipo')
                                              ->pluck('total', 'tipo'),
            'tempo_medio_resposta' => OuvidoriaManifestacao::whereNotNull('respondida_em')
                                                          ->where('created_at', '>=', $dataInicio)
                                                          ->selectRaw('AVG(DATEDIFF(respondida_em, created_at)) as media')
                                                          ->value('media'),
        ];

        return view('admin.relatorios.manifestacoes', compact('manifestacoes', 'estatisticas', 'periodo'));
    }

    /**
     * Relatório de usuários E-SIC
     */
    public function usuarios(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $usuarios = EsicUsuario::withCount('manifestacoes')
                              ->where('created_at', '>=', $dataInicio)
                              ->orderBy('created_at', 'desc')
                              ->paginate(50);

        $estatisticas = [
            'total_cadastrados' => $usuarios->total(),
            'verificados' => EsicUsuario::where('created_at', '>=', $dataInicio)
                                        ->whereNotNull('email_verified_at')
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

        return view('admin.relatorios.usuarios', compact('usuarios', 'estatisticas', 'periodo'));
    }

    /**
     * Relatório de ouvidores
     */
    public function ouvidores(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $ouvidores = \App\Models\User::ouvidores()
                           ->withCount([
                               'manifestacoesResponsavel as manifestacoes_count',
                               'manifestacoesResponsavel as manifestacoes_periodo' => function($q) use ($dataInicio) {
                                   $q->where('created_at', '>=', $dataInicio);
                               },
                               'manifestacoesResponsavel as manifestacoes_respondidas' => function($q) {
                                   $q->where('status', 'respondida');
                               }
                           ])
                           ->get();

        return view('admin.relatorios.ouvidores', compact('ouvidores', 'periodo'));
    }

    /**
     * Relatório de sessões
     */
    public function sessoes(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $sessoes = Sessao::with(['tipo', 'presidente', 'secretario'])
                         ->where('data_sessao', '>=', $dataInicio)
                         ->orderBy('data_sessao', 'desc')
                         ->paginate(50);

        $estatisticas = [
            'total' => $sessoes->total(),
            'por_tipo' => Sessao::where('data_sessao', '>=', $dataInicio)
                                ->join('tipo_sessaos', 'sessoes.tipo_sessao_id', '=', 'tipo_sessaos.id')
                                ->selectRaw('tipo_sessaos.nome, COUNT(*) as total')
                                ->groupBy('tipo_sessaos.nome')
                                ->pluck('total', 'nome'),
            'com_transmissao' => Sessao::where('data_sessao', '>=', $dataInicio)
                                      ->where('transmissao_online', true)
                                      ->count(),
        ];

        return view('admin.relatorios.sessoes', compact('sessoes', 'estatisticas', 'periodo'));
    }

    /**
     * Relatório de projetos de lei
     */
    public function projetos(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $projetos = ProjetoLei::with(['autor', 'coautores'])
                             ->where('created_at', '>=', $dataInicio)
                             ->orderBy('created_at', 'desc')
                             ->paginate(50);

        $estatisticas = [
            'total' => $projetos->total(),
            'por_status' => ProjetoLei::where('created_at', '>=', $dataInicio)
                                     ->selectRaw('status, COUNT(*) as total')
                                     ->groupBy('status')
                                     ->pluck('total', 'status'),
            'por_tipo' => ProjetoLei::where('created_at', '>=', $dataInicio)
                                   ->selectRaw('tipo, COUNT(*) as total')
                                   ->groupBy('tipo')
                                   ->pluck('total', 'tipo'),
        ];

        return view('admin.relatorios.projetos', compact('projetos', 'estatisticas', 'periodo'));
    }

    /**
     * Relatório de documentos
     */
    public function documentos(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $documentos = Documento::where('created_at', '>=', $dataInicio)
                              ->orderBy('created_at', 'desc')
                              ->paginate(50);

        $estatisticas = [
            'total' => $documentos->total(),
            'por_categoria' => Documento::where('created_at', '>=', $dataInicio)
                                       ->selectRaw('categoria, COUNT(*) as total')
                                       ->groupBy('categoria')
                                       ->pluck('total', 'categoria'),
            'mais_visualizados' => Documento::where('created_at', '>=', $dataInicio)
                                           ->orderBy('visualizacoes', 'desc')
                                           ->limit(10)
                                           ->get(),
        ];

        return view('admin.relatorios.documentos', compact('documentos', 'estatisticas', 'periodo'));
    }

    /**
     * Relatório de notícias
     */
    public function noticias(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $noticias = Noticia::with('autor')
                          ->where('data_publicacao', '>=', $dataInicio)
                          ->orderBy('data_publicacao', 'desc')
                          ->paginate(50);

        $estatisticas = [
            'total' => $noticias->total(),
            'publicadas' => Noticia::where('data_publicacao', '>=', $dataInicio)
                                  ->where('status', 'publicado')
                                  ->count(),
            'rascunhos' => Noticia::where('created_at', '>=', $dataInicio)
                                 ->where('status', 'rascunho')
                                 ->count(),
            'por_categoria' => Noticia::where('data_publicacao', '>=', $dataInicio)
                                     ->whereNotNull('categoria')
                                     ->selectRaw('categoria, COUNT(*) as total')
                                     ->groupBy('categoria')
                                     ->pluck('total', 'categoria'),
        ];

        return view('admin.relatorios.noticias', compact('noticias', 'estatisticas', 'periodo'));
    }

    /**
     * Export report data
     */
    public function exportar(Request $request)
    {
        $tipo = $request->get('tipo', 'geral');
        
        // Implementar exportação específica por tipo
        return redirect()->back()->with('info', 'Funcionalidade de exportação em desenvolvimento.');
    }
}