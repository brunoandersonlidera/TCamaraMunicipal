@extends('layouts.app')

@section('title', 'Despesas - Portal da Transparência')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-chart-pie text-danger me-2"></i>
                        Despesas Municipais
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.index') }}">Portal da Transparência</a>
                            </li>
                            <li class="breadcrumb-item active">Despesas</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('transparencia.exportar', 'despesas') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                       class="btn btn-danger">
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
                    <form method="GET" action="{{ route('transparencia.despesas') }}">
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

                            <div class="col-lg-2 col-md-4 mb-3">
                                <label for="mes" class="form-label">Mês</label>
                                <select name="mes" id="mes" class="form-select">
                                    <option value="">Todos os meses</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select name="categoria" id="categoria" class="form-select">
                                    <option value="">Todas as categorias</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                            {{ $categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="busca" class="form-label">Buscar</label>
                                <input type="text" name="busca" id="busca" class="form-control" 
                                       placeholder="Empenho ou descrição..." value="{{ request('busca') }}">
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="credor" class="form-label">Credor</label>
                                <input type="text" name="credor" id="credor" class="form-control" 
                                       placeholder="Nome do credor..." value="{{ request('credor') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-md-6 mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i>
                                    Filtrar
                                </button>
                            </div>
                            @if(request()->hasAny(['ano', 'mes', 'categoria', 'busca', 'credor']))
                                <div class="col-lg-2 col-md-6 mb-3">
                                    <a href="{{ route('transparencia.despesas') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-times me-1"></i>
                                        Limpar
                                    </a>
                                </div>
                            @endif
                        </div>
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
                        Despesas Encontradas
                    </h5>
                    <span class="badge bg-primary">{{ $despesas->total() }} registros</span>
                </div>
                <div class="card-body p-0">
                    @if($despesas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nº Empenho</th>
                                        <th>Descrição</th>
                                        <th>Categoria</th>
                                        <th>Credor</th>
                                        <th class="text-end">Valor Empenhado</th>
                                        <th class="text-end">Valor Pago</th>
                                        <th class="text-center">Data Empenho</th>
                                        <th class="text-center">Período</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($despesas as $despesa)
                                        <tr>
                                            <td>
                                                <code class="text-primary">{{ $despesa->numero_empenho }}</code>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ Str::limit($despesa->descricao, 40) }}</div>
                                                @if($despesa->observacoes)
                                                    <small class="text-muted">{{ Str::limit($despesa->observacoes, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $despesa->categoria_economica }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ Str::limit($despesa->credor, 25) }}</div>
                                                @if($despesa->cnpj_cpf_credor)
                                                    <small class="text-muted">{{ $despesa->cnpj_cpf_credor }}</small>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <span class="text-warning">R$ {{ number_format($despesa->valor_empenhado, 2, ',', '.') }}</span>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-danger">R$ {{ number_format($despesa->valor_pago, 2, ',', '.') }}</strong>
                                                @if($despesa->valor_empenhado > 0)
                                                    <br>
                                                    <small class="text-muted">
                                                        ({{ number_format(($despesa->valor_pago / $despesa->valor_empenhado) * 100, 1) }}%)
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $despesa->data_empenho ? $despesa->data_empenho->format('d/m/Y') : 'Não informado' }}
                                            </td>
                                            <td class="text-center">
                                                <small>
                                                    {{ str_pad($despesa->mes_referencia, 2, '0', STR_PAD_LEFT) }}/{{ $despesa->ano_referencia }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                @switch($despesa->status)
                                                    @case('empenhada')
                                                        <span class="badge bg-warning">Empenhada</span>
                                                        @break
                                                    @case('liquidada')
                                                        <span class="badge bg-info">Liquidada</span>
                                                        @break
                                                    @case('paga')
                                                        <span class="badge bg-success">Paga</span>
                                                        @break
                                                    @case('cancelada')
                                                        <span class="badge bg-danger">Cancelada</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($despesa->status) }}</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($despesas->hasPages())
                            <div class="card-footer bg-light">
                                {{ $despesas->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma despesa encontrada</h5>
                            <p class="text-muted">Tente ajustar os filtros de pesquisa</p>
                            @if(request()->hasAny(['ano', 'mes', 'categoria', 'busca', 'credor']))
                                <a href="{{ route('transparencia.despesas') }}" class="btn btn-outline-primary">
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
    @if($despesas->count() > 0)
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
                                    <h4 class="text-primary mb-1">{{ $despesas->total() }}</h4>
                                    <small class="text-muted">Total de Registros</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-warning mb-1">R$ {{ number_format($despesas->sum('valor_empenhado'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Valor Empenhado</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-danger mb-1">R$ {{ number_format($despesas->sum('valor_pago'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Valor Pago</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-info mb-1">
                                    @php
                                        $totalEmpenhado = $despesas->sum('valor_empenhado');
                                        $totalPago = $despesas->sum('valor_pago');
                                        $percentual = $totalEmpenhado > 0 ? ($totalPago / $totalEmpenhado) * 100 : 0;
                                    @endphp
                                    {{ number_format($percentual, 1) }}%
                                </h4>
                                <small class="text-muted">Percentual Pago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection