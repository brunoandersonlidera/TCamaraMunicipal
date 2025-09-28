@extends('layouts.admin')

@section('title', 'Visualizar Lei - Administração')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-eye"></i>
                Visualizar Lei
            </h1>
            <p class="text-muted mb-0">
                Visualização detalhada da {{ $lei->numero_formatado }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.leis.edit', $lei->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Editar
            </a>
            <a href="{{ route('admin.leis.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <!-- Informações Básicas -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i>
                        Informações Básicas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Número:</label>
                            <p class="mb-0">{{ $lei->numero }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Exercício:</label>
                            <p class="mb-0">{{ $lei->exercicio }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Data:</label>
                            <p class="mb-0">{{ $lei->data ? $lei->data->format('d/m/Y') : 'Não informada' }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Status:</label>
                            <p class="mb-0">
                                @if($lei->status === 'ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipo:</label>
                            <p class="mb-0">{{ $lei->tipo }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Autoria:</label>
                            <p class="mb-0">{{ $lei->autoria ?: 'Não informada' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Título e Ementa -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-heading"></i>
                        Título e Ementa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título:</label>
                        <p class="mb-0">{{ $lei->titulo }}</p>
                    </div>
                    
                    @if($lei->ementa)
                    <div class="mb-0">
                        <label class="form-label fw-bold">Ementa:</label>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($lei->ementa)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Conteúdo -->
            @if($lei->descricao)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-align-left"></i>
                        Conteúdo da Lei
                    </h5>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($lei->descricao)) !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Observações -->
            @if($lei->observacoes)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sticky-note"></i>
                        Observações Internas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Observações internas:</strong> Estas informações não aparecem no site público.
                    </div>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($lei->observacoes)) !!}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informações do Sistema -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog"></i>
                        Informações do Sistema
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug:</label>
                        <p class="mb-0 font-monospace text-muted">{{ $lei->slug }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Criado em:</label>
                        <p class="mb-0">{{ $lei->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label fw-bold">Última atualização:</label>
                        <p class="mb-0">{{ $lei->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Arquivo PDF -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-pdf"></i>
                        Arquivo PDF
                    </h5>
                </div>
                <div class="card-body">
                    @if($lei->temArquivoPdf())
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                            <div>
                                <p class="mb-0 fw-bold">PDF disponível</p>
                                <p class="mb-0 text-muted small">{{ basename($lei->arquivo_pdf) }}</p>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('leis.download', $lei->id) }}" 
                               class="btn btn-outline-danger"
                               target="_blank">
                                <i class="fas fa-download me-2"></i>
                                Download PDF
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-file text-muted fa-2x mb-2"></i>
                            <p class="text-muted mb-0">Nenhum arquivo PDF anexado</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ações -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tools"></i>
                        Ações
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.leis.edit', $lei->id) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>
                            Editar Lei
                        </a>
                        
                        <a href="{{ route('leis.show', $lei->slug) }}" 
                           class="btn btn-outline-info"
                           target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Ver no Site Público
                        </a>
                        
                        <button type="button" 
                                class="btn btn-outline-danger"
                                onclick="confirmarExclusao({{ $lei->id }}, '{{ $lei->numero_formatado }}')">
                            <i class="fas fa-trash me-2"></i>
                            Excluir Lei
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="modalExclusao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a lei <strong id="leiParaExcluir"></strong>?</p>
                <p class="text-danger"><strong>Esta ação não pode ser desfeita!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formExclusao" method="POST" style="display: inline;">
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
function confirmarExclusao(id, numeroFormatado) {
    document.getElementById('leiParaExcluir').textContent = numeroFormatado;
    document.getElementById('formExclusao').action = `/admin/leis/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('modalExclusao'));
    modal.show();
}
</script>
@endpush