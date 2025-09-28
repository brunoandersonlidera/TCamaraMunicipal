@extends('layouts.admin')

@section('title', 'Gestão de Eventos - Painel Administrativo')

@push('styles')
@vite(['resources/css/admin/eventos.css'])
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="eventos-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-2">
                        <i class="fas fa-calendar-alt me-3"></i>
                        Gestão de Eventos
                    </h1>
                    <p class="lead mb-0">
                        Gerencie todos os eventos do calendário legislativo
                    </p>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('admin.eventos.create') }}" class="btn btn-light btn-lg me-2">
                        <i class="fas fa-plus me-2"></i>
                        Novo Evento
                    </a>
                    <button class="btn btn-outline-light" id="btn-sincronizar">
                        <i class="fas fa-sync-alt me-2"></i>
                        Sincronizar Eventos
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $eventos->total() }}</div>
                <div class="text-muted">Total de Eventos</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $eventos->where('ativo', true)->count() }}</div>
                <div class="text-muted">Eventos Ativos</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $eventos->where('destaque', true)->count() }}</div>
                <div class="text-muted">Em Destaque</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $eventos->where('data_evento', '>=', now()->startOfDay())->count() }}</div>
                <div class="text-muted">Próximos Eventos</div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filtros-card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.eventos.index') }}" id="form-filtros">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="">Todos</option>
                            @foreach($tipos as $key => $label)
                                <option value="{{ $key }}" {{ request('tipo') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativos</option>
                            <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativos</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Vereador</label>
                        <select name="vereador_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach($vereadores as $vereador)
                                <option value="{{ $vereador->id }}" {{ request('vereador_id') == $vereador->id ? 'selected' : '' }}>
                                    {{ $vereador->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Data Início</label>
                        <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Data Fim</label>
                        <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Filtrar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <input type="text" name="busca" class="form-control" placeholder="Buscar por título, descrição ou local..." value="{{ request('busca') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="order_by" class="form-select">
                            <option value="data_evento" {{ request('order_by') == 'data_evento' ? 'selected' : '' }}>Data do Evento</option>
                            <option value="titulo" {{ request('order_by') == 'titulo' ? 'selected' : '' }}>Título</option>
                            <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Data de Criação</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                Limpar
                            </a>
                            <a href="{{ route('admin.eventos.exportar-csv', request()->query()) }}" class="btn btn-success">
                                <i class="fas fa-download me-2"></i>
                                Exportar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Eventos -->
    <div class="table-responsive">
        <table class="table table-hover bg-white">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="25%">Evento</th>
                    <th width="15%">Data/Hora</th>
                    <th width="10%">Tipo</th>
                    <th width="15%">Vereador/Local</th>
                    <th width="10%">Status</th>
                    <th width="20%">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($eventos as $evento)
                <tr>
                    <td>
                        <strong>#{{ $evento->id }}</strong>
                    </td>
                    <td>
                        <div class="d-flex align-items-start">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $evento->titulo }}</h6>
                                @if($evento->descricao)
                                    <small class="text-muted">{{ Str::limit($evento->descricao, 80) }}</small>
                                @endif
                                @if($evento->destaque)
                                    <br><span class="destaque-badge mt-1">
                                        <i class="fas fa-star me-1"></i>Destaque
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $evento->data_evento->format('d/m/Y') }}</strong>
                            @if($evento->hora_inicio)
                                <br><small class="text-muted">{{ $evento->hora_inicio }}{{ $evento->hora_fim ? ' às ' . $evento->hora_fim : '' }}</small>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="evento-tipo {{ $evento->tipo }}">
                            {{ $tipos[$evento->tipo] ?? $evento->tipo }}
                        </span>
                    </td>
                    <td>
                        @if($evento->vereador)
                            <div><strong>{{ $evento->vereador->nome }}</strong></div>
                        @endif
                        @if($evento->local)
                            <small class="text-muted">{{ $evento->local }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $evento->ativo ? 'status-ativo' : 'status-inativo' }}">
                            {{ $evento->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <a href="{{ route('admin.eventos.show', $evento) }}" class="btn btn-sm btn-outline-info" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.eventos.edit', $evento) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button data-action="toggle-status" data-evento-id="{{ $evento->id }}" class="btn btn-sm btn-outline-{{ $evento->ativo ? 'warning' : 'success' }}" title="{{ $evento->ativo ? 'Desativar' : 'Ativar' }}">
                                <i class="fas fa-{{ $evento->ativo ? 'pause' : 'play' }}"></i>
                            </button>
                            <button data-action="toggle-destaque" data-evento-id="{{ $evento->id }}" class="btn btn-sm btn-outline-{{ $evento->destaque ? 'secondary' : 'warning' }}" title="{{ $evento->destaque ? 'Remover Destaque' : 'Destacar' }}">
                                <i class="fas fa-star"></i>
                            </button>
                            <a href="{{ route('admin.eventos.duplicate', $evento) }}" class="btn btn-sm btn-outline-secondary" title="Duplicar">
                                <i class="fas fa-copy"></i>
                            </a>
                            <button data-action="confirmar-exclusao" data-evento-id="{{ $evento->id }}" data-evento-nome="{{ $evento->titulo }}" class="btn btn-sm btn-outline-danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <h5>Nenhum evento encontrado</h5>
                            <p>Não há eventos cadastrados com os filtros selecionados.</p>
                            <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Criar Primeiro Evento
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($eventos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $eventos->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="modalExclusao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o evento <strong id="evento-nome"></strong>?</p>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="form-exclusao" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Excluir Evento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/admin/eventos.js'])
@endpush