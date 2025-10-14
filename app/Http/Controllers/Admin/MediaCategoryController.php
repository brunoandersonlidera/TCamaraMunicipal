<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaCategory;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MediaCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = MediaCategory::orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->get();
            
        return view('admin.media-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.media-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:media_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Gerar slug se não for fornecido
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Definir ordem padrão se não for fornecida
        if (!isset($validated['order'])) {
            $validated['order'] = MediaCategory::max('order') + 1;
        }

        $category = MediaCategory::create($validated);

        return redirect()
            ->route('admin.media-categories.index')
            ->with('status', 'Categoria criada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MediaCategory $mediaCategory)
    {
        return view('admin.media-categories.edit', compact('mediaCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediaCategory $mediaCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('media_categories')->ignore($mediaCategory->id),
            ],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Gerar slug se não for fornecido
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $mediaCategory->update($validated);

        return redirect()
            ->route('admin.media-categories.index')
            ->with('status', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaCategory $mediaCategory)
    {
        // Verificar se existem mídias associadas a esta categoria
        $mediaCount = Media::where('category', $mediaCategory->slug)->count();
        
        if ($mediaCount > 0) {
            return redirect()
                ->route('admin.media-categories.index')
                ->with('error', "Não é possível excluir esta categoria. Existem {$mediaCount} mídias associadas a ela.");
        }
        
        $mediaCategory->delete();
        
        return redirect()
            ->route('admin.media-categories.index')
            ->with('status', 'Categoria excluída com sucesso!');
    }
    
    /**
     * Retorna a lista de categorias em formato JSON.
     */
    public function list()
    {
        $categories = MediaCategory::active()
            ->ordered()
            ->get(['id', 'slug', 'name', 'icon']);
            
        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}
