<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComiteIniciativaPopular extends Model
{
    protected $table = 'comite_iniciativa_populars';
    
    protected $fillable = [
        'nome',
        'descricao',
        'objetivo',
        'cpf',
        'email',
        'telefone',
        'endereco',
        'cidadao_responsavel_id',
        'numero_assinaturas',
        'minimo_assinaturas',
        'data_inicio_coleta',
        'data_fim_coleta',
        'status',
        'observacoes',
        'documentos',
        'ementa',
        'texto_projeto_html',
        'motivo_rejeicao',
        'observacoes_admin',
        'data_validacao_admin',
        'validado_por',
        'data_ultima_alteracao',
    ];

    protected $casts = [
        'data_inicio_coleta' => 'date',
        'data_fim_coleta' => 'date',
        'documentos' => 'array',
        'numero_assinaturas' => 'integer',
        'minimo_assinaturas' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'data_validacao_admin' => 'datetime',
        'data_ultima_alteracao' => 'datetime',
    ];

    /**
     * Relacionamento com projetos de lei de iniciativa popular
     */
    public function projetosLei(): HasMany
    {
        return $this->hasMany(ProjetoLei::class, 'comite_iniciativa_popular_id');
    }

    /**
     * Relacionamento com cidadão responsável
     */
    public function cidadaoResponsavel(): BelongsTo
    {
        return $this->belongsTo(Cidadao::class, 'cidadao_responsavel_id');
    }

    /**
     * Relacionamento com assinaturas eletrônicas
     */
    public function assinaturas(): HasMany
    {
        return $this->hasMany(AssinaturaEletronica::class, 'comite_iniciativa_popular_id');
    }

    public function validadoPor()
    {
        return $this->belongsTo(User::class, 'validado_por');
    }

    /**
     * Relacionamento com assinaturas válidas
     */
    public function assinaturasValidas(): HasMany
    {
        return $this->hasMany(AssinaturaEletronica::class, 'comite_iniciativa_popular_id')
                    ->where('status', 'validada')
                    ->where('ativo', true);
    }

    /**
     * Relacionamento com assinaturas pendentes
     */
    public function assinaturasPendentes(): HasMany
    {
        return $this->hasMany(AssinaturaEletronica::class, 'comite_iniciativa_popular_id')
                    ->where('status', 'pendente')
                    ->where('ativo', true);
    }

    /**
     * Verifica se o comitê está ativo (pode coletar assinaturas)
     */
    public function getIsAtivoAttribute()
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se o comitê está ativo (pode coletar assinaturas)
     */
    public function isAtivo()
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se o comitê está inativo (não pode coletar assinaturas)
     */
    public function isInativo()
    {
        return !in_array($this->status, ['ativo']);
    }

    /**
     * Verifica se o comitê foi validado (atingiu meta e foi aprovado)
     */
    public function isValidado()
    {
        return $this->status === 'validado';
    }

    /**
     * Verifica se está aguardando validação inicial
     */
    public function isAguardandoValidacao()
    {
        return $this->status === 'aguardando_validacao';
    }

    /**
     * Verifica se está aguardando alterações do responsável
     */
    public function isAguardandoAlteracoes()
    {
        return $this->status === 'aguardando_alteracoes';
    }

    /**
     * Verifica se foi rejeitado
     */
    public function isRejeitado()
    {
        return $this->status === 'rejeitado';
    }

    /**
     * Verifica se foi arquivado
     */
    public function isArquivado()
    {
        return $this->status === 'arquivado';
    }

    /**
     * Verifica se expirou
     */
    public function isExpirado()
    {
        return $this->status === 'expirado' || ($this->data_fim_coleta && $this->data_fim_coleta->isPast() && $this->status === 'ativo');
    }

    /**
     * Verifica se pode coletar assinaturas
     */
    public function podeColetarAssinaturas()
    {
        return $this->status === 'ativo' && !$this->isExpirado();
    }

    /**
     * Verifica se pode ser editado pelo responsável
     */
    public function podeSerEditado()
    {
        return in_array($this->status, ['aguardando_validacao', 'aguardando_alteracoes']);
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
     * Scope para comitês ativos (podem coletar assinaturas)
     */
    public function scopeAtivo($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para comitês inativos (não podem coletar assinaturas)
     */
    public function scopeInativo($query)
    {
        return $query->where('status', '!=', 'ativo');
    }

    /**
     * Scope para comitês validados
     */
    public function scopeValidados($query)
    {
        return $query->where('status', 'validado');
    }

    /**
     * Scope para comitês aguardando validação
     */
    public function scopeAguardandoValidacao($query)
    {
        return $query->where('status', 'aguardando_validacao');
    }

    /**
     * Scope para comitês aguardando alterações
     */
    public function scopeAguardandoAlteracoes($query)
    {
        return $query->where('status', 'aguardando_alteracoes');
    }

    /**
     * Scope para comitês rejeitados
     */
    public function scopeRejeitados($query)
    {
        return $query->where('status', 'rejeitado');
    }

    /**
     * Scope para comitês arquivados
     */
    public function scopeArquivados($query)
    {
        return $query->where('status', 'arquivado');
    }

    /**
     * Scope para comitês expirados
     */
    public function scopeExpirados($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'expirado')
              ->orWhere(function($subQ) {
                  $subQ->where('status', 'ativo')
                       ->where('data_fim_coleta', '<', now());
              });
        });
    }

    /**
     * Scope para comitês com mínimo de assinaturas
     */
    public function scopeComMinimoAssinaturas($query)
    {
        return $query->where('numero_assinaturas', '>=', 1000);
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
        return $query->where('status', '!=', 'ativo');
    }

    /**
     * Métodos para transições de status
     */
    
    /**
     * Aprova o comitê (admin)
     */
    public function aprovar($adminId = null, $observacoes = null)
    {
        $this->update([
            'status' => 'ativo',
            'data_validacao_admin' => now(),
            'validado_por' => $adminId,
            'observacoes_admin' => $observacoes,
            'data_ultima_alteracao' => now()
        ]);
    }

    /**
     * Solicita alterações no comitê (admin)
     */
    public function solicitarAlteracoes($motivo, $adminId = null)
    {
        $this->update([
            'status' => 'aguardando_alteracoes',
            'motivo_rejeicao' => $motivo,
            'validado_por' => $adminId,
            'data_ultima_alteracao' => now()
        ]);
    }

    /**
     * Rejeita o comitê definitivamente (admin)
     */
    public function rejeitar($motivo, $adminId = null)
    {
        $this->update([
            'status' => 'rejeitado',
            'motivo_rejeicao' => $motivo,
            'validado_por' => $adminId,
            'data_ultima_alteracao' => now()
        ]);
    }

    /**
     * Arquiva o comitê (admin)
     */
    public function arquivar($motivo, $adminId = null)
    {
        $this->update([
            'status' => 'arquivado',
            'motivo_rejeicao' => $motivo,
            'validado_por' => $adminId,
            'data_ultima_alteracao' => now()
        ]);
    }

    /**
     * Valida o comitê após atingir meta (admin)
     */
    public function validar($adminId = null, $observacoes = null)
    {
        $this->update([
            'status' => 'validado',
            'data_validacao_admin' => now(),
            'validado_por' => $adminId,
            'observacoes_admin' => $observacoes,
            'data_ultima_alteracao' => now()
        ]);
    }

    /**
     * Resubmete para validação após alterações (cidadão)
     */
    public function resubmeter()
    {
        $this->update([
            'status' => 'aguardando_validacao',
            'motivo_rejeicao' => null,
            'data_ultima_alteracao' => now()
        ]);
    }

    /**
     * Marca como expirado
     */
    public function marcarComoExpirado()
    {
        $this->update([
            'status' => 'expirado',
            'data_ultima_alteracao' => now()
        ]);
    }

    /**
     * Retorna o status formatado para exibição
     */
    public function getStatusFormatado()
    {
        $statusMap = [
            'aguardando_validacao' => 'Aguardando Validação',
            'ativo' => 'Ativo',
            'aguardando_alteracoes' => 'Aguardando Alterações',
            'validado' => 'Validado',
            'rejeitado' => 'Rejeitado',
            'arquivado' => 'Arquivado',
            'expirado' => 'Expirado'
        ];

        return $statusMap[$this->status] ?? $this->status;
    }

    /**
     * Retorna a classe CSS para o badge do status
     */
    public function getStatusBadgeClass()
    {
        $classMap = [
            'aguardando_validacao' => 'warning',
            'ativo' => 'success',
            'aguardando_alteracoes' => 'info',
            'validado' => 'primary',
            'rejeitado' => 'danger',
            'arquivado' => 'secondary',
            'expirado' => 'dark'
        ];

        return $classMap[$this->status] ?? 'secondary';
    }
}
