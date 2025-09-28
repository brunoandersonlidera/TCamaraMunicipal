@extends('layouts.admin')

@section('page-title', 'Novo Projeto de Lei')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.projetos-lei.index') }}">Projetos de Lei</a></li>
        <li class="breadcrumb-item active">Novo Projeto</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Novo Projeto de Lei</h1>
            <p class="text-muted">Cadastre um novo projeto de lei da Câmara Municipal</p>
        </div>
        <a href="{{ route('admin.projetos-lei.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <form action="{{ route('admin.projetos-lei.store') }}" method="POST" enctype="multipart/form-data" id="projetoForm">
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                           id="numero" name="numero" value="{{ old('numero', $proximoNumero) }}" required>
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Número sequencial do projeto</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ano" class="form-label">Ano <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('ano') is-invalid @enderror" 
                                           id="ano" name="ano" value="{{ old('ano', date('Y')) }}" 
                                           min="2000" max="{{ date('Y') + 1 }}" required>
                                    @error('ano')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="projeto_lei" {{ old('tipo') === 'projeto_lei' ? 'selected' : '' }}>Projeto de Lei</option>
                                        <option value="projeto_lei_complementar" {{ old('tipo') === 'projeto_lei_complementar' ? 'selected' : '' }}>Lei Complementar</option>
                                        <option value="projeto_resolucao" {{ old('tipo') === 'projeto_resolucao' ? 'selected' : '' }}>Resolução</option>
                                        <option value="projeto_decreto_legislativo" {{ old('tipo') === 'projeto_decreto_legislativo' ? 'selected' : '' }}>Decreto Legislativo</option>
                                        <option value="indicacao" {{ old('tipo') === 'indicacao' ? 'selected' : '' }}>Indicação</option>
                                        <option value="mocao" {{ old('tipo') === 'mocao' ? 'selected' : '' }}>Moção</option>
                                        <option value="requerimento" {{ old('tipo') === 'requerimento' ? 'selected' : '' }}>Requerimento</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Título resumido do projeto</div>
                        </div>

                        <div class="mb-3">
                            <label for="ementa" class="form-label">Ementa <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('ementa') is-invalid @enderror" 
                                      id="ementa" name="ementa" rows="3" required>{{ old('ementa') }}</textarea>
                            @error('ementa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Resumo do que o projeto pretende fazer</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_protocolo" class="form-label">Data de Protocolo <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('data_protocolo') is-invalid @enderror"
                                       id="data_protocolo" name="data_protocolo"
                                       value="{{ old('data_protocolo', date('Y-m-d')) }}" required>
                                @error('data_protocolo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="tramitando" {{ old('status', 'tramitando') === 'tramitando' ? 'selected' : '' }}>Tramitando</option>
                                        <option value="aprovado" {{ old('status') === 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                        <option value="rejeitado" {{ old('status') === 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                        <option value="retirado" {{ old('status') === 'retirado' ? 'selected' : '' }}>Retirado</option>
                                        <option value="arquivado" {{ old('status') === 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Autoria -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Autoria</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="tipo_autoria" class="form-label">Tipo de Autoria <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo_autoria') is-invalid @enderror" id="tipo_autoria" name="tipo_autoria" required>
                                <option value="">Selecione o tipo de autoria</option>
                                <option value="vereador" {{ old('tipo_autoria', 'vereador') == 'vereador' ? 'selected' : '' }}>Vereador</option>
                                <option value="prefeito" {{ old('tipo_autoria') == 'prefeito' ? 'selected' : '' }}>Prefeito Municipal</option>
                                <option value="comissao" {{ old('tipo_autoria') == 'comissao' ? 'selected' : '' }}>Comissão da Câmara</option>
                                <option value="iniciativa_popular" {{ old('tipo_autoria') == 'iniciativa_popular' ? 'selected' : '' }}>Iniciativa Popular</option>
                            </select>
                            @error('tipo_autoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campos específicos para Vereador -->
                        <div id="campos_vereador" class="mb-3" style="display: none;">
                            <label for="autor_id" class="form-label">Autor Principal <span class="text-danger">*</span></label>
                            <select class="form-select @error('autor_id') is-invalid @enderror" id="autor_id" name="autor_id">
                                <option value="">Selecione o vereador</option>
                                @foreach($vereadores as $vereador)
                                    <option value="{{ $vereador->id }}" {{ old('autor_id') == $vereador->id ? 'selected' : '' }}>
                                        {{ $vereador->nome }} - {{ $vereador->partido }}
                                    </option>
                                @endforeach
                            </select>
                            @error('autor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campos específicos para Comissão -->
                        <div id="campos_comissao" class="mb-3" style="display: none;">
                            <label for="autor_nome" class="form-label">Nome da Comissão <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('autor_nome') is-invalid @enderror" 
                                   id="autor_nome" name="autor_nome" value="{{ old('autor_nome') }}"
                                   placeholder="Ex: Comissão de Administração e Finanças">
                            @error('autor_nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campos específicos para Iniciativa Popular -->
                        <div id="campos_iniciativa_popular" class="mb-3" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Para projetos de iniciativa popular, é necessário cadastrar um comitê responsável.
                            </div>
                            
                            <label for="comite_nome" class="form-label">Nome do Responsável/Comitê <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('comite_nome') is-invalid @enderror" 
                                   id="comite_nome" name="comite_nome" value="{{ old('comite_nome') }}"
                                   placeholder="Nome do responsável ou comitê">
                            @error('comite_nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="comite_email" class="form-label">Email de Contato</label>
                                    <input type="email" class="form-control" id="comite_email" name="comite_email" 
                                           value="{{ old('comite_email') }}" placeholder="email@exemplo.com">
                                </div>
                                <div class="col-md-6">
                                    <label for="comite_telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="comite_telefone" name="comite_telefone" 
                                           value="{{ old('comite_telefone') }}" placeholder="(00) 00000-0000">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="numero_assinaturas" class="form-label">Número de Assinaturas Coletadas</label>
                                    <input type="number" class="form-control" id="numero_assinaturas" name="numero_assinaturas" 
                                           value="{{ old('numero_assinaturas', 0) }}" min="0">
                                </div>
                                <div class="col-md-6">
                                    <label for="minimo_assinaturas" class="form-label">Mínimo de Assinaturas Necessárias</label>
                                    <input type="number" class="form-control" id="minimo_assinaturas" name="minimo_assinaturas" 
                                           value="{{ old('minimo_assinaturas', 1000) }}" min="1">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Coautores</label>
                            <div class="row">
                                @foreach($vereadores as $vereador)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="vereadores[]" value="{{ $vereador->id }}" 
                                                   id="vereador_{{ $vereador->id }}"
                                                   {{ in_array($vereador->id, old('vereadores', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="vereador_{{ $vereador->id }}">
                                                {{ $vereador->nome }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-text">Selecione os vereadores que são coautores do projeto</div>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Conteúdo</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="justificativa" class="form-label">Justificativa</label>
                            <textarea class="form-control @error('justificativa') is-invalid @enderror" 
                                      id="justificativa" name="justificativa" rows="5">{{ old('justificativa') }}</textarea>
                            @error('justificativa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Justificativa para o projeto de lei</div>
                        </div>

                        <div class="mb-3">
                            <label for="texto_integral" class="form-label">Texto Integral</label>
                            <textarea class="form-control @error('texto_integral') is-invalid @enderror" 
                                      id="texto_integral" name="texto_integral" rows="10">{{ old('texto_integral') }}</textarea>
                            @error('texto_integral')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Texto completo do projeto de lei</div>
                        </div>
                    </div>
                </div>

                <!-- Arquivos -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-paperclip me-2"></i>Arquivos</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="arquivo_projeto" class="form-label">Arquivo do Projeto</label>
                                    <input type="file" class="form-control @error('arquivo_projeto') is-invalid @enderror" 
                                           id="arquivo_projeto" name="arquivo_projeto" accept=".pdf,.doc,.docx">
                                    @error('arquivo_projeto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">PDF, DOC ou DOCX (máx. 10MB)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="arquivo_lei" class="form-label">Arquivo da Lei (se aprovado)</label>
                                    <input type="file" class="form-control @error('arquivo_lei') is-invalid @enderror" 
                                           id="arquivo_lei" name="arquivo_lei" accept=".pdf,.doc,.docx">
                                    @error('arquivo_lei')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">PDF, DOC ou DOCX (máx. 10MB)</div>
                                </div>
                            </div>
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
                                       {{ old('ativo', '1') ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Projeto Ativo
                                </label>
                            </div>
                            <div class="form-text">Projetos inativos não aparecem no site público</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="urgente" name="urgente" value="1" 
                                       {{ old('urgente') ? 'checked' : '' }}>
                                <label class="form-check-label" for="urgente">
                                    Regime de Urgência
                                </label>
                            </div>
                            <div class="form-text">Marca o projeto como urgente</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="destaque" name="destaque" value="1" 
                                       {{ old('destaque') ? 'checked' : '' }}>
                                <label class="form-check-label" for="destaque">
                                    Projeto em Destaque
                                </label>
                            </div>
                            <div class="form-text">Aparece em destaque no site</div>
                        </div>
                    </div>
                </div>

                <!-- Tramitação -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-route me-2"></i>Tramitação</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="comissao_atual" class="form-label">Comissão Atual</label>
                            <input type="text" class="form-control @error('comissao_atual') is-invalid @enderror" 
                                   id="comissao_atual" name="comissao_atual" value="{{ old('comissao_atual') }}">
                            @error('comissao_atual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Comissão onde o projeto está tramitando</div>
                        </div>

                        <div class="mb-3">
                            <label for="data_aprovacao" class="form-label">Data de Aprovação</label>
                            <input type="date" class="form-control @error('data_aprovacao') is-invalid @enderror" 
                                   id="data_aprovacao" name="data_aprovacao" value="{{ old('data_aprovacao') }}">
                            @error('data_aprovacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Preencher apenas se aprovado</div>
                        </div>

                        <div class="mb-3">
                            <label for="numero_lei" class="form-label">Número da Lei</label>
                            <input type="text" class="form-control @error('numero_lei') is-invalid @enderror" 
                                   id="numero_lei" name="numero_lei" value="{{ old('numero_lei') }}">
                            @error('numero_lei')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Número da lei após aprovação</div>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações Internas</label>
                            <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" name="observacoes" rows="4">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Observações para uso interno (não aparecem no site)</div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Projeto
                            </button>
                            <a href="{{ route('admin.projetos-lei.index') }}" class="btn btn-outline-secondary">
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

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/projetos-lei.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoAutoriaSelect = document.getElementById('tipo_autoria');
    const camposVereador = document.getElementById('campos_vereador');
    const camposComissao = document.getElementById('campos_comissao');
    const camposIniciativaPopular = document.getElementById('campos_iniciativa_popular');
    const autorIdSelect = document.getElementById('autor_id');
    const autorNomeInput = document.getElementById('autor_nome');
    const comiteNomeInput = document.getElementById('comite_nome');

    function toggleCampos() {
        const tipoSelecionado = tipoAutoriaSelect.value;
        
        // Esconder todos os campos
        camposVereador.style.display = 'none';
        camposComissao.style.display = 'none';
        camposIniciativaPopular.style.display = 'none';
        
        // Remover required de todos os campos
        autorIdSelect.removeAttribute('required');
        autorNomeInput.removeAttribute('required');
        comiteNomeInput.removeAttribute('required');
        
        // Mostrar campos específicos baseado na seleção
        switch(tipoSelecionado) {
            case 'vereador':
                camposVereador.style.display = 'block';
                autorIdSelect.setAttribute('required', 'required');
                break;
            case 'prefeito':
                // Para prefeito, não precisamos de campos adicionais
                // O nome será definido automaticamente como "Prefeito Municipal"
                break;
            case 'comissao':
                camposComissao.style.display = 'block';
                autorNomeInput.setAttribute('required', 'required');
                break;
            case 'iniciativa_popular':
                camposIniciativaPopular.style.display = 'block';
                comiteNomeInput.setAttribute('required', 'required');
                break;
        }
    }

    // Executar na inicialização
    toggleCampos();
    
    // Executar quando o tipo de autoria mudar
    tipoAutoriaSelect.addEventListener('change', toggleCampos);
});
</script>
@endpush