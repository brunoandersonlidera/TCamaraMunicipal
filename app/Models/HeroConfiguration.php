<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroConfiguration extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'botao_primario_texto',
        'botao_primario_link',
        'botao_primario_nova_aba',
        'botao_secundario_texto',
        'botao_secundario_link',
        'botao_secundario_nova_aba',
        'mostrar_slider',
        'ativo'
    ];

    protected $casts = [
        'botao_primario_nova_aba' => 'boolean',
        'botao_secundario_nova_aba' => 'boolean',
        'mostrar_slider' => 'boolean',
        'ativo' => 'boolean'
    ];

    /**
     * Obter a configuração ativa do hero section
     */
    public static function getActive()
    {
        return static::where('ativo', true)->first() ?? static::getDefault();
    }

    /**
     * Obter configuração padrão caso não exista nenhuma
     */
    public static function getDefault()
    {
        return new static([
            'titulo' => 'Câmara Municipal',
            'descricao' => 'Transparência, participação e representação democrática para nossa cidade.',
            'botao_primario_texto' => 'Transparência',
            'botao_primario_link' => '/transparencia',
            'botao_primario_nova_aba' => false,
            'botao_secundario_texto' => 'Vereadores',
            'botao_secundario_link' => '/vereadores',
            'botao_secundario_nova_aba' => false,
            'mostrar_slider' => true,
            'ativo' => true
        ]);
    }

    /**
     * Ativar esta configuração e desativar as outras
     */
    public function activate()
    {
        // Desativar todas as outras configurações
        static::where('id', '!=', $this->id)->update(['ativo' => false]);
        
        // Ativar esta configuração
        $this->update(['ativo' => true]);
        
        return $this;
    }
}
