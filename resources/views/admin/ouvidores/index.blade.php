@extends('layouts.admin')

@section('title', 'Ouvidores')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Gerenciar Ouvidores</h3>
                    <a href="{{ route('admin.ouvidores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Novo Ouvidor
                    </a>
                </div>

                <div class="card-body">
                    <!-- Estatísticas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total</span>
                                    <span class="info-box-number">{{ $estatisticas['total'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ativos</span>
                                    <span class="info-box-number">{{ $estatisticas['ativos'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-user-times"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Inativos</span>
                                    <span class="info-box-number">{{ $estatisticas['inativos'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-comments"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Com Manifestações</span>
                                    <span class="info-box-number">{{ $estatisticas['com_manifestacoes'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nome ou email..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">Todos os Status</option>
                                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativos</option>
                                    <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativos</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="especialidade" class="form-control">
                                    <option value="">Todas as Especialidades</option>
                                    <option value="ouvidoria" {{ request('especialidade') == 'ouvidoria' ? 'selected' : '' }}>Ouvidoria</option>
                                    <option value="esic" {{ request('especialidade') == 'esic' ? 'selected' : '' }}>e-SIC</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabela de Ouvidores -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Cargo</th>
                                    <th>Setor</th>
                                    <th>Tipo</th>
                                    <th>Manifestações</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ouvidores as $ouvidor)
                                <tr>
                                    <td>
                                        <strong>{{ $ouvidor->nome }}</strong>
                                        @if($ouvidor->user)
                                            <br><small class="text-muted">{{ $ouvidor->user->name }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $ouvidor->email }}</td>
                                    <td>{{ $ouvidor->cargo }}</td>
                                    <td>{{ $ouvidor->setor }}</td>
                                    <td>
                                        <span class="badge badge-{{ $ouvidor->tipo == 'ouvidoria' ? 'primary' : 'info' }}">
                                            {{ ucfirst($ouvidor->tipo) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $ouvidor->manifestacoes_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $ouvidor->ativo ? 'success' : 'danger' }}">
                                            {{ $ouvidor->ativo ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.ouvidores.show', $ouvidor) }}" class="btn btn-sm btn-info" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.ouvidores.edit', $ouvidor) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.ouvidores.destroy', $ouvidor) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este ouvidor?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="mb-0">Nenhum ouvidor encontrado.</p>
                                        <a href="{{ route('admin.ouvidores.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Cadastrar Primeiro Ouvidor
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    @if($ouvidores->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $ouvidores->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.info-box {
    display: block;
    min-height: 90px;
    background: #fff;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
}

.info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 90px;
    width: 90px;
    text-align: center;
    font-size: 45px;
    line-height: 90px;
    background: rgba(0,0,0,0.2);
}

.info-box-content {
    padding: 5px 10px;
    margin-left: 90px;
}

.info-box-text {
    text-transform: uppercase;
    font-weight: bold;
    font-size: 14px;
}

.info-box-number {
    display: block;
    font-weight: bold;
    font-size: 18px;
}
</style>
@endpush