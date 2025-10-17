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
        // 1. Primeiro, atualizar o enum de roles para incluir 'ouvidor'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cidadao', 'secretario', 'vereador', 'presidente', 'funcionario', 'ouvidor') DEFAULT 'cidadao'");
        
        // 2. Adicionar campos específicos de ouvidor na tabela users
        Schema::table('users', function (Blueprint $table) {
            // Campos específicos de ouvidor
            $table->string('especialidade')->nullable()->after('role');
            $table->text('bio')->nullable()->after('especialidade');
            $table->string('foto')->nullable()->after('bio');
            
            // Permissões específicas de ouvidor
            $table->boolean('pode_gerenciar_esic')->default(false)->after('foto');
            $table->boolean('pode_gerenciar_ouvidoria')->default(false)->after('pode_gerenciar_esic');
            $table->boolean('pode_visualizar_relatorios')->default(false)->after('pode_gerenciar_ouvidoria');
            $table->boolean('pode_responder_manifestacoes')->default(false)->after('pode_visualizar_relatorios');
            
            // Configurações de notificação
            $table->boolean('recebe_notificacao_email')->default(true)->after('pode_responder_manifestacoes');
            $table->boolean('recebe_notificacao_sistema')->default(true)->after('recebe_notificacao_email');
            
            // Datas específicas de ouvidor
            $table->date('data_inicio_ouvidor')->nullable()->after('recebe_notificacao_sistema');
            $table->date('data_fim_ouvidor')->nullable()->after('data_inicio_ouvidor');
            
            // Campos adicionais que podem estar na tabela ouvidores
            $table->string('ramal')->nullable()->after('data_fim_ouvidor');
            $table->enum('tipo_ouvidor', ['geral', 'especializado', 'setorial'])->nullable()->after('ramal');
        });
        
        // 3. Migrar dados da tabela ouvidores para users
        $ouvidores = DB::table('ouvidores')->get();
        
        foreach ($ouvidores as $ouvidor) {
            DB::table('users')
                ->where('id', $ouvidor->user_id)
                ->update([
                    'role' => 'ouvidor',
                    'especialidade' => $ouvidor->tipo ?? 'geral',
                    'pode_gerenciar_esic' => $ouvidor->pode_gerenciar_esic ?? false,
                    'pode_gerenciar_ouvidoria' => $ouvidor->pode_gerenciar_ouvidoria ?? false,
                    'pode_visualizar_relatorios' => $ouvidor->pode_visualizar_relatorios ?? false,
                    'pode_responder_manifestacoes' => $ouvidor->pode_responder_manifestacoes ?? true,
                    'recebe_notificacao_email' => $ouvidor->recebe_notificacao_email ?? true,
                    'recebe_notificacao_sistema' => $ouvidor->recebe_notificacao_sistema ?? true,
                    'data_inicio_ouvidor' => $ouvidor->data_inicio,
                    'data_fim_ouvidor' => $ouvidor->data_fim,
                    'ramal' => $ouvidor->ramal,
                    'tipo_ouvidor' => $ouvidor->tipo ?? 'geral',
                    'active' => $ouvidor->ativo ?? true,
                ]);
        }
        
        // 4. Atualizar as foreign keys nas tabelas relacionadas
        // Atualizar ouvidoria_manifestacoes.ouvidor_responsavel_id para user_id
        DB::statement('
            UPDATE ouvidoria_manifestacoes om 
            INNER JOIN ouvidores o ON om.ouvidor_responsavel_id = o.id 
            SET om.ouvidor_responsavel_id = o.user_id
        ');
        
        // Atualizar ouvidoria_manifestacoes.respondida_por para user_id
        DB::statement('
            UPDATE ouvidoria_manifestacoes om 
            INNER JOIN ouvidores o ON om.respondida_por = o.id 
            SET om.respondida_por = o.user_id
        ');
        
        // 5. Remover as constraints de foreign key da tabela ouvidores
        Schema::table('ouvidoria_manifestacoes', function (Blueprint $table) {
            $table->dropForeign(['ouvidor_responsavel_id']);
            $table->dropForeign(['respondida_por']);
        });
        
        // 6. Recriar as foreign keys apontando para users
        Schema::table('ouvidoria_manifestacoes', function (Blueprint $table) {
            $table->foreign('ouvidor_responsavel_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('respondida_por')->references('id')->on('users')->onDelete('set null');
        });
        
        // 7. Remover a tabela ouvidores
        Schema::dropIfExists('ouvidores');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recriar a tabela ouvidores
        Schema::create('ouvidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nome');
            $table->string('email');
            $table->string('cpf', 14)->unique();
            $table->string('cargo')->nullable();
            $table->string('setor')->nullable();
            $table->enum('tipo', ['geral', 'especializado', 'setorial'])->default('geral');
            $table->boolean('pode_gerenciar_esic')->default(false);
            $table->boolean('pode_gerenciar_ouvidoria')->default(false);
            $table->boolean('pode_visualizar_relatorios')->default(false);
            $table->boolean('pode_responder_manifestacoes')->default(true);
            $table->string('telefone', 20)->nullable();
            $table->string('ramal', 10)->nullable();
            $table->boolean('ativo')->default(true);
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->boolean('recebe_notificacao_email')->default(true);
            $table->boolean('recebe_notificacao_sistema')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['tipo']);
            $table->index(['ativo']);
            $table->index(['email']);
        });
        
        // Remover campos adicionados na tabela users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'especialidade',
                'bio',
                'foto',
                'pode_gerenciar_esic',
                'pode_gerenciar_ouvidoria',
                'pode_visualizar_relatorios',
                'pode_responder_manifestacoes',
                'recebe_notificacao_email',
                'recebe_notificacao_sistema',
                'data_inicio_ouvidor',
                'data_fim_ouvidor',
                'ramal',
                'tipo_ouvidor'
            ]);
        });
        
        // Reverter o enum de roles
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cidadao', 'secretario', 'vereador', 'presidente', 'funcionario') DEFAULT 'cidadao'");
    }
};
