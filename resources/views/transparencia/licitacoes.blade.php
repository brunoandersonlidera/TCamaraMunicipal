@extends('layouts.app')

@section('title', 'Licitações - Portal da Transparência')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-gavel text-info me-2"></i>
                        Licitações e Contratos
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.index') }}">Portal da Transparência</a>
                            </li>
                            <li class="breadcrumb-item active">Licitações</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('transparencia.exportar', 'licitacoes') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                       class="btn btn-info">
                        <i class="fas fa-download me-1"></i>
                        Exportar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filtros de Pesquisa
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('transparencia.licitacoes') }}">
                        <div class="row">
                            <div class="col-lg-2 col-md-4 mb-3">
                                <label for="ano" class="form-label">Ano</label>
                                <select name="ano" id="ano" class="form-select">
                                    <option value="">Todos os anos</option>
                                    @foreach($anos as $ano)
                                        <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>
                                            {{ $ano }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-4 mb-3">
                                <label for="modalidade" class="form-label">Modalidade</label>
                                <select name="modalidade" id="modalidade" class="form-select">
                                    <option value="">Todas as modalidades</option>
                                    @foreach($modalidades as $modalidade)
                                        <option value="{{ $modalidade }}" {{ request('modalidade') == $modalidade ? 'selected' : '' }}>
                                            {{ $modalidade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-4 mb-3">
                                <label for="situacao" class="form-label">Situação</label>
                                <select name="situacao" id="situacao" class="form-select">
                                    <option value="">Todas as situações</option>
                                    @foreach($situacoes as $situacao)
                                        <option value="{{ $situacao }}" {{ request('situacao') == $situacao ? 'selected' : '' }}>
                                            {{ ucfirst($situacao) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="busca" class="form-label">Buscar</label>
                                <input type="text" name="busca" id="busca" class="form-control" 
                                       placeholder="Processo ou objeto..." value="{{ request('busca') }}">
                            </div>

                            <div class="col-lg-2 col-md-6 mb-3 d-flex align-items-end">
                                <div class="w-100">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-1"></i>
                                        Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if(request()->hasAny(['ano', 'modalidade', 'situacao', 'busca']))
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('transparencia.licitacoes') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times me-1"></i>
                                        Limpar Filtros
                                    </a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Licitações Encontradas
                    </h5>
                    <span class="badge bg-primary">{{ $licitacoes->total() }} registros</span>
                </div>
                <div class="card-body p-0">
                    @if($licitacoes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nº Processo</th>
                                        <th>Modalidade</th>
                                        <th>Objeto</th>
                                        <th class="text-end">Valor Estimado</th>
                                        <th class="text-end">Valor Homologado</th>
                                        <th class="text-center">Data Publicação</th>
                                        <th class="text-center">Data Abertura</th>
                                        <th>Vencedor</th>
                                        <th class="text-center">Situação</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($licitacoes as $licitacao)
                                        <tr>
                                            <td>
                                                <code class="text-primary">{{ $licitacao->numero_processo }}</code>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $licitacao->modalidade }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ Str::limit($licitacao->objeto, 50) }}</div>
                                                @if($licitacao->observacoes)
                                                    <small class="text-muted">{{ Str::limit($licitacao->observacoes, 40) }}</small>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($licitacao->valor_estimado)
                                                    <span class="text-muted">R$ {{ number_format($licitacao->valor_estimado, 2, ',', '.') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($licitacao->valor_homologado)
                                                    <strong class="text-success">R$ {{ number_format($licitacao->valor_homologado, 2, ',', '.') }}</strong>
                                                    @if($licitacao->valor_estimado > 0)
                                                        <br>
                                                        @php
                                                            $economia = $licitacao->valor_estimado - $licitacao->valor_homologado;
                                                            $percentualEconomia = ($economia / $licitacao->valor_estimado) * 100;
                                                        @endphp
                                                        <small class="text-{{ $economia > 0 ? 'success' : 'danger' }}">
                                                            {{ $economia > 0 ? 'Economia: ' : 'Acréscimo: ' }}{{ number_format(abs($percentualEconomia), 1) }}%
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                @if($licitacao->data_publicacao)
                                    {{ $licitacao->data_publicacao->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">Não informado</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($licitacao->data_abertura)
                                    {{ $licitacao->data_abertura->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">Não informado</span>
                                @endif
                            </td>
                                            <td>
                                                @if($licitacao->vencedor)
                                                    <div class="fw-bold">{{ Str::limit($licitacao->vencedor, 25) }}</div>
                                                    @if($licitacao->cnpj_cpf_vencedor)
                                                        <small class="text-muted">{{ $licitacao->cnpj_cpf_vencedor }}</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @switch($licitacao->status)
                                                    @case('publicado')
                                                        <span class="badge bg-info">Publicado</span>
                                                        @break
                                                    @case('em_andamento')
                                                        <span class="badge bg-warning">Em Andamento</span>
                                                        @break
                                                    @case('homologado')
                                                        <span class="badge bg-success">Homologado</span>
                                                        @break
                                                    @case('deserto')
                                                        <span class="badge bg-secondary">Deserto</span>
                                                        @break
                                                    @case('fracassado')
                                                        <span class="badge bg-danger">Fracassado</span>
                                                        @break
                                                    @case('cancelado')
                                                        <span class="badge bg-dark">Cancelado</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-light text-dark">{{ ucfirst($licitacao->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('transparencia.licitacoes.show', $licitacao) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Ver detalhes e documentos">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($licitacoes->hasPages())
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Mostrando {{ $licitacoes->firstItem() }} a {{ $licitacoes->lastItem() }} 
                                        de {{ $licitacoes->total() }} registros
                                    </div>
                                    <div>
                                        {{ $licitacoes->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma licitação encontrada</h5>
                            <p class="text-muted">Tente ajustar os filtros de pesquisa</p>
                            @if(request()->hasAny(['ano', 'modalidade', 'situacao', 'busca']))
                                <a href="{{ route('transparencia.licitacoes') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-times me-1"></i>
                                    Limpar Filtros
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Resumo Estatístico -->
    @if($licitacoes->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Resumo dos Resultados
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1">{{ $licitacoes->total() }}</h4>
                                    <small class="text-muted">Total de Licitações</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-info mb-1">R$ {{ number_format($licitacoes->sum('valor_estimado'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Valor Estimado</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-success mb-1">R$ {{ number_format($licitacoes->sum('valor_homologado'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Valor Homologado</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-warning mb-1">
                                    @php
                                        $totalEstimado = $licitacoes->sum('valor_estimado');
                                        $totalHomologado = $licitacoes->sum('valor_homologado');
                                        $economia = $totalEstimado - $totalHomologado;
                                        $percentualEconomia = $totalEstimado > 0 ? ($economia / $totalEstimado) * 100 : 0;
                                    @endphp
                                    {{ number_format($percentualEconomia, 1) }}%
                                </h4>
                                <small class="text-muted">Economia Média</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection