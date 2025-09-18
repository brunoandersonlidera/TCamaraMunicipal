<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar se já existe um admin
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@camara.gov.br',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('Usuário administrador criado com sucesso!');
            $this->command->info('Email: admin@camara.gov.br');
            $this->command->info('Senha: admin123');
            $this->command->warn('IMPORTANTE: Altere a senha após o primeiro login!');
        } else {
            $this->command->info('Usuário administrador já existe.');
        }
    }
}
