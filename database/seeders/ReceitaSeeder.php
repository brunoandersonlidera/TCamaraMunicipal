<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Receita;
use Carbon\Carbon;

class ReceitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $receitas = [];
        
        // Receitas para 2024
        $receitasBase2024 = [
            [
                'codigo_receita' => '1.1.1.2.04.11',
                'descricao' => 'Imposto sobre a Propriedade Predial e Territorial Urbana',
                'categoria' => 'Corrente',
                'subcategoria' => 'Tributária',
                'fonte_recurso' => 'Recursos Próprios',
                'valor_previsto' => 50000.00,
                'ano_referencia' => 2024,
                'status' => 'arrecadado'
            ],
            [
                'codigo_receita' => '1.7.2.1.01.02',
                'descricao' => 'Transferências da União - FPM',
                'categoria' => 'Corrente',
                'subcategoria' => 'Transferências Correntes',
                'fonte_recurso' => 'Transferências da União',
                'valor_previsto' => 800000.00,
                'ano_referencia' => 2024,
                'status' => 'arrecadado'
            ],
            [
                'codigo_receita' => '1.7.2.2.01.01',
                'descricao' => 'Transferências do Estado - ICMS',
                'categoria' => 'Corrente',
                'subcategoria' => 'Transferências Correntes',
                'fonte_recurso' => 'Transferências do Estado',
                'valor_previsto' => 300000.00,
                'ano_referencia' => 2024,
                'status' => 'arrecadado'
            ]
        ];

        // Receitas para 2025
        $receitasBase2025 = [
            [
                'codigo_receita' => '1.1.1.2.04.11',
                'descricao' => 'Imposto sobre a Propriedade Predial e Territorial Urbana',
                'categoria' => 'Corrente',
                'subcategoria' => 'Tributária',
                'fonte_recurso' => 'Recursos Próprios',
                'valor_previsto' => 55000.00,
                'ano_referencia' => 2025,
                'status' => 'previsto'
            ],
            [
                'codigo_receita' => '1.7.2.1.01.02',
                'descricao' => 'Transferências da União - FPM',
                'categoria' => 'Corrente',
                'subcategoria' => 'Transferências Correntes',
                'fonte_recurso' => 'Transferências da União',
                'valor_previsto' => 850000.00,
                'ano_referencia' => 2025,
                'status' => 'previsto'
            ],
            [
                'codigo_receita' => '1.7.2.2.01.01',
                'descricao' => 'Transferências do Estado - ICMS',
                'categoria' => 'Corrente',
                'subcategoria' => 'Transferências Correntes',
                'fonte_recurso' => 'Transferências do Estado',
                'valor_previsto' => 320000.00,
                'ano_referencia' => 2025,
                'status' => 'previsto'
            ]
        ];

        // Gerar receitas mensais para 2024
        foreach ($receitasBase2024 as $receita) {
            for ($mes = 1; $mes <= 12; $mes++) {
                $valorMensal = $receita['valor_previsto'] / 12;
                $valorArrecadado = $valorMensal * (0.8 + (rand(0, 40) / 100)); // Variação de 80% a 120%
                
                $receitas[] = array_merge($receita, [
                    'codigo_receita' => $receita['codigo_receita'] . '.' . str_pad($mes, 2, '0', STR_PAD_LEFT),
                    'mes_referencia' => $mes,
                    'valor_previsto' => $valorMensal,
                    'valor_arrecadado' => $valorArrecadado,
                    'data_arrecadacao' => Carbon::create(2024, $mes, rand(1, 28)),
                ]);
            }
        }

        // Gerar receitas mensais para 2025 (apenas primeiros meses)
        foreach ($receitasBase2025 as $receita) {
            for ($mes = 1; $mes <= 9; $mes++) { // Até setembro de 2025
                $valorMensal = $receita['valor_previsto'] / 12;
                $valorArrecadado = $mes <= 9 ? $valorMensal * (0.85 + (rand(0, 30) / 100)) : 0;
                $status = $mes <= 9 ? 'arrecadado' : 'previsto';
                
                $receitas[] = array_merge($receita, [
                    'codigo_receita' => $receita['codigo_receita'] . '.' . str_pad($mes, 2, '0', STR_PAD_LEFT),
                    'mes_referencia' => $mes,
                    'valor_previsto' => $valorMensal,
                    'valor_arrecadado' => $valorArrecadado,
                    'data_arrecadacao' => $status === 'arrecadado' ? Carbon::create(2025, $mes, rand(1, 28)) : null,
                    'status' => $status
                ]);
            }
        }

        foreach ($receitas as $receita) {
            Receita::create($receita);
        }
    }
}
