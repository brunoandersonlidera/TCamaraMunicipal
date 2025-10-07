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
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="openMediaSelectorDestaqueBtn">
                                <i class="fas fa-photo-video"></i> Selecionar da Biblioteca
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSelectedDestaqueBtn">
                                <i class="fas fa-times"></i> Limpar seleção
                            </button>
                        </div>
                        <input type="file" class="form-control @error('imagem_destaque') is-invalid @enderror" 
                               id="imagem_destaque" name="imagem_destaque" accept="image/*">
                        @error('imagem_destaque')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</div>
                        <input type="hidden" name="imagem_destaque_existing" id="imagem_destaque_existing_input" value="{{ old('imagem_destaque_existing') }}">
                        <div id="destaqueSelectedPreview" class="mt-2" style="display: none;">
                            <label class="form-label d-block">Pré-visualização da seleção</label>
                            <img id="destaqueSelectedPreviewImg" src="" alt="Pré-visualização" class="img-thumbnail" style="max-width: 180px;">
                        </div>
                        <div id="preview-destaque" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="galeria_imagens" class="form-label">Galeria de Imagens</label>
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="openMediaSelectorGaleriaBtn">
                                <i class="fas fa-photo-video"></i> Selecionar da Biblioteca
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSelectedGaleriaBtn">
                                <i class="fas fa-times"></i> Limpar seleção
                            </button>
                        </div>
                        <input type="file" class="form-control @error('galeria_imagens.*') is-invalid @enderror" 
                               id="galeria_imagens" name="galeria_imagens[]" accept="image/*" multiple>
                        @error('galeria_imagens.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Selecione múltiplas imagens para a galeria</div>
                        <div id="galeriaExistingContainer"></div>
                        <div id="galeriaSelectedPreview" class="mt-2 row" style="display: none;"></div>
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

<!-- Modal: Seletor de Mídia -->
<div class="modal fade" id="mediaSelectorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-images"></i> Selecionar mídia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div id="mediaSelectorContainer">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-spinner fa-spin"></i> Carregando mídia...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="selectMediaBtn" disabled>Selecionar</button>
            </div>
        </div>
    </div>
    
    <style>
    #galeriaSelectedPreview .galeria-item {
        position: relative;
    }
    #galeriaSelectedPreview .remove-galeria-item {
        position: absolute;
        top: 6px;
        right: 6px;
    }
    </style>
</div>

@push('styles')
<link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openDestaqueBtn = document.getElementById('openMediaSelectorDestaqueBtn');
    const clearDestaqueBtn = document.getElementById('clearSelectedDestaqueBtn');
    const openGaleriaBtn = document.getElementById('openMediaSelectorGaleriaBtn');
    const clearGaleriaBtn = document.getElementById('clearSelectedGaleriaBtn');

    const destaqueHiddenInput = document.getElementById('imagem_destaque_existing_input');
    const destaqueFileInput = document.getElementById('imagem_destaque');
    const destaquePreview = document.getElementById('destaqueSelectedPreview');
    const destaquePreviewImg = document.getElementById('destaqueSelectedPreviewImg');

    const galeriaFileInput = document.getElementById('galeria_imagens');
    const galeriaExistingContainer = document.getElementById('galeriaExistingContainer');
    const galeriaPreview = document.getElementById('galeriaSelectedPreview');

    let modalInstance;
    let selectionMode = 'single';
    let selectionTarget = 'destaque';

    function ensureModal() {
        const modalEl = document.getElementById('mediaSelectorModal');
        modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
    }

    function loadMediaSelector() {
        const container = document.getElementById('mediaSelectorContainer');
        container.innerHTML = '<div class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin"></i> Carregando mídia...</div>';
        // Carregar já filtrado por categoria "noticias" para evitar validação inicial e loops
        fetch(`{{ route('admin.media.select') }}?category=noticias`)
            .then(r => r.text())
            .then(html => { 
                container.innerHTML = html; 
                initializeMediaSelector();
            })
            .catch(err => { console.error('Erro ao carregar seletor de mídia', err); });
    }

    function initializeMediaSelector() {
        document.querySelectorAll('#mediaSelectorModal .media-select-item').forEach(item => {
            item.addEventListener('click', function() {
                const selectBtn = document.querySelector('#selectMediaBtn');
                if (selectionMode === 'single') {
                    document.querySelectorAll('#mediaSelectorModal .media-select-item').forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                } else {
                    this.classList.toggle('selected');
                }
                if (selectBtn) selectBtn.disabled = document.querySelectorAll('#mediaSelectorModal .media-select-item.selected').length === 0;
            });
        });

        const categoryFilter = document.querySelector('#mediaSelectorModal #mediaCategoryFilter');
        const typeFilter = document.querySelector('#mediaSelectorModal #mediaTypeFilter');
        const searchInput = document.querySelector('#mediaSelectorModal #mediaSearchInput');
        const searchBtn = document.querySelector('#mediaSelectorModal #mediaSearchBtn');

        function filterMedia() {
            const category = categoryFilter?.value || '';
            const type = typeFilter?.value || '';
            const search = searchInput?.value || '';
            loadMediaPage(1, { category, type, search });
        }

        categoryFilter?.addEventListener('change', filterMedia);
        typeFilter?.addEventListener('change', filterMedia);
        searchBtn?.addEventListener('click', filterMedia);
        searchInput?.addEventListener('keypress', function(e) { if (e.key === 'Enter') filterMedia(); });

        document.querySelectorAll('#mediaSelectorModal .media-selector-pagination .page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                if (page) loadMediaPage(page);
            });
        });
    }

    function loadMediaPage(page, filters = {}) {
        const params = new URLSearchParams({ page: page, ...filters });
        fetch(`{{ route('admin.media.select') }}?${params}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newGrid = doc.querySelector('.media-selector');
                const container = document.querySelector('#mediaSelectorModal .modal-body #mediaSelectorContainer');
                if (container && newGrid) {
                    container.innerHTML = newGrid.outerHTML;
                    initializeMediaSelector();
                }
            })
            .catch(error => { console.error('Erro ao carregar mídia:', error); });
    }

    openDestaqueBtn?.addEventListener('click', function() {
        selectionMode = 'single';
        selectionTarget = 'destaque';
        ensureModal();
        loadMediaSelector();
        modalInstance.show();
    });

    openGaleriaBtn?.addEventListener('click', function() {
        selectionMode = 'multi';
        selectionTarget = 'galeria';
        ensureModal();
        loadMediaSelector();
        modalInstance.show();
    });

    clearDestaqueBtn?.addEventListener('click', function() {
        destaqueHiddenInput.value = '';
        destaquePreview.style.display = 'none';
        destaquePreviewImg.src = '';
    });

    clearGaleriaBtn?.addEventListener('click', function() {
        galeriaExistingContainer.innerHTML = '';
        galeriaPreview.style.display = 'none';
        galeriaPreview.innerHTML = '';
    });

    document.getElementById('selectMediaBtn')?.addEventListener('click', function() {
        const selectedItems = document.querySelectorAll('#mediaSelectorModal .media-select-item.selected');
        if (selectedItems.length === 0) return;

        if (selectionTarget === 'destaque') {
            const selected = selectedItems[0];
            const path = selected.getAttribute('data-path');
            const url = selected.getAttribute('data-url');
            if (path) {
                destaqueHiddenInput.value = path;
                destaquePreviewImg.src = url;
                destaquePreview.style.display = 'block';
                destaqueFileInput.value = '';
            }
        } else if (selectionTarget === 'galeria') {
            selectedItems.forEach(sel => {
                const path = sel.getAttribute('data-path');
                const url = sel.getAttribute('data-url');
                if (!path) return;
                const exists = Array.from(galeriaExistingContainer.querySelectorAll('input[name="galeria_existing[]"]'))
                    .some(inp => inp.value === path);
                if (!exists) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'galeria_existing[]';
                    hidden.value = path;
                    galeriaExistingContainer.appendChild(hidden);

                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-2 galeria-item';
                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = 'Galeria';
                    img.className = 'preview-image w-100';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-outline-danger remove-galeria-item';
                    removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
                    removeBtn.addEventListener('click', function() {
                        const inputs = galeriaExistingContainer.querySelectorAll('input[name="galeria_existing[]"]');
                        inputs.forEach(inp => { if (inp.value === path) inp.remove(); });
                        col.remove();
                        if (galeriaPreview.children.length === 0) {
                            galeriaPreview.style.display = 'none';
                        }
                    });

                    col.appendChild(img);
                    col.appendChild(removeBtn);
                    galeriaPreview.appendChild(col);
                }
            });
            if (galeriaPreview.children.length > 0) {
                galeriaPreview.style.display = 'flex';
            }
            galeriaFileInput.value = '';
        }

        modalInstance.hide();
    });
});
</script>
@endpush

@push('scripts')
<script src="{{ asset('js/noticias.js') }}"></script>
@endpush