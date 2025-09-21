@extends('layouts.app')

@section('title', 'E-SIC - Sistema Eletrônico do Serviço de Informação ao Cidadão')

@section('content')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.3rem;
    margin-bottom: 30px;
    opacity: 0.95;
    line-height: 1.6;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 50px;
    margin-top: 40px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    display: block;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.main-content {
    padding: 60px 0;
    background: #f8f9fa;
}

.section {
    margin-bottom: 60px;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 600;
    color: #333;
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2px;
}

.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.info-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border-left: 5px solid #667eea;
    position: relative;
    overflow: hidden;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-radius: 0 0 0 100px;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.card-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-bottom: 20px;
}

.card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.card-text {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.card-link {
    color: #667eea;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.card-link:hover {
    color: #5a6fd8;
    gap: 12px;
}

.form-section {
    background: white;
    border-radius: 20px;
    padding: 50px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    margin: 40px 0;
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.form-subtitle {
    color: #666;
    font-size: 1.1rem;
    line-height: 1.6;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.required {
    color: #dc3545;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 15px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
}

.form-text {
    font-size: 14px;
    color: #6c757d;
    margin-top: 5px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 10px;
    padding: 15px 40px;
    font-size: 16px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    background: linear-gradient(135deg, #5a6fd8, #6a5acd);
}

.btn-secondary {
    background: #6c757d;
    border: none;
    border-radius: 10px;
    padding: 15px 40px;
    font-size: 16px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.alert {
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 25px;
    border: none;
}

.alert-info {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    color: #667eea;
    border-left: 4px solid #667eea;
}

.steps-container {
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin: 40px 0;
}

.steps-timeline {
    position: relative;
    padding-left: 40px;
}

.steps-timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #667eea, #764ba2);
}

.step-item {
    position: relative;
    margin-bottom: 40px;
    padding-left: 40px;
}

.step-item::before {
    content: '';
    position: absolute;
    left: -29px;
    top: 5px;
    width: 20px;
    height: 20px;
    background: #667eea;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 0 0 2px #667eea;
}

.step-number {
    background: #667eea;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 15px;
}

.step-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.step-description {
    color: #666;
    line-height: 1.6;
}

.contact-info {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 15px;
    padding: 40px;
    text-align: center;
    margin: 40px 0;
}

.contact-title {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.contact-items {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
}

.contact-item i {
    font-size: 1.3rem;
    opacity: 0.9;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .form-section {
        padding: 30px 20px;
    }
    
    .info-cards {
        grid-template-columns: 1fr;
    }
    
    .contact-items {
        flex-direction: column;
        gap: 20px;
    }
    
    .steps-container {
        padding: 30px 20px;
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title">E-SIC</h1>
            <p class="hero-subtitle">
                Sistema Eletrônico do Serviço de Informação ao Cidadão<br>
                Solicite informações públicas de forma rápida e transparente
            </p>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['total_solicitacoes'] ?? '1.247' }}</span>
                    <span class="stat-label">Solicitações</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['tempo_medio'] ?? '3.2' }}</span>
                    <span class="stat-label">Dias (Tempo Médio)</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['satisfacao'] ?? '94' }}%</span>
                    <span class="stat-label">Satisfação</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Informações sobre o E-SIC -->
        <div class="section">
            <h2 class="section-title">O que é o E-SIC?</h2>
            
            <div class="info-cards">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3 class="card-title">Lei de Acesso à Informação</h3>
                    <p class="card-text">
                        Baseado na Lei Federal 12.527/2011, o E-SIC garante o direito fundamental de acesso às informações públicas.
                    </p>
                    <a href="#" class="card-link">
                        Saiba mais <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="card-title">Prazo de Resposta</h3>
                    <p class="card-text">
                        As solicitações são respondidas em até 20 dias, prorrogáveis por mais 10 dias mediante justificativa.
                    </p>
                    <a href="#consultar" class="card-link">
                        Consultar solicitação <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="card-title">Gratuito e Seguro</h3>
                    <p class="card-text">
                        O serviço é totalmente gratuito e suas informações pessoais são protegidas conforme a LGPD.
                    </p>
                    <a href="#solicitar" class="card-link">
                        Fazer solicitação <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Como Funciona -->
        <div class="section">
            <h2 class="section-title">Como Funciona</h2>
            
            <div class="steps-container">
                <div class="steps-timeline">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <h4 class="step-title">Faça sua Solicitação</h4>
                        <p class="step-description">
                            Preencha o formulário abaixo com sua solicitação de informação. Seja específico sobre o que deseja saber.
                        </p>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <h4 class="step-title">Receba o Protocolo</h4>
                        <p class="step-description">
                            Após enviar, você receberá um número de protocolo para acompanhar sua solicitação.
                        </p>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <h4 class="step-title">Acompanhe o Andamento</h4>
                        <p class="step-description">
                            Use o número de protocolo para consultar o status da sua solicitação a qualquer momento.
                        </p>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <h4 class="step-title">Receba a Resposta</h4>
                        <p class="step-description">
                            A resposta será enviada por email e ficará disponível para consulta no sistema.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de Solicitação -->
        <div class="section" id="solicitar">
            <div class="form-section">
                <div class="form-header">
                    <h2 class="form-title">Nova Solicitação de Informação</h2>
                    <p class="form-subtitle">
                        Preencha os campos abaixo para solicitar informações públicas da Câmara Municipal
                    </p>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Importante:</strong> Todas as informações fornecidas são confidenciais e utilizadas apenas para o processamento da sua solicitação.
                </div>

                <form method="POST" action="{{ route('esic.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Dados Pessoais -->
                    <h4 class="mb-4"><i class="fas fa-user me-2"></i>Dados Pessoais</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome" class="form-label">
                                    Nome Completo <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" name="nome" value="{{ old('nome') }}" required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    E-mail <span class="required">*</span>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                <div class="form-text">Você receberá a resposta neste e-mail</div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf" class="form-label">
                                    CPF <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                       id="cpf" name="cpf" value="{{ old('cpf') }}" 
                                       placeholder="000.000.000-00" required>
                                @error('cpf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                       id="telefone" name="telefone" value="{{ old('telefone') }}" 
                                       placeholder="(00) 00000-0000">
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_pessoa" class="form-label">
                                    Tipo de Pessoa <span class="required">*</span>
                                </label>
                                <select class="form-select @error('tipo_pessoa') is-invalid @enderror" 
                                        id="tipo_pessoa" name="tipo_pessoa" required>
                                    <option value="">Selecione</option>
                                    <option value="fisica" {{ old('tipo_pessoa') == 'fisica' ? 'selected' : '' }}>Pessoa Física</option>
                                    <option value="juridica" {{ old('tipo_pessoa') == 'juridica' ? 'selected' : '' }}>Pessoa Jurídica</option>
                                </select>
                                @error('tipo_pessoa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Solicitação -->
                    <h4 class="mb-4 mt-5"><i class="fas fa-file-alt me-2"></i>Informações da Solicitação</h4>
                    
                    <div class="form-group">
                        <label for="assunto" class="form-label">
                            Assunto <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('assunto') is-invalid @enderror" 
                               id="assunto" name="assunto" value="{{ old('assunto') }}" 
                               placeholder="Resumo da informação solicitada" required>
                        @error('assunto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao" class="form-label">
                            Descrição da Solicitação <span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" name="descricao" rows="6" 
                                  placeholder="Descreva detalhadamente a informação que você deseja obter..." required>{{ old('descricao') }}</textarea>
                        <div class="form-text">Seja específico sobre a informação desejada para agilizar o atendimento</div>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categoria" class="form-label">
                                    Categoria <span class="required">*</span>
                                </label>
                                <select class="form-select @error('categoria') is-invalid @enderror" 
                                        id="categoria" name="categoria" required>
                                    <option value="">Selecione uma categoria</option>
                                    <option value="legislativo" {{ old('categoria') == 'legislativo' ? 'selected' : '' }}>Atividade Legislativa</option>
                                    <option value="administrativo" {{ old('categoria') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                    <option value="financeiro" {{ old('categoria') == 'financeiro' ? 'selected' : '' }}>Financeiro</option>
                                    <option value="recursos_humanos" {{ old('categoria') == 'recursos_humanos' ? 'selected' : '' }}>Recursos Humanos</option>
                                    <option value="contratos" {{ old('categoria') == 'contratos' ? 'selected' : '' }}>Contratos e Licitações</option>
                                    <option value="outros" {{ old('categoria') == 'outros' ? 'selected' : '' }}>Outros</option>
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="forma_recebimento" class="form-label">
                                    Forma de Recebimento <span class="required">*</span>
                                </label>
                                <select class="form-select @error('forma_recebimento') is-invalid @enderror" 
                                        id="forma_recebimento" name="forma_recebimento" required>
                                    <option value="">Selecione</option>
                                    <option value="email" {{ old('forma_recebimento') == 'email' ? 'selected' : '' }}>E-mail</option>
                                    <option value="presencial" {{ old('forma_recebimento') == 'presencial' ? 'selected' : '' }}>Retirada Presencial</option>
                                    <option value="correio" {{ old('forma_recebimento') == 'correio' ? 'selected' : '' }}>Correio</option>
                                </select>
                                @error('forma_recebimento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Anexos -->
                    <div class="form-group">
                        <label for="anexos" class="form-label">Anexos (Opcional)</label>
                        <input type="file" class="form-control @error('anexos.*') is-invalid @enderror" 
                               id="anexos" name="anexos[]" multiple 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">
                            Formatos aceitos: PDF, DOC, DOCX, JPG, PNG. Tamanho máximo: 5MB por arquivo.
                        </div>
                        @error('anexos.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Termos -->
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input @error('aceito_termos') is-invalid @enderror" 
                                   type="checkbox" id="aceito_termos" name="aceito_termos" 
                                   value="1" {{ old('aceito_termos') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="aceito_termos">
                                Declaro que as informações fornecidas são verdadeiras e aceito os 
                                <a href="#" target="_blank">termos de uso</a> do sistema. <span class="required">*</span>
                            </label>
                            @error('aceito_termos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="text-center mt-4">
                        <button type="reset" class="btn btn-secondary me-3">
                            <i class="fas fa-times me-2"></i>Limpar Formulário
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Enviar Solicitação
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Consultar Solicitação -->
        <div class="section" id="consultar">
            <div class="form-section">
                <div class="form-header">
                    <h2 class="form-title">Consultar Solicitação</h2>
                    <p class="form-subtitle">
                        Digite o número do protocolo para acompanhar sua solicitação
                    </p>
                </div>

                <form method="GET" action="{{ route('esic.consultar') }}" class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="protocolo" class="form-label">Número do Protocolo</label>
                            <input type="text" class="form-control" id="protocolo" name="protocolo" 
                                   placeholder="Ex: 2024001234" value="{{ request('protocolo') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Consultar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informações de Contato -->
        <div class="contact-info">
            <h3 class="contact-title">Precisa de Ajuda?</h3>
            <div class="contact-items">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>(11) 1234-5678</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>esic@camara.gov.br</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Seg-Sex: 8h às 17h</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Máscara para CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = value;
});

// Máscara para telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{2})(\d)/, '($1) $2');
    value = value.replace(/(\d{5})(\d)/, '$1-$2');
    e.target.value = value;
});

// Validação do formulário
document.querySelector('form').addEventListener('submit', function(e) {
    const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
    
    if (cpf.length !== 11) {
        e.preventDefault();
        alert('Por favor, digite um CPF válido.');
        document.getElementById('cpf').focus();
        return;
    }
    
    if (!document.getElementById('aceito_termos').checked) {
        e.preventDefault();
        alert('Você deve aceitar os termos de uso para continuar.');
        document.getElementById('aceito_termos').focus();
        return;
    }
});
</script>
@endsection