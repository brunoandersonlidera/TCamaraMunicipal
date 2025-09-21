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
        Schema::create('ouvidoria_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ouvidoria_manifestacao_id')->constrained('ouvidoria_manifestacoes')->onDelete('cascade');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', [
                'aberta',
                'em_analise',
                'aguardando_informacoes',
                'em_apuracao',
                'respondida',
                'procedente',
                'improcedente',
                'parcialmente_procedente',
                'finalizada',
                'arquivada'
            ]);
            $table->text('descricao');
            $table->json('anexos')->nullable();
            $table->datetime('data_movimentacao');
            $table->string('ip_usuario')->nullable();
            $table->timestamps();

            $table->index(['ouvidoria_manifestacao_id', 'data_movimentacao'], 'idx_ouv_mov_manifest_data');
            $table->index('status', 'idx_ouv_mov_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ouvidoria_movimentacoes');
    }
};
