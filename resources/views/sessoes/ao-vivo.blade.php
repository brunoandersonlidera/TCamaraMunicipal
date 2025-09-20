@extends('layouts.app')

@section('title', $sessaoAoVivo ? 'Transmissão ao Vivo - Sessão ' . $sessaoAoVivo->numero_sessao . '/' . $sessaoAoVivo->legislatura : 'Transmissão ao Vivo')

@section('content')
@if(!$sessaoAoVivo)
<!-- Sem Transmissão ao Vivo -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-video-slash fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Nenhuma Transmissão ao Vivo</h3>
                    <p class="text-muted mb-4">
                        {{ $message ?? 'Não há sessões sendo transmitidas ao vivo no momento.' }}
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('sessoes.index') }}" class="btn btn-primary">
                            <i class="fas fa-calendar me-2"></i>Ver Sessões
                        </a>
                        <a href="{{ route('sessoes.calendario') }}" class="btn btn-outline-primary">
                            <i class="fas fa-calendar-alt me-2"></i>Calendário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-danger me-3 fs-6 pulse-animation">
                            <i class="fas fa-circle me-1"></i>AO VIVO
                        </span>
                        <h1 class="h3 mb-0">Sessão {{ $sessaoAoVivo->numero_sessao }}/{{ $sessaoAoVivo->legislatura }}</h1>
                    </div>
                    <p class="mb-0 opacity-75">
                        {{ ucfirst($sessaoAoVivo->tipo) }} • 
                        {{ $sessaoAoVivo->data_sessao->format('d/m/Y') }} às {{ $sessaoAoVivo->hora_inicio }}
                        @if($sessaoAoVivo->local)
                            • {{ $sessaoAoVivo->local }}
                        @endif
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('sessoes.show', $sessaoAoVivo) }}" class="btn btn-outline-light">
                        <i class="fas fa-info-circle me-2"></i>Detalhes da Sessão
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Transmissão -->
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <!-- Player de Vídeo -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="ratio ratio-16x9">
                            @if(str_contains($sessaoAoVivo->transmissao_online, 'youtube.com') || str_contains($sessaoAoVivo->transmissao_online, 'youtu.be'))
                                @php
                                    $videoId = '';
                                    if (str_contains($sessaoAoVivo->transmissao_online, 'youtube.com/watch?v=')) {
                                        $videoId = substr($sessaoAoVivo->transmissao_online, strpos($sessaoAoVivo->transmissao_online, 'v=') + 2);
                                        $videoId = substr($videoId, 0, strpos($videoId, '&') ?: strlen($videoId));
                                    } elseif (str_contains($sessaoAoVivo->transmissao_online, 'youtu.be/')) {
                                        $videoId = substr($sessaoAoVivo->transmissao_online, strrpos($sessaoAoVivo->transmissao_online, '/') + 1);
                                    }
                                @endphp
                                @if($videoId)
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&rel=0" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                    </iframe>
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light">
                                        <div class="text-center">
                                            <i class="fas fa-video fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Erro ao carregar transmissão</p>
                                            <a href="{{ $sessaoAoVivo->transmissao_online }}" target="_blank" class="btn btn-primary">
                                                Abrir Link Externo
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light">
                                    <div class="text-center">
                                        <i class="fas fa-external-link-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-3">Transmissão externa</p>
                                        <a href="{{ $sessaoAoVivo->transmissao_online }}" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>Assistir Transmissão
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pauta da Sessão -->
                @if($sessaoAoVivo->pauta && count($sessaoAoVivo->pauta) > 0)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list-ul me-2"></i>Pauta da Sessão</h5>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-numbered list-group-flush">
                            @foreach($sessaoAoVivo->pauta as $item)
                            <li class="list-group-item border-0 px-0">{{ $item }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Mesa Diretora -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-user-tie me-2"></i>Mesa Diretora</h6>
                    </div>
                    <div class="card-body">
                        @if($sessaoAoVivo->presidenteSessao)
                        <div class="mb-3">
                            <strong class="text-primary">Presidente:</strong><br>
                            <span>{{ $sessaoAoVivo->presidenteSessao->nome }}</span>
                            @if($sessaoAoVivo->presidenteSessao->partido)
                                <small class="text-muted">({{ $sessaoAoVivo->presidenteSessao->partido }})</small>
                            @endif
                        </div>
                        @endif

                        @if($sessaoAoVivo->secretarioSessao)
                        <div>
                            <strong class="text-primary">Secretário:</strong><br>
                            <span>{{ $sessaoAoVivo->secretarioSessao->nome }}</span>
                            @if($sessaoAoVivo->secretarioSessao->partido)
                                <small class="text-muted">({{ $sessaoAoVivo->secretarioSessao->partido }})</small>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Vereadores Presentes -->
                @if($sessaoAoVivo->vereadores->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            Vereadores Presentes ({{ $sessaoAoVivo->vereadores->count() }})
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($sessaoAoVivo->vereadores as $vereador)
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                    <small>
                                        {{ $vereador->nome }}
                                        @if($vereador->partido)
                                            <span class="text-muted">({{ $vereador->partido }})</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Projetos de Lei -->
                @if($sessaoAoVivo->projetosLei->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-balance-scale me-2"></i>
                            Projetos em Pauta ({{ $sessaoAoVivo->projetosLei->count() }})
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($sessaoAoVivo->projetosLei as $projeto)
                        <div class="mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                            <div class="fw-bold text-primary">{{ $projeto->numero }}/{{ $projeto->ano }}</div>
                            <div class="small text-muted mb-1">{{ Str::limit($projeto->ementa, 80) }}</div>
                            <div class="small">
                                <strong>Autor:</strong> {{ $projeto->autor }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Informações Adicionais -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="mb-2">
                                <strong>Legislatura:</strong> {{ $sessaoAoVivo->legislatura }}
                            </div>
                            <div class="mb-2">
                                <strong>Sessão Legislativa:</strong> {{ $sessaoAoVivo->sessao_legislativa ?? 'Não informada' }}
                            </div>
                            @if($sessaoAoVivo->hora_fim)
                            <div class="mb-2">
                                <strong>Previsão de Término:</strong> {{ $sessaoAoVivo->hora_fim }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

.hero-section {
    background: linear-gradient(135deg, var(--bs-primary) 0%, #0056b3 100%);
}
</style>
@endif
@endsection