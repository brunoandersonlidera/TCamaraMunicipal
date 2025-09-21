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
        Schema::create('ouvidoria_manifestacoes', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo', 20)->unique();
            
            // Relacionamentos
            $table->foreignId('esic_usuario_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('ouvidor_responsavel_id')->nullable()->constrained('ouvidores')->onDelete('set null');
            
            // Tipo de manifestação
            $table->enum('tipo', [
                'solicitacao_informacao', // E-SIC
                'reclamacao',
                'sugestao', 
                'elogio',
                'denuncia',
                'ouvidoria_geral'
            ]);
            
            // Dados do manifestante (pode ser anônimo)
            $table->string('nome_manifestante')->nullable();
            $table->string('email_manifestante')->nullable();
            $table->string('telefone_manifestante')->nullable();
            $table->boolean('manifestacao_anonima')->default(false);
            
            // Conteúdo da manifestação
            $table->string('assunto');
            $table->text('descricao');
            $table->string('orgao_destinatario')->nullable();
            $table->string('setor_destinatario')->nullable();
            
            // Classificação E-SIC
            $table->enum('categoria_esic', [
                'acesso_informacao',
                'dados_pessoais', 
                'transparencia_ativa',
                'transparencia_passiva',
                'outros'
            ])->nullable();
            
            // Status e tramitação
            $table->enum('status', [
                'nova',
                'em_analise',
                'em_tramitacao',
                'aguardando_informacoes',
                'respondida',
                'finalizada',
                'arquivada'
            ])->default('nova');
            
            // Prazos (conforme LAI)
            $table->date('prazo_resposta');
            $table->date('prazo_prorrogado')->nullable();
            $table->text('justificativa_prorrogacao')->nullable();
            
            // Resposta
            $table->text('resposta')->nullable();
            $table->timestamp('respondida_em')->nullable();
            $table->foreignId('respondida_por')->nullable()->constrained('ouvidores')->onDelete('set null');
            
            // Avaliação do cidadão
            $table->integer('avaliacao_atendimento')->nullable(); // 1-5
            $table->text('comentario_avaliacao')->nullable();
            $table->timestamp('avaliada_em')->nullable();
            
            // Controle de qualidade
            $table->enum('prioridade', ['baixa', 'media', 'alta', 'urgente'])->default('media');
            $table->boolean('requer_resposta')->default(true);
            $table->boolean('informacao_sigilosa')->default(false);
            $table->text('observacoes_internas')->nullable();
            
            // Auditoria
            $table->string('ip_origem', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->json('historico_status')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['protocolo']);
            $table->index(['tipo', 'status']);
            $table->index(['status', 'prazo_resposta']);
            $table->index(['esic_usuario_id', 'status']);
            $table->index(['created_at', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ouvidoria_manifestacoes');
    }
};
