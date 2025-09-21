@extends('layouts.app')

@section('title', $cartaServico->nome . ' - Cartas de Serviço')

@section('content')
<div class="carta-servico-show">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3 bg-light">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Início
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('cartas-servico.index') }}">Cartas de Serviço</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $cartaServico->nome }}
                </li>
            </ol>
        </div>
    </nav>

    <!-- Header do Serviço -->
    <section class="service-header py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="categoria-badge mb-3">
                        {{ ucfirst(str_replace('_', ' ', $cartaServico->categoria)) }}
                    </div>
                    <h1 class="display-5 fw-bold mb-3">{{ $cartaServico->nome }}</h1>
                    <p class="lead">{{ $cartaServico->descricao }}</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="service-stats">
                        <div class="stat-item">
                            <i class="fas fa-eye fa-2x mb-2"></i>
                            <div class="stat-number">{{ $cartaServico->visualizacoes ?? 0 }}</div>
                            <div class="stat-label">Visualizações</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informações Principais -->
    <section class="service-info py-5">
        <div class="container">
            <div class="row">
                <!-- Informações Básicas -->
                <div class="col-lg-8">
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informações Básicas
                        </h2>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fas fa-building text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Órgão Responsável</h6>
                                        <p>{{ $cartaServico->orgao_responsavel }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fas fa-users text-success"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Público Alvo</h6>
                                        <p>{{ $cartaServico->publico_alvo }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fas fa-clock text-warning"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Prazo de Atendimento</h6>
                                        <p>{{ $cartaServico->prazo_atendimento }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fas fa-money-bill-wave text-success"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Custo</h6>
                                        <p>{{ $cartaServico->custo ?? 'Gratuito' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requisitos -->
                    @if($cartaServico->requisitos)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Requisitos
                        </h2>
                        <div class="content-box">
                            {!! nl2br(e($cartaServico->requisitos)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Documentos Necessários -->
                    @if($cartaServico->documentos_necessarios)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-file-alt text-info me-2"></i>
                            Documentos Necessários
                        </h2>
                        <div class="content-box">
                            {!! nl2br(e($cartaServico->documentos_necessarios)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Etapas do Processo -->
                    @if($cartaServico->etapas_processo)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-list-ol text-primary me-2"></i>
                            Etapas do Processo
                        </h2>
                        <div class="content-box">
                            {!! nl2br(e($cartaServico->etapas_processo)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Canais de Atendimento -->
                    @if($cartaServico->canais_atendimento)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-phone text-success me-2"></i>
                            Canais de Atendimento
                        </h2>
                        <div class="channels-grid">
                            @foreach($cartaServico->canais_atendimento as $canal)
                                <div class="channel-item">
                                    @switch($canal)
                                        @case('presencial')
                                            <i class="fas fa-building"></i>
                                            <span>Presencial</span>
                                            @break
                                        @case('telefone')
                                            <i class="fas fa-phone"></i>
                                            <span>Telefone</span>
                                            @break
                                        @case('email')
                                            <i class="fas fa-envelope"></i>
                                            <span>E-mail</span>
                                            @break
                                        @case('site')
                                            <i class="fas fa-globe"></i>
                                            <span>Site</span>
                                            @break
                                        @case('aplicativo')
                                            <i class="fas fa-mobile-alt"></i>
                                            <span>Aplicativo</span>
                                            @break
                                        @case('whatsapp')
                                            <i class="fab fa-whatsapp"></i>
                                            <span>WhatsApp</span>
                                            @break
                                        @default
                                            <i class="fas fa-info-circle"></i>
                                            <span>{{ ucfirst($canal) }}</span>
                                    @endswitch
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Horário de Funcionamento -->
                    @if($cartaServico->horario_funcionamento)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Horário de Funcionamento
                        </h2>
                        <div class="content-box">
                            {!! nl2br(e($cartaServico->horario_funcionamento)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Legislação Base -->
                    @if($cartaServico->legislacao_base)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-gavel text-secondary me-2"></i>
                            Legislação Base
                        </h2>
                        <div class="content-box">
                            {!! nl2br(e($cartaServico->legislacao_base)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Observações -->
                    @if($cartaServico->observacoes)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            Observações Importantes
                        </h2>
                        <div class="content-box alert alert-warning">
                            {!! nl2br(e($cartaServico->observacoes)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Anexos -->
                    @if($cartaServico->anexos && count($cartaServico->anexos) > 0)
                    <div class="info-section mb-5">
                        <h2 class="section-title">
                            <i class="fas fa-paperclip text-info me-2"></i>
                            Anexos e Formulários
                        </h2>
                        <div class="anexos-list">
                            @foreach($cartaServico->anexos as $anexo)
                                <div class="anexo-item">
                                    <div class="anexo-icon">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                    </div>
                                    <div class="anexo-info">
                                        <h6>{{ $anexo['nome'] }}</h6>
                                        <small class="text-muted">
                                            {{ number_format($anexo['tamanho'] / 1024, 2) }} KB
                                        </small>
                                    </div>
                                    <div class="anexo-actions">
                                        <a href="{{ Storage::url($anexo['path']) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           target="_blank">
                                            <i class="fas fa-download me-1"></i>
                                            Baixar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- Ações Rápidas -->
                        <div class="sidebar-card mb-4">
                            <h5 class="sidebar-title">
                                <i class="fas fa-bolt text-warning me-2"></i>
                                Ações Rápidas
                            </h5>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i>
                                    Imprimir
                                </button>
                                <button class="btn btn-outline-primary" onclick="compartilhar()">
                                    <i class="fas fa-share-alt me-2"></i>
                                    Compartilhar
                                </button>
                                <a href="{{ route('cartas-servico.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Voltar à Lista
                                </a>
                            </div>
                        </div>

                        <!-- Informações de Contato -->
                        <div class="sidebar-card mb-4">
                            <h5 class="sidebar-title">
                                <i class="fas fa-phone text-success me-2"></i>
                                Contato
                            </h5>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-phone text-primary"></i>
                                    <span>(XX) XXXX-XXXX</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-envelope text-primary"></i>
                                    <span>contato@camara.gov.br</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    <span>Endereço da Câmara Municipal</span>
                                </div>
                            </div>
                        </div>

                        <!-- Serviços Relacionados -->
                        <div class="sidebar-card">
                            <h5 class="sidebar-title">
                                <i class="fas fa-link text-info me-2"></i>
                                Serviços Relacionados
                            </h5>
                            <div class="related-services">
                                <a href="{{ route('esic.index') }}" class="related-service-item">
                                    <i class="fas fa-info-circle"></i>
                                    <span>E-SIC - Acesso à Informação</span>
                                </a>
                                <a href="#" class="related-service-item">
                                    <i class="fas fa-comments"></i>
                                    <span>Ouvidoria</span>
                                </a>
                                <a href="#" class="related-service-item">
                                    <i class="fas fa-users"></i>
                                    <span>Vereadores</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="{{ asset('css/cartas-servico.css') }}">
<script src="{{ asset('js/cartas-servico-show.js') }}"></script>

<script>
function compartilhar() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $cartaServico->nome }}',
            text: '{{ Str::limit($cartaServico->descricao, 100) }}',
            url: window.location.href
        });
    } else {
        // Fallback: copiar URL
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copiado para a área de transferência!');
        });
    }
}
</script>
@endsection