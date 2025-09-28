<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Noticia::with('autor');
        
        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('resumo', 'like', "%{$search}%")
                  ->orWhere('conteudo', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            if ($request->status === 'publicado') {
                $query->where('status', 'publicado');
            } elseif ($request->status === 'rascunho') {
                $query->where('status', 'rascunho');
            }
        }
        
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        if ($request->filled('autor')) {
            $query->where('autor_id', $request->autor);
        }
        
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_publicacao', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->whereDate('data_publicacao', '<=', $request->data_fim);
        }
        
        $noticias = $query->orderBy('data_publicacao', 'desc')->paginate(15);
        
        // Para os filtros
        $categorias = Noticia::distinct()->pluck('categoria')->filter()->sort();
        $autores = User::admins()->orderBy('name')->get();
        
        return view('admin.noticias.index', compact('noticias', 'categorias', 'autores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumo' => 'nullable|string|max:500',
            'conteudo' => 'required|string',
            'categoria' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'imagem_destaque' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeria_imagens' => 'nullable|array',
            'galeria_imagens.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'data_publicacao' => 'required|date',
            'publicado' => 'boolean',
            'destaque' => 'boolean',
            'permite_comentarios' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255'
        ]);
        
        // Gerar slug único
        $validated['slug'] = $this->generateUniqueSlug($validated['titulo']);
        
        // Definir autor
        $validated['autor_id'] = Auth::id();
        
        // Upload da imagem de destaque
        if ($request->hasFile('imagem_destaque')) {
            $validated['imagem_destaque'] = $request->file('imagem_destaque')->store('noticias', 'public');
        }
        
        // Upload das imagens da galeria
        if ($request->hasFile('galeria_imagens')) {
            $galeria = [];
            foreach ($request->file('galeria_imagens') as $imagem) {
                $galeria[] = $imagem->store('noticias/galeria', 'public');
            }
            $validated['galeria_imagens'] = $galeria;
        }
        
        // Filtrar tags vazias
        if (isset($validated['tags'])) {
            $validated['tags'] = array_filter($validated['tags']);
        }
        
        // Definir valores padrão para checkboxes
        $validated['publicado'] = $request->has('publicado');
        $validated['destaque'] = $request->has('destaque');
        $validated['permite_comentarios'] = $request->has('permite_comentarios');
        
        Noticia::create($validated);
        
        return redirect()->route('admin.noticias.index')
                        ->with('success', 'Notícia criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia)
    {
        $noticia->load('autor');
        return view('admin.noticias.show', compact('noticia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticia $noticia)
    {
        return view('admin.noticias.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Noticia $noticia)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumo' => 'nullable|string|max:500',
            'conteudo' => 'required|string',
            'categoria' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'imagem_destaque' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeria_imagens' => 'nullable|array',
            'galeria_imagens.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'data_publicacao' => 'required|date',
            'publicado' => 'boolean',
            'destaque' => 'boolean',
            'permite_comentarios' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255'
        ]);
        
        // Atualizar slug se o título mudou
        if ($validated['titulo'] !== $noticia->titulo) {
            $validated['slug'] = $this->generateUniqueSlug($validated['titulo'], $noticia->id);
        }
        
        // Upload da nova imagem de destaque
        if ($request->hasFile('imagem_destaque')) {
            // Deletar imagem antiga se existir
            if ($noticia->imagem_destaque) {
                Storage::disk('public')->delete($noticia->imagem_destaque);
            }
            $validated['imagem_destaque'] = $request->file('imagem_destaque')->store('noticias', 'public');
        }
        
        // Upload das novas imagens da galeria
        if ($request->hasFile('galeria_imagens')) {
            // Deletar imagens antigas se existirem
            if ($noticia->galeria_imagens) {
                foreach ($noticia->galeria_imagens as $imagem) {
                    Storage::disk('public')->delete($imagem);
                }
            }
            
            $galeria = [];
            foreach ($request->file('galeria_imagens') as $imagem) {
                $galeria[] = $imagem->store('noticias/galeria', 'public');
            }
            $validated['galeria_imagens'] = $galeria;
        }
        
        // Filtrar tags vazias
        if (isset($validated['tags'])) {
            $validated['tags'] = array_filter($validated['tags']);
        }
        
        // Definir valores padrão para checkboxes
        $validated['publicado'] = $request->has('publicado');
        $validated['destaque'] = $request->has('destaque');
        $validated['permite_comentarios'] = $request->has('permite_comentarios');
        
        $noticia->update($validated);
        
        return redirect()->route('admin.noticias.index')
                        ->with('success', 'Notícia atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        // Deletar imagem de destaque se existir
        if ($noticia->imagem_destaque) {
            Storage::disk('public')->delete($noticia->imagem_destaque);
        }
        
        // Deletar imagens da galeria se existirem
        if ($noticia->galeria_imagens) {
            foreach ($noticia->galeria_imagens as $imagem) {
                Storage::disk('public')->delete($imagem);
            }
        }
        
        $noticia->delete();
        
        return redirect()->route('admin.noticias.index')
                        ->with('success', 'Notícia removida com sucesso!');
    }
    
    /**
     * Toggle status de publicação da notícia
     */
    public function togglePublicacao(Noticia $noticia)
    {
        $noticia->update([
            'publicado' => !$noticia->publicado
        ]);
        
        $status = $noticia->publicado ? 'publicada' : 'despublicada';
        
        return redirect()->back()
                        ->with('success', "Notícia {$status} com sucesso!");
    }
    
    /**
     * Toggle destaque da notícia
     */
    public function toggleDestaque(Noticia $noticia)
    {
        $noticia->update([
            'destaque' => !$noticia->destaque
        ]);
        
        $status = $noticia->destaque ? 'marcada como destaque' : 'removida do destaque';
        
        return redirect()->back()
                        ->with('success', "Notícia {$status} com sucesso!");
    }
    
    /**
     * Gerar slug único
     */
    private function generateUniqueSlug($titulo, $excludeId = null)
    {
        $slug = Str::slug($titulo);
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            $query = Noticia::where('slug', $slug);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}