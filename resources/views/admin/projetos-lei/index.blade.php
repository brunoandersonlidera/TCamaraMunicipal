@extends('layouts.admin')

@section('page-title', 'Projetos de Lei')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Projetos de Lei</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Projetos de Lei</h1>
            <p class="text-muted">Gerencie os projetos de lei da Câmara Municipal</p>
        </div>
        <a href="{{ route('admin.projetos-lei.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Projeto
        </a>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.projetos-lei.index') }}" id="filtrosForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="busca" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="busca" name="busca" 
                                   value="{{ request('busca') }}" 
                                   placeholder="Número, título, ementa ou autor...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo">
                                <option value="">Todos os tipos</option>
                                <option value="projeto_lei" {{ request('tipo') === 'projeto_lei' ? 'selected' : '' }}>Projeto de Lei</option>
                                <option value="projeto_lei_complementar" {{ request('tipo') === 'projeto_lei_complementar' ? 'selected' : '' }}>Lei Complementar</option>
                                <option value="projeto_resolucao" {{ request('tipo') === 'projeto_resolucao' ? 'selected' : '' }}>Resolução</option>
                                <option value="projeto_decreto_legislativo" {{ request('tipo') === 'projeto_decreto_legislativo' ? 'selected' : '' }}>Decreto Legislativo</option>
                                <option value="indicacao" {{ request('tipo') === 'indicacao' ? 'selected' : '' }}>Indicação</option>
                                <option value="mocao" {{ request('tipo') === 'mocao' ? 'selected' : '' }}>Moção</option>
                                <option value="requerimento" {{ request('tipo') === 'requerimento' ? 'selected' : '' }}>Requerimento</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos os status</option>
                                <option value="tramitando" {{ request('status') === 'tramitando' ? 'selected' : '' }}>Tramitando</option>
                                <option value="aprovado" {{ request('status') === 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                <option value="rejeitado" {{ request('status') === 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                <option value="retirado" {{ request('status') === 'retirado' ? 'selected' : '' }}>Retirado</option>
                                <option value="arquivado" {{ request('status') === 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="ano" class="form-label">Ano</label>
                            <select class="form-select" id="ano" name="ano">
                                <option value="">Todos os anos</option>
                                @foreach($anos as $ano)
                                    <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>{{ $ano }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="autor_id" class="form-label">Autor</label>
                            <select class="form-select" id="autor_id" name="autor_id">
                                <option value="">Todos os autores</option>
                                @foreach($vereadores as $vereador)
                                    <option value="{{ $vereador->id }}" {{ request('autor_id') == $vereador->id ? 'selected' : '' }}>
                                        {{ $vereador->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                    <a href="{{ route('admin.projetos-lei.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Limpar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Projetos -->
    <div class="admin-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-gavel me-2"></i>Projetos de Lei 
                <span class="badge bg-primary ms-2">{{ $projetos->total() }}</span>
            </h5>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="toggleView('table')" id="viewTable">
                    <i class="fas fa-table"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="toggleView('cards')" id="viewCards">
                    <i class="fas fa-th-large"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            @if($projetos->count() > 0)
                <!-- Visualização em Tabela -->
                <div id="tableView" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projetos as $projeto)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $projeto->numero }}</div>
                                    @if($projeto->urgente)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Urgente
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst(str_replace('_', ' ', $projeto->tipo)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($projeto->titulo, 50) }}</div>
                                    <small class="text-muted">{{ Str::limit($projeto->ementa, 80) }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($projeto->autor->foto)
                                            <img src="{{ asset('storage/' . $projeto->autor->foto) }}" 
                                                 alt="{{ $projeto->autor->nome }}" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 30px; height: 30px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold" style="font-size: 0.875rem;">{{ $projeto->autor->nome }}</div>
                                            @if($projeto->vereadores->count() > 0)
                                                <small class="text-muted">+{{ $projeto->vereadores->count() }} coautor(es)</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $projeto->data_protocolo->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $projeto->data_protocolo->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $projeto->status === 'aprovado' ? 'success' : ($projeto->status === 'rejeitado' ? 'danger' : ($projeto->status === 'tramitando' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst($projeto->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.projetos-lei.show', $projeto) }}" 
                                           class="btn btn-outline-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.projetos-lei.edit', $projeto) }}" 
                                           class="btn btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete('{{ $projeto->id }}')" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Visualização em Cards -->
                <div id="cardsView" class="row p-3" style="display: none;">
                    @foreach($projetos as $projeto)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-info">{{ $projeto->numero }}</span>
                                    @if($projeto->urgente)
                                        <span class="badge bg-warning text-dark">Urgente</span>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $projeto->status === 'aprovado' ? 'success' : ($projeto->status === 'rejeitado' ? 'danger' : ($projeto->status === 'tramitando' ? 'warning' : 'secondary')) }}">
                                    {{ ucfirst($projeto->status) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($projeto->titulo, 60) }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($projeto->ementa, 100) }}</p>
                                <div class="d-flex align-items-center mb-2">
                                    @if($projeto->autor->foto)
                                        <img src="{{ asset('storage/' . $projeto->autor->foto) }}" 
                                             alt="{{ $projeto->autor->nome }}" 
                                             class="rounded-circle me-2" 
                                             style="width: 25px; height: 25px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 25px; height: 25px;">
                                            <i class="fas fa-user text-white" style="font-size: 10px;"></i>
                                        </div>
                                    @endif
                                    <small class="text-muted">{{ $projeto->autor->nome }}</small>
                                </div>
                                <small class="text-muted">{{ $projeto->data_protocolo->format('d/m/Y') }}</small>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group btn-group-sm w-100">
                                    <a href="{{ route('admin.projetos-lei.show', $projeto) }}" 
                                       class="btn btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.projetos-lei.edit', $projeto) }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete('{{ $projeto->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                @if($projetos->hasPages())
                <div class="card-footer">
                    {{ $projetos->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum projeto encontrado</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['busca', 'tipo', 'status', 'ano', 'autor_id']))
                            Nenhum projeto corresponde aos filtros aplicados.
                        @else
                            Ainda não há projetos de lei cadastrados.
                        @endif
                    </p>
                    @if(!request()->hasAny(['busca', 'tipo', 'status', 'ano', 'autor_id']))
                        <a href="{{ route('admin.projetos-lei.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Projeto
                        </a>
                    @endif
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
                <p>Tem certeza que deseja excluir este projeto de lei?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção:</strong> Esta ação não pode ser desfeita. Todos os dados e arquivos do projeto serão perdidos permanentemente.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir Projeto
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

.table th {
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.badge {
    font-size: 0.75em;
}

.card-title {
    font-size: 1rem;
    font-weight: 600;
}

.card-text {
    font-size: 0.875rem;
    line-height: 1.4;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/projetos-lei.js') }}"></script>
@endpush