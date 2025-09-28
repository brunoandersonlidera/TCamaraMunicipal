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
        Schema::create('contrato_fiscalizacaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contratos')->onDelete('cascade');
            $table->string('numero_relatorio');
            $table->date('data_fiscalizacao');
            $table->string('fiscal_responsavel');
            $table->enum('tipo_fiscalizacao', ['rotina', 'especial', 'denuncia', 'auditoria']);
            $table->text('objeto_fiscalizacao');
            $table->text('observacoes_encontradas');
            $table->enum('status_execucao', ['conforme', 'nao_conforme', 'parcialmente_conforme']);
            $table->text('recomendacoes')->nullable();
            $table->text('providencias_adotadas')->nullable();
            $table->date('prazo_regularizacao')->nullable();
            $table->enum('status_regularizacao', ['pendente', 'em_andamento', 'regularizado', 'nao_aplicavel'])->default('nao_aplicavel');
            
            // Campos para arquivos
            $table->string('arquivo_relatorio')->nullable();
            $table->string('arquivo_relatorio_original')->nullable();
            
            // Campos de auditoria
            $table->boolean('publico')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['contrato_id', 'data_fiscalizacao']);
            $table->index(['tipo_fiscalizacao']);
            $table->index(['status_execucao']);
            $table->index(['status_regularizacao']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrato_fiscalizacaos');
    }
};
