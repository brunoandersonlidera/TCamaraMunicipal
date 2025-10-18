@extends('layouts.admin')

@section('page-title', 'Editar Vereador')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.vereadores.index') }}">Vereadores</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Editar Vereador: {{ $vereador->nome_parlamentar }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.vereadores.show', $vereador) }}" class="btn btn-outline-info">
            <i class="fas fa-eye"></i> Visualizar
        </a>
        <a href="{{ route('admin.vereadores.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<form action="{{ route('admin.vereadores.update', $vereador) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <!-- Dados Básicos -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-user"></i> Dados Básicos</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome', $vereador->nome) }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome_parlamentar" class="form-label">Nome Parlamentar *</label>
                        <input type="text" class="form-control @error('nome_parlamentar') is-invalid @enderror" 
                               id="nome_parlamentar" name="nome_parlamentar" value="{{ old('nome_parlamentar', $vereador->nome_parlamentar) }}" required>
                        @error('nome_parlamentar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="partido" class="form-label">Partido *</label>
                        <input type="text" class="form-control @error('partido') is-invalid @enderror" 
                               id="partido" name="partido" value="{{ old('partido', $vereador->partido) }}" required>
                        @error('partido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $vereador->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                               id="telefone" name="telefone" value="{{ old('telefone', $vereador->telefone) }}">
                        @error('telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" 
                               id="data_nascimento" name="data_nascimento" 
                               value="{{ old('data_nascimento', $vereador->data_nascimento?->format('Y-m-d')) }}">
                        @error('data_nascimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Selecione...</option>
                            <option value="ativo" {{ old('status', $vereador->status) === 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ old('status', $vereador->status) === 'inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="openMediaSelectorBtn">
                                <i class="fas fa-photo-video"></i> Selecionar da Biblioteca
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSelectedMediaBtn">
                                <i class="fas fa-times"></i> Limpar seleção
                            </button>
                        </div>

                        <input type="hidden" name="foto_existing" id="foto_existing_input" value="{{ old('foto_existing') }}">
                        <div id="fotoSelectedPreview" class="mt-2" style="display: none;">
                            <label class="form-label d-block">Pré-visualização da seleção</label>
                            <img id="fotoSelectedPreviewImg" src="" alt="Pré-visualização" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if($vereador->foto)
                        <div class="mb-3">
                            <label class="form-label">Foto Atual</label>
                            <div>
                                <img src="{{ $vereador->foto_url }}" 
                                     alt="{{ $vereador->nome_parlamentar }}" 
                                     class="img-thumbnail" style="max-width: 150px;"
                                     onerror="this.onerror=null;this.src='{{ asset('images/placeholder-vereador.svg') }}';">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dados Profissionais -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-briefcase"></i> Dados Profissionais</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="profissao" class="form-label">Profissão</label>
                        <input type="text" class="form-control @error('profissao') is-invalid @enderror" 
                               id="profissao" name="profissao" value="{{ old('profissao', $vereador->profissao) }}">
                        @error('profissao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="escolaridade" class="form-label">Escolaridade</label>
                        <input type="text" class="form-control @error('escolaridade') is-invalid @enderror" 
                               id="escolaridade" name="escolaridade" value="{{ old('escolaridade', $vereador->escolaridade) }}">
                        @error('escolaridade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <textarea class="form-control @error('endereco') is-invalid @enderror" 
                          id="endereco" name="endereco" rows="2">{{ old('endereco', $vereador->endereco) }}</textarea>
                @error('endereco')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="biografia" class="form-label">Biografia</label>
                <textarea class="form-control @error('biografia') is-invalid @enderror" 
                          id="biografia" name="biografia" rows="4">{{ old('biografia', $vereador->biografia) }}</textarea>
                @error('biografia')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Mandato -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-calendar"></i> Informações do Mandato</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="inicio_mandato" class="form-label">Início do Mandato</label>
                        <input type="date" class="form-control @error('inicio_mandato') is-invalid @enderror" 
                               id="inicio_mandato" name="inicio_mandato" 
                               value="{{ old('inicio_mandato', $vereador->inicio_mandato?->format('Y-m-d')) }}">
                        @error('inicio_mandato')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="fim_mandato" class="form-label">Fim do Mandato</label>
                        <input type="date" class="form-control @error('fim_mandato') is-invalid @enderror" 
                               id="fim_mandato" name="fim_mandato" 
                               value="{{ old('fim_mandato', $vereador->fim_mandato?->format('Y-m-d')) }}">
                        @error('fim_mandato')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="legislatura" class="form-label">Legislatura</label>
                        <input type="text" class="form-control @error('legislatura') is-invalid @enderror" 
                               id="legislatura" name="legislatura" value="{{ old('legislatura', $vereador->legislatura) }}" 
                               placeholder="Ex: 2021-2024">
                        @error('legislatura')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="comissoes" class="form-label">Comissões</label>
                <div id="comissoes-container">
                    @php
                        $comissoes = old('comissoes');
                        if (!$comissoes) {
                            $comissoes = $vereador->comissoes;
                            // Garantir que seja sempre um array
                            if (is_string($comissoes)) {
                                $comissoes = json_decode($comissoes, true) ?? [];
                            } elseif (!is_array($comissoes)) {
                                $comissoes = [];
                            }
                        }
                    @endphp
                    @if($comissoes && count($comissoes) > 0)
                        @foreach($comissoes as $comissao)
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="comissoes[]" value="{{ $comissao }}" placeholder="Nome da comissão">
                                <button type="button" class="btn btn-outline-danger remove-comissao-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="comissoes[]" placeholder="Nome da comissão">
                            <button type="button" class="btn btn-outline-success add-comissao-btn">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary add-comissao-btn">
                    <i class="fas fa-plus"></i> Adicionar Comissão
                </button>
            </div>
            
            <!-- Presidência e Vice-Presidência -->
            <div class="admin-card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-gavel"></i> Presidência e Vice-Presidência</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="hidden" name="presidente" value="0">
                                <input class="form-check-input" type="checkbox" value="1" id="presidente" name="presidente" 
                                       {{ old('presidente', $vereador->presidente) ? 'checked' : '' }}>
                                <label class="form-check-label" for="presidente">Presidente da Câmara</label>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="presidente_inicio" class="form-label">Início (Presidente)</label>
                                    <input type="date" class="form-control @error('presidente_inicio') is-invalid @enderror" 
                                           id="presidente_inicio" name="presidente_inicio" 
                                           value="{{ old('presidente_inicio', $vereador->presidente_inicio?->format('Y-m-d')) }}">
                                    @error('presidente_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="presidente_fim" class="form-label">Fim (Presidente)</label>
                                    <input type="date" class="form-control @error('presidente_fim') is-invalid @enderror" 
                                           id="presidente_fim" name="presidente_fim" 
                                           value="{{ old('presidente_fim', $vereador->presidente_fim?->format('Y-m-d')) }}">
                                    @error('presidente_fim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="hidden" name="vice_presidente" value="0">
                                <input class="form-check-input" type="checkbox" value="1" id="vice_presidente" name="vice_presidente" 
                                       {{ old('vice_presidente', $vereador->vice_presidente) ? 'checked' : '' }}>
                                <label class="form-check-label" for="vice_presidente">Vice-Presidente</label>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="vice_inicio" class="form-label">Início (Vice)</label>
                                    <input type="date" class="form-control @error('vice_inicio') is-invalid @enderror" 
                                           id="vice_inicio" name="vice_inicio" 
                                           value="{{ old('vice_inicio', $vereador->vice_inicio?->format('Y-m-d')) }}">
                                    @error('vice_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="vice_fim" class="form-label">Fim (Vice)</label>
                                    <input type="date" class="form-control @error('vice_fim') is-invalid @enderror" 
                                           id="vice_fim" name="vice_fim" 
                                           value="{{ old('vice_fim', $vereador->vice_fim?->format('Y-m-d')) }}">
                                    @error('vice_fim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-text">Ao marcar um novo Presidente/Vice, o sistema encerrará automaticamente o mandato anterior ativo.</div>
                </div>
            </div>
        </div>
    </div>

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
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const openBtn = document.getElementById('openMediaSelectorBtn');
        const clearBtn = document.getElementById('clearSelectedMediaBtn');
        const hiddenInput = document.getElementById('foto_existing_input');
        const fileInput = document.getElementById('foto');
        const preview = document.getElementById('fotoSelectedPreview');
        const previewImg = document.getElementById('fotoSelectedPreviewImg');

        let modalInstance;

        function ensureModal() {
            const modalEl = document.getElementById('mediaSelectorModal');
            modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
        }

        function loadMediaSelector() {
            const container = document.getElementById('mediaSelectorContainer');
            container.innerHTML = '<div class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin"></i> Carregando mídia...</div>';
            // Carregar já filtrado por categoria "foto" para facilitar seleção de fotos de vereadores
            fetch(`{{ route('admin.media.select') }}?category=foto`)
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
                    document.querySelectorAll('#mediaSelectorModal .media-select-item').forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    const selectBtn = document.querySelector('#selectMediaBtn');
                    if (selectBtn) selectBtn.disabled = false;
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

        openBtn?.addEventListener('click', function() {
            ensureModal();
            loadMediaSelector();
            modalInstance.show();
        });

        clearBtn?.addEventListener('click', function() {
            hiddenInput.value = '';
            preview.style.display = 'none';
            previewImg.src = '';
        });

        document.getElementById('selectMediaBtn')?.addEventListener('click', function() {
            const selected = document.querySelector('#mediaSelectorModal .media-select-item.selected');
            if (!selected) return;
            const mediaId = selected.getAttribute('data-id');
            const url = selected.getAttribute('data-url');
            if (mediaId) {
                // Armazenar apenas o ID da mídia (mais profissional)
                hiddenInput.value = 'media:' + mediaId;
                // Usar a URL apenas para a pré-visualização
                previewImg.src = url;
                preview.style.display = 'block';
                fileInput.value = '';
            }
            modalInstance.hide();
        });
    });
    </script>
    @endpush
    <!-- Redes Sociais -->
    @php
        $redes_sociais_edit = $vereador->redes_sociais;
        // Garantir que seja sempre um array
        if (is_string($redes_sociais_edit)) {
            $redes_sociais_edit = json_decode($redes_sociais_edit, true) ?? [];
        } elseif (!is_array($redes_sociais_edit)) {
            $redes_sociais_edit = [];
        }
    @endphp
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-share-alt"></i> Redes Sociais</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" class="form-control @error('redes_sociais.facebook') is-invalid @enderror" 
                               id="facebook" name="redes_sociais[facebook]" 
                               value="{{ old('redes_sociais.facebook', $redes_sociais_edit['facebook'] ?? '') }}" 
                               placeholder="https://facebook.com/usuario ou @usuario">
                        @error('redes_sociais.facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" class="form-control @error('redes_sociais.instagram') is-invalid @enderror" 
                               id="instagram" name="redes_sociais[instagram]" 
                               value="{{ old('redes_sociais.instagram', $redes_sociais_edit['instagram'] ?? '') }}" 
                               placeholder="https://instagram.com/usuario ou @usuario">
                        @error('redes_sociais.instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" class="form-control @error('redes_sociais.twitter') is-invalid @enderror" 
                               id="twitter" name="redes_sociais[twitter]" 
                               value="{{ old('redes_sociais.twitter', $redes_sociais_edit['twitter'] ?? '') }}" 
                               placeholder="https://twitter.com/usuario ou @usuario">
                        @error('redes_sociais.twitter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="linkedin" class="form-label">LinkedIn</label>
                        <input type="text" class="form-control @error('redes_sociais.linkedin') is-invalid @enderror" 
                               id="linkedin" name="redes_sociais[linkedin]" 
                               value="{{ old('redes_sociais.linkedin', $redes_sociais_edit['linkedin'] ?? '') }}" 
                               placeholder="https://linkedin.com/in/usuario ou nome-usuario">
                        @error('redes_sociais.linkedin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Observações -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Observações</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações Gerais</label>
                <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                          id="observacoes" name="observacoes" rows="3">{{ old('observacoes', $vereador->observacoes) }}</textarea>
                @error('observacoes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Botões -->
    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('admin.vereadores.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Atualizar Vereador
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('js/media-library.js') }}"></script>
<script src="{{ asset('js/vereadores.js') }}"></script>
@endpush