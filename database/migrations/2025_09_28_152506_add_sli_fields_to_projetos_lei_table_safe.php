<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projetos_lei', function (Blueprint $table) {
            // Campos de protocolo - verificar se não existem
            if (!Schema::hasColumn('projetos_lei', 'protocolo_numero')) {
                $table->string('protocolo_numero')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'protocolo_ano')) {
                $table->integer('protocolo_ano')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'protocolo_sequencial')) {
                $table->integer('protocolo_sequencial')->nullable();
            }
            
            // Datas de tramitação
            if (!Schema::hasColumn('projetos_lei', 'data_distribuicao')) {
                $table->date('data_distribuicao')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_primeira_votacao')) {
                $table->date('data_primeira_votacao')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_segunda_votacao')) {
                $table->date('data_segunda_votacao')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_envio_executivo')) {
                $table->date('data_envio_executivo')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_retorno_executivo')) {
                $table->date('data_retorno_executivo')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_veto')) {
                $table->date('data_veto')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_promulgacao')) {
                $table->date('data_promulgacao')->nullable();
            }
            
            // Consulta pública
            if (!Schema::hasColumn('projetos_lei', 'prazo_consulta_publica')) {
                $table->integer('prazo_consulta_publica')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_inicio_consulta')) {
                $table->date('data_inicio_consulta')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'data_fim_consulta')) {
                $table->date('data_fim_consulta')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'participacao_cidada')) {
                $table->json('participacao_cidada')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'termometro_popular')) {
                $table->json('termometro_popular')->nullable();
            }
            
            // Impacto e relatórios
            if (!Schema::hasColumn('projetos_lei', 'impacto_orcamentario')) {
                $table->decimal('impacto_orcamentario', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'relatorio_impacto')) {
                $table->json('relatorio_impacto')->nullable();
            }
            
            // Votação
            if (!Schema::hasColumn('projetos_lei', 'quorum_necessario')) {
                $table->integer('quorum_necessario')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'votos_favoraveis')) {
                $table->integer('votos_favoraveis')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'votos_contrarios')) {
                $table->integer('votos_contrarios')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'abstencoes')) {
                $table->integer('abstencoes')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'ausencias')) {
                $table->integer('ausencias')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'resultado_primeira_votacao')) {
                $table->json('resultado_primeira_votacao')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'resultado_segunda_votacao')) {
                $table->json('resultado_segunda_votacao')->nullable();
            }
            
            // Veto e pareceres
            if (!Schema::hasColumn('projetos_lei', 'motivo_veto')) {
                $table->text('motivo_veto')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'fundamentacao_veto')) {
                $table->text('fundamentacao_veto')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'parecer_tecnico')) {
                $table->text('parecer_tecnico')->nullable();
            }
            
            // Documentos e histórico
            if (!Schema::hasColumn('projetos_lei', 'audiencias_publicas')) {
                $table->json('audiencias_publicas')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'emendas_apresentadas')) {
                $table->json('emendas_apresentadas')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'substitutivos')) {
                $table->json('substitutivos')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'historico_tramitacao')) {
                $table->json('historico_tramitacao')->nullable();
            }
            if (!Schema::hasColumn('projetos_lei', 'documentos_anexos')) {
                $table->json('documentos_anexos')->nullable();
            }
            
            // Flags de controle
            if (!Schema::hasColumn('projetos_lei', 'consulta_publica_ativa')) {
                $table->boolean('consulta_publica_ativa')->default(false);
            }
            if (!Schema::hasColumn('projetos_lei', 'permite_participacao_cidada')) {
                $table->boolean('permite_participacao_cidada')->default(true);
            }
            if (!Schema::hasColumn('projetos_lei', 'exige_audiencia_publica')) {
                $table->boolean('exige_audiencia_publica')->default(false);
            }
            if (!Schema::hasColumn('projetos_lei', 'exige_maioria_absoluta')) {
                $table->boolean('exige_maioria_absoluta')->default(false);
            }
            if (!Schema::hasColumn('projetos_lei', 'exige_dois_turnos')) {
                $table->boolean('exige_dois_turnos')->default(false);
            }
            if (!Schema::hasColumn('projetos_lei', 'bypass_executivo')) {
                $table->boolean('bypass_executivo')->default(false);
            }
        });
        
        // Adicionar índices se não existirem
        try {
            Schema::table('projetos_lei', function (Blueprint $table) {
                $table->index(['protocolo_ano', 'tipo'], 'idx_protocolo_ano_tipo');
                $table->index(['status', 'data_protocolo'], 'idx_status_data_protocolo');
                $table->index('consulta_publica_ativa', 'idx_consulta_publica_ativa');
            });
        } catch (\Exception $e) {
            // Índices já existem, ignorar
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projetos_lei', function (Blueprint $table) {
            // Remove índices se existirem
            try {
                $table->dropIndex('idx_protocolo_ano_tipo');
                $table->dropIndex('idx_status_data_protocolo');
                $table->dropIndex('idx_consulta_publica_ativa');
            } catch (\Exception $e) {
                // Índices não existem, ignorar
            }
            
            // Remove campos se existirem
            $campos = [
                'protocolo_numero', 'protocolo_ano', 'protocolo_sequencial',
                'data_distribuicao', 'data_primeira_votacao', 'data_segunda_votacao',
                'data_envio_executivo', 'data_retorno_executivo', 'data_veto', 'data_promulgacao',
                'prazo_consulta_publica', 'data_inicio_consulta', 'data_fim_consulta',
                'participacao_cidada', 'termometro_popular', 'impacto_orcamentario', 'relatorio_impacto',
                'quorum_necessario', 'votos_favoraveis', 'votos_contrarios', 'abstencoes', 'ausencias',
                'resultado_primeira_votacao', 'resultado_segunda_votacao',
                'motivo_veto', 'fundamentacao_veto', 'parecer_tecnico',
                'audiencias_publicas', 'emendas_apresentadas', 'substitutivos',
                'historico_tramitacao', 'documentos_anexos',
                'consulta_publica_ativa', 'permite_participacao_cidada', 'exige_audiencia_publica',
                'exige_maioria_absoluta', 'exige_dois_turnos', 'bypass_executivo'
            ];
            
            foreach ($campos as $campo) {
                if (Schema::hasColumn('projetos_lei', $campo)) {
                    $table->dropColumn($campo);
                }
            }
        });
    }
};
