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
        Schema::table('contrato_fiscalizacaos', function (Blueprint $table) {
            // Tornar numero_relatorio nullable
            $table->string('numero_relatorio')->nullable()->change();
            
            // Adicionar novos campos solicitados
            $table->date('data_fim_vigencia')->nullable()->after('data_fiscalizacao');
            $table->string('numero_portaria')->nullable()->after('fiscal_responsavel');
            $table->date('data_portaria')->nullable()->after('numero_portaria');
            $table->string('arquivo_pdf')->nullable()->after('arquivo_relatorio_original');
            $table->string('arquivo_pdf_original')->nullable()->after('arquivo_pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contrato_fiscalizacaos', function (Blueprint $table) {
            // Reverter numero_relatorio para not null
            $table->string('numero_relatorio')->nullable(false)->change();
            
            // Remover novos campos
            $table->dropColumn([
                'data_fim_vigencia',
                'numero_portaria', 
                'data_portaria',
                'arquivo_pdf',
                'arquivo_pdf_original'
            ]);
        });
    }
};
