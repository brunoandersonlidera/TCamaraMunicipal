@extends('layouts.admin')

@section('title', 'Visualizar Evento - Painel Administrativo')

@push('styles')
@vite(['resources/css/admin/eventos.css'])
<link rel="stylesheet" href="{{ asset('css/admin-eventos.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header do Evento -->
    <div class="evento-header">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <span class="tipo-badge tipo-{{ $evento->tipo }} me-3">
                            {{ $tipos[$evento->tipo] ?? $evento->tipo }}
                        </span>
                        @if($evento->destaque)
                            <span class="destaque-badge">
                                <i class="fas fa-star me-1"></i>
                                Em Destaque
                            </span>
                        @endif
                    </div>
                    <h1 class="display-4 fw-bold mb-3">{{ $evento->titulo }}</h1>
                    @if($evento->descricao)
                        <p class="lead mb-0">{{ $evento->descricao }}</p>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="data-destaque evento-cor-dinamica" data-cor="{{ $evento->cor_destaque }}">
                        <div class="data-dia">{{ $evento->data_evento->format('d') }}</div>
                        <div class="data-mes">{{ $evento->data_evento->format('M') }}</div>
                        <div class="data-ano">{{ $evento->data_evento->format('Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <!-- Informações Básicas -->
            <div class="evento-card">
                <div class="evento-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Informações Básicas
                    </h4>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">Data do Evento</div>
                                <div class="info-value">
                                    {{ $evento->data_evento->format('d/m/Y') }}
                                    <small class="text-muted">({{ $evento->data_evento->diffForHumans() }})</small>
                                </div>
                            </div>
                        </div>
                        
                        @if($evento->hora_inicio)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Horário</div>
                                    <div class="info-value">
                                        {{ $evento->hora_inicio }}
                                        @if($evento->hora_fim)
                                            às {{ $evento->hora_fim }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($evento->local)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Local</div>
                                    <div class="info-value">{{ $evento->local }}</div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <span class="status-badge {{ $evento->ativo ? 'status-ativo' : 'status-inativo' }}">
                                        <i class="fas fa-{{ $evento->ativo ? 'check' : 'times' }} me-1"></i>
                                        {{ $evento->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($evento->observacoes)
                    <div class="evento-section">
                        <h4 class="section-title">
                            <i class="fas fa-sticky-note"></i>
                            Observações
                        </h4>
                        <div class="info-item">
                            <div class="info-value">{{ $evento->observacoes }}</div>
                        </div>
                    </div>
                @endif

                <!-- Anexos e Links -->
                @if($evento->anexo || $evento->url_detalhes)
                    <div class="evento-section">
                        <h4 class="section-title">
                            <i class="fas fa-paperclip"></i>
                            Anexos e Links
                        </h4>
                        
                        <div class="row g-3">
                            @if($evento->anexo)
                                <div class="col-md-6">
                                    <div class="anexo-preview">
                                        <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                                        <h6>Anexo do Evento</h6>
                                        <p class="text-muted mb-3">{{ basename($evento->anexo) }}</p>
                                        <a href="{{ Storage::url($evento->anexo) }}" target="_blank" 
                                           class="btn btn-primary btn-action">
                                            <i class="fas fa-download"></i>
                                            Baixar Anexo
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            @if($evento->url_detalhes)
                                <div class="col-md-6">
                                    <div class="anexo-preview">
                                        <i class="fas fa-external-link-alt fa-3x text-success mb-3"></i>
                                        <h6>Link para Detalhes</h6>
                                        <p class="text-muted mb-3">Acesse informações adicionais</p>
                                        <a href="{{ $evento->url_detalhes }}" target="_blank" 
                                           class="btn btn-success btn-action">
                                            <i class="fas fa-external-link-alt"></i>
                                            Acessar Link
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Relacionamentos -->
                @if($evento->vereador || $evento->sessao || $evento->licitacao || $evento->esicSolicitacao)
                    <div class="evento-section">
                        <h4 class="section-title">
                            <i class="fas fa-link"></i>
                            Relacionamentos
                        </h4>
                        
                        <div class="relacionamentos-grid">
                            @if($evento->vereador)
                                <div class="relacionamento-card">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="fas fa-user me-2"></i>
                                        Vereador Responsável
                                    </h6>
                                    <p class="mb-1">{{ $evento->vereador->nome }}</p>
                                    <small class="text-muted">{{ $evento->vereador->partido }}</small>
                                </div>
                            @endif
                            
                            @if($evento->sessao)
                                <div class="relacionamento-card">
                                    <h6 class="fw-bold text-danger mb-2">
                                        <i class="fas fa-gavel me-2"></i>
                                        Sessão Plenária
                                    </h6>
                                    <p class="mb-1">{{ $evento->sessao->titulo }}</p>
                                    <small class="text-muted">{{ $evento->sessao->data->format('d/m/Y') }}</small>
                                </div>
                            @endif
                            
                            @if($evento->licitacao)
                                <div class="relacionamento-card">
                                    <h6 class="fw-bold text-warning mb-2">
                                        <i class="fas fa-file-contract me-2"></i>
                                        Licitação
                                    </h6>
                                    <p class="mb-1">{{ $evento->licitacao->titulo }}</p>
                                    <small class="text-muted">Nº {{ $evento->licitacao->numero }}</small>
                                </div>
                            @endif
                            
                            @if($evento->esicSolicitacao)
                                <div class="relacionamento-card">
                                    <h6 class="fw-bold text-info mb-2">
                                        <i class="fas fa-question-circle me-2"></i>
                                        Solicitação E-SIC
                                    </h6>
                                    <p class="mb-1">{{ $evento->esicSolicitacao->assunto }}</p>
                                    <small class="text-muted">Protocolo: {{ $evento->esicSolicitacao->protocolo }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Countdown -->
            <div class="evento-card">
                <div class="evento-section">
                    @if($evento->isHoje())
                        <div class="countdown hoje">
                            <h5 class="fw-bold mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                HOJE!
                            </h5>
                            <p class="mb-0">O evento é hoje!</p>
                        </div>
                    @elseif($evento->isAmanha())
                        <div class="countdown">
                            <h5 class="fw-bold mb-2">
                                <i class="fas fa-clock me-2"></i>
                                AMANHÃ
                            </h5>
                            <p class="mb-0">O evento é amanhã!</p>
                        </div>
                    @elseif($evento->isPassado())
                        <div class="countdown passado">
                            <h5 class="fw-bold mb-2">
                                <i class="fas fa-history me-2"></i>
                                REALIZADO
                            </h5>
                            <p class="mb-0">Evento já realizado</p>
                        </div>
                    @else
                        <div class="countdown">
                            <h5 class="fw-bold mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>
                                FALTAM
                            </h5>
                            <div class="display-6 fw-bold">{{ $evento->diasRestantes() }}</div>
                            <p class="mb-0">{{ $evento->diasRestantes() == 1 ? 'dia' : 'dias' }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="evento-card">
                <div class="evento-section">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-tools me-2"></i>
                        Ações Rápidas
                    </h5>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.eventos.edit', $evento) }}" 
                           class="btn btn-warning btn-action">
                            <i class="fas fa-edit"></i>
                            Editar Evento
                        </a>
                        
                        <a href="{{ route('admin.eventos.duplicate', $evento) }}" 
                           class="btn btn-info btn-action">
                            <i class="fas fa-copy"></i>
                            Duplicar Evento
                        </a>
                        
                        <button type="button" class="btn btn-{{ $evento->ativo ? 'secondary' : 'success' }} btn-action"
                                data-action="toggle-status" data-evento-id="{{ $evento->id }}">
                            <i class="fas fa-{{ $evento->ativo ? 'pause' : 'play' }}"></i>
                            {{ $evento->ativo ? 'Desativar' : 'Ativar' }}
                        </button>
                        
                        <button type="button" class="btn btn-{{ $evento->destaque ? 'outline-warning' : 'warning' }} btn-action"
                                data-action="toggle-destaque" data-evento-id="{{ $evento->id }}">
                            <i class="fas fa-star"></i>
                            {{ $evento->destaque ? 'Remover Destaque' : 'Destacar' }}
                        </button>
                        
                        <hr>
                        
                        <button type="button" class="btn btn-danger btn-action" 
                                data-action="confirmar-exclusao" data-evento-id="{{ $evento->id }}" data-evento-nome="{{ $evento->titulo }}">
                            <i class="fas fa-trash"></i>
                            Excluir Evento
                        </button>
                    </div>
                </div>
            </div>

            <!-- Histórico -->
            <div class="evento-card">
                <div class="evento-section">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-history me-2"></i>
                        Histórico
                    </h5>
                    
                    <div class="timeline-item">
                        <h6 class="fw-bold mb-1">Evento Criado</h6>
                        <p class="text-muted mb-1">{{ $evento->created_at->format('d/m/Y H:i') }}</p>
                        @if($evento->user)
                            <small class="text-muted">por {{ $evento->user->name }}</small>
                        @endif
                    </div>
                    
                    @if($evento->updated_at != $evento->created_at)
                        <div class="timeline-item">
                            <h6 class="fw-bold mb-1">Última Atualização</h6>
                            <p class="text-muted mb-1">{{ $evento->updated_at->format('d/m/Y H:i') }}</p>
                            <small class="text-muted">{{ $evento->updated_at->diffForHumans() }}</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navegação -->
            <div class="evento-card">
                <div class="evento-section">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-compass me-2"></i>
                        Navegação
                    </h5>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.eventos.index') }}" 
                           class="btn btn-outline-primary btn-action">
                            <i class="fas fa-list"></i>
                            Lista de Eventos
                        </a>
                        
                        <a href="{{ route('admin.eventos.create') }}" 
                           class="btn btn-outline-success btn-action">
                            <i class="fas fa-plus"></i>
                            Novo Evento
                        </a>
                        
                        <a href="{{ route('calendario.agenda') }}" target="_blank"
                           class="btn btn-outline-info btn-action">
                            <i class="fas fa-calendar"></i>
                            Ver no Calendário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="modalExclusao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Tem certeza que deseja excluir este evento?</p>
                <div class="alert alert-warning">
                    <strong>Atenção:</strong> Esta ação não pode ser desfeita!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="form-exclusao" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Excluir Evento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/admin/eventos.js'])
<script src="{{ asset('js/admin-eventos.js') }}"></script>
@endpush