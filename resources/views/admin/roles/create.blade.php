@extends('layouts.admin')

@section('page-title', 'Criar Role')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Criar</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Criar Novo Role</h1>
            <p class="text-muted">Defina um novo tipo de usuário e suas permissões</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST" id="roleForm">
        @csrf
        
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
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="ex: editor-conteudo">
                                    <div class="form-text">Nome único usado internamente (sem espaços, apenas letras, números e hífens)</div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="display_name" class="form-label">Nome de Exibição <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                           id="display_name" name="display_name" value="{{ old('display_name') }}" 
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
                                      placeholder="Descreva as responsabilidades deste role...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Prioridade</label>
                                    <input type="number" class="form-control @error('priority') is-invalid @enderror" 
                                           id="priority" name="priority" value="{{ old('priority', 1) }}" 
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
                                            id="guard_name" name="guard_name">
                                        <option value="web" {{ old('guard_name', 'web') === 'web' ? 'selected' : '' }}>Web</option>
                                        <option value="api" {{ old('guard_name') === 'api' ? 'selected' : '' }}>API</option>
                                    </select>
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
                                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
                                       {{ old('is_active', true) ? 'checked' : '' }}>
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
                                       {{ old('is_system', false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_system">
                                    Role do Sistema
                                </label>
                            </div>
                            <div class="form-text">Roles do sistema não podem ser excluídos</div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Criar Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-eye me-2"></i>Preview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="rolePreview">
                            <p class="text-muted">Preencha os campos para ver o preview</p>
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
    // Auto-gerar nome baseado no display_name
    const displayNameInput = document.getElementById('display_name');
    const nameInput = document.getElementById('name');
    
    displayNameInput.addEventListener('input', function() {
        if (!nameInput.dataset.userModified) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            nameInput.value = slug;
        }
        updatePreview();
    });
    
    nameInput.addEventListener('input', function() {
        this.dataset.userModified = 'true';
        updatePreview();
    });

    // Selecionar todas as permissões
    document.getElementById('selectAllPermissions').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Atualizar preview
    function updatePreview() {
        const name = nameInput.value;
        const displayName = displayNameInput.value;
        const description = document.getElementById('description').value;
        const isActive = document.getElementById('is_active').checked;
        const isSystem = document.getElementById('is_system').checked;
        
        const selectedPermissions = document.querySelectorAll('.permission-checkbox:checked').length;
        
        let preview = '';
        if (displayName) {
            preview += `<strong>${displayName}</strong><br>`;
        }
        if (name) {
            preview += `<small class="text-muted">Nome: ${name}</small><br>`;
        }
        if (description) {
            preview += `<p class="mt-2">${description}</p>`;
        }
        
        preview += `<div class="mt-2">`;
        preview += `<span class="badge bg-${isActive ? 'success' : 'secondary'}">${isActive ? 'Ativo' : 'Inativo'}</span> `;
        preview += `<span class="badge bg-${isSystem ? 'warning' : 'info'}">${isSystem ? 'Sistema' : 'Personalizado'}</span><br>`;
        preview += `<small class="text-muted mt-1 d-block">${selectedPermissions} permissões selecionadas</small>`;
        preview += `</div>`;
        
        document.getElementById('rolePreview').innerHTML = preview || '<p class="text-muted">Preencha os campos para ver o preview</p>';
    }

    // Atualizar preview quando campos mudarem
    ['description', 'is_active', 'is_system'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
        document.getElementById(id).addEventListener('change', updatePreview);
    });

    // Atualizar preview quando permissões mudarem
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updatePreview);
    });
});
</script>
@endpush