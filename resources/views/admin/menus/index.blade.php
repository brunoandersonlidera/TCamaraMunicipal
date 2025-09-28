@extends('layouts.admin')

@section('page-title', 'Gestão de Menus')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Menus</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gestão de Menus</h1>
            <p class="text-muted">Gerencie os menus do cabeçalho e rodapé do site</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Menu
        </a>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.menus.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Título do menu...">
                </div>
                <div class="col-md-3">
                    <label for="posicao" class="form-label">Posição</label>
                    <select class="form-select" id="posicao" name="posicao">
                        <option value="">Todas as posições</option>
                        <option value="header" {{ request('posicao') === 'header' ? 'selected' : '' }}>Cabeçalho</option>
                        <option value="footer" {{ request('posicao') === 'footer' ? 'selected' : '' }}>Rodapé</option>
                        <option value="ambos" {{ request('posicao') === 'ambos' ? 'selected' : '' }}>Ambos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Menus -->
    <div class="admin-card">
        <div class="card-body">
            @if($menus->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">Ordem</th>
                                <th>Título</th>
                                <th>URL/Rota</th>
                                <th>Posição</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="menus-sortable">
                            @foreach($menus as $menu)
                            <tr data-id="{{ $menu->id }}" class="{{ $menu->parent_id ? 'submenu-row' : '' }}">
                                <td>
                                    <span class="badge bg-secondary">{{ $menu->ordem }}</span>
                                    @if($menu->parent_id)
                                        <i class="fas fa-level-up-alt text-muted ms-2" title="Submenu"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($menu->icone)
                                            <i class="{{ $menu->icone }} me-2"></i>
                                        @endif
                                        <div>
                                            <strong>{{ $menu->titulo }}</strong>
                                            @if($menu->parent)
                                                <br><small class="text-muted">↳ Submenu de: {{ $menu->parent->titulo }}</small>
                                            @endif
                                            @if($menu->children->count() > 0)
                                                <br><small class="text-info">{{ $menu->children->count() }} submenu(s)</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($menu->tipo === 'divider')
                                        <span class="text-muted">— Divisor —</span>
                                    @elseif($menu->rota)
                                        <code>{{ $menu->rota }}</code>
                                    @elseif($menu->url)
                                        <a href="{{ $menu->url }}" target="_blank" class="text-decoration-none">
                                            {{ Str::limit($menu->url, 40) }}
                                            @if($menu->nova_aba)
                                                <i class="fas fa-external-link-alt ms-1"></i>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($menu->posicao === 'header')
                                        <span class="badge bg-primary">Cabeçalho</span>
                                    @elseif($menu->posicao === 'footer')
                                        <span class="badge bg-info">Rodapé</span>
                                    @else
                                        <span class="badge bg-success">Ambos</span>
                                    @endif
                                </td>
                                <td>
                                    @if($menu->tipo === 'link')
                                        <span class="badge bg-light text-dark">Link</span>
                                    @elseif($menu->tipo === 'dropdown')
                                        <span class="badge bg-warning">Dropdown</span>
                                    @else
                                        <span class="badge bg-secondary">Divisor</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" type="checkbox" 
                                               data-id="{{ $menu->id }}" {{ $menu->ativo ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.menus.show', $menu) }}" 
                                           class="btn btn-sm btn-outline-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.menus.edit', $menu) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('{{ $menu->id }}')" title="Excluir">
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
                @if($menus->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $menus->links('pagination::bootstrap-5') }}
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bars fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum menu encontrado</h5>
                    <p class="text-muted">Comece criando o primeiro menu do sistema.</p>
                    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Criar Primeiro Menu
                    </a>
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
                <p>Tem certeza que deseja excluir este menu?</p>
                <p class="text-danger"><strong>Atenção:</strong> Esta ação não pode ser desfeita.</p>
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
// Toggle de status
document.querySelectorAll('.toggle-status').forEach(function(toggle) {
    toggle.addEventListener('change', function() {
        const menuId = this.dataset.id;
        const isActive = this.checked;
        
        fetch(`/admin/menus/${menuId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ativo: isActive })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                showAlert('error', data.message);
                this.checked = !isActive; // Reverter o toggle
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('error', 'Erro ao alterar status do menu');
            this.checked = !isActive; // Reverter o toggle
        });
    });
});

// Confirmação de exclusão
function confirmDelete(menuId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/menus/${menuId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Função para mostrar alertas
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