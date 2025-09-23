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
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_empenho')->unique(); // Número do empenho
            $table->string('codigo_despesa'); // Código da despesa orçamentária
            $table->string('descricao'); // Descrição da despesa
            $table->string('categoria'); // Categoria (Corrente, Capital, etc.)
            $table->string('funcao'); // Função orçamentária
            $table->string('subfuncao')->nullable(); // Subfunção orçamentária
            $table->string('programa')->nullable(); // Programa orçamentário
            $table->string('elemento_despesa'); // Elemento de despesa
            $table->string('favorecido'); // Nome do favorecido/fornecedor
            $table->string('cnpj_cpf_favorecido')->nullable(); // CNPJ/CPF do favorecido
            $table->decimal('valor_empenhado', 15, 2); // Valor empenhado
            $table->decimal('valor_liquidado', 15, 2)->default(0); // Valor liquidado
            $table->decimal('valor_pago', 15, 2)->default(0); // Valor pago
            $table->date('data_empenho'); // Data do empenho
            $table->date('data_liquidacao')->nullable(); // Data da liquidação
            $table->date('data_pagamento')->nullable(); // Data do pagamento
            $table->integer('mes_referencia'); // Mês de referência (1-12)
            $table->integer('ano_referencia'); // Ano de referência
            $table->string('modalidade_licitacao')->nullable(); // Modalidade de licitação
            $table->string('numero_processo')->nullable(); // Número do processo
            $table->text('observacoes')->nullable(); // Observações
            $table->enum('status', ['empenhado', 'liquidado', 'pago', 'cancelado'])->default('empenhado');
            $table->timestamps();
            
            // Índices para otimização
            $table->index(['ano_referencia', 'mes_referencia']);
            $table->index('categoria');
            $table->index('favorecido');
            $table->index('status');
            $table->index('data_empenho');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
