<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate para verificar se o usuário pode visualizar relatórios
        Gate::define('visualizar-relatorios', function ($user) {
            return $user && $user->canVisualizarRelatorios();
        });

        // Gate para verificar se o usuário pode gerenciar ouvidoria
        Gate::define('gerenciar-ouvidoria', function ($user) {
            return $user && method_exists($user, 'canGerenciarOuvidoria') ? $user->canGerenciarOuvidoria() : false;
        });
    }
}