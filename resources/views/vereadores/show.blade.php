@extends('layouts.app')

@section('title', $vereador->nome . ' - Vereadores - Câmara Municipal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/public-styles.css') }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center">
                <div class="position-relative mb-4">
                    <div class="vereador-profile-photo-container">
                        @if($vereador->foto)
                            <img src="{{ $vereador->foto }}" alt="{{ $vereador->nome }}" class="vereador-profile-photo">
                        @else
                            <div class="vereador-profile-photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    @if($vereador->isPresidente())
                    <div class="presidente-badge-profile">
                        <i class="fas fa-crown"></i>
                        <span>PRESIDENTE</span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3 text-white animate-fade-in-up">
                    {{ $vereador->nome }}
                </h1>
                @if($vereador->nome_parlamentar && $vereador->nome_parlamentar !== $vereador->nome)
                <p class="lead text-white-50 mb-3 animate-fade-in-up" style="animation-delay: 0.1s;">
                    {{ $vereador->nome_parlamentar }}
                </p>
                @endif
                <div class="d-flex flex-wrap gap-3 mb-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="fas fa-flag me-1"></i>
                        {{ $vereador->partido }}
                    </span>
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="fas fa-calendar me-1"></i>
                        Mandato {{ $vereador->legislatura }}
                    </span>
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="fas fa-check-circle me-1"></i>
                        {{ ucfirst($vereador->status) }}
                    </span>
                </div>
                <div class="d-flex gap-3 flex-wrap animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('vereadores.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>
                        Voltar aos Vereadores
                    </a>
                    @if($vereador->redes_sociais)
                        @php $redes = json_decode($vereador->redes_sociais, true); @endphp
                        @if(isset($redes['facebook']))
                        <a href="{{ $redes['facebook'] }}" target="_blank" class="btn btn-outline-light">
                            <i class="fab fa-facebook me-1"></i>
                            Facebook
                        </a>
                        @endif
                        @if(isset($redes['instagram']))
                        <a href="https://instagram.com/{{ ltrim($redes['instagram'], '@') }}" target="_blank" class="btn btn-outline-light">
                            <i class="fab fa-instagram me-1"></i>
                            Instagram
                        </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Informações Detalhadas -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Biografia -->
            <div class="col-lg-8">
                <div class="card card-custom h-100">
                    <div class="card-body p-4">
                        <h3 class="fw-bold text-primary mb-4">
                            <i class="fas fa-user-circle me-2"></i>
                            Biografia
                        </h3>
                        <p class="text-muted lh-lg">
                            {{ $vereador->biografia }}
                        </p>
                        
                        @if($vereador->proposicoes)
                        <hr class="my-4">
                        <h4 class="fw-bold text-primary mb-3">
                            <i class="fas fa-gavel me-2"></i>
                            Principais Proposições
                        </h4>
                        <div class="proposicoes-list">
                            @foreach(explode(';', $vereador->proposicoes) as $proposicao)
                                @if(trim($proposicao))
                                <div class="proposicao-item mb-3 p-3 bg-light rounded">
                                    <i class="fas fa-file-alt text-primary me-2"></i>
                                    {{ trim($proposicao) }}
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Informações de Contato e Comissões -->
            <div class="col-lg-4">
                <!-- Contato -->
                <div class="card card-custom mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-primary mb-4">
                            <i class="fas fa-address-card me-2"></i>
                            Contato
                        </h4>
                        
                        @if($vereador->telefone)
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Telefone</small>
                                    <strong>{{ $vereador->telefone }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($vereador->email)
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">E-mail</small>
                                    <strong>{{ $vereador->email }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Mandato</small>
                                    <strong>{{ \Carbon\Carbon::parse($vereador->inicio_mandato)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($vereador->fim_mandato)->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Comissões -->
                @if($vereador->comissoes)
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-primary mb-4">
                            <i class="fas fa-users-cog me-2"></i>
                            Comissões
                        </h4>
                        
                        @php $comissoes = json_decode($vereador->comissoes, true); @endphp
                        @if($comissoes)
                            @foreach($comissoes as $comissao)
                            <div class="comissao-item mb-2">
                                <span class="badge bg-primary fs-6 px-3 py-2 w-100 text-start">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ ucwords(str_replace('-', ' ', $comissao)) }}
                                </span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection