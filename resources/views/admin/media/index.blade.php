@extends('layouts.admin')

@section('title', 'Biblioteca de Mídia')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-photo-video mr-2"></i>
                        Biblioteca de Mídia
                    </h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-upload mr-2"></i>
                        Fazer Upload
                    </button>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <select id="categoryFilter" class="form-control">
                                <option value="">Todas as categorias</option>
                                @foreach(\App\Models\Media::getCategories() as $key => $label)
                                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="typeFilter" class="form-control">
                                <option value="">Todos os tipos</option>
                                <option value="images" {{ request('type') == 'images' ? 'selected' : '' }}>Imagens</option>
                                <option value="videos" {{ request('type') == 'videos' ? 'selected' : '' }}>Vídeos</option>
                                <option value="documents" {{ request('type') == 'documents' ? 'selected' : '' }}>Documentos</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar arquivos..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary active" id="gridView">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="listView">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Grid de Mídias -->
                    <div id="mediaGrid" class="row">
                        @forelse($medias as $media)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                                <div class="media-item card h-100" data-id="{{ $media->id }}">
                                    <div class="media-preview">
                                        @if($media->is_image)
                                            <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="card-img-top media-thumbnail">
                                        @else
                                            <div class="card-img-top media-icon d-flex align-items-center justify-content-center">
                                                <i class="fas {{ $media->icon }} fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="media-overlay">
                                            <div class="media-actions">
                                                <button class="btn btn-sm btn-primary view-media" data-id="{{ $media->id }}" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info edit-media" data-id="{{ $media->id }}" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-media" data-id="{{ $media->id }}" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="card-title text-truncate mb-1" title="{{ $media->title ?: $media->original_name }}">
                                            {{ $media->title ?: $media->original_name }}
                                        </h6>
                                        <small class="text-muted">{{ $media->formatted_size }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">Nenhum arquivo encontrado</h5>
                                    <p class="text-muted">Faça upload de seus primeiros arquivos para começar.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Paginação -->
                    <div id="mediaPagination" class="d-flex justify-content-center mt-4">
                        @if($medias->hasPages())
                            {{ $medias->appends(request()->query())->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">
                    <i class="fas fa-upload mr-2"></i>
                    Fazer Upload de Arquivos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="category">Categoria</label>
                        <select name="category" id="category" class="form-control" required>
                            @foreach(\App\Models\Media::getCategories() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="files">Arquivos</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInput" name="files[]" multiple accept="image/*,video/*,.pdf,.doc,.docx">
                            <label class="custom-file-label" for="fileInput">Escolher arquivos...</label>
                        </div>
                        <small class="form-text text-muted">
                        Máximo 50MB por arquivo e até 20 arquivos por envio. Tipos aceitos: imagens, vídeos, PDF, DOC, DOCX.
                        </small>
                    </div>

                    <div id="filePreview" class="row mt-3"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="uploadBtn">
                    <i class="fas fa-upload mr-2"></i>
                    Fazer Upload
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl" style="margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detalhes do Arquivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewModalBody" style="padding: 1.5rem;">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img id="viewImage" class="img-fluid" style="display: none; max-height: 350px; max-width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <div id="viewFileIcon" class="text-center" style="display: none;">
                                <i class="fas fa-file fa-5x text-muted"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="media-info">
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Título:</div>
                                <div class="col-8" id="viewTitle">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Arquivo:</div>
                                <div class="col-8" id="viewFilename" style="font-family: monospace; font-size: 0.9em; word-break: break-all;">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Tamanho:</div>
                                <div class="col-8" id="viewSize">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Tipo:</div>
                                <div class="col-8" id="viewType" style="font-family: monospace; font-size: 0.9em;">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Upload:</div>
                                <div class="col-8" id="viewUploadDate">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Por:</div>
                                <div class="col-8" id="viewUploader">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">URL:</div>
                                <div class="col-8">
                                    <a id="viewPublicUrlLink" href="#" target="_blank" class="text-decoration-none text-primary" style="font-family: monospace; font-size: 0.85em; word-break: break-all;">-</a>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Rota:</div>
                                <div class="col-8">
                                    <code id="viewRouteText" class="bg-light px-2 py-1 rounded" style="font-size: 0.85em; word-break: break-all;">-</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-lg" style="margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>Editar Arquivo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editMediaId">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label fw-semibold">
                                    <i class="fas fa-heading me-1"></i>Título
                                </label>
                                <input type="text" class="form-control" id="editTitle" name="title" placeholder="Digite o título do arquivo">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCategory" class="form-label fw-semibold">
                                    <i class="fas fa-folder me-1"></i>Categoria
                                </label>
                                <select class="form-select" id="editCategory" name="category">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach(\App\Models\Media::getCategories() as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="editAltText" class="form-label fw-semibold">
                                    <i class="fas fa-eye me-1"></i>Texto Alternativo
                                </label>
                                <input type="text" class="form-control" id="editAltText" name="alt_text" placeholder="Descrição para acessibilidade">
                                <div class="form-text">Usado por leitores de tela para descrever a imagem</div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="editDescription" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-1"></i>Descrição
                                </label>
                                <textarea class="form-control" id="editDescription" name="description" rows="4" placeholder="Descrição detalhada do arquivo"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="saveEditBtn">
                    <i class="fas fa-save me-1"></i>Salvar Alterações
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.media-item {
    cursor: pointer;
    transition: transform 0.2s;
}

.media-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.media-preview {
    position: relative;
    overflow: hidden;
}

.media-thumbnail {
    height: 150px;
    object-fit: cover;
    width: 100%;
}

/* Garantir que imagens geradas via JS fiquem contidas ao thumbnail */
.media-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.media-icon {
    height: 150px;
    background-color: #f8f9fa;
}

.media-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.media-item:hover .media-overlay {
    opacity: 1;
}

.media-actions .btn {
    margin: 0 2px;
}

#filePreview .preview-item {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
}

#filePreview img {
    max-height: 100px;
    object-fit: cover;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/media-library.js') }}"></script>
@endpush