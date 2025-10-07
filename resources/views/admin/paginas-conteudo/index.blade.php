@extends('layouts.admin')

@section('title', 'Páginas de Conteúdo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Páginas de Conteúdo</h1>
                <a href="{{ route('admin.paginas-conteudo.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nova Página
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($paginas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Ordem</th>
                                        <th>Atualizado em</th>
                                        <th width="200">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paginas as $pagina)
                                        <tr>
                                            <td>
                                                <strong>{{ $pagina->titulo }}</strong>
                                                @if($pagina->descricao)
                                                    <br><small class="text-muted">{{ Str::limit($pagina->descricao, 60) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <code>{{ $pagina->slug }}</code>
                                            </td>
                                            <td>
                                                @if($pagina->ativo)
                                                    <span class="badge bg-success">Ativo</span>
                                                @else
                                                    <span class="badge bg-secondary">Inativo</span>
                                                @endif
                                            </td>
                                            <td>{{ $pagina->ordem }}</td>
                                            <td>{{ $pagina->updated_at ? $pagina->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.paginas-conteudo.show', $pagina) }}" 
                                                       class="btn btn-sm btn-outline-info" title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.paginas-conteudo.edit', $pagina) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.paginas-conteudo.toggle-status', $pagina) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-{{ $pagina->ativo ? 'warning' : 'success' }}" 
                                                                title="{{ $pagina->ativo ? 'Desativar' : 'Ativar' }}">
                                                            <i class="fas fa-{{ $pagina->ativo ? 'eye-slash' : 'eye' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.paginas-conteudo.destroy', $pagina) }}" 
                                                          method="POST" class="d-inline"
                                                          data-confirm="Tem certeza que deseja excluir esta página?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($paginas->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $paginas->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma página encontrada</h5>
                            <p class="text-muted">Comece criando sua primeira página de conteúdo.</p>
                            <a href="{{ route('admin.paginas-conteudo.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Criar Primeira Página
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection