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
        Schema::create('sessao_projeto_lei', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sessao_id')->constrained('sessoes')->onDelete('cascade');
            $table->foreignId('projeto_lei_id')->constrained('projetos_lei')->onDelete('cascade');
            $table->integer('ordem_pauta')->nullable();
            $table->string('resultado_votacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Índices
            $table->unique(['sessao_id', 'projeto_lei_id']);
            $table->index('ordem_pauta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessao_projeto_lei');
    }
};
