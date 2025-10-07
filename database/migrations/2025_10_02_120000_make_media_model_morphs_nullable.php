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
        Schema::table('media', function (Blueprint $table) {
            // Remover as colunas morphs não nulas e recriá-las como nullable
            // Observação: dropMorphs remove também o índice composto
            $table->dropMorphs('model');
            $table->nullableMorphs('model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Reverter para morphs não nulos
            $table->dropMorphs('model');
            $table->morphs('model');
        });
    }
};