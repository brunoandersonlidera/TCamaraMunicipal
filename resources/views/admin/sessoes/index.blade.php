@extends('layouts.admin')

@section('page-title', 'Sessões')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Sessões</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gerenciar Sessões</h1>
            <p class="text-muted">Gerencie as sessões da Câmara Municipal</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Toggle de visualização -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary" id="tableViewBtn" onclick="toggleView('table')">
                    <i class="fas fa-table"></i> Tabela
                </button>
                <button type="button" class="btn btn-outline-secondary active" id="cardsViewBtn" onclick="toggleView('cards')">
                    <i class="fas fa-th-large"></i> Cards
                </button>
            </div>
            <a href="{{ route('admin.sessoes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nova Sessão
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.sessoes.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="busca" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="busca" name="busca" 
                           value="{{ request('busca') }}" 
                           placeholder="Número da sessão ou pauta...">
                </div>
                
                <div class="col-md-2">
                    <label for="tipo_sessao_id" class="form-label">Tipo de Sessão</label>
                    <select class="form-select" id="tipo_sessao_id" name="tipo_sessao_id">
                        <option value="">Todos os tipos</option>
                        @foreach($tiposSessao as $tipo)
                            <option value="{{ $tipo->id }}" {{ request('tipo_sessao_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="agendada" {{ request('status') === 'agendada' ? 'selected' : '' }}>Agendada</option>
                        <option value="em_andamento" {{ request('status') === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="finalizada" {{ request('status') === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                           value="{{ request('data_inicio') }}">
                </div>
                
                <div class="col-md-2">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                           value="{{ request('data_fim') }}">
                </div>
                
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Visualização em Tabela -->
    <div id="tableView" class="view-container" style="display: none;">
        <div class="admin-card">
            <div class="card-body p-0">
                @if($sessoes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Tipo</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Local</th>
                                    <th>Status</th>
                                    <th>Presentes</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessoes as $sessao)
                                    <tr>
                                        <td>{{ $sessao->numero_sessao }}/{{ $sessao->legislatura }}</td>
                                        <td>
                                            @if($sessao->tipoSessao)
                                                <span class="badge tipo-badge" data-cor="{{ $sessao->tipoSessao->cor }}">
                                                    <i class="{{ $sessao->tipoSessao->icone }}"></i>
                                                    {{ $sessao->tipoSessao->nome }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($sessao->tipo) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $sessao->data_sessao ? \Carbon\Carbon::parse($sessao->data_sessao)->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            @if($sessao->hora_inicio)
                                                {{ \Carbon\Carbon::parse($sessao->hora_inicio)->format('H:i') }}
                                                @if($sessao->hora_fim)
                                                    - {{ \Carbon\Carbon::parse($sessao->hora_fim)->format('H:i') }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $sessao->local ?? 'Plenário' }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $sessao->status === 'agendada' ? 'secondary' : 
                                                ($sessao->status === 'em_andamento' ? 'warning' : 
                                                ($sessao->status === 'finalizada' ? 'success' : 'danger')) 
                                            }}">
                                                {{ match($sessao->status) {
                                                    'agendada' => 'Agendada',
                                                    'em_andamento' => 'Em Andamento',
                                                    'finalizada' => 'Finalizada',
                                                    'cancelada' => 'Cancelada',
                                                    default => 'Indefinido'
                                                } }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($sessao->vereadores->count() > 0)
                                                {{ $sessao->vereadores->where('pivot.presente', true)->count() }}/{{ $sessao->vereadores->count() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.sessoes.show', $sessao) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.sessoes.edit', $sessao) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($sessao->ata)
                                                    <a href="{{ route('admin.sessoes.download-ata', $sessao) }}" 
                                                       class="btn btn-sm btn-outline-info" title="Download Ata">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                @endif
                                                @if($sessao->pauta)
                                                    <a href="{{ route('admin.sessoes.download-pauta', $sessao) }}" 
                                                       class="btn btn-sm btn-outline-secondary" title="Download Pauta">
                                                        <i class="fas fa-file-alt"></i>
                                                    </a>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                                        data-id="{{ $sessao->id }}" 
                                                        data-numero="{{ $sessao->numero_sessao }}" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <p>Nenhuma sessão encontrada</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginação -->
                    @if($sessoes->hasPages())
                        <div class="card-footer">
                            {{ $sessoes->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhuma sessão encontrada</h5>
                        <p class="text-muted">
                            @if(request()->hasAny(['busca', 'tipo', 'status', 'data_inicio', 'data_fim']))
                                Tente ajustar os filtros ou 
                                <a href="{{ route('admin.sessoes.index') }}">limpar a busca</a>.
                            @else
                                Comece criando sua primeira sessão.
                            @endif
                        </p>
                        @if(!request()->hasAny(['busca', 'tipo', 'status', 'data_inicio', 'data_fim']))
                            <a href="{{ route('admin.sessoes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Criar Primeira Sessão
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Visualização em Cards -->
    <div id="cardsView" class="view-container">
        @if($sessoes->count() > 0)
            <div class="row">
                @foreach($sessoes as $sessao)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 sessao-card">
                        <!-- Thumbnail do vídeo -->
                        <div class="card-img-top position-relative" style="height: 200px; overflow: hidden;">
                            @if($sessao->thumbnail_url)
                                <img src="{{ $sessao->thumbnail_url }}" 
                                     alt="Thumbnail da Sessão {{ $sessao->numero_sessao }}" 
                                     class="w-100 h-100" 
                                     style="object-fit: cover;">
                            @elseif($sessao->video_url)
                                @php
                                    // Extrair ID do YouTube para gerar thumbnail
                                    $videoId = null;
                                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $sessao->video_url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if($videoId)
                                    <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" 
                                         alt="Thumbnail da Sessão {{ $sessao->numero_sessao }}" 
                                         class="w-100 h-100" 
                                         style="object-fit: cover;"
                                         onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'">
                                @else
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-video fa-3x text-muted"></i>
                                    </div>
                                @endif
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-gavel fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            <!-- Play button overlay se houver vídeo -->
                            @if($sessao->video_url)
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="bg-dark bg-opacity-75 rounded-circle p-3">
                                        <i class="fas fa-play text-white fa-2x"></i>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Badge de status -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-{{ 
                                    $sessao->status === 'agendada' ? 'secondary' : 
                                    ($sessao->status === 'em_andamento' ? 'warning' : 
                                    ($sessao->status === 'finalizada' ? 'success' : 'danger')) 
                                }}">
                                    {{ match($sessao->status) {
                                        'agendada' => 'Agendada',
                                        'em_andamento' => 'Em Andamento',
                                        'finalizada' => 'Finalizada',
                                        'cancelada' => 'Cancelada',
                                        default => 'Indefinido'
                                    } }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    Sessão {{ $sessao->numero_sessao }}/{{ $sessao->legislatura }}
                                </h5>
                                @if($sessao->tipoSessao)
                                    <span class="badge tipo-badge" data-cor="{{ $sessao->tipoSessao->cor }}">
                                        <i class="{{ $sessao->tipoSessao->icone }}"></i>
                                        {{ $sessao->tipoSessao->nome }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($sessao->tipo) }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $sessao->data_sessao ? \Carbon\Carbon::parse($sessao->data_sessao)->format('d/m/Y') : '-' }}
                                    @if($sessao->hora_inicio)
                                        às {{ \Carbon\Carbon::parse($sessao->hora_inicio)->format('H:i') }}
                                        @if($sessao->hora_fim)
                                            - {{ \Carbon\Carbon::parse($sessao->hora_fim)->format('H:i') }}
                                        @endif
                                    @endif
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $sessao->local ?? 'Plenário' }}
                                </small>
                            </div>
                            
                            @if($sessao->vereadores->count() > 0)
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        {{ $sessao->vereadores->where('pivot.presente', true)->count() }}/{{ $sessao->vereadores->count() }} vereadores presentes
                                    </small>
                                </div>
                            @endif
                            
                            @if($sessao->descricao)
                                <p class="card-text text-muted small">
                                    {{ Str::limit($sessao->descricao, 100) }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.sessoes.show', $sessao) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sessoes.edit', $sessao) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($sessao->video_url)
                                        <a href="{{ $sessao->video_url }}" 
                                           class="btn btn-outline-success" 
                                           title="Assistir Vídeo" 
                                           target="_blank">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="btn-group btn-group-sm" role="group">
                                    @if($sessao->ata)
                                        <a href="{{ route('admin.sessoes.download-ata', $sessao) }}" 
                                           class="btn btn-outline-info" 
                                           title="Download Ata" 
                                           target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    <button type="button" 
                                            class="btn btn-outline-danger delete-btn" 
                                            title="Excluir"
                                            data-id="{{ $sessao->id }}"
                                            data-numero="{{ $sessao->numero_sessao }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Paginação -->
            @if($sessoes->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $sessoes->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhuma sessão encontrada</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['busca', 'tipo', 'status', 'data_inicio', 'data_fim']))
                        Tente ajustar os filtros ou 
                        <a href="{{ route('admin.sessoes.index') }}">limpar a busca</a>.
                    @else
                        Comece criando sua primeira sessão.
                    @endif
                </p>
                @if(!request()->hasAny(['busca', 'tipo', 'status', 'data_inicio', 'data_fim']))
                    <a href="{{ route('admin.sessoes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Criar Primeira Sessão
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a sessão <strong id="sessaoTitulo"></strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita e todos os arquivos associados serão removidos.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.btn-group .btn {
    border-radius: 0.25rem !important;
    margin-right: 2px;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
}

.table-responsive {
    border-radius: 0.5rem;
}

.sessao-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e3e6f0;
}

.sessao-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.view-container {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-img-top img {
    transition: transform 0.3s ease;
}

.sessao-card:hover .card-img-top img {
    transform: scale(1.05);
}

.position-absolute .bg-dark {
    transition: all 0.3s ease;
}

.sessao-card:hover .position-absolute .bg-dark {
    background-color: rgba(0, 0, 0, 0.9) !important;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/sessoes-index.js') }}"></script>
@endpush

@push('styles')
<style>
.tipo-badge {
    color: white !important;
}
</style>
@endpush