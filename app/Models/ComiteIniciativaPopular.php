<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComiteIniciativaPopular extends Model
{
    protected $table = 'comite_iniciativa_populars';
    
    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'endereco',
        'numero_assinaturas',
        'minimo_assinaturas',
        'data_inicio_coleta',
        'data_fim_coleta',
        'status',
        'observacoes',
        'documentos',
    ];

    protected $casts = [
        'data_inicio_coleta' => 'date',
        'data_fim_coleta' => 'date',
        'documentos' => 'array',
        'numero_assinaturas' => 'integer',
        'minimo_assinaturas' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com projetos de lei de iniciativa popular
     */
    public function projetosLei(): HasMany
    {
        return $this->hasMany(ProjetoLei::class, 'comite_iniciativa_popular_id');
    }

    /**
     * Accessor para verificar se o comitê está ativo
     */
    public function getIsAtivoAttribute(): bool
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se o comitê está ativo
     */
    public function isAtivo(): bool
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se o comitê está inativo (rejeitado ou arquivado)
     */
    public function isInativo(): bool
    {
        return in_array($this->status, ['rejeitado', 'arquivado']);
    }

    /**
     * Verifica se o comitê foi validado
     */
    public function isValidado(): bool
    {
        return $this->status === 'validado';
    }

    /**
     * Verifica se o comitê atingiu o mínimo de assinaturas
     */
    public function atingiuMinimoAssinaturas(): bool
    {
        return $this->numero_assinaturas >= $this->minimo_assinaturas;
    }

    /**
     * Calcula o percentual de assinaturas coletadas
     */
    public function getPercentualAssinaturas(): float
    {
        if ($this->minimo_assinaturas <= 0) {
            return 0;
        }
        
        return min(100, ($this->numero_assinaturas / $this->minimo_assinaturas) * 100);
    }

    /**
     * Scope para comitês ativos
     */
    public function scopeAtivo($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para comitês inativos (rejeitados ou arquivados)
     */
    public function scopeInativo($query)
    {
        return $query->whereIn('status', ['rejeitado', 'arquivado']);
    }

    /**
     * Scope para comitês ativos (plural)
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para comitês inativos (plural)
     */
    public function scopeInativos($query)
    {
        return $query->whereIn('status', ['rejeitado', 'arquivado']);
    }

    /**
     * Scope para comitês validados
     */
    public function scopeValidados($query)
    {
        return $query->where('status', 'validado');
    }

    /**
     * Scope para comitês que atingiram o mínimo de assinaturas
     */
    public function scopeComMinimoAssinaturas($query)
    {
        return $query->whereRaw('numero_assinaturas >= minimo_assinaturas');
    }
}
