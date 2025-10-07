<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\EmailVerification;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Exibe o formulário de cadastro
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Processa o cadastro do usuário
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:users,cpf',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'data_nascimento' => 'required|date|before:today',
            'sexo' => 'required|in:M,F',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'required|string|max:20',
            'terms' => 'required|accepted',
            'privacy' => 'required|accepted',
        ], [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_completo.max' => 'O nome completo não pode ter mais de 255 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter 14 caracteres (com pontos e hífen).',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'sexo.required' => 'O sexo é obrigatório.',
            'sexo.in' => 'O sexo deve ser Masculino ou Feminino.',
            'celular.required' => 'O celular é obrigatório.',
            'terms.required' => 'Você deve aceitar os termos de uso.',
            'terms.accepted' => 'Você deve aceitar os termos de uso.',
            'privacy.required' => 'Você deve aceitar a política de privacidade.',
            'privacy.accepted' => 'Você deve aceitar a política de privacidade.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Criar usuário com todos os dados
            $user = User::create([
                'name' => $request->nome_completo,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'cidadao',
                'email_verification_token' => Str::random(60),
                'terms_accepted_at' => now(),
                'privacy_accepted_at' => now(),
                'cpf' => $request->cpf,
                'data_nascimento' => $request->data_nascimento,
                'sexo' => $request->sexo,
                'telefone' => $request->telefone,
                'celular' => $request->celular,
                'status_verificacao' => 'pendente',
            ]);

            // Enviar email de verificação
            $this->sendVerificationEmailUser($user);

            return redirect()->route('register.success')
                           ->with('email', $user->email)
                           ->with('message', 'Cadastro realizado com sucesso! Verifique seu e-mail para ativar sua conta.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar conta: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Exibe a página de sucesso do cadastro
     */
    public function registrationSuccess()
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('register');
        }

        return view('auth.register-success', compact('email'));
    }

    /**
     * Verifica o email do usuário
     */
    public function verifyEmail(Request $request, $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                           ->with('error', 'Token de verificação inválido ou expirado.');
        }

        // Verificar se o token não expirou (24 horas)
        if ($user->created_at->diffInHours(now()) > 24) {
            return redirect()->route('login')
                           ->with('error', 'Token de verificação expirado. Solicite um novo.');
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_token' => null,
            'active' => true, // Ativar a conta após verificação
        ]);

        // Se for cidadão, marcar como verificado
        if ($user->role === 'cidadao') {
            $user->update([
                'verificado' => true,
            ]);
        }

        $message = $user->role === 'cidadao' 
            ? 'E-mail verificado com sucesso! Sua conta de cidadão foi ativada. Você já pode fazer login.'
            : 'E-mail verificado com sucesso! Você já pode fazer login.';

        return redirect()->route('login')->with('success', $message);
    }

    /**
     * Reenvia o email de verificação
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Este e-mail não está cadastrado.');
        }

        if ($user->email_verified_at) {
            return back()->with('error', 'Este e-mail já foi verificado.');
        }

        // Gerar novo token
        $user->update([
            'email_verification_token' => Str::random(60),
        ]);

        // Enviar email
        $this->sendVerificationEmailUser($user);

        return back()->with('success', 'Email de verificação reenviado com sucesso!');
    }

    /**
     * Exibe formulário para reenvio de verificação
     */
    public function showResendForm()
    {
        return view('auth.resend-verification');
    }

    /**
     * Envia email de verificação para usuário
     */
    private function sendVerificationEmailUser(User $user)
    {
        try {
            Mail::to($user->email)->send(new EmailVerification($user));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email de verificação: ' . $e->getMessage());
            // Não falhar o cadastro por causa do email
        }
    }

    /**
     * Exibe os termos de uso
     */
    public function showTerms()
    {
        return view('auth.terms');
    }

    /**
     * Exibe a política de privacidade
     */
    public function showPrivacy()
    {
        return view('auth.privacy');
    }
}