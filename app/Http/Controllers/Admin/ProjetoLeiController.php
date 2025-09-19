<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjetoLei;
use App\Models\Vereador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjetoLeiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProjetoLei::with(['autor', 'vereadores']);

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('numero', 'like', "%{$busca}%")
                  ->orWhere('titulo', 'like', "%{$busca}%")
                  ->orWhere('ementa', 'like', "%{$busca}%")
                  ->orWhereHas('autor', function ($q) use ($busca) {
                      $q->where('nome', 'like', "%{$busca}%");
                  });
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ano')) {
            $query->whereYear('data_protocolo', $request->ano);
        }

        if ($request->filled('autor_id')) {
            $query->where('autor_id', $request->autor_id);
        }

        // Ordenação
        $query->orderBy('numero', 'desc');

        $projetos = $query->paginate(15)->withQueryString();
        $vereadores = Vereador::where('status', 'ativo')->orderBy('nome')->get();
        $anos = ProjetoLei::selectRaw('YEAR(data_protocolo) as ano')
                          ->distinct()
                          ->orderBy('ano', 'desc')
                          ->pluck('ano');

        return view('admin.projetos-lei.index', compact('projetos', 'vereadores', 'anos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vereadores = Vereador::where('status', 'ativo')->orderBy('nome')->get();
        $proximoNumero = $this->getProximoNumero();
        
        return view('admin.projetos-lei.create', compact('vereadores', 'proximoNumero'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:20|unique:projetos_lei,numero',
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tipo' => 'required|in:projeto_lei,projeto_lei_complementar,projeto_resolucao,projeto_decreto_legislativo,indicacao,mocao,requerimento',
            'titulo' => 'required|string|max:500',
            'ementa' => 'required|string',
            'justificativa' => 'nullable|string',
            'texto_integral' => 'nullable|string',
            'autor_id' => 'required|exists:vereadores,id',
            'coautores' => 'nullable|array',
            'coautores.*' => 'exists:vereadores,id',
            'data_protocolo' => 'required|date',
            'data_publicacao' => 'nullable|date',
            'data_aprovacao' => 'nullable|date',
            'status' => 'required|in:tramitando,aprovado,rejeitado,retirado,arquivado',
            'urgente' => 'boolean',
            'arquivo_projeto' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'arquivo_lei' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'observacoes' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        // Upload de arquivos
        if ($request->hasFile('arquivo_projeto')) {
            $validated['arquivo_projeto'] = $request->file('arquivo_projeto')->store('projetos-lei/projetos', 'public');
        }

        if ($request->hasFile('arquivo_lei')) {
            $validated['arquivo_lei'] = $request->file('arquivo_lei')->store('projetos-lei/leis', 'public');
        }

        // Processar tags
        if ($request->filled('tags')) {
            $validated['tags'] = collect(explode(',', $request->tags))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique()
                ->implode(',');
        }

        $projeto = ProjetoLei::create($validated);

        // Sincronizar coautores
        if ($request->filled('coautores')) {
            $projeto->vereadores()->sync($request->coautores);
        }

        return redirect()->route('admin.projetos-lei.index')
                        ->with('success', 'Projeto de lei criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjetoLei $projetoLei)
    {
        $projetoLei->load(['autor', 'vereadores']);
        
        return view('admin.projetos-lei.show', compact('projetoLei'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjetoLei $projetoLei)
    {
        $projetoLei->load(['autor', 'vereadores']);
        $vereadores = Vereador::where('status', 'ativo')->orderBy('nome')->get();
        
        return view('admin.projetos-lei.edit', compact('projetoLei', 'vereadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjetoLei $projetoLei)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:20|unique:projetos_lei,numero,' . $projetoLei->id,
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tipo' => 'required|in:projeto_lei,projeto_lei_complementar,projeto_resolucao,projeto_decreto_legislativo,indicacao,mocao,requerimento',
            'titulo' => 'required|string|max:500',
            'ementa' => 'required|string',
            'justificativa' => 'nullable|string',
            'texto_integral' => 'nullable|string',
            'autor_id' => 'required|exists:vereadores,id',
            'coautores' => 'nullable|array',
            'coautores.*' => 'exists:vereadores,id',
            'data_protocolo' => 'required|date',
            'data_publicacao' => 'nullable|date',
            'data_aprovacao' => 'nullable|date',
            'status' => 'required|in:tramitando,aprovado,rejeitado,retirado,arquivado',
            'urgente' => 'boolean',
            'arquivo_projeto' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'arquivo_lei' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'observacoes' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        // Upload de arquivos
        if ($request->hasFile('arquivo_projeto')) {
            // Deletar arquivo anterior
            if ($projetoLei->arquivo_projeto) {
                Storage::disk('public')->delete($projetoLei->arquivo_projeto);
            }
            $validated['arquivo_projeto'] = $request->file('arquivo_projeto')->store('projetos-lei/projetos', 'public');
        }

        if ($request->hasFile('arquivo_lei')) {
            // Deletar arquivo anterior
            if ($projetoLei->arquivo_lei) {
                Storage::disk('public')->delete($projetoLei->arquivo_lei);
            }
            $validated['arquivo_lei'] = $request->file('arquivo_lei')->store('projetos-lei/leis', 'public');
        }

        // Processar tags
        if ($request->filled('tags')) {
            $validated['tags'] = collect(explode(',', $request->tags))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique()
                ->implode(',');
        } else {
            $validated['tags'] = null;
        }

        $projetoLei->update($validated);

        // Sincronizar coautores
        if ($request->filled('coautores')) {
            $projetoLei->vereadores()->sync($request->coautores);
        } else {
            $projetoLei->vereadores()->detach();
        }

        return redirect()->route('admin.projetos-lei.show', $projetoLei)
                        ->with('success', 'Projeto de lei atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjetoLei $projetoLei)
    {
        // Deletar arquivos associados
        if ($projetoLei->arquivo_projeto) {
            Storage::disk('public')->delete($projetoLei->arquivo_projeto);
        }
        
        if ($projetoLei->arquivo_lei) {
            Storage::disk('public')->delete($projetoLei->arquivo_lei);
        }

        // Remover relacionamentos
        $projetoLei->vereadores()->detach();

        $projetoLei->delete();

        return redirect()->route('admin.projetos-lei.index')
                        ->with('success', 'Projeto de lei excluído com sucesso!');
    }

    /**
     * Toggle status do projeto
     */
    public function toggleStatus(Request $request, ProjetoLei $projetoLei)
    {
        $request->validate([
            'status' => 'required|in:tramitando,aprovado,rejeitado,retirado,arquivado'
        ]);

        $projetoLei->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'status' => $projetoLei->status
        ]);
    }

    /**
     * Download de arquivos
     */
    public function download(ProjetoLei $projetoLei, $tipo)
    {
        $arquivo = null;
        
        switch ($tipo) {
            case 'projeto':
                $arquivo = $projetoLei->arquivo_projeto;
                break;
            case 'lei':
                $arquivo = $projetoLei->arquivo_lei;
                break;
            default:
                abort(404);
        }

        if (!$arquivo || !Storage::disk('public')->exists($arquivo)) {
            abort(404, 'Arquivo não encontrado');
        }

        return Storage::disk('public')->download($arquivo);
    }

    /**
     * Gerar próximo número do projeto
     */
    private function getProximoNumero()
    {
        $ano = date('Y');
        $ultimoNumero = ProjetoLei::whereYear('data_protocolo', $ano)
                                  ->max('numero');
        
        if (!$ultimoNumero) {
            return "001/{$ano}";
        }

        // Extrair número da string (formato: 001/2024)
        $numero = (int) explode('/', $ultimoNumero)[0];
        $proximoNumero = str_pad($numero + 1, 3, '0', STR_PAD_LEFT);
        
        return "{$proximoNumero}/{$ano}";
    }
}