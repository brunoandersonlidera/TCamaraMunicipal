<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjetoLei;
use Carbon\Carbon;

class TramitacaoTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Atualizar projetos existentes com dados de tramitação
        $projetos = ProjetoLei::all();
        
        foreach ($projetos as $index => $projeto) {
            $statusOptions = [
                'protocolado',
                'em_tramitacao',
                'aprovado',
                'rejeitado',
                'arquivado'
            ];
            
            // Definir status baseado no índice para variedade
            $statusIndex = $index % count($statusOptions);
            $status = $statusOptions[$statusIndex];
            
            // Gerar protocolo automático
            $ano = Carbon::now()->year;
            $numero = str_pad($projeto->numero, 3, '0', STR_PAD_LEFT);
            $protocolo = "PL{$numero}/{$ano}";
            
            // Definir datas baseadas no status
            $dataProtocolo = Carbon::now()->subDays(rand(30, 180));
            $dataStatus = $dataProtocolo->copy()->addDays(rand(1, 30));
            
            $updateData = [
                'status' => $status,
                'protocolo_numero' => $protocolo,
                'protocolo_ano' => $ano,
                'protocolo_sequencial' => $projeto->numero,
            ];
            
            // Adicionar dados específicos baseados no status
            switch ($status) {
                case 'em_tramitacao':
                    $updateData['data_distribuicao'] = $dataStatus->copy()->subDays(rand(1, 10));
                    break;
                    
                case 'aprovado':
                    $updateData['data_primeira_votacao'] = $dataStatus->copy()->subDays(rand(1, 15));
                    $updateData['data_aprovacao'] = $dataStatus;
                    break;
            }
            
            // Criar histórico de tramitação
            $historico = [
                [
                    'data' => $dataProtocolo->format('Y-m-d H:i:s'),
                    'evento' => 'Protocolo',
                    'descricao' => 'Projeto de lei protocolado na Câmara Municipal',
                    'responsavel' => 'Secretaria Legislativa',
                    'status' => 'protocolado'
                ]
            ];
            
            if ($status !== 'protocolado') {
                $historico[] = [
                    'data' => $dataStatus->format('Y-m-d H:i:s'),
                    'evento' => match($status) {
                        'em_tramitacao' => 'Em Tramitação',
                        'aprovado' => 'Aprovado',
                        'rejeitado' => 'Rejeitado',
                        'arquivado' => 'Arquivado',
                        default => 'Atualização de Status'
                    },
                    'descricao' => match($status) {
                        'em_tramitacao' => 'Projeto em tramitação nas comissões',
                        'aprovado' => 'Projeto aprovado pelo plenário',
                        'rejeitado' => 'Projeto rejeitado pelos vereadores',
                        'arquivado' => 'Projeto arquivado',
                        default => 'Status do projeto atualizado'
                    },
                    'responsavel' => match($status) {
                        'em_tramitacao' => 'Comissão Competente',
                        'aprovado', 'rejeitado' => 'Plenário',
                        'arquivado' => 'Mesa Diretora',
                        default => 'Sistema'
                    },
                    'status' => $status
                ];
            }
            
            $updateData['historico_tramitacao'] = json_encode($historico);
            
            // Adicionar consulta pública para alguns projetos em tramitação
            if ($status === 'em_tramitacao' && rand(0, 1)) {
                $updateData['consulta_publica_ativa'] = true;
                $updateData['data_inicio_consulta'] = $dataStatus->copy()->subDays(rand(5, 15));
                $updateData['data_fim_consulta'] = $updateData['data_inicio_consulta']->copy()->addDays(rand(15, 30));
                $updateData['permite_participacao_cidada'] = true;
            }
            
            $projeto->update($updateData);
        }
        
        $this->command->info('Dados de tramitação adicionados com sucesso!');
    }
}
