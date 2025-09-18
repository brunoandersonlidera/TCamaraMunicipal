@extends('layouts.app')

@section('title', 'Login - Câmara Municipal')

@section('content')
<style>
    .login-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .login-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        padding: 3rem;
        width: 100%;
        max-width: 400px;
    }
    
    .login-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
    }
    
    .login-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .login-title {
        text-align: center;
        color: var(--text-dark);
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        text-align: center;
        color: var(--text-muted);
        margin-bottom: 2rem;
    }
    
    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
    }
    
    .btn-login {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);
        color: white;
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    .alert-custom {
        border: none;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        background-color: #fef2f2;
        border-left: 4px solid #dc2626;
    }
    
    .back-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .back-link:hover {
        color: var(--primary-dark);
        text-decoration: none;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-icon">
            <i class="fas fa-lock"></i>
        </div>
        
        <h2 class="login-title">Acesso Administrativo</h2>
        <p class="login-subtitle">Sistema da Câmara Municipal</p>

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

            <div class="mb-3 form-check">
                <input type="checkbox" 
                       class="form-check-input" 
                       id="remember" 
                       name="remember">
                <label class="form-check-label" for="remember">
                    Lembrar-me
                </label>
            </div>

            <button type="submit" class="btn btn-login mb-3">
                <i class="fas fa-sign-in-alt me-2"></i>
                Entrar
            </button>

            <div class="text-center">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left me-1"></i>
                    Voltar ao site
                </a>
            </div>
        </form>
    </div>
</div>
@endsection