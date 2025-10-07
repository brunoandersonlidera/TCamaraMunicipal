@extends('layouts.app')

@section('title', 'Notícias - Câmara Municipal')

@section('meta-description', 'Acompanhe as últimas notícias da Câmara Municipal. Fique por dentro das atividades dos vereadores, sessões e projetos de lei.')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Notícias</h1>
                    <p class="lead mb-0">Acompanhe as últimas notícias e atividades da Câmara Municipal</p>
                </div>
                <div class="col-lg-4 text-end">
                    <i class="fas fa-newspaper fa-5x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Conteúdo Principal -->
            <div class="col-lg-8">
                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('noticias.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="busca" class="form-label">Buscar</label>
                                <input type="text" class="form-control" id="busca" name="busca" 
                                       value="{{ request('busca') }}" placeholder="Digite sua busca...">
                            </div>
                            <div class="col-md-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select class="form-select" id="categoria" name="categoria">
                                    <option value="">Todas as categorias</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria }}" 
                                                {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                            {{ ucfirst($categoria) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="ordenacao" class="form-label">Ordenar por</label>
                                <select class="form-select" id="ordenacao" name="ordenacao">
                                    <option value="recentes" {{ request('ordenacao') == 'recentes' ? 'selected' : '' }}>
                                        Mais recentes
                                    </option>
                                    <option value="mais_lidas" {{ request('ordenacao') == 'mais_lidas' ? 'selected' : '' }}>
                                        Mais lidas
                                    </option>
                                    <option value="antigas" {{ request('ordenacao') == 'antigas' ? 'selected' : '' }}>
                                        Mais antigas
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i> Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de Notícias -->
                @if($noticias->count() > 0)
                    <div class="row">
                        @foreach($noticias as $noticia)
                            <div class="col-md-6 mb-4">
                                <div class="card card-news h-100 shadow-sm">
                                    @if($noticia->imagem_destaque)
                                        <div class="news-image-wrapper">
                                            <img src="{{ asset('storage/' . $noticia->imagem_destaque) }}" 
                                                 class="news-image" alt="{{ $noticia->titulo }}">
                                        </div>
                                    @endif
                                    
                                    <div class="card-body d-flex flex-column">
                                        @if($noticia->categoria)
                                            <span class="badge bg-secondary mb-2 align-self-start">
                                                {{ ucfirst($noticia->categoria) }}
                                            </span>
                                        @endif
                                        
                                        <h5 class="card-title">
                                            <a href="{{ route('noticias.show', $noticia->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ $noticia->titulo }}
                                            </a>
                                        </h5>
                                        
                                        <p class="card-text text-muted flex-grow-1">
                                            {{ Str::limit($noticia->resumo, 120) }}
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $noticia->data_publicacao->format('d/m/Y') }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-eye me-1"></i>
                                                {{ $noticia->visualizacoes }} visualizações
                                            </small>
                                        </div>
                                        
                                        <a href="{{ route('noticias.show', $noticia->slug) }}" 
                                           class="btn btn-outline-primary btn-sm mt-2">
                                            Ler mais <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginação -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $noticias->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Nenhuma notícia encontrada</h4>
                        <p class="text-muted">Não há notícias disponíveis no momento ou que correspondam aos filtros aplicados.</p>
                        @if(request()->hasAny(['busca', 'categoria']))
                            <a href="{{ route('noticias.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-times me-1"></i> Limpar filtros
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Notícias em Destaque -->
                @if($noticiasDestaque->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-star me-2"></i>Notícias em Destaque
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @foreach($noticiasDestaque as $destaque)
                                <div class="p-3 border-bottom">
                                    <h6 class="mb-2">
                                        <a href="{{ route('noticias.show', $destaque->slug) }}" 
                                           class="text-decoration-none">
                                            {{ Str::limit($destaque->titulo, 60) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $destaque->data_publicacao->format('d/m/Y') }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Links Úteis -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-link me-2"></i>Links Úteis
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('transparencia.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-eye me-2"></i>Portal da Transparência
                            </a>
                            <a href="{{ route('vereadores.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-users me-2"></i>Vereadores
                            </a>
                            <a href="{{ route('sessoes.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-gavel me-2"></i>Sessões
                            </a>
                            <a href="{{ route('leis.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-balance-scale me-2"></i>Legislação
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection