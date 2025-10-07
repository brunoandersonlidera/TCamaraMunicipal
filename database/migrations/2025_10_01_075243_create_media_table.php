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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->unique(); // Nome único do arquivo
            $table->string('original_name'); // Nome original do arquivo
            $table->string('mime_type'); // Tipo MIME do arquivo
            $table->bigInteger('size'); // Tamanho do arquivo em bytes
            $table->string('path'); // Caminho do arquivo no storage
            $table->string('alt_text')->nullable(); // Texto alternativo para imagens
            $table->string('title')->nullable(); // Título do arquivo
            $table->text('description')->nullable(); // Descrição do arquivo
            $table->string('category')->default('outros'); // Categoria do arquivo
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null'); // Usuário que fez upload
            $table->timestamps();
            
            // Índices para melhor performance
            $table->index(['category']);
            $table->index(['mime_type']);
            $table->index(['uploaded_by']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
