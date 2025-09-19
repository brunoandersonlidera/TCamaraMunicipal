@extends('layouts.admin')

@section('page-title', 'Solicitações e-SIC')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Solicitações e-SIC</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Solicitações e-SIC</h1>
            <p class="text-muted mb-0">Gerencie as solicitações de acesso à informação</p>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-info" onclick="atualizarEstatisticas()">
                <i class="fas fa-sync me-2"></i>Atualizar
            </button>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <div class="h3 mb-0">{{ $estatisticas['total'] }}</div>
                    <small>Total</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <div class="h3 mb-0">{{ $estatisticas['pendentes'] }}</div>
                    <small>Pendentes</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <div class="h3 mb-0">{{ $estatisticas['em_andamento'] }}</div>
                    <small>Em Andamento</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <div class="h3 mb-0">{{ $estatisticas['respondidas'] }}</div>
                    <small>Respondidas</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <div class="h3 mb-0">{{ $estatisticas['arquivadas'] }}</div>
                    <small>Arquivadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <div class="h3 mb-0">{{ $solicitacoes->where('visualizada_em', null)->count() }}</div>
                    <small>Não Lidas</small>
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
            <form method="GET" action="{{ route('admin.solicitacoes.index') }}" id="filtrosForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="busca" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="busca" name="busca" 
                                   value="{{ request('busca') }}" 
                                   placeholder="Nome, email, assunto ou protocolo...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo">
                                <option value="">Todos</option>
                                @foreach($tipos as $value => $label)
                                    <option value="{{ $value }}" {{ request('tipo') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="data_inicio" class="form-label">Data Início</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                                   value="{{ request('data_inicio') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="data_fim" class="form-label">Data Fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim" 
                                   value="{{ request('data_fim') }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if(request()->hasAny(['busca', 'status', 'tipo', 'data_inicio', 'data_fim']))
                                    <a href="{{ route('admin.solicitacoes.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times me-2"></i>Limpar Filtros
                                    </a>
                                @endif
                            </div>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleView('table')" id="btnTable">
                                    <i class="fas fa-table"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleView('cards')" id="btnCards">
                                    <i class="fas fa-th-large"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    @if($solicitacoes->count() > 0)
        <!-- Visualização em Tabela -->
        <div id="tableView" class="admin-card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Solicitações ({{ $solicitacoes->total() }})
                    </h5>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sort me-2"></i>Ordenar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order_by' => 'created_at', 'order_direction' => 'desc']) }}">Mais Recentes</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order_by' => 'created_at', 'order_direction' => 'asc']) }}">Mais Antigas</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order_by' => 'nome', 'order_direction' => 'asc']) }}">Nome A-Z</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order_by' => 'status', 'order_direction' => 'asc']) }}">Status</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Protocolo</th>
                                <th>Solicitante</th>
                                <th>Assunto</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitacoes as $solicitacao)
                            <tr class="{{ !$solicitacao->visualizada_em ? 'table-warning' : '' }}">
                                <td>
                                    <div class="fw-bold">{{ $solicitacao->protocolo }}</div>
                                    @if(!$solicitacao->visualizada_em)
                                        <small class="badge bg-danger">Nova</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $solicitacao->nome }}</div>
                                    <small class="text-muted">{{ $solicitacao->email }}</small>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $solicitacao->assunto }}">
                                        {{ $solicitacao->assunto }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $tipos[$solicitacao->tipo] ?? $solicitacao->tipo }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pendente' => 'warning',
                                            'em_andamento' => 'info',
                                            'respondida' => 'success',
                                            'arquivada' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$solicitacao->status] ?? 'secondary' }}">
                                        {{ $statusOptions[$solicitacao->status] ?? $solicitacao->status }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $solicitacao->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $solicitacao->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.solicitacoes.show', $solicitacao) }}" 
                                           class="btn btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.solicitacoes.edit', $solicitacao) }}" 
                                           class="btn btn-outline-secondary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete({{ $solicitacao->id }})" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Visualização em Cards -->
        <div id="cardsView" class="row" style="display: none;">
            @foreach($solicitacoes as $solicitacao)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 {{ !$solicitacao->visualizada_em ? 'border-warning' : '' }}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $solicitacao->protocolo }}</strong>
                            @if(!$solicitacao->visualizada_em)
                                <span class="badge bg-danger ms-2">Nova</span>
                            @endif
                        </div>
                        @php
                            $statusColors = [
                                'pendente' => 'warning',
                                'em_andamento' => 'info',
                                'respondida' => 'success',
                                'arquivada' => 'secondary'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$solicitacao->status] ?? 'secondary' }}">
                            {{ $statusOptions[$solicitacao->status] ?? $solicitacao->status }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $solicitacao->nome }}</h6>
                        <p class="card-text text-muted small">{{ $solicitacao->email }}</p>
                        <p class="card-text">
                            <strong>Assunto:</strong><br>
                            {{ Str::limit($solicitacao->assunto, 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-light text-dark">{{ $tipos[$solicitacao->tipo] ?? $solicitacao->tipo }}</span>
                            <small class="text-muted">{{ $solicitacao->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.solicitacoes.show', $solicitacao) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Ver
                            </a>
                            <a href="{{ route('admin.solicitacoes.edit', $solicitacao) }}" 
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                    onclick="confirmDelete({{ $solicitacao->id }})">
                                <i class="fas fa-trash me-1"></i>Excluir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center">
            {{ $solicitacoes->links() }}
        </div>
    @else
        <!-- Nenhum resultado -->
        <div class="admin-card">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5>Nenhuma solicitação encontrada</h5>
                @if(request()->hasAny(['busca', 'status', 'tipo', 'data_inicio', 'data_fim']))
                    <p class="text-muted">Tente ajustar os filtros para encontrar solicitações.</p>
                    <a href="{{ route('admin.solicitacoes.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-times me-2"></i>Limpar Filtros
                    </a>
                @else
                    <p class="text-muted">Ainda não há solicitações e-SIC cadastradas no sistema.</p>
                @endif
            </div>
        </div>
    @endif
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
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção!</strong> Esta ação não pode ser desfeita.
                </div>
                <p>Tem certeza que deseja excluir esta solicitação?</p>
                <p class="text-muted">Todos os dados e arquivos relacionados serão removidos permanentemente.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir Solicitação
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.admin-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.border-warning {
    border-color: #ffc107 !important;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endpush

@push('scripts')
<script>
// Controle de visualização
function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const btnTable = document.getElementById('btnTable');
    const btnCards = document.getElementById('btnCards');

    if (view === 'table') {
        tableView.style.display = 'block';
        cardsView.style.display = 'none';
        btnTable.classList.add('active');
        btnCards.classList.remove('active');
        localStorage.setItem('solicitacoes_view', 'table');
    } else {
        tableView.style.display = 'none';
        cardsView.style.display = 'block';
        btnCards.classList.add('active');
        btnTable.classList.remove('active');
        localStorage.setItem('solicitacoes_view', 'cards');
    }
}

// Restaurar visualização salva
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('solicitacoes_view') || 'table';
    toggleView(savedView);
});

// Confirmação de exclusão
function confirmDelete(id) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/solicitacoes/${id}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Atualizar estatísticas
function atualizarEstatisticas() {
    // Recarregar a página para atualizar as estatísticas
    window.location.reload();
}

// Auto-submit do formulário de filtros
document.getElementById('status').addEventListener('change', function() {
    document.getElementById('filtrosForm').submit();
});

document.getElementById('tipo').addEventListener('change', function() {
    document.getElementById('filtrosForm').submit();
});
</script>
@endpush