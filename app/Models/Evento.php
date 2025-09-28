<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Evento extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'tipo',
        'data_evento',
        'hora_inicio',
        'hora_fim',
        'local',
        'observacoes',
        'destaque',
        'cor_destaque',
        'ativo',
        'vereador_id',
        'sessao_id',
        'licitacao_id',
        'esic_solicitacao_id',
        'user_id'
    ];

    protected $casts = [
        'data_evento' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
        'destaque' => 'boolean',
        'ativo' => 'boolean'
    ];

    // Tipos de eventos disponíveis
    public static function getTipos()
    {
        return [
            'sessao_plenaria' => 'Sessão Plenária',
            'audiencia_publica' => 'Audiência Pública',
            'reuniao_comissao' => 'Reunião de Comissão',
            'votacao' => 'Votação',
            'licitacao' => 'Licitação',
            'agenda_vereador' => 'Agenda de Vereador',
            'ato_vereador' => 'Ato de Vereador',
            'data_comemorativa' => 'Data Comemorativa',
            'prazo_esic' => 'Prazo E-SIC',
            'outro' => 'Outro'
        ];
    }

    // Cores padrão por tipo de evento (conforme legenda do calendário)
    public static function getCoresPadrao()
    {
        return [
            'sessao_plenaria' => '#dc3545',     // Vermelho - Sessões Plenárias
            'audiencia_publica' => '#28a745',   // Verde - Audiências Públicas
            'reuniao_comissao' => '#007bff',    // Azul - Reuniões
            'votacao' => '#e83e8c',             // Rosa
            'licitacao' => '#ffc107',           // Amarelo - Licitações
            'agenda_vereador' => '#20c997',     // Verde água - Agenda dos Vereadores
            'ato_vereador' => '#6610f2',        // Índigo
            'data_comemorativa' => '#6f42c1',   // Roxo - Datas Comemorativas
            'prazo_esic' => '#fd7e14',          // Laranja - Meus Prazos E-SIC
            'outro' => '#6c757d'                // Cinza
        ];
    }

    // Relacionamentos
    public function vereador(): BelongsTo
    {
        return $this->belongsTo(Vereador::class);
    }

    public function sessao(): BelongsTo
    {
        return $this->belongsTo(Sessao::class);
    }

    public function licitacao(): BelongsTo
    {
        return $this->belongsTo(Licitacao::class);
    }

    public function esicSolicitacao(): BelongsTo
    {
        return $this->belongsTo(EsicSolicitacao::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopePorMes($query, $ano, $mes)
    {
        return $query->whereYear('data_evento', $ano)
                    ->whereMonth('data_evento', $mes);
    }

    public function scopeProximos($query, $limite = 5)
    {
        return $query->where('data_evento', '>=', now()->toDateString())
                    ->orderBy('data_evento')
                    ->orderBy('hora_inicio')
                    ->limit($limite);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhereHas('esicSolicitacao', function($esic) use ($userId) {
                  $esic->where('user_id', $userId);
              });
        });
    }

    // Accessors
    public function getTipoLabelAttribute()
    {
        return self::getTipos()[$this->tipo] ?? $this->tipo;
    }

    public function getDataFormatadaAttribute()
    {
        return $this->data_evento->format('d/m/Y');
    }

    public function getHorarioFormatadoAttribute()
    {
        if ($this->hora_inicio && $this->hora_fim) {
            return $this->hora_inicio->format('H:i') . ' às ' . $this->hora_fim->format('H:i');
        } elseif ($this->hora_inicio) {
            return $this->hora_inicio->format('H:i');
        }
        return 'Horário não definido';
    }

    public function getCorAttribute()
    {
        if ($this->cor_destaque) {
            return $this->cor_destaque;
        }
        
        $cores = self::getCoresPadrao();
        return $cores[$this->tipo] ?? '#007bff';
    }

    // Métodos auxiliares
    public function isHoje()
    {
        return $this->data_evento->isToday();
    }

    public function isAmanha()
    {
        return $this->data_evento->isTomorrow();
    }

    public function isPassado()
    {
        return $this->data_evento->isPast();
    }

    public function diasRestantes()
    {
        if ($this->isPassado()) {
            return 0;
        }
        
        return now()->diffInDays($this->data_evento);
    }

    // Método para criar evento automaticamente a partir de outros modelos
    public static function criarEventoAutomatico($tipo, $dados)
    {
        $evento = new self();
        $evento->tipo = $tipo;
        $evento->ativo = true;
        
        switch ($tipo) {
            case 'sessao_plenaria':
                $evento->titulo = 'Sessão Plenária - ' . $dados['tipo'];
                $evento->data_evento = $dados['data'];
                $evento->hora_inicio = $dados['hora_inicio'] ?? '14:00';
                $evento->local = 'Plenário da Câmara';
                $evento->sessao_id = $dados['id'];
                break;
                
            case 'licitacao':
                $evento->titulo = 'Licitação - ' . $dados['objeto'];
                $evento->data_evento = $dados['data_abertura'];
                $evento->hora_inicio = $dados['hora_abertura'] ?? '14:00';
                $evento->local = 'Sala de Licitações';
                $evento->licitacao_id = $dados['id'];
                break;
                
            case 'prazo_esic':
                $evento->titulo = 'Prazo E-SIC - ' . $dados['assunto'];
                $evento->data_evento = $dados['prazo_resposta'];
                $evento->descricao = 'Prazo para resposta da solicitação E-SIC';
                $evento->esic_solicitacao_id = $dados['id'];
                break;
        }
        
        $evento->save();
        return $evento;
    }
}
