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
        Schema::create('licitacoes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_processo')->unique(); // Número do processo licitatório
            $table->string('numero_edital')->nullable(); // Número do edital
            $table->string('modalidade'); // Modalidade (Pregão, Concorrência, etc.)
            $table->string('tipo'); // Tipo (Menor Preço, Melhor Técnica, etc.)
            $table->string('objeto'); // Objeto da licitação
            $table->text('descricao_detalhada')->nullable(); // Descrição detalhada
            $table->decimal('valor_estimado', 15, 2)->nullable(); // Valor estimado
            $table->decimal('valor_homologado', 15, 2)->nullable(); // Valor homologado
            $table->date('data_abertura'); // Data de abertura
            $table->datetime('data_hora_abertura')->nullable(); // Data e hora específica
            $table->date('data_homologacao')->nullable(); // Data de homologação
            $table->string('local_abertura')->nullable(); // Local de abertura
            $table->string('responsavel')->nullable(); // Responsável pela licitação
            $table->string('vencedor')->nullable(); // Empresa vencedora
            $table->string('cnpj_vencedor')->nullable(); // CNPJ da empresa vencedora
            $table->decimal('valor_vencedor', 15, 2)->nullable(); // Valor da proposta vencedora
            $table->string('arquivo_edital')->nullable(); // Caminho do arquivo do edital
            $table->string('arquivo_resultado')->nullable(); // Caminho do arquivo de resultado
            $table->integer('ano_referencia'); // Ano de referência
            $table->text('observacoes')->nullable(); // Observações
            $table->enum('status', ['publicado', 'em_andamento', 'homologado', 'deserto', 'fracassado', 'cancelado'])->default('publicado');
            $table->timestamps();
            
            // Índices para otimização
            $table->index('ano_referencia');
            $table->index('modalidade');
            $table->index('status');
            $table->index('data_abertura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licitacoes');
    }
};
