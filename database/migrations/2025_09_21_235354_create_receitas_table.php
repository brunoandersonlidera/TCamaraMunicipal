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
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_receita')->unique(); // Código da receita orçamentária
            $table->string('descricao'); // Descrição da receita
            $table->string('categoria'); // Categoria (Corrente, Capital, etc.)
            $table->string('subcategoria')->nullable(); // Subcategoria
            $table->string('fonte_recurso')->nullable(); // Fonte do recurso
            $table->decimal('valor_previsto', 15, 2); // Valor previsto no orçamento
            $table->decimal('valor_arrecadado', 15, 2)->default(0); // Valor arrecadado
            $table->date('data_arrecadacao')->nullable(); // Data da arrecadação
            $table->integer('mes_referencia'); // Mês de referência (1-12)
            $table->integer('ano_referencia'); // Ano de referência
            $table->text('observacoes')->nullable(); // Observações
            $table->enum('status', ['previsto', 'arrecadado', 'cancelado'])->default('previsto');
            $table->timestamps();
            
            // Índices para otimização
            $table->index(['ano_referencia', 'mes_referencia']);
            $table->index('categoria');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receitas');
    }
};
