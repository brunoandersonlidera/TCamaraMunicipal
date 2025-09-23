@extends('layouts.app')

@section('title', 'Licitação ' . $licitacao->numero_processo . ' - Portal da Transparência')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-gavel text-info me-2"></i>
                        Licitação {{ $licitacao->numero_processo }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.index') }}">Portal da Transparência</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('transparencia.licitacoes') }}">Licitações</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $licitacao->numero_processo }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('transparencia.licitacoes') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações da Licitação -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informações da Licitação
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <strong>Número do Processo:</strong><br>
                            <code class="text-primary">{{ $licitacao->numero_processo }}</code>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Número do Edital:</strong><br>
                            {{ $licitacao->numero_edital ?? '-' }}
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Modalidade:</strong><br>
                            <span class="badge bg-secondary">{{ $licitacao->modalidade }}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Tipo:</strong><br>
                            {{ $licitacao->tipo ?? '-' }}
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Objeto:</strong><br>
                            {{ $licitacao->objeto }}
                        </div>
                        @if($licitacao->descricao_detalhada)
                        <div class="col-12 mb-3">
                            <strong>Descrição Detalhada:</strong><br>
                            <div class="text-muted">{{ $licitacao->descricao_detalhada }}</div>
                        </div>
                        @endif
                        <div class="col-lg-6 mb-3">
                            <strong>Valor Estimado:</strong><br>
                            @if($licitacao->valor_estimado)
                                <span class="text-success fw-bold">R$ {{ number_format($licitacao->valor_estimado, 2, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Valor Homologado:</strong><br>
                            @if($licitacao->valor_homologado)
                                <span class="text-success fw-bold">R$ {{ number_format($licitacao->valor_homologado, 2, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Data de Publicação:</strong><br>
                            @if($licitacao->data_publicacao)
                                {{ $licitacao->data_publicacao->format('d/m/Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Data de Abertura:</strong><br>
                            @if($licitacao->data_abertura)
                                {{ $licitacao->data_abertura->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Local de Abertura:</strong><br>
                            {{ $licitacao->local_abertura ?? '-' }}
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Responsável:</strong><br>
                            {{ $licitacao->responsavel ?? '-' }}
                        </div>
                        @if($licitacao->vencedor)
                        <div class="col-lg-6 mb-3">
                            <strong>Vencedor:</strong><br>
                            <div class="fw-bold">{{ $licitacao->vencedor }}</div>
                            @if($licitacao->cnpj_vencedor)
                                <small class="text-muted">CNPJ: {{ $licitacao->cnpj_vencedor }}</small>
                            @endif
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong>Valor do Vencedor:</strong><br>
                            @if($licitacao->valor_vencedor)
                                <span class="text-success fw-bold">R$ {{ number_format($licitacao->valor_vencedor, 2, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                        @endif
                        <div class="col-lg-6 mb-3">
                            <strong>Situação:</strong><br>
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
                        </div>
                        @if($licitacao->observacoes)
                        <div class="col-12 mb-3">
                            <strong>Observações:</strong><br>
                            <div class="text-muted">{{ $licitacao->observacoes }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documentos -->
    @if($licitacao->documentos->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Documentos Disponíveis
                    </h5>
                    <span class="badge bg-primary">{{ $licitacao->documentos->count() }} documento(s)</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($licitacao->documentos as $documento)
                        <div class="col-lg-6 col-xl-4 mb-3">
                            <div class="card h-100 border">
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-2">
                                        <div class="me-2">
                                            @switch($documento->tipo_documento)
                                                @case('edital')
                                                    <i class="fas fa-file-contract text-primary fa-2x"></i>
                                                    @break
                                                @case('anexo_edital')
                                                    <i class="fas fa-paperclip text-info fa-2x"></i>
                                                    @break
                                                @case('ata_abertura')
                                                @case('ata_julgamento')
                                                    <i class="fas fa-file-signature text-warning fa-2x"></i>
                                                    @break
                                                @case('resultado')
                                                    <i class="fas fa-trophy text-success fa-2x"></i>
                                                    @break
                                                @case('contrato')
                                                    <i class="fas fa-handshake text-success fa-2x"></i>
                                                    @break
                                                @case('termo_referencia')
                                                @case('projeto_basico')
                                                    <i class="fas fa-file-alt text-secondary fa-2x"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-file text-muted fa-2x"></i>
                                            @endswitch
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">{{ $documento->nome }}</h6>
                                            @if($documento->descricao)
                                                <p class="card-text text-muted small mb-2">{{ $documento->descricao }}</p>
                                            @endif
                                            <div class="small text-muted">
                                                <div><strong>Arquivo:</strong> {{ Str::limit($documento->arquivo_original, 25) }}</div>
                                                <div><strong>Tipo:</strong> {{ ucfirst(str_replace('_', ' ', $documento->tipo_documento)) }}</div>
                                                <div><strong>Tamanho:</strong> {{ number_format($documento->tamanho / 1024, 1) }} KB</div>
                                                <div><strong>Enviado em:</strong> {{ $documento->created_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <a href="{{ route('transparencia.licitacoes.documento.download', [$licitacao, $documento]) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-download me-1"></i>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum documento disponível</h5>
                    <p class="text-muted">Esta licitação ainda não possui documentos públicos.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection