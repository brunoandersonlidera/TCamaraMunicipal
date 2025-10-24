@extends('layouts.admin')

@section('title', 'Visualizar Comitê de Iniciativa Popular')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $comite->nome }}</h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.comites-iniciativa-popular.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <a href="{{ route('admin.comites-iniciativa-popular.edit', $comite) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-{{ $comite->status == 'ativo' ? 'secondary' : 'success' }}" 
                                data-action="toggle-status" data-id="{{ $comite->id }}">
                            <i class="fas fa-{{ $comite->status == 'ativo' ? 'pause' : 'play' }}"></i> 
                            {{ $comite->status == 'ativo' ? 'Desativar' : 'Ativar' }}
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Informações do Comitê -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informações do Comitê</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nome:</strong></td>
                                    <td>{{ $comite->nome }}</td>
                                </tr>
                                <tr>
                                    <td><strong>CPF:</strong></td>
                                    <td>{{ $comite->cpf }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>
                                        <a href="mailto:{{ $comite->email }}">{{ $comite->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Telefone:</strong></td>
                                    <td>
                                        <a href="tel:{{ $comite->telefone }}">{{ $comite->telefone }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Endereço:</strong></td>
                                    <td>{{ $comite->endereco ?: 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $comite->getStatusBadgeClass() }}">
                                            {{ $comite->getStatusFormatado() }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Cadastrado em:</strong></td>
                                    <td>{{ $comite->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Última atualização:</strong></td>
                                    <td>{{ $comite->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informações das Assinaturas -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Coleta de Assinaturas</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Assinaturas Coletadas:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $comite->atingiuMinimoAssinaturas() ? 'success' : 'warning' }} fs-6">
                                            {{ number_format($comite->numero_assinaturas, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Mínimo Necessário:</strong></td>
                                    <td>{{ number_format($comite->minimo_assinaturas, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Percentual Atingido:</strong></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $comite->atingiuMinimoAssinaturas() ? 'success' : 'warning' }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min(100, $comite->getPercentualAssinaturas()) }}%">
                                                {{ number_format($comite->getPercentualAssinaturas(), 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Data Início Coleta:</strong></td>
                                    <td>{{ $comite->data_inicio_coleta ? $comite->data_inicio_coleta->format('d/m/Y') : 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Data Fim Coleta:</strong></td>
                                    <td>{{ $comite->data_fim_coleta ? $comite->data_fim_coleta->format('d/m/Y') : 'Não informado' }}</td>
                                </tr>
                                @if($comite->data_inicio_coleta && $comite->data_fim_coleta)
                                <tr>
                                    <td><strong>Período de Coleta:</strong></td>
                                    <td>
                                        @php
                                            $dias = $comite->data_inicio_coleta->diffInDays($comite->data_fim_coleta);
                                        @endphp
                                        {{ $dias }} dias
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Documentos -->
                    @if($comite->documentos && is_array($comite->documentos) && count($comite->documentos) > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Documentos</h5>
                                
                                <div class="row">
                                    @foreach($comite->documentos as $tipo => $arquivo)
                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                                                    <h6>{{ ucfirst(str_replace('_', ' ', $tipo)) }}</h6>
                                                    @if($arquivo)
                                                        <a href="{{ route('admin.comites-iniciativa-popular.download', [$comite, $tipo]) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Não enviado</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Observações -->
                    @if($comite->observacoes)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Observações</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {!! nl2br(e($comite->observacoes)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Estatísticas -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Estatísticas</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <h4>{{ number_format($comite->numero_assinaturas, 0, ',', '.') }}</h4>
                                            <p class="mb-0">Assinaturas Coletadas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-target fa-2x mb-2"></i>
                                            <h4>{{ number_format($comite->minimo_assinaturas, 0, ',', '.') }}</h4>
                                            <p class="mb-0">Meta de Assinaturas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-{{ $comite->atingiuMinimoAssinaturas() ? 'success' : 'warning' }} text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-percentage fa-2x mb-2"></i>
                                            <h4>{{ number_format($comite->getPercentualAssinaturas(), 1) }}%</h4>
                                            <p class="mb-0">Percentual Atingido</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-{{ $comite->isValidado() ? 'success' : 'secondary' }} text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-{{ $comite->isValidado() ? 'check-circle' : 'clock' }} fa-2x mb-2"></i>
                                            <h4>{{ $comite->isValidado() ? 'Sim' : 'Não' }}</h4>
                                            <p class="mb-0">Validado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs"></i> Ações Administrativas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group" role="group">
                                    @if($comite->isAguardandoValidacao())
                                        <button type="button" class="btn btn-success" 
                                                onclick="aprovarComite({{ $comite->id }})" title="Aprovar comitê">
                                            <i class="fas fa-check"></i> Aprovar
                                        </button>
                                        <button type="button" class="btn btn-warning" 
                                                onclick="solicitarAlteracoes({{ $comite->id }})" title="Solicitar alterações">
                                            <i class="fas fa-edit"></i> Solicitar Alterações
                                        </button>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="rejeitarComite({{ $comite->id }})" title="Rejeitar comitê">
                                            <i class="fas fa-times"></i> Rejeitar
                                        </button>
                                    @elseif($comite->status === 'ativo')
                                        <button type="button" class="btn btn-warning" 
                                                onclick="solicitarAlteracoes({{ $comite->id }})" title="Solicitar alterações">
                                            <i class="fas fa-edit"></i> Solicitar Alterações
                                        </button>
                                        <button type="button" class="btn btn-success" 
                                                onclick="validarComite({{ $comite->id }})" title="Validar comitê">
                                            <i class="fas fa-check-circle"></i> Validar
                                        </button>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="rejeitarComite({{ $comite->id }})" title="Rejeitar comitê">
                                            <i class="fas fa-times"></i> Rejeitar
                                        </button>
                                    @elseif($comite->isAguardandoAlteracoes())
                                        <button type="button" class="btn btn-success" 
                                                onclick="aprovarComite({{ $comite->id }})" title="Aprovar comitê">
                                            <i class="fas fa-check"></i> Aprovar
                                        </button>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="rejeitarComite({{ $comite->id }})" title="Rejeitar comitê">
                                            <i class="fas fa-times"></i> Rejeitar
                                        </button>
                                    @endif
                                    
                                    @if(!in_array($comite->status, ['arquivado', 'expirado']))
                                        <button type="button" class="btn btn-secondary" 
                                                onclick="arquivarComite({{ $comite->id }})" title="Arquivar comitê">
                                            <i class="fas fa-archive"></i> Arquivar
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('admin.comites-iniciativa-popular.edit', $comite) }}" 
                                       class="btn btn-primary" title="Editar dados">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    
                                    <a href="{{ route('admin.comites-iniciativa-popular.index') }}" 
                                       class="btn btn-outline-secondary" title="Voltar à listagem">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Aprovar -->
<div class="modal fade" id="aprovarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aprovar Comitê</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja aprovar este comitê?</p>
                <div class="mb-3">
                    <label for="observacoes_aprovacao" class="form-label">Observações (opcional)</label>
                    <textarea class="form-control" id="observacoes_aprovacao" rows="3" 
                              placeholder="Adicione observações sobre a aprovação..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="confirmarAprovacao()">
                    <i class="fas fa-check"></i> Aprovar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Solicitar Alterações -->
<div class="modal fade" id="solicitarAlteracoesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Solicitar Alterações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Informe o motivo para solicitar alterações no comitê:</p>
                <div class="mb-3">
                    <label for="motivo_alteracoes" class="form-label">Motivo <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="motivo_alteracoes" rows="4" required
                              placeholder="Descreva quais alterações são necessárias..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="confirmarSolicitacaoAlteracoes()">
                    <i class="fas fa-edit"></i> Solicitar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Rejeitar -->
<div class="modal fade" id="rejeitarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejeitar Comitê</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><strong>Atenção:</strong> Esta ação rejeitará definitivamente o comitê.</p>
                <div class="mb-3">
                    <label for="motivo_rejeicao" class="form-label">Motivo da Rejeição <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="motivo_rejeicao" rows="4" required
                              placeholder="Descreva o motivo da rejeição..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarRejeicao()">
                    <i class="fas fa-times"></i> Rejeitar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Validar -->
<div class="modal fade" id="validarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validar Comitê</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja validar este comitê?</p>
                <div class="mb-3">
                    <label for="observacoes_validacao" class="form-label">Observações (opcional)</label>
                    <textarea class="form-control" id="observacoes_validacao" rows="3" 
                              placeholder="Adicione observações sobre a validação..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="confirmarValidacao()">
                    <i class="fas fa-check-circle"></i> Validar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Arquivar -->
<div class="modal fade" id="arquivarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Arquivar Comitê</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja arquivar este comitê?</p>
                <div class="mb-3">
                    <label for="motivo_arquivamento" class="form-label">Motivo (opcional)</label>
                    <textarea class="form-control" id="motivo_arquivamento" rows="3" 
                              placeholder="Descreva o motivo do arquivamento..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-secondary" onclick="confirmarArquivamento()">
                    <i class="fas fa-archive"></i> Arquivar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let comiteIdAtual = null;

function aprovarComite(id) {
    comiteIdAtual = id;
    new bootstrap.Modal(document.getElementById('aprovarModal')).show();
}

function solicitarAlteracoes(id) {
    comiteIdAtual = id;
    new bootstrap.Modal(document.getElementById('solicitarAlteracoesModal')).show();
}

function rejeitarComite(id) {
    comiteIdAtual = id;
    new bootstrap.Modal(document.getElementById('rejeitarModal')).show();
}

function validarComite(id) {
    comiteIdAtual = id;
    new bootstrap.Modal(document.getElementById('validarModal')).show();
}

function arquivarComite(id) {
    comiteIdAtual = id;
    new bootstrap.Modal(document.getElementById('arquivarModal')).show();
}

function confirmarAprovacao() {
    const observacoes = document.getElementById('observacoes_aprovacao').value;
    
    fetch(`/admin/comites-iniciativa-popular/${comiteIdAtual}/aprovar`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            observacoes: observacoes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao aprovar comitê');
    });
}

function confirmarSolicitacaoAlteracoes() {
    const motivo = document.getElementById('motivo_alteracoes').value.trim();
    
    if (!motivo) {
        alert('Por favor, informe o motivo para solicitar alterações.');
        return;
    }
    
    fetch(`/admin/comites-iniciativa-popular/${comiteIdAtual}/solicitar-alteracoes`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            motivo: motivo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao solicitar alterações');
    });
}

function confirmarRejeicao() {
    const motivo = document.getElementById('motivo_rejeicao').value.trim();
    
    if (!motivo) {
        alert('Por favor, informe o motivo da rejeição.');
        return;
    }
    
    fetch(`/admin/comites-iniciativa-popular/${comiteIdAtual}/rejeitar`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            motivo: motivo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao rejeitar comitê');
    });
}

function confirmarValidacao() {
    const observacoes = document.getElementById('observacoes_validacao').value;
    
    fetch(`/admin/comites-iniciativa-popular/${comiteIdAtual}/validar`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            observacoes: observacoes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao validar comitê');
    });
}

function confirmarArquivamento() {
    const motivo = document.getElementById('motivo_arquivamento').value || 'Arquivado pela administração';
    
    fetch(`/admin/comites-iniciativa-popular/${comiteIdAtual}/arquivar`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            motivo: motivo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao arquivar comitê');
    });
}
</script>
@endpush