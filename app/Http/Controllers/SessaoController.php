<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Vereador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SessaoController extends Controller
{
    public function index(Request $request)
    {
        $query = Sessao::with(['presidenteSessao', 'secretarioSessao', 'vereadores', 'projetosLei'])
            ->where('status', '!=', 'cancelada');

        // Filtros públicos
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('numero_sessao', 'like', "%{$busca}%")
                  ->orWhereJsonContains('pauta', $busca);
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ano')) {
            $query->whereYear('data_sessao', $request->ano);
        }

        if ($request->filled('mes')) {
            $query->whereMonth('data_sessao', $request->mes);
        }

        if ($request->filled('legislatura')) {
            $query->where('legislatura', $request->legislatura);
        }

        // Filtros para vídeos gravados
        if ($request->filled('com_video')) {
            if ($request->com_video === '1') {
                $query->comVideo();
            } elseif ($request->com_video === '0') {
                $query->where(function($q) {
                    $q->where('video_disponivel', false)
                      ->orWhereNull('video_url');
                });
            }
        }

        if ($request->filled('plataforma')) {
            $query->plataforma($request->plataforma);
        }

        // Ordenação
        $ordenacao = $request->get('ordenacao', 'data_desc');
        switch ($ordenacao) {
            case 'data_asc':
                $query->orderBy('data_sessao', 'asc')->orderBy('hora_inicio', 'asc');
                break;
            case 'numero_asc':
                $query->orderBy('numero_sessao', 'asc');
                break;
            case 'numero_desc':
                $query->orderBy('numero_sessao', 'desc');
                break;
            case 'tipo':
                $query->orderBy('tipo', 'asc')->orderBy('data_sessao', 'desc');
                break;
            default: // data_desc
                $query->orderBy('data_sessao', 'desc')->orderBy('hora_inicio', 'desc');
        }

        $sessoes = $query->paginate(12)->withQueryString();

        // Dados para filtros
        $anos = Sessao::selectRaw('YEAR(data_sessao) as ano')
            ->distinct()
            ->orderBy('ano', 'desc')
            ->pluck('ano');

        $legislaturas = Sessao::select('legislatura')
            ->distinct()
            ->orderBy('legislatura', 'desc')
            ->pluck('legislatura');

        // Buscar sessão ao vivo (em andamento)
        $sessaoAoVivo = Sessao::where('status', 'em_andamento')
            ->whereNotNull('transmissao_online')
            ->with(['presidenteSessao', 'secretarioSessao'])
            ->first();

        // Se não há filtros ativos, buscar sessões agrupadas por tipo
        $sessoesPorTipo = null;
        if (!$request->hasAny(['busca', 'tipo', 'status', 'ano', 'com_video', 'plataforma'])) {
            $sessoesPorTipo = Sessao::select('tipo')
                ->selectRaw('COUNT(*) as total')
                ->whereNotNull('tipo')
                ->where('tipo', '!=', '')
                ->groupBy('tipo')
                ->orderBy('total', 'desc')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->tipo => Sessao::where('tipo', $item->tipo)
                            ->orderBy('data_sessao', 'desc')
                            ->orderBy('numero_sessao', 'desc')
                            ->take(6)
                            ->get()
                    ];
                });
        }

        return view('sessoes.index', compact('sessoes', 'anos', 'legislaturas', 'sessaoAoVivo', 'sessoesPorTipo'));
    }

    public function tvCamara()
    {
        // Buscar sessão em destaque (próxima, atual ou última)
        $sessaoDestaque = Sessao::where('status', 'em_andamento')->first() ?? // Sessão em andamento
                         Sessao::where('status', 'agendada')
                               ->where('data_sessao', '>=', now()->toDateString())
                               ->orderBy('data_sessao', 'asc')
                               ->orderBy('hora_inicio', 'asc')
                               ->first() ?? // Próxima sessão agendada
                         Sessao::where('status', 'finalizada')
                               ->orderBy('data_sessao', 'desc')
                               ->orderBy('hora_inicio', 'desc')
                               ->first(); // Última sessão finalizada

        // Buscar todas as sessões com vídeo, organizadas por tipo
        $sessoesPorTipo = Sessao::comVideo()
            ->with(['presidenteSessao', 'secretarioSessao'])
            ->orderBy('data_sessao', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->get()
            ->groupBy('tipo');

        // Buscar sessão ao vivo
        $sessaoAoVivo = Sessao::where('status', 'em_andamento')
            ->whereNotNull('transmissao_online')
            ->with(['presidenteSessao', 'secretarioSessao'])
            ->first();

        // Estatísticas
        $totalSessoes = Sessao::count();
        $sessoesComVideo = Sessao::comVideo()->count();
        $horasGravadas = Sessao::comVideo()
            ->whereNotNull('duracao_video')
            ->sum('duracao_video'); // em minutos

        return view('sessoes.tv-camara', compact(
            'sessaoDestaque', 
            'sessoesPorTipo', 
            'sessaoAoVivo',
            'totalSessoes',
            'sessoesComVideo',
            'horasGravadas'
        ));
    }

    public function show(Sessao $sessao)
    {
        // Carregar relacionamentos
        $sessao->load([
            'presidenteSessao', 
            'secretarioSessao', 
            'vereadores' => function($query) {
                $query->orderBy('nome');
            },
            'projetosLei' => function($query) {
                $query->orderBy('numero');
            }
        ]);

        // Sessões relacionadas (mesmo tipo e legislatura)
        $sessoesRelacionadas = Sessao::where('id', '!=', $sessao->id)
            ->where('tipo', $sessao->tipo)
            ->where('legislatura', $sessao->legislatura)
            ->where('status', '!=', 'cancelada')
            ->orderBy('data_sessao', 'desc')
            ->limit(5)
            ->get();

        return view('sessoes.show', compact('sessao', 'sessoesRelacionadas'));
    }

    public function calendario(Request $request)
    {
        $ano = $request->get('ano', date('Y'));
        $mes = $request->get('mes', date('m'));

        $sessoes = Sessao::whereYear('data_sessao', $ano)
            ->whereMonth('data_sessao', $mes)
            ->where('status', '!=', 'cancelada')
            ->with(['presidenteSessao', 'secretarioSessao'])
            ->orderBy('data_sessao')
            ->orderBy('hora_inicio')
            ->get();

        // Agrupar sessões por data
        $sessoesPorData = $sessoes->groupBy(function($sessao) {
            return $sessao->data_sessao->format('Y-m-d');
        });

        return view('sessoes.calendario', compact('sessoesPorData', 'ano', 'mes'));
    }

    public function proximas()
    {
        $proximasSessoes = Sessao::where('data_sessao', '>=', now()->toDateString())
            ->where('status', 'agendada')
            ->with(['presidenteSessao', 'secretarioSessao'])
            ->orderBy('data_sessao')
            ->orderBy('hora_inicio')
            ->limit(10)
            ->get();

        return view('sessoes.proximas', compact('proximasSessoes'));
    }

    public function aoVivo()
    {
        $sessaoAoVivo = Sessao::where('status', 'em_andamento')
            ->whereNotNull('transmissao_online')
            ->with(['presidenteSessao', 'secretarioSessao', 'vereadores'])
            ->first();

        if (!$sessaoAoVivo) {
            return view('sessoes.ao-vivo', [
                'sessaoAoVivo' => null,
                'message' => 'Não há sessões sendo transmitidas ao vivo no momento.'
            ]);
        }

        return view('sessoes.ao-vivo', compact('sessaoAoVivo'));
    }

    public function downloadAta(Sessao $sessao)
    {
        // Verificar se a sessão foi finalizada
        if ($sessao->status !== 'finalizada') {
            return redirect()->back()
                ->with('error', 'A ata só está disponível para sessões finalizadas.');
        }

        if (!$sessao->ata || !Storage::disk('public')->exists($sessao->ata)) {
            return redirect()->back()
                ->with('error', 'Arquivo de ata não encontrado.');
        }

        return Storage::disk('public')->download(
            $sessao->ata, 
            "Ata_Sessao_{$sessao->numero_sessao}_{$sessao->data_sessao->format('Y-m-d')}.pdf"
        );
    }

    public function downloadPauta(Sessao $sessao)
    {
        if (!$sessao->arquivo_pauta || !Storage::disk('public')->exists($sessao->arquivo_pauta)) {
            return redirect()->back()
                ->with('error', 'Arquivo de pauta não encontrado.');
        }

        return Storage::disk('public')->download(
            $sessao->arquivo_pauta, 
            "Pauta_Sessao_{$sessao->numero_sessao}_{$sessao->data_sessao->format('Y-m-d')}.pdf"
        );
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'termo' => 'required|string|min:3|max:100'
        ]);

        $termo = $request->termo;

        $sessoes = Sessao::where(function($query) use ($termo) {
                $query->where('numero_sessao', 'like', "%{$termo}%")
                      ->orWhereJsonContains('pauta', $termo)
                      ->orWhere('observacoes', 'like', "%{$termo}%");
            })
            ->where('status', '!=', 'cancelada')
            ->with(['presidenteSessao', 'secretarioSessao'])
            ->orderBy('data_sessao', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('sessoes.buscar', compact('sessoes', 'termo'));
    }

    public function arquivo(Request $request)
    {
        $query = Sessao::where('status', 'finalizada')
            ->with(['presidenteSessao', 'secretarioSessao']);

        // Filtros para arquivo histórico
        if ($request->filled('ano')) {
            $query->whereYear('data_sessao', $request->ano);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('legislatura')) {
            $query->where('legislatura', $request->legislatura);
        }

        $sessoes = $query->orderBy('data_sessao', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Dados para filtros
        $anos = Sessao::where('status', 'finalizada')
            ->selectRaw('YEAR(data_sessao) as ano')
            ->distinct()
            ->orderBy('ano', 'desc')
            ->pluck('ano');

        $legislaturas = Sessao::where('status', 'finalizada')
            ->select('legislatura')
            ->distinct()
            ->orderBy('legislatura', 'desc')
            ->pluck('legislatura');

        return view('sessoes.arquivo', compact('sessoes', 'anos', 'legislaturas'));
    }

    public function estatisticas()
    {
        $estatisticas = [
            'total_sessoes' => Sessao::count(),
            'sessoes_finalizadas' => Sessao::where('status', 'finalizada')->count(),
            'sessoes_agendadas' => Sessao::where('status', 'agendada')->count(),
            'sessoes_em_andamento' => Sessao::where('status', 'em_andamento')->count(),
            'sessoes_por_tipo' => Sessao::selectRaw('tipo, COUNT(*) as total')
                ->groupBy('tipo')
                ->pluck('total', 'tipo'),
            'sessoes_por_ano' => Sessao::selectRaw('YEAR(data_sessao) as ano, COUNT(*) as total')
                ->groupBy('ano')
                ->orderBy('ano', 'desc')
                ->pluck('total', 'ano'),
            'media_presenca' => $this->calcularMediaPresenca(),
        ];

        return view('sessoes.estatisticas', compact('estatisticas'));
    }

    private function calcularMediaPresenca()
    {
        $sessoesFinalizadas = Sessao::where('status', 'finalizada')
            ->with('vereadores')
            ->get();

        if ($sessoesFinalizadas->isEmpty()) {
            return 0;
        }

        $totalPresencas = 0;
        $totalSessoes = $sessoesFinalizadas->count();
        $totalVereadores = Vereador::ativo()->count();

        foreach ($sessoesFinalizadas as $sessao) {
            $presentes = $sessao->vereadores->where('pivot.presente', true)->count();
            $totalPresencas += $presentes;
        }

        return $totalSessoes > 0 && $totalVereadores > 0 
            ? round(($totalPresencas / ($totalSessoes * $totalVereadores)) * 100, 2)
            : 0;
    }
}