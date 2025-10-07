@extends('layouts.app')

@section('title', 'Página não encontrada (404)')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <i class="fas fa-search-minus text-muted" style="font-size: 4rem;"></i>
                <h1 class="h3 mt-3">Página não encontrada</h1>
                <p class="text-muted">A página que você tentou acessar não existe ou foi movida.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Que tal tentar uma busca?</h5>
                    <form action="{{ route('search') }}" method="GET" class="mt-3">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Buscar notícias, vereadores, projetos, documentos..." aria-label="Buscar" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                        </div>
                    </form>
                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-1"></i> Página inicial
                        </a>
                        <a href="{{ route('noticias.index') }}" class="btn btn-outline-secondary">
                            <i class="far fa-newspaper me-1"></i> Notícias
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
.card-title { color: var(--primary-color); }
</style>
@endpush