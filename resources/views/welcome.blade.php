@extends('layouts.app')

@section('title', 'Câmara Municipal - Início')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/public-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/welcome.js') }}"></script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <!-- Texto Dinâmico - Lado Esquerdo -->
            <div class="col-lg-6">
                @if(optional($heroConfig->imagemTopo)->url)
                    <div class="mb-3 text-center animate-fade-in-up" style="animation-delay: 0.05s;">
                        <img src="{{ optional($heroConfig->imagemTopo)->url }}" 
                             alt="{{ optional($heroConfig->imagemTopo)->alt_text ?? ($heroConfig->titulo ?? 'Imagem do Hero') }}" 
                             class="{{ ($heroConfig->centralizar_imagem_topo ?? true) ? 'img-fluid mx-auto d-block hero-top-image' : 'img-fluid hero-top-image' }}" 
                             style="max-height: {{ $heroConfig->imagem_topo_altura_px ?? 160 }}px; width: auto; object-fit: contain;">
                    </div>
                @endif
                @if(!empty($heroConfig->titulo))
                    <h1 class="display-4 fw-bold mb-4 animate-fade-in-up">
                        {{ $heroConfig->titulo }}
                    </h1>
                @endif
                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="d-flex {{ ($heroConfig->centralizar_imagem_descricao ?? false) ? 'justify-content-center align-items-center' : 'align-items-start' }}">
                        @if(optional($heroConfig->imagemDescricao)->url)
                            <img src="{{ optional($heroConfig->imagemDescricao)->url }}" 
                                 alt="{{ optional($heroConfig->imagemDescricao)->alt_text ?? 'Imagem descritiva' }}" 
                                 class="me-3 flex-shrink-0 hero-desc-image {{ ($heroConfig->centralizar_imagem_descricao ?? false) ? 'mx-auto d-block' : '' }}" 
                                 style="max-height: {{ $heroConfig->imagem_descricao_altura_px ?? 96 }}px; width: auto; object-fit: contain; @if(!empty($heroConfig->imagem_descricao_largura_px)) max-width: {{ $heroConfig->imagem_descricao_largura_px }}px; @endif">
                        @endif
                        <p class="lead mb-0">
                            {{ $heroConfig->descricao }}
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-3 flex-wrap animate-fade-in-up" style="animation-delay: 0.4s;">
                    <a href="{{ $heroConfig->botao_primario_link }}" 
                       class="btn btn-primary-custom"
                       target="{{ $heroConfig->botao_primario_nova_aba ? '_blank' : '_self' }}">
                        <i class="fas fa-eye me-2"></i>
                        {{ $heroConfig->botao_primario_texto }}
                    </a>
                    <a href="{{ $heroConfig->botao_secundario_link }}" 
                       class="btn btn-outline-light"
                       target="{{ $heroConfig->botao_secundario_nova_aba ? '_blank' : '_self' }}">
                        <i class="fas fa-users me-2"></i>
                        {{ $heroConfig->botao_secundario_texto }}
                    </a>
                </div>
            </div>
            
            <!-- Slider de Imagens - Lado Direito -->
            <div class="col-lg-6">
                @if($slides->count() > 0)
                    <div id="heroSlider" class="carousel slide hero-slider" data-bs-ride="carousel">
                        <!-- Indicadores -->
                        <div class="carousel-indicators">
                            @foreach($slides as $index => $slide)
                                <button type="button" 
                                        data-bs-target="#heroSlider" 
                                        data-bs-slide-to="{{ $index }}" 
                                        class="{{ $index === 0 ? 'active' : '' }}"
                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        
                        <!-- Slides -->
                        <div class="carousel-inner">
                            @foreach($slides as $index => $slide)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                                     data-bs-interval="{{ $slide->velocidade * 1000 }}">
                                    @if($slide->link)
                                        <a href="{{ $slide->link }}" 
                                           target="{{ $slide->nova_aba ? '_blank' : '_self' }}"
                                           class="d-block">
                                    @endif
                                    
                                    <img src="{{ $slide->url_imagem }}" 
                                         class="d-block w-100 hero-slide-image" 
                                         alt="{{ $slide->titulo }}">
                                    
                                    @if($slide->titulo || $slide->descricao)
                                        <div class="carousel-caption d-none d-md-block">
                                            @if($slide->titulo)
                                                <h5>{{ $slide->titulo }}</h5>
                                            @endif
                                            @if($slide->descricao)
                                                <p>{{ $slide->descricao }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    @if($slide->link)
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Controles -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>
                @else
                    <!-- Fallback quando não há slides -->
                    <div class="text-center animate-fade-in-up" style="animation-delay: 0.6s;">
                        <i class="fas fa-landmark" style="font-size: 12rem; opacity: 0.1;"></i>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</section>

<!-- Acesso Rápido e Calendário -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Acesso Rápido (4/5 do espaço) -->
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="section-title">Acesso Rápido</h2>
                    <p class="text-muted">Encontre rapidamente o que você precisa</p>
                </div>
                
                @if($acessosRapidos->count() > 0)
                    <div class="row g-3 justify-content-center">
                        @foreach($acessosRapidos as $acesso)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                <a href="{{ $acesso->getUrlFormatada() }}" 
                                   class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                                   target="{{ $acesso->getTarget() }}"
                                   data-bg-color="{{ $acesso->cor_botao ?? '#007bff' }}"
                                   data-text-color="{{ $acesso->cor_fonte ?? '#ffffff' }}">
                                    <i class="{{ $acesso->icone ?? 'fas fa-link' }} mb-2 acesso-rapido-icon"></i>
                                    <span class="fw-bold text-center acesso-rapido-title">{{ $acesso->nome }}</span>
                                    @if($acesso->descricao)
                                        <small class="text-center mt-1 opacity-75 acesso-rapido-desc">{{ Str::limit($acesso->descricao, 30) }}</small>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback para quando não há acessos rápidos cadastrados -->
                    <div class="row g-3 justify-content-center">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="{{ route('vereadores.index') }}" 
                               class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                               style="background-color: #007bff; color: white; border: 2px solid #007bff;">
                                <i class="fas fa-users mb-2" style="font-size: 2.5rem;"></i>
                                <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">Vereadores</span>
                                <small class="text-center mt-1 opacity-75" style="font-size: 0.75rem;">Representantes eleitos</small>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="#" 
                               class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                               style="background-color: var(--theme-success, #28a745); color: white; border: 2px solid var(--theme-success, #28a745);">
                                <i class="fas fa-gavel mb-2" style="font-size: 2.5rem;"></i>
                                <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">Projetos de Lei</span>
                                <small class="text-center mt-1 opacity-75" style="font-size: 0.75rem;">Em tramitação</small>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="{{ route('calendario.agenda') }}" 
                               class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                               style="background-color: #dc3545; color: white; border: 2px solid #dc3545;">
                                <i class="fas fa-calendar-alt mb-2" style="font-size: 2.5rem;"></i>
                                <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">Sessões</span>
                                <small class="text-center mt-1 opacity-75" style="font-size: 0.75rem;">Calendário e atas</small>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="{{ route('transparencia.index') }}" 
                               class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                               style="background-color: #6f42c1; color: white; border: 2px solid #6f42c1;">
                                <i class="fas fa-eye mb-2" style="font-size: 2.5rem;"></i>
                                <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">Transparência</span>
                                <small class="text-center mt-1 opacity-75" style="font-size: 0.75rem;">Portal da transparência</small>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Mini Calendário (1/5 do espaço) -->
            <div class="col-lg-4">
                @include('components.mini-calendario')
            </div>
        </div>
    </div>
</section>

<!-- Últimas Notícias -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Últimas Notícias</h2>
            <p class="text-muted">Fique por dentro das atividades da Câmara</p>
        </div>
        
        <div class="row g-4">
            @forelse($ultimasNoticias as $noticia)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-custom card-news h-100">
                        @if($noticia->imagem_destaque)
                            <div class="news-image-wrapper">
                                <img src="{{ asset('storage/' . $noticia->imagem_destaque) }}" 
                                     class="news-image" alt="{{ $noticia->titulo }}">
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <small class="text-muted">{{ $noticia->data_publicacao->format('d \d\e F, Y') }}</small>
                            </div>
                            @if($noticia->categoria)
                                <span class="badge bg-primary mb-2">{{ ucfirst($noticia->categoria) }}</span>
                            @endif
                            <h5 class="card-title">{{ Str::limit($noticia->titulo, 60) }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit(strip_tags($noticia->resumo ?: $noticia->conteudo), 100) }}
                            </p>
                            <a href="{{ route('noticias.show', $noticia->slug) }}" class="btn btn-sm btn-outline-primary">
                                Leia mais
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback caso não haja notícias -->
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhuma notícia disponível no momento</h5>
                        <p class="text-muted">As últimas notícias da Câmara Municipal aparecerão aqui.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('noticias.index') }}" class="btn btn-primary">
                <i class="fas fa-newspaper me-2"></i>
                Ver Todas as Notícias
            </a>
        </div>
    </div>
</section>

<!-- Vereadores -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nossos Vereadores</h2>
            <p class="text-muted">Conheça os representantes eleitos pelo povo</p>
        </div>
        
        <!-- Carrossel Completo de Vereadores (incluindo Presidente) -->
        <div class="vereadores-carrossel-completo">
            <div class="carrossel-track" style="--num-slides: {{ ($presidente ? 1 : 0) + ($vicepresidente ? 1 : 0) + ($vereadores->count()) }};">
                <!-- Presidente como primeiro card do carrossel -->
                @if($presidente)
                <div class="vereador-slide">
                    <div class="card card-custom h-100 presidente-card">
                        <div class="card-body text-center p-3">
                            <div class="position-relative mb-3">
                                <div class="vereador-mini-photo-container">
                                    @if($presidente->foto)
                                        <img src="{{ $presidente->foto_url }}" alt="{{ $presidente->nome }}" class="vereador-mini-photo">
                                    @else
                                        <div class="vereador-mini-photo-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="presidente-badge">
                                    <i class="fas fa-crown"></i>
                                    <span>PRESIDENTE</span>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1">{{ $presidente->nome }}</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-flag me-1"></i>
                                {{ $presidente->partido }}
                            </p>
                            <div class="d-flex gap-1 flex-column">
                                <a href="{{ route('vereadores.show', $presidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-eye me-1"></i>
                                    Ver Perfil
                                </a>
                                <a href="{{ route('calendario.agenda.vereador', $presidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ver Agenda
                                </a>
                            </div>
                </div>
                </div>
                </div>
                @endif

                <!-- Vice-Presidente como segundo card do carrossel -->
                @if($vicepresidente)
                <div class="vereador-slide">
                    <div class="card card-custom h-100 presidente-card">
                        <div class="card-body text-center p-3">
                            <div class="position-relative mb-3">
                                <div class="vereador-mini-photo-container">
                                    @if($vicepresidente->foto)
                                        <img src="{{ $vicepresidente->foto_url }}" alt="{{ $vicepresidente->nome }}" class="vereador-mini-photo">
                                    @else
                                        <div class="vereador-mini-photo-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="presidente-badge">
                                    <i class="fas fa-medal"></i>
                                    <span>VICE-PRESIDENTE</span>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1">{{ $vicepresidente->nome }}</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-flag me-1"></i>
                                {{ $vicepresidente->partido }}
                            </p>
                            <div class="d-flex gap-1 flex-column">
                                <a href="{{ route('vereadores.show', $vicepresidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-eye me-1"></i>
                                    Ver Perfil
                                </a>
                                <a href="{{ route('calendario.agenda.vereador', $vicepresidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ver Agenda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Outros Vereadores -->
                @foreach($vereadores as $vereador)
                <div class="vereador-slide">
                    <div class="card card-custom h-100 vereador-mini-card">
                        <div class="card-body text-center p-3">
                            <div class="vereador-mini-photo-container mb-3">
                                @if($vereador->foto)
                                    <img src="{{ $vereador->foto_url }}" alt="{{ $vereador->nome }}" class="vereador-mini-photo">
                                @else
                                    <div class="vereador-mini-photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-1">{{ $vereador->nome }}</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-flag me-1"></i>
                                {{ $vereador->partido }}
                            </p>
                            <div class="d-flex gap-1 flex-column">
                                <a href="{{ route('vereadores.show', $vereador->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>
                                    Ver Perfil
                                </a>
                                <a href="{{ route('calendario.agenda', ['vereador' => $vereador->id]) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ver Agenda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Duplicar todos para efeito contínuo -->
                @if($presidente)
                <div class="vereador-slide">
                    <div class="card card-custom h-100 presidente-card">
                        <div class="card-body text-center p-3">
                            <div class="position-relative mb-3">
                                <div class="vereador-mini-photo-container">
                                    @if($presidente->foto)
                                        <img src="{{ $presidente->foto_url }}" alt="{{ $presidente->nome }}" class="vereador-mini-photo">
                                    @else
                                        <div class="vereador-mini-photo-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="presidente-badge">
                                    <i class="fas fa-crown"></i>
                                    <span>PRESIDENTE</span>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1">{{ $presidente->nome }}</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-flag me-1"></i>
                                {{ $presidente->partido }}
                            </p>
                            <div class="d-flex gap-1 flex-column">
                                <a href="{{ route('vereadores.show', $presidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-eye me-1"></i>
                                    Ver Perfil
                                </a>
                                <a href="{{ route('calendario.agenda.vereador', $presidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ver Agenda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Duplicação do Vice-Presidente para efeito contínuo -->
                @if($vicepresidente)
                <div class="vereador-slide">
                    <div class="card card-custom h-100 presidente-card">
                        <div class="card-body text-center p-3">
                            <div class="position-relative mb-3">
                                <div class="vereador-mini-photo-container">
                                    @if($vicepresidente->foto)
                                        <img src="{{ $vicepresidente->foto_url }}" alt="{{ $vicepresidente->nome }}" class="vereador-mini-photo">
                                    @else
                                        <div class="vereador-mini-photo-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="presidente-badge">
                                    <i class="fas fa-medal"></i>
                                    <span>VICE-PRESIDENTE</span>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1">{{ $vicepresidente->nome }}</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-flag me-1"></i>
                                {{ $vicepresidente->partido }}
                            </p>
                            <div class="d-flex gap-1 flex-column">
                                <a href="{{ route('vereadores.show', $vicepresidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-eye me-1"></i>
                                    Ver Perfil
                                </a>
                                <a href="{{ route('calendario.agenda.vereador', $vicepresidente->id) }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ver Agenda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @foreach($vereadores as $vereador)
                <div class="vereador-slide">
                    <div class="card card-custom h-100 vereador-mini-card">
                        <div class="card-body text-center p-3">
                            <div class="vereador-mini-photo-container mb-3">
                                @if($vereador->foto)
                                    <img src="{{ $vereador->foto_url }}" alt="{{ $vereador->nome }}" class="vereador-mini-photo">
                                @else
                                    <div class="vereador-mini-photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-1">{{ $vereador->nome }}</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-flag me-1"></i>
                                {{ $vereador->partido }}
                            </p>
                            <div class="d-flex gap-1 flex-column">
                                <a href="{{ route('vereadores.show', $vereador->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>
                                    Ver Perfil
                                </a>
                                <a href="{{ route('calendario.agenda', ['vereador' => $vereador->id]) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ver Agenda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('vereadores.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-users me-2"></i>
                Ver Todos os Vereadores
            </a>
        </div>
    </div>
</section>

<!-- TV Câmara -->
@if($sessoesGravadas->count() > 0 || $sessaoDestaque)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">TV Câmara</h2>
            <p class="text-muted">Acompanhe as sessões da Câmara Municipal</p>
        </div>
        
        <!-- Sessão em Destaque -->
        @if($sessaoDestaque)
        <div class="row mb-5">
            <div class="col-12">
                <div class="card card-custom sessao-destaque-card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="fas fa-star me-2"></i>
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
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="position-relative">
                                    @if($sessaoDestaque->getThumbnailUrl())
                                        <img src="{{ $sessaoDestaque->getThumbnailUrl() }}" alt="Sessão {{ $sessaoDestaque->numero_sessao }}" class="img-fluid rounded sessao-thumbnail-destaque" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-video.svg') }}';">
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
                            <div class="col-md-8">
                                @if($sessaoDestaque->descricao_video)
                                <p class="text-muted mb-3">{{ $sessaoDestaque->descricao_video }}</p>
                                @endif
                                
                                @if($sessaoDestaque->pauta && is_array($sessaoDestaque->pauta))
                                <h6 class="fw-bold mb-2">Pauta:</h6>
                                <ul class="list-unstyled">
                                    @foreach(array_slice($sessaoDestaque->pauta, 0, 3) as $item)
                                    <li class="mb-1">
                                        <i class="fas fa-chevron-right text-primary me-2"></i>
                                        {{ $item }}
                                    </li>
                                    @endforeach
                                    @if(count($sessaoDestaque->pauta) > 3)
                                    <li class="text-muted">
                                        <i class="fas fa-ellipsis-h me-2"></i>
                                        e mais {{ count($sessaoDestaque->pauta) - 3 }} itens...
                                    </li>
                                    @endif
                                </ul>
                                @endif
                                
                                <div class="mt-3">
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
        
        <!-- Últimas Sessões -->
        @if($sessoesGravadas->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-3">Últimas Sessões</h4>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($sessoesGravadas as $sessao)
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom h-100 sessao-gravada-card">
                    <div class="position-relative">
                        @if($sessao->getThumbnailUrl())
                            <img src="{{ $sessao->getThumbnailUrl() }}" alt="Sessão {{ $sessao->numero_sessao }}" class="card-img-top sessao-thumbnail" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-video.svg') }}';">
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
                            {{ Str::limit($sessao->descricao_video, 80) }}
                        </p>
                        @endif
                        <a href="{{ route('sessoes.show', $sessao) }}" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-play me-1"></i>
                            Assistir Sessão
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        <div class="text-center mt-4">
            <a href="{{ route('tv-camara') }}" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-tv me-2"></i>
                TV Câmara
            </a>
            <a href="{{ route('sessoes.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-video me-2"></i>
                Ver Todas as Sessões
            </a>
        </div>
    </div>
</section>
@endif

<!-- Números da Câmara -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Números da Câmara</h2>
            <p class="text-muted">Transparência em dados</p>
        </div>
        
        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-users text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $totalVereadores ?? '9' }}</h3>
                        <p class="text-muted mb-0">Vereadores Ativos</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-gavel text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $projetos ?? '45' }}</h3>
                        <p class="text-muted mb-0">Projetos em 2024</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-calendar-check text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $sessoes ?? '24' }}</h3>
                        <p class="text-muted mb-0">Sessões Realizadas</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-file-alt text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $leis ?? '12' }}</h3>
                        <p class="text-muted mb-0">Leis Aprovadas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contato e Localização -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <h2 class="section-title">Entre em Contato</h2>
                <p class="text-muted mb-4">
                    Estamos aqui para atender você. Entre em contato conosco através dos canais abaixo.
                </p>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Endereço</h6>
                                <p class="text-muted mb-0">
                                    Rua da Câmara, 123<br>
                                    Centro - CEP 12345-678
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Telefone</h6>
                                <p class="text-muted mb-0">
                                    (XX) XXXX-XXXX<br>
                                    (XX) XXXX-XXXX
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">E-mail</h6>
                                <p class="text-muted mb-0">
                                    contato@camara.gov.br<br>
                                    ouvidoria@camara.gov.br
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Horário</h6>
                                <p class="text-muted mb-0">
                                    Segunda a Sexta<br>
                                    8h às 17h
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <h2 class="section-title">Localização</h2>
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt text-primary" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3 mb-0">Mapa da localização</p>
                                <small class="text-muted">Integração com Google Maps</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Widget de Clima -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="fw-bold mb-3 text-primary text-center">Previsão do Tempo</h3>
                <div class="d-flex justify-content-center">
                    <div style="width: 100%; max-width: 100%; overflow: hidden;">
                        <div id="ww_f3e29fa144d25" v='1.3' loc='id' a='{"t":"responsive","lang":"pt","sl_lpl":1,"ids":["wl4875"],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"#303F9F","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","cl_odd":"#0000000a"}'>Mais previsões: <a href="https://tempolongo.com/rio_de_janeiro_tempo_25_dias/" id="ww_f3e29fa144d25_u" target="_blank">Weather Rio de Janeiro 30 days</a></div><script async src="https://app3.weatherwidget.org/js/?id=ww_f3e29fa144d25"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Participe da Vida Política da Sua Cidade</h2>
                <p class="lead mb-4">
                    Sua participação é fundamental para o desenvolvimento do nosso município. 
                    Acompanhe as sessões, conheça os projetos e faça parte das decisões que afetam sua vida.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="#" class="btn btn-light btn-lg">
                        <i class="fas fa-calendar me-2"></i>
                        Próximas Sessões
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-question-circle me-2"></i>
                        e-SIC
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Botão flutuante: Rolar Para Cima -->
<button id="scrollTopBtn" class="scroll-to-top" aria-label="Rolar para cima" title="Rolar para cima">
    <i class="fas fa-arrow-up"></i>
</button>
@endsection

@push('scripts')
<script>
    // Counter animation for numbers
    function animateCounters() {
        const counters = document.querySelectorAll('.fw-bold.text-primary');
        
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            if (target && target > 0) {
                const increment = target / 50;
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            }
        });
    }

    // Simple trigger for counter animation on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Delay animation slightly for better effect
        setTimeout(animateCounters, 1000);
    });
</script>
@endpush
