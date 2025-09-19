@extends('layouts.admin')

@section('page-title', 'Sessões')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Sessões</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gerenciar Sessões</h1>
            <p class="text-muted">Gerencie as sessões da Câmara Municipal</p>
        </div>
        <a href="{{ route('admin.sessoes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nova Sessão
        </a>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.sessoes.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="busca" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="busca" name="busca" 
                           value="{{ request('busca') }}" 
                           placeholder="Número, título ou pauta...">
                </div>
                
                <div class="col-md-2">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Todos os tipos</option>
                        <option value="ordinaria" {{ request('tipo') === 'ordinaria' ? 'selected' : '' }}>Ordinária</option>
                        <option value="extraordinaria" {{ request('tipo') === 'extraordinaria' ? 'selected' : '' }}>Extraordinária</option>
                        <option value="solene" {{ request('tipo') === 'solene' ? 'selected' : '' }}>Solene</option>
                        <option value="especial" {{ request('tipo') === 'especial' ? 'selected' : '' }}>Especial</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="agendada" {{ request('status') === 'agendada' ? 'selected' : '' }}>Agendada</option>
                        <option value="em_andamento" {{ request('status') === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="finalizada" {{ request('status') === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                           value="{{ request('data_inicio') }}">
                </div>
                
                <div class="col-md-2">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                           value="{{ request('data_fim') }}">
                </div>
                
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela -->
    <div class="admin-card">
        <div class="card-body p-0">
            @if($sessoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Tipo</th>
                                <th>Título</th>
                                <th>Data/Hora</th>
                                <th>Local</th>
                                <th>Status</th>
                                <th>Presentes</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessoes as $sessao)
                            <tr>
                                <td>
                                    <strong>#{{ $sessao->numero }}</strong>
                                    <small class="text-muted d-block">{{ $sessao->legislatura }}ª Leg.</small>
                                </td>
                                <td>
                                    @switch($sessao->tipo)
                                        @case('ordinaria')
                                            <span class="badge bg-primary">Ordinária</span>
                                            @break
                                        @case('extraordinaria')
                                            <span class="badge bg-warning">Extraordinária</span>
                                            @break
                                        @case('solene')
                                            <span class="badge bg-info">Solene</span>
                                            @break
                                        @case('especial')
                                            <span class="badge bg-secondary">Especial</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="fw-medium">{{ Str::limit($sessao->titulo, 40) }}</div>
                                    @if($sessao->arquivo_pauta)
                                        <small class="text-success">
                                            <i class="fas fa-file-pdf me-1"></i>Pauta
                                        </small>
                                    @endif
                                    @if($sessao->arquivo_ata)
                                        <small class="text-info">
                                            <i class="fas fa-file-pdf me-1"></i>Ata
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $sessao->data_hora->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $sessao->data_hora->format('H:i') }}</small>
                                </td>
                                <td>{{ Str::limit($sessao->local, 30) }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-sessao-id="{{ $sessao->id }}" 
                                               data-current-status="{{ $sessao->status }}"
                                               {{ in_array($sessao->status, ['em_andamento', 'finalizada']) ? 'checked' : '' }}>
                                        <label class="form-check-label status-label">
                                            @switch($sessao->status)
                                                @case('agendada')
                                                    <span class="badge bg-secondary">Agendada</span>
                                                    @break
                                                @case('em_andamento')
                                                    <span class="badge bg-warning">Em Andamento</span>
                                                    @break
                                                @case('finalizada')
                                                    <span class="badge bg-success">Finalizada</span>
                                                    @break
                                                @case('cancelada')
                                                    <span class="badge bg-danger">Cancelada</span>
                                                    @break
                                            @endswitch
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $sessao->vereadores->count() }} vereadores
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sessoes.show', $sessao) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.sessoes.edit', $sessao) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        @if($sessao->arquivo_pauta)
                                            <a href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'pauta']) }}" 
                                               class="btn btn-sm btn-outline-info" title="Download Pauta">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        
                                        @if($sessao->arquivo_ata)
                                            <a href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'ata']) }}" 
                                               class="btn btn-sm btn-outline-success" title="Download Ata">
                                                <i class="fas fa-file-download"></i>
                                            </a>
                                        @endif
                                        
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-sessao" 
                                                data-sessao-id="{{ $sessao->id }}" 
                                                data-sessao-titulo="{{ $sessao->titulo }}" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                @if($sessoes->hasPages())
                    <div class="card-footer">
                        {{ $sessoes->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma sessão encontrada</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['busca', 'tipo', 'status', 'data_inicio', 'data_fim']))
                            Tente ajustar os filtros ou 
                            <a href="{{ route('admin.sessoes.index') }}">limpar a busca</a>.
                        @else
                            Comece criando sua primeira sessão.
                        @endif
                    </p>
                    @if(!request()->hasAny(['busca', 'tipo', 'status', 'data_inicio', 'data_fim']))
                        <a href="{{ route('admin.sessoes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Criar Primeira Sessão
                        </a>
                    @endif
                </div>
            @endif
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
                <p>Tem certeza que deseja excluir a sessão <strong id="sessaoTitulo"></strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita e todos os arquivos associados serão removidos.</small></p>
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

@push('styles')
<style>
.status-toggle {
    cursor: pointer;
}

.btn-group .btn {
    border-radius: 0.25rem !important;
    margin-right: 2px;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.table-responsive {
    border-radius: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de status
    const statusToggles = document.querySelectorAll('.status-toggle');
    statusToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const sessaoId = this.dataset.sessaoId;
            const currentStatus = this.dataset.currentStatus;
            
            fetch(`/admin/sessoes/${sessaoId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualizar o dataset
                    this.dataset.currentStatus = data.status;
                    
                    // Atualizar o badge
                    const statusLabel = this.nextElementSibling.querySelector('.badge');
                    statusLabel.className = 'badge ' + getBadgeClass(data.status);
                    statusLabel.textContent = data.status_label;
                    
                    // Mostrar mensagem de sucesso
                    showAlert('success', data.message);
                } else {
                    // Reverter o toggle
                    this.checked = !this.checked;
                    showAlert('error', data.message || 'Erro ao alterar status');
                }
            })
            .catch(error => {
                // Reverter o toggle
                this.checked = !this.checked;
                showAlert('error', 'Erro ao alterar status da sessão');
            });
        });
    });

    // Modal de exclusão
    const deleteButtons = document.querySelectorAll('.delete-sessao');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const sessaoId = this.dataset.sessaoId;
            const sessaoTitulo = this.dataset.sessaoTitulo;
            
            document.getElementById('sessaoTitulo').textContent = sessaoTitulo;
            document.getElementById('deleteForm').action = `/admin/sessoes/${sessaoId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

function getBadgeClass(status) {
    const classes = {
        'agendada': 'bg-secondary',
        'em_andamento': 'bg-warning',
        'finalizada': 'bg-success',
        'cancelada': 'bg-danger'
    };
    return classes[status] || 'bg-secondary';
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.querySelector('.container-fluid');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-remover após 5 segundos
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}
</script>
@endpush