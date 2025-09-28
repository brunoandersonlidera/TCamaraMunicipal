<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $user = Auth::user();

        // Verificar se o usuário possui a permissão necessária
        if (!$user->can($permission)) {
            // Se for uma requisição AJAX, retornar JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Acesso negado. Você não possui permissão para realizar esta ação.',
                    'required_permission' => $permission
                ], 403);
            }

            // Para requisições normais, redirecionar com mensagem de erro
            return redirect()->back()->with('error', 'Acesso negado. Você não possui permissão para realizar esta ação.');
        }

        return $next($request);
    }
}
