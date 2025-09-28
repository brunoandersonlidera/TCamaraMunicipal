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
        Schema::create('leis', function (Blueprint $table) {
            $table->id();
            $table->string('numero'); // Número da lei (ex: 1.485)
            $table->year('exercicio'); // Ano/exercício (ex: 2025)
            $table->date('data'); // Data da lei
            $table->enum('tipo', [
                'Lei Ordinária',
                'Lei Complementar', 
                'Resolução',
                'Decreto Legislativo',
                'Lei Orgânica',
                'Emenda à Lei Orgânica'
            ]); // Tipo da lei
            $table->string('titulo'); // Título da lei
            $table->text('descricao'); // Descrição completa
            $table->string('autoria')->nullable(); // Autoria (ex: Poder Executivo Municipal)
            $table->text('ementa')->nullable(); // Ementa da lei
            $table->string('arquivo_pdf')->nullable(); // Caminho para arquivo PDF
            $table->boolean('ativo')->default(true); // Se a lei está ativa
            $table->text('observacoes')->nullable(); // Observações adicionais
            $table->string('slug')->unique(); // Slug para URLs amigáveis
            $table->timestamps();
            
            // Índices para melhor performance nas buscas
            $table->index(['tipo', 'exercicio']);
            $table->index(['numero', 'exercicio']);
            $table->index('data');
            $table->index('ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leis');
    }
};
