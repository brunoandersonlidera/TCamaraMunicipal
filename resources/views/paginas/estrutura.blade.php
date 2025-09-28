{{-- 
    AVISO: Esta view foi substituída pelo sistema dinâmico de páginas.
    O conteúdo agora é gerenciado através do banco de dados.
    Acesse: /admin/paginas-conteudo para gerenciar o conteúdo.
    
    Esta view é mantida apenas para compatibilidade.
    Use a rota: route('paginas.show', 'estrutura') para acessar a nova versão.
--}}

@php
    // Redirecionar para a nova rota dinâmica
    $pagina = \App\Models\PaginaConteudo::where('slug', 'estrutura')->first();
    if ($pagina) {
        return redirect()->route('paginas.show', 'estrutura');
    }
@endphp

@extends('layouts.app')

@section('title', 'Estrutura - Câmara Municipal')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="#">Sobre</a></li>
            <li class="breadcrumb-item active" aria-current="page">Estrutura</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="page-header text-center">
                <h1 class="display-4 text-primary mb-3">
                    <i class="fas fa-sitemap me-3"></i>
                    Estrutura Organizacional
                </h1>
                <p class="lead text-muted">Conheça como nossa instituição está organizada</p>
            </div>
        </div>
    </div>

    <!-- Mesa Diretora -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>
                        Mesa Diretora
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        A Mesa Diretora é o órgão responsável pela direção dos trabalhos legislativos e 
                        administrativos da Câmara Municipal.
                    </p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="position-card">
                                <h5 class="text-primary">
                                    <i class="fas fa-crown me-2"></i>
                                    Presidente
                                </h5>
                                <p class="mb-0">Dirige as sessões e representa a Câmara externamente</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="position-card">
                                <h5 class="text-primary">
                                    <i class="fas fa-user-tie me-2"></i>
                                    Vice-Presidente
                                </h5>
                                <p class="mb-0">Substitui o Presidente em suas ausências</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="position-card">
                                <h5 class="text-primary">
                                    <i class="fas fa-edit me-2"></i>
                                    1º Secretário
                                </h5>
                                <p class="mb-0">Responsável pela redação das atas e correspondências</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="position-card">
                                <h5 class="text-primary">
                                    <i class="fas fa-clipboard me-2"></i>
                                    2º Secretário
                                </h5>
                                <p class="mb-0">Auxilia o 1º Secretário em suas funções</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comissões -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-layer-group me-2"></i>
                        Comissões Permanentes
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        As comissões são órgãos técnicos destinados a estudar e emitir parecer sobre 
                        as matérias em tramitação na Câmara.
                    </p>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="commission-card">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-balance-scale me-2"></i>
                                    Comissão de Justiça e Redação
                                </h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Análise jurídica dos projetos</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Verificação de constitucionalidade</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Redação final das proposições</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="commission-card">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-calculator me-2"></i>
                                    Comissão de Finanças e Orçamento
                                </h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Análise de projetos com impacto financeiro</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Acompanhamento orçamentário</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Fiscalização de gastos públicos</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="commission-card">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-city me-2"></i>
                                    Comissão de Obras e Serviços Públicos
                                </h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Análise de projetos de infraestrutura</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Fiscalização de obras públicas</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Acompanhamento de serviços municipais</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="commission-card">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    Comissão de Educação e Cultura
                                </h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Projetos relacionados à educação</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Políticas culturais municipais</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Acompanhamento do ensino público</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estrutura Administrativa -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-building me-2"></i>
                        Estrutura Administrativa
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="admin-section">
                                <h5 class="text-info mb-3">
                                    <i class="fas fa-user-cog me-2"></i>
                                    Secretaria Geral
                                </h5>
                                <ul class="list-unstyled">
                                    <li>• Protocolo e arquivo</li>
                                    <li>• Expediente geral</li>
                                    <li>• Apoio às sessões</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="admin-section">
                                <h5 class="text-info mb-3">
                                    <i class="fas fa-laptop me-2"></i>
                                    Assessoria Técnica
                                </h5>
                                <ul class="list-unstyled">
                                    <li>• Suporte tecnológico</li>
                                    <li>• Assessoria jurídica</li>
                                    <li>• Comunicação social</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="admin-section">
                                <h5 class="text-info mb-3">
                                    <i class="fas fa-users-cog me-2"></i>
                                    Recursos Humanos
                                </h5>
                                <ul class="list-unstyled">
                                    <li>• Gestão de pessoal</li>
                                    <li>• Folha de pagamento</li>
                                    <li>• Capacitação</li>
                                </ul>
                            </div>
                        </div>
                    </div>
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

.position-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    border-left: 4px solid #007bff;
    height: 100%;
}

.commission-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    border-left: 4px solid #28a745;
    height: 100%;
}

.admin-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    border-left: 4px solid #17a2b8;
    height: 100%;
}

.card-header {
    border-bottom: none;
}
</style>
@endsection