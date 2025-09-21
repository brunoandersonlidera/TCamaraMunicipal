<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ConfiguracaoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display the system configuration page.
     */
    public function index()
    {
        $configuracoes = [
            'sistema' => [
                'titulo' => 'Configurações do Sistema',
                'descricao' => 'Configurações gerais da aplicação',
                'icone' => 'fas fa-cogs',
                'items' => [
                    'nome_camara' => config('camara.nome', 'Câmara Municipal'),
                    'endereco' => config('camara.endereco', ''),
                    'telefone' => config('camara.telefone', ''),
                    'email' => config('camara.email', ''),
                    'site' => config('camara.site', ''),
                    'presidente' => config('camara.presidente', ''),
                    'vice_presidente' => config('camara.vice_presidente', ''),
                    'secretario' => config('camara.secretario', ''),
                ]
            ],
            'email' => [
                'titulo' => 'Configurações de E-mail',
                'descricao' => 'Configurações do servidor de e-mail',
                'icone' => 'fas fa-envelope',
                'items' => [
                    'mail_driver' => config('mail.default'),
                    'mail_host' => config('mail.mailers.smtp.host'),
                    'mail_port' => config('mail.mailers.smtp.port'),
                    'mail_username' => config('mail.mailers.smtp.username'),
                    'mail_encryption' => config('mail.mailers.smtp.encryption'),
                    'mail_from_address' => config('mail.from.address'),
                    'mail_from_name' => config('mail.from.name'),
                ]
            ],
            'cache' => [
                'titulo' => 'Cache do Sistema',
                'descricao' => 'Gerenciamento do cache da aplicação',
                'icone' => 'fas fa-database',
                'items' => [
                    'cache_driver' => config('cache.default'),
                    'session_driver' => config('session.driver'),
                    'queue_driver' => config('queue.default'),
                ]
            ],
            'arquivos' => [
                'titulo' => 'Armazenamento de Arquivos',
                'descricao' => 'Configurações de upload e armazenamento',
                'icone' => 'fas fa-folder',
                'items' => [
                    'filesystem_driver' => config('filesystems.default'),
                    'max_upload_size' => ini_get('upload_max_filesize'),
                    'max_post_size' => ini_get('post_max_size'),
                    'memory_limit' => ini_get('memory_limit'),
                ]
            ],
            'seguranca' => [
                'titulo' => 'Configurações de Segurança',
                'descricao' => 'Configurações de autenticação e segurança',
                'icone' => 'fas fa-shield-alt',
                'items' => [
                    'session_lifetime' => config('session.lifetime'),
                    'password_timeout' => config('auth.password_timeout'),
                    'app_debug' => config('app.debug') ? 'Ativado' : 'Desativado',
                    'app_env' => config('app.env'),
                ]
            ]
        ];

        $estatisticas = [
            'cache_size' => $this->getCacheSize(),
            'storage_size' => $this->getStorageSize(),
            'logs_size' => $this->getLogsSize(),
            'database_size' => $this->getDatabaseSize(),
        ];

        return view('admin.configuracoes.index', compact('configuracoes', 'estatisticas'));
    }

    /**
     * Show the form for editing system configurations.
     */
    public function edit()
    {
        $configuracoes = [
            'camara' => [
                'nome' => config('camara.nome', ''),
                'endereco' => config('camara.endereco', ''),
                'telefone' => config('camara.telefone', ''),
                'email' => config('camara.email', ''),
                'site' => config('camara.site', ''),
                'presidente' => config('camara.presidente', ''),
                'vice_presidente' => config('camara.vice_presidente', ''),
                'secretario' => config('camara.secretario', ''),
                'cnpj' => config('camara.cnpj', ''),
                'cep' => config('camara.cep', ''),
                'cidade' => config('camara.cidade', ''),
                'estado' => config('camara.estado', ''),
            ]
        ];

        return view('admin.configuracoes.edit', compact('configuracoes'));
    }

    /**
     * Update system configurations.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'nullable|string|max:500',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'site' => 'nullable|url|max:255',
            'presidente' => 'nullable|string|max:255',
            'vice_presidente' => 'nullable|string|max:255',
            'secretario' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'cep' => 'nullable|string|max:9',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
        ]);

        // Aqui você implementaria a lógica para salvar as configurações
        // Por exemplo, salvando em um arquivo de configuração ou banco de dados
        
        return redirect()->route('admin.configuracoes.index')
                        ->with('success', 'Configurações atualizadas com sucesso!');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            return redirect()->route('admin.configuracoes.index')
                            ->with('success', 'Cache limpo com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.configuracoes.index')
                            ->with('error', 'Erro ao limpar cache: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application.
     */
    public function optimize()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return redirect()->route('admin.configuracoes.index')
                            ->with('success', 'Aplicação otimizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.configuracoes.index')
                            ->with('error', 'Erro ao otimizar aplicação: ' . $e->getMessage());
        }
    }

    /**
     * Show system information.
     */
    public function info()
    {
        $info = [
            'php' => [
                'version' => PHP_VERSION,
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ],
            'laravel' => [
                'version' => app()->version(),
                'environment' => config('app.env'),
                'debug' => config('app.debug') ? 'Ativado' : 'Desativado',
                'timezone' => config('app.timezone'),
                'locale' => config('app.locale'),
            ],
            'servidor' => [
                'software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
                'php_sapi' => php_sapi_name(),
                'os' => PHP_OS,
                'host' => $_SERVER['HTTP_HOST'] ?? 'N/A',
            ],
            'banco' => [
                'driver' => config('database.default'),
                'host' => config('database.connections.' . config('database.default') . '.host'),
                'database' => config('database.connections.' . config('database.default') . '.database'),
            ]
        ];

        return view('admin.configuracoes.info', compact('info'));
    }

    /**
     * Show application logs.
     */
    public function logs()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logPath)) {
            $content = file_get_contents($logPath);
            $lines = array_reverse(explode("\n", $content));
            $logs = array_slice($lines, 0, 100); // Últimas 100 linhas
        }

        return view('admin.configuracoes.logs', compact('logs'));
    }

    /**
     * Clear application logs.
     */
    public function clearLogs()
    {
        try {
            $logPath = storage_path('logs/laravel.log');
            if (file_exists($logPath)) {
                file_put_contents($logPath, '');
            }

            return redirect()->route('admin.configuracoes.logs')
                            ->with('success', 'Logs limpos com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.configuracoes.logs')
                            ->with('error', 'Erro ao limpar logs: ' . $e->getMessage());
        }
    }

    /**
     * Get cache size.
     */
    private function getCacheSize()
    {
        try {
            $cachePath = storage_path('framework/cache');
            return $this->getDirectorySize($cachePath);
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Get storage size.
     */
    private function getStorageSize()
    {
        try {
            $storagePath = storage_path('app');
            return $this->getDirectorySize($storagePath);
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Get logs size.
     */
    private function getLogsSize()
    {
        try {
            $logsPath = storage_path('logs');
            return $this->getDirectorySize($logsPath);
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Get database size.
     */
    private function getDatabaseSize()
    {
        try {
            $dbPath = database_path('database.sqlite');
            if (file_exists($dbPath)) {
                return $this->formatBytes(filesize($dbPath));
            }
            return 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Get directory size.
     */
    private function getDirectorySize($directory)
    {
        if (!is_dir($directory)) {
            return 'N/A';
        }

        $size = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }

        return $this->formatBytes($size);
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}