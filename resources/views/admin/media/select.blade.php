<!-- Modal de Seleção de Mídia -->
<div class="media-selector">
    <div class="media-selector-header mb-3">
        <div class="row align-items-center">
            <div class="col-md-3">
                <select id="mediaCategoryFilter" class="form-control form-control-sm">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="mediaTypeFilter" class="form-control form-control-sm">
                    <option value="">Todos os tipos</option>
                    <option value="images" {{ request('type') == 'images' ? 'selected' : '' }}>Imagens</option>
                    <option value="videos" {{ request('type') == 'videos' ? 'selected' : '' }}>Vídeos</option>
                    <option value="documents" {{ request('type') == 'documents' ? 'selected' : '' }}>Documentos</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" id="mediaSearchInput" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="mediaSearchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-outline-secondary" type="button" id="mediaClearFiltersBtn" title="Limpar filtros">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#quickUploadPanel" aria-expanded="false" aria-controls="quickUploadPanel">
                    <i class="fas fa-upload me-1"></i> Upload rápido
                </button>
            </div>
        </div>
        <div class="collapse mt-2" id="quickUploadPanel">
            <div class="card card-body p-2">
                <form id="mediaQuickUploadForm" method="POST" action="/admin/media" enctype="multipart/form-data" data-ml-handled="1" onsubmit="return mlQuickUploadSubmit(event);">
                    @csrf
                    <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label form-label-sm" for="quickUploadFiles">Arquivos</label>
                            <input type="file" name="files[]" id="quickUploadFiles" class="form-control form-control-sm" multiple accept="image/*,video/*,application/pdf,.doc,.docx">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label form-label-sm" for="quickUploadCategory">Categoria</label>
                            <select name="category" id="quickUploadCategory" class="form-select form-select-sm" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-success w-100" id="quickUploadBtn">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Enviar
                            </button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Formatos aceitos: imagens, vídeos e documentos (PDF, DOC, DOCX). Máx. 50MB por arquivo. Até 20 arquivos por envio.</small>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary category-chip" data-value="">Todas</button>
                    <button type="button" class="btn btn-sm btn-outline-primary category-chip" data-value="noticias">Notícias</button>
                    <button type="button" class="btn btn-sm btn-outline-primary category-chip" data-value="galeria">Galeria</button>
                    <button type="button" class="btn btn-sm btn-outline-primary category-chip" data-value="banner">Banners</button>
                    <button type="button" class="btn btn-sm btn-outline-primary category-chip" data-value="foto">Fotos</button>
                    <button type="button" class="btn btn-sm btn-outline-primary category-chip" data-value="documento">Documentos</button>
                </div>
            </div>
        </div>
    </div>

    <div class="media-selector-grid" style="max-height: 400px; overflow-y: auto;">
        <div class="row" id="mediaSelectGrid">
            @forelse($medias as $media)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <div class="media-select-item" data-id="{{ $media->id }}" data-url="{{ $media->url }}" data-path="{{ $media->path }}" data-title="{{ $media->title ?: $media->original_name }}">
                        <div class="media-select-preview">
                            @if($media->is_image)
                                <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="img-fluid">
                            @else
                                <div class="media-select-icon d-flex align-items-center justify-content-center">
                                    <i class="fas {{ $media->icon }} fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div class="media-select-overlay">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="media-select-info p-1">
                            <small class="text-truncate d-block" title="{{ $media->title ?: $media->original_name }}">
                                {{ $media->title ?: $media->original_name }}
                            </small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-4">
                        <i class="fas fa-images fa-3x text-muted mb-2"></i>
                        <p class="text-muted">Nenhum arquivo encontrado</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @if($medias->hasPages())
        <div class="media-selector-pagination mt-3">
            <nav>
                <ul class="pagination pagination-sm justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($medias->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">‹</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="#" data-page="{{ $medias->currentPage() - 1 }}">‹</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($medias->getUrlRange(1, $medias->lastPage()) as $page => $url)
                        @if ($page == $medias->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="#" data-page="{{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($medias->hasMorePages())
                        <li class="page-item"><a class="page-link" href="#" data-page="{{ $medias->currentPage() + 1 }}">›</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">›</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>

<style>
.media-select-item {
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 4px;
    transition: all 0.2s;
}

.media-select-item:hover {
    border-color: #007bff;
}

.media-select-item.selected {
    border-color: #28a745;
    background-color: #f8fff9;
}

.media-select-preview {
    position: relative;
    height: 80px;
    overflow: hidden;
    border-radius: 4px;
    background-color: #f8f9fa;
}

.media-select-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.media-select-icon {
    height: 100%;
    background-color: #f8f9fa;
}

.media-select-overlay {
    position: absolute;
    top: 5px;
    right: 5px;
    color: #28a745;
    font-size: 1.2em;
    opacity: 0;
    transition: opacity 0.2s;
}

.media-select-item.selected .media-select-overlay {
    opacity: 1;
}

.media-select-info {
    font-size: 0.75em;
}
</style>

<script>
// Toast simples no canto superior direito
function showToast(message, type = 'success') {
    const bg = type === 'success' ? '#198754' : (type === 'warning' ? '#ffc107' : '#dc3545');
    const color = type === 'warning' ? '#212529' : '#fff';
    const toast = document.createElement('div');
    toast.style.position = 'fixed';
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = '2000';
    toast.style.background = bg;
    toast.style.color = color;
    toast.style.padding = '10px 14px';
    toast.style.borderRadius = '6px';
    toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    toast.style.fontSize = '0.9rem';
    toast.style.maxWidth = '360px';
    toast.style.wordBreak = 'break-word';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
// Garante inicialização mesmo quando este script é carregado após DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeMediaSelector);
} else {
    initializeMediaSelector();
}

// Fallback global: impedir submissão nativa do Upload Rápido mesmo que algum listener falhe
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form && form.id === 'mediaQuickUploadForm') {
        e.preventDefault();
    }
}, true);

function initializeMediaSelector() {
    bindSelection();
    bindFiltersAndSearch();
    bindPagination();
}

function bindSelection() {
    document.querySelectorAll('.media-select-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.media-select-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            const selectBtn = document.querySelector('#selectMediaBtn');
            if (selectBtn) selectBtn.disabled = false;
        });
    });
}

function bindFiltersAndSearch() {
    const categorySelect = document.getElementById('mediaCategoryFilter');
    const typeSelect = document.getElementById('mediaTypeFilter');
    const searchInput = document.getElementById('mediaSearchInput');
    const searchBtn = document.getElementById('mediaSearchBtn');
    const clearBtn = document.getElementById('mediaClearFiltersBtn');
    const chips = document.querySelectorAll('.category-chip');
    const quickUploadForm = document.getElementById('mediaQuickUploadForm');
    const quickUploadCategory = document.getElementById('quickUploadCategory');
    const quickUploadFiles = document.getElementById('quickUploadFiles');
    const quickUploadBtn = document.getElementById('quickUploadBtn');

    let debounceTimer;

    categorySelect && categorySelect.addEventListener('change', filterMedia);
    typeSelect && typeSelect.addEventListener('change', filterMedia);
    searchBtn && searchBtn.addEventListener('click', filterMedia);
    searchInput && searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterMedia, 300);
    });
    searchInput && searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') filterMedia();
    });

    clearBtn && clearBtn.addEventListener('click', function() {
        if (categorySelect) categorySelect.value = '';
        if (typeSelect) typeSelect.value = '';
        if (searchInput) searchInput.value = '';
        if (quickUploadCategory) quickUploadCategory.value = '';
        filterMedia();
    });

    chips.forEach(chip => {
        chip.addEventListener('click', function() {
            const value = this.getAttribute('data-value') || '';
            if (categorySelect) categorySelect.value = value;
            if (quickUploadCategory) quickUploadCategory.value = value;
            filterMedia();
        });
    });

    function filterMedia() {
        const category = categorySelect?.value || '';
        const type = typeSelect?.value || '';
        const search = searchInput?.value || '';
        loadMediaPage(1, { category, type, search });
    }

    // Upload rápido
    quickUploadForm && quickUploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!quickUploadCategory || !quickUploadCategory.value) {
            showToast('Selecione uma categoria para enviar os arquivos.', 'warning');
            return;
        }
        if (!quickUploadFiles || quickUploadFiles.files.length === 0) {
            showToast('Selecione ao menos um arquivo para enviar.', 'warning');
            return;
        }
        // Limitar a quantidade de arquivos a no máximo 20
        if (quickUploadFiles.files.length > 20) {
            showToast('Você pode enviar no máximo 20 arquivos por vez.', 'warning');
            return;
        }
        // Verificação de tamanho máximo por arquivo (50MB)
        const maxBytes = 50 * 1024 * 1024;
        for (const file of quickUploadFiles.files) {
            if (file.size > maxBytes) {
                showToast(`O arquivo "${file.name}" excede o limite de 50MB.`, 'danger');
                return;
            }
        }
        quickUploadBtn && (quickUploadBtn.disabled = true);

        const formData = new FormData();
        Array.from(quickUploadFiles.files).forEach(file => formData.append('files[]', file));
        formData.append('category', quickUploadCategory.value);
        formData.append('_token', '{{ csrf_token() }}');

        fetch(`{{ route('admin.media.store') }}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData,
            credentials: 'same-origin'
        })
        .then(async res => {
            if (!res.ok) {
                let msg = `Falha no upload (${res.status})`;
                try {
                    const data = await res.json();
                    if (data.message) msg = data.message;
                    if (data.errors) console.error('Erros no upload:', data.errors);
                } catch (e) {
                    const text = await res.text();
                    console.error('Resposta não-JSON do servidor:', text);
                }
                showToast(msg, 'danger');
                throw new Error(msg);
            }
            return res.json();
        })
        .then(json => {
            if (json.success) {
                // Recarrega a grade na categoria selecionada
                const category = categorySelect?.value || quickUploadCategory.value || '';
                const type = typeSelect?.value || '';
                const search = searchInput?.value || '';
                // IDs dos arquivos enviados
                const uploadedIds = (json.data || []).map(m => m.id);
                loadMediaPage(1, { category, type, search });
                // Feedback e fechar painel
                showToast(json.message || 'Upload realizado com sucesso!', 'success');
                // Manter o painel de upload rápido aberto após o upload
                // Limpar seleção de arquivos
                quickUploadFiles.value = '';
            } else {
                showToast(json.message || 'Falha no upload.', 'danger');
                if (json.errors) console.error(json.errors);
            }
        })
        .catch(err => {
            console.error('Erro no upload:', err);
            showToast('Erro ao enviar arquivos. Verifique se está logado e se o token CSRF é válido.', 'danger');
        })
        .finally(() => {
            quickUploadBtn && (quickUploadBtn.disabled = false);
        });
    });

    // Evitar submit padrão do formulário: o botão não é mais "submit"
    quickUploadBtn && quickUploadBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (quickUploadForm) {
            // Dispara o mesmo fluxo do handler de submit
            quickUploadForm.dispatchEvent(new Event('submit', { cancelable: true }));
        }
    });
}

// Fallback inline para submissão do formulário (Enter/submit nativo)
function mlQuickUploadSubmit(e) {
    if (e) e.preventDefault();
    try {
        const form = document.getElementById('mediaQuickUploadForm');
        if (form) {
            form.dispatchEvent(new Event('submit', { cancelable: true }));
        }
    } catch (err) {
        console.error('Falha ao iniciar upload rápido via fallback:', err);
        showToast('Erro ao enviar arquivos.', 'danger');
    }
    return false;
}

function bindPagination() {
    document.querySelectorAll('.media-selector-pagination .page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('data-page');
            if (page) loadMediaPage(page);
        });
    });
}

function loadMediaPage(page, filters = {}) {
    const params = new URLSearchParams({ page, ...filters });
    fetch(`{{ route('admin.media.select') }}?${params}`)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            // Atualizar apenas a grade e a paginação, preservando cabeçalho e estado do painel de upload
            const newGridRows = doc.querySelector('#mediaSelectGrid');
            const currentGridRows = document.querySelector('#mediaSelectGrid');
            if (newGridRows && currentGridRows) {
                currentGridRows.innerHTML = newGridRows.innerHTML;
            }

            const newPagination = doc.querySelector('.media-selector-pagination');
            const currentPagination = document.querySelector('.media-selector-pagination');
            if (currentPagination && newPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
            } else if (currentPagination && !newPagination) {
                // Remove paginação se não houver mais páginas
                currentPagination.remove();
            } else if (!currentPagination && newPagination) {
                // Inserir paginação se ela aparecer
                const container = document.querySelector('.media-selector');
                if (container) container.insertAdjacentHTML('beforeend', newPagination.outerHTML);
            }

            initializeMediaSelector();
        })
        .catch(error => console.error('Erro ao carregar mídia:', error));
}
</script>