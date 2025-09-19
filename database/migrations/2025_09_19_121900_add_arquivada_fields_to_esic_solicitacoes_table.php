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
            $table->boolean('arquivada')->default(false)->after('status');
            $table->timestamp('arquivada_em')->nullable()->after('arquivada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esic_solicitacoes', function (Blueprint $table) {
            $table->dropColumn(['arquivada', 'arquivada_em']);
        });
    }
};
