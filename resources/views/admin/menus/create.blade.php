@extends('layouts.admin')

@section('page-title', 'Novo Menu')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.menus.index') }}">Menus</a></li>
        <li class="breadcrumb-item active">Novo Menu</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Novo Menu</h1>
            <p class="text-muted">Adicione um novo item ao menu do site</p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <form action="{{ route('admin.menus.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <!-- Formulário Principal -->
            <div class="col-lg-8">
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informações Básicas</h5>
                    </div>
                    <div class="card-body">
                        <!-- Título -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}">
                            <div class="form-text">Deixe em branco para gerar automaticamente</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="">Selecione o tipo</option>
                                <option value="link" {{ old('tipo') === 'link' ? 'selected' : '' }}>Link</option>
                                <option value="dropdown" {{ old('tipo') === 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                <option value="divider" {{ old('tipo') === 'divider' ? 'selected' : '' }}>Divisor</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- URL/Rota (condicionalmente visível) -->
                        <div id="url-section" class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="url" class="form-label">URL Externa</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                           id="url" name="url" value="{{ old('url') }}" 
                                           placeholder="https://exemplo.com ou /pagina-interna">
                                    <div class="form-text">
                                        Insira uma URL completa (https://exemplo.com) ou relativa (/leis)
                                    </div>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="rota" class="form-label">Rota Interna</label>
                                    <select class="form-select @error('rota') is-invalid @enderror" id="rota" name="rota">
                                        <option value="">Selecione uma rota</option>
                                        @foreach($rotas as $nome => $rota)
                                            <option value="{{ $rota }}" {{ old('rota') === $rota ? 'selected' : '' }}>
                                                {{ $nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-text">Preencha apenas URL OU Rota, não ambos</div>
                        </div>

                        <!-- Ícone -->
                        <div class="mb-3">
                            <label for="icone" class="form-label">
                                <i class="fas fa-icons me-1"></i>
                                Ícone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i id="icone-preview" class="{{ old('icone', 'fas fa-home') }}"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('icone') is-invalid @enderror" 
                                       id="icone" 
                                       name="icone" 
                                       value="{{ old('icone') }}" 
                                       placeholder="Ex: fas fa-home">
                                <button type="button" class="btn btn-outline-primary" id="btn-selecionar-icone" data-bs-toggle="modal" data-bs-target="#modalSeletorIcones">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Use classes do Font Awesome ou clique no botão para selecionar visualmente
                            </div>
                            @error('icone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descrição -->
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
                            <div class="form-text">Descrição opcional para fins administrativos</div>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configurações -->
            <div class="col-lg-4">
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Configurações</h5>
                    </div>
                    <div class="card-body">
                        <!-- Posição -->
                        <div class="mb-3">
                            <label for="posicao" class="form-label">Posição <span class="text-danger">*</span></label>
                            <select class="form-select @error('posicao') is-invalid @enderror" id="posicao" name="posicao" required>
                                <option value="">Selecione a posição</option>
                                <option value="header" {{ old('posicao') === 'header' ? 'selected' : '' }}>Cabeçalho</option>
                                <option value="footer" {{ old('posicao') === 'footer' ? 'selected' : '' }}>Rodapé</option>
                                <option value="ambos" {{ old('posicao') === 'ambos' ? 'selected' : '' }}>Ambos</option>
                            </select>
                            @error('posicao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Menu Pai -->
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Menu Pai</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">Nenhum (menu principal)</option>
                                @foreach($menusParent as $menuParent)
                                    <option value="{{ $menuParent->id }}" {{ old('parent_id') == $menuParent->id ? 'selected' : '' }}>
                                        {{ $menuParent->titulo }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Deixe vazio para menu principal</div>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ordem -->
                        <div class="mb-3">
                            <label for="ordem" class="form-label">Ordem</label>
                            <input type="number" class="form-control @error('ordem') is-invalid @enderror" 
                                   id="ordem" name="ordem" value="{{ old('ordem') }}" min="0">
                            <div class="form-text">Deixe vazio para adicionar no final</div>
                            @error('ordem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Permissão -->
                        <div class="mb-3">
                            <label for="permissao" class="form-label">Permissão</label>
                            <input type="text" class="form-control @error('permissao') is-invalid @enderror" 
                                   id="permissao" name="permissao" value="{{ old('permissao') }}" 
                                   placeholder="admin, user, etc.">
                            <div class="form-text">Deixe vazio para acesso público</div>
                            @error('permissao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Opções -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" 
                                       {{ old('ativo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Ativo
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="nova_aba" name="nova_aba" value="1" 
                                       {{ old('nova_aba') ? 'checked' : '' }}>
                                <label class="form-check-label" for="nova_aba">
                                    Abrir em nova aba
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Menu
                            </button>
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form></div>
</div>

<!-- Modal Seletor de Ícones -->
<div class="modal fade" id="modalSeletorIcones" tabindex="-1" aria-labelledby="modalSeletorIconesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSeletorIconesLabel">
                    <i class="fas fa-icons me-2"></i>
                    Selecionar Ícone
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="buscar-icone" placeholder="Buscar ícone...">
                </div>
                <div class="row" id="grid-icones">
                    <!-- Ícones serão carregados via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmar-icone" disabled>Confirmar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const urlSection = document.getElementById('url-section');
    const tituloInput = document.getElementById('titulo');
    const slugInput = document.getElementById('slug');
    const iconeInput = document.getElementById('icone');
    const iconePreview = document.getElementById('icone-preview');

    // Controlar visibilidade da seção URL/Rota baseado no tipo
    function toggleUrlSection() {
        if (tipoSelect.value === 'divider') {
            urlSection.style.display = 'none';
        } else {
            urlSection.style.display = 'block';
        }
    }

    // Gerar slug automaticamente baseado no título
    function generateSlug() {
        if (slugInput.value === '') {
            const slug = tituloInput.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                .replace(/[^a-z0-9\s-]/g, '') // Remove caracteres especiais
                .replace(/\s+/g, '-') // Substitui espaços por hífens
                .replace(/-+/g, '-') // Remove hífens duplicados
                .trim('-'); // Remove hífens do início/fim
            
            slugInput.value = slug;
        }
    }

    // Ícones populares do Font Awesome organizados por categoria
    const iconesPopulares = {
        'Geral': [
            'fas fa-home', 'fas fa-user', 'fas fa-users', 'fas fa-cog', 'fas fa-search',
            'fas fa-plus', 'fas fa-edit', 'fas fa-trash', 'fas fa-save', 'fas fa-download',
            'fas fa-upload', 'fas fa-print', 'fas fa-share', 'fas fa-link', 'fas fa-star',
            'fas fa-heart', 'fas fa-eye', 'fas fa-lock', 'fas fa-unlock', 'fas fa-key'
        ],
        'Navegação': [
            'fas fa-arrow-left', 'fas fa-arrow-right', 'fas fa-arrow-up', 'fas fa-arrow-down',
            'fas fa-chevron-left', 'fas fa-chevron-right', 'fas fa-chevron-up', 'fas fa-chevron-down',
            'fas fa-angle-left', 'fas fa-angle-right', 'fas fa-angle-up', 'fas fa-angle-down',
            'fas fa-bars', 'fas fa-times', 'fas fa-menu', 'fas fa-list'
        ],
        'Documentos': [
            'fas fa-file', 'fas fa-file-alt', 'fas fa-file-pdf', 'fas fa-file-word',
            'fas fa-file-excel', 'fas fa-file-powerpoint', 'fas fa-file-image', 'fas fa-file-video',
            'fas fa-file-audio', 'fas fa-file-archive', 'fas fa-folder', 'fas fa-folder-open',
            'fas fa-copy', 'fas fa-clipboard', 'fas fa-book', 'fas fa-newspaper'
        ],
        'Comunicação': [
            'fas fa-envelope', 'fas fa-phone', 'fas fa-mobile-alt', 'fas fa-fax',
            'fas fa-comment', 'fas fa-comments', 'fas fa-chat', 'fas fa-message',
            'fas fa-bell', 'fas fa-bullhorn', 'fas fa-microphone', 'fas fa-volume-up',
            'fas fa-wifi', 'fas fa-signal', 'fas fa-broadcast-tower', 'fas fa-satellite'
        ],
        'Governo': [
            'fas fa-university', 'fas fa-landmark', 'fas fa-gavel', 'fas fa-balance-scale',
            'fas fa-vote-yea', 'fas fa-handshake', 'fas fa-flag', 'fas fa-shield-alt',
            'fas fa-crown', 'fas fa-medal', 'fas fa-award', 'fas fa-certificate',
            'fas fa-id-card', 'fas fa-passport', 'fas fa-stamp', 'fas fa-scroll'
        ],
        'Transparência': [
            'fas fa-eye', 'fas fa-search', 'fas fa-chart-bar', 'fas fa-chart-pie',
            'fas fa-chart-line', 'fas fa-table', 'fas fa-database', 'fas fa-server',
            'fas fa-coins', 'fas fa-dollar-sign', 'fas fa-euro-sign', 'fas fa-money-bill',
            'fas fa-calculator', 'fas fa-receipt', 'fas fa-credit-card', 'fas fa-wallet'
        ]
    };

    let iconeSelecionado = '';

    // Atualizar preview do ícone
    iconeInput.addEventListener('input', function() {
        iconePreview.className = this.value || 'fas fa-home';
    });

    // Função para carregar ícones no modal
    function carregarIcones(filtro = '') {
        const gridIcones = document.getElementById('grid-icones');
        gridIcones.innerHTML = '';

        Object.keys(iconesPopulares).forEach(categoria => {
            const iconesFiltrados = iconesPopulares[categoria].filter(icone => 
                icone.toLowerCase().includes(filtro.toLowerCase())
            );

            if (iconesFiltrados.length > 0) {
                // Adicionar título da categoria
                const tituloCategoria = document.createElement('div');
                tituloCategoria.className = 'col-12 mt-3 mb-2';
                tituloCategoria.innerHTML = `<h6 class="text-muted">${categoria}</h6>`;
                gridIcones.appendChild(tituloCategoria);

                // Adicionar ícones da categoria
                iconesFiltrados.forEach(icone => {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-2 mb-2';
                    
                    const iconeBtn = document.createElement('button');
                    iconeBtn.type = 'button';
                    iconeBtn.className = 'btn btn-outline-secondary w-100 p-2 icone-option';
                    iconeBtn.style.height = '60px';
                    iconeBtn.setAttribute('data-icone', icone);
                    iconeBtn.innerHTML = `<i class="${icone}" style="font-size: 1.5rem;"></i>`;
                    iconeBtn.title = icone;
                    
                    // Evento de clique no ícone
                    iconeBtn.addEventListener('click', function() {
                        // Remove seleção anterior
                        document.querySelectorAll('.icone-option').forEach(btn => {
                            btn.classList.remove('btn-primary');
                            btn.classList.add('btn-outline-secondary');
                        });
                        
                        // Adiciona seleção atual
                        this.classList.remove('btn-outline-secondary');
                        this.classList.add('btn-primary');
                        
                        iconeSelecionado = this.getAttribute('data-icone');
                        document.getElementById('confirmar-icone').disabled = false;
                    });
                    
                    colDiv.appendChild(iconeBtn);
                    gridIcones.appendChild(colDiv);
                });
            }
        });
    }

    // Busca de ícones
    document.getElementById('buscar-icone').addEventListener('input', function() {
        carregarIcones(this.value);
    });

    // Confirmar seleção de ícone
    document.getElementById('confirmar-icone').addEventListener('click', function() {
        if (iconeSelecionado) {
            iconeInput.value = iconeSelecionado;
            iconePreview.className = iconeSelecionado;
            
            // Fechar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalSeletorIcones'));
            modal.hide();
        }
    });

    // Carregar ícones quando o modal for aberto
    document.getElementById('modalSeletorIcones').addEventListener('shown.bs.modal', function() {
        carregarIcones();
        document.getElementById('buscar-icone').value = '';
        iconeSelecionado = '';
        document.getElementById('confirmar-icone').disabled = true;
    });

    // Event listeners
    tipoSelect.addEventListener('change', toggleUrlSection);
    tituloInput.addEventListener('input', generateSlug);

    // Inicializar
    toggleUrlSection();
});
</script>
@endpush