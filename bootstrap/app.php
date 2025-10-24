<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'validate.autoria' => \App\Http\Middleware\ValidateAutoriaType::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'cidadao.auth' => \App\Http\Middleware\CidadaoAuth::class,
            'ouvidor' => \App\Http\Middleware\OuvidorMiddleware::class,
        ]);
    })
    ->withSchedule(function ($schedule) {
        // Processar encerramentos automáticos de solicitações E-SIC
        // Executa diariamente às 08:00
        $schedule->command('esic:processar-encerramentos')
                 ->dailyAt('08:00')
                 ->withoutOverlapping()
                 ->runInBackground()
                 ->appendOutputTo(storage_path('logs/esic-encerramentos.log'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
