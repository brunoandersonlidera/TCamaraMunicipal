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
        Schema::table('media', function (Blueprint $table) {
            // Adicionar colunas necessárias para o Spatie Media Library
            $table->morphs('model'); // model_type e model_id
            $table->uuid('uuid')->nullable()->unique();
            $table->string('collection_name')->default('default');
            $table->string('name')->nullable();
            $table->string('disk')->default('public');
            $table->string('conversions_disk')->nullable();
            $table->json('manipulations')->default('{}');
            $table->json('custom_properties')->default('{}');
            $table->json('generated_conversions')->default('{}');
            $table->unsignedInteger('order_column')->nullable()->index();
            
            // Renomear filename para file_name (padrão do Spatie)
            $table->renameColumn('filename', 'file_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Remover colunas do Spatie
            $table->dropMorphs('model');
            $table->dropColumn([
                'uuid', 'collection_name', 'name', 'disk',
                'conversions_disk', 'manipulations', 'custom_properties',
                'generated_conversions', 'order_column'
            ]);
            
            // Restaurar nome original da coluna
            $table->renameColumn('file_name', 'filename');
        });
    }
};
