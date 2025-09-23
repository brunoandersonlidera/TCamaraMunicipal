<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receita extends Model
{
    use HasFactory;

    protected $table = 'receitas';

    protected $fillable = [
        'codigo',
        'descricao',
        'categoria',
        'subcategoria',
        'valor_previsto',
        'valor_arrecadado',
        'data_previsao',
        'data_arrecadacao',
        'mes_referencia',
        'ano_referencia',
        'fonte_recurso',
        'origem',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'valor_previsto' => 'decimal:2',
        'valor_arrecadado' => 'decimal:2',
        'data_previsao' => 'date',
        'data_arrecadacao' => 'date',
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

    // Accessor para valor formatado
    public function getValorPrevistoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_previsto, 2, ',', '.');
    }

    public function getValorArrecadadoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_arrecadado, 2, ',', '.');
    }

    // Método para calcular percentual de arrecadação
    public function getPercentualArrecadacaoAttribute()
    {
        if ($this->valor_previsto > 0) {
            return round(($this->valor_arrecadado / $this->valor_previsto) * 100, 2);
        }
        return 0;
    }
}
