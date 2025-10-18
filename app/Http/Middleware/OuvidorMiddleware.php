<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OuvidorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta área.');
        }

        $user = Auth::user();

        // Verificar se o usuário é ouvidor ou admin
        if (!$user->isOuvidor() && !$user->isAdmin()) {
            abort(403, 'Acesso negado. Você não tem permissão para acessar a área do ouvidor.');
        }

        // Verificar se o ouvidor está ativo
        if ($user->isOuvidor() && !$user->active) {
            abort(403, 'Sua conta de ouvidor está inativa. Entre em contato com o administrador.');
        }

        return $next($request);
    }
}