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
        Schema::table('projetos_lei', function (Blueprint $table) {
            $table->foreignId('comite_iniciativa_popular_id')
                  ->nullable()
                  ->constrained('comite_iniciativa_populars')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projetos_lei', function (Blueprint $table) {
            $table->dropForeign(['comite_iniciativa_popular_id']);
            $table->dropColumn('comite_iniciativa_popular_id');
        });
    }
};
