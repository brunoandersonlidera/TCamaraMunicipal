@extends('layouts.app')

@section('title', 'Política de Privacidade')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Política de Privacidade
                    </h4>
                </div>

                <div class="card-body">
                    <div class="privacy-content">
                        <p class="lead">
                            A Câmara Municipal está comprometida com a proteção da sua privacidade e dos seus dados pessoais, 
                            em conformidade com a Lei Geral de Proteção de Dados (LGPD - Lei nº 13.709/2018).
                        </p>

                        <h5>1. Informações que Coletamos</h5>
                        <p>Coletamos as seguintes informações quando você utiliza nossos serviços:</p>
                        
                        <h6>1.1 Dados Fornecidos por Você:</h6>
                        <ul>
                            <li>Nome completo</li>
                            <li>Endereço de e-mail</li>
                            <li>Dados de identificação (quando necessário para serviços específicos)</li>
                            <li>Informações fornecidas em formulários e solicitações</li>
                        </ul>

                        <h6>1.2 Dados Coletados Automaticamente:</h6>
                        <ul>
                            <li>Endereço IP</li>
                            <li>Informações do navegador</li>
                            <li>Data e hora de acesso</li>
                            <li>Páginas visitadas</li>
                            <li>Cookies e tecnologias similares</li>
                        </ul>

                        <h5>2. Como Utilizamos suas Informações</h5>
                        <p>Utilizamos suas informações para:</p>
                        <ul>
                            <li>Fornecer e melhorar nossos serviços</li>
                            <li>Processar solicitações via e-SIC</li>
                            <li>Gerenciar manifestações na Ouvidoria</li>
                            <li>Enviar notificações sobre o andamento de seus pedidos</li>
                            <li>Garantir a segurança do sistema</li>
                            <li>Cumprir obrigações legais</li>
                            <li>Comunicar mudanças em nossos serviços</li>
                        </ul>

                        <h5>3. Base Legal para o Tratamento</h5>
                        <p>Tratamos seus dados pessoais com base nas seguintes hipóteses legais:</p>
                        <ul>
                            <li><strong>Consentimento:</strong> Para envio de comunicações não obrigatórias</li>
                            <li><strong>Execução de contrato:</strong> Para prestação dos serviços solicitados</li>
                            <li><strong>Cumprimento de obrigação legal:</strong> Para atender exigências legais</li>
                            <li><strong>Exercício regular de direitos:</strong> Para defesa em processos</li>
                            <li><strong>Interesse público:</strong> Para atividades da administração pública</li>
                        </ul>

                        <h5>4. Compartilhamento de Informações</h5>
                        <p>Não vendemos, alugamos ou compartilhamos suas informações pessoais com terceiros, exceto:</p>
                        <ul>
                            <li>Quando exigido por lei ou ordem judicial</li>
                            <li>Para prestadores de serviços que nos auxiliam (sob contrato de confidencialidade)</li>
                            <li>Em caso de transferência de responsabilidade legal</li>
                            <li>Com seu consentimento explícito</li>
                        </ul>

                        <h5>5. Segurança dos Dados</h5>
                        <p>Implementamos medidas de segurança técnicas e organizacionais para proteger seus dados:</p>
                        <ul>
                            <li>Criptografia de dados sensíveis</li>
                            <li>Controle de acesso restrito</li>
                            <li>Monitoramento de segurança</li>
                            <li>Backup regular dos dados</li>
                            <li>Treinamento da equipe em proteção de dados</li>
                        </ul>

                        <h5>6. Retenção de Dados</h5>
                        <p>
                            Mantemos seus dados pessoais apenas pelo tempo necessário para cumprir as finalidades descritas 
                            nesta política ou conforme exigido por lei. Os prazos de retenção variam conforme o tipo de dado 
                            e a finalidade do tratamento.
                        </p>

                        <h5>7. Seus Direitos</h5>
                        <p>De acordo com a LGPD, você tem os seguintes direitos:</p>
                        <ul>
                            <li><strong>Confirmação:</strong> Saber se tratamos seus dados</li>
                            <li><strong>Acesso:</strong> Obter cópia dos seus dados</li>
                            <li><strong>Correção:</strong> Corrigir dados incompletos ou incorretos</li>
                            <li><strong>Anonimização:</strong> Solicitar anonimização dos dados</li>
                            <li><strong>Bloqueio:</strong> Bloquear dados desnecessários</li>
                            <li><strong>Eliminação:</strong> Excluir dados desnecessários</li>
                            <li><strong>Portabilidade:</strong> Transferir dados para outro fornecedor</li>
                            <li><strong>Informação:</strong> Saber com quem compartilhamos seus dados</li>
                            <li><strong>Revogação:</strong> Retirar consentimento a qualquer momento</li>
                        </ul>

                        <h5>8. Cookies</h5>
                        <p>
                            Utilizamos cookies para melhorar sua experiência de navegação. Você pode configurar seu navegador 
                            para recusar cookies, mas isso pode afetar algumas funcionalidades do sistema.
                        </p>

                        <h5>9. Menores de Idade</h5>
                        <p>
                            Nossos serviços não são direcionados a menores de 18 anos. Se tomarmos conhecimento de que coletamos 
                            dados de menores sem consentimento dos responsáveis, tomaremos medidas para excluir essas informações.
                        </p>

                        <h5>10. Alterações nesta Política</h5>
                        <p>
                            Podemos atualizar esta política periodicamente. Notificaremos sobre mudanças significativas através 
                            do sistema ou por e-mail. Recomendamos que revise esta política regularmente.
                        </p>

                        <h5>11. Encarregado de Proteção de Dados (DPO)</h5>
                        <p>
                            Para exercer seus direitos ou esclarecer dúvidas sobre o tratamento de dados pessoais, 
                            entre em contato com nosso Encarregado de Proteção de Dados:
                        </p>
                        <div class="alert alert-info">
                            <strong>E-mail:</strong> dpo@camara.gov.br<br>
                            <strong>Telefone:</strong> (XX) XXXX-XXXX<br>
                            <strong>Endereço:</strong> [Endereço da Câmara Municipal]
                        </div>

                        <h5>12. Autoridade Nacional de Proteção de Dados (ANPD)</h5>
                        <p>
                            Se não ficar satisfeito com nossas respostas, você pode contatar a ANPD através do site 
                            <a href="https://www.gov.br/anpd" target="_blank" class="text-primary">www.gov.br/anpd</a>.
                        </p>

                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Última atualização:</strong> {{ date('d/m/Y') }}
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar ao Cadastro
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>
                            Página Inicial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.privacy-content {
    line-height: 1.8;
}

.privacy-content h5 {
    color: #0d6efd;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.privacy-content h6 {
    color: #495057;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
}

.privacy-content p {
    margin-bottom: 1rem;
    text-align: justify;
}

.privacy-content ul {
    margin-bottom: 1rem;
}

.privacy-content li {
    margin-bottom: 0.5rem;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.text-primary {
    color: #0d6efd !important;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endpush