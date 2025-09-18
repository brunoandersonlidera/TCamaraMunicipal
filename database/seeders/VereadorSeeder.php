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
        // Vereador Carlos Eduardo Pereira - PRESIDENTE
        Vereador::updateOrCreate(
            ['email' => 'carlos.pereira@camara.gov.br'],
            [
                'nome' => 'Carlos Eduardo Pereira',
                'nome_parlamentar' => 'Vereador Carlos Pereira',
                'partido' => 'PSDB',
                'telefone' => '11966666666',
                'biografia' => 'Formado em Administração Pública, Carlos Eduardo Pereira tem 15 anos de experiência em gestão municipal. Durante seu mandato, tem focado em projetos de educação, saúde pública e desenvolvimento urbano sustentável. Atualmente exerce a função de Presidente da Câmara Municipal.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['presidente', 'comissao-educacao']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadorcarlospereira',
                    'instagram' => '@vereadorcarlospereira',
                    'twitter' => '@carlospereira_vr'
                ]),
                'proposicoes' => 'PL 001/2021 - Programa Municipal de Alfabetização Digital; PL 015/2022 - Criação de Centros de Saúde Comunitários; PL 028/2023 - Incentivo ao Transporte Sustentável',
            ]
        );

        // Vereadora Ana Paula Rodrigues
        Vereador::updateOrCreate(
            ['email' => 'ana.rodrigues@camara.gov.br'],
            [
                'nome' => 'Ana Paula Rodrigues',
                'nome_parlamentar' => 'Vereadora Ana Paula',
                'partido' => 'PT',
                'telefone' => '11955555555',
                'biografia' => 'Assistente Social com mestrado em Políticas Sociais, Ana Paula Rodrigues é uma defensora incansável dos direitos das mulheres e das políticas de inclusão social. Atua há 12 anos no terceiro setor.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-direitos-humanos', 'comissao-saude']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadoraanapaula',
                    'instagram' => '@vereadoraanapaula',
                    'linkedin' => 'ana-paula-rodrigues-vereadora'
                ]),
                'proposicoes' => 'PL 008/2021 - Casa de Apoio à Mulher Vítima de Violência; PL 022/2022 - Programa Municipal de Capacitação Profissional Feminina; PL 035/2023 - Creches Noturnas para Mães Trabalhadoras',
            ]
        );

        // Vereador adicional para demonstração
        Vereador::updateOrCreate(
            ['email' => 'roberto.mendes@camara.gov.br'],
            [
                'nome' => 'Roberto Silva Mendes',
                'nome_parlamentar' => 'Vereador Roberto Mendes',
                'partido' => 'MDB',
                'telefone' => '11911111111',
                'biografia' => 'Empresário do setor de construção civil, Roberto Silva Mendes dedica-se às questões de infraestrutura urbana e desenvolvimento econômico do município.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-obras', 'comissao-financas']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadorrobertomendes',
                    'instagram' => '@robertomendes_vereador'
                ]),
                'proposicoes' => 'PL 012/2021 - Modernização da Infraestrutura Viária; PL 025/2022 - Incentivos para Pequenas Empresas Locais; PL 031/2023 - Programa de Construção Sustentável',
            ]
        );

        $this->command->info('Vereadores criados com sucesso!');
        $this->command->info('3 vereadores cadastrados no sistema.');
    }
}
