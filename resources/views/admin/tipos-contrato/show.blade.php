@extends('layouts.admin')

@section('title', 'Visualizar Tipo de Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $tipoContrato->nome }}</h3>
                    <div>
                        <a href="{{ route('admin.tipos-contrato.edit', $tipoContrato) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('admin.tipos-contrato.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Informações principais -->
                            <div class="form-group">
                                <label><strong>Nome:</strong></label>
                                <p class="form-control-plaintext">{{ $tipoContrato->nome }}</p>
                            </div>

                            @if($tipoContrato->descricao)
                            <div class="form-group">
                                <label><strong>Descrição:</strong></label>
                                <p class="form-control-plaintext">{{ $tipoContrato->descricao }}</p>
                            </div>
                            @endif

                            <!-- Contratos relacionados -->
                            @if($tipoContrato->contratos_count > 0)
                            <div class="form-group">
                                <label><strong>Contratos deste tipo:</strong></label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-box bg-info">
                                                    <span class="info-box-icon"><i class="fas fa-file-contract"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Total de Contratos</span>
                                                        <span class="info-box-number">{{ $tipoContrato->contratos_count }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-box bg-success">
                                                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Contratos Ativos</span>
                                                        <span class="info-box-number">{{ $tipoContrato->contratos()->ativos()->count() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('admin.contratos.index', ['tipo_contrato_id' => $tipoContrato->id]) }}" 
                                               class="btn btn-primary">
                                                <i class="fas fa-list"></i> Ver Contratos
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Ainda não há contratos cadastrados para este tipo.
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Status e informações -->
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Informações
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><strong>Status:</strong></label>
                                        <p>
                                            <span class="badge badge-{{ $tipoContrato->ativo ? 'success' : 'danger' }} badge-lg">
                                                <i class="fas fa-{{ $tipoContrato->ativo ? 'check' : 'ban' }}"></i>
                                                {{ $tipoContrato->ativo ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>ID:</strong></label>
                                        <p class="form-control-plaintext">#{{ $tipoContrato->id }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Criado em:</strong></label>
                                        <p class="form-control-plaintext">
                                            {{ $tipoContrato->created_at->format('d/m/Y H:i') }}
                                            <br><small class="text-muted">{{ $tipoContrato->created_at->diffForHumans() }}</small>
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Atualizado em:</strong></label>
                                        <p class="form-control-plaintext">
                                            {{ $tipoContrato->updated_at->format('d/m/Y H:i') }}
                                            <br><small class="text-muted">{{ $tipoContrato->updated_at->diffForHumans() }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cogs"></i> Ações
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="button" 
                                                class="btn btn-{{ $tipoContrato->ativo ? 'warning' : 'success' }} btn-block"
                                                onclick="toggleStatus({{ $tipoContrato->id }})">
                                            <i class="fas fa-{{ $tipoContrato->ativo ? 'ban' : 'check' }}"></i>
                                            {{ $tipoContrato->ativo ? 'Desativar' : 'Ativar' }}
                                        </button>
                                        
                                        @if($tipoContrato->contratos_count == 0)
                                        <button type="button" 
                                                class="btn btn-danger btn-block"
                                                onclick="confirmDelete({{ $tipoContrato->id }})">
                                            <i class="fas fa-trash"></i> Excluir
                                        </button>
                                        @else
                                        <button type="button" 
                                                class="btn btn-danger btn-block" 
                                                disabled
                                                title="Não é possível excluir tipos com contratos associados">
                                            <i class="fas fa-trash"></i> Excluir
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o tipo de contrato <strong>"{{ $tipoContrato->nome }}"</strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id) {
    fetch(`/admin/tipos-contrato/${id}/toggle-status`, {
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
    document.getElementById('deleteForm').action = `/admin/tipos-contrato/${id}`;
    $('#deleteModal').modal('show');
}
</script>
@endpush

@push('styles')
<style>
.badge-lg {
    font-size: 0.9em;
    padding: 0.5em 0.75em;
}

.info-box {
    border-radius: 0.375rem;
}
</style>
@endpush