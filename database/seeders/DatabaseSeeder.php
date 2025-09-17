<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🏛️ Iniciando população do banco de dados da Câmara Municipal...');
        
        // Executar seeders em ordem específica
        $this->call([
            UserSeeder::class,
            VereadorSeeder::class,
        ]);

        $this->command->info('✅ Banco de dados populado com sucesso!');
        $this->command->info('');
        $this->command->info('📋 Resumo dos dados criados:');
        $this->command->info('👥 Usuários: 8 usuários com diferentes roles');
        $this->command->info('🏛️ Vereadores: 3 vereadores com perfis completos');
        $this->command->info('');
        $this->command->info('🔑 Credenciais de acesso:');
        $this->command->info('🔧 Admin: admin@camara.gov.br / admin123');
        $this->command->info('📝 Secretário: secretario@camara.gov.br / secretario123');
        $this->command->info('✏️ Editor: editor@camara.gov.br / editor123');
        $this->command->info('🏛️ Vereadores: carlos.pereira@camara.gov.br / vereador123');
        $this->command->info('🏛️           ana.rodrigues@camara.gov.br / vereador123');
        $this->command->info('📊 e-SIC: esic@camara.gov.br / esic123');
    }
}
