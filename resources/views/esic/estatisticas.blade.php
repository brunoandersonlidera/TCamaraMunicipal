@extends('layouts.app')

@section('title', 'Estatísticas E-SIC - Transparência')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Estatísticas E-SIC</h1>
                    <p class="text-muted mb-0">Dados de transparência sobre o atendimento às solicitações de informação</p>
                </div>
                <div>
                    <a href="{{ route('esic.public') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar ao E-SIC
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Container para dados dos gráficos -->
    <div id="esic-charts-container" 
         data-status-data="{{ json_encode($solicitacoesPorStatus) }}"
         data-categoria-data="{{ json_encode($solicitacoesPorCategoria) }}"
         data-categorias="{{ json_encode(\App\Models\EsicSolicitacao::getCategorias()) }}"
         data-evolucao-data="{{ json_encode($solicitacoesPorMes) }}"
         style="display: none;">
    </div>

    <!-- Estatísticas Gerais -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                    <h3 class="text-primary">{{ $totalSolicitacoes }}</h3>
                    <p class="card-text text-muted mb-0">Total de Solicitações</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                    <h3 class="text-info">{{ $solicitacoesAno }}</h3>
                    <p class="card-text text-muted mb-0">Solicitações em {{ date('Y') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h3 class="text-warning">{{ $tempoMedioResposta }}</h3>
                    <p class="card-text text-muted mb-0">Tempo Médio (dias)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="text-success">{{ $taxaAtendimento }}%</h3>
                    <p class="card-text text-muted mb-0">Taxa de Atendimento</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <!-- Solicitações por Status -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Solicitações por Status
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Solicitações por Categoria -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Solicitações por Categoria
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="categoriaChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Evolução Mensal -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Evolução Mensal das Solicitações
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="evolucaoChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabelas Detalhadas -->
    <div class="row">
        <!-- Detalhamento por Status -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Detalhamento por Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th class="text-end">Quantidade</th>
                                    <th class="text-end">Percentual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($solicitacoesPorStatus as $item)
                                    @php
                                        $statusText = $item['status'];
                                        $quantidade = $item['total'];
                                        $statusClass = match($statusText) {
                                            'Pendente' => 'warning',
                                            'Em Análise' => 'info',
                                            'Respondida' => 'success',
                                            'Finalizada' => 'primary',
                                            'Negada' => 'danger',
                                            default => 'secondary'
                                        };
                                        $percentual = $totalSolicitacoes > 0 ? round(($quantidade / $totalSolicitacoes) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td class="text-end">{{ $quantidade }}</td>
                                        <td class="text-end">{{ $percentual }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalhamento por Categoria -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>Detalhamento por Categoria
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th class="text-end">Quantidade</th>
                                    <th class="text-end">Percentual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($solicitacoesPorCategoria as $item)
                                    @php
                                        $nomeCategoria = $item['categoria'];
                                        $quantidade = $item['total'];
                                        $percentual = $totalSolicitacoes > 0 ? round(($quantidade / $totalSolicitacoes) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $nomeCategoria }}</td>
                                        <td class="text-end">{{ $quantidade }}</td>
                                        <td class="text-end">{{ $percentual }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Legais -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Sobre as Estatísticas
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Metodologia de Cálculo:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Tempo médio calculado em dias úteis</li>
                                <li><i class="fas fa-check text-success me-2"></i>Taxa de atendimento considera solicitações respondidas</li>
                                <li><i class="fas fa-check text-success me-2"></i>Dados atualizados em tempo real</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Base Legal:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-gavel text-primary me-2"></i>Lei Federal nº 12.527/2011 (LAI)</li>
                                <li><i class="fas fa-gavel text-primary me-2"></i>Decreto Federal nº 7.724/2012</li>
                                <li><i class="fas fa-gavel text-primary me-2"></i>Legislação Municipal aplicável</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/esic-estatisticas.css') }}">
@endpush

@push('scripts')
<!-- Scripts para os gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/esic-estatisticas.js') }}"></script>
@endpush