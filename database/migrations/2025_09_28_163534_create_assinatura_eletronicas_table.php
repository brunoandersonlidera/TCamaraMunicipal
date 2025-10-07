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
        Schema::create('assinatura_eletronicas', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento com o comitê
            $table->foreignId('comite_iniciativa_popular_id')
                  ->constrained('comite_iniciativa_populars')
                  ->onDelete('cascade');
            
            // Dados do cidadão
            $table->string('nome_completo');
            $table->string('cpf', 14)->unique();
            $table->string('email');
            $table->string('telefone')->nullable();
            $table->date('data_nascimento');
            $table->string('titulo_eleitor', 12);
            $table->string('zona_eleitoral')->nullable();
            $table->string('secao_eleitoral')->nullable();
            
            // Endereço
            $table->string('endereco');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 9);
            
            // Dados da assinatura
            $table->timestamp('data_assinatura');
            $table->string('ip_address');
            $table->text('user_agent');
            $table->string('hash_assinatura')->unique(); // Hash único da assinatura
            
            // Status e validação
            $table->enum('status', ['pendente', 'validada', 'rejeitada'])->default('pendente');
            $table->text('motivo_rejeicao')->nullable();
            $table->timestamp('data_validacao')->nullable();
            $table->foreignId('validado_por')->nullable()->constrained('users');
            
            // Controle de duplicatas
            $table->boolean('ativo')->default(true);
            
            $table->timestamps();
            
            // Índices
            $table->index(['comite_iniciativa_popular_id', 'status']);
            $table->index(['cpf', 'comite_iniciativa_popular_id']);
            $table->index('data_assinatura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinatura_eletronicas');
    }
};
