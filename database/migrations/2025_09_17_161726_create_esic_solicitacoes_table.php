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
        Schema::create('esic_solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo')->unique();
            $table->string('nome_solicitante');
            $table->string('email_solicitante');
            $table->string('telefone_solicitante')->nullable();
            $table->string('cpf_solicitante')->nullable();
            $table->enum('tipo_pessoa', ['fisica', 'juridica'])->default('fisica');
            $table->string('cnpj_solicitante')->nullable();
            $table->text('endereco_solicitante')->nullable();
            $table->enum('categoria', ['informacao', 'documento', 'dados', 'outros']);
            $table->string('assunto');
            $table->longText('descricao');
            $table->enum('forma_recebimento', ['email', 'presencial', 'correios'])->default('email');
            $table->text('endereco_resposta')->nullable();
            $table->enum('status', ['pendente', 'em_analise', 'respondida', 'negada', 'parcialmente_atendida', 'recurso', 'finalizada'])->default('pendente');
            $table->date('data_limite_resposta');
            $table->longText('resposta')->nullable();
            $table->json('anexos_solicitacao')->nullable();
            $table->json('anexos_resposta')->nullable();
            $table->foreignId('responsavel_id')->nullable()->constrained('users');
            $table->text('justificativa_negativa')->nullable();
            $table->boolean('recurso_solicitado')->default(false);
            $table->text('recurso_justificativa')->nullable();
            $table->longText('recurso_resposta')->nullable();
            $table->json('tramitacao')->nullable(); // Histórico de tramitação
            $table->text('observacoes_internas')->nullable();
            $table->integer('prazo_prorrogacao_dias')->default(0);
            $table->text('justificativa_prorrogacao')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'data_limite_resposta']);
            $table->index(['categoria', 'status']);
            $table->index('tipo_pessoa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esic_solicitacoes');
    }
};
