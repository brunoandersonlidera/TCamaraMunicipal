<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TipoSessao extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_sessaos';

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'cor',
        'icone',
        'ativo',
        'ordem'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer'
    ];

    // Relacionamentos
    public function sessoes()
    {
        return $this->hasMany(Sessao::class, 'tipo', 'nome');
    }

    // Mutators
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    // Métodos auxiliares
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
