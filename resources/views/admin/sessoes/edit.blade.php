@extends('layouts.admin')

@section('page-title', 'Editar Sessão')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.sessoes.index') }}">Sessões</a></li>
        <li class="breadcrumb-item active">Editar Sessão</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Editar Sessão</h1>
                    <p class="text-muted">Edite os dados da sessão {{ $sessao->numero }}/{{ $sessao->legislatura }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.sessoes.show', $sessao) }}" class="btn btn-outline-info me-2">
                        <i class="fas fa-eye me-2"></i>Visualizar
                    </a>
                    <a href="{{ route('admin.sessoes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.sessoes.update', $sessao) }}" method="POST" enctype="multipart/form-data" id="sessaoForm">
                @csrf
                @method('PUT')
                
                <!-- Dados Básicos -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Dados Básicos</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número da Sessão <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('numero') is-invalid @enderror" 
                                           id="numero" name="numero" value="{{ old('numero', $sessao->numero) }}" min="1" required>
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="ordinaria" {{ old('tipo', $sessao->tipo) === 'ordinaria' ? 'selected' : '' }}>Ordinária</option>
                                        <option value="extraordinaria" {{ old('tipo', $sessao->tipo) === 'extraordinaria' ? 'selected' : '' }}>Extraordinária</option>
                                        <option value="solene" {{ old('tipo', $sessao->tipo) === 'solene' ? 'selected' : '' }}>Solene</option>
                                        <option value="especial" {{ old('tipo', $sessao->tipo) === 'especial' ? 'selected' : '' }}>Especial</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="legislatura" class="form-label">Legislatura <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('legislatura') is-invalid @enderror" 
                                           id="legislatura" name="legislatura" value="{{ old('legislatura', $sessao->legislatura) }}" min="1" required>
                                    @error('legislatura')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="sessao_legislativa" class="form-label">Sessão Legislativa <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('sessao_legislativa') is-invalid @enderror" 
                                           id="sessao_legislativa" name="sessao_legislativa" value="{{ old('sessao_legislativa', $sessao->sessao_legislativa) }}" min="1" required>
                                    @error('sessao_legislativa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                           id="titulo" name="titulo" value="{{ old('titulo', $sessao->titulo) }}" 
                                           placeholder="Ex: Sessão Ordinária para discussão do orçamento municipal" required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <span id="tituloCount">0</span>/255 caracteres
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="agendada" {{ old('status', $sessao->status) === 'agendada' ? 'selected' : '' }}>Agendada</option>
                                        <option value="em_andamento" {{ old('status', $sessao->status) === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                        <option value="finalizada" {{ old('status', $sessao->status) === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                        <option value="cancelada" {{ old('status', $sessao->status) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data, Hora e Local -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Data, Hora e Local</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_hora" class="form-label">Data e Hora <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('data_hora') is-invalid @enderror" 
                                           id="data_hora" name="data_hora" 
                                           value="{{ old('data_hora', $sessao->data_hora ? $sessao->data_hora->format('Y-m-d\TH:i') : '') }}" required>
                                    @error('data_hora')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="local" class="form-label">Local <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('local') is-invalid @enderror" 
                                           id="local" name="local" value="{{ old('local', $sessao->local) }}" 
                                           placeholder="Ex: Plenário da Câmara Municipal" required>
                                    @error('local')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pauta e Ata -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Pauta e Ata</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="pauta" class="form-label">Pauta <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('pauta') is-invalid @enderror" 
                                      id="pauta" name="pauta" rows="6" required 
                                      placeholder="Descreva a pauta da sessão...">{{ old('pauta', $sessao->pauta) }}</textarea>
                            @error('pauta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="ata" class="form-label">Ata</label>
                            <textarea class="form-control @error('ata') is-invalid @enderror" 
                                      id="ata" name="ata" rows="6" 
                                      placeholder="Registre a ata da sessão...">{{ old('ata', $sessao->ata) }}</textarea>
                            @error('ata')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                    <label for="arquivo_pauta" class="form-label">Arquivo da Pauta</label>
                                    @if($sessao->arquivo_pauta)
                                        <div class="mb-2">
                                            <div class="alert alert-info d-flex align-items-center">
                                                <i class="fas fa-file-pdf me-2"></i>
                                                <div class="flex-grow-1">
                                                    <strong>Arquivo atual:</strong> {{ basename($sessao->arquivo_pauta) }}
                                                    <div class="mt-1">
                                                        <a href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'pauta']) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download me-1"></i>Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('arquivo_pauta') is-invalid @enderror" 
                                           id="arquivo_pauta" name="arquivo_pauta" accept=".pdf,.doc,.docx">
                                    @error('arquivo_pauta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Formatos aceitos: PDF, DOC, DOCX (máx. 10MB)
                                        @if($sessao->arquivo_pauta)
                                            <br><small class="text-warning">Selecionar um novo arquivo substituirá o atual</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="arquivo_ata" class="form-label">Arquivo da Ata</label>
                                    @if($sessao->arquivo_ata)
                                        <div class="mb-2">
                                            <div class="alert alert-info d-flex align-items-center">
                                                <i class="fas fa-file-pdf me-2"></i>
                                                <div class="flex-grow-1">
                                                    <strong>Arquivo atual:</strong> {{ basename($sessao->arquivo_ata) }}
                                                    <div class="mt-1">
                                                        <a href="{{ route('admin.sessoes.download', ['sessao' => $sessao, 'tipo' => 'ata']) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download me-1"></i>Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('arquivo_ata') is-invalid @enderror" 
                                           id="arquivo_ata" name="arquivo_ata" accept=".pdf,.doc,.docx">
                                    @error('arquivo_ata')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Formatos aceitos: PDF, DOC, DOCX (máx. 10MB)
                                        @if($sessao->arquivo_ata)
                                            <br><small class="text-warning">Selecionar um novo arquivo substituirá o atual</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vereadores Presentes -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Vereadores Presentes</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($vereadores as $vereador)
                            <div class="col-md-4 col-sm-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" 
                                           id="vereador_{{ $vereador->id }}" 
                                           name="vereadores_presentes[]" 
                                           value="{{ $vereador->id }}"
                                           {{ in_array($vereador->id, old('vereadores_presentes', $sessao->vereadores->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vereador_{{ $vereador->id }}">
                                        {{ $vereador->nome }}
                                        <small class="text-muted d-block">{{ $vereador->partido }}</small>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($vereadores->count() === 0)
                            <div class="text-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Nenhum vereador ativo cadastrado.
                            </div>
                        @else
                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllVereadores()">
                                    <i class="fas fa-check-square me-2"></i>Selecionar Todos
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllVereadores()">
                                    <i class="fas fa-square me-2"></i>Desmarcar Todos
                                </button>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Atualmente {{ $sessao->vereadores->count() }} vereador(es) marcado(s) como presente(s)
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Transmissão -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-video me-2"></i>Transmissão</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="transmissao_url" class="form-label">URL de Transmissão</label>
                                    <input type="url" class="form-control @error('transmissao_url') is-invalid @enderror" 
                                           id="transmissao_url" name="transmissao_url" value="{{ old('transmissao_url', $sessao->transmissao_url) }}" 
                                           placeholder="https://exemplo.com/transmissao">
                                    @error('transmissao_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">URL do YouTube</label>
                                    <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                           id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $sessao->youtube_url) }}" 
                                           placeholder="https://youtube.com/watch?v=...">
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" name="observacoes" rows="4" 
                                      placeholder="Observações adicionais sobre a sessão...">{{ old('observacoes', $sessao->observacoes) }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.sessoes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Atualizar Sessão
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-check-label {
    cursor: pointer;
}

.admin-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-text {
    font-size: 0.875em;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}

.alert-info {
    background-color: #e7f3ff;
    border-color: #b3d7ff;
    color: #0c5460;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contador de caracteres para título
    const tituloInput = document.getElementById('titulo');
    const tituloCount = document.getElementById('tituloCount');
    
    function updateTituloCount() {
        const count = tituloInput.value.length;
        tituloCount.textContent = count;
        tituloCount.className = count > 255 ? 'text-danger' : '';
    }
    
    tituloInput.addEventListener('input', updateTituloCount);
    updateTituloCount(); // Inicializar contador
});

function selectAllVereadores() {
    const checkboxes = document.querySelectorAll('input[name="vereadores_presentes[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllVereadores() {
    const checkboxes = document.querySelectorAll('input[name="vereadores_presentes[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>
@endpush