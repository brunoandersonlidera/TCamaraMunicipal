@extends('layouts.admin')

@section('title', isset($cartaServico) ? 'Editar Carta de Serviço' : 'Nova Carta de Serviço')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.cartas-servico.index') }}">Cartas de Serviço</a></li>
        <li class="breadcrumb-item active">{{ isset($cartaServico) ? 'Editar' : 'Nova' }}</li>
    </ol>
</nav>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cartas-servico.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="form-container">
        <!-- Cabeçalho -->
        <div class="form-header">
            <h2>{{ isset($cartaServico) ? 'Editar Carta de Serviço' : 'Nova Carta de Serviço' }}</h2>
            <p>{{ isset($cartaServico) ? 'Atualize as informações do serviço' : 'Preencha as informações conforme a Lei 13.460/2017' }}</p>
        </div>

        <!-- Formulário -->
        <form method="POST" action="{{ isset($cartaServico) ? route('admin.cartas-servico.update', $cartaServico->id) : route('admin.cartas-servico.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($cartaServico))
                @method('PUT')
            @endif

            <div class="form-body">
                <!-- Informações Básicas -->
                <div class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Informações Básicas
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nome" class="form-label">
                                Nome do Serviço <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                   id="nome" name="nome" value="{{ old('nome', $cartaServico->nome ?? '') }}" 
                                   placeholder="Ex: Protocolo de Documentos" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="categoria" class="form-label">
                                Categoria <span class="required">*</span>
                            </label>
                            <select class="form-select @error('categoria') is-invalid @enderror" 
                                    id="categoria" name="categoria" required>
                                <option value="">Selecione uma categoria</option>
                                <option value="legislativo" {{ old('categoria', $cartaServico->categoria ?? '') == 'legislativo' ? 'selected' : '' }}>Legislativo</option>
                                <option value="administrativo" {{ old('categoria', $cartaServico->categoria ?? '') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="transparencia" {{ old('categoria', $cartaServico->categoria ?? '') == 'transparencia' ? 'selected' : '' }}>Transparência</option>
                                <option value="protocolo" {{ old('categoria', $cartaServico->categoria ?? '') == 'protocolo' ? 'selected' : '' }}>Protocolo</option>
                                <option value="ouvidoria" {{ old('categoria', $cartaServico->categoria ?? '') == 'ouvidoria' ? 'selected' : '' }}>Ouvidoria</option>
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descricao" class="form-label">
                        Descrição do Serviço <span class="required">*</span>
                    </label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" 
                              id="descricao" name="descricao" rows="4" 
                              placeholder="Descreva detalhadamente o que é este serviço e para que serve" required>{{ old('descricao', $cartaServico->descricao ?? '') }}</textarea>
                    <div class="form-text">Explique claramente o objetivo e benefícios do serviço</div>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publico_alvo" class="form-label">
                                Público-Alvo <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('publico_alvo') is-invalid @enderror" 
                                   id="publico_alvo" name="publico_alvo" 
                                   value="{{ old('publico_alvo', $cartaServico->publico_alvo ?? '') }}" 
                                   placeholder="Ex: Cidadãos, Empresas, Advogados" required>
                            <div class="form-text">Quem pode utilizar este serviço</div>
                            @error('publico_alvo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="prazo_atendimento" class="form-label">
                                Prazo de Atendimento <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('prazo_atendimento') is-invalid @enderror" 
                                   id="prazo_atendimento" name="prazo_atendimento" 
                                   value="{{ old('prazo_atendimento', $cartaServico->prazo_atendimento ?? '') }}" 
                                   placeholder="Ex: 5 dias úteis" required>
                            @error('prazo_atendimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status" class="form-label">
                                Status <span class="required">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="rascunho" {{ old('status', $cartaServico->status ?? 'rascunho') == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                                <option value="ativo" {{ old('status', $cartaServico->status ?? '') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="inativo" {{ old('status', $cartaServico->status ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ícone -->
                <div class="form-group">
                    <label class="form-label">Ícone do Serviço</label>
                    <input type="hidden" id="icone" name="icone" value="{{ old('icone', $cartaServico->icone ?? 'file-alt') }}">
                    <div class="icon-selector">
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? 'file-alt') == 'file-alt' ? 'selected' : '' }}" data-icon="file-alt">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? '') == 'search' ? 'selected' : '' }}" data-icon="search">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? '') == 'info-circle' ? 'selected' : '' }}" data-icon="info-circle">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? '') == 'comments' ? 'selected' : '' }}" data-icon="comments">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? '') == 'clipboard-list' ? 'selected' : '' }}" data-icon="clipboard-list">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? '') == 'certificate' ? 'selected' : '' }}" data-icon="certificate">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? '') == 'handshake' ? 'selected' : '' }}" data-icon="handshake">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="icon-option {{ old('icone', $cartaServico->icone ?? '') == 'gavel' ? 'selected' : '' }}" data-icon="gavel">
                            <i class="fas fa-gavel"></i>
                        </div>
                    </div>
                </div>

                <!-- Etapas do Processo -->
                <div class="section-title">
                    <i class="fas fa-list-ol"></i>
                    Etapas do Processo
                </div>

                <div class="etapas-container">
                    <div id="etapas-list">
                        @if(old('etapas') || (isset($cartaServico) && $cartaServico->etapas))
                            @foreach(old('etapas', json_decode($cartaServico->etapas ?? '[]', true)) as $index => $etapa)
                            <div class="etapa-item">
                                <div class="etapa-header">
                                    <div class="etapa-number">{{ $index + 1 }}</div>
                                    <button type="button" class="remove-etapa" onclick="removeEtapa(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="etapas[{{ $index }}][titulo]" 
                                               placeholder="Título da etapa" value="{{ $etapa['titulo'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="etapas[{{ $index }}][descricao]" 
                                               placeholder="Descrição da etapa" value="{{ $etapa['descricao'] ?? '' }}" required>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="etapa-item">
                            <div class="etapa-header">
                                <div class="etapa-number">1</div>
                                <button type="button" class="remove-etapa" onclick="removeEtapa(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="etapas[0][titulo]" 
                                           placeholder="Título da etapa" required>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="etapas[0][descricao]" 
                                           placeholder="Descrição da etapa" required>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="add-etapa" onclick="addEtapa()">
                        <i class="fas fa-plus me-2"></i>Adicionar Etapa
                    </button>
                </div>

                <!-- Documentos Necessários -->
                <div class="section-title">
                    <i class="fas fa-folder-open"></i>
                    Documentos Necessários
                </div>

                <div class="documentos-container">
                    <div id="documentos-list">
                        @if(old('documentos') || (isset($cartaServico) && $cartaServico->documentos))
                            @foreach(old('documentos', json_decode($cartaServico->documentos ?? '[]', true)) as $index => $documento)
                            <div class="documento-item">
                                <input type="text" class="form-control" name="documentos[]" 
                                       placeholder="Ex: RG, CPF, Comprovante de residência" value="{{ $documento }}" required>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeDocumento(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @endforeach
                        @else
                        <div class="documento-item">
                            <input type="text" class="form-control" name="documentos[]" 
                                   placeholder="Ex: RG, CPF, Comprovante de residência" required>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeDocumento(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="add-etapa" onclick="addDocumento()">
                        <i class="fas fa-plus me-2"></i>Adicionar Documento
                    </button>
                </div>

                <!-- Canais de Atendimento -->
                <div class="section-title">
                    <i class="fas fa-phone"></i>
                    Canais de Atendimento
                </div>

                <div class="canais-container">
                    <div class="canal-item {{ in_array('presencial', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'selected' : '' }}" 
                         data-canal="presencial">
                        <i class="fas fa-building"></i>
                        <span>Presencial</span>
                        <input type="checkbox" name="canais[]" value="presencial" 
                               {{ in_array('presencial', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'checked' : '' }}>
                    </div>
                    
                    <div class="canal-item {{ in_array('telefone', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'selected' : '' }}" 
                         data-canal="telefone">
                        <i class="fas fa-phone"></i>
                        <span>Telefone</span>
                        <input type="checkbox" name="canais[]" value="telefone" 
                               {{ in_array('telefone', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'checked' : '' }}>
                    </div>
                    
                    <div class="canal-item {{ in_array('email', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'selected' : '' }}" 
                         data-canal="email">
                        <i class="fas fa-envelope"></i>
                        <span>E-mail</span>
                        <input type="checkbox" name="canais[]" value="email" 
                               {{ in_array('email', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'checked' : '' }}>
                    </div>
                    
                    <div class="canal-item {{ in_array('online', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'selected' : '' }}" 
                         data-canal="online">
                        <i class="fas fa-globe"></i>
                        <span>Online</span>
                        <input type="checkbox" name="canais[]" value="online" 
                               {{ in_array('online', old('canais', json_decode($cartaServico->canais ?? '[]', true))) ? 'checked' : '' }}>
                    </div>
                </div>

                <!-- Informações Adicionais -->
                <div class="section-title">
                    <i class="fas fa-plus-circle"></i>
                    Informações Adicionais
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="custo" class="form-label">Custo do Serviço</label>
                            <input type="text" class="form-control @error('custo') is-invalid @enderror" 
                                   id="custo" name="custo" value="{{ old('custo', $cartaServico->custo ?? '') }}" 
                                   placeholder="Ex: Gratuito, R$ 10,00">
                            <div class="form-text">Deixe em branco se for gratuito</div>
                            @error('custo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="base_legal" class="form-label">Base Legal</label>
                            <input type="text" class="form-control @error('base_legal') is-invalid @enderror" 
                                   id="base_legal" name="base_legal" value="{{ old('base_legal', $cartaServico->base_legal ?? '') }}" 
                                   placeholder="Ex: Lei Municipal nº 123/2020">
                            <div class="form-text">Lei ou regulamento que fundamenta o serviço</div>
                            @error('base_legal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                              id="observacoes" name="observacoes" rows="3" 
                              placeholder="Informações complementares, horários especiais, etc.">{{ old('observacoes', $cartaServico->observacoes ?? '') }}</textarea>
                    @error('observacoes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Preview -->
                <div class="preview-card hidden" id="preview-card">
                    <h5><i class="fas fa-eye me-2"></i>Pré-visualização</h5>
                    <div class="preview-header">
                        <div class="preview-icon">
                            <i class="fas fa-file-alt" id="preview-icon"></i>
                        </div>
                        <div>
                            <div class="preview-title" id="preview-title">Nome do Serviço</div>
                            <span class="preview-category" id="preview-category">Categoria</span>
                        </div>
                    </div>
                    <p id="preview-description">Descrição do serviço...</p>
                </div>
            </div>

            <!-- Ações -->
            <div class="form-actions">
                <div>
                    @if(isset($cartaServico))
                    <button type="button" class="btn btn-outline-danger" onclick="deleteServiceCurrent()">
                        <i class="fas fa-trash"></i>
                        Excluir Serviço
                    </button>
                    @endif
                </div>
                
                <div class="btn-group">
                    <a href="{{ route('admin.cartas-servico.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                    
                    <button type="submit" name="status" value="rascunho" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Salvar Rascunho
                    </button>
                    
                    <button type="submit" name="status" value="ativo" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        {{ isset($cartaServico) ? 'Atualizar' : 'Publicar' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Dados da carta de serviço para JavaScript -->
<div id="carta-servico-data" 
     data-id="{{ $cartaServico->id ?? '' }}"
     data-nome="{{ $cartaServico->nome ?? '' }}"
     style="display: none;"></div>

@push('scripts')
<script src="{{ asset('js/cartas-servico-data.js') }}"></script>
<script src="{{ asset('js/cartas-servico.js') }}"></script>
<script src="{{ asset('js/cartas-servico-form.js') }}"></script>
<script src="{{ asset('js/cartas-servico-form-init.js') }}"></script>
@endpush
@endsection