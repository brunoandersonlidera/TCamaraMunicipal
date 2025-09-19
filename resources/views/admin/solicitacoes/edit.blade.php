@extends('layouts.admin')

@section('page-title', 'Responder Solicitação e-SIC')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.solicitacoes.index') }}">Solicitações e-SIC</a></li>
        <li class="breadcrumb-item active">Responder</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Responder Solicitação e-SIC</h1>
            <p class="text-muted mb-0">Protocolo: <strong>{{ $solicitacao->protocolo }}</strong></p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.solicitacoes.show', $solicitacao) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>Visualizar
            </a>
            <a href="{{ route('admin.solicitacoes.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Dados da Solicitação -->
        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Dados da Solicitação</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Protocolo</label>
                        <div class="form-control-plaintext">{{ $solicitacao->protocolo }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Solicitante</label>
                        <div class="form-control-plaintext">{{ $solicitacao->nome }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">E-mail</label>
                        <div class="form-control-plaintext">{{ $solicitacao->email }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Telefone</label>
                        <div class="form-control-plaintext">{{ $solicitacao->telefone ?: 'Não informado' }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipo</label>
                        <div class="form-control-plaintext">
                            <span class="badge bg-light text-dark">{{ $tipos[$solicitacao->tipo] ?? $solicitacao->tipo }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Atual</label>
                        <div class="form-control-plaintext">
                            @php
                                $statusColors = [
                                    'pendente' => 'warning',
                                    'em_andamento' => 'info',
                                    'respondida' => 'success',
                                    'arquivada' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$solicitacao->status] ?? 'secondary' }}">
                                {{ $statusOptions[$solicitacao->status] ?? $solicitacao->status }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Data da Solicitação</label>
                        <div class="form-control-plaintext">{{ $solicitacao->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if($solicitacao->prazo_resposta)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Prazo de Resposta</label>
                        <div class="form-control-plaintext">
                            {{ \Carbon\Carbon::parse($solicitacao->prazo_resposta)->format('d/m/Y') }}
                            @if(\Carbon\Carbon::parse($solicitacao->prazo_resposta)->isPast() && $solicitacao->status !== 'respondida')
                                <span class="badge bg-danger ms-2">Vencido</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Assunto e Descrição -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-comment me-2"></i>Solicitação</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Assunto</label>
                        <div class="form-control-plaintext">{{ $solicitacao->assunto }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição</label>
                        <div class="form-control-plaintext" style="white-space: pre-wrap;">{{ $solicitacao->descricao }}</div>
                    </div>

                    @if($solicitacao->arquivo_solicitacao)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Arquivo Anexado</label>
                        <div class="form-control-plaintext">
                            <a href="{{ route('admin.solicitacoes.download', $solicitacao) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download me-2"></i>
                                {{ basename($solicitacao->arquivo_solicitacao) }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulário de Resposta -->
        <div class="col-lg-8">
            <form action="{{ route('admin.solicitacoes.update', $solicitacao) }}" method="POST" enctype="multipart/form-data" id="formResposta">
                @csrf
                @method('PUT')

                <!-- Status e Configurações -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Status e Configurações</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        @foreach($statusOptions as $value => $label)
                                            <option value="{{ $value }}" 
                                                    {{ old('status', $solicitacao->status) === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prazo_resposta" class="form-label">Prazo de Resposta</label>
                                    <input type="date" class="form-control @error('prazo_resposta') is-invalid @enderror" 
                                           id="prazo_resposta" name="prazo_resposta" 
                                           value="{{ old('prazo_resposta', $solicitacao->prazo_resposta ? \Carbon\Carbon::parse($solicitacao->prazo_resposta)->format('Y-m-d') : '') }}">
                                    @error('prazo_resposta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Deixe em branco para usar o prazo padrão (20 dias)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="arquivada" name="arquivada" value="1"
                                           {{ old('arquivada', $solicitacao->arquivada) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arquivada">
                                        Arquivar solicitação
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="notificar_solicitante" name="notificar_solicitante" value="1" checked>
                                    <label class="form-check-label" for="notificar_solicitante">
                                        Notificar solicitante por e-mail
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resposta -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-reply me-2"></i>Resposta</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="resposta" class="form-label">Texto da Resposta</label>
                            <textarea class="form-control @error('resposta') is-invalid @enderror" 
                                      id="resposta" name="resposta" rows="8" 
                                      placeholder="Digite aqui a resposta para a solicitação...">{{ old('resposta', $solicitacao->resposta) }}</textarea>
                            @error('resposta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Esta resposta será enviada por e-mail para o solicitante.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="arquivo_resposta" class="form-label">Arquivo de Resposta</label>
                            <input type="file" class="form-control @error('arquivo_resposta') is-invalid @enderror" 
                                   id="arquivo_resposta" name="arquivo_resposta" 
                                   accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                            @error('arquivo_resposta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Formatos aceitos: PDF, DOC, DOCX, TXT, JPG, PNG (máx. 10MB)
                            </div>

                            @if($solicitacao->arquivo_resposta)
                            <div class="mt-2">
                                <div class="alert alert-info">
                                    <i class="fas fa-file me-2"></i>
                                    <strong>Arquivo atual:</strong> {{ basename($solicitacao->arquivo_resposta) }}
                                    <a href="{{ route('admin.solicitacoes.download-resposta', $solicitacao) }}" 
                                       class="btn btn-outline-primary btn-sm ms-2">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Observações Internas -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações Internas</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="observacoes_internas" class="form-label">Observações</label>
                            <textarea class="form-control @error('observacoes_internas') is-invalid @enderror" 
                                      id="observacoes_internas" name="observacoes_internas" rows="4" 
                                      placeholder="Observações internas sobre a solicitação (não serão enviadas ao solicitante)...">{{ old('observacoes_internas', $solicitacao->observacoes_internas) }}</textarea>
                            @error('observacoes_internas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-lock me-1"></i>
                                Estas observações são apenas para uso interno e não serão enviadas ao solicitante.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-outline-secondary" onclick="limparFormulario()">
                                    <i class="fas fa-eraser me-2"></i>Limpar
                                </button>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('admin.solicitacoes.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Salvar Resposta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Ação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Atenção!</strong> Esta ação irá atualizar o status da solicitação.
                </div>
                <p id="confirmMessage">Tem certeza que deseja salvar as alterações?</p>
                <div id="emailNotification" style="display: none;">
                    <p class="text-muted">
                        <i class="fas fa-envelope me-2"></i>
                        Um e-mail de notificação será enviado para o solicitante.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">
                    <i class="fas fa-save me-2"></i>Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.admin-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}

.badge {
    font-size: 0.75em;
}

.alert {
    border: none;
    border-radius: 0.375rem;
}

.form-text {
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #6c757d;
}
</style>
@endpush

@push('scripts')
<script>
// Controle do formulário
document.getElementById('formResposta').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const status = document.getElementById('status').value;
    const notificar = document.getElementById('notificar_solicitante').checked;
    const resposta = document.getElementById('resposta').value.trim();
    
    let message = 'Tem certeza que deseja salvar as alterações?';
    
    if (status === 'respondida' && !resposta) {
        alert('Para marcar como "Respondida", é necessário preencher o campo de resposta.');
        return;
    }
    
    if (status === 'respondida') {
        message = 'A solicitação será marcada como respondida.';
    } else if (status === 'arquivada') {
        message = 'A solicitação será arquivada.';
    }
    
    document.getElementById('confirmMessage').textContent = message;
    
    if (notificar) {
        document.getElementById('emailNotification').style.display = 'block';
    } else {
        document.getElementById('emailNotification').style.display = 'none';
    }
    
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    confirmModal.show();
});

function submitForm() {
    document.getElementById('formResposta').submit();
}

// Limpar formulário
function limparFormulario() {
    if (confirm('Tem certeza que deseja limpar o formulário? Todas as alterações não salvas serão perdidas.')) {
        document.getElementById('resposta').value = '';
        document.getElementById('observacoes_internas').value = '';
        document.getElementById('arquivo_resposta').value = '';
        document.getElementById('status').value = '{{ $solicitacao->status }}';
        document.getElementById('arquivada').checked = {{ $solicitacao->arquivada ? 'true' : 'false' }};
        document.getElementById('notificar_solicitante').checked = true;
    }
}

// Controle de status
document.getElementById('status').addEventListener('change', function() {
    const status = this.value;
    const respostaField = document.getElementById('resposta');
    
    if (status === 'respondida') {
        respostaField.setAttribute('required', 'required');
        respostaField.closest('.mb-3').querySelector('.form-label').innerHTML = 'Texto da Resposta <span class="text-danger">*</span>';
    } else {
        respostaField.removeAttribute('required');
        respostaField.closest('.mb-3').querySelector('.form-label').innerHTML = 'Texto da Resposta';
    }
});

// Controle de arquivo
document.getElementById('arquivo_resposta').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
            alert('O arquivo é muito grande. O tamanho máximo permitido é 10MB.');
            this.value = '';
            return;
        }
        
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];
        
        if (!allowedTypes.includes(file.type)) {
            alert('Tipo de arquivo não permitido. Use apenas: PDF, DOC, DOCX, TXT, JPG, PNG.');
            this.value = '';
            return;
        }
    }
});

// Auto-save (opcional)
let autoSaveTimer;
function autoSave() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(function() {
        const formData = new FormData(document.getElementById('formResposta'));
        // Implementar auto-save se necessário
    }, 30000); // 30 segundos
}

document.getElementById('resposta').addEventListener('input', autoSave);
document.getElementById('observacoes_internas').addEventListener('input', autoSave);
</script>
@endpush