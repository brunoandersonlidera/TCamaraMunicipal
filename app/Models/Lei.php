<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Lei extends Model
{
    protected $table = 'leis';

    protected $fillable = [
        'numero',
        'exercicio',
        'data',
        'tipo',
        'titulo',
        'descricao',
        'autoria',
        'ementa',
        'arquivo_pdf',
        'ativo',
        'observacoes',
        'slug'
    ];

    protected $casts = [
        'data' => 'date',
        'exercicio' => 'integer',
        'ativo' => 'boolean',
    ];

    protected $dates = [
        'data',
        'created_at',
        'updated_at'
    ];

    /**
     * Tipos de leis disponíveis
     */
    public static function getTipos()
    {
        return [
            'Lei Ordinária' => 'Lei Ordinária',
            'Lei Complementar' => 'Lei Complementar',
            'Resolução' => 'Resolução',
            'Decreto Legislativo' => 'Decreto Legislativo',
            'Lei Orgânica' => 'Lei Orgânica',
            'Emenda à Lei Orgânica' => 'Emenda à Lei Orgânica'
        ];
    }

    // Scope para buscar por tipo
    public function scopeByTipo(Builder $query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Scope para buscar por exercício
    public function scopeByExercicio(Builder $query, $exercicio)
    {
        return $query->where('exercicio', $exercicio);
    }

    // Scope para leis ativas
    public function scopeAtivas(Builder $query)
    {
        return $query->where('ativo', true);
    }

    // Scope para busca geral
    public function scopeBuscar(Builder $query, $termo)
    {
        return $query->where(function ($q) use ($termo) {
            $q->where('numero', 'like', "%{$termo}%")
              ->orWhere('titulo', 'like', "%{$termo}%")
              ->orWhere('descricao', 'like', "%{$termo}%")
              ->orWhere('ementa', 'like', "%{$termo}%")
              ->orWhere('autoria', 'like', "%{$termo}%");
        });
    }

    // Scope para ordenação padrão
    public function scopeOrdenacaoPadrao(Builder $query)
    {
        return $query->orderBy('exercicio', 'desc')
                    ->orderBy('data', 'desc')
                    ->orderBy('numero', 'desc');
    }

    // Gerar slug automaticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lei) {
            if (empty($lei->slug)) {
                $lei->slug = Str::slug($lei->numero . '-' . $lei->exercicio . '-' . $lei->titulo);
            }
        });

        static::updating(function ($lei) {
            if ($lei->isDirty(['numero', 'exercicio', 'titulo'])) {
                $lei->slug = Str::slug($lei->numero . '-' . $lei->exercicio . '-' . $lei->titulo);
            }
        });
    }

    // Accessor para número formatado
    public function getNumeroFormatadoAttribute()
    {
        return "Lei Municipal nº {$this->numero} de " . $this->data->format('d/m/Y');
    }

    // Accessor para URL amigável
    public function getUrlAttribute()
    {
        return route('leis.show', $this->slug);
    }

    // Método para verificar se tem arquivo PDF
    public function temArquivoPdf()
    {
        return !empty($this->arquivo_pdf) && file_exists(public_path($this->arquivo_pdf));
    }

    // Método para obter URL do PDF
    public function getUrlPdf()
    {
        if ($this->temArquivoPdf()) {
            return asset($this->arquivo_pdf);
        }
        return null;
    }
}
