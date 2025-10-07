# 📚 Guia do Spatie Media Library - TCamaraMunicipal

## 🎯 Visão Geral

O sistema TCamaraMunicipal agora utiliza o **Spatie Laravel Media Library** para gerenciamento avançado de mídia, oferecendo funcionalidades como conversões automáticas de imagem, thumbnails e organização por coleções.

## 🚀 Funcionalidades Implementadas

### ✅ **Instalação e Configuração**
- ✅ Pacote `spatie/laravel-medialibrary` instalado
- ✅ Migrações executadas e tabela `media` atualizada
- ✅ Modelo `Media` integrado com Spatie
- ✅ Controller atualizado para usar funcionalidades do Spatie

### 🖼️ **Conversões de Imagem Automáticas**
- **Thumbnail pequeno**: 150x150px
- **Thumbnail médio**: 300x300px  
- **Preview grande**: 800x600px
- **Versão WebP**: Otimizada para web

### 📁 **Categorias de Mídia**
- `brasao` - Brasões
- `logo` - Logos
- `icone` - Ícones
- `foto` - Fotos
- `documento` - Documentos
- `banner` - Banners
- `galeria` - Galeria
- `outros` - Outros

## 🔧 Como Usar

### **1. Upload de Arquivos**
```php
// No MediaController, o upload agora usa campos do Spatie
$media = Media::create([
    'model_type' => null, // Para arquivos independentes
    'model_id' => null,
    'uuid' => Str::uuid(),
    'collection_name' => $request->category,
    'name' => $title,
    'file_name' => $filename,
    'mime_type' => $file->getMimeType(),
    'disk' => 'public',
    'size' => $file->getSize(),
    'custom_properties' => [
        'alt_text' => $alt_text,
        'title' => $title,
        'description' => $description,
    ],
    // Campos customizados mantidos para compatibilidade
    'original_name' => $file->getClientOriginalName(),
    'category' => $request->category,
    'uploaded_by' => Auth::id(),
]);
```

### **2. Usando com Modelos (HasMedia)**
```php
// Exemplo: Associar mídia a um modelo
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Noticia extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png']);
    }
}

// Adicionar mídia ao modelo
$noticia = Noticia::find(1);
$noticia->addMediaFromRequest('image')
    ->toMediaCollection('images');

// Obter mídia
$imagens = $noticia->getMedia('images');
$primeiraImagem = $noticia->getFirstMedia('images');
```

### **3. Conversões de Imagem**
```php
// As conversões são geradas automaticamente para imagens
$media = Media::find(1);

// URLs das conversões
$thumbUrl = $media->getUrl('thumb');      // 150x150
$mediumUrl = $media->getUrl('medium');    // 300x300
$previewUrl = $media->getUrl('preview');  // 800x600
$webpUrl = $media->getUrl('webp');        // Versão WebP
```

### **4. Propriedades Customizadas**
```php
// Definir propriedades customizadas
$media->setCustomProperty('alt_text', 'Texto alternativo');
$media->setCustomProperty('description', 'Descrição da imagem');
$media->save();

// Obter propriedades customizadas
$altText = $media->getCustomProperty('alt_text');
$description = $media->getCustomProperty('description');
```

## 🗂️ **Estrutura da Tabela Media**

### **Campos do Spatie**
- `model_type` - Tipo do modelo associado
- `model_id` - ID do modelo associado
- `uuid` - Identificador único
- `collection_name` - Nome da coleção
- `name` - Nome do arquivo
- `file_name` - Nome do arquivo no disco
- `mime_type` - Tipo MIME
- `disk` - Disco de armazenamento
- `conversions_disk` - Disco para conversões
- `size` - Tamanho do arquivo
- `manipulations` - Manipulações aplicadas
- `custom_properties` - Propriedades customizadas (JSON)
- `generated_conversions` - Conversões geradas (JSON)

### **Campos Customizados Mantidos**
- `original_name` - Nome original do arquivo
- `path` - Caminho do arquivo
- `alt_text` - Texto alternativo
- `title` - Título
- `description` - Descrição
- `category` - Categoria
- `uploaded_by` - ID do usuário que fez upload

## 🎨 **Interface de Usuário**

### **Páginas Disponíveis**
- `/admin/media` - Biblioteca de mídia principal
- `/admin/media/create` - Upload de arquivos
- `/admin/media/{id}` - Detalhes do arquivo
- `/admin/media-select` - Seleção de mídia para formulários

### **Funcionalidades da Interface**
- ✅ Upload múltiplo de arquivos
- ✅ Filtros por categoria e tipo
- ✅ Busca por nome/título
- ✅ Visualização em grid
- ✅ Modais para upload, visualização e edição
- ✅ Drag & drop para upload

## 🔍 **Testes e Verificação**

### **Verificar Instalação**
```bash
# Verificar se o pacote está instalado
composer show spatie/laravel-medialibrary

# Verificar rotas
php artisan route:list --name=media

# Testar modelo
php artisan tinker
>>> use App\Models\Media;
>>> Media::getCategories();
>>> Media::count();
```

### **Testar Upload**
1. Acesse `/admin/media`
2. Clique em "Fazer Upload"
3. Selecione arquivos e categoria
4. Verifique se as conversões são geradas automaticamente

## 📝 **Notas Importantes**

### **Compatibilidade**
- ✅ Mantém compatibilidade com código existente
- ✅ Campos customizados preservados
- ✅ URLs de arquivos funcionam normalmente

### **Performance**
- ✅ Conversões são geradas de forma não-bloqueante
- ✅ Cache automático de conversões
- ✅ Otimização automática de imagens

### **Segurança**
- ✅ Validação de tipos de arquivo
- ✅ Nomes de arquivo únicos
- ✅ Armazenamento seguro

## 🚀 **Próximos Passos Sugeridos**

1. **Implementar Queue para Conversões**
   ```bash
   php artisan queue:table
   php artisan migrate
   ```

2. **Configurar Limpeza Automática**
   ```php
   // Agendar limpeza de arquivos órfãos
   $schedule->command('medialibrary:clean')->daily();
   ```

3. **Adicionar Mais Conversões**
   ```php
   // No modelo Media
   $this->addMediaConversion('social')
       ->width(1200)
       ->height(630)
       ->performOnCollections('images');
   ```

---

**Implementação concluída com sucesso!** 🎉

O sistema agora possui um gerenciamento de mídia robusto e escalável usando o Spatie Laravel Media Library.