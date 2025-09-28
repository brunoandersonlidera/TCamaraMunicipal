<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slide;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar slides existentes
        Slide::truncate();
        
        // Criar slides de exemplo
        $slides = [
            [
                'titulo' => 'Transparência e Participação',
                'descricao' => 'Acompanhe as atividades da Câmara Municipal e participe das decisões que afetam nossa cidade.',
                'imagem' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=400&fit=crop&crop=center',
                'link' => route('transparencia.index'),
                'nova_aba' => false,
                'ordem' => 1,
                'ativo' => true,
                'velocidade' => 5,
                'transicao' => 'slide',
                'direcao' => 'ltr'
            ],
            [
                'titulo' => 'Conheça Nossos Vereadores',
                'descricao' => 'Representantes eleitos trabalhando pelo desenvolvimento e bem-estar da população.',
                'imagem' => 'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=800&h=400&fit=crop&crop=center',
                'link' => route('vereadores.index'),
                'nova_aba' => false,
                'ordem' => 2,
                'ativo' => true,
                'velocidade' => 4,
                'transicao' => 'slide',
                'direcao' => 'ltr'
            ],
            [
                'titulo' => 'Sessões da Câmara',
                'descricao' => 'Assista às sessões ao vivo e acompanhe as discussões sobre projetos de lei e políticas públicas.',
                'imagem' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800&h=400&fit=crop&crop=center',
                'link' => route('sessoes.index'),
                'nova_aba' => false,
                'ordem' => 3,
                'ativo' => true,
                'velocidade' => 6,
                'transicao' => 'fade',
                'direcao' => 'ltr'
            ],
            [
                'titulo' => 'Portal da Transparência',
                'descricao' => 'Acesse informações sobre gastos públicos, contratos e prestação de contas da administração.',
                'imagem' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=400&fit=crop&crop=center',
                'link' => '#',
                'nova_aba' => true,
                'ordem' => 4,
                'ativo' => true,
                'velocidade' => 5,
                'transicao' => 'slide',
                'direcao' => 'ltr'
            ],
            [
                'titulo' => 'Ouvidoria Municipal',
                'descricao' => 'Canal direto para sugestões, reclamações e elogios. Sua voz é importante para nós.',
                'imagem' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&h=400&fit=crop&crop=center',
                'link' => route('ouvidoria.index'),
                'nova_aba' => false,
                'ordem' => 5,
                'ativo' => true,
                'velocidade' => 4,
                'transicao' => 'slide',
                'direcao' => 'ltr'
            ]
        ];
        
        foreach ($slides as $slideData) {
            Slide::create($slideData);
        }
        
        $this->command->info('✅ Slides de exemplo criados com sucesso!');
        $this->command->info('📊 Total de slides criados: ' . count($slides));
    }
}
