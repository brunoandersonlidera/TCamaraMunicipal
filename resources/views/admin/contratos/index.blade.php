@extends('layouts.admin')

@section('title', 'Contratos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Contratos</h3>
                    <a href="{{ route('admin.contratos.create') }}" class="btn btn-primary-modern">
                        <i class="fas fa-plus"></i> Novo Contrato
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Buscar por número, objeto..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="tipo_contrato_id" class="form-control">
                                    <option value="">Todos os tipos</option>
                                    @foreach($tiposContrato as $tipo)
                                        <option value="{{ $tipo->id }}" {{ request('tipo_contrato_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">Todos os status</option>
                                    <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="vencido" {{ request('status') === 'vencido' ? 'selected' : '' }}>Vencido</option>
                                    <option value="publico" {{ request('status') === 'publico' ? 'selected' : '' }}>Público</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="ano" class="form-control">
                                    <option value="">Todos os anos</option>
                                    @foreach($anos as $ano)
                                        <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>
                                            {{ $ano }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-secondary-modern">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                <a href="{{ route('admin.contratos.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Estatísticas -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card stats-total">
                                <div class="stats-card-body">
                                    <div class="stats-icon">
                                        <i class="fas fa-file-contract"></i>
                                    </div>
                                    <div class="stats-content">
                                        <div class="stats-label">Total</div>
                                        <div class="stats-number">{{ number_format($estatisticas['total'], 0, ',', '.') }}</div>
                                        <div class="stats-trend neutral">
                                            <i class="fas fa-file-alt"></i>
                                            Contratos cadastrados
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card stats-ativos">
                                <div class="stats-card-body">
                                    <div class="stats-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stats-content">
                                        <div class="stats-label">Ativos</div>
                                        <div class="stats-number">{{ number_format($estatisticas['ativos'], 0, ',', '.') }}</div>
                                        <div class="stats-trend positive">
                                            <i class="fas fa-arrow-up"></i>
                                            {{ $estatisticas['total'] > 0 ? number_format(($estatisticas['ativos'] / $estatisticas['total']) * 100, 1) : 0 }}% do total
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card stats-vencidos">
                                <div class="stats-card-body">
                                    <div class="stats-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="stats-content">
                                        <div class="stats-label">Vencidos</div>
                                        <div class="stats-number">{{ number_format($estatisticas['vencidos'], 0, ',', '.') }}</div>
                                        <div class="stats-trend {{ $estatisticas['vencidos'] > 0 ? 'negative' : 'positive' }}">
                                            <i class="fas fa-{{ $estatisticas['vencidos'] > 0 ? 'exclamation-circle' : 'check-circle' }}"></i>
                                            {{ $estatisticas['vencidos'] > 0 ? 'Requer atenção' : 'Tudo em dia' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card stats-valor">
                                <div class="stats-card-body">
                                    <div class="stats-icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="stats-content">
                                        <div class="stats-label">Valor Total</div>
                                        <div class="stats-number currency">R$ {{ number_format($estatisticas['valor_total'], 2, ',', '.') }}</div>
                                        <div class="stats-trend neutral">
                                            <i class="fas fa-calculator"></i>
                                            Valor consolidado
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Tipo</th>
                                    <th>Objeto</th>
                                    <th>Contratado</th>
                                    <th>Valor</th>
                                    <th>Vigência</th>
                                    <th>Status</th>
                                    <th width="200">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contratos as $contrato)
                                <tr>
                                    <td>
                                        <strong>{{ $contrato->numero }}</strong>
                                        @if($contrato->publico)
                                            <span class="badge badge-info badge-sm ml-1" title="Público">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge-contrato badge-contrato-tipo">
                                            {{ $contrato->tipoContrato->nome }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ Str::limit($contrato->objeto, 40) }}
                                    </td>
                                    <td>{{ Str::limit($contrato->contratado, 30) }}</td>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            R$ {{ number_format($contrato->valor_inicial, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="vigencia-info">
                                            <div class="mb-1">
                                                <i class="fas fa-calendar-alt text-success"></i>
                                                <strong>Início:</strong> {{ $contrato->data_inicio ? $contrato->data_inicio->format('d/m/Y') : 'N/A' }}
                                            </div>
                                            <div class="mb-1">
                                                <i class="fas fa-calendar-times text-danger"></i>
                                                <strong>Fim:</strong> {{ $contrato->data_fim ? $contrato->data_fim->format('d/m/Y') : 'N/A' }}
                                            </div>
                                            @if($contrato->isVencido())
                                                <div class="mt-2">
                                                    <small class="text-danger">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        Vencido há {{ abs($contrato->diasParaVencimento()) }} dias
                                                    </small>
                                                </div>
                                            @else
                                                @php
                                                    $diasRestantes = $contrato->diasParaVencimento();
                                                @endphp
                                                <div class="mt-2">
                                                    <small class="text-{{ $diasRestantes <= 30 ? 'warning' : 'info' }}">
                                                        <i class="fas fa-clock"></i>
                                                        {{ $diasRestantes }} dias restantes
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($contrato->isVencido())
                                            <span class="badge-contrato badge-status-vencido">
                                                <i class="fas fa-exclamation-triangle"></i> Vencido
                                            </span>
                                        @elseif($contrato->status === 'ativo')
                                            <span class="badge-contrato badge-status-ativo">
                                                <i class="fas fa-check-circle"></i> Ativo
                                            </span>
                                        @elseif($contrato->status === 'suspenso')
                                            <span class="badge-contrato badge-status-suspenso">
                                                <i class="fas fa-pause-circle"></i> Suspenso
                                            </span>
                                        @elseif($contrato->status === 'encerrado')
                                            <span class="badge-contrato badge-status-encerrado">
                                                <i class="fas fa-stop-circle"></i> Encerrado
                                            </span>
                                        @elseif($contrato->status === 'rescindido')
                                            <span class="badge-contrato badge-status-rescindido">
                                                <i class="fas fa-times-circle"></i> Rescindido
                                            </span>
                                        @else
                                            <span class="badge-contrato badge-aditivo-default">
                                                <i class="fas fa-question-circle"></i> {{ ucfirst($contrato->status ?? 'Indefinido') }}
                                            </span>
                                        @endif
                                        <br>
                                        <small class="mt-1">
                                            <span class="badge-contrato {{ $contrato->publico ? 'badge-publico' : 'badge-privado' }}">
                                                <i class="fas fa-{{ $contrato->publico ? 'eye' : 'eye-slash' }}"></i>
                                                {{ $contrato->publico ? 'Público' : 'Privado' }}
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.contratos.show', $contrato) }}" 
                                               class="btn btn-sm btn-view" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.contratos.edit', $contrato) }}" 
                                               class="btn btn-sm btn-edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($contrato->arquivo_contrato)
                                            <a href="{{ route('admin.contratos.download', $contrato) }}" 
                                               class="btn btn-sm btn-success-modern" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @endif
                                            <button type="button" 
                                                    class="btn btn-sm btn-toggle"
                                                    data-action="toggle-status" data-id="{{ $contrato->id }}"
                                                    title="{{ $contrato->publico ? 'Tornar Privado' : 'Tornar Público' }}">
                                                <i class="fas fa-{{ $contrato->publico ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-delete" 
                                                    data-action="confirm-delete" data-id="{{ $contrato->id }}"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum contrato encontrado.</p>
                                            <a href="{{ route('admin.contratos.create') }}" class="btn btn-primary-modern">
                                                <i class="fas fa-plus"></i> Criar Primeiro Contrato
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    @if($contratos->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $contratos->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este contrato?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita e excluirá também todos os aditivos e fiscalizações relacionados.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-modern">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id) {
    fetch(`/admin/contratos/${id}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao alterar status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao alterar status');
    });
}

function confirmDelete(id) {
    document.getElementById('deleteForm').action = `/admin/contratos/${id}`;
    $('#deleteModal').modal('show');
}
</script>
@endpush

@push('styles')
<style>
.info-box {
    border-radius: 0.375rem;
}

.badge-sm {
    font-size: 0.7em;
}
</style>
@endpush