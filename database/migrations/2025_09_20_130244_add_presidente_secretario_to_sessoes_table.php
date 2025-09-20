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
            $table->foreignId('presidente_id')->nullable()->constrained('vereadores')->onDelete('set null');
            $table->foreignId('secretario_id')->nullable()->constrained('vereadores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessoes', function (Blueprint $table) {
            $table->dropForeign(['presidente_id']);
            $table->dropForeign(['secretario_id']);
            $table->dropColumn(['presidente_id', 'secretario_id']);
        });
    }
};
