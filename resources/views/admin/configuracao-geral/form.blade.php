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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Modal de seleção de mídia
    let modalInstance;
    function ensureModal() {
        const modalEl = document.getElementById('mediaSelectorModalImagem');
        modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
    }

    function loadMediaSelector() {
        const container = document.getElementById('mediaSelectorContainerImagem');
        container.innerHTML = '<div class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin"></i> Carregando mídia...</div>';
        fetch(`{{ route('admin.media.select') }}`)
            .then(r => r.text())
            .then(html => { 
                container.innerHTML = html; 
                initializeMediaSelectorImagem();
            })
            .catch(err => { console.error('Erro ao carregar seletor de mídia', err); });
    }

    function initializeMediaSelectorImagem() {
        document.querySelectorAll('#mediaSelectorModalImagem .media-select-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('#mediaSelectorModalImagem .media-select-item').forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');
                const selectBtn = document.getElementById('selectMediaBtnImagem');
                if (selectBtn) selectBtn.disabled = false;
            });
        });

        // Paginação dentro do modal
        document.querySelectorAll('#mediaSelectorModalImagem .media-selector-pagination .page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                if (page) {
                    const params = new URLSearchParams({ page });
                    fetch(`{{ route('admin.media.select') }}?${params}`)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newGrid = doc.querySelector('.media-selector');
                            document.querySelector('#mediaSelectorModalImagem .media-selector').innerHTML = newGrid.innerHTML;
                            initializeMediaSelectorImagem();
                        });
                }
            });
        });
    }

    function applySelectedMedia() {
        const selected = document.querySelector('#mediaSelectorModalImagem .media-select-item.selected');
        if (!selected) return;
        const url = selected.getAttribute('data-url');
        const path = selected.getAttribute('data-path');
        if (hiddenInput) hiddenInput.value = path || '';
        if (previewImg) previewImg.src = url || '';
        if (preview) preview.style.display = url ? 'block' : 'none';
        if (imagemInput) imagemInput.value = ''; // Limpa arquivo local se houver seleção
        if (modalInstance) modalInstance.hide();
    }

    if (openBtn) {
        openBtn.addEventListener('click', function() {
            ensureModal();
            loadMediaSelector();
            modalInstance.show();
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

    const selectBtn = document.getElementById('selectMediaBtnImagem');
    if (selectBtn) {
        selectBtn.addEventListener('click', applySelectedMedia);
    }
});
</script>
@endpush

<!-- Modal: Seletor de Mídia para Imagem -->
<div class="modal fade" id="mediaSelectorModalImagem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-images"></i> Selecionar mídia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div id="mediaSelectorContainerImagem">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-spinner fa-spin"></i> Carregando mídia...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="selectMediaBtnImagem" disabled>Selecionar</button>
            </div>
        </div>
    </div>
</div>