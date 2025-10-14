@extends('layouts.app')

@section('title', 'Contato - Câmara Municipal')

@section('content')
<div class="contato-page">
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contato</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="page-header text-center">
                <h1 class="display-4 text-primary mb-3">
                    <i class="fas fa-phone me-3"></i>
                    Entre em Contato
                </h1>
                <p class="lead text-muted">Estamos aqui para atender você e esclarecer suas dúvidas</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informações de Contato -->
        <div class="col-lg-4 mb-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informações de Contato
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Endereço -->
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <div class="contact-info">
                                <h5 class="mb-2">Endereço</h5>
                                <p class="text-muted mb-0">
                                    Rua da Câmara Municipal, 123<br>
                                    Centro - CEP: 12345-678<br>
                                    Cidade - Estado
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Telefones -->
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon">
                                <i class="fas fa-phone fa-2x text-primary"></i>
                            </div>
                            <div class="contact-info">
                                <h5 class="mb-2">Telefones</h5>
                                <p class="text-muted mb-1">
                                    <strong>Geral:</strong> (11) 1234-5678
                                </p>
                                <p class="text-muted mb-1">
                                    <strong>Protocolo:</strong> (11) 1234-5679
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Ouvidoria:</strong> (11) 1234-5680
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                            </div>
                            <div class="contact-info">
                                <h5 class="mb-2">E-mail</h5>
                                <p class="text-muted mb-1">
                                    <strong>Geral:</strong><br>
                                    <a href="mailto:contato@camara.gov.br">contato@camara.gov.br</a>
                                </p>
                                <p class="text-muted mb-1">
                                    <strong>Protocolo:</strong><br>
                                    <a href="mailto:protocolo@camara.gov.br">protocolo@camara.gov.br</a>
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Ouvidoria:</strong><br>
                                    <a href="mailto:ouvidoria@camara.gov.br">ouvidoria@camara.gov.br</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Horário de Funcionamento -->
                    <div class="contact-item">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon">
                                <i class="fas fa-clock fa-2x text-primary"></i>
                            </div>
                            <div class="contact-info">
                                <h5 class="mb-2">Horário de Funcionamento</h5>
                                <p class="text-muted mb-1">
                                    <strong>Segunda a Sexta:</strong><br>
                                    8h00 às 12h00 e 13h30 às 17h30
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Sessões:</strong><br>
                                    Conforme calendário oficial
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de Contato -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-paper-plane me-2"></i>
                        Envie sua Mensagem
                    </h3>
                </div>
                <div class="card-body p-4">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="nome" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="telefone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="assunto" class="form-label">Assunto *</label>
                                <select class="form-select" id="assunto" required>
                                    <option value="">Selecione o assunto</option>
                                    <option value="informacao">Solicitação de Informação</option>
                                    <option value="sugestao">Sugestão</option>
                                    <option value="reclamacao">Reclamação</option>
                                    <option value="elogio">Elogio</option>
                                    <option value="denuncia">Denúncia</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Mensagem *</label>
                            <textarea class="form-control" id="mensagem" rows="6" required 
                                placeholder="Descreva sua solicitação, sugestão ou dúvida..."></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="privacidade" required>
                                <label class="form-check-label" for="privacidade">
                                    Concordo com a <a href="#" target="_blank">Política de Privacidade</a> 
                                    e autorizo o tratamento dos meus dados pessoais *
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Enviar Mensagem
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Canais Alternativos -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Outros Canais de Atendimento
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="channel-item">
                                <i class="fas fa-headset fa-3x text-info mb-3"></i>
                                <h5>Ouvidoria</h5>
                                <p class="text-muted">Para reclamações, sugestões e denúncias</p>
                                <a href="{{ route('ouvidoria.index') }}" class="btn btn-outline-info">
                                    Acessar Ouvidoria
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="channel-item">
                                <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                                <h5>e-SIC</h5>
                                <p class="text-muted">Serviço de Informação ao Cidadão</p>
                                <a href="{{ route('esic.index') }}" class="btn btn-outline-info">
                                    Acessar e-SIC
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="channel-item">
                                <i class="fas fa-calendar-alt fa-3x text-info mb-3"></i>
                                <h5>Agendamento</h5>
                                <p class="text-muted">Agende uma visita ou reunião</p>
                                <a href="#" class="btn btn-outline-info">
                                    Agendar Visita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa (Placeholder) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-map me-2"></i>
                        Localização
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="map-placeholder">
                        <div class="map-content">
                            <i class="fas fa-map-marked-alt fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Mapa Interativo</h5>
                            <p class="text-muted">
                                Rua da Câmara Municipal, 123 - Centro<br>
                                CEP: 12345-678 - Cidade/Estado
                            </p>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-external-link-alt me-2"></i>
                                Ver no Google Maps
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
/* Tematização escopada para a página de Contato */
.contato-page .page-header {
    border-bottom: 3px solid var(--theme-primary, #007bff);
    padding-bottom: 2rem;
}

.contato-page .page-header h1 {
    color: var(--theme-heading, #2c3e50);
}

.contato-page .page-header .lead {
    color: var(--theme-text-muted, #6c757d);
}

.contato-page .text-primary,
.contato-page .text-info,
.contato-page .text-success,
.contato-page .text-secondary {
    color: var(--theme-primary, #007bff) !important;
}

.contato-page a {
    color: var(--theme-primary, #007bff);
}

.contato-page .card-header.bg-primary,
.contato-page .card-header.bg-success,
.contato-page .card-header.bg-info,
.contato-page .card-header.bg-secondary {
    background: linear-gradient(135deg, var(--theme-primary, #667eea) 0%, var(--theme-primary-dark, #764ba2) 100%);
    color: #fff;
}

.contato-page .contact-item {
    border-bottom: 1px solid var(--theme-border, #e9ecef);
    padding-bottom: 1.5rem;
}

.contato-page .contact-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.contato-page .contact-icon {
    margin-right: 1rem;
    min-width: 60px;
}

.contato-page .contact-info h5 {
    color: var(--theme-heading, #2c3e50);
}

.contato-page .channel-item {
    padding: 1.5rem;
    border-radius: 0.5rem;
    transition: transform 0.3s ease;
}

.contato-page .channel-item:hover {
    transform: translateY(-5px);
    background-color: var(--theme-light, #f8f9fa);
}

.contato-page .map-placeholder {
    height: 300px;
    background: linear-gradient(135deg, var(--theme-light, #f8f9fa) 0%, var(--theme-border, #e9ecef) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.contato-page .map-content {
    text-align: center;
}

.contato-page .form-control:focus,
.contato-page .form-select:focus {
    border-color: var(--theme-primary, #007bff);
    box-shadow: 0 0 0 0.2rem var(--theme-primary-shadow, rgba(0, 123, 255, 0.25));
}

.contato-page .btn-success {
    background-color: var(--theme-primary, #007bff);
    border-color: var(--theme-primary, #007bff);
}

.contato-page .btn-success:hover {
    background-color: var(--theme-primary-dark, #0056b3);
    border-color: var(--theme-primary-dark, #0056b3);
}

.contato-page .btn-outline-info {
    color: var(--theme-primary, #007bff);
    border-color: var(--theme-primary, #007bff);
}

.contato-page .btn-outline-info:hover {
    background: var(--theme-primary, #007bff);
    color: #fff;
}
</style>
@endsection