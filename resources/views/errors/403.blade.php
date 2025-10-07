@extends('layouts.app')

@section('title', 'Acesso negado (403)')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <i class="fas fa-ban text-danger" style="font-size: 4rem;"></i>
                <h1 class="h3 mt-3">Você não tem permissão para acessar esta página</h1>
                <p class="text-muted">Se você acredita que isso é um engano, tente fazer login novamente ou contate o suporte.</p>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-1"></i> Página inicial
                </a>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-1"></i> Fazer login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection