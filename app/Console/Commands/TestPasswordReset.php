<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestPasswordReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:test-reset {email} {newPassword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o reset de senha simulando o processo do PasswordResetController';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $newPassword = $this->argument('newPassword');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuário com email {$email} não encontrado.");
            return 1;
        }

        $this->info("=== TESTE DE RESET DE SENHA ===");
        $this->info("Email: {$user->email}");
        $this->info("Nome: {$user->name}");
        
        // Mostra o hash atual
        $oldHash = $user->password;
        $this->info("Hash ANTES do reset: " . substr($oldHash, 0, 50) . "...");

        // Simula o processo do PasswordResetController (SEM Hash::make)
        $user->password = $newPassword; // O mutator do modelo fará o hash
        $user->save();

        // Recarrega o usuário do banco
        $user->refresh();
        $newHash = $user->password;
        $this->info("Hash DEPOIS do reset: " . substr($newHash, 0, 50) . "...");

        // Testa se a nova senha funciona
        $passwordCheck = Hash::check($newPassword, $user->password);
        
        if ($passwordCheck) {
            $this->info("✅ SUCESSO: A nova senha '{$newPassword}' confere com o hash no banco!");
            $this->info("✅ O reset de senha está funcionando corretamente!");
        } else {
            $this->error("❌ ERRO: A nova senha '{$newPassword}' NÃO confere com o hash no banco!");
            $this->error("❌ Ainda há problema com o reset de senha!");
        }

        // Verifica se o hash mudou
        if ($oldHash !== $newHash) {
            $this->info("✅ O hash da senha foi alterado corretamente.");
        } else {
            $this->error("❌ O hash da senha NÃO foi alterado!");
        }

        return $passwordCheck ? 0 : 1;
    }
}