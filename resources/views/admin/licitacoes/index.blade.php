@extends('layouts.admin')

@section('title', 'Licitações')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Licitações</h3>
                    <a href="{{ route('admin.licitacoes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nova Licitação
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Número</th>
                                    <th>Modalidade</th>
                                    <th>Objeto</th>
                                    <th>Valor Estimado</th>
                                    <th>Data Abertura</th>
                                    <th>Status</th>
                                    <th>Documentos</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($licitacoes as $licitacao)
                                    <tr>
                                        <td>{{ $licitacao->id }}</td>
                                        <td>{{ $licitacao->numero }}</td>
                                        <td>{{ $licitacao->modalidade->nome ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($licitacao->objeto, 50) }}</td>
                                        <td>R$ {{ number_format($licitacao->valor_estimado, 2, ',', '.') }}</td>
                                        <td>{{ $licitacao->data_abertura->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $licitacao->status === 'aberta' ? 'success' : ($licitacao->status === 'em_andamento' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $licitacao->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $licitacao->documentos->count() }} doc(s)
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.licitacoes.show', $licitacao) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.licitacoes.edit', $licitacao) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.licitacoes.destroy', $licitacao) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Tem certeza que deseja excluir esta licitação?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Nenhuma licitação encontrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($licitacoes->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $licitacoes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection