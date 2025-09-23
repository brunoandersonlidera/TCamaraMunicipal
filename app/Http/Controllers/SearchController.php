<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\Vereador;
use App\Models\ProjetoLei;
use App\Models\Documento;
use App\Models\Sessao;
use App\Models\Licitacao;
use App\Models\Receita;
use App\Models\Despesa;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Busca geral em todos os conteúdos
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', 'all');
        
        if (empty($query)) {
            return view('public.search.results', [
                'query' => $query,
                'category' => $category,
                'results' => collect(),
                'total' => 0
            ]);
        }

        $results = collect();

        switch ($category) {
            case 'noticias':
                $results = $this->searchNoticias($query);
                break;
            case 'vereadores':
                $results = $this->searchVereadores($query);
                break;
            case 'projetos':
                $results = $this->searchProjetos($query);
                break;
            case 'documentos':
                $results = $this->searchDocumentos($query);
                break;
            case 'sessoes':
                $results = $this->searchSessoes($query);
                break;
            case 'transparencia':
                $results = $this->searchTransparencia($query);
                break;
            default:
                $results = $this->searchAll($query);
                break;
        }

        return view('public.search.results', [
            'query' => $query,
            'category' => $category,
            'results' => $results,
            'total' => $results->count()
        ]);
    }

    /**
     * Busca em todas as categorias
     */
    private function searchAll($query)
    {
        $results = collect();

        // Buscar notícias
        $noticias = $this->searchNoticias($query)->take(5);
        $results = $results->merge($noticias);

        // Buscar vereadores
        $vereadores = $this->searchVereadores($query)->take(5);
        $results = $results->merge($vereadores);

        // Buscar projetos de lei
        $projetos = $this->searchProjetos($query)->take(5);
        $results = $results->merge($projetos);

        // Buscar documentos
        $documentos = $this->searchDocumentos($query)->take(5);
        $results = $results->merge($documentos);

        // Buscar sessões
        $sessoes = $this->searchSessoes($query)->take(5);
        $results = $results->merge($sessoes);

        return $results->sortByDesc('relevance');
    }

    /**
     * Busca em notícias
     */
    private function searchNoticias($query)
    {
        return Noticia::where('status', 'publicada')
            ->where(function($q) use ($query) {
                $q->where('titulo', 'LIKE', "%{$query}%")
                  ->orWhere('conteudo', 'LIKE', "%{$query}%")
                  ->orWhere('resumo', 'LIKE', "%{$query}%");
            })
            ->orderBy('data_publicacao', 'desc')
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'noticia',
                    'title' => $item->titulo,
                    'content' => $this->highlightText($item->resumo ?? substr(strip_tags($item->conteudo), 0, 200), $query),
                    'url' => route('noticias.show', $item->id),
                    'date' => $item->data_publicacao,
                    'relevance' => $this->calculateRelevance($item->titulo . ' ' . $item->conteudo, $query),
                    'category' => 'Notícias'
                ];
            });
    }

    /**
     * Busca em vereadores
     */
    private function searchVereadores($query)
    {
        return Vereador::where('status', 'ativo')
            ->where(function($q) use ($query) {
                $q->where('nome', 'LIKE', "%{$query}%")
                  ->orWhere('partido', 'LIKE', "%{$query}%")
                  ->orWhere('biografia', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'vereador',
                    'title' => $item->nome,
                    'content' => $this->highlightText($item->partido . ' - ' . substr($item->biografia ?? '', 0, 150), $query),
                    'url' => route('vereadores.show', $item->id),
                    'date' => $item->created_at,
                    'relevance' => $this->calculateRelevance($item->nome . ' ' . $item->partido, $query),
                    'category' => 'Vereadores'
                ];
            });
    }

    /**
     * Busca em projetos de lei
     */
    private function searchProjetos($query)
    {
        return ProjetoLei::where(function($q) use ($query) {
                $q->where('titulo', 'LIKE', "%{$query}%")
                  ->orWhere('ementa', 'LIKE', "%{$query}%")
                  ->orWhere('numero', 'LIKE', "%{$query}%");
            })
            ->orderBy('data_protocolo', 'desc')
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'projeto',
                    'title' => "Projeto de Lei nº {$item->numero}/{$item->ano} - {$item->titulo}",
                    'content' => $this->highlightText($item->ementa ?? '', $query),
                    'url' => route('projetos.show', $item->id),
                    'date' => $item->data_protocolo,
                    'relevance' => $this->calculateRelevance($item->titulo . ' ' . $item->ementa, $query),
                    'category' => 'Projetos de Lei'
                ];
            });
    }

    /**
     * Busca em documentos
     */
    private function searchDocumentos($query)
    {
        return Documento::where(function($q) use ($query) {
                $q->where('titulo', 'LIKE', "%{$query}%")
                  ->orWhere('descricao', 'LIKE', "%{$query}%")
                  ->orWhere('categoria', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'documento',
                    'title' => $item->titulo,
                    'content' => $this->highlightText($item->descricao ?? '', $query),
                    'url' => route('documentos.show', $item->id),
                    'date' => $item->created_at,
                    'relevance' => $this->calculateRelevance($item->titulo . ' ' . $item->descricao, $query),
                    'category' => 'Documentos'
                ];
            });
    }

    /**
     * Busca em sessões
     */
    private function searchSessoes($query)
    {
        return Sessao::with('tipo')
            ->where(function($q) use ($query) {
                $q->where('numero_sessao', 'LIKE', "%{$query}%")
                  ->orWhere('pauta', 'LIKE', "%{$query}%")
                  ->orWhere('ata', 'LIKE', "%{$query}%")
                  ->orWhere('tipo', 'LIKE', "%{$query}%");
            })
            ->orderBy('data_sessao', 'desc')
            ->get()
            ->map(function($item) use ($query) {
                $titulo_sessao = "Sessão {$item->tipo} nº {$item->numero_sessao}";
                return [
                    'type' => 'sessao',
                    'title' => $titulo_sessao,
                    'content' => $this->highlightText(substr(strip_tags($item->pauta ?? ''), 0, 200), $query),
                    'url' => route('sessoes.show', $item->id),
                    'date' => $item->data_sessao,
                    'relevance' => $this->calculateRelevance($titulo_sessao . ' ' . $item->pauta, $query),
                    'category' => 'Sessões'
                ];
            });
    }

    /**
     * Busca em transparência (receitas, despesas, licitações)
     */
    private function searchTransparencia($query)
    {
        $results = collect();

        // Buscar receitas
        $receitas = Receita::where(function($q) use ($query) {
                $q->where('descricao', 'LIKE', "%{$query}%")
                  ->orWhere('origem', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'receita',
                    'title' => "Receita: {$item->descricao}",
                    'content' => $this->highlightText("Origem: {$item->origem} - Valor: R$ " . number_format($item->valor, 2, ',', '.'), $query),
                    'url' => route('transparencia.receitas'),
                    'date' => $item->data_receita,
                    'relevance' => $this->calculateRelevance($item->descricao . ' ' . $item->origem, $query),
                    'category' => 'Receitas'
                ];
            });

        // Buscar despesas
        $despesas = Despesa::where(function($q) use ($query) {
                $q->where('descricao', 'LIKE', "%{$query}%")
                  ->orWhere('fornecedor', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'despesa',
                    'title' => "Despesa: {$item->descricao}",
                    'content' => $this->highlightText("Fornecedor: {$item->fornecedor} - Valor: R$ " . number_format($item->valor, 2, ',', '.'), $query),
                    'url' => route('transparencia.despesas'),
                    'date' => $item->data_pagamento,
                    'relevance' => $this->calculateRelevance($item->descricao . ' ' . $item->fornecedor, $query),
                    'category' => 'Despesas'
                ];
            });

        // Buscar licitações
        $licitacoes = Licitacao::where(function($q) use ($query) {
                $q->where('objeto', 'LIKE', "%{$query}%")
                  ->orWhere('numero', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'licitacao',
                    'title' => "Licitação nº {$item->numero}/{$item->ano}",
                    'content' => $this->highlightText($item->objeto, $query),
                    'url' => route('transparencia.licitacoes'),
                    'date' => $item->data_abertura,
                    'relevance' => $this->calculateRelevance($item->objeto . ' ' . $item->numero, $query),
                    'category' => 'Licitações'
                ];
            });

        return $results->merge($receitas)->merge($despesas)->merge($licitacoes);
    }

    /**
     * Destaca o texto da busca
     */
    private function highlightText($text, $query)
    {
        if (empty($query) || empty($text)) {
            return $text;
        }

        return preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $text);
    }

    /**
     * Calcula relevância do resultado
     */
    private function calculateRelevance($text, $query)
    {
        $text = strtolower($text);
        $query = strtolower($query);
        
        $relevance = 0;
        
        // Pontuação por ocorrências exatas
        $relevance += substr_count($text, $query) * 10;
        
        // Pontuação por palavras individuais
        $words = explode(' ', $query);
        foreach ($words as $word) {
            $relevance += substr_count($text, $word) * 5;
        }
        
        return $relevance;
    }

    /**
     * API de busca para AJAX
     */
    public function api(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', 'all');
        $limit = $request->get('limit', 10);
        
        if (empty($query)) {
            return response()->json([
                'results' => [],
                'total' => 0
            ]);
        }

        $results = collect();

        switch ($category) {
            case 'noticias':
                $results = $this->searchNoticias($query);
                break;
            case 'vereadores':
                $results = $this->searchVereadores($query);
                break;
            case 'projetos':
                $results = $this->searchProjetos($query);
                break;
            case 'documentos':
                $results = $this->searchDocumentos($query);
                break;
            case 'sessoes':
                $results = $this->searchSessoes($query);
                break;
            case 'transparencia':
                $results = $this->searchTransparencia($query);
                break;
            default:
                $results = $this->searchAll($query);
                break;
        }

        return response()->json([
            'results' => $results->take($limit)->values(),
            'total' => $results->count()
        ]);
    }
}
