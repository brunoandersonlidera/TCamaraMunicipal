{{-- 
    AVISO: Esta view foi substituída pelo sistema dinâmico de páginas.
    O conteúdo agora é gerenciado através do banco de dados.
    Acesse: /admin/paginas-conteudo para gerenciar o conteúdo.
    
    Esta view é mantida apenas para compatibilidade.
    Use a rota: route('paginas.show', 'historia') para acessar a nova versão.
--}}

@php
    // Redirecionar para a nova rota dinâmica
    $pagina = \App\Models\PaginaConteudo::where('slug', 'historia')->first();
    if ($pagina) {
        return redirect()->route('paginas.show', 'historia');
    }
@endphp

@extends('layouts.app')

@section('title', 'História da Câmara Municipal')

@section('content')
<div class="container-fluid px-0">
    <!-- Header da Página -->
    <div class="page-header bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb bg-transparent p-0 mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">
                                    <i class="fas fa-home"></i> Início
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#" class="text-white-50 text-decoration-none">
                                    Institucional
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                História
                            </li>
                        </ol>
                    </nav>
                    
                    <div class="text-center">
                        <i class="fas fa-landmark fa-3x mb-3 opacity-75"></i>
                        <h1 class="display-4 mb-3 fw-bold">História da Câmara Municipal</h1>
                        <p class="lead mb-0 opacity-75">Conheça a trajetória e evolução da nossa instituição</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <!-- Seção: Fundação -->
                    <div class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-flag me-2"></i>
                            Fundação e Primeiros Anos
                        </h2>
                        <p class="text-justify">
                            A Câmara Municipal foi fundada com o objetivo de representar os interesses da população local 
                            e promover o desenvolvimento ordenado do município. Desde sua criação, tem sido um pilar 
                            fundamental da democracia local, garantindo a participação cidadã nas decisões que afetam 
                            a comunidade.
                        </p>
                        <p class="text-justify">
                            Nos primeiros anos de funcionamento, a instituição enfrentou diversos desafios para 
                            estabelecer-se como um órgão efetivo de representação popular, sempre pautando suas 
                            ações pelos princípios da transparência e do interesse público.
                        </p>
                    </div>

                    <!-- Seção: Evolução -->
                    <div class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-chart-line me-2"></i>
                            Evolução e Modernização
                        </h2>
                        <p class="text-justify">
                            Ao longo dos anos, a Câmara Municipal passou por importantes processos de modernização, 
                            adaptando-se às novas demandas da sociedade e incorporando tecnologias que facilitam 
                            o acesso da população às informações e serviços públicos.
                        </p>
                        <p class="text-justify">
                            A implementação de sistemas digitais, a criação de canais de comunicação direta com 
                            os cidadãos e a adoção de práticas de transparência ativa marcaram uma nova era na 
                            gestão pública municipal.
                        </p>
                    </div>

                    <!-- Seção: Marcos Importantes -->
                    <div class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-star me-2"></i>
                            Marcos Importantes
                        </h2>
                        <div class="timeline">
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h5 class="mb-2">Criação da Ouvidoria</h5>
                                    <p class="text-muted mb-0">
                                        Estabelecimento de canal direto de comunicação com a população para 
                                        recebimento de sugestões, reclamações e denúncias.
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h5 class="mb-2">Portal da Transparência</h5>
                                    <p class="text-muted mb-0">
                                        Lançamento do portal online com informações sobre gastos públicos, 
                                        licitações e atos administrativos.
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h5 class="mb-2">Modernização Tecnológica</h5>
                                    <p class="text-muted mb-0">
                                        Implementação de sistemas digitais para gestão de processos e 
                                        atendimento ao público.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seção: Presente e Futuro -->
                    <div class="mb-4">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-rocket me-2"></i>
                            Presente e Futuro
                        </h2>
                        <p class="text-justify">
                            Hoje, a Câmara Municipal continua seu compromisso com a excelência no atendimento 
                            ao público e na representação dos interesses da comunidade. Com foco na inovação 
                            e na participação cidadã, busca constantemente aprimorar seus serviços e processos.
                        </p>
                        <p class="text-justify">
                            O futuro da instituição está alinhado com os princípios da governança digital, 
                            sustentabilidade e participação social, sempre mantendo o compromisso com a 
                            transparência e a eficiência na gestão pública.
                        </p>
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

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.75rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    border-left: 3px solid #007bff;
}

.text-justify {
    text-align: justify;
}
</style>
@endsection