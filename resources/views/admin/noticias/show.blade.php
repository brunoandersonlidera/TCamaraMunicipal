@extends('layouts.admin')

@section('page-title', 'Visualizar Notícia')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.noticias.index') }}">Notícias</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($noticia->titulo, 30) }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Visualizar Notícia</h1>
    <div>
        <a href="{{ route('admin.noticias.edit', $noticia) }}" class="btn btn-primary me-2">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('admin.noticias.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <!-- Coluna Principal -->
    <div class="col-lg-8">
        <!-- Conteúdo da Notícia -->
        <div class="admin-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-newspaper"></i> Conteúdo
                </h5>
                <div>
                    @if($noticia->publicado)
                        <span class="badge bg-success">Publicado</span>
                    @else
                        <span class="badge bg-warning">Rascunho</span>
                    @endif
                    
                    @if($noticia->destaque)
                        <span class="badge bg-warning ms-1">
                            <i class="fas fa-star"></i> Destaque
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <h1 class="h2 mb-3">{{ $noticia->titulo }}</h1>
                
                @if($noticia->resumo)
                    <div class="lead mb-4 text-muted">
                        {{ $noticia->resumo }}
                    </div>
                @endif
                
                @if($noticia->imagem_destaque)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $noticia->imagem_destaque) }}" 
                             alt="{{ $noticia->titulo }}" 
                             class="img-fluid rounded shadow-sm">
                    </div>
                @endif
                
                <div class="content-body">
                    {!! nl2br(e($noticia->conteudo)) !!}
                </div>
                
                @if($noticia->galeria_imagens && count($noticia->galeria_imagens) > 0)
                    <div class="mt-4">
                        <h5>Galeria de Imagens</h5>
                        <div class="row">
                            @foreach($noticia->galeria_imagens as $imagem)
                                <div class="col-md-4 mb-3">
                                    <img src="{{ asset('storage/' . $imagem) }}" 
                                         alt="Galeria" 
                                         class="img-fluid rounded shadow-sm">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- SEO -->
        @if($noticia->meta_description || $noticia->meta_keywords)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-search"></i> Informações SEO
                    </h5>
                </div>
                <div class="card-body">
                    @if($noticia->meta_description)
                        <div class="mb-3">
                            <strong>Meta Description:</strong>
                            <p class="text-muted mb-0">{{ $noticia->meta_description }}</p>
                        </div>
                    @endif
                    
                    @if($noticia->meta_keywords)
                        <div class="mb-0">
                            <strong>Meta Keywords:</strong>
                            <p class="text-muted mb-0">{{ $noticia->meta_keywords }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Informações da Publicação -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Informações
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Status:</strong></div>
                    <div class="col-sm-8">
                        @if($noticia->publicado)
                            <span class="badge bg-success">Publicado</span>
                        @else
                            <span class="badge bg-warning">Rascunho</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Destaque:</strong></div>
                    <div class="col-sm-8">
                        @if($noticia->destaque)
                            <span class="badge bg-warning">
                                <i class="fas fa-star"></i> Sim
                            </span>
                        @else
                            <span class="text-muted">Não</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Comentários:</strong></div>
                    <div class="col-sm-8">
                        @if($noticia->permite_comentarios)
                            <span class="text-success">Permitidos</span>
                        @else
                            <span class="text-muted">Desabilitados</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Autor:</strong></div>
                    <div class="col-sm-8">{{ $noticia->autor->name ?? 'N/A' }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Publicação:</strong></div>
                    <div class="col-sm-8">{{ $noticia->data_publicacao->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Criado em:</strong></div>
                    <div class="col-sm-8">{{ $noticia->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Atualizado:</strong></div>
                    <div class="col-sm-8">{{ $noticia->updated_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="row">
                    <div class="col-sm-4"><strong>Slug:</strong></div>
                    <div class="col-sm-8">
                        <code>{{ $noticia->slug }}</code>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Categorização -->
        @if($noticia->categoria || ($noticia->tags && count($noticia->tags) > 0))
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tags"></i> Categorização
                    </h5>
                </div>
                <div class="card-body">
                    @if($noticia->categoria)
                        <div class="mb-3">
                            <strong>Categoria:</strong>
                            <br><span class="badge bg-info">{{ $noticia->categoria }}</span>
                        </div>
                    @endif
                    
                    @if($noticia->tags && count($noticia->tags) > 0)
                        <div class="mb-0">
                            <strong>Tags:</strong>
                            <br>
                            @foreach($noticia->tags as $tag)
                                <span class="badge bg-secondary me-1 mb-1">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Ações Rápidas -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs"></i> Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.noticias.edit', $noticia) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar Notícia
                    </a>
                    
                    <!-- Toggle Publicação -->
                    <form method="POST" action="{{ route('admin.noticias.toggle-publicacao', $noticia) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-{{ $noticia->publicado ? 'warning' : 'success' }} w-100">
                            <i class="fas fa-{{ $noticia->publicado ? 'eye-slash' : 'eye' }}"></i> 
                            {{ $noticia->publicado ? 'Despublicar' : 'Publicar' }}
                        </button>
                    </form>
                    
                    <!-- Toggle Destaque -->
                    <form method="POST" action="{{ route('admin.noticias.toggle-destaque', $noticia) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-{{ $noticia->destaque ? 'secondary' : 'warning' }} w-100">
                            <i class="fas fa-star"></i> 
                            {{ $noticia->destaque ? 'Remover Destaque' : 'Destacar' }}
                        </button>
                    </form>
                    
                    <!-- Duplicar -->
                    <a href="{{ route('admin.noticias.create') }}?duplicate={{ $noticia->id }}" class="btn btn-outline-info">
                        <i class="fas fa-copy"></i> Duplicar Notícia
                    </a>
                    
                    <!-- Excluir -->
                    <form method="POST" action="{{ route('admin.noticias.destroy', $noticia) }}" 
                          onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash"></i> Excluir Notícia
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Estatísticas -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar"></i> Estatísticas
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary mb-0">0</h4>
                            <small class="text-muted">Visualizações</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-0">0</h4>
                        <small class="text-muted">Comentários</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> 
                        Tempo de leitura estimado: {{ ceil(str_word_count(strip_tags($noticia->conteudo)) / 200) }} min
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
@endpush