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
            // Se o caminho começar com /images/, usar asset() para public/images
            if (str_starts_with($this->valor, '/images/')) {
                return asset($this->valor);
            }
            // Caso contrário, usar Storage::url() para arquivos em storage
            return Storage::url($this->valor);
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
        return self::obterValor('brasao_camara');
    }

    public static function obterLogoFooter()
    {
        return self::obterValor('logo_footer');
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
}
