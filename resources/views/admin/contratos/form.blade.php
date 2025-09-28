<!-- Informações Básicas -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="numero" class="required">Número do Contrato</label>
            <input type="text" 
                   class="form-control @error('numero') is-invalid @enderror" 
                   id="numero" 
                   name="numero" 
                   value="{{ old('numero', $contrato->numero ?? '') }}" 
                   maxlength="50"
                   required>
            @error('numero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tipo_contrato_id" class="required">Tipo de Contrato</label>
            <select class="form-control @error('tipo_contrato_id') is-invalid @enderror" 
                    id="tipo_contrato_id" 
                    name="tipo_contrato_id" 
                    required>
                <option value="">Selecione um tipo</option>
                @foreach($tiposContrato as $tipo)
                    <option value="{{ $tipo->id }}" 
                            {{ old('tipo_contrato_id', $contrato->tipo_contrato_id ?? '') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nome }}
                    </option>
                @endforeach
            </select>
            @error('tipo_contrato_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="objeto" class="required">Objeto do Contrato</label>
    <textarea class="form-control @error('objeto') is-invalid @enderror" 
              id="objeto" 
              name="objeto" 
              rows="3" 
              maxlength="1000"
              required>{{ old('objeto', $contrato->objeto ?? '') }}</textarea>
    <small class="form-text text-muted">
        <span id="objeto-count">0</span>/1000 caracteres
    </small>
    @error('objeto')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Dados do Contratado -->
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="contratado" class="required">Contratado</label>
            <input type="text" 
                   class="form-control @error('contratado') is-invalid @enderror" 
                   id="contratado" 
                   name="contratado" 
                   value="{{ old('contratado', $contrato->contratado ?? '') }}" 
                   maxlength="200"
                   required>
            @error('contratado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="cnpj_cpf">CNPJ/CPF</label>
            <input type="text" 
                   class="form-control @error('cnpj_cpf') is-invalid @enderror" 
                   id="cnpj_cpf" 
                   name="cnpj_cpf" 
                   value="{{ old('cnpj_cpf', $contrato->cnpj_cpf ?? '') }}" 
                   maxlength="18">
            @error('cnpj_cpf')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Valores -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="valor_inicial" class="required">Valor Inicial</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="text" 
                       class="form-control money @error('valor_inicial') is-invalid @enderror" 
                       id="valor_inicial" 
                       name="valor_inicial" 
                       value="{{ old('valor_inicial', isset($contrato) ? number_format($contrato->valor_inicial, 2, ',', '.') : '') }}" 
                       required>
                @error('valor_inicial')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="valor_atual">Valor Atual</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="text" 
                       class="form-control money @error('valor_atual') is-invalid @enderror" 
                       id="valor_atual" 
                       name="valor_atual" 
                       value="{{ old('valor_atual', isset($contrato) ? number_format($contrato->valor_atual, 2, ',', '.') : '') }}">
                @error('valor_atual')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <small class="form-text text-muted">Deixe em branco para usar o valor inicial</small>
        </div>
    </div>
</div>

<!-- Datas -->
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="data_assinatura" class="required">Data de Assinatura</label>
            <input type="date" 
                   class="form-control @error('data_assinatura') is-invalid @enderror" 
                   id="data_assinatura" 
                   name="data_assinatura" 
                   value="{{ old('data_assinatura', isset($contrato) ? $contrato->data_assinatura->format('Y-m-d') : '') }}" 
                   required>
            @error('data_assinatura')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="data_inicio" class="required">Início da Vigência</label>
            <input type="date" 
                   class="form-control @error('data_inicio') is-invalid @enderror" 
                   id="data_inicio" 
                   name="data_inicio" 
                   value="{{ old('data_inicio', isset($contrato) && $contrato->data_inicio ? $contrato->data_inicio->format('Y-m-d') : '') }}" 
                   required>
            @error('data_inicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="data_fim" class="required">Fim da Vigência</label>
            <input type="date" 
                   class="form-control @error('data_fim') is-invalid @enderror" 
                   id="data_fim" 
                   name="data_fim" 
                   value="{{ old('data_fim', isset($contrato) && $contrato->data_fim ? $contrato->data_fim->format('Y-m-d') : '') }}" 
                   required>
            @error('data_fim')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Arquivo do Contrato -->
<div class="form-group">
    <label for="arquivo_contrato">Arquivo do Contrato</label>
    <input type="file" 
           class="form-control-file @error('arquivo_contrato') is-invalid @enderror" 
           id="arquivo_contrato" 
           name="arquivo_contrato" 
           accept=".pdf,.doc,.docx">
    @if(isset($contrato) && $contrato->arquivo_contrato)
        <div class="mt-2">
            <small class="text-muted">
                Arquivo atual: 
                <a href="{{ route('admin.contratos.download', $contrato) }}" target="_blank">
                    {{ $contrato->arquivo_original }}
                </a>
                <button type="button" 
                        class="btn btn-sm btn-outline-danger ml-2" 
                        onclick="removeFile()">
                    <i class="fas fa-trash"></i> Remover
                </button>
            </small>
        </div>
    @endif
    <small class="form-text text-muted">Formatos aceitos: PDF, DOC, DOCX. Tamanho máximo: 10MB</small>
    @error('arquivo_contrato')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Observações -->
<div class="form-group">
    <label for="observacoes">Observações</label>
    <textarea class="form-control @error('observacoes') is-invalid @enderror" 
              id="observacoes" 
              name="observacoes" 
              rows="3" 
              maxlength="1000">{{ old('observacoes', $contrato->observacoes ?? '') }}</textarea>
    <small class="form-text text-muted">
        <span id="observacoes-count">0</span>/1000 caracteres
    </small>
    @error('observacoes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Status -->
<div class="form-group">
    <div class="custom-control custom-switch">
        <input type="checkbox" 
               class="custom-control-input" 
               id="publico" 
               name="publico" 
               value="1" 
               {{ old('publico', $contrato->publico ?? false) ? 'checked' : '' }}>
        <label class="custom-control-label" for="publico">
            <strong>Contrato Público</strong>
            <small class="text-muted d-block">Marque para exibir este contrato no portal de transparência</small>
        </label>
    </div>
</div>

@if(isset($contrato))
<!-- Informações Adicionais (apenas na edição) -->
<hr>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>ID</label>
            <input type="text" class="form-control" value="{{ $contrato->id }}" readonly>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Criado em</label>
            <input type="text" class="form-control" value="{{ $contrato->created_at ? $contrato->created_at->format('d/m/Y H:i') : 'N/A' }}" readonly>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Atualizado em</label>
            <input type="text" class="form-control" value="{{ $contrato->updated_at ? $contrato->updated_at->format('d/m/Y H:i') : 'N/A' }}" readonly>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Status</label>
            <input type="text" 
                   class="form-control" 
                   value="{{ $contrato->isVencido() ? 'Vencido' : 'Ativo' }}" 
                   readonly>
        </div>
    </div>
</div>

<!-- Estatísticas -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Aditivos</label>
            <input type="text" class="form-control" value="{{ $contrato->aditivos->count() }}" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Fiscalizações</label>
            <input type="text" class="form-control" value="{{ $contrato->fiscalizacoes->count() }}" readonly>
        </div>
    </div>
</div>
@endif

<!-- Campo hidden para remoção de arquivo -->
<input type="hidden" id="remove_file" name="remove_file" value="0">

@push('scripts')
<script>
$(document).ready(function() {
    // Contador de caracteres
    function updateCharCount(textareaId, countId) {
        const textarea = document.getElementById(textareaId);
        const counter = document.getElementById(countId);
        if (textarea && counter) {
            counter.textContent = textarea.value.length;
            textarea.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }
    }
    
    updateCharCount('objeto', 'objeto-count');
    updateCharCount('observacoes', 'observacoes-count');
    
    // Máscara para valores monetários
    $('.money').mask('#.##0,00', {
        reverse: true,
        translation: {
            '#': {pattern: /[0-9]/}
        }
    });
    
    // Máscara para CNPJ/CPF
    $('#cnpj_cpf').mask('00.000.000/0000-00', {
        translation: {
            '0': {pattern: /[0-9]/}
        },
        onKeyPress: function(val, e, field, options) {
            var mask = val.length > 14 ? '00.000.000/0000-00' : '000.000.000-00';
            field.mask(mask, options);
        }
    });
});

function removeFile() {
    if (confirm('Tem certeza que deseja remover o arquivo atual?')) {
        document.getElementById('remove_file').value = '1';
        document.querySelector('input[name="arquivo_contrato"]').required = true;
        alert('O arquivo será removido ao salvar o contrato. Você deve fazer upload de um novo arquivo.');
    }
}
</script>
@endpush

@push('styles')
<style>
.required::after {
    content: " *";
    color: red;
}

.form-group label.required {
    font-weight: 600;
}

.custom-control-label strong {
    color: #495057;
}
</style>
@endpush