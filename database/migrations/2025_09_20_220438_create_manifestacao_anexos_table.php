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
        Schema::create('manifestacao_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manifestacao_id')->constrained('ouvidoria_manifestacoes')->onDelete('cascade');
            
            // Informações do arquivo
            $table->string('nome_original');
            $table->string('nome_arquivo'); // Nome único no sistema
            $table->string('caminho_arquivo');
            $table->string('tipo_mime');
            $table->string('extensao', 10);
            $table->bigInteger('tamanho_bytes');
            
            // Tipo de anexo
            $table->enum('tipo_anexo', [
                'documento',
                'imagem', 
                'comprovante',
                'evidencia',
                'outros'
            ])->default('documento');
            
            // Controle de acesso
            $table->boolean('publico')->default(false);
            $table->boolean('confidencial')->default(false);
            
            // Hash para verificação de integridade
            $table->string('hash_arquivo', 64);
            
            // Metadados
            $table->text('descricao')->nullable();
            $table->json('metadados')->nullable(); // Para armazenar informações extras como dimensões de imagem
            
            // Auditoria
            $table->string('ip_upload', 45)->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('esic_usuarios')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['manifestacao_id', 'tipo_anexo']);
            $table->index(['nome_arquivo']);
            $table->index(['hash_arquivo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifestacao_anexos');
    }
};
