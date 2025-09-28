<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $user = Auth::user();

        // Verificar se o usuário possui o role necessário
        if (!$user->hasRole($role)) {
            // Se for uma requisição AJAX, retornar JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Acesso negado. Você não possui permissão para acessar este recurso.',
                    'required_role' => $role
                ], 403);
            }

            // Para requisições normais, redirecionar com mensagem de erro
            return redirect()->back()->with('error', 'Acesso negado. Você não possui o perfil necessário para acessar esta página.');
        }

        return $next($request);
    }
}
