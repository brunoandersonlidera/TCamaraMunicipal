@extends('layouts.admin')

@section('page-title', 'Configurações Gerais')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Configurações Gerais</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Configurações Gerais</h1>
            <p class="text-muted">Gerencie as configurações do site (brasão, logo, contatos, etc.)</p>
        </div>
        <a href="{{ route('admin.configuracao-geral.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nova Configuração
        </a>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.configuracao-geral.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Chave ou descrição...">
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Todos os tipos</option>
                        <option value="texto" {{ request('tipo') === 'texto' ? 'selected' : '' }}>Texto</option>
                        <option value="imagem" {{ request('tipo') === 'imagem' ? 'selected' : '' }}>Imagem</option>
                        <option value="email" {{ request('tipo') === 'email' ? 'selected' : '' }}>E-mail</option>
                        <option value="telefone" {{ request('tipo') === 'telefone' ? 'selected' : '' }}>Telefone</option>
                        <option value="endereco" {{ request('tipo') === 'endereco' ? 'selected' : '' }}>Endereço</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.configuracao-geral.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela -->
    <div class="admin-card">
        <div class="card-body">
            @if($configuracoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Chave</th>
                                <th>Descrição</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($configuracoes as $config)
                                <tr>
                                    <td>
                                        <strong>{{ $config->chave }}</strong>
                                    </td>
                                    <td>{{ $config->descricao }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($config->tipo) }}</span>
                                    </td>
                                    <td>
                                        @if($config->tipo === 'imagem' && $config->valor)
                                            <img src="{{ $config->url_imagem }}" alt="{{ $config->chave }}" 
                                                 class="img-thumbnail" style="max-width: 60px; max-height: 40px;">
                                        @else
                                            {{ Str::limit($config->valor, 50) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($config->ativo)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-secondary">Inativo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.configuracao-geral.edit', $config) }}" 
                                               class="btn btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.configuracao-geral.destroy', $config) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta configuração?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Excluir">
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
                @if($configuracoes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $configuracoes->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma configuração encontrada</h5>
                    <p class="text-muted">Comece criando uma nova configuração.</p>
                    <a href="{{ route('admin.configuracao-geral.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nova Configuração
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection