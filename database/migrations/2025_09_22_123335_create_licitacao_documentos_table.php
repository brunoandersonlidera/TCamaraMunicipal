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
        Schema::create('licitacao_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licitacao_id')->constrained('licitacoes')->onDelete('cascade');
            $table->string('nome'); // Nome do documento
            $table->string('descricao')->nullable(); // Descrição opcional
            $table->string('arquivo'); // Nome do arquivo no storage
            $table->string('arquivo_original'); // Nome original do arquivo
            $table->string('tipo_mime'); // Tipo MIME do arquivo
            $table->integer('tamanho'); // Tamanho em bytes
            $table->enum('tipo_documento', [
                'edital',
                'anexo_edital', 
                'ata_abertura',
                'ata_julgamento',
                'resultado',
                'contrato',
                'termo_referencia',
                'projeto_basico',
                'outros'
            ])->default('outros');
            $table->boolean('publico')->default(true); // Se está disponível para o público
            $table->integer('ordem')->default(0); // Ordem de exibição
            $table->timestamps();
            
            // Índices para performance
            $table->index(['licitacao_id', 'publico']);
            $table->index(['tipo_documento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licitacao_documentos');
    }
};
