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
        Schema::table('cidadaos', function (Blueprint $table) {
            // Aumentar o tamanho do campo CPF para suportar formatação (000.000.000-00)
            $table->string('cpf', 14)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cidadaos', function (Blueprint $table) {
            // Reverter para o tamanho original
            $table->string('cpf', 11)->change();
        });
    }
};
