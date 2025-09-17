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
            'password' => 'admin123',
            'role' => 'admin',
            'status' => true,
            'cargo' => 'Administrador do Sistema',
            'departamento' => 'TI',
            'telefone' => '11999999999',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Secretário da Câmara
        User::create([
            'name' => 'João Silva Santos',
            'email' => 'secretario@camara.gov.br',
            'password' => 'secretario123',
            'role' => 'secretario',
            'status' => true,
            'cargo' => 'Secretário da Câmara',
            'departamento' => 'Secretaria',
            'telefone' => '11988888888',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Editor de Conteúdo
        User::create([
            'name' => 'Maria Oliveira Costa',
            'email' => 'editor@camara.gov.br',
            'password' => 'editor123',
            'role' => 'editor',
            'status' => true,
            'cargo' => 'Assessora de Comunicação',
            'departamento' => 'Comunicação',
            'telefone' => '11977777777',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Vereador Exemplo 1
        User::create([
            'name' => 'Carlos Eduardo Pereira',
            'email' => 'carlos.pereira@camara.gov.br',
            'password' => 'vereador123',
            'role' => 'vereador',
            'status' => true,
            'cargo' => 'Vereador',
            'departamento' => 'Legislativo',
            'telefone' => '11966666666',
            'bio' => 'Vereador eleito para o mandato 2021-2024, com foco em educação e saúde pública.',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Vereador Exemplo 2
        User::create([
            'name' => 'Ana Paula Rodrigues',
            'email' => 'ana.rodrigues@camara.gov.br',
            'password' => 'vereador123',
            'role' => 'vereador',
            'status' => true,
            'cargo' => 'Vereadora',
            'departamento' => 'Legislativo',
            'telefone' => '11955555555',
            'bio' => 'Vereadora com experiência em políticas sociais e direitos da mulher.',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuário Comum (Cidadão)
        User::create([
            'name' => 'José da Silva',
            'email' => 'jose.silva@email.com',
            'password' => 'usuario123',
            'role' => 'user',
            'status' => true,
            'telefone' => '11944444444',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuário para testes de e-SIC
        User::create([
            'name' => 'Pedro Santos Oliveira',
            'email' => 'pedro.santos@email.com',
            'password' => 'usuario123',
            'role' => 'user',
            'status' => true,
            'telefone' => '11933333333',
            'cpf' => '12345678901',
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Responsável por e-SIC
        User::create([
            'name' => 'Fernanda Lima Costa',
            'email' => 'esic@camara.gov.br',
            'password' => 'esic123',
            'role' => 'editor',
            'status' => true,
            'cargo' => 'Responsável e-SIC',
            'departamento' => 'Transparência',
            'telefone' => '11922222222',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
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
