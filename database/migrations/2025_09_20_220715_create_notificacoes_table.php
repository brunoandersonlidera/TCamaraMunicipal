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
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            
            // Destinatário
            $table->morphs('notificavel'); // Para usuários E-SIC ou ouvidores
            
            // Relacionamento com manifestação (opcional)
            $table->foreignId('manifestacao_id')->nullable()->constrained('ouvidoria_manifestacoes')->onDelete('cascade');
            
            // Tipo de notificação
            $table->enum('tipo', [
                'nova_manifestacao',
                'resposta_manifestacao',
                'prazo_vencendo',
                'prazo_vencido',
                'manifestacao_avaliada',
                'status_alterado',
                'confirmacao_email',
                'recuperacao_senha',
                'sistema_geral'
            ]);
            
            // Conteúdo da notificação
            $table->string('titulo');
            $table->text('mensagem');
            $table->json('dados_extras')->nullable(); // Para dados específicos da notificação
            
            // Canal de envio
            $table->enum('canal', ['sistema', 'email', 'sms', 'push'])->default('sistema');
            
            // Status
            $table->boolean('lida')->default(false);
            $table->timestamp('lida_em')->nullable();
            $table->boolean('enviada')->default(false);
            $table->timestamp('enviada_em')->nullable();
            $table->text('erro_envio')->nullable();
            $table->integer('tentativas_envio')->default(0);
            
            // Prioridade
            $table->enum('prioridade', ['baixa', 'normal', 'alta', 'urgente'])->default('normal');
            
            // Agendamento
            $table->timestamp('agendada_para')->nullable();
            
            // Ações da notificação
            $table->json('acoes')->nullable(); // Botões/links de ação
            $table->string('url_acao')->nullable();
            
            // Expiração
            $table->timestamp('expira_em')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['notificavel_type', 'notificavel_id', 'lida']);
            $table->index(['tipo', 'enviada']);
            $table->index(['agendada_para', 'enviada']);
            $table->index(['manifestacao_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
