@extends('layouts.admin')

@section('title', 'Comitês de Iniciativa Popular')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Comitês de Iniciativa Popular</h3>
                    <a href="{{ route('admin.comites-iniciativa-popular.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Novo Comitê
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('admin.comites-iniciativa-popular.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" 
                                           placeholder="Buscar por nome..." 
                                           value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('admin.comites-iniciativa-popular.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <select class="form-select" name="status" onchange="this.form.submit()">
                                    <option value="">Todos os status</option>
                                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="validado" {{ request('status') == 'validado' ? 'selected' : '' }}>Validado</option>
                                    <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                    <option value="arquivado" {{ request('status') == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('admin.comites-iniciativa-popular.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <select class="form-select" name="assinaturas" onchange="this.form.submit()">
                                    <option value="">Todas as assinaturas</option>
                                    <option value="atingiu" {{ request('assinaturas') == 'atingiu' ? 'selected' : '' }}>Atingiu mínimo</option>
                                    <option value="nao_atingiu" {{ request('assinaturas') == 'nao_atingiu' ? 'selected' : '' }}>Não atingiu mínimo</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <h4>{{ $comites->total() }}</h4>
                                    <p class="mb-0">Total de Comitês</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h4>{{ $comites->where('status', 'validado')->count() }}</h4>
                                    <p class="mb-0">Validados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <h4>{{ $comites->where('status', 'ativo')->count() }}</h4>
                                    <p class="mb-0">Ativos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-signature fa-2x mb-2"></i>
                                    <h4>{{ $comites->sum('numero_assinaturas') }}</h4>
                                    <p class="mb-0">Total Assinaturas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Assinaturas</th>
                                    <th>Status</th>
                                    <th>Criado em</th>
                                    <th width="200">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($comites as $comite)
                                    <tr>
                                        <td>
                                            <strong>{{ $comite->nome }}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-{{ $comite->atingiuMinimoAssinaturas() ? 'success' : 'warning' }} me-2">
                                                    {{ number_format($comite->numero_assinaturas, 0, ',', '.') }}
                                                </span>
                                                <small class="text-muted">
                                                    / {{ number_format($comite->minimo_assinaturas, 0, ',', '.') }}
                                                    ({{ number_format($comite->getPercentualAssinaturas(), 1) }}%)
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $comite->status == 'ativo' ? 'success' : ($comite->status == 'validado' ? 'primary' : ($comite->status == 'rejeitado' ? 'danger' : 'secondary')) }}">
                                                {{ ucfirst($comite->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $comite->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.comites-iniciativa-popular.show', $comite) }}" 
                                                   class="btn btn-sm btn-info" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.comites-iniciativa-popular.edit', $comite) }}" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-{{ $comite->status == 'ativo' ? 'secondary' : 'success' }}" 
                                                        onclick="toggleStatus({{ $comite->id }})" 
                                                        title="{{ $comite->status == 'ativo' ? 'Desativar' : 'Ativar' }}">
                                                    <i class="fas fa-{{ $comite->status == 'ativo' ? 'pause' : 'play' }}"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="confirmDelete({{ $comite->id }})" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum comitê encontrado.</p>
                                            <a href="{{ route('admin.comites-iniciativa-popular.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Cadastrar Primeiro Comitê
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    @if($comites->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $comites->appends(request()->query())->links() }}
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
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este comitê?</p>
                <p class="text-danger"><strong>Esta ação não pode ser desfeita.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
function confirmDelete(id) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/comites-iniciativa-popular/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function toggleStatus(id) {
    if (confirm('Tem certeza que deseja alterar o status deste comitê?')) {
        fetch(`/admin/comites-iniciativa-popular/${id}/toggle-status`, {
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
                alert('Erro ao alterar status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao alterar status');
        });
    }
}
</script>
@endpush