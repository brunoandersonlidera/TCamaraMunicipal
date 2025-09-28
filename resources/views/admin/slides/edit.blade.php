@extends('layouts.admin')

@section('title', 'Editar Slide')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Editar Slide: {{ $slide->titulo }}
                    </h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.slides.show', $slide) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye me-1"></i>
                            Visualizar
                        </a>
                        <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.slides.update', $slide) }}" method="POST" enctype="multipart/form-data" id="slideForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Coluna Esquerda -->
                            <div class="col-md-8">
                                <!-- Título -->
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">
                                        <i class="fas fa-heading me-1"></i>
                                        Título <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('titulo') is-invalid @enderror" 
                                           id="titulo" 
                                           name="titulo" 
                                           value="{{ old('titulo', $slide->titulo) }}" 
                                           required 
                                           maxlength="255">
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Descrição -->
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>
                                        Descrição
                                    </label>
                                    <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                              id="descricao" 
                                              name="descricao" 
                                              rows="4" 
                                              placeholder="Descrição do slide (opcional)">{{ old('descricao', $slide->descricao) }}</textarea>
                                    @error('descricao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Imagem Atual -->
                                @if($slide->imagem)
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-image me-1"></i>
                                        Imagem Atual
                                    </label>
                                    <div class="current-image">
                                        <img src="{{ $slide->url_imagem }}" 
                                             alt="{{ $slide->titulo }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 300px; max-height: 200px;">
                                        <div class="mt-2">
                                            <small class="text-muted">{{ $slide->imagem }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Nova Imagem -->
                                <div class="mb-3">
                                    <label for="imagem" class="form-label">
                                        <i class="fas fa-image me-1"></i>
                                        {{ $slide->imagem ? 'Alterar Imagem' : 'Imagem' }}
                                        @if(!$slide->imagem) <span class="text-danger">*</span> @endif
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('imagem') is-invalid @enderror" 
                                           id="imagem" 
                                           name="imagem" 
                                           accept="image/*" 
                                           {{ !$slide->imagem ? 'required' : '' }}>
                                    <div class="form-text">
                                        Formatos aceitos: JPEG, PNG, JPG, GIF, SVG. Tamanho máximo: 2MB.
                                        @if($slide->imagem)
                                            <br><strong>Deixe em branco para manter a imagem atual.</strong>
                                        @endif
                                    </div>
                                    @error('imagem')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Preview da nova imagem -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <label class="form-label">Preview da Nova Imagem:</label>
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                                    </div>
                                </div>

                                <!-- Link -->
                                <div class="mb-3">
                                    <label for="link" class="form-label">
                                        <i class="fas fa-link me-1"></i>
                                        Link (URL)
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('link') is-invalid @enderror" 
                                           id="link" 
                                           name="link" 
                                           value="{{ old('link', $slide->link) }}" 
                                           placeholder="https://exemplo.com">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Coluna Direita -->
                            <div class="col-md-4">
                                <!-- Configurações -->
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-cogs me-1"></i>
                                            Configurações
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Ordem -->
                                        <div class="mb-3">
                                            <label for="ordem" class="form-label">
                                                <i class="fas fa-sort-numeric-up me-1"></i>
                                                Ordem <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('ordem') is-invalid @enderror" 
                                                   id="ordem" 
                                                   name="ordem" 
                                                   value="{{ old('ordem', $slide->ordem) }}" 
                                                   min="0" 
                                                   required>
                                            @error('ordem')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Velocidade -->
                                        <div class="mb-3">
                                            <label for="velocidade" class="form-label">
                                                <i class="fas fa-tachometer-alt me-1"></i>
                                                Velocidade <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="number" 
                                                       class="form-control @error('velocidade') is-invalid @enderror" 
                                                       id="velocidade" 
                                                       name="velocidade" 
                                                       value="{{ old('velocidade', $slide->velocidade) }}" 
                                                       min="1000" 
                                                       max="10000" 
                                                       step="500" 
                                                       required>
                                                <span class="input-group-text">{{ ($slide->velocidade / 1000) }}s</span>
                                            </div>
                                            <div class="form-text">Entre 1000ms (1s) e 10000ms (10s)</div>
                                            @error('velocidade')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Transição -->
                                        <div class="mb-3">
                                            <label for="transicao" class="form-label">
                                                <i class="fas fa-exchange-alt me-1"></i>
                                                Transição <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('transicao') is-invalid @enderror" 
                                                    id="transicao" 
                                                    name="transicao" 
                                                    required>
                                                @foreach($opcoesTransicao as $valor => $label)
                                                    <option value="{{ $valor }}" {{ old('transicao', $slide->transicao) == $valor ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('transicao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Direção -->
                                        <div class="mb-3">
                                            <label for="direcao" class="form-label">
                                                <i class="fas fa-arrows-alt me-1"></i>
                                                Direção <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('direcao') is-invalid @enderror" 
                                                    id="direcao" 
                                                    name="direcao" 
                                                    required>
                                                @foreach($opcoesDirecao as $valor => $label)
                                                    <option value="{{ $valor }}" {{ old('direcao', $slide->direcao) == $valor ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('direcao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Checkboxes -->
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="nova_aba" 
                                                       name="nova_aba" 
                                                       value="1" 
                                                       {{ old('nova_aba', $slide->nova_aba) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nova_aba">
                                                    <i class="fas fa-external-link-alt me-1"></i>
                                                    Abrir link em nova aba
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="ativo" 
                                                       name="ativo" 
                                                       value="1" 
                                                       {{ old('ativo', $slide->ativo) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ativo">
                                                    <i class="fas fa-eye me-1"></i>
                                                    Slide ativo
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Informações adicionais -->
                                        <hr>
                                        <div class="small text-muted">
                                            <div><strong>Criado em:</strong> {{ $slide->created_at->format('d/m/Y H:i') }}</div>
                                            <div><strong>Atualizado em:</strong> {{ $slide->updated_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <!-- Botão de exclusão -->
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal">
                                            <i class="fas fa-trash me-2"></i>
                                            Excluir Slide
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Atualizar Slide
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o slide <strong>"{{ $slide->titulo }}"</strong>?</p>
                <p class="text-danger mb-0">
                    <i class="fas fa-warning me-1"></i>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </button>
                <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview da nova imagem
    const imagemInput = document.getElementById('imagem');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    imagemInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });

    // Validação do formulário
    const form = document.getElementById('slideForm');
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validar título
        const titulo = document.getElementById('titulo');
        if (!titulo.value.trim()) {
            isValid = false;
            titulo.classList.add('is-invalid');
        } else {
            titulo.classList.remove('is-invalid');
        }

        // Validar velocidade
        const velocidade = document.getElementById('velocidade');
        const velocidadeValue = parseInt(velocidade.value);
        if (velocidadeValue < 1000 || velocidadeValue > 10000) {
            isValid = false;
            velocidade.classList.add('is-invalid');
        } else {
            velocidade.classList.remove('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            alert('Por favor, corrija os erros no formulário antes de continuar.');
        }
    });

    // Atualizar preview da velocidade
    const velocidadeInput = document.getElementById('velocidade');
    velocidadeInput.addEventListener('input', function() {
        const valor = parseInt(this.value);
        const segundos = (valor / 1000).toFixed(1);
        
        // Atualizar texto do input group
        const inputGroupText = this.parentElement.querySelector('.input-group-text');
        if (inputGroupText) {
            inputGroupText.textContent = `${segundos}s`;
        }
    });
});
</script>
@endpush