@extends('layouts.admin')

@section('page-title', 'Visualizar Menu')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.menus.index') }}">Menus</a></li>
        <li class="breadcrumb-item active">{{ $menu->titulo }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 d-flex align-items-center">
                @if($menu->icone)
                    <i class="{{ $menu->icone }} me-2"></i>
                @endif
                {{ $menu->titulo }}
                @if(!$menu->ativo)
                    <span class="badge bg-secondary ms-2">Inativo</span>
                @endif
            </h1>
            <p class="text-muted">Detalhes do menu</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="fas fa-trash me-2"></i>Excluir
            </button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informações Principais -->
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações Básicas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Título:</label>
                                <p class="mb-0">{{ $menu->titulo }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Slug:</label>
                                <p class="mb-0">
                                    <code>{{ $menu->slug ?: 'Não definido' }}</code>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo:</label>
                                <p class="mb-0">
                                    @switch($menu->tipo)
                                        @case('link')
                                            <span class="badge bg-primary">Link</span>
                                            @break
                                        @case('dropdown')
                                            <span class="badge bg-info">Dropdown</span>
                                            @break
                                        @case('divider')
                                            <span class="badge bg-secondary">Divisor</span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark">{{ ucfirst($menu->tipo) }}</span>
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Posição:</label>
                                <p class="mb-0">
                                    @switch($menu->posicao)
                                        @case('header')
                                            <span class="badge bg-success">Cabeçalho</span>
                                            @break
                                        @case('footer')
                                            <span class="badge bg-warning">Rodapé</span>
                                            @break
                                        @case('ambos')
                                            <span class="badge bg-info">Ambos</span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark">{{ ucfirst($menu->posicao) }}</span>
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        @if($menu->url || $menu->rota)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Link:</label>
                                    <p class="mb-0">
                                        @if($menu->url)
                                            <a href="{{ $menu->url }}" target="_blank" class="text-decoration-none">
                                                {{ $menu->url }} <i class="fas fa-external-link-alt ms-1"></i>
                                            </a>
                                        @elseif($menu->rota)
                                            <code>{{ $menu->rota }}</code>
                                            @if($menu->getUrlCompleta())
                                                <br>
                                                <small class="text-muted">
                                                    URL: <a href="{{ $menu->getUrlCompleta() }}" target="_blank">{{ $menu->getUrlCompleta() }}</a>
                                                </small>
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if($menu->icone)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ícone:</label>
                                    <p class="mb-0">
                                        <i class="{{ $menu->icone }} me-2"></i>
                                        <code>{{ $menu->icone }}</code>
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if($menu->descricao)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Descrição:</label>
                                    <p class="mb-0">{{ $menu->descricao }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submenus -->
            @if($menu->children->count() > 0)
                <div class="admin-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Submenus ({{ $menu->children->count() }})</h5>
                        <a href="{{ route('admin.menus.create', ['parent_id' => $menu->id]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>Adicionar Submenu
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Ordem</th>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menu->children->sortBy('ordem') as $submenu)
                                        <tr>
                                            <td>{{ $submenu->ordem }}</td>
                                            <td>
                                                @if($submenu->icone)
                                                    <i class="{{ $submenu->icone }} me-2"></i>
                                                @endif
                                                {{ $submenu->titulo }}
                                            </td>
                                            <td>
                                                @switch($submenu->tipo)
                                                    @case('link')
                                                        <span class="badge bg-primary">Link</span>
                                                        @break
                                                    @case('dropdown')
                                                        <span class="badge bg-info">Dropdown</span>
                                                        @break
                                                    @case('divider')
                                                        <span class="badge bg-secondary">Divisor</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($submenu->ativo)
                                                    <span class="badge bg-success">Ativo</span>
                                                @else
                                                    <span class="badge bg-secondary">Inativo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.menus.show', $submenu) }}" class="btn btn-outline-info" title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.menus.edit', $submenu) }}" class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Configurações e Informações -->
        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Configurações</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <p class="mb-0">
                            @if($menu->ativo)
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-secondary">Inativo</span>
                            @endif
                        </p>
                    </div>

                    @if($menu->parent)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Menu Pai:</label>
                            <p class="mb-0">
                                <a href="{{ route('admin.menus.show', $menu->parent) }}" class="text-decoration-none">
                                    {{ $menu->parent->titulo }}
                                </a>
                            </p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ordem:</label>
                        <p class="mb-0">{{ $menu->ordem }}</p>
                    </div>

                    @if($menu->permissao)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Permissão:</label>
                            <p class="mb-0">
                                <code>{{ $menu->permissao }}</code>
                            </p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nova Aba:</label>
                        <p class="mb-0">
                            @if($menu->nova_aba)
                                <span class="badge bg-info">Sim</span>
                            @else
                                <span class="badge bg-secondary">Não</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Sistema</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p class="mb-0"><code>{{ $menu->id }}</code></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Criado em:</label>
                        <p class="mb-0">{{ $menu->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Atualizado em:</label>
                        <p class="mb-0">{{ $menu->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    @if($menu->children->count() > 0)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Submenus:</label>
                            <p class="mb-0">{{ $menu->children->count() }} item(s)</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.menus.toggle-status', $menu) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-{{ $menu->ativo ? 'warning' : 'success' }} w-100">
                                <i class="fas fa-{{ $menu->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                                {{ $menu->ativo ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>

                        @if($menu->tipo === 'dropdown')
                            <a href="{{ route('admin.menus.create', ['parent_id' => $menu->id]) }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Adicionar Submenu
                            </a>
                        @endif

                        <a href="{{ route('admin.menus.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>Novo Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o menu <strong>{{ $menu->titulo }}</strong>?</p>
                @if($menu->children->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção:</strong> Este menu possui {{ $menu->children->count() }} submenu(s) que também serão excluídos.
                    </div>
                @endif
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection