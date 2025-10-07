@extends('layouts.app')

@section('title', 'Cadastro de Cidadão')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Cadastro de Cidadão
                    </h4>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-4">
                        Crie sua conta de cidadão para acessar os serviços da Câmara Municipal.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nome_completo" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Nome Completo <span class="text-danger">*</span>
                                </label>
                                <input id="nome_completo" type="text" 
                                       class="form-control @error('nome_completo') is-invalid @enderror" 
                                       name="nome_completo" value="{{ old('nome_completo') }}" 
                                       required autocomplete="name" autofocus
                                       placeholder="Digite seu nome completo">
                                @error('nome_completo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cpf" class="form-label">
                                    <i class="fas fa-id-card me-1"></i>
                                    CPF <span class="text-danger">*</span>
                                </label>
                                <input id="cpf" type="text" 
                                       class="form-control @error('cpf') is-invalid @enderror" 
                                       name="cpf" value="{{ old('cpf') }}" 
                                       required autocomplete="off"
                                       placeholder="000.000.000-00"
                                       maxlength="14">
                                @error('cpf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="data_nascimento" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Data de Nascimento <span class="text-danger">*</span>
                                </label>
                                <input id="data_nascimento" type="date" 
                                       class="form-control @error('data_nascimento') is-invalid @enderror" 
                                       name="data_nascimento" value="{{ old('data_nascimento') }}" 
                                       required autocomplete="bday">
                                @error('data_nascimento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sexo" class="form-label">
                                    <i class="fas fa-venus-mars me-1"></i>
                                    Sexo <span class="text-danger">*</span>
                                </label>
                                <select id="sexo" class="form-select @error('sexo') is-invalid @enderror" 
                                        name="sexo" required>
                                    <option value="">Selecione...</option>
                                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                                </select>
                                @error('sexo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">
                                    <i class="fas fa-mobile-alt me-1"></i>
                                    Celular <span class="text-danger">*</span>
                                </label>
                                <input id="celular" type="text" 
                                       class="form-control @error('celular') is-invalid @enderror" 
                                       name="celular" value="{{ old('celular') }}" 
                                       required autocomplete="tel"
                                       placeholder="(00) 00000-0000">
                                @error('celular')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Telefone (opcional)
                                </label>
                                <input id="telefone" type="text" 
                                       class="form-control @error('telefone') is-invalid @enderror" 
                                       name="telefone" value="{{ old('telefone') }}" 
                                       autocomplete="tel"
                                       placeholder="(00) 0000-0000">
                                @error('telefone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    E-mail <span class="text-danger">*</span>
                                </label>
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email"
                                       placeholder="Digite seu e-mail">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Senha <span class="text-danger">*</span>
                                </label>
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="Digite sua senha">
                                <small class="form-text text-muted">
                                    Mínimo de 8 caracteres
                                </small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Confirmar Senha <span class="text-danger">*</span>
                                </label>
                                <input id="password-confirm" type="password" 
                                       class="form-control" name="password_confirmation" 
                                       required autocomplete="new-password"
                                       placeholder="Confirme sua senha">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror" 
                                       type="checkbox" value="1" id="terms" name="terms" 
                                       {{ old('terms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="terms">
                                    Li e aceito os 
                                    <a href="{{ route('terms') }}" target="_blank" class="text-primary">
                                        Termos de Uso
                                    </a>
                                    <span class="text-danger">*</span>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('privacy') is-invalid @enderror" 
                                       type="checkbox" value="1" id="privacy" name="privacy"
                                       {{ old('privacy') ? 'checked' : '' }}>
                                <label class="form-check-label" for="privacy">
                                    Li e aceito a 
                                    <a href="{{ route('privacy') }}" target="_blank" class="text-primary">
                                        Política de Privacidade
                                    </a>
                                    <span class="text-danger">*</span>
                                </label>
                                @error('privacy')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>
                                Criar Conta
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="mb-0">
                                Já possui uma conta? 
                                <a href="{{ route('login') }}" class="text-primary">
                                    Faça login aqui
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.text-primary {
    color: #0d6efd !important;
}

.text-primary:hover {
    color: #0b5ed7 !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    }

    // Máscara para Celular
    const celularInput = document.getElementById('celular');
    if (celularInput) {
        celularInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });
    }

    // Máscara para Telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = value;
        });
    }

    // Validação de CPF
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
        
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let resto = 11 - (soma % 11);
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(9))) return false;
        
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        if (resto === 10 || resto === 11) resto = 0;
        return resto === parseInt(cpf.charAt(10));
    }

    // Validação em tempo real do CPF
    if (cpfInput) {
        cpfInput.addEventListener('blur', function(e) {
            const cpf = e.target.value;
            if (cpf && !validarCPF(cpf)) {
                e.target.classList.add('is-invalid');
                let feedback = e.target.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    e.target.parentNode.appendChild(feedback);
                }
                feedback.textContent = 'CPF inválido';
            } else {
                e.target.classList.remove('is-invalid');
                const feedback = e.target.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.remove();
                }
            }
        });
    }
});
</script>
@endpush