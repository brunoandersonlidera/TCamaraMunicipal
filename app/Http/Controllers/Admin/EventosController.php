<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Vereador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Evento::with(['vereador', 'user']);
        
        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_evento', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->whereDate('data_evento', '<=', $request->data_fim);
        }
        
        if ($request->filled('vereador_id')) {
            $query->where('vereador_id', $request->vereador_id);
        }
        
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('local', 'like', "%{$busca}%");
            });
        }
        
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inativo') {
                $query->where('ativo', false);
            }
        }
        
        // Ordenação
        $orderBy = $request->get('order_by', 'data_evento');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);
        
        $eventos = $query->paginate(5)->withQueryString();
        
        // Dados para filtros
        $vereadores = Vereador::ativos()->orderBy('nome')->get();
        $tipos = Evento::getTipos();
        
        return view('admin.eventos.index', compact('eventos', 'vereadores', 'tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vereadores = Vereador::ativos()->orderBy('nome')->get();
        $tipos = Evento::getTipos();
        $cores = Evento::getCoresPadrao();
        
        return view('admin.eventos.create', compact('vereadores', 'tipos', 'cores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:' . implode(',', array_keys(Evento::getTipos())),
            'data_evento' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i|after:hora_inicio',
            'local' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'vereador_id' => 'nullable|exists:vereadores,id',
            'destaque' => 'boolean',
            'cor_destaque' => 'nullable|string|max:7',
            'ativo' => 'boolean',
            'url_detalhes' => 'nullable|url',
            'anexo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);
        
        // Processar anexo se enviado
        if ($request->hasFile('anexo')) {
            $anexo = $request->file('anexo');
            $nomeArquivo = time() . '_' . $anexo->getClientOriginalName();
            $caminhoAnexo = $anexo->storeAs('eventos/anexos', $nomeArquivo, 'public');
            $validated['anexo_path'] = $caminhoAnexo;
            $validated['anexo_nome'] = $anexo->getClientOriginalName();
        }
        
        $validated['user_id'] = Auth::id();
        
        $evento = Evento::create($validated);
        
        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load(['vereador', 'user']);
        
        return view('admin.eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        $vereadores = Vereador::ativos()->orderBy('nome')->get();
        $tipos = Evento::getTipos();
        $cores = Evento::getCoresPadrao();
        
        return view('admin.eventos.edit', compact('evento', 'vereadores', 'tipos', 'cores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:' . implode(',', array_keys(Evento::getTipos())),
            'data_evento' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i|after:hora_inicio',
            'local' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'vereador_id' => 'nullable|exists:vereadores,id',
            'destaque' => 'boolean',
            'cor_destaque' => 'nullable|string|max:7',
            'ativo' => 'boolean',
            'url_detalhes' => 'nullable|url',
            'anexo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'remover_anexo' => 'boolean'
        ]);
        
        // Remover anexo se solicitado
        if ($request->boolean('remover_anexo') && $evento->anexo_path) {
            Storage::disk('public')->delete($evento->anexo_path);
            $validated['anexo_path'] = null;
            $validated['anexo_nome'] = null;
        }
        
        // Processar novo anexo se enviado
        if ($request->hasFile('anexo')) {
            // Remover anexo anterior se existir
            if ($evento->anexo_path) {
                Storage::disk('public')->delete($evento->anexo_path);
            }
            
            $anexo = $request->file('anexo');
            $nomeArquivo = time() . '_' . $anexo->getClientOriginalName();
            $caminhoAnexo = $anexo->storeAs('eventos/anexos', $nomeArquivo, 'public');
            $validated['anexo_path'] = $caminhoAnexo;
            $validated['anexo_nome'] = $anexo->getClientOriginalName();
        }
        
        $evento->update($validated);
        
        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        // Remover anexo se existir
        if ($evento->anexo_path) {
            Storage::disk('public')->delete($evento->anexo_path);
        }
        
        $evento->delete();
        
        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento excluído com sucesso!');
    }
    
    /**
     * Ativar/Desativar evento
     */
    public function toggleStatus(Evento $evento)
    {
        $evento->update(['ativo' => !$evento->ativo]);
        
        $status = $evento->ativo ? 'ativado' : 'desativado';
        
        return response()->json([
            'success' => true,
            'message' => "Evento {$status} com sucesso!",
            'ativo' => $evento->ativo
        ]);
    }
    
    /**
     * Destacar/Remover destaque do evento
     */
    public function toggleDestaque(Evento $evento)
    {
        $evento->update(['destaque' => !$evento->destaque]);
        
        $status = $evento->destaque ? 'destacado' : 'removido do destaque';
        
        return response()->json([
            'success' => true,
            'message' => "Evento {$status} com sucesso!",
            'destaque' => $evento->destaque
        ]);
    }
    
    /**
     * Duplicar evento
     */
    public function duplicate(Evento $evento)
    {
        $novoEvento = $evento->replicate();
        $novoEvento->titulo = $evento->titulo . ' (Cópia)';
        $novoEvento->user_id = Auth::id();
        $novoEvento->created_at = now();
        $novoEvento->updated_at = now();
        
        // Não duplicar anexos
        $novoEvento->anexo_path = null;
        $novoEvento->anexo_nome = null;
        
        $novoEvento->save();
        
        return redirect()->route('admin.eventos.edit', $novoEvento)
            ->with('success', 'Evento duplicado com sucesso! Edite as informações necessárias.');
    }
    
    /**
     * Exportar eventos para CSV
     */
    public function exportarCsv(Request $request)
    {
        $query = Evento::with(['vereador', 'user']);
        
        // Aplicar mesmos filtros da listagem
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_evento', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->whereDate('data_evento', '<=', $request->data_fim);
        }
        
        if ($request->filled('vereador_id')) {
            $query->where('vereador_id', $request->vereador_id);
        }
        
        $eventos = $query->orderBy('data_evento', 'desc')->get();
        
        $filename = 'eventos_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($eventos) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalho
            fputcsv($file, [
                'ID',
                'Título',
                'Tipo',
                'Data',
                'Hora Início',
                'Hora Fim',
                'Local',
                'Vereador',
                'Destaque',
                'Ativo',
                'Criado em'
            ], ';');
            
            // Dados
            foreach ($eventos as $evento) {
                fputcsv($file, [
                    $evento->id,
                    $evento->titulo,
                    Evento::getTipos()[$evento->tipo] ?? $evento->tipo,
                    $evento->data_evento->format('d/m/Y'),
                    $evento->hora_inicio,
                    $evento->hora_fim,
                    $evento->local,
                    $evento->vereador ? $evento->vereador->nome : '',
                    $evento->destaque ? 'Sim' : 'Não',
                    $evento->ativo ? 'Sim' : 'Não',
                    $evento->created_at->format('d/m/Y H:i')
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Sincronizar eventos automáticos
     */
    public function sincronizar()
    {
        try {
            $eventosGerados = Evento::sincronizarEventos();
            
            return response()->json([
                'success' => true,
                'message' => "Sincronização concluída! {$eventosGerados} eventos foram processados.",
                'eventos_gerados' => $eventosGerados
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na sincronização: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Dashboard de estatísticas
     */
    public function dashboard()
    {
        $hoje = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $fimMes = Carbon::now()->endOfMonth();
        
        $stats = [
            'total_eventos' => Evento::count(),
            'eventos_ativos' => Evento::ativos()->count(),
            'eventos_mes' => Evento::whereBetween('data_evento', [$inicioMes, $fimMes])->count(),
            'eventos_hoje' => Evento::whereDate('data_evento', $hoje)->count(),
            'eventos_destaque' => Evento::destaque()->count(),
            'proximos_eventos' => Evento::proximos()->limit(5)->get(),
            'eventos_por_tipo' => Evento::selectRaw('tipo, COUNT(*) as total')
                ->groupBy('tipo')
                ->pluck('total', 'tipo')
                ->toArray(),
            'eventos_por_mes' => Evento::selectRaw('YEAR(data_evento) as ano, MONTH(data_evento) as mes, COUNT(*) as total')
                ->where('data_evento', '>=', Carbon::now()->subMonths(12))
                ->groupBy('ano', 'mes')
                ->orderBy('ano', 'desc')
                ->orderBy('mes', 'desc')
                ->get()
        ];
        
        return view('admin.eventos.dashboard', compact('stats'));
    }
}
