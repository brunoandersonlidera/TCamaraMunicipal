@extends('layouts.admin')

@section('page-title', 'Editar Mídia')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Biblioteca de Mídia</a></li>
        <li class="breadcrumb-item active">Editar: {{ $media->title ?: $media->original_name }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Editar Mídia</h1>
                    <p class="text-muted">Atualize as informações de {{ $media->title ?: $media->original_name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>

            <!-- Formulário de Edição -->
            <form action="{{ route('admin.media.update', $media) }}" method="POST" id="mediaForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-lg-4">
                        <!-- Preview da Mídia -->
                        <div class="admin-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Preview</h5>
                            </div>
                            <div class="card-body text-center">
                                @if($media->is_image)
                                    <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="img-fluid rounded" style="max-height: 300px;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas {{ $media->icon }} fa-5x text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="mt-3">
                                    <h6 class="mb-1">{{ $media->original_name }}</h6>
                                    <small class="text-muted">{{ $media->formatted_size }}</small>
                                </div>
                                
                                <div class="mt-3">
                                    <a href="{{ $media->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i>Abrir Arquivo
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Informações do Arquivo -->
                        <div class="admin-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-5 text-muted">Tipo:</div>
                                    <div class="col-7"><code>{{ $media->mime_type }}</code></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted">Tamanho:</div>
                                    <div class="col-7">{{ $media->formatted_size }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted">Upload:</div>
                                    <div class="col-7">{{ $media->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                @if($media->uploader)
                                <div class="row mb-2">
                                    <div class="col-5 text-muted">Por:</div>
                                    <div class="col-7">{{ $media->uploader->name }}</div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-5 text-muted">URL:</div>
                                    <div class="col-7">
                                        <small class="text-break">{{ $media->url }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <!-- Dados Principais -->
                        <div class="admin-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Dados da Mídia</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">
                                                <i class="fas fa-heading me-1"></i>Título
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" 
                                                   name="title" 
                                                   value="{{ old('title', $media->title) }}" 
                                                   placeholder="Digite o título do arquivo">
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">
                                                <i class="fas fa-folder me-1"></i>Categoria <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                                    id="category_id" 
                                                    name="category_id" 
                                                    required>
                                                <option value="">Selecione uma categoria</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                            {{ old('category_id', $media->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">A categoria determina onde o arquivo será exibido no site.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="alt_text" class="form-label">
                                                <i class="fas fa-eye me-1"></i>Texto Alternativo
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('alt_text') is-invalid @enderror" 
                                                   id="alt_text" 
                                                   name="alt_text" 
                                                   value="{{ old('alt_text', $media->alt_text) }}" 
                                                   placeholder="Descrição para acessibilidade">
                                            @error('alt_text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Usado por leitores de tela para descrever a imagem.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>Descrição
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Descrição detalhada do arquivo">{{ old('description', $media->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="admin-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Salvar Alterações
                                        </button>
                                        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary ms-2">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                            <i class="fas fa-trash me-2"></i>Excluir Arquivo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este arquivo?</p>
                <p class="text-muted mb-0">
                    <strong>{{ $media->title ?: $media->original_name }}</strong><br>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.media.destroy', $media) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.admin-card {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.admin-card .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.25rem;
}

.admin-card .card-body {
    padding: 1.25rem;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.text-break {
    word-break: break-all;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Validação do formulário
document.getElementById('mediaForm').addEventListener('submit', function(e) {
    const categoryId = document.getElementById('category_id').value;
    
    if (!categoryId) {
        e.preventDefault();
        alert('Por favor, selecione uma categoria.');
        document.getElementById('category_id').focus();
        return false;
    }
});
</script>
@endpush