@extends('layouts.app')

@section('title', 'Acervo de Leis - Câmara Municipal')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section-leis">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="hero-title">
                        <i class="fas fa-balance-scale"></i>
                        Acervo de Leis
                    </h1>
                    <p class="hero-subtitle">
                        Consulte toda a legislação municipal de forma organizada e acessível
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="filtros-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="filtros-card">
                        <form method="GET" action="{{ route('leis.index') }}" id="filtros-form">
                            <div class="row g-3">
                                <!-- Busca Geral -->
                                <div class="col-md-4">
                                    <label for="busca" class="form-label">
                                        <i class="fas fa-search"></i>
                                        Buscar
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="busca" 
                                           name="busca" 
                                           value="{{ request('busca') }}"
                                           placeholder="Número, título, descrição...">
                                </div>

                                <!-- Filtro por Tipo -->
                                <div class="col-md-3">
                                    <label for="tipo" class="form-label">
                                        <i class="fas fa-filter"></i>
                                        Tipo de Lei
                                    </label>
                                    <select class="form-select" id="tipo" name="tipo">
                                        <option value="">Todos os tipos</option>
                                        @foreach($tipos as $tipo)
                                            <option value="{{ $tipo }}" 
                                                    {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                                {{ $tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtro por Exercício -->
                                <div class="col-md-2">
                                    <label for="exercicio" class="form-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Exercício
                                    </label>
                                    <select class="form-select" id="exercicio" name="exercicio">
                                        <option value="">Todos</option>
                                        @foreach($exercicios as $exercicio)
                                            <option value="{{ $exercicio }}" 
                                                    {{ request('exercicio') == $exercicio ? 'selected' : '' }}>
                                                {{ $exercicio }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ordenação -->
                                <div class="col-md-2">
                                    <label for="ordenacao" class="form-label">
                                        <i class="fas fa-sort"></i>
                                        Ordenar por
                                    </label>
                                    <select class="form-select" id="ordenacao" name="ordenacao">
                                        <option value="padrao" {{ request('ordenacao') == 'padrao' ? 'selected' : '' }}>
                                            Mais recentes
                                        </option>
                                        <option value="numero_asc" {{ request('ordenacao') == 'numero_asc' ? 'selected' : '' }}>
                                            Número (crescente)
                                        </option>
                                        <option value="numero_desc" {{ request('ordenacao') == 'numero_desc' ? 'selected' : '' }}>
                                            Número (decrescente)
                                        </option>
                                        <option value="data_asc" {{ request('ordenacao') == 'data_asc' ? 'selected' : '' }}>
                                            Data (mais antigas)
                                        </option>
                                        <option value="data_desc" {{ request('ordenacao') == 'data_desc' ? 'selected' : '' }}>
                                            Data (mais recentes)
                                        </option>
                                        <option value="titulo_asc" {{ request('ordenacao') == 'titulo_asc' ? 'selected' : '' }}>
                                            Título (A-Z)
                                        </option>
                                        <option value="titulo_desc" {{ request('ordenacao') == 'titulo_desc' ? 'selected' : '' }}>
                                            Título (Z-A)
                                        </option>
                                    </select>
                                </div>

                                <!-- Botões -->
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="{{ route('leis.index') }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <div class="resultados-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Informações dos Resultados -->
                    <div class="resultados-info">
                        @include('leis.partials.info', ['leis' => $leis])
                    </div>

                    <!-- Lista de Leis -->
                    @if($leis->count() > 0)
                        <div class="leis-grid">
                            @include('leis.partials.grid', ['leis' => $leis])
                        </div>

                        <!-- Paginação -->
                        <div class="paginacao-section">
                            {{ $leis->links() }}
                        </div>
                    @else
                        <div class="leis-grid">
                            @include('leis.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loading-overlay">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <div class="loading-text">Carregando leis...</div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leis.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/leis.js') }}"></script>
@endpush