@extends('layouts.admin')

@section('title', 'Editar Categoria de Mídia')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">
        <i class="fas fa-edit me-1"></i> Editar Categoria de Mídia
    </h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.media-categories.index') }}">Categorias de Mídia</a></li>
        <li class="breadcrumb-item active">Editar {{ $mediaCategory->name }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Formulário de Edição
        </div>
        <div class="card-body">
            <form action="{{ route('admin.media-categories.update', $mediaCategory) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $mediaCategory->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nome da categoria que será exibido para os usuários.</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $mediaCategory->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Identificador único para a categoria. Se não for fornecido, será gerado automaticamente a partir do nome.</div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="icon" class="form-label">Ícone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i id="iconPreview" class="fas {{ $mediaCategory->icon ?: 'fa-folder' }}"></i></span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" name="icon" value="{{ old('icon', $mediaCategory->icon) }}">
                            </div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Ícone FontAwesome para a categoria (ex: fa-image, fa-file-pdf, etc).</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="order" class="form-label">Ordem</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $mediaCategory->order) }}">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Ordem de exibição da categoria.</div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-group">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $mediaCategory->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Descrição detalhada da categoria.</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1" 
                               {{ old('active', $mediaCategory->active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Categoria Ativa</label>
                    </div>
                    <div class="form-text">Desative para ocultar esta categoria temporariamente.</div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.media-categories.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Atualizar o preview do ícone quando o campo for alterado
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('iconPreview');
        
        function updateIconPreview() {
            // Remover todas as classes fa-*
            iconPreview.className = '';
            // Adicionar a classe fas e o valor do input
            iconPreview.classList.add('fas');
            if (iconInput.value) {
                iconPreview.classList.add(iconInput.value);
            } else {
                iconPreview.classList.add('fa-folder');
            }
        }
        
        // Inicializar o preview
        updateIconPreview();
        
        // Atualizar o preview quando o campo for alterado
        iconInput.addEventListener('input', updateIconPreview);
    });
</script>
@endsection