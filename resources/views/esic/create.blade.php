@extends('layouts.app')

@section('title', 'Nova Solicitação - E-SIC')

@section('content')
<div class="esic-create-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="fas fa-plus-circle me-3"></i>
                        Nova Solicitação E-SIC
                    </h1>
                    <p class="page-subtitle">
                        Preencha o formulário abaixo para solicitar informações públicas da Câmara Municipal
                    </p>
                </div>

                <!-- Alertas -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i>Atenção!</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <h5><i class="fas fa-check-circle me-2"></i>Sucesso!</h5>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Formulário -->
                <div class="form-card">
                    <form action="{{ route('esic.store') }}" method="POST" id="esicForm">
                        @csrf

                        <!-- Dados do Solicitante -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-user me-2"></i>
                                Dados do Solicitante
                            </h3>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nome_solicitante" class="form-label required">Nome Completo</label>
                                    <input type="text" class="form-control" id="nome_solicitante" name="nome_solicitante" 
                                           value="{{ old('nome_solicitante') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cpf_solicitante" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf_solicitante" name="cpf_solicitante" 
                                           value="{{ old('cpf_solicitante') }}" placeholder="000.000.000-00">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="email_solicitante" class="form-label required">E-mail</label>
                                    <input type="email" class="form-control" id="email_solicitante" name="email_solicitante" 
                                           value="{{ old('email_solicitante') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="telefone_solicitante" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone_solicitante" name="telefone_solicitante" 
                                           value="{{ old('telefone_solicitante') }}" placeholder="(00) 00000-0000">
                                </div>
                            </div>
                        </div>

                        <!-- Dados da Solicitação -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-file-alt me-2"></i>
                                Dados da Solicitação
                            </h3>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="assunto" class="form-label required">Assunto</label>
                                    <input type="text" class="form-control" id="assunto" name="assunto" 
                                           value="{{ old('assunto') }}" required 
                                           placeholder="Resumo do que você está solicitando">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="categoria" class="form-label required">Categoria</label>
                                    <select class="form-select" id="categoria" name="categoria" required>
                                        <option value="">Selecione...</option>
                                        <option value="atos_legislativos" {{ old('categoria') == 'atos_legislativos' ? 'selected' : '' }}>Atos Legislativos</option>
                                        <option value="informacoes_financeiras" {{ old('categoria') == 'informacoes_financeiras' ? 'selected' : '' }}>Informações Financeiras</option>
                                        <option value="informacoes_administrativas" {{ old('categoria') == 'informacoes_administrativas' ? 'selected' : '' }}>Informações Administrativas</option>
                                        <option value="documentos_publicos" {{ old('categoria') == 'documentos_publicos' ? 'selected' : '' }}>Documentos Públicos</option>
                                        <option value="outros" {{ old('categoria') == 'outros' ? 'selected' : '' }}>Outros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label required">Descrição Detalhada</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="6" required 
                                          placeholder="Descreva detalhadamente a informação que você está solicitando...">{{ old('descricao') }}</textarea>
                                <div class="form-text">
                                    Seja específico sobre a informação desejada. Quanto mais detalhada for sua solicitação, 
                                    mais precisa será a resposta.
                                </div>
                            </div>
                        </div>

                        <!-- Forma de Recebimento -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-envelope me-2"></i>
                                Forma de Recebimento da Resposta
                            </h3>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="forma_recebimento" id="email" 
                                           value="email" {{ old('forma_recebimento', 'email') == 'email' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email">
                                        <strong>E-mail</strong> - Receber resposta por e-mail (recomendado)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="forma_recebimento" id="presencial" 
                                           value="presencial" {{ old('forma_recebimento') == 'presencial' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="presencial">
                                        <strong>Presencial</strong> - Retirar resposta na Câmara Municipal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="forma_recebimento" id="correio" 
                                           value="correio" {{ old('forma_recebimento') == 'correio' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="correio">
                                        <strong>Correio</strong> - Receber resposta pelo correio
                                    </label>
                                </div>
                            </div>

                            <div id="endereco_section" class="mb-3" style="display: none;">
                                <label for="endereco_solicitante" class="form-label required">Endereço Completo</label>
                                <textarea class="form-control" id="endereco_solicitante" name="endereco_solicitante" rows="3" 
                                          placeholder="Rua, número, complemento, bairro, cidade, CEP">{{ old('endereco_solicitante') }}</textarea>
                            </div>
                        </div>

                        <!-- Opções Adicionais -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-cog me-2"></i>
                                Opções Adicionais
                            </h3>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="anonima" name="anonima" 
                                       {{ old('anonima') ? 'checked' : '' }}>
                                <label class="form-check-label" for="anonima">
                                    <strong>Solicitação Anônima</strong> - Não identificar o solicitante na resposta pública
                                </label>
                                <div class="form-text">
                                    Marque esta opção se desejar que sua identidade não seja divulgada caso a resposta 
                                    seja publicada no portal da transparência.
                                </div>
                            </div>
                        </div>

                        <!-- Termos de Uso -->
                        <div class="form-section">
                            <div class="terms-box">
                                <h4><i class="fas fa-shield-alt me-2"></i>Termos de Uso e Privacidade</h4>
                                <p>
                                    Ao enviar esta solicitação, você declara que:
                                </p>
                                <ul>
                                    <li>As informações fornecidas são verdadeiras</li>
                                    <li>Está ciente dos prazos estabelecidos pela Lei de Acesso à Informação</li>
                                    <li>Concorda com o tratamento de seus dados conforme nossa Política de Privacidade</li>
                                    <li>Entende que informações sigilosas não serão fornecidas</li>
                                </ul>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aceite_termos" name="aceite_termos" 
                                           required {{ old('aceite_termos') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="aceite_termos">
                                        <strong>Aceito os termos de uso e política de privacidade</strong>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Enviar Solicitação
                            </button>
                            <a href="{{ route('esic.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Voltar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Informações Importantes -->
                <div class="info-box mt-4">
                    <h4><i class="fas fa-info-circle me-2"></i>Informações Importantes</h4>
                    <ul>
                        <li><strong>Prazo:</strong> A resposta será fornecida em até 20 dias corridos</li>
                        <li><strong>Protocolo:</strong> Após o envio, você receberá um número de protocolo para acompanhamento</li>
                        <li><strong>Gratuito:</strong> Este serviço é totalmente gratuito</li>
                        <li><strong>Dúvidas:</strong> Em caso de dúvidas, consulte nossa seção de <a href="{{ route('esic.faq') }}">Perguntas Frequentes</a></li>
                    </ul>
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
<script src="{{ asset('js/esic-form.js') }}"></script>
@endpush