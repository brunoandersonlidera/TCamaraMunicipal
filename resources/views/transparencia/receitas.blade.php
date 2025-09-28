@extends('layouts.app')

@section('title', 'Receitas - Portal da Transparência')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-chart-line text-success me-2"></i>
                        Receitas Municipais
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.index') }}">Portal da Transparência</a>
                            </li>
                            <li class="breadcrumb-item active">Receitas</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('transparencia.exportar', 'receitas') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                       class="btn btn-success">
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
                    <form method="GET" action="{{ route('transparencia.receitas') }}">
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

                            <div class="col-lg-3 col-md-4 mb-3">
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
                                       placeholder="Código ou descrição..." value="{{ request('busca') }}">
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

                        @if(request()->hasAny(['ano', 'mes', 'categoria', 'busca']))
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('transparencia.receitas') }}" class="btn btn-outline-secondary btn-sm">
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
                        Receitas Encontradas
                    </h5>
                    <span class="badge bg-primary">{{ $receitas->total() }} registros</span>
                </div>
                <div class="card-body p-0">
                    @if($receitas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                        <th>Categoria</th>
                                        <th class="text-end">Valor Previsto</th>
                                        <th class="text-end">Valor Arrecadado</th>
                                        <th class="text-center">Data Arrecadação</th>
                                        <th class="text-center">Período</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receitas as $receita)
                                        <tr>
                                            <td>
                                                <code class="text-primary">{{ $receita->codigo }}</code>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $receita->descricao }}</div>
                                                @if($receita->observacoes)
                                                    <small class="text-muted">{{ Str::limit($receita->observacoes, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $receita->categoria }}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-muted">R$ {{ number_format($receita->valor_previsto, 2, ',', '.') }}</span>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-success">R$ {{ number_format($receita->valor_arrecadado, 2, ',', '.') }}</strong>
                                                @if($receita->valor_previsto > 0)
                                                    <br>
                                                    <small class="text-muted">
                                                        ({{ number_format(($receita->valor_arrecadado / $receita->valor_previsto) * 100, 1) }}%)
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                @if($receita->data_arrecadacao)
                                    {{ $receita->data_arrecadacao->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">Não informado</span>
                                @endif
                            </td>
                                            <td class="text-center">
                                                <small>
                                                    {{ str_pad($receita->mes_referencia, 2, '0', STR_PAD_LEFT) }}/{{ $receita->ano_referencia }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                @switch($receita->status)
                                                    @case('prevista')
                                                        <span class="badge bg-warning">Prevista</span>
                                                        @break
                                                    @case('arrecadada')
                                                        <span class="badge bg-success">Arrecadada</span>
                                                        @break
                                                    @case('cancelada')
                                                        <span class="badge bg-danger">Cancelada</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($receita->status) }}</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($receitas->hasPages())
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Mostrando {{ $receitas->firstItem() }} a {{ $receitas->lastItem() }} 
                                        de {{ $receitas->total() }} registros
                                    </div>
                                    <div>
                                        {{ $receitas->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma receita encontrada</h5>
                            <p class="text-muted">Tente ajustar os filtros de pesquisa</p>
                            @if(request()->hasAny(['ano', 'mes', 'categoria', 'busca']))
                                <a href="{{ route('transparencia.receitas') }}" class="btn btn-outline-primary">
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
    @if($receitas->count() > 0)
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
                                    <h4 class="text-primary mb-1">{{ $receitas->total() }}</h4>
                                    <small class="text-muted">Total de Registros</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-info mb-1">R$ {{ number_format($receitas->sum('valor_previsto'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Valor Previsto</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-success mb-1">R$ {{ number_format($receitas->sum('valor_arrecadado'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Valor Arrecadado</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-warning mb-1">
                                    @php
                                        $totalPrevisto = $receitas->sum('valor_previsto');
                                        $totalArrecadado = $receitas->sum('valor_arrecadado');
                                        $percentual = $totalPrevisto > 0 ? ($totalArrecadado / $totalPrevisto) * 100 : 0;
                                    @endphp
                                    {{ number_format($percentual, 1) }}%
                                </h4>
                                <small class="text-muted">Percentual Arrecadado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection