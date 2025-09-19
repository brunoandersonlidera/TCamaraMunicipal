@extends('layouts.admin')

@section('page-title', 'Novo Documento')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.documentos.index') }}">Documentos</a></li>
        <li class="breadcrumb-item active">Novo Documento</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Novo Documento</h1>
            <p class="text-muted mb-0">Adicione um novo documento à biblioteca da Câmara Municipal</p>
        </div>
        <a href="{{ route('admin.documentos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <form action="{{ route('admin.documentos.store') }}" method="POST" enctype="multipart/form-data" id="documentoForm">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Dados Básicos -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Dados Básicos</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                           id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                           id="numero" name="numero" value="{{ old('numero') }}" 
                                           placeholder="Ex: 001/2024">
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-select @error('categoria') is-invalid @enderror" 
                                            id="categoria" name="categoria" required>
                                        <option value="">Selecione uma categoria</option>
                                        @foreach($categorias as $value => $label)
                                            <option value="{{ $value }}" {{ old('categoria') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_documento" class="form-label">Data do Documento <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('data_documento') is-invalid @enderror" 
                                           id="data_documento" name="data_documento" value="{{ old('data_documento', date('Y-m-d')) }}" required>
                                    @error('data_documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-0">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                              id="descricao" name="descricao" rows="4" 
                                              placeholder="Descreva brevemente o conteúdo do documento...">{{ old('descricao') }}</textarea>
                                    @error('descricao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload de Arquivo -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Arquivo do Documento</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="arquivo" class="form-label">Arquivo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('arquivo') is-invalid @enderror" 
                                   id="arquivo" name="arquivo" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" required>
                            <div class="form-text">
                                Formatos aceitos: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Tamanho máximo: 10MB.
                            </div>
                            @error('arquivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview do arquivo -->
                        <div id="arquivoPreview" class="d-none">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file fa-2x me-3"></i>
                                    <div>
                                        <div class="fw-bold" id="arquivoNome"></div>
                                        <small class="text-muted" id="arquivoInfo"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observações Internas -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações Internas</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Observações internas:</strong> Estas informações não aparecem no site público.
                        </div>
                        <div class="mb-0">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" name="observacoes" rows="4" 
                                      placeholder="Observações internas sobre o documento...">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Configurações -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Configurações</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" 
                                       {{ old('ativo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    <strong>Documento Ativo</strong>
                                </label>
                            </div>
                            <small class="text-muted">Documentos ativos aparecem no site público</small>
                        </div>

                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="destaque" name="destaque" value="1" 
                                       {{ old('destaque') ? 'checked' : '' }}>
                                <label class="form-check-label" for="destaque">
                                    <strong>Documento em Destaque</strong>
                                </label>
                            </div>
                            <small class="text-muted">Documentos em destaque aparecem em posição de maior visibilidade</small>
                        </div>
                    </div>
                </div>

                <!-- Informações de Categoria -->
                <div class="admin-card mb-4" id="categoriaInfo" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info me-2"></i>Sobre a Categoria</h5>
                    </div>
                    <div class="card-body">
                        <div id="categoriaDescricao"></div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-save me-2"></i>Ações</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Documento
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="limparFormulario()">
                                <i class="fas fa-eraser me-2"></i>Limpar Formulário
                            </button>
                            <a href="{{ route('admin.documentos.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.admin-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}

#arquivoPreview .alert {
    background-color: #e3f2fd;
    color: #1565c0;
    border-left: 4px solid #2196f3;
}
</style>
@endpush

@push('scripts')
<script>
// Informações sobre categorias
const categoriasInfo = {
    'ata': 'Atas são documentos que registram as discussões e decisões tomadas em sessões da Câmara Municipal.',
    'decreto': 'Decretos são atos administrativos expedidos pelo Poder Executivo para regulamentar leis.',
    'edital': 'Editais são documentos que tornam públicos concursos, licitações e outros procedimentos.',
    'lei': 'Leis são normas jurídicas de caráter geral e obrigatório, aprovadas pela Câmara Municipal.',
    'portaria': 'Portarias são atos administrativos internos que disciplinam o funcionamento dos órgãos.',
    'regimento': 'Regimentos estabelecem as normas de funcionamento interno da Câmara Municipal.',
    'resolucao': 'Resoluções são atos normativos que disciplinam matérias de competência interna.',
    'contrato': 'Contratos são instrumentos jurídicos que estabelecem obrigações entre partes.',
    'convenio': 'Convênios são acordos de cooperação entre entidades públicas ou privadas.',
    'licitacao': 'Documentos relacionados a processos licitatórios para contratação de bens e serviços.',
    'balanco': 'Balanços apresentam a situação financeira e patrimonial da Câmara Municipal.',
    'relatorio': 'Relatórios apresentam informações sobre atividades e resultados da administração.',
    'outros': 'Outros documentos que não se enquadram nas categorias específicas.'
};

// Preview do arquivo
document.getElementById('arquivo').addEventListener('change', function(e) {
    const arquivo = e.target.files[0];
    const preview = document.getElementById('arquivoPreview');
    const nome = document.getElementById('arquivoNome');
    const info = document.getElementById('arquivoInfo');

    if (arquivo) {
        nome.textContent = arquivo.name;
        info.textContent = `${(arquivo.size / 1024 / 1024).toFixed(2)} MB - ${arquivo.type}`;
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
    }
});

// Informações da categoria
document.getElementById('categoria').addEventListener('change', function(e) {
    const categoria = e.target.value;
    const categoriaInfo = document.getElementById('categoriaInfo');
    const categoriaDescricao = document.getElementById('categoriaDescricao');

    if (categoria && categoriasInfo[categoria]) {
        categoriaDescricao.innerHTML = `<p class="mb-0">${categoriasInfo[categoria]}</p>`;
        categoriaInfo.style.display = 'block';
    } else {
        categoriaInfo.style.display = 'none';
    }
});

// Limpar formulário
function limparFormulario() {
    if (confirm('Tem certeza que deseja limpar todos os campos do formulário?')) {
        document.getElementById('documentoForm').reset();
        document.getElementById('arquivoPreview').classList.add('d-none');
        document.getElementById('categoriaInfo').style.display = 'none';
    }
}

// Validação do formulário
document.getElementById('documentoForm').addEventListener('submit', function(e) {
    const arquivo = document.getElementById('arquivo').files[0];
    
    if (arquivo && arquivo.size > 10 * 1024 * 1024) { // 10MB
        e.preventDefault();
        alert('O arquivo é muito grande. O tamanho máximo permitido é 10MB.');
        return false;
    }
});

// Auto-gerar número baseado na categoria e ano
document.getElementById('categoria').addEventListener('change', function(e) {
    const categoria = e.target.value;
    const numeroField = document.getElementById('numero');
    
    if (categoria && !numeroField.value) {
        const ano = new Date().getFullYear();
        // Sugestão de numeração baseada na categoria
        const prefixos = {
            'ata': 'ATA',
            'decreto': 'DEC',
            'edital': 'EDT',
            'lei': 'LEI',
            'portaria': 'PRT',
            'regimento': 'REG',
            'resolucao': 'RES',
            'contrato': 'CTR',
            'convenio': 'CNV',
            'licitacao': 'LIC',
            'balanco': 'BAL',
            'relatorio': 'REL',
            'outros': 'DOC'
        };
        
        if (prefixos[categoria]) {
            numeroField.placeholder = `Ex: ${prefixos[categoria]}-001/${ano}`;
        }
    }
});
</script>
@endpush