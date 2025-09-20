@extends('layouts.app')

@section('title', 'TV Câmara')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-tv me-3"></i>
                        TV Câmara
                    </h1>
                    <p class="lead mb-4">
                        Acompanhe todas as sessões da Câmara Municipal. Assista às transmissões ao vivo e acesse o arquivo completo de sessões gravadas.
                    </p>
                    @if($sessaoAoVivo)
                    <div class="d-flex gap-3">
                        <a href="{{ $sessaoAoVivo->transmissao_online }}" class="btn btn-danger btn-lg" target="_blank">
                            <i class="fas fa-broadcast-tower me-2"></i>
                            <span class="badge bg-light text-danger me-2">●</span>
                            AO VIVO AGORA
                        </a>
                    </div>
                    @endif
                </div>
                <div class="col-lg-4 text-center">
                    <div class="tv-icon-container">
                        <i class="fas fa-tv fa-5x opacity-75"></i>
                        @if($sessaoAoVivo)
                        <div class="live-indicator">
                            <span class="badge bg-danger">AO VIVO</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Estatísticas -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <i class="fas fa-video text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h3 class="fw-bold text-primary">{{ $sessoesComVideo }}</h3>
                                    <p class="text-muted mb-0">Sessões Gravadas</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <i class="fas fa-gavel text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h3 class="fw-bold text-primary">{{ $totalSessoes }}</h3>
                                    <p class="text-muted mb-0">Total de Sessões</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <i class="fas fa-clock text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h3 class="fw-bold text-primary">{{ number_format($horasGravadas / 60, 1) }}h</h3>
                                    <p class="text-muted mb-0">Horas de Conteúdo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessão em Destaque -->
        @if($sessaoDestaque)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title mb-4">
                    <i class="fas fa-star text-warning me-2"></i>
                    Sessão em Destaque
                </h2>
                <div class="card card-custom sessao-destaque-card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                @if($sessaoDestaque->status === 'em_andamento')
                                    <span class="badge bg-danger me-2">AO VIVO</span>
                                @elseif($sessaoDestaque->status === 'agendada')
                                    <span class="badge bg-warning me-2">PRÓXIMA</span>
                                @else
                                    <span class="badge bg-success me-2">ÚLTIMA</span>
                                @endif
                                {{ $sessaoDestaque->tipo }} Nº {{ $sessaoDestaque->numero_sessao }}
                            </h5>
                            <small>
                                <i class="fas fa-calendar me-1"></i>
                                {{ $sessaoDestaque->dataFormatada }}
                                @if($sessaoDestaque->hora_inicio)
                                    às {{ $sessaoDestaque->horaInicioFormatada }}
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="position-relative">
                                    @if($sessaoDestaque->getThumbnailUrl())
                                        <img src="{{ $sessaoDestaque->getThumbnailUrl() }}" alt="Sessão {{ $sessaoDestaque->numero_sessao }}" class="img-fluid rounded sessao-thumbnail-destaque">
                                    @else
                                        <div class="sessao-thumbnail-placeholder-destaque">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="sessao-overlay-destaque">
                                        <div class="play-button-destaque">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                    
                                    @if($sessaoDestaque->plataforma_video)
                                    <div class="sessao-platform-destaque">
                                        @switch($sessaoDestaque->plataforma_video)
                                            @case('youtube')
                                                <i class="fab fa-youtube text-danger"></i>
                                                @break
                                            @case('vimeo')
                                                <i class="fab fa-vimeo text-info"></i>
                                                @break
                                            @case('facebook')
                                                <i class="fab fa-facebook text-primary"></i>
                                                @break
                                            @default
                                                <i class="fas fa-video"></i>
                                        @endswitch
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7">
                                @if($sessaoDestaque->descricao_video)
                                <p class="text-muted mb-3">{{ $sessaoDestaque->descricao_video }}</p>
                                @endif
                                
                                @if($sessaoDestaque->pauta && is_array($sessaoDestaque->pauta))
                                <h6 class="fw-bold mb-2">Pauta:</h6>
                                <ul class="list-unstyled">
                                    @foreach(array_slice($sessaoDestaque->pauta, 0, 5) as $item)
                                    <li class="mb-1">
                                        <i class="fas fa-chevron-right text-primary me-2"></i>
                                        {{ $item }}
                                    </li>
                                    @endforeach
                                    @if(count($sessaoDestaque->pauta) > 5)
                                    <li class="text-muted">
                                        <i class="fas fa-ellipsis-h me-2"></i>
                                        e mais {{ count($sessaoDestaque->pauta) - 5 }} itens...
                                    </li>
                                    @endif
                                </ul>
                                @endif
                                
                                <div class="mt-4">
                                    @if($sessaoDestaque->status === 'em_andamento' && $sessaoDestaque->transmissao_online)
                                        <a href="{{ $sessaoDestaque->transmissao_online }}" class="btn btn-danger btn-lg me-2" target="_blank">
                                            <i class="fas fa-broadcast-tower me-2"></i>
                                            Assistir AO VIVO
                                        </a>
                                    @elseif($sessaoDestaque->video_url)
                                        <a href="{{ route('sessoes.show', $sessaoDestaque) }}" class="btn btn-primary btn-lg me-2">
                                            <i class="fas fa-play me-2"></i>
                                            Assistir Sessão
                                        </a>
                                    @endif
                                    <a href="{{ route('sessoes.show', $sessaoDestaque) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Sessões por Tipo -->
        @if($sessoesPorTipo->count() > 0)
        <div class="row">
            <div class="col-12">
                <h2 class="section-title mb-4">
                    <i class="fas fa-folder-open me-2"></i>
                    Sessões por Tipo
                </h2>
            </div>
        </div>

        @foreach($sessoesPorTipo as $tipo => $sessoes)
        <div class="row mb-5">
            <div class="col-12">
                <div class="card card-custom">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-tag me-2 text-primary"></i>
                            {{ ucfirst($tipo) }}
                            <span class="badge bg-primary ms-2">{{ $sessoes->count() }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @foreach($sessoes->take(8) as $sessao)
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-custom h-100 sessao-gravada-card">
                                    <div class="position-relative">
                                        @if($sessao->getThumbnailUrl())
                                            <img src="{{ $sessao->getThumbnailUrl() }}" alt="Sessão {{ $sessao->numero_sessao }}" class="card-img-top sessao-thumbnail">
                                        @else
                                            <div class="sessao-thumbnail-placeholder">
                                                <i class="fas fa-play-circle"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="sessao-overlay">
                                            <div class="play-button">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                        
                                        @if($sessao->getDuracaoFormatada())
                                        <div class="sessao-duration">
                                            {{ $sessao->getDuracaoFormatada() }}
                                        </div>
                                        @endif
                                        
                                        <div class="sessao-platform">
                                            @switch($sessao->plataforma_video)
                                                @case('youtube')
                                                    <i class="fab fa-youtube text-danger"></i>
                                                    @break
                                                @case('vimeo')
                                                    <i class="fab fa-vimeo text-info"></i>
                                                    @break
                                                @case('facebook')
                                                    <i class="fab fa-facebook text-primary"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-video"></i>
                                            @endswitch
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">
                                            {{ $sessao->tipo }} Nº {{ $sessao->numero_sessao }}
                                        </h6>
                                        <p class="card-text text-muted small mb-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $sessao->dataFormatada }}
                                            @if($sessao->hora_inicio)
                                                às {{ $sessao->horaInicioFormatada }}
                                            @endif
                                        </p>
                                        @if($sessao->descricao_video)
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($sessao->descricao_video, 60) }}
                                        </p>
                                        @endif
                                        <a href="{{ route('sessoes.show', $sessao) }}" class="btn btn-sm btn-primary w-100">
                                            <i class="fas fa-play me-1"></i>
                                            Assistir
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($sessoes->count() > 8)
                        <div class="text-center mt-4">
                            <a href="{{ route('sessoes.index', ['tipo' => $tipo]) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>
                                Ver todas as {{ $sessoes->count() }} sessões de {{ ucfirst($tipo) }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        <!-- Link para todas as sessões -->
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('sessoes.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-list me-2"></i>
                    Ver Todas as Sessões
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.tv-icon-container {
    position: relative;
    display: inline-block;
}

.live-indicator {
    position: absolute;
    top: -10px;
    right: -10px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.stat-item {
    padding: 1rem;
}

.sessao-destaque-card {
    border: 2px solid var(--bs-primary);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.sessao-thumbnail-destaque {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.sessao-thumbnail-placeholder-destaque {
    width: 100%;
    height: 250px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
}

.sessao-thumbnail-placeholder-destaque i {
    font-size: 4rem;
    color: #6c757d;
}

.sessao-overlay-destaque {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 0.375rem;
}

.sessao-overlay-destaque:hover {
    opacity: 1;
}

.play-button-destaque {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--bs-primary);
    transition: transform 0.3s ease;
}

.play-button-destaque:hover {
    transform: scale(1.1);
}

.sessao-platform-destaque {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    padding: 5px 8px;
    border-radius: 15px;
    font-size: 1.2rem;
}
</style>
@endpush
@endsection