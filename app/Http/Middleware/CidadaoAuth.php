<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CidadaoAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o cidadão está autenticado no guard cidadao
        if (!Auth::guard('cidadao')->check()) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $user = Auth::guard('cidadao')->user();

        // Verificar se o usuário tem role cidadao e está ativo
        if ($user->role !== 'cidadao' || !$user->active) {
            Auth::guard('cidadao')->logout();
            return redirect()->route('login')
                ->with('error', 'Sua conta não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}
