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
        'tipo_sessao_id',
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
        'presidente_id',
        'secretario_id',
        // Novos campos para vídeo gravado
        'video_url',
        'plataforma_video',
        'thumbnail_url',
        'duracao_video',
        'descricao_video',
        'video_disponivel',
        'data_gravacao'
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
        'gravacao_disponivel' => 'boolean',
        'video_disponivel' => 'boolean',
        'data_gravacao' => 'datetime'
    ];

    protected $dates = [
        'data_sessao',
        'deleted_at'
    ];

    // Relacionamentos
    public function tipoSessao()
    {
        return $this->belongsTo(TipoSessao::class, 'tipo_sessao_id');
    }

    public function presidenteSessao()
    {
        return $this->belongsTo(Vereador::class, 'presidente_id');
    }

    public function secretarioSessao()
    {
        return $this->belongsTo(Vereador::class, 'secretario_id');
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
        return $query->where('status', 'finalizada');
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

    public function scopeComVideo($query)
    {
        return $query->where('video_disponivel', true)
                    ->whereNotNull('video_url');
    }

    public function scopeAoVivo($query)
    {
        return $query->where('status', 'em_andamento')
                    ->where('transmissao_online', true)
                    ->whereNotNull('link_transmissao');
    }

    public function scopePlataforma($query, $plataforma)
    {
        return $query->where('plataforma_video', $plataforma);
    }

    public function scopeRecentes($query, $limite = 4)
    {
        return $query->where('status', 'finalizada')
                    ->where('video_disponivel', true)
                    ->orderBy('data_sessao', 'desc')
                    ->limit($limite);
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

    public function temVideo()
    {
        return $this->video_disponivel && !empty($this->video_url);
    }

    public function getVideoId()
    {
        if (!$this->video_url) return null;

        switch ($this->plataforma_video) {
            case 'youtube':
                if (str_contains($this->video_url, 'youtube.com/watch?v=')) {
                    $videoId = substr($this->video_url, strpos($this->video_url, 'v=') + 2);
                    return substr($videoId, 0, strpos($videoId, '&') ?: strlen($videoId));
                } elseif (str_contains($this->video_url, 'youtu.be/')) {
                    return substr($this->video_url, strrpos($this->video_url, '/') + 1);
                }
                break;
            case 'vimeo':
                if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches)) {
                    return $matches[1];
                }
                break;
            case 'facebook':
                if (preg_match('/facebook\.com\/.*\/videos\/(\d+)/', $this->video_url, $matches)) {
                    return $matches[1];
                }
                break;
        }

        return null;
    }

    public function getEmbedUrl()
    {
        $videoId = $this->getVideoId();
        if (!$videoId) return null;

        switch ($this->plataforma_video) {
            case 'youtube':
                return "https://www.youtube.com/embed/{$videoId}";
            case 'vimeo':
                return "https://player.vimeo.com/video/{$videoId}";
            case 'facebook':
                return "https://www.facebook.com/plugins/video.php?href=" . urlencode($this->video_url);
            default:
                return $this->video_url;
        }
    }

    public function getThumbnailUrl()
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }

        $videoId = $this->getVideoId();
        if (!$videoId) return null;

        switch ($this->plataforma_video) {
            case 'youtube':
                return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
            case 'vimeo':
                // Para Vimeo, seria necessário fazer uma chamada à API
                return null;
            case 'facebook':
                // Facebook não fornece thumbnails diretas
                return null;
            default:
                return null;
        }
    }

    public function getDuracaoFormatada()
    {
        if (!$this->duracao_video) return null;

        $horas = floor($this->duracao_video / 3600);
        $minutos = floor(($this->duracao_video % 3600) / 60);
        $segundos = $this->duracao_video % 60;

        if ($horas > 0) {
            return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
        } else {
            return sprintf('%02d:%02d', $minutos, $segundos);
        }
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

    // Métodos de busca
    public static function search($query)
    {
        return self::where(function ($q) use ($query) {
                $q->where('tipo', 'LIKE', "%{$query}%")
                  ->orWhere('observacoes', 'LIKE', "%{$query}%")
                  ->orWhere('legislatura', 'LIKE', "%{$query}%")
                  ->orWhere('descricao_video', 'LIKE', "%{$query}%")
                  ->orWhereRaw("CONCAT(numero_sessao, '/', YEAR(data_sessao)) LIKE ?", ["%{$query}%"]);
            })
            ->orderBy('data_sessao', 'desc');
    }

    public function getSearchableContent()
    {
        return [
            'numero_ano' => $this->numero_sessao . '/' . $this->data_sessao->year,
            'tipo' => $this->tipo,
            'status' => $this->status,
            'legislatura' => $this->legislatura,
            'observacoes' => $this->observacoes,
            'descricao_video' => $this->descricao_video,
        ];
    }

    public function getSearchUrl()
    {
        return route('sessoes.show', $this->id);
    }

    public function getSearchType()
    {
        return 'Sessão';
    }

    public function getSearchDate()
    {
        return $this->data_sessao;
    }
}
