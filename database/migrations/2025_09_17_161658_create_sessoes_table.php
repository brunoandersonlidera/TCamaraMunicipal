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
        Schema::create('sessoes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_sessao');
            $table->enum('tipo', ['ordinaria', 'extraordinaria', 'solene', 'especial']);
            $table->date('data_sessao');
            $table->time('hora_inicio');
            $table->time('hora_fim')->nullable();
            $table->enum('status', ['agendada', 'em_andamento', 'finalizada', 'cancelada'])->default('agendada');
            $table->text('pauta')->nullable();
            $table->longText('ata')->nullable();
            $table->string('local')->default('Plenário da Câmara Municipal');
            $table->json('presencas')->nullable(); // IDs dos vereadores presentes
            $table->json('votacoes')->nullable(); // Resultados das votações
            $table->string('arquivo_ata')->nullable();
            $table->string('arquivo_audio')->nullable();
            $table->string('arquivo_video')->nullable();
            $table->text('observacoes')->nullable();
            $table->integer('legislatura');
            $table->boolean('transmissao_online')->default(false);
            $table->string('link_transmissao')->nullable();
            $table->timestamps();
            
            $table->index(['data_sessao', 'tipo']);
            $table->index(['status', 'legislatura']);
            $table->unique(['numero_sessao', 'legislatura']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessoes');
    }
};
