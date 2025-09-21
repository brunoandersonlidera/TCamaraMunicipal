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
        Schema::create('esic_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20)->nullable();
            $table->date('data_nascimento');
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20);
            
            // Endereço
            $table->string('cep', 10);
            $table->string('logradouro');
            $table->string('numero', 10);
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            
            // Controle de acesso
            $table->boolean('ativo')->default(false);
            $table->string('token_ativacao')->nullable();
            $table->timestamp('token_ativacao_expires_at')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_expires_at')->nullable();
            
            // Termos e consentimento
            $table->boolean('aceite_termos')->default(false);
            $table->timestamp('aceite_termos_at')->nullable();
            $table->boolean('aceite_lgpd')->default(false);
            $table->timestamp('aceite_lgpd_at')->nullable();
            
            // Auditoria
            $table->timestamp('ultimo_acesso')->nullable();
            $table->string('ip_cadastro', 45)->nullable();
            $table->string('user_agent_cadastro')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['email', 'ativo']);
            $table->index(['cpf', 'ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esic_usuarios');
    }
};
