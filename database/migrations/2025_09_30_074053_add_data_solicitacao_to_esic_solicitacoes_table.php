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
            $table->timestamp('data_solicitacao')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esic_solicitacoes', function (Blueprint $table) {
            $table->dropColumn('data_solicitacao');
        });
    }
};
