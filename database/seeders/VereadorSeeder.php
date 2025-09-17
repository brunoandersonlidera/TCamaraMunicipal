<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vereador;
use App\Models\User;

class VereadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar usuários com role 'vereador'
        $userCarlos = User::where('email', 'carlos.pereira@camara.gov.br')->first();
        $userAna = User::where('email', 'ana.rodrigues@camara.gov.br')->first();

        // Vereador Carlos Eduardo Pereira
        if ($userCarlos) {
            Vereador::create([
                'user_id' => $userCarlos->id,
                'nome_completo' => 'Carlos Eduardo Pereira',
                'nome_parlamentar' => 'Vereador Carlos Pereira',
                'partido' => 'PSDB',
                'numero_eleicao' => '45123',
                'votos_recebidos' => 2850,
                'mandato_inicio' => '2021-01-01',
                'mandato_fim' => '2024-12-31',
                'status' => 'ativo',
                'telefone' => '11966666666',
                'email' => 'carlos.pereira@camara.gov.br',
                'biografia' => 'Formado em Administração Pública, Carlos Eduardo Pereira tem 15 anos de experiência em gestão municipal. Durante seu mandato, tem focado em projetos de educação, saúde pública e desenvolvimento urbano sustentável.',
                'formacao_academica' => 'Graduação em Administração Pública - USP, Especialização em Gestão Municipal - FGV',
                'experiencia_profissional' => 'Ex-Secretário de Educação (2015-2020), Consultor em Políticas Públicas (2010-2015)',
                'comissoes' => json_encode([
                    'Comissão de Educação e Cultura',
                    'Comissão de Saúde e Assistência Social',
                    'Comissão de Orçamento e Finanças'
                ]),
                'projetos_lei' => json_encode([
                    'PL 001/2021 - Programa Municipal de Alfabetização Digital',
                    'PL 015/2022 - Criação de Centros de Saúde Comunitários',
                    'PL 028/2023 - Incentivo ao Transporte Sustentável'
                ]),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadorcarlospereira',
                    'instagram' => '@vereadorcarlospereira',
                    'twitter' => '@carlospereira_vr'
                ]),
                'endereco_gabinete' => 'Gabinete 101 - Câmara Municipal',
                'horario_atendimento' => 'Segunda a Sexta: 8h às 17h',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Vereadora Ana Paula Rodrigues
        if ($userAna) {
            Vereador::create([
                'user_id' => $userAna->id,
                'nome_completo' => 'Ana Paula Rodrigues',
                'nome_parlamentar' => 'Vereadora Ana Paula',
                'partido' => 'PT',
                'numero_eleicao' => '13456',
                'votos_recebidos' => 3120,
                'mandato_inicio' => '2021-01-01',
                'mandato_fim' => '2024-12-31',
                'status' => 'ativo',
                'telefone' => '11955555555',
                'email' => 'ana.rodrigues@camara.gov.br',
                'biografia' => 'Assistente Social com mestrado em Políticas Sociais, Ana Paula Rodrigues é uma defensora incansável dos direitos das mulheres e das políticas de inclusão social. Atua há 12 anos no terceiro setor.',
                'formacao_academica' => 'Graduação em Serviço Social - PUC-SP, Mestrado em Políticas Sociais - UNICAMP',
                'experiencia_profissional' => 'Coordenadora de ONG (2010-2020), Assistente Social na Prefeitura (2008-2010)',
                'comissoes' => json_encode([
                    'Comissão de Direitos Humanos e Cidadania',
                    'Comissão da Mulher',
                    'Comissão de Assistência Social'
                ]),
                'projetos_lei' => json_encode([
                    'PL 008/2021 - Casa de Apoio à Mulher Vítima de Violência',
                    'PL 022/2022 - Programa Municipal de Capacitação Profissional Feminina',
                    'PL 035/2023 - Creches Noturnas para Mães Trabalhadoras'
                ]),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadoraanapaula',
                    'instagram' => '@vereadoraanapaula',
                    'linkedin' => 'ana-paula-rodrigues-vereadora'
                ]),
                'endereco_gabinete' => 'Gabinete 205 - Câmara Municipal',
                'horario_atendimento' => 'Segunda a Sexta: 9h às 18h',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Vereador adicional para demonstração
        Vereador::create([
            'nome_completo' => 'Roberto Silva Mendes',
            'nome_parlamentar' => 'Vereador Roberto Mendes',
            'partido' => 'MDB',
            'numero_eleicao' => '15789',
            'votos_recebidos' => 2650,
            'mandato_inicio' => '2021-01-01',
            'mandato_fim' => '2024-12-31',
            'status' => 'ativo',
            'telefone' => '11911111111',
            'email' => 'roberto.mendes@camara.gov.br',
            'biografia' => 'Empresário do setor de construção civil, Roberto Silva Mendes dedica-se às questões de infraestrutura urbana e desenvolvimento econômico do município.',
            'formacao_academica' => 'Graduação em Engenharia Civil - MACKENZIE, MBA em Gestão Empresarial - FIA',
            'experiencia_profissional' => 'Empresário (1995-presente), Presidente do Sindicato da Construção Civil (2015-2020)',
            'comissoes' => json_encode([
                'Comissão de Obras e Serviços Públicos',
                'Comissão de Desenvolvimento Econômico',
                'Comissão de Meio Ambiente'
            ]),
            'projetos_lei' => json_encode([
                'PL 012/2021 - Modernização da Infraestrutura Viária',
                'PL 025/2022 - Incentivos para Pequenas Empresas Locais',
                'PL 031/2023 - Programa de Construção Sustentável'
            ]),
            'redes_sociais' => json_encode([
                'facebook' => 'https://facebook.com/vereadorrobertomendes',
                'instagram' => '@robertomendes_vereador'
            ]),
            'endereco_gabinete' => 'Gabinete 150 - Câmara Municipal',
            'horario_atendimento' => 'Terça e Quinta: 14h às 18h',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Vereadores criados com sucesso!');
        $this->command->info('3 vereadores cadastrados no sistema.');
    }
}
