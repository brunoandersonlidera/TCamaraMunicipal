<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contrato extends Model
{
    protected $fillable = [
        'tipo_contrato_id',
        'numero',
        'processo',
        'objeto',
        'contratado',
        'cnpj_cpf_contratado',
        'valor_inicial',
        'valor_atual',
        'data_assinatura',
        'data_inicio',
        'data_fim',
        'data_fim_atual',
        'status',
        'observacoes',
        'observacoes_transparencia',
        'arquivo_contrato',
        'arquivo_contrato_original',
        'publico',
        'ano_referencia'
    ];

    protected $casts = [
        'data_assinatura' => 'date',
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'data_fim_atual' => 'date',
        'valor_inicial' => 'decimal:2',
        'valor_atual' => 'decimal:2',
        'publico' => 'boolean'
    ];

    /**
     * Relacionamento com tipo de contrato
     */
    public function tipoContrato()
    {
        return $this->belongsTo(TipoContrato::class);
    }

    /**
     * Relacionamento com aditivos
     */
    public function aditivos()
    {
        return $this->hasMany(ContratoAditivo::class);
    }

    /**
     * Relacionamento com fiscalizações
     */
    public function fiscalizacoes()
    {
        return $this->hasMany(ContratoFiscalizacao::class);
    }

    /**
     * Scope para contratos públicos
     */
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    /**
     * Scope para contratos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para ano específico
     */
    public function scopeAno($query, $ano)
    {
        return $query->where('ano_referencia', $ano);
    }

    /**
     * Verifica se o contrato está vencido
     */
    public function getVencidoAttribute()
    {
        $dataFim = $this->data_fim_atual ?? $this->data_fim;
        return $dataFim < now()->toDateString() && $this->status === 'ativo';
    }

    /**
     * Verifica se o contrato está vencido (método)
     */
    public function isVencido()
    {
        $dataFim = $this->data_fim_atual ?? $this->data_fim;
        return $dataFim < now()->toDateString() && $this->status === 'ativo';
    }

    /**
     * Retorna quantos dias faltam para o vencimento
     */
    public function diasParaVencimento()
    {
        $dataFim = $this->data_fim_atual ?? $this->data_fim;
        if (!$dataFim) {
            return null;
        }
        return now()->diffInDays($dataFim, false);
    }

    /**
     * Retorna o valor total com aditivos
     */
    public function getValorTotalAttribute()
    {
        return $this->valor_atual;
    }

    /**
     * URL do arquivo do contrato
     */
    public function getArquivoUrlAttribute()
    {
        if ($this->arquivo_contrato) {
            return Storage::url('contratos/' . $this->arquivo_contrato);
        }
        return null;
    }

    /**
     * Verifica se tem arquivo
     */
    public function getTemArquivoAttribute()
    {
        return !empty($this->arquivo_contrato) && Storage::exists('contratos/' . $this->arquivo_contrato);
    }
}
