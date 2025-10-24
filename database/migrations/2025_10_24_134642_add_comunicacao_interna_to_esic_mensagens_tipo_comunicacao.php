<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar o enum para incluir 'comunicacao_interna'
        DB::statement("ALTER TABLE esic_mensagens MODIFY COLUMN tipo_comunicacao ENUM('mensagem', 'resposta_oficial', 'comunicacao_interna') DEFAULT 'mensagem'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter o enum para os valores originais
        DB::statement("ALTER TABLE esic_mensagens MODIFY COLUMN tipo_comunicacao ENUM('mensagem', 'resposta_oficial') DEFAULT 'mensagem'");
    }
};
