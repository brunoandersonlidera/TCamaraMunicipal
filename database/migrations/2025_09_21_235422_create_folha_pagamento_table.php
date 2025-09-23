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
        Schema::create('folha_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome_servidor'); // Nome do servidor (pode ser abreviado por privacidade)
            $table->string('cargo'); // Cargo do servidor
            $table->string('lotacao'); // Lotação/Setor
            $table->string('vinculo'); // Tipo de vínculo (Efetivo, Comissionado, etc.)
            $table->string('regime_juridico')->nullable(); // Regime jurídico
            $table->decimal('remuneracao_basica', 10, 2); // Remuneração básica
            $table->decimal('vantagens_pessoais', 10, 2)->default(0); // Vantagens pessoais
            $table->decimal('funcao_cargo', 10, 2)->default(0); // Função/Cargo em comissão
            $table->decimal('gratificacoes', 10, 2)->default(0); // Gratificações
            $table->decimal('adicionais', 10, 2)->default(0); // Adicionais
            $table->decimal('indenizacoes', 10, 2)->default(0); // Indenizações
            $table->decimal('descontos_obrigatorios', 10, 2)->default(0); // Descontos obrigatórios
            $table->decimal('outros_descontos', 10, 2)->default(0); // Outros descontos
            $table->decimal('remuneracao_liquida', 10, 2); // Remuneração líquida
            $table->decimal('diarias', 10, 2)->default(0); // Diárias
            $table->decimal('auxilios', 10, 2)->default(0); // Auxílios
            $table->decimal('vantagens_indenizatorias', 10, 2)->default(0); // Vantagens indenizatórias
            $table->integer('mes_referencia'); // Mês de referência (1-12)
            $table->integer('ano_referencia'); // Ano de referência
            $table->date('data_admissao')->nullable(); // Data de admissão
            $table->string('situacao')->default('ativo'); // Situação (ativo, inativo, etc.)
            $table->text('observacoes')->nullable(); // Observações
            $table->timestamps();
            
            // Índices para otimização
            $table->index(['ano_referencia', 'mes_referencia']);
            $table->index('cargo');
            $table->index('lotacao');
            $table->index('vinculo');
            $table->index('situacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folha_pagamento');
    }
};
