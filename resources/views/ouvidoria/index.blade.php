@extends('layouts.app')

@section('title', 'Ouvidoria - Câmara Municipal')

@section('content')
<style>
.hero-section {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 2px;
}

.manifestation-types {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.type-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border-left: 5px solid #28a745;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.type-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: linear-gradient(45deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
    border-radius: 0 0 0 100px;
}

.type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.type-card.selected {
    border-left-color: #20c997;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.05), rgba(32, 201, 151, 0.05));
}

.card-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #28a745, #20c997);
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

.card-examples {
    font-size: 0.9rem;
    color: #28a745;
    font-style: italic;
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
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    background: white;
}

.form-text {
    font-size: 14px;
    color: #6c757d;
    margin-top: 5px;
}

.btn-primary {
    background: linear-gradient(135deg, #28a745, #20c997);
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
    box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #218838, #1ea085);
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
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
    color: #28a745;
    border-left: 4px solid #28a745;
}

.alert-warning {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.1));
    color: #856404;
    border-left: 4px solid #ffc107;
}

.contact-info {
    background: linear-gradient(135deg, #28a745, #20c997);
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

.anonymous-toggle {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
}

.anonymous-info {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.1));
    border: 1px solid #ffc107;
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
    display: none;
}

.anonymous-info.show {
    display: block;
}

.file-upload-area {
    border: 2px dashed #e9ecef;
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
}

.file-upload-area.dragover {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.1);
}

.upload-icon {
    font-size: 3rem;
    color: #28a745;
    margin-bottom: 15px;
}

.upload-text {
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 10px;
}

.upload-hint {
    font-size: 0.9rem;
    color: #666;
}

.file-list {
    margin-top: 20px;
}

.file-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 15px;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 10px;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.file-icon {
    color: #28a745;
}

.file-name {
    font-weight: 500;
}

.file-size {
    font-size: 0.9rem;
    color: #666;
}

.file-remove {
    color: #dc3545;
    cursor: pointer;
    padding: 5px;
}

.file-remove:hover {
    background: rgba(220, 53, 69, 0.1);
    border-radius: 4px;
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
    
    .manifestation-types {
        grid-template-columns: 1fr;
    }
    
    .contact-items {
        flex-direction: column;
        gap: 20px;
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title">Ouvidoria</h1>
            <p class="hero-subtitle">
                Canal direto de comunicação com a Câmara Municipal<br>
                Sua voz é importante para melhorarmos nossos serviços
            </p>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['total_manifestacoes'] ?? '2.156' }}</span>
                    <span class="stat-label">Manifestações</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['tempo_medio'] ?? '5.8' }}</span>
                    <span class="stat-label">Dias (Tempo Médio)</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['satisfacao'] ?? '91' }}%</span>
                    <span class="stat-label">Satisfação</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Tipos de Manifestação -->
        <div class="section">
            <h2 class="section-title">Tipos de Manifestação</h2>
            
            <div class="manifestation-types">
                <div class="type-card" data-type="reclamacao">
                    <div class="card-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="card-title">Reclamação</h3>
                    <p class="card-text">
                        Manifestação de insatisfação relativa a serviços públicos prestados pela Câmara Municipal.
                    </p>
                    <p class="card-examples">
                        Ex: Demora no atendimento, falha na prestação de serviços, problemas no site.
                    </p>
                </div>
                
                <div class="type-card" data-type="denuncia">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="card-title">Denúncia</h3>
                    <p class="card-text">
                        Comunicação de irregularidades, ilegalidades ou condutas inadequadas de servidores.
                    </p>
                    <p class="card-examples">
                        Ex: Corrupção, abuso de poder, descumprimento de normas.
                    </p>
                </div>
                
                <div class="type-card" data-type="sugestao">
                    <div class="card-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="card-title">Sugestão</h3>
                    <p class="card-text">
                        Propostas para melhoria dos serviços públicos prestados pela Câmara Municipal.
                    </p>
                    <p class="card-examples">
                        Ex: Melhorias no atendimento, novos serviços, otimização de processos.
                    </p>
                </div>
                
                <div class="type-card" data-type="elogio">
                    <div class="card-icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <h3 class="card-title">Elogio</h3>
                    <p class="card-text">
                        Manifestação de satisfação ou reconhecimento pela qualidade dos serviços prestados.
                    </p>
                    <p class="card-examples">
                        Ex: Bom atendimento, eficiência, cortesia dos servidores.
                    </p>
                </div>
                
                <div class="type-card" data-type="solicitacao">
                    <div class="card-icon">
                        <i class="fas fa-hand-paper"></i>
                    </div>
                    <h3 class="card-title">Solicitação</h3>
                    <p class="card-text">
                        Pedido de providências ou informações sobre serviços da Câmara Municipal.
                    </p>
                    <p class="card-examples">
                        Ex: Solicitação de documentos, esclarecimentos, providências.
                    </p>
                </div>
                
                <div class="type-card" data-type="informacao">
                    <div class="card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3 class="card-title">Pedido de Informação</h3>
                    <p class="card-text">
                        Solicitação de informações sobre atividades e serviços da Câmara Municipal.
                    </p>
                    <p class="card-examples">
                        Ex: Horários de funcionamento, procedimentos, contatos.
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulário de Manifestação -->
        <div class="section" id="manifestacao">
            <div class="form-section">
                <div class="form-header">
                    <h2 class="form-title">Nova Manifestação</h2>
                    <p class="form-subtitle">
                        Preencha o formulário abaixo para registrar sua manifestação
                    </p>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Importante:</strong> Todas as manifestações são analisadas e respondidas no prazo de até 30 dias.
                </div>

                <form method="POST" action="{{ route('ouvidoria.store') }}" enctype="multipart/form-data" id="manifestacaoForm">
                    @csrf
                    
                    <!-- Tipo de Manifestação -->
                    <div class="form-group">
                        <label for="tipo" class="form-label">
                            Tipo de Manifestação <span class="required">*</span>
                        </label>
                        <select class="form-select @error('tipo') is-invalid @enderror" 
                                id="tipo" name="tipo" required>
                            <option value="">Selecione o tipo</option>
                            <option value="reclamacao" {{ old('tipo') == 'reclamacao' ? 'selected' : '' }}>Reclamação</option>
                            <option value="denuncia" {{ old('tipo') == 'denuncia' ? 'selected' : '' }}>Denúncia</option>
                            <option value="sugestao" {{ old('tipo') == 'sugestao' ? 'selected' : '' }}>Sugestão</option>
                            <option value="elogio" {{ old('tipo') == 'elogio' ? 'selected' : '' }}>Elogio</option>
                            <option value="solicitacao" {{ old('tipo') == 'solicitacao' ? 'selected' : '' }}>Solicitação</option>
                            <option value="informacao" {{ old('tipo') == 'informacao' ? 'selected' : '' }}>Pedido de Informação</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Manifestação Anônima -->
                    <div class="anonymous-toggle">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="anonima" name="anonima" 
                                   value="1" {{ old('anonima') ? 'checked' : '' }}>
                            <label class="form-check-label" for="anonima">
                                <strong>Manifestação Anônima</strong>
                            </label>
                        </div>
                        <div class="anonymous-info" id="anonymousInfo">
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Atenção:</strong> Manifestações anônimas não permitem retorno direto. 
                                Recomendamos identificar-se para receber resposta sobre sua manifestação.
                            </div>
                        </div>
                    </div>

                    <!-- Dados Pessoais (ocultos se anônima) -->
                    <div id="dadosPessoais">
                        <h4 class="mb-4"><i class="fas fa-user me-2"></i>Dados Pessoais</h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome" class="form-label">
                                        Nome Completo <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" name="nome" value="{{ old('nome') }}">
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
                                           id="email" name="email" value="{{ old('email') }}">
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
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" name="cpf" value="{{ old('cpf') }}" 
                                           placeholder="000.000.000-00">
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
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                           id="cidade" name="cidade" value="{{ old('cidade') }}">
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados da Manifestação -->
                    <h4 class="mb-4 mt-5"><i class="fas fa-file-alt me-2"></i>Dados da Manifestação</h4>
                    
                    <div class="form-group">
                        <label for="assunto" class="form-label">
                            Assunto <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('assunto') is-invalid @enderror" 
                               id="assunto" name="assunto" value="{{ old('assunto') }}" 
                               placeholder="Resumo da sua manifestação" required>
                        @error('assunto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao" class="form-label">
                            Descrição <span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" name="descricao" rows="6" 
                                  placeholder="Descreva detalhadamente sua manifestação..." required>{{ old('descricao') }}</textarea>
                        <div class="form-text">Seja claro e objetivo para facilitar nossa análise</div>
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
                                    <option value="atendimento" {{ old('categoria') == 'atendimento' ? 'selected' : '' }}>Atendimento ao Público</option>
                                    <option value="legislativo" {{ old('categoria') == 'legislativo' ? 'selected' : '' }}>Atividade Legislativa</option>
                                    <option value="administrativo" {{ old('categoria') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                    <option value="transparencia" {{ old('categoria') == 'transparencia' ? 'selected' : '' }}>Transparência</option>
                                    <option value="infraestrutura" {{ old('categoria') == 'infraestrutura' ? 'selected' : '' }}>Infraestrutura</option>
                                    <option value="tecnologia" {{ old('categoria') == 'tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                                    <option value="outros" {{ old('categoria') == 'outros' ? 'selected' : '' }}>Outros</option>
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prioridade" class="form-label">Prioridade</label>
                                <select class="form-select @error('prioridade') is-invalid @enderror" 
                                        id="prioridade" name="prioridade">
                                    <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                    <option value="media" {{ old('prioridade', 'media') == 'media' ? 'selected' : '' }}>Média</option>
                                    <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('prioridade') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('prioridade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Upload de Anexos -->
                    <div class="form-group">
                        <label class="form-label">Anexos (Opcional)</label>
                        <div class="file-upload-area" id="fileUploadArea">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">
                                Clique aqui ou arraste arquivos para anexar
                            </div>
                            <div class="upload-hint">
                                Formatos aceitos: PDF, DOC, DOCX, JPG, PNG, MP4<br>
                                Tamanho máximo: 10MB por arquivo
                            </div>
                            <input type="file" id="anexos" name="anexos[]" multiple 
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.mp4" style="display: none;">
                        </div>
                        <div class="file-list" id="fileList"></div>
                        @error('anexos.*')
                            <div class="text-danger mt-2">{{ $message }}</div>
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
                                <a href="#" target="_blank">termos de uso</a> da Ouvidoria. <span class="required">*</span>
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
                            <i class="fas fa-paper-plane me-2"></i>Enviar Manifestação
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Consultar Manifestação -->
        <div class="section" id="consultar">
            <div class="form-section">
                <div class="form-header">
                    <h2 class="form-title">Consultar Manifestação</h2>
                    <p class="form-subtitle">
                        Digite o número do protocolo para acompanhar sua manifestação
                    </p>
                </div>

                <form method="GET" action="{{ route('ouvidoria.consultar') }}" class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="protocolo" class="form-label">Número do Protocolo</label>
                            <input type="text" class="form-control" id="protocolo" name="protocolo" 
                                   placeholder="Ex: OUV2024001234" value="{{ request('protocolo') }}" required>
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
            <h3 class="contact-title">Fale Conosco</h3>
            <div class="contact-items">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>(11) 1234-5678</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>ouvidoria@camara.gov.br</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Seg-Sex: 8h às 17h</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Rua da Câmara, 123 - Centro</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Seleção de tipo de manifestação
document.querySelectorAll('.type-card').forEach(card => {
    card.addEventListener('click', function() {
        // Remove seleção anterior
        document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
        
        // Adiciona seleção atual
        this.classList.add('selected');
        
        // Atualiza o select
        const tipo = this.dataset.type;
        document.getElementById('tipo').value = tipo;
        
        // Scroll para o formulário
        document.getElementById('manifestacao').scrollIntoView({ behavior: 'smooth' });
    });
});

// Toggle manifestação anônima
document.getElementById('anonima').addEventListener('change', function() {
    const dadosPessoais = document.getElementById('dadosPessoais');
    const anonymousInfo = document.getElementById('anonymousInfo');
    const nomeField = document.getElementById('nome');
    const emailField = document.getElementById('email');
    
    if (this.checked) {
        dadosPessoais.style.display = 'none';
        anonymousInfo.classList.add('show');
        nomeField.removeAttribute('required');
        emailField.removeAttribute('required');
    } else {
        dadosPessoais.style.display = 'block';
        anonymousInfo.classList.remove('show');
        nomeField.setAttribute('required', 'required');
        emailField.setAttribute('required', 'required');
    }
});

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

// Upload de arquivos
const fileUploadArea = document.getElementById('fileUploadArea');
const fileInput = document.getElementById('anexos');
const fileList = document.getElementById('fileList');
let selectedFiles = [];

fileUploadArea.addEventListener('click', () => fileInput.click());

fileUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileUploadArea.classList.add('dragover');
});

fileUploadArea.addEventListener('dragleave', () => {
    fileUploadArea.classList.remove('dragover');
});

fileUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    fileUploadArea.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});

fileInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    Array.from(files).forEach(file => {
        if (file.size <= 10 * 1024 * 1024) { // 10MB
            selectedFiles.push(file);
            addFileToList(file);
        } else {
            alert(`Arquivo ${file.name} é muito grande. Tamanho máximo: 10MB`);
        }
    });
    updateFileInput();
}

function addFileToList(file) {
    const fileItem = document.createElement('div');
    fileItem.className = 'file-item';
    fileItem.innerHTML = `
        <div class="file-info">
            <i class="fas fa-file file-icon"></i>
            <span class="file-name">${file.name}</span>
            <span class="file-size">(${formatFileSize(file.size)})</span>
        </div>
        <i class="fas fa-times file-remove" onclick="removeFile('${file.name}')"></i>
    `;
    fileList.appendChild(fileItem);
}

function removeFile(fileName) {
    selectedFiles = selectedFiles.filter(file => file.name !== fileName);
    updateFileInput();
    renderFileList();
}

function renderFileList() {
    fileList.innerHTML = '';
    selectedFiles.forEach(file => addFileToList(file));
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Validação do formulário
document.getElementById('manifestacaoForm').addEventListener('submit', function(e) {
    const anonima = document.getElementById('anonima').checked;
    
    if (!anonima) {
        const nome = document.getElementById('nome').value.trim();
        const email = document.getElementById('email').value.trim();
        
        if (!nome || !email) {
            e.preventDefault();
            alert('Nome e e-mail são obrigatórios para manifestações identificadas.');
            return;
        }
    }
    
    if (!document.getElementById('aceito_termos').checked) {
        e.preventDefault();
        alert('Você deve aceitar os termos de uso para continuar.');
        document.getElementById('aceito_termos').focus();
        return;
    }
});

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se manifestação anônima está marcada
    if (document.getElementById('anonima').checked) {
        document.getElementById('anonima').dispatchEvent(new Event('change'));
    }
});
</script>
@endsection