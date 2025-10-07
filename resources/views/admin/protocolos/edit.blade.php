@extends('layouts.admin')

@section('title', 'Editar Protocolo: ' . $protocolo->numero_protocolo)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.protocolos.index') }}">Protocolos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.protocolos.show', $protocolo) }}">{{ $protocolo->numero_protocolo }}</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar Protocolo: {{ $protocolo->numero_protocolo }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.protocolos.update', $protocolo) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numero_protocolo" class="form-label">Número do Protocolo</label>
                                    <input type="text" class="form-control" id="numero_protocolo" 
                                           value="{{ $protocolo->numero_protocolo }}" readonly>
                                    <small class="form-text text-muted">O número do protocolo não pode ser alterado.</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_protocolo" class="form-label">Data do Protocolo</label>
                                    <input type="text" class="form-control" id="data_protocolo" 
                                           value="{{ $protocolo->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                           id="titulo" name="titulo" value="{{ old('titulo', $protocolo->titulo) }}" required>
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
                                        <option value="projeto_lei" {{ old('tipo', $protocolo->tipo) == 'projeto_lei' ? 'selected' : '' }}>Projeto de Lei</option>
                                        <option value="projeto_resolucao" {{ old('tipo', $protocolo->tipo) == 'projeto_resolucao' ? 'selected' : '' }}>Projeto de Resolução</option>
                                        <option value="projeto_decreto" {{ old('tipo', $protocolo->tipo) == 'projeto_decreto' ? 'selected' : '' }}>Projeto de Decreto</option>
                                        <option value="indicacao" {{ old('tipo', $protocolo->tipo) == 'indicacao' ? 'selected' : '' }}>Indicação</option>
                                        <option value="requerimento" {{ old('tipo', $protocolo->tipo) == 'requerimento' ? 'selected' : '' }}>Requerimento</option>
                                        <option value="mocao" {{ old('tipo', $protocolo->tipo) == 'mocao' ? 'selected' : '' }}>Moção</option>
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
                                           id="autor" name="autor" value="{{ old('autor', $protocolo->autor) }}" required>
                                    @error('autor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="protocolado" {{ old('status', $protocolo->status) == 'protocolado' ? 'selected' : '' }}>Protocolado</option>
                                        <option value="em_tramitacao" {{ old('status', $protocolo->status) == 'em_tramitacao' ? 'selected' : '' }}>Em Tramitação</option>
                                        <option value="aprovado" {{ old('status', $protocolo->status) == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                        <option value="rejeitado" {{ old('status', $protocolo->status) == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                        <option value="arquivado" {{ old('status', $protocolo->status) == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
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
                                      id="ementa" name="ementa" rows="3" required>{{ old('ementa', $protocolo->ementa) }}</textarea>
                            @error('ementa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="justificativa" class="form-label">Justificativa</label>
                            <textarea class="form-control @error('justificativa') is-invalid @enderror" 
                                      id="justificativa" name="justificativa" rows="5">{{ old('justificativa', $protocolo->justificativa) }}</textarea>
                            @error('justificativa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="arquivo_projeto" class="form-label">Arquivo do Projeto (PDF)</label>
                                    @if($protocolo->arquivo_projeto)
                                        <div class="mb-2">
                                            <small class="text-muted">Arquivo atual: </small>
                                            <a href="{{ Storage::url($protocolo->arquivo_projeto) }}" target="_blank" class="text-primary">
                                                <i class="mdi mdi-file-pdf"></i> Visualizar arquivo atual
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('arquivo_projeto') is-invalid @enderror" 
                                           id="arquivo_projeto" name="arquivo_projeto" accept=".pdf">
                                    @error('arquivo_projeto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Formato aceito: PDF (máx. 10MB). Deixe em branco para manter o arquivo atual.</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="arquivo_justificativa" class="form-label">Arquivo da Justificativa (PDF)</label>
                                    @if($protocolo->arquivo_justificativa)
                                        <div class="mb-2">
                                            <small class="text-muted">Arquivo atual: </small>
                                            <a href="{{ Storage::url($protocolo->arquivo_justificativa) }}" target="_blank" class="text-primary">
                                                <i class="mdi mdi-file-pdf"></i> Visualizar arquivo atual
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('arquivo_justificativa') is-invalid @enderror" 
                                           id="arquivo_justificativa" name="arquivo_justificativa" accept=".pdf">
                                    @error('arquivo_justificativa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Formato aceito: PDF (máx. 10MB). Deixe em branco para manter o arquivo atual.</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="consulta_publica" name="consulta_publica" 
                                       value="1" {{ old('consulta_publica', $protocolo->consulta_publica) ? 'checked' : '' }}>
                                <label class="form-check-label" for="consulta_publica">
                                    Disponibilizar para consulta pública
                                </label>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.protocolos.show', $protocolo) }}" class="btn btn-light me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Atualizar Protocolo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection