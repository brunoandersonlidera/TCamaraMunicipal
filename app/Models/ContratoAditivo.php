<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContratoAditivo extends Model
{
    protected $fillable = [
        'contrato_id',
        'numero',
        'tipo',
        'objeto',
        'valor_aditivo',
        'prazo_adicional_dias',
        'data_assinatura',
        'data_inicio_vigencia',
        'data_fim_vigencia',
        'justificativa',
        'observacoes',
        'arquivo_aditivo',
        'arquivo_aditivo_original',
        'publico'
    ];

    protected $casts = [
        'data_assinatura' => 'date',
        'data_inicio_vigencia' => 'date',
        'data_fim_vigencia' => 'date',
        'valor_aditivo' => 'decimal:2',
        'publico' => 'boolean'
    ];

    /**
     * Relacionamento com contrato
     */
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    /**
     * Scope para aditivos públicos
     */
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    /**
     * Scope para tipo específico
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * URL do arquivo do aditivo
     */
    public function getArquivoUrlAttribute()
    {
        if ($this->arquivo_aditivo) {
            return Storage::url('contratos/aditivos/' . $this->arquivo_aditivo);
        }
        return null;
    }

    /**
     * Verifica se tem arquivo
     */
    public function getTemArquivoAttribute()
    {
        return !empty($this->arquivo_aditivo) && Storage::exists('contratos/aditivos/' . $this->arquivo_aditivo);
    }

    /**
     * Retorna o tipo formatado
     */
    public function getTipoFormatadoAttribute()
    {
        $tipos = [
            'prazo' => 'Aditivo de Prazo',
            'valor' => 'Aditivo de Valor',
            'prazo_valor' => 'Aditivo de Prazo e Valor',
            'objeto' => 'Aditivo de Objeto'
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }
}
