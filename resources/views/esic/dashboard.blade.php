@extends('layouts.app')

@section('title', 'Meu Dashboard E-SIC')

@section('content')
<div class="container-fluid">
    <!-- Header do Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Meu Dashboard E-SIC</h1>
                    <p class="text-muted mb-0">Bem-vindo(a), {{ auth()->user()->name }}!</p>
                </div>
                <div>
                    <a href="{{ route('esic.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nova Solicitação
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            @if(session('protocolo'))
                <br><strong>Protocolo:</strong> {{ session('protocolo') }}
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estatísticas do Usuário -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticasUsuario['total_solicitacoes'] }}</h4>
                            <p class="mb-0 opacity-75">Total de Solicitações</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticasUsuario['pendentes'] }}</h4>
                            <p class="mb-0 opacity-75">Pendentes</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticasUsuario['em_analise'] }}</h4>
                            <p class="mb-0 opacity-75">Em Análise</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-search fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $estatisticasUsuario['respondidas'] }}</h4>
                            <p class="mb-0 opacity-75">Respondidas</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Minhas Solicitações Recentes -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Minhas Solicitações Recentes
                    </h5>
                    <a href="{{ route('esic.minhas-solicitacoes') }}" class="btn btn-sm btn-outline-primary">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body">
                    @if($minhasSolicitacoes->count() > 0)
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
                                    @foreach($minhasSolicitacoes as $solicitacao)
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
                                                        'aguardando_informacoes' => 'secondary',
                                                        'informacoes_recebidas' => 'primary',
                                                        'respondida' => 'success',
                                                        'finalizada' => 'dark',
                                                        'arquivada' => 'secondary',
                                                        'negada' => 'danger',
                                                        default => 'light'
                                                    };
                                                    $statusText = match($solicitacao->status) {
                                                        'pendente' => 'Pendente',
                                                        'em_analise' => 'Em Análise',
                                                        'aguardando_informacoes' => 'Aguardando Informações',
                                                        'informacoes_recebidas' => 'Informações Recebidas',
                                                        'respondida' => 'Respondida',
                                                        'finalizada' => 'Finalizada',
                                                        'arquivada' => 'Arquivada',
                                                        'negada' => 'Negada',
                                                        default => ucfirst($solicitacao->status)
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
                            <h5 class="text-muted">Nenhuma solicitação encontrada</h5>
                            <p class="text-muted mb-3">Você ainda não fez nenhuma solicitação via E-SIC.</p>
                            <a href="{{ route('esic.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Fazer Primeira Solicitação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Menu de Ações -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('esic.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nova Solicitação
                        </a>
                        <a href="{{ route('esic.minhas-solicitacoes') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Minhas Solicitações
                        </a>
                        <a href="{{ route('esic.consultar') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-search me-2"></i>Consultar por Protocolo
                        </a>
                        <hr>
                        <a href="{{ route('esic.faq') }}" class="btn btn-outline-info">
                            <i class="fas fa-question-circle me-2"></i>Perguntas Frequentes
                        </a>
                        <a href="{{ route('esic.sobre') }}" class="btn btn-outline-success">
                            <i class="fas fa-info-circle me-2"></i>Sobre o E-SIC
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informações Úteis -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>Dicas Importantes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <small>
                            <i class="fas fa-clock me-1"></i>
                            <strong>Prazo de Resposta:</strong> Até 20 dias úteis, prorrogáveis por mais 10 dias.
                        </small>
                    </div>
                    <div class="alert alert-warning mb-3">
                        <small>
                            <i class="fas fa-file-alt me-1"></i>
                            <strong>Documentos:</strong> Anexe apenas arquivos relevantes (máx. 10MB cada).
                        </small>
                    </div>
                    <div class="alert alert-success mb-0">
                        <small>
                            <i class="fas fa-bell me-1"></i>
                            <strong>Notificações:</strong> Você receberá e-mails sobre atualizações.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: transform 0.2s ease-in-out;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
}

.table td {
    vertical-align: middle;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}

.btn {
    border-radius: 0.5rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}
</style>
@endsection