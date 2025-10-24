<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class EsicMensagem extends Model
{
    protected $table = 'esic_mensagens';

    protected $fillable = [
        'esic_solicitacao_id',
        'usuario_id',
        'tipo_remetente',
        'tipo_comunicacao',
        'mensagem',
        'canal_comunicacao',
        'telefone_contato',
        'email_contato',
        'observacoes_canal',
        'anexos',
        'lida',
        'data_leitura',
        'interna',
        'ip_usuario'
    ];

    protected $casts = [
        'anexos' => 'array',
        'lida' => 'boolean',
        'interna' => 'boolean',
        'data_leitura' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Constantes para tipos de remetente
    const TIPO_CIDADAO = 'cidadao';
    const TIPO_OUVIDOR = 'ouvidor';

    // Constantes para tipos de comunicação
    const TIPO_MENSAGEM = 'mensagem';
    const TIPO_RESPOSTA_OFICIAL = 'resposta_oficial';
    const TIPO_COMUNICACAO_INTERNA = 'comunicacao_interna';

    // Constantes para canais de comunicação
    const CANAL_SISTEMA = 'sistema';
    const CANAL_TELEFONE = 'telefone';
    const CANAL_WHATSAPP = 'whatsapp';
    const CANAL_EMAIL = 'email';
    const CANAL_PRESENCIAL = 'presencial';
    const CANAL_CARTA = 'carta';
    const CANAL_OUTRO = 'outro';

    /**
     * Relacionamento com EsicSolicitacao
     */
    public function solicitacao(): BelongsTo
    {
        return $this->belongsTo(EsicSolicitacao::class, 'esic_solicitacao_id');
    }

    /**
     * Relacionamento com User (remetente)
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Verifica se a mensagem foi enviada pelo cidadão
     */
    public function isCidadao(): bool
    {
        return $this->tipo_remetente === self::TIPO_CIDADAO;
    }

    /**
     * Verifica se a mensagem foi enviada pelo ouvidor
     */
    public function isOuvidor(): bool
    {
        return $this->tipo_remetente === self::TIPO_OUVIDOR;
    }

    /**
     * Verifica se a mensagem tem anexos
     */
    public function temAnexos(): bool
    {
        return !empty($this->anexos);
    }

    /**
     * Retorna o número de anexos
     */
    public function numeroAnexos(): int
    {
        return $this->temAnexos() ? count($this->anexos) : 0;
    }

    /**
     * Marca a mensagem como lida
     */
    public function marcarComoLida(): void
    {
        $this->update([
            'lida' => true,
            'data_leitura' => now()
        ]);
    }

    /**
     * Retorna o nome formatado do canal de comunicação
     */
    public function getCanalFormatado(): string
    {
        return match($this->canal_comunicacao) {
            self::CANAL_SISTEMA => 'Sistema',
            self::CANAL_TELEFONE => 'Telefone',
            self::CANAL_WHATSAPP => 'WhatsApp',
            self::CANAL_EMAIL => 'E-mail',
            self::CANAL_PRESENCIAL => 'Presencial',
            self::CANAL_CARTA => 'Carta',
            self::CANAL_OUTRO => 'Outro',
            default => 'Sistema'
        };
    }

    /**
     * Retorna o ícone do canal de comunicação
     */
    public function getIconeCanal(): string
    {
        return match($this->canal_comunicacao) {
            self::CANAL_SISTEMA => 'fas fa-desktop',
            self::CANAL_TELEFONE => 'fas fa-phone',
            self::CANAL_WHATSAPP => 'fab fa-whatsapp',
            self::CANAL_EMAIL => 'fas fa-envelope',
            self::CANAL_PRESENCIAL => 'fas fa-user',
            self::CANAL_CARTA => 'fas fa-mail-bulk',
            self::CANAL_OUTRO => 'fas fa-comment',
            default => 'fas fa-desktop'
        };
    }

    /**
     * Retorna a cor do canal de comunicação
     */
    public function getCorCanal(): string
    {
        return match($this->canal_comunicacao) {
            self::CANAL_SISTEMA => 'primary',
            self::CANAL_TELEFONE => 'info',
            self::CANAL_WHATSAPP => 'success',
            self::CANAL_EMAIL => 'warning',
            self::CANAL_PRESENCIAL => 'secondary',
            self::CANAL_CARTA => 'dark',
            self::CANAL_OUTRO => 'muted',
            default => 'primary'
        };
    }

    /**
     * Retorna o tipo de comunicação formatado
     */
    public function getTipoComunicacaoFormatado(): string
    {
        return match($this->tipo_comunicacao) {
            self::TIPO_MENSAGEM => 'Mensagem',
            self::TIPO_RESPOSTA_OFICIAL => 'Resposta Oficial',
            self::TIPO_COMUNICACAO_INTERNA => 'Comunicação Interna',
            default => 'Mensagem'
        };
    }

    /**
     * Scope para mensagens não lidas
     */
    public function scopeNaoLidas($query)
    {
        return $query->where('lida', false);
    }

    /**
     * Scope para mensagens do cidadão
     */
    public function scopeDoCidadao($query)
    {
        return $query->where('tipo_remetente', self::TIPO_CIDADAO);
    }

    /**
     * Scope para mensagens do ouvidor
     */
    public function scopeDoOuvidor($query)
    {
        return $query->where('tipo_remetente', self::TIPO_OUVIDOR);
    }

    /**
     * Scope para mensagens públicas (não internas)
     */
    public function scopePublicas($query)
    {
        return $query->where('interna', false);
    }

    /**
     * Scope para mensagens internas
     */
    public function scopeInternas($query)
    {
        return $query->where('interna', true);
    }
}
