@extends('layouts.app')

@section('title', 'Ouvidoria - Nova Solicitação')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-bullhorn me-2"></i>
                        Ouvidoria Municipal
                    </h4>
                    <p class="mb-0 mt-2">Envie sua reclamação, sugestão ou elogio</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('ouvidoria.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">
                                    <i class="fas fa-tag me-1"></i>
                                    Tipo de Solicitação *
                                </label>
                                <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="reclamacao" {{ old('tipo') == 'reclamacao' ? 'selected' : '' }}>
                                        Reclamação
                                    </option>
                                    <option value="sugestao" {{ old('tipo') == 'sugestao' ? 'selected' : '' }}>
                                        Sugestão
                                    </option>
                                    <option value="elogio" {{ old('tipo') == 'elogio' ? 'selected' : '' }}>
                                        Elogio
                                    </option>
                                    <option value="denuncia" {{ old('tipo') == 'denuncia' ? 'selected' : '' }}>
                                        Denúncia
                                    </option>
                                    <option value="informacao" {{ old('tipo') == 'informacao' ? 'selected' : '' }}>
                                        Solicitação de Informação
                                    </option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">
                                    <i class="fas fa-folder me-1"></i>
                                    Categoria *
                                </label>
                                <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                    <option value="">Selecione a categoria</option>
                                    <option value="saude" {{ old('categoria') == 'saude' ? 'selected' : '' }}>
                                        Saúde
                                    </option>
                                    <option value="educacao" {{ old('categoria') == 'educacao' ? 'selected' : '' }}>
                                        Educação
                                    </option>
                                    <option value="infraestrutura" {{ old('categoria') == 'infraestrutura' ? 'selected' : '' }}>
                                        Infraestrutura
                                    </option>
                                    <option value="transporte" {{ old('categoria') == 'transporte' ? 'selected' : '' }}>
                                        Transporte
                                    </option>
                                    <option value="meio_ambiente" {{ old('categoria') == 'meio_ambiente' ? 'selected' : '' }}>
                                        Meio Ambiente
                                    </option>
                                    <option value="seguranca" {{ old('categoria') == 'seguranca' ? 'selected' : '' }}>
                                        Segurança
                                    </option>
                                    <option value="assistencia_social" {{ old('categoria') == 'assistencia_social' ? 'selected' : '' }}>
                                        Assistência Social
                                    </option>
                                    <option value="administracao" {{ old('categoria') == 'administracao' ? 'selected' : '' }}>
                                        Administração Pública
                                    </option>
                                    <option value="outros" {{ old('categoria') == 'outros' ? 'selected' : '' }}>
                                        Outros
                                    </option>
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="assunto" class="form-label">
                                <i class="fas fa-heading me-1"></i>
                                Assunto *
                            </label>
                            <input type="text" 
                                   class="form-control @error('assunto') is-invalid @enderror" 
                                   id="assunto" 
                                   name="assunto" 
                                   value="{{ old('assunto') }}"
                                   placeholder="Descreva brevemente o assunto"
                                   maxlength="200"
                                   required>
                            @error('assunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Máximo 200 caracteres</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descricao" class="form-label">
                                <i class="fas fa-align-left me-1"></i>
                                Descrição Detalhada *
                            </label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" 
                                      name="descricao" 
                                      rows="6"
                                      placeholder="Descreva detalhadamente sua solicitação..."
                                      maxlength="2000"
                                      required>{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Máximo 2000 caracteres</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="localizacao" class="form-label">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Localização (opcional)
                            </label>
                            <input type="text" 
                                   class="form-control @error('localizacao') is-invalid @enderror" 
                                   id="localizacao" 
                                   name="localizacao" 
                                   value="{{ old('localizacao') }}"
                                   placeholder="Endereço, bairro ou ponto de referência">
                            @error('localizacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-images me-1"></i>
                                Anexar Imagens (opcional)
                            </label>
                            <p class="text-muted small mb-3">
                                Adicione fotos que possam ajudar a ilustrar sua solicitação
                            </p>
                            
                            <x-image-upload 
                                name="anexos"
                                :multiple="true"
                                :max-files="5"
                                label="Selecionar Imagens"
                                help-text="Máximo 5 imagens. Formatos: JPG, PNG, GIF. Tamanho máximo: 5MB por imagem"
                                :preview="true"
                                :required="false"
                            />
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3">
                            <i class="fas fa-user me-2"></i>
                            Dados para Contato
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">
                                    Nome Completo *
                                </label>
                                <input type="text" 
                                       class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" 
                                       name="nome" 
                                       value="{{ old('nome', auth()->user()->name ?? '') }}"
                                       required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    E-mail *
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">
                                    Telefone (opcional)
                                </label>
                                <input type="tel" 
                                       class="form-control @error('telefone') is-invalid @enderror" 
                                       id="telefone" 
                                       name="telefone" 
                                       value="{{ old('telefone', auth()->user()->phone ?? '') }}"
                                       placeholder="(00) 00000-0000">
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="anonimo" 
                                           name="anonimo" 
                                           value="1"
                                           {{ old('anonimo') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anonimo">
                                        Enviar de forma anônima
                                    </label>
                                    <div class="form-text">
                                        Seus dados não serão divulgados publicamente
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('aceito_termos') is-invalid @enderror" 
                                       type="checkbox" 
                                       id="aceito_termos" 
                                       name="aceito_termos" 
                                       value="1"
                                       {{ old('aceito_termos') ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="aceito_termos">
                                    Aceito os <a href="#" data-bs-toggle="modal" data-bs-target="#termosModal">termos de uso</a> 
                                    e autorizo o tratamento dos meus dados *
                                </label>
                                @error('aceito_termos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i>
                                Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>
                                Enviar Solicitação
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Termos -->
<div class="modal fade" id="termosModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Termos de Uso - Ouvidoria Municipal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>1. Finalidade</h6>
                <p>A Ouvidoria Municipal tem como finalidade receber, analisar e encaminhar manifestações dos cidadãos sobre os serviços públicos municipais.</p>
                
                <h6>2. Tratamento de Dados</h6>
                <p>Os dados pessoais fornecidos serão utilizados exclusivamente para:</p>
                <ul>
                    <li>Análise e encaminhamento da manifestação</li>
                    <li>Comunicação sobre o andamento do processo</li>
                    <li>Estatísticas internas (dados anonimizados)</li>
                </ul>
                
                <h6>3. Confidencialidade</h6>
                <p>Garantimos a confidencialidade dos dados pessoais e o sigilo das informações, exceto quando a divulgação for necessária para o atendimento da manifestação.</p>
                
                <h6>4. Prazo de Resposta</h6>
                <p>O prazo para resposta é de até 30 dias úteis, podendo ser prorrogado por igual período mediante justificativa.</p>
                
                <h6>5. Responsabilidade</h6>
                <p>O manifestante é responsável pela veracidade das informações prestadas.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus,
.form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-1px);
}

.btn-outline-secondary {
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.modal-content {
    border-radius: 15px;
}

.modal-header {
    background-color: #f8f9fa;
    border-radius: 15px 15px 0 0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                if (value.length < 14) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
            }
            e.target.value = value;
        });
    }
    
    // Contador de caracteres
    const assuntoInput = document.getElementById('assunto');
    const descricaoTextarea = document.getElementById('descricao');
    
    function addCharacterCounter(element, maxLength) {
        const counter = document.createElement('div');
        counter.className = 'form-text text-end';
        counter.style.fontSize = '0.875rem';
        element.parentNode.appendChild(counter);
        
        function updateCounter() {
            const remaining = maxLength - element.value.length;
            counter.textContent = `${element.value.length}/${maxLength} caracteres`;
            counter.className = remaining < 50 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
        }
        
        element.addEventListener('input', updateCounter);
        updateCounter();
    }
    
    if (assuntoInput) addCharacterCounter(assuntoInput, 200);
    if (descricaoTextarea) addCharacterCounter(descricaoTextarea, 2000);
    
    // Checkbox anônimo
    const anonimoCheckbox = document.getElementById('anonimo');
    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const telefoneInputMask = document.getElementById('telefone');
    
    if (anonimoCheckbox) {
        anonimoCheckbox.addEventListener('change', function() {
            if (this.checked) {
                nomeInput.value = '';
                emailInput.value = '';
                telefoneInputMask.value = '';
                nomeInput.disabled = true;
                emailInput.disabled = true;
                telefoneInputMask.disabled = true;
            } else {
                nomeInput.disabled = false;
                emailInput.disabled = false;
                telefoneInputMask.disabled = false;
            }
        });
    }
});
</script>
@endpush