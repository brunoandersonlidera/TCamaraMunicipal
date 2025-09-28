<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroConfiguration;

class HeroConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar configurações existentes
        HeroConfiguration::truncate();
        
        // Criar configuração padrão
        HeroConfiguration::create([
            'titulo' => 'Bem-vindo à Câmara Municipal',
            'descricao' => 'Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. Acompanhe as atividades legislativas e participe da vida política da sua cidade.',
            'botao_primario_texto' => 'Portal da Transparência',
            'botao_primario_link' => '#',
            'botao_primario_nova_aba' => true,
            'botao_secundario_texto' => 'Conheça os Vereadores',
            'botao_secundario_link' => '/vereadores',
            'botao_secundario_nova_aba' => false,
            'mostrar_slider' => true,
            'ativo' => true
        ]);
        
        $this->command->info('✅ Configuração padrão do hero section criada com sucesso!');
    }
}
