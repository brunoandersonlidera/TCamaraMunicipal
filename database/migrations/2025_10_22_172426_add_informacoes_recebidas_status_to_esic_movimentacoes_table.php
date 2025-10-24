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
        // Alterar o ENUM da coluna status para incluir 'informacoes_recebidas'
        DB::statement("ALTER TABLE esic_movimentacoes MODIFY COLUMN status ENUM(
            'aberta',
            'em_analise',
            'aguardando_informacoes',
            'informacoes_recebidas',
            'respondida',
            'negada',
            'parcialmente_atendida',
            'recurso_solicitado',
            'recurso_em_analise',
            'recurso_deferido',
            'recurso_indeferido',
            'finalizada',
            'arquivada'
        ) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter o ENUM da coluna status para o estado anterior
        DB::statement("ALTER TABLE esic_movimentacoes MODIFY COLUMN status ENUM(
            'aberta',
            'em_analise',
            'aguardando_informacoes',
            'respondida',
            'negada',
            'parcialmente_atendida',
            'recurso_solicitado',
            'recurso_em_analise',
            'recurso_deferido',
            'recurso_indeferido',
            'finalizada',
            'arquivada'
        ) NOT NULL");
    }
};
