<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Licitacao extends Model
{
    use HasFactory;

    protected $table = 'licitacoes';

    protected $fillable = [
        'numero_processo',
        'numero_edital',
        'modalidade',
        'tipo',
        'objeto',
        'descricao_detalhada',
        'valor_estimado',
        'valor_homologado',
        'data_abertura',
        'data_publicacao',
        'data_hora_abertura',
        'data_homologacao',
        'local_abertura',
        'responsavel',
        'vencedor',
        'cnpj_vencedor',
        'valor_vencedor',
        'arquivo_edital',
        'arquivo_resultado',
        'ano_referencia',
        'observacoes',
        'status'
    ];

    protected $casts = [
        'valor_estimado' => 'decimal:2',
        'valor_homologado' => 'decimal:2',
        'valor_vencedor' => 'decimal:2',
        'data_abertura' => 'date',
        'data_publicacao' => 'date',
        'data_hora_abertura' => 'datetime',
        'data_homologacao' => 'date',
        'ano_referencia' => 'integer'
    ];

    /**
     * Relacionamento com documentos
     */
    public function documentos(): HasMany
    {
        return $this->hasMany(LicitacaoDocumento::class);
    }

    /**
     * Documentos públicos ordenados
     */
    public function documentosPublicos(): HasMany
    {
        return $this->hasMany(LicitacaoDocumento::class)
                    ->publicos()
                    ->ordenados();
    }

    // Scopes para facilitar consultas
    public function scopeModalidade($query, $modalidade)
    {
        return $query->where('modalidade', $modalidade);
    }

    public function scopeSituacao($query, $situacao)
    {
        return $query->where('situacao', $situacao);
    }

    public function scopeAno($query, $ano)
    {
        return $query->whereYear('data_publicacao', $ano);
    }

    public function scopeVencedor($query, $vencedor)
    {
        return $query->where('vencedor', 'like', '%' . $vencedor . '%');
    }

    public function scopeObjeto($query, $objeto)
    {
        return $query->where('objeto', 'like', '%' . $objeto . '%');
    }

    // Accessors para valores formatados
    public function getValorEstimadoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_estimado, 2, ',', '.');
    }

    public function getValorHomologadoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_homologado, 2, ',', '.');
    }

    // Método para calcular economia
    public function getEconomiaAttribute()
    {
        if ($this->valor_estimado > 0 && $this->valor_homologado > 0) {
            return $this->valor_estimado - $this->valor_homologado;
        }
        return 0;
    }

    public function getEconomiaFormatadaAttribute()
    {
        return 'R$ ' . number_format($this->economia, 2, ',', '.');
    }

    public function getPercentualEconomiaAttribute()
    {
        if ($this->valor_estimado > 0 && $this->economia > 0) {
            return round(($this->economia / $this->valor_estimado) * 100, 2);
        }
        return 0;
    }

    // Método para verificar se está em andamento
    public function getEmAndamentoAttribute()
    {
        return in_array($this->situacao, ['publicado', 'em_andamento', 'habilitacao']);
    }

    // Método para verificar se foi finalizada
    public function getFinalizadaAttribute()
    {
        return in_array($this->situacao, ['homologada', 'adjudicada', 'contratada']);
    }

    // Método para verificar se foi cancelada/deserta
    public function getCanceladaAttribute()
    {
        return in_array($this->situacao, ['cancelada', 'deserta', 'fracassada']);
    }
}
