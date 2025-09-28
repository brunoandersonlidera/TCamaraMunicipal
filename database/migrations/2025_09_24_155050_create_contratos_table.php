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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_contrato_id')->constrained('tipo_contratos')->onDelete('cascade');
            $table->string('numero')->unique();
            $table->string('processo')->nullable();
            $table->text('objeto');
            $table->string('contratado');
            $table->string('cnpj_cpf_contratado')->nullable();
            $table->decimal('valor_inicial', 15, 2);
            $table->decimal('valor_atual', 15, 2);
            $table->date('data_assinatura');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->date('data_fim_atual')->nullable(); // Para quando há aditivos
            $table->enum('status', ['ativo', 'suspenso', 'encerrado', 'rescindido'])->default('ativo');
            $table->text('observacoes')->nullable();
            
            // Campos para arquivos
            $table->string('arquivo_contrato')->nullable(); // Arquivo principal do contrato
            $table->string('arquivo_contrato_original')->nullable(); // Nome original do arquivo
            
            // Campos de auditoria
            $table->boolean('publico')->default(true); // Se deve aparecer no portal da transparência
            $table->integer('ano_referencia');
            $table->timestamps();
            
            // Índices
            $table->index(['status', 'publico']);
            $table->index(['ano_referencia']);
            $table->index(['data_inicio', 'data_fim']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
