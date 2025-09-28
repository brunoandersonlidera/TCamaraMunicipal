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
use App\Models\Contrato;
use App\Models\PaginaConteudo;
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
            case 'paginas':
                $results = $this->searchPaginas($query);
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

        // Buscar palavras-chave (seções do sistema) - prioridade máxima
        $keywords = $this->searchKeywords($query);
        $results = $results->merge($keywords);

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

        // Buscar contratos
        $contratos = $this->searchContratos($query)->take(5);
        $results = $results->merge($contratos);

        // Buscar páginas institucionais
        $paginas = $this->searchPaginas($query)->take(5);
        $results = $results->merge($paginas);

        return $results->sortByDesc('relevance');
    }

    /**
     * Busca em notícias
     */
    private function searchNoticias($query)
    {
        return Noticia::where('status', 'publicado')
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

        // Buscar contratos
        $contratos = $this->searchContratos($query);

        return $results->merge($receitas)->merge($despesas)->merge($licitacoes)->merge($contratos);
    }

    /**
     * Busca em contratos
     */
    private function searchContratos($query)
    {
        return Contrato::publicos()
            ->where(function($q) use ($query) {
                $q->where('numero', 'LIKE', "%{$query}%")
                  ->orWhere('objeto', 'LIKE', "%{$query}%")
                  ->orWhere('contratado', 'LIKE', "%{$query}%")
                  ->orWhere('cnpj_cpf_contratado', 'LIKE', "%{$query}%")
                  ->orWhere('observacoes', 'LIKE', "%{$query}%")
                  ->orWhere('observacoes_transparencia', 'LIKE', "%{$query}%")
                  ->orWhere('processo', 'LIKE', "%{$query}%")
                  ->orWhereHas('tipoContrato', function($q) use ($query) {
                      $q->where('nome', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('aditivos', function($q) use ($query) {
                      $q->where('numero', 'LIKE', "%{$query}%")
                        ->orWhere('objeto', 'LIKE', "%{$query}%")
                        ->orWhere('tipo', 'LIKE', "%{$query}%")
                        ->orWhere('justificativa', 'LIKE', "%{$query}%")
                        ->orWhere('observacoes', 'LIKE', "%{$query}%");
                  });
            })
            ->get()
            ->map(function($item) use ($query) {
                return [
                    'type' => 'contrato',
                    'title' => "Contrato nº {$item->numero}",
                    'content' => $this->highlightText("Contratado: {$item->contratado} - Objeto: {$item->objeto}", $query),
                    'url' => route('transparencia.contratos.show', $item->id),
                    'date' => $item->data_assinatura,
                    'relevance' => $this->calculateRelevance($item->numero . ' ' . $item->objeto . ' ' . $item->contratado, $query),
                    'category' => 'Contratos'
                ];
            });
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
     * Busca em páginas institucionais
     */
    private function searchPaginas($query)
    {
        $paginas = PaginaConteudo::ativo()
            ->where(function($q) use ($query) {
                $q->where('titulo', 'LIKE', "%{$query}%")
                  ->orWhere('descricao', 'LIKE', "%{$query}%")
                  ->orWhere('conteudo', 'LIKE', "%{$query}%")
                  ->orWhere('slug', 'LIKE', "%{$query}%");
            })
            ->get();

        return $paginas->map(function($pagina) use ($query) {
            // Determina qual campo teve o match para destacar
            $content = '';
            $highlightField = '';
            
            if (stripos($pagina->titulo, $query) !== false) {
                $content = $this->highlightText($pagina->titulo, $query);
                $highlightField = 'titulo';
            } elseif (stripos($pagina->descricao, $query) !== false) {
                $content = $this->highlightText($pagina->descricao, $query);
                $highlightField = 'descricao';
            } elseif (stripos($pagina->conteudo, $query) !== false) {
                // Para conteúdo, mostra um trecho relevante
                $content = $this->highlightText(strip_tags(substr($pagina->conteudo, 0, 200)), $query) . '...';
                $highlightField = 'conteudo';
            } else {
                $content = $pagina->descricao ?: strip_tags(substr($pagina->conteudo, 0, 150)) . '...';
            }

            // Calcula relevância
            $relevance = $this->calculateRelevance(
                $pagina->titulo . ' ' . $pagina->descricao . ' ' . $pagina->conteudo, 
                $query
            );

            return [
                'type' => 'pagina',
                'title' => $pagina->titulo,
                'content' => $content,
                'url' => route('paginas.show', $pagina->slug),
                'date' => $pagina->updated_at,
                'relevance' => $relevance,
                'category' => 'Páginas Institucionais',
                'highlight_field' => $highlightField
            ];
        });
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
            case 'keywords':
                $results = $this->searchKeywords($query);
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

    /**
     * Busca por palavras-chave que direcionam para seções específicas
     */
    private function searchKeywords($query)
    {
        $keywords = [
            // Transparência
            'transparencia' => [
                'url' => '/transparencia',
                'title' => 'Portal da Transparência',
                'description' => 'Acesse informações sobre receitas, despesas, licitações, contratos e folha de pagamento da Câmara Municipal.'
            ],
            'licitacoes' => [
                'url' => '/transparencia/licitacoes',
                'title' => 'Licitações',
                'description' => 'Consulte todas as licitações da Câmara Municipal, incluindo editais, documentos e resultados.'
            ],
            'licitacao' => [
                'url' => '/transparencia/licitacoes',
                'title' => 'Licitações',
                'description' => 'Consulte todas as licitações da Câmara Municipal, incluindo editais, documentos e resultados.'
            ],
            'contratos' => [
                'url' => '/transparencia/contratos',
                'title' => 'Contratos',
                'description' => 'Visualize todos os contratos firmados pela Câmara Municipal, incluindo aditivos e fiscalizações.'
            ],
            'contrato' => [
                'url' => '/transparencia/contratos',
                'title' => 'Contratos',
                'description' => 'Visualize todos os contratos firmados pela Câmara Municipal, incluindo aditivos e fiscalizações.'
            ],
            'receitas' => [
                'url' => '/transparencia/receitas',
                'title' => 'Receitas',
                'description' => 'Consulte as receitas da Câmara Municipal organizadas por categoria e período.'
            ],
            'receita' => [
                'url' => '/transparencia/receitas',
                'title' => 'Receitas',
                'description' => 'Consulte as receitas da Câmara Municipal organizadas por categoria e período.'
            ],
            'despesas' => [
                'url' => '/transparencia/despesas',
                'title' => 'Despesas',
                'description' => 'Acompanhe as despesas da Câmara Municipal detalhadas por categoria e fornecedor.'
            ],
            'despesa' => [
                'url' => '/transparencia/despesas',
                'title' => 'Despesas',
                'description' => 'Acompanhe as despesas da Câmara Municipal detalhadas por categoria e fornecedor.'
            ],
            'folha' => [
                'url' => '/transparencia/folha-pagamento',
                'title' => 'Folha de Pagamento',
                'description' => 'Consulte a folha de pagamento dos servidores da Câmara Municipal.'
            ],
            'folha-pagamento' => [
                'url' => '/transparencia/folha-pagamento',
                'title' => 'Folha de Pagamento',
                'description' => 'Consulte a folha de pagamento dos servidores da Câmara Municipal.'
            ],
            'salarios' => [
                'url' => '/transparencia/folha-pagamento',
                'title' => 'Folha de Pagamento',
                'description' => 'Consulte a folha de pagamento dos servidores da Câmara Municipal.'
            ],
            'financeiro' => [
                'url' => '/transparencia/financeiro',
                'title' => 'Relatórios Financeiros',
                'description' => 'Acesse relatórios financeiros detalhados da Câmara Municipal.'
            ],

            // Vereadores
            'vereadores' => [
                'url' => '/vereadores',
                'title' => 'Vereadores',
                'description' => 'Conheça os vereadores da Câmara Municipal, suas biografias e proposições.'
            ],
            'vereador' => [
                'url' => '/vereadores',
                'title' => 'Vereadores',
                'description' => 'Conheça os vereadores da Câmara Municipal, suas biografias e proposições.'
            ],
            'parlamentares' => [
                'url' => '/vereadores',
                'title' => 'Vereadores',
                'description' => 'Conheça os vereadores da Câmara Municipal, suas biografias e proposições.'
            ],

            // Sessões
            'sessoes' => [
                'url' => '/sessoes',
                'title' => 'Sessões',
                'description' => 'Acompanhe as sessões da Câmara Municipal, incluindo pautas, atas e transmissões.'
            ],
            'sessao' => [
                'url' => '/sessoes',
                'title' => 'Sessões',
                'description' => 'Acompanhe as sessões da Câmara Municipal, incluindo pautas, atas e transmissões.'
            ],
            'plenarias' => [
                'url' => '/sessoes',
                'title' => 'Sessões',
                'description' => 'Acompanhe as sessões da Câmara Municipal, incluindo pautas, atas e transmissões.'
            ],
            'plenaria' => [
                'url' => '/sessoes',
                'title' => 'Sessões',
                'description' => 'Acompanhe as sessões da Câmara Municipal, incluindo pautas, atas e transmissões.'
            ],
            'calendario' => [
                'url' => '/sessoes/calendario',
                'title' => 'Calendário de Sessões',
                'description' => 'Consulte o calendário com todas as sessões programadas da Câmara Municipal.'
            ],
            'ao-vivo' => [
                'url' => '/ao-vivo',
                'title' => 'Transmissão ao Vivo',
                'description' => 'Assista às sessões da Câmara Municipal em tempo real.'
            ],
            'transmissao' => [
                'url' => '/ao-vivo',
                'title' => 'Transmissão ao Vivo',
                'description' => 'Assista às sessões da Câmara Municipal em tempo real.'
            ],
            'tv-camara' => [
                'url' => '/tv-camara',
                'title' => 'TV Câmara',
                'description' => 'Acesse o canal de televisão da Câmara Municipal.'
            ],

            // Ouvidoria e ESIC
            'ouvidoria' => [
                'url' => '/ouvidoria',
                'title' => 'Ouvidoria',
                'description' => 'Entre em contato com a Ouvidoria da Câmara Municipal para manifestações e sugestões.'
            ],
            'esic' => [
                'url' => '/esic',
                'title' => 'ESIC - Sistema de Informações ao Cidadão',
                'description' => 'Solicite informações públicas através do Sistema Eletrônico de Informações ao Cidadão.'
            ],
            'lai' => [
                'url' => '/esic',
                'title' => 'Lei de Acesso à Informação',
                'description' => 'Solicite informações públicas através do Sistema Eletrônico de Informações ao Cidadão.'
            ],

            // Páginas institucionais
            'historia' => [
                'url' => '/sobre/historia',
                'title' => 'História da Câmara',
                'description' => 'Conheça a história e trajetória da Câmara Municipal.'
            ],
            'estrutura' => [
                'url' => '/sobre/estrutura',
                'title' => 'Estrutura Organizacional',
                'description' => 'Veja a estrutura organizacional da Câmara Municipal.'
            ],
            'regimento' => [
                'url' => '/sobre/regimento',
                'title' => 'Regimento Interno',
                'description' => 'Consulte o regimento interno da Câmara Municipal.'
            ],
            'missao' => [
                'url' => '/sobre/missao',
                'title' => 'Missão e Valores',
                'description' => 'Conheça a missão, visão e valores da Câmara Municipal.'
            ],
            'contato' => [
                'url' => '/contato',
                'title' => 'Contato',
                'description' => 'Entre em contato com a Câmara Municipal.'
            ],

            // Cartas de Serviço
            'cartas-servico' => [
                'url' => '/cartas-servico',
                'title' => 'Cartas de Serviço',
                'description' => 'Consulte as cartas de serviço oferecidos pela Câmara Municipal.'
            ],
            'servicos' => [
                'url' => '/cartas-servico',
                'title' => 'Serviços',
                'description' => 'Consulte os serviços oferecidos pela Câmara Municipal.'
            ]
        ];

        $query = strtolower(trim($query));
        $results = collect();

        foreach ($keywords as $keyword => $data) {
            // Busca exata
            if ($keyword === $query) {
                $results->push([
                    'type' => 'keyword',
                    'title' => $data['title'],
                    'content' => $data['description'],
                    'url' => url($data['url']),
                    'date' => now(),
                    'relevance' => 100,
                    'category' => 'Seção do Sistema',
                    'highlight_field' => 'title'
                ]);
            }
            // Busca parcial
            elseif (str_contains($keyword, $query) || str_contains($query, $keyword)) {
                $relevance = 50;
                if (str_starts_with($keyword, $query)) {
                    $relevance = 80;
                }
                
                $results->push([
                    'type' => 'keyword',
                    'title' => $data['title'],
                    'content' => $data['description'],
                    'url' => url($data['url']),
                    'date' => now(),
                    'relevance' => $relevance,
                    'category' => 'Seção do Sistema',
                    'highlight_field' => 'title'
                ]);
            }
        }

        return $results->sortByDesc('relevance');
    }
}
