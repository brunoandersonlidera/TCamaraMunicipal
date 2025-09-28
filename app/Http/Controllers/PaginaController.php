<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaginaConteudo;

class PaginaController extends Controller
{
    /**
     * Exibir página dinâmica baseada no slug
     */
    public function show($slug)
    {
        $pagina = PaginaConteudo::ativo()->porSlug($slug)->first();
        
        if (!$pagina) {
            abort(404, 'Página não encontrada');
        }

        $pageTitle = $pagina->seo['title'] ?? $pagina->titulo;
        $metaDescription = $pagina->seo['description'] ?? $pagina->descricao;
        $metaKeywords = $pagina->seo['keywords'] ?? '';
        
        $breadcrumb = [
            ['title' => 'Início', 'url' => route('home')],
            ['title' => 'Sobre', 'url' => '#'],
            ['title' => $pagina->titulo, 'url' => null]
        ];

        // Determinar qual template usar
        $template = $pagina->template ?? 'default';
        $viewName = "paginas.{$template}";
        
        // Fallback para template padrão se não existir
        if (!view()->exists($viewName)) {
            $viewName = 'paginas.default';
        }

        return view($viewName, compact(
            'pagina', 
            'pageTitle', 
            'metaDescription', 
            'metaKeywords', 
            'breadcrumb'
        ));
    }

    /**
     * Exibir página de história da câmara
     * @deprecated Use show() method instead
     */
    public function historia()
    {
        return $this->show('historia');
    }

    /**
     * Exibir página de estrutura da câmara
     * @deprecated Use show() method instead
     */
    public function estrutura()
    {
        return $this->show('estrutura');
    }

    /**
     * Exibir página do regimento interno
     * @deprecated Use show() method instead
     */
    public function regimento()
    {
        return $this->show('regimento');
    }

    /**
     * Exibir página de missão, visão e valores
     * @deprecated Use show() method instead
     */
    public function missao()
    {
        return $this->show('missao');
    }

    /**
     * Exibir página de contato
     */
    public function contato()
    {
        $pageTitle = 'Fale Conosco';
        $breadcrumb = [
            ['title' => 'Início', 'url' => route('home')],
            ['title' => 'Contato', 'url' => null]
        ];

        return view('paginas.contato', compact('pageTitle', 'breadcrumb'));
    }
}