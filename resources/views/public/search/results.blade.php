@extends('layouts.app')

@section('title', 'Resultados da Busca')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Cabeçalho da Busca -->
            <div class="search-header mb-4">
                <h1 class="h3 mb-3">
                    <i class="fas fa-search text-primary me-2"></i>
                    Resultados da Busca
                </h1>
                
                @if(!empty($query))
                    <div class="search-info">
                        <p class="mb-2">
                            <strong>{{ $total }}</strong> resultado(s) encontrado(s) para: 
                            <span class="text-primary fw-bold">"{{ $query }}"</span>
                        </p>
                        
                        @if($category !== 'all')
                            <p class="text-muted small mb-0">
                                Filtrado por categoria: <span class="badge bg-secondary">{{ ucfirst($category) }}</span>
                            </p>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Digite um termo para realizar a busca.
                    </div>
                @endif
            </div>

            <!-- Filtros de Categoria -->
            @if(!empty($query))
            <div class="search-filters mb-4">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label class="form-label mb-0 fw-bold">Filtrar por categoria:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="btn-group flex-wrap" role="group">
                                    <a href="{{ route('search', ['q' => $query, 'category' => 'all']) }}" 
                                       class="btn btn-sm {{ $category === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Todos
                                    </a>
                                    <a href="{{ route('search', ['q' => $query, 'category' => 'noticias']) }}" 
                                       class="btn btn-sm {{ $category === 'noticias' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Notícias
                                    </a>
                                    <a href="{{ route('search', ['q' => $query, 'category' => 'vereadores']) }}" 
                                       class="btn btn-sm {{ $category === 'vereadores' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Vereadores
                                    </a>
                                    <a href="{{ route('search', ['q' => $query, 'category' => 'projetos']) }}" 
                                       class="btn btn-sm {{ $category === 'projetos' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Projetos
                                    </a>
                                    <a href="{{ route('search', ['q' => $query, 'category' => 'documentos']) }}" 
                                       class="btn btn-sm {{ $category === 'documentos' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Documentos
                                    </a>
                                    <a href="{{ route('search', ['q' => $query, 'category' => 'sessoes']) }}" 
                                       class="btn btn-sm {{ $category === 'sessoes' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Sessões
                                    </a>
                                    <a href="{{ route('search', ['q' => $query, 'category' => 'transparencia']) }}" 
                                       class="btn btn-sm {{ $category === 'transparencia' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Transparência
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Resultados -->
            @if(!empty($query) && $results->count() > 0)
                <div class="search-results">
                    @foreach($results as $result)
                        <div class="result-item mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-{{ $result['type'] === 'noticia' ? 'primary' : ($result['type'] === 'vereador' ? 'success' : ($result['type'] === 'projeto' ? 'warning' : ($result['type'] === 'documento' ? 'info' : ($result['type'] === 'sessao' ? 'secondary' : 'dark')))) }} mb-2">
                                            {{ $result['category'] }}
                                        </span>
                                        @if(isset($result['date']))
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($result['date'])->format('d/m/Y') }}
                                            </small>
                                        @endif
                                    </div>
                                    
                                    <h5 class="card-title">
                                        <a href="{{ $result['url'] }}" class="text-decoration-none">
                                            {!! $result['title'] !!}
                                        </a>
                                    </h5>
                                    
                                    @if(!empty($result['content']))
                                        <p class="card-text text-muted">
                                            {!! $result['content'] !!}
                                        </p>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ $result['url'] }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>
                                            Ver detalhes
                                        </a>
                                        
                                        @if(isset($result['relevance']))
                                            <small class="text-muted">
                                                Relevância: {{ $result['relevance'] }}%
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif(!empty($query))
                <!-- Nenhum resultado encontrado -->
                <div class="no-results text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search-minus text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted mb-3">Nenhum resultado encontrado</h4>
                    <p class="text-muted mb-4">
                        Não encontramos nenhum resultado para "<strong>{{ $query }}</strong>".
                    </p>
                    
                    <div class="suggestions">
                        <h6 class="mb-3">Sugestões:</h6>
                        <ul class="list-unstyled text-muted">
                            <li><i class="fas fa-check text-success me-2"></i>Verifique a ortografia das palavras</li>
                            <li><i class="fas fa-check text-success me-2"></i>Tente usar termos mais gerais</li>
                            <li><i class="fas fa-check text-success me-2"></i>Use palavras-chave diferentes</li>
                            <li><i class="fas fa-check text-success me-2"></i>Remova filtros de categoria</li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-home me-2"></i>
                        Voltar ao início
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.search-header {
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 1rem;
}

.search-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid var(--primary-color);
}

.result-item .card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.result-item .card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.result-item .card-title a {
    color: var(--primary-color);
}

.result-item .card-title a:hover {
    color: var(--primary-dark);
}

mark {
    background-color: #fff3cd;
    padding: 0.1em 0.2em;
    border-radius: 0.2em;
}

.search-filters .btn-group {
    gap: 0.25rem;
}

.search-filters .btn-group .btn {
    border-radius: 20px;
    margin-bottom: 0.25rem;
}

.no-results {
    background: #f8f9fa;
    border-radius: 12px;
    margin: 2rem 0;
}

@media (max-width: 768px) {
    .search-filters .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .search-filters .btn-group .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Destacar termos de busca nos resultados
    const query = '{{ $query }}';
    if (query) {
        // Já é feito no backend com highlightText()
        console.log('Busca realizada para:', query);
    }
});
</script>
@endpush
@endsection