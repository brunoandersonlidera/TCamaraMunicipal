@extends('layouts.app')

@section('title', 'Redefinir Senha - Câmara Municipal')

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
        background: linear-gradient(135deg, #10b981, #059669);
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
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        background-color: white;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    
    .btn-reset {
        background: linear-gradient(135deg, #10b981, #059669);
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
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        background: linear-gradient(135deg, #059669, #047857);
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
    
    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    
    .password-requirements {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    
    .password-requirements h6 {
        color: #0c4a6e;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .password-requirements ul {
        margin: 0;
        padding-left: 1.2rem;
        color: #0369a1;
    }
    
    .password-requirements li {
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="reset-container">
    <div class="reset-card">
        <div class="reset-icon">
            <i class="fas fa-lock"></i>
        </div>
        
        <h1 class="reset-title">Nova Senha</h1>
        <p class="reset-subtitle">
            Digite sua nova senha para concluir a recuperação
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="password-requirements">
            <h6><i class="fas fa-shield-alt me-2"></i>Requisitos da senha:</h6>
            <ul>
                <li>Mínimo de 8 caracteres</li>
                <li>Recomendado: letras maiúsculas e minúsculas</li>
                <li>Recomendado: números e símbolos</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ request('email') ?? old('email') }}"
                       placeholder="Digite seu email"
                       required 
                       autocomplete="email">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Digite sua nova senha"
                       required 
                       autocomplete="new-password">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Confirme sua nova senha"
                       required 
                       autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-reset mb-3">
                <i class="fas fa-check me-2"></i>
                Redefinir Senha
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="back-link">
                    <i class="fas fa-arrow-left me-1"></i>
                    Voltar ao login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection