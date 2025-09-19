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
        Schema::create('projeto_lei_coautor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_lei_id')->constrained('projetos_lei')->onDelete('cascade');
            $table->foreignId('vereador_id')->constrained('vereadores')->onDelete('cascade');
            $table->timestamps();
            
            // Índices
            $table->unique(['projeto_lei_id', 'vereador_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projeto_lei_coautor');
    }
};
