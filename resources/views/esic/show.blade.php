@extends('layouts.app')

@section('title', 'Solicitação #' . $solicitacao->protocolo . ' - E-SIC')

@section('content')
<div class="esic-show-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h1 class="page-title">
                                <i class="fas fa-file-alt me-3"></i>
                                Solicitação E-SIC
                            </h1>
                            <p class="page-subtitle">
                                Protocolo: <strong>{{ $solicitacao->protocolo }}</strong>
                            </p>
                        </div>
                        <div class="status-badge">
                            <span class="badge badge-{{ $solicitacao->status }}">
                                {{ ucfirst(str_replace('_', ' ', $solicitacao->status)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informações da Solicitação -->
                <div class="info-card">
                    <div class="card-header">
                        <h3><i class="fas fa-info-circle me-2"></i>Informações da Solicitação</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Data da Solicitação:</label>
                                    <span>{{ $solicitacao->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Categoria:</label>
                                    <span>{{ ucfirst(str_replace('_', ' ', $solicitacao->categoria)) }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Forma de Recebimento:</label>
                                    <span>{{ ucfirst($solicitacao->forma_recebimento) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Status:</label>
                                    <span class="badge badge-{{ $solicitacao->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $solicitacao->status)) }}
                                    </span>
                                </div>
                                @if($solicitacao->data_resposta)
                                <div class="info-item">
                                    <label>Data da Resposta:</label>
                                    <span>{{ \Carbon\Carbon::parse($solicitacao->data_resposta)->format('d/m/Y H:i') }}</span>
                                </div>
                                @endif
                                <div class="info-item">
                                    <label>Prazo Limite:</label>
                                    <span class="{{ $solicitacao->created_at->addDays(20) < now() ? 'text-danger' : 'text-success' }}">
                                        {{ $solicitacao->created_at->addDays(20)->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados do Solicitante -->
                <div class="info-card">
                    <div class="card-header">
                        <h3><i class="fas fa-user me-2"></i>Dados do Solicitante</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Nome:</label>
                                    <span>{{ $solicitacao->anonima ? 'Solicitação Anônima' : $solicitacao->nome_solicitante }}</span>
                                </div>
                                @if(!$solicitacao->anonima)
                                <div class="info-item">
                                    <label>E-mail:</label>
                                    <span>{{ $solicitacao->email_solicitante }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if(!$solicitacao->anonima && $solicitacao->telefone_solicitante)
                                <div class="info-item">
                                    <label>Telefone:</label>
                                    <span>{{ $solicitacao->telefone_solicitante }}</span>
                                </div>
                                @endif
                                <div class="info-item">
                                    <label>Solicitação Anônima:</label>
                                    <span class="badge {{ $solicitacao->anonima ? 'bg-warning' : 'bg-info' }}">
                                        {{ $solicitacao->anonima ? 'Sim' : 'Não' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo da Solicitação -->
                <div class="info-card">
                    <div class="card-header">
                        <h3><i class="fas fa-file-text me-2"></i>Conteúdo da Solicitação</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <label>Assunto:</label>
                            <span class="fw-bold">{{ $solicitacao->assunto }}</span>
                        </div>
                        <div class="info-item">
                            <label>Descrição:</label>
                            <div class="description-content">
                                {!! nl2br(e($solicitacao->descricao)) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resposta (se houver) -->
                @if($solicitacao->resposta)
                <div class="info-card response-card">
                    <div class="card-header">
                        <h3><i class="fas fa-reply me-2"></i>Resposta da Câmara Municipal</h3>
                    </div>
                    <div class="card-body">
                        <div class="response-meta">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Respondido por:</label>
                                        <span>{{ $solicitacao->respondido_por ?? 'Câmara Municipal' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Data da Resposta:</label>
                                        <span>{{ \Carbon\Carbon::parse($solicitacao->data_resposta)->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="response-content">
                            {!! nl2br(e($solicitacao->resposta)) !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timeline de Status -->
                <div class="info-card">
                    <div class="card-header">
                        <h3><i class="fas fa-history me-2"></i>Histórico da Solicitação</h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item active">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Solicitação Recebida</h4>
                                    <p>{{ $solicitacao->created_at->format('d/m/Y H:i') }}</p>
                                    <small>Sua solicitação foi registrada no sistema</small>
                                </div>
                            </div>

                            @if($solicitacao->status !== 'pendente')
                            <div class="timeline-item active">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Em Análise</h4>
                                    <p>{{ $solicitacao->updated_at->format('d/m/Y H:i') }}</p>
                                    <small>Solicitação está sendo analisada pela equipe responsável</small>
                                </div>
                            </div>
                            @endif

                            @if($solicitacao->status === 'respondida')
                            <div class="timeline-item active">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Respondida</h4>
                                    <p>{{ \Carbon\Carbon::parse($solicitacao->data_resposta)->format('d/m/Y H:i') }}</p>
                                    <small>Resposta fornecida pela Câmara Municipal</small>
                                </div>
                            </div>
                            @endif

                            @if($solicitacao->status === 'negada')
                            <div class="timeline-item active">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Negada</h4>
                                    <p>{{ \Carbon\Carbon::parse($solicitacao->data_resposta)->format('d/m/Y H:i') }}</p>
                                    <small>Solicitação negada com justificativa</small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="actions-section">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('esic.consultar') }}" class="btn btn-outline-primary">
                                <i class="fas fa-search me-2"></i>
                                Consultar Outra Solicitação
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('esic.index') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>
                                Voltar ao E-SIC
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informações de Recurso -->
                @if($solicitacao->status === 'negada')
                <div class="alert alert-info mt-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Direito de Recurso</h5>
                    <p>
                        Caso não concorde com a negativa, você tem o direito de apresentar recurso no prazo de 10 dias 
                        a partir da ciência da decisão. Entre em contato conosco através dos canais oficiais.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/esic.css') }}">
@endpush