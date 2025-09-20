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
        Schema::table('sessoes', function (Blueprint $table) {
            $table->foreignId('tipo_sessao_id')->nullable()->after('tipo')->constrained('tipo_sessaos')->onDelete('set null');
            $table->index('tipo_sessao_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessoes', function (Blueprint $table) {
            $table->dropForeign(['tipo_sessao_id']);
            $table->dropColumn('tipo_sessao_id');
        });
    }
};
