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
        Schema::create('contrato_aditivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contratos')->onDelete('cascade');
            $table->string('numero');
            $table->enum('tipo', ['prazo', 'valor', 'prazo_valor', 'objeto']);
            $table->text('objeto');
            $table->decimal('valor_aditivo', 15, 2)->default(0);
            $table->integer('prazo_adicional_dias')->default(0);
            $table->date('data_assinatura');
            $table->date('data_inicio_vigencia');
            $table->date('data_fim_vigencia')->nullable();
            $table->text('justificativa');
            $table->text('observacoes')->nullable();
            
            // Campos para arquivos
            $table->string('arquivo_aditivo')->nullable();
            $table->string('arquivo_aditivo_original')->nullable();
            
            // Campos de auditoria
            $table->boolean('publico')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['contrato_id', 'numero']);
            $table->index(['tipo']);
            $table->index(['data_assinatura']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrato_aditivos');
    }
};
