<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\Vereador;
use App\Models\Sessao;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar eventos existentes
        Evento::truncate();

        // Obter alguns vereadores e sessões para relacionar
        $vereadores = Vereador::limit(3)->get();
        $sessoes = Sessao::limit(3)->get();

        $eventos = [
            // Sessões Plenárias (baseadas nas sessões existentes)
            [
                'titulo' => 'Sessão Ordinária - Discussão do Orçamento 2025',
                'descricao' => 'Discussão e votação do projeto de lei orçamentária anual para o exercício de 2025.',
                'tipo' => 'sessao_plenaria',
                'data_evento' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'hora_inicio' => '14:00',
                'hora_fim' => '18:00',
                'local' => 'Plenário da Câmara Municipal',
                'destaque' => true,
                'cor_destaque' => '#dc3545',
                'ativo' => true,
                'sessao_id' => $sessoes->first()?->id,
            ],
            [
                'titulo' => 'Sessão Extraordinária - Aprovação de Convênios',
                'descricao' => 'Sessão extraordinária para aprovação de convênios com o Estado e União.',
                'tipo' => 'sessao_plenaria',
                'data_evento' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'hora_inicio' => '09:00',
                'hora_fim' => '12:00',
                'local' => 'Plenário da Câmara Municipal',
                'destaque' => false,
                'ativo' => true,
                'sessao_id' => $sessoes->skip(1)->first()?->id,
            ],

            // Audiências Públicas
            [
                'titulo' => 'Audiência Pública - Plano Diretor Municipal',
                'descricao' => 'Audiência pública para discussão das alterações propostas no Plano Diretor Municipal.',
                'tipo' => 'audiencia_publica',
                'data_evento' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'hora_inicio' => '19:00',
                'hora_fim' => '21:00',
                'local' => 'Auditório da Câmara Municipal',
                'destaque' => true,
                'cor_destaque' => '#fd7e14',
                'ativo' => true,
            ],
            [
                'titulo' => 'Audiência Pública - Saúde Municipal',
                'descricao' => 'Prestação de contas e discussão sobre os investimentos em saúde pública municipal.',
                'tipo' => 'audiencia_publica',
                'data_evento' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'hora_inicio' => '14:30',
                'hora_fim' => '17:00',
                'local' => 'Auditório da Câmara Municipal',
                'destaque' => false,
                'ativo' => true,
            ],

            // Reuniões de Comissão
            [
                'titulo' => 'Reunião da Comissão de Finanças',
                'descricao' => 'Análise dos projetos de lei relacionados ao orçamento e finanças municipais.',
                'tipo' => 'reuniao_comissao',
                'data_evento' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'hora_inicio' => '08:30',
                'hora_fim' => '11:00',
                'local' => 'Sala da Comissão de Finanças',
                'destaque' => false,
                'ativo' => true,
            ],
            [
                'titulo' => 'Reunião da Comissão de Obras e Serviços Públicos',
                'descricao' => 'Discussão sobre projetos de infraestrutura e melhorias urbanas.',
                'tipo' => 'reuniao_comissao',
                'data_evento' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'hora_inicio' => '14:00',
                'hora_fim' => '16:30',
                'local' => 'Sala da Comissão de Obras',
                'destaque' => false,
                'ativo' => true,
            ],

            // Agenda de Vereadores
            [
                'titulo' => 'Atendimento ao Público - Vereador João Silva',
                'descricao' => 'Atendimento aos cidadãos para recebimento de demandas e sugestões.',
                'tipo' => 'agenda_vereador',
                'data_evento' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'hora_inicio' => '08:00',
                'hora_fim' => '12:00',
                'local' => 'Gabinete do Vereador',
                'destaque' => false,
                'ativo' => true,
                'vereador_id' => $vereadores->first()?->id,
            ],
            [
                'titulo' => 'Visita Técnica - Escola Municipal',
                'descricao' => 'Visita técnica à Escola Municipal para verificação das condições de infraestrutura.',
                'tipo' => 'agenda_vereador',
                'data_evento' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'hora_inicio' => '09:00',
                'hora_fim' => '11:00',
                'local' => 'Escola Municipal Centro',
                'destaque' => false,
                'ativo' => true,
                'vereador_id' => $vereadores->skip(1)->first()?->id,
            ],

            // Licitações
            [
                'titulo' => 'Licitação - Aquisição de Equipamentos de Informática',
                'descricao' => 'Abertura de licitação para aquisição de equipamentos de informática para a Câmara.',
                'tipo' => 'licitacao',
                'data_evento' => Carbon::now()->addDays(12)->format('Y-m-d'),
                'hora_inicio' => '10:00',
                'hora_fim' => '12:00',
                'local' => 'Sala de Licitações',
                'destaque' => false,
                'ativo' => true,
            ],

            // Datas Comemorativas
            [
                'titulo' => 'Dia do Servidor Público Municipal',
                'descricao' => 'Homenagem aos servidores públicos municipais pelos serviços prestados à comunidade.',
                'tipo' => 'data_comemorativa',
                'data_evento' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'hora_inicio' => '10:00',
                'hora_fim' => '12:00',
                'local' => 'Plenário da Câmara Municipal',
                'destaque' => true,
                'cor_destaque' => '#6f42c1',
                'ativo' => true,
            ],
            [
                'titulo' => 'Semana do Meio Ambiente',
                'descricao' => 'Abertura da Semana do Meio Ambiente com palestras e atividades educativas.',
                'tipo' => 'data_comemorativa',
                'data_evento' => Carbon::now()->addDays(25)->format('Y-m-d'),
                'hora_inicio' => '14:00',
                'hora_fim' => '17:00',
                'local' => 'Praça Central',
                'destaque' => false,
                'ativo' => true,
            ],

            // Votações Especiais
            [
                'titulo' => 'Votação - Projeto de Lei Complementar nº 001/2024',
                'descricao' => 'Votação em segundo turno do Projeto de Lei Complementar sobre o Código Tributário Municipal.',
                'tipo' => 'votacao',
                'data_evento' => Carbon::now()->addDays(8)->format('Y-m-d'),
                'hora_inicio' => '15:00',
                'hora_fim' => '17:00',
                'local' => 'Plenário da Câmara Municipal',
                'destaque' => true,
                'cor_destaque' => '#e83e8c',
                'ativo' => true,
            ],

            // Eventos passados (para histórico)
            [
                'titulo' => 'Sessão Solene - Posse dos Vereadores',
                'descricao' => 'Sessão solene de posse dos vereadores eleitos para a legislatura 2021-2024.',
                'tipo' => 'sessao_plenaria',
                'data_evento' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'hora_inicio' => '14:00',
                'hora_fim' => '18:00',
                'local' => 'Plenário da Câmara Municipal',
                'destaque' => false,
                'ativo' => true,
                'sessao_id' => $sessoes->last()?->id,
            ],
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento);
        }

        $this->command->info('EventoSeeder executado com sucesso! ' . count($eventos) . ' eventos criados.');
    }
}