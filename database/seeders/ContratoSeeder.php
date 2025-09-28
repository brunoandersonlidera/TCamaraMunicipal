<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contrato;
use App\Models\TipoContrato;
use Carbon\Carbon;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoServicos = TipoContrato::where('nome', 'Prestação de Serviços')->first();
        $tipoMateriais = TipoContrato::where('nome', 'Fornecimento de Materiais')->first();
        $tipoLocacao = TipoContrato::where('nome', 'Locação')->first();
        $tipoManutencao = TipoContrato::where('nome', 'Manutenção')->first();

        $contratos = [
            [
                'numero' => '001/2024',
                'tipo_contrato_id' => $tipoServicos->id,
                'objeto' => 'Prestação de serviços de limpeza e conservação das dependências da Câmara Municipal',
                'contratado' => 'Empresa de Limpeza Modelo Ltda',
                'cnpj_cpf_contratado' => '12.345.678/0001-90',
                'valor_inicial' => 50000.00,
                'valor_atual' => 50000.00,
                'data_assinatura' => Carbon::create(2024, 1, 15),
                'data_inicio' => Carbon::create(2024, 2, 1),
                'data_fim' => Carbon::create(2025, 1, 31),
                'ano_referencia' => 2024,
                'observacoes' => 'Contrato com renovação automática por igual período.',
                'publico' => true,
            ],
            [
                'numero' => '002/2024',
                'tipo_contrato_id' => $tipoMateriais->id,
                'objeto' => 'Fornecimento de materiais de escritório e expediente',
                'contratado' => 'Papelaria Central Ltda',
                'cnpj_cpf_contratado' => '98.765.432/0001-10',
                'valor_inicial' => 25000.00,
                'valor_atual' => 27500.00,
                'data_assinatura' => Carbon::create(2024, 3, 10),
                'data_inicio' => Carbon::create(2024, 3, 15),
                'data_fim' => Carbon::create(2024, 12, 31),
                'ano_referencia' => 2024,
                'observacoes' => 'Valor atualizado por aditivo em junho/2024.',
                'publico' => true,
            ],
            [
                'numero' => '003/2024',
                'tipo_contrato_id' => $tipoLocacao->id,
                'objeto' => 'Locação de equipamentos de informática',
                'contratado' => 'TechRent Equipamentos',
                'cnpj_cpf_contratado' => '11.222.333/0001-44',
                'valor_inicial' => 15000.00,
                'valor_atual' => 15000.00,
                'data_assinatura' => Carbon::create(2024, 4, 5),
                'data_inicio' => Carbon::create(2024, 4, 10),
                'data_fim' => Carbon::create(2025, 4, 9),
                'ano_referencia' => 2024,
                'observacoes' => 'Inclui manutenção preventiva e corretiva.',
                'publico' => true,
            ],
            [
                'numero' => '004/2024',
                'tipo_contrato_id' => $tipoManutencao->id,
                'objeto' => 'Manutenção do sistema de ar condicionado',
                'contratado' => 'Clima Perfeito Manutenções',
                'cnpj_cpf_contratado' => '55.666.777/0001-88',
                'valor_inicial' => 8000.00,
                'valor_atual' => 8000.00,
                'data_assinatura' => Carbon::create(2024, 5, 20),
                'data_inicio' => Carbon::create(2024, 6, 1),
                'data_fim' => Carbon::create(2024, 11, 30),
                'ano_referencia' => 2024,
                'observacoes' => 'Manutenção preventiva trimestral.',
                'publico' => false,
            ],
            [
                'numero' => '005/2024',
                'tipo_contrato_id' => $tipoServicos->id,
                'objeto' => 'Serviços de segurança patrimonial',
                'contratado' => 'Segurança Total Ltda',
                'cnpj_cpf_contratado' => '33.444.555/0001-66',
                'valor_inicial' => 120000.00,
                'valor_atual' => 120000.00,
                'data_assinatura' => Carbon::create(2024, 6, 15),
                'data_inicio' => Carbon::create(2024, 7, 1),
                'data_fim' => Carbon::create(2025, 6, 30),
                'ano_referencia' => 2024,
                'observacoes' => 'Cobertura 24 horas com 2 vigilantes por turno.',
                'publico' => true,
            ],
            [
                'numero' => '006/2023',
                'tipo_contrato_id' => $tipoServicos->id,
                'objeto' => 'Prestação de serviços de jardinagem',
                'contratado' => 'Verde Vida Paisagismo',
                'cnpj_cpf_contratado' => '77.888.999/0001-22',
                'valor_inicial' => 12000.00,
                'valor_atual' => 12000.00,
                'data_assinatura' => Carbon::create(2023, 8, 10),
                'data_inicio' => Carbon::create(2023, 9, 1),
                'data_fim' => Carbon::create(2024, 8, 31),
                'ano_referencia' => 2023,
                'observacoes' => 'Contrato vencido - não renovado.',
                'publico' => true,
            ],
        ];

        foreach ($contratos as $contrato) {
            Contrato::create($contrato);
        }
    }
}
