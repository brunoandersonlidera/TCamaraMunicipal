@extends('layouts.admin')

@section('title', 'Usuários E-SIC - Câmara Municipal')
@section('page-title', 'Usuários E-SIC')

@section('breadcrumb')
    <li class="breadcrumb-item">Transparência</li>
    <li class="breadcrumb-item active">Usuários E-SIC</li>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
@endpush

@section('content')

<!-- Estatísticas -->
<div class="stats-row">
    <div class="row text-center">
        <div class="col-md-3">
            <div class="d-flex align-items-center justify-content-center">
                <div class="me-3">
                    <i class="fas fa-users text-primary fs-2"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">{{ $estatisticas['total'] ?? 0 }}</h4>
                    <small class="text-muted">Total de Usuários</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex align-items-center justify-content-center">
                <div class="me-3">
                    <i class="fas fa-user-check text-success fs-2"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-success">{{ $estatisticas['ativos'] ?? 0 }}</h4>
                    <small class="text-muted">Ativos</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex align-items-center justify-content-center">
                <div class="me-3">
                    <i class="fas fa-user-times text-danger fs-2"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-danger">{{ $estatisticas['inativos'] ?? 0 }}</h4>
                    <small class="text-muted">Inativos</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex align-items-center justify-content-center">
                <div class="me-3">
                    <i class="fas fa-calendar-plus text-info fs-2"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-info">{{ $estatisticas['mes_atual'] ?? 0 }}</h4>
                    <small class="text-muted">Este Mês</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros e Ações -->
<div class="filter-card">
    <form method="GET" action="{{ route('admin.esic-usuarios.index') }}" class="row g-3">
        <div class="col-md-3">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" 
                   value="{{ request('search') }}" placeholder="Nome, email ou CPF">
        </div>
        <div class="col-md-2">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="">Todos</option>
                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="data_inicio" class="form-label">Data Início</label>
            <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                   value="{{ request('data_inicio') }}">
        </div>
        <div class="col-md-2">
            <label for="data_fim" class="form-label">Data Fim</label>
            <input type="date" class="form-control" id="data_fim" name="data_fim" 
                   value="{{ request('data_fim') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.esic-usuarios.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Limpar
                </a>
                <a href="{{ route('admin.esic-usuarios.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>Novo
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Lista de Usuários -->
<div class="row">
    @forelse($usuarios as $usuario)
    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card user-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $usuario->nome }}</h6>
                            <small class="text-muted">{{ $usuario->email }}</small>
                        </div>
                    </div>
                    <span class="status-badge {{ $usuario->ativo ? 'bg-success text-white' : 'bg-danger text-white' }}">
                        {{ $usuario->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="mb-0 text-primary fw-bold">{{ $usuario->solicitacoes_count ?? 0 }}</h6>
                                <small class="text-muted">Solicitações</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="mb-0 text-success fw-bold">{{ $usuario->solicitacoes_respondidas_count ?? 0 }}</h6>
                                <small class="text-muted">Respondidas</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h6 class="mb-0 text-warning fw-bold">{{ $usuario->solicitacoes_pendentes_count ?? 0 }}</h6>
                            <small class="text-muted">Pendentes</small>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        Cadastrado em {{ $usuario->created_at->format('d/m/Y') }}
                    </small>
                    @if($usuario->ultimo_acesso)
                    <br>
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Último acesso: {{ $usuario->ultimo_acesso->format('d/m/Y H:i') }}
                    </small>
                    @endif
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.esic-usuarios.show', $usuario) }}" 
                       class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="fas fa-eye me-1"></i>Ver
                    </a>
                    <a href="{{ route('admin.esic-usuarios.edit', $usuario) }}" 
                       class="btn btn-sm btn-outline-warning flex-fill">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-{{ $usuario->ativo ? 'danger' : 'success' }}" 
                            data-action="toggle-status" 
                            data-user-id="{{ $usuario->id }}">
                        <i class="fas fa-{{ $usuario->ativo ? 'ban' : 'check' }} me-1"></i>
                        {{ $usuario->ativo ? 'Inativar' : 'Ativar' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-muted">Nenhum usuário encontrado</h4>
            <p class="text-muted">Não há usuários cadastrados no sistema E-SIC.</p>
            <a href="{{ route('admin.esic-usuarios.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Usuário
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Paginação -->
@if($usuarios->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $usuarios->appends(request()->query())->links() }}
</div>
@endif

@endsection

@push('scripts')
<script src="{{ asset('js/esic-usuarios-index.js') }}"></script>
@endpush