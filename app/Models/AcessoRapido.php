<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcessoRapido extends Model
{
    protected $table = 'acesso_rapido';

    protected $fillable = [
        'nome',
        'descricao',
        'url',
        'icone',
        'cor_botao',
        'cor_fonte',
        'ordem',
        'ativo',
        'abrir_nova_aba'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'abrir_nova_aba' => 'boolean',
        'ordem' => 'integer'
    ];

    /**
     * Scope para buscar apenas itens ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para ordenar por ordem
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem', 'asc');
    }

    /**
     * Verifica se a URL é externa
     */
    public function isUrlExterna()
    {
        return filter_var($this->url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Retorna a URL formatada
     */
    public function getUrlFormatada()
    {
        if ($this->isUrlExterna()) {
            return $this->url;
        }
        
        // Se não for URL externa, assume que é uma rota interna
        return url($this->url);
    }

    /**
     * Retorna o target do link
     */
    public function getTarget()
    {
        return $this->abrir_nova_aba ? '_blank' : '_self';
    }
}
