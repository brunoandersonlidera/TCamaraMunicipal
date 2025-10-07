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
        Schema::table('vereadores', function (Blueprint $table) {
            // Datas de mandato para presidente e vice-presidente
            $table->date('presidente_inicio')->nullable()->after('vice_presidente');
            $table->date('presidente_fim')->nullable()->after('presidente_inicio');
            $table->date('vice_inicio')->nullable()->after('presidente_fim');
            $table->date('vice_fim')->nullable()->after('vice_inicio');

            // Índices auxiliares para consultas de presidente/vice ativos
            $table->index(['presidente', 'presidente_inicio', 'presidente_fim'], 'vereadores_presidente_index');
            $table->index(['vice_presidente', 'vice_inicio', 'vice_fim'], 'vereadores_vice_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vereadores', function (Blueprint $table) {
            $table->dropIndex('vereadores_presidente_index');
            $table->dropIndex('vereadores_vice_index');
            $table->dropColumn(['presidente_inicio', 'presidente_fim', 'vice_inicio', 'vice_fim']);
        });
    }
};