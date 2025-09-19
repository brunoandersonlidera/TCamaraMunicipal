@extends('layouts.admin')

@section('page-title', 'Editar Notícia')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.noticias.index') }}">Notícias</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Editar Notícia</h1>
    <div>
        <a href="{{ route('admin.noticias.show', $noticia) }}" class="btn btn-outline-info me-2">
            <i class="fas fa-eye"></i> Visualizar
        </a>
        <a href="{{ route('admin.noticias.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<form action="{{ route('admin.noticias.update', $noticia) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <!-- Dados Básicos -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Dados Básicos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                               id="titulo" name="titulo" value="{{ old('titulo', $noticia->titulo) }}" required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="resumo" class="form-label">Resumo</label>
                        <textarea class="form-control @error('resumo') is-invalid @enderror" 
                                  id="resumo" name="resumo" rows="3" 
                                  placeholder="Breve descrição da notícia (máx. 500 caracteres)">{{ old('resumo', $noticia->resumo) }}</textarea>
                        @error('resumo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Máximo 500 caracteres</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="conteudo" class="form-label">Conteúdo <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('conteudo') is-invalid @enderror" 
                                  id="conteudo" name="conteudo" rows="15" required>{{ old('conteudo', $noticia->conteudo) }}</textarea>
                        @error('conteudo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Imagens -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-images"></i> Imagens
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="imagem_destaque" class="form-label">Imagem de Destaque</label>
                        
                        @if($noticia->imagem_destaque)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $noticia->imagem_destaque) }}" 
                                     alt="Imagem atual" class="preview-image">
                                <div class="form-text">Imagem atual</div>
                            </div>
                        @endif
                        
                        <input type="file" class="form-control @error('imagem_destaque') is-invalid @enderror" 
                               id="imagem_destaque" name="imagem_destaque" accept="image/*">
                        @error('imagem_destaque')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB
                            @if($noticia->imagem_destaque)
                                <br>Deixe em branco para manter a imagem atual
                            @endif
                        </div>
                        <div id="preview-destaque" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="galeria_imagens" class="form-label">Galeria de Imagens</label>
                        
                        @if($noticia->galeria_imagens && count($noticia->galeria_imagens) > 0)
                            <div class="mb-2">
                                <div class="row">
                                    @foreach($noticia->galeria_imagens as $imagem)
                                        <div class="col-md-3 mb-2">
                                            <img src="{{ asset('storage/' . $imagem) }}" 
                                                 alt="Galeria" class="preview-image w-100">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-text">Galeria atual</div>
                            </div>
                        @endif
                        
                        <input type="file" class="form-control @error('galeria_imagens.*') is-invalid @enderror" 
                               id="galeria_imagens" name="galeria_imagens[]" accept="image/*" multiple>
                        @error('galeria_imagens.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Selecione múltiplas imagens para a galeria
                            @if($noticia->galeria_imagens && count($noticia->galeria_imagens) > 0)
                                <br>Deixe em branco para manter as imagens atuais
                            @endif
                        </div>
                        <div id="preview-galeria" class="mt-2 row"></div>
                    </div>
                </div>
            </div>
            
            <!-- SEO -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-search"></i> SEO
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                  id="meta_description" name="meta_description" rows="2" 
                                  placeholder="Descrição para mecanismos de busca">{{ old('meta_description', $noticia->meta_description) }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Máximo 160 caracteres</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                               id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $noticia->meta_keywords) }}" 
                               placeholder="palavra1, palavra2, palavra3">
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Palavras-chave separadas por vírgula</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publicação -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar"></i> Publicação
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="data_publicacao" class="form-label">Data de Publicação <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('data_publicacao') is-invalid @enderror" 
                               id="data_publicacao" name="data_publicacao" 
                               value="{{ old('data_publicacao', $noticia->data_publicacao->format('Y-m-d\TH:i')) }}" required>
                        @error('data_publicacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="publicado" name="publicado" 
                               {{ old('publicado', $noticia->publicado) ? 'checked' : '' }}>
                        <label class="form-check-label" for="publicado">
                            Publicar imediatamente
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="destaque" name="destaque" 
                               {{ old('destaque', $noticia->destaque) ? 'checked' : '' }}>
                        <label class="form-check-label" for="destaque">
                            Marcar como destaque
                        </label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="permite_comentarios" name="permite_comentarios" 
                               {{ old('permite_comentarios', $noticia->permite_comentarios) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permite_comentarios">
                            Permitir comentários
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Categorização -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tags"></i> Categorização
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <input type="text" class="form-control @error('categoria') is-invalid @enderror" 
                               id="categoria" name="categoria" value="{{ old('categoria', $noticia->categoria) }}" 
                               placeholder="Ex: Política, Saúde, Educação">
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <div id="tags-container">
                            @if(old('tags', $noticia->tags))
                                @foreach(old('tags', $noticia->tags) as $tag)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="tags[]" value="{{ $tag }}">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="tags[]" placeholder="Digite uma tag">
                                <button type="button" class="btn btn-outline-secondary" onclick="addTag()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-text">Pressione Enter ou clique no + para adicionar tags</div>
                    </div>
                </div>
            </div>
            
            <!-- Informações -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informações
                    </h5>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        <strong>Criado em:</strong> {{ $noticia->created_at->format('d/m/Y H:i') }}<br>
                        <strong>Última atualização:</strong> {{ $noticia->updated_at->format('d/m/Y H:i') }}<br>
                        <strong>Autor:</strong> {{ $noticia->autor->name ?? 'N/A' }}<br>
                        <strong>Slug:</strong> {{ $noticia->slug }}
                    </small>
                </div>
            </div>
            
            <!-- Ações -->
            <div class="admin-card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar Notícia
                        </button>
                        <button type="submit" name="action" value="save_and_continue" class="btn btn-outline-primary">
                            <i class="fas fa-save"></i> Salvar e Continuar Editando
                        </button>
                        <a href="{{ route('admin.noticias.show', $noticia) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('admin.noticias.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
.preview-image {
    max-width: 200px;
    max-height: 150px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #dee2e6;
}

.tag-item {
    display: inline-block;
    background-color: #e9ecef;
    padding: 0.25rem 0.5rem;
    margin: 0.125rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.tag-remove {
    margin-left: 0.5rem;
    color: #6c757d;
    cursor: pointer;
}

.tag-remove:hover {
    color: #dc3545;
}
</style>
@endpush

@push('scripts')
<script>
// Preview da imagem de destaque
document.getElementById('imagem_destaque').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview-destaque');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

// Preview da galeria
document.getElementById('galeria_imagens').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.getElementById('preview-galeria');
    preview.innerHTML = '';
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-md-4 mb-2';
            col.innerHTML = `<img src="${e.target.result}" class="preview-image w-100" alt="Preview ${i+1}">`;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    }
});

// Gerenciamento de tags
function addTag() {
    const container = document.getElementById('tags-container');
    const newTag = document.createElement('div');
    newTag.className = 'input-group mb-2';
    newTag.innerHTML = `
        <input type="text" class="form-control" name="tags[]" placeholder="Digite uma tag">
        <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(newTag);
}

function removeTag(button) {
    button.closest('.input-group').remove();
}

// Adicionar tag com Enter
document.addEventListener('keydown', function(e) {
    if (e.target.name === 'tags[]' && e.key === 'Enter') {
        e.preventDefault();
        if (e.target.value.trim()) {
            addTag();
            e.target.focus();
        }
    }
});

// Contador de caracteres
document.getElementById('resumo').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    let helpText = this.nextElementSibling;
    if (helpText && helpText.classList.contains('form-text')) {
        helpText.textContent = `${remaining} caracteres restantes`;
        helpText.className = remaining < 0 ? 'form-text text-danger' : 'form-text';
    }
});

document.getElementById('meta_description').addEventListener('input', function() {
    const maxLength = 160;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    let helpText = this.nextElementSibling;
    if (helpText && helpText.classList.contains('form-text')) {
        helpText.textContent = `${remaining} caracteres restantes`;
        helpText.className = remaining < 0 ? 'form-text text-danger' : 'form-text';
    }
});
</script>
@endpush