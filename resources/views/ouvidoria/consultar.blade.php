@extends('layouts.app')

@section('title', 'Consultar Manifestação - Ouvidoria')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Hero Section -->
            <div class="text-center mb-5 p-4 bg-success text-white rounded">
                <h1><i class="fas fa-search me-3"></i>Consultar Manifestação</h1>
                <p class="mb-0">Digite o número do protocolo para acompanhar o andamento da sua manifestação</p>
            </div>

            <!-- Alerts -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                @if(session('protocolo'))
                    <br><strong>Protocolo: {{ session('protocolo') }}</strong>
                    <br><small>Anote este número para acompanhar sua manifestação.</small>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Formulário de Busca -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Buscar Protocolo
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('ouvidoria.consultar') }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <label for="protocolo" class="form-label">Número do Protocolo</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="protocolo" 
                                   name="protocolo" 
                                   placeholder="Ex: OUV2024001234"
                                   value="{{ request('protocolo') }}"
                                   required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-search me-2"></i>
                                Consultar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resultados -->
            @if(isset($manifestacao))
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Manifestação Encontrada
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Protocolo:</strong> {{ $manifestacao->protocolo }}</p>
                            <p><strong>Tipo:</strong> {{ ucfirst($manifestacao->tipo) }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $manifestacao->status == 'nova' ? 'primary' : ($manifestacao->status == 'em_analise' ? 'warning' : ($manifestacao->status == 'respondida' ? 'success' : 'secondary')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $manifestacao->status)) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Data:</strong> {{ $manifestacao->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Assunto:</strong> {{ $manifestacao->assunto }}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Descrição:</h5>
                    <p>{{ $manifestacao->descricao }}</p>

                    @if($manifestacao->movimentacoes && $manifestacao->movimentacoes->count() > 0)
                    <hr>
                    <h5>Histórico de Movimentações:</h5>
                    @foreach($manifestacao->movimentacoes as $movimentacao)
                    <div class="border-start border-3 border-success ps-3 mb-3">
                        <p class="mb-1"><strong>{{ $movimentacao->data_movimentacao->format('d/m/Y H:i') }}</strong></p>
                        <p class="mb-0">{{ $movimentacao->descricao }}</p>
                    </div>
                    @endforeach
                    @endif

                    @if($manifestacao->anexos && $manifestacao->anexos->count() > 0)
                    <hr>
                    <h5>Anexos:</h5>
                    @foreach($manifestacao->anexos as $anexo)
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-file me-2"></i>
                        <a href="{{ route('ouvidoria.download-anexo', ['protocolo' => $manifestacao->protocolo, 'arquivo' => $anexo->nome_arquivo]) }}" 
                           class="text-decoration-none">
                            {{ $anexo->nome_original }}
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @elseif(request('protocolo'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Nenhuma manifestação encontrada com o protocolo informado.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection