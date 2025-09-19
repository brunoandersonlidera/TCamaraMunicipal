@extends('layouts.app')

@section('title', 'Dashboard Administrativo - Câmara Municipal')

@section('content')
<div class="min-vh-100" style="background-color: #f8f9fa;">
    <!-- Header -->
    <header class="bg-white shadow-sm border-bottom">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center py-4">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">Dashboard Administrativo</h1>
                    <p class="text-muted small mb-0">Bem-vindo, {{ $user->name }}</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none" title="Ir para o site">
                        <i class="fas fa-home fs-5"></i>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container-fluid py-4">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stats -->
        <div class="row g-4 mb-4">
            <!-- Total Users -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
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
                <div class="card h-100 border-0 shadow-sm">
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
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-user-check text-info fs-4"></i>
                                </div>
                            </div>
                                <h6 class="text-muted mb-1 small">Usuários Ativos</h6>
                                <h3 class="mb-0 fw-bold">{{ $stats['active_users'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Ações Rápidas</h4>
                <div class="row g-4">
                    <!-- Gerenciar Vereadores -->
                    <div class="col-md-4">
                        <a href="{{ route('vereadores.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none card-hover">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3">
                                        <i class="fas fa-users text-primary fs-2"></i>
                                    </div>
                                </div>
                                <h5 class="card-title text-dark">Gerenciar Vereadores</h5>
                                <p class="card-text text-muted small">
                                    Visualizar e gerenciar informações dos vereadores
                                </p>
                            </div>
                        </a>
                    </div>

                    <!-- Configurações do Sistema -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm opacity-50">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex p-3">
                                        <i class="fas fa-cog text-secondary fs-2"></i>
                                    </div>
                                </div>
                                <h5 class="card-title text-muted">Configurações</h5>
                                <p class="card-text text-muted small">
                                    Em desenvolvimento
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Relatórios -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm opacity-50">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex p-3">
                                        <i class="fas fa-chart-bar text-secondary fs-2"></i>
                                    </div>
                                </div>
                                <h5 class="card-title text-muted">Relatórios</h5>
                                <p class="card-text text-muted small">
                                    Em desenvolvimento
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
.card-hover {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endsection