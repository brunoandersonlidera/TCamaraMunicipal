@extends('layouts.admin')

@section('title', 'Dashboard Administrativo - Câmara Municipal')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

<!-- Stats -->
<div class="row g-4 mb-4">
    <!-- Total Users -->
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1 small">Total de Usuários</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_users'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Admins -->
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-shield-alt text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1 small">Administradores</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_admins'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-check text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1 small">Usuários Ativos</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['active_users'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card">
    <div class="card-body">
        <h4 class="card-title mb-4">Ações Rápidas</h4>
        <div class="row g-4">
            <!-- Gerenciar Vereadores -->
            <div class="col-md-3">
                <a href="{{ route('admin.vereadores.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3">
                                <i class="fas fa-users text-primary fs-2"></i>
                            </div>
                        </div>
                        <h5 class="card-title text-dark">Vereadores</h5>
                        <p class="card-text text-muted small">
                            Gerenciar vereadores
                        </p>
                    </div>
                </a>
            </div>

            <!-- Gerenciar Notícias -->
            <div class="col-md-3">
                <a href="{{ route('admin.noticias.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3">
                                <i class="fas fa-newspaper text-success fs-2"></i>
                            </div>
                        </div>
                        <h5 class="card-title text-dark">Notícias</h5>
                        <p class="card-text text-muted small">
                            Gerenciar notícias
                        </p>
                    </div>
                </a>
            </div>

            <!-- Gerenciar Sessões -->
            <div class="col-md-3">
                <a href="{{ route('admin.sessoes.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-3">
                                <i class="fas fa-gavel text-info fs-2"></i>
                            </div>
                        </div>
                        <h5 class="card-title text-dark">Sessões</h5>
                        <p class="card-text text-muted small">
                            Gerenciar sessões
                        </p>
                    </div>
                </a>
            </div>

            <!-- Gerenciar Usuários -->
            <div class="col-md-3">
                <a href="{{ route('admin.users.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3">
                                <i class="fas fa-user-cog text-warning fs-2"></i>
                            </div>
                        </div>
                        <h5 class="card-title text-dark">Usuários</h5>
                        <p class="card-text text-muted small">
                            Gerenciar usuários
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card-hover {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endpush
@endsection