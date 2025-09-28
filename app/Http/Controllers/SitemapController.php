<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Noticia;
use App\Models\Vereador;
use App\Models\ProjetoLei;
use App\Models\Documento;
use App\Models\Sessao;
use App\Models\PaginaConteudo;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Página inicial
        $sitemap .= $this->addUrl(url('/'), Carbon::now(), 'daily', '1.0');

        // Páginas estáticas principais
        $staticPages = [
            '/' => ['daily', '1.0'],
            '/vereadores' => ['weekly', '0.9'],
            '/transparencia' => ['daily', '0.9'],
            '/transparencia/licitacoes' => ['daily', '0.8'],
            '/transparencia/contratos' => ['daily', '0.8'],
            '/transparencia/receitas' => ['monthly', '0.7'],
            '/transparencia/despesas' => ['monthly', '0.7'],
            '/transparencia/folha-pagamento' => ['monthly', '0.7'],
            '/ouvidoria' => ['weekly', '0.8'],
            '/esic' => ['weekly', '0.8'],
            '/noticias' => ['daily', '0.9'],
            '/projetos-lei' => ['weekly', '0.8'],
            '/documentos' => ['weekly', '0.8'],
            '/sessoes' => ['weekly', '0.8'],
            '/cartas-servico' => ['monthly', '0.7'],
            '/tv-camara' => ['weekly', '0.6'],
            '/ao-vivo' => ['weekly', '0.6'],
        ];

        foreach ($staticPages as $url => $config) {
            $sitemap .= $this->addUrl(url($url), Carbon::now(), $config[0], $config[1]);
        }

        // Notícias publicadas
        $noticias = Noticia::where('status', 'publicado')
            ->where('data_publicacao', '<=', now())
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($noticias as $noticia) {
            $sitemap .= $this->addUrl(
                url("/noticias/{$noticia->slug}"),
                $noticia->updated_at,
                'weekly',
                '0.8'
            );
        }

        // Vereadores ativos
        $vereadores = Vereador::where('status', 'ativo')->get();
        foreach ($vereadores as $vereador) {
            $sitemap .= $this->addUrl(
                url("/vereadores/{$vereador->slug}"),
                $vereador->updated_at,
                'monthly',
                '0.7'
            );
        }

        // Projetos de Lei
        $projetos = ProjetoLei::where('status', '!=', 'rascunho')->get();
        foreach ($projetos as $projeto) {
            $sitemap .= $this->addUrl(
                url("/projetos-lei/{$projeto->numero}/{$projeto->ano}"),
                $projeto->updated_at,
                'weekly',
                '0.7'
            );
        }

        // Sessões
        $sessoes = Sessao::where('status', 'realizada')->get();
        foreach ($sessoes as $sessao) {
            $sitemap .= $this->addUrl(
                url("/sessoes/{$sessao->id}"),
                $sessao->updated_at,
                'monthly',
                '0.6'
            );
        }

        // Páginas de conteúdo dinâmico
        $paginas = PaginaConteudo::where('ativo', true)
            ->get();

        foreach ($paginas as $pagina) {
            $sitemap .= $this->addUrl(
                url("/pagina/{$pagina->slug}"),
                $pagina->updated_at,
                'monthly',
                '0.6'
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600', // Cache por 1 hora
        ]);
    }

    private function addUrl($url, $lastmod, $changefreq, $priority)
    {
        $xml = "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
        $xml .= "    <lastmod>" . $lastmod->format('Y-m-d\TH:i:s+00:00') . "</lastmod>\n";
        $xml .= "    <changefreq>{$changefreq}</changefreq>\n";
        $xml .= "    <priority>{$priority}</priority>\n";
        $xml .= "  </url>\n";
        
        return $xml;
    }
}