@extends('layouts.admin')

@section('title', 'Visualizar Role')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">{{ $role->display_name }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Visualizar Role</h1>
            <p class="text-muted mb-0">Detalhes completos do role {{ $role->display_name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informações Básicas -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Informações Básicas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Nome:</strong></div>
                        <div class="col-sm-8">
                            <code>{{ $role->name }}</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Nome de Exibição:</strong></div>
                        <div class="col-sm-8">{{ $role->display_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Descrição:</strong></div>
                        <div class="col-sm-8">{{ $role->description ?? 'Não informada' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Prioridade:</strong></div>
                        <div class="col-sm-8">
                            <span class="badge badge-info">{{ $role->priority }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Guard:</strong></div>
                        <div class="col-sm-8">
                            <code>{{ $role->guard_name }}</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Status:</strong></div>
                        <div class="col-sm-8">
                            @if($role->is_active)
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
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Tipo:</strong></div>
                        <div class="col-sm-8">
                            @if($role->is_system)
                                <span class="badge badge-warning">
                                    <i class="fas fa-cog"></i> Sistema
                                </span>
                            @else
                                <span class="badge badge-primary">
                                    <i class="fas fa-user"></i> Personalizado
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar"></i> Estatísticas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <h3 class="text-primary mb-1">{{ $role->users->count() }}</h3>
                                <p class="text-muted mb-0">Usuários</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success mb-1">{{ $role->permissions->count() }}</h3>
                            <p class="text-muted mb-0">Permissões</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-6"><strong>Criado em:</strong></div>
                        <div class="col-sm-6">{{ $role->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6"><strong>Atualizado em:</strong></div>
                        <div class="col-sm-6">{{ $role->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Usuários com este Role -->
    @if($role->users->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-users"></i> Usuários com este Role ({{ $role->users->count() }})
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Último Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role->users as $user)
                        <tr>
                            <td>
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         class="rounded-circle" 
                                         width="32" height="32">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px; font-size: 14px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">Nunca</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Visualizar usuário">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Permissões -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-key"></i> Permissões ({{ $role->permissions->count() }})
            </h5>
        </div>
        <div class="card-body">
            @if($role->permissions->count() > 0)
                @php
                    $permissionsByModule = $role->permissions->groupBy('module');
                @endphp
                
                <div class="accordion" id="permissionsAccordion">
                    @foreach($permissionsByModule as $module => $permissions)
                    <div class="card">
                        <div class="card-header" id="heading{{ $loop->index }}">
                            <h6 class="mb-0">
                                <button class="btn btn-link text-left" type="button" 
                                        data-toggle="collapse" 
                                        data-target="#collapse{{ $loop->index }}" 
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                        aria-controls="collapse{{ $loop->index }}">
                                    <i class="fas fa-folder"></i> 
                                    {{ ucfirst($module) }} 
                                    <span class="badge badge-primary ml-2">{{ $permissions->count() }}</span>
                                </button>
                            </h6>
                        </div>
                        <div id="collapse{{ $loop->index }}" 
                             class="collapse {{ $loop->first ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $loop->index }}" 
                             data-parent="#permissionsAccordion">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check text-success mr-2"></i>
                                            <div>
                                                <strong>{{ $permission->display_name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $permission->name }}</small>
                                                @if($permission->description)
                                                    <br>
                                                    <small class="text-info">{{ $permission->description }}</small>
                                                @endif
                                            </div>
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
                <div class="text-center py-4">
                    <i class="fas fa-key fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma permissão atribuída</h5>
                    <p class="text-muted">Este role ainda não possui permissões associadas.</p>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Atribuir Permissões
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-right {
    border-right: 1px solid #dee2e6;
}

.accordion .card {
    border: 1px solid #dee2e6;
    margin-bottom: 0;
}

.accordion .card:first-child {
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.accordion .card:last-child {
    border-bottom-left-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}

.accordion .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.accordion .btn-link {
    text-decoration: none;
    color: #495057;
    width: 100%;
}

.accordion .btn-link:hover {
    text-decoration: none;
    color: #007bff;
}
</style>
@endpush