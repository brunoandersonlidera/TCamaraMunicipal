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
        User::updateOrCreate(
            ['email' => 'admin@camara.gov.br'],
            [
                'name' => 'Administrador do Sistema',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Secretário da Câmara
        User::updateOrCreate(
            ['email' => 'secretario@camara.gov.br'],
            [
                'name' => 'João Silva Santos',
                'password' => Hash::make('secretario123'),
                'email_verified_at' => now(),
            ]
        );

        // Editor de Conteúdo
        User::updateOrCreate(
            ['email' => 'editor@camara.gov.br'],
            [
                'name' => 'Maria Oliveira Costa',
                'password' => Hash::make('editor123'),
                'email_verified_at' => now(),
            ]
        );

        // Vereador Exemplo 1
        User::updateOrCreate(
            ['email' => 'carlos.pereira@camara.gov.br'],
            [
                'name' => 'Carlos Eduardo Pereira',
                'password' => Hash::make('vereador123'),
                'email_verified_at' => now(),
            ]
        );

        // Vereador Exemplo 2
        User::updateOrCreate(
            ['email' => 'ana.rodrigues@camara.gov.br'],
            [
                'name' => 'Ana Paula Rodrigues',
                'password' => Hash::make('vereador123'),
                'email_verified_at' => now(),
            ]
        );

        // Usuário Comum (Cidadão)
        User::updateOrCreate(
            ['email' => 'jose.silva@email.com'],
            [
                'name' => 'José da Silva',
                'password' => Hash::make('usuario123'),
                'email_verified_at' => now(),
            ]
        );

        // Usuário para testes de e-SIC
        User::updateOrCreate(
            ['email' => 'pedro.santos@email.com'],
            [
                'name' => 'Pedro Santos Oliveira',
                'password' => Hash::make('usuario123'),
                'email_verified_at' => now(),
            ]
        );

        // Responsável por e-SIC
        User::updateOrCreate(
            ['email' => 'esic@camara.gov.br'],
            [
                'name' => 'Fernanda Lima Costa',
                'password' => Hash::make('esic123'),
                'email_verified_at' => now(),
            ]
        );

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
