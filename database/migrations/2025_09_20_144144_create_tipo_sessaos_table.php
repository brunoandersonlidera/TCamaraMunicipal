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
        Schema::create('tipo_sessaos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('descricao')->nullable();
            $table->string('cor', 7)->default('#007bff'); // Cor hexadecimal
            $table->string('icone', 50)->default('fas fa-gavel'); // Classe do ícone
            $table->boolean('ativo')->default(true);
            $table->integer('ordem')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['ativo', 'ordem']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_sessaos');
    }
};
