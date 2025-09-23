@extends('layouts.admin')

@section('title', isset($acessoRapido) ? 'Editar Acesso Rápido' : 'Novo Acesso Rápido')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-rocket me-2"></i>
                        {{ isset($acessoRapido) ? 'Editar Acesso Rápido' : 'Novo Acesso Rápido' }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.acesso-rapido.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>
                            Voltar
                        </a>
                    </div>
                </div>

                <form action="{{ isset($acessoRapido) ? route('admin.acesso-rapido.update', $acessoRapido) : route('admin.acesso-rapido.store') }}" 
                      method="POST">
                    @csrf
                    @if(isset($acessoRapido))
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="row">
                            <!-- Coluna Esquerda -->
                            <div class="col-md-6">
                                <!-- Nome -->
                                <div class="mb-3">
                                    <label for="nome" class="form-label">
                                        <i class="fas fa-tag me-1"></i>
                                        Nome do Acesso <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" 
                                           name="nome" 
                                           value="{{ old('nome', $acessoRapido->nome ?? '') }}" 
                                           placeholder="Ex: Portal da Transparência"
                                           required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Descrição -->
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>
                                        Descrição
                                    </label>
                                    <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                              id="descricao" 
                                              name="descricao" 
                                              rows="3"
                                              placeholder="Descrição opcional do acesso">{{ old('descricao', $acessoRapido->descricao ?? '') }}</textarea>
                                    @error('descricao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- URL -->
                                <div class="mb-3">
                                    <label for="url" class="form-label">
                                        <i class="fas fa-link me-1"></i>
                                        URL <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('url') is-invalid @enderror" 
                                           id="url" 
                                           name="url" 
                                           value="{{ old('url', $acessoRapido->url ?? '') }}" 
                                           placeholder="Ex: /transparencia ou https://exemplo.com"
                                           required>
                                    <div class="form-text">
                                        Use URLs internas (/transparencia) ou externas (https://exemplo.com)
                                    </div>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ícone -->
                                <div class="mb-3">
                                    <label for="icone" class="form-label">
                                        <i class="fas fa-icons me-1"></i>
                                        Ícone <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i id="icone-preview" class="{{ old('icone', $acessoRapido->icone ?? 'fas fa-link') }}"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control @error('icone') is-invalid @enderror" 
                                               id="icone" 
                                               name="icone" 
                                               value="{{ old('icone', $acessoRapido->icone ?? 'fas fa-link') }}" 
                                               placeholder="Ex: fas fa-eye"
                                               required>
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
                            </div>

                            <!-- Coluna Direita -->
                            <div class="col-md-6">
                                <!-- Cores -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cor_botao" class="form-label">
                                                <i class="fas fa-palette me-1"></i>
                                                Cor do Botão <span class="text-danger">*</span>
                                            </label>
                                            <input type="color" 
                                                   class="form-control form-control-color @error('cor_botao') is-invalid @enderror" 
                                                   id="cor_botao" 
                                                   name="cor_botao" 
                                                   value="{{ old('cor_botao', $acessoRapido->cor_botao ?? '#007bff') }}"
                                                   required>
                                            @error('cor_botao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cor_fonte" class="form-label">
                                                <i class="fas fa-font me-1"></i>
                                                Cor da Fonte <span class="text-danger">*</span>
                                            </label>
                                            <input type="color" 
                                                   class="form-control form-control-color @error('cor_fonte') is-invalid @enderror" 
                                                   id="cor_fonte" 
                                                   name="cor_fonte" 
                                                   value="{{ old('cor_fonte', $acessoRapido->cor_fonte ?? '#ffffff') }}"
                                                   required>
                                            @error('cor_fonte')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Ordem -->
                                <div class="mb-3">
                                    <label for="ordem" class="form-label">
                                        <i class="fas fa-sort-numeric-up me-1"></i>
                                        Ordem de Exibição <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('ordem') is-invalid @enderror" 
                                           id="ordem" 
                                           name="ordem" 
                                           value="{{ old('ordem', $acessoRapido->ordem ?? 0) }}" 
                                           min="0"
                                           required>
                                    <div class="form-text">
                                        Menor número aparece primeiro
                                    </div>
                                    @error('ordem')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Switches -->
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="ativo" 
                                               name="ativo" 
                                               value="1"
                                               {{ old('ativo', $acessoRapido->ativo ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ativo">
                                            <i class="fas fa-eye me-1"></i>
                                            Ativo (visível na página inicial)
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="abrir_nova_aba" 
                                               name="abrir_nova_aba" 
                                               value="1"
                                               {{ old('abrir_nova_aba', $acessoRapido->abrir_nova_aba ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="abrir_nova_aba">
                                            <i class="fas fa-external-link-alt me-1"></i>
                                            Abrir em nova aba
                                        </label>
                                    </div>
                                </div>

                                <!-- Preview -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-eye me-1"></i>
                                        Preview do Botão
                                    </label>
                                    <div class="border rounded p-3 bg-light">
                                        <div id="button-preview" class="d-inline-block">
                                            <!-- Preview será gerado via JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.acesso-rapido.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                {{ isset($acessoRapido) ? 'Atualizar' : 'Salvar' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    const iconeInput = document.getElementById('icone');
    const iconePreview = document.getElementById('icone-preview');
    const corBotaoInput = document.getElementById('cor_botao');
    const corFonteInput = document.getElementById('cor_fonte');
    const nomeInput = document.getElementById('nome');
    const buttonPreview = document.getElementById('button-preview');

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
        iconePreview.className = this.value || 'fas fa-link';
        updateButtonPreview();
    });

    // Atualizar preview do botão quando cores mudarem
    corBotaoInput.addEventListener('input', updateButtonPreview);
    corFonteInput.addEventListener('input', updateButtonPreview);
    nomeInput.addEventListener('input', updateButtonPreview);

    // Função para atualizar o preview do botão
    function updateButtonPreview() {
        const nome = nomeInput.value || 'Nome do Acesso';
        const icone = iconeInput.value || 'fas fa-link';
        const corBotao = corBotaoInput.value;
        const corFonte = corFonteInput.value;

        buttonPreview.innerHTML = `
            <div style="max-width: 150px;">
                <a href="#" 
                   class="btn d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                   style="background-color: ${corBotao}; color: ${corFonte}; border: 2px solid ${corBotao}; border-radius: 12px; min-height: 120px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <i class="${icone} mb-2" style="font-size: 2.5rem;"></i>
                    <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">${nome}</span>
                </a>
            </div>
        `;
    }

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
            updateButtonPreview();
            
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

    // Inicializar preview
    updateButtonPreview();
});
</script>
@endpush