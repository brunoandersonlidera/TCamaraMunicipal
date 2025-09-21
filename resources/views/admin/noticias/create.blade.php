@extends('layouts.admin')

@section('page-title', 'Nova Notícia')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.noticias.index') }}">Notícias</a></li>
        <li class="breadcrumb-item active">Nova Notícia</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Nova Notícia</h1>
    <a href="{{ route('admin.noticias.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
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
                               id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="resumo" class="form-label">Resumo</label>
                        <textarea class="form-control @error('resumo') is-invalid @enderror" 
                                  id="resumo" name="resumo" rows="3" 
                                  placeholder="Breve descrição da notícia (máx. 500 caracteres)">{{ old('resumo') }}</textarea>
                        @error('resumo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Máximo 500 caracteres</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="conteudo" class="form-label">Conteúdo <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('conteudo') is-invalid @enderror" 
                                  id="conteudo" name="conteudo" rows="15" required>{{ old('conteudo') }}</textarea>
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
                        <input type="file" class="form-control @error('imagem_destaque') is-invalid @enderror" 
                               id="imagem_destaque" name="imagem_destaque" accept="image/*">
                        @error('imagem_destaque')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</div>
                        <div id="preview-destaque" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="galeria_imagens" class="form-label">Galeria de Imagens</label>
                        <input type="file" class="form-control @error('galeria_imagens.*') is-invalid @enderror" 
                               id="galeria_imagens" name="galeria_imagens[]" accept="image/*" multiple>
                        @error('galeria_imagens.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Selecione múltiplas imagens para a galeria</div>
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
                                  placeholder="Descrição para mecanismos de busca">{{ old('meta_description') }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Máximo 160 caracteres</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                               id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" 
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
                               value="{{ old('data_publicacao', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('data_publicacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="publicado" name="publicado" 
                               {{ old('publicado') ? 'checked' : '' }}>
                        <label class="form-check-label" for="publicado">
                            Publicar imediatamente
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="destaque" name="destaque" 
                               {{ old('destaque') ? 'checked' : '' }}>
                        <label class="form-check-label" for="destaque">
                            Marcar como destaque
                        </label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="permite_comentarios" name="permite_comentarios" 
                               {{ old('permite_comentarios', true) ? 'checked' : '' }}>
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
                               id="categoria" name="categoria" value="{{ old('categoria') }}" 
                               placeholder="Ex: Política, Saúde, Educação">
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <div id="tags-container">
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
            
            <!-- Ações -->
            <div class="admin-card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Notícia
                        </button>
                        <button type="submit" name="action" value="save_and_continue" class="btn btn-outline-primary">
                            <i class="fas fa-save"></i> Salvar e Continuar Editando
                        </button>
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
<link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/noticias.js') }}"></script>
@endpush