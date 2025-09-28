<div class="row">
    <!-- Chave -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="chave" class="form-label">Chave <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('chave') is-invalid @enderror" 
                   id="chave" name="chave" value="{{ old('chave', $configuracao->chave ?? '') }}" 
                   placeholder="Ex: brasao_header, logo_footer" required>
            @error('chave')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Identificador único da configuração (sem espaços, use underscore)</div>
        </div>
    </div>

    <!-- Tipo -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                <option value="">Selecione o tipo</option>
                <option value="texto" {{ old('tipo', $configuracao->tipo ?? '') === 'texto' ? 'selected' : '' }}>Texto</option>
                <option value="imagem" {{ old('tipo', $configuracao->tipo ?? '') === 'imagem' ? 'selected' : '' }}>Imagem</option>
                <option value="email" {{ old('tipo', $configuracao->tipo ?? '') === 'email' ? 'selected' : '' }}>E-mail</option>
                <option value="telefone" {{ old('tipo', $configuracao->tipo ?? '') === 'telefone' ? 'selected' : '' }}>Telefone</option>
                <option value="endereco" {{ old('tipo', $configuracao->tipo ?? '') === 'endereco' ? 'selected' : '' }}>Endereço</option>
            </select>
            @error('tipo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Descrição -->
<div class="mb-3">
    <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('descricao') is-invalid @enderror" 
           id="descricao" name="descricao" value="{{ old('descricao', $configuracao->descricao ?? '') }}" 
           placeholder="Ex: Brasão da Câmara Municipal para o cabeçalho" required>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Valor (para tipos não-imagem) -->
<div class="mb-3" id="campo-valor" style="{{ old('tipo', $configuracao->tipo ?? '') === 'imagem' ? 'display: none;' : '' }}">
    <label for="valor" class="form-label">Valor <span class="text-danger">*</span></label>
    <textarea class="form-control @error('valor') is-invalid @enderror" 
              id="valor" name="valor" rows="3" 
              placeholder="Digite o valor da configuração">{{ old('valor', $configuracao->valor ?? '') }}</textarea>
    @error('valor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Upload de Imagem (para tipo imagem) -->
<div class="mb-3" id="campo-imagem" style="{{ old('tipo', $configuracao->tipo ?? '') === 'imagem' ? '' : 'display: none;' }}">
    <label for="imagem" class="form-label">Imagem</label>
    <input type="file" class="form-control @error('imagem') is-invalid @enderror" 
           id="imagem" name="imagem" accept="image/*">
    @error('imagem')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Formatos aceitos: JPG, PNG, GIF, SVG. Tamanho máximo: 2MB</div>
    
    @if(isset($configuracao) && $configuracao->tipo === 'imagem' && $configuracao->valor)
        <div class="mt-2">
            <label class="form-label">Imagem atual:</label>
            <div>
                <img src="{{ $configuracao->url_imagem }}" alt="{{ $configuracao->chave }}" 
                     class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
            </div>
        </div>
    @endif
</div>

<!-- Status -->
<div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" 
               {{ old('ativo', $configuracao->ativo ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="ativo">
            Ativo
        </label>
    </div>
    <div class="form-text">Configurações inativas não serão exibidas no site</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const campoValor = document.getElementById('campo-valor');
    const campoImagem = document.getElementById('campo-imagem');
    const valorInput = document.getElementById('valor');
    const imagemInput = document.getElementById('imagem');

    function toggleCampos() {
        const tipo = tipoSelect.value;
        
        if (tipo === 'imagem') {
            campoValor.style.display = 'none';
            campoImagem.style.display = 'block';
            valorInput.removeAttribute('required');
        } else {
            campoValor.style.display = 'block';
            campoImagem.style.display = 'none';
            valorInput.setAttribute('required', 'required');
        }
    }

    tipoSelect.addEventListener('change', toggleCampos);
    
    // Executar na inicialização
    toggleCampos();
});
</script>
@endpush