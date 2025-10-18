@extends('layouts.admin')

@section('title', 'Manifestações da Ouvidoria')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Manifestações da Ouvidoria</li>
    </ol>
</nav>
@endsection

@section('content')
<style>
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.stat-item {
    text-align: center;
    padding: 20px;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.filters-card {
    background: white;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-left: 4px solid #667eea;
}

.manifestacoes-table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    padding: 15px;
}

.table tbody td {
    padding: 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pendente {
    background: #fff3cd;
    color: #856404;
}

.status-em-andamento {
    background: #cce5ff;
    color: #004085;
}

.status-respondida {
    background: #d4edda;
    color: #155724;
}

.status-arquivada {
    background: #f8d7da;
    color: #721c24;
}

.tipo-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 500;
    text-transform: uppercase;
}

.tipo-reclamacao {
    background: #ffebee;
    color: #c62828;
}

.tipo-sugestao {
    background: #e8f5e8;
    color: #2e7d32;
}

.tipo-elogio {
    background: #fff3e0;
    color: #ef6c00;
}

.tipo-denuncia {
    background: #fce4ec;
    color: #ad1457;
}

.tipo-solicitacao {
    background: #e3f2fd;
    color: #1565c0;
}

.priority-badge {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.priority-baixa {
    background: #4caf50;
}

.priority-media {
    background: #ff9800;
}

.priority-alta {
    background: #f44336;
}

.priority-urgente {
    background: #9c27b0;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn-action {
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-view {
    background: #17a2b8;
    color: white;
}

.btn-view:hover {
    background: #138496;
    color: white;
}

.btn-edit {
    background: #28a745;
    color: white;
}

.btn-edit:hover {
    background: #218838;
    color: white;
}

.btn-respond {
    background: #007bff;
    color: white;
}

.btn-respond:hover {
    background: #0056b3;
    color: white;
}

.btn-archive {
    background: #6c757d;
    color: white;
}

.btn-archive:hover {
    background: #545b62;
    color: white;
}

.search-box {
    position: relative;
}

.search-box input {
    padding-left: 40px;
}

.search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.filter-row {
    display: flex;
    gap: 15px;
    align-items: end;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.pagination-wrapper {
    background: white;
    padding: 20px;
    border-radius: 0 0 10px 10px;
    border-top: 1px solid #f0f0f0;
}

@media (max-width: 768px) {
    .stats-card .row {
        text-align: center;
    }
    
    .stat-item {
        margin-bottom: 20px;
    }
    
    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        min-width: auto;
    }
    
    .table-responsive {
        font-size: 14px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<div class="container-fluid">
    <!-- Estatísticas -->
    <div class="stats-card">
        <div class="row">
            <div class="col-md-2 col-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['total'] ?? 0 }}</span>
                    <span class="stat-label">Total</span>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['pendentes'] ?? 0 }}</span>
                    <span class="stat-label">Pendentes</span>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['em_andamento'] ?? 0 }}</span>
                    <span class="stat-label">Em Andamento</span>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['respondidas'] ?? 0 }}</span>
                    <span class="stat-label">Respondidas</span>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['mes_atual'] ?? 0 }}</span>
                    <span class="stat-label">Este Mês</span>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['tempo_medio'] ?? 0 }}</span>
                    <span class="stat-label">Dias Médio</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filtros</h5>
        
        <form method="GET" action="{{ route('admin.ouvidoria-manifestacoes.index') }}" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search" class="form-label">Buscar</label>
                    <div class="search-box">
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Protocolo, nome, assunto...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                
                <div class="filter-group">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Todos os tipos</option>
                        <option value="reclamacao" {{ request('tipo') == 'reclamacao' ? 'selected' : '' }}>Reclamação</option>
                        <option value="sugestao" {{ request('tipo') == 'sugestao' ? 'selected' : '' }}>Sugestão</option>
                        <option value="elogio" {{ request('tipo') == 'elogio' ? 'selected' : '' }}>Elogio</option>
                        <option value="denuncia" {{ request('tipo') == 'denuncia' ? 'selected' : '' }}>Denúncia</option>
                        <option value="solicitacao" {{ request('tipo') == 'solicitacao' ? 'selected' : '' }}>Solicitação</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="respondida" {{ request('status') == 'respondida' ? 'selected' : '' }}>Respondida</option>
                        <option value="arquivada" {{ request('status') == 'arquivada' ? 'selected' : '' }}>Arquivada</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="prioridade" class="form-label">Prioridade</label>
                    <select class="form-select" id="prioridade" name="prioridade">
                        <option value="">Todas as prioridades</option>
                        <option value="baixa" {{ request('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ request('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta" {{ request('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="urgente" {{ request('prioridade') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                           value="{{ request('data_inicio') }}">
                </div>
                
                <div class="filter-group">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                           value="{{ request('data_fim') }}">
                </div>
                
                <div class="filter-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <a href="{{ route('admin.ouvidoria-manifestacoes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Limpar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela de Manifestações -->
    <div class="manifestacoes-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Protocolo</th>
                        <th>Tipo</th>
                        <th>Manifestante</th>
                        <th>Assunto</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Prazo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($manifestacoes ?? [] as $manifestacao)
                    <tr>
                        <td>
                            <strong>#{{ $manifestacao->protocolo ?? 'OUV' . str_pad($manifestacao->id ?? 1, 6, '0', STR_PAD_LEFT) }}</strong>
                        </td>
                        <td>
                            <span class="tipo-badge tipo-{{ $manifestacao->tipo ?? 'reclamacao' }}">
                                {{ ucfirst($manifestacao->tipo ?? 'Reclamação') }}
                            </span>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $manifestacao->nome_manifestante ?? 'Não informado' }}</strong><br>
                                <small class="text-muted">{{ $manifestacao->email_manifestante ?? 'Não informado' }}</small>
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 200px;">
                                <strong>{{ Str::limit($manifestacao->assunto ?? 'Problema com atendimento na recepção', 30) }}</strong><br>
                                <small class="text-muted">{{ Str::limit($manifestacao->descricao ?? 'Descrição da manifestação...', 50) }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="priority-badge priority-{{ $manifestacao->prioridade ?? 'media' }}"></span>
                            {{ ucfirst($manifestacao->prioridade ?? 'Média') }}
                        </td>
                        <td>
                            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($manifestacao->status ?? 'pendente')) }}">
                                {{ $manifestacao->status ?? 'Pendente' }}
                            </span>
                        </td>
                        <td>
                            <div>
                                {{ ($manifestacao->created_at ?? now())->format('d/m/Y') }}<br>
                                <small class="text-muted">{{ ($manifestacao->created_at ?? now())->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            @php
                                $prazo = ($manifestacao->created_at ?? now())->addDays(20);
                                $diasRestantes = now()->diffInDays($prazo, false);
                            @endphp
                            <div>
                                {{ $prazo->format('d/m/Y') }}<br>
                                <small class="text-{{ $diasRestantes < 0 ? 'danger' : ($diasRestantes <= 5 ? 'warning' : 'muted') }}">
                                    @if($diasRestantes < 0)
                                        {{ abs($diasRestantes) }} dias em atraso
                                    @elseif($diasRestantes == 0)
                                        Vence hoje
                                    @else
                                        {{ $diasRestantes }} dias restantes
                                    @endif
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.ouvidoria-manifestacoes.show', $manifestacao->id ?? 1) }}" 
                                   class="btn-action btn-view" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(($manifestacao->status ?? 'pendente') != 'arquivada')
                                <a href="{{ route('admin.ouvidoria-manifestacoes.edit', $manifestacao->id ?? 1) }}" 
                                   class="btn-action btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <button type="button" class="btn-action btn-respond" 
                                        data-action="open-response-modal" data-manifestacao-id="{{ $manifestacao->id ?? 1 }}" title="Responder">
                                    <i class="fas fa-reply"></i>
                                </button>
                                @endif
                                
                                <button type="button" class="btn-action btn-archive" 
                                        data-action="archive-manifestacao" data-manifestacao-id="{{ $manifestacao->id ?? 1 }}" title="Arquivar">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>
                            <span class="text-muted">Nenhuma manifestação encontrada</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($manifestacoes) && $manifestacoes->hasPages())
        <div class="pagination-wrapper">
            {{ $manifestacoes->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de Resposta Rápida -->
<div class="modal fade" id="responseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Responder Manifestação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="responseForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="response_status" class="form-label">Novo Status</label>
                        <select class="form-select" id="response_status" name="status" required>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="respondida">Respondida</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="response_text" class="form-label">Resposta</label>
                        <textarea class="form-control" id="response_text" name="resposta" rows="5" 
                                  placeholder="Digite a resposta para o manifestante..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="send_email" name="send_email" checked>
                            <label class="form-check-label" for="send_email">
                                Enviar resposta por email para o manifestante
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Resposta</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/ouvidoria-manifestacoes.js') }}"></script>
@endpush
@endsection