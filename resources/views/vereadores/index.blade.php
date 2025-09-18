@extends('layouts.app')

@section('title', 'Vereadores - Câmara Municipal')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4 animate-fade-in-up">
                    Nossos Vereadores
                </h1>
                <p class="lead mb-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                    Conheça os representantes eleitos pelo povo para defender os interesses do nosso município.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                    <i class="fas fa-users" style="font-size: 8rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vereadores Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($vereadores as $vereador)
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100 vereador-card">
                    <div class="card-body text-center p-4">
                        <div class="position-relative mb-4">
                            <div class="vereador-photo-container">
                                @if($vereador->foto)
                                    <img src="{{ $vereador->foto }}" alt="{{ $vereador->nome }}" class="vereador-photo">
                                @else
                                    <div class="vereador-photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            @if($vereador->isPresidente())
                            <div class="presidente-badge-small">
                                <i class="fas fa-crown"></i>
                                <span>PRESIDENTE</span>
                            </div>
                            @endif
                        </div>
                        
                        <h5 class="fw-bold text-primary mb-2">{{ $vereador->nome }}</h5>
                        <p class="text-muted mb-3">
                            <i class="fas fa-flag me-1"></i>
                            {{ $vereador->partido }}
                        </p>
                        
                        @if($vereador->telefone)
                        <p class="text-muted small mb-2">
                            <i class="fas fa-phone me-1"></i>
                            {{ $vereador->telefone }}
                        </p>
                        @endif
                        
                        @if($vereador->email)
                        <p class="text-muted small mb-3">
                            <i class="fas fa-envelope me-1"></i>
                            {{ $vereador->email }}
                        </p>
                        @endif
                        
                        <p class="card-text text-muted mb-4">
                            {{ Str::limit($vereador->biografia, 100) }}
                        </p>
                        
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('vereadores.show', $vereador->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-user me-1"></i>
                                Ver Perfil
                            </a>
                            
                            @if($vereador->redes_sociais)
                                @php $redes = json_decode($vereador->redes_sociais, true); @endphp
                                @if(isset($redes['facebook']))
                                <a href="{{ $redes['facebook'] }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                @endif
                                @if(isset($redes['instagram']))
                                <a href="https://instagram.com/{{ ltrim($redes['instagram'], '@') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($vereadores->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">Nenhum vereador encontrado</h4>
            <p class="text-muted">Os dados dos vereadores serão carregados em breve.</p>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .vereador-card {
        transition: all 0.3s ease;
    }

    .vereador-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .vereador-photo-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }

    .vereador-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .vereador-photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        border: 3px solid var(--primary-color);
    }

    .presidente-badge-small {
        position: absolute;
        top: -5px;
        right: -5px;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        padding: 4px 8px;
        border-radius: 15px;
        font-size: 0.65rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 3px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
</style>
@endpush