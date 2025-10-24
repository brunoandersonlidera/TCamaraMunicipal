@extends('layouts.ouvidor')

@section('title', 'Solicitações E-SIC')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-file-alt text-primary me-2"></i>
                        Solicitações E-SIC
                    </h1>
                    <p class="text-muted mb-0">Gerencie as solicitações de acesso à informação</p>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Todos os Status</option>
                                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="em_analise" {{ request('status') == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
                                <option value="aguardando_informacoes" {{ request('status') == 'aguardando_informacoes' ? 'selected' : '' }}>Aguardando Informações</option>
                                <option value="respondida" {{ request('status') == 'respondida' ? 'selected' : '' }}>Respondida</option>
                                <option value="negada" {{ request('status') == 'negada' ? 'selected' : '' }}>Negada</option>
                                <option value="finalizada" {{ request('status') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="prazo" class="form-label">Prazo</label>
                            <select name="prazo" id="prazo" class="form-select">
                                <option value="">Todos os Prazos</option>
                                <option value="vencidas" {{ request('prazo') == 'vencidas' ? 'selected' : '' }}>Vencidas</option>
                                <option value="vencendo" {{ request('prazo') == 'vencendo' ? 'selected' : '' }}>Vencendo (3 dias)</option>
                                <option value="no_prazo" {{ request('prazo') == 'no_prazo' ? 'selected' : '' }}>No Prazo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="busca" class="form-label">Buscar</label>
                            <input type="text" name="busca" id="busca" class="form-control" 
                                   placeholder="Protocolo, assunto ou nome do solicitante..." 
                                   value="{{ request('busca') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Solicitações -->
            <div class="card">
                <div class="card-body">
                    @if($solicitacoes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Solicitante</th>
                                        <th>Assunto</th>
                                        <th>Status</th>
                                        <th>Prazo</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($solicitacoes as $solicitacao)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">#{{ $solicitacao->protocolo }}</strong>
                                        </td>
                                        <td>
                                            @if($solicitacao->anonima)
                                                <span class="text-muted">
                                                    <i class="fas fa-user-secret me-1"></i>
                                                    Anônima
                                                </span>
                                            @else
                                                <div>{{ $solicitacao->nome_solicitante }}</div>
                                                <small class="text-muted">{{ $solicitacao->email_solicitante }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ Str::limit($solicitacao->assunto, 50) }}</div>
                                            <small class="text-muted">{{ Str::limit($solicitacao->descricao, 80) }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($solicitacao->status) {
                                                'pendente' => 'warning',
                                                'em_analise' => 'info',
                                                'aguardando_informacoes' => 'secondary',
                                                'informacoes_recebidas' => 'primary',
                                                'respondida' => 'success',
                                                'negada' => 'danger',
                                                'parcialmente_atendida' => 'warning',
                                                'finalizada' => 'dark',
                                                'arquivada' => 'secondary',
                                                default => 'secondary'
                                            };
                                            
                                            $statusText = match($solicitacao->status) {
                                                'pendente' => 'Pendente',
                                                'em_analise' => 'Em Análise',
                                                'aguardando_informacoes' => 'Aguardando Info.',
                                                'informacoes_recebidas' => 'Info. Recebidas',
                                                'respondida' => 'Respondida',
                                                'negada' => 'Negada',
                                                'parcialmente_atendida' => 'Parc. Atendida',
                                                'finalizada' => 'Finalizada',
                                                'arquivada' => 'Arquivada',
                                                default => 'Indefinido'
                                            };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            @if($solicitacao->data_limite_resposta)
                                                @php
                                                    $prazo = \Carbon\Carbon::parse($solicitacao->data_limite_resposta);
                                                    $hoje = \Carbon\Carbon::now();
                                                    $diasRestantes = $hoje->diffInDays($prazo, false);
                                                    $prazoFormatado = $solicitacao->diasParaRespostaFormatado();
                                                @endphp
                                                
                                                @if($diasRestantes < 0)
                                                    <span class="text-danger fw-bold">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Vencida
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $prazo->format('d/m/Y') }}</small>
                                                @elseif($diasRestantes <= 3)
                                                    <span class="text-warning fw-bold">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $prazoFormatado }}
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $prazo->format('d/m/Y') }}</small>
                                                @else
                                                    <span class="text-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        {{ $prazoFormatado }}
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $prazo->format('d/m/Y') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Não definido</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $solicitacao->data_solicitacao->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $solicitacao->data_solicitacao->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('ouvidor.esic.show', $solicitacao) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Ver Detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($solicitacoes->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $solicitacoes->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma solicitação encontrada</h5>
                            <p class="text-muted">
                                @if(request()->hasAny(['status', 'prazo', 'busca']))
                                    Tente ajustar os filtros para encontrar solicitações.
                                @else
                                    Não há solicitações E-SIC atribuídas a você no momento.
                                @endif
                            </p>
                            @if(request()->hasAny(['status', 'prazo', 'busca']))
                                <a href="{{ route('ouvidor.esic.index') }}" class="btn btn-outline-primary">
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
</div>


@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.badge {
    font-size: 0.75rem;
}

.table-responsive {
    border-radius: 0.5rem;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-text {
    font-size: 0.875rem;
}
</style>
@endpush