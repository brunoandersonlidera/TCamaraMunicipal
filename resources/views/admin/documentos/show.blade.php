@extends('layouts.admin')

@section('page-title', 'Visualizar Documento')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.documentos.index') }}">Documentos</a></li>
        <li class="breadcrumb-item active">{{ $documento->titulo }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 mb-2">{{ $documento->titulo }}</h1>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-{{ $documento->ativo ? 'success' : 'danger' }} fs-6">
                    {{ $documento->ativo ? 'Ativo' : 'Inativo' }}
                </span>
                @if($documento->destaque)
                <span class="badge bg-warning text-dark fs-6">
                    <i class="fas fa-star me-1"></i>Em Destaque
                </span>
                @endif
                <span class="badge bg-light text-dark fs-6">{{ ucfirst($documento->categoria) }}</span>
                @if($documento->numero)
                <span class="text-muted">Nº {{ $documento->numero }}</span>
                @endif
            </div>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <button type="button" class="btn btn-outline-{{ $documento->ativo ? 'warning' : 'success' }}" 
                    onclick="toggleStatus()">
                <i class="fas fa-{{ $documento->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                {{ $documento->ativo ? 'Desativar' : 'Ativar' }}
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @if($documento->arquivo)
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.documentos.download', $documento) }}">
                            <i class="fas fa-download me-2"></i>Download Arquivo
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @endif
                    <li>
                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Excluir Documento
                        </a>
                    </li>
                </ul>
            </div>
            <a href="{{ route('admin.documentos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Informações Básicas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações Básicas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Título</label>
                                <div class="fw-bold">{{ $documento->titulo }}</div>
                            </div>
                        </div>
                        @if($documento->numero)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Número</label>
                                <div class="fw-bold">{{ $documento->numero }}</div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Categoria</label>
                                <div>
                                    <span class="badge bg-light text-dark fs-6">{{ ucfirst($documento->categoria) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Data do Documento</label>
                                <div class="fw-bold">{{ $documento->data_documento->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        @if($documento->descricao)
                        <div class="col-12">
                            <div class="mb-0">
                                <label class="form-label text-muted">Descrição</label>
                                <div class="border rounded p-3 bg-light">
                                    {{ $documento->descricao }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Arquivo -->
            @if($documento->arquivo)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file me-2"></i>Arquivo</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-file fa-3x text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $documento->nome_original }}</div>
                                <div class="text-muted">
                                    {{ number_format($documento->tamanho / 1024, 1) }} KB
                                    @if($documento->tipo_arquivo)
                                    • {{ strtoupper($documento->tipo_arquivo) }}
                                    @endif
                                </div>
                                <small class="text-muted">
                                    Enviado em {{ $documento->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.documentos.download', $documento) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file me-2"></i>Arquivo</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Nenhum arquivo anexado</strong><br>
                        Este documento não possui arquivo anexado. 
                        <a href="{{ route('admin.documentos.edit', $documento) }}">Clique aqui para adicionar um arquivo</a>.
                    </div>
                </div>
            </div>
            @endif

            <!-- Observações -->
            @if($documento->observacoes)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações Internas</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Observações internas:</strong> Estas informações não aparecem no site público.
                    </div>
                    <div class="border rounded p-3 bg-light">
                        {{ $documento->observacoes }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Status e Configurações -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Status e Configurações</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span>Status:</span>
                        <span class="badge bg-{{ $documento->ativo ? 'success' : 'danger' }} fs-6">
                            {{ $documento->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span>Destaque:</span>
                        @if($documento->destaque)
                        <span class="badge bg-warning text-dark fs-6">
                            <i class="fas fa-star me-1"></i>Em Destaque
                        </span>
                        @else
                        <span class="text-muted">Não</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span>Categoria:</span>
                        <span class="badge bg-light text-dark">{{ ucfirst($documento->categoria) }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <span>Visibilidade:</span>
                        <span class="text-{{ $documento->ativo ? 'success' : 'danger' }}">
                            <i class="fas fa-{{ $documento->ativo ? 'eye' : 'eye-slash' }} me-1"></i>
                            {{ $documento->ativo ? 'Público' : 'Oculto' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Estatísticas</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h4 mb-0 text-primary">{{ $documento->downloads ?? 0 }}</div>
                                <small class="text-muted">Downloads</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0 text-info">{{ $documento->visualizacoes ?? 0 }}</div>
                            <small class="text-muted">Visualizações</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Editar Documento
                        </a>
                        
                        <button type="button" class="btn btn-outline-{{ $documento->ativo ? 'warning' : 'success' }}" 
                                onclick="toggleStatus()">
                            <i class="fas fa-{{ $documento->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                            {{ $documento->ativo ? 'Desativar' : 'Ativar' }}
                        </button>

                        @if($documento->arquivo)
                        <a href="{{ route('admin.documentos.download', $documento) }}" class="btn btn-outline-info">
                            <i class="fas fa-download me-2"></i>Download Arquivo
                        </a>
                        @endif

                        <button type="button" class="btn btn-outline-warning" onclick="toggleDestaque()">
                            <i class="fas fa-star me-2"></i>
                            {{ $documento->destaque ? 'Remover Destaque' : 'Destacar' }}
                        </button>

                        <hr>

                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Excluir Documento
                        </button>
                    </div>
                </div>
            </div>

            <!-- Informações do Sistema -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info me-2"></i>Informações do Sistema</h5>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <div class="mb-2">
                            <strong>ID:</strong> {{ $documento->id }}
                        </div>
                        <div class="mb-2">
                            <strong>Criado em:</strong><br>
                            {{ $documento->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="mb-2">
                            <strong>Última atualização:</strong><br>
                            {{ $documento->updated_at->format('d/m/Y H:i') }}
                        </div>
                        @if($documento->arquivo)
                        <div class="mb-2">
                            <strong>Arquivo:</strong><br>
                            {{ $documento->arquivo }}
                        </div>
                        <div>
                            <strong>Tamanho:</strong><br>
                            {{ number_format($documento->tamanho / 1024, 1) }} KB
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção!</strong> Esta ação não pode ser desfeita.
                </div>
                <p>Tem certeza que deseja excluir o documento <strong>"{{ $documento->titulo }}"</strong>?</p>
                @if($documento->arquivo)
                <p class="text-muted">O arquivo anexado também será removido permanentemente.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.documentos.destroy', $documento) }}" method="POST" style="display: inline;">
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

<!-- Modal de Toggle Status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Alterar Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja <strong>{{ $documento->ativo ? 'desativar' : 'ativar' }}</strong> este documento?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Documentos inativos não aparecem no site público da Câmara Municipal.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.documentos.toggle-status', $documento) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $documento->ativo ? 'warning' : 'success' }}">
                        <i class="fas fa-{{ $documento->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                        {{ $documento->ativo ? 'Desativar' : 'Ativar' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Toggle Destaque -->
<div class="modal fade" id="destaqueModal" tabindex="-1" aria-labelledby="destaqueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="destaqueModalLabel">Alterar Destaque</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja <strong>{{ $documento->destaque ? 'remover o destaque' : 'destacar' }}</strong> este documento?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Documentos em destaque aparecem em posição de maior visibilidade no site público.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.documentos.toggle-destaque', $documento) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-star me-2"></i>
                        {{ $documento->destaque ? 'Remover Destaque' : 'Destacar' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.admin-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}

.border-end {
    border-right: 1px solid #dee2e6 !important;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function toggleStatus() {
    const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
    statusModal.show();
}

function toggleDestaque() {
    const destaqueModal = new bootstrap.Modal(document.getElementById('destaqueModal'));
    destaqueModal.show();
}
</script>
@endpush