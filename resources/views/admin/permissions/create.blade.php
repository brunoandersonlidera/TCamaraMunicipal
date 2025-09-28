@extends('layouts.admin')

@section('title', 'Nova Permissão')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissões</a></li>
            <li class="breadcrumb-item active">Nova Permissão</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Nova Permissão</h1>
            <p class="text-muted mb-0">Criar uma nova permissão no sistema</p>
        </div>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="row">
        <!-- Formulário -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key"></i> Informações da Permissão
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.permissions.store') }}" method="POST" id="permissionForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Nome de Exibição -->
                            <div class="col-md-6 mb-3">
                                <label for="display_name" class="form-label">
                                    Nome de Exibição <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('display_name') is-invalid @enderror" 
                                       id="display_name" 
                                       name="display_name" 
                                       value="{{ old('display_name') }}" 
                                       placeholder="Ex: Visualizar Usuários"
                                       required>
                                @error('display_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Nome amigável da permissão</small>
                            </div>

                            <!-- Nome (Slug) -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    Nome (Slug) <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Ex: users.view"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Identificador único da permissão</small>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Módulo -->
                            <div class="col-md-6 mb-3">
                                <label for="module" class="form-label">
                                    Módulo <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('module') is-invalid @enderror" 
                                        id="module" 
                                        name="module" 
                                        required>
                                    <option value="">Selecione um módulo</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module }}" {{ old('module') == $module ? 'selected' : '' }}>
                                            {{ ucfirst($module) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('module')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Módulo ao qual a permissão pertence</small>
                            </div>

                            <!-- Guard -->
                            <div class="col-md-6 mb-3">
                                <label for="guard_name" class="form-label">Guard</label>
                                <select class="form-control @error('guard_name') is-invalid @enderror" 
                                        id="guard_name" 
                                        name="guard_name">
                                    <option value="web" {{ old('guard_name', 'web') == 'web' ? 'selected' : '' }}>Web</option>
                                    <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>API</option>
                                </select>
                                @error('guard_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Sistema de autenticação</small>
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Descreva o que esta permissão permite fazer">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Descrição detalhada da permissão</small>
                        </div>

                        <div class="row">
                            <!-- Prioridade -->
                            <div class="col-md-4 mb-3">
                                <label for="priority" class="form-label">Prioridade</label>
                                <input type="number" 
                                       class="form-control @error('priority') is-invalid @enderror" 
                                       id="priority" 
                                       name="priority" 
                                       value="{{ old('priority', 0) }}" 
                                       min="0" 
                                       max="100">
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">0 = menor prioridade, 100 = maior prioridade</small>
                            </div>

                            <!-- Status -->
                            <div class="col-md-4 mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-control @error('is_active') is-invalid @enderror" 
                                        id="is_active" 
                                        name="is_active">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inativo</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo -->
                            <div class="col-md-4 mb-3">
                                <label for="is_system" class="form-label">Tipo</label>
                                <select class="form-control @error('is_system') is-invalid @enderror" 
                                        id="is_system" 
                                        name="is_system">
                                    <option value="0" {{ old('is_system', '0') == '0' ? 'selected' : '' }}>Personalizada</option>
                                    <option value="1" {{ old('is_system') == '1' ? 'selected' : '' }}>Sistema</option>
                                </select>
                                @error('is_system')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Permissões do sistema não podem ser excluídas</small>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Criar Permissão
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye"></i> Preview da Permissão
                    </h5>
                </div>
                <div class="card-body">
                    <div id="permissionPreview">
                        <div class="mb-3">
                            <strong>Nome de Exibição:</strong>
                            <div id="preview-display-name" class="text-muted">-</div>
                        </div>
                        <div class="mb-3">
                            <strong>Nome (Slug):</strong>
                            <div id="preview-name" class="text-muted">
                                <code>-</code>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Módulo:</strong>
                            <div id="preview-module" class="text-muted">-</div>
                        </div>
                        <div class="mb-3">
                            <strong>Descrição:</strong>
                            <div id="preview-description" class="text-muted">-</div>
                        </div>
                        <div class="mb-3">
                            <strong>Guard:</strong>
                            <div id="preview-guard" class="text-muted">
                                <code>web</code>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Prioridade:</strong>
                            <div id="preview-priority" class="text-muted">0</div>
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong>
                            <div id="preview-status">
                                <span class="badge badge-success">Ativo</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Tipo:</strong>
                            <div id="preview-type">
                                <span class="badge badge-primary">Personalizada</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dicas -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb"></i> Dicas
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Use nomes descritivos para facilitar a identificação
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Siga o padrão: <code>modulo.acao</code>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Agrupe permissões relacionadas no mesmo módulo
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success"></i>
                            Use prioridades para ordenar permissões importantes
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-gerar nome baseado no nome de exibição
    $('#display_name').on('input', function() {
        const displayName = $(this).val();
        const module = $('#module').val();
        
        if (displayName) {
            // Gerar slug básico
            let slug = displayName
                .toLowerCase()
                .replace(/[^a-z0-9\s]/g, '')
                .replace(/\s+/g, '.');
            
            // Adicionar módulo se selecionado
            if (module) {
                slug = module + '.' + slug;
            }
            
            $('#name').val(slug);
        }
        
        updatePreview();
    });

    // Atualizar nome quando módulo mudar
    $('#module').on('change', function() {
        const displayName = $('#display_name').val();
        if (displayName) {
            $('#display_name').trigger('input');
        }
        updatePreview();
    });

    // Atualizar preview em tempo real
    $('#permissionForm input, #permissionForm select, #permissionForm textarea').on('input change', function() {
        updatePreview();
    });

    function updatePreview() {
        // Nome de exibição
        const displayName = $('#display_name').val() || '-';
        $('#preview-display-name').text(displayName);

        // Nome (slug)
        const name = $('#name').val() || '-';
        $('#preview-name').html(name !== '-' ? `<code>${name}</code>` : '-');

        // Módulo
        const module = $('#module').val() || '-';
        $('#preview-module').text(module !== '-' ? module.charAt(0).toUpperCase() + module.slice(1) : '-');

        // Descrição
        const description = $('#description').val() || '-';
        $('#preview-description').text(description);

        // Guard
        const guard = $('#guard_name').val() || 'web';
        $('#preview-guard').html(`<code>${guard}</code>`);

        // Prioridade
        const priority = $('#priority').val() || '0';
        $('#preview-priority').text(priority);

        // Status
        const isActive = $('#is_active').val();
        if (isActive === '1') {
            $('#preview-status').html('<span class="badge badge-success">Ativo</span>');
        } else {
            $('#preview-status').html('<span class="badge badge-danger">Inativo</span>');
        }

        // Tipo
        const isSystem = $('#is_system').val();
        if (isSystem === '1') {
            $('#preview-type').html('<span class="badge badge-warning"><i class="fas fa-cog"></i> Sistema</span>');
        } else {
            $('#preview-type').html('<span class="badge badge-primary"><i class="fas fa-user"></i> Personalizada</span>');
        }
    }

    // Inicializar preview
    updatePreview();
});
</script>
@endpush

@push('styles')
<style>
.form-label {
    font-weight: 600;
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}

.form-text {
    font-size: 0.875em;
}

#permissionPreview {
    font-size: 0.9em;
}

#permissionPreview strong {
    color: #495057;
}

#permissionPreview .text-muted {
    color: #6c757d !important;
}

.badge {
    font-size: 0.75em;
}

code {
    font-size: 0.875em;
    color: #e83e8c;
    background-color: #f8f9fa;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
}

.list-unstyled li {
    font-size: 0.9em;
}

.card-title {
    font-size: 1.1em;
    font-weight: 600;
}
</style>
@endpush