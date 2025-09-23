<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FolhaPagamento extends Model
{
    use HasFactory;

    protected $table = 'folha_pagamento';

    protected $fillable = [
        'nome_servidor',
        'cargo',
        'lotacao',
        'vinculo',
        'regime_juridico',
        'remuneracao_basica',
        'vantagens_pessoais',
        'funcao_cargo',
        'gratificacoes',
        'adicionais',
        'indenizacoes',
        'descontos_obrigatorios',
        'outros_descontos',
        'remuneracao_liquida',
        'diarias',
        'auxilios',
        'vantagens_indenizatorias',
        'mes_referencia',
        'ano_referencia',
        'data_admissao',
        'situacao',
        'observacoes'
    ];

    protected $casts = [
        'remuneracao_basica' => 'decimal:2',
        'vantagens_pessoais' => 'decimal:2',
        'funcao_cargo' => 'decimal:2',
        'gratificacoes' => 'decimal:2',
        'adicionais' => 'decimal:2',
        'indenizacoes' => 'decimal:2',
        'descontos_obrigatorios' => 'decimal:2',
        'outros_descontos' => 'decimal:2',
        'remuneracao_liquida' => 'decimal:2',
        'diarias' => 'decimal:2',
        'auxilios' => 'decimal:2',
        'vantagens_indenizatorias' => 'decimal:2',
        'mes_referencia' => 'integer',
        'ano_referencia' => 'integer',
        'data_admissao' => 'date'
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

    public function scopeCargo($query, $cargo)
    {
        return $query->where('cargo', 'like', '%' . $cargo . '%');
    }

    public function scopeLotacao($query, $lotacao)
    {
        return $query->where('lotacao', 'like', '%' . $lotacao . '%');
    }

    public function scopeVinculo($query, $vinculo)
    {
        return $query->where('vinculo', $vinculo);
    }

    public function scopeSituacao($query, $situacao)
    {
        return $query->where('situacao', $situacao);
    }

    public function scopeNome($query, $nome)
    {
        return $query->where('nome_servidor', 'like', '%' . $nome . '%');
    }

    // Accessors para valores formatados
    public function getRemuneracaoBasicaFormatadaAttribute()
    {
        return 'R$ ' . number_format($this->remuneracao_basica, 2, ',', '.');
    }

    public function getRemuneracaoLiquidaFormatadaAttribute()
    {
        return 'R$ ' . number_format($this->remuneracao_liquida, 2, ',', '.');
    }

    public function getTotalVantagensAttribute()
    {
        return $this->vantagens_pessoais + $this->funcao_cargo + $this->gratificacoes + 
               $this->adicionais + $this->indenizacoes;
    }

    public function getTotalVantagensFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->total_vantagens, 2, ',', '.');
    }

    public function getTotalDescontosAttribute()
    {
        return $this->descontos_obrigatorios + $this->outros_descontos;
    }

    public function getTotalDescontosFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->total_descontos, 2, ',', '.');
    }

    public function getRemuneracaoTotalBrutaAttribute()
    {
        return $this->remuneracao_basica + $this->total_vantagens;
    }

    public function getRemuneracaoTotalBrutaFormatadaAttribute()
    {
        return 'R$ ' . number_format($this->remuneracao_total_bruta, 2, ',', '.');
    }

    // Método para calcular tempo de serviço
    public function getTempoServicoAttribute()
    {
        if ($this->data_admissao) {
            $admissao = $this->data_admissao;
            $hoje = now();
            return $admissao->diff($hoje);
        }
        return null;
    }

    public function getTempoServicoFormatadoAttribute()
    {
        $tempo = $this->tempo_servico;
        if ($tempo) {
            return $tempo->y . ' anos, ' . $tempo->m . ' meses';
        }
        return 'Não informado';
    }

    // Método para verificar se é servidor efetivo
    public function getEfetivoAttribute()
    {
        return strtolower($this->vinculo) === 'efetivo';
    }

    // Método para verificar se é cargo comissionado
    public function getComissionadoAttribute()
    {
        return in_array(strtolower($this->vinculo), ['comissionado', 'cargo em comissão']);
    }
}
