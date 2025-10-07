<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AutoUrlServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Se APP_URL estiver configurado como 'auto', detectar automaticamente
        if (config('app.url') === 'auto') {
            $this->setAutoUrl();
        }
    }

    /**
     * Define a URL automaticamente baseada no request atual
     */
    private function setAutoUrl(): void
    {
        if (app()->runningInConsole()) {
            // Para comandos artisan, usar localhost como padrão
            $url = 'http://localhost';
        } else {
            // Para requests web, detectar automaticamente
            $request = request();
            
            // Detectar protocolo
            $protocol = $request->isSecure() ? 'https' : 'http';
            
            // Detectar host
            $host = $request->getHost();
            
            // Detectar porta (se não for padrão)
            $port = $request->getPort();
            $portString = '';
            
            if (($protocol === 'http' && $port !== 80) || 
                ($protocol === 'https' && $port !== 443)) {
                $portString = ':' . $port;
            }
            
            $url = $protocol . '://' . $host . $portString;
        }
        
        // Definir a URL da aplicação
        config(['app.url' => $url]);
        URL::forceRootUrl($url);
    }
}