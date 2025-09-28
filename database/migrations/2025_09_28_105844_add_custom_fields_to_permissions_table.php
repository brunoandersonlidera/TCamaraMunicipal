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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name', 100)->nullable()->after('name')->comment('Nome para exibição (ex: Criar Notícias)');
            $table->text('description')->nullable()->after('display_name')->comment('Descrição detalhada da permissão');
            $table->string('module', 50)->nullable()->after('description')->comment('Módulo da permissão (ex: noticias, usuarios, esic)');
            $table->string('action', 20)->nullable()->after('module')->comment('Ação da permissão (view, create, edit, delete, manage)');
            $table->boolean('is_system')->default(false)->after('action')->comment('Permissão do sistema (não pode ser excluída)');
            $table->boolean('is_active')->default(true)->after('is_system')->comment('Permissão ativa/inativa');
            $table->integer('priority')->default(0)->after('is_active')->comment('Prioridade para ordenação dentro do módulo');
            
            // Índices
            $table->index(['module', 'action']);
            $table->index(['is_active', 'module']);
            $table->index('is_system');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropIndex(['module', 'action']);
            $table->dropIndex(['is_active', 'module']);
            $table->dropIndex(['is_system']);
            $table->dropColumn([
                'display_name',
                'description',
                'module',
                'action',
                'is_system',
                'is_active',
                'priority'
            ]);
        });
    }
};
