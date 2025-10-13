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
            // Largura máxima para a imagem da descrição (px)
            $table->unsignedInteger('imagem_descricao_largura_px')->nullable()->after('imagem_descricao_altura_px');
            // Centralizar imagem da descrição (alinhamento do bloco)
            $table->boolean('centralizar_imagem_descricao')->default(false)->after('imagem_descricao_largura_px');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_configurations', function (Blueprint $table) {
            $table->dropColumn(['imagem_descricao_largura_px', 'centralizar_imagem_descricao']);
        });
    }
};