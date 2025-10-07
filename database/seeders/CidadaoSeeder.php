<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cidadao;
use Illuminate\Support\Facades\Hash;

class CidadaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar cidadão de teste
        Cidadao::create([
            'nome_completo' => 'João Silva Santos',
            'email' => 'joao.silva@email.com',
            'cpf' => '12345678901',
            'data_nascimento' => '1985-05-15',
            'sexo' => 'M',
            'celular' => '(11) 99999-9999',
            'telefone' => '(11) 3333-4444',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'ativo' => true,
            // Endereço obrigatório
            'cep' => '01234567',
            'endereco' => 'Rua das Flores',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            // Dados eleitorais obrigatórios
            'titulo_eleitor' => '123456789012',
            'zona_eleitoral' => '0001',
            'secao_eleitoral' => '0001',
            // Termos
            'aceite_termos' => true,
            'aceite_termos_em' => now(),
            'aceite_lgpd' => true,
            'aceite_lgpd_em' => now(),
        ]);

        // Criar cidadã de teste
        Cidadao::create([
            'nome_completo' => 'Maria Oliveira Costa',
            'email' => 'maria.oliveira@email.com',
            'cpf' => '98765432109',
            'data_nascimento' => '1990-08-22',
            'sexo' => 'F',
            'celular' => '(11) 88888-8888',
            'telefone' => null,
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'ativo' => true,
            // Endereço obrigatório
            'cep' => '09876543',
            'endereco' => 'Avenida Brasil',
            'numero' => '456',
            'bairro' => 'Vila Nova',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            // Dados eleitorais obrigatórios
            'titulo_eleitor' => '987654321098',
            'zona_eleitoral' => '0002',
            'secao_eleitoral' => '0002',
            // Termos
            'aceite_termos' => true,
            'aceite_termos_em' => now(),
            'aceite_lgpd' => true,
            'aceite_lgpd_em' => now(),
        ]);

        $this->command->info('Cidadãos de teste criados com sucesso!');
    }
}
