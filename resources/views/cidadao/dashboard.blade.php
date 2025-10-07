@extends('layouts.app')

@section('title', 'Dashboard do Cidadão')

@section('content')
<div class="container-fluid">
    <!-- Header do Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Dashboard do Cidadão</h1>
                    <p class="text-muted mb-0">Bem-vindo(a), {{ $user->nome_completo ?? $user->name }}!</p>
                </div>
                <div>
                    <a href="{{ route('esic.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Nova Solicitação e-SIC
                    </a>
                    <a href="{{ route('cidadao.comites.create') }}" class="btn btn-success">
                        <i class="fas fa-users me-2"></i>Criar Comitê
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Status do Cidadão -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-check"></i> Status da Conta
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Status:</strong> 
                                @if($user->active)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-warning">Inativo</span>
                                @endif
                            </p>
                            <p class="mb-2">
                                <strong>Verificação:</strong> 
                                @if($user->status_verificacao === 'verificado')
                                    <span class="badge bg-success">Verificado</span>
                                @else
                                    <span class="badge bg-warning">Pendente</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Pode Assinar:</strong> 
                                @if($user->pode_assinar)
                                    <span class="badge bg-success">Sim</span>
                                @else
                                    <span class="badge bg-danger">Não</span>
                                @endif
                            </p>
                            <p class="mb-2">
                                <strong>Pode Criar Comitê:</strong> 
                                @if($user->pode_criar_comite)
                                    <span class="badge bg-success">Sim</span>
                                @else
                                    <span class="badge bg-danger">Não</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($user->status_verificacao !== 'verificado')
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i>
                            <strong>Conta em verificação:</strong> Sua conta está sendo analisada pela equipe da Câmara Municipal. 
                            Você poderá assinar projetos e criar comitês após a verificação.
                            
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary btn-sm" onclick="solicitarVerificacao()">
                                    <i class="fas fa-check-circle me-2"></i>Solicitar Verificação Automática
                                </button>
                                <small class="text-muted d-block mt-2">
                                    Clique aqui para verificar automaticamente sua conta se você já forneceu todas as informações necessárias.
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas Gerais -->
    <div class="row mb-4">
        <div class="col-md-2 mb-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticas['minhas_assinaturas'] ?? 0 }}</h4>
                            <p class="mb-0 opacity-75">Minhas Assinaturas</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-signature fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticas['meus_comites'] ?? 0 }}</h4>
                            <p class="mb-0 opacity-75">Meus Comitês</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticas['projetos_disponiveis'] ?? 0 }}</h4>
                            <p class="mb-0 opacity-75">Projetos Disponíveis</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticas['projetos_ativos'] ?? 0 }}</h4>
                            <p class="mb-0 opacity-75">Projetos Ativos</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticasEsic['total_solicitacoes'] ?? 0 }}</h4>
                            <p class="mb-0 opacity-75">Total e-SIC</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card bg-dark text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticasEsic['pendentes'] ?? 0 }}</h4>
                            <p class="mb-0 opacity-75">e-SIC Pendentes</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Minhas Solicitações e-SIC Recentes -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Minhas Solicitações e-SIC Recentes
                    </h5>
                    <a href="{{ route('esic.minhas-solicitacoes') }}" class="btn btn-sm btn-outline-primary">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body">
                    @if($minhasSolicitacoesEsic && $minhasSolicitacoesEsic->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Assunto</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($minhasSolicitacoesEsic as $solicitacao)
                                        <tr>
                                            <td>
                                                <code>{{ $solicitacao->protocolo }}</code>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" title="{{ $solicitacao->assunto }}">
                                                    {{ $solicitacao->assunto }}
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = match($solicitacao->status) {
                                                        'pendente' => 'warning',
                                                        'em_analise' => 'info',
                                                        'respondida' => 'success',
                                                        'finalizada' => 'primary',
                                                        'negada' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                    $statusText = match($solicitacao->status) {
                                                        'pendente' => 'Pendente',
                                                        'em_analise' => 'Em Análise',
                                                        'respondida' => 'Respondida',
                                                        'finalizada' => 'Finalizada',
                                                        'negada' => 'Negada',
                                                        default => 'Desconhecido'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $solicitacao->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ route('esic.show', $solicitacao->protocolo) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma solicitação e-SIC encontrada</h5>
                            <p class="text-muted mb-3">Você ainda não fez nenhuma solicitação via E-SIC.</p>
                            <a href="{{ route('esic.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Fazer Primeira Solicitação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
                        </div>

                        <!-- Ações Rápidas e-SIC -->
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cogs me-2"></i>Ações Rápidas e-SIC
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('esic.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-2"></i>Nova Solicitação
                                        </a>
                                        <a href="{{ route('esic.minhas-solicitacoes') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-list me-2"></i>Minhas Solicitações
                                        </a>
                                        <a href="{{ route('esic.consultar') }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-search me-2"></i>Consultar por Protocolo
                                        </a>
                                        <hr class="my-2">
                                        <a href="{{ route('esic.faq') }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-question-circle me-2"></i>Perguntas Frequentes
                                        </a>
                                        <a href="{{ route('esic.sobre') }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-info-circle me-2"></i>Sobre o e-SIC
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Dicas e-SIC -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-lightbulb me-2"></i>Dicas e-SIC
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info mb-2 py-2">
                                        <small>
                                            <i class="fas fa-clock me-1"></i>
                                            <strong>Prazo:</strong> Até 20 dias úteis para resposta.
                                        </small>
                                    </div>
                                    <div class="alert alert-warning mb-2 py-2">
                                        <small>
                                            <i class="fas fa-file-alt me-1"></i>
                                            <strong>Documentos:</strong> Máx. 10MB cada arquivo.
                                        </small>
                                    </div>
                                    <div class="alert alert-success mb-0 py-2">
                                        <small>
                                            <i class="fas fa-bell me-1"></i>
                                            <strong>Notificações:</strong> Receba atualizações por e-mail.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comitês Disponíveis para Assinatura -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-pen-fancy"></i> Comitês Disponíveis para Assinatura
                    </h5>
                </div>
                <div class="card-body">
                    @if($comites_disponiveis && $comites_disponiveis->count() > 0)
                        <div class="row">
                            @foreach($comites_disponiveis as $comite)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $comite->nome }}</h6>
                                            <p class="card-text small text-muted">
                                                <strong>Responsável:</strong> {{ $comite->responsavel_nome }}<br>
                                                <strong>E-mail:</strong> {{ $comite->responsavel_email }}
                                            </p>
                                            
                                            <div class="progress mb-2" style="height: 20px;">
                                                @php
                                                    $percentual = $comite->minimo_assinaturas > 0 ? 
                                                        ($comite->numero_assinaturas / $comite->minimo_assinaturas) * 100 : 0;
                                                    $percentual = min($percentual, 100);
                                                @endphp
                                                <div class="progress-bar" 
                                                     role="progressbar" 
                                                     style="width: {{ $percentual }}%"
                                                     aria-valuenow="{{ $percentual }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ number_format($percentual, 1) }}%
                                                </div>
                                            </div>
                                            
                                            <p class="small mb-2">
                                                <strong>{{ number_format($comite->numero_assinaturas) }}</strong> de 
                                                <strong>{{ number_format($comite->minimo_assinaturas) }}</strong> assinaturas
                                            </p>
                                            
                                            <p class="small text-muted mb-3">
                                                <i class="fas fa-calendar"></i> 
                                                Coleta até: {{ \Carbon\Carbon::parse($comite->data_fim_coleta)->format('d/m/Y') }}
                                            </p>
                                            
                                            @if($user && $user->pode_assinar)
                                <button class="btn btn-primary btn-sm" onclick="assinarComite({{ $comite->id }})">
                                    <i class="fas fa-signature"></i> Assinar
                                </button>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-lock"></i> Verificação Pendente
                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Não há comitês disponíveis para assinatura no momento.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Meus Comitês -->
    @if($user && $user->pode_criar_comite)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users"></i> Meus Comitês
                        </h5>
                        <button class="btn btn-success btn-sm" onclick="criarComite()">
                            <i class="fas fa-plus"></i> Criar Comitê
                        </button>
                    </div>
                    <div class="card-body">
                        @if($meus_comites && $meus_comites->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome do Comitê</th>
                                            <th>Status</th>
                                            <th>Assinaturas</th>
                                            <th>Progresso</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($meus_comites as $comite)
                                            <tr>
                                                <td>{{ $comite->nome }}</td>
                                                <td>
                                                    @if($comite->ativo)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inativo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($comite->numero_assinaturas) }} / 
                                                    {{ number_format($comite->minimo_assinaturas) }}
                                                </td>
                                                <td>
                                                    @php
                                                        $percentual = $comite->minimo_assinaturas > 0 ? 
                                                            ($comite->numero_assinaturas / $comite->minimo_assinaturas) * 100 : 0;
                                                        $percentual = min($percentual, 100);
                                                    @endphp
                                                    <div class="progress" style="height: 15px;">
                                                        <div class="progress-bar" 
                                                             role="progressbar" 
                                                             style="width: {{ $percentual }}%">
                                                            {{ number_format($percentual, 1) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" onclick="verComite({{ $comite->id }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Você ainda não criou nenhum comitê.</p>
                                <button class="btn btn-success" onclick="criarComite()">
                                    <i class="fas fa-plus"></i> Criar Primeiro Comitê
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Informações Importantes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informações Importantes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-gavel text-primary"></i> Sobre a Iniciativa Popular</h6>
                            <p class="small">
                                A iniciativa popular permite que cidadãos apresentem projetos de lei à Câmara Municipal. 
                                É necessário coletar assinaturas de pelo menos 
                                <strong>{{ number_format($minimo_assinaturas ?? 0) }} eleitores</strong> do município.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-shield-alt text-success"></i> Segurança e Privacidade</h6>
                            <p class="small">
                                Seus dados são protegidos conforme a LGPD. As assinaturas são validadas pela equipe da Câmara 
                                para garantir a autenticidade e evitar fraudes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas e Informações -->
        <div class="col-lg-4 mb-4">
            <!-- Ações Rápidas -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('esic.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nova Solicitação e-SIC
                        </a>
                        <a href="{{ route('cidadao.comites.create') }}" class="btn btn-success">
                            <i class="fas fa-users me-2"></i>Criar Comitê
                        </a>
                        <a href="{{ route('esic.consultar') }}" class="btn btn-outline-primary">
                            <i class="fas fa-search me-2"></i>Consultar por Protocolo
                        </a>
                        <a href="{{ route('projetos-lei.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-file-contract me-2"></i>Ver Projetos de Lei
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informações Importantes -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informações Importantes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <h6 class="alert-heading">
                            <i class="fas fa-clock me-2"></i>Prazo de Resposta e-SIC
                        </h6>
                        <p class="mb-0 small">
                            As solicitações são respondidas em até <strong>20 dias úteis</strong>, 
                            podendo ser prorrogado por mais 10 dias.
                        </p>
                    </div>

                    <div class="alert alert-warning mb-3">
                        <h6 class="alert-heading">
                            <i class="fas fa-paperclip me-2"></i>Anexos
                        </h6>
                        <p class="mb-0 small">
                            Você pode anexar documentos de até <strong>10MB</strong> 
                            em suas solicitações.
                        </p>
                    </div>

                    <div class="alert alert-success mb-0">
                        <h6 class="alert-heading">
                            <i class="fas fa-bell me-2"></i>Notificações
                        </h6>
                        <p class="mb-0 small">
                            Você receberá notificações por email sobre 
                            atualizações em suas solicitações.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function assinarComite(comiteId) {
    if (confirm('Deseja realmente assinar este comitê de iniciativa popular?')) {
        // Mostrar loading
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Assinando...';
        btn.disabled = true;
        
        fetch(`/cidadao/comites/${comiteId}/assinar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar sucesso e recarregar página
                alert(data.message);
                location.reload();
            } else {
                // Mostrar erro
                alert(data.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao processar assinatura. Tente novamente.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
}

function criarComite() {
    // Redirecionar para a página de criação de comitê
    window.location.href = '/cidadao/comites/criar';
}

function verComite(comiteId) {
    // Redirecionar para a página de detalhes do comitê
    window.location.href = `/cidadao/comites/${comiteId}`;
}

function solicitarVerificacao() {
    if (confirm('Deseja solicitar a verificação automática da sua conta? Esta ação irá analisar seus dados e verificar sua conta se todas as informações estiverem corretas.')) {
        // Mostrar loading
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verificando...';
        btn.disabled = true;
        
        fetch('/cidadao/solicitar-verificacao', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar sucesso e recarregar página
                alert(data.message);
                location.reload();
            } else {
                // Mostrar erro
                alert(data.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao processar verificação. Tente novamente.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
}
</script>
@endsection