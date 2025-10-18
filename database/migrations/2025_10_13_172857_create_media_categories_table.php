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
        Schema::create('media_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->comment('Identificador único para a categoria');
            $table->string('name')->comment('Nome da categoria');
            $table->text('description')->nullable()->comment('Descrição da categoria');
            $table->string('icon')->nullable()->comment('Ícone da categoria (FontAwesome)');
            $table->boolean('active')->default(true)->comment('Status da categoria');
            $table->integer('order')->default(0)->comment('Ordem de exibição');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_categories');
    }
};
