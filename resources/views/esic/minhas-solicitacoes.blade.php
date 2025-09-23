@extends('layouts.app')

@section('title', 'Minhas Solicitações E-SIC')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Minhas Solicitações E-SIC</h1>
                    <p class="text-muted mb-0">Acompanhe todas as suas solicitações de informação</p>
                </div>
                <div>
                    <a href="{{ route('esic.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Voltar ao Dashboard
                    </a>
                    <a href="{{ route('esic.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nova Solicitação
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('esic.minhas-solicitacoes') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Todos os Status</option>
                                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                    <option value="em_analise" {{ request('status') == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
                                    <option value="respondida" {{ request('status') == 'respondida' ? 'selected' : '' }}>Respondida</option>
                                    <option value="finalizada" {{ request('status') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                    <option value="negada" {{ request('status') == 'negada' ? 'selected' : '' }}>Negada</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select name="categoria" id="categoria" class="form-select">
                                    <option value="">Todas as Categorias</option>
                                    @foreach(\App\Models\EsicSolicitacao::getCategorias() as $key => $nome)
                                        <option value="{{ $key }}" {{ request('categoria') == $key ? 'selected' : '' }}>
                                            {{ $nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="busca" class="form-label">Buscar</label>
                                <input type="text" name="busca" id="busca" class="form-control" 
                                       placeholder="Protocolo, assunto ou descrição..." 
                                       value="{{ request('busca') }}">
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
        </div>
    </div>

    <!-- Lista de Solicitações -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Suas Solicitações ({{ $solicitacoes->total() }} encontradas)
                    </h5>
                </div>
                <div class="card-body">
                    @if($solicitacoes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Assunto</th>
                                        <th>Categoria</th>
                                        <th>Status</th>
                                        <th>Data Solicitação</th>
                                        <th>Última Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($solicitacoes as $solicitacao)
                                        <tr>
                                            <td>
                                                <code class="fs-6">{{ $solicitacao->protocolo }}</code>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 250px;" title="{{ $solicitacao->assunto }}">
                                                    <strong>{{ $solicitacao->assunto }}</strong>
                                                </div>
                                                <small class="text-muted">
                                                    {{ Str::limit($solicitacao->descricao, 80) }}
                                                </small>
                                            </td>
                                            <td>
                                                @php
                                                    $categorias = \App\Models\EsicSolicitacao::getCategorias();
                                                @endphp
                                                <span class="badge bg-secondary">
                                                    {{ $categorias[$solicitacao->categoria] ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = match($solicitacao->status) {
                                                        'pendente' => 'warning',
                                                        'em_analise' => 'info',
                                                        'respondida' => 'success',
                                                        'finalizada' => 'primary',
                                                        'negada' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                    $statusText = match($solicitacao->status) {
                                                        'pendente' => 'Pendente',
                                                        'em_analise' => 'Em Análise',
                                                        'respondida' => 'Respondida',
                                                        'finalizada' => 'Finalizada',
                                                        'negada' => 'Negada',
                                                        default => 'Desconhecido'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $solicitacao->created_at->format('d/m/Y') }}<br>
                                                    <span class="text-muted">{{ $solicitacao->created_at->format('H:i') }}</span>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $solicitacao->updated_at->format('d/m/Y') }}<br>
                                                    <span class="text-muted">{{ $solicitacao->updated_at->format('H:i') }}</span>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('esic.show', $solicitacao->protocolo) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($solicitacao->status == 'respondida')
                                                        <button class="btn btn-sm btn-outline-success" title="Respondida">
                                                            <i class="fas fa-check"></i>
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
                        <div class="d-flex justify-content-center mt-4">
                            {{ $solicitacoes->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Nenhuma solicitação encontrada</h4>
                            @if(request()->hasAny(['status', 'categoria', 'busca']))
                                <p class="text-muted mb-3">
                                    Não encontramos solicitações com os filtros aplicados.
                                </p>
                                <a href="{{ route('esic.minhas-solicitacoes') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-2"></i>Limpar Filtros
                                </a>
                            @else
                                <p class="text-muted mb-3">
                                    Você ainda não fez nenhuma solicitação via E-SIC.
                                </p>
                            @endif
                            <a href="{{ route('esic.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Fazer Primeira Solicitação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Resumo Estatístico -->
    @if($solicitacoes->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h5 class="text-primary">{{ $solicitacoes->total() }}</h5>
                            <small class="text-muted">Total de Solicitações</small>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-warning">
                                {{ $solicitacoes->where('status', 'pendente')->count() + $solicitacoes->where('status', 'em_analise')->count() }}
                            </h5>
                            <small class="text-muted">Em Andamento</small>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-success">{{ $solicitacoes->where('status', 'respondida')->count() }}</h5>
                            <small class="text-muted">Respondidas</small>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-info">{{ $solicitacoes->where('status', 'finalizada')->count() }}</h5>
                            <small class="text-muted">Finalizadas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.btn-group .btn {
    border-radius: 0.375rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.25rem;
}

.form-select, .form-control {
    border-radius: 0.5rem;
}

.btn {
    border-radius: 0.5rem;
}

code {
    background-color: #f8f9fa;
    color: #e83e8c;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}
</style>
@endsection