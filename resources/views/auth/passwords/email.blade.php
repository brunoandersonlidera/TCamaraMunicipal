@extends('layouts.app')

@section('title', 'Recuperar Senha - Câmara Municipal')

@push('styles')
<style>
    .reset-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .reset-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        padding: 3rem;
        width: 100%;
        max-width: 450px;
    }
    
    .reset-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
    }
    
    .reset-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .reset-title {
        text-align: center;
        color: var(--text-dark);
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .reset-subtitle {
        text-align: center;
        color: var(--text-muted);
        margin-bottom: 2rem;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }
    
    .form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        background-color: white;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    
    .btn-reset {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        border-radius: 0.75rem;
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-reset:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        background: linear-gradient(135deg, #d97706, #b45309);
    }
    
    .back-link {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }
    
    .back-link:hover {
        color: var(--primary-color);
    }
    
    .alert {
        border-radius: 0.75rem;
        border: none;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    
    .info-box {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box i {
        color: #0284c7;
        margin-right: 0.5rem;
    }
    
    .info-box p {
        margin: 0;
        color: #0c4a6e;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="reset-container">
    <div class="reset-card">
        <div class="reset-icon">
            <i class="fas fa-key"></i>
        </div>
        
        <h1 class="reset-title">Recuperar Senha</h1>
        <p class="reset-subtitle">
            Digite seu email para receber um link de recuperação de senha
        </p>

        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <p>Você receberá um email com instruções para redefinir sua senha. O link será válido por 24 horas.</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       placeholder="Digite seu email cadastrado"
                       required 
                       autocomplete="email">
            </div>

            <button type="submit" class="btn btn-reset mb-3">
                <i class="fas fa-paper-plane me-2"></i>
                Enviar Link de Recuperação
            </button>

            <div class="text-center">
                <div class="mb-3">
                    <span class="text-muted">Lembrou da senha?</span>
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--primary-color);">
                        Fazer login
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