@extends('layouts.app')

@section('title', 'Erro interno do servidor (500)')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <i class="fas fa-tools text-danger" style="font-size: 4rem;"></i>
                <h1 class="h3 mt-3">Ocorreu um erro inesperado</h1>
                <p class="text-muted">Sentimos muito! Algo deu errado ao processar sua solicitação.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <p>Você pode tentar as opções abaixo:</p>
                    <ul class="text-muted">
                        <li>Voltar para a página inicial</li>
                        <li>Tentar novamente mais tarde</li>
                        <li>Se o problema persistir, entrar em contato com o suporte</li>
                    </ul>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-1"></i> Página inicial
                        </a>
                        <a href="{{ route('paginas.contato') }}" class="btn btn-primary">
                            <i class="fas fa-envelope me-1"></i> Fale conosco
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection