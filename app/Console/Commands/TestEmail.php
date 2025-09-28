<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Models\User;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email? : Email para enviar o teste}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o envio de emails com as configurações atuais';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'teste@exemplo.com';
        
        $this->info('Testando configurações de email...');
        $this->info('MAIL_MAILER: ' . config('mail.default'));
        $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        $this->info('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
        $this->info('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
        
        try {
            // Criar um usuário temporário para teste
            $testUser = new User([
                'name' => 'Teste Email',
                'email' => $email,
                'email_verification_token' => 'test-token-123'
            ]);
            
            $this->info("Enviando email de teste para: {$email}");
            
            Mail::raw('Este é um email de teste das configurações da Câmara Municipal.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Teste de Email - Câmara Municipal')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            $this->info('✅ Email de teste enviado com sucesso!');
            
        } catch (\Exception $e) {
            $this->error('❌ Erro ao enviar email: ' . $e->getMessage());
            $this->error('Detalhes: ' . $e->getTraceAsString());
        }
    }
}