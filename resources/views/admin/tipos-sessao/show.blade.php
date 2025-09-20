@extends('layouts.admin')

@section('title', 'Tipo de Sessão: ' . $tipoSessao->nome)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <span class="badge mr-2 tipo-badge" data-cor="{{ $tipoSessao->cor }}">
                            <i class="{{ $tipoSessao->icone }}"></i>
                        </span>
                        {{ $tipoSessao->nome }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.tipos-sessao.edit', $tipoSessao) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('admin.tipos-sessao.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações Básicas</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nome:</strong></td>
                                    <td>{{ $tipoSessao->nome }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Slug:</strong></td>
                                    <td><code>{{ $tipoSessao->slug }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Cor:</strong></td>
                                    <td>
                                        <span class="color-preview mr-2" data-preview-cor="{{ $tipoSessao->cor }}"></span>
                                        {{ $tipoSessao->cor }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Ícone:</strong></td>
                                    <td>
                                        <i class="{{ $tipoSessao->icone }}"></i>
                                        <code class="ml-2">{{ $tipoSessao->icone }}</code>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Ordem:</strong></td>
                                    <td>{{ $tipoSessao->ordem }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($tipoSessao->ativo)
                                            <span class="badge badge-success">Ativo</span>
                                        @else
                                            <span class="badge badge-secondary">Inativo</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Criado em:</strong></td>
                                    <td>{{ $tipoSessao->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Atualizado em:</strong></td>
                                    <td>{{ $tipoSessao->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Preview</h5>
                            <div class="card mb-3" style="max-width: 300px;">
                                <div class="card-body text-center">
                                    <span class="badge badge-preview-large" data-cor="{{ $tipoSessao->cor }}">
                                        <i class="{{ $tipoSessao->icone }}"></i>
                                        {{ $tipoSessao->nome }}
                                    </span>
                                </div>
                            </div>

                            @if($tipoSessao->descricao)
                            <h5>Descrição</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $tipoSessao->descricao }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sessões vinculadas -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>
                                Sessões Vinculadas 
                                <span class="badge badge-info">{{ $tipoSessao->sessoes->count() }}</span>
                            </h5>
                            
                            @if($tipoSessao->sessoes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Hora</th>
                                                <th>Local</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tipoSessao->sessoes->take(10) as $sessao)
                                            <tr>
                                                <td>{{ $sessao->data_sessao ? $sessao->data_sessao->format('d/m/Y') : '-' }}</td>
                                                <td>{{ $sessao->hora_inicio ?? '-' }}</td>
                                                <td>{{ $sessao->local ?? '-' }}</td>
                                                <td>
                                                    @switch($sessao->status)
                                                        @case('agendada')
                                                            <span class="badge badge-primary">Agendada</span>
                                                            @break
                                                        @case('em_andamento')
                                                            <span class="badge badge-success">Em Andamento</span>
                                                            @break
                                                        @case('finalizada')
                                                            <span class="badge badge-secondary">Finalizada</span>
                                                            @break
                                                        @case('cancelada')
                                                            <span class="badge badge-danger">Cancelada</span>
                                                            @break
                                                        @default
                                                            <span class="badge badge-light">{{ ucfirst($sessao->status) }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.sessoes.show', $sessao) }}" 
                                                       class="btn btn-sm btn-info" title="Ver sessão">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($tipoSessao->sessoes->count() > 10)
                                    <p class="text-muted">
                                        Mostrando 10 de {{ $tipoSessao->sessoes->count() }} sessões. 
                                        <a href="{{ route('admin.sessoes.index', ['tipo' => $tipoSessao->nome]) }}">
                                            Ver todas as sessões deste tipo
                                        </a>
                                    </p>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nenhuma sessão vinculada a este tipo ainda.</p>
                                    <a href="{{ route('admin.sessoes.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Criar Sessão
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('admin.tipos-sessao.edit', $tipoSessao) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('admin.tipos-sessao.destroy', $tipoSessao) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Tem certeza que deseja excluir este tipo de sessão? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger"
                                {{ $tipoSessao->sessoes->count() > 0 ? 'disabled title=Não é possível excluir tipos com sessões vinculadas' : '' }}>
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </form>
                    <a href="{{ route('admin.tipos-sessao.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.color-preview {
    width: 20px;
    height: 20px;
    display: inline-block;
    border-radius: 3px;
    border: 1px solid #ddd;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.tipo-badge {
    color: white !important;
}

.badge-preview-large {
    color: white !important;
    font-size: 16px;
    padding: 8px 12px;
}
</style>
@endpush