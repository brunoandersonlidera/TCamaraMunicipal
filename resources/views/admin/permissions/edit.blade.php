@extends('layouts.admin')

@section('title', 'Editar Permissão')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissões</a></li>
            <li class="breadcrumb-item active">Editar: {{ $permission->display_name }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Editar Permissão</h1>
            <p class="text-muted mb-0">Modificar permissão: {{ $permission->display_name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.permissions.show', $permission) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> Visualizar
            </a>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
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
                    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST" id="permissionForm">
                        @csrf
                        @method('PUT')
                        
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
                                       value="{{ old('display_name', $permission->display_name) }}" 
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
                                       value="{{ old('name', $permission->name) }}" 
                                       placeholder="Ex: users.view"
                                       {{ $permission->is_system ? 'readonly' : '' }}
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Identificador único da permissão
                                    @if($permission->is_system)
                                        <span class="text-warning">(Não editável - Permissão do sistema)</span>
                                    @endif
                                </small>
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
                                        {{ $permission->is_system ? 'disabled' : '' }}
                                        required>
                                    <option value="">Selecione um módulo</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module }}" 
                                                {{ old('module', $permission->module) == $module ? 'selected' : '' }}>
                                            {{ ucfirst($module) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($permission->is_system)
                                    <input type="hidden" name="module" value="{{ $permission->module }}">
                                @endif
                                @error('module')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Módulo ao qual a permissão pertence
                                    @if($permission->is_system)
                                        <span class="text-warning">(Não editável - Permissão do sistema)</span>
                                    @endif
                                </small>
                            </div>

                            <!-- Guard -->
                            <div class="col-md-6 mb-3">
                                <label for="guard_name" class="form-label">Guard</label>
                                <select class="form-control @error('guard_name') is-invalid @enderror" 
                                        id="guard_name" 
                                        name="guard_name"
                                        {{ $permission->is_system ? 'disabled' : '' }}>
                                    <option value="web" {{ old('guard_name', $permission->guard_name) == 'web' ? 'selected' : '' }}>Web</option>
                                    <option value="api" {{ old('guard_name', $permission->guard_name) == 'api' ? 'selected' : '' }}>API</option>
                                </select>
                                @if($permission->is_system)
                                    <input type="hidden" name="guard_name" value="{{ $permission->guard_name }}">
                                @endif
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
                                      placeholder="Descreva o que esta permissão permite fazer">{{ old('description', $permission->description) }}</textarea>
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
                                       value="{{ old('priority', $permission->priority) }}" 
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
                                    <option value="1" {{ old('is_active', $permission->is_active) == '1' ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ old('is_active', $permission->is_active) == '0' ? 'selected' : '' }}>Inativo</option>
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
                                        name="is_system"
                                        disabled>
                                    <option value="0" {{ $permission->is_system == '0' ? 'selected' : '' }}>Personalizada</option>
                                    <option value="1" {{ $permission->is_system == '1' ? 'selected' : '' }}>Sistema</option>
                                </select>
                                <input type="hidden" name="is_system" value="{{ $permission->is_system }}">
                                @error('is_system')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Tipo não pode ser alterado após criação</small>
                            </div>
                        </div>

                        <!-- Informações de Sistema -->
                        @if($permission->is_system)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Permissão do Sistema:</strong> 
                            Alguns campos não podem ser editados pois esta é uma permissão crítica do sistema.
                        </div>
                        @endif

                        <!-- Botões -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview e Informações -->
        <div class="col-lg-4">
            <!-- Preview -->
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
                            <div id="preview-display-name" class="text-muted">{{ $permission->display_name }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Nome (Slug):</strong>
                            <div id="preview-name" class="text-muted">
                                <code>{{ $permission->name }}</code>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Módulo:</strong>
                            <div id="preview-module" class="text-muted">{{ ucfirst($permission->module) }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Descrição:</strong>
                            <div id="preview-description" class="text-muted">{{ $permission->description ?: '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Guard:</strong>
                            <div id="preview-guard" class="text-muted">
                                <code>{{ $permission->guard_name }}</code>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Prioridade:</strong>
                            <div id="preview-priority" class="text-muted">{{ $permission->priority }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong>
                            <div id="preview-status">
                                @if($permission->is_active)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-danger">Inativo</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Tipo:</strong>
                            <div id="preview-type">
                                @if($permission->is_system)
                                    <span class="badge badge-warning"><i class="fas fa-cog"></i> Sistema</span>
                                @else
                                    <span class="badge badge-primary"><i class="fas fa-user"></i> Personalizada</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar"></i> Estatísticas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <h3 class="text-primary mb-1">{{ $permission->roles->count() }}</h3>
                            <p class="text-muted mb-0">Roles com esta permissão</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-6"><strong>Criado em:</strong></div>
                        <div class="col-sm-6">{{ $permission->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6"><strong>Atualizado em:</strong></div>
                        <div class="col-sm-6">{{ $permission->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Roles Associados -->
            @if($permission->roles->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users-cog"></i> Roles Associados
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($permission->roles as $role)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>{{ $role->display_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $role->name }}</small>
                        </div>
                        <div>
                            @if($role->is_active)
                                <span class="badge badge-success">Ativo</span>
                            @else
                                <span class="badge badge-danger">Inativo</span>
                            @endif
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr class="my-2">
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Atualizar preview em tempo real (apenas para campos editáveis)
    $('#permissionForm input:not([readonly]):not([type="hidden"]), #permissionForm select:not([disabled]), #permissionForm textarea').on('input change', function() {
        updatePreview();
    });

    function updatePreview() {
        // Nome de exibição
        const displayName = $('#display_name').val() || '-';
        $('#preview-display-name').text(displayName);

        // Descrição
        const description = $('#description').val() || '-';
        $('#preview-description').text(description);

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
    }
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

.card-title {
    font-size: 1.1em;
    font-weight: 600;
}

.alert {
    border-radius: 0.5rem;
}

input[readonly], select[disabled] {
    background-color: #f8f9fa;
    opacity: 0.8;
}
</style>
@endpush