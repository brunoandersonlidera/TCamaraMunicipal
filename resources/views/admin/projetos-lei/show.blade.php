@extends('layouts.admin')

@section('page-title', 'Visualizar Projeto de Lei')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.projetos-lei.index') }}">Projetos de Lei</a></li>
        <li class="breadcrumb-item active">Projeto {{ $projetoLei->numero }}/{{ $projetoLei->ano }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                {{ ucfirst(str_replace('_', ' ', $projetoLei->tipo)) }} nº {{ $projetoLei->numero }}/{{ $projetoLei->ano }}
                @if($projetoLei->urgente)
                    <span class="badge bg-warning text-dark ms-2">
                        <i class="fas fa-exclamation-triangle me-1"></i>Urgente
                    </span>
                @endif
                @if($projetoLei->destaque)
                    <span class="badge bg-info ms-2">
                        <i class="fas fa-star me-1"></i>Destaque
                    </span>
                @endif
            </h1>
            <p class="text-muted mb-0">{{ $projetoLei->titulo }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.projetos-lei.edit', $projetoLei) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                <i class="fas fa-trash me-2"></i>Excluir
            </button>
            <a href="{{ route('admin.projetos-lei.index') }}" class="btn btn-outline-secondary">
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
                                <label class="form-label fw-bold">Número:</label>
                                <p class="mb-0">{{ $projetoLei->numero }}/{{ $projetoLei->ano }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo:</label>
                                <p class="mb-0">
                                    <span class="badge bg-info">
                                        {{ ucfirst(str_replace('_', ' ', $projetoLei->tipo)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Data de Apresentação:</label>
                                <p class="mb-0">{{ $projetoLei->data_protocolo->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $projetoLei->status === 'aprovado' ? 'success' : ($projetoLei->status === 'rejeitado' ? 'danger' : ($projetoLei->status === 'tramitando' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst($projetoLei->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Título:</label>
                                <p class="mb-0">{{ $projetoLei->titulo }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-0">
                                <label class="form-label fw-bold">Ementa:</label>
                                <p class="mb-0">{{ $projetoLei->ementa }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Autoria -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Autoria</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Autor Principal:</label>
                                <div class="d-flex align-items-center">
                                    @if($projetoLei->isAutoriaVereador() && $projetoLei->autor)
                                        <img src="{{ $projetoLei->autor->foto_url }}" 
                                             alt="{{ $projetoLei->getAutorCompleto() }}" 
                                             class="rounded-circle me-3" 
                                             style="width: 50px; height: 50px; object-fit: cover;"
                                             onerror="this.onerror=null;this.src='{{ asset('images/placeholder-vereador.svg') }}';">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 50px; height: 50px;">
                                            @if($projetoLei->isIniciativaPopular())
                                                <i class="fas fa-users text-white"></i>
                                            @elseif($projetoLei->isAutoriaExecutivo())
                                                <i class="fas fa-building text-white"></i>
                                            @elseif($projetoLei->isAutoriaComissao())
                                                <i class="fas fa-users-cog text-white"></i>
                                            @else
                                                <i class="fas fa-user text-white"></i>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $projetoLei->getAutorCompleto() }}</div>
                                        <small class="text-muted">
                                            <span class="badge bg-info">
                                                {{ ucfirst(str_replace('_', ' ', $projetoLei->tipo_autoria)) }}
                                            </span>
                                            @if($projetoLei->isAutoriaVereador() && $projetoLei->autor)
                                                - {{ $projetoLei->autor->partido }} - {{ $projetoLei->autor->cargo }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                
                                @if($projetoLei->isIniciativaPopular() && $projetoLei->getDetalhesIniciativaPopular())
                                    <div class="mt-3">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Projeto de iniciativa popular
                                        </small>
                                        @php $detalhes = $projetoLei->getDetalhesIniciativaPopular(); @endphp
                                        @if(isset($detalhes['responsavel']))
                                            <small class="text-muted d-block">
                                                <strong>Responsável:</strong> {{ $detalhes['responsavel'] }}
                                            </small>
                                        @endif
                                        @if(isset($detalhes['assinaturas']))
                                            <small class="text-muted d-block">
                                                <strong>Assinaturas:</strong> {{ number_format($detalhes['assinaturas']) }}
                                            </small>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($projetoLei->coautores && $projetoLei->coautores->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Coautores</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($projetoLei->coautores as $vereador)
                                        <span class="badge bg-light text-dark border">
                                            {{ $vereador->nome }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Conteúdo -->
            @if($projetoLei->justificativa || $projetoLei->texto_integral)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Conteúdo</h5>
                </div>
                <div class="card-body">
                    @if($projetoLei->justificativa)
                    <div class="mb-4">
                        <label class="form-label fw-bold">Justificativa:</label>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($projetoLei->justificativa)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($projetoLei->texto_integral)
                    <div class="mb-0">
                        <label class="form-label fw-bold">Texto Integral:</label>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($projetoLei->texto_integral)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Arquivos -->
            @if($projetoLei->arquivo_projeto || $projetoLei->arquivo_lei)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-paperclip me-2"></i>Arquivos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($projetoLei->arquivo_projeto)
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center">
                                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                <h6>Arquivo do Projeto</h6>
                                <p class="text-muted small mb-3">{{ basename($projetoLei->arquivo_projeto) }}</p>
                                <a href="{{ route('admin.projetos-lei.download', ['projeto' => $projetoLei, 'tipo' => 'projeto']) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-download me-2"></i>Download
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($projetoLei->arquivo_lei)
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center">
                                <i class="fas fa-file-pdf fa-3x text-success mb-3"></i>
                                <h6>Arquivo da Lei</h6>
                                <p class="text-muted small mb-3">{{ basename($projetoLei->arquivo_lei) }}</p>
                                <a href="{{ route('admin.projetos-lei.download', ['projeto' => $projetoLei, 'tipo' => 'lei']) }}" 
                                   class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-download me-2"></i>Download
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Observações -->
            @if($projetoLei->observacoes)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações Internas</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Observações internas:</strong> Estas informações não aparecem no site público.
                    </div>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($projetoLei->observacoes)) !!}
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
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Atual:</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $projetoLei->status === 'aprovado' ? 'success' : ($projetoLei->status === 'rejeitado' ? 'danger' : ($projetoLei->status === 'tramitando' ? 'warning' : 'secondary')) }} fs-6">
                                {{ ucfirst($projetoLei->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Configurações:</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-{{ $projetoLei->ativo ? 'check-circle text-success' : 'times-circle text-danger' }} me-2"></i>
                                <span>{{ $projetoLei->ativo ? 'Ativo' : 'Inativo' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-{{ $projetoLei->urgente ? 'exclamation-triangle text-warning' : 'clock text-muted' }} me-2"></i>
                                <span>{{ $projetoLei->urgente ? 'Regime de Urgência' : 'Tramitação Normal' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-{{ $projetoLei->destaque ? 'star text-info' : 'star-o text-muted' }} me-2"></i>
                                <span>{{ $projetoLei->destaque ? 'Em Destaque' : 'Sem Destaque' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-{{ $projetoLei->ativo ? 'warning' : 'success' }}" 
                                onclick="toggleStatus()">
                            <i class="fas fa-{{ $projetoLei->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                            {{ $projetoLei->ativo ? 'Desativar' : 'Ativar' }} Projeto
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tramitação -->
            @if($projetoLei->comissao_atual || $projetoLei->data_aprovacao || $projetoLei->numero_lei)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-route me-2"></i>Tramitação</h5>
                </div>
                <div class="card-body">
                    @if($projetoLei->comissao_atual)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Comissão Atual:</label>
                        <p class="mb-0">{{ $projetoLei->comissao_atual }}</p>
                    </div>
                    @endif

                    @if($projetoLei->data_aprovacao)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Data de Aprovação:</label>
                        <p class="mb-0">{{ $projetoLei->data_aprovacao->format('d/m/Y') }}</p>
                    </div>
                    @endif

                    @if($projetoLei->numero_lei)
                    <div class="mb-0">
                        <label class="form-label fw-bold">Número da Lei:</label>
                        <p class="mb-0">
                            <span class="badge bg-success">Lei nº {{ $projetoLei->numero_lei }}</span>
                        </p>
                    </div>
                    @endif
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
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-0">{{ ($projetoLei->coautores ? $projetoLei->coautores->count() : 0) + 1 }}</h4>
                                <small class="text-muted">Autores</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info mb-0">{{ $projetoLei->created_at->diffInDays() }}</h4>
                            <small class="text-muted">Dias</small>
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
                        <a href="{{ route('admin.projetos-lei.edit', $projetoLei) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Editar Projeto
                        </a>
                        
                        @if($projetoLei->arquivo_projeto)
                        <a href="{{ route('admin.projetos-lei.download', ['projeto' => $projetoLei, 'tipo' => 'projeto']) }}" 
                           class="btn btn-outline-info">
                            <i class="fas fa-download me-2"></i>Download Projeto
                        </a>
                        @endif
                        
                        @if($projetoLei->arquivo_lei)
                        <a href="{{ route('admin.projetos-lei.download', ['projeto' => $projetoLei, 'tipo' => 'lei']) }}" 
                           class="btn btn-outline-success">
                            <i class="fas fa-download me-2"></i>Download Lei
                        </a>
                        @endif
                        
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Excluir Projeto
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
                            <strong>Criado em:</strong><br>
                            {{ $projetoLei->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="mb-2">
                            <strong>Última atualização:</strong><br>
                            {{ $projetoLei->updated_at->format('d/m/Y H:i') }}
                        </div>
                        <div>
                            <strong>ID:</strong> {{ $projetoLei->id }}
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
                <p>Tem certeza que deseja excluir este projeto de lei?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção:</strong> Esta ação não pode ser desfeita. Todos os dados e arquivos do projeto serão perdidos permanentemente.
                </div>
                <div class="bg-light p-3 rounded">
                    <strong>Projeto:</strong> {{ $projetoLei->tipo }} nº {{ $projetoLei->numero }}/{{ $projetoLei->ano }}<br>
                    <strong>Título:</strong> {{ $projetoLei->titulo }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.projetos-lei.destroy', $projetoLei) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir Projeto
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
                <p>Tem certeza que deseja <strong id="statusAction">{{ $projetoLei->ativo ? 'desativar' : 'ativar' }}</strong> este projeto?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Projetos inativos não aparecem no site público da Câmara Municipal.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.projetos-lei.toggle-status', $projetoLei) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $projetoLei->ativo ? 'warning' : 'success' }}">
                        <i class="fas fa-{{ $projetoLei->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                        {{ $projetoLei->ativo ? 'Desativar' : 'Ativar' }}
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

.bg-light {
    background-color: #f8f9fa !important;
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
</script>
@endpush