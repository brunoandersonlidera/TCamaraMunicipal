<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestPasswordHash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:test-hash {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o hash de senha de um usuário específico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuário com email {$email} não encontrado.");
            return 1;
        }

        $this->info("=== TESTE DE HASH DE SENHA ===");
        $this->info("Email: {$user->email}");
        $this->info("Nome: {$user->name}");
        $this->info("Hash atual no banco: " . substr($user->password, 0, 50) . "...");
        
        // Testa se a senha confere
        $passwordCheck = Hash::check($password, $user->password);
        
        if ($passwordCheck) {
            $this->info("✅ SUCESSO: A senha '{$password}' confere com o hash no banco!");
        } else {
            $this->error("❌ ERRO: A senha '{$password}' NÃO confere com o hash no banco!");
        }

        // Mostra como seria o hash se fosse feito agora
        $newHash = Hash::make($password);
        $this->info("Hash que seria gerado agora: " . substr($newHash, 0, 50) . "...");
        
        // Testa se o novo hash funcionaria
        $newHashCheck = Hash::check($password, $newHash);
        $this->info("Teste do novo hash: " . ($newHashCheck ? "✅ OK" : "❌ ERRO"));

        return 0;
    }
}