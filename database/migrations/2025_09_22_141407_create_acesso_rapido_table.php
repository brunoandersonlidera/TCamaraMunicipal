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
        Schema::create('acesso_rapido', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->string('url');
            $table->string('icone')->default('fas fa-link');
            $table->string('cor_botao')->default('#007bff');
            $table->string('cor_fonte')->default('#ffffff');
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->boolean('abrir_nova_aba')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acesso_rapido');
    }
};
