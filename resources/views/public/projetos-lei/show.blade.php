@extends('layouts.app')

@section('title', $projeto->titulo . ' - Projeto de Lei ' . $projeto->numero . '/' . $projeto->ano)
@section('meta-description', 'Detalhes do ' . $projeto->titulo . '. Acompanhe a tramitação, documentos e informações completas deste projeto de lei.')
@section('meta-keywords', 'projeto de lei, ' . $projeto->numero . ', ' . $projeto->ano . ', tramitação, legislação, câmara municipal')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projetos-lei.index') }}">Projetos de Lei</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $projeto->numero }}/{{ $projeto->ano }}</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Conteúdo Principal -->
            <div class="col-lg-8">
                <!-- Cabeçalho do Projeto -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="h3 mb-2">
                                    <i class="fas fa-balance-scale me-2"></i>
                                    Projeto de Lei {{ $projeto->numero }}/{{ $projeto->ano }}
                                </h1>
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $projeto->tipo)) }}</span>
                                    @if($projeto->urgencia)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            URGENTE
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span class="badge bg-{{ $projeto->status == 'aprovado' ? 'success' : ($projeto->status == 'tramitando' ? 'info' : 'secondary') }} fs-6">
                                {{ ucfirst($projeto->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 class="h4 mb-3">{{ $projeto->titulo }}</h2>
                        
                        <!-- Informações Básicas -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-user me-1"></i>
                                    Autor Principal
                                </h6>
                                <p class="mb-3">
                                    {{ $projeto->getAutorCompleto() }}
                                    @if($projeto->tipo_autoria !== 'vereador')
                                        <span class="badge bg-info ms-2">
                                            {{ ucfirst(str_replace('_', ' ', $projeto->tipo_autoria)) }}
                                        </span>
                                    @endif
                                </p>
                                
                                @if($projeto->isIniciativaPopular() && $projeto->getDetalhesIniciativaPopular())
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Projeto de iniciativa popular
                                        </small>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    Data de Protocolo
                                </h6>
                                <p class="mb-3">{{ \Carbon\Carbon::parse($projeto->data_protocolo)->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        {{-- @if($projeto->coautores->count() > 0)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-users me-1"></i>
                                Coautores
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($projeto->coautores as $vereador)
                                    <span class="badge bg-light text-dark">{{ $vereador->nome }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif --}}

                        @if($projeto->tags && is_array($projeto->tags) && count($projeto->tags) > 0)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-tags me-1"></i>
                                Tags
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($projeto->tags as $tag)
                                    <span class="badge bg-secondary">#{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Ementa -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-file-alt me-1"></i>
                                Ementa
                            </h6>
                            <p class="text-justify">{{ $projeto->ementa }}</p>
                        </div>

                        <!-- Justificativa -->
                        @if($projeto->justificativa)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-quote-left me-1"></i>
                                Justificativa
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <p class="text-justify mb-0">{!! nl2br(e($projeto->justificativa)) !!}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Observações -->
                        @if($projeto->observacoes)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-sticky-note me-1"></i>
                                Observações
                            </h6>
                            <div class="alert alert-info">
                                <p class="mb-0">{!! nl2br(e($projeto->observacoes)) !!}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Downloads -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-download me-1"></i>
                                Documentos
                            </h6>
                            <div class="d-flex gap-2 flex-wrap">
                                @if($projeto->arquivo_projeto)
                                    <a href="{{ route('projetos-lei.download', ['projetoLei' => $projeto, 'tipo' => 'projeto']) }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-file-pdf me-1"></i>
                                        Baixar Projeto Original
                                    </a>
                                @endif
                                @if($projeto->arquivo_lei && $projeto->status == 'aprovado')
                                    <a href="{{ route('projetos-lei.download', ['projetoLei' => $projeto, 'tipo' => 'lei']) }}" 
                                       class="btn btn-success">
                                        <i class="fas fa-file-pdf me-1"></i>
                                        Baixar Lei Aprovada
                                    </a>
                                @endif
                                @if(!$projeto->arquivo_projeto && !$projeto->arquivo_lei)
                                    <span class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Documentos não disponíveis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Histórico de Tramitação -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-route me-2"></i>
                            Histórico de Tramitação
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(count($historicoTramitacao) > 0)
                            <div class="timeline">
                                @foreach($historicoTramitacao as $index => $evento)
                                <div class="timeline-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="timeline-marker">
                                        <i class="fas fa-{{ $evento['icone'] }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">{{ $evento['titulo'] }}</h6>
                                        <p class="timeline-description">{{ $evento['descricao'] }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $evento['data'] }}
                                        </small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-clock display-4 text-muted mb-3"></i>
                                <p class="text-muted">Histórico de tramitação não disponível</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Projetos Relacionados -->
                @if($projetosRelacionados->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-link me-2"></i>
                            Projetos Relacionados
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($projetosRelacionados as $relacionado)
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-primary">{{ $relacionado->numero }}/{{ $relacionado->ano }}</span>
                                            <span class="badge bg-{{ $relacionado->status == 'aprovado' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($relacionado->status) }}
                                            </span>
                                        </div>
                                        <h6 class="card-title">{{ Str::limit($relacionado->titulo, 60) }}</h6>
                                        <p class="card-text small text-muted">{{ Str::limit($relacionado->ementa, 80) }}</p>
                                        <a href="{{ route('projetos-lei.show', $relacionado) }}" class="btn btn-outline-primary btn-sm">
                                            Ver Detalhes
                                        </a>
                                    </div>
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
                <!-- Informações Rápidas -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Informações Rápidas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h4 text-primary mb-1">{{ $projeto->numero }}</div>
                                    <small class="text-muted">Número</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h4 text-primary mb-1">{{ $projeto->ano }}</div>
                                    <small class="text-muted">Ano</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <div class="text-center">
                                    <div class="h6 mb-1">{{ ucfirst($projeto->status) }}</div>
                                    <small class="text-muted">Status Atual</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-tools me-2"></i>
                            Ações
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button onclick="window.print()" class="btn btn-outline-primary">
                                <i class="fas fa-print me-2"></i>
                                Imprimir
                            </button>
                            <button onclick="compartilhar()" class="btn btn-outline-secondary">
                                <i class="fas fa-share me-2"></i>
                                Compartilhar
                            </button>
                            <a href="{{ route('projetos-lei.index') }}" class="btn btn-outline-dark">
                                <i class="fas fa-arrow-left me-2"></i>
                                Voltar à Lista
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Links Úteis -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Links Úteis
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="/sessoes" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-video me-2"></i>
                                Sessões da Câmara
                            </a>
                            <a href="/leis" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-book me-2"></i>
                                Leis Aprovadas
                            </a>
                            <a href="/vereadores" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-users me-2"></i>
                                Vereadores
                            </a>
                            <a href="/transparencia" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-chart-bar me-2"></i>
                                Portal da Transparência
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #6c757d;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.timeline-item.active .timeline-marker {
    background: #0d6efd;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #dee2e6;
}

.timeline-item.active .timeline-content {
    border-left-color: #0d6efd;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-description {
    margin-bottom: 10px;
    color: #6c757d;
}

@media print {
    .card-header,
    .btn,
    .breadcrumb,
    .col-lg-4 {
        display: none !important;
    }
    
    .col-lg-8 {
        width: 100% !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
function compartilhar() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $projeto->titulo }}',
            text: 'Projeto de Lei {{ $projeto->numero }}/{{ $projeto->ano }} - {{ $projeto->titulo }}',
            url: window.location.href
        });
    } else {
        // Fallback para navegadores que não suportam Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
            alert('Link copiado para a área de transferência!');
        });
    }
}
</script>
@endpush