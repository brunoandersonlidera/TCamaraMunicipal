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
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4 animate-fade-in-up">
                    Bem-vindo à Câmara Municipal
                </h1>
                <p class="lead mb-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                    Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. 
                    Acompanhe as atividades legislativas e participe da vida política da sua cidade.
                </p>
                <div class="d-flex gap-3 flex-wrap animate-fade-in-up" style="animation-delay: 0.4s;">
                    <a href="{{ route('vereadores.index') }}" class="btn btn-primary-custom">
                        <i class="fas fa-users me-2"></i>
                        Conheça os Vereadores
                    </a>
                    <a href="#" class="btn btn-outline-light">
                        <i class="fas fa-eye me-2"></i>
                        Portal da Transparência
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
                    <i class="fas fa-landmark" style="font-size: 12rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Acesso Rápido -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Acesso Rápido</h2>
            <p class="text-muted">Encontre rapidamente o que você precisa</p>
        </div>
        
        @if($acessosRapidos->count() > 0)
            <div class="row g-3 justify-content-center">
                @foreach($acessosRapidos as $acesso)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
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
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="{{ route('vereadores.index') }}" 
                       class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                       style="background-color: #007bff; color: white; border: 2px solid #007bff;">
                        <i class="fas fa-users mb-2" style="font-size: 2.5rem;"></i>
                        <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">Vereadores</span>
                        <small class="text-center mt-1 opacity-75" style="font-size: 0.75rem;">Representantes eleitos</small>
                    </a>
                </div>
                
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="#" 
                       class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                       style="background-color: #28a745; color: white; border: 2px solid #28a745;">
                        <i class="fas fa-gavel mb-2" style="font-size: 2.5rem;"></i>
                        <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">Projetos de Lei</span>
                        <small class="text-center mt-1 opacity-75" style="font-size: 0.75rem;">Em tramitação</small>
                    </a>
                </div>
                
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="#" 
                       class="btn btn-acesso-rapido d-flex flex-column align-items-center p-3 h-100 text-decoration-none"
                       style="background-color: #dc3545; color: white; border: 2px solid #dc3545;">
                        <i class="fas fa-calendar-alt mb-2" style="font-size: 2.5rem;"></i>
                        <span class="fw-bold text-center" style="font-size: 0.9rem; line-height: 1.2;">Sessões</span>
                        <small class="text-center mt-1 opacity-75" style="font-size: 0.75rem;">Calendário e atas</small>
                    </a>
                </div>
                
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="#" 
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
</section>

<!-- Vereadores -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nossos Vereadores</h2>
            <p class="text-muted">Conheça os representantes eleitos pelo povo</p>
        </div>
        
        <div class="row g-4 align-items-center">
            <!-- Presidente em Destaque -->
            @if($presidente)
            <div class="col-lg-5">
                <div class="card card-custom h-100 presidente-card">
                    <div class="card-body text-center p-4">
                        <div class="position-relative mb-4">
                            <div class="presidente-photo-container">
                                @if($presidente->foto)
                                    <img src="{{ $presidente->foto }}" alt="{{ $presidente->nome }}" class="presidente-photo">
                                @else
                                    <div class="presidente-photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="presidente-badge">
                                <i class="fas fa-crown"></i>
                                <span>PRESIDENTE</span>
                            </div>
                        </div>
                        <h4 class="fw-bold text-primary mb-2">{{ $presidente->nome }}</h4>
                        <p class="text-muted mb-3">
                            <i class="fas fa-flag me-1"></i>
                            {{ $presidente->partido }}
                        </p>
                        <p class="card-text text-muted mb-4">
                            {{ Str::limit($presidente->biografia, 120) }}
                        </p>
                        <a href="{{ route('vereadores.show', $presidente->id) }}" class="btn btn-primary">
                            <i class="fas fa-user me-2"></i>
                            Ver Perfil Completo
                        </a>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Demais Vereadores -->
            <div class="col-lg-7">
                <div class="row g-3">
                    @foreach($vereadores as $vereador)
                    <div class="col-md-6 col-sm-6">
                        <div class="card card-custom h-100 vereador-mini-card">
                            <div class="card-body text-center p-3">
                                <div class="vereador-mini-photo-container mb-3">
                                    @if($vereador->foto)
                                        <img src="{{ $vereador->foto }}" alt="{{ $vereador->nome }}" class="vereador-mini-photo">
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
                                <a href="{{ route('vereadores.show', $vereador->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>
                                    Ver Perfil
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('vereadores.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-users me-2"></i>
                        Ver Todos os Vereadores
                    </a>
                </div>
            </div>
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

<!-- Últimas Notícias -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Últimas Notícias</h2>
            <p class="text-muted">Fique por dentro das atividades da Câmara</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <small class="text-muted">15 de Janeiro, 2024</small>
                        </div>
                        <h5 class="card-title">Nova Lei de Incentivo ao Empreendedorismo</h5>
                        <p class="card-text text-muted">
                            Projeto de lei que visa incentivar pequenos empreendedores foi aprovado em primeira votação...
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Leia mais
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <small class="text-muted">12 de Janeiro, 2024</small>
                        </div>
                        <h5 class="card-title">Sessão Extraordinária Convocada</h5>
                        <p class="card-text text-muted">
                            Sessão extraordinária foi convocada para discussão do orçamento municipal para 2024...
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Leia mais
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <small class="text-muted">10 de Janeiro, 2024</small>
                        </div>
                        <h5 class="card-title">Audiência Pública sobre Mobilidade Urbana</h5>
                        <p class="card-text text-muted">
                            População é convidada a participar de audiência sobre o novo plano de mobilidade urbana...
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Leia mais
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-newspaper me-2"></i>
                Ver Todas as Notícias
            </a>
        </div>
    </div>
</section>

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
                        <a class="weatherwidget-io" href="https://forecast7.com/pt/-23d55-46d64/sao-paulo/" data-label_1="SÃO PAULO" data-label_2="BRASIL" data-mode="Forecast" data-theme="pure" data-accent="#007bff" data-textcolor="#333333" data-suncolor="#FFA500" data-cloudcolor="#d4edda" data-cloudanimate="true" data-days="5">SÃO PAULO BRASIL</a>
                        <script>
                        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                        </script>
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
