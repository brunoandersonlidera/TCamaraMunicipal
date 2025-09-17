<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documentos';

    protected $fillable = [
        'titulo',
        'descricao',
        'tipo',
        'categoria',
        'arquivo_nome',
        'arquivo_caminho',
        'arquivo_tamanho',
        'arquivo_tipo',
        'arquivo_hash',
        'publico',
        'data_documento',
        'data_publicacao',
        'numero_documento',
        'ano_documento',
        'autor_id',
        'projeto_lei_id',
        'sessao_id',
        'tags',
        'metadata',
        'downloads',
        'visualizacoes',
        'slug'
    ];

    protected $casts = [
        'data_documento' => 'date',
        'data_publicacao' => 'date',
        'publico' => 'boolean',
        'tags' => 'array',
        'metadata' => 'array',
        'downloads' => 'integer',
        'visualizacoes' => 'integer',
        'arquivo_tamanho' => 'integer'
    ];

    protected $dates = [
        'data_documento',
        'data_publicacao',
        'deleted_at'
    ];

    // Relacionamentos
    public function autor()
    {
        return $this->belongsTo(Vereador::class, 'autor_id');
    }

    public function projetoLei()
    {
        return $this->belongsTo(ProjetoLei::class, 'projeto_lei_id');
    }

    public function sessao()
    {
        return $this->belongsTo(Sessao::class, 'sessao_id');
    }

    // Scopes
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    public function scopePrivados($query)
    {
        return $query->where('publico', false);
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeAno($query, $ano)
    {
        return $query->where('ano_documento', $ano);
    }

    public function scopeAutor($query, $autorId)
    {
        return $query->where('autor_id', $autorId);
    }

    public function scopeProjetoLei($query, $projetoId)
    {
        return $query->where('projeto_lei_id', $projetoId);
    }

    public function scopeSessao($query, $sessaoId)
    {
        return $query->where('sessao_id', $sessaoId);
    }

    public function scopeComTags($query, $tags)
    {
        if (is_string($tags)) {
            $tags = [$tags];
        }
        
        return $query->where(function ($q) use ($tags) {
            foreach ($tags as $tag) {
                $q->orWhereJsonContains('tags', $tag);
            }
        });
    }

    public function scopeRecentes($query, $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    public function scopeMaisVisualizados($query, $limite = 10)
    {
        return $query->orderByDesc('visualizacoes')->limit($limite);
    }

    public function scopeMaisBaixados($query, $limite = 10)
    {
        return $query->orderByDesc('downloads')->limit($limite);
    }

    // Accessors
    protected function numeroCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->numero_documento 
                ? sprintf('%03d/%d', $this->numero_documento, $this->ano_documento)
                : null,
        );
    }

    protected function dataDocumentoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_documento?->format('d/m/Y'),
        );
    }

    protected function dataPublicacaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_publicacao?->format('d/m/Y'),
        );
    }

    protected function tipoFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->tipo) {
                'ata' => 'Ata',
                'lei' => 'Lei',
                'decreto' => 'Decreto',
                'resolucao' => 'Resolução',
                'portaria' => 'Portaria',
                'oficio' => 'Ofício',
                'requerimento' => 'Requerimento',
                'indicacao' => 'Indicação',
                'mocao' => 'Moção',
                'emenda' => 'Emenda',
                'substitutivo' => 'Substitutivo',
                'parecer' => 'Parecer',
                'relatorio' => 'Relatório',
                'contrato' => 'Contrato',
                'convenio' => 'Convênio',
                'edital' => 'Edital',
                'outros' => 'Outros',
                default => 'Indefinido'
            },
        );
    }

    protected function categoriaFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->categoria) {
                'legislativo' => 'Legislativo',
                'administrativo' => 'Administrativo',
                'juridico' => 'Jurídico',
                'financeiro' => 'Financeiro',
                'transparencia' => 'Transparência',
                'licitacao' => 'Licitação',
                'recursos_humanos' => 'Recursos Humanos',
                'protocolo' => 'Protocolo',
                'outros' => 'Outros',
                default => 'Indefinido'
            },
        );
    }

    protected function tamanhoFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->arquivo_tamanho 
                ? $this->formatarTamanhoArquivo($this->arquivo_tamanho)
                : null,
        );
    }

    protected function extensaoArquivo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->arquivo_nome 
                ? strtoupper(pathinfo($this->arquivo_nome, PATHINFO_EXTENSION))
                : null,
        );
    }

    protected function urlDownload(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->arquivo_caminho 
                ? route('documentos.download', $this->id)
                : null,
        );
    }

    protected function urlVisualizacao(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->arquivo_caminho 
                ? route('documentos.visualizar', $this->id)
                : null,
        );
    }

    // Mutators
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?: Str::slug($this->titulo),
        );
    }

    protected function tags(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => is_string($value) 
                ? array_map('trim', explode(',', $value))
                : $value,
        );
    }

    // Métodos auxiliares
    public function isPublico()
    {
        return $this->publico === true;
    }

    public function isPrivado()
    {
        return $this->publico === false;
    }

    public function temArquivo()
    {
        return !empty($this->arquivo_caminho) && Storage::exists($this->arquivo_caminho);
    }

    public function isPdf()
    {
        return $this->arquivo_tipo === 'application/pdf' || 
               strtolower($this->extensao_arquivo) === 'pdf';
    }

    public function isImagem()
    {
        return str_starts_with($this->arquivo_tipo, 'image/');
    }

    public function isDocumento()
    {
        $extensoesDocumento = ['doc', 'docx', 'odt', 'rtf'];
        return in_array(strtolower($this->extensao_arquivo), $extensoesDocumento);
    }

    public function isPlanilha()
    {
        $extensoesPlanilha = ['xls', 'xlsx', 'ods', 'csv'];
        return in_array(strtolower($this->extensao_arquivo), $extensoesPlanilha);
    }

    public function podeSerVisualizado()
    {
        return $this->isPdf() || $this->isImagem();
    }

    public function incrementarVisualizacoes()
    {
        $this->increment('visualizacoes');
    }

    public function incrementarDownloads()
    {
        $this->increment('downloads');
    }

    public function adicionarTag($tag)
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->update(['tags' => $tags]);
        }
    }

    public function removerTag($tag)
    {
        $tags = collect($this->tags)->reject(fn($t) => $t === $tag)->values()->toArray();
        $this->update(['tags' => $tags]);
    }

    public function adicionarMetadata($chave, $valor)
    {
        $metadata = $this->metadata ?? [];
        $metadata[$chave] = $valor;
        $this->update(['metadata' => $metadata]);
    }

    public function obterMetadata($chave, $default = null)
    {
        return data_get($this->metadata, $chave, $default);
    }

    public function gerarHash()
    {
        if ($this->temArquivo()) {
            $conteudo = Storage::get($this->arquivo_caminho);
            return hash('sha256', $conteudo);
        }
        return null;
    }

    public function verificarIntegridade()
    {
        if (!$this->arquivo_hash || !$this->temArquivo()) {
            return false;
        }
        
        return $this->arquivo_hash === $this->gerarHash();
    }

    public function gerarNumeroSequencial($ano = null)
    {
        $ano = $ano ?: now()->year;
        $ultimoNumero = static::where('ano_documento', $ano)
                             ->where('tipo', $this->tipo)
                             ->max('numero_documento') ?? 0;
        return $ultimoNumero + 1;
    }

    private function formatarTamanhoArquivo($bytes)
    {
        $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($unidades) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $unidades[$pow];
    }

    public function duplicar($novoTitulo = null)
    {
        $documento = $this->replicate();
        $documento->titulo = $novoTitulo ?: $this->titulo . ' (Cópia)';
        $documento->slug = null; // Será gerado automaticamente
        $documento->downloads = 0;
        $documento->visualizacoes = 0;
        $documento->save();
        
        return $documento;
    }

    // Boot method para auto-gerar slug e número
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($documento) {
            if (empty($documento->slug)) {
                $documento->slug = Str::slug($documento->titulo);
            }
            
            if (empty($documento->numero_documento) && $documento->tipo) {
                $documento->numero_documento = $documento->gerarNumeroSequencial($documento->ano_documento);
            }
            
            if (empty($documento->ano_documento)) {
                $documento->ano_documento = now()->year;
            }
        });

        static::updating(function ($documento) {
            if ($documento->isDirty('titulo') && empty($documento->slug)) {
                $documento->slug = Str::slug($documento->titulo);
            }
        });

        static::deleting(function ($documento) {
            // Remove arquivo físico quando documento é excluído
            if ($documento->temArquivo()) {
                Storage::delete($documento->arquivo_caminho);
            }
        });
    }

    // Validações customizadas
    public static function rules($id = null)
    {
        return [
            'titulo' => 'required|string|min:3|max:255',
            'descricao' => 'nullable|string|max:1000',
            'tipo' => 'required|in:ata,lei,decreto,resolucao,portaria,oficio,requerimento,indicacao,mocao,emenda,substitutivo,parecer,relatorio,contrato,convenio,edital,outros',
            'categoria' => 'required|in:legislativo,administrativo,juridico,financeiro,transparencia,licitacao,recursos_humanos,protocolo,outros',
            'arquivo_nome' => 'nullable|string|max:255',
            'arquivo_caminho' => 'nullable|string|max:500',
            'arquivo_tamanho' => 'nullable|integer|min:0',
            'arquivo_tipo' => 'nullable|string|max:100',
            'publico' => 'boolean',
            'data_documento' => 'nullable|date',
            'data_publicacao' => 'nullable|date',
            'numero_documento' => 'nullable|integer|min:1',
            'ano_documento' => 'nullable|integer|min:1900|max:' . (now()->year + 10),
            'autor_id' => 'nullable|exists:vereadores,id',
            'projeto_lei_id' => 'nullable|exists:projetos_lei,id',
            'sessao_id' => 'nullable|exists:sessoes,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'slug' => 'nullable|string|max:255|unique:documentos,slug,' . $id
        ];
    }

    public static function messages()
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.min' => 'O título deve ter pelo menos 3 caracteres.',
            'titulo.max' => 'O título não pode exceder 255 caracteres.',
            'descricao.max' => 'A descrição não pode exceder 1000 caracteres.',
            'tipo.required' => 'O tipo do documento é obrigatório.',
            'tipo.in' => 'O tipo deve ser: ata, lei, decreto, resolução, portaria, ofício, requerimento, indicação, moção, emenda, substitutivo, parecer, relatório, contrato, convênio, edital ou outros.',
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.in' => 'A categoria deve ser: legislativo, administrativo, jurídico, financeiro, transparência, licitação, recursos humanos, protocolo ou outros.',
            'arquivo_nome.max' => 'O nome do arquivo não pode exceder 255 caracteres.',
            'arquivo_caminho.max' => 'O caminho do arquivo não pode exceder 500 caracteres.',
            'arquivo_tamanho.integer' => 'O tamanho do arquivo deve ser um número inteiro.',
            'arquivo_tamanho.min' => 'O tamanho do arquivo deve ser maior ou igual a zero.',
            'arquivo_tipo.max' => 'O tipo do arquivo não pode exceder 100 caracteres.',
            'data_documento.date' => 'A data do documento deve ser uma data válida.',
            'data_publicacao.date' => 'A data de publicação deve ser uma data válida.',
            'numero_documento.integer' => 'O número do documento deve ser um valor inteiro.',
            'numero_documento.min' => 'O número do documento deve ser maior que zero.',
            'ano_documento.integer' => 'O ano deve ser um valor inteiro.',
            'ano_documento.min' => 'O ano deve ser maior que 1900.',
            'ano_documento.max' => 'O ano não pode ser superior a ' . (now()->year + 10) . '.',
            'autor_id.exists' => 'O autor selecionado não existe.',
            'projeto_lei_id.exists' => 'O projeto de lei selecionado não existe.',
            'sessao_id.exists' => 'A sessão selecionada não existe.',
            'tags.array' => 'As tags devem ser um array.',
            'tags.*.string' => 'Cada tag deve ser uma string.',
            'tags.*.max' => 'Cada tag não pode exceder 50 caracteres.',
            'slug.unique' => 'Este slug já está em uso.'
        ];
    }
}
