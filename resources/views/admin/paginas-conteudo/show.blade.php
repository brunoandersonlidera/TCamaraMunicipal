@extends('layouts.admin')

@section('title', 'Visualizar: ' . $pagina->titulo)

@push('styles')
<style>
    .page-content {
        background: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 30px;
    }
    .info-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .info-card h6 {
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
    .badge-status {
        font-size: 0.9em;
    }
    .content-preview {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 15px;
        background: #fff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header da Página -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="h2 mb-2">{{ $pagina->titulo }}</h1>
                        <p class="mb-0 opacity-75">{{ $pagina->descricao ?: 'Sem descrição' }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge badge-status bg-{{ $pagina->ativo ? 'success' : 'danger' }} mb-2">
                            {{ $pagina->ativo ? 'Ativa' : 'Inativa' }}
                        </span>
                        <br>
                        <small class="opacity-75">Atualizada em {{ $pagina->updated_at ? $pagina->updated_at->format('d/m/Y H:i') : 'N/A' }}</small>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('admin.paginas-conteudo.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
                    </a>
                </div>
                <div>
                    @if($pagina->slug)
                        <a href="{{ route('paginas.show', $pagina->slug) }}" target="_blank" class="btn btn-outline-primary me-2">
                            <i class="fas fa-external-link-alt me-2"></i>Ver no Site
                        </a>
                    @endif
                    <a href="{{ route('admin.paginas-conteudo.edit', $pagina) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Conteúdo da Página -->
                    <div class="info-card">
                        <h6><i class="fas fa-file-alt me-2"></i>Conteúdo da Página</h6>
                        <div class="content-preview">
                            {!! $pagina->conteudo !!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Informações Gerais -->
                    <div class="info-card">
                        <h6><i class="fas fa-info-circle me-2"></i>Informações Gerais</h6>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Slug:</strong></div>
                            <div class="col-sm-8"><code>{{ $pagina->slug }}</code></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Status:</strong></div>
                            <div class="col-sm-8">
                                <span class="badge bg-{{ $pagina->ativo ? 'success' : 'danger' }}">
                                    {{ $pagina->ativo ? 'Ativa' : 'Inativa' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Ordem:</strong></div>
                            <div class="col-sm-8">{{ $pagina->ordem }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Template:</strong></div>
                            <div class="col-sm-8">
                                <span class="badge bg-info">{{ ucfirst($pagina->template) }}</span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Criada:</strong></div>
                            <div class="col-sm-8">{{ $pagina->created_at ? $pagina->created_at->format('d/m/Y H:i') : 'N/A' }}</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4"><strong>Atualizada:</strong></div>
                            <div class="col-sm-8">{{ $pagina->updated_at ? $pagina->updated_at->format('d/m/Y H:i') : 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- SEO -->
                    @if($pagina->seo && (isset($pagina->seo['title']) || isset($pagina->seo['description']) || isset($pagina->seo['keywords'])))
                    <div class="info-card">
                        <h6><i class="fas fa-search me-2"></i>Informações SEO</h6>
                        
                        @if(isset($pagina->seo['title']) && $pagina->seo['title'])
                        <div class="mb-3">
                            <strong>Título SEO:</strong>
                            <p class="mb-0 text-muted">{{ $pagina->seo['title'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($pagina->seo['description']) && $pagina->seo['description'])
                        <div class="mb-3">
                            <strong>Descrição SEO:</strong>
                            <p class="mb-0 text-muted">{{ $pagina->seo['description'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($pagina->seo['keywords']) && $pagina->seo['keywords'])
                        <div class="mb-0">
                            <strong>Palavras-chave:</strong>
                            <p class="mb-0 text-muted">{{ $pagina->seo['keywords'] }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Estatísticas -->
                    <div class="info-card">
                        <h6><i class="fas fa-chart-bar me-2"></i>Estatísticas</h6>
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1">{{ strlen(strip_tags($pagina->conteudo)) }}</h4>
                                    <small class="text-muted">Caracteres</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-1">{{ str_word_count(strip_tags($pagina->conteudo)) }}</h4>
                                <small class="text-muted">Palavras</small>
                            </div>
                        </div>
                    </div>

                    <!-- Configurações -->
                    @if($pagina->configuracoes && count($pagina->configuracoes) > 0)
                    <div class="info-card">
                        <h6><i class="fas fa-cog me-2"></i>Configurações Extras</h6>
                        
                        @foreach($pagina->configuracoes as $chave => $valor)
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>{{ ucfirst($chave) }}:</strong></div>
                            <div class="col-sm-7">
                                @if(is_bool($valor))
                                    <span class="badge bg-{{ $valor ? 'success' : 'danger' }}">
                                        {{ $valor ? 'Sim' : 'Não' }}
                                    </span>
                                @else
                                    {{ $valor }}
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Ações Rápidas -->
                    <div class="info-card">
                        <h6><i class="fas fa-bolt me-2"></i>Ações Rápidas</h6>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.paginas-conteudo.edit', $pagina) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-2"></i>Editar Página
                            </a>
                            
                            <form action="{{ route('admin.paginas-conteudo.toggle-status', $pagina) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-{{ $pagina->ativo ? 'warning' : 'success' }} btn-sm w-100">
                                    <i class="fas fa-{{ $pagina->ativo ? 'eye-slash' : 'eye' }} me-2"></i>
                                    {{ $pagina->ativo ? 'Desativar' : 'Ativar' }}
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmarExclusao()">
                                <i class="fas fa-trash me-2"></i>Excluir
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form para exclusão -->
            <form id="delete-form" action="{{ route('admin.paginas-conteudo.destroy', $pagina) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmarExclusao() {
    if (confirm('Tem certeza que deseja excluir esta página? Esta ação não pode ser desfeita.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush