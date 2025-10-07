@extends('layouts.admin')

@section('title', 'Novo Protocolo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.protocolos.index') }}">Protocolos</a></li>
                        <li class="breadcrumb-item active">Novo Protocolo</li>
                    </ol>
                </div>
                <h4 class="page-title">Novo Protocolo</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.protocolos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                           id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="projeto_lei" {{ old('tipo') == 'projeto_lei' ? 'selected' : '' }}>Projeto de Lei</option>
                                        <option value="projeto_resolucao" {{ old('tipo') == 'projeto_resolucao' ? 'selected' : '' }}>Projeto de Resolução</option>
                                        <option value="projeto_decreto" {{ old('tipo') == 'projeto_decreto' ? 'selected' : '' }}>Projeto de Decreto</option>
                                        <option value="indicacao" {{ old('tipo') == 'indicacao' ? 'selected' : '' }}>Indicação</option>
                                        <option value="requerimento" {{ old('tipo') == 'requerimento' ? 'selected' : '' }}>Requerimento</option>
                                        <option value="mocao" {{ old('tipo') == 'mocao' ? 'selected' : '' }}>Moção</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="autor" class="form-label">Autor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('autor') is-invalid @enderror" 
                                           id="autor" name="autor" value="{{ old('autor') }}" required>
                                    @error('autor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="protocolado" {{ old('status', 'protocolado') == 'protocolado' ? 'selected' : '' }}>Protocolado</option>
                                        <option value="em_tramitacao" {{ old('status') == 'em_tramitacao' ? 'selected' : '' }}>Em Tramitação</option>
                                        <option value="aprovado" {{ old('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                        <option value="rejeitado" {{ old('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                        <option value="arquivado" {{ old('status') == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ementa" class="form-label">Ementa <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('ementa') is-invalid @enderror" 
                                      id="ementa" name="ementa" rows="3" required>{{ old('ementa') }}</textarea>
                            @error('ementa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="justificativa" class="form-label">Justificativa</label>
                            <textarea class="form-control @error('justificativa') is-invalid @enderror" 
                                      id="justificativa" name="justificativa" rows="5">{{ old('justificativa') }}</textarea>
                            @error('justificativa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="arquivo_projeto" class="form-label">Arquivo do Projeto (PDF)</label>
                                    <input type="file" class="form-control @error('arquivo_projeto') is-invalid @enderror" 
                                           id="arquivo_projeto" name="arquivo_projeto" accept=".pdf">
                                    @error('arquivo_projeto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Formato aceito: PDF (máx. 10MB)</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="arquivo_justificativa" class="form-label">Arquivo da Justificativa (PDF)</label>
                                    <input type="file" class="form-control @error('arquivo_justificativa') is-invalid @enderror" 
                                           id="arquivo_justificativa" name="arquivo_justificativa" accept=".pdf">
                                    @error('arquivo_justificativa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Formato aceito: PDF (máx. 10MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="consulta_publica" name="consulta_publica" value="1" {{ old('consulta_publica') ? 'checked' : '' }}>
                                <label class="form-check-label" for="consulta_publica">
                                    Disponibilizar para consulta pública
                                </label>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.protocolos.index') }}" class="btn btn-light me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Salvar Protocolo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-gerar número do protocolo baseado no tipo
    const tipoSelect = document.getElementById('tipo');
    
    tipoSelect.addEventListener('change', function() {
        // Aqui poderia fazer uma requisição AJAX para gerar o número do protocolo
        // Por enquanto, será gerado no backend
    });
});
</script>
@endpush
@endsection