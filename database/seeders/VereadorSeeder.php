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

        // Vereadora Maria José Santos
        Vereador::updateOrCreate(
            ['email' => 'maria.santos@camara.gov.br'],
            [
                'nome' => 'Maria José Santos',
                'nome_parlamentar' => 'Vereadora Maria José',
                'partido' => 'PDT',
                'telefone' => '11922222222',
                'biografia' => 'Professora aposentada com 30 anos de magistério, Maria José Santos é especialista em educação infantil e políticas educacionais. Dedica seu mandato à melhoria da qualidade do ensino público municipal.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-educacao', 'comissao-cultura']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadoramariajose',
                    'instagram' => '@mariajose_vereadora',
                    'youtube' => 'Vereadora Maria José Santos'
                ]),
                'proposicoes' => 'PL 005/2021 - Ampliação do Ensino Integral; PL 018/2022 - Biblioteca Comunitária em Cada Bairro; PL 029/2023 - Programa de Alfabetização de Adultos',
            ]
        );

        // Vereador João Batista Lima
        Vereador::updateOrCreate(
            ['email' => 'joao.lima@camara.gov.br'],
            [
                'nome' => 'João Batista Lima',
                'nome_parlamentar' => 'Vereador João Batista',
                'partido' => 'PP',
                'telefone' => '11933333333',
                'biografia' => 'Agricultor familiar e líder comunitário, João Batista Lima representa os interesses da zona rural do município. Atua na defesa da agricultura sustentável e do desenvolvimento rural.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-agricultura', 'comissao-meio-ambiente']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadorjoaobatista',
                    'instagram' => '@joaobatista_rural',
                    'whatsapp' => '11933333333'
                ]),
                'proposicoes' => 'PL 007/2021 - Incentivo à Agricultura Familiar; PL 020/2022 - Programa de Reflorestamento Municipal; PL 033/2023 - Centro de Comercialização de Produtos Rurais',
            ]
        );

        // Vereadora Fernanda Costa
        Vereador::updateOrCreate(
            ['email' => 'fernanda.costa@camara.gov.br'],
            [
                'nome' => 'Fernanda Costa',
                'nome_parlamentar' => 'Vereadora Fernanda',
                'partido' => 'PSOL',
                'telefone' => '11944444444',
                'biografia' => 'Advogada especializada em direitos humanos e ativista social. Fernanda Costa luta pelos direitos da juventude, LGBTQIA+ e pela transparência na gestão pública.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-direitos-humanos', 'comissao-juventude']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadorafernanda',
                    'instagram' => '@fernanda_vereadora',
                    'twitter' => '@fernandacosta_vr',
                    'tiktok' => '@vereadorafernanda'
                ]),
                'proposicoes' => 'PL 010/2021 - Centro de Referência LGBTQIA+; PL 024/2022 - Programa Jovem Empreendedor; PL 037/2023 - Portal da Transparência Cidadã',
            ]
        );

        // Vereador Antônio Carlos Oliveira
        Vereador::updateOrCreate(
            ['email' => 'antonio.oliveira@camara.gov.br'],
            [
                'nome' => 'Antônio Carlos Oliveira',
                'nome_parlamentar' => 'Vereador Antônio Carlos',
                'partido' => 'PL',
                'telefone' => '11977777777',
                'biografia' => 'Ex-policial militar e especialista em segurança pública. Antônio Carlos Oliveira dedica seu mandato às questões de segurança urbana, trânsito e proteção civil.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-seguranca', 'comissao-transito']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadorantoniocarlos',
                    'instagram' => '@antoniocarlos_seguranca',
                    'linkedin' => 'antonio-carlos-oliveira-vereador'
                ]),
                'proposicoes' => 'PL 003/2021 - Ampliação do Sistema de Videomonitoramento; PL 016/2022 - Programa Ronda Escolar; PL 030/2023 - Central de Emergências Integrada',
            ]
        );

        // Vereadora Patrícia Almeida
        Vereador::updateOrCreate(
            ['email' => 'patricia.almeida@camara.gov.br'],
            [
                'nome' => 'Patrícia Almeida',
                'nome_parlamentar' => 'Vereadora Patrícia',
                'partido' => 'REPUBLICANOS',
                'telefone' => '11988888888',
                'biografia' => 'Enfermeira com especialização em saúde pública. Patrícia Almeida atua na defesa da saúde municipal, com foco na atenção básica e na saúde da mulher e da criança.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-saude', 'comissao-assistencia-social']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadorapatricia',
                    'instagram' => '@patricia_saude',
                    'youtube' => 'Vereadora Patrícia Almeida'
                ]),
                'proposicoes' => 'PL 006/2021 - Ampliação das UBS; PL 019/2022 - Programa Saúde da Mulher; PL 032/2023 - Centro de Especialidades Médicas',
            ]
        );

        // Vereador Marcos Vinícius Silva
        Vereador::updateOrCreate(
            ['email' => 'marcos.silva@camara.gov.br'],
            [
                'nome' => 'Marcos Vinícius Silva',
                'nome_parlamentar' => 'Vereador Marcos Vinícius',
                'partido' => 'UNIÃO',
                'telefone' => '11999999999',
                'biografia' => 'Jovem empreendedor e especialista em tecnologia. Marcos Vinícius Silva trabalha pela modernização da gestão pública e pelo desenvolvimento da economia digital no município.',
                'status' => 'ativo',
                'inicio_mandato' => '2021-01-01',
                'fim_mandato' => '2024-12-31',
                'legislatura' => 2021,
                'comissoes' => json_encode(['comissao-tecnologia', 'comissao-desenvolvimento-economico']),
                'redes_sociais' => json_encode([
                    'facebook' => 'https://facebook.com/vereadormarcosvinicius',
                    'instagram' => '@marcosvinicius_tech',
                    'twitter' => '@marcosvinicius_vr',
                    'linkedin' => 'marcos-vinicius-silva-vereador',
                    'tiktok' => '@vereadormarcos'
                ]),
                'proposicoes' => 'PL 004/2021 - Cidade Inteligente Digital; PL 017/2022 - Hub de Inovação Municipal; PL 034/2023 - Programa de Inclusão Digital para Idosos',
            ]
        );

        $this->command->info('Vereadores criados com sucesso!');
        $this->command->info('9 vereadores cadastrados no sistema.');
    }
}
