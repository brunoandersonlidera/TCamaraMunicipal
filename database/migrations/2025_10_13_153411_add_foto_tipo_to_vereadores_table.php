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
            $table->string('foto_tipo')->nullable()->default('path')->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vereadores', function (Blueprint $table) {
            $table->dropColumn('foto_tipo');
        });
    }
};
