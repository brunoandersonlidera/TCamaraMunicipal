@extends('layouts.admin')

@section('page-title', 'Visualizar Solicitação e-SIC')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.solicitacoes.index') }}">Solicitações e-SIC</a></li>
        <li class="breadcrumb-item active">{{ $solicitacao->protocolo }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Solicitação e-SIC</h1>
            <p class="text-muted mb-0">
                Protocolo: <strong>{{ $solicitacao->protocolo }}</strong>
                @if(!$solicitacao->visualizada_em)
                    <span class="badge bg-danger ms-2">Nova</span>
                @endif
            </p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.solicitacoes.edit', $solicitacao) }}" class="btn btn-primary">
                <i class="fas fa-reply me-2"></i>Responder
            </a>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" 
                    data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.solicitacoes.edit', $solicitacao) }}">
                    <i class="fas fa-edit me-2"></i>Editar
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="toggleStatus()">
                    <i class="fas fa-toggle-on me-2"></i>Alterar Status
                </a></li>
                <li><a class="dropdown-item" href="#" onclick="toggleArquivo()">
                    <i class="fas fa-archive me-2"></i>
                    {{ $solicitacao->arquivada ? 'Desarquivar' : 'Arquivar' }}
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete()">
                    <i class="fas fa-trash me-2"></i>Excluir
                </a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Informações Principais -->
        <div class="col-lg-8">
            <!-- Status e Informações Básicas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações da Solicitação</h5>
                        @php
                            $statusColors = [
                                'pendente' => 'warning',
                                'em_andamento' => 'info',
                                'respondida' => 'success',
                                'arquivada' => 'secondary'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$solicitacao->status] ?? 'secondary' }} fs-6">
                            {{ $statusOptions[$solicitacao->status] ?? $solicitacao->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Solicitante</label>
                                <div class="form-control-plaintext">{{ $solicitacao->nome }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">E-mail</label>
                                <div class="form-control-plaintext">
                                    <a href="mailto:{{ $solicitacao->email }}">{{ $solicitacao->email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Telefone</label>
                                <div class="form-control-plaintext">{{ $solicitacao->telefone ?: 'Não informado' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-light text-dark">{{ $tipos[$solicitacao->tipo] ?? $solicitacao->tipo }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Assunto</label>
                        <div class="form-control-plaintext">{{ $solicitacao->assunto }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição da Solicitação</label>
                        <div class="form-control-plaintext border rounded p-3 bg-light" style="white-space: pre-wrap;">{{ $solicitacao->descricao }}</div>
                    </div>

                    @if($solicitacao->arquivo_solicitacao)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Arquivo Anexado</label>
                        <div class="form-control-plaintext">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x text-primary me-3"></i>
                                <div>
                                    <div class="fw-bold">{{ basename($solicitacao->arquivo_solicitacao) }}</div>
                                    <small class="text-muted">
                                        Tamanho: {{ number_format(filesize(storage_path('app/' . $solicitacao->arquivo_solicitacao)) / 1024, 2) }} KB
                                    </small>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('admin.solicitacoes.download', $solicitacao) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Resposta -->
            @if($solicitacao->resposta || $solicitacao->arquivo_resposta)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-reply me-2"></i>Resposta</h5>
                </div>
                <div class="card-body">
                    @if($solicitacao->resposta)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Texto da Resposta</label>
                        <div class="form-control-plaintext border rounded p-3 bg-light" style="white-space: pre-wrap;">{{ $solicitacao->resposta }}</div>
                    </div>
                    @endif

                    @if($solicitacao->arquivo_resposta)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Arquivo de Resposta</label>
                        <div class="form-control-plaintext">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x text-success me-3"></i>
                                <div>
                                    <div class="fw-bold">{{ basename($solicitacao->arquivo_resposta) }}</div>
                                    <small class="text-muted">
                                        Tamanho: {{ number_format(filesize(storage_path('app/' . $solicitacao->arquivo_resposta)) / 1024, 2) }} KB
                                    </small>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('admin.solicitacoes.download-resposta', $solicitacao) }}" 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($solicitacao->respondida_em)
                    <div class="mb-0">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Respondida em: {{ \Carbon\Carbon::parse($solicitacao->respondida_em)->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Observações Internas -->
            @if($solicitacao->observacoes_internas)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações Internas</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-lock me-2"></i>
                        <strong>Observações internas</strong> - Não visíveis ao solicitante
                    </div>
                    <div class="form-control-plaintext" style="white-space: pre-wrap;">{{ $solicitacao->observacoes_internas }}</div>
                </div>
            </div>
            @endif

            <!-- Histórico de Movimentações -->
            @if($solicitacao->movimentacoes->count() > 0)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Histórico de Movimentações</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($solicitacao->movimentacoes->sortByDesc('data_movimentacao') as $movimentacao)
                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <i class="fas fa-circle text-primary"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0">{{ $movimentacao->descricao }}</h6>
                                    <span class="badge bg-{{ $movimentacao->status === 'pendente' ? 'warning' : ($movimentacao->status === 'em_andamento' ? 'info' : ($movimentacao->status === 'respondida' ? 'success' : 'secondary')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $movimentacao->status)) }}
                                    </span>
                                </div>
                                <div class="text-muted small">
                                    <i class="fas fa-user me-1"></i>{{ $movimentacao->usuario->name ?? 'Sistema' }}
                                    <i class="fas fa-clock ms-3 me-1"></i>{{ $movimentacao->data_movimentacao->format('d/m/Y H:i') }}
                                </div>
                                @if($movimentacao->observacoes)
                                <div class="mt-2">
                                    <small class="text-muted">{{ $movimentacao->observacoes }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Estatísticas e Prazos -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Informações</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Data da Solicitação</label>
                        <div class="form-control-plaintext">
                            {{ $solicitacao->created_at->format('d/m/Y H:i') }}
                            <small class="text-muted d-block">{{ $solicitacao->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    @if($solicitacao->prazo_resposta)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Prazo de Resposta</label>
                        <div class="form-control-plaintext">
                            {{ \Carbon\Carbon::parse($solicitacao->prazo_resposta)->format('d/m/Y') }}
                            @php
                                $prazo = \Carbon\Carbon::parse($solicitacao->prazo_resposta);
                                $hoje = \Carbon\Carbon::now();
                                $diasRestantes = $hoje->diffInDays($prazo, false);
                            @endphp
                            @if($solicitacao->status !== 'respondida')
                                @if($diasRestantes < 0)
                                    <span class="badge bg-danger ms-2">Vencido há {{ abs($diasRestantes) }} dias</span>
                                @elseif($diasRestantes <= 3)
                                    <span class="badge bg-warning ms-2">{{ $diasRestantes }} dias restantes</span>
                                @else
                                    <span class="badge bg-success ms-2">{{ $diasRestantes }} dias restantes</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($solicitacao->visualizada_em)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Primeira Visualização</label>
                        <div class="form-control-plaintext">
                            {{ \Carbon\Carbon::parse($solicitacao->visualizada_em)->format('d/m/Y H:i') }}
                            <small class="text-muted d-block">{{ \Carbon\Carbon::parse($solicitacao->visualizada_em)->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endif

                    @if($solicitacao->respondida_em)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Data da Resposta</label>
                        <div class="form-control-plaintext">
                            {{ \Carbon\Carbon::parse($solicitacao->respondida_em)->format('d/m/Y H:i') }}
                            <small class="text-muted d-block">{{ \Carbon\Carbon::parse($solicitacao->respondida_em)->diffForHumans() }}</small>
                        </div>
                    </div>

                    @php
                        $tempoResposta = \Carbon\Carbon::parse($solicitacao->created_at)->diffInDays(\Carbon\Carbon::parse($solicitacao->respondida_em));
                    @endphp
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tempo de Resposta</label>
                        <div class="form-control-plaintext">
                            {{ $tempoResposta }} {{ $tempoResposta === 1 ? 'dia' : 'dias' }}
                            @if($tempoResposta <= 10)
                                <span class="badge bg-success ms-2">Rápida</span>
                            @elseif($tempoResposta <= 20)
                                <span class="badge bg-warning ms-2">Normal</span>
                            @else
                                <span class="badge bg-danger ms-2">Demorada</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mb-0">
                        <label class="form-label fw-bold">Última Atualização</label>
                        <div class="form-control-plaintext">
                            {{ $solicitacao->updated_at->format('d/m/Y H:i') }}
                            <small class="text-muted d-block">{{ $solicitacao->updated_at->diffForHumans() }}</small>
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
                        @if($solicitacao->status === 'pendente')
                        <button type="button" class="btn btn-info btn-sm" onclick="alterarStatus('em_andamento')">
                            <i class="fas fa-play me-2"></i>Marcar como Em Andamento
                        </button>
                        @endif

                        @if($solicitacao->status !== 'respondida')
                        <a href="{{ route('admin.solicitacoes.edit', $solicitacao) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-reply me-2"></i>Responder Agora
                        </a>
                        @endif

                        @if(!$solicitacao->arquivada)
                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleArquivo()">
                            <i class="fas fa-archive me-2"></i>Arquivar
                        </button>
                        @else
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleArquivo()">
                            <i class="fas fa-box-open me-2"></i>Desarquivar
                        </button>
                        @endif

                        <a href="mailto:{{ $solicitacao->email }}?subject=Re: {{ $solicitacao->assunto }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-2"></i>Enviar E-mail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Configurações -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Configurações</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="arquivada" 
                               {{ $solicitacao->arquivada ? 'checked' : '' }} onchange="toggleArquivo()">
                        <label class="form-check-label" for="arquivada">
                            Arquivada
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="visualizada" 
                               {{ $solicitacao->visualizada_em ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="visualizada">
                            Visualizada
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegação entre registros -->
    <div class="admin-card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.solicitacoes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
                </a>
                <div class="btn-group">
                    @if($anterior)
                    <a href="{{ route('admin.solicitacoes.show', $anterior) }}" class="btn btn-outline-primary">
                        <i class="fas fa-chevron-left me-2"></i>Anterior
                    </a>
                    @endif
                    @if($proximo)
                    <a href="{{ route('admin.solicitacoes.show', $proximo) }}" class="btn btn-outline-primary">
                        Próximo<i class="fas fa-chevron-right ms-2"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Alterar Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <div class="mb-3">
                        <label for="novo_status" class="form-label">Novo Status</label>
                        <select class="form-select" id="novo_status" name="status">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ $solicitacao->status === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="salvarStatus()">
                    <i class="fas fa-save me-2"></i>Salvar
                </button>
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
                <p>Tem certeza que deseja excluir esta solicitação?</p>
                <p class="text-muted">Todos os dados e arquivos relacionados serão removidos permanentemente.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.solicitacoes.destroy', $solicitacao) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir Solicitação
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

.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}

.badge {
    font-size: 0.75em;
}

.alert {
    border: none;
    border-radius: 0.375rem;
}

.btn-group .btn {
    border-radius: 0.375rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.25rem;
}
</style>
@endpush

@push('scripts')
@if(!$solicitacao->visualizada_em)
<script>
// Marcar como visualizada ao carregar a página
fetch('{{ route("admin.solicitacoes.marcar-visualizada", $solicitacao) }}', {
    method: 'PATCH',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
    }
});
</script>
@endif
<script>

// Alterar status
function toggleStatus() {
    const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
    statusModal.show();
}

function alterarStatus(novoStatus) {
    document.getElementById('novo_status').value = novoStatus;
    toggleStatus();
}

function salvarStatus() {
    const novoStatus = document.getElementById('novo_status').value;
    
    fetch('{{ route("admin.solicitacoes.toggle-status", $solicitacao) }}', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            status: novoStatus
        })
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

// Toggle arquivo
function toggleArquivo() {
    fetch('{{ route("admin.solicitacoes.toggle-arquivo", $solicitacao) }}', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao alterar arquivo: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao alterar arquivo');
    });
}

// Confirmação de exclusão
function confirmDelete() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush