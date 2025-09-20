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
        Schema::table('sessoes', function (Blueprint $table) {
            // Campos para vídeo gravado
            $table->text('video_url')->nullable()->comment('URL do vídeo gravado (YouTube, Vimeo, Facebook)');
            $table->enum('plataforma_video', ['youtube', 'vimeo', 'facebook', 'outro'])->nullable()->comment('Plataforma do vídeo');
            $table->text('thumbnail_url')->nullable()->comment('URL da thumbnail do vídeo');
            $table->integer('duracao_video')->nullable()->comment('Duração do vídeo em segundos');
            $table->text('descricao_video')->nullable()->comment('Descrição do vídeo gravado');
            $table->boolean('video_disponivel')->default(false)->comment('Se o vídeo está disponível para visualização');
            $table->timestamp('data_gravacao')->nullable()->comment('Data e hora da gravação');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessoes', function (Blueprint $table) {
            $table->dropColumn([
                'video_url',
                'plataforma_video', 
                'thumbnail_url',
                'duracao_video',
                'descricao_video',
                'video_disponivel',
                'data_gravacao'
            ]);
        });
    }
};
