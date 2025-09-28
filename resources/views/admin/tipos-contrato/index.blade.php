@extends('layouts.admin')

@section('title', 'Tipos de Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tipos de Contrato</h3>
                    <a href="{{ route('admin.tipos-contrato.create') }}" class="btn btn-primary">
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
                                <a href="{{ route('admin.tipos-contrato.index') }}" class="btn btn-outline-secondary">
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
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Status</th>
                                    <th>Contratos</th>
                                    <th>Criado em</th>
                                    <th width="200">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tiposContrato as $tipo)
                                <tr>
                                    <td>{{ $tipo->id }}</td>
                                    <td>
                                        <strong>{{ $tipo->nome }}</strong>
                                    </td>
                                    <td>
                                        {{ Str::limit($tipo->descricao, 50) }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $tipo->ativo ? 'success' : 'danger' }}">
                                            {{ $tipo->ativo ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $tipo->contratos_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td>{{ $tipo->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tipos-contrato.show', $tipo) }}" 
                                               class="btn btn-sm btn-info" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.tipos-contrato.edit', $tipo) }}" 
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-{{ $tipo->ativo ? 'secondary' : 'success' }}"
                                                    onclick="toggleStatus({{ $tipo->id }})"
                                                    title="{{ $tipo->ativo ? 'Desativar' : 'Ativar' }}">
                                                <i class="fas fa-{{ $tipo->ativo ? 'ban' : 'check' }}"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete({{ $tipo->id }})"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum tipo de contrato encontrado.</p>
                                            <a href="{{ route('admin.tipos-contrato.create') }}" class="btn btn-primary">
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
                    @if($tiposContrato->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $tiposContrato->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este tipo de contrato?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id) {
    fetch(`/admin/tipos-contrato/${id}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao alterar status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao alterar status');
    });
}

function confirmDelete(id) {
    document.getElementById('deleteForm').action = `/admin/tipos-contrato/${id}`;
    $('#deleteModal').modal('show');
}
</script>
@endpush