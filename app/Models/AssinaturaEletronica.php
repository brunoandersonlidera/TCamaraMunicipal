<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class AssinaturaEletronica extends Model
{
    protected $fillable = [
        'comite_iniciativa_popular_id',
        'cidadao_id',
        'nome_completo',
        'cpf',
        'email',
        'telefone',
        'data_nascimento',
        'titulo_eleitor',
        'zona_eleitoral',
        'secao_eleitoral',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'data_assinatura',
        'ip_address',
        'user_agent',
        'hash_assinatura',
        'status',
        'motivo_rejeicao',
        'data_validacao',
        'validado_por',
        'ativo'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_assinatura' => 'datetime',
        'data_validacao' => 'datetime',
        'ativo' => 'boolean'
    ];

    /**
     * Relacionamento com o comitê
     */
    public function comite(): BelongsTo
    {
        return $this->belongsTo(ComiteIniciativaPopular::class, 'comite_iniciativa_popular_id');
    }

    /**
     * Relacionamento com o usuário que validou
     */
    public function validador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validado_por');
    }

    /**
     * Relacionamento com o cidadão que assinou
     */
    public function cidadao(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cidadao_id');
    }

    /**
     * Gerar hash único para a assinatura
     */
    public static function gerarHashAssinatura($cpf, $comiteId, $timestamp)
    {
        return hash('sha256', $cpf . $comiteId . $timestamp . config('app.key'));
    }

    /**
     * Verificar se o CPF já assinou este comitê
     */
    public static function jaAssinou($cpf, $comiteId)
    {
        return self::where('cpf', $cpf)
                  ->where('comite_iniciativa_popular_id', $comiteId)
                  ->where('ativo', true)
                  ->exists();
    }

    /**
     * Validar assinatura
     */
    public function validar($userId, $motivo = null)
    {
        $this->update([
            'status' => 'validada',
            'data_validacao' => now(),
            'validado_por' => $userId,
            'motivo_rejeicao' => null
        ]);
    }

    /**
     * Rejeitar assinatura
     */
    public function rejeitar($userId, $motivo)
    {
        $this->update([
            'status' => 'rejeitada',
            'data_validacao' => now(),
            'validado_por' => $userId,
            'motivo_rejeicao' => $motivo
        ]);
    }

    /**
     * Scope para assinaturas válidas
     */
    public function scopeValidas($query)
    {
        return $query->where('status', 'validada')->where('ativo', true);
    }

    /**
     * Scope para assinaturas pendentes
     */
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente')->where('ativo', true);
    }

    /**
     * Accessor para CPF formatado
     */
    public function getCpfFormatadoAttribute()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    /**
     * Accessor para CEP formatado
     */
    public function getCepFormatadoAttribute()
    {
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $this->cep);
    }
}
