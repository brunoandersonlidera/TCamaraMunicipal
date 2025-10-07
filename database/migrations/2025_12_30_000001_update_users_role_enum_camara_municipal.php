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
        // Atualizar o ENUM da coluna role para incluir todas as roles necessárias para Câmara Municipal
        // Removendo 'user' e adicionando roles específicas da Câmara
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cidadao', 'secretario', 'vereador', 'presidente', 'funcionario') DEFAULT 'cidadao'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter para o ENUM anterior
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'cidadao') DEFAULT 'user'");
    }
};