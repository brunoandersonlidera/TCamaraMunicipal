<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ConfiguracaoGeral extends Model
{
    protected $table = 'configuracao_gerais';
    
    protected $fillable = [
        'chave',
        'valor',
        'tipo',
        'descricao',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Obter valor de uma configuração por chave
     */
    public static function obterValor($chave, $padrao = null)
    {
        $config = self::where('chave', $chave)
                     ->where('ativo', true)
                     ->first();
        
        return $config ? $config->valor : $padrao;
    }

    /**
     * Definir valor de uma configuração
     */
    public static function definirValor($chave, $valor, $tipo = 'texto', $descricao = null)
    {
        return self::updateOrCreate(
            ['chave' => $chave],
            [
                'valor' => $valor,
                'tipo' => $tipo,
                'descricao' => $descricao,
                'ativo' => true
            ]
        );
    }

    /**
     * Obter URL completa para imagens
     */
    public function getUrlImagemAttribute()
    {
        if ($this->tipo === 'imagem' && $this->valor) {
            $valor = $this->valor;

            // Se já for URL absoluta, retorna como está
            if (preg_match('#^https?://#', $valor)) {
                return $valor;
            }

            // Se o caminho começar com /images/, usar asset() para public/images
            if (str_starts_with($valor, '/images/')) {
                return asset($valor);
            }

            // Caminhos via rota de mídia
            // Padronizar para /media/{file_name}, pois o controlador serve busca por file_name apenas
            if (str_starts_with($valor, '/media/')) {
                return '/media/' . basename($valor);
            }
            if (str_starts_with($valor, 'media/')) {
                return '/media/' . basename($valor);
            }

            // Caminhos armazenados em storage (ex.: public/configuracoes/...)
            // Normaliza valores que vieram salvos com prefixo /storage ou storage
            $path = ltrim($valor, '/');
            $path = preg_replace('#^storage/#', '', $path);
            // Remove barras duplas que podem ter sido salvas incorretamente
            $path = preg_replace('#/+#', '/', $path);
            return '/media/' . basename($path);
        }
        return null;
    }

    /**
     * Obter todas as configurações organizadas por chave
     */
    public static function obterTodasConfiguracoes()
    {
        return self::where('ativo', true)
                  ->pluck('valor', 'chave')
                  ->toArray();
    }

    /**
     * Configurações específicas do sistema
     */
    public static function obterBrasao()
    {
        $config = self::where('chave', 'brasao_camara')
                     ->where('ativo', true)
                     ->first();

        if (!$config || empty($config->valor)) {
            return null;
        }

        $valor = $config->valor;

        // Se já for URL absoluta, retorna
        if (preg_match('#^https?://#', $valor)) {
            return $valor;
        }

        // Caminhos em public/images
        if (str_starts_with($valor, '/images/')) {
            return asset($valor);
        }
        if (str_starts_with($valor, 'images/')) {
            return asset('/' . $valor);
        }

        // Caminhos via rota de mídia
        // Padronizar para /media/{file_name}, pois o controlador serve busca por file_name apenas
        if (str_starts_with($valor, '/media/')) {
            return '/media/' . basename($valor);
        }
        if (str_starts_with($valor, 'media/')) {
            return '/media/' . basename($valor);
        }

        // Caminhos armazenados em storage (ex.: public/configuracoes/...)
        // Normaliza valores que vieram salvos com prefixo /storage ou storage
        $path = ltrim($valor, '/');
        $path = preg_replace('#^storage/#', '', $path);
        // Remove barras duplas que podem ter sido salvas incorretamente
        $path = preg_replace('#/+#', '/', $path);
        return \Illuminate\Support\Facades\Storage::url($path);
    }

    /**
     * Obter brasão com URL absoluta (para e-mails)
     */
    public static function obterBrasaoAbsoluto()
    {
        $config = self::where('chave', 'brasao_camara')
                     ->where('ativo', true)
                     ->first();

        if (!$config || empty($config->valor)) {
            return null;
        }

        $valor = $config->valor;

        // Se já for URL absoluta, retorna
        if (preg_match('#^https?://#', $valor)) {
            return $valor;
        }

        // Obter URL base da aplicação
        $baseUrl = config('app.url');
        if (empty($baseUrl) || $baseUrl === 'auto') {
            // Detectar automaticamente se APP_URL não estiver configurado
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8080';
            $baseUrl = $protocol . '://' . $host;
        }

        // Caminhos em public/images
        if (str_starts_with($valor, '/images/')) {
            return $baseUrl . $valor;
        }
        if (str_starts_with($valor, 'images/')) {
            return $baseUrl . '/' . $valor;
        }

        // Caminhos via rota de mídia
        if (str_starts_with($valor, '/media/')) {
            return $baseUrl . '/media/' . basename($valor);
        }
        if (str_starts_with($valor, 'media/')) {
            return $baseUrl . '/media/' . basename($valor);
        }

        // Caminhos armazenados em storage
        $path = ltrim($valor, '/');
        $path = preg_replace('#^storage/#', '', $path);
        $path = preg_replace('#/+#', '/', $path);
        return $baseUrl . '/storage/' . $path;
    }

    public static function obterLogoFooter()
    {
        $config = self::where('chave', 'logo_footer')
                     ->where('ativo', true)
                     ->first();

        if (!$config || empty($config->valor)) {
            return null;
        }

        $valor = $config->valor;

        // Se já for URL absoluta, retorna
        if (preg_match('#^https?://#', $valor)) {
            return $valor;
        }

        // Caminhos em public/images
        if (str_starts_with($valor, '/images/')) {
            return asset($valor);
        }
        if (str_starts_with($valor, 'images/')) {
            return asset('/' . $valor);
        }

        // Caminhos via rota de mídia (padronizar para /media/{file_name})
        if (str_starts_with($valor, '/media/')) {
            return '/media/' . basename($valor);
        }
        if (str_starts_with($valor, 'media/')) {
            return '/media/' . basename($valor);
        }

        // Caminhos armazenados em storage (ex.: public/configuracoes/...)
        // Normaliza valores que vieram salvos com prefixo /storage ou storage
        $path = ltrim($valor, '/');
        $path = preg_replace('#^storage/#', '', $path);
        // Remove barras duplas que podem ter sido salvas incorretamente
        $path = preg_replace('#/+#', '/', $path);
        return \Illuminate\Support\Facades\Storage::url($path);
    }

    public static function obterLogoLogin()
    {
        $config = self::where('chave', 'logo_login')
                     ->where('ativo', true)
                     ->first();

        if (!$config || empty($config->valor)) {
            return null;
        }

        $valor = $config->valor;

        // Se já for URL absoluta, retorna
        if (preg_match('#^https?://#', $valor)) {
            return $valor;
        }

        // Caminhos em public/images
        if (str_starts_with($valor, '/images/')) {
            return asset($valor);
        }
        if (str_starts_with($valor, 'images/')) {
            return asset('/' . $valor);
        }

        // Caminhos via rota de mídia (padronizar para /media/{file_name})
        if (str_starts_with($valor, '/media/')) {
            return '/media/' . basename($valor);
        }
        if (str_starts_with($valor, 'media/')) {
            return '/media/' . basename($valor);
        }

        // Caminhos armazenados em storage (ex.: public/configuracoes/...)
        // Normaliza valores que vieram salvos com prefixo /storage ou storage
        $path = ltrim($valor, '/');
        $path = preg_replace('#^storage/#', '', $path);
        // Remove barras duplas que podem ter sido salvas incorretamente
        $path = preg_replace('#/+#', '/', $path);
        return \Illuminate\Support\Facades\Storage::url($path);
    }

    public static function obterEndereco()
    {
        return self::obterValor('endereco_camara', 'Endereço não informado');
    }

    public static function obterTelefone()
    {
        return self::obterValor('telefone_camara', 'Telefone não informado');
    }

    public static function obterEmail()
    {
        return self::obterValor('email_camara', 'email@camara.gov.br');
    }

    public static function obterDireitosAutorais()
    {
        return self::obterValor('direitos_autorais', '© 2025 Câmara Municipal. Todos os direitos reservados.');
    }

    /**
     * Configurações específicas do município
     */
    public static function obterNomeMunicipio()
    {
        return self::obterValor('nome_municipio', 'Município não informado');
    }

    public static function obterQuantidadeHabitantes()
    {
        return (int) self::obterValor('quantidade_habitantes', 0);
    }

    public static function obterQuantidadeEleitores()
    {
        return (int) self::obterValor('quantidade_eleitores', 0);
    }

    /**
     * Calcular quantidade mínima de assinaturas para iniciativa popular
     * Baseado em 5% do eleitorado (conforme Lei Orgânica padrão)
     */
    public static function calcularMinimoAssinaturas()
    {
        $eleitores = self::obterQuantidadeEleitores();
        return max(1, ceil($eleitores * 0.05)); // Mínimo 5% dos eleitores
    }

    /**
     * Obter percentual de assinaturas necessárias
     */
    public static function obterPercentualAssinaturas()
    {
        return (float) self::obterValor('percentual_assinaturas', 5.0);
    }

    /**
     * Calcular quantidade mínima de assinaturas com percentual customizável
     */
    public static function calcularMinimoAssinaturasCustom()
    {
        $eleitores = self::obterQuantidadeEleitores();
        $percentual = self::obterPercentualAssinaturas() / 100;
        return max(1, ceil($eleitores * $percentual));
    }
}
