@extends('layouts.app')

@section('title', 'Cadastro Realizado com Sucesso')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>

                    <h2 class="text-success mb-3">Cadastro Realizado com Sucesso!</h2>
                    
                    <p class="lead mb-4">
                        Sua conta foi criada com sucesso. Para ativá-la, você precisa verificar seu e-mail.
                    </p>

                    <div class="alert alert-info">
                        <i class="fas fa-envelope me-2"></i>
                        <strong>Verifique seu e-mail:</strong><br>
                        Enviamos um link de verificação para <strong>{{ $email }}</strong>
                    </div>

                    <div class="mb-4">
                        <h5>Próximos passos:</h5>
                        <ol class="text-start">
                            <li>Acesse sua caixa de e-mail</li>
                            <li>Procure por um e-mail da Câmara Municipal</li>
                            <li>Clique no link de verificação</li>
                            <li>Faça login com suas credenciais</li>
                        </ol>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Não recebeu o e-mail?</strong><br>
                        Verifique sua caixa de spam ou 
                        <a href="{{ route('verification.resend') }}" class="alert-link">
                            clique aqui para reenviar
                        </a>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('login') }}" class="btn btn-primary me-md-2">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Ir para Login
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>
                            Voltar ao Início
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.text-success {
    color: #198754 !important;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffecb5;
    color: #664d03;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

ol {
    display: inline-block;
    text-align: left;
}
</style>
@endpush