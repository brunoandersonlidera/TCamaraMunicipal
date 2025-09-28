@extends('layouts.admin')

@section('title', 'Editar Página: ' . $pagina->titulo)

@push('styles')
<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        min-height: 300px;
    }
    .form-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .form-section h5 {
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .page-info {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 15px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Editar Página: {{ $pagina->titulo }}</h1>
                <div>
                    @if($pagina->slug)
                        <a href="{{ route('paginas.show', $pagina->slug) }}" target="_blank" class="btn btn-outline-primary me-2">
                            <i class="fas fa-external-link-alt me-2"></i>Visualizar
                        </a>
                    @endif
                    <a href="{{ route('admin.paginas-conteudo.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>

            <!-- Informações da Página -->
            <div class="page-info">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $pagina->ativo ? 'success' : 'danger' }}">
                            {{ $pagina->ativo ? 'Ativa' : 'Inativa' }}
                        </span>
                    </div>
                    <div class="col-md-3">
                        <strong>Criada em:</strong> {{ $pagina->created_at ? $pagina->created_at->format('d/m/Y H:i') : 'N/A' }}
                    </div>
                    <div class="col-md-3">
                        <strong>Atualizada em:</strong> {{ $pagina->updated_at ? $pagina->updated_at->format('d/m/Y H:i') : 'N/A' }}
                    </div>
                    <div class="col-md-3">
                        <strong>URL:</strong> <code>/{{ $pagina->slug }}</code>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.paginas-conteudo.update', $pagina) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Informações Básicas -->
                        <div class="form-section">
                            <h5><i class="fas fa-info-circle me-2"></i>Informações Básicas</h5>
                            
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título *</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" 
                                       value="{{ old('titulo', $pagina->titulo) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug (URL)</label>
                                <input type="text" class="form-control" id="slug" name="slug" 
                                       value="{{ old('slug', $pagina->slug) }}">
                                <div class="form-text">URL amigável para a página (ex: historia, estrutura)</div>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" 
                                          placeholder="Breve descrição da página">{{ old('descricao', $pagina->descricao) }}</textarea>
                            </div>
                        </div>

                        <!-- Conteúdo -->
                        <div class="form-section">
                            <h5><i class="fas fa-edit me-2"></i>Conteúdo</h5>
                            
                            <div class="mb-3">
                                <label for="conteudo" class="form-label">Conteúdo da Página *</label>
                                <div id="editor-container">
                                    <div id="editor">{!! old('conteudo', $pagina->conteudo) !!}</div>
                                </div>
                                <input type="hidden" id="conteudo" name="conteudo" value="{{ old('conteudo', $pagina->conteudo) }}">
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="form-section">
                            <h5><i class="fas fa-search me-2"></i>Otimização para Buscadores (SEO)</h5>
                            
                            <div class="mb-3">
                                <label for="seo_title" class="form-label">Título SEO</label>
                                <input type="text" class="form-control" id="seo_title" name="seo_title" 
                                       value="{{ old('seo_title', $pagina->seo['title'] ?? '') }}" maxlength="255">
                                <div class="form-text">Título que aparecerá nos resultados de busca</div>
                            </div>

                            <div class="mb-3">
                                <label for="seo_description" class="form-label">Descrição SEO</label>
                                <textarea class="form-control" id="seo_description" name="seo_description" 
                                          rows="3" maxlength="500">{{ old('seo_description', $pagina->seo['description'] ?? '') }}</textarea>
                                <div class="form-text">Descrição que aparecerá nos resultados de busca</div>
                            </div>

                            <div class="mb-3">
                                <label for="seo_keywords" class="form-label">Palavras-chave</label>
                                <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" 
                                       value="{{ old('seo_keywords', $pagina->seo['keywords'] ?? '') }}">
                                <div class="form-text">Palavras-chave separadas por vírgula</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Configurações -->
                        <div class="form-section">
                            <h5><i class="fas fa-cog me-2"></i>Configurações</h5>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" 
                                           value="1" {{ old('ativo', $pagina->ativo) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">
                                        Página Ativa
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="ordem" class="form-label">Ordem de Exibição</label>
                                <input type="number" class="form-control" id="ordem" name="ordem" 
                                       value="{{ old('ordem', $pagina->ordem) }}" min="0">
                                <div class="form-text">Ordem para organização (0 = primeiro)</div>
                            </div>

                            <div class="mb-3">
                                <label for="template" class="form-label">Template</label>
                                <select class="form-select" id="template" name="template">
                                    <option value="default" {{ old('template', $pagina->template) == 'default' ? 'selected' : '' }}>Padrão</option>
                                    <option value="full-width" {{ old('template', $pagina->template) == 'full-width' ? 'selected' : '' }}>Largura Total</option>
                                    <option value="sidebar" {{ old('template', $pagina->template) == 'sidebar' ? 'selected' : '' }}>Com Sidebar</option>
                                </select>
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="form-section">
                            <h5><i class="fas fa-save me-2"></i>Ações</h5>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Atualizar Página
                                </button>
                                <a href="{{ route('admin.paginas-conteudo.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <hr>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmarExclusao()">
                                    <i class="fas fa-trash me-2"></i>Excluir Página
                                </button>
                            </div>
                        </div>

                        <!-- Estatísticas -->
                        <div class="form-section">
                            <h5><i class="fas fa-chart-bar me-2"></i>Estatísticas</h5>
                            
                            <div class="mb-2">
                                <small class="text-muted">Caracteres no conteúdo:</small>
                                <span id="char-count" class="badge bg-info">{{ strlen(strip_tags($pagina->conteudo)) }}</span>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted">Palavras no conteúdo:</small>
                                <span id="word-count" class="badge bg-info">{{ str_word_count(strip_tags($pagina->conteudo)) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

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
<!-- Quill Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configurar Quill Editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['blockquote', 'code-block'],
                ['clean']
            ]
        }
    });

    // Sincronizar conteúdo do editor com o campo hidden
    quill.on('text-change', function() {
        var conteudo = quill.root.innerHTML;
        document.getElementById('conteudo').value = conteudo;
        
        // Atualizar estatísticas
        var texto = quill.getText();
        document.getElementById('char-count').textContent = texto.length;
        document.getElementById('word-count').textContent = texto.trim().split(/\s+/).length;
    });

    // Gerar slug automaticamente baseado no título (apenas se slug estiver vazio)
    document.getElementById('titulo').addEventListener('input', function() {
        var titulo = this.value;
        var slugField = document.getElementById('slug');
        
        if (slugField.value === '' || slugField.dataset.autoGenerated === 'true') {
            var slug = titulo.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove caracteres especiais
                .replace(/\s+/g, '-') // Substitui espaços por hífens
                .replace(/-+/g, '-') // Remove hífens duplicados
                .trim();
            
            slugField.value = slug;
            slugField.dataset.autoGenerated = 'true';
        }
    });

    // Marcar slug como editado manualmente
    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });

    // Validação do formulário
    document.querySelector('form').addEventListener('submit', function(e) {
        var conteudo = quill.root.innerHTML.trim();
        if (conteudo === '<p><br></p>' || conteudo === '') {
            e.preventDefault();
            alert('Por favor, adicione conteúdo à página.');
            return false;
        }
        document.getElementById('conteudo').value = conteudo;
    });
});

function confirmarExclusao() {
    if (confirm('Tem certeza que deseja excluir esta página? Esta ação não pode ser desfeita.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush