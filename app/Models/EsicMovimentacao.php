<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class EsicMovimentacao extends Model
{
    use HasFactory;

    protected $table = 'esic_movimentacoes';

    protected $fillable = [
        'esic_solicitacao_id',
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

    protected $dates = [
        'data_movimentacao'
    ];

    // Constantes para status
    const STATUS_ABERTA = 'aberta';
    const STATUS_EM_ANALISE = 'em_analise';
    const STATUS_AGUARDANDO_INFORMACOES = 'aguardando_informacoes';
    const STATUS_RESPONDIDA = 'respondida';
    const STATUS_NEGADA = 'negada';
    const STATUS_PARCIALMENTE_ATENDIDA = 'parcialmente_atendida';
    const STATUS_RECURSO_SOLICITADO = 'recurso_solicitado';
    const STATUS_RECURSO_EM_ANALISE = 'recurso_em_analise';
    const STATUS_RECURSO_DEFERIDO = 'recurso_deferido';
    const STATUS_RECURSO_INDEFERIDO = 'recurso_indeferido';
    const STATUS_FINALIZADA = 'finalizada';
    const STATUS_FINALIZACAO_SOLICITADA = 'finalizacao_solicitada';
    const STATUS_ARQUIVADA = 'arquivada';

    // Relacionamentos
    public function solicitacao()
    {
        return $this->belongsTo(EsicSolicitacao::class, 'esic_solicitacao_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Scopes
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecentes($query, $dias = 30)
    {
        return $query->where('data_movimentacao', '>=', now()->subDays($dias));
    }

    public function scopePorSolicitacao($query, $solicitacaoId)
    {
        return $query->where('esic_solicitacao_id', $solicitacaoId);
    }

    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // Métodos auxiliares
    public function getStatusFormatado()
    {
        $statusMap = [
            self::STATUS_ABERTA => 'Aberta',
            self::STATUS_EM_ANALISE => 'Em Análise',
            self::STATUS_AGUARDANDO_INFORMACOES => 'Aguardando Informações',
            self::STATUS_RESPONDIDA => 'Respondida',
            self::STATUS_NEGADA => 'Negada',
            self::STATUS_PARCIALMENTE_ATENDIDA => 'Parcialmente Atendida',
            self::STATUS_RECURSO_SOLICITADO => 'Recurso Solicitado',
            self::STATUS_RECURSO_EM_ANALISE => 'Recurso em Análise',
            self::STATUS_RECURSO_DEFERIDO => 'Recurso Deferido',
            self::STATUS_RECURSO_INDEFERIDO => 'Recurso Indeferido',
            self::STATUS_FINALIZADA => 'Finalizada',
            self::STATUS_FINALIZACAO_SOLICITADA => 'Finalização Solicitada',
            self::STATUS_ARQUIVADA => 'Arquivada'
        ];

        return $statusMap[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getDataFormatada()
    {
        return $this->data_movimentacao->format('d/m/Y H:i');
    }

    public function temAnexos()
    {
        return !empty($this->anexos) && is_array($this->anexos) && count($this->anexos) > 0;
    }

    public function getAnexosCount()
    {
        return $this->temAnexos() ? count($this->anexos) : 0;
    }

    // Métodos estáticos
    public static function getStatusOptions()
    {
        return [
            self::STATUS_ABERTA => 'Aberta',
            self::STATUS_EM_ANALISE => 'Em Análise',
            self::STATUS_AGUARDANDO_INFORMACOES => 'Aguardando Informações',
            self::STATUS_RESPONDIDA => 'Respondida',
            self::STATUS_NEGADA => 'Negada',
            self::STATUS_PARCIALMENTE_ATENDIDA => 'Parcialmente Atendida',
            self::STATUS_RECURSO_SOLICITADO => 'Recurso Solicitado',
            self::STATUS_RECURSO_EM_ANALISE => 'Recurso em Análise',
            self::STATUS_RECURSO_DEFERIDO => 'Recurso Deferido',
            self::STATUS_RECURSO_INDEFERIDO => 'Recurso Indeferido',
            self::STATUS_FINALIZADA => 'Finalizada',
            self::STATUS_FINALIZACAO_SOLICITADA => 'Finalização Solicitada',
            self::STATUS_ARQUIVADA => 'Arquivada'
        ];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($movimentacao) {
            if (empty($movimentacao->data_movimentacao)) {
                $movimentacao->data_movimentacao = now();
            }
            
            if (empty($movimentacao->ip_usuario)) {
                $movimentacao->ip_usuario = request()->ip();
            }
        });
    }
}