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
        Schema::table('roles', function (Blueprint $table) {
            $table->string('display_name', 100)->nullable()->after('name')->comment('Nome para exibição (ex: Administrador, Secretário)');
            $table->text('description')->nullable()->after('display_name')->comment('Descrição detalhada do tipo de usuário');
            $table->string('color', 7)->default('#6B7280')->after('description')->comment('Cor para identificação visual (hex)');
            $table->boolean('is_system')->default(false)->after('color')->comment('Role do sistema (não pode ser excluído)');
            $table->boolean('is_active')->default(true)->after('is_system')->comment('Role ativo/inativo');
            $table->integer('priority')->default(0)->after('is_active')->comment('Prioridade para ordenação (maior = mais importante)');
            
            // Índices
            $table->index(['is_active', 'priority']);
            $table->index('is_system');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'priority']);
            $table->dropIndex(['is_system']);
            $table->dropColumn([
                'display_name',
                'description', 
                'color',
                'is_system',
                'is_active',
                'priority'
            ]);
        });
    }
};
