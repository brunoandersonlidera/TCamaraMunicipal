@extends('layouts.admin')

@section('page-title', 'Gerenciar Notícias')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Notícias</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gerenciar Notícias</h1>
    <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova Notícia
    </a>
</div>

<!-- Filtros -->
<div class="admin-card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-filter"></i> Filtros
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.noticias.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Título, resumo ou conteúdo...">
                </div>
                
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="publicado" {{ request('status') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                        <option value="rascunho" {{ request('status') === 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria" name="categoria">
                        <option value="">Todas</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria }}" {{ request('categoria') === $categoria ? 'selected' : '' }}>
                                {{ $categoria }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="autor" class="form-label">Autor</label>
                    <select class="form-select" id="autor" name="autor">
                        <option value="">Todos</option>
                        @foreach($autores as $autor)
                            <option value="{{ $autor->id }}" {{ request('autor') == $autor->id ? 'selected' : '' }}>
                                {{ $autor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-1">
                    <label for="data_inicio" class="form-label">De</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                           value="{{ request('data_inicio') }}">
                </div>
                
                <div class="col-md-1">
                    <label for="data_fim" class="form-label">Até</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                           value="{{ request('data_fim') }}">
                </div>
                
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.noticias.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista de Notícias -->
<div class="admin-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-newspaper"></i> Notícias 
            <span class="badge bg-secondary">{{ $noticias->total() }}</span>
        </h5>
    </div>
    
    <div class="card-body p-0">
        @if($noticias->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Imagem</th>
                            <th>Título</th>
                            <th width="120">Categoria</th>
                            <th width="120">Autor</th>
                            <th width="120">Data Publicação</th>
                            <th width="100">Status</th>
                            <th width="80">Destaque</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($noticias as $noticia)
                        <tr>
                            <td>
                                @if($noticia->imagem_destaque)
                                    <img src="{{ asset('storage/' . $noticia->imagem_destaque) }}" 
                                         alt="Imagem da notícia" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 40px; border-radius: 4px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong>{{ Str::limit($noticia->titulo, 50) }}</strong>
                                    @if($noticia->resumo)
                                        <br><small class="text-muted">{{ Str::limit($noticia->resumo, 80) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($noticia->categoria)
                                    <span class="badge bg-info">{{ $noticia->categoria }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $noticia->autor->name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <small>{{ $noticia->data_publicacao->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                @if($noticia->publicado)
                                    <span class="badge bg-success">Publicado</span>
                                @else
                                    <span class="badge bg-warning">Rascunho</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($noticia->destaque)
                                    <i class="fas fa-star text-warning" title="Em destaque"></i>
                                @else
                                    <i class="far fa-star text-muted" title="Sem destaque"></i>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.noticias.show', $noticia) }}" 
                                       class="btn btn-outline-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.noticias.edit', $noticia) }}" 
                                       class="btn btn-outline-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Toggle Publicação -->
                                    <form method="POST" action="{{ route('admin.noticias.toggle-publicacao', $noticia) }}" 
                                          style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $noticia->publicado ? 'warning' : 'success' }}" 
                                                title="{{ $noticia->publicado ? 'Despublicar' : 'Publicar' }}">
                                            <i class="fas fa-{{ $noticia->publicado ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Toggle Destaque -->
                                    <form method="POST" action="{{ route('admin.noticias.toggle-destaque', $noticia) }}" 
                                          style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $noticia->destaque ? 'secondary' : 'warning' }}" 
                                                title="{{ $noticia->destaque ? 'Remover destaque' : 'Destacar' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Excluir -->
                                    <form method="POST" action="{{ route('admin.noticias.destroy', $noticia) }}" 
                                          style="display: inline;" 
                                          data-confirm="Tem certeza que deseja excluir esta notícia?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            @if($noticias->hasPages())
                <div class="card-footer">
                    {{ $noticias->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhuma notícia encontrada</h5>
                @if(request()->hasAny(['search', 'status', 'categoria', 'autor', 'data_inicio', 'data_fim']))
                    <p class="text-muted">Tente ajustar os filtros ou <a href="{{ route('admin.noticias.index') }}">limpar a busca</a>.</p>
                @else
                    <p class="text-muted">Comece criando sua primeira notícia.</p>
                    <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Criar Primeira Notícia
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.4rem;
    font-size: 0.75rem;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
}

.badge {
    font-size: 0.7em;
}
</style>
@endpush