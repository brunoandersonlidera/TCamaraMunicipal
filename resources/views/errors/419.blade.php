@extends('layouts.app')

@section('title', 'Sessão expirada (419)')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <i class="fas fa-hourglass-end text-warning" style="font-size: 4rem;"></i>
                <h1 class="h3 mt-3">Sua sessão expirou</h1>
                <p class="text-muted">Por segurança, sua sessão foi encerrada. Atualize a página ou faça login novamente.</p>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                    <i class="fas fa-redo me-1"></i> Atualizar a página
                </a>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-1"></i> Fazer login
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home me-1"></i> Página inicial
                </a>
            </div>
        </div>
    </div>
</div>
@endsection