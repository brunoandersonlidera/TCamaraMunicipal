<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ouvidor']);
    }

    /**
     * Exibir o perfil do ouvidor
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('ouvidor.perfil.index', compact('user'));
    }

    /**
     * Atualizar o perfil do ouvidor
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telefone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Verificar senha atual se uma nova senha foi fornecida
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
            }
        }

        // Atualizar dados do usuário
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
        ]);

        // Atualizar senha se fornecida
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}