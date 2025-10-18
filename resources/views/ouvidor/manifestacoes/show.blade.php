@extends('layouts.ouvidor')

@section('title', 'Manifestação #' . $manifestacao->protocolo)

@section('content')
<div class="container-fluid ouvidor-layout">
    <div class="row">
        <div class="col-12">
            <div class="page-header mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-ouvidor">
                            <li class="breadcrumb-item">
                                <a href="{{ route('ouvidor.dashboard') }}">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('ouvidor.manifestacoes.index') }}">
                                    <i class="fas fa-comments me-1"></i>Manifestações
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ $manifestacao->protocolo }}</li>
                        </ol>
                    </nav>
                    <h1 class="page-title text-ouvidor-primary mb-3">
                        <i class="fas fa-comment-dots me-2"></i>
                        Manifestação #{{ $manifestacao->protocolo }}
                    </h1>
                </div>
                <div class="page-actions">
                    <a href="{{ route('ouvidor.manifestacoes.index') }}" class="btn btn-ouvidor-outline">
                        <i class="fas fa-arrow-left me-1"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensagens de Erro e Sucesso -->
    @if(session('success'))
        <div class="alert alert-ouvidor alert-ouvidor-success alert-dismissible fade show fade-in-up" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-ouvidor alert-ouvidor-danger alert-dismissible fade show fade-in-up" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-ouvidor alert-ouvidor-danger alert-dismissible fade show fade-in-up" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Layout de 3 colunas otimizado -->
    <div class="row g-2 ouvidor-layout-3col">
        <!-- Coluna 1: Informações Principais da Manifestação -->
        <div class="col-lg-5 ouvidor-col-main">
            <div class="card ouvidor-card ouvidor-card-compact h-100 fade-in-up">
                <div class="card-header ouvidor-card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Detalhes da Manifestação
                    </h5>
                </div>
                <div class="card-body ouvidor-card-body p-3">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="info-item mb-2">
                                <label class="form-label text-ouvidor-primary fw-bold mb-1">
                                    <i class="fas fa-hashtag me-1"></i>Protocolo:
                                </label>
                                <p class="mb-0 fs-6 fw-semibold">{{ $manifestacao->protocolo }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-item mb-2">
                                <label class="form-label text-ouvidor-primary fw-bold mb-1">
                                    <i class="fas fa-tag me-1"></i>Tipo:
                                </label>
                                <p class="mb-0 small">{{ ucfirst($manifestacao->tipo) }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-item mb-2">
                                <label class="form-label text-ouvidor-primary fw-bold mb-1">
                                    <i class="fas fa-calendar-plus me-1"></i>Criação:
                                </label>
                                <p class="mb-0 small">{{ $manifestacao->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item mb-2">
                                <label class="form-label text-ouvidor-primary fw-bold mb-1">
                                    <i class="fas fa-clock me-1"></i>Prazo de Resposta:
                                </label>
                                <p class="mb-0 small">
                                    {{ \Carbon\Carbon::parse($manifestacao->prazo_resposta)->format('d/m/Y') }}
                                    @if(\Carbon\Carbon::parse($manifestacao->prazo_resposta)->isPast())
                                        <span class="badge badge-ouvidor badge-vencida ms-2">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Vencido
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item mb-2">
                                <label class="form-label text-ouvidor-primary fw-bold mb-1">
                                    <i class="fas fa-flag me-1"></i>Status:
                                </label>
                                <span class="badge badge-ouvidor 
                                    @if($manifestacao->status == 'vencida') badge-vencida
                                    @elseif($manifestacao->status == 'em_andamento') badge-em-andamento
                                    @elseif($manifestacao->status == 'respondida') badge-respondida
                                    @elseif($manifestacao->status == 'arquivada') badge-arquivada
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $manifestacao->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-ouvidor-primary fw-bold mb-1">
                            <i class="fas fa-subject me-1"></i>Assunto:
                        </label>
                        <p class="mb-0 small">{{ $manifestacao->assunto }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-ouvidor-primary fw-bold mb-1">
                            <i class="fas fa-align-left me-1"></i>Descrição:
                        </label>
                        <div class="description-content p-2 bg-light rounded small" style="max-height: 150px; overflow-y: auto;">
                            {!! nl2br(e($manifestacao->descricao)) !!}
                        </div>
                    </div>

                    @if($manifestacao->anexos->count() > 0)
                        <div class="mb-3">
                            <label class="form-label text-ouvidor-primary fw-bold mb-1">
                                <i class="fas fa-paperclip me-1"></i>Anexos:
                            </label>
                            <div class="anexos-list" style="max-height: 100px; overflow-y: auto;">
                                @foreach($manifestacao->anexos as $anexo)
                                    <div class="anexo-item d-flex align-items-center p-1 bg-light rounded mb-1">
                                        <i class="fas fa-file me-1 text-ouvidor-secondary small"></i>
                                        <a href="{{ Storage::url($anexo->caminho) }}" target="_blank" class="text-decoration-none small">
                                            {{ Str::limit($anexo->nome_original, 20) }}
                                        </a>
                                        <small class="text-muted ms-auto">
                                            {{ number_format($anexo->tamanho / 1024, 1) }}KB
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Dados do Manifestante -->
                    @if($manifestacao->anonima)
                        <div class="alert alert-ouvidor alert-ouvidor-info p-2">
                            <i class="fas fa-user-secret me-1"></i>
                            <strong class="small">Manifestação Anônima</strong>
                        </div>
                    @else
                        <div class="manifestante-info">
                            <h6 class="text-ouvidor-primary fw-bold mb-2 small">
                                <i class="fas fa-user me-1"></i>Dados do Manifestante
                            </h6>
                            <div class="row g-1">
                                <div class="col-12">
                                    <div class="info-item mb-1">
                                        <strong class="small">Nome:</strong> <span class="small">{{ $manifestacao->nome }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-item mb-1">
                                        <strong class="small">E-mail:</strong> <span class="small">{{ $manifestacao->email }}</span>
                                    </div>
                                </div>
                                @if($manifestacao->telefone)
                                    <div class="col-12">
                                        <div class="info-item mb-1">
                                            <strong class="small">Telefone:</strong> <span class="small">{{ $manifestacao->telefone }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if($manifestacao->endereco)
                                    <div class="col-12">
                                        <div class="info-item mb-1">
                                            <strong class="small">Endereço:</strong> <span class="small">{{ $manifestacao->endereco }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Coluna 2: Ações e Controles (Sidebar) -->
        <div class="col-lg-3 ouvidor-col-actions">
            <!-- Status Atual -->
            <div class="card ouvidor-card ouvidor-card-compact mb-2 fade-in-up">
                <div class="card-header ouvidor-card-header py-2">
                    <h6 class="card-title mb-0 small">
                        <i class="fas fa-cogs me-1"></i>Ações
                    </h6>
                </div>
                <div class="card-body ouvidor-card-body p-2">
                    <div class="d-grid gap-2">
                        <a href="{{ route('ouvidor.manifestacoes.index') }}" class="btn btn-ouvidor-outline btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Voltar
                        </a>
                        <button type="button" class="btn btn-ouvidor-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalResponder">
                            <i class="fas fa-reply me-1"></i>Responder
                        </button>
                        <button type="button" class="btn btn-ouvidor-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAlterarStatus">
                            <i class="fas fa-edit me-1"></i>Alterar Status
                        </button>
                        <button type="button" class="btn btn-ouvidor-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarTramitacao">
                            <i class="fas fa-plus me-1"></i>Nova Tramitação
                        </button>
                    </div>
                </div>
            </div>

            <!-- Status Atual Compacto -->
            <div class="card ouvidor-card mb-3 fade-in-up">
                <div class="card-header ouvidor-card-header py-2">
                    <h6 class="card-title mb-0 small">
                        <i class="fas fa-flag me-1"></i>Status
                    </h6>
                </div>
                <div class="card-body ouvidor-card-body p-2 text-center">
                    @php
                        $statusClass = match($manifestacao->status) {
                            'nova' => 'badge-pendente',
                            'em_analise', 'em_tramitacao' => 'badge-em-andamento',
                            'respondida', 'finalizada' => 'badge-respondida',
                            'arquivada' => 'badge-arquivada',
                            default => 'badge-pendente'
                        };
                    @endphp
                    <span class="badge badge-ouvidor {{ $statusClass }} small">
                        {{ ucwords(str_replace('_', ' ', $manifestacao->status)) }}
                    </span>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ $manifestacao->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Informações Adicionais Compactas -->
            <div class="card ouvidor-card fade-in-up">
                <div class="card-header ouvidor-card-header py-2">
                    <h6 class="card-title mb-0 small">
                        <i class="fas fa-info me-1"></i>Informações
                    </h6>
                </div>
                <div class="card-body ouvidor-card-body p-2">
                    @if($manifestacao->ouvidorResponsavel)
                        <div class="info-item mb-2">
                            <label class="form-label text-ouvidor-primary fw-bold mb-0 small">
                                <i class="fas fa-user-tie me-1"></i>Responsável:
                            </label>
                            <p class="mb-0 small">{{ $manifestacao->ouvidorResponsavel->name }}</p>
                        </div>
                    @endif

                    @if($manifestacao->data_resposta)
                        <div class="info-item mb-2">
                            <label class="form-label text-ouvidor-primary fw-bold mb-0 small">
                                <i class="fas fa-calendar-check me-1"></i>Resposta:
                            </label>
                            <p class="mb-0 small">{{ \Carbon\Carbon::parse($manifestacao->data_resposta)->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif

                    <div class="info-item">
                        <label class="form-label text-ouvidor-primary fw-bold mb-0 small">
                            <i class="fas fa-clock me-1"></i>Tramitações:
                        </label>
                        <p class="mb-0 small">{{ $manifestacao->movimentacoes ? count($manifestacao->movimentacoes) : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna 3: Histórico de Tramitações Sempre Visível -->
        <div class="col-lg-4 ouvidor-col-history">
            <div class="card ouvidor-card ouvidor-card-compact history-fixed fade-in-up">
                <div class="card-header ouvidor-card-header py-2 sticky-top bg-white">
                    <h6 class="card-title mb-0 small">
                        <i class="fas fa-history me-1"></i>Histórico de Tramitações
                        @if($manifestacao->movimentacoes && count($manifestacao->movimentacoes) > 0)
                            <span class="badge badge-ouvidor badge-em-andamento ms-2">{{ count($manifestacao->movimentacoes) }}</span>
                        @endif
                    </h6>
                </div>
                <div class="card-body ouvidor-card-body p-2 history-scrollable">
                    @if($manifestacao->movimentacoes && count($manifestacao->movimentacoes) > 0)
                        <div class="timeline-ouvidor timeline-ouvidor-compact">
                            @foreach($manifestacao->movimentacoes->sortByDesc('created_at') as $movimentacao)
                                <div class="timeline-item-ouvidor mb-3">
                                    <div class="timeline-marker-ouvidor">
                                        <i class="fas fa-circle text-ouvidor-primary"></i>
                                    </div>
                                    <div class="timeline-content-ouvidor">
                                        <div class="timeline-header d-flex justify-content-between align-items-start">
                                            <div class="timeline-title">
                                                <strong class="small text-ouvidor-primary">
                                                    @if($movimentacao->tipo == 'status_alterado')
                                                        <i class="fas fa-flag me-1"></i>Status Alterado
                                                    @elseif($movimentacao->tipo == 'resposta_enviada')
                                                        <i class="fas fa-reply me-1"></i>Resposta Enviada
                                                    @elseif($movimentacao->tipo == 'tramitacao_interna')
                                                        <i class="fas fa-exchange-alt me-1"></i>Tramitação Interna
                                                    @else
                                                        <i class="fas fa-info-circle me-1"></i>{{ ucfirst($movimentacao->tipo) }}
                                                    @endif
                                                </strong>
                                            </div>
                                            <div class="timeline-date">
                                                <small class="text-muted">{{ $movimentacao->created_at->format('d/m H:i') }}</small>
                                            </div>
                                        </div>
                                        @if($movimentacao->descricao)
                                            <div class="timeline-description mt-1">
                                                @php
                                                    // Detectar se é uma movimentação de resposta sem conteúdo detalhado
                                                    $isRespostaSimples = (
                                                        Str::contains($movimentacao->descricao, ['Resposta enviada pelo ouvidor', 'Resposta fornecida']) &&
                                                        !Str::contains($movimentacao->descricao, ['Observações Internas:', 'Resposta:']) &&
                                                        $manifestacao->resposta
                                                    );
                                                    
                                                    if ($isRespostaSimples) {
                                                        // Construir descrição completa com a resposta da manifestação
                                                        $descricaoCompleta = $movimentacao->descricao . "\n\nResposta: " . $manifestacao->resposta;
                                                        $descricaoLinhas = explode("\n", $descricaoCompleta);
                                                    } else {
                                                        $descricaoLinhas = explode("\n", $movimentacao->descricao);
                                                    }
                                                    
                                                    $primeiraLinha = $descricaoLinhas[0];
                                                    $temMaisConteudo = count($descricaoLinhas) > 1 || strlen(implode("\n", $descricaoLinhas)) > 100;
                                                @endphp
                                                
                                                <div class="timeline-preview">
                                                    <p class="mb-1 small text-muted">{{ Str::limit($primeiraLinha, 80) }}</p>
                                                    @if($temMaisConteudo)
                                                        <button type="button" class="btn btn-link btn-sm p-0 text-ouvidor-primary expand-details" 
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#detalhes-{{ $movimentacao->id }}" 
                                                                aria-expanded="false">
                                                            <i class="fas fa-chevron-down me-1"></i>
                                                            <small>Ver detalhes completos</small>
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                @if($temMaisConteudo)
                                                    <div class="collapse mt-2" id="detalhes-{{ $movimentacao->id }}">
                                                        <div class="card card-body p-2 bg-light border-0">
                                                            <div class="timeline-full-content">
                                                                @foreach($descricaoLinhas as $linha)
                                                                    @if(trim($linha))
                                                                        @if(Str::startsWith($linha, 'Observações Internas:'))
                                                                            <div class="mb-2">
                                                                                <strong class="text-warning">
                                                                                    <i class="fas fa-eye-slash me-1"></i>Observações Internas:
                                                                                </strong>
                                                                                <div class="ms-3 mt-1">
                                                                                    <small class="text-muted">{{ Str::after($linha, 'Observações Internas:') }}</small>
                                                                                </div>
                                                                            </div>
                                                                        @elseif(Str::startsWith($linha, 'Resposta:'))
                                                                            <div class="mb-2">
                                                                                <strong class="text-success">
                                                                                    <i class="fas fa-reply me-1"></i>Resposta:
                                                                                </strong>
                                                                                <div class="ms-3 mt-1">
                                                                                    <small class="text-muted">{{ Str::after($linha, 'Resposta:') }}</small>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="mb-1">
                                                                                <small class="text-muted">{{ $linha }}</small>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        @if($movimentacao->usuario)
                                            <div class="timeline-user">
                                                <small class="text-ouvidor-secondary">
                                                    <i class="fas fa-user me-1"></i>{{ $movimentacao->usuario->name }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-history fa-2x mb-2"></i>
                            <p class="mb-0 small">Nenhuma tramitação registrada ainda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



<!-- Modais -->
<!-- Modal Responder -->
<div class="modal fade" id="modalResponder" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-ouvidor">
            <div class="modal-header modal-header-ouvidor">
                <h5 class="modal-title text-ouvidor-primary">
                    <i class="fas fa-reply me-2"></i>Responder Manifestação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ouvidor.manifestacoes.responder', $manifestacao) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body modal-body-ouvidor">
                    <div class="mb-3">
                        <label class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-comment-dots me-1"></i>Resposta *
                        </label>
                        <textarea name="resposta" class="form-control form-control-ouvidor" rows="6" required 
                                  placeholder="Digite sua resposta..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status_resposta" class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-flag me-1"></i>Status após Resposta *
                        </label>
                        <select name="status" id="status_resposta" class="form-select form-select-ouvidor" required>
                            <option value="">Selecione o status</option>
                            <option value="respondida" selected>Respondida</option>
                            <option value="em_analise">Em Análise</option>
                            <option value="em_tramitacao">Em Tramitação</option>
                            <option value="finalizada">Finalizada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-sticky-note me-1"></i>Observações Internas
                        </label>
                        <textarea name="observacoes" class="form-control form-control-ouvidor" rows="3" 
                                  placeholder="Observações para uso interno (não serão enviadas ao manifestante)"></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-ouvidor">
                    <button type="button" class="btn btn-ouvidor-outline" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-ouvidor-success">
                        <i class="fas fa-paper-plane me-1"></i>Enviar Resposta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Alterar Status -->
<div class="modal fade" id="modalAlterarStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modal-ouvidor">
            <div class="modal-header modal-header-ouvidor">
                <h5 class="modal-title text-ouvidor-primary">
                    <i class="fas fa-edit me-2"></i>Alterar Status da Manifestação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ouvidor.manifestacoes.alterar-status', $manifestacao) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body modal-body-ouvidor">
                    <div class="mb-3">
                        <label class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-flag me-1"></i>Status Atual
                        </label>
                        <input type="text" class="form-control form-control-ouvidor" 
                               value="{{ ucwords(str_replace('_', ' ', $manifestacao->status)) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-exchange-alt me-1"></i>Novo Status *
                        </label>
                        <select name="status" id="status" class="form-select form-select-ouvidor" required>
                            <option value="">Selecione o novo status</option>
                            <option value="nova" {{ $manifestacao->status == 'nova' ? 'disabled' : '' }}>Nova</option>
                            <option value="em_analise" {{ $manifestacao->status == 'em_analise' ? 'disabled' : '' }}>Em Análise</option>
                            <option value="em_tramitacao" {{ $manifestacao->status == 'em_tramitacao' ? 'disabled' : '' }}>Em Tramitação</option>
                            <option value="aguardando_informacoes" {{ $manifestacao->status == 'aguardando_informacoes' ? 'disabled' : '' }}>Aguardando Informações</option>
                            <option value="respondida" {{ $manifestacao->status == 'respondida' ? 'disabled' : '' }}>Respondida</option>
                            <option value="finalizada" {{ $manifestacao->status == 'finalizada' ? 'disabled' : '' }}>Finalizada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-comment me-1"></i>Observações
                        </label>
                        <textarea name="observacoes" id="observacoes" class="form-control form-control-ouvidor" rows="3" 
                                  placeholder="Descreva o motivo da alteração de status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-ouvidor">
                    <button type="button" class="btn btn-ouvidor-outline" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-ouvidor-primary">
                        <i class="fas fa-save me-1"></i>Alterar Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Adicionar Tramitação -->
<div class="modal fade" id="modalAdicionarTramitacao" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-ouvidor">
            <div class="modal-header modal-header-ouvidor">
                <h5 class="modal-title text-ouvidor-primary">
                    <i class="fas fa-plus-circle me-2"></i>Adicionar Tramitação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ouvidor.manifestacoes.tramitacao', $manifestacao) }}" method="POST">
                @csrf
                <div class="modal-body modal-body-ouvidor">
                    <div class="mb-3">
                        <label for="acao" class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-tasks me-1"></i>Ação
                        </label>
                        <input type="text" class="form-control form-control-ouvidor" id="acao" name="acao" required 
                               placeholder="Ex: Encaminhamento para análise">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-align-left me-1"></i>Descrição
                        </label>
                        <textarea class="form-control form-control-ouvidor" id="descricao" name="descricao" rows="3" required 
                                  placeholder="Descreva a tramitação realizada"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label text-ouvidor-primary fw-bold">
                            <i class="fas fa-comment me-1"></i>Observações
                        </label>
                        <textarea class="form-control form-control-ouvidor" id="observacoes" name="observacoes" rows="2" 
                                  placeholder="Observações sobre a tramitação (opcional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-ouvidor">
                    <button type="button" class="btn btn-ouvidor-outline" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-ouvidor-info">
                        <i class="fas fa-plus me-1"></i>Adicionar Tramitação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.page-title {
    margin: 0;
    color: #495057;
}

/* Timeline Ouvidor Styles */
.timeline-ouvidor {
    position: relative;
    padding-left: 2.5rem;
}

.timeline-ouvidor::before {
    content: '';
    position: absolute;
    left: 0.75rem;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, var(--ouvidor-primary), var(--ouvidor-secondary));
    border-radius: 1.5px;
}

.timeline-item-ouvidor {
    position: relative;
    margin-bottom: 2rem;
    animation: fadeInUp 0.6s ease-out;
}

.timeline-item-latest .timeline-content-ouvidor {
    border-left-color: var(--ouvidor-primary);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
}

.timeline-marker-ouvidor {
    position: absolute;
    left: -2.25rem;
    top: 0.5rem;
    width: 1.5rem;
    height: 1.5rem;
    background: var(--ouvidor-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.7rem;
    box-shadow: 0 0 0 4px #fff, 0 0 0 6px var(--ouvidor-primary-light);
    z-index: 2;
}

.timeline-content-ouvidor {
    background: #fff;
    padding: 1.5rem;
    border-radius: 0.75rem;
    border-left: 4px solid var(--ouvidor-secondary);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.timeline-content-ouvidor:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.timeline-title {
    font-weight: 600;
    margin: 0;
}

.timeline-date {
    font-size: 0.85rem;
    white-space: nowrap;
}

.timeline-description {
    color: #6c757d;
    line-height: 1.6;
}

.timeline-user {
    padding-top: 0.5rem;
    border-top: 1px solid #f1f3f4;
}

/* Estilos adicionais para melhor aparência */
.info-item {
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateX(5px);
}

.description-content {
    border: 1px solid #e9ecef;
    transition: border-color 0.3s ease;
}

.description-content:hover {
    border-color: var(--ouvidor-primary);
}

.anexo-item {
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.anexo-item:hover {
    background-color: #f8f9fa !important;
    border-color: var(--ouvidor-primary);
    transform: translateX(5px);
}

.status-display .badge {
    animation: pulse 2s infinite;
}

/* Responsividade melhorada */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .timeline-ouvidor {
        padding-left: 2rem;
    }
    
    .timeline-marker-ouvidor {
        left: -1.75rem;
        width: 1.25rem;
        height: 1.25rem;
    }
    
    .timeline-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .timeline-content-ouvidor {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .col-lg-8, .col-lg-4 {
        margin-bottom: 1rem;
    }
    
    .d-grid.gap-2 button {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
}
</style>

<script>
function responderManifestacao() {
    const modal = new bootstrap.Modal(document.getElementById('modalResponder'));
    modal.show();
}

function alterarStatus() {
    const modal = new bootstrap.Modal(document.getElementById('modalAlterarStatus'));
    modal.show();
}

// Adicionar evento de submit para debug
document.addEventListener('DOMContentLoaded', function() {
    const formAlterarStatus = document.querySelector('#modalAlterarStatus form');
    if (formAlterarStatus) {
        formAlterarStatus.addEventListener('submit', function(e) {
            console.log('Formulário sendo enviado...');
            const status = document.querySelector('#status').value;
            const observacoes = document.querySelector('#observacoes').value;
            
            console.log('Status selecionado:', status);
            console.log('Observações:', observacoes);
            
            if (!status) {
                e.preventDefault();
                alert('Por favor, selecione um novo status.');
                return false;
            }
        });
    }

    // Funcionalidade para expandir/recolher detalhes do histórico
    document.querySelectorAll('.expand-details').forEach(function(button) {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Alterar ícone
            if (isExpanded) {
                icon.className = 'fas fa-chevron-down me-1';
                this.querySelector('small').textContent = 'Ver detalhes completos';
            } else {
                icon.className = 'fas fa-chevron-up me-1';
                this.querySelector('small').textContent = 'Ocultar detalhes';
            }
        });
    });

    // Adicionar evento para quando o collapse é mostrado/ocultado
    document.querySelectorAll('[id^="detalhes-"]').forEach(function(collapse) {
        collapse.addEventListener('shown.bs.collapse', function() {
            const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
            if (button) {
                const icon = button.querySelector('i');
                icon.className = 'fas fa-chevron-up me-1';
                button.querySelector('small').textContent = 'Ocultar detalhes';
            }
        });

        collapse.addEventListener('hidden.bs.collapse', function() {
            const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
            if (button) {
                const icon = button.querySelector('i');
                icon.className = 'fas fa-chevron-down me-1';
                button.querySelector('small').textContent = 'Ver detalhes completos';
            }
        });
    });
});

function adicionarTramitacao() {
    const modal = new bootstrap.Modal(document.getElementById('modalAdicionarTramitacao'));
    modal.show();
}

function arquivarManifestacao() {
    const motivo = prompt('Informe o motivo do arquivamento:');
    if (motivo && motivo.trim() !== '') {
        // Criar formulário para enviar requisição de arquivamento
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("ouvidor.manifestacoes.arquivar", $manifestacao) }}';
        
        // Adicionar token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Adicionar método PATCH
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        form.appendChild(methodField);
        
        // Adicionar motivo
        const motivoInput = document.createElement('input');
        motivoInput.type = 'hidden';
        motivoInput.name = 'motivo';
        motivoInput.value = motivo;
        form.appendChild(motivoInput);
        
        // Adicionar ao body e submeter
        document.body.appendChild(form);
        form.submit();
    }
}

function imprimirManifestacao() {
    window.print();
}
</script>
@endsection