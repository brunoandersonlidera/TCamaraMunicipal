@extends('layouts.admin')

@section('title', 'Nova Licitação')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nova Licitação</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.licitacoes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.licitacoes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="numero_processo" class="form-label">Número do Processo *</label>
                                    <input type="text" class="form-control @error('numero_processo') is-invalid @enderror" 
                                           id="numero_processo" name="numero_processo" value="{{ old('numero_processo') }}" required>
                                    @error('numero_processo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="numero_edital" class="form-label">Número do Edital</label>
                                    <input type="text" class="form-control @error('numero_edital') is-invalid @enderror" 
                                           id="numero_edital" name="numero_edital" value="{{ old('numero_edital') }}">
                                    @error('numero_edital')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="modalidade" class="form-label">Modalidade *</label>
                                    <select class="form-control @error('modalidade') is-invalid @enderror" 
                                            id="modalidade" name="modalidade" required>
                                        <option value="">Selecione uma modalidade</option>
                                        @foreach($modalidades as $modalidade)
                                            <option value="{{ $modalidade }}" 
                                                    {{ old('modalidade') == $modalidade ? 'selected' : '' }}>
                                                {{ $modalidade }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('modalidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select class="form-control @error('tipo') is-invalid @enderror" 
                                            id="tipo" name="tipo">
                                        <option value="">Selecione um tipo</option>
                                        <option value="Menor Preço" {{ old('tipo') == 'Menor Preço' ? 'selected' : '' }}>Menor Preço</option>
                                        <option value="Melhor Técnica" {{ old('tipo') == 'Melhor Técnica' ? 'selected' : '' }}>Melhor Técnica</option>
                                        <option value="Técnica e Preço" {{ old('tipo') == 'Técnica e Preço' ? 'selected' : '' }}>Técnica e Preço</option>
                                        <option value="Maior Lance" {{ old('tipo') == 'Maior Lance' ? 'selected' : '' }}>Maior Lance</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ano_referencia" class="form-label">Ano de Referência *</label>
                                    <input type="number" min="2020" max="2030" 
                                           class="form-control @error('ano_referencia') is-invalid @enderror" 
                                           id="ano_referencia" name="ano_referencia" 
                                           value="{{ old('ano_referencia', date('Y')) }}" required>
                                    @error('ano_referencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="objeto" class="form-label">Objeto *</label>
                            <textarea class="form-control @error('objeto') is-invalid @enderror" 
                                      id="objeto" name="objeto" rows="3" required>{{ old('objeto') }}</textarea>
                            @error('objeto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="descricao_detalhada" class="form-label">Descrição Detalhada</label>
                            <textarea class="form-control @error('descricao_detalhada') is-invalid @enderror" 
                                      id="descricao_detalhada" name="descricao_detalhada" rows="4">{{ old('descricao_detalhada') }}</textarea>
                            @error('descricao_detalhada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="valor_estimado" class="form-label">Valor Estimado *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" 
                                               class="form-control @error('valor_estimado') is-invalid @enderror" 
                                               id="valor_estimado" name="valor_estimado" 
                                               value="{{ old('valor_estimado') }}" required>
                                        @error('valor_estimado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="data_abertura" class="form-label">Data e Hora de Abertura *</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('data_abertura') is-invalid @enderror" 
                                           id="data_abertura" name="data_abertura" 
                                           value="{{ old('data_abertura') }}" required>
                                    @error('data_abertura')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Selecione um status</option>
                                        <option value="publicado" {{ old('status') == 'publicado' ? 'selected' : '' }}>Publicado</option>
                                        <option value="em_andamento" {{ old('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                        <option value="homologado" {{ old('status') == 'homologado' ? 'selected' : '' }}>Homologado</option>
                                        <option value="deserto" {{ old('status') == 'deserto' ? 'selected' : '' }}>Deserto</option>
                                        <option value="fracassado" {{ old('status') == 'fracassado' ? 'selected' : '' }}>Fracassado</option>
                                        <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="local_abertura" class="form-label">Local de Abertura</label>
                                    <input type="text" class="form-control @error('local_abertura') is-invalid @enderror" 
                                           id="local_abertura" name="local_abertura" value="{{ old('local_abertura') }}">
                                    @error('local_abertura')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="responsavel" class="form-label">Responsável</label>
                                    <input type="text" class="form-control @error('responsavel') is-invalid @enderror" 
                                           id="responsavel" name="responsavel" value="{{ old('responsavel') }}">
                                    @error('responsavel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Seção de Upload de Documentos -->
                        <div class="card mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-upload"></i> Documentos da Licitação
                                </h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-documento">
                                    <i class="fas fa-plus"></i> Adicionar Documento
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="documentos-container">
                                    <!-- Documentos serão adicionados aqui dinamicamente -->
                                </div>
                                <div class="form-text">
                                    Formatos aceitos: PDF, DOC, DOCX, XLS, XLSX, TXT. Máximo 10MB por arquivo.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Licitação
                        </button>
                        <a href="{{ route('admin.licitacoes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let documentoIndex = 0;

function adicionarDocumento() {
    const container = document.getElementById('documentos-container');
    const documentoDiv = document.createElement('div');
    documentoDiv.className = 'documento-item border rounded p-3 mb-3';
    documentoDiv.setAttribute('data-index', documentoIndex);
    
    documentoDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Documento ${documentoIndex + 1}</h6>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerDocumento(${documentoIndex})">
                <i class="fas fa-trash"></i> Remover
            </button>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Nome do Documento *</label>
                    <input type="text" class="form-control" name="documentos[${documentoIndex}][nome]" 
                           placeholder="Ex: Edital de Licitação" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Tipo de Documento</label>
                    <select class="form-control" name="documentos[${documentoIndex}][tipo_documento]">
                        <option value="edital">Edital</option>
                        <option value="anexo">Anexo</option>
                        <option value="ata">Ata</option>
                        <option value="resultado">Resultado</option>
                        <option value="contrato">Contrato</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="documentos[${documentoIndex}][descricao]" rows="2" 
                      placeholder="Descrição opcional do documento"></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label class="form-label">Arquivo *</label>
                    <input type="file" class="form-control" name="documentos[${documentoIndex}][arquivo]" 
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Documento Público?</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="documentos[${documentoIndex}][publico]" 
                               id="publico_${documentoIndex}" value="1" checked>
                        <label class="form-check-label" for="publico_${documentoIndex}">
                            Visível no portal de transparência
                        </label>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(documentoDiv);
    documentoIndex++;
}

function removerDocumento(index) {
    const documento = document.querySelector(`[data-index="${index}"]`);
    if (documento) {
        documento.remove();
    }
}

// Adicionar evento ao botão
document.getElementById('add-documento').addEventListener('click', adicionarDocumento);

// Adicionar primeiro documento automaticamente
document.addEventListener('DOMContentLoaded', function() {
    adicionarDocumento();
});
</script>
@endpush
@endsection