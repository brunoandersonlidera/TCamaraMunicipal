@extends('layouts.admin')

@section('title', 'Novo Evento - Painel Administrativo')

@push('styles')
@vite(['resources/css/admin/eventos.css'])
<link rel="stylesheet" href="{{ asset('css/admin-eventos.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="form-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-2">
                        <i class="fas fa-plus-circle me-3"></i>
                        Novo Evento
                    </h1>
                    <p class="lead mb-0">
                        Adicione um novo evento ao calendário legislativo
                    </p>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>
                        Voltar à Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data" id="form-evento">
                @csrf
                
                <div class="form-card">
                    <!-- Informações Básicas -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Informações Básicas
                        </h4>
                        
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="titulo" class="form-label">Título do Evento *</label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" name="titulo" value="{{ old('titulo') }}" 
                                       placeholder="Digite o título do evento..." required>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="tipo" class="form-label">Tipo de Evento *</label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" name="tipo" required>
                                    <option value="">Selecione o tipo</option>
                                    @foreach($tipos as $key => $label)
                                        <option value="{{ $key }}" {{ old('tipo') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                          id="descricao" name="descricao" rows="4" 
                                          placeholder="Descreva os detalhes do evento...">{{ old('descricao') }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data e Horário -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Data e Horário
                        </h4>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="data_evento" class="form-label">Data do Evento *</label>
                                <input type="date" class="form-control @error('data_evento') is-invalid @enderror" 
                                       id="data_evento" name="data_evento" value="{{ old('data_evento') }}" required>
                                @error('data_evento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="hora_inicio" class="form-label">Hora de Início</label>
                                <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" 
                                       id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio') }}">
                                @error('hora_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="hora_fim" class="form-label">Hora de Término</label>
                                <input type="time" class="form-control @error('hora_fim') is-invalid @enderror" 
                                       id="hora_fim" name="hora_fim" value="{{ old('hora_fim') }}">
                                @error('hora_fim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Local e Responsável -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Local e Responsável
                        </h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="local" class="form-label">Local do Evento</label>
                                <input type="text" class="form-control @error('local') is-invalid @enderror" 
                                       id="local" name="local" value="{{ old('local') }}" 
                                       placeholder="Ex: Plenário da Câmara Municipal">
                                @error('local')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="vereador_id" class="form-label">Vereador Responsável</label>
                                <select class="form-select @error('vereador_id') is-invalid @enderror" 
                                        id="vereador_id" name="vereador_id">
                                    <option value="">Nenhum vereador específico</option>
                                    @foreach($vereadores as $vereador)
                                        <option value="{{ $vereador->id }}" {{ old('vereador_id') == $vereador->id ? 'selected' : '' }}>
                                            {{ $vereador->nome }} - {{ $vereador->partido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vereador_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Configurações Visuais -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-palette me-2"></i>
                            Configurações Visuais
                        </h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cor de Destaque</label>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach($cores as $cor => $nome)
                                        <div class="color-preview evento-cor-dinamica" 
                                             data-cor="{{ $cor }}" 
                                             data-color="{{ $cor }}" 
                                             title="{{ $nome }}"
                                             onclick="selecionarCor('{{ $cor }}')">
                                        </div>
                                    @endforeach
                                </div>
                                <input type="color" class="form-control @error('cor_destaque') is-invalid @enderror" 
                                       id="cor_destaque" name="cor_destaque" value="{{ old('cor_destaque', '#007bff') }}">
                                @error('cor_destaque')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Opções de Exibição</label>
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>Destacar no calendário</span>
                                        <label class="switch">
                                            <input type="checkbox" name="destaque" value="1" {{ old('destaque') ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>Evento ativo</span>
                                        <label class="switch">
                                            <input type="checkbox" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-plus-circle me-2"></i>
                            Informações Adicionais
                        </h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="url_detalhes" class="form-label">URL para Detalhes</label>
                                <input type="url" class="form-control @error('url_detalhes') is-invalid @enderror" 
                                       id="url_detalhes" name="url_detalhes" value="{{ old('url_detalhes') }}" 
                                       placeholder="https://exemplo.com/detalhes-evento">
                                @error('url_detalhes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="anexo" class="form-label">Anexo (PDF, DOC, Imagem)</label>
                                <div class="file-upload-area" onclick="document.getElementById('anexo').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Clique para selecionar um arquivo</p>
                                    <small class="text-muted">Máximo 10MB - PDF, DOC, DOCX, JPG, PNG</small>
                                </div>
                                <input type="file" class="form-control @error('anexo') is-invalid @enderror" 
                                       id="anexo" name="anexo" style="display: none;" 
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                @error('anexo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="arquivo-selecionado" class="mt-2" style="display: none;">
                                    <small class="text-success">
                                        <i class="fas fa-check me-1"></i>
                                        <span id="nome-arquivo"></span>
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <label for="observacoes" class="form-label">Observações</label>
                                <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                          id="observacoes" name="observacoes" rows="3" 
                                          placeholder="Observações adicionais sobre o evento...">{{ old('observacoes') }}</textarea>
                                @error('observacoes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Preview do Evento -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-eye me-2"></i>
                            Preview do Evento
                        </h4>
                        
                        <div class="preview-evento" id="preview-evento">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <div class="bg-primary text-white p-2 rounded text-center" style="min-width: 60px;">
                                        <div class="fw-bold" id="preview-dia">--</div>
                                        <small id="preview-mes">---</small>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1" id="preview-titulo">Título do Evento</h5>
                                    <p class="text-muted mb-2" id="preview-descricao">Descrição do evento...</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-secondary" id="preview-tipo">Tipo</span>
                                        <span class="badge bg-info" id="preview-horario" style="display: none;">Horário</span>
                                        <span class="badge bg-warning" id="preview-local" style="display: none;">Local</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="form-section">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-secondary btn-action">
                                <i class="fas fa-times me-2"></i>
                                Cancelar
                            </a>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-action" onclick="salvarRascunho()">
                                    <i class="fas fa-save me-2"></i>
                                    Salvar Rascunho
                                </button>
                                <button type="submit" class="btn btn-success btn-action">
                                    <i class="fas fa-check me-2"></i>
                                    Criar Evento
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/admin/eventos.js'])
<script src="{{ asset('js/admin-eventos.js') }}"></script>
@endpush