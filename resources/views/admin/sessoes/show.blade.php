@extends('layouts.admin')

@section('page-title', 'Visualizar Sessão')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.sessoes.index') }}">Sessões</a></li>
        <li class="breadcrumb-item active">Sessão {{ $sessao->numero }}/{{ $sessao->legislatura }}</li>
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
                    <h1 class="h3 mb-0">
                        Sessão {{ $sessao->numero }}/{{ $sessao->legislatura }}
                        <span class="badge bg-{{ $sessao->status === 'finalizada' ? 'success' : ($sessao->status === 'em_andamento' ? 'warning' : ($sessao->status === 'cancelada' ? 'danger' : 'primary')) }} ms-2">
                            {{ ucfirst(str_replace('_', ' ', $sessao->status)) }}
                        </span>
                    </h1>
                    <p class="text-muted mb-0">{{ $sessao->titulo }}</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.sessoes.edit', $sessao) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item" onclick="toggleStatus('{{ $sessao->id }}')">
                                <i class="fas fa-toggle-on me-2"></i>Alterar Status
                            </button>
                        </li>
                        @if($sessao->arquivo_pauta)
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'pauta']) }}">
                                <i class="fas fa-download me-2"></i>Download Pauta
                            </a>
                        </li>
                        @endif
                        @if($sessao->arquivo_ata)
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'ata']) }}">
                                <i class="fas fa-download me-2"></i>Download Ata
                            </a>
                        </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item text-danger" onclick="confirmDelete('{{ $sessao->id }}')">
                                <i class="fas fa-trash me-2"></i>Excluir
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Informações Básicas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações Básicas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Número da Sessão:</label>
                                <div class="info-value">{{ $sessao->numero }}</div>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Tipo:</label>
                                <div class="info-value">
                                    <span class="badge bg-secondary">{{ ucfirst($sessao->tipo) }}</span>
                                </div>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Legislatura:</label>
                                <div class="info-value">{{ $sessao->legislatura }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Sessão Legislativa:</label>
                                <div class="info-value">{{ $sessao->sessao_legislativa }}</div>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Status:</label>
                                <div class="info-value">
                                    <span class="badge bg-{{ $sessao->status === 'finalizada' ? 'success' : ($sessao->status === 'em_andamento' ? 'warning' : ($sessao->status === 'cancelada' ? 'danger' : 'primary')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $sessao->status)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Data de Criação:</label>
                                <div class="info-value">{{ $sessao->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data, Hora e Local -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Data, Hora e Local</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Data e Hora:</label>
                                <div class="info-value">
                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                    {{ $sessao->data_hora ? $sessao->data_hora->format('d/m/Y') : 'Não definida' }}
                                    @if($sessao->data_hora)
                                        <br>
                                        <i class="fas fa-clock me-2 text-primary"></i>
                                        {{ $sessao->data_hora->format('H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Local:</label>
                                <div class="info-value">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    {{ $sessao->local ?: 'Não informado' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pauta -->
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Pauta</h5>
                    @if($sessao->arquivo_pauta)
                        <a href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'pauta']) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($sessao->pauta)
                        <div class="content-text">
                            {!! nl2br(e($sessao->pauta)) !!}
                        </div>
                    @else
                        <div class="text-muted text-center py-3">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <p>Pauta não informada</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ata -->
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Ata</h5>
                    @if($sessao->arquivo_ata)
                        <a href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'ata']) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($sessao->ata)
                        <div class="content-text">
                            {!! nl2br(e($sessao->ata)) !!}
                        </div>
                    @else
                        <div class="text-muted text-center py-3">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <p>Ata não registrada</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vereadores Presentes -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>Vereadores Presentes 
                        <span class="badge bg-info ms-2">{{ $sessao->vereadores->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($sessao->vereadores->count() > 0)
                        <div class="row">
                            @foreach($sessao->vereadores as $vereador)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $vereador->foto_url }}" 
                                         alt="{{ $vereador->nome }}" 
                                         class="rounded-circle me-3" 
                                         style="width: 40px; height: 40px; object-fit: cover;"
                                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder-vereador.svg') }}';">
                                    <div>
                                        <div class="fw-bold">{{ $vereador->nome }}</div>
                                        <small class="text-muted">{{ $vereador->partido }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted text-center py-3">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <p>Nenhum vereador marcado como presente</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Transmissão -->
            @if($sessao->transmissao_url || $sessao->youtube_url)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-video me-2"></i>Transmissão</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($sessao->transmissao_url)
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">URL de Transmissão:</label>
                                <div class="info-value">
                                    <a href="{{ $sessao->transmissao_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-2"></i>Acessar Transmissão
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($sessao->youtube_url)
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">YouTube:</label>
                                <div class="info-value">
                                    <a href="{{ $sessao->youtube_url }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                        <i class="fab fa-youtube me-2"></i>Assistir no YouTube
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Observações -->
            @if($sessao->observacoes)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                </div>
                <div class="card-body">
                    <div class="content-text">
                        {!! nl2br(e($sessao->observacoes)) !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Estatísticas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Estatísticas</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-primary">{{ $sessao->vereadores->count() }}</div>
                                <div class="stat-label">Presentes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-info">{{ $totalVereadores - $sessao->vereadores->count() }}</div>
                                <div class="stat-label">Ausentes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-success">{{ number_format(($sessao->vereadores->count() / max($totalVereadores, 1)) * 100, 1) }}%</div>
                                <div class="stat-label">Presença</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-warning">{{ $totalVereadores }}</div>
                                <div class="stat-label">Total</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="admin-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.sessoes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar para Lista
                        </a>
                        <div>
                            <a href="{{ route('admin.sessoes.edit', $sessao) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-2"></i>Editar Sessão
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $sessao->id }}')">
                                <i class="fas fa-trash me-2"></i>Excluir
                            </button>
                        </div>
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
                <p>Tem certeza que deseja excluir esta sessão?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção:</strong> Esta ação não pode ser desfeita. Todos os dados da sessão serão perdidos permanentemente.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir Sessão
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.info-group {
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 0.5rem;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    color: #212529;
    font-size: 0.95rem;
}

.content-text {
    line-height: 1.6;
    color: #495057;
}

.stat-item {
    padding: 1rem;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.admin-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(sessaoId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/sessoes/${sessaoId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function toggleStatus(sessaoId) {
    // Implementar modal ou dropdown para alterar status
    console.log('Toggle status for sessao:', sessaoId);
}
</script>
@endpush