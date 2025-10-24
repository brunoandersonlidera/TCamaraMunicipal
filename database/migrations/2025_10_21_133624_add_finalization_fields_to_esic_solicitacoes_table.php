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
            $table->timestamp('data_finalizacao_solicitada')->nullable()->comment('Data em que foi solicitada a finalização');
            $table->timestamp('data_limite_encerramento')->nullable()->comment('Data limite para encerramento automático (10 dias após finalização solicitada)');
            $table->boolean('encerrada_automaticamente')->default(false)->comment('Indica se foi encerrada automaticamente pelo sistema');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esic_solicitacoes', function (Blueprint $table) {
            $table->dropColumn(['data_finalizacao_solicitada', 'data_limite_encerramento', 'encerrada_automaticamente']);
        });
    }
};
