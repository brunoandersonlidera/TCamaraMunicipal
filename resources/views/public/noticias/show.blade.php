@extends('layouts.app')

@section('title', $noticia->titulo . ' - Câmara Municipal')

@section('meta-description', $noticia->meta_description ?: Str::limit(strip_tags($noticia->resumo), 160))

@section('meta-keywords', $noticia->meta_keywords ?: implode(', ', $noticia->tags ?? []))

@section('og-title', $noticia->titulo)
@section('og-description', Str::limit(strip_tags($noticia->resumo), 200))
@section('og-image', $noticia->imagem_destaque ? asset('storage/' . $noticia->imagem_destaque) : asset('images/logo-camara-og.png'))

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}">Notícias</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($noticia->titulo, 50) }}</li>
            </ol>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Conteúdo Principal -->
            <div class="col-lg-8">
                <article class="card card-news shadow-sm">
                    <!-- Imagem de Destaque -->
                    @if($noticia->imagem_destaque)
                        <div class="news-image-wrapper news-image-wrapper-lg">
                            <img src="{{ asset('storage/' . $noticia->imagem_destaque) }}" 
                                 class="news-image" alt="{{ $noticia->titulo }}">
                        </div>
                    @endif

                    <div class="card-body">
                        @php
                            $wordCount = str_word_count(strip_tags($noticia->conteudo ?? ''));
                            $readingMinutes = max(1, ceil($wordCount / 200));
                        @endphp
                        <!-- Categoria e Data -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @if($noticia->categoria)
                                <span class="badge bg-primary fs-6">
                                    {{ ucfirst($noticia->categoria) }}
                                </span>
                            @endif
                            
                            <div class="text-muted">
                                <small>
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $noticia->data_publicacao->format('d/m/Y \à\s H:i') }}
                                </small>
                                <small class="ms-3">
                                    <i class="fas fa-eye me-1"></i>
                                    {{ $noticia->visualizacoes }} visualizações
                                </small>
                                <small class="ms-3">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $readingMinutes }} min de leitura
                                </small>
                            </div>
                        </div>

                        <!-- Título -->
                        <h1 class="card-title display-5 fw-bold mb-4">{{ $noticia->titulo }}</h1>

                        <!-- Resumo -->
                        @if($noticia->resumo)
                            <div class="lead text-muted mb-4 p-3 bg-light rounded">
                                {{ $noticia->resumo }}
                            </div>
                        @endif

                        <!-- Autor -->
                        @if($noticia->autor)
                            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                                <div class="me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <strong>Por: {{ $noticia->autor->name }}</strong>
                                    @if($noticia->autor->email)
                                        <br><small class="text-muted">{{ $noticia->autor->email }}</small>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Conteúdo -->
                        <div class="content-body">
                            {!! $noticia->conteudo !!}
                        </div>

                        <!-- Tags -->
                        @if($noticia->tags && count($noticia->tags) > 0)
                            <div class="mt-4 pt-4 border-top">
                                <h6 class="text-muted mb-2">Tags:</h6>
                                @foreach($noticia->tags as $tag)
                                    <span class="tag-chip me-1 mb-1">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Galeria de Imagens -->
                        @if($noticia->galeria_imagens && count($noticia->galeria_imagens) > 0)
                            <div class="mt-4 pt-4 border-top">
                                <h6 class="mb-3">Galeria de Imagens</h6>
                                <div class="row">
                                    @foreach($noticia->galeria_imagens as $imagem)
                                        <div class="col-md-4 mb-3">
                                            <img src="{{ asset('storage/' . $imagem) }}" 
                                                 class="img-fluid rounded shadow-sm" 
                                                 alt="Galeria"
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#galeriaModal"
                                                 data-bs-slide-to="{{ $loop->index }}"
                                                 style="cursor: pointer;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Leia também (grid de relacionadas) -->
                        @if(isset($noticiasRelacionadas) && $noticiasRelacionadas->count() > 0)
                            <div class="mt-4 pt-4 border-top">
                                <h5 class="mb-3">Leia também</h5>
                                <div class="row g-3">
                                    @foreach($noticiasRelacionadas->take(3) as $rel)
                                        <div class="col-md-4">
                                            <article class="card card-news h-100">
                                                @if($rel->imagem_destaque)
                                                    <div class="news-image-wrapper news-image-wrapper-sm">
                                                        <img src="{{ asset('storage/' . $rel->imagem_destaque) }}" class="news-image" alt="{{ $rel->titulo }}">
                                                    </div>
                                                @endif
                                                <div class="card-body">
                                                    <h6 class="related-title mb-2">{{ Str::limit($rel->titulo, 70) }}</h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ $rel->data_publicacao->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                                <a href="{{ route('noticias.show', $rel->slug) }}" class="stretched-link" aria-label="Ler: {{ $rel->titulo }}"></a>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <!-- Compartilhar -->
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="mb-3">Compartilhar</h6>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook-f me-1"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($noticia->titulo) }}" 
                                   target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fab fa-twitter me-1"></i> Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($noticia->titulo . ' - ' . request()->url()) }}" 
                                   target="_blank" class="btn btn-outline-success btn-sm">
                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                                    <i class="fas fa-link me-1"></i> Copiar Link
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Navegação entre notícias -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('noticias.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar às notícias
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Notícias Relacionadas -->
                @if($noticiasRelacionadas->count() > 0)
                    <div class="card card-news mb-4">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="fas fa-newspaper me-2"></i>Notícias Relacionadas
                            </h5>
                            <a href="{{ route('noticias.index') }}" class="btn btn-outline-light btn-sm">Ver todas</a>
                        </div>
                        <div class="card-body p-0">
                            @foreach($noticiasRelacionadas as $relacionada)
                                <a href="{{ route('noticias.show', $relacionada->slug) }}" 
                                   class="related-item d-block p-3 border-bottom text-decoration-none">
                                    @if($relacionada->imagem_destaque)
                                        <div class="news-image-wrapper news-image-wrapper-sm mb-2">
                                            <img src="{{ asset('storage/' . $relacionada->imagem_destaque) }}" 
                                                 class="news-image" alt="{{ $relacionada->titulo }}">
                                        </div>
                                    @endif
                                    <h6 class="related-title mb-1">{{ Str::limit($relacionada->titulo, 80) }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $relacionada->data_publicacao->format('d/m/Y') }}
                                    </small>
                                </a>
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

<!-- Modal para Galeria -->
@if($noticia->galeria_imagens && count($noticia->galeria_imagens) > 0)
    <div class="modal fade" id="galeriaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Galeria de Imagens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="galeriaCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($noticia->galeria_imagens as $imagem)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $imagem) }}" 
                                         class="d-block w-100" alt="Galeria">
                                </div>
                            @endforeach
                        </div>
                        @if(count($noticia->galeria_imagens) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#galeriaCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#galeriaCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link copiado para a área de transferência!');
    });
}
</script>
@endsection