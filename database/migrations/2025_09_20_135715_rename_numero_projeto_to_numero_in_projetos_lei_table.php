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
            $table->renameColumn('numero_projeto', 'numero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projetos_lei', function (Blueprint $table) {
            $table->renameColumn('numero', 'numero_projeto');
        });
    }
};
