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
            $table->foreignId('imagem_topo_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('imagem_descricao_id')->nullable()->constrained('media')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_configurations', function (Blueprint $table) {
            $table->dropForeign(['imagem_topo_id']);
            $table->dropForeign(['imagem_descricao_id']);
            $table->dropColumn(['imagem_topo_id', 'imagem_descricao_id']);
        });
    }
};