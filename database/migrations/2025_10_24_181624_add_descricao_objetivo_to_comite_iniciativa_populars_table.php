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
            $table->text('descricao')->nullable()->after('observacoes');
            $table->text('objetivo')->nullable()->after('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comite_iniciativa_populars', function (Blueprint $table) {
            $table->dropColumn(['descricao', 'objetivo']);
        });
    }
};
