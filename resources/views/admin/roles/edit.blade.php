@extends('layouts.admin')

@section('page-title', 'Editar Role')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Editar: {{ $role->display_name }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Editar Role: {{ $role->display_name }}</h1>
            <p class="text-muted">Modifique as informações e permissões do role</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>Visualizar
            </a>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST" id="roleForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Informações Básicas -->
            <div class="col-lg-8">
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informações Básicas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome do Role <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $role->name) }}" 
                                           placeholder="ex: editor-conteudo"
                                           {{ $role->is_system ? 'readonly' : '' }}>
                                    <div class="form-text">Nome único usado internamente (sem espaços, apenas letras, números e hífens)</div>
                                    @if($role->is_system)
                                        <div class="form-text text-warning">
                                            <i class="fas fa-lock me-1"></i>Roles do sistema não podem ter o nome alterado
                                        </div>
                                    @endif
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="display_name" class="form-label">Nome de Exibição <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                           id="display_name" name="display_name" value="{{ old('display_name', $role->display_name) }}" 
                                           placeholder="ex: Editor de Conteúdo">
                                    <div class="form-text">Nome amigável exibido na interface</div>
                                    @error('display_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Descreva as responsabilidades deste role...">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Prioridade</label>
                                    <input type="number" class="form-control @error('priority') is-invalid @enderror" 
                                           id="priority" name="priority" value="{{ old('priority', $role->priority) }}" 
                                           min="1" max="100">
                                    <div class="form-text">Ordem de exibição (1 = maior prioridade)</div>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="guard_name" class="form-label">Guard</label>
                                    <select class="form-select @error('guard_name') is-invalid @enderror" 
                                            id="guard_name" name="guard_name"
                                            {{ $role->is_system ? 'disabled' : '' }}>
                                        <option value="web" {{ old('guard_name', $role->guard_name) === 'web' ? 'selected' : '' }}>Web</option>
                                        <option value="api" {{ old('guard_name', $role->guard_name) === 'api' ? 'selected' : '' }}>API</option>
                                    </select>
                                    @if($role->is_system)
                                        <input type="hidden" name="guard_name" value="{{ $role->guard_name }}">
                                        <div class="form-text text-warning">
                                            <i class="fas fa-lock me-1"></i>Roles do sistema não podem ter o guard alterado
                                        </div>
                                    @endif
                                    @error('guard_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissões -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-key me-2"></i>Permissões
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllPermissions">
                                <label class="form-check-label fw-bold" for="selectAllPermissions">
                                    Selecionar Todas as Permissões
                                </label>
                            </div>
                        </div>

                        @if($permissionsByModule->count() > 0)
                            <div class="accordion" id="permissionsAccordion">
                                @foreach($permissionsByModule as $module => $permissions)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ Str::studly($module) }}">
                                        <button class="accordion-button collapsed" type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse{{ Str::studly($module) }}" 
                                                aria-expanded="false">
                                            <i class="fas fa-folder me-2"></i>
                                            {{ ucfirst($module) }}
                                            <span class="badge bg-secondary ms-2">{{ $permissions->count() }}</span>
                                            <span class="badge bg-primary ms-1" id="selected-{{ Str::studly($module) }}">0</span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ Str::studly($module) }}" 
                                         class="accordion-collapse collapse" 
                                         data-bs-parent="#permissionsAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                <div class="col-md-6 col-lg-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox" 
                                                               type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $permission->id }}" 
                                                               id="permission{{ $permission->id }}"
                                                               data-module="{{ Str::studly($module) }}"
                                                               {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                                            <strong>{{ $permission->display_name }}</strong>
                                                            @if($permission->description)
                                                                <br><small class="text-muted">{{ $permission->description }}</small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Nenhuma permissão encontrada. <a href="{{ route('admin.permissions.index') }}">Criar permissões primeiro</a>.
                            </div>
                        @endif

                        @error('permissions')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cog me-2"></i>Configurações
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Role Ativo
                                </label>
                            </div>
                            <div class="form-text">Roles inativos não podem ser atribuídos a usuários</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_system" name="is_system" value="1" 
                                       {{ old('is_system', $role->is_system) ? 'checked' : '' }}
                                       {{ $role->is_system ? 'disabled' : '' }}>
                                <label class="form-check-label" for="is_system">
                                    Role do Sistema
                                </label>
                            </div>
                            @if($role->is_system)
                                <input type="hidden" name="is_system" value="1">
                                <div class="form-text text-warning">
                                    <i class="fas fa-lock me-1"></i>Esta configuração não pode ser alterada
                                </div>
                            @else
                                <div class="form-text">Roles do sistema não podem ser excluídos</div>
                            @endif
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Alterações
                            </button>
                            <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>Visualizar
                            </a>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Estatísticas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-item">
                                    <h4 class="text-primary">{{ $role->users()->count() }}</h4>
                                    <small class="text-muted">Usuários</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <h4 class="text-success">{{ $role->permissions()->count() }}</h4>
                                    <small class="text-muted">Permissões</small>
                                </div>
                            </div>
                        </div>
                        
                        @if($role->users()->count() > 0)
                            <hr>
                            <h6>Usuários com este role:</h6>
                            <div class="user-list">
                                @foreach($role->users()->limit(5)->get() as $user)
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                             class="rounded-circle me-2" width="24" height="24">
                                        <small>{{ $user->name }}</small>
                                    </div>
                                @endforeach
                                @if($role->users()->count() > 5)
                                    <small class="text-muted">e mais {{ $role->users()->count() - 5 }} usuários...</small>
                                @endif
                            </div>
                        @endif
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
    // Selecionar todas as permissões
    document.getElementById('selectAllPermissions').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateModuleCounts();
    });

    // Atualizar contadores por módulo
    function updateModuleCounts() {
        const modules = {};
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            const module = checkbox.dataset.module;
            if (!modules[module]) {
                modules[module] = { total: 0, selected: 0 };
            }
            modules[module].total++;
            if (checkbox.checked) {
                modules[module].selected++;
            }
        });

        Object.keys(modules).forEach(module => {
            const badge = document.getElementById(`selected-${module}`);
            if (badge) {
                badge.textContent = modules[module].selected;
                badge.className = modules[module].selected > 0 ? 'badge bg-success ms-1' : 'badge bg-secondary ms-1';
            }
        });
    }

    // Atualizar contadores quando permissões mudarem
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateModuleCounts);
    });

    // Inicializar contadores
    updateModuleCounts();
});
</script>
@endpush