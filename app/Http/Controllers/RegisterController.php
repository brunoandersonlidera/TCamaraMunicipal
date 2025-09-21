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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
            'privacy' => 'required|accepted',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'terms.required' => 'Você deve aceitar os termos de uso.',
            'terms.accepted' => 'Você deve aceitar os termos de uso.',
            'privacy.required' => 'Você deve aceitar a política de privacidade.',
            'privacy.accepted' => 'Você deve aceitar a política de privacidade.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Criar o usuário
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password, // O mutator já faz o hash
                'role' => 'user',
                'active' => true,
                'email_verification_token' => Str::random(60),
                'terms_accepted_at' => now(),
                'privacy_accepted_at' => now(),
            ]);

            // Enviar email de verificação
            $this->sendVerificationEmail($user);

            return redirect()->route('register.success')
                           ->with('email', $user->email);

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

        // Verificar email
        $user->update([
            'email_verified_at' => now(),
            'email_verification_token' => null,
        ]);

        return redirect()->route('login')
                       ->with('success', 'Email verificado com sucesso! Você já pode fazer login.');
    }

    /**
     * Reenvia o email de verificação
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.exists' => 'Este e-mail não está cadastrado.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return back()->with('error', 'Este e-mail já foi verificado.');
        }

        // Gerar novo token
        $user->update([
            'email_verification_token' => Str::random(60),
        ]);

        // Enviar email
        $this->sendVerificationEmail($user);

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
     * Envia email de verificação
     */
    private function sendVerificationEmail(User $user)
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