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
        Schema::create('esic_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esic_solicitacao_id')->constrained('esic_solicitacoes')->onDelete('cascade');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', [
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
            ]);
            $table->text('descricao');
            $table->json('anexos')->nullable();
            $table->datetime('data_movimentacao');
            $table->string('ip_usuario')->nullable();
            $table->timestamps();

            $table->index(['esic_solicitacao_id', 'data_movimentacao']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esic_movimentacoes');
    }
};
