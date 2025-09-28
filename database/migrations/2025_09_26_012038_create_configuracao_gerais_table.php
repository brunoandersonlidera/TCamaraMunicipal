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
        Schema::create('configuracao_gerais', function (Blueprint $table) {
            $table->id();
            $table->string('chave')->unique(); // Chave única para identificar a configuração
            $table->text('valor')->nullable(); // Valor da configuração
            $table->string('tipo')->default('texto'); // tipo: texto, imagem, email, telefone
            $table->text('descricao')->nullable(); // Descrição da configuração
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracao_gerais');
    }
};
