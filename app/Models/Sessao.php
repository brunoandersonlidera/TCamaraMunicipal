<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Sessao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sessoes';

    protected $fillable = [
        'numero_sessao',
        'tipo',
        'data_sessao',
        'hora_inicio',
        'hora_fim',
        'status',
        'pauta',
        'ata',
        'presencas',
        'votacoes',
        'transmissao_online',
        'link_transmissao',
        'gravacao_disponivel',
        'link_gravacao',
        'observacoes',
        'legislatura',
        'presidente_sessao_id',
        'secretario_sessao_id'
    ];

    protected $casts = [
        'data_sessao' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
        'pauta' => 'array',
        'ata' => 'array',
        'presencas' => 'array',
        'votacoes' => 'array',
        'transmissao_online' => 'boolean',
        'gravacao_disponivel' => 'boolean'
    ];

    protected $dates = [
        'data_sessao',
        'deleted_at'
    ];

    // Relacionamentos
    public function presidenteSessao()
    {
        return $this->belongsTo(Vereador::class, 'presidente_sessao_id');
    }

    public function secretarioSessao()
    {
        return $this->belongsTo(Vereador::class, 'secretario_sessao_id');
    }

    public function projetosLei()
    {
        return $this->belongsToMany(ProjetoLei::class, 'sessao_projeto_lei')
                    ->withPivot(['ordem_pauta', 'resultado_votacao', 'observacoes'])
                    ->withTimestamps();
    }

    public function vereadores()
    {
        return $this->belongsToMany(Vereador::class, 'sessao_vereador')
                    ->withPivot(['presente', 'justificativa_ausencia', 'observacoes'])
                    ->withTimestamps();
    }

    // Scopes
    public function scopeOrdinarias($query)
    {
        return $query->where('tipo', 'ordinaria');
    }

    public function scopeExtraordinarias($query)
    {
        return $query->where('tipo', 'extraordinaria');
    }

    public function scopeSolenes($query)
    {
        return $query->where('tipo', 'solene');
    }

    public function scopeRealizadas($query)
    {
        return $query->where('status', 'realizada');
    }

    public function scopeAgendadas($query)
    {
        return $query->where('status', 'agendada');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('status', 'cancelada');
    }

    public function scopeLegislatura($query, $legislatura)
    {
        return $query->where('legislatura', $legislatura);
    }

    public function scopeAno($query, $ano)
    {
        return $query->whereYear('data_sessao', $ano);
    }

    public function scopeMes($query, $mes)
    {
        return $query->whereMonth('data_sessao', $mes);
    }

    public function scopeComTransmissao($query)
    {
        return $query->where('transmissao_online', true);
    }

    public function scopeComGravacao($query)
    {
        return $query->where('gravacao_disponivel', true);
    }

    // Accessors
    protected function dataFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_sessao?->format('d/m/Y'),
        );
    }

    protected function horaInicioFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hora_inicio?->format('H:i'),
        );
    }

    protected function horaFimFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hora_fim?->format('H:i'),
        );
    }

    protected function duracaoSessao(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hora_inicio && $this->hora_fim 
                ? $this->hora_inicio->diffInMinutes($this->hora_fim) 
                : null,
        );
    }

    protected function numeroFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => str_pad($this->numero_sessao, 3, '0', STR_PAD_LEFT) . '/' . $this->data_sessao?->year,
        );
    }

    protected function statusFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                'agendada' => 'Agendada',
                'em_andamento' => 'Em Andamento',
                'realizada' => 'Realizada',
                'cancelada' => 'Cancelada',
                'adiada' => 'Adiada',
                default => 'Indefinido'
            },
        );
    }

    protected function tipoFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->tipo) {
                'ordinaria' => 'Ordinária',
                'extraordinaria' => 'Extraordinária',
                'solene' => 'Solene',
                'especial' => 'Especial',
                default => 'Indefinido'
            },
        );
    }

    // Métodos auxiliares
    public function getTotalPresentes()
    {
        if (!$this->presencas) return 0;
        
        return collect($this->presencas)->where('presente', true)->count();
    }

    public function getTotalAusentes()
    {
        if (!$this->presencas) return 0;
        
        return collect($this->presencas)->where('presente', false)->count();
    }

    public function getPercentualPresenca()
    {
        $total = collect($this->presencas)->count();
        if ($total === 0) return 0;
        
        $presentes = $this->getTotalPresentes();
        return round(($presentes / $total) * 100, 2);
    }

    public function getTotalVotacoes()
    {
        return collect($this->votacoes)->count();
    }

    public function getItensPauta()
    {
        return collect($this->pauta);
    }

    public function isRealizada()
    {
        return $this->status === 'realizada';
    }

    public function isAgendada()
    {
        return $this->status === 'agendada';
    }

    public function isCancelada()
    {
        return $this->status === 'cancelada';
    }

    public function isEmAndamento()
    {
        return $this->status === 'em_andamento';
    }

    public function temTransmissao()
    {
        return $this->transmissao_online && !empty($this->link_transmissao);
    }

    public function temGravacao()
    {
        return $this->gravacao_disponivel && !empty($this->link_gravacao);
    }

    public function podeSerEditada()
    {
        return in_array($this->status, ['agendada', 'em_andamento']);
    }

    public function adicionarItemPauta($item)
    {
        $pauta = $this->pauta ?? [];
        $pauta[] = $item;
        $this->update(['pauta' => $pauta]);
    }

    public function registrarPresenca($vereadorId, $presente = true, $justificativa = null)
    {
        $presencas = $this->presencas ?? [];
        $presencas[$vereadorId] = [
            'presente' => $presente,
            'justificativa' => $justificativa,
            'registrado_em' => now()->toISOString()
        ];
        $this->update(['presencas' => $presencas]);
    }

    public function registrarVotacao($projetoId, $resultado, $detalhes = [])
    {
        $votacoes = $this->votacoes ?? [];
        $votacoes[$projetoId] = [
            'resultado' => $resultado,
            'detalhes' => $detalhes,
            'registrado_em' => now()->toISOString()
        ];
        $this->update(['votacoes' => $votacoes]);
    }

    // Validações customizadas
    public static function rules($id = null)
    {
        return [
            'numero_sessao' => 'required|integer|min:1',
            'tipo' => 'required|in:ordinaria,extraordinaria,solene,especial',
            'data_sessao' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i|after:hora_inicio',
            'status' => 'required|in:agendada,em_andamento,realizada,cancelada,adiada',
            'legislatura' => 'required|string|max:20',
            'presidente_sessao_id' => 'nullable|exists:vereadores,id',
            'secretario_sessao_id' => 'nullable|exists:vereadores,id',
            'link_transmissao' => 'nullable|url',
            'link_gravacao' => 'nullable|url',
            'transmissao_online' => 'boolean',
            'gravacao_disponivel' => 'boolean'
        ];
    }

    public static function messages()
    {
        return [
            'numero_sessao.required' => 'O número da sessão é obrigatório.',
            'numero_sessao.integer' => 'O número da sessão deve ser um número inteiro.',
            'numero_sessao.min' => 'O número da sessão deve ser maior que zero.',
            'tipo.required' => 'O tipo da sessão é obrigatório.',
            'tipo.in' => 'O tipo deve ser: ordinária, extraordinária, solene ou especial.',
            'data_sessao.required' => 'A data da sessão é obrigatória.',
            'data_sessao.date' => 'A data da sessão deve ser uma data válida.',
            'hora_inicio.required' => 'A hora de início é obrigatória.',
            'hora_inicio.date_format' => 'A hora de início deve estar no formato HH:MM.',
            'hora_fim.date_format' => 'A hora de fim deve estar no formato HH:MM.',
            'hora_fim.after' => 'A hora de fim deve ser posterior à hora de início.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: agendada, em andamento, realizada, cancelada ou adiada.',
            'legislatura.required' => 'A legislatura é obrigatória.',
            'presidente_sessao_id.exists' => 'O presidente da sessão selecionado não existe.',
            'secretario_sessao_id.exists' => 'O secretário da sessão selecionado não existe.',
            'link_transmissao.url' => 'O link de transmissão deve ser uma URL válida.',
            'link_gravacao.url' => 'O link de gravação deve ser uma URL válida.'
        ];
    }
}
