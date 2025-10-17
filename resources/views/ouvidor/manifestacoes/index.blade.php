@extends('layouts.ouvidor')

@section('title', 'Manifestações')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-comments me-2"></i>
                    Manifestações
                </h1>
                <div class="page-actions">
                    <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                        <i class="fas fa-sync-alt me-1"></i>
                        Atualizar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filtros
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('ouvidor.manifestacoes.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Todos os status</option>
                                    <option value="nova" {{ request('status') == 'nova' ? 'selected' : '' }}>Nova</option>
                                    <option value="em_analise" {{ request('status') == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
                                    <option value="em_tramitacao" {{ request('status') == 'em_tramitacao' ? 'selected' : '' }}>Em Tramitação</option>
                                    <option value="aguardando_informacoes" {{ request('status') == 'aguardando_informacoes' ? 'selected' : '' }}>Aguardando Informações</option>
                                    <option value="respondida" {{ request('status') == 'respondida' ? 'selected' : '' }}>Respondida</option>
                                    <option value="finalizada" {{ request('status') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                    <option value="arquivada" {{ request('status') == 'arquivada' ? 'selected' : '' }}>Arquivada</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" class="form-select">
                                    <option value="">Todos os tipos</option>
                                    <option value="reclamacao" {{ request('tipo') == 'reclamacao' ? 'selected' : '' }}>Reclamação</option>
                                    <option value="sugestao" {{ request('tipo') == 'sugestao' ? 'selected' : '' }}>Sugestão</option>
                                    <option value="elogio" {{ request('tipo') == 'elogio' ? 'selected' : '' }}>Elogio</option>
                                    <option value="denuncia" {{ request('tipo') == 'denuncia' ? 'selected' : '' }}>Denúncia</option>
                                    <option value="informacao" {{ request('tipo') == 'informacao' ? 'selected' : '' }}>Informação</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Buscar</label>
                                <input type="text" name="busca" class="form-control" 
                                       placeholder="Protocolo, assunto, manifestante..." 
                                       value="{{ request('busca') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i>
                                        Filtrar
                                    </button>
                                    <a href="{{ route('ouvidor.manifestacoes.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Limpar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Manifestações -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Manifestações Atribuídas
                        <span class="badge bg-primary ms-2">{{ $manifestacoes->total() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($manifestacoes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Tipo</th>
                                        <th>Manifestante</th>
                                        <th>Assunto</th>
                                        <th>Responsável</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Prazo</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($manifestacoes as $manifestacao)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $manifestacao->protocolo }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $tipoIcons = [
                                                    'reclamacao' => 'fas fa-exclamation-triangle text-warning',
                                                    'sugestao' => 'fas fa-lightbulb text-info',
                                                    'elogio' => 'fas fa-thumbs-up text-success',
                                                    'denuncia' => 'fas fa-flag text-danger',
                                                    'informacao' => 'fas fa-info-circle text-primary'
                                                ];
                                            @endphp
                                            <i class="{{ $tipoIcons[$manifestacao->tipo] ?? 'fas fa-comment' }} me-1"></i>
                                            {{ ucfirst($manifestacao->tipo) }}
                                        </td>
                                        <td>
                                            @if($manifestacao->manifestacao_anonima)
                                                <span class="text-muted">
                                                    <i class="fas fa-user-secret me-1"></i>
                                                    Anônima
                                                </span>
                                            @else
                                                {{ $manifestacao->nome_manifestante ?? 'Não informado' }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $manifestacao->assunto }}">
                                                {{ $manifestacao->assunto }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($manifestacao->ouvidorResponsavel)
                                                <small class="text-muted">{{ $manifestacao->ouvidorResponsavel->name }}</small>
                                            @else
                                                <small class="text-muted">Não atribuída</small>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'nova' => 'bg-info',
                                                    'em_analise' => 'bg-warning',
                                                    'em_tramitacao' => 'bg-primary',
                                                    'aguardando_informacoes' => 'bg-secondary',
                                                    'respondida' => 'bg-success',
                                                    'finalizada' => 'bg-dark',
                                                    'arquivada' => 'bg-light text-dark'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClasses[$manifestacao->status] ?? 'bg-secondary' }}">
                                                {{ ucwords(str_replace('_', ' ', $manifestacao->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $manifestacao->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($manifestacao->prazo_resposta)
                                                @php
                                                    $prazo = \Carbon\Carbon::parse($manifestacao->prazo_resposta);
                                                    $hoje = \Carbon\Carbon::now();
                                                    $diasRestantes = $hoje->diffInDays($prazo, false);
                                                @endphp
                                                @if($diasRestantes < 0)
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Vencido
                                                    </span>
                                                @elseif($diasRestantes == 0)
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Hoje
                                                    </span>
                                                @elseif($diasRestantes <= 3)
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $diasRestantes }} dia(s)
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>
                                                        {{ $diasRestantes }} dia(s)
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('ouvidor.manifestacoes.show', $manifestacao) }}" 
                                                   class="btn btn-outline-primary" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(in_array($manifestacao->status, ['recebida', 'nova', 'em_analise', 'em_tramitacao', 'aguardando_informacoes']))
                                                    <button class="btn btn-outline-success" 
                                                            onclick="responderManifestacao({{ $manifestacao->id }})" 
                                                            title="Responder">
                                                        <i class="fas fa-reply"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($manifestacoes->hasPages())
                            <div class="card-footer">
                                {{ $manifestacoes->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma manifestação encontrada</h5>
                            <p class="text-muted">
                                @if(request()->hasAny(['status', 'tipo', 'busca']))
                                    Tente ajustar os filtros para encontrar manifestações.
                                @else
                                    Você ainda não possui manifestações atribuídas.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.page-title {
    margin: 0;
    color: #495057;
}

.page-actions {
    display: flex;
    gap: 0.5rem;
}

.table th {
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>

<script>
function responderManifestacao(id) {
    // Redirecionar para página de resposta ou abrir modal
    window.location.href = `/ouvidor/manifestacoes/${id}`;
}
</script>
@endsection