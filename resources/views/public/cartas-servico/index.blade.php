@extends('layouts.app')

@section('title', 'Cartas de Serviço - Câmara Municipal')

@section('content')
<div class="cartas-servico-page">
    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-file-alt me-3"></i>
                        Cartas de Serviço
                    </h1>
                    <p class="lead mb-4">
                        Conheça todos os serviços oferecidos pela Câmara Municipal. 
                        Aqui você encontra informações detalhadas sobre como solicitar 
                        cada serviço, documentos necessários, prazos e custos.
                    </p>
                    <div class="hero-stats d-flex flex-wrap gap-4">
                        <div class="stat-item">
                            <span class="stat-number">{{ $cartasServico->total() }}</span>
                            <span class="stat-label">Serviços Disponíveis</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $categorias->count() }}</span>
                            <span class="stat-label">Categorias</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="hero-icon">
                        <i class="fas fa-clipboard-list fa-8x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtros e Busca -->
    <section class="filters-section py-4 bg-light">
        <div class="container">
            <form method="GET" action="{{ route('cartas-servico.index') }}" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Buscar por nome, descrição ou órgão responsável...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="categoria" class="form-select">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria }}" 
                                    {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $categoria)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Lista de Cartas de Serviço -->
    <section class="cartas-list-section py-5">
        <div class="container">
            @if($cartasServico->count() > 0)
                <div class="row">
                    @foreach($cartasServico as $carta)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="carta-card h-100">
                                <div class="card-header">
                                    <div class="categoria-badge">
                                        {{ ucfirst(str_replace('_', ' ', $carta->categoria)) }}
                                    </div>
                                    <h5 class="card-title">{{ $carta->nome }}</h5>
                                </div>
                                
                                <div class="card-body">
                                    <p class="card-description">
                                        {{ Str::limit($carta->descricao, 120) }}
                                    </p>
                                    
                                    <div class="service-info">
                                        <div class="info-item">
                                            <i class="fas fa-building text-primary"></i>
                                            <span>{{ $carta->orgao_responsavel }}</span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <i class="fas fa-clock text-warning"></i>
                                            <span>{{ $carta->prazo_atendimento }}</span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <i class="fas fa-money-bill-wave text-success"></i>
                                            <span>{{ $carta->custo ?? 'Gratuito' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer">
                                    <a href="{{ route('cartas-servico.show', $carta->slug) }}" 
                                       class="btn btn-primary w-100">
                                        <i class="fas fa-eye me-2"></i>
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $cartasServico->appends(request()->query())->links() }}
                </div>
            @else
                <div class="no-results text-center py-5">
                    <div class="no-results-icon mb-4">
                        <i class="fas fa-search fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Nenhum serviço encontrado</h3>
                    <p class="text-muted mb-4">
                        Não encontramos serviços que correspondam aos seus critérios de busca.
                    </p>
                    <a href="{{ route('cartas-servico.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh me-2"></i>
                        Ver Todos os Serviços
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Informações Adicionais -->
    <section class="info-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="info-card text-center">
                        <div class="info-icon mb-3">
                            <i class="fas fa-question-circle fa-3x text-primary"></i>
                        </div>
                        <h4>Dúvidas?</h4>
                        <p>Entre em contato conosco para esclarecimentos sobre nossos serviços.</p>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Fale Conosco
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="info-card text-center">
                        <div class="info-icon mb-3">
                            <i class="fas fa-file-download fa-3x text-success"></i>
                        </div>
                        <h4>Documentos</h4>
                        <p>Baixe formulários e documentos necessários para solicitar nossos serviços.</p>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fas fa-download me-2"></i>Downloads
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="info-card text-center">
                        <div class="info-icon mb-3">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                        <h4>Horários</h4>
                        <p>Confira os horários de atendimento e funcionamento da Câmara Municipal.</p>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-calendar me-2"></i>Ver Horários
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="{{ asset('css/cartas-servico.css') }}">
<script src="{{ asset('js/cartas-servico-public.js') }}"></script>
@endsection