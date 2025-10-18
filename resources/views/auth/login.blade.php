@extends('layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .login-wrapper {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    
    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        border: none;
    }
    
    .login-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.5rem;
    }
    
    .login-body {
        padding: 2.5rem 2rem;
    }
    
    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 2rem;
        width: 100%;
    }
    
    .logo-container img {
        max-height: 100px;
        max-width: 250px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        display: block;
        margin: 0 auto;
    }
    
    .form-floating {
        margin-bottom: 1.5rem;
    }
    
    .form-floating .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem 0.75rem;
        height: auto;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .form-floating .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
    }
    
    .form-floating label {
        color: #6c757d;
        font-weight: 500;
    }
    
    .form-floating .input-group .form-control:not(:placeholder-shown) ~ label,
    .form-floating .input-group .form-control:focus ~ label {
        opacity: 0.65;
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    }
    
    .password-field-container {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .password-field-container .form-floating {
        margin-bottom: 0;
    }
    
    .password-field-container .form-floating label {
        z-index: 2;
        pointer-events: none;
    }
    
    .password-input {
        padding-right: 3rem !important;
    }
    
    .password-toggle-btn-absolute {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 3rem;
        border: 2px solid #e9ecef;
        border-left: none;
        border-radius: 0 12px 12px 0;
        background: #f8f9fa;
        color: #6c757d;
        transition: all 0.3s ease;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .password-toggle-btn-absolute:hover {
        background: #e9ecef;
        color: #495057;
    }
    
    .password-toggle-btn-absolute:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }
    
    .form-check {
        margin: 1.5rem 0;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .form-check-label {
        color: #495057;
        font-weight: 500;
    }
    
    .forgot-password {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .forgot-password:hover {
        color: #5a67d8;
        text-decoration: underline;
    }
    
    .login-footer {
        text-align: center;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
        margin-top: 1.5rem;
    }
    
    @media (max-width: 1200px) {
        .login-body {
            padding: 2rem 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .login-wrapper {
            padding: 1rem 0;
            min-height: calc(100vh - 150px);
        }
        
        .login-body {
            padding: 1.5rem 1rem;
        }
        
        .login-header {
            padding: 1.5rem 1rem;
        }
        
        .logo-container img {
            max-height: 80px;
            max-width: 200px;
        }
    }
    
    @media (max-width: 576px) {
        .login-wrapper {
            padding: 0.5rem 0;
        }
        
        .login-body {
            padding: 1rem 0.75rem;
        }
        
        .login-header {
            padding: 1rem 0.75rem;
        }
        
        .login-header h4 {
            font-size: 1.25rem;
        }
        
        .form-floating .form-control {
            padding: 0.875rem 0.75rem;
        }
        
        .password-input {
            padding-right: 2.5rem !important;
        }
        
        .password-toggle-btn-absolute {
            width: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-10">
                    <div class="card login-card">
                    <div class="card-header login-header">
                        <h4>Acesso ao Sistema</h4>
                        <p class="mb-0 opacity-75">Entre com suas credenciais</p>
                    </div>

                    <div class="card-body login-body">
                        @php
                            $logoLogin = \App\Models\ConfiguracaoGeral::obterLogoLogin();
                        @endphp
                        
                        @if($logoLogin)
                            <div class="logo-container">
                                <img src="{{ $logoLogin }}" alt="Logo" class="img-fluid">
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-floating">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Endereço de Email">
                                <label for="email">Endereço de Email</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="password-field-container">
                                <div class="form-floating">
                                    <input id="password" type="password" class="form-control password-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Senha">
                                    <label for="password">Senha</label>
                                </div>
                                <button class="btn password-toggle-btn-absolute" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Lembrar de Mim
                                </label>
                            </div>

                            <button type="submit" class="btn btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Entrar
                            </button>

                            @if (Route::has('password.request'))
                                <div class="login-footer">
                                    <a class="forgot-password" href="{{ route('password.request') }}">
                                        <i class="fas fa-key me-1"></i>
                                        Esqueceu sua Senha?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (togglePassword && passwordField && eyeIcon) {
        togglePassword.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    }
});
</script>
@endpush