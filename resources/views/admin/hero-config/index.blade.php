@extends('layouts.admin')

@section('page-title', 'Configurações do Hero Section')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Configurações Hero</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Configurações do Hero Section</h1>
            <p class="text-muted">Gerencie o texto e configurações da seção principal do site</p>
        </div>
        <a href="{{ route('admin.hero-config.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>Editar Configurações
        </a>
    </div>

    <!-- Configurações Atuais -->
    <div class="admin-card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-cog me-2"></i>
                Configurações Atuais
            </h5>
        </div>
        <div class="card-body">
            @if($heroConfig)
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Título Principal</h6>
                        <p class="mb-3">{{ $heroConfig->titulo ?? 'Bem-vindo à Câmara Municipal' }}</p>
                        
                        <h6 class="text-muted mb-2">Descrição</h6>
                        <p class="mb-3">{{ $heroConfig->descricao ?? 'Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. Acompanhe as atividades legislativas e participe da vida política da sua cidade.' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Configurações do Slider</h6>
                        <ul class="list-unstyled">
                            <li><strong>Intervalo:</strong> {{ $heroConfig->intervalo ?? 5000 }}ms</li>
                            <li><strong>Transição:</strong> {{ $heroConfig->transicao ?? 'slide' }}</li>
                            <li><strong>Autoplay:</strong> {{ $heroConfig->autoplay ? 'Ativo' : 'Inativo' }}</li>
                            <li><strong>Pausar no Hover:</strong> {{ $heroConfig->pausar_hover ? 'Sim' : 'Não' }}</li>
                            <li><strong>Indicadores:</strong> {{ $heroConfig->mostrar_indicadores ? 'Visíveis' : 'Ocultos' }}</li>
                            <li><strong>Controles:</strong> {{ $heroConfig->mostrar_controles ? 'Visíveis' : 'Ocultos' }}</li>
                        </ul>
                    </div>
                </div>
                
                @if($heroConfig->updated_at)
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Última atualização: {{ $heroConfig->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                @endif
            @else
                <div class="text-center py-4">
                    <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                    <h5>Nenhuma configuração encontrada</h5>
                    <p class="text-muted">Clique em "Editar Configurações" para criar as configurações iniciais.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Preview do Hero Section -->
    <div class="admin-card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-eye me-2"></i>
                Preview do Hero Section
            </h5>
        </div>
        <div class="card-body">
            @if($heroConfig)
            <div class="hero-preview" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem 1.5rem; border-radius: 0.5rem; max-width: 1100px; margin: 0 auto;">
                <!-- Imagem acima do título -->
                @php
                    $imgTopoUrl = optional($heroConfig->imagemTopo)->url;
                    $imgTopoAltura = $heroConfig->imagem_topo_altura_px ?? 120;
                    $imgTopoCenter = $heroConfig->centralizar_imagem_topo ?? true;
                @endphp
                @if($imgTopoUrl)
                    <div class="mb-3 {{ $imgTopoCenter ? 'text-center' : '' }}">
                        <img src="{{ $imgTopoUrl }}" alt="Imagem acima do título" class="{{ $imgTopoCenter ? 'mx-auto d-block' : '' }}" style="max-height: {{ $imgTopoAltura }}px; max-width: 100%; height: auto; width: auto;">
                    </div>
                @endif

                <!-- Título (exibido apenas se houver conteúdo) -->
                @if(!empty($heroConfig->titulo))
                    <h1 class="display-6 mb-3 text-center">{{ $heroConfig->titulo }}</h1>
                @endif

                <!-- Descrição com possível imagem -->
                @php
                    $imgDescUrl = optional($heroConfig->imagemDescricao)->url;
                    $imgDescAltura = $heroConfig->imagem_descricao_altura_px ?? 120;
                    $imgDescLargura = $heroConfig->imagem_descricao_largura_px ?? null;
                    $imgDescCenter = $heroConfig->centralizar_imagem_descricao ?? false;
                @endphp
                <div class="d-flex align-items-center gap-3 flex-wrap {{ $imgDescCenter ? 'justify-content-center' : '' }}">
                    @if($imgDescUrl)
                        <img src="{{ $imgDescUrl }}" alt="Imagem da descrição" class="{{ $imgDescCenter ? 'mx-auto d-block' : '' }}"
                             style="
                                {{ $imgDescLargura ? 'width: ' . $imgDescLargura . 'px;' : 'max-width: 100%;' }}
                                height: {{ $imgDescAltura }}px;
                                object-fit: contain;
                            ">
                    @endif
                    <p class="lead mb-0" style="flex:1 1 300px;">
                        {{ $heroConfig->descricao ?? 'Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. Acompanhe as atividades legislativas e participe da vida política da sua cidade.' }}
                    </p>
                </div>

                <!-- Resumo do slider -->
                <div class="mt-4 text-center">
                    <small class="text-light opacity-75 d-block mb-2">
                        <i class="fas fa-sliders-h me-1"></i>
                        Slider: intervalo {{ $heroConfig->intervalo ?? 5000 }}ms • transição {{ $heroConfig->transicao ?? 'slide' }} • autoplay {{ ($heroConfig->autoplay ?? true) ? 'on' : 'off' }} • hover {{ ($heroConfig->pausar_hover ?? true) ? 'pausa' : 'não pausa' }} • indicadores {{ ($heroConfig->mostrar_indicadores ?? true) ? 'visíveis' : 'ocultos' }} • controles {{ ($heroConfig->mostrar_controles ?? true) ? 'visíveis' : 'ocultos' }}
                    </small>
                    <small class="text-light opacity-75">
                        <i class="fas fa-info-circle me-1"></i>
                        Este preview reflete as opções salvas, mas é uma aproximação visual da homepage.
                    </small>
                </div>
            </div>
            @else
                <div class="alert alert-warning mb-0">Nenhuma configuração ativa encontrada. Clique em "Editar Configurações" para criar/ajustar.</div>
            @endif
        </div>
    </div>

    <!-- Links Relacionados -->
    <div class="admin-card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-link me-2"></i>
                Links Relacionados
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-images me-2"></i>
                        Gerenciar Slides
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mb-2" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Ver Site
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection