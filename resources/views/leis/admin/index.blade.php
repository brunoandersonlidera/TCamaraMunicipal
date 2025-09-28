@extends('layouts.admin')

@section('title', 'Gerenciar Leis - Administração')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-balance-scale"></i>
                Gerenciar Leis
            </h1>
            <p class="text-muted mb-0">Administre o acervo de leis municipais</p>
        </div>
        <div>
            <a href="{{ route('admin.leis.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Nova Lei
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.leis.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="busca" class="form-label">Buscar</label>
                    <input type="text" 
                           class="form-control" 
                           id="busca" 
                           name="busca" 
                           value="{{ request('busca') }}"
                           placeholder="Número, título, descrição...">
                </div>
                <div class="col-md-2">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Todos</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="exercicio" class="form-label">Exercício</label>
                    <select class="form-select" id="exercicio" name="exercicio">
                        <option value="">Todos</option>
                        @foreach($exercicios as $exercicio)
                            <option value="{{ $exercicio }}" {{ request('exercicio') == $exercicio ? 'selected' : '' }}>
                                {{ $exercicio }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="ordenacao" class="form-label">Ordenar por</label>
                    <select class="form-select" id="ordenacao" name="ordenacao">
                        <option value="padrao" {{ request('ordenacao') == 'padrao' ? 'selected' : '' }}>Mais recentes</option>
                        <option value="numero_asc" {{ request('ordenacao') == 'numero_asc' ? 'selected' : '' }}>Número ↑</option>
                        <option value="numero_desc" {{ request('ordenacao') == 'numero_desc' ? 'selected' : '' }}>Número ↓</option>
                        <option value="data_asc" {{ request('ordenacao') == 'data_asc' ? 'selected' : '' }}>Data ↑</option>
                        <option value="data_desc" {{ request('ordenacao') == 'data_desc' ? 'selected' : '' }}>Data ↓</option>
                        <option value="titulo_asc" {{ request('ordenacao') == 'titulo_asc' ? 'selected' : '' }}>Título A-Z</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.leis.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $leis->total() }}</strong> {{ $leis->total() == 1 ? 'lei encontrada' : 'leis encontradas' }}
                    @if(request()->hasAny(['busca', 'tipo', 'exercicio', 'status']))
                        <span class="text-muted">(filtros aplicados)</span>
                    @endif
                </div>
                <div class="text-muted">
                    Página {{ $leis->currentPage() }} de {{ $leis->lastPage() }}
                </div>
            </div>
        </div>
        
        @if($leis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Número</th>
                            <th width="120">Tipo</th>
                            <th>Título</th>
                            <th width="100">Data</th>
                            <th width="80">Exercício</th>
                            <th width="80">Status</th>
                            <th width="60">PDF</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leis as $lei)
                            <tr>
                                <td>
                                    <strong>{{ $lei->numero }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-tipo badge-{{ Str::slug($lei->tipo) }}">
                                        {{ $lei->tipo }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($lei->titulo, 60) }}</div>
                                    @if($lei->autoria)
                                        <small class="text-muted">{{ $lei->autoria }}</small>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $lei->data->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $lei->exercicio }}</span>
                                </td>
                                <td>
                                    @if($lei->ativo)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lei->temArquivoPdf())
                                        <i class="fas fa-file-pdf text-danger" title="PDF disponível"></i>
                                    @else
                                        <i class="fas fa-file text-muted" title="Sem PDF"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.leis.show', $lei->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.leis.edit', $lei->id) }}" 
                                           class="btn btn-outline-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger"
                                                title="Excluir"
                                                onclick="confirmarExclusao({{ $lei->id }}, '{{ $lei->numero_formatado }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            @if($leis->hasPages())
                <div class="card-footer">
                    {{ $leis->links() }}
                </div>
            @endif
        @else
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5>Nenhuma lei encontrada</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['busca', 'tipo', 'exercicio', 'status']))
                        Não encontramos leis que correspondam aos filtros aplicados.
                    @else
                        Ainda não há leis cadastradas no sistema.
                    @endif
                </p>
                @if(request()->hasAny(['busca', 'tipo', 'exercicio', 'status']))
                    <a href="{{ route('admin.leis.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-times"></i>
                        Limpar filtros
                    </a>
                @else
                    <a href="{{ route('admin.leis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Cadastrar primeira lei
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="modalExclusao" tabindex="-1" aria-labelledby="modalExclusaoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExclusaoLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a lei <strong id="leiNumero"></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Atenção:</strong> Esta ação não pode ser desfeita.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <form id="formExclusao" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Excluir Lei
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leis.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/leis.js') }}"></script>
<script>
function confirmarExclusao(id, numero) {
    document.getElementById('leiNumero').textContent = numero;
    document.getElementById('formExclusao').action = '{{ route("admin.leis.destroy", ":id") }}'.replace(':id', id);
    
    const modal = new bootstrap.Modal(document.getElementById('modalExclusao'));
    modal.show();
}
</script>
@endpush