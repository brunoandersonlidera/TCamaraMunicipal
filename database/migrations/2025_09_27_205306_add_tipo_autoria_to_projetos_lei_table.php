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
            $table->enum('tipo_autoria', ['vereador', 'prefeito', 'comissao', 'iniciativa_popular'])
                  ->default('vereador')
                  ->after('autor_id');
            $table->string('autor_nome')->nullable()->after('tipo_autoria'); // Para casos como comissão ou iniciativa popular
            $table->json('dados_iniciativa_popular')->nullable()->after('autor_nome'); // Para dados específicos da iniciativa popular
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projetos_lei', function (Blueprint $table) {
            $table->dropColumn(['tipo_autoria', 'autor_nome', 'dados_iniciativa_popular']);
        });
    }
};
