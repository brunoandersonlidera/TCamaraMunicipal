<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário Administrador Principal
        User::create([
            'name' => 'Administrador do Sistema',
            'email' => 'admin@camara.gov.br',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Secretário da Câmara
        User::create([
            'name' => 'João Silva Santos',
            'email' => 'secretario@camara.gov.br',
            'password' => Hash::make('secretario123'),
            'email_verified_at' => now(),
        ]);

        // Editor de Conteúdo
        User::create([
            'name' => 'Maria Oliveira Costa',
            'email' => 'editor@camara.gov.br',
            'password' => Hash::make('editor123'),
            'email_verified_at' => now(),
        ]);

        // Vereador Exemplo 1
        User::create([
            'name' => 'Carlos Eduardo Pereira',
            'email' => 'carlos.pereira@camara.gov.br',
            'password' => Hash::make('vereador123'),
            'email_verified_at' => now(),
        ]);

        // Vereador Exemplo 2
        User::create([
            'name' => 'Ana Paula Rodrigues',
            'email' => 'ana.rodrigues@camara.gov.br',
            'password' => Hash::make('vereador123'),
            'email_verified_at' => now(),
        ]);

        // Usuário Comum (Cidadão)
        User::create([
            'name' => 'José da Silva',
            'email' => 'jose.silva@email.com',
            'password' => Hash::make('usuario123'),
            'email_verified_at' => now(),
        ]);

        // Usuário para testes de e-SIC
        User::create([
            'name' => 'Pedro Santos Oliveira',
            'email' => 'pedro.santos@email.com',
            'password' => Hash::make('usuario123'),
            'email_verified_at' => now(),
        ]);

        // Responsável por e-SIC
        User::create([
            'name' => 'Fernanda Lima Costa',
            'email' => 'esic@camara.gov.br',
            'password' => Hash::make('esic123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Usuários criados com sucesso!');
        $this->command->info('Credenciais de acesso:');
        $this->command->info('Admin: admin@camara.gov.br / admin123');
        $this->command->info('Secretário: secretario@camara.gov.br / secretario123');
        $this->command->info('Editor: editor@camara.gov.br / editor123');
        $this->command->info('Vereadores: carlos.pereira@camara.gov.br / vereador123');
        $this->command->info('           ana.rodrigues@camara.gov.br / vereador123');
        $this->command->info('e-SIC: esic@camara.gov.br / esic123');
    }
}
