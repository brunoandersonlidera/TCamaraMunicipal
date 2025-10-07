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
        Schema::table('cidadaos', function (Blueprint $table) {
            // Adicionar foreign key para user_id (coluna já existe)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Remover campos de autenticação duplicados
            $table->dropColumn([
                'email',
                'email_verified_at', 
                'password',
                'ativo',
                'remember_token',
                'aceite_termos',
                'aceite_termos_em',
                'aceite_lgpd',
                'aceite_lgpd_em',
                'token_ativacao',
                'ultimo_acesso',
                'ip_ultimo_acesso'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cidadaos', function (Blueprint $table) {
            // Restaurar campos removidos
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('ativo')->default(true);
            $table->rememberToken();
            $table->boolean('aceite_termos')->default(false);
            $table->timestamp('aceite_termos_em')->nullable();
            $table->boolean('aceite_lgpd')->default(false);
            $table->timestamp('aceite_lgpd_em')->nullable();
            $table->string('token_ativacao')->nullable();
            $table->timestamp('ultimo_acesso')->nullable();
            $table->string('ip_ultimo_acesso')->nullable();
            
            // Remover relacionamento
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
