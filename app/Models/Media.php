<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Illuminate\Support\Facades\Storage;

class Media extends BaseMedia
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'original_name',
        'mime_type',
        'size',
        'path',
        'alt_text',
        'title',
        'description',
        'category_id',
        'uploaded_by',
        'model_type',
        'model_id',
        'uuid',
        'name',
        'disk',
        'conversions_disk',
        'manipulations',
        'custom_properties',
        'generated_conversions',
        'order_column'
    ];

    protected $casts = [
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'manipulations' => 'array',
        'custom_properties' => 'array',
        'generated_conversions' => 'array',
    ];

    /**
     * Atributos adicionados automaticamente ao array/JSON
     */
    protected $appends = [
        'file_name',
        'url',
        'public_url',
        'is_image',
        'is_video',
        'is_document',
        'formatted_size',
        'icon',
    ];

    /**
     * Garantir que o ID seja sempre incluído na serialização JSON
     */
    protected $visible = [
        'id',
        'file_name',
        'original_name',
        'mime_type',
        'size',
        'path',
        'alt_text',
        'title',
        'description',
        'category_id',
        'uploaded_by',
        'created_at',
        'updated_at',
        'name',
        'custom_properties',
        'url',
        'public_url',
        'is_image',
        'is_video',
        'is_document',
        'formatted_size',
        'icon',
        'category',
    ];

    /**
     * Relacionamento com o usuário que fez o upload
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    
    /**
     * Relacionamento com a categoria
     */
    public function mediaCategory()
    {
        return $this->belongsTo(MediaCategory::class, 'category_id');
    }
    
    /**
     * Acessor para obter a categoria (compatibilidade)
     */
    public function getCategoryAttribute()
    {
        // Primeiro tenta obter da relação com MediaCategory
        if ($this->mediaCategory) {
            return $this->mediaCategory->slug;
        }
        
        // Depois tenta obter do atributo category (para compatibilidade com registros antigos)
        if (!empty($this->attributes['category'])) {
            return $this->attributes['category'];
        }
        
        // Tenta obter do collection_name (para compatibilidade com registros antigos)
        if (!empty($this->attributes['collection_name'])) {
            return $this->attributes['collection_name'];
        }
        
        // Valor padrão
        return 'outros';
    }

    /**
     * Retorna a URL completa do arquivo
     */
    public function getUrlAttribute()
    {
        // Cache do resultado para evitar recálculos
        if (isset($this->attributes['_cached_url'])) {
            return $this->attributes['_cached_url'];
        }

        $url = null;

        // Preferir a rota de serve quando houver file_name
        if (!empty($this->file_name)) {
            $url = route('media.serve', ['filename' => $this->file_name]);
        }
        // Fallback seguro para URL pública via Storage quando houver caminho
        elseif (!empty($this->path)) {
            $url = Storage::disk($this->disk ?? 'public')->url($this->path);
        }
        // Fallback adicional para registros do Spatie sem coluna 'path'
        elseif (method_exists($this, 'getFullUrl')) {
            try {
                $url = $this->getFullUrl();
            } catch (\Throwable $e) {
                // Ignorar e continuar retornando null
            }
        }

        // Cache do resultado
        $this->attributes['_cached_url'] = $url;
        return $url;
    }

    /**
     * Retorna a URL pública do arquivo
     */
    public function getPublicUrlAttribute()
    {
        // Cache do resultado para evitar recálculos
        if (isset($this->attributes['_cached_public_url'])) {
            return $this->attributes['_cached_public_url'];
        }

        $url = null;

        if (!empty($this->path)) {
            $url = $this->getAutoUrl($this->path);
        }
        // Fallback: tentar montar a partir de collection_name e file_name
        elseif (!empty($this->file_name) && !empty($this->collection_name)) {
            $path = "media/{$this->collection_name}/{$this->file_name}";
            $url = $this->getAutoUrl($path);
        }
        // Fallback final para registros do Spatie: usar URL completa padrão
        elseif (method_exists($this, 'getFullUrl')) {
            try {
                $url = $this->getFullUrl();
            } catch (\Throwable $e) {
                // Ignorar e continuar retornando null
            }
        }

        // Cache do resultado
        $this->attributes['_cached_public_url'] = $url;
        return $url;
    }

    /**
     * Gera URL automática detectando o host atual
     */
    private function getAutoUrl($path)
    {
        $appUrl = env('APP_URL');
        
        // Se APP_URL for 'auto' ou vazio, detecta automaticamente
        if ($appUrl === 'auto' || empty($appUrl)) {
            // Detecta automaticamente o protocolo e host
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $baseUrl = $protocol . '://' . $host;
        } else {
            $baseUrl = $appUrl;
        }
        
        return $baseUrl . '/storage/' . $path;
    }

    /**
     * Título amigável da mídia, com fallback para campos existentes
     */
    public function getTitleAttribute()
    {
        // Usar o atributo direto se existir
        if (!empty($this->attributes['title'])) {
            return $this->attributes['title'];
        }

        // Fallback para custom_properties do Spatie
        if (!empty($this->custom_properties['title'])) {
            return $this->custom_properties['title'];
        }

        // Fallback para nome do registro
        if (!empty($this->attributes['name'])) {
            return $this->attributes['name'];
        }

        // Fallback para nome original ou nome do arquivo
        if (!empty($this->attributes['original_name'])) {
            return $this->attributes['original_name'];
        }
        return $this->attributes['file_name'] ?? null;
    }

    /**
     * Texto alternativo da mídia, com fallback para custom_properties
     */
    public function getAltTextAttribute()
    {
        if (!empty($this->attributes['alt_text'])) {
            return $this->attributes['alt_text'];
        }
        return $this->custom_properties['alt_text'] ?? null;
    }

    /**
     * Descrição da mídia, com fallback para custom_properties
     */
    public function getDescriptionAttribute()
    {
        if (!empty($this->attributes['description'])) {
            return $this->attributes['description'];
        }
        return $this->custom_properties['description'] ?? null;
    }

    // Método getCategoryAttribute já definido anteriormente

    /**
     * Nome original do arquivo, com fallbacks
     */
    public function getOriginalNameAttribute()
    {
        if (!empty($this->attributes['original_name'])) {
            return $this->attributes['original_name'];
        }
        if (!empty($this->attributes['name'])) {
            return $this->attributes['name'];
        }
        return $this->attributes['file_name'] ?? null;
    }

    /**
     * Expõe file_name com compatibilidade para coluna legacy "filename" e fallback via path
     */
    public function getFileNameAttribute()
    {
        // Valor nativo do Spatie, se existir
        if (!empty($this->attributes['file_name'])) {
            return $this->attributes['file_name'];
        }

        // Compatibilidade com migração que usa "filename"
        if (!empty($this->attributes['filename'])) {
            return $this->attributes['filename'];
        }

        // Derivar do caminho, se disponível
        if (!empty($this->attributes['path'])) {
            return basename($this->attributes['path']);
        }

        return null;
    }

    /**
     * Verifica se o arquivo é uma imagem
     */
    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Verifica se o arquivo é um vídeo
     */
    public function getIsVideoAttribute()
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    /**
     * Verifica se o arquivo é um documento
     */
    public function getIsDocumentAttribute()
    {
        $documentTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        return in_array($this->mime_type, $documentTypes);
    }

    /**
     * Retorna o tamanho formatado
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Retorna o ícone baseado no tipo de arquivo
     */
    public function getIconAttribute()
    {
        if ($this->is_image) {
            return 'fa-image';
        } elseif ($this->is_video) {
            return 'fa-video';
        } elseif ($this->is_document) {
            return 'fa-file-pdf';
        } else {
            return 'fa-file';
        }
    }

    /**
     * Scope para filtrar por categoria
     */
    public function scopeByCategory($query, $category)
    {
        // Se for um slug (string), converter para ID
        if (!is_numeric($category)) {
            $categoryId = self::getCategoryIdBySlug($category);
            if ($categoryId) {
                return $query->where('category_id', $categoryId);
            }
            // Se não encontrar a categoria pelo slug, retorna query vazia
            return $query->whereRaw('1 = 0');
        }
        
        // Se for numérico, usar diretamente como ID
        return $query->where('category_id', $category);
    }

    /**
     * Scope para filtrar por tipo de arquivo
     */
    public function scopeByType($query, $type)
    {
        switch ($type) {
            case 'images':
                return $query->where('mime_type', 'like', 'image/%');
            case 'videos':
                return $query->where('mime_type', 'like', 'video/%');
            case 'documents':
                return $query->whereIn('mime_type', [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ]);
            default:
                return $query;
        }
    }

    /**
     * Deleta o arquivo físico e o registro
     */
    public function deleteFile()
    {
        if (Storage::exists($this->path)) {
            Storage::delete($this->path);
        }
        return $this->delete();
    }

    /**
     * Categorias disponíveis
     */
    public static function getCategories()
    {
        // Sempre usar as categorias do banco
        $dbCategories = \App\Models\MediaCategory::active()->ordered()->get();
        
        if ($dbCategories->isNotEmpty()) {
            return $dbCategories->pluck('name', 'slug')->toArray();
        }
        
        // Fallback apenas se não houver categorias no banco
        return ['outros' => 'Outros'];
    }
    
    /**
     * Obter o ID da categoria a partir do slug
     */
    public static function getCategoryIdBySlug($slug)
    {
        $category = \App\Models\MediaCategory::where('slug', $slug)->first();
        return $category ? $category->id : null;
    }
    
    // Método mediaCategory já definido anteriormente

    /**
     * Define as conversões de mídia para imagens
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        // Thumbnail pequeno (150x150)
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('images')
            ->nonQueued();

        // Thumbnail médio (300x300)
        $this->addMediaConversion('medium')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('images')
            ->nonQueued();

        // Preview grande (800x600)
        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->optimize()
            ->performOnCollections('images')
            ->nonQueued();

        // Versão otimizada para web
        $this->addMediaConversion('webp')
            ->format(Manipulations::FORMAT_WEBP)
            ->quality(85)
            ->performOnCollections('images')
            ->nonQueued();
    }
}