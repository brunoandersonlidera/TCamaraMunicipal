@props([
    'sessao',
    'autoplay' => false,
    'controls' => true,
    'width' => '100%',
    'height' => '400px',
    'class' => ''
])

@php
    $videoUrl = $sessao->video_url;
    $plataforma = $sessao->plataforma_video;
    $videoId = $sessao->getVideoId();
    $embedUrl = $sessao->getEmbedUrl();
    $thumbnail = $sessao->thumbnail_url;
    
    // Se não tiver plataforma definida, tentar detectar automaticamente
    if (!$plataforma && $videoUrl) {
        if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
            $plataforma = 'youtube';
        } elseif (str_contains($videoUrl, 'vimeo.com')) {
            $plataforma = 'vimeo';
        } elseif (str_contains($videoUrl, 'facebook.com')) {
            $plataforma = 'facebook';
        }
    }
    
    // Parâmetros para autoplay
    $autoplayParam = $autoplay ? 1 : 0;
@endphp

<div class="video-player-container {{ $class }}" style="--video-width: {{ $width }}; --video-height: {{ $height }};">
    @if($sessao->temVideo() && $embedUrl)
        @if($plataforma === 'youtube')
            <!-- YouTube Player -->
            <div class="youtube-player video-player-dynamic">
                <iframe 
                    width="100%" 
                    height="100%" 
                    src="{{ $embedUrl }}?autoplay={{ $autoplayParam }}&controls={{ $controls ? '1' : '0' }}&rel=0&modestbranding=1"
                    title="Sessão {{ $sessao->numero_sessao }} - {{ $sessao->tipo_formatado }}"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen
                    loading="lazy">
                </iframe>
            </div>
            
        @elseif($plataforma === 'vimeo')
            <!-- Vimeo Player -->
            <div class="vimeo-player video-player-dynamic">
                <iframe 
                    src="{{ $embedUrl }}?autoplay={{ $autoplayParam }}&controls={{ $controls ? '1' : '0' }}&title=0&byline=0&portrait=0"
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allow="autoplay; fullscreen; picture-in-picture" 
                    allowfullscreen
                    title="Sessão {{ $sessao->numero_sessao }} - {{ $sessao->tipo_formatado }}"
                    loading="lazy">
                </iframe>
            </div>
            
        @elseif($plataforma === 'facebook')
            <!-- Facebook Player -->
            <div class="facebook-player video-player-dynamic">
                <iframe 
                    src="{{ $embedUrl }}&autoplay={{ $autoplayParam ? 'true' : 'false' }}&show_text=false"
                    width="100%" 
                    height="100%" 
                    style="border:none;overflow:hidden" 
                    scrolling="no" 
                    frameborder="0" 
                    allowfullscreen="true" 
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                    title="Sessão {{ $sessao->numero_sessao }} - {{ $sessao->tipo_formatado }}"
                    loading="lazy">
                </iframe>
            </div>
            
        @else
            <!-- Player genérico para outras plataformas -->
            <div class="generic-player video-player-dynamic">
                @if($thumbnail)
                    <div class="video-thumbnail-dynamic" style="background-image: url('{{ $thumbnail }}');">
                        <div class="play-overlay-dynamic" onclick="window.open('{{ $videoUrl }}', '_blank')">
                            <i class="fas fa-play text-white" style="font-size: 2rem; margin-left: 4px;"></i>
                        </div>
                    </div>
                @else
                    <div class="video-link-dynamic">
                        <a href="{{ $videoUrl }}" target="_blank" class="btn btn-primary btn-lg">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Assistir Vídeo
                        </a>
                    </div>
                @endif
            </div>
        @endif
        
        <!-- Informações do vídeo -->
        <div class="video-info mt-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-1">
                        <i class="fas fa-video me-2 text-primary"></i>
                        Sessão {{ $sessao->numero_sessao }} - {{ $sessao->tipo_formatado }}
                    </h6>
                    @if($sessao->descricao_video)
                        <p class="text-muted mb-1 small">{{ $sessao->descricao_video }}</p>
                    @endif
                    <div class="video-meta small text-muted">
                        @if($sessao->data_gravacao)
                            <span class="me-3">
                                <i class="fas fa-calendar me-1"></i>
                                Gravado em {{ $sessao->data_gravacao->format('d/m/Y') }}
                            </span>
                        @endif
                        @if($sessao->duracao_video)
                            <span class="me-3">
                                <i class="fas fa-clock me-1"></i>
                                {{ $sessao->getDuracaoFormatada() }}
                            </span>
                        @endif
                        <span class="me-3">
                            <i class="fab fa-{{ $plataforma }} me-1"></i>
                            {{ ucfirst($plataforma) }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ $videoUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i>
                        Ver no {{ ucfirst($plataforma) }}
                    </a>
                </div>
            </div>
        </div>
        
    @else
        <!-- Sem vídeo disponível -->
        <div class="no-video no-video-dynamic">
            <div class="text-center text-muted">
                <i class="fas fa-video-slash fa-3x mb-3"></i>
                <h6>Vídeo não disponível</h6>
                <p class="mb-0">Esta sessão não possui vídeo gravado</p>
            </div>
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/video-player.css') }}">
@endpush