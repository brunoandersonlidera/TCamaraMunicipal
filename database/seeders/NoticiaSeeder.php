<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noticia;
use App\Models\User;
use Carbon\Carbon;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar um usuário admin para ser o autor
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first();
        }
        
        if (!$admin) {
            $this->command->error('Nenhum usuário encontrado. Execute primeiro o UserSeeder.');
            return;
        }

        $noticias = [
            [
                'titulo' => 'Câmara Municipal aprova novo projeto de lei para melhorias urbanas',
                'slug' => 'camara-aprova-projeto-melhorias-urbanas',
                'resumo' => 'O projeto prevê investimentos em infraestrutura e mobilidade urbana para os próximos dois anos.',
                'conteudo' => '<p>A Câmara Municipal aprovou por unanimidade o projeto de lei que destina recursos para melhorias na infraestrutura urbana da cidade. O projeto, de autoria do vereador João Silva, prevê investimentos em pavimentação, iluminação pública e mobilidade urbana.</p><p>As obras devem começar no próximo trimestre e beneficiarão diretamente mais de 50 mil moradores da região central e dos bairros periféricos.</p><p>"Este é um marco importante para nossa cidade", declarou o presidente da Câmara durante a sessão.</p>',
                'categoria' => 'legislativo',
                'status' => 'publicado',
                'destaque' => true,
                'data_publicacao' => Carbon::now()->subDays(1),
                'tags' => ['infraestrutura', 'mobilidade', 'aprovação'],
                'meta_description' => 'Câmara Municipal aprova projeto para melhorias urbanas com investimentos em infraestrutura.',
                'meta_keywords' => 'câmara municipal, projeto de lei, infraestrutura, melhorias urbanas'
            ],
            [
                'titulo' => 'Sessão extraordinária discutirá orçamento municipal para 2024',
                'slug' => 'sessao-extraordinaria-orcamento-2024',
                'resumo' => 'Vereadores se reunirão na próxima semana para debater a proposta orçamentária do município.',
                'conteudo' => '<p>A Câmara Municipal convocou uma sessão extraordinária para a próxima terça-feira (15) para discussão e votação da Lei Orçamentária Anual (LOA) de 2024.</p><p>A proposta, enviada pelo Executivo, prevê um orçamento de R$ 120 milhões, com foco em educação, saúde e obras públicas.</p><p>A sessão será aberta ao público e transmitida ao vivo pelos canais oficiais da Câmara.</p>',
                'categoria' => 'legislativo',
                'status' => 'publicado',
                'destaque' => false,
                'data_publicacao' => Carbon::now()->subDays(3),
                'tags' => ['orçamento', 'sessão extraordinária', 'LOA'],
                'meta_description' => 'Sessão extraordinária da Câmara discutirá orçamento municipal de 2024.',
                'meta_keywords' => 'sessão extraordinária, orçamento municipal, LOA 2024'
            ],
            [
                'titulo' => 'Câmara promove audiência pública sobre meio ambiente',
                'slug' => 'audiencia-publica-meio-ambiente',
                'resumo' => 'Evento debaterá políticas ambientais e sustentabilidade no município.',
                'conteudo' => '<p>A Câmara Municipal realizará na próxima sexta-feira (18) uma audiência pública para discutir políticas ambientais e sustentabilidade no município.</p><p>O evento contará com a participação de especialistas, representantes de ONGs ambientais e da sociedade civil organizada.</p><p>Entre os temas abordados estão: gestão de resíduos sólidos, preservação de áreas verdes e políticas de sustentabilidade urbana.</p><p>A audiência será realizada no Plenário da Câmara, às 19h, com entrada gratuita.</p>',
                'categoria' => 'eventos',
                'status' => 'publicado',
                'destaque' => true,
                'data_publicacao' => Carbon::now()->subDays(5),
                'tags' => ['meio ambiente', 'audiência pública', 'sustentabilidade'],
                'meta_description' => 'Câmara promove audiência pública sobre políticas ambientais e sustentabilidade.',
                'meta_keywords' => 'audiência pública, meio ambiente, sustentabilidade, políticas ambientais'
            ],
            [
                'titulo' => 'Transparência: Câmara publica relatório de atividades do 1º semestre',
                'slug' => 'relatorio-atividades-primeiro-semestre',
                'resumo' => 'Documento apresenta dados sobre projetos aprovados, sessões realizadas e investimentos.',
                'conteudo' => '<p>A Câmara Municipal publicou o relatório de atividades do primeiro semestre de 2024, demonstrando seu compromisso com a transparência pública.</p><p>O documento apresenta dados detalhados sobre:</p><ul><li>25 projetos de lei analisados</li><li>48 sessões ordinárias realizadas</li><li>12 audiências públicas promovidas</li><li>R$ 2,8 milhões em investimentos</li></ul><p>O relatório está disponível no portal da transparência da Câmara e pode ser acessado gratuitamente por todos os cidadãos.</p>',
                'categoria' => 'transparencia',
                'status' => 'publicado',
                'destaque' => false,
                'data_publicacao' => Carbon::now()->subWeek(),
                'tags' => ['transparência', 'relatório', 'atividades'],
                'meta_description' => 'Câmara publica relatório de atividades do 1º semestre com dados de transparência.',
                'meta_keywords' => 'relatório de atividades, transparência, câmara municipal'
            ],
            [
                'titulo' => 'Homenagem aos professores marca sessão solene da Câmara',
                'slug' => 'homenagem-professores-sessao-solene',
                'resumo' => 'Evento reconheceu o trabalho de educadores que se destacaram no município.',
                'conteudo' => '<p>A Câmara Municipal realizou uma sessão solene em homenagem aos professores da rede municipal de ensino. O evento reconheceu o trabalho de 15 educadores que se destacaram por suas práticas inovadoras e dedicação.</p><p>Durante a cerimônia, foram entregues certificados de reconhecimento e medalhas de honra ao mérito educacional.</p><p>"Os professores são os verdadeiros construtores do futuro da nossa cidade", destacou o presidente da Câmara durante seu discurso.</p><p>A sessão contou com a presença de familiares, colegas de trabalho e autoridades municipais.</p>',
                'categoria' => 'eventos',
                'status' => 'publicado',
                'destaque' => false,
                'data_publicacao' => Carbon::now()->subDays(10),
                'tags' => ['educação', 'professores', 'homenagem'],
                'meta_description' => 'Câmara realiza sessão solene em homenagem aos professores municipais.',
                'meta_keywords' => 'sessão solene, professores, educação, homenagem'
            ]
        ];

        foreach ($noticias as $noticiaData) {
            $noticiaData['autor_id'] = $admin->id;
            Noticia::create($noticiaData);
        }

        $this->command->info('Notícias criadas com sucesso!');
    }
}