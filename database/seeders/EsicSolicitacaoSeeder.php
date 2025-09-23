<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EsicSolicitacaoSeeder extends Seeder
{
    public function run()
    {
        // Dados de exemplo para solicitações
        $solicitacoes = [
            [
                'protocolo' => 'ESIC-2025-000001',
                'nome_solicitante' => 'João Silva Santos',
                'email_solicitante' => 'joao.silva@email.com',
                'telefone_solicitante' => '(87) 99999-1111',
                'cpf_solicitante' => '123.456.789-01',
                'categoria' => 'informacao',
                'assunto' => 'Informações sobre gastos com combustível',
                'descricao' => 'Solicito informações detalhadas sobre os gastos com combustível da frota municipal no último trimestre.',
                'forma_recebimento' => 'email',
                'status' => 'respondida',
                'data_limite_resposta' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'user_id' => 2,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'protocolo' => 'ESIC-2025-000002',
                'nome_solicitante' => 'Maria Oliveira Costa',
                'email_solicitante' => 'maria.costa@email.com',
                'telefone_solicitante' => '(87) 99999-2222',
                'cpf_solicitante' => '987.654.321-02',
                'categoria' => 'documento',
                'assunto' => 'Cópia de atas das sessões',
                'descricao' => 'Solicito cópia das atas das sessões ordinárias dos últimos 6 meses.',
                'forma_recebimento' => 'email',
                'status' => 'em_analise',
                'data_limite_resposta' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'user_id' => 3,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'protocolo' => 'ESIC-2025-000003',
                'nome_solicitante' => 'Carlos Eduardo Pereira',
                'email_solicitante' => 'carlos.pereira@email.com',
                'telefone_solicitante' => '(87) 99999-3333',
                'cpf_solicitante' => '456.789.123-03',
                'categoria' => 'dados',
                'assunto' => 'Dados sobre licitações',
                'descricao' => 'Solicito dados sobre todas as licitações realizadas no ano de 2024.',
                'forma_recebimento' => 'email',
                'status' => 'pendente',
                'data_limite_resposta' => Carbon::now()->addDays(25)->format('Y-m-d'),
                'user_id' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'protocolo' => 'ESIC-2025-000004',
                'nome_solicitante' => 'Ana Paula Rodrigues',
                'email_solicitante' => 'ana.rodrigues@email.com',
                'telefone_solicitante' => '(87) 99999-4444',
                'cpf_solicitante' => '789.123.456-04',
                'categoria' => 'informacao',
                'assunto' => 'Informações sobre folha de pagamento',
                'descricao' => 'Solicito informações sobre a folha de pagamento dos servidores municipais.',
                'forma_recebimento' => 'email',
                'status' => 'finalizada',
                'data_limite_resposta' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'user_id' => 4,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(25),
            ],
            [
                'protocolo' => 'ESIC-2025-000005',
                'nome_solicitante' => 'Roberto Lima Silva',
                'email_solicitante' => 'roberto.lima@email.com',
                'telefone_solicitante' => '(87) 99999-5555',
                'cpf_solicitante' => '321.654.987-05',
                'categoria' => 'outros',
                'assunto' => 'Informações sobre obras públicas',
                'descricao' => 'Solicito informações sobre o andamento das obras de pavimentação na cidade.',
                'forma_recebimento' => 'presencial',
                'status' => 'negada',
                'data_limite_resposta' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'user_id' => null,
                'created_at' => Carbon::now()->subDays(35),
                'updated_at' => Carbon::now()->subDays(30),
            ],
        ];

        // Inserir as solicitações
        foreach ($solicitacoes as $solicitacao) {
            DB::table('esic_solicitacoes')->insert($solicitacao);
        }

        $this->command->info('Solicitações E-SIC de exemplo criadas com sucesso!');
    }
}