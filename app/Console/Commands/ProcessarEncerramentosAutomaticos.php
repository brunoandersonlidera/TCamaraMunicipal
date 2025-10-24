<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EsicSolicitacao;
use App\Models\EsicMovimentacao;
use Illuminate\Support\Facades\DB;

class ProcessarEncerramentosAutomaticos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esic:processar-encerramentos {--dry-run : Executa sem fazer alterações}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa encerramentos automáticos de solicitações E-SIC que venceram o prazo de 10 dias';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando processamento de encerramentos automáticos...');

        // Buscar solicitações que venceram o prazo de encerramento
        $solicitacoesVencidas = EsicSolicitacao::where('data_limite_encerramento', '<=', now())
            ->where('status', '!=', EsicSolicitacao::STATUS_FINALIZADA)
            ->whereNotNull('data_finalizacao_solicitada')
            ->get();

        if ($solicitacoesVencidas->isEmpty()) {
            $this->info('Nenhuma solicitação encontrada para encerramento automático.');
            return 0;
        }

        $this->info("Encontradas {$solicitacoesVencidas->count()} solicitação(ões) para encerramento automático:");

        $processadas = 0;

        foreach ($solicitacoesVencidas as $solicitacao) {
            $diasVencidos = now()->diffInDays($solicitacao->data_limite_encerramento);
            
            $this->line("- Protocolo: {$solicitacao->protocolo} | Vencida há {$diasVencidos} dia(s)");

            if (!$this->option('dry-run')) {
                try {
                    DB::transaction(function () use ($solicitacao) {
                        // Finalizar a solicitação
                        $solicitacao->finalizar(true);

                        // Adicionar movimentação
                        EsicMovimentacao::create([
                            'esic_solicitacao_id' => $solicitacao->id,
                            'usuario_id' => null, // Sistema
                            'status' => 'finalizada',
                            'descricao' => 'Solicitação encerrada automaticamente pelo sistema após 10 dias corridos sem manifestação do solicitante.',
                            'data_movimentacao' => now(),
                            'ip_usuario' => '127.0.0.1'
                        ]);
                    });

                    $processadas++;
                    $this->info("  ✓ Solicitação {$solicitacao->protocolo} encerrada automaticamente.");

                } catch (\Exception $e) {
                    $this->error("  ✗ Erro ao processar solicitação {$solicitacao->protocolo}: {$e->getMessage()}");
                }
            }
        }

        if ($this->option('dry-run')) {
            $this->warn('Modo dry-run ativo - nenhuma alteração foi feita.');
        } else {
            $this->info("Processamento concluído! {$processadas} solicitação(ões) encerrada(s) automaticamente.");
        }

        return 0;
    }
}
