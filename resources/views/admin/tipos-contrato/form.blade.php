<!-- Exibir erros de validação -->
@if ($errors->any())
    <div class="alert alert-danger">
        <h6><i class="fas fa-exclamation-triangle"></i> Erro de validação:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <!-- Nome -->
        <div class="form-group">
            <label for="nome" class="required">Nome do Tipo</label>
            <input type="text" 
                   class="form-control @error('nome') is-invalid @enderror" 
                   id="nome" 
                   name="nome" 
                   value="{{ old('nome', $tipoContrato->nome ?? '') }}" 
                   required 
                   maxlength="100"
                   placeholder="Ex: Prestação de Serviços, Fornecimento, Obra...">
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Nome que identifica o tipo de contrato (máximo 100 caracteres)
            </small>
        </div>

        <!-- Descrição -->
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                      id="descricao" 
                      name="descricao" 
                      rows="4"
                      maxlength="500"
                      placeholder="Descreva as características deste tipo de contrato...">{{ old('descricao', $tipoContrato->descricao ?? '') }}</textarea>
            @error('descricao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Descrição detalhada do tipo de contrato (máximo 500 caracteres)
            </small>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Status -->
        <div class="form-group">
            <label for="ativo">Status</label>
            <div class="custom-control custom-switch">
                <input type="checkbox" 
                       class="custom-control-input" 
                       id="ativo" 
                       name="ativo" 
                       value="1"
                       {{ old('ativo', $tipoContrato->ativo ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="ativo">
                    <span class="text-success">Ativo</span>
                </label>
            </div>
            <small class="form-text text-muted">
                Tipos inativos não aparecerão na criação de novos contratos
            </small>
        </div>

        <!-- Informações adicionais (apenas na edição) -->
        @if(isset($tipoContrato) && $tipoContrato->exists)
        <div class="card bg-light">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Informações
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>ID:</strong> {{ $tipoContrato->id }}<br>
                    <strong>Criado em:</strong> {{ $tipoContrato->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Atualizado em:</strong> {{ $tipoContrato->updated_at->format('d/m/Y H:i') }}<br>
                    <strong>Contratos:</strong> {{ $tipoContrato->contratos_count ?? 0 }}
                </small>
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.required::after {
    content: " *";
    color: red;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contador de caracteres para descrição
    const descricaoTextarea = document.getElementById('descricao');
    if (descricaoTextarea) {
        const maxLength = 500;
        const counter = document.createElement('small');
        counter.className = 'form-text text-muted text-right';
        counter.style.display = 'block';
        
        function updateCounter() {
            const remaining = maxLength - descricaoTextarea.value.length;
            counter.textContent = `${descricaoTextarea.value.length}/${maxLength} caracteres`;
            counter.className = remaining < 50 ? 'form-text text-warning text-right' : 'form-text text-muted text-right';
        }
        
        descricaoTextarea.addEventListener('input', updateCounter);
        descricaoTextarea.parentNode.appendChild(counter);
        updateCounter();
    }
});
</script>
@endpush