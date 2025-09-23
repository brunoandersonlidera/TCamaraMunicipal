<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desabilitar verificações de chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Limpar menus existentes
        Menu::truncate();
        
        // Reabilitar verificações de chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Menus do Header Principal
        $this->createHeaderMenus();

        // Menus do Footer
        $this->createFooterMenus();
    }

    private function createHeaderMenus()
    {
        // 1. Início
        Menu::create([
            'titulo' => 'Início',
            'slug' => 'inicio',
            'tipo' => 'link',
            'url' => '/',
            'icone' => 'fas fa-home',
            'posicao' => 'header',
            'ordem' => 1,
            'ativo' => true,
        ]);

        // 2. Sobre (Dropdown)
        $menuSobre = Menu::create([
            'titulo' => 'Sobre',
            'slug' => 'sobre',
            'tipo' => 'dropdown',
            'icone' => 'fas fa-info-circle',
            'posicao' => 'header',
            'ordem' => 2,
            'ativo' => true,
        ]);

        // Submenus do "Sobre"
        Menu::create([
            'titulo' => 'História',
            'slug' => 'historia',
            'tipo' => 'link',
            'url' => '/sobre/historia',
            'icone' => 'fas fa-book',
            'posicao' => 'header',
            'parent_id' => $menuSobre->id,
            'ordem' => 1,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Estrutura',
            'slug' => 'estrutura',
            'tipo' => 'link',
            'url' => '/sobre/estrutura',
            'icone' => 'fas fa-building',
            'posicao' => 'header',
            'parent_id' => $menuSobre->id,
            'ordem' => 2,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Regimento Interno',
            'slug' => 'regimento-interno',
            'tipo' => 'link',
            'url' => '/sobre/regimento',
            'icone' => 'fas fa-gavel',
            'posicao' => 'header',
            'parent_id' => $menuSobre->id,
            'ordem' => 3,
            'ativo' => true,
        ]);

        // 3. Legislativo (Dropdown) - Agrupando Vereadores, Projetos e Sessões
        $menuLegislativo = Menu::create([
            'titulo' => 'Legislativo',
            'slug' => 'legislativo',
            'tipo' => 'dropdown',
            'icone' => 'fas fa-university',
            'posicao' => 'header',
            'ordem' => 3,
            'ativo' => true,
        ]);

        // Submenus do "Legislativo"
        Menu::create([
            'titulo' => 'Vereadores',
            'slug' => 'vereadores',
            'tipo' => 'link',
            'rota' => 'vereadores.index',
            'icone' => 'fas fa-users',
            'posicao' => 'header',
            'parent_id' => $menuLegislativo->id,
            'ordem' => 1,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Projetos de Lei',
            'slug' => 'projetos-lei',
            'tipo' => 'link',
            'url' => '#',
            'icone' => 'fas fa-file-alt',
            'posicao' => 'header',
            'parent_id' => $menuLegislativo->id,
            'ordem' => 2,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Sessões',
            'slug' => 'sessoes',
            'tipo' => 'link',
            'rota' => 'sessoes.index',
            'icone' => 'fas fa-calendar-alt',
            'posicao' => 'header',
            'parent_id' => $menuLegislativo->id,
            'ordem' => 3,
            'ativo' => true,
        ]);

        // 4. Transparência (Dropdown)
        $transparencia = Menu::create([
            'titulo' => 'Transparência',
            'slug' => 'transparencia',
            'tipo' => 'dropdown',
            'icone' => 'fas fa-eye',
            'posicao' => 'header',
            'ordem' => 4,
            'ativo' => true,
        ]);

        // Submenus da "Transparência"
        Menu::create([
            'titulo' => 'Portal da Transparência',
            'slug' => 'portal-transparencia',
            'tipo' => 'link',
            'url' => '/transparencia/portal',
            'icone' => 'fas fa-globe',
            'posicao' => 'header',
            'parent_id' => $transparencia->id,
            'ordem' => 1,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Receitas e Despesas',
            'slug' => 'receitas-despesas',
            'tipo' => 'link',
            'url' => '/transparencia/financeiro',
            'icone' => 'fas fa-dollar-sign',
            'posicao' => 'header',
            'parent_id' => $transparencia->id,
            'ordem' => 2,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Licitações',
            'slug' => 'licitacoes',
            'tipo' => 'link',
            'url' => '/transparencia/licitacoes',
            'icone' => 'fas fa-file-contract',
            'posicao' => 'header',
            'parent_id' => $transparencia->id,
            'ordem' => 3,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Contratos',
            'slug' => 'contratos',
            'tipo' => 'link',
            'url' => '/transparencia/contratos',
            'icone' => 'fas fa-handshake',
            'posicao' => 'header',
            'parent_id' => $transparencia->id,
            'ordem' => 4,
            'ativo' => true,
        ]);

        Menu::create([
            'titulo' => 'Ouvidoria',
            'slug' => 'ouvidoria',
            'tipo' => 'link',
            'rota' => 'ouvidoria.index',
            'icone' => 'fas fa-comments',
            'posicao' => 'header',
            'parent_id' => $transparencia->id,
            'ordem' => 5,
            'ativo' => true,
        ]);

        // 5. Contato
        Menu::create([
            'titulo' => 'Contato',
            'slug' => 'contato',
            'tipo' => 'link',
            'rota' => 'contato.index',
            'icone' => 'fas fa-envelope',
            'posicao' => 'header',
            'ordem' => 5,
            'ativo' => true,
        ]);

        // 6. Entrar (Login)
        Menu::create([
            'titulo' => 'Entrar',
            'slug' => 'entrar',
            'tipo' => 'link',
            'rota' => 'login',
            'icone' => 'fas fa-sign-in-alt',
            'posicao' => 'header',
            'ordem' => 6,
            'ativo' => true,
            'configuracoes' => json_encode([
                'visibilidade' => 'guest_only',
                'classe_css' => 'nav-link-auth'
            ]),
        ]);

        // 7. Cadastrar (Register)
        Menu::create([
            'titulo' => 'Cadastrar',
            'slug' => 'cadastrar',
            'tipo' => 'link',
            'rota' => 'register',
            'icone' => 'fas fa-user-plus',
            'posicao' => 'header',
            'ordem' => 7,
            'ativo' => true,
            'configuracoes' => json_encode([
                'visibilidade' => 'guest_only',
                'classe_css' => 'nav-link-auth'
            ]),
        ]);
    }

    private function createFooterMenus()
    {
        // Vou usar as configurações JSON para armazenar o grupo do footer
        
        // Links Rápidos
        Menu::create([
            'titulo' => 'Vereadores',
            'slug' => 'footer-vereadores',
            'tipo' => 'link',
            'rota' => 'vereadores.index',
            'posicao' => 'footer',
            'ordem' => 1,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Links Rápidos']),
        ]);

        Menu::create([
            'titulo' => 'Projetos de Lei',
            'slug' => 'footer-projetos-lei',
            'tipo' => 'link',
            'url' => '#',
            'posicao' => 'footer',
            'ordem' => 2,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Links Rápidos']),
        ]);

        Menu::create([
            'titulo' => 'Sessões',
            'slug' => 'footer-sessoes',
            'tipo' => 'link',
            'rota' => 'sessoes.index',
            'posicao' => 'footer',
            'ordem' => 3,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Links Rápidos']),
        ]);

        Menu::create([
            'titulo' => 'Atas',
            'slug' => 'footer-atas',
            'tipo' => 'link',
            'url' => '#',
            'posicao' => 'footer',
            'ordem' => 4,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Links Rápidos']),
        ]);

        // Transparência
        Menu::create([
            'titulo' => 'Portal da Transparência',
            'slug' => 'footer-portal-transparencia',
            'tipo' => 'link',
            'url' => '#',
            'posicao' => 'footer',
            'ordem' => 11,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Transparência']),
        ]);

        Menu::create([
            'titulo' => 'e-SIC',
            'slug' => 'footer-esic',
            'tipo' => 'link',
            'rota' => 'esic.public',
            'posicao' => 'footer',
            'ordem' => 12,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Transparência']),
        ]);

        Menu::create([
            'titulo' => 'Lei de Acesso',
            'slug' => 'footer-lei-acesso',
            'tipo' => 'link',
            'url' => '#',
            'posicao' => 'footer',
            'ordem' => 13,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Transparência']),
        ]);

        Menu::create([
            'titulo' => 'Ouvidoria',
            'slug' => 'footer-ouvidoria',
            'tipo' => 'link',
            'rota' => 'ouvidoria.index',
            'posicao' => 'footer',
            'ordem' => 14,
            'ativo' => true,
            'configuracoes' => json_encode(['grupo_footer' => 'Transparência']),
        ]);
    }
}