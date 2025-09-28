@extends('layouts.app')

@section('title', 'Vereadores - Câmara Municipal')

@push('styles')
<style>
/* Vereadores Page Styles */
.vereadores-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.vereadores-hero {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.vereadores-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="1" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.brasao-vereadores {
    height: 120px;
    width: auto;
    max-width: 120px;
    object-fit: contain;
    opacity: 0.8;
    filter: brightness(1.2) contrast(1.1);
    transition: all 0.3s ease;
}

.brasao-vereadores:hover {
    opacity: 1;
    transform: scale(1.05);
}



.vereadores-grid {
    padding: 80px 0;
}

.vereador-card-modern {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.vereador-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}

.vereador-photo-large {
    position: relative;
    height: 350px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.vereador-photo-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 20%;
    transition: transform 0.3s ease;
}

.vereador-card-modern:hover .vereador-photo-large img {
    transform: scale(1.05);
}

.vereador-photo-placeholder-large {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 4rem;
}

.presidente-badge-modern {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #f39c12 0%, #e74c3c 100%);
    color: white;
    padding: 8px 15px;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.presidente-badge-modern i {
    font-size: 0.9rem;
}

.vereador-info {
    padding: 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.vereador-nome {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.vereador-partido {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #3498db;
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.vereador-partido i {
    font-size: 1rem;
}

.vereador-contatos {
    margin-bottom: 1.5rem;
}

.contato-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 0.8rem;
    color: #666;
    font-size: 0.95rem;
}

.contato-icon {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.vereador-biografia {
    color: #666;
    line-height: 1.6;
    margin-bottom: 2rem;
    flex: 1;
}

.vereador-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: auto;
}

.btn-perfil {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-perfil:hover {
    background: linear-gradient(135deg, #34495e 0%, #2980b9 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.social-links {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.btn-social {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.btn-social:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    color: white;
}

.btn-facebook {
    background: linear-gradient(135deg, #3b5998 0%, #8b9dc3 100%);
}

.btn-instagram {
    background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%);
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #666;
}

.empty-state i {
    font-size: 5rem;
    color: #ddd;
    margin-bottom: 2rem;
}

.empty-state h3 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.empty-state p {
    font-size: 1.1rem;
    max-width: 400px;
    margin: 0 auto;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .vereadores-hero {
        padding: 60px 0;
    }
    
    .vereadores-grid {
        padding: 60px 0;
    }
    
    .vereador-photo-large {
        height: 280px;
    }
    
    .vereador-info {
        padding: 1.5rem;
    }
    
    .vereador-nome {
        font-size: 1.3rem;
    }
    
    .brasao-vereadores {
        height: 80px;
        max-width: 80px;
    }
}

/* Animation Classes */
.animate-fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@php
    $brasao = \App\Models\ConfiguracaoGeral::obterBrasao();
@endphp

@section('content')
<!-- Hero Section -->
<section class="vereadores-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="animate-fade-in-up">
                    Nossos Vereadores
                </h1>
                <p class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    Conheça os representantes eleitos pelo povo para defender os interesses do nosso município na Câmara Municipal.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                    @if($brasao)
                        <img src="{{ $brasao }}" alt="Brasão da Câmara" class="brasao-vereadores">
                    @else
                        <i class="fas fa-landmark" style="font-size: 6rem; opacity: 0.2;"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Vereadores Grid -->
<section class="vereadores-grid">
    <div class="container">
        @if($vereadores->count() > 0)
        <div class="row g-4">
            @foreach($vereadores as $index => $vereador)
            <div class="col-lg-4 col-md-6">
                <div class="vereador-card-modern animate-fade-in-up" style="animation-delay: {{ 0.1 * $index }}s;">
                    <div class="vereador-photo-large">
                        @if($vereador->foto)
                            <img src="{{ asset('storage/' . $vereador->foto) }}" alt="{{ $vereador->nome }}" loading="lazy">
                        @else
                            <div class="vereador-photo-placeholder-large">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        
                        @if($vereador->isPresidente())
                        <div class="presidente-badge-modern">
                            <i class="fas fa-crown"></i>
                            <span>PRESIDENTE</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="vereador-info">
                        <h3 class="vereador-nome">{{ $vereador->nome }}</h3>
                        
                        <div class="vereador-partido">
                            <i class="fas fa-flag"></i>
                            {{ $vereador->partido }}
                        </div>
                        
                        <div class="vereador-contatos">
                            @if($vereador->telefone)
                            <div class="contato-item">
                                <div class="contato-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span>{{ $vereador->telefone }}</span>
                            </div>
                            @endif
                            
                            @if($vereador->email)
                            <div class="contato-item">
                                <div class="contato-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span>{{ $vereador->email }}</span>
                            </div>
                            @endif
                        </div>
                        
                        @if($vereador->biografia)
                        <p class="vereador-biografia">
                            {{ Str::limit($vereador->biografia, 120) }}
                        </p>
                        @endif
                        
                        <div class="vereador-actions">
                            <a href="{{ route('vereadores.show', $vereador->id) }}" class="btn-perfil">
                                <i class="fas fa-user me-2"></i>
                                Ver Perfil Completo
                            </a>
                            
                            @if($vereador->redes_sociais)
                                @php 
                                    $redes = $vereador->redes_sociais;
                                    if (is_string($redes)) {
                                        $redes = json_decode($redes, true) ?? [];
                                    } elseif (!is_array($redes)) {
                                        $redes = [];
                                    }
                                @endphp
                                <div class="social-links">
                                    @if(isset($redes['facebook']))
                                    <a href="{{ $redes['facebook'] }}" target="_blank" class="btn-social btn-facebook" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    @endif
                                    @if(isset($redes['instagram']))
                                    <a href="https://instagram.com/{{ ltrim($redes['instagram'], '@') }}" target="_blank" class="btn-social btn-instagram" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h3>Nenhum vereador encontrado</h3>
            <p>Os dados dos vereadores serão carregados em breve.</p>
        </div>
        @endif
    </div>
</section>
@endsection