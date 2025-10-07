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
        Schema::table('comite_iniciativa_populars', function (Blueprint $table) {
            $table->text('ementa')->nullable()->after('observacoes');
            $table->longText('texto_projeto_html')->nullable()->after('ementa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comite_iniciativa_populars', function (Blueprint $table) {
            $table->dropColumn(['ementa', 'texto_projeto_html']);
        });
    }
};