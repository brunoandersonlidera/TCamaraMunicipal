@extends('layouts.app')

@section('title', 'E-SIC - Sistema Eletrônico do Serviço de Informação ao Cidadão')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section bg-gradient-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">E-SIC</h1>
                    <h2 class="h3 mb-4">Sistema Eletrônico do Serviço de Informação ao Cidadão</h2>
                    <p class="lead mb-4">
                        O E-SIC é o canal oficial para solicitação de informações públicas da Câmara Municipal, 
                        garantindo transparência e acesso à informação conforme a Lei de Acesso à Informação (LAI).
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-user-plus me-2"></i>Cadastre-se
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-sign-in-alt me-2"></i>Fazer Login
                            </a>
                        @else
                            <a href="{{ route('esic.dashboard') }}" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-tachometer-alt me-2"></i>Meu Dashboard
                            </a>
                            <a href="{{ route('esic.create') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-plus me-2"></i>Nova Solicitação
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="hero-icon">
                        <i class="fas fa-file-alt fa-8x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Estatísticas Gerais -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-center mb-4">Estatísticas de Atendimento</h2>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon text-primary mb-3">
                            <i class="fas fa-file-alt fa-3x"></i>
                        </div>
                        <h3 class="stat-number">{{ number_format($estatisticas['total_solicitacoes']) }}</h3>
                        <p class="stat-label text-muted">Total de Solicitações</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon text-success mb-3">
                            <i class="fas fa-calendar-month fa-3x"></i>
                        </div>
                        <h3 class="stat-number">{{ number_format($estatisticas['solicitacoes_mes']) }}</h3>
                        <p class="stat-label text-muted">Solicitações este Mês</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon text-info mb-3">
                            <i class="fas fa-clock fa-3x"></i>
                        </div>
                        <h3 class="stat-number">{{ $estatisticas['tempo_medio_resposta'] }}</h3>
                        <p class="stat-label text-muted">Dias (Tempo Médio)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon text-warning mb-3">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                        <h3 class="stat-number">{{ $estatisticas['taxa_atendimento'] }}%</h3>
                        <p class="stat-label text-muted">Taxa de Atendimento</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row mb-5">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Solicitações por Categoria
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoriaChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>Solicitações por Mês
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="mesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações sobre o E-SIC -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="card-title mb-0">Como Funciona o E-SIC?</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="step-icon text-primary mb-3">
                                    <i class="fas fa-user-plus fa-3x"></i>
                                </div>
                                <h5>1. Cadastre-se</h5>
                                <p class="text-muted">Crie sua conta no sistema para ter acesso ao formulário de solicitações.</p>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="step-icon text-success mb-3">
                                    <i class="fas fa-file-plus fa-3x"></i>
                                </div>
                                <h5>2. Faça sua Solicitação</h5>
                                <p class="text-muted">Preencha o formulário com sua solicitação de informação pública.</p>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="step-icon text-info mb-3">
                                    <i class="fas fa-search fa-3x"></i>
                                </div>
                                <h5>3. Acompanhe</h5>
                                <p class="text-muted">Monitore o status da sua solicitação através do seu dashboard.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        @guest
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <div class="card bg-light">
                    <div class="card-body py-5">
                        <h3 class="mb-4">Pronto para solicitar informações?</h3>
                        <p class="lead mb-4">
                            Cadastre-se agora e tenha acesso completo ao sistema de solicitação de informações públicas.
                        </p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-user-plus me-2"></i>Criar Conta
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5">
                                <i class="fas fa-sign-in-alt me-2"></i>Já tenho conta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endguest

        <!-- Links Úteis -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-question-circle fa-3x text-primary mb-3"></i>
                        <h5>Perguntas Frequentes</h5>
                        <p class="text-muted">Tire suas dúvidas sobre o E-SIC e a Lei de Acesso à Informação.</p>
                        <a href="{{ route('esic.faq') }}" class="btn btn-outline-primary">Ver FAQ</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-info-circle fa-3x text-success mb-3"></i>
                        <h5>Sobre o E-SIC</h5>
                        <p class="text-muted">Conheça mais sobre o sistema e seus direitos como cidadão.</p>
                        <a href="{{ route('esic.sobre') }}" class="btn btn-outline-success">Saiba Mais</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                        <h5>Estatísticas Detalhadas</h5>
                        <p class="text-muted">Veja estatísticas completas e relatórios de transparência.</p>
                        <a href="{{ route('esic.estatisticas') }}" class="btn btn-outline-info">Ver Estatísticas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container invisível para passar dados para JavaScript -->
<div id="esic-public-charts-container" 
     data-categoria-data="{{ json_encode($estatisticas['solicitacoes_por_categoria'] ?? []) }}"
     data-mes-data="{{ json_encode($estatisticas['solicitacoes_por_mes'] ?? []) }}"
     style="display: none;"></div>

@endsection

@push('styles')
<link href="{{ asset('css/esic.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/esic-public-index.js') }}"></script>
@endpush