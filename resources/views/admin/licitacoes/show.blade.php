@extends('layouts.admin')

@section('title', 'Licitação #' . $licitacao->numero)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Licitação #{{ $licitacao->numero }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.licitacoes.edit', $licitacao) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('admin.licitacoes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
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
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Número:</th>
                                    <td>{{ $licitacao->numero }}</td>
                                </tr>
                                <tr>
                                    <th>Modalidade:</th>
                                    <td>{{ $licitacao->modalidade->nome ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $licitacao->status === 'aberta' ? 'success' : ($licitacao->status === 'em_andamento' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $licitacao->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Valor Estimado:</th>
                                    <td>R$ {{ number_format($licitacao->valor_estimado, 2, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Data de Abertura:</th>
                                    <td>{{ $licitacao->data_abertura->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Local de Abertura:</th>
                                    <td>{{ $licitacao->local_abertura ?: 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Criado em:</th>
                                    <td>{{ $licitacao->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Atualizado em:</th>
                                    <td>{{ $licitacao->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Objeto da Licitação</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $licitacao->objeto }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($licitacao->observacoes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Observações</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $licitacao->observacoes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Documentos -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-file-alt"></i> Documentos da Licitação
                                    </h5>
                                    <span class="badge bg-info">{{ $licitacao->documentos->count() }} documento(s)</span>
                                </div>
                                <div class="card-body">
                                    @if($licitacao->documentos->count() > 0)
                                        <div class="row">
                                            @foreach($licitacao->documentos as $documento)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card border h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">
                                                                    <i class="fas fa-file text-primary"></i> 
                                                                    {{ Str::limit($documento->arquivo_original, 25) }}
                                                                </h6>
                                                                <small class="text-muted d-block">
                                                                    Enviado em {{ $documento->created_at->format('d/m/Y H:i') }}
                                                                </small>
                                                                <small class="text-muted">
                                                                    {{ number_format($documento->tamanho / 1024, 2) }} KB
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group w-100" role="group">
                                                            <a href="{{ route('admin.licitacoes.documento.download', $documento) }}" 
                                                               class="btn btn-sm btn-outline-primary" title="Download">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                            @if(in_array(strtolower(pathinfo($documento->arquivo_original, PATHINFO_EXTENSION)), ['pdf', 'txt']))
                                                            <a href="{{ route('licitacao.documento.visualizar', $documento) }}" 
                                                               class="btn btn-sm btn-outline-info" title="Visualizar" target="_blank">
                                                                <i class="fas fa-eye"></i> Ver
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum documento foi anexado a esta licitação.</p>
                                            <a href="{{ route('admin.licitacoes.edit', $licitacao) }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Adicionar Documentos
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.licitacoes.edit', $licitacao) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar Licitação
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <form action="{{ route('admin.licitacoes.destroy', $licitacao) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Tem certeza que deseja excluir esta licitação? Esta ação não pode ser desfeita.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Excluir Licitação
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection