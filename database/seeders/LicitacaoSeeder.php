<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Licitacao;
use Carbon\Carbon;

class LicitacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $licitacoes = [
            [
                'numero_processo' => '001/2025',
                'numero_edital' => 'ED-001/2025',
                'modalidade' => 'Pregão Eletrônico',
                'tipo' => 'Menor Preço',
                'objeto' => 'Aquisição de material de escritório para a Câmara Municipal',
                'descricao_detalhada' => 'Aquisição de materiais de escritório diversos incluindo papel A4, canetas, lápis, grampeadores e outros itens de papelaria.',
                'valor_estimado' => 15000.00,
                'valor_homologado' => 14500.00,
                'data_abertura' => Carbon::now()->subDays(30),
                'data_publicacao' => Carbon::now()->subDays(35),
                'data_homologacao' => Carbon::now()->subDays(25),
                'local_abertura' => 'Sala de Licitações - Câmara Municipal',
                'responsavel' => 'João Silva - Pregoeiro',
                'vencedor' => 'Papelaria Central Ltda',
                'cnpj_vencedor' => '12.345.678/0001-90',
                'valor_vencedor' => 14500.00,
                'ano_referencia' => 2025,
                'status' => 'homologado',
                'observacoes' => 'Licitação concluída com sucesso.'
            ],
            [
                'numero_processo' => '002/2025',
                'numero_edital' => 'ED-002/2025',
                'modalidade' => 'Tomada de Preços',
                'tipo' => 'Menor Preço',
                'objeto' => 'Contratação de serviços de limpeza e conservação',
                'descricao_detalhada' => 'Contratação de empresa especializada em serviços de limpeza e conservação das dependências da Câmara Municipal.',
                'valor_estimado' => 120000.00,
                'data_abertura' => Carbon::now()->addDays(15),
                'data_publicacao' => Carbon::now()->subDays(10),
                'local_abertura' => 'Sala de Licitações - Câmara Municipal',
                'responsavel' => 'Maria Santos - Pregoeira',
                'ano_referencia' => 2025,
                'status' => 'em_andamento',
                'observacoes' => 'Processo em fase de análise das propostas.'
            ],
            [
                'numero_processo' => '003/2025',
                'numero_edital' => 'ED-003/2025',
                'modalidade' => 'Pregão Presencial',
                'tipo' => 'Menor Preço',
                'objeto' => 'Aquisição de equipamentos de informática',
                'descricao_detalhada' => 'Aquisição de computadores, impressoras e equipamentos de rede para modernização do parque tecnológico.',
                'valor_estimado' => 85000.00,
                'data_abertura' => Carbon::now()->addDays(30),
                'data_publicacao' => Carbon::now()->subDays(5),
                'local_abertura' => 'Plenário da Câmara Municipal',
                'responsavel' => 'Carlos Oliveira - Pregoeiro',
                'ano_referencia' => 2025,
                'status' => 'publicado',
                'observacoes' => 'Edital publicado, aguardando propostas.'
            ],
            [
                'numero_processo' => '004/2024',
                'numero_edital' => 'ED-015/2024',
                'modalidade' => 'Concorrência',
                'tipo' => 'Menor Preço',
                'objeto' => 'Reforma do plenário da Câmara Municipal',
                'descricao_detalhada' => 'Reforma completa do plenário incluindo sistema de som, iluminação e mobiliário.',
                'valor_estimado' => 250000.00,
                'valor_homologado' => 235000.00,
                'data_abertura' => Carbon::now()->subDays(90),
                'data_publicacao' => Carbon::now()->subDays(95),
                'data_homologacao' => Carbon::now()->subDays(80),
                'local_abertura' => 'Sala de Licitações - Câmara Municipal',
                'responsavel' => 'Ana Costa - Presidente da Comissão',
                'vencedor' => 'Construtora Municipal Ltda',
                'cnpj_vencedor' => '98.765.432/0001-10',
                'valor_vencedor' => 235000.00,
                'ano_referencia' => 2024,
                'status' => 'homologado',
                'observacoes' => 'Obra concluída dentro do prazo estabelecido.'
            ],
            [
                'numero_processo' => '005/2025',
                'numero_edital' => 'ED-004/2025',
                'modalidade' => 'Pregão Eletrônico',
                'tipo' => 'Menor Preço',
                'objeto' => 'Contratação de serviços de segurança patrimonial',
                'descricao_detalhada' => 'Contratação de empresa para prestação de serviços de segurança patrimonial 24 horas.',
                'valor_estimado' => 180000.00,
                'data_abertura' => Carbon::now()->addDays(20),
                'data_publicacao' => Carbon::now()->subDays(3),
                'local_abertura' => 'Portal de Compras Eletrônicas',
                'responsavel' => 'Pedro Almeida - Pregoeiro',
                'ano_referencia' => 2025,
                'status' => 'publicado',
                'observacoes' => 'Licitação eletrônica em andamento.'
            ]
        ];

        foreach ($licitacoes as $licitacao) {
            Licitacao::create($licitacao);
        }
    }
}
