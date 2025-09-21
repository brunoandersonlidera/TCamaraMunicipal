@extends('layouts.app')

@section('title', 'Perguntas Frequentes - E-SIC')

@section('content')
<div class="esic-faq-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="fas fa-question-circle me-3"></i>
                        Perguntas Frequentes
                    </h1>
                    <p class="page-subtitle">
                        Tire suas dúvidas sobre o Sistema E-SIC
                    </p>
                </div>

                <!-- Busca -->
                <div class="search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" id="faqSearch" 
                               placeholder="Digite sua dúvida para buscar...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Categorias de FAQ -->
                <div class="faq-categories">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="category-card" data-category="geral">
                                <i class="fas fa-info-circle"></i>
                                <h4>Informações Gerais</h4>
                                <p>Dúvidas básicas sobre o E-SIC</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="category-card" data-category="solicitacao">
                                <i class="fas fa-file-alt"></i>
                                <h4>Solicitações</h4>
                                <p>Como fazer e acompanhar</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="category-card" data-category="prazos">
                                <i class="fas fa-clock"></i>
                                <h4>Prazos</h4>
                                <p>Tempos de resposta e recursos</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="category-card" data-category="recursos">
                                <i class="fas fa-gavel"></i>
                                <h4>Recursos</h4>
                                <p>Contestações e direitos</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Accordion -->
                <div class="faq-accordion">
                    <!-- Informações Gerais -->
                    <div class="faq-section" data-category="geral">
                        <h2 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Informações Gerais
                        </h2>
                        
                        <div class="accordion" id="faqGeral">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq1">
                                        O que é o E-SIC?
                                    </button>
                                </h3>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqGeral">
                                    <div class="accordion-body">
                                        O E-SIC (Sistema Eletrônico do Serviço de Informação ao Cidadão) é uma plataforma 
                                        digital que permite aos cidadãos solicitarem informações públicas da Câmara Municipal 
                                        de forma eletrônica, em conformidade com a Lei de Acesso à Informação (Lei nº 12.527/2011).
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq2">
                                        Quem pode usar o E-SIC?
                                    </button>
                                </h3>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqGeral">
                                    <div class="accordion-body">
                                        Qualquer pessoa, física ou jurídica, pode usar o E-SIC para solicitar informações 
                                        públicas. Não é necessário apresentar motivos para a solicitação, nem comprovar 
                                        interesse específico. O acesso à informação é um direito fundamental.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq3">
                                        O serviço é gratuito?
                                    </button>
                                </h3>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqGeral">
                                    <div class="accordion-body">
                                        Sim, o acesso à informação pública é totalmente gratuito. Você não paga nada para 
                                        fazer solicitações, consultar o andamento ou receber as respostas por e-mail. 
                                        Custos podem ser cobrados apenas para reprodução de documentos físicos em grandes quantidades.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq4">
                                        Posso fazer solicitação anônima?
                                    </button>
                                </h3>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqGeral">
                                    <div class="accordion-body">
                                        Sim, você pode marcar a opção "Solicitação Anônima" no formulário. Neste caso, 
                                        sua identidade não será divulgada caso a resposta seja publicada no portal da 
                                        transparência. Porém, seus dados ainda serão necessários para o envio da resposta.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Solicitações -->
                    <div class="faq-section" data-category="solicitacao">
                        <h2 class="section-title">
                            <i class="fas fa-file-alt me-2"></i>
                            Solicitações
                        </h2>
                        
                        <div class="accordion" id="faqSolicitacao">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq5">
                                        Como fazer uma solicitação?
                                    </button>
                                </h3>
                                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqSolicitacao">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Acesse a página "Nova Solicitação"</li>
                                            <li>Preencha seus dados pessoais</li>
                                            <li>Descreva detalhadamente a informação desejada</li>
                                            <li>Escolha a forma de recebimento da resposta</li>
                                            <li>Aceite os termos de uso</li>
                                            <li>Envie a solicitação</li>
                                            <li>Anote o número do protocolo para acompanhamento</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq6">
                                        Como acompanhar minha solicitação?
                                    </button>
                                </h3>
                                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqSolicitacao">
                                    <div class="accordion-body">
                                        Use a página "Consultar Solicitação" e informe o número do protocolo que você 
                                        recebeu após enviar a solicitação. Você poderá ver o status atual, histórico 
                                        de tramitação e, quando disponível, a resposta completa.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq7">
                                        Que tipo de informação posso solicitar?
                                    </button>
                                </h3>
                                <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqSolicitacao">
                                    <div class="accordion-body">
                                        Você pode solicitar qualquer informação pública, como:
                                        <ul>
                                            <li>Atos legislativos e administrativos</li>
                                            <li>Orçamento e gastos públicos</li>
                                            <li>Contratos e convênios</li>
                                            <li>Folha de pagamento</li>
                                            <li>Licitações e compras</li>
                                            <li>Relatórios de gestão</li>
                                            <li>Estrutura organizacional</li>
                                        </ul>
                                        Não podem ser fornecidas informações sigilosas, dados pessoais de terceiros 
                                        ou informações que comprometam a segurança.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq8">
                                        Perdi meu número de protocolo, o que fazer?
                                    </button>
                                </h3>
                                <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqSolicitacao">
                                    <div class="accordion-body">
                                        Entre em contato conosco através dos canais oficiais (telefone ou e-mail) 
                                        informando seus dados pessoais e detalhes da solicitação. Nossa equipe poderá 
                                        localizar seu protocolo e fornecer as informações necessárias.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prazos -->
                    <div class="faq-section" data-category="prazos">
                        <h2 class="section-title">
                            <i class="fas fa-clock me-2"></i>
                            Prazos
                        </h2>
                        
                        <div class="accordion" id="faqPrazos">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq9">
                                        Qual o prazo para receber a resposta?
                                    </button>
                                </h3>
                                <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqPrazos">
                                    <div class="accordion-body">
                                        O prazo legal é de <strong>20 dias corridos</strong> a partir do registro da 
                                        solicitação. Em casos excepcionais, este prazo pode ser prorrogado por mais 
                                        <strong>10 dias corridos</strong>, mediante justificativa expressa.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq10">
                                        O que acontece se o prazo não for cumprido?
                                    </button>
                                </h3>
                                <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqPrazos">
                                    <div class="accordion-body">
                                        Se o prazo não for cumprido, você pode apresentar reclamação à Controladoria 
                                        ou órgão equivalente. O descumprimento de prazos da Lei de Acesso à Informação 
                                        pode resultar em responsabilização do servidor público responsável.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq11">
                                        Como são contados os prazos?
                                    </button>
                                </h3>
                                <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqPrazos">
                                    <div class="accordion-body">
                                        Os prazos são contados em <strong>dias corridos</strong> (incluindo sábados, 
                                        domingos e feriados), a partir do dia seguinte ao registro da solicitação no sistema. 
                                        O prazo se encerra no final do expediente do último dia.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recursos -->
                    <div class="faq-section" data-category="recursos">
                        <h2 class="section-title">
                            <i class="fas fa-gavel me-2"></i>
                            Recursos e Contestações
                        </h2>
                        
                        <div class="accordion" id="faqRecursos">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq12">
                                        Posso contestar uma resposta negativa?
                                    </button>
                                </h3>
                                <div id="faq12" class="accordion-collapse collapse" data-bs-parent="#faqRecursos">
                                    <div class="accordion-body">
                                        Sim, você tem o direito de apresentar recurso no prazo de <strong>10 dias corridos</strong> 
                                        a partir da ciência da decisão. O recurso deve ser dirigido à autoridade hierarquicamente 
                                        superior àquela que exarou a decisão impugnada.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq13">
                                        Como apresentar um recurso?
                                    </button>
                                </h3>
                                <div id="faq13" class="accordion-collapse collapse" data-bs-parent="#faqRecursos">
                                    <div class="accordion-body">
                                        Entre em contato conosco através dos canais oficiais informando:
                                        <ul>
                                            <li>Número do protocolo da solicitação original</li>
                                            <li>Motivos da contestação</li>
                                            <li>Argumentos que justifiquem o recurso</li>
                                            <li>Documentos que comprovem seu direito à informação</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq14">
                                        Quais são os motivos para negativa de informação?
                                    </button>
                                </h3>
                                <div id="faq14" class="accordion-collapse collapse" data-bs-parent="#faqRecursos">
                                    <div class="accordion-body">
                                        A informação pode ser negada quando:
                                        <ul>
                                            <li>For classificada como sigilosa</li>
                                            <li>Contiver dados pessoais de terceiros</li>
                                            <li>Puder comprometer a segurança pública</li>
                                            <li>Envolver segredos industriais</li>
                                            <li>Estiver em processo judicial sob sigilo</li>
                                            <li>For informação preparatória</li>
                                        </ul>
                                        A negativa deve sempre ser fundamentada e indicar a possibilidade de recurso.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Não encontrou sua dúvida? -->
                <div class="help-section">
                    <div class="help-card">
                        <h3><i class="fas fa-headset me-2"></i>Não encontrou sua dúvida?</h3>
                        <p>
                            Se você não encontrou a resposta para sua pergunta, entre em contato conosco 
                            através dos canais oficiais. Nossa equipe está pronta para ajudá-lo.
                        </p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="contact-option">
                                    <i class="fas fa-phone text-primary"></i>
                                    <h4>Telefone</h4>
                                    <p>(XX) XXXX-XXXX</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-option">
                                    <i class="fas fa-envelope text-primary"></i>
                                    <h4>E-mail</h4>
                                    <p>esic@camara.gov.br</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-option">
                                    <i class="fas fa-clock text-primary"></i>
                                    <h4>Horário</h4>
                                    <p>Seg-Sex: 8h às 17h</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="actions-section">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('esic.create') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-plus me-2"></i>
                                Nova Solicitação
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('esic.consultar') }}" class="btn btn-outline-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i>
                                Consultar Solicitação
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('esic.sobre') }}" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-info-circle me-2"></i>
                                Sobre o E-SIC
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/esic.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/esic-faq.js') }}"></script>
@endpush