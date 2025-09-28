<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todos os usuários do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::select('id', 'name', 'email', 'role', 'active')->get();

        if ($users->isEmpty()) {
            $this->info('Nenhum usuário encontrado no banco de dados.');
            return 0;
        }

        $this->info('=== USUÁRIOS DO SISTEMA ===');
        
        foreach ($users as $user) {
            $status = $user->active ? '✅ Ativo' : '❌ Inativo';
            $this->line("{$user->id} - {$user->name} ({$user->email}) - {$user->role} - {$status}");
        }

        $this->info("\nTotal: {$users->count()} usuários");

        return 0;
    }
}