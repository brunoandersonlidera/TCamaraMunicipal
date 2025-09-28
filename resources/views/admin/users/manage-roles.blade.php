@extends('layouts.admin')

@section('title', 'Gerenciar Roles - ' . $user->name)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuários</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></li>
            <li class="breadcrumb-item active">Gerenciar Roles</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gerenciar Roles</h1>
            <p class="text-muted mb-0">Atribuir e remover roles do usuário {{ $user->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informações do Usuário -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i> Informações do Usuário
                    </h5>
                </div>
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle mb-3" 
                             width="80" height="80">
                    @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 80px; height: 80px; font-size: 32px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    
                    @if($user->cargo)
                        <p class="text-muted mb-2">
                            <i class="fas fa-briefcase"></i> {{ $user->cargo }}
                        </p>
                    @endif
                    
                    @if($user->setor)
                        <p class="text-muted mb-2">
                            <i class="fas fa-building"></i> {{ $user->setor }}
                        </p>
                    @endif
                    
                    <div class="mt-3">
                        @if($user->is_active)
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i> Ativo
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times"></i> Inativo
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Roles Atuais -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users-cog"></i> Roles Atuais
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ $role->display_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $role->description }}</small>
                                </div>
                                @if($role->is_system)
                                    <span class="badge badge-warning">Sistema</span>
                                @else
                                    <span class="badge badge-primary">Personalizado</span>
                                @endif
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    @else
                        <p class="text-muted text-center mb-0">
                            <i class="fas fa-info-circle"></i> Nenhum role atribuído
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulário de Roles -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Atribuir Roles
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update-roles', $user) }}" method="POST" id="rolesForm">
                        @csrf
                        @method('PUT')
                        
                        @if($roles->count() > 0)
                            <div class="row">
                                @foreach($roles->groupBy(function($role) { return $role->is_system ? 'Sistema' : 'Personalizado'; }) as $type => $groupedRoles)
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-3">
                                            @if($type === 'Sistema')
                                                <i class="fas fa-cog"></i> Roles do Sistema
                                            @else
                                                <i class="fas fa-user"></i> Roles Personalizados
                                            @endif
                                        </h6>
                                        
                                        @foreach($groupedRoles as $role)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input role-checkbox" 
                                                       type="checkbox" 
                                                       name="roles[]" 
                                                       value="{{ $role->id }}" 
                                                       id="role_{{ $role->id }}"
                                                       {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                                       data-role-name="{{ $role->name }}"
                                                       data-permissions-count="{{ $role->permissions->count() }}">
                                                <label class="form-check-label w-100" for="role_{{ $role->id }}">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <strong>{{ $role->display_name }}</strong>
                                                            @if($role->description)
                                                                <br>
                                                                <small class="text-muted">{{ $role->description }}</small>
                                                            @endif
                                                            <br>
                                                            <small class="text-info">
                                                                <i class="fas fa-key"></i> {{ $role->permissions->count() }} permissões
                                                            </small>
                                                        </div>
                                                        <div class="text-right">
                                                            <span class="badge badge-secondary">{{ $role->priority }}</span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            
                            <hr>
                            
                            <!-- Resumo de Permissões -->
                            <div id="permissionsPreview" class="mt-4" style="display: none;">
                                <h6 class="text-muted mb-3">
                                    <i class="fas fa-eye"></i> Preview de Permissões
                                </h6>
                                <div id="permissionsContent" class="border rounded p-3 bg-light">
                                    <!-- Conteúdo será preenchido via JavaScript -->
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <button type="button" class="btn btn-outline-secondary" id="selectAll">
                                        <i class="fas fa-check-square"></i> Selecionar Todos
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="deselectAll">
                                        <i class="fas fa-square"></i> Desmarcar Todos
                                    </button>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Salvar Alterações
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users-cog fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhum role disponível</h5>
                                <p class="text-muted">Não há roles ativos para atribuir a este usuário.</p>
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Criar Novo Role
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleCheckboxes = document.querySelectorAll('.role-checkbox');
    const selectAllBtn = document.getElementById('selectAll');
    const deselectAllBtn = document.getElementById('deselectAll');
    const permissionsPreview = document.getElementById('permissionsPreview');
    const permissionsContent = document.getElementById('permissionsContent');
    
    // Função para atualizar preview de permissões
    function updatePermissionsPreview() {
        const selectedRoles = Array.from(roleCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => ({
                id: cb.value,
                name: cb.dataset.roleName,
                permissionsCount: parseInt(cb.dataset.permissionsCount)
            }));
        
        if (selectedRoles.length > 0) {
            const totalPermissions = selectedRoles.reduce((sum, role) => sum + role.permissionsCount, 0);
            
            let content = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-2">Roles Selecionados (${selectedRoles.length})</h6>
                        <ul class="list-unstyled mb-0">
            `;
            
            selectedRoles.forEach(role => {
                content += `
                    <li class="mb-1">
                        <i class="fas fa-check text-success"></i> 
                        <strong>${role.name}</strong>
                        <small class="text-muted">(${role.permissionsCount} permissões)</small>
                    </li>
                `;
            });
            
            content += `
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-2">Resumo</h6>
                        <p class="mb-1">
                            <i class="fas fa-key text-primary"></i> 
                            <strong>${totalPermissions}</strong> permissões totais
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-info-circle text-info"></i> 
                            Permissões duplicadas serão mescladas automaticamente
                        </p>
                    </div>
                </div>
            `;
            
            permissionsContent.innerHTML = content;
            permissionsPreview.style.display = 'block';
        } else {
            permissionsPreview.style.display = 'none';
        }
    }
    
    // Event listeners para checkboxes
    roleCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePermissionsPreview);
    });
    
    // Selecionar todos
    selectAllBtn.addEventListener('click', function() {
        roleCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updatePermissionsPreview();
    });
    
    // Desmarcar todos
    deselectAllBtn.addEventListener('click', function() {
        roleCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updatePermissionsPreview();
    });
    
    // Atualizar preview inicial
    updatePermissionsPreview();
    
    // Confirmação antes de enviar
    document.getElementById('rolesForm').addEventListener('submit', function(e) {
        const selectedCount = Array.from(roleCheckboxes).filter(cb => cb.checked).length;
        
        if (selectedCount === 0) {
            e.preventDefault();
            alert('Selecione pelo menos um role para o usuário.');
            return false;
        }
        
        const confirmMessage = `Tem certeza que deseja atribuir ${selectedCount} role(s) ao usuário {{ $user->name }}?`;
        
        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.form-check {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    transition: all 0.2s ease;
}

.form-check:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.form-check-input:checked + .form-check-label {
    color: #007bff;
}

.form-check-input:checked ~ .form-check {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.badge {
    font-size: 0.75em;
}

#permissionsPreview {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-title {
    font-size: 1.1em;
    font-weight: 600;
}
</style>
@endpush