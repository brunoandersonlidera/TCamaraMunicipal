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
        Schema::create('comite_iniciativa_populars', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Nome do comitê ou responsável
            $table->string('cpf')->nullable(); // CPF do responsável principal
            $table->string('email')->nullable(); // Email de contato
            $table->string('telefone')->nullable(); // Telefone de contato
            $table->text('endereco')->nullable(); // Endereço completo
            $table->integer('numero_assinaturas')->default(0); // Número de assinaturas coletadas
            $table->integer('minimo_assinaturas')->default(1000); // Mínimo necessário (configurável)
            $table->date('data_inicio_coleta')->nullable(); // Data de início da coleta
            $table->date('data_fim_coleta')->nullable(); // Data de fim da coleta
            $table->enum('status', ['ativo', 'validado', 'rejeitado', 'arquivado'])->default('ativo');
            $table->text('observacoes')->nullable(); // Observações gerais
            $table->json('documentos')->nullable(); // Documentos anexados (JSON)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comite_iniciativa_populars');
    }
};
