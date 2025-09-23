<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class ProjetoLei extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos_lei';

    protected $fillable = [
        'numero',
        'ano',
        'tipo',
        'ementa',
        'justificativa',
        'texto_integral',
        'status',
        'data_protocolo',
        'data_aprovacao',
        'data_publicacao',
        'autor_id',
        'relator_id',
        'comissao_responsavel',
        'urgencia',
        'observacoes',
        'anexos',
        'tramitacao',
        'votacao_resultado',
        'lei_numero',
        'lei_data_sancao',
        'slug'
    ];

    protected $casts = [
        'data_protocolo' => 'date',
        'data_aprovacao' => 'date',
        'data_publicacao' => 'date',
        'lei_data_sancao' => 'date',
        'urgencia' => 'boolean',
        'anexos' => 'array',
        'tramitacao' => 'array',
        'votacao_resultado' => 'array'
    ];

    protected $dates = [
        'data_protocolo',
        'data_aprovacao',
        'data_publicacao',
        'lei_data_sancao',
        'deleted_at'
    ];

    // Relacionamentos
    public function autor()
    {
        return $this->belongsTo(Vereador::class, 'autor_id');
    }

    public function relator()
    {
        return $this->belongsTo(Vereador::class, 'relator_id');
    }

    public function sessoes()
    {
        return $this->belongsToMany(Sessao::class, 'sessao_projeto_lei')
                    ->withPivot(['ordem_pauta', 'resultado_votacao', 'observacoes'])
                    ->withTimestamps();
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'projeto_lei_id');
    }

    public function coautores()
    {
        return $this->belongsToMany(Vereador::class, 'projeto_lei_coautor')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeAprovados($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopeRejeitados($query)
    {
        return $query->where('status', 'rejeitado');
    }

    public function scopeTramitando($query)
    {
        return $query->where('status', 'tramitando');
    }

    public function scopeArquivados($query)
    {
        return $query->where('status', 'arquivado');
    }

    public function scopeSancionados($query)
    {
        return $query->where('status', 'sancionado');
    }

    public function scopeVetados($query)
    {
        return $query->where('status', 'vetado');
    }

    public function scopeUrgentes($query)
    {
        return $query->where('urgencia', true);
    }

    public function scopeAno($query, $ano)
    {
        return $query->where('ano', $ano);
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeAutor($query, $autorId)
    {
        return $query->where('autor_id', $autorId);
    }

    public function scopeRelator($query, $relatorId)
    {
        return $query->where('relator_id', $relatorId);
    }

    public function scopeComissao($query, $comissao)
    {
        return $query->where('comissao_responsavel', $comissao);
    }

    // Accessors
    protected function numeroCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => sprintf('%03d/%d', $this->numero, $this->ano),
        );
    }

    protected function dataProtocoloFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_protocolo?->format('d/m/Y'),
        );
    }

    protected function dataAprovacaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_aprovacao?->format('d/m/Y'),
        );
    }

    protected function dataPublicacaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_publicacao?->format('d/m/Y'),
        );
    }

    protected function leiDataSancaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->lei_data_sancao?->format('d/m/Y'),
        );
    }

    protected function statusFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                'apresentado' => 'Apresentado',
                'tramitando' => 'Em Tramitação',
                'aprovado' => 'Aprovado',
                'rejeitado' => 'Rejeitado',
                'arquivado' => 'Arquivado',
                'sancionado' => 'Sancionado',
                'vetado' => 'Vetado',
                'promulgado' => 'Promulgado',
                default => 'Indefinido'
            },
        );
    }

    protected function tipoFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->tipo) {
                'projeto_lei' => 'Projeto de Lei',
                'projeto_lei_complementar' => 'Projeto de Lei Complementar',
                'projeto_resolucao' => 'Projeto de Resolução',
                'projeto_decreto_legislativo' => 'Projeto de Decreto Legislativo',
                'emenda' => 'Emenda',
                'substitutivo' => 'Substitutivo',
                default => 'Indefinido'
            },
        );
    }

    protected function ementaResumo(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->ementa, 100),
        );
    }

    protected function tempoTramitacao(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_protocolo 
                ? $this->data_protocolo->diffInDays(now()) 
                : null,
        );
    }

    // Mutators
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?: Str::slug($this->numero_completo . '-' . Str::limit($this->ementa, 50)),
        );
    }

    // Métodos auxiliares
    public function isAprovado()
    {
        return $this->status === 'aprovado';
    }

    public function isRejeitado()
    {
        return $this->status === 'rejeitado';
    }

    public function isTramitando()
    {
        return $this->status === 'tramitando';
    }

    public function isArquivado()
    {
        return $this->status === 'arquivado';
    }

    public function isSancionado()
    {
        return $this->status === 'sancionado';
    }

    public function isVetado()
    {
        return $this->status === 'vetado';
    }

    public function isPromulgado()
    {
        return $this->status === 'promulgado';
    }

    public function isUrgente()
    {
        return $this->urgencia === true;
    }

    public function temAnexos()
    {
        return !empty($this->anexos);
    }

    public function getTotalAnexos()
    {
        return collect($this->anexos)->count();
    }

    public function getHistoricoTramitacao()
    {
        return collect($this->tramitacao)->sortBy('data');
    }

    public function getUltimaTramitacao()
    {
        return collect($this->tramitacao)->sortByDesc('data')->first();
    }

    public function adicionarTramitacao($descricao, $data = null, $responsavel = null)
    {
        $tramitacao = $this->tramitacao ?? [];
        $tramitacao[] = [
            'descricao' => $descricao,
            'data' => $data ?: now()->toISOString(),
            'responsavel' => $responsavel,
            'id' => Str::uuid()
        ];
        $this->update(['tramitacao' => $tramitacao]);
    }

    public function adicionarAnexo($nome, $caminho, $tipo = null, $tamanho = null)
    {
        $anexos = $this->anexos ?? [];
        $anexos[] = [
            'nome' => $nome,
            'caminho' => $caminho,
            'tipo' => $tipo,
            'tamanho' => $tamanho,
            'data_upload' => now()->toISOString(),
            'id' => Str::uuid()
        ];
        $this->update(['anexos' => $anexos]);
    }

    public function removerAnexo($anexoId)
    {
        $anexos = collect($this->anexos)->reject(function ($anexo) use ($anexoId) {
            return $anexo['id'] === $anexoId;
        })->values()->toArray();
        
        $this->update(['anexos' => $anexos]);
    }

    public function registrarVotacao($resultado, $detalhes = [])
    {
        $this->update([
            'votacao_resultado' => [
                'resultado' => $resultado,
                'detalhes' => $detalhes,
                'data_votacao' => now()->toISOString()
            ]
        ]);
    }

    public function podeSerEditado()
    {
        return in_array($this->status, ['apresentado', 'tramitando']);
    }

    public function podeSerVotado()
    {
        return $this->status === 'tramitando';
    }

    public function gerarNumeroSequencial($ano = null)
    {
        $ano = $ano ?: now()->year;
        $ultimoNumero = static::where('ano', $ano)->max('numero') ?? 0;
        return $ultimoNumero + 1;
    }

    // Boot method para auto-gerar slug e número
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($projeto) {
            if (empty($projeto->slug)) {
                $projeto->slug = Str::slug($projeto->numero_completo . '-' . Str::limit($projeto->ementa, 50));
            }
            
            if (empty($projeto->numero)) {
                $projeto->numero = $projeto->gerarNumeroSequencial($projeto->ano);
            }
        });

        static::updating(function ($projeto) {
            if ($projeto->isDirty(['numero', 'ano', 'ementa']) && empty($projeto->slug)) {
                $projeto->slug = Str::slug($projeto->numero_completo . '-' . Str::limit($projeto->ementa, 50));
            }
        });
    }

    // Validações customizadas
    public static function rules($id = null)
    {
        return [
            'numero' => 'required|integer|min:1',
            'ano' => 'required|integer|min:1900|max:' . (now()->year + 10),
            'tipo' => 'required|in:projeto_lei,projeto_lei_complementar,projeto_resolucao,projeto_decreto_legislativo,emenda,substitutivo',
            'ementa' => 'required|string|min:10|max:1000',
            'justificativa' => 'nullable|string|max:5000',
            'texto_integral' => 'nullable|string',
            'status' => 'required|in:apresentado,tramitando,aprovado,rejeitado,arquivado,sancionado,vetado,promulgado',
            'data_protocolo' => 'required|date',
            'data_aprovacao' => 'nullable|date|after_or_equal:data_protocolo',
            'data_publicacao' => 'nullable|date|after_or_equal:data_aprovacao',
            'autor_id' => 'required|exists:vereadores,id',
            'relator_id' => 'nullable|exists:vereadores,id',
            'comissao_responsavel' => 'nullable|string|max:100',
            'urgencia' => 'boolean',
            'lei_numero' => 'nullable|string|max:20',
            'lei_data_sancao' => 'nullable|date',
            'slug' => 'nullable|string|max:255|unique:projetos_lei,slug,' . $id
        ];
    }

    public static function messages()
    {
        return [
            'numero.required' => 'O número do projeto é obrigatório.',
            'numero.integer' => 'O número deve ser um valor inteiro.',
            'numero.min' => 'O número deve ser maior que zero.',
            'ano.required' => 'O ano é obrigatório.',
            'ano.integer' => 'O ano deve ser um valor inteiro.',
            'ano.min' => 'O ano deve ser maior que 1900.',
            'ano.max' => 'O ano não pode ser superior a ' . (now()->year + 10) . '.',
            'tipo.required' => 'O tipo do projeto é obrigatório.',
            'tipo.in' => 'O tipo deve ser: projeto de lei, projeto de lei complementar, projeto de resolução, projeto de decreto legislativo, emenda ou substitutivo.',
            'ementa.required' => 'A ementa é obrigatória.',
            'ementa.min' => 'A ementa deve ter pelo menos 10 caracteres.',
            'ementa.max' => 'A ementa não pode exceder 1000 caracteres.',
            'justificativa.max' => 'A justificativa não pode exceder 5000 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: apresentado, tramitando, aprovado, rejeitado, arquivado, sancionado, vetado ou promulgado.',
            'data_protocolo.required' => 'A data de protocolo é obrigatória.',
            'data_protocolo.date' => 'A data de protocolo deve ser uma data válida.',
            'data_aprovacao.date' => 'A data de aprovação deve ser uma data válida.',
            'data_aprovacao.after_or_equal' => 'A data de aprovação deve ser posterior ou igual à data de protocolo.',
            'data_publicacao.date' => 'A data de publicação deve ser uma data válida.',
            'data_publicacao.after_or_equal' => 'A data de publicação deve ser posterior ou igual à data de aprovação.',
            'autor_id.required' => 'O autor é obrigatório.',
            'autor_id.exists' => 'O autor selecionado não existe.',
            'relator_id.exists' => 'O relator selecionado não existe.',
            'comissao_responsavel.max' => 'O nome da comissão não pode exceder 100 caracteres.',
            'lei_numero.max' => 'O número da lei não pode exceder 20 caracteres.',
            'lei_data_sancao.date' => 'A data de sanção deve ser uma data válida.',
            'slug.unique' => 'Este slug já está em uso.'
        ];
    }

    // Métodos de busca
    public static function search($query)
    {
        return self::where(function ($q) use ($query) {
                $q->where('ementa', 'LIKE', "%{$query}%")
                  ->orWhere('justificativa', 'LIKE', "%{$query}%")
                  ->orWhere('texto_integral', 'LIKE', "%{$query}%")
                  ->orWhere('tipo', 'LIKE', "%{$query}%")
                  ->orWhere('lei_numero', 'LIKE', "%{$query}%")
                  ->orWhereRaw("CONCAT(numero, '/', ano) LIKE ?", ["%{$query}%"]);
            })
            ->orderBy('data_protocolo', 'desc');
    }

    public function getSearchableContent()
    {
        return [
            'numero_ano' => $this->numero . '/' . $this->ano,
            'tipo' => $this->tipo,
            'ementa' => $this->ementa,
            'justificativa' => strip_tags($this->justificativa),
            'status' => $this->status,
            'lei_numero' => $this->lei_numero,
        ];
    }

    public function getSearchUrl()
    {
        return route('projetos-lei.show', $this->slug ?: $this->id);
    }

    public function getSearchType()
    {
        return 'Projeto de Lei';
    }

    public function getSearchDate()
    {
        return $this->data_protocolo;
    }
}
