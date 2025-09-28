<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lei;
use Carbon\Carbon;

class LeisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lei fornecida pelo usuário como exemplo
        Lei::create([
            'numero' => 1485,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '16/09/2025'),
            'tipo' => 'Lei Ordinária',
            'titulo' => 'Lei Municipal nº 1.485 de 16 de setembro de 2025',
            'autoria' => 'Câmara Municipal',
            'ementa' => 'Dispõe sobre normas gerais para o município e dá outras providências.',
            'descricao' => 'Esta lei estabelece diretrizes importantes para o desenvolvimento municipal, abordando aspectos fundamentais da administração pública local e promovendo melhorias na qualidade dos serviços prestados à população.',
            'ativo' => true,
            'observacoes' => 'Lei de grande relevância para o município.',
            'slug' => 'lei-municipal-1485-2025'
        ]);

        // Leis Ordinárias de exemplo
        Lei::create([
            'numero' => 1486,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '20/09/2025'),
            'tipo' => 'Lei Ordinária',
            'titulo' => 'Dispõe sobre a criação do Programa Municipal de Meio Ambiente',
            'autoria' => 'Vereador João Silva',
            'ementa' => 'Institui o Programa Municipal de Meio Ambiente e estabelece diretrizes para a preservação ambiental no município.',
            'descricao' => 'Esta lei cria o Programa Municipal de Meio Ambiente com o objetivo de promover a sustentabilidade, a educação ambiental e a preservação dos recursos naturais do município. O programa incluirá ações de reflorestamento, coleta seletiva e conscientização da população sobre a importância da preservação ambiental.',
            'ativo' => true,
            'observacoes' => 'Aprovada por unanimidade.',
            'slug' => 'programa-municipal-meio-ambiente-1486-2025'
        ]);

        Lei::create([
            'numero' => 1487,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '25/09/2025'),
            'tipo' => 'Lei Ordinária',
            'titulo' => 'Altera a Lei Municipal de Trânsito e Transporte',
            'autoria' => 'Vereadora Maria Santos',
            'ementa' => 'Altera dispositivos da Lei Municipal de Trânsito e Transporte para melhorar a mobilidade urbana.',
            'descricao' => 'Esta lei promove alterações na legislação municipal de trânsito, estabelecendo novas regras para o transporte público, criando ciclovias e melhorando a sinalização urbana. As mudanças visam reduzir o trânsito e promover meios de transporte mais sustentáveis.',
            'ativo' => true,
            'observacoes' => 'Entrada em vigor em 60 dias.',
            'slug' => 'alteracao-lei-transito-1487-2025'
        ]);

        // Leis Complementares de exemplo
        Lei::create([
            'numero' => 45,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '10/08/2025'),
            'tipo' => 'Lei Complementar',
            'titulo' => 'Código Tributário Municipal',
            'autoria' => 'Poder Executivo',
            'ementa' => 'Institui o Código Tributário Municipal e estabelece normas gerais de direito tributário aplicáveis ao município.',
            'descricao' => 'Esta lei complementar estabelece o sistema tributário municipal, definindo os tributos de competência do município, suas bases de cálculo, alíquotas e procedimentos de arrecadação. Inclui disposições sobre IPTU, ISS, taxas municipais e contribuições de melhoria.',
            'ativo' => true,
            'observacoes' => 'Substitui a legislação tributária anterior.',
            'slug' => 'codigo-tributario-municipal-45-2025'
        ]);

        Lei::create([
            'numero' => 46,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '15/08/2025'),
            'tipo' => 'Lei Complementar',
            'titulo' => 'Plano Diretor Municipal',
            'autoria' => 'Comissão Especial',
            'ementa' => 'Aprova o Plano Diretor Municipal e estabelece diretrizes para o desenvolvimento urbano.',
            'descricao' => 'O Plano Diretor Municipal é o instrumento básico da política de desenvolvimento e expansão urbana. Esta lei estabelece as diretrizes para o crescimento ordenado da cidade, definindo zonas de uso, parâmetros urbanísticos e instrumentos de política urbana.',
            'ativo' => true,
            'observacoes' => 'Elaborado com participação popular.',
            'slug' => 'plano-diretor-municipal-46-2025'
        ]);

        // Resoluções de exemplo
        Lei::create([
            'numero' => 12,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '05/09/2025'),
            'tipo' => 'Resolução',
            'titulo' => 'Regimento Interno da Câmara Municipal',
            'autoria' => 'Mesa Diretora',
            'ementa' => 'Aprova o novo Regimento Interno da Câmara Municipal.',
            'descricao' => 'Esta resolução estabelece as normas de funcionamento da Câmara Municipal, definindo os procedimentos para as sessões, tramitação de projetos, funcionamento das comissões e demais atividades legislativas.',
            'ativo' => true,
            'observacoes' => 'Atualização do regimento anterior.',
            'slug' => 'regimento-interno-camara-12-2025'
        ]);

        Lei::create([
            'numero' => 13,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '12/09/2025'),
            'tipo' => 'Resolução',
            'titulo' => 'Criação da Comissão de Ética e Decoro Parlamentar',
            'autoria' => 'Vereador Carlos Oliveira',
            'ementa' => 'Cria a Comissão de Ética e Decoro Parlamentar e estabelece suas competências.',
            'descricao' => 'Esta resolução institui a Comissão de Ética e Decoro Parlamentar, órgão responsável por zelar pela observância dos princípios éticos e das normas de decoro parlamentar pelos membros da Câmara Municipal.',
            'ativo' => true,
            'observacoes' => 'Comissão permanente.',
            'slug' => 'comissao-etica-decoro-13-2025'
        ]);

        // Decretos Legislativos de exemplo
        Lei::create([
            'numero' => 8,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '30/08/2025'),
            'tipo' => 'Decreto Legislativo',
            'titulo' => 'Concessão de Título de Cidadão Honorário',
            'autoria' => 'Vereador Pedro Costa',
            'ementa' => 'Concede o título de Cidadão Honorário ao Sr. José da Silva pelos relevantes serviços prestados ao município.',
            'descricao' => 'Este decreto legislativo reconhece os méritos e a contribuição do Sr. José da Silva para o desenvolvimento do município, concedendo-lhe o título de Cidadão Honorário em reconhecimento aos seus serviços prestados à comunidade.',
            'ativo' => true,
            'observacoes' => 'Cerimônia de entrega agendada.',
            'slug' => 'titulo-cidadao-honorario-jose-silva-8-2025'
        ]);

        Lei::create([
            'numero' => 9,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '02/09/2025'),
            'tipo' => 'Decreto Legislativo',
            'titulo' => 'Aprovação de Convênio com o Estado',
            'autoria' => 'Comissão de Finanças',
            'ementa' => 'Aprova o convênio celebrado entre o município e o governo estadual para execução de obras de infraestrutura.',
            'descricao' => 'Este decreto legislativo aprova o convênio firmado com o governo estadual para a execução de obras de pavimentação, drenagem e saneamento básico em diversos bairros do município, com investimento total de R$ 2.500.000,00.',
            'ativo' => true,
            'observacoes' => 'Contrapartida municipal de 20%.',
            'slug' => 'aprovacao-convenio-estado-obras-9-2025'
        ]);

        // Lei Orgânica
        Lei::create([
            'numero' => 1,
            'exercicio' => 2024,
            'data' => Carbon::createFromFormat('d/m/Y', '15/01/2024'),
            'tipo' => 'Lei Orgânica',
            'titulo' => 'Lei Orgânica do Município',
            'autoria' => 'Câmara Municipal Constituinte',
            'ementa' => 'Lei Orgânica do Município, estabelecendo sua organização política e administrativa.',
            'descricao' => 'A Lei Orgânica é a lei fundamental do município, estabelecendo sua organização política, administrativa e territorial. Define os poderes municipais, os direitos e deveres dos cidadãos, as competências do município e os princípios da administração pública local.',
            'ativo' => true,
            'observacoes' => 'Lei fundamental do município.',
            'slug' => 'lei-organica-municipio-1-2024'
        ]);

        // Emenda à Lei Orgânica
        Lei::create([
            'numero' => 3,
            'exercicio' => 2025,
            'data' => Carbon::createFromFormat('d/m/Y', '22/07/2025'),
            'tipo' => 'Emenda à Lei Orgânica',
            'titulo' => 'Emenda à Lei Orgânica nº 03/2025',
            'autoria' => 'Vereadora Ana Paula',
            'ementa' => 'Altera o artigo 45 da Lei Orgânica Municipal para incluir disposições sobre transparência pública.',
            'descricao' => 'Esta emenda à Lei Orgânica Municipal modifica o artigo 45, incluindo novos dispositivos sobre transparência pública, acesso à informação e participação popular na gestão municipal, fortalecendo os mecanismos de controle social.',
            'ativo' => true,
            'observacoes' => 'Aprovada em dois turnos.',
            'slug' => 'emenda-lei-organica-transparencia-3-2025'
        ]);

        // Leis de anos anteriores para demonstrar histórico
        Lei::create([
            'numero' => 1450,
            'exercicio' => 2024,
            'data' => Carbon::createFromFormat('d/m/Y', '10/12/2024'),
            'tipo' => 'Lei Ordinária',
            'titulo' => 'Lei Orçamentária Anual 2025',
            'autoria' => 'Poder Executivo',
            'ementa' => 'Estima a receita e fixa a despesa do município para o exercício financeiro de 2025.',
            'descricao' => 'A Lei Orçamentária Anual estabelece as previsões de receitas e as autorizações de despesas para o exercício de 2025, contemplando os programas e ações do governo municipal para o próximo ano.',
            'ativo' => true,
            'observacoes' => 'Orçamento aprovado no prazo legal.',
            'slug' => 'lei-orcamentaria-anual-2025-1450-2024'
        ]);

        Lei::create([
            'numero' => 1420,
            'exercicio' => 2024,
            'data' => Carbon::createFromFormat('d/m/Y', '15/06/2024'),
            'tipo' => 'Lei Ordinária',
            'titulo' => 'Estatuto do Servidor Público Municipal',
            'autoria' => 'Comissão de Administração',
            'ementa' => 'Dispõe sobre o regime jurídico dos servidores públicos municipais.',
            'descricao' => 'Este estatuto estabelece o regime jurídico dos servidores públicos municipais, definindo direitos, deveres, proibições, regime disciplinar e demais aspectos da relação funcional entre o servidor e a administração municipal.',
            'ativo' => true,
            'observacoes' => 'Substitui legislação anterior.',
            'slug' => 'estatuto-servidor-publico-municipal-1420-2024'
        ]);

        Lei::create([
            'numero' => 1380,
            'exercicio' => 2023,
            'data' => Carbon::createFromFormat('d/m/Y', '20/11/2023'),
            'tipo' => 'Lei Ordinária',
            'titulo' => 'Criação do Conselho Municipal de Educação',
            'autoria' => 'Vereadora Lucia Fernandes',
            'ementa' => 'Cria o Conselho Municipal de Educação e estabelece suas competências.',
            'descricao' => 'Esta lei institui o Conselho Municipal de Educação como órgão normativo, consultivo e de controle social do sistema municipal de ensino, definindo sua composição, competências e funcionamento.',
            'ativo' => true,
            'observacoes' => 'Órgão de controle social da educação.',
            'slug' => 'conselho-municipal-educacao-1380-2023'
        ]);
    }
}
