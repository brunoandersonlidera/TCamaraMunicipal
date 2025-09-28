{{-- 
    AVISO: Esta view foi substituída pelo sistema dinâmico de páginas.
    O conteúdo agora é gerenciado através do banco de dados.
    Acesse: /admin/paginas-conteudo para gerenciar o conteúdo.
    
    Esta view é mantida apenas para compatibilidade.
    Use a rota: route('paginas.show', 'missao-visao-valores') para acessar a nova versão.
--}}

@php
    // Redirecionar para a nova rota dinâmica
    $pagina = \App\Models\PaginaConteudo::where('slug', 'missao-visao-valores')->first();
    if ($pagina) {
        return redirect()->route('paginas.show', 'missao-visao-valores');
    }
@endphp

@extends('layouts.app')

@section('title', 'Missão, Visão e Valores - Câmara Municipal')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="#">Sobre</a></li>
            <li class="breadcrumb-item active" aria-current="page">Missão, Visão e Valores</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="page-header text-center">
                <h1 class="display-4 text-primary mb-3">
                    <i class="fas fa-bullseye me-3"></i>
                    Missão, Visão e Valores
                </h1>
                <p class="lead text-muted">Nossos princípios e diretrizes institucionais</p>
            </div>
        </div>
    </div>

    <!-- Missão -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="card-title mb-0 h1">
                        <i class="fas fa-bullseye me-3"></i>
                        MISSÃO
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center">
                        <blockquote class="blockquote">
                            <p class="mb-4 h4 text-muted font-weight-light">
                                "Representar os interesses da população, exercer a função legislativa com 
                                transparência e eficiência, fiscalizar o Poder Executivo e promover o 
                                desenvolvimento sustentável do município através de leis justas e 
                                participação cidadã."
                            </p>
                        </blockquote>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4 text-center">
                            <div class="mission-pillar">
                                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                <h5>Representação</h5>
                                <p class="text-muted">Ser a voz do povo nas decisões municipais</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mission-pillar">
                                <i class="fas fa-balance-scale fa-3x text-primary mb-3"></i>
                                <h5>Legislação</h5>
                                <p class="text-muted">Criar leis justas e eficazes para a sociedade</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mission-pillar">
                                <i class="fas fa-search fa-3x text-primary mb-3"></i>
                                <h5>Fiscalização</h5>
                                <p class="text-muted">Acompanhar e controlar os atos do Executivo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visão -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-4">
                    <h2 class="card-title mb-0 h1">
                        <i class="fas fa-eye me-3"></i>
                        VISÃO
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center">
                        <blockquote class="blockquote">
                            <p class="mb-4 h4 text-muted font-weight-light">
                                "Ser reconhecida como uma Câmara Municipal moderna, transparente e 
                                participativa, referência em gestão pública democrática e inovação 
                                legislativa, contribuindo para fazer do nosso município um lugar 
                                próspero e sustentável para todos."
                            </p>
                        </blockquote>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-3 text-center">
                            <div class="vision-goal">
                                <i class="fas fa-laptop fa-2x text-success mb-3"></i>
                                <h6>Modernidade</h6>
                                <p class="small text-muted">Tecnologia a serviço do cidadão</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="vision-goal">
                                <i class="fas fa-glass fa-2x text-success mb-3"></i>
                                <h6>Transparência</h6>
                                <p class="small text-muted">Informação acessível e clara</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="vision-goal">
                                <i class="fas fa-handshake fa-2x text-success mb-3"></i>
                                <h6>Participação</h6>
                                <p class="small text-muted">Cidadão ativo nas decisões</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="vision-goal">
                                <i class="fas fa-leaf fa-2x text-success mb-3"></i>
                                <h6>Sustentabilidade</h6>
                                <p class="small text-muted">Desenvolvimento responsável</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Valores -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h2 class="card-title mb-0 h1">
                        <i class="fas fa-heart me-3"></i>
                        VALORES
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="value-item">
                                <div class="d-flex align-items-start">
                                    <div class="value-icon">
                                        <i class="fas fa-shield-alt fa-2x text-warning"></i>
                                    </div>
                                    <div class="value-content">
                                        <h5 class="text-dark">Ética e Integridade</h5>
                                        <p class="text-muted mb-0">
                                            Agir com honestidade, probidade e retidão em todas as ações, 
                                            mantendo a confiança da população.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="value-item">
                                <div class="d-flex align-items-start">
                                    <div class="value-icon">
                                        <i class="fas fa-eye fa-2x text-warning"></i>
                                    </div>
                                    <div class="value-content">
                                        <h5 class="text-dark">Transparência</h5>
                                        <p class="text-muted mb-0">
                                            Garantir acesso pleno às informações públicas e prestação 
                                            de contas clara e acessível.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="value-item">
                                <div class="d-flex align-items-start">
                                    <div class="value-icon">
                                        <i class="fas fa-users fa-2x text-warning"></i>
                                    </div>
                                    <div class="value-content">
                                        <h5 class="text-dark">Participação Social</h5>
                                        <p class="text-muted mb-0">
                                            Promover e valorizar a participação cidadã nos processos 
                                            decisórios e na construção de políticas públicas.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="value-item">
                                <div class="d-flex align-items-start">
                                    <div class="value-icon">
                                        <i class="fas fa-cogs fa-2x text-warning"></i>
                                    </div>
                                    <div class="value-content">
                                        <h5 class="text-dark">Eficiência</h5>
                                        <p class="text-muted mb-0">
                                            Otimizar recursos e processos para entregar resultados 
                                            de qualidade à população.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="value-item">
                                <div class="d-flex align-items-start">
                                    <div class="value-icon">
                                        <i class="fas fa-balance-scale fa-2x text-warning"></i>
                                    </div>
                                    <div class="value-content">
                                        <h5 class="text-dark">Justiça Social</h5>
                                        <p class="text-muted mb-0">
                                            Buscar a equidade e a redução das desigualdades através 
                                            de políticas públicas inclusivas.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="value-item">
                                <div class="d-flex align-items-start">
                                    <div class="value-icon">
                                        <i class="fas fa-lightbulb fa-2x text-warning"></i>
                                    </div>
                                    <div class="value-content">
                                        <h5 class="text-dark">Inovação</h5>
                                        <p class="text-muted mb-0">
                                            Buscar constantemente novas soluções e tecnologias para 
                                            melhorar os serviços prestados.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compromisso -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body p-5 text-center">
                    <h3 class="text-primary mb-4">
                        <i class="fas fa-handshake me-2"></i>
                        Nosso Compromisso
                    </h3>
                    <p class="lead text-muted mb-0">
                        Estes princípios orientam todas as nossas ações e decisões, garantindo que 
                        a Câmara Municipal cumpra seu papel constitucional de forma exemplar, 
                        sempre em benefício da população e do desenvolvimento do município.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    border-bottom: 3px solid #007bff;
    padding-bottom: 2rem;
}

.mission-pillar {
    padding: 2rem 1rem;
    border-radius: 0.5rem;
    transition: transform 0.3s ease;
}

.mission-pillar:hover {
    transform: translateY(-5px);
}

.vision-goal {
    padding: 1.5rem 1rem;
    border-radius: 0.5rem;
    transition: transform 0.3s ease;
}

.vision-goal:hover {
    transform: translateY(-3px);
}

.value-item {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    border-left: 4px solid #ffc107;
    height: 100%;
    transition: box-shadow 0.3s ease;
}

.value-item:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.value-icon {
    margin-right: 1rem;
    min-width: 60px;
}

.value-content {
    flex: 1;
}

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endsection