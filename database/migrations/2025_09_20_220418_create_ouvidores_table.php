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
        Schema::create('ouvidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('cpf', 14)->unique();
            $table->string('cargo');
            $table->string('setor');
            
            // Tipo de responsabilidade
            $table->enum('tipo', ['ouvidor_geral', 'ouvidor_setorial', 'responsavel_esic', 'equipe_ouvidoria']);
            
            // Permissões específicas
            $table->boolean('pode_gerenciar_esic')->default(false);
            $table->boolean('pode_gerenciar_ouvidoria')->default(false);
            $table->boolean('pode_visualizar_relatorios')->default(true);
            $table->boolean('pode_responder_manifestacoes')->default(true);
            
            // Dados de contato
            $table->string('telefone', 20)->nullable();
            $table->string('ramal', 10)->nullable();
            
            // Status
            $table->boolean('ativo')->default(true);
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            
            // Configurações de notificação
            $table->boolean('recebe_notificacao_email')->default(true);
            $table->boolean('recebe_notificacao_sistema')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['tipo', 'ativo']);
            $table->index(['email', 'ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ouvidores');
    }
};
