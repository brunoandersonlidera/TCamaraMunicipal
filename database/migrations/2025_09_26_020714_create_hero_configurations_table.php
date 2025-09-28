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
        Schema::create('hero_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->default('Câmara Municipal');
            $table->text('descricao')->default('Transparência, participação e representação democrática para nossa cidade.');
            $table->string('botao_primario_texto')->default('Transparência');
            $table->string('botao_primario_link')->default('/transparencia');
            $table->boolean('botao_primario_nova_aba')->default(false);
            $table->string('botao_secundario_texto')->default('Vereadores');
            $table->string('botao_secundario_link')->default('/vereadores');
            $table->boolean('botao_secundario_nova_aba')->default(false);
            $table->boolean('mostrar_slider')->default(true);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_configurations');
    }
};
