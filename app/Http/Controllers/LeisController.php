<?php

namespace App\Http\Controllers;

use App\Models\Lei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LeisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Verificar se está sendo acessado via rota administrativa
        $routeName = $request->route()->getName();
        $isAdmin = str_starts_with($routeName, 'admin.leis.');
        
        if ($isAdmin) {
            // Para área administrativa, mostrar todas as leis (incluindo inativas)
            $query = Lei::query();
        } else {
            // Para área pública, mostrar apenas leis ativas
            $query = Lei::query()->ativas();
        }

        // Filtros
        if ($request->filled('tipo')) {
            $query->byTipo($request->tipo);
        }

        if ($request->filled('exercicio')) {
            $query->byExercicio($request->exercicio);
        }

        if ($request->filled('busca')) {
            $query->buscar($request->busca);
        }

        // Ordenação
        $ordenacao = $request->get('ordenacao', 'padrao');
        switch ($ordenacao) {
            case 'numero_asc':
                $query->orderBy('numero', 'asc');
                break;
            case 'numero_desc':
                $query->orderBy('numero', 'desc');
                break;
            case 'data_asc':
                $query->orderBy('data', 'asc');
                break;
            case 'data_desc':
                $query->orderBy('data', 'desc');
                break;
            case 'titulo_asc':
                $query->orderBy('titulo', 'asc');
                break;
            case 'titulo_desc':
                $query->orderBy('titulo', 'desc');
                break;
            default:
                $query->ordenacaoPadrao();
        }

        $leis = $query->paginate(15)->withQueryString();

        // Dados para filtros
        $tipos = Lei::getTipos();
        $exercicios = Lei::select('exercicio')
            ->distinct()
            ->orderBy('exercicio', 'desc')
            ->pluck('exercicio');

        // Se for uma requisição AJAX, retornar JSON
        if ($request->ajax()) {
            try {
                // Renderizar apenas a seção de resultados
                $leisGridHtml = '';
                $resultadosInfoHtml = '';
                $paginacaoHtml = '';
                
                if ($leis->count() > 0) {
                    // Grid de leis
                    $leisGridHtml = view('leis.partials.grid', compact('leis'))->render();
                    
                    // Informações dos resultados
                    $resultadosInfoHtml = view('leis.partials.info', compact('leis'))->render();
                    
                    // Paginação
                    $paginacaoHtml = $leis->links()->render();
                } else {
                    // Estado vazio
                    $leisGridHtml = view('leis.partials.empty')->render();
                }
                
                return response()->json([
                    'success' => true,
                    'html' => $leisGridHtml,
                    'info' => $resultadosInfoHtml,
                    'pagination' => $paginacaoHtml,
                    'total' => $leis->total(),
                    'current_page' => $leis->currentPage(),
                    'last_page' => $leis->lastPage()
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao carregar resultados: ' . $e->getMessage()
                ], 500);
            }
        }

        // Retornar view apropriada para requisições normais
        if ($isAdmin) {
            return view('leis.admin.index', compact('leis', 'tipos', 'exercicios'));
        } else {
            return view('leis.index', compact('leis', 'tipos', 'exercicios'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = Lei::getTipos();
        return view('leis.admin.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:255',
            'exercicio' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'data' => 'required|date',
            'tipo' => 'required|in:' . implode(',', Lei::getTipos()),
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'autoria' => 'nullable|string|max:255',
            'ementa' => 'nullable|string',
            'arquivo_pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
            'observacoes' => 'nullable|string',
        ]);

        // Upload do arquivo PDF se fornecido
        if ($request->hasFile('arquivo_pdf')) {
            $arquivo = $request->file('arquivo_pdf');
            $nomeArquivo = Str::slug($validated['numero'] . '-' . $validated['exercicio']) . '.pdf';
            $caminhoArquivo = $arquivo->storeAs('leis', $nomeArquivo, 'public');
            $validated['arquivo_pdf'] = 'storage/' . $caminhoArquivo;
        }

        Lei::create($validated);

        return redirect()->route('leis.index')
            ->with('success', 'Lei criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $lei = Lei::where('slug', $slug)->firstOrFail();
        
        // Buscar lei anterior (número menor no mesmo exercício ou exercício anterior)
        $leiAnterior = Lei::where(function($query) use ($lei) {
            $query->where('exercicio', $lei->exercicio)
                  ->where('numero', '<', $lei->numero);
        })
        ->orWhere(function($query) use ($lei) {
            $query->where('exercicio', '<', $lei->exercicio);
        })
        ->orderBy('exercicio', 'desc')
        ->orderBy('numero', 'desc')
        ->first();
        
        // Buscar lei posterior (número maior no mesmo exercício ou exercício posterior)
        $leiPosterior = Lei::where(function($query) use ($lei) {
            $query->where('exercicio', $lei->exercicio)
                  ->where('numero', '>', $lei->numero);
        })
        ->orWhere(function($query) use ($lei) {
            $query->where('exercicio', '>', $lei->exercicio);
        })
        ->orderBy('exercicio', 'asc')
        ->orderBy('numero', 'asc')
        ->first();
        
        // Buscar leis relacionadas (mesmo tipo, exercício próximo, excluindo a lei atual)
        $leisRelacionadas = Lei::where('id', '!=', $lei->id)
            ->where(function($query) use ($lei) {
                $query->where('tipo', $lei->tipo)
                      ->orWhere('exercicio', $lei->exercicio)
                      ->orWhere('titulo', 'like', '%' . substr($lei->titulo, 0, 20) . '%');
            })
            ->orderBy('exercicio', 'desc')
            ->orderBy('numero', 'desc')
            ->limit(5)
            ->get();
        
        // Calcular estatísticas
        $totalLeis = Lei::count();
        $totalTipoAtual = Lei::where('tipo', $lei->tipo)->count();
        $totalExercicioAtual = Lei::where('exercicio', $lei->exercicio)->count();
        
        return view('leis.show', compact(
            'lei', 
            'leiAnterior', 
            'leiPosterior', 
            'leisRelacionadas',
            'totalLeis',
            'totalTipoAtual',
            'totalExercicioAtual'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lei = Lei::findOrFail($id);
        $tipos = Lei::getTipos();
        return view('leis.admin.edit', compact('lei', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lei = Lei::findOrFail($id);

        $validated = $request->validate([
            'numero' => 'required|string|max:255',
            'exercicio' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'data' => 'required|date',
            'tipo' => 'required|in:' . implode(',', Lei::getTipos()),
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'autoria' => 'nullable|string|max:255',
            'ementa' => 'nullable|string',
            'arquivo_pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        // Upload do novo arquivo PDF se fornecido
        if ($request->hasFile('arquivo_pdf')) {
            // Remove arquivo antigo se existir
            if ($lei->arquivo_pdf && Storage::disk('public')->exists(str_replace('storage/', '', $lei->arquivo_pdf))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $lei->arquivo_pdf));
            }

            $arquivo = $request->file('arquivo_pdf');
            $nomeArquivo = Str::slug($validated['numero'] . '-' . $validated['exercicio']) . '.pdf';
            $caminhoArquivo = $arquivo->storeAs('leis', $nomeArquivo, 'public');
            $validated['arquivo_pdf'] = 'storage/' . $caminhoArquivo;
        }

        $lei->update($validated);

        return redirect()->route('leis.index')
            ->with('success', 'Lei atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lei = Lei::findOrFail($id);

        // Remove arquivo PDF se existir
        if ($lei->arquivo_pdf && Storage::disk('public')->exists(str_replace('storage/', '', $lei->arquivo_pdf))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $lei->arquivo_pdf));
        }

        $lei->delete();

        return redirect()->route('leis.index')
            ->with('success', 'Lei removida com sucesso!');
    }

    /**
     * Busca AJAX para o motor de busca geral
     */
    public function buscarAjax(Request $request)
    {
        $termo = $request->get('q');
        
        if (strlen($termo) < 3) {
            return response()->json([]);
        }

        $leis = Lei::ativas()
            ->buscar($termo)
            ->ordenacaoPadrao()
            ->limit(10)
            ->get(['id', 'numero', 'exercicio', 'titulo', 'tipo', 'slug']);

        $resultados = $leis->map(function ($lei) {
            return [
                'id' => $lei->id,
                'titulo' => $lei->numero_formatado,
                'subtitulo' => $lei->titulo,
                'tipo' => $lei->tipo,
                'url' => route('leis.show', $lei->slug),
                'categoria' => 'Legislação'
            ];
        });

        return response()->json($resultados);
    }

    /**
     * Download do arquivo PDF
     */
    public function downloadPdf($id)
    {
        $lei = Lei::findOrFail($id);

        if (!$lei->temArquivoPdf()) {
            abort(404, 'Arquivo PDF não encontrado.');
        }

        $caminhoCompleto = public_path($lei->arquivo_pdf);
        $nomeDownload = "Lei_{$lei->numero}_{$lei->exercicio}.pdf";

        return response()->download($caminhoCompleto, $nomeDownload);
    }

    /**
     * Display the specified resource for admin (read-only view).
     */
    public function adminShow($id)
    {
        $lei = Lei::findOrFail($id);
        
        return view('admin.leis.show', compact('lei'));
    }
}
