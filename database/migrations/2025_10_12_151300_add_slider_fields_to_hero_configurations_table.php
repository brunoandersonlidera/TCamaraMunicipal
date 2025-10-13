<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hero_configurations', function (Blueprint $table) {
            // Configurações de slider/hero
            $table->integer('intervalo')->default(5000)->after('imagem_descricao_id');
            $table->string('transicao')->default('slide')->after('intervalo');
            $table->boolean('autoplay')->default(true)->after('transicao');
            $table->boolean('pausar_hover')->default(true)->after('autoplay');
            $table->boolean('mostrar_indicadores')->default(true)->after('pausar_hover');
            $table->boolean('mostrar_controles')->default(true)->after('mostrar_indicadores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_configurations', function (Blueprint $table) {
            $table->dropColumn([
                'intervalo',
                'transicao',
                'autoplay',
                'pausar_hover',
                'mostrar_indicadores',
                'mostrar_controles',
            ]);
        });
    }
};