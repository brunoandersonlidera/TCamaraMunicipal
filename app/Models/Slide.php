<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'imagem',
        'link',
        'nova_aba',
        'ordem',
        'ativo',
        'velocidade',
        'transicao',
        'direcao'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'nova_aba' => 'boolean',
        'velocidade' => 'integer',
        'ordem' => 'integer'
    ];

    /**
     * Obter URL completa da imagem
     */
    public function getUrlImagemAttribute()
    {
        if ($this->imagem) {
            // Se for uma URL externa (http/https), retornar diretamente
            if (str_starts_with($this->imagem, 'http://') || str_starts_with($this->imagem, 'https://')) {
                return $this->imagem;
            }
            // Se o caminho começar com /images/, usar asset() para public/images
            if (str_starts_with($this->imagem, '/images/')) {
                return asset($this->imagem);
            }
            // Caso contrário, usar Storage::url() para arquivos em storage
            return Storage::url($this->imagem);
        }
        return null;
    }

    /**
     * Obter slides ativos ordenados
     */
    public static function getSlidesAtivos()
    {
        return self::where('ativo', true)
                  ->orderBy('ordem')
                  ->orderBy('created_at')
                  ->get();
    }

    /**
     * Obter próxima ordem disponível
     */
    public static function getProximaOrdem()
    {
        return self::max('ordem') + 1;
    }

    /**
     * Scope para slides ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para ordenação
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('created_at');
    }

    /**
     * Obter opções de transição
     */
    public static function getOpcoesTransicao()
    {
        return [
            'fade' => 'Fade (Desvanecer)',
            'slide' => 'Slide (Deslizar)',
            'zoom' => 'Zoom (Ampliar)'
        ];
    }

    /**
     * Obter opções de direção
     */
    public static function getOpcoesDirecao()
    {
        return [
            'left' => 'Esquerda',
            'right' => 'Direita',
            'up' => 'Cima',
            'down' => 'Baixo'
        ];
    }
}
