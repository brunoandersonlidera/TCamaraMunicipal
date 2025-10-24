<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class OuvidoriaManifestacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ouvidoria_manifestacoes';

    // Constantes de status
    const STATUS_RECEBIDA = 'recebida';
    const STATUS_NOVA = 'nova';
    const STATUS_EM_ANALISE = 'em_analise';
    const STATUS_EM_TRAMITACAO = 'em_tramitacao';
    const STATUS_AGUARDANDO_INFORMACOES = 'aguardando_informacoes';
    const STATUS_RESPONDIDA = 'respondida';
    const STATUS_FINALIZADA = 'finalizada';
    const STATUS_ARQUIVADA = 'arquivada';

    protected $fillable = [
        'protocolo',
        'esic_usuario_id',
        'ouvidor_responsavel_id',
        'tipo',
        'nome_manifestante',
        'email_manifestante',
        'telefone_manifestante',
        'manifestacao_anonima',
        'assunto',
        'descricao',
        'orgao_destinatario',
        'setor_destinatario',
        'categoria_esic',
        'status',
        'prazo_resposta',
        'prazo_prorrogado',
        'justificativa_prorrogacao',
        'resposta',
        'respondida_em',
        'respondida_por',
        'avaliacao_atendimento',
        'comentario_avaliacao',
        'avaliada_em',
        'prioridade',
        'requer_resposta',
        'informacao_sigilosa',
        'observacoes_internas',
        'ip_origem',
        'user_agent',
        'historico_status'
    ];

    protected $casts = [
        'manifestacao_anonima' => 'boolean',
        'prazo_resposta' => 'date',
        'prazo_prorrogado' => 'date',
        'respondida_em' => 'datetime',
        'avaliada_em' => 'datetime',
        'requer_resposta' => 'boolean',
        'informacao_sigilosa' => 'boolean',
        'historico_status' => 'array',
    ];

    // Relacionamentos
    public function ouvidorResponsavel()
    {
        return $this->belongsTo(User::class, 'ouvidor_responsavel_id');
    }

    public function respondidaPor()
    {
        return $this->belongsTo(User::class, 'respondida_por');
    }

    public function anexos()
    {
        return $this->hasMany(ManifestacaoAnexo::class, 'manifestacao_id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(OuvidoriaMovimentacao::class, 'ouvidoria_manifestacao_id');
    }

    // Scopes
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeEsic($query)
    {
        return $query->where('tipo', 'solicitacao_informacao');
    }

    public function scopeOuvidoria($query)
    {
        return $query->whereIn('tipo', ['reclamacao', 'sugestao', 'elogio', 'denuncia', 'ouvidoria_geral']);
    }

    public function scopePendentes($query)
    {
        return $query->whereIn('status', ['recebida', 'nova', 'em_analise', 'em_tramitacao', 'aguardando_informacoes']);
    }

    public function scopeConcluidas($query)
    {
        return $query->whereIn('status', ['respondida', 'finalizada']);
    }

    public function scopePrazoVencido($query)
    {
        return $query->where('prazo_resposta', '<', now()->toDateString())
                    ->whereNotIn('status', ['respondida', 'finalizada', 'arquivada']);
    }

    public function scopePrazoVencendoHoje($query)
    {
        return $query->where('prazo_resposta', now()->toDateString())
                    ->whereNotIn('status', ['respondida', 'finalizada', 'arquivada']);
    }

    public function scopePorPrioridade($query, $prioridade)
    {
        return $query->where('prioridade', $prioridade);
    }

    public function scopeComAnexos($query)
    {
        return $query->has('anexos');
    }

    public function scopeAnonimas($query)
    {
        return $query->where('manifestacao_anonima', true);
    }

    // Accessors
    public function getTipoDescricaoAttribute()
    {
        $tipos = [
            'solicitacao_informacao' => 'Solicitação de Informação (E-SIC)',
            'reclamacao' => 'Reclamação',
            'sugestao' => 'Sugestão',
            'elogio' => 'Elogio',
            'denuncia' => 'Denúncia',
            'ouvidoria_geral' => 'Ouvidoria Geral'
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }

    public function getStatusDescricaoAttribute()
    {
        $status = [
            'recebida' => 'Recebida',
            'nova' => 'Nova',
            'em_analise' => 'Em Análise',
            'em_tramitacao' => 'Em Tramitação',
            'aguardando_informacoes' => 'Aguardando Informações',
            'respondida' => 'Respondida',
            'finalizada' => 'Finalizada',
            'arquivada' => 'Arquivada'
        ];

        return $status[$this->status] ?? $this->status;
    }

    public function getPrioridadeDescricaoAttribute()
    {
        $prioridades = [
            'baixa' => 'Baixa',
            'media' => 'Média',
            'alta' => 'Alta',
            'urgente' => 'Urgente'
        ];

        return $prioridades[$this->prioridade] ?? $this->prioridade;
    }

    public function getDiasParaVencimentoAttribute()
    {
        $prazo = $this->prazo_prorrogado ?? $this->prazo_resposta;
        return now()->diffInDays($prazo, false);
    }

    public function diasParaVencimentoFormatado()
    {
        $prazo = $this->prazo_prorrogado ?? $this->prazo_resposta;
        
        if (!$prazo) {
            return 'Não definido';
        }

        $agora = now();
        $diffInMinutes = $agora->diffInMinutes($prazo, false);
        
        if ($diffInMinutes < 0) {
            return 'Vencido';
        }
        
        $dias = intval($diffInMinutes / (24 * 60));
        $horas = intval(($diffInMinutes % (24 * 60)) / 60);
        $minutos = $diffInMinutes % 60;
        
        $resultado = [];
        
        if ($dias > 0) {
            $resultado[] = $dias . ($dias == 1 ? ' dia' : ' dias');
        }
        
        if ($horas > 0) {
            $resultado[] = $horas . ($horas == 1 ? ' hora' : ' horas');
        }
        
        if ($minutos > 0 && $dias == 0) {
            $resultado[] = $minutos . ($minutos == 1 ? ' minuto' : ' minutos');
        }
        
        return empty($resultado) ? '0 minutos' : implode(' e ', $resultado);
    }

    public function getStatusPrazoAttribute()
    {
        $dias = $this->dias_para_vencimento;
        
        if ($dias < 0) {
            return 'vencido';
        } elseif ($dias == 0) {
            return 'vence_hoje';
        } elseif ($dias <= 3) {
            return 'vence_em_breve';
        } else {
            return 'no_prazo';
        }
    }

    public function getManifestanteNomeAttribute()
    {
        if ($this->manifestacao_anonima) {
            return 'Manifestação Anônima';
        }
        
        return $this->nome_manifestante ?? 'Não informado';
    }

    public function getManifestanteEmailAttribute()
    {
        if ($this->manifestacao_anonima) {
            return null;
        }
        
        return $this->email_manifestante;
    }

    // Métodos auxiliares
    public function isEsic()
    {
        return $this->tipo === 'solicitacao_informacao';
    }

    public function isOuvidoria()
    {
        return in_array($this->tipo, ['reclamacao', 'sugestao', 'elogio', 'denuncia', 'ouvidoria_geral']);
    }

    public function isPendente()
    {
        return in_array($this->status, ['nova', 'em_analise', 'em_tramitacao', 'aguardando_informacoes']);
    }

    public function isConcluida()
    {
        return in_array($this->status, ['respondida', 'finalizada']);
    }

    public function isPrazoVencido()
    {
        return $this->status_prazo === 'vencido';
    }

    public function isPrazoVencendoHoje()
    {
        return $this->status_prazo === 'vence_hoje';
    }

    public function podeSerRespondida()
    {
        return $this->isPendente() && $this->requer_resposta;
    }

    public function podeSerAvaliada()
    {
        return $this->isConcluida() && is_null($this->avaliacao_atendimento);
    }

    public function temAnexos()
    {
        return $this->anexos()->count() > 0;
    }

    // Métodos de ação
    public function gerarProtocolo()
    {
        $ano = now()->year;
        $sequencial = static::whereYear('created_at', $ano)->count() + 1;
        $tipo = $this->isEsic() ? 'ESIC' : 'OUV';
        
        $this->protocolo = sprintf('%s%04d%06d', $tipo, $ano, $sequencial);
        
        return $this->protocolo;
    }

    public function alterarStatus($novoStatus, $observacao = null, $ouvidorId = null)
    {
        $statusAnterior = $this->status;
        $this->status = $novoStatus;
        
        // Atualizar histórico
        $historico = $this->historico_status ?? [];
        $historico[] = [
            'status_anterior' => $statusAnterior,
            'status_novo' => $novoStatus,
            'data_alteracao' => now()->toISOString(),
            'ouvidor_id' => $ouvidorId,
            'observacao' => $observacao
        ];
        $this->historico_status = $historico;
        
        $this->save();
        
        return $this;
    }

    public function definirPrazoResposta()
    {
        // Conforme LAI - 20 dias para E-SIC, 30 dias para Ouvidoria
        $dias = $this->isEsic() ? 20 : 30;
        $this->prazo_resposta = now()->addDays($dias)->toDateString();
        $this->save();
        
        return $this;
    }

    public function prorrogarPrazo($dias, $justificativa)
    {
        $prazoAtual = $this->prazo_prorrogado ?? $this->prazo_resposta;
        $this->prazo_prorrogado = Carbon::parse($prazoAtual)->addDays($dias)->toDateString();
        $this->justificativa_prorrogacao = $justificativa;
        $this->save();
        
        return $this;
    }

    public function responder($resposta, $ouvidorId)
    {
        $this->resposta = $resposta;
        $this->respondida_em = now();
        $this->respondida_por = $ouvidorId;
        $this->alterarStatus('respondida', 'Manifestação respondida', $ouvidorId);
        
        return $this;
    }

    public function avaliar($nota, $comentario = null)
    {
        $this->avaliacao_atendimento = $nota;
        $this->comentario_avaliacao = $comentario;
        $this->avaliada_em = now();
        $this->save();
        
        return $this;
    }

    public function finalizar($ouvidorId = null)
    {
        $this->alterarStatus('finalizada', 'Manifestação finalizada', $ouvidorId);
        return $this;
    }

    public function arquivar($ouvidorId = null)
    {
        $this->alterarStatus('arquivada', 'Manifestação arquivada', $ouvidorId);
        return $this;
    }

    // Boot method para eventos
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($manifestacao) {
            if (empty($manifestacao->protocolo)) {
                $manifestacao->gerarProtocolo();
            }
            
            if (empty($manifestacao->prazo_resposta)) {
                $manifestacao->definirPrazoResposta();
            }
        });
    }
}
