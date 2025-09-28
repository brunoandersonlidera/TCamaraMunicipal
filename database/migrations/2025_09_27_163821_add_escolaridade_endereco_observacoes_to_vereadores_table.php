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
            $table->string('escolaridade')->nullable()->after('profissao');
            $table->text('endereco')->nullable()->after('escolaridade');
            $table->text('observacoes')->nullable()->after('endereco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vereadores', function (Blueprint $table) {
            $table->dropColumn(['escolaridade', 'endereco', 'observacoes']);
        });
    }
};
