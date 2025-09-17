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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['ata', 'lei', 'decreto', 'resolucao', 'portaria', 'edital', 'contrato', 'balancete', 'relatorio', 'outros']);
            $table->string('categoria')->nullable();
            $table->string('arquivo_path');
            $table->string('arquivo_nome_original');
            $table->string('arquivo_mime_type');
            $table->bigInteger('arquivo_tamanho'); // em bytes
            $table->string('numero_documento')->nullable();
            $table->date('data_documento');
            $table->date('data_publicacao')->nullable();
            $table->enum('status', ['rascunho', 'publicado', 'arquivado'])->default('publicado');
            $table->foreignId('usuario_upload_id')->constrained('users');
            $table->integer('downloads')->default(0);
            $table->json('tags')->nullable();
            $table->text('observacoes')->nullable();
            $table->boolean('publico')->default(true);
            $table->string('hash_arquivo')->nullable(); // Para verificação de integridade
            $table->integer('legislatura')->nullable();
            $table->json('metadados')->nullable(); // Metadados adicionais
            $table->timestamps();
            
            $table->index(['tipo', 'status']);
            $table->index(['data_documento', 'publico']);
            $table->index('categoria');
            $table->index('numero_documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
