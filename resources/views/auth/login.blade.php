@extends('layouts.app')

@section('title', 'Login - Câmara Municipal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/public-styles.css') }}">
@endpush

@section('content')

<div class="login-container">
    <div class="login-card">
        <div class="login-icon">
            <i class="fas fa-lock"></i>
        </div>
        
        <h2 class="login-title">Acesso ao Sistema</h2>
        <p class="login-subtitle">Câmara Municipal - Portal do Cidadão</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            @if ($errors->any())
                <div class="alert-custom">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle text-danger me-2 mt-1"></i>
                        <div>
                            <strong class="text-danger">Erro no login</strong>
                            <ul class="mb-0 mt-1 text-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       class="form-control" 
                       id="email" 
                       name="email" 
                       placeholder="Digite seu email"
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="email">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       placeholder="Digite sua senha"
                       required 
                       autocomplete="current-password">
            </div>

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input type="checkbox" 
                           class="form-check-input" 
                           id="remember" 
                           name="remember">
                    <label class="form-check-label" for="remember">
                        Lembrar-me
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: var(--primary-color); font-size: 0.9rem;">
                    Esqueci minha senha
                </a>
            </div>

            <button type="submit" class="btn btn-login mb-3">
                <i class="fas fa-sign-in-alt me-2"></i>
                Entrar
            </button>

            <div class="text-center">
                <div class="mb-3">
                    <span class="text-muted">Não tem uma conta?</span>
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--primary-color);">
                        Cadastre-se aqui
                    </a>
                </div>
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left me-1"></i>
                    Voltar ao site
                </a>
            </div>
        </form>
    </div>
</div>
@endsection