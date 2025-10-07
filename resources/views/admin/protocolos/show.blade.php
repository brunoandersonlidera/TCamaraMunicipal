@extends('layouts.admin')

@section('title', 'Protocolo: ' . $protocolo->numero_protocolo)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.protocolos.index') }}">Protocolos</a></li>
                        <li class="breadcrumb-item active">{{ $protocolo->numero_protocolo }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Protocolo: {{ $protocolo->numero_protocolo }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title">Detalhes do Protocolo</h4>
                        <div>
                            <a href="{{ route('admin.protocolos.edit', $protocolo) }}" class="btn btn-warning btn-sm">
                                <i class="mdi mdi-pencil"></i> Editar
                            </a>
                            <a href="{{ route('admin.protocolos.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Número do Protocolo:</label>
                                <p class="mb-0">{{ $protocolo->numero_protocolo }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Data de Protocolo:</label>
                                <p class="mb-0">{{ $protocolo->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo:</label>
                                <p class="mb-0">
                                    <span class="badge bg-info">
                                        {{ ucfirst(str_replace('_', ' ', $protocolo->tipo)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <p class="mb-0">
                                    @php
                                        $statusColors = [
                                            'protocolado' => 'secondary',
                                            'em_tramitacao' => 'warning',
                                            'aprovado' => 'success',
                                            'rejeitado' => 'danger',
                                            'arquivado' => 'dark'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$protocolo->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $protocolo->status)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Título:</label>
                        <p class="mb-0">{{ $protocolo->titulo }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Autor:</label>
                        <p class="mb-0">{{ $protocolo->autor }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ementa:</label>
                        <p class="mb-0">{{ $protocolo->ementa }}</p>
                    </div>

                    @if($protocolo->justificativa)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Justificativa:</label>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($protocolo->justificativa)) !!}
                        </div>
                    </div>
                    @endif

                    @if($protocolo->arquivo_projeto || $protocolo->arquivo_justificativa)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Arquivos:</label>
                        <div class="row">
                            @if($protocolo->arquivo_projeto)
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf text-danger fa-2x mb-2"></i>
                                        <h6>Arquivo do Projeto</h6>
                                        <a href="{{ Storage::url($protocolo->arquivo_projeto) }}" 
                                           class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="mdi mdi-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($protocolo->arquivo_justificativa)
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf text-danger fa-2x mb-2"></i>
                                        <h6>Arquivo da Justificativa</h6>
                                        <a href="{{ Storage::url($protocolo->arquivo_justificativa) }}" 
                                           class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="mdi mdi-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($protocolo->consulta_publica)
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i>
                        <strong>Consulta Pública:</strong> Este protocolo está disponível para consulta pública.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Histórico de Tramitação -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Histórico de Tramitação</h4>
                    
                    @php
                        $historicoTramitacao = $protocolo->historico_tramitacao ?? [];
                        if (is_string($historicoTramitacao)) {
                            $historicoTramitacao = json_decode($historicoTramitacao, true) ?? [];
                        }
                    @endphp
                    
                    @if(!empty($historicoTramitacao) && is_array($historicoTramitacao))
                        <div class="timeline-alt pb-0">
                            @foreach($historicoTramitacao as $historico)
                            <div class="timeline-item">
                                <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <h5 class="mt-0 mb-1">{{ $historico['acao'] ?? 'Ação não especificada' }}</h5>
                                    <p class="font-14">{{ $historico['observacao'] ?? '' }}</p>
                                    <p class="text-muted font-12 mb-0">
                                        <i class="mdi mdi-clock"></i> 
                                        {{ isset($historico['data']) ? \Carbon\Carbon::parse($historico['data'])->format('d/m/Y H:i') : 'Data não informada' }}
                                    </p>
                                    @if(isset($historico['usuario']))
                                    <p class="text-muted font-12 mb-0">
                                        <i class="mdi mdi-account"></i> {{ $historico['usuario'] }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <i class="mdi mdi-timeline-clock text-muted" style="font-size: 48px;"></i>
                            <p class="text-muted mt-2">Nenhum histórico de tramitação disponível.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Ações Rápidas</h4>
                    
                    <div class="d-grid gap-2">
                        @if($protocolo->status == 'protocolado')
                        <form action="{{ route('admin.protocolos.update', $protocolo) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="em_tramitacao">
                            <button type="submit" class="btn btn-warning btn-sm w-100">
                                <i class="mdi mdi-play"></i> Iniciar Tramitação
                            </button>
                        </form>
                        @endif

                        @if($protocolo->status == 'em_tramitacao')
                        <form action="{{ route('admin.protocolos.update', $protocolo) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="aprovado">
                            <button type="submit" class="btn btn-success btn-sm w-100">
                                <i class="mdi mdi-check"></i> Aprovar
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.protocolos.update', $protocolo) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejeitado">
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="mdi mdi-close"></i> Rejeitar
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('admin.protocolos.update', $protocolo) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="arquivado">
                            <button type="submit" class="btn btn-secondary btn-sm w-100">
                                <i class="mdi mdi-archive"></i> Arquivar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection