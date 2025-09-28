<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaginaConteudo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaginaConteudoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginas = PaginaConteudo::ordenado()->paginate(10);
        
        return view('admin.paginas-conteudo.index', compact('paginas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.paginas-conteudo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'conteudo' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:paginas_conteudo,slug',
            'ativo' => 'boolean',
            'ordem' => 'nullable|integer|min:0',
            'template' => 'nullable|string|max:100',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        // Gerar slug automaticamente se não fornecido
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['titulo']);
        }

        // Preparar dados SEO
        $seo = [];
        if (!empty($validated['seo_title'])) {
            $seo['title'] = $validated['seo_title'];
        }
        if (!empty($validated['seo_description'])) {
            $seo['description'] = $validated['seo_description'];
        }
        if (!empty($validated['seo_keywords'])) {
            $seo['keywords'] = $validated['seo_keywords'];
        }

        $data = [
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'conteudo' => $validated['conteudo'],
            'slug' => $validated['slug'],
            'ativo' => $validated['ativo'] ?? true,
            'ordem' => $validated['ordem'] ?? 0,
            'template' => $validated['template'] ?? 'default',
            'seo' => $seo,
        ];

        PaginaConteudo::create($data);

        return redirect()->route('admin.paginas-conteudo.index')
            ->with('success', 'Página criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaginaConteudo $pagina)
    {
        return view('admin.paginas-conteudo.show', compact('pagina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaginaConteudo $pagina)
    {
        return view('admin.paginas-conteudo.edit', compact('pagina'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaginaConteudo $pagina)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'conteudo' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:paginas_conteudo,slug,' . $pagina->id,
            'ativo' => 'boolean',
            'ordem' => 'nullable|integer|min:0',
            'template' => 'nullable|string|max:100',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        // Gerar slug automaticamente se não fornecido
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['titulo']);
        }

        // Preparar dados SEO
        $seo = $pagina->seo ?? [];
        if (!empty($validated['seo_title'])) {
            $seo['title'] = $validated['seo_title'];
        }
        if (!empty($validated['seo_description'])) {
            $seo['description'] = $validated['seo_description'];
        }
        if (!empty($validated['seo_keywords'])) {
            $seo['keywords'] = $validated['seo_keywords'];
        }

        $data = [
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'conteudo' => $validated['conteudo'],
            'slug' => $validated['slug'],
            'ativo' => $validated['ativo'] ?? true,
            'ordem' => $validated['ordem'] ?? 0,
            'template' => $validated['template'] ?? 'default',
            'seo' => $seo,
        ];

        $pagina->update($data);

        return redirect()->route('admin.paginas-conteudo.index')
            ->with('success', 'Página atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaginaConteudo $pagina)
    {
        $pagina->delete();

        return redirect()->route('admin.paginas-conteudo.index')
            ->with('success', 'Página removida com sucesso!');
    }

    /**
     * Ativar/desativar página
     */
    public function toggleStatus(PaginaConteudo $pagina)
    {
        $pagina->update(['ativo' => !$pagina->ativo]);

        $status = $pagina->ativo ? 'ativada' : 'desativada';
        
        return redirect()->back()
            ->with('success', "Página {$status} com sucesso!");
    }
}
