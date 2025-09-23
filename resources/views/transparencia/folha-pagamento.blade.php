@extends('layouts.app')

@section('title', 'Folha de Pagamento - Portal da Transparência')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-users text-success me-2"></i>
                        Folha de Pagamento
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.index') }}">Portal da Transparência</a>
                            </li>
                            <li class="breadcrumb-item active">Folha de Pagamento</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('transparencia.exportar', 'folha-pagamento') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                       class="btn btn-success">
                        <i class="fas fa-download me-1"></i>
                        Exportar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Aviso de Transparência -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x me-3"></i>
                    <div>
                        <h6 class="mb-1">Informações sobre Transparência</h6>
                        <p class="mb-0">
                            Os dados apresentados seguem a Lei de Acesso à Informação (Lei nº 12.527/2011) e 
                            a Lei de Responsabilidade Fiscal. Valores líquidos são apresentados para preservar 
                            informações pessoais dos servidores.
                        </p>
                    </div>
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
                    <form method="GET" action="{{ route('transparencia.folha-pagamento') }}">
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
                                    @foreach($meses as $numero => $nome)
                                        <option value="{{ $numero }}" {{ request('mes') == $numero ? 'selected' : '' }}>
                                            {{ $nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-4 mb-3">
                                <label for="cargo" class="form-label">Cargo</label>
                                <select name="cargo" id="cargo" class="form-select">
                                    <option value="">Todos os cargos</option>
                                    @foreach($cargos as $cargo)
                                        <option value="{{ $cargo }}" {{ request('cargo') == $cargo ? 'selected' : '' }}>
                                            {{ $cargo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="busca" class="form-label">Buscar Servidor</label>
                                <input type="text" name="busca" id="busca" class="form-control" 
                                       placeholder="Nome do servidor..." value="{{ request('busca') }}">
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

                        @if(request()->hasAny(['ano', 'mes', 'cargo', 'busca']))
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('transparencia.folha-pagamento') }}" class="btn btn-outline-secondary btn-sm">
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
                        Servidores Encontrados
                    </h5>
                    <span class="badge bg-primary">{{ $folhaPagamento->total() }} registros</span>
                </div>
                <div class="card-body p-0">
                    @if($folhaPagamento->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Servidor</th>
                                        <th>Cargo</th>
                                        <th class="text-center">Competência</th>
                                        <th class="text-end">Salário Base</th>
                                        <th class="text-end">Gratificações</th>
                                        <th class="text-end">Descontos</th>
                                        <th class="text-end">Valor Líquido</th>
                                        <th class="text-center">Situação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($folhaPagamento as $registro)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $registro->nome_servidor }}</div>
                                                @if($registro->matricula)
                                                    <small class="text-muted">Mat: {{ $registro->matricula }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $registro->cargo }}</span>
                                                @if($registro->lotacao)
                                                    <br><small class="text-muted">{{ $registro->lotacao }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <strong>{{ str_pad($registro->mes, 2, '0', STR_PAD_LEFT) }}/{{ $registro->ano }}</strong>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-primary">R$ {{ number_format($registro->salario_base, 2, ',', '.') }}</strong>
                                            </td>
                                            <td class="text-end">
                                                @if($registro->gratificacoes > 0)
                                                    <span class="text-success">R$ {{ number_format($registro->gratificacoes, 2, ',', '.') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($registro->descontos > 0)
                                                    <span class="text-danger">R$ {{ number_format($registro->descontos, 2, ',', '.') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-success">R$ {{ number_format($registro->valor_liquido, 2, ',', '.') }}</strong>
                                            </td>
                                            <td class="text-center">
                                                @switch($registro->situacao)
                                                    @case('ativo')
                                                        <span class="badge bg-success">Ativo</span>
                                                        @break
                                                    @case('aposentado')
                                                        <span class="badge bg-info">Aposentado</span>
                                                        @break
                                                    @case('pensionista')
                                                        <span class="badge bg-warning">Pensionista</span>
                                                        @break
                                                    @case('afastado')
                                                        <span class="badge bg-secondary">Afastado</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-light text-dark">{{ ucfirst($registro->situacao) }}</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($folhaPagamento->hasPages())
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Mostrando {{ $folhaPagamento->firstItem() }} a {{ $folhaPagamento->lastItem() }} 
                                        de {{ $folhaPagamento->total() }} registros
                                    </div>
                                    <div>
                                        {{ $folhaPagamento->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhum registro encontrado</h5>
                            <p class="text-muted">Tente ajustar os filtros de pesquisa</p>
                            @if(request()->hasAny(['ano', 'mes', 'cargo', 'busca']))
                                <a href="{{ route('transparencia.folha-pagamento') }}" class="btn btn-outline-primary">
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
    @if($folhaPagamento->count() > 0)
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
                                    <h4 class="text-primary mb-1">{{ $folhaPagamento->total() }}</h4>
                                    <small class="text-muted">Total de Servidores</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-info mb-1">R$ {{ number_format($folhaPagamento->sum('salario_base'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Total Salários Base</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-warning mb-1">R$ {{ number_format($folhaPagamento->sum('gratificacoes'), 2, ',', '.') }}</h4>
                                    <small class="text-muted">Total Gratificações</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-success mb-1">R$ {{ number_format($folhaPagamento->sum('valor_liquido'), 2, ',', '.') }}</h4>
                                <small class="text-muted">Total Líquido</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Informações Legais -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-balance-scale me-2"></i>
                        Base Legal
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Lei de Acesso à Informação</h6>
                            <p class="small text-muted mb-3">
                                Lei nº 12.527/2011 - Regula o acesso a informações previsto no inciso XXXIII 
                                do art. 5º, no inciso II do § 3º do art. 37 e no § 2º do art. 216 da Constituição Federal.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Lei de Responsabilidade Fiscal</h6>
                            <p class="small text-muted mb-3">
                                Lei Complementar nº 101/2000 - Estabelece normas de finanças públicas voltadas 
                                para a responsabilidade na gestão fiscal.
                            </p>
                        </div>
                    </div>
                    <div class="alert alert-warning mb-0">
                        <small>
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Importante:</strong> Os valores apresentados são líquidos e não incluem 
                            informações pessoais dos servidores, em conformidade com a Lei Geral de Proteção 
                            de Dados (LGPD - Lei nº 13.709/2018).
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection