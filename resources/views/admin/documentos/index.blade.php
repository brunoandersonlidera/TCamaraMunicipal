@extends('layouts.admin')

@section('page-title', 'Documentos')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Documentos</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gestão de Documentos</h1>
            <p class="text-muted mb-0">Gerencie os documentos da Câmara Municipal</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Documento
            </a>
            <button type="button" class="btn btn-outline-secondary" onclick="toggleView()">
                <i class="fas fa-th-list me-2" id="viewIcon"></i>
                <span id="viewText">Visualização</span>
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>Filtros
                <button class="btn btn-sm btn-outline-secondary float-end" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </h5>
        </div>
        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.documentos.index') }}" id="filtrosForm">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="busca" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="busca" name="busca" 
                                   value="{{ request('busca') }}" placeholder="Título, descrição ou número...">
                        </div>
                        <div class="col-md-2">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria }}" {{ request('categoria') === $categoria ? 'selected' : '' }}>
                                        {{ ucfirst($categoria) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="ano" class="form-label">Ano</label>
                            <select class="form-select" id="ano" name="ano">
                                <option value="">Todos</option>
                                @foreach($anos as $ano)
                                    <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>
                                        {{ $ano }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Período</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="data_inicio" 
                                       value="{{ request('data_inicio') }}" placeholder="Data início">
                                <input type="date" class="form-control" name="data_fim" 
                                       value="{{ request('data_fim') }}" placeholder="Data fim">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Filtrar
                            </button>
                            <a href="{{ route('admin.documentos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Limpar
                            </a>
                            <span class="text-muted ms-3">
                                {{ $documentos->total() }} documento(s) encontrado(s)
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lista de Documentos - Visualização Tabela -->
    <div class="admin-card" id="tableView">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-file-alt me-2"></i>Documentos
                <span class="badge bg-primary ms-2">{{ $documentos->total() }}</span>
            </h5>
        </div>
        <div class="card-body p-0">
            @if($documentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Documento</th>
                                <th>Categoria</th>
                                <th>Data</th>
                                <th>Arquivo</th>
                                <th>Status</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documentos as $documento)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @php
                                                $iconClass = match($documento->categoria) {
                                                    'ata' => 'fas fa-file-alt text-primary',
                                                    'decreto' => 'fas fa-gavel text-warning',
                                                    'edital' => 'fas fa-bullhorn text-info',
                                                    'lei' => 'fas fa-balance-scale text-success',
                                                    'portaria' => 'fas fa-file-signature text-secondary',
                                                    'regimento' => 'fas fa-book text-dark',
                                                    'resolucao' => 'fas fa-check-circle text-success',
                                                    'contrato' => 'fas fa-handshake text-primary',
                                                    'convenio' => 'fas fa-hands-helping text-info',
                                                    'licitacao' => 'fas fa-shopping-cart text-warning',
                                                    'balanco' => 'fas fa-chart-line text-success',
                                                    'relatorio' => 'fas fa-chart-bar text-info',
                                                    default => 'fas fa-file text-muted'
                                                };
                                            @endphp
                                            <i class="{{ $iconClass }} fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $documento->titulo }}</div>
                                            @if($documento->numero)
                                                <small class="text-muted">Nº {{ $documento->numero }}</small>
                                            @endif
                                            @if($documento->destaque)
                                                <span class="badge bg-warning text-dark ms-2">
                                                    <i class="fas fa-star me-1"></i>Destaque
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ ucfirst($documento->categoria) }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $documento->data_documento->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $documento->data_documento->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($documento->arquivo)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-paperclip text-muted me-2"></i>
                                            <div>
                                                <div class="small">{{ $documento->nome_original }}</div>
                                                <small class="text-muted">{{ number_format($documento->tamanho / 1024, 1) }} KB</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Sem arquivo</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $documento->ativo ? 'success' : 'danger' }}">
                                        {{ $documento->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.documentos.show', $documento) }}" 
                                           class="btn btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.documentos.edit', $documento) }}" 
                                           class="btn btn-outline-secondary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($documento->arquivo)
                                        <a href="{{ route('admin.documentos.download', $documento) }}" 
                                           class="btn btn-outline-info" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @endif
                                        <button type="button" class="btn btn-outline-danger delete-btn" 
                                                data-id="{{ $documento->id }}" 
                                                data-nome="{{ $documento->titulo }}"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum documento encontrado</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['busca', 'categoria', 'status', 'ano', 'data_inicio', 'data_fim']))
                            Tente ajustar os filtros ou 
                            <a href="{{ route('admin.documentos.index') }}">limpar a busca</a>.
                        @else
                            Comece criando o primeiro documento.
                        @endif
                    </p>
                    @if(!request()->hasAny(['busca', 'categoria', 'status', 'ano', 'data_inicio', 'data_fim']))
                    <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Criar Primeiro Documento
                    </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Lista de Documentos - Visualização Cards -->
    <div class="row" id="cardView" style="display: none;">
        @if($documentos->count() > 0)
            @foreach($documentos as $documento)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="admin-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">{{ $documento->titulo }}</h6>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-light text-dark">{{ ucfirst($documento->categoria) }}</span>
                                    @if($documento->numero)
                                        <small class="text-muted">Nº {{ $documento->numero }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.documentos.show', $documento) }}">
                                        <i class="fas fa-eye me-2"></i>Visualizar
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.documentos.edit', $documento) }}">
                                        <i class="fas fa-edit me-2"></i>Editar
                                    </a></li>
                                    @if($documento->arquivo)
                                    <li><a class="dropdown-item" href="{{ route('admin.documentos.download', $documento) }}">
                                        <i class="fas fa-download me-2"></i>Download
                                    </a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger delete-btn" href="#" 
                                           data-id="{{ $documento->id }}" 
                                           data-nome="{{ $documento->titulo }}">
                                        <i class="fas fa-trash me-2"></i>Excluir
                                    </a></li>
                                </ul>
                            </div>
                        </div>

                        @if($documento->descricao)
                        <p class="card-text small text-muted mb-3">
                            {{ Str::limit($documento->descricao, 100) }}
                        </p>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $documento->data_documento->format('d/m/Y') }}
                                </small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if($documento->destaque)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i>
                                    </span>
                                @endif
                                <span class="badge bg-{{ $documento->ativo ? 'success' : 'danger' }}">
                                    {{ $documento->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>
                        </div>

                        @if($documento->arquivo)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-paperclip text-muted me-2"></i>
                                    <small class="text-muted">{{ $documento->nome_original }}</small>
                                </div>
                                <small class="text-muted">{{ number_format($documento->tamanho / 1024, 1) }} KB</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum documento encontrado</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['busca', 'categoria', 'status', 'ano', 'data_inicio', 'data_fim']))
                            Tente ajustar os filtros ou 
                            <a href="{{ route('admin.documentos.index') }}">limpar a busca</a>.
                        @else
                            Comece criando o primeiro documento.
                        @endif
                    </p>
                    @if(!request()->hasAny(['busca', 'categoria', 'status', 'ano', 'data_inicio', 'data_fim']))
                    <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Criar Primeiro Documento
                    </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Paginação -->
    @if($documentos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $documentos->appends(request()->query())->links() }}
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
                <p>Tem certeza que deseja excluir este documento?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção:</strong> Esta ação não pode ser desfeita. O documento e seu arquivo serão perdidos permanentemente.
                </div>
                <div class="bg-light p-3 rounded">
                    <strong>Documento:</strong> <span id="documentoNome"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir Documento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/documentos.js') }}"></script>
@endpush