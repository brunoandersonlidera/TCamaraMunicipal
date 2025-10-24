<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comite_iniciativa_populars', function (Blueprint $table) {
            // Adicionar novos campos para controle de status
            $table->text('motivo_rejeicao')->nullable()->after('observacoes');
            $table->text('observacoes_admin')->nullable()->after('motivo_rejeicao');
            $table->timestamp('data_validacao_admin')->nullable()->after('observacoes_admin');
            $table->unsignedBigInteger('validado_por')->nullable()->after('data_validacao_admin');
            $table->timestamp('data_ultima_alteracao')->nullable()->after('validado_por');
            
            // Adicionar foreign key para o usuário que validou
            $table->foreign('validado_por')->references('id')->on('users')->onDelete('set null');
        });

        // Atualizar enum de status para incluir novos valores
        DB::statement("ALTER TABLE comite_iniciativa_populars MODIFY COLUMN status ENUM('aguardando_validacao', 'ativo', 'aguardando_alteracoes', 'validado', 'rejeitado', 'arquivado', 'expirado') DEFAULT 'aguardando_validacao'");
        
        // Atualizar comitês existentes que estão como 'ativo' para 'aguardando_validacao'
        // (exceto se já tiverem assinaturas significativas)
        DB::table('comite_iniciativa_populars')
            ->where('status', 'ativo')
            ->where('numero_assinaturas', '<=', 1)
            ->update(['status' => 'aguardando_validacao']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comite_iniciativa_populars', function (Blueprint $table) {
            $table->dropForeign(['validado_por']);
            $table->dropColumn([
                'motivo_rejeicao',
                'observacoes_admin', 
                'data_validacao_admin',
                'validado_por',
                'data_ultima_alteracao'
            ]);
        });

        // Reverter enum para valores originais
        DB::statement("ALTER TABLE comite_iniciativa_populars MODIFY COLUMN status ENUM('ativo', 'validado', 'rejeitado', 'arquivado') DEFAULT 'ativo'");
    }
};