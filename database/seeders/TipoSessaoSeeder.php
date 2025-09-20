<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoSessao;

class TipoSessaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nome' => 'Sessão Ordinária',
                'slug' => 'sessao-ordinaria',
                'descricao' => 'Sessões regulares realizadas conforme calendário oficial da Câmara Municipal.',
                'cor' => '#3b82f6',
                'icone' => 'fas fa-calendar-alt',
                'ativo' => true,
                'ordem' => 1,
            ],
            [
                'nome' => 'Sessão Extraordinária',
                'slug' => 'sessao-extraordinaria',
                'descricao' => 'Sessões especiais convocadas para tratar de assuntos urgentes ou específicos.',
                'cor' => '#ef4444',
                'icone' => 'fas fa-exclamation-triangle',
                'ativo' => true,
                'ordem' => 2,
            ],
            [
                'nome' => 'Sessão Solene',
                'slug' => 'sessao-solene',
                'descricao' => 'Sessões cerimoniais para homenagens, outorga de títulos e eventos especiais.',
                'cor' => '#8b5cf6',
                'icone' => 'fas fa-award',
                'ativo' => true,
                'ordem' => 3,
            ],
            [
                'nome' => 'Audiência Pública',
                'slug' => 'audiencia-publica',
                'descricao' => 'Sessões abertas para participação e manifestação da população sobre temas específicos.',
                'cor' => '#10b981',
                'icone' => 'fas fa-users',
                'ativo' => true,
                'ordem' => 4,
            ],
            [
                'nome' => 'Sessão Especial',
                'slug' => 'sessao-especial',
                'descricao' => 'Sessões temáticas ou comemorativas sobre assuntos de interesse público.',
                'cor' => '#f59e0b',
                'icone' => 'fas fa-star',
                'ativo' => true,
                'ordem' => 5,
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoSessao::updateOrCreate(
                ['slug' => $tipo['slug']],
                $tipo
            );
        }
    }
}
