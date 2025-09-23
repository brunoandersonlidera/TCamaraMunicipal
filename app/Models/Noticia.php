<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'slug',
        'resumo',
        'conteudo',
        'imagem_destaque',
        'galeria_imagens',
        'autor_id',
        'status',
        'destaque',
        'visualizacoes',
        'tags',
        'categoria',
        'data_publicacao',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'data_publicacao' => 'datetime',
        'galeria_imagens' => 'array',
        'tags' => 'array',
        'destaque' => 'boolean',
        'visualizacoes' => 'integer'
    ];

    protected $dates = [
        'data_publicacao',
        'deleted_at'
    ];

    // Relacionamentos
    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function vereadorAutor()
    {
        return $this->belongsTo(Vereador::class, 'autor_id');
    }

    // Scopes
    public function scopePublicadas($query)
    {
        return $query->where('status', 'publicada')
                    ->where('data_publicacao', '<=', now());
    }

    public function scopeRascunhos($query)
    {
        return $query->where('status', 'rascunho');
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeRecentes($query, $limit = 10)
    {
        return $query->orderBy('data_publicacao', 'desc')->limit($limit);
    }

    public function scopeMaisLidas($query, $limit = 10)
    {
        return $query->orderBy('visualizacoes', 'desc')->limit($limit);
    }

    public function scopeBuscar($query, $termo)
    {
        return $query->where(function ($q) use ($termo) {
            $q->where('titulo', 'like', "%{$termo}%")
              ->orWhere('resumo', 'like', "%{$termo}%")
              ->orWhere('conteudo', 'like', "%{$termo}%")
              ->orWhere('tags', 'like', "%{$termo}%");
        });
    }

    // Accessors
    protected function imagemDestaqueUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->imagem_destaque 
                ? asset('storage/' . $this->imagem_destaque) 
                : asset('images/noticia-placeholder.jpg'),
        );
    }

    protected function resumoLimitado(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->resumo, 150),
        );
    }

    protected function tempoLeitura(): Attribute
    {
        return Attribute::make(
            get: fn () => ceil(str_word_count(strip_tags($this->conteudo)) / 200), // 200 palavras por minuto
        );
    }

    protected function dataPublicacaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_publicacao?->format('d/m/Y H:i'),
        );
    }

    protected function dataPublicacaoHumana(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_publicacao?->diffForHumans(),
        );
    }

    // Mutators
    protected function titulo(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => [
                'titulo' => $value,
                'slug' => $this->slug ?: Str::slug($value)
            ],
        );
    }

    // Métodos auxiliares
    public function incrementarVisualizacoes()
    {
        $this->increment('visualizacoes');
    }

    public function isPublicada()
    {
        return $this->status === 'publicada' && $this->data_publicacao <= now();
    }

    public function isRascunho()
    {
        return $this->status === 'rascunho';
    }

    public function isDestaque()
    {
        return $this->destaque;
    }

    public function getUrlCompleta()
    {
        return route('noticias.show', $this->slug);
    }

    public function getGaleriaImagensUrls()
    {
        if (!$this->galeria_imagens) return [];
        
        return collect($this->galeria_imagens)->map(function ($imagem) {
            return asset('storage/' . $imagem);
        })->toArray();
    }

    public function getTagsFormatadas()
    {
        if (!$this->tags) return '';
        
        return collect($this->tags)->implode(', ');
    }

    // Validações customizadas
    public static function rules($id = null)
    {
        return [
            'titulo' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:noticias,slug,' . $id,
            'resumo' => 'required|string|max:500',
            'conteudo' => 'required|string',
            'imagem_destaque' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'galeria_imagens.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'autor_id' => 'required|exists:users,id',
            'status' => 'required|in:rascunho,publicada,arquivada',
            'destaque' => 'boolean',
            'categoria' => 'required|in:geral,legislativo,eventos,comunicados,transparencia',
            'data_publicacao' => 'required|date',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ];
    }

    public static function messages()
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'slug.unique' => 'Este slug já está sendo usado por outra notícia.',
            'resumo.required' => 'O resumo é obrigatório.',
            'resumo.max' => 'O resumo não pode ter mais de 500 caracteres.',
            'conteudo.required' => 'O conteúdo é obrigatório.',
            'autor_id.required' => 'O autor é obrigatório.',
            'autor_id.exists' => 'O autor selecionado não existe.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: rascunho, publicada ou arquivada.',
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.in' => 'A categoria deve ser: geral, legislativo, eventos, comunicados ou transparência.',
            'data_publicacao.required' => 'A data de publicação é obrigatória.',
            'data_publicacao.date' => 'A data de publicação deve ser uma data válida.',
            'meta_description.max' => 'A meta descrição não pode ter mais de 160 caracteres.',
            'meta_keywords.max' => 'As meta palavras-chave não podem ter mais de 255 caracteres.',
            'imagem_destaque.image' => 'A imagem de destaque deve ser um arquivo de imagem.',
            'imagem_destaque.mimes' => 'A imagem de destaque deve ser do tipo: jpeg, png, jpg ou webp.',
            'imagem_destaque.max' => 'A imagem de destaque não pode ser maior que 2MB.',
            'galeria_imagens.*.image' => 'Todos os arquivos da galeria devem ser imagens.',
            'galeria_imagens.*.mimes' => 'As imagens da galeria devem ser do tipo: jpeg, png, jpg ou webp.',
            'galeria_imagens.*.max' => 'As imagens da galeria não podem ser maiores que 2MB.',
            'tags.*.max' => 'Cada tag não pode ter mais de 50 caracteres.'
        ];
    }

    // Métodos de busca
    public static function search($query)
    {
        return self::where('status', 'publicada')
            ->where(function ($q) use ($query) {
                $q->where('titulo', 'LIKE', "%{$query}%")
                  ->orWhere('resumo', 'LIKE', "%{$query}%")
                  ->orWhere('conteudo', 'LIKE', "%{$query}%")
                  ->orWhere('categoria', 'LIKE', "%{$query}%")
                  ->orWhere('meta_keywords', 'LIKE', "%{$query}%");
            })
            ->orderBy('data_publicacao', 'desc');
    }

    public function getSearchableContent()
    {
        return [
            'titulo' => $this->titulo,
            'resumo' => $this->resumo,
            'conteudo' => strip_tags($this->conteudo),
            'categoria' => $this->categoria,
            'tags' => is_array($this->tags) ? implode(' ', $this->tags) : '',
        ];
    }

    public function getSearchUrl()
    {
        return route('noticias.show', $this->slug);
    }

    public function getSearchType()
    {
        return 'Notícia';
    }

    public function getSearchDate()
    {
        return $this->data_publicacao;
    }

    // Boot method para auto-gerar slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($noticia) {
            if (!$noticia->slug) {
                $noticia->slug = Str::slug($noticia->titulo);
            }
        });

        static::updating(function ($noticia) {
            if ($noticia->isDirty('titulo') && !$noticia->isDirty('slug')) {
                $noticia->slug = Str::slug($noticia->titulo);
            }
        });
    }
}
