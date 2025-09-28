@extends('layouts.app')

@section('title', 'Detalhes do Evento - ' . $evento->titulo)

@push('styles')
<style>
.evento-detalhes {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.evento-icon {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.evento-icon-lg {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

.breadcrumb-custom {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: #6c757d;
}

.card-evento {
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.info-section {
    border-left: 3px solid #007bff;
    padding-left: 1rem;
    margin-bottom: 1.5rem;
}

.btn-action {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Início</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('calendario.agenda') }}" class="text-decoration-none">Calendário</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $evento->titulo }}</li>
                </ol>
            </nav>

            <!-- Cabeçalho do Evento -->
            <div class="card card-evento mb-4">
                <div class="card-header evento-detalhes text-white p-4">
                    <div class="row align-items-start">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-light bg-opacity-25 text-white me-3 px-3 py-2">
                                    {{ $evento->tipo_label }}
                                </span>
                                @if($evento->cor_destaque)
                                    <div class="rounded-circle border border-white border-2" 
                                         style="width: 16px; height: 16px; background-color: {{ $evento->cor_destaque }}"></div>
                                @endif
                            </div>
                            <h1 class="h2 fw-bold mb-2 text-white">{{ $evento->titulo }}</h1>
                            <div class="d-flex align-items-center text-white-50">
                                <i class="fas fa-calendar-alt evento-icon me-2"></i>
                                <span class="fs-5">{{ $evento->data_formatada }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('calendario.agenda') }}" class="btn btn-outline-light btn-sm text-white border-white btn-action">
                                <i class="fas fa-arrow-left evento-icon me-2"></i>
                                Voltar ao Calendário
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalhes do Evento -->
            <div class="row g-4">
                <!-- Informações Principais -->
                <div class="col-lg-8">
                    <div class="card card-evento">
                        <div class="card-body p-4">
                            <h2 class="h4 fw-semibold mb-4 text-dark">
                                <i class="fas fa-info-circle evento-icon-lg me-2 text-primary"></i>
                                Informações do Evento
                            </h2>
                            
                            <!-- Horário -->
                            <div class="info-section">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock evento-icon me-2 text-muted"></i>
                                    <span class="fw-medium text-dark">Horário</span>
                                </div>
                                <p class="text-dark ms-4 mb-0">{{ $evento->horario_formatado }}</p>
                            </div>

                            <!-- Local -->
                            @if($evento->local)
                            <div class="info-section">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt evento-icon me-2 text-muted"></i>
                                    <span class="fw-medium text-dark">Local</span>
                                </div>
                                <p class="text-dark ms-4 mb-0">{{ $evento->local }}</p>
                            </div>
                            @endif

                            <!-- Descrição -->
                            @if($evento->descricao)
                            <div class="info-section">
                                <div class="d-flex align-items-start mb-2">
                                    <i class="fas fa-file-alt evento-icon me-2 text-muted mt-1"></i>
                                    <span class="fw-medium text-dark">Descrição</span>
                                </div>
                                <div class="text-dark ms-4 lh-base">
                                    {!! nl2br(e($evento->descricao)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Informações Relacionadas -->
                    @if($evento->vereador || $evento->sessao || $evento->licitacao)
                    <div class="card card-evento mb-4">
                        <div class="card-body p-4">
                            <h3 class="h5 fw-semibold mb-3 text-dark">
                                <i class="fas fa-link evento-icon-lg me-2 text-primary"></i>
                                Informações Relacionadas
                            </h3>
                            
                            @if($evento->vereador)
                            <div class="mb-3">
                                <small class="text-muted fw-medium d-block">Vereador</small>
                                <p class="text-dark mb-0">{{ $evento->vereador->nome }}</p>
                            </div>
                            @endif

                            @if($evento->sessao)
                            <div class="mb-3">
                                <small class="text-muted fw-medium d-block">Sessão</small>
                                <p class="text-dark mb-0">{{ $evento->sessao->numero_sessao }}ª {{ $evento->sessao->tipo }}</p>
                            </div>
                            @endif

                            @if($evento->licitacao)
                            <div class="mb-3">
                                <small class="text-muted fw-medium d-block">Licitação</small>
                                <p class="text-dark mb-0">{{ $evento->licitacao->titulo }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Ações -->
                    <div class="card card-evento">
                        <div class="card-body p-4">
                            <h3 class="h5 fw-semibold mb-3 text-dark">
                                <i class="fas fa-cog evento-icon-lg me-2 text-primary"></i>
                                Ações
                            </h3>
                            
                            <!-- Adicionar ao Calendário -->
                            <a href="{{ route('calendario.exportar.ics', ['evento' => $evento->id]) }}" 
                               class="btn btn-primary w-100 mb-3 btn-action d-flex align-items-center justify-content-center">
                                <i class="fas fa-calendar-plus evento-icon me-2"></i>
                                Adicionar ao Calendário
                            </a>

                            <!-- Compartilhar -->
                            <button onclick="compartilharEvento()" 
                                    class="btn btn-secondary w-100 btn-action d-flex align-items-center justify-content-center">
                                <i class="fas fa-share-alt evento-icon me-2"></i>
                                Compartilhar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function compartilharEvento() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $evento->titulo }}',
            text: 'Evento: {{ $evento->titulo }} - {{ $evento->data_formatada }}',
            url: window.location.href
        });
    } else {
        // Fallback para navegadores que não suportam Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copiado para a área de transferência!');
        });
    }
}
</script>
@endsection