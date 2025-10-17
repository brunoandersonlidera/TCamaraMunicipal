<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OuvidoriaMovimentacao extends Model
{
    use HasFactory;

    protected $table = 'ouvidoria_movimentacoes';

    protected $fillable = [
        'ouvidoria_manifestacao_id',
        'usuario_id',
        'status',
        'descricao',
        'anexos',
        'data_movimentacao',
        'ip_usuario'
    ];

    protected $casts = [
        'anexos' => 'array',
        'data_movimentacao' => 'datetime'
    ];

    /**
     * Relacionamento com a manifestação
     */
    public function manifestacao()
    {
        return $this->belongsTo(OuvidoriaManifestacao::class, 'ouvidoria_manifestacao_id');
    }

    /**
     * Relacionamento com o usuário responsável pela movimentação
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Accessor para formatar o status
     */
    public function getStatusFormatadoAttribute()
    {
        $statusMap = [
            'nova' => 'Nova',
            'aberta' => 'Aberta',
            'em_analise' => 'Em Análise',
            'em_tramitacao' => 'Em Tramitação',
            'aguardando_informacoes' => 'Aguardando Informações',
            'respondida' => 'Respondida',
            'finalizada' => 'Finalizada',
            'arquivada' => 'Arquivada'
        ];

        return $statusMap[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Scope para filtrar por manifestação
     */
    public function scopePorManifestacao($query, $manifestacaoId)
    {
        return $query->where('ouvidoria_manifestacao_id', $manifestacaoId);
    }

    /**
     * Scope para ordenar por data
     */
    public function scopeOrdenadoPorData($query, $direcao = 'desc')
    {
        return $query->orderBy('data_movimentacao', $direcao);
    }
}