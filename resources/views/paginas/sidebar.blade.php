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
        padding: 3rem 0;
        margin-bottom: 3rem;
        border-radius: 0 0 50px 50px;
    }
    
    .content-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .sidebar-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .sidebar-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border: none;
        font-weight: 600;
    }
    
    .sidebar-card .card-body {
        padding: 1.5rem;
    }
    
    .sidebar-nav .nav-link {
        color: #495057;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .sidebar-nav .nav-link:hover,
    .sidebar-nav .nav-link.active {
        background: #007bff;
        color: white;
        transform: translateX(5px);
    }
    
    .last-updated {
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 1rem 2rem;
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .quick-links {
        list-style: none;
        padding: 0;
    }
    
    .quick-links li {
        margin-bottom: 0.5rem;
    }
    
    .quick-links a {
        color: #495057;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 0.5rem;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .quick-links a:hover {
        background: #f8f9fa;
        color: #007bff;
        transform: translateX(3px);
    }
    
    .quick-links i {
        width: 20px;
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Breadcrumb -->
                    @if(isset($breadcrumb) && count($breadcrumb) > 0)
                    <nav aria-label="breadcrumb" class="mb-4">
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
                        <h1 class="display-4 mb-3 fw-bold">
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

    <!-- Conteúdo Principal com Sidebar -->
    <div class="container py-5">
        <div class="row">
            <!-- Conteúdo Principal -->
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="p-4 p-md-5">
                        <div class="page-content">
                            {!! $pagina->conteudo !!}
                        </div>
                    </div>
                    
                    <!-- Informações de Atualização -->
                    <div class="last-updated">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <i class="fas fa-clock me-2"></i>
                                Última atualização: {{ $pagina->updated_at->format('d/m/Y \à\s H:i') }}
                            </div>
                            <div class="col-md-6 text-md-end">
                                
                            </div>
                        </div>
                    </div>
                    <x-page-share :titulo="$pagina->titulo" />
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Navegação das Páginas -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-list me-2"></i>
                        Páginas Institucionais
                    </div>
                    <div class="card-body">
                        <nav class="sidebar-nav">
                            @php
                                $paginasInstitucionais = \App\Models\PaginaConteudo::ativo()->ordenado()->get();
                            @endphp
                            @foreach($paginasInstitucionais as $pag)
                                @if($pag->slug)
                                    <a href="{{ route('paginas.show', $pag->slug) }}" 
                                       class="nav-link {{ $pag->slug === $pagina->slug ? 'active' : '' }}">
                                        <i class="fas fa-chevron-right me-2"></i>
                                        {{ $pag->titulo }}
                                    </a>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                </div>

                <!-- Links Rápidos -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Links Rápidos
                    </div>
                    <div class="card-body">
                        <ul class="quick-links">
                            <li>
                                <a href="{{ route('vereadores.index') }}">
                                    <i class="fas fa-users"></i>
                                    Vereadores
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('sessoes.index') }}">
                                    <i class="fas fa-gavel"></i>
                                    Sessões Plenárias
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('projetos-lei.index') }}">
                                    <i class="fas fa-file-alt"></i>
                                    Projetos de Lei
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transparencia.index') }}">
                                    <i class="fas fa-eye"></i>
                                    Transparência
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('esic.index') }}">
                                    <i class="fas fa-info-circle"></i>
                                    e-SIC
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('paginas.contato') }}">
                                    <i class="fas fa-envelope"></i>
                                    Contato
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Informações de Contato -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-phone me-2"></i>
                        Contato
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Telefone:</strong><br>
                            <span class="text-muted">(XX) XXXX-XXXX</span>
                        </div>
                        <div class="mb-3">
                            <strong>E-mail:</strong><br>
                            <span class="text-muted">contato@camara.gov.br</span>
                        </div>
                        <div class="mb-0">
                            <strong>Horário de Atendimento:</strong><br>
                            <span class="text-muted">Segunda a Sexta<br>8h às 17h</span>
                        </div>
                    </div>
                </div>
            </div>
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