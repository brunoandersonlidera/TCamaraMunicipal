<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Despesa;
use Carbon\Carbon;

class DespesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $despesas = [];
        
        // Despesas base para 2024
        $despesasBase2024 = [
            [
                'codigo_despesa' => '3.1.90.11.00',
                'descricao' => 'Vencimentos e Vantagens Fixas - Pessoal Civil',
                'categoria' => 'Corrente',
                'funcao' => 'Administração',
                'subfuncao' => 'Administração Geral',
                'programa' => 'Gestão e Manutenção',
                'elemento_despesa' => 'Pessoal e Encargos Sociais',
                'favorecido' => 'Folha de Pagamento - Servidores',
                'cnpj_cpf_favorecido' => null,
                'modalidade_licitacao' => null,
                'numero_processo' => null,
                'ano_referencia' => 2024
            ],
            [
                'codigo_despesa' => '3.3.90.30.00',
                'descricao' => 'Material de Consumo',
                'categoria' => 'Corrente',
                'funcao' => 'Administração',
                'subfuncao' => 'Administração Geral',
                'programa' => 'Gestão e Manutenção',
                'elemento_despesa' => 'Outras Despesas Correntes',
                'favorecido' => 'Papelaria Central Ltda',
                'cnpj_cpf_favorecido' => '12.345.678/0001-90',
                'modalidade_licitacao' => 'Pregão Eletrônico',
                'numero_processo' => '001/2024',
                'ano_referencia' => 2024
            ],
            [
                'codigo_despesa' => '3.3.90.39.00',
                'descricao' => 'Outros Serviços de Terceiros - Pessoa Jurídica',
                'categoria' => 'Corrente',
                'funcao' => 'Urbanismo',
                'subfuncao' => 'Infraestrutura Urbana',
                'programa' => 'Manutenção da Cidade',
                'elemento_despesa' => 'Outras Despesas Correntes',
                'favorecido' => 'Construtora ABC Ltda',
                'cnpj_cpf_favorecido' => '98.765.432/0001-10',
                'modalidade_licitacao' => 'Tomada de Preços',
                'numero_processo' => '002/2024',
                'ano_referencia' => 2024
            ]
        ];

        // Despesas base para 2025
        $despesasBase2025 = [
            [
                'codigo_despesa' => '3.1.90.11.00',
                'descricao' => 'Vencimentos e Vantagens Fixas - Pessoal Civil',
                'categoria' => 'Corrente',
                'funcao' => 'Administração',
                'subfuncao' => 'Administração Geral',
                'programa' => 'Gestão e Manutenção',
                'elemento_despesa' => 'Pessoal e Encargos Sociais',
                'favorecido' => 'Folha de Pagamento - Servidores',
                'cnpj_cpf_favorecido' => null,
                'modalidade_licitacao' => null,
                'numero_processo' => null,
                'ano_referencia' => 2025
            ],
            [
                'codigo_despesa' => '3.3.90.30.00',
                'descricao' => 'Material de Consumo',
                'categoria' => 'Corrente',
                'funcao' => 'Administração',
                'subfuncao' => 'Administração Geral',
                'programa' => 'Gestão e Manutenção',
                'elemento_despesa' => 'Outras Despesas Correntes',
                'favorecido' => 'Papelaria Central Ltda',
                'cnpj_cpf_favorecido' => '12.345.678/0001-90',
                'modalidade_licitacao' => 'Pregão Eletrônico',
                'numero_processo' => '003/2025',
                'ano_referencia' => 2025
            ]
        ];

        $numeroEmpenho = 1;

        // Gerar despesas mensais para 2024
        foreach ($despesasBase2024 as $despesa) {
            for ($mes = 1; $mes <= 12; $mes++) {
                $valorBase = $despesa['codigo_despesa'] === '3.1.90.11.00' ? 25000 : rand(5000, 15000);
                $valorEmpenhado = $valorBase + rand(-1000, 1000);
                $valorLiquidado = $valorEmpenhado * 0.9; // 90% liquidado
                $valorPago = $valorLiquidado * 0.85; // 85% pago
                
                $dataEmpenho = Carbon::create(2024, $mes, rand(1, 15));
                $dataLiquidacao = $dataEmpenho->copy()->addDays(rand(5, 20));
                $dataPagamento = $dataLiquidacao->copy()->addDays(rand(3, 15));
                
                $despesas[] = array_merge($despesa, [
                    'numero_empenho' => str_pad($numeroEmpenho, 6, '0', STR_PAD_LEFT) . '/2024',
                    'mes_referencia' => $mes,
                    'valor_empenhado' => $valorEmpenhado,
                    'valor_liquidado' => $valorLiquidado,
                    'valor_pago' => $valorPago,
                    'data_empenho' => $dataEmpenho,
                    'data_liquidacao' => $dataLiquidacao,
                    'data_pagamento' => $dataPagamento,
                    'status' => 'pago',
                    'observacoes' => 'Despesa referente ao mês ' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '/2024'
                ]);
                
                $numeroEmpenho++;
            }
        }

        // Gerar despesas mensais para 2025 (até setembro)
        foreach ($despesasBase2025 as $despesa) {
            for ($mes = 1; $mes <= 9; $mes++) {
                $valorBase = $despesa['codigo_despesa'] === '3.1.90.11.00' ? 27000 : rand(5500, 16000);
                $valorEmpenhado = $valorBase + rand(-1000, 1000);
                
                // Status varia conforme o mês
                if ($mes <= 7) {
                    $valorLiquidado = $valorEmpenhado * 0.9;
                    $valorPago = $valorLiquidado * 0.85;
                    $status = 'pago';
                } elseif ($mes <= 8) {
                    $valorLiquidado = $valorEmpenhado * 0.9;
                    $valorPago = 0;
                    $status = 'liquidado';
                } else {
                    $valorLiquidado = 0;
                    $valorPago = 0;
                    $status = 'empenhado';
                }
                
                $dataEmpenho = Carbon::create(2025, $mes, rand(1, 15));
                $dataLiquidacao = $status !== 'empenhado' ? $dataEmpenho->copy()->addDays(rand(5, 20)) : null;
                $dataPagamento = $status === 'pago' ? $dataLiquidacao->copy()->addDays(rand(3, 15)) : null;
                
                $despesas[] = array_merge($despesa, [
                    'numero_empenho' => str_pad($numeroEmpenho, 6, '0', STR_PAD_LEFT) . '/2025',
                    'mes_referencia' => $mes,
                    'valor_empenhado' => $valorEmpenhado,
                    'valor_liquidado' => $valorLiquidado,
                    'valor_pago' => $valorPago,
                    'data_empenho' => $dataEmpenho,
                    'data_liquidacao' => $dataLiquidacao,
                    'data_pagamento' => $dataPagamento,
                    'status' => $status,
                    'observacoes' => 'Despesa referente ao mês ' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '/2025'
                ]);
                
                $numeroEmpenho++;
            }
        }

        foreach ($despesas as $despesa) {
            Despesa::create($despesa);
        }
    }
}
