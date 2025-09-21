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
        Schema::create('carta_servico_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('icone')->nullable();
            $table->string('cor', 7)->default('#007bff'); // Cor hexadecimal
            $table->boolean('ativo')->default(true);
            $table->integer('ordem_exibicao')->default(0);
            $table->timestamps();

            $table->index('ativo');
            $table->index('ordem_exibicao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta_servico_categorias');
    }
};
