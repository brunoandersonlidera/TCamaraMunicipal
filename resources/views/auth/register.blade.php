@extends('layouts.app')

@section('title', 'Cadastro de Usuário')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Cadastro de Usuário
                    </h4>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-4">
                        Crie sua conta para acessar os serviços da Câmara Municipal.
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
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Nome Completo <span class="text-danger">*</span>
                                </label>
                                <input id="name" type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" 
                                       required autocomplete="name" autofocus
                                       placeholder="Digite seu nome completo">
                                @error('name')
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