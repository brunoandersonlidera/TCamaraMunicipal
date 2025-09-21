@extends('layouts.admin')

@section('title', 'Cartas de Serviços')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Cartas de Serviços</li>
    </ol>
</nav>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cartas-servico.css') }}">
@endpush

@section('content')

<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="header-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">Cartas de Serviços</h2>
                <p class="mb-0">Gerencie os serviços oferecidos pela Câmara Municipal conforme a Lei 13.460/2017</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.cartas-servico.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus me-2"></i>Nova Carta de Serviço
                </a>
            </div>
        </div>
        
        <div class="stats-row">
            <div class="stat-item">
                <span class="stat-number">{{ $stats['total'] ?? 12 }}</span>
                <span class="stat-label">Total de Serviços</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['ativos'] ?? 8 }}</span>
                <span class="stat-label">Ativos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['rascunhos'] ?? 3 }}</span>
                <span class="stat-label">Rascunhos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['categorias'] ?? 5 }}</span>
                <span class="stat-label">Categorias</span>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filtros</h5>
        
        <form method="GET" action="{{ route('admin.cartas-servico.index') }}" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search" class="form-label">Buscar</label>
                    <div class="search-box">
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nome do serviço, descrição...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                
                <div class="filter-group">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria" name="categoria">
                        <option value="">Todas as categorias</option>
                        <option value="legislativo" {{ request('categoria') == 'legislativo' ? 'selected' : '' }}>Legislativo</option>
                        <option value="administrativo" {{ request('categoria') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                        <option value="transparencia" {{ request('categoria') == 'transparencia' ? 'selected' : '' }}>Transparência</option>
                        <option value="protocolo" {{ request('categoria') == 'protocolo' ? 'selected' : '' }}>Protocolo</option>
                        <option value="ouvidoria" {{ request('categoria') == 'ouvidoria' ? 'selected' : '' }}>Ouvidoria</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                        <option value="rascunho" {{ request('status') == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <a href="{{ route('admin.cartas-servico.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Limpar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Grid de Serviços -->
    <div class="services-grid">
        <!-- Card para adicionar novo serviço -->
        <a href="{{ route('admin.cartas-servico.create') }}" class="add-service-card text-decoration-none">
            <div class="add-service-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="add-service-text">
                Adicionar Nova Carta de Serviço
            </div>
        </a>

        <!-- Cards dos serviços existentes -->
        @forelse($servicos ?? [] as $servico)
        <div class="service-card">
            <div class="service-header">
                <div class="service-icon">
                    <i class="fas fa-{{ $servico->icone ?? 'file-alt' }}"></i>
                </div>
                <span class="service-status status-{{ $servico->status ?? 'ativo' }}">
                    {{ ucfirst($servico->status ?? 'Ativo') }}
                </span>
            </div>
            
            <h3 class="service-title">{{ $servico->nome ?? 'Protocolo de Documentos' }}</h3>
            
            <p class="service-description">
                {{ $servico->descricao ?? 'Serviço para protocolo de documentos, petições e requerimentos dirigidos à Câmara Municipal. Atendimento presencial ou digital.' }}
            </p>
            
            <div class="service-meta">
                <span class="service-category">{{ ucfirst($servico->categoria ?? 'Protocolo') }}</span>
                <span>Atualizado em {{ ($servico->updated_at ?? now())->format('d/m/Y') }}</span>
            </div>
            
            <div class="service-actions">
                <a href="{{ route('admin.cartas-servico.show', $servico->id ?? 1) }}" 
                   class="btn-action btn-view" title="Visualizar">
                    <i class="fas fa-eye"></i>
                </a>
                
                <a href="{{ route('admin.cartas-servico.edit', $servico->id ?? 1) }}" 
                   class="btn-action btn-edit" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                
                <button type="button" class="btn-action btn-toggle" 
                        data-action="toggle-status" data-service-id="{{ $servico->id ?? 1 }}" title="Alterar Status">
                    <i class="fas fa-toggle-{{ ($servico->status ?? 'ativo') == 'ativo' ? 'on' : 'off' }}"></i>
                </button>
                
                <button type="button" class="btn-action btn-delete" 
                        data-action="delete-service" data-service-id="{{ $servico->id ?? 1 }}" title="Excluir">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        @empty
        @if(!request()->hasAny(['search', 'categoria', 'status']))
        <!-- Serviços de exemplo quando não há dados -->
        <div class="service-card">
            <div class="service-header">
                <div class="service-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="service-status status-ativo">Ativo</span>
            </div>
            <h3 class="service-title">Protocolo de Documentos</h3>
            <p class="service-description">
                Serviço para protocolo de documentos, petições e requerimentos dirigidos à Câmara Municipal. Atendimento presencial ou digital.
            </p>
            <div class="service-meta">
                <span class="service-category">Protocolo</span>
                <span>Atualizado em {{ now()->format('d/m/Y') }}</span>
            </div>
            <div class="service-actions">
                <a href="#" class="btn-action btn-view" title="Visualizar">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="#" class="btn-action btn-edit" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn-action btn-toggle" title="Alterar Status">
                    <i class="fas fa-toggle-on"></i>
                </button>
                <button type="button" class="btn-action btn-delete" title="Excluir">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <div class="service-card">
            <div class="service-header">
                <div class="service-icon">
                    <i class="fas fa-search"></i>
                </div>
                <span class="service-status status-ativo">Ativo</span>
            </div>
            <h3 class="service-title">Consulta de Processos</h3>
            <p class="service-description">
                Consulta ao andamento de processos protocolados na Câmara Municipal. Acompanhe o status de suas solicitações online.
            </p>
            <div class="service-meta">
                <span class="service-category">Transparência</span>
                <span>Atualizado em {{ now()->subDays(2)->format('d/m/Y') }}</span>
            </div>
            <div class="service-actions">
                <a href="#" class="btn-action btn-view" title="Visualizar">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="#" class="btn-action btn-edit" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn-action btn-toggle" title="Alterar Status">
                    <i class="fas fa-toggle-on"></i>
                </button>
                <button type="button" class="btn-action btn-delete" title="Excluir">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <div class="service-card">
            <div class="service-header">
                <div class="service-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <span class="service-status status-ativo">Ativo</span>
            </div>
            <h3 class="service-title">Solicitação de Informações (E-SIC)</h3>
            <p class="service-description">
                Solicitação de acesso à informação pública conforme Lei de Acesso à Informação. Processo totalmente digital.
            </p>
            <div class="service-meta">
                <span class="service-category">Transparência</span>
                <span>Atualizado em {{ now()->subDays(5)->format('d/m/Y') }}</span>
            </div>
            <div class="service-actions">
                <a href="#" class="btn-action btn-view" title="Visualizar">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="#" class="btn-action btn-edit" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn-action btn-toggle" title="Alterar Status">
                    <i class="fas fa-toggle-on"></i>
                </button>
                <button type="button" class="btn-action btn-delete" title="Excluir">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <div class="service-card">
            <div class="service-header">
                <div class="service-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <span class="service-status status-rascunho">Rascunho</span>
            </div>
            <h3 class="service-title">Ouvidoria Municipal</h3>
            <p class="service-description">
                Canal para reclamações, sugestões, elogios e denúncias sobre os serviços da Câmara Municipal. Atendimento gratuito.
            </p>
            <div class="service-meta">
                <span class="service-category">Ouvidoria</span>
                <span>Atualizado em {{ now()->subDays(1)->format('d/m/Y') }}</span>
            </div>
            <div class="service-actions">
                <a href="#" class="btn-action btn-view" title="Visualizar">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="#" class="btn-action btn-edit" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn-action btn-toggle" title="Alterar Status">
                    <i class="fas fa-toggle-off"></i>
                </button>
                <button type="button" class="btn-action btn-delete" title="Excluir">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        @endif
        @endforelse
        
        @if(request()->hasAny(['search', 'categoria', 'status']) && count($servicos ?? []) == 0)
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h4>Nenhum serviço encontrado</h4>
                <p>Tente ajustar os filtros ou criar um novo serviço.</p>
                <a href="{{ route('admin.cartas-servico.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Criar Novo Serviço
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/cartas-servico-index.js') }}"></script>
@endpush
@endsection