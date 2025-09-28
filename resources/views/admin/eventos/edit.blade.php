@extends('layouts.admin')

@section('title', 'Editar Evento - Painel Administrativo')

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
                        <i class="fas fa-edit me-3"></i>
                        Editar Evento
                    </h1>
                    <p class="lead mb-0">
                        Modifique as informações do evento: {{ $evento->titulo }}
                    </p>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.eventos.show', $evento) }}" class="btn btn-outline-light">
                            <i class="fas fa-eye me-2"></i>
                            Visualizar
                        </a>
                        <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" enctype="multipart/form-data" id="form-evento">
                @csrf
                @method('PUT')
                
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
                                       id="titulo" name="titulo" value="{{ old('titulo', $evento->titulo) }}" 
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
                                        <option value="{{ $key }}" {{ old('tipo', $evento->tipo) == $key ? 'selected' : '' }}>
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
                                          placeholder="Descreva os detalhes do evento...">{{ old('descricao', $evento->descricao) }}</textarea>
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
                                       id="data_evento" name="data_evento" 
                                       value="{{ old('data_evento', $evento->data_evento->format('Y-m-d')) }}" required>
                                @error('data_evento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="hora_inicio" class="form-label">Hora de Início</label>
                                <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" 
                                       id="hora_inicio" name="hora_inicio" 
                                       value="{{ old('hora_inicio', $evento->hora_inicio) }}">
                                @error('hora_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="hora_fim" class="form-label">Hora de Término</label>
                                <input type="time" class="form-control @error('hora_fim') is-invalid @enderror" 
                                       id="hora_fim" name="hora_fim" 
                                       value="{{ old('hora_fim', $evento->hora_fim) }}">
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
                                       id="local" name="local" value="{{ old('local', $evento->local) }}" 
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
                                        <option value="{{ $vereador->id }}" 
                                                {{ old('vereador_id', $evento->vereador_id) == $vereador->id ? 'selected' : '' }}>
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
                                        <div class="color-preview evento-cor-dinamica {{ old('cor_destaque', $evento->cor_destaque) == $cor ? 'selected' : '' }}" 
                                             data-cor="{{ $cor }}" 
                                             data-color="{{ $cor }}" 
                                             title="{{ $nome }}"
                                             onclick="selecionarCor('{{ $cor }}')">
                                        </div>
                                    @endforeach
                                </div>
                                <input type="color" class="form-control @error('cor_destaque') is-invalid @enderror" 
                                       id="cor_destaque" name="cor_destaque" 
                                       value="{{ old('cor_destaque', $evento->cor_destaque) }}">
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
                                            <input type="checkbox" name="destaque" value="1" 
                                                   {{ old('destaque', $evento->destaque) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>Evento ativo</span>
                                        <label class="switch">
                                            <input type="checkbox" name="ativo" value="1" 
                                                   {{ old('ativo', $evento->ativo) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anexos -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-paperclip me-2"></i>
                            Anexos e Links
                        </h4>
                        
                        @if($evento->anexo)
                            <div class="anexo-atual">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-alt fa-2x text-primary me-3"></i>
                                        <div>
                                            <h6 class="mb-1">Anexo Atual</h6>
                                            <p class="mb-0 text-muted">{{ basename($evento->anexo) }}</p>
                                            <small class="text-muted">
                                                Enviado em {{ $evento->updated_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ Storage::url($evento->anexo) }}" target="_blank" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download me-1"></i>
                                            Baixar
                                        </a>
                                        <button type="button" class="btn-remove" onclick="removerAnexo()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="remover_anexo" id="remover_anexo" value="0">
                        @endif
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="url_detalhes" class="form-label">URL para Detalhes</label>
                                <input type="url" class="form-control @error('url_detalhes') is-invalid @enderror" 
                                       id="url_detalhes" name="url_detalhes" 
                                       value="{{ old('url_detalhes', $evento->url_detalhes) }}" 
                                       placeholder="https://exemplo.com/detalhes-evento">
                                @error('url_detalhes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="anexo" class="form-label">
                                    {{ $evento->anexo ? 'Substituir Anexo' : 'Novo Anexo' }}
                                </label>
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
                                          placeholder="Observações adicionais sobre o evento...">{{ old('observacoes', $evento->observacoes) }}</textarea>
                                @error('observacoes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Histórico -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-history me-2"></i>
                            Histórico do Evento
                        </h4>
                        
                        <div class="historico-evento">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Criado em:</strong><br>
                                    {{ $evento->created_at->format('d/m/Y H:i') }}
                                    @if($evento->user)
                                        <br><small class="text-muted">por {{ $evento->user->name }}</small>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Última atualização:</strong><br>
                                    {{ $evento->updated_at->format('d/m/Y H:i') }}
                                    @if($evento->updated_at != $evento->created_at)
                                        <br><small class="text-muted">{{ $evento->updated_at->diffForHumans() }}</small>
                                    @endif
                                </div>
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
                                    <div class="text-white p-2 rounded text-center evento-cor-dinamica preview-cor-evento" 
                                         data-cor="{{ $evento->cor_destaque }}" 
                                         id="preview-cor">
                                        <div class="fw-bold" id="preview-dia">{{ $evento->data_evento->format('d') }}</div>
                                        <small id="preview-mes">{{ strtoupper($evento->data_evento->format('M')) }}</small>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1" id="preview-titulo">{{ $evento->titulo }}</h5>
                                    <p class="text-muted mb-2" id="preview-descricao">{{ $evento->descricao ?: 'Sem descrição' }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-secondary" id="preview-tipo">{{ $tipos[$evento->tipo] ?? $evento->tipo }}</span>
                                        @if($evento->hora_inicio)
                                            <span class="badge bg-info" id="preview-horario">
                                                {{ $evento->hora_inicio }}{{ $evento->hora_fim ? ' às ' . $evento->hora_fim : '' }}
                                            </span>
                                        @endif
                                        @if($evento->local)
                                            <span class="badge bg-warning" id="preview-local">{{ $evento->local }}</span>
                                        @endif
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
                                <a href="{{ route('admin.eventos.duplicate', $evento) }}" 
                                   class="btn btn-outline-info btn-action">
                                    <i class="fas fa-copy me-2"></i>
                                    Duplicar
                                </a>
                                <button type="submit" class="btn btn-warning btn-action">
                                    <i class="fas fa-save me-2"></i>
                                    Salvar Alterações
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