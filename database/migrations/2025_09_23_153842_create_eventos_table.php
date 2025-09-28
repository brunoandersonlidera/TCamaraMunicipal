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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', [
                'sessao_plenaria',
                'audiencia_publica', 
                'reuniao_comissao',
                'votacao',
                'licitacao',
                'agenda_vereador',
                'ato_vereador',
                'data_comemorativa',
                'prazo_esic',
                'outro'
            ]);
            $table->date('data_evento');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fim')->nullable();
            $table->string('local')->nullable();
            $table->text('observacoes')->nullable();
            $table->boolean('destaque')->default(false);
            $table->string('cor_destaque', 7)->default('#007bff'); // Cor hexadecimal
            $table->boolean('ativo')->default(true);
            $table->unsignedBigInteger('vereador_id')->nullable();
            $table->unsignedBigInteger('sessao_id')->nullable();
            $table->unsignedBigInteger('licitacao_id')->nullable();
            $table->unsignedBigInteger('esic_solicitacao_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Usuário que criou
            $table->timestamps();

            // Índices para performance
            $table->index('data_evento');
            $table->index('tipo');
            $table->index(['data_evento', 'tipo']);
            $table->index(['ativo', 'data_evento']);
            
            // Chaves estrangeiras
            $table->foreign('vereador_id')->references('id')->on('vereadores')->onDelete('set null');
            $table->foreign('sessao_id')->references('id')->on('sessoes')->onDelete('set null');
            $table->foreign('licitacao_id')->references('id')->on('licitacoes')->onDelete('set null');
            $table->foreign('esic_solicitacao_id')->references('id')->on('esic_solicitacoes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
