<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaginaConteudo;

class PaginaConteudoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paginas = [
            [
                'slug' => 'historia',
                'titulo' => 'História da Câmara Municipal',
                'descricao' => 'Conheça a trajetória e evolução da nossa Câmara Municipal ao longo dos anos.',
                'conteudo' => '<div class="historia-content">
                    <h2>Nossa História</h2>
                    <p>A Câmara Municipal tem uma rica história de representação democrática e serviço à comunidade. Desde sua fundação, tem sido o centro das decisões legislativas que moldam o desenvolvimento de nossa cidade.</p>
                    
                    <h3>Fundação e Primeiros Anos</h3>
                    <p>Estabelecida com o objetivo de representar os interesses da população local, nossa Câmara Municipal iniciou suas atividades focada na criação de leis que promovessem o bem-estar social e o desenvolvimento econômico sustentável.</p>
                    
                    <h3>Marcos Importantes</h3>
                    <ul>
                        <li>Criação das primeiras leis municipais</li>
                        <li>Implementação de políticas públicas inovadoras</li>
                        <li>Modernização dos processos legislativos</li>
                        <li>Digitalização e transparência dos dados públicos</li>
                    </ul>
                    
                    <h3>Evolução Institucional</h3>
                    <p>Ao longo dos anos, a Câmara Municipal evoluiu constantemente, adaptando-se às necessidades da população e incorporando novas tecnologias para melhor servir aos cidadãos.</p>
                </div>',
                'ativo' => true,
                'ordem' => 1,
                'template' => 'default',
                'seo' => [
                    'title' => 'História da Câmara Municipal - Conheça Nossa Trajetória',
                    'description' => 'Descubra a rica história da Câmara Municipal, seus marcos importantes e evolução institucional ao longo dos anos.',
                    'keywords' => 'história, câmara municipal, trajetória, evolução, marcos históricos'
                ]
            ],
            [
                'slug' => 'estrutura',
                'titulo' => 'Estrutura Organizacional',
                'descricao' => 'Conheça a organização institucional e a estrutura administrativa da Câmara Municipal.',
                'conteudo' => '<div class="estrutura-content">
                    <h2>Estrutura Organizacional</h2>
                    <p>A Câmara Municipal está organizada de forma a garantir eficiência, transparência e representatividade em todas as suas atividades legislativas e administrativas.</p>
                    
                    <h3>Mesa Diretora</h3>
                    <p>Responsável pela direção dos trabalhos legislativos e pela administração da Câmara Municipal.</p>
                    <ul>
                        <li>Presidente da Câmara</li>
                        <li>Vice-Presidente</li>
                        <li>1º Secretário</li>
                        <li>2º Secretário</li>
                    </ul>
                    
                    <h3>Comissões Permanentes</h3>
                    <p>Órgãos técnicos especializados que analisam as matérias de sua competência:</p>
                    <ul>
                        <li>Comissão de Constituição, Justiça e Redação</li>
                        <li>Comissão de Finanças e Orçamento</li>
                        <li>Comissão de Obras, Serviços Públicos e Meio Ambiente</li>
                        <li>Comissão de Educação, Cultura e Assistência Social</li>
                    </ul>
                    
                    <h3>Estrutura Administrativa</h3>
                    <p>Setor responsável pelo apoio técnico e administrativo às atividades legislativas:</p>
                    <ul>
                        <li>Secretaria Geral</li>
                        <li>Departamento Legislativo</li>
                        <li>Departamento Administrativo</li>
                        <li>Assessoria Jurídica</li>
                        <li>Departamento de Comunicação</li>
                    </ul>
                </div>',
                'ativo' => true,
                'ordem' => 2,
                'template' => 'default',
                'seo' => [
                    'title' => 'Estrutura Organizacional - Câmara Municipal',
                    'description' => 'Conheça a organização institucional, mesa diretora, comissões e estrutura administrativa da Câmara Municipal.',
                    'keywords' => 'estrutura, organização, mesa diretora, comissões, administração'
                ]
            ],
            [
                'slug' => 'regimento',
                'titulo' => 'Regimento Interno',
                'descricao' => 'Consulte as normas internas que regem o funcionamento da Câmara Municipal.',
                'conteudo' => '<div class="regimento-content">
                    <h2>Regimento Interno</h2>
                    <p>O Regimento Interno estabelece as normas e procedimentos que regem o funcionamento da Câmara Municipal, garantindo ordem, transparência e eficiência nos trabalhos legislativos.</p>
                    
                    <h3>Disposições Gerais</h3>
                    <p>O Regimento Interno da Câmara Municipal disciplina a organização, a direção dos trabalhos, a ordem dos debates e o processo de votação, bem como a polícia interna da Casa.</p>
                    
                    <h3>Principais Capítulos</h3>
                    <ul>
                        <li><strong>Capítulo I:</strong> Da Câmara Municipal e suas atribuições</li>
                        <li><strong>Capítulo II:</strong> Da Mesa Diretora</li>
                        <li><strong>Capítulo III:</strong> Das Comissões</li>
                        <li><strong>Capítulo IV:</strong> Das Sessões</li>
                        <li><strong>Capítulo V:</strong> Dos Projetos e Proposições</li>
                        <li><strong>Capítulo VI:</strong> Da Votação</li>
                        <li><strong>Capítulo VII:</strong> Da Disciplina e Polícia Interna</li>
                    </ul>
                    
                    <h3>Sessões Ordinárias</h3>
                    <p>As sessões ordinárias realizam-se conforme calendário estabelecido, seguindo a seguinte ordem:</p>
                    <ol>
                        <li>Abertura da sessão</li>
                        <li>Verificação de presença</li>
                        <li>Leitura da ata da sessão anterior</li>
                        <li>Expediente</li>
                        <li>Ordem do dia</li>
                        <li>Explicações pessoais</li>
                        <li>Encerramento</li>
                    </ol>
                    
                    <h3>Acesso ao Regimento Completo</h3>
                    <p>O texto completo do Regimento Interno está disponível para consulta pública e pode ser acessado através da Secretaria da Câmara ou solicitado via Lei de Acesso à Informação.</p>
                </div>',
                'ativo' => true,
                'ordem' => 3,
                'template' => 'default',
                'seo' => [
                    'title' => 'Regimento Interno - Normas da Câmara Municipal',
                    'description' => 'Consulte o regimento interno com as normas e procedimentos que regem o funcionamento da Câmara Municipal.',
                    'keywords' => 'regimento interno, normas, procedimentos, funcionamento, legislativo'
                ]
            ],
            [
                'slug' => 'missao',
                'titulo' => 'Missão, Visão e Valores',
                'descricao' => 'Conheça os princípios fundamentais que orientam as ações da Câmara Municipal.',
                'conteudo' => '<div class="missao-content">
                    <h2>Nossos Princípios Institucionais</h2>
                    <p>A Câmara Municipal pauta suas ações em princípios sólidos que garantem uma atuação ética, transparente e comprometida com o bem-estar da população.</p>
                    
                    <div class="principio-box missao-box">
                        <h3>🎯 Nossa Missão</h3>
                        <p>Exercer com excelência a função legislativa municipal, representando os interesses da população através da elaboração de leis justas e eficazes, fiscalizando o Poder Executivo e promovendo o desenvolvimento sustentável e a qualidade de vida dos cidadãos.</p>
                    </div>
                    
                    <div class="principio-box visao-box">
                        <h3>🔭 Nossa Visão</h3>
                        <p>Ser reconhecida como uma instituição legislativa moderna, transparente e eficiente, referência em participação democrática e inovação nos processos legislativos, contribuindo para o desenvolvimento de uma cidade próspera, justa e sustentável.</p>
                    </div>
                    
                    <div class="principio-box valores-box">
                        <h3>⭐ Nossos Valores</h3>
                        <ul>
                            <li><strong>Transparência:</strong> Atuamos com clareza e abertura em todos os processos</li>
                            <li><strong>Ética:</strong> Pautamos nossas ações pela integridade e honestidade</li>
                            <li><strong>Responsabilidade:</strong> Assumimos o compromisso com o bem público</li>
                            <li><strong>Participação:</strong> Valorizamos o envolvimento da sociedade nas decisões</li>
                            <li><strong>Inovação:</strong> Buscamos constantemente melhorar nossos processos</li>
                            <li><strong>Respeito:</strong> Tratamos todos com dignidade e consideração</li>
                            <li><strong>Eficiência:</strong> Otimizamos recursos para maximizar resultados</li>
                            <li><strong>Sustentabilidade:</strong> Promovemos o desenvolvimento responsável</li>
                        </ul>
                    </div>
                    
                    <h3>Compromisso com a Sociedade</h3>
                    <p>Estes princípios orientam todas as nossas ações e decisões, garantindo que a Câmara Municipal cumpra seu papel constitucional de forma exemplar, sempre priorizando o interesse público e o bem-estar da comunidade.</p>
                </div>',
                'ativo' => true,
                'ordem' => 4,
                'template' => 'default',
                'seo' => [
                    'title' => 'Missão, Visão e Valores - Câmara Municipal',
                    'description' => 'Conheça a missão, visão e valores que orientam as ações da Câmara Municipal em prol da sociedade.',
                    'keywords' => 'missão, visão, valores, princípios, ética, transparência'
                ]
            ]
        ];

        foreach ($paginas as $pagina) {
            $pagina['created_at'] = now();
            $pagina['updated_at'] = now();
            
            PaginaConteudo::updateOrCreate(
                ['slug' => $pagina['slug']],
                $pagina
            );
        }
    }
}
