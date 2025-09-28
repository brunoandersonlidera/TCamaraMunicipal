@extends('layouts.app')

@section('title', $lei->titulo . ' - Câmara Municipal')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home"></i>
                            Início
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('leis.index') }}">
                            <i class="fas fa-balance-scale"></i>
                            Acervo de Leis
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $lei->numero_formatado }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="lei-detalhes-section">
        <div class="container">
            <div class="row">
                <!-- Conteúdo Principal -->
                <div class="col-lg-8">
                    <div class="lei-detalhes-card">
                        <!-- Cabeçalho -->
                        <div class="lei-header">
                            <div class="lei-tipo-badge">
                                <span class="badge badge-tipo badge-{{ Str::slug($lei->tipo) }}">
                                    {{ $lei->tipo }}
                                </span>
                            </div>
                            <h1 class="lei-titulo">{{ $lei->titulo }}</h1>
                            <div class="lei-numero">{{ $lei->numero_formatado }}</div>
                        </div>

                        <!-- Metadados -->
                        <div class="lei-meta">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <strong>Data:</strong>
                                        {{ $lei->data->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <i class="fas fa-hashtag"></i>
                                        <strong>Exercício:</strong>
                                        {{ $lei->exercicio }}
                                    </div>
                                </div>
                                @if($lei->autoria)
                                    <div class="col-md-6">
                                        <div class="meta-item">
                                            <i class="fas fa-user"></i>
                                            <strong>Autoria:</strong>
                                            {{ $lei->autoria }}
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        <strong>Publicado em:</strong>
                                        {{ $lei->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ementa -->
                        @if($lei->ementa)
                            <div class="lei-ementa">
                                <h3>
                                    <i class="fas fa-file-alt"></i>
                                    Ementa
                                </h3>
                                <div class="ementa-content">
                                    {{ $lei->ementa }}
                                </div>
                            </div>
                        @endif

                        <!-- Descrição/Conteúdo -->
                        <div class="lei-conteudo">
                            <h3>
                                <i class="fas fa-align-left"></i>
                                Conteúdo da Lei
                            </h3>
                            <div class="lei-visualizacao conteudo-text">
                                {!! $lei->descricao !!}
                            </div>
                        </div>

                        <!-- Observações -->
                        @if($lei->observacoes)
                            <div class="lei-observacoes">
                                <h3>
                                    <i class="fas fa-info-circle"></i>
                                    Observações
                                </h3>
                                <div class="observacoes-content">
                                    {!! nl2br(e($lei->observacoes)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Ações -->
                        <div class="lei-acoes">
                            <div class="row g-2">
                                <div class="col-auto">
                                    @if($lei->temArquivoPdf())
                                        <a href="{{ route('leis.download', $lei->id) }}" 
                                           class="btn btn-danger"
                                           target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                            Baixar PDF
                                        </a>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <button type="button" 
                                            class="btn btn-outline-primary"
                                            onclick="imprimirLei()">
                                        <i class="fas fa-print"></i>
                                        Imprimir
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" 
                                            class="btn btn-outline-secondary"
                                            onclick="compartilharLei()">
                                        <i class="fas fa-share-alt"></i>
                                        Compartilhar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Navegação -->
                    <div class="sidebar-card navegacao-card">
                        <h4>
                            <i class="fas fa-compass"></i>
                            Navegação
                        </h4>
                        <div class="navegacao-links">
                            <a href="{{ route('leis.index') }}" class="nav-link">
                                <i class="fas fa-arrow-left"></i>
                                Voltar ao Acervo
                            </a>
                            @if($leiAnterior)
                                <a href="{{ route('leis.show', $leiAnterior->slug) }}" class="nav-link">
                                    <i class="fas fa-chevron-left"></i>
                                    Lei Anterior
                                    <small>{{ $leiAnterior->numero_formatado }}</small>
                                </a>
                            @endif
                            @if($leiPosterior)
                                <a href="{{ route('leis.show', $leiPosterior->slug) }}" class="nav-link">
                                    <i class="fas fa-chevron-right"></i>
                                    Próxima Lei
                                    <small>{{ $leiPosterior->numero_formatado }}</small>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Leis Relacionadas -->
                    @if($leisRelacionadas->count() > 0)
                        <div class="sidebar-card relacionadas-card">
                            <h4>
                                <i class="fas fa-link"></i>
                                Leis Relacionadas
                            </h4>
                            <div class="leis-relacionadas">
                                @foreach($leisRelacionadas as $relacionada)
                                    <div class="lei-relacionada">
                                        <a href="{{ route('leis.show', $relacionada->slug) }}">
                                            <div class="relacionada-tipo">
                                                <span class="badge badge-tipo badge-{{ Str::slug($relacionada->tipo) }}">
                                                    {{ $relacionada->tipo }}
                                                </span>
                                            </div>
                                            <div class="relacionada-titulo">
                                                {{ $relacionada->numero_formatado }}
                                            </div>
                                            <div class="relacionada-descricao">
                                                {{ Str::limit($relacionada->titulo, 80) }}
                                            </div>
                                            <div class="relacionada-data">
                                                {{ $relacionada->data->format('d/m/Y') }}
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Busca Rápida -->
                    <div class="sidebar-card busca-card">
                        <h4>
                            <i class="fas fa-search"></i>
                            Busca Rápida
                        </h4>
                        <form action="{{ route('leis.index') }}" method="GET">
                            <div class="mb-3">
                                <input type="text" 
                                       class="form-control" 
                                       name="busca" 
                                       placeholder="Buscar outras leis..."
                                       value="{{ request('busca') }}">
                            </div>
                            <div class="mb-3">
                                <select class="form-select" name="tipo">
                                    <option value="">Todos os tipos</option>
                                    @foreach(\App\Models\Lei::getTipos() as $tipo)
                                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i>
                                Buscar
                            </button>
                        </form>
                    </div>

                    <!-- Estatísticas -->
                    <div class="sidebar-card estatisticas-card">
                        <h4>
                            <i class="fas fa-chart-bar"></i>
                            Estatísticas
                        </h4>
                        <div class="estatisticas">
                            <div class="estatistica-item">
                                <div class="estatistica-numero">{{ $totalLeis }}</div>
                                <div class="estatistica-label">Total de Leis</div>
                            </div>
                            <div class="estatistica-item">
                                <div class="estatistica-numero">{{ $totalTipoAtual }}</div>
                                <div class="estatistica-label">{{ $lei->tipo }}s</div>
                            </div>
                            <div class="estatistica-item">
                                <div class="estatistica-numero">{{ $totalExercicioAtual }}</div>
                                <div class="estatistica-label">Em {{ $lei->exercicio }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Compartilhamento -->
<div class="modal fade" id="compartilharModal" tabindex="-1" aria-labelledby="compartilharModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="compartilharModalLabel">
                    <i class="fas fa-share-alt"></i>
                    Compartilhar Lei
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="urlCompartilhamento" class="form-label">URL da Lei:</label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               id="urlCompartilhamento" 
                               value="{{ $lei->url }}" 
                               readonly>
                        <button class="btn btn-outline-secondary" 
                                type="button" 
                                onclick="copiarUrl()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                <div class="compartilhamento-social">
                    <h6>Compartilhar em:</h6>
                    <div class="social-buttons">
                        <a href="#" class="btn btn-outline-primary" onclick="compartilharWhatsApp()">
                            <i class="fab fa-whatsapp"></i>
                            WhatsApp
                        </a>
                        <a href="#" class="btn btn-outline-info" onclick="compartilharTwitter()">
                            <i class="fab fa-twitter"></i>
                            Twitter
                        </a>
                        <a href="#" class="btn btn-outline-primary" onclick="compartilharFacebook()">
                            <i class="fab fa-facebook"></i>
                            Facebook
                        </a>
                        <a href="#" class="btn btn-outline-success" onclick="compartilharEmail()">
                            <i class="fas fa-envelope"></i>
                            E-mail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leis.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/leis.js') }}"></script>
<script>
    // Dados da lei para JavaScript
    window.leiData = {
        id: {{ $lei->id }},
        titulo: @json($lei->titulo),
        numero: @json($lei->numero_formatado),
        url: @json($lei->url),
        tipo: @json($lei->tipo)
    };
</script>
@endpush