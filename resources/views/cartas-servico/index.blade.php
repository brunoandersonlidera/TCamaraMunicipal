@extends('layouts.app')

@section('title', 'Carta de Serviços - Câmara Municipal')

@push('styles')
<link href="{{ asset('css/public-styles.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="hero-title">Carta de Serviços</h1>
            <p class="hero-subtitle">Conheça todos os serviços oferecidos pela Câmara Municipal</p>
            <p class="hero-description">
                A Carta de Serviços é um documento que informa aos cidadãos quais serviços são prestados pela Câmara Municipal, 
                como acessá-los e quais são os compromissos de qualidade de atendimento.
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Busca e Filtros -->
        <div class="search-section">
            <form method="GET" action="{{ route('cartas-servico.index') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busca" class="form-label">Buscar Serviços</label>
                            <input type="text" class="form-control" id="busca" name="busca" 
                                   placeholder="Digite o nome do serviço ou palavra-chave..." 
                                   value="{{ request('busca') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas as categorias</option>
                                <option value="legislativo" {{ request('categoria') === 'legislativo' ? 'selected' : '' }}>
                                    Processo Legislativo
                                </option>
                                <option value="administrativo" {{ request('categoria') === 'administrativo' ? 'selected' : '' }}>
                                    Serviços Administrativos
                                </option>
                                <option value="transparencia" {{ request('categoria') === 'transparencia' ? 'selected' : '' }}>
                                    Transparência
                                </option>
                                <option value="comunicacao" {{ request('categoria') === 'comunicacao' ? 'selected' : '' }}>
                                    Comunicação
                                </option>
                                <option value="participacao" {{ request('categoria') === 'participacao' ? 'selected' : '' }}>
                                    Participação Cidadã
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Estatísticas -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalServicos ?? 25 }}</div>
                    <div class="stat-label">Serviços Disponíveis</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $totalCategorias ?? 5 }}</div>
                    <div class="stat-label">Categorias</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $servicosDigitais ?? 18 }}</div>
                    <div class="stat-label">Serviços Digitais</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24h</div>
                    <div class="stat-label">Disponibilidade</div>
                </div>
            </div>
        </div>

        <!-- Filtros por Categoria -->
        <div class="category-filter">
            <a href="{{ route('cartas-servico.index') }}" 
               class="category-btn {{ !request('categoria') ? 'active' : '' }}">
                <i class="fas fa-th-large me-2"></i>Todos
            </a>
            <a href="{{ route('cartas-servico.index', ['categoria' => 'legislativo']) }}" 
               class="category-btn {{ request('categoria') === 'legislativo' ? 'active' : '' }}">
                <i class="fas fa-gavel me-2"></i>Processo Legislativo
            </a>
            <a href="{{ route('cartas-servico.index', ['categoria' => 'administrativo']) }}" 
               class="category-btn {{ request('categoria') === 'administrativo' ? 'active' : '' }}">
                <i class="fas fa-file-alt me-2"></i>Administrativos
            </a>
            <a href="{{ route('cartas-servico.index', ['categoria' => 'transparencia']) }}" 
               class="category-btn {{ request('categoria') === 'transparencia' ? 'active' : '' }}">
                <i class="fas fa-eye me-2"></i>Transparência
            </a>
            <a href="{{ route('cartas-servico.index', ['categoria' => 'comunicacao']) }}" 
               class="category-btn {{ request('categoria') === 'comunicacao' ? 'active' : '' }}">
                <i class="fas fa-bullhorn me-2"></i>Comunicação
            </a>
            <a href="{{ route('cartas-servico.index', ['categoria' => 'participacao']) }}" 
               class="category-btn {{ request('categoria') === 'participacao' ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i>Participação
            </a>
        </div>

        <!-- Grid de Serviços -->
        @if(isset($servicos) && $servicos->count() > 0)
            <div class="services-grid">
                @foreach($servicos as $servico)
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="{{ $servico->icone ?? 'fas fa-cog' }}"></i>
                        </div>
                        
                        <h3 class="service-title">{{ $servico->nome }}</h3>
                        
                        <p class="service-description">{{ $servico->descricao }}</p>
                        
                        <div class="service-meta">
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                {{ ucfirst($servico->categoria) }}
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                {{ $servico->prazo_atendimento ?? 'Imediato' }}
                            </div>
                            @if($servico->custo)
                                <div class="meta-item">
                                    <i class="fas fa-dollar-sign"></i>
                                    {{ $servico->custo }}
                                </div>
                            @else
                                <div class="meta-item">
                                    <i class="fas fa-gift"></i>
                                    Gratuito
                                </div>
                            @endif
                        </div>
                        
                        <div class="service-actions">
                            <a href="{{ route('cartas-servico.show', $servico->id) }}" class="btn-view">
                                <i class="fas fa-eye me-2"></i>Ver Detalhes
                            </a>
                            @if($servico->arquivo_pdf)
                                <a href="{{ $servico->arquivo_pdf }}" class="btn-download" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            @if(method_exists($servicos, 'links'))
                {{ $servicos->links() }}
            @endif

        @else
            <!-- Estado Vazio -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="empty-state-title">Nenhum serviço encontrado</h3>
                <p class="empty-state-description">
                    @if(request('busca') || request('categoria'))
                        Não encontramos serviços que correspondam aos seus critérios de busca.
                        <br>Tente ajustar os filtros ou fazer uma nova busca.
                    @else
                        Os serviços estão sendo atualizados. Volte em breve para conferir nossa carta de serviços completa.
                    @endif
                </p>
                @if(request('busca') || request('categoria'))
                    <a href="{{ route('cartas-servico.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-refresh me-2"></i>Ver Todos os Serviços
                    </a>
                @endif
            </div>
        @endif

        <!-- Informações Adicionais -->
        <div class="info-section">
            <h2 class="info-title">Sobre a Carta de Serviços</h2>
            <div class="info-content">
                <p>
                    A Carta de Serviços da Câmara Municipal é um instrumento de transparência que visa informar 
                    aos cidadãos sobre os serviços prestados pela instituição, estabelecendo padrões de qualidade 
                    e facilitando o acesso aos serviços públicos.
                </p>
                <p>
                    Aqui você encontra informações detalhadas sobre cada serviço, incluindo documentos necessários, 
                    prazos de atendimento, canais de acesso e custos envolvidos, garantindo maior clareza e 
                    eficiência no atendimento ao público.
                </p>
            </div>
        </div>
    </div>
</section>

<script>
// Auto-submit do formulário quando categoria é alterada
document.getElementById('categoria').addEventListener('change', function() {
    this.form.submit();
});

// Filtro em tempo real
document.getElementById('busca').addEventListener('input', function() {
    // Implementar busca em tempo real se necessário
});

// Smooth scroll para seções
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
</script>
@endsection