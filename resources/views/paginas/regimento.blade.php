{{-- 
    AVISO: Esta view foi substituída pelo sistema dinâmico de páginas.
    O conteúdo agora é gerenciado através do banco de dados.
    Acesse: /admin/paginas-conteudo para gerenciar o conteúdo.
    
    Esta view é mantida apenas para compatibilidade.
    Use a rota: route('paginas.show', 'regimento-interno') para acessar a nova versão.
--}}

@php
    // Redirecionar para a nova rota dinâmica
    $pagina = \App\Models\PaginaConteudo::where('slug', 'regimento-interno')->first();
    if ($pagina) {
        return redirect()->route('paginas.show', 'regimento-interno');
    }
@endphp

@extends('layouts.app')

@section('title', 'Regimento Interno - Câmara Municipal')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="#">Legislação</a></li>
            <li class="breadcrumb-item active" aria-current="page">Regimento Interno</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="page-header text-center">
                <h1 class="display-4 text-primary mb-3">
                    <i class="fas fa-gavel me-3"></i>
                    Regimento Interno
                </h1>
                <p class="lead text-muted">Normas e procedimentos que regem o funcionamento da Câmara Municipal</p>
            </div>
        </div>
    </div>

    <!-- Introdução -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="alert alert-info" role="alert">
                        <h5 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>
                            Sobre o Regimento Interno
                        </h5>
                        <p class="mb-0">
                            O Regimento Interno é o conjunto de normas que disciplina o funcionamento da Câmara Municipal, 
                            estabelecendo os procedimentos para as sessões, tramitação de projetos, funcionamento das 
                            comissões e demais atividades legislativas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Principais Títulos -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    
                    <!-- Título I -->
                    <div class="regimento-section mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-building me-2"></i>
                            Título I - Da Câmara Municipal
                        </h2>
                        <div class="subsection mb-4">
                            <h4 class="h5 text-secondary">Capítulo I - Disposições Preliminares</h4>
                            <ul class="list-styled">
                                <li>Finalidade e competência da Câmara Municipal</li>
                                <li>Sede e funcionamento</li>
                                <li>Símbolos oficiais</li>
                                <li>Prerrogativas institucionais</li>
                            </ul>
                        </div>
                        <div class="subsection">
                            <h4 class="h5 text-secondary">Capítulo II - Das Atribuições</h4>
                            <ul class="list-styled">
                                <li>Função legislativa</li>
                                <li>Função fiscalizadora</li>
                                <li>Função administrativa</li>
                                <li>Função julgadora</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Título II -->
                    <div class="regimento-section mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-users me-2"></i>
                            Título II - Dos Vereadores
                        </h2>
                        <div class="subsection mb-4">
                            <h4 class="h5 text-secondary">Capítulo I - Do Exercício da Vereança</h4>
                            <ul class="list-styled">
                                <li>Posse e exercício do mandato</li>
                                <li>Direitos e prerrogativas</li>
                                <li>Deveres e responsabilidades</li>
                                <li>Incompatibilidades e impedimentos</li>
                            </ul>
                        </div>
                        <div class="subsection">
                            <h4 class="h5 text-secondary">Capítulo II - Da Remuneração</h4>
                            <ul class="list-styled">
                                <li>Subsídio dos vereadores</li>
                                <li>Ajuda de custo</li>
                                <li>Verba de gabinete</li>
                                <li>Critérios de pagamento</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Título III -->
                    <div class="regimento-section mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-crown me-2"></i>
                            Título III - Da Mesa Diretora
                        </h2>
                        <div class="subsection mb-4">
                            <h4 class="h5 text-secondary">Capítulo I - Da Composição e Eleição</h4>
                            <ul class="list-styled">
                                <li>Composição da Mesa Diretora</li>
                                <li>Processo de eleição</li>
                                <li>Mandato e renovação</li>
                                <li>Substituições e licenças</li>
                            </ul>
                        </div>
                        <div class="subsection">
                            <h4 class="h5 text-secondary">Capítulo II - Das Atribuições</h4>
                            <ul class="list-styled">
                                <li>Atribuições do Presidente</li>
                                <li>Atribuições do Vice-Presidente</li>
                                <li>Atribuições dos Secretários</li>
                                <li>Atribuições coletivas da Mesa</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Título IV -->
                    <div class="regimento-section mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-layer-group me-2"></i>
                            Título IV - Das Comissões
                        </h2>
                        <div class="subsection mb-4">
                            <h4 class="h5 text-secondary">Capítulo I - Disposições Gerais</h4>
                            <ul class="list-styled">
                                <li>Tipos de comissões</li>
                                <li>Composição e funcionamento</li>
                                <li>Competências gerais</li>
                                <li>Relatórios e pareceres</li>
                            </ul>
                        </div>
                        <div class="subsection">
                            <h4 class="h5 text-secondary">Capítulo II - Das Comissões Permanentes</h4>
                            <ul class="list-styled">
                                <li>Comissão de Justiça e Redação</li>
                                <li>Comissão de Finanças e Orçamento</li>
                                <li>Comissão de Obras e Serviços Públicos</li>
                                <li>Comissão de Educação e Cultura</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Título V -->
                    <div class="regimento-section mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Título V - Das Sessões
                        </h2>
                        <div class="subsection mb-4">
                            <h4 class="h5 text-secondary">Capítulo I - Disposições Gerais</h4>
                            <ul class="list-styled">
                                <li>Tipos de sessões</li>
                                <li>Periodicidade e horários</li>
                                <li>Quórum para funcionamento</li>
                                <li>Publicidade das sessões</li>
                            </ul>
                        </div>
                        <div class="subsection">
                            <h4 class="h5 text-secondary">Capítulo II - Do Desenvolvimento das Sessões</h4>
                            <ul class="list-styled">
                                <li>Ordem do dia</li>
                                <li>Discussão e votação</li>
                                <li>Apartes e questões de ordem</li>
                                <li>Atas e registros</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Título VI -->
                    <div class="regimento-section mb-4">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-file-alt me-2"></i>
                            Título VI - Do Processo Legislativo
                        </h2>
                        <div class="subsection mb-4">
                            <h4 class="h5 text-secondary">Capítulo I - Das Proposições</h4>
                            <ul class="list-styled">
                                <li>Tipos de proposições</li>
                                <li>Apresentação e protocolo</li>
                                <li>Tramitação nas comissões</li>
                                <li>Prazos e procedimentos</li>
                            </ul>
                        </div>
                        <div class="subsection">
                            <h4 class="h5 text-secondary">Capítulo II - Da Discussão e Votação</h4>
                            <ul class="list-styled">
                                <li>Discussão em primeiro turno</li>
                                <li>Discussão em segundo turno</li>
                                <li>Emendas e substitutivos</li>
                                <li>Votação e proclamação do resultado</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Download -->
                    <div class="text-center mt-5">
                        <div class="alert alert-light border" role="alert">
                            <h5 class="mb-3">
                                <i class="fas fa-download me-2"></i>
                                Documento Completo
                            </h5>
                            <p class="mb-3">Para acessar o texto completo do Regimento Interno:</p>
                            <a href="#" class="btn btn-primary btn-lg">
                                <i class="fas fa-file-pdf me-2"></i>
                                Baixar Regimento Interno (PDF)
                            </a>
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

.regimento-section {
    border-left: 4px solid #007bff;
    padding-left: 1.5rem;
    margin-left: 1rem;
}

.subsection {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.list-styled {
    list-style: none;
    padding-left: 0;
}

.list-styled li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
    position: relative;
    padding-left: 1.5rem;
}

.list-styled li:before {
    content: "▶";
    color: #007bff;
    position: absolute;
    left: 0;
    top: 0.5rem;
}

.list-styled li:last-child {
    border-bottom: none;
}
</style>
@endsection