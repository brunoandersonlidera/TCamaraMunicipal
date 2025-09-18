@extends('layouts.app')

@section('title', 'Câmara Municipal - Início')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4 animate-fade-in-up">
                    Bem-vindo à Câmara Municipal
                </h1>
                <p class="lead mb-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                    Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. 
                    Acompanhe as atividades legislativas e participe da vida política da sua cidade.
                </p>
                <div class="d-flex gap-3 flex-wrap animate-fade-in-up" style="animation-delay: 0.4s;">
                    <a href="#" class="btn btn-primary-custom">
                        <i class="fas fa-users me-2"></i>
                        Conheça os Vereadores
                    </a>
                    <a href="#" class="btn btn-outline-light">
                        <i class="fas fa-eye me-2"></i>
                        Portal da Transparência
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
                    <i class="fas fa-landmark" style="font-size: 12rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Acesso Rápido -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Acesso Rápido</h2>
            <p class="text-muted">Encontre rapidamente o que você precisa</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom h-100 text-center p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-users text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Vereadores</h5>
                        <p class="card-text text-muted">
                            Conheça os representantes eleitos e suas proposições
                        </p>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-1"></i>
                            Ver Vereadores
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom h-100 text-center p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-gavel text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Projetos de Lei</h5>
                        <p class="card-text text-muted">
                            Acompanhe os projetos em tramitação na Câmara
                        </p>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-1"></i>
                            Ver Projetos
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom h-100 text-center p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-calendar-alt text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Sessões</h5>
                        <p class="card-text text-muted">
                            Calendário e atas das sessões plenárias
                        </p>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-1"></i>
                            Ver Sessões
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom h-100 text-center p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-eye text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Transparência</h5>
                        <p class="card-text text-muted">
                            Portal da transparência e acesso à informação
                        </p>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-1"></i>
                            Acessar Portal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Últimas Notícias -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Últimas Notícias</h2>
            <p class="text-muted">Fique por dentro das atividades da Câmara</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <small class="text-muted">15 de Janeiro, 2024</small>
                        </div>
                        <h5 class="card-title">Nova Lei de Incentivo ao Empreendedorismo</h5>
                        <p class="card-text text-muted">
                            Projeto de lei que visa incentivar pequenos empreendedores foi aprovado em primeira votação...
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Leia mais
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <small class="text-muted">12 de Janeiro, 2024</small>
                        </div>
                        <h5 class="card-title">Sessão Extraordinária Convocada</h5>
                        <p class="card-text text-muted">
                            Sessão extraordinária foi convocada para discussão do orçamento municipal para 2024...
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Leia mais
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <small class="text-muted">10 de Janeiro, 2024</small>
                        </div>
                        <h5 class="card-title">Audiência Pública sobre Mobilidade Urbana</h5>
                        <p class="card-text text-muted">
                            População é convidada a participar de audiência sobre o novo plano de mobilidade urbana...
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Leia mais
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-newspaper me-2"></i>
                Ver Todas as Notícias
            </a>
        </div>
    </div>
</section>

<!-- Números da Câmara -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Números da Câmara</h2>
            <p class="text-muted">Transparência em dados</p>
        </div>
        
        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-users text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $vereadores ?? '9' }}</h3>
                        <p class="text-muted mb-0">Vereadores Ativos</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-gavel text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $projetos ?? '45' }}</h3>
                        <p class="text-muted mb-0">Projetos em 2024</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-calendar-check text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $sessoes ?? '24' }}</h3>
                        <p class="text-muted mb-0">Sessões Realizadas</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-custom p-4">
                    <div class="card-body">
                        <i class="fas fa-file-alt text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">{{ $leis ?? '12' }}</h3>
                        <p class="text-muted mb-0">Leis Aprovadas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contato e Localização -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <h2 class="section-title">Entre em Contato</h2>
                <p class="text-muted mb-4">
                    Estamos aqui para atender você. Entre em contato conosco através dos canais abaixo.
                </p>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Endereço</h6>
                                <p class="text-muted mb-0">
                                    Rua da Câmara, 123<br>
                                    Centro - CEP 12345-678
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Telefone</h6>
                                <p class="text-muted mb-0">
                                    (XX) XXXX-XXXX<br>
                                    (XX) XXXX-XXXX
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">E-mail</h6>
                                <p class="text-muted mb-0">
                                    contato@camara.gov.br<br>
                                    ouvidoria@camara.gov.br
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Horário</h6>
                                <p class="text-muted mb-0">
                                    Segunda a Sexta<br>
                                    8h às 17h
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <h2 class="section-title">Localização</h2>
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt text-primary" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3 mb-0">Mapa da localização</p>
                                <small class="text-muted">Integração com Google Maps</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Participe da Vida Política da Sua Cidade</h2>
                <p class="lead mb-4">
                    Sua participação é fundamental para o desenvolvimento do nosso município. 
                    Acompanhe as sessões, conheça os projetos e faça parte das decisões que afetam sua vida.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="#" class="btn btn-light btn-lg">
                        <i class="fas fa-calendar me-2"></i>
                        Próximas Sessões
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-question-circle me-2"></i>
                        e-SIC
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Counter animation for numbers
    function animateCounters() {
        const counters = document.querySelectorAll('.fw-bold.text-primary');
        
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            if (target && target > 0) {
                const increment = target / 50;
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            }
        });
    }

    // Simple trigger for counter animation on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Delay animation slightly for better effect
        setTimeout(animateCounters, 1000);
    });
</script>
@endpush
