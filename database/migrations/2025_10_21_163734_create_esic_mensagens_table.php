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
        Schema::create('esic_mensagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esic_solicitacao_id')->constrained('esic_solicitacoes')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo_remetente', ['cidadao', 'ouvidor'])->comment('Quem enviou a mensagem');
            $table->text('mensagem');
            $table->enum('canal_comunicacao', ['sistema', 'telefone', 'whatsapp', 'email', 'presencial', 'carta', 'outro'])->default('sistema');
            $table->string('telefone_contato')->nullable()->comment('Telefone usado quando canal for telefone/whatsapp');
            $table->string('email_contato')->nullable()->comment('Email usado quando canal for email');
            $table->text('observacoes_canal')->nullable()->comment('Observações sobre o canal de comunicação');
            $table->json('anexos')->nullable()->comment('Array com informações dos arquivos anexados');
            $table->boolean('lida')->default(false)->comment('Se a mensagem foi lida pelo destinatário');
            $table->timestamp('data_leitura')->nullable();
            $table->boolean('interna')->default(false)->comment('Mensagem interna (apenas para ouvidores)');
            $table->string('ip_usuario')->nullable();
            $table->timestamps();
            
            // Índices para performance
            $table->index(['esic_solicitacao_id', 'created_at']);
            $table->index(['usuario_id', 'tipo_remetente']);
            $table->index(['canal_comunicacao']);
            $table->index(['lida']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esic_mensagens');
    }
};
