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
        Schema::table('esic_mensagens', function (Blueprint $table) {
            $table->enum('tipo_comunicacao', ['mensagem', 'resposta_oficial'])->default('mensagem')->after('tipo_remetente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esic_mensagens', function (Blueprint $table) {
            $table->dropColumn('tipo_comunicacao');
        });
    }
};
