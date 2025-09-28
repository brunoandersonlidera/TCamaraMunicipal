@extends('layouts.admin')

@section('title', 'Detalhes do Aditivo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-file-contract mr-2"></i>
                        Detalhes do Aditivo {{ $aditivo->numero_aditivo }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.contratos.show', $contrato) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar ao Contrato
                        </a>
                        <a href="{{ route('admin.contratos.aditivos.edit', [$contrato, $aditivo]) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        @if($aditivo->arquivo_aditivo)
                        <a href="{{ route('admin.contratos.aditivos.download', [$contrato, $aditivo]) }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Download
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <!-- Informações do Contrato -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-muted">Contrato Relacionado</h5>
                            <p><strong>{{ $contrato->numero_contrato }}</strong> - {{ $contrato->objeto }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Informações do Aditivo -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Número do Aditivo:</strong></label>
                                <p>{{ $aditivo->numero_aditivo }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Tipo:</strong></label>
                                <p>
                                    @switch($aditivo->tipo)
                        @case('valor')
                            <span class="badge-contrato badge-aditivo-valor">Valor</span>
                            @break
                        @case('prazo')
                            <span class="badge-contrato badge-aditivo-prazo">Prazo</span>
                            @break
                        @case('valor_prazo')
                            <span class="badge-contrato badge-aditivo-valor-prazo">Valor e Prazo</span>
                            @break
                        @case('supressao')
                            <span class="badge-contrato badge-aditivo-supressao">Supressão</span>
                            @break
                        @case('acrescimo')
                            <span class="badge-contrato badge-aditivo-acrescimo">Acréscimo</span>
                            @break
                        @default
                            <span class="badge-contrato badge-aditivo-default">{{ ucfirst($aditivo->tipo) }}</span>
                    @endswitch
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Data de Assinatura:</strong></label>
                                <p>{{ $aditivo->data_assinatura ? $aditivo->data_assinatura->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Valor:</strong></label>
                                <p>
                                    @if($aditivo->valor_aditivo)
                                        R$ {{ number_format($aditivo->valor_aditivo, 2, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Data de Início da Vigência:</strong></label>
                                <p>{{ $aditivo->data_inicio_vigencia ? $aditivo->data_inicio_vigencia->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Data de Fim da Vigência:</strong></label>
                                <p>{{ $aditivo->data_fim_vigencia ? $aditivo->data_fim_vigencia->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><strong>Objeto:</strong></label>
                                <p>{{ $aditivo->objeto ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><strong>Justificativa:</strong></label>
                                <p>{{ $aditivo->justificativa ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($aditivo->arquivo_aditivo)
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><strong>Arquivo Anexo:</strong></label>
                                <p>
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    {{ basename($aditivo->arquivo_aditivo) }}
                                    <a href="{{ route('admin.contratos.aditivos.download', [$contrato, $aditivo]) }}" 
                                       class="btn btn-sm btn-outline-success ml-2">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Informações de Sistema -->
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Criado em:</strong></label>
                                <p>{{ $aditivo->created_at ? $aditivo->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Última atualização:</strong></label>
                                <p>{{ $aditivo->updated_at ? $aditivo->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection