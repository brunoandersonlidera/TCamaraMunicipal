<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfiguracaoGeral;

class ConfiguracaoGeralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configuracoes = [
            [
                'chave' => 'brasao_camara',
                'valor' => null,
                'tipo' => 'imagem',
                'descricao' => 'Brasão da Câmara Municipal exibido no header',
                'ativo' => true
            ],
            [
                'chave' => 'logo_footer',
                'valor' => null,
                'tipo' => 'imagem',
                'descricao' => 'Logo da Câmara Municipal exibida no footer',
                'ativo' => true
            ],
            [
                'chave' => 'endereco_camara',
                'valor' => 'Rua Principal, 123 - Centro - Cidade/UF - CEP: 12345-678',
                'tipo' => 'texto',
                'descricao' => 'Endereço completo da Câmara Municipal',
                'ativo' => true
            ],
            [
                'chave' => 'telefone_camara',
                'valor' => '(11) 1234-5678',
                'tipo' => 'telefone',
                'descricao' => 'Telefone principal da Câmara Municipal',
                'ativo' => true
            ],
            [
                'chave' => 'email_camara',
                'valor' => 'contato@camara.gov.br',
                'tipo' => 'email',
                'descricao' => 'E-mail principal da Câmara Municipal',
                'ativo' => true
            ],
            [
                'chave' => 'direitos_autorais',
                'valor' => '© 2025 Câmara Municipal. Todos os direitos reservados.',
                'tipo' => 'texto',
                'descricao' => 'Texto de direitos autorais exibido no footer',
                'ativo' => true
            ],
            [
                'chave' => 'nome_camara',
                'valor' => 'Câmara Municipal',
                'tipo' => 'texto',
                'descricao' => 'Nome oficial da Câmara Municipal',
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
}
