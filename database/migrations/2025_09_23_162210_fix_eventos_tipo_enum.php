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
        // Primeiro, atualizar registros existentes que possam ter 'comemorativa' para 'data_comemorativa'
        DB::table('eventos')
            ->where('tipo', 'comemorativa')
            ->update(['tipo' => 'data_comemorativa']);

        // Alterar o enum apenas se for MySQL (SQLite não suporta ALTER COLUMN com ENUM)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE eventos MODIFY COLUMN tipo ENUM(
                'sessao_plenaria',
                'audiencia_publica', 
                'reuniao_comissao',
                'votacao',
                'licitacao',
                'agenda_vereador',
                'ato_vereador',
                'data_comemorativa',
                'prazo_esic',
                'outro'
            ) NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter para o enum anterior apenas se for MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE eventos MODIFY COLUMN tipo ENUM(
                'sessao_plenaria',
                'audiencia_publica', 
                'reuniao_comissao',
                'votacao',
                'licitacao',
                'agenda_vereador',
                'ato_vereador',
                'comemorativa',
                'prazo_esic',
                'outro'
            ) NOT NULL");
        }

        // Reverter registros para o valor antigo
        DB::table('eventos')
            ->where('tipo', 'data_comemorativa')
            ->update(['tipo' => 'comemorativa']);
    }
};
