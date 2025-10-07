@extends('layouts.admin')

@section('page-title', 'Tramitação - ' . $projeto->numero . '/' . $projeto->ano)

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tramitacao.index') }}">Tramitação</a></li>
        <li class="breadcrumb-item active">{{ $projeto->numero }}/{{ $projeto->ano }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-route me-2"></i>
                Tramitação do Projeto {{ $projeto->numero }}/{{ $projeto->ano }}
            </h1>
            <p class="text-muted mb-0">{{ $projeto->titulo }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.projetos-lei.show', $projeto) }}" class="btn btn-outline-secondary">
                <i class="fas fa-eye me-2"></i>Ver Projeto
            </a>
            <a href="{{ route('admin.projetos-lei.edit', $projeto) }}" class="btn btn-outline-primary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAtualizarStatus">
                <i class="fas fa-arrow-right me-2"></i>Atualizar Status
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Coluna Principal - Linha do Tempo -->
        <div class="col-lg-8">
            <!-- Status Atual -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status Atual</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            @php
                                $statusConfig = [
                                    'protocolado' => ['color' => 'primary', 'icon' => 'file-alt', 'label' => 'Protocolado'],
                                    'distribuido' => ['color' => 'info', 'icon' => 'share-alt', 'label' => 'Distribuído'],
                                    'em_comissao' => ['color' => 'warning', 'icon' => 'users', 'label' => 'Em Comissão'],
                                    'aprovado_1_turno' => ['color' => 'success', 'icon' => 'check', 'label' => 'Aprovado 1º Turno'],
                                    'aprovado' => ['color' => 'success', 'icon' => 'check-double', 'label' => 'Aprovado'],
                                    'rejeitado' => ['color' => 'danger', 'icon' => 'times', 'label' => 'Rejeitado'],
                                    'enviado_executivo' => ['color' => 'info', 'icon' => 'paper-plane', 'label' => 'Enviado ao Executivo'],
                                    'sancionado' => ['color' => 'success', 'icon' => 'stamp', 'label' => 'Sancionado'],
                                    'vetado' => ['color' => 'danger', 'icon' => 'ban', 'label' => 'Vetado'],
                                    'promulgado' => ['color' => 'success', 'icon' => 'certificate', 'label' => 'Promulgado']
                                ];
                                $config = $statusConfig[$projeto->status] ?? ['color' => 'secondary', 'icon' => 'question', 'label' => 'Indefinido'];
                            @endphp
                            <div class="d-flex align-items-center">
                                <div class="status-icon bg-{{ $config['color'] }} text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-{{ $config['icon'] }} fa-lg"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-{{ $config['color'] }}">{{ $config['label'] }}</h4>
                                    <p class="text-muted mb-0">
                                        @if($projeto->data_status_atual)
                                            Desde {{ $projeto->data_status_atual->format('d/m/Y H:i') }}
                                        @else
                                            Data não informada
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h5 class="text-primary mb-1">{{ $projeto->getTempoTramitacao() }}</h5>
                                        <small class="text-muted">Tempo de Tramitação</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-info mb-1">{{ $projeto->historico_tramitacao->count() }}</h5>
                                    <small class="text-muted">Movimentações</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Linha do Tempo de Tramitação -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Histórico de Tramitação</h5>
                </div>
                <div class="card-body">
                    @if($projeto->historico_tramitacao && $projeto->historico_tramitacao->count() > 0)
                        <div class="timeline">
                            @foreach($projeto->historico_tramitacao->sortByDesc('created_at') as $historico)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $statusConfig[$historico->status]['color'] ?? 'secondary' }}">
                                        <i class="fas fa-{{ $statusConfig[$historico->status]['icon'] ?? 'circle' }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">{{ $statusConfig[$historico->status]['label'] ?? ucfirst($historico->status) }}</h6>
                                            <small class="text-muted">{{ $historico->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        @if($historico->observacoes)
                                            <p class="mb-2">{{ $historico->observacoes }}</p>
                                        @endif
                                        @if($historico->usuario)
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $historico->usuario->name }}
                                            </small>
                                        @endif
                                        @if($historico->anexos && $historico->anexos->count() > 0)
                                            <div class="mt-2">
                                                @foreach($historico->anexos as $anexo)
                                                    <a href="{{ Storage::url($anexo->caminho) }}" class="btn btn-sm btn-outline-secondary me-1" target="_blank">
                                                        <i class="fas fa-paperclip me-1"></i>{{ $anexo->nome }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Nenhum histórico de tramitação</h6>
                            <p class="text-muted">Este projeto ainda não possui movimentações registradas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Coluna Lateral - Informações e Ações -->
        <div class="col-lg-4">
            <!-- Informações do Projeto -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info me-2"></i>Informações</h6>
                </div>
                <div class="card-body">
                    <div class="info-item mb-3">
                        <label class="form-label text-muted mb-1">Protocolo</label>
                        <div>
                            @if($projeto->protocolo_numero)
                                <code>{{ $projeto->protocolo_numero }}</code>
                            @else
                                <span class="text-muted">Não protocolado</span>
                                <button class="btn btn-sm btn-outline-primary ms-2" onclick="gerarProtocolo({{ $projeto->id }})">
                                    <i class="fas fa-plus me-1"></i>Gerar
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <label class="form-label text-muted mb-1">Tipo</label>
                        <div>
                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $projeto->tipo)) }}</span>
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <label class="form-label text-muted mb-1">Autor</label>
                        <div>
                            @if($projeto->autor)
                                {{ $projeto->autor->nome }}
                            @else
                                {{ ucfirst($projeto->tipo_autoria) }}
                            @endif
                        </div>
                    </div>

                    @if($projeto->urgente)
                        <div class="info-item mb-3">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-exclamation-triangle me-1"></i>Urgente
                            </span>
                        </div>
                    @endif

                    @if($projeto->numero_lei)
                        <div class="info-item mb-3">
                            <label class="form-label text-muted mb-1">Lei Nº</label>
                            <div>
                                <strong>{{ $projeto->numero_lei }}/{{ $projeto->ano }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Consulta Pública -->
            @if($projeto->consulta_publica_ativa || $projeto->consulta_publica_inicio)
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-users me-2"></i>Consulta Pública</h6>
                    </div>
                    <div class="card-body">
                        @if($projeto->consulta_publica_ativa)
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Consulta Ativa</strong><br>
                                <small>
                                    Até {{ $projeto->consulta_publica_prazo->format('d/m/Y H:i') }}
                                    ({{ $projeto->consulta_publica_prazo->diffForHumans() }})
                                </small>
                            </div>
                            <button class="btn btn-sm btn-warning w-100" onclick="finalizarConsultaPublica({{ $projeto->id }})">
                                <i class="fas fa-stop me-1"></i>Finalizar Consulta
                            </button>
                        @else
                            @if($projeto->consulta_publica_inicio)
                                <div class="alert alert-secondary mb-3">
                                    <i class="fas fa-check me-2"></i>
                                    <strong>Consulta Finalizada</strong><br>
                                    <small>
                                        De {{ $projeto->consulta_publica_inicio->format('d/m/Y') }} 
                                        até {{ $projeto->consulta_publica_prazo->format('d/m/Y') }}
                                    </small>
                                </div>
                            @else
                                <button class="btn btn-sm btn-info w-100" data-bs-toggle="modal" data-bs-target="#modalConsultaPublica">
                                    <i class="fas fa-play me-1"></i>Iniciar Consulta Pública
                                </button>
                            @endif
                        @endif

                        @if($projeto->consulta_publica_participacoes > 0)
                            <div class="mt-3 text-center">
                                <h5 class="text-primary mb-1">{{ $projeto->consulta_publica_participacoes }}</h5>
                                <small class="text-muted">Participações</small>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Ações Rápidas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Ações Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(!$projeto->consulta_publica_ativa && !$projeto->consulta_publica_inicio)
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalConsultaPublica">
                                <i class="fas fa-users me-1"></i>Iniciar Consulta Pública
                            </button>
                        @endif

                        @if(in_array($projeto->status, ['aprovado', 'aprovado_1_turno']))
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistrarVotacao">
                                <i class="fas fa-vote-yea me-1"></i>Registrar Votação
                            </button>
                        @endif

                        @if($projeto->status === 'enviado_executivo')
                            <button class="btn btn-sm btn-success" onclick="registrarSancao({{ $projeto->id }})">
                                <i class="fas fa-stamp me-1"></i>Registrar Sanção
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="registrarVeto({{ $projeto->id }})">
                                <i class="fas fa-ban me-1"></i>Registrar Veto
                            </button>
                        @endif

                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalAdicionarHistorico">
                            <i class="fas fa-plus me-1"></i>Adicionar ao Histórico
                        </button>

                        <a href="{{ route('admin.projetos-lei.show', $projeto) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>Ver Projeto Completo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Documentos -->
            @if($projeto->anexos && $projeto->anexos->count() > 0)
                <div class="admin-card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-paperclip me-2"></i>Documentos</h6>
                    </div>
                    <div class="card-body">
                        @foreach($projeto->anexos as $anexo)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <i class="fas fa-file me-2 text-muted"></i>
                                    <span class="small">{{ $anexo->nome }}</span>
                                </div>
                                <a href="{{ Storage::url($anexo->caminho) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modais -->
@include('admin.tramitacao.modals.atualizar-status')
@include('admin.tramitacao.modals.consulta-publica')
@include('admin.tramitacao.modals.registrar-votacao')
@include('admin.tramitacao.modals.adicionar-historico')

@endsection

@section('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #dee2e6;
}

.info-item label {
    font-size: 0.875rem;
    font-weight: 600;
}

.status-icon {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection

@section('scripts')
<script>
function gerarProtocolo(projetoId) {
    if (confirm('Deseja gerar um protocolo automático para este projeto?')) {
        fetch(`/admin/projetos-lei/${projetoId}/gerar-protocolo`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao gerar protocolo: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao gerar protocolo');
        });
    }
}

function finalizarConsultaPublica(projetoId) {
    if (confirm('Deseja finalizar a consulta pública deste projeto?')) {
        fetch(`/admin/projetos-lei/${projetoId}/finalizar-consulta-publica`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao finalizar consulta pública: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao finalizar consulta pública');
        });
    }
}

function registrarSancao(projetoId) {
    const numeroLei = prompt('Digite o número da lei:');
    if (numeroLei) {
        fetch(`/admin/tramitacao/${projetoId}/registrar-sancao`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                numero_lei: numeroLei
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao registrar sanção: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao registrar sanção');
        });
    }
}

function registrarVeto(projetoId) {
    const motivo = prompt('Digite o motivo do veto:');
    if (motivo) {
        fetch(`/admin/tramitacao/${projetoId}/registrar-veto`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                motivo: motivo
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao registrar veto: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao registrar veto');
        });
    }
}
</script>
@endsection