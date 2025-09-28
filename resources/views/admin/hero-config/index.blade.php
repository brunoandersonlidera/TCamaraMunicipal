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
                        
                        <h6 class="text-muted mb-2">Subtítulo</h6>
                        <p class="mb-3">{{ $heroConfig->subtitulo ?? 'Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. Acompanhe as atividades legislativas e participe da vida política da sua cidade.' }}</p>
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
            <div class="hero-preview" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem; border-radius: 0.5rem; text-align: center;">
                <h1 class="display-4 mb-3">{{ $heroConfig->titulo ?? 'Bem-vindo à Câmara Municipal' }}</h1>
                <p class="lead">{{ $heroConfig->subtitulo ?? 'Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. Acompanhe as atividades legislativas e participe da vida política da sua cidade.' }}</p>
                <div class="mt-4">
                    <small class="text-light opacity-75">
                        <i class="fas fa-info-circle me-1"></i>
                        Este é um preview simplificado. Veja o resultado completo no site.
                    </small>
                </div>
            </div>
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