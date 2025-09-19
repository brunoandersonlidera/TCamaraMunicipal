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
        Schema::create('sessao_vereador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sessao_id')->constrained('sessoes')->onDelete('cascade');
            $table->foreignId('vereador_id')->constrained('vereadores')->onDelete('cascade');
            $table->boolean('presente')->default(true);
            $table->string('justificativa_ausencia')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Índices
            $table->unique(['sessao_id', 'vereador_id']);
            $table->index('presente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessao_vereador');
    }
};
