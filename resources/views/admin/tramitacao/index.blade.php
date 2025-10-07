@extends('layouts.admin')

@section('page-title', 'Dashboard de Tramitação')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Tramitação Legislativa</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-route me-2"></i>Dashboard de Tramitação Legislativa
            </h1>
            <p class="text-muted mb-0">Sistema de acompanhamento e gestão de processos legislativos</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.projetos-lei.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Projeto
            </a>
            <a href="{{ route('admin.tramitacao.relatorio') }}" class="btn btn-outline-secondary">
                <i class="fas fa-chart-bar me-2"></i>Relatórios
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="admin-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Total de Projetos</h6>
                            <h3 class="mb-0">{{ $estatisticas['total'] ?? 0 }}</h3>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="admin-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Em Tramitação</h6>
                            <h3 class="mb-0">{{ $estatisticas['em_tramitacao'] ?? 0 }}</h3>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="admin-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Aprovados</h6>
                            <h3 class="mb-0">{{ $estatisticas['aprovados'] ?? 0 }}</h3>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="admin-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Rejeitados</h6>
                            <h3 class="mb-0">{{ $estatisticas['rejeitados'] ?? 0 }}</h3>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-times-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.tramitacao.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos os status</option>
                            <option value="protocolado" {{ request('status') === 'protocolado' ? 'selected' : '' }}>Protocolado</option>
                            <option value="distribuido" {{ request('status') === 'distribuido' ? 'selected' : '' }}>Distribuído</option>
                            <option value="em_comissao" {{ request('status') === 'em_comissao' ? 'selected' : '' }}>Em Comissão</option>
                            <option value="aprovado_1_turno" {{ request('status') === 'aprovado_1_turno' ? 'selected' : '' }}>Aprovado 1º Turno</option>
                            <option value="aprovado" {{ request('status') === 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                            <option value="rejeitado" {{ request('status') === 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                            <option value="enviado_executivo" {{ request('status') === 'enviado_executivo' ? 'selected' : '' }}>Enviado ao Executivo</option>
                            <option value="sancionado" {{ request('status') === 'sancionado' ? 'selected' : '' }}>Sancionado</option>
                            <option value="vetado" {{ request('status') === 'vetado' ? 'selected' : '' }}>Vetado</option>
                            <option value="promulgado" {{ request('status') === 'promulgado' ? 'selected' : '' }}>Promulgado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos os tipos</option>
                            <option value="projeto_lei" {{ request('tipo') === 'projeto_lei' ? 'selected' : '' }}>Projeto de Lei</option>
                            <option value="projeto_lei_complementar" {{ request('tipo') === 'projeto_lei_complementar' ? 'selected' : '' }}>Projeto de Lei Complementar</option>
                            <option value="projeto_resolucao" {{ request('tipo') === 'projeto_resolucao' ? 'selected' : '' }}>Projeto de Resolução</option>
                            <option value="projeto_decreto_legislativo" {{ request('tipo') === 'projeto_decreto_legislativo' ? 'selected' : '' }}>Projeto de Decreto Legislativo</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="ano" class="form-label">Ano</label>
                        <select class="form-select" id="ano" name="ano">
                            <option value="">Todos os anos</option>
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('ano') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="consulta_publica" class="form-label">Consulta Pública</label>
                        <select class="form-select" id="consulta_publica" name="consulta_publica">
                            <option value="">Todas</option>
                            <option value="ativa" {{ request('consulta_publica') === 'ativa' ? 'selected' : '' }}>Ativa</option>
                            <option value="finalizada" {{ request('consulta_publica') === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Projetos -->
    <div class="admin-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Projetos em Tramitação</h5>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-1"></i>Ordenar
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['ordenar' => 'numero']) }}">Por Número</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['ordenar' => 'data_protocolo']) }}">Por Data</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['ordenar' => 'status']) }}">Por Status</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['ordenar' => 'tipo']) }}">Por Tipo</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($projetos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Projeto</th>
                                <th>Tipo</th>
                                <th>Autor</th>
                                <th>Status</th>
                                <th>Protocolo</th>
                                <th>Tempo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projetos as $projeto)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $projeto->numero }}/{{ $projeto->ano }}</strong>
                                            @if($projeto->urgente)
                                                <span class="badge bg-warning text-dark ms-1">Urgente</span>
                                            @endif
                                            @if($projeto->consulta_publica_ativa)
                                                <span class="badge bg-info ms-1">Consulta Pública</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ Str::limit($projeto->titulo, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst(str_replace('_', ' ', $projeto->tipo)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($projeto->autor)
                                            {{ $projeto->autor->nome }}
                                        @else
                                            <span class="text-muted">{{ ucfirst($projeto->tipo_autoria) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'protocolado' => ['color' => 'primary', 'icon' => 'file-alt'],
                                                'distribuido' => ['color' => 'info', 'icon' => 'share-alt'],
                                                'em_comissao' => ['color' => 'warning', 'icon' => 'users'],
                                                'aprovado_1_turno' => ['color' => 'success', 'icon' => 'check'],
                                                'aprovado' => ['color' => 'success', 'icon' => 'check-double'],
                                                'rejeitado' => ['color' => 'danger', 'icon' => 'times'],
                                                'enviado_executivo' => ['color' => 'info', 'icon' => 'paper-plane'],
                                                'sancionado' => ['color' => 'success', 'icon' => 'stamp'],
                                                'vetado' => ['color' => 'danger', 'icon' => 'ban'],
                                                'promulgado' => ['color' => 'success', 'icon' => 'certificate']
                                            ];
                                            $config = $statusConfig[$projeto->status] ?? ['color' => 'secondary', 'icon' => 'question'];
                                        @endphp
                                        <span class="badge bg-{{ $config['color'] }}">
                                            <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $projeto->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($projeto->protocolo_numero)
                                            <code>{{ $projeto->protocolo_numero }}</code>
                                        @else
                                            <span class="text-muted">Sem protocolo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $projeto->getTempoTramitacao() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.projetos-lei.tramitacao', $projeto) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Ver Tramitação">
                                                <i class="fas fa-route"></i>
                                            </a>
                                            <a href="{{ route('admin.projetos-lei.show', $projeto) }}" 
                                               class="btn btn-outline-secondary" 
                                               title="Ver Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.projetos-lei.edit', $projeto) }}" 
                                               class="btn btn-outline-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                @if($projetos->hasPages())
                    <div class="card-footer">
                        {{ $projetos->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum projeto encontrado</h5>
                    <p class="text-muted">Não há projetos de lei que correspondam aos filtros aplicados.</p>
                    <a href="{{ route('admin.projetos-lei.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Criar Primeiro Projeto
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Projetos com Prazo Vencendo -->
    @if(isset($projetosUrgentes) && $projetosUrgentes->count() > 0)
        <div class="admin-card mt-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Projetos com Prazo Vencendo
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($projetosUrgentes as $projeto)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $projeto->numero }}/{{ $projeto->ano }}</h6>
                                    <p class="card-text small">{{ Str::limit($projeto->titulo, 60) }}</p>
                                    @if($projeto->consulta_publica_ativa)
                                        <div class="alert alert-warning alert-sm mb-2">
                                            <small>
                                                <i class="fas fa-clock me-1"></i>
                                                Consulta pública até {{ $projeto->consulta_publica_prazo->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    @endif
                                    <a href="{{ route('admin.projetos-lei.tramitacao', $projeto) }}" class="btn btn-sm btn-warning">
                                        Ver Tramitação
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
.card-icon {
    opacity: 0.7;
}

.admin-card.bg-primary .card-icon,
.admin-card.bg-warning .card-icon,
.admin-card.bg-success .card-icon,
.admin-card.bg-info .card-icon {
    opacity: 0.3;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
}

.alert-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh da página a cada 5 minutos para manter dados atualizados
    setTimeout(function() {
        location.reload();
    }, 300000); // 5 minutos
    
    // Tooltip para botões de ação
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection