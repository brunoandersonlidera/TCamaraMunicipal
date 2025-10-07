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
        Schema::table('esic_solicitacoes', function (Blueprint $table) {
            // Alterar a coluna categoria de ENUM para VARCHAR
            $table->string('categoria', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esic_solicitacoes', function (Blueprint $table) {
            // Reverter para o ENUM original
            $table->enum('categoria', ['informacao', 'documento', 'dados', 'outros'])->change();
        });
    }
};
