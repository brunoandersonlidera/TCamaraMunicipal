@extends('layouts.app')

@section('title', 'Sobre o E-SIC')

@section('content')
<div class="esic-sobre-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="fas fa-info-circle me-3"></i>
                        Sobre o E-SIC
                    </h1>
                    <p class="page-subtitle">
                        Sistema Eletrônico do Serviço de Informação ao Cidadão
                    </p>
                </div>

                <!-- O que é o E-SIC -->
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-question-circle me-2"></i>O que é o E-SIC?</h2>
                    </div>
                    <div class="card-body">
                        <p>
                            O E-SIC (Sistema Eletrônico do Serviço de Informação ao Cidadão) é uma plataforma digital 
                            que permite aos cidadãos solicitarem informações públicas da Câmara Municipal de forma 
                            rápida, fácil e transparente.
                        </p>
                        <p>
                            Este sistema foi desenvolvido em conformidade com a <strong>Lei nº 12.527/2011</strong> 
                            (Lei de Acesso à Informação), que regulamenta o direito constitucional de acesso às 
                            informações públicas.
                        </p>
                    </div>
                </div>

                <!-- Lei de Acesso à Informação -->
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-gavel me-2"></i>Lei de Acesso à Informação</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p>
                                    A Lei de Acesso à Informação (LAI) garante a qualquer pessoa, física ou jurídica, 
                                    o direito de receber dos órgãos públicos informações de seu interesse particular 
                                    ou de interesse coletivo ou geral.
                                </p>
                                <h4>Princípios da LAI:</h4>
                                <ul>
                                    <li>Publicidade como regra geral</li>
                                    <li>Sigilo como exceção</li>
                                    <li>Divulgação de informações de interesse público</li>
                                    <li>Utilização de meios de comunicação viabilizados pela tecnologia</li>
                                    <li>Fomento ao desenvolvimento da cultura de transparência</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="highlight-box">
                                    <h4><i class="fas fa-calendar-alt me-2"></i>Lei nº 12.527/2011</h4>
                                    <p><strong>Vigência:</strong> 16 de maio de 2012</p>
                                    <p><strong>Aplicação:</strong> Todos os órgãos públicos</p>
                                    <a href="http://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm" 
                                       target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i>
                                        Ler Lei Completa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Como Funciona -->
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-cogs me-2"></i>Como Funciona</h2>
                    </div>
                    <div class="card-body">
                        <div class="process-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Faça sua Solicitação</h4>
                                    <p>Preencha o formulário com suas informações e descreva detalhadamente a informação desejada.</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h4>Receba o Protocolo</h4>
                                    <p>Após o envio, você receberá um número de protocolo para acompanhar sua solicitação.</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h4>Acompanhe o Status</h4>
                                    <p>Use o número do protocolo para consultar o andamento da sua solicitação.</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-content">
                                    <h4>Receba a Resposta</h4>
                                    <p>A resposta será enviada no prazo de até 20 dias corridos pela forma escolhida.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prazos e Procedimentos -->
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-clock me-2"></i>Prazos e Procedimentos</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Prazos Legais</h4>
                                <div class="timeline-simple">
                                    <div class="timeline-item">
                                        <strong>20 dias corridos</strong>
                                        <p>Prazo para resposta inicial</p>
                                    </div>
                                    <div class="timeline-item">
                                        <strong>+10 dias corridos</strong>
                                        <p>Prorrogação (em casos excepcionais)</p>
                                    </div>
                                    <div class="timeline-item">
                                        <strong>10 dias corridos</strong>
                                        <p>Prazo para recurso em caso de negativa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Formas de Recebimento</h4>
                                <ul class="list-styled">
                                    <li><i class="fas fa-envelope text-primary me-2"></i><strong>E-mail:</strong> Mais rápido e ecológico</li>
                                    <li><i class="fas fa-building text-primary me-2"></i><strong>Presencial:</strong> Retirada na Câmara Municipal</li>
                                    <li><i class="fas fa-mail-bulk text-primary me-2"></i><strong>Correio:</strong> Envio pelos Correios</li>
                                </ul>
                                
                                <h4 class="mt-4">Custos</h4>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Gratuito:</strong> O acesso à informação é um direito e não tem custo.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tipos de Informação -->
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-list me-2"></i>Tipos de Informação Disponíveis</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-success"><i class="fas fa-check me-2"></i>Informações Públicas</h4>
                                <ul>
                                    <li>Atos legislativos e administrativos</li>
                                    <li>Orçamento e execução financeira</li>
                                    <li>Contratos e convênios</li>
                                    <li>Folha de pagamento</li>
                                    <li>Licitações e compras</li>
                                    <li>Estrutura organizacional</li>
                                    <li>Programas e projetos</li>
                                    <li>Relatórios de gestão</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-danger"><i class="fas fa-times me-2"></i>Informações Restritas</h4>
                                <ul>
                                    <li>Dados pessoais de terceiros</li>
                                    <li>Informações sigilosas</li>
                                    <li>Segredos industriais</li>
                                    <li>Informações em processo judicial</li>
                                    <li>Dados que possam comprometer a segurança</li>
                                    <li>Informações preparatórias</li>
                                </ul>
                                <div class="alert alert-warning mt-3">
                                    <small>
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Informações restritas podem ser negadas com justificativa legal.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Direitos e Deveres -->
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-balance-scale me-2"></i>Direitos e Deveres</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Seus Direitos</h4>
                                <ul class="rights-list">
                                    <li>Solicitar informações públicas</li>
                                    <li>Receber resposta no prazo legal</li>
                                    <li>Ter acesso gratuito às informações</li>
                                    <li>Apresentar recurso em caso de negativa</li>
                                    <li>Ser informado sobre a tramitação</li>
                                    <li>Manter o anonimato (se desejar)</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4>Seus Deveres</h4>
                                <ul class="duties-list">
                                    <li>Fornecer informações verdadeiras</li>
                                    <li>Ser específico na solicitação</li>
                                    <li>Respeitar os prazos estabelecidos</li>
                                    <li>Usar as informações de forma ética</li>
                                    <li>Não solicitar informações sigilosas</li>
                                    <li>Aguardar o prazo legal de resposta</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contato e Suporte -->
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-headset me-2"></i>Contato e Suporte</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="fas fa-phone text-primary"></i>
                                    <h4>Telefone</h4>
                                    <p>(XX) XXXX-XXXX</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="fas fa-envelope text-primary"></i>
                                    <h4>E-mail</h4>
                                    <p>esic@camara.gov.br</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    <h4>Endereço</h4>
                                    <p>Câmara Municipal<br>Centro - Cidade/UF</p>
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
                            <a href="{{ route('esic.faq') }}" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-question-circle me-2"></i>
                                Perguntas Frequentes
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