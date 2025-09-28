<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaginaConteudo extends Model
{
    use SoftDeletes;

    protected $table = 'paginas_conteudo';

    protected $fillable = [
        'slug',
        'titulo',
        'descricao',
        'conteudo',
        'configuracoes',
        'ativo',
        'ordem',
        'template',
        'seo'
    ];

    protected $casts = [
        'configuracoes' => 'array',
        'seo' => 'array',
        'ativo' => 'boolean',
        'ordem' => 'integer'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem', 'asc');
    }

    public function scopePorSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // Métodos auxiliares
    public function getConteudoLimpoAttribute()
    {
        return strip_tags($this->conteudo);
    }

    public function getResumoAttribute($limite = 150)
    {
        $texto = strip_tags($this->conteudo);
        return strlen($texto) > $limite ? substr($texto, 0, $limite) . '...' : $texto;
    }

    public function getSeoTitleAttribute()
    {
        return $this->seo['title'] ?? $this->titulo;
    }

    public function getSeoDescriptionAttribute()
    {
        return $this->seo['description'] ?? $this->descricao ?? $this->getResumoAttribute();
    }

    public function getSeoKeywordsAttribute()
    {
        return $this->seo['keywords'] ?? '';
    }

    // Método estático para buscar por slug
    public static function buscarPorSlug($slug)
    {
        return static::ativo()->porSlug($slug)->first();
    }

    // Método para obter todas as páginas ativas ordenadas
    public static function paginasAtivas()
    {
        return static::ativo()->ordenado()->get();
    }

    // Método para verificar se o conteúdo tem HTML
    public function temHtml()
    {
        return $this->conteudo !== strip_tags($this->conteudo);
    }

    // Método para obter configuração específica
    public function getConfiguracao($chave, $padrao = null)
    {
        return $this->configuracoes[$chave] ?? $padrao;
    }

    // Método para definir configuração
    public function setConfiguracao($chave, $valor)
    {
        $configuracoes = $this->configuracoes ?? [];
        $configuracoes[$chave] = $valor;
        $this->configuracoes = $configuracoes;
        return $this;
    }
}
