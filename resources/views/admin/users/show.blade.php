@extends('layouts.admin')

@section('page-title', 'Visualizar Usuário')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuários</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">{{ $user->name }}</h1>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Informações Básicas -->
                <div class="col-md-8">
                    <!-- Dados Pessoais -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Nome Completo:</label>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Email:</label>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>CPF:</label>
                                        <span>{{ $user->cpf ?: 'Não informado' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Telefone:</label>
                                        <span>{{ $user->telefone ?: 'Não informado' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados Profissionais -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Dados Profissionais</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Cargo:</label>
                                        <span>{{ $user->cargo ?: 'Não informado' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Setor:</label>
                                        <span>{{ $user->setor ?: 'Não informado' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acesso e Permissões -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-key me-2"></i>Acesso e Permissões</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Tipo de Usuário:</label>
                                        <span>
                                            @if($user->role === 'admin')
                                                <span class="badge bg-danger">Administrador</span>
                                            @else
                                                <span class="badge bg-secondary">Usuário</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Status:</label>
                                        <span>
                                            @if($user->active)
                                                <span class="badge bg-success">Ativo</span>
                                            @else
                                                <span class="badge bg-danger">Inativo</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Email Verificado:</label>
                                        <span>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">Verificado</span>
                                                <small class="text-muted d-block">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge bg-warning">Não Verificado</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Último Login:</label>
                                        <span>
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->format('d/m/Y H:i') }}
                                                <small class="text-muted d-block">{{ $user->last_login_at->diffForHumans() }}</small>
                                            @else
                                                <span class="text-muted">Nunca fez login</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observações -->
                    @if($user->observacoes)
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $user->observacoes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Histórico de Atividades -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Histórico de Atividades</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6>Usuário criado</h6>
                                        <p class="text-muted mb-0">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @if($user->email_verified_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6>Email verificado</h6>
                                        <p class="text-muted mb-0">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                                @if($user->last_login_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6>Último login</h6>
                                        <p class="text-muted mb-0">{{ $user->last_login_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                                @if($user->updated_at != $user->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6>Última atualização</h6>
                                        <p class="text-muted mb-0">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Avatar e Ações Rápidas -->
                    <div class="admin-card mb-4">
                        <div class="card-body text-center">
                            <div class="user-avatar-large mb-3">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                     class="rounded-circle" width="120" height="120">
                            </div>
                            <h5>{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->cargo ?: 'Usuário do Sistema' }}</p>
                            
                            <div class="d-grid gap-2">
                                @if($user->id !== auth()->id())
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-user-id="{{ $user->id }}" 
                                               {{ $user->active ? 'checked' : '' }}>
                                        <label class="form-check-label ms-2">
                                            {{ $user->active ? 'Ativo' : 'Inativo' }}
                                        </label>
                                    </div>
                                    
                                    @if($user->active)
                                        <a href="{{ route('admin.users.impersonate', $user) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-user-secret me-2"></i>Fazer Login Como
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('admin.users.reset-password', $user) }}" 
                                       class="btn btn-outline-warning btn-sm"
                                       onclick="return confirm('Tem certeza que deseja resetar a senha?')">
                                        <i class="fas fa-key me-2"></i>Resetar Senha
                                    </a>
                                @endif
                                
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-2"></i>Editar Usuário
                                </a>
                                
                                @if($user->id !== auth()->id())
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-user" 
                                            data-user-id="{{ $user->id }}" 
                                            data-user-name="{{ $user->name }}">
                                        <i class="fas fa-trash me-2"></i>Excluir Usuário
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Estatísticas</h6>
                        </div>
                        <div class="card-body">
                            <div class="stat-item">
                                <span class="stat-label">Notícias Criadas:</span>
                                <span class="stat-value">{{ $user->noticias()->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Sessões Registradas:</span>
                                <span class="stat-value">{{ $user->sessoes()->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Documentos Criados:</span>
                                <span class="stat-value">{{ $user->documentos()->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Tempo no Sistema:</span>
                                <span class="stat-value">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Sistema -->
                    <div class="admin-card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações do Sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item-small">
                                <label>ID do Usuário:</label>
                                <span>#{{ $user->id }}</span>
                            </div>
                            <div class="info-item-small">
                                <label>Criado em:</label>
                                <span>{{ $user->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="info-item-small">
                                <label>Atualizado em:</label>
                                <span>{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
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
                <p>Tem certeza que deseja excluir o usuário <strong id="userName"></strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
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
.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    font-weight: 600;
    color: #495057;
    display: block;
    margin-bottom: 0.25rem;
}

.info-item span {
    color: #6c757d;
}

.info-item-small {
    margin-bottom: 0.5rem;
    font-size: 0.875em;
}

.info-item-small label {
    font-weight: 600;
    color: #495057;
    display: inline-block;
    width: 100px;
}

.user-avatar-large img {
    object-fit: cover;
    border: 4px solid #e9ecef;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.75rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -2.25rem;
    top: 0.25rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content h6 {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.stat-item {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e9ecef;
}

.stat-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.stat-label {
    font-weight: 500;
    color: #495057;
    flex: 1;
}

.stat-value {
    font-weight: 600;
    color: #007bff;
}

.badge {
    font-size: 0.75em;
}

.status-toggle {
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de status
    const statusToggle = document.querySelector('.status-toggle');
    if (statusToggle) {
        statusToggle.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const isActive = this.checked;
            
            fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualizar label
                    const label = this.nextElementSibling;
                    label.textContent = data.active ? 'Ativo' : 'Inativo';
                    
                    // Mostrar mensagem de sucesso
                    showAlert('success', data.message);
                    
                    // Recarregar página após 2 segundos para atualizar badges
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Reverter o toggle
                    this.checked = !isActive;
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                // Reverter o toggle
                this.checked = !isActive;
                showAlert('error', 'Erro ao alterar status do usuário');
            });
        });
    }

    // Modal de exclusão
    const deleteButton = document.querySelector('.delete-user');
    if (deleteButton) {
        deleteButton.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    }
});

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