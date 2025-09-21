@extends('layouts.app')

@section('title', $servico->nome ?? 'Detalhes do Serviço - Carta de Serviços')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/public-styles.css') }}">
@endpush

@section('content')

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cartas-servico.index') }}">Carta de Serviços</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $servico->nome ?? 'Detalhes do Serviço' }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="hero-title">Detalhes do Serviço</h1>
            <p class="hero-subtitle">Informações completas sobre como acessar este serviço</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Cabeçalho do Serviço -->
        <div class="service-header">
            <div class="service-icon">
                <i class="{{ $servico->icone ?? 'fas fa-cog' }}"></i>
            </div>
            
            <h1 class="service-title">{{ $servico->nome ?? 'Nome do Serviço' }}</h1>
            
            <p class="service-description">
                {{ $servico->descricao ?? 'Descrição detalhada do serviço oferecido pela Câmara Municipal.' }}
            </p>
            
            <div class="service-meta">
                <div class="meta-badge category">
                    <i class="fas fa-tag"></i>
                    {{ ucfirst($servico->categoria ?? 'Categoria') }}
                </div>
                
                @if($servico->custo ?? false)
                    <div class="meta-badge cost">
                        <i class="fas fa-dollar-sign"></i>
                        {{ $servico->custo }}
                    </div>
                @else
                    <div class="meta-badge cost">
                        <i class="fas fa-gift"></i>
                        Gratuito
                    </div>
                @endif
                
                <div class="meta-badge time">
                    <i class="fas fa-clock"></i>
                    {{ $servico->prazo_atendimento ?? 'Imediato' }}
                </div>
            </div>
        </div>

        <!-- Informações Gerais -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                Informações Gerais
            </h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Público-Alvo</div>
                    <div class="info-value">{{ $servico->publico_alvo ?? 'Cidadãos em geral' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Prazo de Atendimento</div>
                    <div class="info-value">{{ $servico->prazo_atendimento ?? 'Imediato' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Setor Responsável</div>
                    <div class="info-value">{{ $servico->setor_responsavel ?? 'Secretaria Geral' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Base Legal</div>
                    <div class="info-value">{{ $servico->base_legal ?? 'Lei Orgânica Municipal' }}</div>
                </div>
            </div>
            
            @if($servico->observacoes ?? false)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Observações Importantes:</strong><br>
                    {{ $servico->observacoes }}
                </div>
            @endif
        </div>

        <!-- Etapas do Processo -->
        @if($servico->etapas ?? false)
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-list-ol"></i>
                    Como Solicitar
                </h2>
                
                <ol class="steps-list">
                    @foreach($servico->etapas as $index => $etapa)
                        <li class="step-item">
                            <div class="step-number">{{ $index + 1 }}</div>
                            <div class="step-title">{{ $etapa['titulo'] }}</div>
                            <div class="step-description">{{ $etapa['descricao'] }}</div>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif

        <!-- Documentos Necessários -->
        @if($servico->documentos ?? false)
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Documentos Necessários
                </h2>
                
                <ul class="documents-list">
                    @foreach($servico->documentos as $documento)
                        <li class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-file"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-name">{{ $documento['nome'] }}</div>
                                @if($documento['descricao'] ?? false)
                                    <div class="document-description">{{ $documento['descricao'] }}</div>
                                @endif
                            </div>
                            @if($documento['obrigatorio'] ?? true)
                                <span class="document-required">Obrigatório</span>
                            @else
                                <span class="document-optional">Opcional</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção:</strong> Todos os documentos devem estar em via original ou cópia autenticada. 
                    Documentos ilegíveis ou danificados não serão aceitos.
                </div>
            </div>
        @endif

        <!-- Canais de Atendimento -->
        @if($servico->canais ?? false)
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-phone"></i>
                    Canais de Atendimento
                </h2>
                
                <div class="channels-grid">
                    @foreach($servico->canais as $canal)
                        <div class="channel-card">
                            <div class="channel-icon">
                                <i class="{{ $canal['icone'] ?? 'fas fa-phone' }}"></i>
                            </div>
                            <div class="channel-name">{{ $canal['nome'] }}</div>
                            <div class="channel-info">{{ $canal['descricao'] }}</div>
                            @if($canal['horario'] ?? false)
                                <div class="channel-details">
                                    <strong>Horário:</strong> {{ $canal['horario'] }}
                                </div>
                            @endif
                            @if($canal['contato'] ?? false)
                                <div class="channel-details">
                                    <strong>Contato:</strong> {{ $canal['contato'] }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Ações -->
        <div class="action-buttons">
            <a href="{{ route('cartas-servico.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Voltar à Lista
            </a>
            
            @if($servico->arquivo_pdf ?? false)
                <a href="{{ $servico->arquivo_pdf }}" class="btn-primary" target="_blank">
                    <i class="fas fa-download"></i>
                    Baixar PDF
                </a>
            @endif
            
            @if($servico->link_externo ?? false)
                <a href="{{ $servico->link_externo }}" class="btn-outline-primary" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    Acessar Serviço
                </a>
            @endif
            
            <button onclick="window.print()" class="btn-outline-primary">
                <i class="fas fa-print"></i>
                Imprimir
            </button>
            
            <button onclick="compartilhar()" class="btn-outline-primary">
                <i class="fas fa-share-alt"></i>
                Compartilhar
            </button>
        </div>

        <!-- Serviços Relacionados -->
        @if($servicosRelacionados ?? false)
            <div class="related-services">
                <h2 class="section-title">
                    <i class="fas fa-link"></i>
                    Serviços Relacionados
                </h2>
                
                <div class="related-grid">
                    @foreach($servicosRelacionados as $relacionado)
                        <div class="related-item">
                            <div class="related-title">{{ $relacionado->nome }}</div>
                            <div class="related-description">{{ Str::limit($relacionado->descricao, 100) }}</div>
                            <a href="{{ route('cartas-servico.show', $relacionado->id) }}" class="related-link">
                                Ver detalhes <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<script>
// Função para compartilhar
function compartilhar() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $servico->nome ?? "Serviço da Câmara Municipal" }}',
            text: '{{ $servico->descricao ?? "Confira este serviço da Câmara Municipal" }}',
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

// Smooth scroll para âncoras
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Destacar seção atual no scroll
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('.content-section');
    const scrollPos = window.scrollY + 100;
    
    sections.forEach(section => {
        const top = section.offsetTop;
        const bottom = top + section.offsetHeight;
        
        if (scrollPos >= top && scrollPos <= bottom) {
            // Adicionar classe de destaque se necessário
        }
    });
});
</script>
@endsection