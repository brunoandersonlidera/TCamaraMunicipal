@extends('layouts.app')

@section('title', 'Contratos - Portal da Transparência')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-file-contract text-info me-2"></i>
                        Contratos Públicos
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.index') }}">Portal da Transparência</a>
                            </li>
                            <li class="breadcrumb-item active">Contratos</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('transparencia.exportar', 'contratos') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
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
                    <form method="GET" action="{{ route('transparencia.contratos') }}">
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
                                <label for="tipo_contrato_id" class="form-label">Tipo de Contrato</label>
                                <select name="tipo_contrato_id" id="tipo_contrato_id" class="form-select">
                                    <option value="">Todos os tipos</option>
                                    @foreach($tiposContrato as $tipo)
                                        <option value="{{ $tipo->id }}" {{ request('tipo_contrato_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-4 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="vencido" {{ request('status') === 'vencido' ? 'selected' : '' }}>Vencido</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="search" class="form-label">Buscar</label>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       class="form-control" 
                                       placeholder="Número, objeto, contratado..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-lg-2 col-md-6 mb-3 d-flex align-items-end">
                                <div class="w-100">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-1"></i>
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                        @if(request()->hasAny(['ano', 'tipo_contrato_id', 'status', 'search']))
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('transparencia.contratos') }}" class="btn btn-outline-secondary btn-sm">
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

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-file-contract fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-1">{{ number_format($estatisticas['total'], 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Total de Contratos</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-1">{{ number_format($estatisticas['ativos'], 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Contratos Ativos</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-1">{{ number_format($estatisticas['vencidos'], 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Contratos Vencidos</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-plus-circle fa-2x text-info"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-1">{{ number_format($estatisticas['aditivados'], 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Contratos Aditivados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Contratos -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Contratos Encontrados
                        @if($contratos->total() > 0)
                            <span class="badge bg-primary ms-2">{{ number_format($contratos->total(), 0, ',', '.') }}</span>
                        @endif
                    </h5>
                    <small class="text-muted">
                        Mostrando {{ $contratos->firstItem() ?? 0 }} a {{ $contratos->lastItem() ?? 0 }} 
                        de {{ number_format($contratos->total(), 0, ',', '.') }} resultados
                    </small>
                </div>
                <div class="card-body p-0">
                    @if($contratos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Número</th>
                                        <th>Tipo</th>
                                        <th>Objeto</th>
                                        <th>Contratado</th>
                                        <th>Valor Inicial</th>
                                        <th>Valor Aditivado</th>
                                        <th>Vigência</th>
                                        <th>Status</th>
                                        <th width="120">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contratos as $contrato)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $contrato->numero }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $contrato->tipoContrato->nome }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;" title="{{ $contrato->objeto }}">
                                                {{ $contrato->objeto }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $contrato->contratado }}">
                                                {{ $contrato->contratado }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-primary fw-bold">
                                                R$ {{ number_format($contrato->valor_inicial, 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($contrato->valor_atual > $contrato->valor_inicial)
                                                <span class="text-success fw-bold">
                                                    R$ {{ number_format($contrato->valor_atual, 2, ',', '.') }}
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    +R$ {{ number_format($contrato->valor_atual - $contrato->valor_inicial, 2, ',', '.') }}
                                                </small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                {{ $contrato->data_inicio ? $contrato->data_inicio->format('d/m/Y') : 'Não informado' }}<br>
                                                até {{ $contrato->data_fim ? $contrato->data_fim->format('d/m/Y') : 'Não informado' }}
                                                @if($contrato->data_fim_atual && $contrato->data_fim_atual != $contrato->data_fim)
                                                    <br><span class="text-info">Aditivado até {{ \Carbon\Carbon::parse($contrato->data_fim_atual)->format('d/m/Y') }}</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $temAditivos = $contrato->data_fim_atual && $contrato->data_fim_atual != $contrato->data_fim;
                                                $dataVencimento = $contrato->data_fim_atual ?? $contrato->data_fim;
                                                $vencido = $dataVencimento && \Carbon\Carbon::parse($dataVencimento)->isPast();
                                            @endphp
                                            
                                            @if($vencido)
                                                <span class="badge bg-danger">Vencido</span>
                                            @elseif($temAditivos)
                                                <span class="badge bg-info">Aditivado</span>
                                            @else
                                                <span class="badge bg-success">Em Vigência</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('transparencia.contratos.show', $contrato) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="Ver detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($contrato->arquivo_contrato)
                                                <a href="{{ route('transparencia.contratos.download', $contrato) }}" 
                                                   class="btn btn-outline-success" 
                                                   title="Download do contrato"
                                                   target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-file-contract fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Nenhum contrato encontrado</h5>
                            <p class="text-muted mb-0">
                                @if(request()->hasAny(['ano', 'tipo_contrato_id', 'status', 'search']))
                                    Tente ajustar os filtros de pesquisa.
                                @else
                                    Não há contratos públicos disponíveis no momento.
                                @endif
                            </p>
                            @if(request()->hasAny(['ano', 'tipo_contrato_id', 'status', 'search']))
                            <a href="{{ route('transparencia.contratos') }}" class="btn btn-outline-primary mt-3">
                                <i class="fas fa-times me-1"></i>
                                Limpar Filtros
                            </a>
                            @endif
                        </div>
                    @endif
                </div>
                
                @if($contratos->hasPages())
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-center">
                        {{ $contratos->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Valor Total -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <h4 class="mb-1">
                        <i class="fas fa-dollar-sign text-success me-2"></i>
                        R$ {{ number_format($estatisticas['valor_total'], 2, ',', '.') }}
                    </h4>
                    <p class="text-muted mb-0">Valor Total dos Contratos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Adicionais -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informações sobre os Contratos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">O que são contratos públicos?</h6>
                            <p class="text-muted small">
                                Os contratos públicos são acordos firmados pela Câmara Municipal com terceiros 
                                para a prestação de serviços, fornecimento de bens ou execução de obras, 
                                seguindo os princípios da legalidade, impessoalidade, moralidade, publicidade e eficiência.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Transparência e Acesso</h6>
                            <p class="text-muted small">
                                Conforme a Lei de Acesso à Informação (Lei nº 12.527/2011), todos os contratos 
                                públicos devem ser disponibilizados para consulta da população, garantindo 
                                transparência na gestão pública municipal.
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold">Legenda dos Status</h6>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2">Em Vigência</span>
                                    <small class="text-muted">Contrato dentro do prazo de vigência</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-2">Vencido</span>
                                    <small class="text-muted">Contrato com prazo de vigência expirado</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info me-2">Aditivado</span>
                                    <small class="text-muted">Contrato que possui aditivos de prazo ou valor</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
}

.table td {
    vertical-align: middle;
    font-size: 0.875rem;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.card {
    transition: all 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>
@endpush