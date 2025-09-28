<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;

class NoticiaController extends Controller
{
    /**
     * Exibe a listagem de notícias publicadas
     */
    public function index(Request $request)
    {
        $query = Noticia::publicadas()->with('autor');
        
        // Filtro por categoria
        if ($request->has('categoria') && $request->categoria) {
            $query->categoria($request->categoria);
        }
        
        // Busca por termo
        if ($request->has('busca') && $request->busca) {
            $query->buscar($request->busca);
        }
        
        // Ordenação
        $ordenacao = $request->get('ordenacao', 'recentes');
        switch ($ordenacao) {
            case 'mais_lidas':
                $query->maisLidas(50);
                break;
            case 'antigas':
                $query->orderBy('data_publicacao', 'asc');
                break;
            default:
                $query->orderBy('data_publicacao', 'desc');
                break;
        }
        
        $noticias = $query->paginate(12);
        
        // Notícias em destaque para a sidebar
        $noticiasDestaque = Noticia::publicadas()
            ->destaque()
            ->recentes(5)
            ->get();
        
        // Categorias disponíveis
        $categorias = Noticia::publicadas()
            ->select('categoria')
            ->distinct()
            ->whereNotNull('categoria')
            ->pluck('categoria');
        
        return view('public.noticias.index', compact(
            'noticias', 
            'noticiasDestaque', 
            'categorias'
        ));
    }
    
    /**
     * Exibe uma notícia específica
     */
    public function show($id)
    {
        $noticia = Noticia::publicadas()
            ->with('autor')
            ->findOrFail($id);
        
        // Incrementar visualizações
        $noticia->increment('visualizacoes');
        
        // Notícias relacionadas (mesma categoria)
        $noticiasRelacionadas = Noticia::publicadas()
            ->where('id', '!=', $noticia->id)
            ->where('categoria', $noticia->categoria)
            ->recentes(4)
            ->get();
        
        // Se não houver notícias relacionadas da mesma categoria, pegar as mais recentes
        if ($noticiasRelacionadas->count() < 4) {
            $noticiasRelacionadas = Noticia::publicadas()
                ->where('id', '!=', $noticia->id)
                ->recentes(4)
                ->get();
        }
        
        return view('public.noticias.show', compact(
            'noticia', 
            'noticiasRelacionadas'
        ));
    }
}
