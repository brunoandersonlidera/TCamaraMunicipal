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
        Schema::create('carta_servico_avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carta_servico_id')->constrained()->onDelete('cascade');
            $table->string('nome_avaliador')->nullable();
            $table->string('email_avaliador')->nullable();
            $table->integer('nota')->unsigned(); // 1 a 5
            $table->text('comentario')->nullable();
            $table->string('ip_avaliador')->nullable();
            $table->boolean('aprovado')->default(false);
            $table->datetime('data_aprovacao')->nullable();
            $table->foreignId('aprovado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['carta_servico_id', 'aprovado']);
            $table->index('nota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta_servico_avaliacoes');
    }
};
