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
        Schema::create('paginas_conteudo', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // identificador único da página (historia, estrutura, etc)
            $table->string('titulo'); // título da página
            $table->text('descricao')->nullable(); // descrição breve da página
            $table->longText('conteudo'); // conteúdo HTML da página
            $table->json('configuracoes')->nullable(); // configurações extras (meta tags, etc)
            $table->boolean('ativo')->default(true); // se a página está ativa
            $table->integer('ordem')->default(0); // ordem de exibição
            $table->string('template')->default('default'); // template a ser usado
            $table->json('seo')->nullable(); // dados de SEO (meta description, keywords, etc)
            $table->timestamps();
            $table->softDeletes(); // para soft delete
            
            // Índices para performance
            $table->index('slug');
            $table->index('ativo');
            $table->index('ordem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paginas_conteudo');
    }
};
