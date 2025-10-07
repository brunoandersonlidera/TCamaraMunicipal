@extends('layouts.app')

@section('title', $pageTitle ?? $pagina->titulo)

@if(isset($metaDescription))
@section('meta-description', $metaDescription)
@endif

@if(isset($metaKeywords))
@section('meta-keywords', $metaKeywords)
@endif

@push('styles')
<style>
    .page-content {
        line-height: 1.8;
    }
    .page-content h1, .page-content h2, .page-content h3, 
    .page-content h4, .page-content h5, .page-content h6 {
        color: #2c3e50;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .page-content h1 { font-size: 2.5rem; }
    .page-content h2 { font-size: 2rem; }
    .page-content h3 { font-size: 1.75rem; }
    .page-content h4 { font-size: 1.5rem; }
    .page-content h5 { font-size: 1.25rem; }
    .page-content h6 { font-size: 1.1rem; }
    
    .page-content p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }
    
    .page-content ul, .page-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    
    .page-content li {
        margin-bottom: 0.5rem;
    }
    
    .page-content blockquote {
        border-left: 4px solid #007bff;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #6c757d;
    }
    
    .page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin: 1.5rem 0;
    }
    
    .page-content table {
        width: 100%;
        margin: 1.5rem 0;
        border-collapse: collapse;
    }
    
    .page-content table th,
    .page-content table td {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        text-align: left;
    }
    
    .page-content table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .content-section {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .last-updated {
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 1rem;
        font-size: 0.9rem;
        color: #6c757d;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Breadcrumb -->
                    @if(isset($breadcrumb) && count($breadcrumb) > 0)
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb bg-transparent p-0 mb-0">
                            @foreach($breadcrumb as $item)
                                @if($loop->last)
                                    <li class="breadcrumb-item active text-white" aria-current="page">
                                        {{ $item['title'] }}
                                    </li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $item['url'] }}" class="text-white-50 text-decoration-none">
                                            {{ $item['title'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                    @endif
                    
                    <div class="text-center">
                        <h1 class="display-5 mb-2 fw-bold">
                            {{ $pagina->titulo }}
                        </h1>
                        @if($pagina->descricao)
                        <p class="lead mb-0 opacity-75">
                            {{ $pagina->descricao }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal - Largura Total -->
    <div class="container-fluid py-4">
        <div class="content-section">
            <div class="p-3 p-md-4">
                <div class="page-content">
                    {!! $pagina->conteudo !!}
                </div>
            </div>
            
            <!-- Informações de Atualização -->
            <div class="last-updated">
                <i class="fas fa-clock me-2"></i>
                Última atualização: {{ $pagina->updated_at->format('d/m/Y \à\s H:i') }}
            </div>
            <x-page-share :titulo="$pagina->titulo" />
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar classes Bootstrap às tabelas do conteúdo
    const tables = document.querySelectorAll('.page-content table');
    tables.forEach(table => {
        table.classList.add('table', 'table-striped', 'table-hover');
        
        // Envolver tabela em div responsiva
        const wrapper = document.createElement('div');
        wrapper.classList.add('table-responsive');
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });
    
    // Adicionar classes aos links
    const links = document.querySelectorAll('.page-content a');
    links.forEach(link => {
        if (!link.classList.contains('btn')) {
            link.classList.add('text-decoration-none');
        }
    });
    
    // Lazy loading para imagens
    const images = document.querySelectorAll('.page-content img');
    images.forEach(img => {
        img.setAttribute('loading', 'lazy');
        img.classList.add('img-fluid');
    });
});
</script>
@endpush