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
        Schema::create('carta_servicos', function (Blueprint $table) {
            $table->id();
            
            // Identificação do serviço
            $table->string('codigo_servico', 20)->unique();
            $table->string('nome_servico');
            $table->text('descricao');
            
            // Categoria do serviço
            $table->enum('categoria', [
                'acesso_informacao',
                'ouvidoria',
                'transparencia',
                'participacao_social',
                'servicos_administrativos'
            ]);
            
            // Informações legais
            $table->text('base_legal');
            $table->text('requisitos');
            $table->text('documentos_necessarios');
            
            // Prazos e custos
            $table->integer('prazo_atendimento_dias');
            $table->decimal('custo', 10, 2)->default(0);
            $table->text('forma_prestacao');
            
            // Canais de atendimento
            $table->json('canais_atendimento'); // presencial, telefone, email, sistema
            $table->text('horario_funcionamento');
            $table->text('endereco_atendimento')->nullable();
            $table->string('telefone_contato')->nullable();
            $table->string('email_contato')->nullable();
            
            // Responsáveis
            $table->string('orgao_responsavel');
            $table->string('setor_responsavel');
            $table->string('responsavel_tecnico');
            $table->string('responsavel_aprovacao');
            
            // Indicadores de qualidade
            $table->text('compromissos_qualidade');
            $table->text('mecanismos_comunicacao');
            $table->text('procedimentos_reclamacao');
            
            // Informações complementares
            $table->text('outras_informacoes')->nullable();
            $table->text('legislacao_aplicavel');
            
            // Controle de versão
            $table->string('versao', 10)->default('1.0');
            $table->date('data_vigencia');
            $table->date('data_revisao')->nullable();
            
            // Status
            $table->boolean('ativo')->default(true);
            $table->boolean('publicado')->default(false);
            
            // Auditoria
            $table->foreignId('criado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('atualizado_por')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['categoria', 'ativo']);
            $table->index(['codigo_servico']);
            $table->index(['publicado', 'ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta_servicos');
    }
};
