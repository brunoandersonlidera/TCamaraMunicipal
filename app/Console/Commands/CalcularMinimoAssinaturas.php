<?php

namespace App\Console\Commands;

use App\Services\IniciativaPopularService;
use Illuminate\Console\Command;

class CalcularMinimoAssinaturas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projeto-lei:calcular-minimo-assinaturas 
                            {eleitorado? : Número de eleitores do município}
                            {--percentual= : Percentual do eleitorado (ex: 0.01 para 1%)}
                            {--mostrar-requisitos : Mostrar todos os requisitos para iniciativa popular}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcular o mínimo de assinaturas necessárias para projetos de iniciativa popular';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('mostrar-requisitos')) {
            $this->mostrarRequisitos();
            return;
        }

        $eleitorado = $this->argument('eleitorado');
        $percentual = $this->option('percentual');

        if ($eleitorado) {
            $eleitorado = (int) $eleitorado;
            
            if ($eleitorado <= 0) {
                $this->error('O número de eleitores deve ser maior que zero.');
                return 1;
            }

            // Atualizar percentual se fornecido
            if ($percentual) {
                $percentual = (float) $percentual;
                if ($percentual <= 0 || $percentual > 1) {
                    $this->error('O percentual deve estar entre 0.001 (0.1%) e 1 (100%).');
                    return 1;
                }
                config(['projeto_lei.iniciativa_popular.percentual_eleitorado' => $percentual]);
            }

            $minimoCalculado = IniciativaPopularService::calcularMinimoAssinaturas($eleitorado);
            
            $this->info("📊 Cálculo do Mínimo de Assinaturas");
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("🗳️  Eleitorado municipal: " . number_format($eleitorado, 0, ',', '.'));
            $this->line("📈 Percentual aplicado: " . (config('projeto_lei.iniciativa_popular.percentual_eleitorado') * 100) . "%");
            $this->line("⚖️  Mínimo legal: " . number_format(config('projeto_lei.iniciativa_popular.minimo_legal'), 0, ',', '.'));
            $this->line("✅ Mínimo necessário: " . number_format($minimoCalculado, 0, ',', '.') . " assinaturas");
            
        } else {
            $minimoPadrao = config('projeto_lei.iniciativa_popular.minimo_assinaturas_padrao');
            $minimoLegal = config('projeto_lei.iniciativa_popular.minimo_legal');
            
            $this->info("📊 Configuração Atual - Mínimo de Assinaturas");
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("⚖️  Mínimo legal: " . number_format($minimoLegal, 0, ',', '.'));
            $this->line("📋 Mínimo padrão: " . number_format($minimoPadrao, 0, ',', '.'));
            $this->line("📈 Percentual do eleitorado: " . (config('projeto_lei.iniciativa_popular.percentual_eleitorado') * 100) . "%");
            $this->line("");
            $this->comment("💡 Para calcular com base no eleitorado específico:");
            $this->comment("   php artisan projeto-lei:calcular-minimo-assinaturas [número_de_eleitores]");
        }

        return 0;
    }

    /**
     * Mostrar todos os requisitos para iniciativa popular
     */
    private function mostrarRequisitos()
    {
        $requisitos = IniciativaPopularService::obterRequisitos();

        $this->info("📋 Requisitos para Projetos de Iniciativa Popular");
        $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        $this->line("📊 Assinaturas:");
        $this->line("   • Mínimo legal: " . number_format($requisitos['minimo_legal'], 0, ',', '.'));
        $this->line("   • Mínimo padrão: " . number_format($requisitos['minimo_padrao'], 0, ',', '.'));
        $this->line("   • Percentual do eleitorado: " . ($requisitos['percentual_eleitorado'] * 100) . "%");
        
        $this->line("");
        $this->line("⏰ Prazo para coleta: " . $requisitos['prazo_coleta_dias'] . " dias");
        
        $this->line("");
        $this->line("📄 Documentos necessários:");
        foreach ($requisitos['documentos_necessarios'] as $documento) {
            $this->line("   • " . $documento);
        }

        $this->line("");
        $this->comment("💡 Dicas importantes:");
        $this->comment("   • Verificar a legislação municipal específica");
        $this->comment("   • Manter registro de todas as assinaturas coletadas");
        $this->comment("   • Validar dados dos eleitores antes do protocolo");
    }
}
