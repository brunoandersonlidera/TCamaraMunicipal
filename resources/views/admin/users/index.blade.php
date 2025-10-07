@extends('layouts.admin')

@section('page-title', 'Gestão de Usuários')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuários</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gestão de Usuários</h1>
            <p class="text-muted">Gerencie usuários e suas permissões no sistema</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Usuário
        </a>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nome ou email...">
                </div>
                <div class="col-md-3">
                    <label for="role" class="form-label">Tipo</label>
                    <select class="form-select" id="role" name="role">
                        <option value="">Todos os tipos</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="funcionario" {{ request('role') === 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                        <option value="cidadao" {{ request('role') === 'cidadao' ? 'selected' : '' }}>Cidadão</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Usuários -->
    <div class="admin-card">
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Tipo</th>
                                <th>Verificação</th>
                                <th>Permissões</th>
                                <th>Status</th>
                                <th>Último Acesso</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-avatar">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                             class="rounded-circle" width="40" height="40">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>
                                            @if($user->role === 'cidadao' && $user->nome_completo)
                                    {{ $user->nome_completo }}
                                            @else
                                                {{ $user->name }}
                                            @endif
                                        </strong>
                                        @if($user->cargo)
                                            <br><small class="text-muted">{{ $user->cargo }}</small>
                                        @elseif($user->role === 'cidadao' && $user->profissao)
                                            <br><small class="text-muted">{{ $user->profissao }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->cpf)
                                        {{ $user->cpf }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Administrador</span>
                                    @elseif($user->role === 'funcionario')
                                        <span class="badge bg-primary">Funcionário</span>
                                    @elseif($user->role === 'cidadao')
                                        <span class="badge bg-success">Cidadão</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'cidadao')
                                        @if($user->status_verificacao === 'verificado')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Verificado
                                            </span>
                                        @elseif($user->status_verificacao === 'pendente')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pendente
                                            </span>
                                            <div class="mt-1">
                                                <button class="btn btn-xs btn-success me-1" data-action="verify-citizen" data-id="{{ $user->id }}" title="Aprovar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-xs btn-danger" data-action="reject-citizen" data-id="{{ $user->id }}" title="Rejeitar">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @elseif($user->status_verificacao === 'rejeitado')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Rejeitado
                                            </span>
                                            <div class="mt-1">
                                                <button class="btn btn-xs btn-success" data-action="verify-citizen" data-id="{{ $user->id }}" title="Aprovar">
                                                    <i class="fas fa-check"></i> Aprovar
                                                </button>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Não definido</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'cidadao')
                                        <div class="d-flex flex-column gap-1">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input permission-toggle" type="checkbox" 
                                                       data-user-id="{{ $user->id }}" 
                                                       data-permission="pode_assinar"
                                                       {{ $user->pode_assinar ? 'checked' : '' }}>
                                                <label class="form-check-label small">
                                                    Pode Assinar
                                                </label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input permission-toggle" type="checkbox" 
                                                       data-user-id="{{ $user->id }}" 
                                                       data-permission="pode_criar_comite"
                                                       {{ $user->pode_criar_comite ? 'checked' : '' }}>
                                                <label class="form-check-label small">
                                                    Pode Criar Comitê
                                                </label>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-user-id="{{ $user->id }}" 
                                               {{ $user->active ? 'checked' : '' }}
                                               {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <label class="form-check-label">
                                            {{ $user->active ? 'Ativo' : 'Inativo' }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    @if($user->last_login_at)
                                        {{ $user->last_login_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">Nunca</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="btn btn-sm btn-outline-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->active && $user->id !== auth()->id())
                                            <a href="{{ route('admin.users.impersonate', $user) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Fazer login como">
                                                <i class="fas fa-user-secret"></i>
                                            </a>
                                        @endif
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-user" 
                                                    data-user-id="{{ $user->id }}" 
                                                    data-user-name="{{ $user->name }}" title="Excluir">
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
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} 
                        de {{ $users->total() }} usuários
                    </div>
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>Nenhum usuário encontrado</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'role', 'status']))
                            Tente ajustar os filtros ou 
                            <a href="{{ route('admin.users.index') }}">limpar a busca</a>
                        @else
                            Comece criando o primeiro usuário
                        @endif
                    </p>
                    @if(!request()->hasAny(['search', 'role', 'status']))
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Criar Primeiro Usuário
                        </a>
                    @endif
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
                <p>Tem certeza que deseja excluir o usuário <strong id="userName"></strong>?</p>
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

@push('styles')
<style>
.user-avatar img {
    object-fit: cover;
    border: 2px solid #e9ecef;
}

.status-toggle {
    cursor: pointer;
}

.status-toggle:disabled {
    cursor: not-allowed;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-right: 0.25rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/users-index.js') }}"></script>
@endpush