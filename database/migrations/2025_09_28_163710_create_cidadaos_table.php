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
        Schema::create('cidadaos', function (Blueprint $table) {
            $table->id();
            
            // Dados pessoais
            $table->string('nome_completo');
            $table->string('cpf', 11)->unique();
            $table->string('rg', 20)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('data_nascimento');
            $table->enum('sexo', ['M', 'F', 'O'])->nullable();
            $table->string('estado_civil', 20)->nullable();
            $table->string('profissao', 100)->nullable();
            
            // Contato
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            
            // Endereço
            $table->string('cep', 8);
            $table->string('endereco');
            $table->string('numero', 10);
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            
            // Dados eleitorais
            $table->string('titulo_eleitor', 12)->unique();
            $table->string('zona_eleitoral', 4);
            $table->string('secao_eleitoral', 4);
            
            // Controle de acesso
            $table->boolean('ativo')->default(true);
            $table->string('token_ativacao')->nullable();
            $table->timestamp('ultimo_acesso')->nullable();
            $table->string('ip_ultimo_acesso')->nullable();
            
            // Termos e políticas
            $table->boolean('aceite_termos')->default(false);
            $table->timestamp('aceite_termos_em')->nullable();
            $table->boolean('aceite_lgpd')->default(false);
            $table->timestamp('aceite_lgpd_em')->nullable();
            
            // Verificação de identidade
            $table->enum('status_verificacao', ['pendente', 'verificado', 'rejeitado'])->default('pendente');
            $table->text('motivo_rejeicao')->nullable();
            $table->timestamp('verificado_em')->nullable();
            $table->unsignedBigInteger('verificado_por')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
            
            // Índices
            $table->index(['cpf', 'ativo']);
            $table->index(['email', 'ativo']);
            $table->index(['titulo_eleitor', 'ativo']);
            $table->index('status_verificacao');
            
            // Chave estrangeira
            $table->foreign('verificado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cidadaos');
    }
};
