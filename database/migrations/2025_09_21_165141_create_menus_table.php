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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->string('url')->nullable();
            $table->string('rota')->nullable();
            $table->string('icone')->nullable();
            $table->enum('posicao', ['header', 'footer', 'ambos'])->default('header');
            $table->enum('tipo', ['link', 'dropdown', 'divider'])->default('link');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->boolean('nova_aba')->default(false);
            $table->string('permissao')->nullable(); // Para controle de acesso
            $table->text('descricao')->nullable();
            $table->json('configuracoes')->nullable(); // Para configurações extras
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
            $table->index(['posicao', 'ativo', 'ordem']);
            $table->index(['parent_id', 'ordem']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
