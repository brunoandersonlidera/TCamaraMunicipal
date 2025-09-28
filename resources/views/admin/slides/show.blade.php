@extends('layouts.admin')

@section('title', 'Visualizar Slide')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Visualizar Slide: {{ $slide->titulo }}
                    </h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.slides.edit', $slide) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Editar
                        </a>
                        <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Coluna Esquerda - Informações -->
                        <div class="col-md-8">
                            <!-- Título -->
                            <div class="mb-4">
                                <h4 class="text-primary">
                                    <i class="fas fa-heading me-2"></i>
                                    {{ $slide->titulo }}
                                </h4>
                                <div class="d-flex gap-2 mt-2">
                                    <span class="badge bg-{{ $slide->ativo ? 'success' : 'secondary' }}">
                                        <i class="fas fa-{{ $slide->ativo ? 'eye' : 'eye-slash' }} me-1"></i>
                                        {{ $slide->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                    <span class="badge bg-info">
                                        <i class="fas fa-sort-numeric-up me-1"></i>
                                        Ordem: {{ $slide->ordem }}
                                    </span>
                                </div>
                            </div>

                            <!-- Descrição -->
                            @if($slide->descricao)
                            <div class="mb-4">
                                <h6 class="text-muted">
                                    <i class="fas fa-align-left me-1"></i>
                                    Descrição:
                                </h6>
                                <p class="lead">{{ $slide->descricao }}</p>
                            </div>
                            @endif

                            <!-- Imagem -->
                            @if($slide->imagem)
                            <div class="mb-4">
                                <h6 class="text-muted">
                                    <i class="fas fa-image me-1"></i>
                                    Imagem:
                                </h6>
                                <div class="text-center">
                                    <img src="{{ $slide->url_imagem }}" 
                                         alt="{{ $slide->titulo }}" 
                                         class="img-fluid rounded shadow"
                                         style="max-height: 400px;">
                                    <div class="mt-2">
                                        <small class="text-muted">{{ $slide->imagem }}</small>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Link -->
                            @if($slide->link)
                            <div class="mb-4">
                                <h6 class="text-muted">
                                    <i class="fas fa-link me-1"></i>
                                    Link:
                                </h6>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ $slide->link }}" 
                                       target="{{ $slide->nova_aba ? '_blank' : '_self' }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i>
                                        {{ $slide->link }}
                                    </a>
                                    @if($slide->nova_aba)
                                        <span class="badge bg-info">
                                            <i class="fas fa-external-link-alt me-1"></i>
                                            Nova aba
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Preview do Slider -->
                            <div class="mb-4">
                                <h6 class="text-muted">
                                    <i class="fas fa-play me-1"></i>
                                    Preview do Slider:
                                </h6>
                                <div class="border rounded p-3 bg-light">
                                    <div id="slidePreview" class="position-relative" style="height: 300px; overflow: hidden;">
                                        <div class="slide-item position-absolute w-100 h-100" 
                                             style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ $slide->url_imagem }}') center/cover;">
                                            <div class="d-flex align-items-center h-100 text-white p-4">
                                                <div>
                                                    <h3 class="mb-3">{{ $slide->titulo }}</h3>
                                                    @if($slide->descricao)
                                                        <p class="mb-3">{{ $slide->descricao }}</p>
                                                    @endif
                                                    @if($slide->link)
                                                        <a href="{{ $slide->link }}" 
                                                           target="{{ $slide->nova_aba ? '_blank' : '_self' }}" 
                                                           class="btn btn-primary">
                                                            Saiba mais
                                                            @if($slide->nova_aba)
                                                                <i class="fas fa-external-link-alt ms-1"></i>
                                                            @endif
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Preview de como o slide aparecerá no site
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Direita - Configurações -->
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cogs me-1"></i>
                                        Configurações do Slider
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Velocidade -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-tachometer-alt me-1"></i>
                                                Velocidade:
                                            </span>
                                            <span class="fw-bold">{{ $slide->velocidade }}ms ({{ $slide->velocidade / 1000 }}s)</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 6px;">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: {{ (($slide->velocidade - 1000) / 9000) * 100 }}%"
                                                 aria-valuenow="{{ $slide->velocidade }}" 
                                                 aria-valuemin="1000" 
                                                 aria-valuemax="10000"></div>
                                        </div>
                                        <small class="text-muted">Intervalo: 1000ms - 10000ms</small>
                                    </div>

                                    <!-- Transição -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-exchange-alt me-1"></i>
                                                Transição:
                                            </span>
                                            <span class="fw-bold">{{ ucfirst($slide->transicao) }}</span>
                                        </div>
                                        <small class="text-muted">
                                            @switch($slide->transicao)
                                                @case('fade')
                                                    Transição suave com fade in/out
                                                    @break
                                                @case('slide')
                                                    Deslizamento lateral
                                                    @break
                                                @case('zoom')
                                                    Efeito de zoom
                                                    @break
                                                @default
                                                    Transição personalizada
                                            @endswitch
                                        </small>
                                    </div>

                                    <!-- Direção -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-arrows-alt me-1"></i>
                                                Direção:
                                            </span>
                                            <span class="fw-bold">
                                                @switch($slide->direcao)
                                                    @case('left')
                                                        <i class="fas fa-arrow-left me-1"></i>Esquerda
                                                        @break
                                                    @case('right')
                                                        <i class="fas fa-arrow-right me-1"></i>Direita
                                                        @break
                                                    @case('up')
                                                        <i class="fas fa-arrow-up me-1"></i>Cima
                                                        @break
                                                    @case('down')
                                                        <i class="fas fa-arrow-down me-1"></i>Baixo
                                                        @break
                                                    @default
                                                        {{ ucfirst($slide->direcao) }}
                                                @endswitch
                                            </span>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-toggle-{{ $slide->ativo ? 'on' : 'off' }} me-1"></i>
                                                Status:
                                            </span>
                                            <form action="{{ route('admin.slides.toggle-status', $slide) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-{{ $slide->ativo ? 'success' : 'secondary' }}">
                                                    <i class="fas fa-{{ $slide->ativo ? 'eye' : 'eye-slash' }} me-1"></i>
                                                    {{ $slide->ativo ? 'Ativo' : 'Inativo' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Link -->
                                    @if($slide->link)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                Nova aba:
                                            </span>
                                            <span class="badge bg-{{ $slide->nova_aba ? 'success' : 'secondary' }}">
                                                {{ $slide->nova_aba ? 'Sim' : 'Não' }}
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    <hr>

                                    <!-- Informações do sistema -->
                                    <div class="small text-muted">
                                        <div class="mb-2">
                                            <i class="fas fa-calendar-plus me-1"></i>
                                            <strong>Criado:</strong><br>
                                            {{ $slide->created_at->format('d/m/Y H:i:s') }}
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-calendar-edit me-1"></i>
                                            <strong>Atualizado:</strong><br>
                                            {{ $slide->updated_at->format('d/m/Y H:i:s') }}
                                        </div>
                                        @if($slide->created_at != $slide->updated_at)
                                        <div>
                                            <i class="fas fa-clock me-1"></i>
                                            <strong>Última modificação:</strong><br>
                                            {{ $slide->updated_at->diffForHumans() }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-tools me-1"></i>
                                        Ações
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.slides.edit', $slide) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i>
                                            Editar Slide
                                        </a>
                                        
                                        <form action="{{ route('admin.slides.toggle-status', $slide) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-{{ $slide->ativo ? 'secondary' : 'success' }} w-100">
                                                <i class="fas fa-{{ $slide->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                                                {{ $slide->ativo ? 'Desativar' : 'Ativar' }}
                                            </button>
                                        </form>

                                        <button type="button" 
                                                class="btn btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal">
                                            <i class="fas fa-trash me-2"></i>
                                            Excluir Slide
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o slide <strong>"{{ $slide->titulo }}"</strong>?</p>
                <p class="text-danger mb-0">
                    <i class="fas fa-warning me-1"></i>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </button>
                <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection