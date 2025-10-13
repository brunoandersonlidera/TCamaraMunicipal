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
            // Altura máxima em pixels para a imagem da descrição (opcional)
            $table->unsignedInteger('imagem_descricao_altura_px')->nullable()->after('imagem_descricao_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_configurations', function (Blueprint $table) {
            $table->dropColumn(['imagem_descricao_altura_px']);
        });
    }
};