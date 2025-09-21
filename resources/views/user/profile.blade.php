@extends('layouts.app')

@section('title', 'Meu Perfil')

@push('styles')
<style>
    .profile-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .profile-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2.5rem;
    }
    
    .profile-body {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    .password-section {
        border-top: 1px solid #e9ecef;
        margin-top: 2rem;
        padding-top: 2rem;
    }
    
    .section-title {
        color: #333;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }
    
    .info-text {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .password-requirements {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    
    .password-requirements ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    
    .password-requirements li {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="profile-page">
    <div class="profile-container">
        <div class="profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="mb-1">{{ auth()->user()->name }}</h2>
                <p class="mb-0 opacity-75">{{ auth()->user()->email }}</p>
            </div>

            <!-- Profile Body -->
            <div class="profile-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Erro:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Profile Form -->
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="section-title">
                        <i class="fas fa-user-edit"></i>
                        Informações Pessoais
                    </h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}" 
                                       placeholder="(00) 00000-0000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birth_date" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" 
                                       value="{{ old('birth_date', auth()->user()->birth_date) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Endereço</label>
                        <textarea class="form-control" id="address" name="address" rows="3" 
                                  placeholder="Rua, número, bairro, cidade">{{ old('address', auth()->user()->address) }}</textarea>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>
                            Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>

                <!-- Password Change Section -->
                <div class="password-section">
                    <h3 class="section-title">
                        <i class="fas fa-lock"></i>
                        Alterar Senha
                    </h3>
                    
                    <p class="info-text">
                        Para sua segurança, você precisa informar sua senha atual para definir uma nova senha.
                    </p>

                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control" id="current_password" 
                                   name="current_password" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control" id="password" 
                                           name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="password-requirements">
                            <strong>Requisitos da senha:</strong>
                            <ul>
                                <li>Mínimo de 8 caracteres</li>
                                <li>Pelo menos uma letra maiúscula</li>
                                <li>Pelo menos uma letra minúscula</li>
                                <li>Pelo menos um número</li>
                                <li>Pelo menos um caractere especial (!@#$%^&*)</li>
                            </ul>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-1"></i>
                                Alterar Senha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para telefone
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                if (value.length < 14) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = value;
            }
        });
    }
});
</script>
@endsection