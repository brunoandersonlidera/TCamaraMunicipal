<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ConfiguracaoGeral;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Adicionar configurações de favicon
        $configuracoes = [
            [
                'chave' => 'favicon_site',
                'valor' => '/images/favicon.svg',
                'tipo' => 'imagem',
                'descricao' => 'Favicon do site (formato .ico, .png ou .svg)',
                'ativo' => true
            ],
            [
                'chave' => 'favicon_apple_touch',
                'valor' => '/images/apple-touch-icon.svg',
                'tipo' => 'imagem',
                'descricao' => 'Ícone para dispositivos Apple (180x180px)',
                'ativo' => true
            ],
            [
                'chave' => 'favicon_32x32',
                'valor' => '/images/favicon-32x32.svg',
                'tipo' => 'imagem',
                'descricao' => 'Favicon 32x32 pixels',
                'ativo' => true
            ],
            [
                'chave' => 'favicon_16x16',
                'valor' => '/images/favicon-16x16.svg',
                'tipo' => 'imagem',
                'descricao' => 'Favicon 16x16 pixels',
                'ativo' => true
            ]
        ];

        foreach ($configuracoes as $config) {
            ConfiguracaoGeral::updateOrCreate(
                ['chave' => $config['chave']],
                $config
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover configurações de favicon
        $chaves = [
            'favicon_site',
            'favicon_apple_touch',
            'favicon_32x32',
            'favicon_16x16'
        ];

        ConfiguracaoGeral::whereIn('chave', $chaves)->delete();
    }
};
