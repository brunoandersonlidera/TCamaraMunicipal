@extends('layouts.app')

@section('title', 'Portal da Transparência')

@push('styles')
<link href="{{ asset('css/transparencia.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header do Portal -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card portal-header text-white">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 mb-3">
                        <i class="fas fa-eye me-3"></i>
                        Portal da Transparência
                    </h1>
                    <p class="lead mb-0">
                        Acesso público às informações financeiras e administrativas da Câmara Municipal
                    </p>
                    <small class="opacity-75">Dados atualizados em tempo real - Ano {{ $anoAtual }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Estatísticas Principais -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-receita stats-icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <h3 class="text-receita mb-2">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Total de Receitas</p>
                    <small class="text-muted">{{ $anoAtual }}</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-despesa stats-icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <h3 class="text-despesa mb-2">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Total de Despesas</p>
                    <small class="text-muted">{{ $anoAtual }}</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-licitacao stats-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h3 class="text-licitacao mb-2">{{ $totalLicitacoes }}</h3>
                    <p class="text-muted mb-0">Licitações</p>
                    <small class="text-muted">{{ $anoAtual }}</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-servidor stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-servidor mb-2">{{ $totalServidores }}</h3>
                    <p class="text-muted mb-0">Servidores</p>
                    <small class="text-muted">Folha Atual</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu de Navegação Rápida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-compass me-2"></i>
                        Acesso Rápido
                    </h5>
                </div>
                <div class="card-body nav-quick-access">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('transparencia.receitas') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <strong>Receitas</strong>
                                <small>Arrecadação Municipal</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('transparencia.despesas') }}" class="btn btn-outline-danger w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-chart-pie fa-2x mb-2"></i>
                                <strong>Despesas</strong>
                                <small>Gastos Públicos</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('transparencia.licitacoes') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-gavel fa-2x mb-2"></i>
                                <strong>Licitações</strong>
                                <small>Processos Licitatórios</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('transparencia.folha-pagamento') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <strong>Folha de Pagamento</strong>
                                <small>Remuneração dos Servidores</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Evolução Mensal -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area me-2"></i>
                        Evolução Mensal - {{ $anoAtual }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="evolucaoChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Licitações Recentes -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Licitações Recentes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush licitacoes-recentes">
                        @forelse($licitacoesRecentes as $licitacao)
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $licitacao->objeto }}</div>
                                <small class="text-muted">
                                    Processo: {{ $licitacao->numero_processo }} | 
                                    Modalidade: {{ $licitacao->modalidade }}
                                </small>
                                <div class="mt-1">
                                    <small class="text-muted">
                                        Valor: R$ {{ number_format($licitacao->valor_estimado, 2, ',', '.') }}
                                    </small>
                                </div>
                            </div>
                            <span class="badge badge-status bg-{{ $licitacao->status == 'homologado' ? 'success' : ($licitacao->status == 'em_andamento' ? 'warning' : 'secondary') }} rounded-pill">
                                            {{ ucfirst(str_replace('_', ' ', $licitacao->status)) }}
                            </span>
                        </div>
                        @empty
                        <div class="list-group-item text-center text-muted">
                            <i class="fas fa-info-circle me-2"></i>
                            Nenhuma licitação encontrada
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Receitas e Despesas por Categoria -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Top 5 - Receitas por Categoria
                    </h5>
                </div>
                <div class="card-body">
                    @if($receitasPorCategoria->count() > 0)
                        @foreach($receitasPorCategoria as $receita)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">{{ $receita->categoria }}</h6>
                                </div>
                                <div class="text-end">
                                    <strong class="text-success">R$ {{ number_format($receita->total, 2, ',', '.') }}</strong>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-pie fa-2x mb-2"></i>
                            <p>Nenhuma receita encontrada</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Top 5 - Despesas por Categoria
                    </h5>
                </div>
                <div class="card-body">
                    @if($despesasPorCategoria->count() > 0)
                        @foreach($despesasPorCategoria as $despesa)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">{{ $despesa->categoria_economica }}</h6>
                                </div>
                                <div class="text-end">
                                    <strong class="text-danger">R$ {{ number_format($despesa->total, 2, ',', '.') }}</strong>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-pie fa-2x mb-2"></i>
                            <p>Nenhuma despesa encontrada</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Legais -->
    <div class="row">
        <div class="col-12">
            <div class="card info-legal border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-balance-scale me-2"></i>
                        Informações Legais
                    </h5>
                </div>
                <div class="card-body text-center py-4">
                    <h5 class="mb-3">
                        <i class="fas fa-balance-scale me-2"></i>
                        Transparência e Legalidade
                    </h5>
                    <p class="text-muted mb-3">
                        Este portal atende às exigências da Lei de Acesso à Informação (Lei nº 12.527/2011) 
                        e da Lei de Responsabilidade Fiscal (Lei Complementar nº 101/2000).
                    </p>
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Dados Oficiais
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="fas fa-sync me-1"></i>
                                Atualização Automática
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="fas fa-download me-1"></i>
                                Exportação Disponível
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/transparencia.js') }}"></script>
@endpush
@endsection