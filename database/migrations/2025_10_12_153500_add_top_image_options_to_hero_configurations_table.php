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
            // Altura máxima em pixels para a imagem do topo (opcional)
            $table->unsignedInteger('imagem_topo_altura_px')->nullable()->after('imagem_topo_id');
            // Centralizar imagem do topo
            $table->boolean('centralizar_imagem_topo')->default(true)->after('imagem_topo_altura_px');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_configurations', function (Blueprint $table) {
            $table->dropColumn(['imagem_topo_altura_px', 'centralizar_imagem_topo']);
        });
    }
};