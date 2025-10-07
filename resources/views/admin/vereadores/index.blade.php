@extends('layouts.admin')

@section('page-title', 'Gerenciar Vereadores')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Vereadores</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gerenciar Vereadores</h1>
    <a href="{{ route('admin.vereadores.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Vereador
    </a>
</div>

<!-- Filtros -->
<div class="admin-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.vereadores.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nome ou partido...">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Todos</option>
                    <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="partido" class="form-label">Partido</label>
                <select class="form-select" id="partido" name="partido">
                    <option value="">Todos</option>
                    @foreach($partidos as $partido)
                        <option value="{{ $partido }}" {{ request('partido') === $partido ? 'selected' : '' }}>
                            {{ $partido }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search"></i> Filtrar
                </button>
                <a href="{{ route('admin.vereadores.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Lista de Vereadores -->
<div class="admin-card">
    <div class="card-body">
        @if($vereadores->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome Parlamentar</th>
                            <th>Nome Completo</th>
                            <th>Partido</th>
                            <th>Status</th>
                            <th>Mandato</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vereadores as $vereador)
                            <tr>
                                <td>
                                    <img src="{{ $vereador->foto_url }}" 
                                         alt="{{ $vereador->nome_parlamentar }}" 
                                         class="rounded-circle" width="40" height="40"
                                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder-vereador.svg') }}';">
                                </td>
                                <td>
                                    <strong>{{ $vereador->nome_parlamentar }}</strong>
                                </td>
                                <td>{{ $vereador->nome }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $vereador->partido }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $vereador->status === 'ativo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($vereador->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($vereador->inicio_mandato)
                                        {{ $vereador->inicio_mandato->format('Y') }} - 
                                        {{ $vereador->fim_mandato ? $vereador->fim_mandato->format('Y') : 'Atual' }}
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.vereadores.show', $vereador) }}" 
                                           class="btn btn-sm btn-outline-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.vereadores.edit', $vereador) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.vereadores.toggle-status', $vereador) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-{{ $vereador->status === 'ativo' ? 'warning' : 'success' }}" 
                                                    title="{{ $vereador->status === 'ativo' ? 'Desativar' : 'Ativar' }}">
                                                <i class="fas fa-{{ $vereador->status === 'ativo' ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.vereadores.destroy', $vereador) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Tem certeza que deseja excluir este vereador?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Mostrando {{ $vereadores->firstItem() }} a {{ $vereadores->lastItem() }} 
                    de {{ $vereadores->total() }} resultados
                </div>
                {{ $vereadores->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhum vereador encontrado</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'status', 'partido']))
                        Tente ajustar os filtros ou 
                        <a href="{{ route('admin.vereadores.index') }}">limpar a busca</a>.
                    @else
                        Comece cadastrando o primeiro vereador.
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'status', 'partido']))
                    <a href="{{ route('admin.vereadores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Cadastrar Primeiro Vereador
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection