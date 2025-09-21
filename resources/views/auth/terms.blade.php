@extends('layouts.app')

@section('title', 'Termos de Uso')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-file-contract me-2"></i>
                        Termos de Uso
                    </h4>
                </div>

                <div class="card-body">
                    <div class="terms-content">
                        <p class="lead">
                            Bem-vindo ao sistema da Câmara Municipal. Ao utilizar nossos serviços, você concorda com os seguintes termos e condições.
                        </p>

                        <h5>1. Aceitação dos Termos</h5>
                        <p>
                            Ao acessar e usar este sistema, você aceita e concorda em ficar vinculado aos termos e condições deste acordo. 
                            Se você não concordar com qualquer parte destes termos, não deve usar nossos serviços.
                        </p>

                        <h5>2. Descrição do Serviço</h5>
                        <p>
                            O sistema da Câmara Municipal oferece acesso a:
                        </p>
                        <ul>
                            <li>Serviços de transparência pública</li>
                            <li>Sistema de Informações ao Cidadão (e-SIC)</li>
                            <li>Ouvidoria Municipal</li>
                            <li>Consulta a documentos públicos</li>
                            <li>Acompanhamento de sessões e projetos de lei</li>
                        </ul>

                        <h5>3. Cadastro e Conta do Usuário</h5>
                        <p>
                            Para utilizar alguns serviços, você deve criar uma conta fornecendo informações precisas e atualizadas. 
                            Você é responsável por:
                        </p>
                        <ul>
                            <li>Manter a confidencialidade de sua senha</li>
                            <li>Todas as atividades realizadas em sua conta</li>
                            <li>Notificar imediatamente sobre uso não autorizado</li>
                            <li>Fornecer informações verdadeiras e atualizadas</li>
                        </ul>

                        <h5>4. Uso Aceitável</h5>
                        <p>Você concorda em usar o sistema apenas para fins legítimos e de acordo com a lei. É proibido:</p>
                        <ul>
                            <li>Usar o sistema para atividades ilegais ou não autorizadas</li>
                            <li>Tentar acessar áreas restritas do sistema</li>
                            <li>Interferir no funcionamento do sistema</li>
                            <li>Transmitir vírus ou códigos maliciosos</li>
                            <li>Fazer uso comercial não autorizado das informações</li>
                            <li>Violar direitos de propriedade intelectual</li>
                        </ul>

                        <h5>5. Privacidade e Proteção de Dados</h5>
                        <p>
                            Respeitamos sua privacidade e protegemos seus dados pessoais de acordo com a Lei Geral de Proteção de Dados (LGPD). 
                            Consulte nossa <a href="{{ route('privacy') }}" class="text-primary">Política de Privacidade</a> para mais detalhes.
                        </p>

                        <h5>6. Propriedade Intelectual</h5>
                        <p>
                            Todo o conteúdo do sistema, incluindo textos, gráficos, logos, ícones e software, é propriedade da Câmara Municipal 
                            ou de seus licenciadores e está protegido por leis de direitos autorais.
                        </p>

                        <h5>7. Limitação de Responsabilidade</h5>
                        <p>
                            A Câmara Municipal não se responsabiliza por:
                        </p>
                        <ul>
                            <li>Interrupções temporárias do serviço</li>
                            <li>Perda de dados devido a falhas técnicas</li>
                            <li>Danos indiretos ou consequenciais</li>
                            <li>Uso inadequado do sistema por terceiros</li>
                        </ul>

                        <h5>8. Modificações dos Termos</h5>
                        <p>
                            Reservamo-nos o direito de modificar estes termos a qualquer momento. As alterações entrarão em vigor 
                            imediatamente após a publicação. O uso continuado do sistema constitui aceitação dos novos termos.
                        </p>

                        <h5>9. Suspensão e Encerramento</h5>
                        <p>
                            Podemos suspender ou encerrar sua conta a qualquer momento, sem aviso prévio, se você violar estes termos 
                            ou por qualquer outro motivo que consideremos apropriado.
                        </p>

                        <h5>10. Lei Aplicável</h5>
                        <p>
                            Estes termos são regidos pelas leis brasileiras. Qualquer disputa será resolvida nos tribunais competentes 
                            da comarca onde está localizada a Câmara Municipal.
                        </p>

                        <h5>11. Contato</h5>
                        <p>
                            Se você tiver dúvidas sobre estes termos, entre em contato conosco através dos canais oficiais da Câmara Municipal.
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
.terms-content {
    line-height: 1.8;
}

.terms-content h5 {
    color: #0d6efd;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.terms-content p {
    margin-bottom: 1rem;
    text-align: justify;
}

.terms-content ul {
    margin-bottom: 1rem;
}

.terms-content li {
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