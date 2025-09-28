@extends('layouts.admin')

@section('title', 'Visualizar Permissão')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissões</a></li>
            <li class="breadcrumb-item active">{{ $permission->display_name }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Visualizar Permissão</h1>
            <p class="text-muted mb-0">Detalhes completos da permissão {{ $permission->display_name }}</p>
        </div>
        <div>
            @unless($permission->is_system)
            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endunless
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
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
                            <code>{{ $permission->name }}</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Nome de Exibição:</strong></div>
                        <div class="col-sm-8">{{ $permission->display_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Descrição:</strong></div>
                        <div class="col-sm-8">{{ $permission->description ?? 'Não informada' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Módulo:</strong></div>
                        <div class="col-sm-8">
                            <span class="badge badge-info">{{ ucfirst($permission->module) }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Prioridade:</strong></div>
                        <div class="col-sm-8">
                            <span class="badge badge-secondary">{{ $permission->priority }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Guard:</strong></div>
                        <div class="col-sm-8">
                            <code>{{ $permission->guard_name }}</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Status:</strong></div>
                        <div class="col-sm-8">
                            @if($permission->is_active)
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
                            @if($permission->is_system)
                                <span class="badge badge-warning">
                                    <i class="fas fa-cog"></i> Sistema
                                </span>
                            @else
                                <span class="badge badge-primary">
                                    <i class="fas fa-user"></i> Personalizada
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
                                <h3 class="text-primary mb-1">{{ $permission->roles->count() }}</h3>
                                <p class="text-muted mb-0">Roles</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success mb-1">{{ $permission->roles->sum(function($role) { return $role->users->count(); }) }}</h3>
                            <p class="text-muted mb-0">Usuários</p>
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
        </div>
    </div>

    <!-- Roles com esta Permissão -->
    @if($permission->roles->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-users-cog"></i> Roles com esta Permissão ({{ $permission->roles->count() }})
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Nome de Exibição</th>
                            <th>Descrição</th>
                            <th>Usuários</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permission->roles as $role)
                        <tr>
                            <td>
                                <code>{{ $role->name }}</code>
                            </td>
                            <td>
                                <strong>{{ $role->display_name }}</strong>
                            </td>
                            <td>
                                <span class="text-muted">
                                    {{ Str::limit($role->description, 50) ?: 'Não informada' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $role->users->count() }}</span>
                            </td>
                            <td>
                                @if($role->is_system)
                                    <span class="badge badge-warning">
                                        <i class="fas fa-cog"></i> Sistema
                                    </span>
                                @else
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user"></i> Personalizado
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($role->is_active)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.roles.show', $role) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Visualizar role">
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

    <!-- Usuários com esta Permissão (através de roles) -->
    @php
        $usersWithPermission = collect();
        foreach($permission->roles as $role) {
            $usersWithPermission = $usersWithPermission->merge($role->users);
        }
        $usersWithPermission = $usersWithPermission->unique('id');
    @endphp

    @if($usersWithPermission->count() > 0)
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-users"></i> Usuários com esta Permissão ({{ $usersWithPermission->count() }})
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
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Último Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usersWithPermission as $user)
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
                                @php
                                    $userRolesWithPermission = $user->roles->intersect($permission->roles);
                                @endphp
                                @foreach($userRolesWithPermission as $role)
                                    <span class="badge badge-info mr-1">{{ $role->display_name }}</span>
                                @endforeach
                            </td>
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
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Nenhum usuário com esta permissão</h5>
            <p class="text-muted">Esta permissão ainda não foi atribuída a nenhum role ou os roles não possuem usuários.</p>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">
                <i class="fas fa-users-cog"></i> Gerenciar Roles
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.border-right {
    border-right: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
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

.mr-1 {
    margin-right: 0.25rem;
}
</style>
@endpush