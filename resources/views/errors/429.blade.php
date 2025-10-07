@extends('layouts.app')

@section('title', 'Muitas requisições (429)')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                <h1 class="h3 mt-3">Muitas tentativas em pouco tempo</h1>
                <p class="text-muted">Por favor, aguarde alguns instantes e tente novamente. Isso ajuda a manter o sistema estável e seguro.</p>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-1"></i> Página inicial
                </a>
                <a href="{{ route('paginas.contato') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-envelope me-1"></i> Fale conosco
                </a>
            </div>
        </div>
    </div>
</div>
@endsection