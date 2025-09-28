@extends('layouts.admin')

@section('title', 'Gerenciar Permissões')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Permissões</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gerenciar Permissões</h1>
            <p class="text-muted mb-0">Controle total sobre as permissões do sistema</p>
        </div>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Permissão
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.permissions.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nome ou descrição da permissão">
                </div>
                <div class="col-md-2">
                    <label for="module" class="form-label">Módulo</label>
                    <select class="form-control" id="module" name="module">
                        <option value="">Todos os módulos</option>
                        @foreach($modules as $module)
                            <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                {{ ucfirst($module) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="type" class="form-label">Tipo</label>
                    <select class="form-control" id="type" name="type">
                        <option value="">Todos</option>
                        <option value="1" {{ request('type') === '1' ? 'selected' : '' }}>Sistema</option>
                        <option value="0" {{ request('type') === '0' ? 'selected' : '' }}>Personalizada</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Limpar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Permissões -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-key"></i> 
                Permissões 
                <span class="badge badge-primary">{{ $permissions->total() }}</span>
            </h5>
        </div>
        <div class="card-body p-0">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Nome de Exibição</th>
                                <th>Módulo</th>
                                <th>Descrição</th>
                                <th>Roles</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    <code>{{ $permission->name }}</code>
                                </td>
                                <td>
                                    <strong>{{ $permission->display_name }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($permission->module) }}</span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ Str::limit($permission->description, 50) ?: 'Não informada' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $permission->roles->count() }}</span>
                                </td>
                                <td>
                                    @if($permission->is_system)
                                        <span class="badge badge-warning">
                                            <i class="fas fa-cog"></i> Sistema
                                        </span>
                                    @else
                                        <span class="badge badge-primary">
                                            <i class="fas fa-user"></i> Personalizada
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" 
                                               type="checkbox" 
                                               data-id="{{ $permission->id }}"
                                               {{ $permission->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.permissions.show', $permission) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @unless($permission->is_system)
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-permission" 
                                                data-id="{{ $permission->id }}"
                                                data-name="{{ $permission->display_name }}"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Mostrando {{ $permissions->firstItem() }} a {{ $permissions->lastItem() }} 
                            de {{ $permissions->total() }} permissões
                        </div>
                        {{ $permissions->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-key fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma permissão encontrada</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'module', 'status', 'type']))
                            Tente ajustar os filtros ou 
                            <a href="{{ route('admin.permissions.index') }}">limpar a busca</a>.
                        @else
                            Comece criando sua primeira permissão.
                        @endif
                    </p>
                    @unless(request()->hasAny(['search', 'module', 'status', 'type']))
                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Criar Primeira Permissão
                    </a>
                    @endunless
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a permissão <strong id="permissionName"></strong>?</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Esta ação não pode ser desfeita e a permissão será removida de todos os roles.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle de status
    $('.status-toggle').change(function() {
        const permissionId = $(this).data('id');
        const isActive = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/permissions/${permissionId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                is_active: isActive
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error('Erro ao alterar status da permissão');
                    // Reverter o toggle em caso de erro
                    $(this).prop('checked', !isActive);
                }
            }.bind(this),
            error: function() {
                toastr.error('Erro ao alterar status da permissão');
                // Reverter o toggle em caso de erro
                $(this).prop('checked', !isActive);
            }.bind(this)
        });
    });

    // Modal de exclusão
    $('.delete-permission').click(function() {
        const permissionId = $(this).data('id');
        const permissionName = $(this).data('name');
        
        $('#permissionName').text(permissionName);
        $('#deleteForm').attr('action', `/admin/permissions/${permissionId}`);
        $('#deleteModal').modal('show');
    });

    // Submissão do formulário de exclusão
    $('#deleteForm').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const url = form.attr('action');
        
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#deleteModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.message || 'Erro ao excluir permissão');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                toastr.error(response?.message || 'Erro ao excluir permissão');
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.form-switch .form-check-input {
    width: 2.5em;
    height: 1.25em;
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table-responsive {
    border-radius: 0;
}

code {
    font-size: 0.875em;
    color: #e83e8c;
    background-color: #f8f9fa;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
}
</style>
@endpush