<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ouvidor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ouvidores';

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'cpf',
        'cargo',
        'setor',
        'tipo',
        'pode_gerenciar_esic',
        'pode_gerenciar_ouvidoria',
        'pode_visualizar_relatorios',
        'pode_responder_manifestacoes',
        'telefone',
        'ramal',
        'ativo',
        'data_inicio',
        'data_fim',
        'recebe_notificacao_email',
        'recebe_notificacao_sistema'
    ];

    protected $casts = [
        'pode_gerenciar_esic' => 'boolean',
        'pode_gerenciar_ouvidoria' => 'boolean',
        'pode_visualizar_relatorios' => 'boolean',
        'pode_responder_manifestacoes' => 'boolean',
        'ativo' => 'boolean',
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'recebe_notificacao_email' => 'boolean',
        'recebe_notificacao_sistema' => 'boolean',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manifestacoesResponsavel()
    {
        return $this->hasMany(OuvidoriaManifestacao::class, 'ouvidor_responsavel_id');
    }

    public function manifestacoesRespondidas()
    {
        return $this->hasMany(OuvidoriaManifestacao::class, 'respondida_por');
    }

    public function notificacoes()
    {
        return $this->morphMany(Notificacao::class, 'notificavel');
    }

    public function manifestacoes()
    {
        return $this->hasMany(OuvidoriaManifestacao::class, 'ouvidor_responsavel_id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeComPermissaoEsic($query)
    {
        return $query->where('pode_gerenciar_esic', true);
    }

    public function scopeComPermissaoOuvidoria($query)
    {
        return $query->where('pode_gerenciar_ouvidoria', true);
    }

    public function scopeQuePodemResponder($query)
    {
        return $query->where('pode_responder_manifestacoes', true);
    }

    // Accessors
    public function getCpfFormatadoAttribute()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    public function getTelefoneFormatadoAttribute()
    {
        if (strlen($this->telefone) == 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $this->telefone);
        } elseif (strlen($this->telefone) == 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $this->telefone);
        }
        return $this->telefone;
    }

    public function getTipoDescricaoAttribute()
    {
        $tipos = [
            'ouvidor_geral' => 'Ouvidor Geral',
            'ouvidor_setorial' => 'Ouvidor Setorial',
            'responsavel_esic' => 'Responsável E-SIC',
            'equipe_ouvidoria' => 'Equipe de Ouvidoria'
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }

    // Mutators
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = preg_replace('/[^0-9]/', '', $value);
    }

    // Métodos auxiliares
    public function isAtivo()
    {
        return $this->ativo && (is_null($this->data_fim) || $this->data_fim->isFuture());
    }

    public function podeGerenciarEsic()
    {
        return $this->pode_gerenciar_esic && $this->isAtivo();
    }

    public function podeGerenciarOuvidoria()
    {
        return $this->pode_gerenciar_ouvidoria && $this->isAtivo();
    }

    public function podeVisualizarRelatorios()
    {
        return $this->pode_visualizar_relatorios && $this->isAtivo();
    }

    public function podeResponderManifestacoes()
    {
        return $this->pode_responder_manifestacoes && $this->isAtivo();
    }

    public function isOuvidorGeral()
    {
        return $this->tipo === 'ouvidor_geral';
    }

    public function isResponsavelEsic()
    {
        return $this->tipo === 'responsavel_esic';
    }

    public function recebeNotificacoes()
    {
        return $this->recebe_notificacao_email || $this->recebe_notificacao_sistema;
    }

    // Estatísticas
    public function getTotalManifestacoes()
    {
        return $this->manifestacoesResponsavel()->count();
    }

    public function getManifestacoesPendentes()
    {
        return $this->manifestacoesResponsavel()
            ->whereIn('status', ['nova', 'em_analise', 'em_tramitacao', 'aguardando_informacoes'])
            ->count();
    }

    public function getManifestacoesConcluidas()
    {
        return $this->manifestacoesResponsavel()
            ->whereIn('status', ['respondida', 'finalizada'])
            ->count();
    }

    public function getManifestacoesPrazoVencido()
    {
        return $this->manifestacoesResponsavel()
            ->where('prazo_resposta', '<', now()->toDateString())
            ->whereNotIn('status', ['respondida', 'finalizada', 'arquivada'])
            ->count();
    }

    public function getManifestacoesPrazoVencendoHoje()
    {
        return $this->manifestacoesResponsavel()
            ->where('prazo_resposta', now()->toDateString())
            ->whereNotIn('status', ['respondida', 'finalizada', 'arquivada'])
            ->count();
    }

    public function getTempoMedioResposta()
    {
        $manifestacoes = $this->manifestacoesRespondidas()
            ->whereNotNull('respondida_em')
            ->get();

        if ($manifestacoes->isEmpty()) {
            return 0;
        }

        $totalDias = 0;
        foreach ($manifestacoes as $manifestacao) {
            $diasResposta = $manifestacao->created_at->diffInDays($manifestacao->respondida_em);
            $totalDias += $diasResposta;
        }

        return round($totalDias / $manifestacoes->count(), 1);
    }
}
