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
        Schema::create('vereadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_parlamentar')->nullable();
            $table->string('partido', 10);
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->text('biografia')->nullable();
            $table->string('foto')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('profissao')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'licenciado'])->default('ativo');
            $table->date('inicio_mandato');
            $table->date('fim_mandato');
            $table->integer('legislatura');
            $table->boolean('presidente')->default(false);
            $table->boolean('vice_presidente')->default(false);
            $table->json('redes_sociais')->nullable();
            $table->text('proposicoes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'legislatura']);
            $table->index('partido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vereadores');
    }
};
