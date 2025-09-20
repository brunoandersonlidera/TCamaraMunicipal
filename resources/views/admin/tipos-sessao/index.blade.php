@extends('layouts.admin')

@section('title', 'Tipos de Sessão')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tipos de Sessão</h3>
                    <a href="{{ route('admin.tipos-sessao.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Novo Tipo
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Buscar por nome..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">Todos os status</option>
                                    <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                <a href="{{ route('admin.tipos-sessao.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Tabela -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Ordem</th>
                                    <th>Nome</th>
                                    <th>Cor</th>
                                    <th>Ícone</th>
                                    <th>Status</th>
                                    <th>Sessões</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tiposSessao as $tipo)
                                <tr>
                                    <td>{{ $tipo->ordem }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge mr-2 tipo-badge" data-cor="{{ $tipo->cor }}">
                                                <i class="{{ $tipo->icone }}"></i>
                                            </span>
                                            {{ $tipo->nome }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="color-preview" data-preview-cor="{{ $tipo->cor }}"></span>
                                        {{ $tipo->cor }}
                                    </td>
                                    <td>
                                        <i class="{{ $tipo->icone }}"></i>
                                        <small class="text-muted">{{ $tipo->icone }}</small>
                                    </td>
                                    <td>
                                        @if($tipo->ativo)
                                            <span class="badge badge-success">Ativo</span>
                                        @else
                                            <span class="badge badge-secondary">Inativo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $tipo->sessoes_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tipos-sessao.show', $tipo) }}" 
                                               class="btn btn-sm btn-info" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.tipos-sessao.edit', $tipo) }}" 
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.tipos-sessao.destroy', $tipo) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este tipo de sessão?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum tipo de sessão encontrado.</p>
                                            <a href="{{ route('admin.tipos-sessao.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Criar Primeiro Tipo
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    @if($tiposSessao->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $tiposSessao->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.color-preview {
    width: 20px;
    height: 20px;
    display: inline-block;
    border-radius: 3px;
    border: 1px solid #ddd;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.tipo-badge {
    color: white !important;
}
</style>
@endpush