<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcessoRapido;

class AcessoRapidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acessos = [
            [
                'nome' => 'Vereadores',
                'descricao' => 'Conheça os vereadores e suas propostas',
                'url' => '/vereadores',
                'icone' => 'fas fa-users',
                'cor_botao' => '#2563eb',
                'cor_fonte' => '#ffffff',
                'ordem' => 1,
                'ativo' => true,
                'abrir_nova_aba' => false,
            ],
            [
                'nome' => 'Projetos de Lei',
                'descricao' => 'Acompanhe os projetos em tramitação',
                'url' => '/projetos-lei',
                'icone' => 'fas fa-gavel',
                'cor_botao' => '#059669',
                'cor_fonte' => '#ffffff',
                'ordem' => 2,
                'ativo' => true,
                'abrir_nova_aba' => false,
            ],
            [
                'nome' => 'Sessões',
                'descricao' => 'Calendário e atas das sessões plenárias',
                'url' => '/sessoes',
                'icone' => 'fas fa-calendar-alt',
                'cor_botao' => '#dc2626',
                'cor_fonte' => '#ffffff',
                'ordem' => 3,
                'ativo' => true,
                'abrir_nova_aba' => false,
            ],
            [
                'nome' => 'Transparência',
                'descricao' => 'Portal da transparência e acesso à informação',
                'url' => '/transparencia',
                'icone' => 'fas fa-eye',
                'cor_botao' => '#7c3aed',
                'cor_fonte' => '#ffffff',
                'ordem' => 4,
                'ativo' => true,
                'abrir_nova_aba' => false,
            ],
            [
                'nome' => 'E-SIC',
                'descricao' => 'Sistema Eletrônico do Serviço de Informação ao Cidadão',
                'url' => '/esic',
                'icone' => 'fas fa-info-circle',
                'cor_botao' => '#ea580c',
                'cor_fonte' => '#ffffff',
                'ordem' => 5,
                'ativo' => true,
                'abrir_nova_aba' => false,
            ],
            [
                'nome' => 'Ouvidoria',
                'descricao' => 'Canal de comunicação com o cidadão',
                'url' => '/ouvidoria',
                'icone' => 'fas fa-comments',
                'cor_botao' => '#0891b2',
                'cor_fonte' => '#ffffff',
                'ordem' => 6,
                'ativo' => true,
                'abrir_nova_aba' => false,
            ],
        ];

        foreach ($acessos as $acesso) {
            AcessoRapido::create($acesso);
        }
    }
}
