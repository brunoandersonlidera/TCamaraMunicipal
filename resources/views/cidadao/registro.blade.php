@extends('layouts.app')

@section('title', 'Cadastro de Cidadão')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4><i class="fas fa-user-plus"></i> Cadastro de Cidadão</h4>
                    <p class="mb-0">Cadastre-se para participar da iniciativa popular</p>
                    <p class="text-muted small mt-2">
                        Para criar um projeto de iniciativa popular, são necessárias pelo menos 
                        <strong>{{ number_format($minimo_assinaturas ?? 1000, 0, ',', '.') }} assinaturas</strong> de cidadãos eleitores do município.
                    </p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('cidadao.registro.post') }}" id="registroForm">
                        @csrf
                        
                        <!-- Dados Pessoais -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-user"></i> Dados Pessoais
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" 
                                       class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" 
                                       name="nome" 
                                       value="{{ old('nome') }}" 
                                       required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento *</label>
                                <input type="date" 
                                       class="form-control @error('data_nascimento') is-invalid @enderror" 
                                       id="data_nascimento" 
                                       name="data_nascimento" 
                                       value="{{ old('data_nascimento') }}" 
                                       required>
                                @error('data_nascimento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cpf" class="form-label">CPF *</label>
                                <input type="text" 
                                       class="form-control @error('cpf') is-invalid @enderror" 
                                       id="cpf" 
                                       name="cpf" 
                                       value="{{ old('cpf') }}" 
                                       placeholder="000.000.000-00"
                                       maxlength="14"
                                       required>
                                @error('cpf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rg" class="form-label">RG</label>
                                <input type="text" 
                                       class="form-control @error('rg') is-invalid @enderror" 
                                       id="rg" 
                                       name="rg" 
                                       value="{{ old('rg') }}">
                                @error('rg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-select @error('sexo') is-invalid @enderror" id="sexo" name="sexo">
                                    <option value="">Selecione</option>
                                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                                    <option value="O" {{ old('sexo') == 'O' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('sexo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="estado_civil" class="form-label">Estado Civil</label>
                                <select class="form-select @error('estado_civil') is-invalid @enderror" id="estado_civil" name="estado_civil">
                                    <option value="">Selecione</option>
                                    <option value="solteiro" {{ old('estado_civil') == 'solteiro' ? 'selected' : '' }}>Solteiro(a)</option>
                                    <option value="casado" {{ old('estado_civil') == 'casado' ? 'selected' : '' }}>Casado(a)</option>
                                    <option value="divorciado" {{ old('estado_civil') == 'divorciado' ? 'selected' : '' }}>Divorciado(a)</option>
                                    <option value="viuvo" {{ old('estado_civil') == 'viuvo' ? 'selected' : '' }}>Viúvo(a)</option>
                                    <option value="uniao_estavel" {{ old('estado_civil') == 'uniao_estavel' ? 'selected' : '' }}>União Estável</option>
                                </select>
                                @error('estado_civil')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="profissao" class="form-label">Profissão</label>
                                <input type="text" 
                                       class="form-control @error('profissao') is-invalid @enderror" 
                                       id="profissao" 
                                       name="profissao" 
                                       value="{{ old('profissao') }}">
                                @error('profissao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contato -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                                    <i class="fas fa-phone"></i> Contato
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" 
                                       class="form-control @error('telefone') is-invalid @enderror" 
                                       id="telefone" 
                                       name="telefone" 
                                       value="{{ old('telefone') }}" 
                                       placeholder="(00) 0000-0000">
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="text" 
                                       class="form-control @error('celular') is-invalid @enderror" 
                                       id="celular" 
                                       name="celular" 
                                       value="{{ old('celular') }}" 
                                       placeholder="(00) 00000-0000">
                                @error('celular')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                                    <i class="fas fa-map-marker-alt"></i> Endereço
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cep" class="form-label">CEP *</label>
                                <input type="text" 
                                       class="form-control @error('cep') is-invalid @enderror" 
                                       id="cep" 
                                       name="cep" 
                                       value="{{ old('cep') }}" 
                                       placeholder="00000-000"
                                       maxlength="9"
                                       required>
                                @error('cep')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="endereco" class="form-label">Endereço *</label>
                                <input type="text" 
                                       class="form-control @error('endereco') is-invalid @enderror" 
                                       id="endereco" 
                                       name="endereco" 
                                       value="{{ old('endereco') }}" 
                                       required>
                                @error('endereco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="numero" class="form-label">Número *</label>
                                <input type="text" 
                                       class="form-control @error('numero') is-invalid @enderror" 
                                       id="numero" 
                                       name="numero" 
                                       value="{{ old('numero') }}" 
                                       required>
                                @error('numero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" 
                                       class="form-control @error('complemento') is-invalid @enderror" 
                                       id="complemento" 
                                       name="complemento" 
                                       value="{{ old('complemento') }}">
                                @error('complemento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bairro" class="form-label">Bairro *</label>
                                <input type="text" 
                                       class="form-control @error('bairro') is-invalid @enderror" 
                                       id="bairro" 
                                       name="bairro" 
                                       value="{{ old('bairro') }}" 
                                       required>
                                @error('bairro')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cidade" class="form-label">Cidade *</label>
                                <input type="text" 
                                       class="form-control @error('cidade') is-invalid @enderror" 
                                       id="cidade" 
                                       name="cidade" 
                                       value="{{ old('cidade') }}" 
                                       required>
                                @error('cidade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dados Eleitorais -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                                    <i class="fas fa-vote-yea"></i> Dados Eleitorais
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titulo_eleitor" class="form-label">Título de Eleitor *</label>
                                <input type="text" 
                                       class="form-control @error('titulo_eleitor') is-invalid @enderror" 
                                       id="titulo_eleitor" 
                                       name="titulo_eleitor" 
                                       value="{{ old('titulo_eleitor') }}" 
                                       required>
                                @error('titulo_eleitor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zona_eleitoral" class="form-label">Zona Eleitoral *</label>
                                <input type="text" 
                                       class="form-control @error('zona_eleitoral') is-invalid @enderror" 
                                       id="zona_eleitoral" 
                                       name="zona_eleitoral" 
                                       value="{{ old('zona_eleitoral') }}" 
                                       required>
                                @error('zona_eleitoral')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="secao_eleitoral" class="form-label">Seção Eleitoral *</label>
                                <input type="text" 
                                       class="form-control @error('secao_eleitoral') is-invalid @enderror" 
                                       id="secao_eleitoral" 
                                       name="secao_eleitoral" 
                                       value="{{ old('secao_eleitoral') }}" 
                                       required>
                                @error('secao_eleitoral')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Senha -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                                    <i class="fas fa-lock"></i> Senha de Acesso
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Senha *</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Mínimo de 8 caracteres</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Senha *</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>

                        <!-- Termos -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mb-3">
                                    <input type="checkbox" 
                                           class="form-check-input @error('aceite_termos') is-invalid @enderror" 
                                           id="aceite_termos" 
                                           name="aceite_termos" 
                                           value="1" 
                                           {{ old('aceite_termos') ? 'checked' : '' }} 
                                           required>
                                    <label class="form-check-label" for="aceite_termos">
                                        Aceito os <a href="#" target="_blank">Termos de Uso</a> *
                                    </label>
                                    @error('aceite_termos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check mb-4">
                                    <input type="checkbox" 
                                           class="form-check-input @error('aceite_lgpd') is-invalid @enderror" 
                                           id="aceite_lgpd" 
                                           name="aceite_lgpd" 
                                           value="1" 
                                           {{ old('aceite_lgpd') ? 'checked' : '' }} 
                                           required>
                                    <label class="form-check-label" for="aceite_lgpd">
                                        Aceito a <a href="#" target="_blank">Política de Privacidade</a> (LGPD) *
                                    </label>
                                    @error('aceite_lgpd')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus"></i> Cadastrar
                            </button>
                        </div>
                    </form>

                    <hr>
                    
                    <div class="text-center">
                        <p class="mb-2">Já tem uma conta?</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt"></i> Fazer Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscaras para campos
    const cpfInput = document.getElementById('cpf');
    const cepInput = document.getElementById('cep');
    const telefoneInput = document.getElementById('telefone');
    const celularInput = document.getElementById('celular');

    // Máscara CPF
    cpfInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    });

    // Máscara CEP
    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    });

    // Máscara Telefone
    telefoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
        e.target.value = value;
    });

    // Máscara Celular
    celularInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    });

    // Buscar CEP
    cepInput.addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('endereco').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                    }
                })
                .catch(error => console.log('Erro ao buscar CEP:', error));
        }
    });
});
</script>
@endsection