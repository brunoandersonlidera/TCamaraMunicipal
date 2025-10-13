@extends('layouts.admin')

@section('title', 'Temas do Site')
@section('page-title', 'Temas do Site')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Temas</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Gerenciar Temas</h2>
        <a href="{{ route('admin.temas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Novo Tema
        </a>
    </div>

    @if($activeTheme)
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="fas fa-palette me-2"></i>
            <div>
                Tema ativo: <strong>{{ $activeTheme->name }}</strong>
                <a class="btn btn-sm btn-outline-primary ms-2" href="{{ route('admin.temas.preview', $activeTheme) }}" target="_blank">
                    <i class="fas fa-eye me-1"></i> Ver Site com Tema
                </a>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Primária</th>
                            <th>Secundária</th>
                            <th>Acento</th>
                            <th>Agendado</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Ativo</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($themes as $theme)
                        <tr>
                            <td>{{ $theme->name }}</td>
                            <td><code>{{ $theme->slug }}</code></td>
                            <td>
                                <span class="badge" style="background-color: {{ $theme->primary_color }};">&nbsp;&nbsp;</span>
                                <small class="text-muted ms-1">{{ $theme->primary_color }}</small>
                            </td>
                            <td>
                                @if($theme->secondary_color)
                                    <span class="badge" style="background-color: {{ $theme->secondary_color }};">&nbsp;&nbsp;</span>
                                    <small class="text-muted ms-1">{{ $theme->secondary_color }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($theme->accent_color)
                                    <span class="badge" style="background-color: {{ $theme->accent_color }};">&nbsp;&nbsp;</span>
                                    <small class="text-muted ms-1">{{ $theme->accent_color }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($theme->is_scheduled)
                                    <span class="badge bg-warning text-dark">Sim</span>
                                @else
                                    <span class="badge bg-secondary">Não</span>
                                @endif
                            </td>
                            <td>{{ $theme->start_date ? \Carbon\Carbon::parse($theme->start_date)->format('d/m/Y') : '—' }}</td>
                            <td>{{ $theme->end_date ? \Carbon\Carbon::parse($theme->end_date)->format('d/m/Y') : '—' }}</td>
                            <td>
                                @if($theme->is_currently_active)
                                    <span class="badge bg-success">Ativo</span>
                                    @if($theme->is_scheduled && !$theme->is_active)
                                        <small class="text-muted ms-1">(agendado)</small>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.temas.preview', $theme) }}" class="btn btn-sm btn-outline-primary" title="Pré-visualizar" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.temas.edit', $theme) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$theme->is_active)
                                        <form action="{{ route('admin.temas.activate', $theme) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Ativar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.temas.destroy', $theme) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este tema?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir" {{ $theme->is_active ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="mt-2">
                                    <form action="{{ route('admin.temas.schedule', $theme) }}" method="POST" class="row g-2 align-items-center">
                                        @csrf
                                        <div class="col-auto">
                                            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $theme->start_date ? \Carbon\Carbon::parse($theme->start_date)->format('Y-m-d') : '' }}" placeholder="Início">
                                        </div>
                                        <div class="col-auto">
                                            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $theme->end_date ? \Carbon\Carbon::parse($theme->end_date)->format('Y-m-d') : '' }}" placeholder="Fim">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-calendar-alt me-1"></i> Agendar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Nenhum tema cadastrado ainda.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($themes, 'links'))
            <div class="card-footer">{{ $themes->links() }}</div>
        @endif
    </div>
@endsection