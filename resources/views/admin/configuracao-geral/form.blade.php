<div class="row">
    <!-- Chave -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="chave" class="form-label">Chave <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('chave') is-invalid @enderror" 
                   id="chave" name="chave" value="{{ old('chave', $configuracao->chave ?? '') }}" 
                   placeholder="Ex: brasao_header, logo_footer" required>
            @error('chave')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Identificador único da configuração (sem espaços, use underscore)</div>
        </div>
    </div>

    <!-- Tipo -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                <option value="">Selecione o tipo</option>
                <option value="texto" {{ old('tipo', $configuracao->tipo ?? '') === 'texto' ? 'selected' : '' }}>Texto</option>
                <option value="imagem" {{ old('tipo', $configuracao->tipo ?? '') === 'imagem' ? 'selected' : '' }}>Imagem</option>
                <option value="email" {{ old('tipo', $configuracao->tipo ?? '') === 'email' ? 'selected' : '' }}>E-mail</option>
                <option value="telefone" {{ old('tipo', $configuracao->tipo ?? '') === 'telefone' ? 'selected' : '' }}>Telefone</option>
                <option value="endereco" {{ old('tipo', $configuracao->tipo ?? '') === 'endereco' ? 'selected' : '' }}>Endereço</option>
            </select>
            @error('tipo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Descrição -->
<div class="mb-3">
    <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('descricao') is-invalid @enderror" 
           id="descricao" name="descricao" value="{{ old('descricao', $configuracao->descricao ?? '') }}" 
           placeholder="Ex: Brasão da Câmara Municipal para o cabeçalho" required>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Valor (para tipos não-imagem) -->
<div class="mb-3" id="campo-valor" style="{{ old('tipo', $configuracao->tipo ?? '') === 'imagem' ? 'display: none;' : '' }}">
    <label for="valor" class="form-label">Valor <span class="text-danger">*</span></label>
    <textarea class="form-control @error('valor') is-invalid @enderror" 
              id="valor" name="valor" rows="3" 
              placeholder="Digite o valor da configuração">{{ old('valor', $configuracao->valor ?? '') }}</textarea>
    @error('valor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Upload/Seleção de Imagem (para tipo imagem) -->
<div class="mb-3" id="campo-imagem" style="{{ old('tipo', $configuracao->tipo ?? '') === 'imagem' ? '' : 'display: none;' }}">
    <label class="form-label">Imagem</label>
    <div class="d-flex gap-2 mb-2">
        <button type="button" class="btn btn-outline-primary btn-sm" id="openMediaSelectorBtnImagem">
            <i class="fas fa-photo-video"></i> Selecionar da Biblioteca
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSelectedMediaBtnImagem">
            <i class="fas fa-times"></i> Limpar seleção
        </button>
    </div>
    <div class="mb-2">
        <input type="file" class="form-control @error('imagem') is-invalid @enderror" 
               id="imagem" name="imagem" accept="image/*">
        @error('imagem')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Formatos aceitos: JPG, PNG, GIF, SVG. Tamanho máximo: 2MB</div>
    </div>
    <input type="hidden" name="imagem_existing" id="imagem_existing_input" value="{{ old('imagem_existing') }}">
    <div id="imagemSelectedPreview" class="mt-2" style="display: none;">
        <label class="form-label d-block">Pré-visualização da seleção</label>
        <img id="imagemSelectedPreviewImg" src="" alt="Pré-visualização" class="img-thumbnail" style="max-width: 150px;">
    </div>

    @if(isset($configuracao) && $configuracao->tipo === 'imagem' && $configuracao->valor)
        <div class="mt-3">
            <label class="form-label">Imagem atual:</label>
            <div>
                <img src="{{ $configuracao->url_imagem }}" alt="{{ $configuracao->chave }}" 
                     class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
            </div>
        </div>
    @endif
</div>

<!-- Status -->
<div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" 
               {{ old('ativo', $configuracao->ativo ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="ativo">
            Ativo
        </label>
    </div>
    <div class="form-text">Configurações inativas não serão exibidas no site</div>
</div>

<!-- Modal de Seleção de Mídia -->
<div class="modal fade" id="mediaSelectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-images"></i> Selecionar mídia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div id="mediaSelectContainer">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-spinner fa-spin"></i> Carregando mídia...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="targetInput">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="selectMediaBtn" disabled>Selecionar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/media-library.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuração do modal de seleção de mídia
    const mediaSelectModal = document.getElementById('mediaSelectModal');
    let mediaModalInstance = null;
    
    if (mediaSelectModal) {
        // Inicializar modal Bootstrap
        mediaModalInstance = new bootstrap.Modal(mediaSelectModal);
        
        // Carregar conteúdo quando o modal for mostrado
        mediaSelectModal.addEventListener('shown.bs.modal', function() {
            loadMediaSelector();
        });
    }
    
    function loadMediaSelector() {
        const container = document.getElementById('mediaSelectContainer');
        if (!container) return;
        
        container.innerHTML = '<div class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin"></i> Carregando mídia...</div>';
        
        fetch('{{ route("admin.media.select") }}')
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                initializeMediaSelector();
            })
            .catch(error => {
                console.error('Erro ao carregar mídia:', error);
                container.innerHTML = '<div class="text-center py-5 text-danger"><i class="fas fa-exclamation-triangle"></i> Erro ao carregar mídia</div>';
            });
    }
    
    function initializeMediaSelector() {
        // Configurar seleção de mídia
        document.querySelectorAll('#mediaSelectModal .media-select-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remover seleção anterior
                document.querySelectorAll('#mediaSelectModal .media-select-item').forEach(i => i.classList.remove('selected'));
                // Adicionar seleção atual
                this.classList.add('selected');
                // Habilitar botão de seleção
                const selectBtn = document.getElementById('selectMediaBtn');
                if (selectBtn) selectBtn.disabled = false;
            });
        });
        
        // Configurar filtros
        const categoryFilter = document.getElementById('mediaCategoryFilter');
        const typeFilter = document.getElementById('mediaTypeFilter');
        const searchInput = document.getElementById('mediaSearchInput');
        const searchBtn = document.getElementById('mediaSearchBtn');
        const clearBtn = document.getElementById('mediaClearFiltersBtn');
        
        if (categoryFilter) {
            categoryFilter.addEventListener('change', applyMediaFilters);
        }
        if (typeFilter) {
            typeFilter.addEventListener('change', applyMediaFilters);
        }
        if (searchInput) {
            searchInput.addEventListener('input', debounceMediaSearch);
        }
        if (searchBtn) {
            searchBtn.addEventListener('click', applyMediaFilters);
        }
        if (clearBtn) {
            clearBtn.addEventListener('click', clearMediaFilters);
        }
        
        // Configurar paginação
        document.querySelectorAll('#mediaSelectModal .media-selector-pagination .page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                if (page) {
                    loadMediaPage(page);
                }
            });
        });
    }
    
    function applyMediaFilters() {
        const category = document.getElementById('mediaCategoryFilter')?.value || '';
        const type = document.getElementById('mediaTypeFilter')?.value || '';
        const search = document.getElementById('mediaSearchInput')?.value || '';
        
        loadMediaPage(1, { category, type, search });
    }
    
    function clearMediaFilters() {
        const categoryFilter = document.getElementById('mediaCategoryFilter');
        const typeFilter = document.getElementById('mediaTypeFilter');
        const searchInput = document.getElementById('mediaSearchInput');
        
        if (categoryFilter) categoryFilter.value = '';
        if (typeFilter) typeFilter.value = '';
        if (searchInput) searchInput.value = '';
        
        loadMediaPage(1);
    }
    
    function loadMediaPage(page, filters = {}) {
        const params = new URLSearchParams({ page: page, ...filters });
        const container = document.getElementById('mediaSelectContainer');
        
        if (!container) return;
        
        container.innerHTML = '<div class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>';
        
        fetch(`{{ route("admin.media.select") }}?${params}`)
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                initializeMediaSelector();
            })
            .catch(error => {
                console.error('Erro ao carregar mídia:', error);
                container.innerHTML = '<div class="text-center py-5 text-danger"><i class="fas fa-exclamation-triangle"></i> Erro ao carregar mídia</div>';
            });
    }
    
    let mediaSearchTimeout;
    function debounceMediaSearch() {
        clearTimeout(mediaSearchTimeout);
        mediaSearchTimeout = setTimeout(applyMediaFilters, 300);
    }
    
    // Configurar botão de seleção
    const selectMediaBtn = document.getElementById('selectMediaBtn');
    if (selectMediaBtn) {
        selectMediaBtn.addEventListener('click', function() {
            const selected = document.querySelector('#mediaSelectModal .media-select-item.selected');
            if (selected && window.mediaLibraryOptions && window.mediaLibraryOptions.onSelect) {
                const mediaData = {
                    id: selected.getAttribute('data-id'),
                    url: selected.getAttribute('data-url'),
                    path: selected.getAttribute('data-path'),
                    title: selected.getAttribute('data-title')
                };
                window.mediaLibraryOptions.onSelect(mediaData);
                mediaModalInstance.hide();
            }
        });
    }
    
    // Sobrescrever a função openMediaLibrary para usar nosso modal
    window.openMediaLibrary = function(options = {}) {
        window.mediaLibraryOptions = {
            multiple: options.multiple || false,
            type: options.type || 'all',
            onSelect: options.onSelect || function() {}
        };
        
        if (mediaModalInstance) {
            mediaModalInstance.show();
        }
    };
     
     // Configuração dos campos do formulário
     const tipoSelect = document.getElementById('tipo');
    const campoValor = document.getElementById('campo-valor');
    const campoImagem = document.getElementById('campo-imagem');
    const valorInput = document.getElementById('valor');
    const imagemInput = document.getElementById('imagem');
    const openBtn = document.getElementById('openMediaSelectorBtnImagem');
    const clearBtn = document.getElementById('clearSelectedMediaBtnImagem');
    const hiddenInput = document.getElementById('imagem_existing_input');
    const preview = document.getElementById('imagemSelectedPreview');
    const previewImg = document.getElementById('imagemSelectedPreviewImg');

    function toggleCampos() {
        const tipo = tipoSelect.value;
        
        if (tipo === 'imagem') {
            campoValor.style.display = 'none';
            campoImagem.style.display = 'block';
            valorInput.removeAttribute('required');
        } else {
            campoValor.style.display = 'block';
            campoImagem.style.display = 'none';
            valorInput.setAttribute('required', 'required');
            // Limpa seleção de mídia quando sair do tipo imagem
            if (hiddenInput) hiddenInput.value = '';
            if (preview) preview.style.display = 'none';
            if (previewImg) previewImg.src = '';
            if (imagemInput) imagemInput.value = '';
        }
    }

    tipoSelect.addEventListener('change', toggleCampos);
    
    // Executar na inicialização
    toggleCampos();

    // Usar a nova função openMediaLibrary
    if (openBtn) {
        openBtn.addEventListener('click', function() {
            if (typeof window.openMediaLibrary === 'function') {
                window.openMediaLibrary({
                    onSelect: function(media) {
                        if (hiddenInput) hiddenInput.value = media.path || '';
                        if (previewImg) previewImg.src = media.url || '';
                        if (preview) preview.style.display = media.url ? 'block' : 'none';
                        if (imagemInput) imagemInput.value = ''; // Limpa arquivo local se houver seleção
                    }
                });
            } else {
                alert('Biblioteca de mídia não disponível. Verifique se a página foi carregada corretamente.');
            }
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            if (hiddenInput) hiddenInput.value = '';
            if (previewImg) previewImg.src = '';
            if (preview) preview.style.display = 'none';
            if (imagemInput) imagemInput.value = '';
        });
    }
});
</script>
@endpush