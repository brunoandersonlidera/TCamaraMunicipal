@extends('layouts.app')

@section('title', 'Transparência Financeira')

@push('styles')
<link href="{{ asset('css/transparencia.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card portal-header text-white">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 mb-3">
                        <i class="fas fa-chart-pie me-3"></i>
                        Transparência Financeira
                    </h1>
                    <p class="lead mb-0">
                        Informações detalhadas sobre a gestão financeira da Câmara Municipal
                    </p>
                    <small class="opacity-75">Dados atualizados em tempo real - Ano {{ $anoAtual }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Estatísticas Principais -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
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

        <div class="col-lg-4 col-md-6 mb-3">
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

        <div class="col-lg-4 col-md-12 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-{{ $saldoAtual >= 0 ? 'receita' : 'despesa' }} stats-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3 class="text-{{ $saldoAtual >= 0 ? 'receita' : 'despesa' }} mb-2">R$ {{ number_format(abs($saldoAtual), 2, ',', '.') }}</h3>
                    <p class="text-muted mb-0">{{ $saldoAtual >= 0 ? 'Superávit' : 'Déficit' }} Financeiro</p>
                    <small class="text-muted">{{ $anoAtual }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Links para Relatórios Detalhados -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Relatórios Detalhados
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('transparencia.receitas') }}" class="btn btn-outline-success w-100 h-100 py-3">
                                <i class="fas fa-chart-line mb-2 d-block"></i>
                                <strong>Relatório de Receitas</strong>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('transparencia.despesas') }}" class="btn btn-outline-danger w-100 h-100 py-3">
                                <i class="fas fa-chart-bar mb-2 d-block"></i>
                                <strong>Relatório de Despesas</strong>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('transparencia.licitacoes') }}" class="btn btn-outline-primary w-100 h-100 py-3">
                                <i class="fas fa-gavel mb-2 d-block"></i>
                                <strong>Licitações e Contratos</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection