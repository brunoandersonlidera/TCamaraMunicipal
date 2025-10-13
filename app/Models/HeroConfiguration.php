<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroConfiguration extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'imagem_topo_id',
        'imagem_topo_altura_px',
        'centralizar_imagem_topo',
        'imagem_descricao_id',
        'imagem_descricao_altura_px',
        'imagem_descricao_largura_px',
        'centralizar_imagem_descricao',
        'botao_primario_texto',
        'botao_primario_link',
        'botao_primario_nova_aba',
        'botao_secundario_texto',
        'botao_secundario_link',
        'botao_secundario_nova_aba',
        'mostrar_slider',
        'ativo',
        // Novos campos de slider/hero
        'intervalo',
        'transicao',
        'autoplay',
        'pausar_hover',
        'mostrar_indicadores',
        'mostrar_controles'
    ];

    protected $casts = [
        'botao_primario_nova_aba' => 'boolean',
        'botao_secundario_nova_aba' => 'boolean',
        'mostrar_slider' => 'boolean',
        'ativo' => 'boolean',
        'imagem_topo_id' => 'integer',
        'imagem_topo_altura_px' => 'integer',
        'centralizar_imagem_topo' => 'boolean',
        'imagem_descricao_id' => 'integer',
        'imagem_descricao_altura_px' => 'integer',
        'imagem_descricao_largura_px' => 'integer',
        'centralizar_imagem_descricao' => 'boolean',
        // Casts dos novos campos
        'intervalo' => 'integer',
        'autoplay' => 'boolean',
        'pausar_hover' => 'boolean',
        'mostrar_indicadores' => 'boolean',
        'mostrar_controles' => 'boolean'
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

    /**
     * Relações com a biblioteca de mídia
     */
    public function imagemTopo()
    {
        return $this->belongsTo(\App\Models\Media::class, 'imagem_topo_id');
    }

    public function imagemDescricao()
    {
        return $this->belongsTo(\App\Models\Media::class, 'imagem_descricao_id');
    }
}
