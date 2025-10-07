<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Processa o login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Primeiro tenta autenticar como usuário administrativo
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();
            
            // Verifica se o usuário está ativo
            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Sua conta está inativa. Entre em contato com o administrador.',
                ]);
            }

            // Redireciona baseado no role
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'cidadao') {
                // Para cidadãos, também autenticar no guard cidadao
                Auth::guard('cidadao')->login($user, $remember);
                return redirect()->intended('/cidadao/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não conferem com nossos registros.',
        ]);
    }

    /**
     * Processa o logout
     */
    public function logout(Request $request)
    {
        // Fazer logout de ambos os guards
        Auth::logout();
        Auth::guard('cidadao')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Dashboard administrativo
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Estatísticas básicas
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::admins()->count(),
            'active_users' => User::active()->count(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }

    /**
     * Exibe formulário de primeiro acesso (criar admin)
     */
    public function showFirstAccessForm()
    {
        // Verifica se já existe algum admin
        if (User::admins()->exists()) {
            return redirect()->route('login')->with('error', 'Sistema já configurado.');
        }

        return view('auth.first-access');
    }

    /**
     * Cria o primeiro usuário administrador
     */
    public function createFirstAdmin(Request $request)
    {
        // Verifica se já existe algum admin
        if (User::admins()->exists()) {
            return redirect()->route('login')->with('error', 'Sistema já configurado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin',
            'active' => true,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Administrador criado com sucesso!');
    }
}
