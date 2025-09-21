<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class Notificacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notificacoes';

    protected $fillable = [
        'notificavel_type',
        'notificavel_id',
        'manifestacao_id',
        'tipo',
        'titulo',
        'mensagem',
        'canal',
        'lida',
        'enviada',
        'prioridade',
        'agendada_para',
        'acoes',
        'expira_em'
    ];

    protected $casts = [
        'lida' => 'boolean',
        'enviada' => 'boolean',
        'agendada_para' => 'datetime',
        'expira_em' => 'datetime',
        'acoes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Enums
    const TIPOS = [
        'nova_manifestacao' => 'Nova Manifestação',
        'resposta_manifestacao' => 'Resposta da Manifestação',
        'prazo_vencendo' => 'Prazo Vencendo',
        'prazo_vencido' => 'Prazo Vencido',
        'manifestacao_encaminhada' => 'Manifestação Encaminhada',
        'solicitacao_informacao' => 'Solicitação de Informação',
        'confirmacao_email' => 'Confirmação de E-mail',
        'recuperacao_senha' => 'Recuperação de Senha',
        'sistema' => 'Notificação do Sistema'
    ];

    const CANAIS = [
        'email' => 'E-mail',
        'sistema' => 'Sistema',
        'sms' => 'SMS',
        'push' => 'Push Notification'
    ];

    const PRIORIDADES = [
        'baixa' => 'Baixa',
        'normal' => 'Normal',
        'alta' => 'Alta',
        'urgente' => 'Urgente'
    ];

    // Relacionamentos
    public function notificavel()
    {
        return $this->morphTo();
    }

    public function manifestacao()
    {
        return $this->belongsTo(OuvidoriaManifestacao::class, 'manifestacao_id');
    }

    // Scopes
    public function scopeNaoLidas($query)
    {
        return $query->where('lida', false);
    }

    public function scopeLidas($query)
    {
        return $query->where('lida', true);
    }

    public function scopeEnviadas($query)
    {
        return $query->where('enviada', true);
    }

    public function scopePendentes($query)
    {
        return $query->where('enviada', false);
    }

    public function scopeAgendadas($query)
    {
        return $query->whereNotNull('agendada_para')
                    ->where('agendada_para', '>', now());
    }

    public function scopeProntas($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('agendada_para')
              ->orWhere('agendada_para', '<=', now());
        })->where('enviada', false);
    }

    public function scopeExpiradas($query)
    {
        return $query->whereNotNull('expira_em')
                    ->where('expira_em', '<', now());
    }

    public function scopeVigentes($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expira_em')
              ->orWhere('expira_em', '>=', now());
        });
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorCanal($query, $canal)
    {
        return $query->where('canal', $canal);
    }

    public function scopePorPrioridade($query, $prioridade)
    {
        return $query->where('prioridade', $prioridade);
    }

    public function scopeRecentes($query, $dias = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    // Accessors
    public function getTipoFormatadoAttribute()
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    public function getCanalFormatadoAttribute()
    {
        return self::CANAIS[$this->canal] ?? $this->canal;
    }

    public function getPrioridadeFormatadaAttribute()
    {
        return self::PRIORIDADES[$this->prioridade] ?? $this->prioridade;
    }

    public function getEstaExpiradaAttribute()
    {
        return $this->expira_em && $this->expira_em->isPast();
    }

    public function getEstaAgendadaAttribute()
    {
        return $this->agendada_para && $this->agendada_para->isFuture();
    }

    public function getPodeSerEnviadaAttribute()
    {
        if ($this->enviada) {
            return false;
        }

        if ($this->esta_expirada) {
            return false;
        }

        if ($this->esta_agendada) {
            return false;
        }

        return true;
    }

    public function getTempoEsperaAttribute()
    {
        if (!$this->agendada_para) {
            return null;
        }

        return $this->agendada_para->diffForHumans();
    }

    public function getTempoExpiracaoAttribute()
    {
        if (!$this->expira_em) {
            return null;
        }

        return $this->expira_em->diffForHumans();
    }

    public function getCorPrioridadeAttribute()
    {
        return match($this->prioridade) {
            'baixa' => 'success',
            'normal' => 'info',
            'alta' => 'warning',
            'urgente' => 'danger',
            default => 'secondary'
        };
    }

    // Métodos de ação
    public function marcarComoLida()
    {
        $this->lida = true;
        return $this->save();
    }

    public function marcarComoNaoLida()
    {
        $this->lida = false;
        return $this->save();
    }

    public function enviar()
    {
        if (!$this->pode_ser_enviada) {
            return false;
        }

        try {
            switch ($this->canal) {
                case 'email':
                    return $this->enviarPorEmail();
                case 'sms':
                    return $this->enviarPorSms();
                case 'push':
                    return $this->enviarPushNotification();
                case 'sistema':
                default:
                    // Notificação do sistema já está "enviada" ao ser criada
                    break;
            }

            $this->enviada = true;
            $this->save();
            return true;

        } catch (\Exception $e) {
            \Log::error('Erro ao enviar notificação: ' . $e->getMessage(), [
                'notificacao_id' => $this->id,
                'canal' => $this->canal,
                'tipo' => $this->tipo
            ]);
            return false;
        }
    }

    public function reagendar($novaData)
    {
        $this->agendada_para = $novaData;
        $this->enviada = false;
        return $this->save();
    }

    public function cancelar()
    {
        return $this->delete();
    }

    // Métodos privados de envio
    private function enviarPorEmail()
    {
        if (!$this->notificavel || !method_exists($this->notificavel, 'email')) {
            return false;
        }

        $email = $this->notificavel->email;
        if (!$email) {
            return false;
        }

        // Aqui você implementaria o envio real do email
        // Mail::to($email)->send(new NotificacaoMail($this));
        
        return true;
    }

    private function enviarPorSms()
    {
        // Implementar envio por SMS
        return true;
    }

    private function enviarPushNotification()
    {
        // Implementar push notification
        return true;
    }

    // Métodos estáticos
    public static function criarNotificacao($destinatario, $tipo, $dados = [])
    {
        $notificacao = new self();
        $notificacao->notificavel()->associate($destinatario);
        $notificacao->tipo = $tipo;
        $notificacao->titulo = $dados['titulo'] ?? self::TIPOS[$tipo] ?? 'Notificação';
        $notificacao->mensagem = $dados['mensagem'] ?? '';
        $notificacao->canal = $dados['canal'] ?? 'sistema';
        $notificacao->prioridade = $dados['prioridade'] ?? 'normal';
        $notificacao->manifestacao_id = $dados['manifestacao_id'] ?? null;
        $notificacao->agendada_para = $dados['agendada_para'] ?? null;
        $notificacao->expira_em = $dados['expira_em'] ?? null;
        $notificacao->acoes = $dados['acoes'] ?? null;

        $notificacao->save();

        // Se não está agendada, tenta enviar imediatamente
        if (!$notificacao->esta_agendada) {
            $notificacao->enviar();
        }

        return $notificacao;
    }

    public static function enviarPendentes()
    {
        $notificacoes = self::prontas()->get();
        $enviadas = 0;

        foreach ($notificacoes as $notificacao) {
            if ($notificacao->enviar()) {
                $enviadas++;
            }
        }

        return $enviadas;
    }

    public static function limparExpiradas()
    {
        return self::expiradas()->delete();
    }

    public static function estatisticas()
    {
        return [
            'total' => self::count(),
            'nao_lidas' => self::naoLidas()->count(),
            'pendentes' => self::pendentes()->count(),
            'agendadas' => self::agendadas()->count(),
            'expiradas' => self::expiradas()->count(),
            'por_tipo' => self::selectRaw('tipo, COUNT(*) as total')
                             ->groupBy('tipo')
                             ->pluck('total', 'tipo')
                             ->toArray(),
            'por_canal' => self::selectRaw('canal, COUNT(*) as total')
                              ->groupBy('canal')
                              ->pluck('total', 'canal')
                              ->toArray()
        ];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notificacao) {
            // Define valores padrão
            if (!$notificacao->prioridade) {
                $notificacao->prioridade = 'normal';
            }
            
            if (!$notificacao->canal) {
                $notificacao->canal = 'sistema';
            }
        });
    }
}
