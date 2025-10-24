<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OuvidorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar se já existe um ouvidor
        if (!User::where('role', 'ouvidor')->exists()) {
            User::create([
                'name' => 'Ouvidor Teste',
                'email' => 'ouvidor@teste.com',
                'password' => Hash::make('123456'),
                'role' => 'ouvidor',
                'active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('Usuário ouvidor criado com sucesso!');
            $this->command->info('Email: ouvidor@teste.com');
            $this->command->info('Senha: 123456');
        } else {
            $this->command->info('Usuário ouvidor já existe.');
        }
    }
}