@extends('layouts.app')

@section('title', 'Contrato ' . $contrato->numero . ' - Portal da Transparência')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-file-contract text-info me-2"></i>
                        Contrato {{ $contrato->numero }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.index') }}">Portal da Transparência</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.contratos') }}">Contratos</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $contrato->numero }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('transparencia.contratos') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>
                        Voltar
                    </a>
                    @if($contrato->arquivo_contrato)
                    <a href="{{ route('transparencia.contratos.download', $contrato) }}" 
                       class="btn btn-sm btn-success" 
                       target="_blank"
                       title="Download do PDF do Contrato">
                        <i class="fas fa-download me-1"></i>
                        PDF
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Status do Contrato -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert {{ $contrato->isVencido() ? 'alert-danger' : 'alert-success' }} border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas {{ $contrato->isVencido() ? 'fa-exclamation-triangle' : 'fa-check-circle' }} fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">
                            Status: {{ $contrato->isVencido() ? 'Contrato Vencido' : 'Contrato Ativo' }}
                        </h5>
                        <p class="mb-0">
                            @php
                                $dataFimVigencia = $contrato->data_fim_atual ?? $contrato->data_fim;
                            @endphp
                            @if($contrato->isVencido())
                                Este contrato teve sua vigência encerrada em {{ $dataFimVigencia ? \Carbon\Carbon::parse($dataFimVigencia)->format('d/m/Y') : 'data não informada' }}.
                                @if($contrato->aditivos->where('tipo', 'prazo')->count() > 0 || $contrato->aditivos->where('tipo', 'valor_prazo')->count() > 0)
                                    <br><small class="text-muted"><i class="fas fa-info-circle me-1"></i>Data alterada por aditivo de prazo.</small>
                                @endif
                            @else
                                Este contrato está ativo e vigente até {{ $dataFimVigencia ? \Carbon\Carbon::parse($dataFimVigencia)->format('d/m/Y') : 'data não informada' }}.
                                @if($contrato->aditivos->where('tipo', 'prazo')->count() > 0 || $contrato->aditivos->where('tipo', 'valor_prazo')->count() > 0)
                                    <br><small class="text-muted"><i class="fas fa-info-circle me-1"></i>Prazo estendido por aditivo.</small>
                                @endif
                                @if($contrato->diasParaVencimento() <= 30)
                                    <br><strong>Atenção:</strong> Vence em {{ $contrato->diasParaVencimento() }} dias.
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Básicas -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informações Básicas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Número do Contrato</label>
                            <div class="fw-bold">{{ $contrato->numero }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Tipo de Contrato</label>
                            <div>
                                <span class="badge bg-secondary fs-6">{{ $contrato->tipoContrato->nome }}</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">Objeto do Contrato</label>
                            <div class="fw-bold">{{ $contrato->objeto }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Contratado</label>
                            <div class="fw-bold">{{ $contrato->contratado }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">CNPJ/CPF</label>
                            <div>{{ $contrato->cnpj_cpf }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-dollar-sign me-2"></i>
                        Valores
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Valor Inicial</label>
                        <div class="h5 text-primary mb-0">
                            R$ {{ number_format($contrato->valor_inicial, 2, ',', '.') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Valor Atual</label>
                        <div class="h4 text-success mb-0">
                            R$ {{ number_format($contrato->valor_atual, 2, ',', '.') }}
                        </div>
                    </div>
                    @if($contrato->valor_atual != $contrato->valor_inicial)
                    <div class="mb-0">
                        <small class="text-muted">
                            @if($contrato->valor_atual > $contrato->valor_inicial)
                                <i class="fas fa-arrow-up text-warning me-1"></i>
                                Acréscimo de R$ {{ number_format($contrato->valor_atual - $contrato->valor_inicial, 2, ',', '.') }}
                            @else
                                <i class="fas fa-arrow-down text-info me-1"></i>
                                Redução de R$ {{ number_format($contrato->valor_inicial - $contrato->valor_atual, 2, ',', '.') }}
                            @endif
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Datas e Vigência -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Datas e Vigência
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="form-label text-muted small">Data de Assinatura</label>
                            <div class="fw-bold">
                                <i class="fas fa-pen me-1 text-primary"></i>
                                {{ $contrato->data_assinatura ? $contrato->data_assinatura->format('d/m/Y') : 'Não informado' }}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="form-label text-muted small">Início da Vigência</label>
                            <div class="fw-bold">
                                <i class="fas fa-play me-1 text-success"></i>
                                {{ $contrato->data_inicio ? $contrato->data_inicio->format('d/m/Y') : 'Não informado' }}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="form-label text-muted small">Fim da Vigência</label>
                            <div class="fw-bold">
                                <i class="fas fa-stop me-1 {{ $contrato->isVencido() ? 'text-danger' : 'text-warning' }}"></i>
                                {{ $contrato->data_fim ? $contrato->data_fim->format('d/m/Y') : 'Não informado' }}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="form-label text-muted small">Duração</label>
                            <div class="fw-bold">
                                <i class="fas fa-clock me-1 text-info"></i>
                                @if($contrato->data_inicio && $contrato->data_fim)
                                    {{ $contrato->data_inicio->diffInDays($contrato->data_fim) }} dias
                                @else
                                    Não calculado
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Observações -->
    @if($contrato->observacoes)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-sticky-note me-2"></i>
                        Observações
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-muted">
                        {!! nl2br(e($contrato->observacoes)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Aditivos -->
    @if($contrato->aditivos->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Aditivos Contratuais
                        <span class="badge bg-primary ms-2">{{ $contrato->aditivos->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Número</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th>Data Assinatura</th>
                                    <th>Data Fim Vigência</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contrato->aditivos as $aditivo)
                                <tr>
                                    <td>
                                        <span class="badge bg-info">{{ $aditivo->numero }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $aditivo->tipo }}</span>
                                    </td>
                                    <td>
                                        @if($aditivo->valor_aditivo)
                                            <span class="text-success fw-bold">
                                                R$ {{ number_format($aditivo->valor_aditivo, 2, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $aditivo->data_assinatura ? $aditivo->data_assinatura->format('d/m/Y') : 'Não informado' }}</td>
                                    <td>
                                        @if(in_array($aditivo->tipo, ['prazo', 'prazo_valor']) && $aditivo->data_fim_vigencia)
                                            <span class="text-info fw-bold">
                                                {{ $aditivo->data_fim_vigencia->format('d/m/Y') }}
                                            </span>
                                        @elseif(in_array($aditivo->tipo, ['prazo', 'prazo_valor']))
                                            <span class="text-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Não informado
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-truncate me-2" style="max-width: 200px;" title="{{ $aditivo->objeto ?? $aditivo->justificativa }}">
                                                {{ $aditivo->objeto ?? $aditivo->justificativa ?? 'Não informado' }}
                                            </div>
                                            @if($aditivo->arquivo_aditivo)
                                                <a href="{{ route('transparencia.contratos.aditivos.download', [$contrato, $aditivo]) }}" 
                                                   class="btn btn-sm btn-success" 
                                                   title="Download do PDF do Aditivo"
                                                   target="_blank">
                                                    <i class="fas fa-download me-1"></i>
                                                    PDF
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Fiscalizações -->
    @if($contrato->fiscalizacoes->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-search me-2"></i>
                        Fiscalizações
                        <span class="badge bg-primary ms-2">{{ $contrato->fiscalizacoes->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Fiscal</th>
                                    <th>Tipo</th>
                                    <th>Observações</th>
                                    <th width="120">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contrato->fiscalizacoes as $fiscalizacao)
                                <tr>
                                    <td>{{ $fiscalizacao->data_fiscalizacao ? \Carbon\Carbon::parse($fiscalizacao->data_fiscalizacao)->format('d/m/Y') : 'Não informado' }}</td>
                                    <td>{{ $fiscalizacao->fiscal_responsavel }}</td>
                                    <td>
                                        <span class="badge bg-warning">
                                            {{ ucfirst(str_replace('_', ' ', $fiscalizacao->tipo_fiscalizacao)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 400px;" title="{{ $fiscalizacao->observacoes_encontradas }}">
                                            {{ $fiscalizacao->observacoes_encontradas }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($fiscalizacao->arquivo_pdf)
                                            <a href="{{ route('contratos.fiscalizacoes.pdf.publico', ['contrato' => $contrato->id, 'fiscalizacao' => $fiscalizacao->id]) }}" 
                                               class="btn btn-sm btn-success" 
                                               title="Download do PDF da Fiscalização"
                                               target="_blank">
                                                <i class="fas fa-download me-1"></i>
                                                PDF
                                            </a>
                                        @else
                                            <span class="text-muted small">Sem PDF</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Arquivo do Contrato -->
    @if($contrato->arquivo_contrato)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-file-pdf me-2"></i>
                        Arquivo do Contrato
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-file-pdf fa-3x text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ basename($contrato->arquivo_contrato) }}</h6>
                                <small class="text-muted">
                                    Arquivo do contrato em formato PDF
                                </small>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('transparencia.contratos.download', $contrato) }}" 
                               class="btn btn-sm btn-success" 
                               target="_blank"
                               title="Download do PDF do Contrato">
                                <i class="fas fa-download me-1"></i>
                                PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Informações Legais -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-balance-scale me-2"></i>
                        Informações Legais
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Base Legal</h6>
                            <p class="text-muted small mb-3">
                                Este contrato foi celebrado em conformidade com a Lei nº 8.666/93 (Lei de Licitações) 
                                e demais normas aplicáveis à contratação pública.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Transparência</h6>
                            <p class="text-muted small mb-3">
                                Informações disponibilizadas conforme a Lei nº 12.527/2011 (Lei de Acesso à Informação) 
                                e o Decreto nº 7.724/2012.
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Última atualização:</strong> {{ $contrato->updated_at ? $contrato->updated_at->format('d/m/Y H:i') : 'Não informado' }}
                                | <strong>Publicado em:</strong> {{ $contrato->created_at ? $contrato->created_at->format('d/m/Y H:i') : 'Não informado' }}
                            </small>
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
.alert {
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #28a745;
}

.alert-danger {
    border-left-color: #dc3545;
}

.card {
    transition: all 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
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

.form-label {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.badge {
    font-size: 0.75rem;
}

.fs-6 {
    font-size: 1rem !important;
}
</style>
@endpush