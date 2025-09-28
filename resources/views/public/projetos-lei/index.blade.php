@extends('layouts.app')

@section('title', 'Projetos de Lei')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/public-styles.css') }}">
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0 2rem;
            margin-bottom: 2rem;
        }
        
        .filter-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 2rem;
        }
        
        .projeto-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .projeto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .projeto-destaque {
            border-left: 5px solid #ffc107;
            background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-tramitando { background: #fff3cd; color: #856404; }
        .status-aprovado { background: #d1edff; color: #0c5460; }
        .status-rejeitado { background: #f8d7da; color: #721c24; }
        .status-arquivado { background: #e2e3e5; color: #383d41; }
        
        .btn-action {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-outline-custom {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }
        
        .btn-outline-custom:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .destaque-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 3rem 0;
            margin-bottom: 3rem;
            border-radius: 20px;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 1rem;
        }
        
        .stats-icon {
            font-size: 3rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
@endpush

@section('content')
<!-- Header da Página -->
<section class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-balance-scale me-3"></i>
                    Projetos de Lei
                </h1>
                <p class="lead mb-0">
                    Acompanhe os projetos de lei em tramitação na Câmara Municipal
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="stats-card d-inline-block">
                    <div class="stats-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h3 class="fw-bold text-primary mb-1">{{ $projetos->total() }}</h3>
                    <p class="text-muted mb-0">Projetos Ativos</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- Filtros -->
    <div class="card filter-card">
        <div class="card-header bg-transparent border-0 pb-0">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-filter me-2 text-primary"></i>
                Filtros de Busca
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('projetos-lei.index') }}" id="filtrosForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="busca" class="form-label fw-semibold">Buscar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0" 
                                   id="busca" 
                                   name="busca" 
                                   value="{{ request('busca') }}" 
                                   placeholder="Número, título, ementa...">
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="tipo" class="form-label fw-semibold">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos os tipos</option>
                            <option value="projeto_lei" {{ request('tipo') == 'projeto_lei' ? 'selected' : '' }}>Projeto de Lei</option>
                            <option value="projeto_lei_complementar" {{ request('tipo') == 'projeto_lei_complementar' ? 'selected' : '' }}>Lei Complementar</option>
                            <option value="projeto_resolucao" {{ request('tipo') == 'projeto_resolucao' ? 'selected' : '' }}>Resolução</option>
                            <option value="projeto_decreto_legislativo" {{ request('tipo') == 'projeto_decreto_legislativo' ? 'selected' : '' }}>Decreto Legislativo</option>
                            <option value="indicacao" {{ request('tipo') == 'indicacao' ? 'selected' : '' }}>Indicação</option>
                            <option value="mocao" {{ request('tipo') == 'mocao' ? 'selected' : '' }}>Moção</option>
                            <option value="requerimento" {{ request('tipo') == 'requerimento' ? 'selected' : '' }}>Requerimento</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos os status</option>
                            <option value="tramitando" {{ request('status') == 'tramitando' ? 'selected' : '' }}>Tramitando</option>
                            <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                            <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                            <option value="arquivado" {{ request('status') == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="ano" class="form-label fw-semibold">Ano</label>
                        <select class="form-select" id="ano" name="ano">
                            <option value="">Todos os anos</option>
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('ano') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-search me-2"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </div>
                
                @if(request()->hasAny(['busca', 'tipo', 'status', 'ano']))
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('projetos-lei.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times me-2"></i>Limpar Filtros
                        </a>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Projetos em Destaque -->
    @if(isset($projetosDestaque) && $projetosDestaque->count() > 0)
    <section class="destaque-section">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-star me-2"></i>
                    Projetos em Destaque
                </h2>
                <p class="text-muted">Projetos de maior relevância e impacto para a comunidade</p>
            </div>
            
            <div class="row g-4">
                @foreach($projetosDestaque as $projeto)
                <div class="col-lg-4 col-md-6">
                    <div class="card projeto-card projeto-destaque h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-star me-1"></i>Destaque
                                </span>
                                <span class="status-badge status-{{ $projeto->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $projeto->status)) }}
                                </span>
                            </div>
                            
                            <h5 class="card-title fw-bold mb-3">{{ $projeto->titulo }}</h5>
                            <p class="card-text text-muted mb-3">{{ Str::limit($projeto->ementa, 120) }}</p>
                            
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Número</small>
                                    <strong>{{ $projeto->numero }}/{{ $projeto->ano }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Autor</small>
                                    <strong>
                                        @if($projeto->tipo_autoria === 'vereador' && $projeto->autor)
                                            {{ $projeto->autor->nome }}
                                        @elseif($projeto->tipo_autoria === 'prefeito')
                                            {{ $projeto->autor_nome ?? 'Prefeito Municipal' }}
                                        @elseif($projeto->tipo_autoria === 'comissao')
                                            {{ $projeto->autor_nome ?? 'Comissão' }}
                                        @elseif($projeto->tipo_autoria === 'iniciativa_popular')
                                            {{ $projeto->comiteIniciativaPopular ? $projeto->comiteIniciativaPopular->nome : 'Iniciativa Popular' }}
                                        @else
                                            N/A
                                        @endif
                                    </strong>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('projetos-lei.show', $projeto->id) }}" class="btn btn-primary-custom">
                                    <i class="fas fa-eye me-2"></i>Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Lista de Projetos -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-list me-2"></i>
                Todos os Projetos
                <span class="badge bg-primary ms-2">{{ $projetos->total() }}</span>
            </h2>
            
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;" onchange="changeSort(this.value)">
                    <option value="data_desc" {{ request('ordenacao') == 'data_desc' ? 'selected' : '' }}>Mais Recentes</option>
                    <option value="data_asc" {{ request('ordenacao') == 'data_asc' ? 'selected' : '' }}>Mais Antigos</option>
                    <option value="numero_desc" {{ request('ordenacao') == 'numero_desc' ? 'selected' : '' }}>Número (Desc)</option>
                    <option value="numero_asc" {{ request('ordenacao') == 'numero_asc' ? 'selected' : '' }}>Número (Asc)</option>
                </select>
            </div>
        </div>
        
        @if($projetos->count() > 0)
            <div class="row g-4">
                @foreach($projetos as $projeto)
                <div class="col-lg-6">
                    <div class="card projeto-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-info text-dark mb-2">
                                        {{ ucfirst(str_replace('_', ' ', $projeto->tipo)) }}
                                    </span>
                                    @if($projeto->urgencia)
                                        <span class="badge bg-danger ms-1">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Urgente
                                        </span>
                                    @endif
                                </div>
                                <span class="status-badge status-{{ $projeto->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $projeto->status)) }}
                                </span>
                            </div>
                            
                            <h5 class="card-title fw-bold mb-3">{{ $projeto->titulo }}</h5>
                            <p class="card-text text-muted mb-3">{{ Str::limit($projeto->ementa, 150) }}</p>
                            
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <small class="text-muted d-block">Número</small>
                                    <strong>{{ $projeto->numero }}/{{ $projeto->ano }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Autor</small>
                                    <strong>
                                        @php
                                            $autorNome = 'N/A';
                                            if($projeto->tipo_autoria === 'vereador' && $projeto->autor) {
                                                $autorNome = $projeto->autor->nome;
                                            } elseif($projeto->tipo_autoria === 'prefeito') {
                                                $autorNome = $projeto->autor_nome ?? 'Prefeito Municipal';
                                            } elseif($projeto->tipo_autoria === 'comissao') {
                                                $autorNome = $projeto->autor_nome ?? 'Comissão';
                                            } elseif($projeto->tipo_autoria === 'iniciativa_popular') {
                                                $autorNome = $projeto->comiteIniciativaPopular ? $projeto->comiteIniciativaPopular->nome : 'Iniciativa Popular';
                                            }
                                        @endphp
                                        {{ Str::limit($autorNome, 15) }}
                                    </strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Data</small>
                                    <strong>{{ $projeto->data_protocolo ? $projeto->data_protocolo->format('d/m/Y') : 'N/A' }}</strong>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('projetos-lei.show', $projeto->id) }}" class="btn btn-primary-custom flex-fill">
                                    <i class="fas fa-eye me-2"></i>Ver Detalhes
                                </a>
                                @if($projeto->arquivo_projeto)
                                <a href="{{ route('projetos-lei.download', ['projetoLei' => $projeto->id, 'tipo' => 'projeto']) }}" 
                                   class="btn btn-outline-custom" title="Download do Projeto">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif
                                @if($projeto->arquivo_lei)
                                <a href="{{ route('projetos-lei.download', ['projetoLei' => $projeto->id, 'tipo' => 'lei']) }}" 
                                   class="btn btn-outline-success" title="Download da Lei">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-5">
                {{ $projetos->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h4 class="fw-bold mb-3">Nenhum projeto encontrado</h4>
                <p class="mb-4">Não foram encontrados projetos de lei com os filtros aplicados.</p>
                <a href="{{ route('projetos-lei.index') }}" class="btn btn-primary-custom">
                    <i class="fas fa-refresh me-2"></i>Ver Todos os Projetos
                </a>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
function changeSort(value) {
    const url = new URL(window.location);
    url.searchParams.set('ordenacao', value);
    window.location.href = url.toString();
}

// Auto-submit do formulário de filtros
document.addEventListener('DOMContentLoaded', function() {
    const filtrosForm = document.getElementById('filtrosForm');
    const selects = filtrosForm.querySelectorAll('select');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            // Não submeter automaticamente, deixar o usuário clicar no botão
        });
    });
    
    // Adicionar funcionalidade de busca em tempo real (opcional)
    const buscaInput = document.getElementById('busca');
    let timeoutId;
    
    buscaInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            // Opcional: submeter automaticamente após 1 segundo de inatividade
            // filtrosForm.submit();
        }, 1000);
    });
});
</script>
@endpush