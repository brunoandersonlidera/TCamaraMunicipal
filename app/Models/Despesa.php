<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Despesa extends Model
{
    use HasFactory;

    protected $table = 'despesas';

    protected $fillable = [
        'numero_empenho',
        'codigo_despesa',
        'descricao',
        'categoria',
        'funcao',
        'subfuncao',
        'programa',
        'elemento_despesa',
        'favorecido',
        'cnpj_cpf_favorecido',
        'valor_empenhado',
        'valor_liquidado',
        'valor_pago',
        'data_empenho',
        'data_liquidacao',
        'data_pagamento',
        'mes_referencia',
        'ano_referencia',
        'modalidade_licitacao',
        'numero_processo',
        'observacoes',
        'status'
    ];

    protected $casts = [
        'valor_empenhado' => 'decimal:2',
        'valor_liquidado' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'data_empenho' => 'date',
        'data_liquidacao' => 'date',
        'data_pagamento' => 'date',
        'mes_referencia' => 'integer',
        'ano_referencia' => 'integer'
    ];

    // Scopes para facilitar consultas
    public function scopeAno($query, $ano)
    {
        return $query->where('ano_referencia', $ano);
    }

    public function scopeMes($query, $mes)
    {
        return $query->where('mes_referencia', $mes);
    }

    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCredor($query, $credor)
    {
        return $query->where('favorecido', 'like', '%' . $credor . '%');
    }

    // Accessors para valores formatados
    public function getValorEmpenhadoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_empenhado, 2, ',', '.');
    }

    public function getValorLiquidadoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_liquidado, 2, ',', '.');
    }

    public function getValorPagoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_pago, 2, ',', '.');
    }

    // Métodos para calcular percentuais
    public function getPercentualLiquidadoAttribute()
    {
        if ($this->valor_empenhado > 0) {
            return round(($this->valor_liquidado / $this->valor_empenhado) * 100, 2);
        }
        return 0;
    }

    public function getPercentualPagoAttribute()
    {
        if ($this->valor_empenhado > 0) {
            return round(($this->valor_pago / $this->valor_empenhado) * 100, 2);
        }
        return 0;
    }

    // Método para verificar se está totalmente pago
    public function getTotalmentePagoAttribute()
    {
        return $this->valor_pago >= $this->valor_empenhado;
    }
}
