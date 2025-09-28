<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoContrato;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nome' => 'Prestação de Serviços',
                'descricao' => 'Contratos para prestação de serviços diversos à Câmara Municipal',
                'ativo' => true,
            ],
            [
                'nome' => 'Fornecimento de Materiais',
                'descricao' => 'Contratos para fornecimento de materiais de consumo e permanente',
                'ativo' => true,
            ],
            [
                'nome' => 'Locação',
                'descricao' => 'Contratos de locação de bens móveis e imóveis',
                'ativo' => true,
            ],
            [
                'nome' => 'Manutenção',
                'descricao' => 'Contratos para manutenção de equipamentos e instalações',
                'ativo' => true,
            ],
            [
                'nome' => 'Consultoria',
                'descricao' => 'Contratos para serviços de consultoria especializada',
                'ativo' => true,
            ],
            [
                'nome' => 'Obras e Reformas',
                'descricao' => 'Contratos para execução de obras e reformas',
                'ativo' => true,
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoContrato::create($tipo);
        }
    }
}
