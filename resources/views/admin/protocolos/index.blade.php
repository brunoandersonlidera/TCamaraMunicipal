@extends('layouts.admin')

@section('title', 'Protocolos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Protocolos</li>
                    </ol>
                </div>
                <h4 class="page-title">Protocolos</h4>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row">
        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="fas fa-file-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Total de Protocolos">Total</h5>
                    <h3 class="mt-3 mb-3">{{ $estatisticas['total'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="fas fa-clock widget-icon bg-warning"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Em Tramitação">Em Tramitação</h5>
                    <h3 class="mt-3 mb-3">{{ $estatisticas['em_tramitacao'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="fas fa-check-circle widget-icon bg-success"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Aprovados">Aprovados</h5>
                    <h3 class="mt-3 mb-3">{{ $estatisticas['aprovados'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="fas fa-times-circle widget-icon bg-danger"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Rejeitados">Rejeitados</h5>
                    <h3 class="mt-3 mb-3">{{ $estatisticas['rejeitados'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('admin.protocolos.create') }}" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i> Novo Protocolo
                            </a>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <form method="GET" action="{{ route('admin.protocolos.index') }}" class="d-inline-flex">
                                    <div class="me-2">
                                        <select name="tipo" class="form-select">
                                            <option value="">Todos os tipos</option>
                                            <option value="projeto_lei" {{ request('tipo') == 'projeto_lei' ? 'selected' : '' }}>Projeto de Lei</option>
                                            <option value="projeto_resolucao" {{ request('tipo') == 'projeto_resolucao' ? 'selected' : '' }}>Projeto de Resolução</option>
                                            <option value="projeto_decreto" {{ request('tipo') == 'projeto_decreto' ? 'selected' : '' }}>Projeto de Decreto</option>
                                            <option value="indicacao" {{ request('tipo') == 'indicacao' ? 'selected' : '' }}>Indicação</option>
                                            <option value="requerimento" {{ request('tipo') == 'requerimento' ? 'selected' : '' }}>Requerimento</option>
                                            <option value="mocao" {{ request('tipo') == 'mocao' ? 'selected' : '' }}>Moção</option>
                                        </select>
                                    </div>
                                    <div class="me-2">
                                        <select name="status" class="form-select">
                                            <option value="">Todos os status</option>
                                            <option value="protocolado" {{ request('status') == 'protocolado' ? 'selected' : '' }}>Protocolado</option>
                                            <option value="em_tramitacao" {{ request('status') == 'em_tramitacao' ? 'selected' : '' }}>Em Tramitação</option>
                                            <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                            <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                            <option value="arquivado" {{ request('status') == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                                        </select>
                                    </div>
                                    <div class="me-2">
                                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="protocolos-datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Autor</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th style="width: 85px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($protocolos as $protocolo)
                                <tr>
                                    <td>
                                        <strong>{{ $protocolo->numero_protocolo }}</strong>
                                    </td>
                                    <td>
                                        <h5 class="m-0 d-inline-block align-middle">
                                            <a href="{{ route('admin.protocolos.show', $protocolo) }}" class="text-body">
                                                {{ Str::limit($protocolo->titulo, 50) }}
                                            </a>
                                        </h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst(str_replace('_', ' ', $protocolo->tipo)) }}
                                        </span>
                                    </td>
                                    <td>{{ $protocolo->autor }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'protocolado' => 'secondary',
                                                'em_tramitacao' => 'warning',
                                                'aprovado' => 'success',
                                                'rejeitado' => 'danger',
                                                'arquivado' => 'dark'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$protocolo->status] ?? 'secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $protocolo->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $protocolo->created_at->format('d/m/Y') }}</td>
                                    <td class="table-action">
                                        <a href="{{ route('admin.protocolos.show', $protocolo) }}" class="action-icon">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.protocolos.edit', $protocolo) }}" class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        <form action="{{ route('admin.protocolos.destroy', $protocolo) }}" method="POST" class="d-inline" data-confirm="Tem certeza que deseja excluir este protocolo?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon btn btn-link p-0">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Nenhum protocolo encontrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    @if($protocolos->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $protocolos->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection