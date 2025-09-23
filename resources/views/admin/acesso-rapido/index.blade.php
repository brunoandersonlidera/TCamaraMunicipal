@extends('layouts.admin')

@section('title', 'Acesso Rápido')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-rocket me-2"></i>
                        Gerenciar Acesso Rápido
                    </h3>
                    <a href="{{ route('admin.acesso-rapido.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Novo Acesso
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($acessos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50">Ordem</th>
                                        <th>Nome</th>
                                        <th>URL</th>
                                        <th width="100">Ícone</th>
                                        <th width="80">Cores</th>
                                        <th width="80">Status</th>
                                        <th width="150">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-table">
                                    @foreach($acessos as $acesso)
                                        <tr data-id="{{ $acesso->id }}">
                                            <td>
                                                <span class="badge bg-secondary">{{ $acesso->ordem }}</span>
                                                <i class="fas fa-grip-vertical text-muted ms-2 drag-handle"></i>
                                            </td>
                                            <td>
                                                <strong>{{ $acesso->nome }}</strong>
                                                @if($acesso->descricao)
                                                    <br><small class="text-muted">{{ Str::limit($acesso->descricao, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <code>{{ Str::limit($acesso->url, 40) }}</code>
                                                @if($acesso->abrir_nova_aba)
                                                    <i class="fas fa-external-link-alt text-info ms-1" title="Abre em nova aba"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <i class="{{ $acesso->icone ?? 'fas fa-link' }} acesso-icon" 
                                                   data-color="{{ $acesso->cor_botao ?? '#007bff' }}"></i>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <div class="color-preview" 
                                                         data-bg-color="{{ $acesso->cor_botao ?? '#007bff' }}" 
                                                         title="Cor do botão"></div>
                                                    <div class="color-preview" 
                                                         data-bg-color="{{ $acesso->cor_fonte ?? '#ffffff' }}" 
                                                         title="Cor da fonte"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.acesso-rapido.toggle-status', $acesso) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $acesso->ativo ? 'btn-success' : 'btn-secondary' }}">
                                                        <i class="fas {{ $acesso->ativo ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                        {{ $acesso->ativo ? 'Ativo' : 'Inativo' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.acesso-rapido.edit', $acesso) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.acesso-rapido.destroy', $acesso) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este item?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
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
                        @if($acessos->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $acessos->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-rocket text-muted empty-state-icon"></i>
                            <h4 class="text-muted mt-3">Nenhum acesso rápido cadastrado</h4>
                            <p class="text-muted">Comece criando seu primeiro acesso rápido para a página inicial.</p>
                            <a href="{{ route('admin.acesso-rapido.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Criar Primeiro Acesso
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/acesso-rapido-admin.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="{{ asset('js/acesso-rapido-admin.js') }}"></script>
<meta name="update-order-url" content="{{ route('admin.acesso-rapido.update-order') }}">
@endpush