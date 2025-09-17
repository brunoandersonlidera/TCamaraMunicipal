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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('resumo');
            $table->longText('conteudo');
            $table->string('imagem_destaque')->nullable();
            $table->json('galeria_imagens')->nullable();
            $table->foreignId('autor_id')->constrained('users');
            $table->enum('status', ['rascunho', 'publicado', 'arquivado'])->default('rascunho');
            $table->boolean('destaque')->default(false);
            $table->integer('visualizacoes')->default(0);
            $table->json('tags')->nullable();
            $table->string('categoria')->nullable();
            $table->timestamp('data_publicacao')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'data_publicacao']);
            $table->index(['destaque', 'status']);
            $table->index('categoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
