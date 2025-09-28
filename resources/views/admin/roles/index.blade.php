@extends('layouts.admin')

@section('page-title', 'Gestão de Roles')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Roles</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gestão de Roles</h1>
            <p class="text-muted">Gerencie os tipos de usuários e suas funções no sistema</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Role
        </a>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.roles.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nome do role...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="system" class="form-label">Tipo</label>
                    <select class="form-select" id="system" name="system">
                        <option value="">Todos os tipos</option>
                        <option value="1" {{ request('system') === '1' ? 'selected' : '' }}>Sistema</option>
                        <option value="0" {{ request('system') === '0' ? 'selected' : '' }}>Personalizado</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Roles -->
    <div class="admin-card">
        <div class="card-body">
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Nome de Exibição</th>
                                <th>Descrição</th>
                                <th>Usuários</th>
                                <th>Permissões</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>
                                    <strong>{{ $role->name }}</strong>
                                </td>
                                <td>{{ $role->display_name }}</td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($role->description, 50) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $role->users_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $role->permissions_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if($role->is_system)
                                        <span class="badge bg-warning">Sistema</span>
                                    @else
                                        <span class="badge bg-success">Personalizado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-role-id="{{ $role->id }}" 
                                               {{ $role->is_active ? 'checked' : '' }}
                                               {{ $role->is_system ? 'disabled' : '' }}>
                                        <label class="form-check-label">
                                            {{ $role->is_active ? 'Ativo' : 'Inativo' }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.roles.show', $role) }}" 
                                           class="btn btn-sm btn-outline-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.roles.edit', $role) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(!$role->is_system)
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-role" 
                                                    data-role-id="{{ $role->id }}" 
                                                    data-role-name="{{ $role->display_name }}" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                @if($roles->hasPages())
                    <div class="admin-pagination-wrapper">
                        <div class="admin-pagination-container">
                            {{ $roles->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users-cog fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum role encontrado</h5>
                    <p class="text-muted">Não há roles cadastrados no sistema.</p>
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Criar Primeiro Role
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o role <strong id="roleNameToDelete"></strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de status
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const roleId = this.dataset.roleId;
            const isActive = this.checked;
            
            fetch(`/admin/roles/${roleId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualizar label
                    const label = this.nextElementSibling;
                    label.textContent = isActive ? 'Ativo' : 'Inativo';
                    
                    // Mostrar notificação
                    showNotification('Status atualizado com sucesso!', 'success');
                } else {
                    // Reverter toggle em caso de erro
                    this.checked = !isActive;
                    showNotification('Erro ao atualizar status', 'error');
                }
            })
            .catch(error => {
                // Reverter toggle em caso de erro
                this.checked = !isActive;
                showNotification('Erro ao atualizar status', 'error');
            });
        });
    });

    // Modal de exclusão
    document.querySelectorAll('.delete-role').forEach(function(button) {
        button.addEventListener('click', function() {
            const roleId = this.dataset.roleId;
            const roleName = this.dataset.roleName;
            
            document.getElementById('roleNameToDelete').textContent = roleName;
            document.getElementById('deleteForm').action = `/admin/roles/${roleId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

function showNotification(message, type) {
    // Implementar sistema de notificações
    console.log(`${type}: ${message}`);
}
</script>
@endpush