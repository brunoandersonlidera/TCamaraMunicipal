@extends('layouts.admin')

@section('page-title', 'Editar Configurações do Hero')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.hero-config.index') }}">Configurações Hero</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Editar Configurações do Hero Section</h1>
            <p class="text-muted">Configure o texto e comportamento da seção principal do site</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.hero-config.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <form action="{{ route('admin.hero-config.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Formulário Principal -->
            <div class="col-lg-8">
                <!-- Textos do Hero -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-font me-2"></i>
                            Textos do Hero Section
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título Principal</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" name="titulo" 
                                   value="{{ old('titulo', $heroConfig->titulo ?? 'Bem-vindo à Câmara Municipal') }}"
                                   placeholder="Ex: Bem-vindo à Câmara Municipal">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Este será o título principal exibido no hero section.</div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" name="descricao" rows="3" maxlength="350"
                                      placeholder="Ex: Trabalhando pela transparência, representatividade e desenvolvimento do nosso município...">{{ old('descricao', $heroConfig->descricao ?? 'Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. Acompanhe as atividades legislativas e participe da vida política da sua cidade.') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-text">Descrição que aparece abaixo do título principal.</div>
                                <div class="small text-muted" id="descricao_counter">0/350</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Imagens do Hero -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-image me-2"></i>
                            Imagens do Hero
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="imagem_topo_id" class="form-label">Imagem acima do título</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('imagem_topo_id') is-invalid @enderror" 
                                               id="imagem_topo_id" name="imagem_topo_id" 
                                               value="{{ old('imagem_topo_id', $heroConfig->imagem_topo_id ?? '') }}" 
                                               placeholder="ID da mídia (opcional)">
                                        <button type="button" class="btn btn-outline-primary" data-open-media-select="imagem_topo_id">
                                            <i class="fas fa-photo-video me-1"></i> Selecionar da Biblioteca
                                        </button>
                                    </div>
                                    @error('imagem_topo_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Use o botão para escolher diretamente na Biblioteca de Mídia. Se preferir, abra a <a href="{{ route('admin.media.index') }}" target="_blank">Biblioteca de Mídia</a> e informe o ID manualmente.</div>
                                </div>
                                <div class="row g-3 align-items-end mb-3">
                                    <div class="col-sm-6">
                                        <label for="imagem_topo_altura_px" class="form-label">Altura máxima da imagem (px)</label>
                                        <input type="number" min="50" max="2000" step="10" class="form-control @error('imagem_topo_altura_px') is-invalid @enderror"
                                               id="imagem_topo_altura_px" name="imagem_topo_altura_px"
                                               value="{{ old('imagem_topo_altura_px', $heroConfig->imagem_topo_altura_px ?? '') }}" placeholder="Ex: 300">
                                        @error('imagem_topo_altura_px')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Defina a altura máxima para a imagem do topo. Deixe vazio para usar o tamanho automático.</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" value="1" id="centralizar_imagem_topo" name="centralizar_imagem_topo"
                                                   {{ old('centralizar_imagem_topo', $heroConfig->centralizar_imagem_topo ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="centralizar_imagem_topo">
                                                Centralizar imagem acima do título
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="preview_imagem_topo" class="border rounded p-2 text-center" style="min-height: 120px;">
                                    @if(optional($heroConfig->imagemTopo)->url)
                                        <img src="{{ optional($heroConfig->imagemTopo)->url }}" alt="Imagem acima do título" class="mx-auto d-block" style="max-height: {{ $heroConfig->imagem_topo_altura_px ?? 120 }}px; max-width: 100%; height: auto; width: auto;">
                                    @else
                                        <span class="text-muted">Nenhuma imagem selecionada</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="imagem_descricao_id" class="form-label">Imagem ao lado esquerdo da descrição</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('imagem_descricao_id') is-invalid @enderror" 
                                               id="imagem_descricao_id" name="imagem_descricao_id" 
                                               value="{{ old('imagem_descricao_id', $heroConfig->imagem_descricao_id ?? '') }}" 
                                               placeholder="ID da mídia (opcional)">
                                        <button type="button" class="btn btn-outline-primary" data-open-media-select="imagem_descricao_id">
                                            <i class="fas fa-photo-video me-1"></i> Selecionar da Biblioteca
                                        </button>
                                    </div>
                                    @error('imagem_descricao_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Use o botão para escolher diretamente na Biblioteca de Mídia. Se preferir, abra a <a href="{{ route('admin.media.index') }}" target="_blank">Biblioteca de Mídia</a> e informe o ID manualmente.</div>
                                </div>
                                <div class="row g-3 align-items-end mb-3">
                                    <div class="col-sm-8">
                                        <label for="imagem_descricao_altura_px" class="form-label">Altura máxima da imagem da descrição (px)</label>
                                        <input type="number" min="50" max="2000" step="10" class="form-control @error('imagem_descricao_altura_px') is-invalid @enderror"
                                               id="imagem_descricao_altura_px" name="imagem_descricao_altura_px"
                                               value="{{ old('imagem_descricao_altura_px', $heroConfig->imagem_descricao_altura_px ?? '') }}" placeholder="Ex: 120">
                                        @error('imagem_descricao_altura_px')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Defina a altura máxima para a imagem ao lado da descrição. Deixe vazio para usar o tamanho automático.</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="imagem_descricao_largura_px" class="form-label">Largura máxima da imagem da descrição (px)</label>
                                        <input type="number" min="50" max="3000" step="10" class="form-control @error('imagem_descricao_largura_px') is-invalid @enderror"
                                               id="imagem_descricao_largura_px" name="imagem_descricao_largura_px"
                                               value="{{ old('imagem_descricao_largura_px', $heroConfig->imagem_descricao_largura_px ?? '') }}" placeholder="Ex: 200">
                                        @error('imagem_descricao_largura_px')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Defina a largura máxima para a imagem ao lado da descrição. Deixe vazio para usar o tamanho automático.</div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-end mb-3">
                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="centralizar_imagem_descricao" name="centralizar_imagem_descricao"
                                                   {{ old('centralizar_imagem_descricao', $heroConfig->centralizar_imagem_descricao ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="centralizar_imagem_descricao">
                                                Centralizar imagem da descrição no preview
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="preview_imagem_descricao" class="border rounded p-2 text-center" style="min-height: 120px;">
                                    @if(optional($heroConfig->imagemDescricao)->url)
                                        <img src="{{ optional($heroConfig->imagemDescricao)->url }}" alt="Imagem da descrição" class="{{ old('centralizar_imagem_descricao', $heroConfig->centralizar_imagem_descricao ?? false) ? 'mx-auto d-block' : '' }}"
                                             style="
                                                height: {{ old('imagem_descricao_altura_px', $heroConfig->imagem_descricao_altura_px ?? 120) }}px;
                                                {{ !empty(old('imagem_descricao_largura_px', $heroConfig->imagem_descricao_largura_px ?? '')) ? 'width: ' . old('imagem_descricao_largura_px', $heroConfig->imagem_descricao_largura_px) . 'px;' : 'max-width: 100%;' }}
                                                object-fit: contain;
                                            ">
                                    @else
                                        <span class="text-muted">Nenhuma imagem selecionada</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configurações do Slider -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sliders-h me-2"></i>
                            Configurações do Slider
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="intervalo" class="form-label">Intervalo entre Slides (ms)</label>
                                    <input type="number" class="form-control @error('intervalo') is-invalid @enderror" 
                                           id="intervalo" name="intervalo" 
                                           value="{{ old('intervalo', $heroConfig->intervalo ?? 5000) }}"
                                           min="1000" max="30000" step="500">
                                    @error('intervalo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Tempo em milissegundos (1000ms = 1 segundo).</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="transicao" class="form-label">Tipo de Transição</label>
                                    <select class="form-select @error('transicao') is-invalid @enderror" 
                                            id="transicao" name="transicao">
                                        <option value="slide" {{ old('transicao', $heroConfig->transicao ?? 'slide') == 'slide' ? 'selected' : '' }}>Deslizar</option>
                                        <option value="fade" {{ old('transicao', $heroConfig->transicao ?? 'slide') == 'fade' ? 'selected' : '' }}>Fade</option>
                                        <option value="zoom" {{ old('transicao', $heroConfig->transicao ?? 'slide') == 'zoom' ? 'selected' : '' }}>Zoom</option>
                                    </select>
                                    @error('transicao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configurações Laterais -->
            <div class="col-lg-4">
                <!-- Opções de Comportamento -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-toggle-on me-2"></i>
                            Comportamento
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="autoplay" name="autoplay" value="1"
                                   {{ old('autoplay', $heroConfig->autoplay ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="autoplay">
                                Autoplay
                            </label>
                            <div class="form-text">Reproduzir slides automaticamente.</div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="pausar_hover" name="pausar_hover" value="1"
                                   {{ old('pausar_hover', $heroConfig->pausar_hover ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pausar_hover">
                                Pausar no Hover
                            </label>
                            <div class="form-text">Pausar quando o mouse estiver sobre o slider.</div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrar_indicadores" name="mostrar_indicadores" value="1"
                                   {{ old('mostrar_indicadores', $heroConfig->mostrar_indicadores ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="mostrar_indicadores">
                                Mostrar Indicadores
                            </label>
                            <div class="form-text">Exibir pontos indicadores na parte inferior.</div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrar_controles" name="mostrar_controles" value="1"
                                   {{ old('mostrar_controles', $heroConfig->mostrar_controles ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="mostrar_controles">
                                Mostrar Controles
                            </label>
                            <div class="form-text">Exibir setas de navegação.</div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-save me-2"></i>
                            Ações
                        </h5>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>
                            Salvar Configurações
                        </button>
                        
                        <a href="{{ route('admin.hero-config.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                        
                        <hr>
                        
                        <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-info w-100 mb-2">
                            <i class="fas fa-images me-2"></i>
                            Gerenciar Slides
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-success w-100" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Visualizar Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal de Seleção de Mídia -->
<div class="modal fade" id="mediaSelectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-photo-video me-2"></i>Selecionar Mídia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input type="text" id="mlSearch" class="form-control" placeholder="Buscar por título ou nome">
                    </div>
                    <div class="col-md-4">
                        <select id="mlCategory" class="form-select">
                            <option value="">Todas as categorias</option>
                            <option value="imagens">Imagens</option>
                            <option value="videos">Vídeos</option>
                            <option value="documentos">Documentos</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="mlType" class="form-select">
                            <option value="">Todos os tipos</option>
                            <option value="image">Imagens</option>
                            <option value="video">Vídeos</option>
                            <option value="document">Documentos</option>
                        </select>
                    </div>
                </div>

                <div id="mlGrid" class="row g-3"></div>

                <nav class="mt-3">
                    <ul id="mlPagination" class="pagination justify-content-center"></ul>
                </nav>

                <input type="hidden" id="mlTargetInput" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview em tempo real do intervalo
    const intervaloInput = document.getElementById('intervalo');
    const intervaloLabel = document.querySelector('label[for="intervalo"]');
    function updateIntervaloLabel() {
        const valor = parseInt(intervaloInput.value);
        const segundos = (valor / 1000).toFixed(1);
        intervaloLabel.textContent = `Intervalo entre Slides (${segundos}s)`;
    }
    if (intervaloInput) {
        intervaloInput.addEventListener('input', updateIntervaloLabel);
        updateIntervaloLabel(); // Inicializar
    }

    // Seleção de mídia via modal
    const apiUrl = "{{ route('admin.media.api') }}";
    const mediaModalEl = document.getElementById('mediaSelectModal');
    const mediaModal = mediaModalEl ? new bootstrap.Modal(mediaModalEl) : null;
    const mlGrid = document.getElementById('mlGrid');
    const mlPagination = document.getElementById('mlPagination');
    const mlSearch = document.getElementById('mlSearch');
    const mlCategory = document.getElementById('mlCategory');
    const mlType = document.getElementById('mlType');
    const mlTargetInput = document.getElementById('mlTargetInput');

    // Abrir modal ao clicar nos botões
    document.querySelectorAll('[data-open-media-select]').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!mediaModal) return;
            mlTargetInput.value = this.getAttribute('data-open-media-select');
            // Limpar busca ao abrir
            if (mlSearch) mlSearch.value = '';
            if (mlCategory) mlCategory.value = '';
            if (mlType) mlType.value = 'image'; // por padrão, focar imagens
            mediaModal.show();
            loadMedia(1);
        });
    });

    // Filtros e busca
    if (mlSearch) mlSearch.addEventListener('input', debounce(() => loadMedia(1), 300));
    if (mlCategory) mlCategory.addEventListener('change', () => loadMedia(1));
    if (mlType) mlType.addEventListener('change', () => loadMedia(1));

    function buildQuery(page) {
        const params = new URLSearchParams();
        if (mlSearch && mlSearch.value) params.append('search', mlSearch.value);
        if (mlCategory && mlCategory.value) params.append('category', mlCategory.value);
        if (mlType && mlType.value) params.append('type', mlType.value);
        params.append('page', page || 1);
        params.append('per_page', 12);
        return params.toString();
    }

    async function loadMedia(page = 1) {
        try {
            const url = apiUrl + '?' + buildQuery(page);
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const json = await res.json();
            if (!json.success) throw new Error('Falha ao carregar mídia');
            renderGrid(json.media || []);
            renderPagination(json.pagination || { current_page: 1, last_page: 1 });
        } catch (err) {
            console.error('Erro ao carregar mídia:', err);
            if (mlGrid) mlGrid.innerHTML = '<div class="col-12"><div class="alert alert-danger">Erro ao carregar a biblioteca de mídia.</div></div>';
        }
    }

    function renderGrid(items) {
        if (!mlGrid) return;
        if (!items.length) {
            mlGrid.innerHTML = '<div class="col-12"><div class="alert alert-warning">Nenhum arquivo encontrado com os filtros informados.</div></div>';
            return;
        }
        mlGrid.innerHTML = items.map(item => {
            const url = item.url || item.public_url;
            const isImage = !!item.is_image;
            const title = item.title || item.original_name || item.file_name;
            return `
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center">
                            ${isImage && url ? `<img src="${url}" alt="${title}" class="img-fluid" style="object-fit: cover;">` : `<div class="p-3 text-center text-muted">${item.icon || '<i class=\"fas fa-file\"></i>'}</div>`}
                        </div>
                        <div class="card-body p-2">
                            <div class="small text-truncate" title="${title}">${title}</div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary btn-sm" data-select-media="${item.id}" data-media-url="${url || ''}" data-media-title="${title}">
                                    <i class="fas fa-check me-1"></i> Selecionar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
        }).join('');

        // Ativar botões de seleção
        mlGrid.querySelectorAll('[data-select-media]').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-select-media');
                const url = this.getAttribute('data-media-url');
                applySelection(id, url);
            });
        });
    }

    function renderPagination(p) {
        if (!mlPagination) return;
        const current = p.current_page || 1;
        const last = p.last_page || 1;
        let html = '';
        const makePage = (page, label, disabled = false, active = false) => {
            return `<li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}"><a class="page-link" href="#" data-page="${page}">${label}</a></li>`;
        };
        html += makePage(Math.max(1, current - 1), '&laquo;', current <= 1);
        for (let i = 1; i <= last; i++) {
            html += makePage(i, i, false, i === current);
        }
        html += makePage(Math.min(last, current + 1), '&raquo;', current >= last);
        mlPagination.innerHTML = html;
        mlPagination.querySelectorAll('[data-page]').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                if (!isNaN(page)) loadMedia(page);
            });
        });
    }

    function applySelection(id, url) {
        const targetId = mlTargetInput ? mlTargetInput.value : null;
        if (!targetId) return;
        const input = document.getElementById(targetId);
        if (input) {
            input.value = id;
            // Atualizar preview
            const preview = document.getElementById('preview_' + targetId.replace(/_id$/, '')) || document.getElementById('preview_' + targetId);
            if (preview) {
                if (url) {
                    // Respeitar tamanhos configurados para cada área
                    if (targetId === 'imagem_topo_id') {
                        const topoAlturaInput = document.getElementById('imagem_topo_altura_px');
                        const topoCentralizar = document.getElementById('centralizar_imagem_topo');
                        const h = topoAlturaInput && parseInt(topoAlturaInput.value) ? parseInt(topoAlturaInput.value) : 120;
                        const center = !!(topoCentralizar && topoCentralizar.checked);
                        preview.innerHTML = `<img src="${url}" alt="Pré-visualização" class="${center ? 'mx-auto d-block' : ''}" style="max-height: ${h}px; max-width: 100%; height: auto; width: auto;">`;
                        preview.classList.toggle('text-center', center);
                    } else if (targetId === 'imagem_descricao_id') {
                        const descAlturaInput = document.getElementById('imagem_descricao_altura_px');
                        const descLarguraInput = document.getElementById('imagem_descricao_largura_px');
                        const descCentralizar = document.getElementById('centralizar_imagem_descricao');
                        const h = descAlturaInput && parseInt(descAlturaInput.value) ? parseInt(descAlturaInput.value) : 120;
                        const w = descLarguraInput && parseInt(descLarguraInput.value) ? parseInt(descLarguraInput.value) : null;
                        const center = !!(descCentralizar && descCentralizar.checked);
                        const style = `height: ${h}px; ${w ? 'width: ' + w + 'px;' : 'max-width: 100%;'} object-fit: contain;`;
                        preview.innerHTML = `<img src="${url}" alt="Pré-visualização" class="${center ? 'mx-auto d-block' : ''}" style="${style}">`;
                        preview.classList.toggle('text-center', center);
                    } else {
                        preview.innerHTML = `<img src="${url}" alt="Pré-visualização" style="max-height: 120px; max-width: 100%;">`;
                    }
                } else {
                    preview.innerHTML = '<span class="text-muted">Imagem selecionada</span>';
                }
            }
        }
        if (mediaModal) mediaModal.hide();
    }

    // Utilitário debounce
    function debounce(fn, delay) {
        let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    // ===== Preview em tempo real dos campos de imagem =====
    const topoAlturaInput = document.getElementById('imagem_topo_altura_px');
    const topoCentralizarInput = document.getElementById('centralizar_imagem_topo');
    const topoPreview = document.getElementById('preview_imagem_topo');
    function updateTopoPreview() {
        if (!topoPreview) return;
        const img = topoPreview.querySelector('img');
        if (img) {
            const h = topoAlturaInput && parseInt(topoAlturaInput.value) ? parseInt(topoAlturaInput.value) : 120;
            img.style.maxHeight = h + 'px';
            img.style.maxWidth = '100%';
            img.style.height = 'auto';
            img.style.width = 'auto';
            const center = !!(topoCentralizarInput && topoCentralizarInput.checked);
            topoPreview.classList.toggle('text-center', center);
            img.classList.toggle('mx-auto', center);
            img.classList.toggle('d-block', center);
            if (!center) { img.classList.remove('mx-auto', 'd-block'); }
        }
    }
    if (topoAlturaInput) topoAlturaInput.addEventListener('input', updateTopoPreview);
    if (topoCentralizarInput) topoCentralizarInput.addEventListener('change', updateTopoPreview);

    const descAlturaInput = document.getElementById('imagem_descricao_altura_px');
    const descLarguraInput = document.getElementById('imagem_descricao_largura_px');
    const descCentralizarInput = document.getElementById('centralizar_imagem_descricao');
    const descPreview = document.getElementById('preview_imagem_descricao');
    function updateDescPreview() {
        if (!descPreview) return;
        const img = descPreview.querySelector('img');
        if (img) {
            const h = descAlturaInput && parseInt(descAlturaInput.value) ? parseInt(descAlturaInput.value) : 120;
            const w = descLarguraInput && parseInt(descLarguraInput.value) ? parseInt(descLarguraInput.value) : null;
            img.style.height = h + 'px';
            if (w) {
                img.style.width = w + 'px';
                img.style.maxWidth = '';
            } else {
                img.style.width = '';
                img.style.maxWidth = '100%';
            }
            img.style.objectFit = 'contain';
            const center = !!(descCentralizarInput && descCentralizarInput.checked);
            descPreview.classList.toggle('text-center', center);
            img.classList.toggle('mx-auto', center);
            img.classList.toggle('d-block', center);
            if (!center) { img.classList.remove('mx-auto', 'd-block'); }
        }
    }
    if (descAlturaInput) descAlturaInput.addEventListener('input', updateDescPreview);
    if (descLarguraInput) descLarguraInput.addEventListener('input', updateDescPreview);
    if (descCentralizarInput) descCentralizarInput.addEventListener('change', updateDescPreview);

    // Inicializar previews ao carregar
    updateTopoPreview();
    updateDescPreview();

    // ===== Contador de caracteres da descrição =====
    const descricaoInput = document.getElementById('descricao');
    const descricaoCounter = document.getElementById('descricao_counter');
    function updateDescricaoCounter() {
        if (!descricaoInput || !descricaoCounter) return;
        const max = 350;
        let val = descricaoInput.value || '';
        if (val.length > max) {
            val = val.substring(0, max);
            descricaoInput.value = val;
        }
        descricaoCounter.textContent = `${val.length}/${max}`;
    }
    if (descricaoInput) {
        descricaoInput.addEventListener('input', updateDescricaoCounter);
        descricaoInput.addEventListener('change', updateDescricaoCounter);
        updateDescricaoCounter();
    }
});
</script>
@endpush
@endsection