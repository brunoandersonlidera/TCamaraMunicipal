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
        Schema::create('projetos_lei', function (Blueprint $table) {
            $table->id();
            $table->string('numero_projeto');
            $table->integer('ano');
            $table->enum('tipo', ['projeto_lei', 'projeto_resolucao', 'projeto_decreto', 'emenda', 'indicacao', 'mocao', 'requerimento']);
            $table->string('titulo');
            $table->text('ementa');
            $table->longText('texto_integral');
            $table->foreignId('autor_id')->constrained('vereadores');
            $table->json('coautores')->nullable(); // IDs dos vereadores coautores
            $table->enum('status', ['protocolado', 'em_tramitacao', 'aprovado', 'rejeitado', 'arquivado', 'retirado'])->default('protocolado');
            $table->date('data_protocolo');
            $table->date('data_aprovacao')->nullable();
            $table->string('comissao_atual')->nullable();
            $table->json('tramitacao')->nullable(); // Histórico de tramitação
            $table->text('justificativa')->nullable();
            $table->string('arquivo_original')->nullable();
            $table->string('arquivo_aprovado')->nullable();
            $table->json('votacoes')->nullable(); // Histórico de votações
            $table->text('observacoes')->nullable();
            $table->string('categoria')->nullable();
            $table->json('tags')->nullable();
            $table->integer('legislatura');
            $table->boolean('urgencia')->default(false);
            $table->text('parecer_juridico')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'legislatura']);
            $table->index(['tipo', 'ano']);
            $table->index('categoria');
            $table->unique(['numero_projeto', 'ano', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos_lei');
    }
};
