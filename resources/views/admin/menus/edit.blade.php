@extends('layouts.admin')

@section('page-title', 'Editar Menu')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.menus.index') }}">Menus</a></li>
        <li class="breadcrumb-item active">Editar Menu</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Editar Menu</h1>
            <p class="text-muted">Edite as informações do menu: {{ $menu->titulo }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.menus.show', $menu) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>Visualizar
            </a>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
        @csrf
        @method('PUT')
        
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
                                   id="titulo" name="titulo" value="{{ old('titulo', $menu->titulo) }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $menu->slug) }}">
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
                                <option value="link" {{ old('tipo', $menu->tipo) === 'link' ? 'selected' : '' }}>Link</option>
                                <option value="dropdown" {{ old('tipo', $menu->tipo) === 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                <option value="divider" {{ old('tipo', $menu->tipo) === 'divider' ? 'selected' : '' }}>Divisor</option>
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
                                    <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                           id="url" name="url" value="{{ old('url', $menu->url) }}" placeholder="https://exemplo.com">
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="rota" class="form-label">Rota Interna</label>
                                    <select class="form-select @error('rota') is-invalid @enderror" id="rota" name="rota">
                                        <option value="">Selecione uma rota</option>
                                        @foreach($rotas as $nome => $rota)
                                            <option value="{{ $rota }}" {{ old('rota', $menu->rota) === $rota ? 'selected' : '' }}>
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
                            <label for="icone" class="form-label">Ícone</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('icone') is-invalid @enderror" 
                                       id="icone" name="icone" value="{{ old('icone', $menu->icone) }}" 
                                       placeholder="fas fa-home">
                                <span class="input-group-text">
                                    <i id="icone-preview" class="{{ old('icone', $menu->icone) }}"></i>
                                </span>
                            </div>
                            <div class="form-text">Use classes do Font Awesome (ex: fas fa-home)</div>
                            @error('icone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descrição -->
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" name="descricao" rows="3">{{ old('descricao', $menu->descricao) }}</textarea>
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
                                <option value="header" {{ old('posicao', $menu->posicao) === 'header' ? 'selected' : '' }}>Cabeçalho</option>
                                <option value="footer" {{ old('posicao', $menu->posicao) === 'footer' ? 'selected' : '' }}>Rodapé</option>
                                <option value="ambos" {{ old('posicao', $menu->posicao) === 'ambos' ? 'selected' : '' }}>Ambos</option>
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
                                    @if($menuParent->id !== $menu->id)
                                        <option value="{{ $menuParent->id }}" {{ old('parent_id', $menu->parent_id) == $menuParent->id ? 'selected' : '' }}>
                                            {{ $menuParent->titulo }}
                                        </option>
                                    @endif
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
                                   id="ordem" name="ordem" value="{{ old('ordem', $menu->ordem) }}" min="0">
                            <div class="form-text">Ordem de exibição do menu</div>
                            @error('ordem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Permissão -->
                        <div class="mb-3">
                            <label for="permissao" class="form-label">Permissão</label>
                            <input type="text" class="form-control @error('permissao') is-invalid @enderror" 
                                   id="permissao" name="permissao" value="{{ old('permissao', $menu->permissao) }}" 
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
                                       {{ old('ativo', $menu->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Ativo
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="nova_aba" name="nova_aba" value="1" 
                                       {{ old('nova_aba', $menu->nova_aba) ? 'checked' : '' }}>
                                <label class="form-check-label" for="nova_aba">
                                    Abrir em nova aba
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações Adicionais -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informações</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted">
                                    <strong>Criado em:</strong> {{ $menu->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Atualizado em:</strong> {{ $menu->updated_at->format('d/m/Y H:i') }}<br>
                                    @if($menu->children->count() > 0)
                                        <strong>Submenus:</strong> {{ $menu->children->count() }} item(s)
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Atualizar Menu
                            </button>
                            <a href="{{ route('admin.menus.show', $menu) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>Visualizar
                            </a>
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

    // Gerar slug automaticamente baseado no título (apenas se slug estiver vazio)
    function generateSlug() {
        if (slugInput.value === '' || slugInput.dataset.autoGenerated === 'true') {
            const slug = tituloInput.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                .replace(/[^a-z0-9\s-]/g, '') // Remove caracteres especiais
                .replace(/\s+/g, '-') // Substitui espaços por hífens
                .replace(/-+/g, '-') // Remove hífens duplicados
                .trim('-'); // Remove hífens do início/fim
            
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    }

    // Atualizar preview do ícone
    function updateIconPreview() {
        iconePreview.className = iconeInput.value || 'fas fa-question';
    }

    // Event listeners
    tipoSelect.addEventListener('change', toggleUrlSection);
    tituloInput.addEventListener('input', generateSlug);
    iconeInput.addEventListener('input', updateIconPreview);
    
    // Marcar slug como editado manualmente
    slugInput.addEventListener('input', function() {
        if (this.value !== '') {
            this.dataset.autoGenerated = 'false';
        }
    });

    // Inicializar
    toggleUrlSection();
    updateIconPreview();
});
</script>
@endpush