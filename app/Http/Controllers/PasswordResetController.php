<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    /**
     * Exibe o formulário de solicitação de reset de senha
     */
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Processa a solicitação de reset de senha
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.exists' => 'Este email não está cadastrado em nosso sistema.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        // Verifica se o usuário está ativo
        if (!$user->active) {
            return back()->withErrors(['email' => 'Esta conta está inativa. Entre em contato com o administrador.']);
        }

        // Gera token de reset
        $token = Str::random(64);

        // Remove tokens antigos do usuário
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Cria novo token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        // Envia email
        try {
            Mail::to($user->email)->send(new PasswordReset($user, $token));
            
            return back()->with('status', 'Link de recuperação de senha enviado para seu email!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erro ao enviar email. Tente novamente mais tarde.']);
        }
    }

    /**
     * Exibe o formulário de reset de senha
     */
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Processa o reset de senha
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token inválido.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.exists' => 'Este email não está cadastrado em nosso sistema.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verifica se o token existe e é válido
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['token' => 'Token inválido ou expirado.']);
        }

        // Verifica se o token não expirou (24 horas)
        if (now()->diffInHours($passwordReset->created_at) > 24) {
            return back()->withErrors(['token' => 'Token expirado. Solicite um novo link de recuperação.']);
        }

        // Atualiza a senha do usuário
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Remove o token usado
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Senha alterada com sucesso! Faça login com sua nova senha.');
    }

    /**
     * Exibe a página de confirmação de envio
     */
    public function showLinkRequestDone()
    {
        return view('auth.passwords.sent');
    }
}