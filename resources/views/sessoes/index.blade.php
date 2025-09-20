@extends('layouts.app')

@section('title', 'Sessões Plenárias')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Sessões Plenárias</h1>
                    <p class="lead mb-4">Acompanhe as sessões da Câmara Municipal, suas pautas, atas e transmissões ao vivo.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('sessoes.calendario') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-calendar-alt me-2"></i>Calendário
                        </a>
                        @if(isset($sessaoAoVivo) && $sessaoAoVivo)
                        <a href="{{ route('sessoes.ao-vivo', $sessaoAoVivo) }}" class="btn btn-danger btn-lg">
                            <i class="fas fa-broadcast-tower me-2"></i>AO VIVO
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-gavel fa-5x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Filtros e Busca -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('sessoes.index') }}" class="row g-3">
                            <!-- Primeira linha de filtros -->
                            <div class="col-md-3">
                                <label for="busca" class="form-label">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </label>
                                <input type="text" class="form-control" id="busca" name="busca" 
                                       value="{{ request('busca') }}" 
                                       placeholder="Número da sessão ou pauta...">
                            </div>
                            <div class="col-md-2">
                                <label for="tipo" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Tipo
                                </label>
                                <select class="form-select" id="tipo" name="tipo">
                                    <option value="">Todos</option>
                                    <option value="ordinaria" {{ request('tipo') === 'ordinaria' ? 'selected' : '' }}>Ordinária</option>
                                    <option value="extraordinaria" {{ request('tipo') === 'extraordinaria' ? 'selected' : '' }}>Extraordinária</option>
                                    <option value="solene" {{ request('tipo') === 'solene' ? 'selected' : '' }}>Solene</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">
                                    <i class="fas fa-info-circle me-1"></i>Status
                                </label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Todos</option>
                                    <option value="agendada" {{ request('status') === 'agendada' ? 'selected' : '' }}>Agendada</option>
                                    <option value="em_andamento" {{ request('status') === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="finalizada" {{ request('status') === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="ano" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Ano
                                </label>
                                <select class="form-select" id="ano" name="ano">
                                    <option value="">Todos</option>
                                    @for($i = date('Y'); $i >= 2020; $i--)
                                        <option value="{{ $i }}" {{ request('ano') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="ordenacao" class="form-label">
                                    <i class="fas fa-sort me-1"></i>Ordenação
                                </label>
                                <select class="form-select" id="ordenacao" name="ordenacao">
                                    <option value="data_desc" {{ request('ordenacao') === 'data_desc' ? 'selected' : '' }}>Data (Mais recente)</option>
                                    <option value="data_asc" {{ request('ordenacao') === 'data_asc' ? 'selected' : '' }}>Data (Mais antiga)</option>
                                    <option value="numero_desc" {{ request('ordenacao') === 'numero_desc' ? 'selected' : '' }}>Número (Decrescente)</option>
                                    <option value="numero_asc" {{ request('ordenacao') === 'numero_asc' ? 'selected' : '' }}>Número (Crescente)</option>
                                    <option value="tipo" {{ request('ordenacao') === 'tipo' ? 'selected' : '' }}>Por Tipo</option>
                                </select>
                            </div>

                            <!-- Segunda linha de filtros - Vídeos -->
                            <div class="col-12 filtros-video" style="display: none;">
                                <div class="p-3">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-video me-2"></i>Filtros de Vídeo
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="com_video" class="form-label">
                                                <i class="fas fa-play-circle me-1"></i>Vídeo Disponível
                                            </label>
                                            <select class="form-select" id="com_video" name="com_video">
                                                <option value="">Todos</option>
                                                <option value="1" {{ request('com_video') === '1' ? 'selected' : '' }}>Com vídeo</option>
                                                <option value="0" {{ request('com_video') === '0' ? 'selected' : '' }}>Sem vídeo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="plataforma" class="form-label">
                                                <i class="fas fa-tv me-1"></i>Plataforma
                                            </label>
                                            <select class="form-select" id="plataforma" name="plataforma">
                                                <option value="">Todas</option>
                                                <option value="youtube" {{ request('plataforma') === 'youtube' ? 'selected' : '' }}>
                                                    YouTube
                                                </option>
                                                <option value="vimeo" {{ request('plataforma') === 'vimeo' ? 'selected' : '' }}>
                                                    Vimeo
                                                </option>
                                                <option value="facebook" {{ request('plataforma') === 'facebook' ? 'selected' : '' }}>
                                                    Facebook
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Filtre sessões por disponibilidade de vídeo gravado
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </button>
                                <a href="{{ route('sessoes.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Limpar
                                </a>
                                <button type="button" class="btn btn-outline-info" id="filtros-avancados">
                                    <i class="fas fa-filter me-1"></i>Filtros Avançados
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessão Ao Vivo -->
        @if($sessaoAoVivo)
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning border-0 shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="alert-heading mb-2">
                                <i class="fas fa-broadcast-tower text-danger me-2"></i>
                                Sessão em Andamento
                            </h5>
                            <p class="mb-2">
                                <strong>{{ $sessaoAoVivo->numero_sessao }}/{{ $sessaoAoVivo->legislatura }}</strong> - 
                                {{ ucfirst($sessaoAoVivo->tipo) }}
                            </p>
                            <small class="text-muted">
                                {{ $sessaoAoVivo->data_sessao ? \Carbon\Carbon::parse($sessaoAoVivo->data_sessao)->format('d/m/Y') : '' }}
                                às {{ $sessaoAoVivo->hora_inicio ? \Carbon\Carbon::parse($sessaoAoVivo->hora_inicio)->format('H:i') : '' }}
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($sessaoAoVivo->transmissao_online)
                                <a href="{{ $sessaoAoVivo->transmissao_online }}" target="_blank" 
                                   class="btn btn-danger btn-lg">
                                    <i class="fas fa-play me-2"></i>Assistir Ao Vivo
                                </a>
                            @endif
                            <a href="{{ route('sessoes.show', $sessaoAoVivo) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Sessões por Tipo (quando não há filtros ativos) -->
        @if(!request()->hasAny(['busca', 'tipo', 'status', 'ano', 'com_video', 'plataforma']) && isset($sessoesPorTipo) && $sessoesPorTipo->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="section-title mb-4">
                    <i class="fas fa-folder-open me-2"></i>
                    Sessões por Tipo
                </h3>
                <p class="text-muted mb-4">Navegue pelas sessões organizadas por tipo para encontrar o conteúdo que procura.</p>
            </div>
        </div>

        @foreach($sessoesPorTipo as $tipo => $sessoesDoTipo)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-custom">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-tag me-2 text-primary"></i>
                            {{ ucfirst(str_replace('_', ' ', $tipo)) }}
                            <span class="badge bg-primary ms-2">{{ $sessoesDoTipo->count() }}</span>
                        </h5>
                        <a href="{{ route('sessoes.index', ['tipo' => $tipo]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>
                            Ver todas
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($sessoesDoTipo->take(6) as $sessao)
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-custom h-100 sessao-tipo-card">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title fw-bold mb-1">
                                                Sessão {{ $sessao->numero_sessao }}/{{ $sessao->legislatura }}
                                            </h6>
                                            <span class="badge bg-{{ 
                                                $sessao->status === 'agendada' ? 'secondary' : 
                                                ($sessao->status === 'em_andamento' ? 'warning' : 
                                                ($sessao->status === 'finalizada' ? 'success' : 'danger')) 
                                            }} small">
                                                {{ match($sessao->status) {
                                                    'agendada' => 'Agendada',
                                                    'em_andamento' => 'Em Andamento',
                                                    'finalizada' => 'Finalizada',
                                                    'cancelada' => 'Cancelada',
                                                    default => 'Indefinido'
                                                } }}
                                            </span>
                                        </div>
                                        
                                        <p class="card-text text-muted small mb-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $sessao->data_sessao ? \Carbon\Carbon::parse($sessao->data_sessao)->format('d/m/Y') : '-' }}
                                            @if($sessao->hora_inicio)
                                                às {{ \Carbon\Carbon::parse($sessao->hora_inicio)->format('H:i') }}
                                            @endif
                                        </p>
                                        
                                        @if($sessao->temVideo())
                                        <div class="mb-2">
                                            <span class="badge bg-success small">
                                                <i class="fas fa-play me-1"></i>
                                                Vídeo Disponível
                                                @if($sessao->plataforma_video === 'youtube')
                                                    <i class="fab fa-youtube ms-1"></i>
                                                @elseif($sessao->plataforma_video === 'vimeo')
                                                    <i class="fab fa-vimeo ms-1"></i>
                                                @elseif($sessao->plataforma_video === 'facebook')
                                                    <i class="fab fa-facebook ms-1"></i>
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                        
                                        <div class="d-flex gap-2 mt-auto">
                                            <a href="{{ route('sessoes.show', $sessao) }}" class="btn btn-sm btn-primary flex-fill">
                                                <i class="fas fa-eye me-1"></i>
                                                Ver Detalhes
                                            </a>
                                            @if($sessao->temVideo())
                                            <a href="{{ route('sessoes.show', $sessao) }}" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-play"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($sessoesDoTipo->count() > 6)
                        <div class="text-center mt-3">
                            <a href="{{ route('sessoes.index', ['tipo' => $tipo]) }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>
                                Ver mais {{ $sessoesDoTipo->count() - 6 }} sessões de {{ ucfirst(str_replace('_', ' ', $tipo)) }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="row mb-4">
            <div class="col-12">
                <hr class="my-4">
                <h3 class="section-title mb-4">
                    <i class="fas fa-list me-2"></i>
                    Todas as Sessões
                </h3>
            </div>
        </div>
        @endif

        <!-- Lista de Sessões -->
        <div class="row">
            @forelse($sessoes as $sessao)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">
                                Sessão {{ $sessao->numero_sessao }}/{{ $sessao->legislatura }}
                            </h6>
                            <span class="badge bg-{{ 
                                $sessao->tipo === 'ordinaria' ? 'primary' : 
                                ($sessao->tipo === 'extraordinaria' ? 'warning' : 'info') 
                            }}">
                                {{ ucfirst($sessao->tipo) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar text-muted me-2"></i>
                                <span>{{ $sessao->data_sessao ? \Carbon\Carbon::parse($sessao->data_sessao)->format('d/m/Y') : '-' }}</span>
                            </div>
                            @if($sessao->hora_inicio)
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-clock text-muted me-2"></i>
                                <span>
                                    {{ \Carbon\Carbon::parse($sessao->hora_inicio)->format('H:i') }}
                                    @if($sessao->hora_fim)
                                        - {{ \Carbon\Carbon::parse($sessao->hora_fim)->format('H:i') }}
                                    @endif
                                </span>
                            </div>
                            @endif
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                <span>{{ $sessao->local ?? 'Plenário' }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
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

                        @if($sessao->pauta)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Pauta:</h6>
                            <p class="small text-muted mb-0">
                                {{ Str::limit(is_string($sessao->pauta) ? $sessao->pauta : json_encode($sessao->pauta), 100) }}
                            </p>
                        </div>
                        @endif

                        <!-- Vídeo Gravado -->
                        @if($sessao->temVideo())
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-play-circle text-primary me-2"></i>
                                    <span class="small fw-bold">Vídeo Disponível</span>
                                    @if($sessao->plataforma_video)
                                        <span class="badge bg-secondary ms-2">
                                            @switch($sessao->plataforma_video)
                                                @case('youtube')
                                                    <i class="fab fa-youtube me-1"></i>YouTube
                                                    @break
                                                @case('vimeo')
                                                    <i class="fab fa-vimeo me-1"></i>Vimeo
                                                    @break
                                                @case('facebook')
                                                    <i class="fab fa-facebook me-1"></i>Facebook
                                                    @break
                                                @default
                                                    {{ ucfirst($sessao->plataforma_video) }}
                                            @endswitch
                                        </span>
                                    @endif
                                </div>
                                @if($sessao->getDuracaoFormatada())
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>{{ $sessao->getDuracaoFormatada() }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Documentos -->
                        <div class="mb-3">
                            @if($sessao->ata)
                                <a href="{{ route('sessoes.download-ata', $sessao) }}" 
                                   class="btn btn-sm btn-outline-info me-2">
                                    <i class="fas fa-file-pdf me-1"></i>Ata
                                </a>
                            @endif
                            @if($sessao->pauta)
                                <a href="{{ route('sessoes.download-pauta', $sessao) }}" 
                                   class="btn btn-sm btn-outline-secondary me-2">
                                    <i class="fas fa-file-alt me-1"></i>Pauta
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('sessoes.show', $sessao) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Ver Detalhes
                            </a>
                            <div class="d-flex gap-2">
                                @if($sessao->transmissao_online && $sessao->status === 'em_andamento')
                                    <a href="{{ $sessao->transmissao_online }}" target="_blank" 
                                       class="btn btn-danger btn-sm">
                                        <i class="fas fa-broadcast-tower me-1"></i>Ao Vivo
                                    </a>
                                @endif
                                @if($sessao->temVideo())
                                    <a href="{{ $sessao->video_url }}" target="_blank" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-play me-1"></i>Assistir
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhuma sessão encontrada</h4>
                    <p class="text-muted">Não há sessões que correspondam aos filtros selecionados.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if($sessoes->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $sessoes->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75em;
}

.alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left: 4px solid #ffc107;
}

@media (max-width: 768px) {
    .hero-section {
        text-align: center;
    }
    
    .display-4 {
        font-size: 2rem;
    }
}

.filtros-video {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.video-badge {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
}

.filtros-avancados-collapsed {
    display: none;
}

.btn-filter-active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.sessao-tipo-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #e9ecef;
}

.sessao-tipo-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.section-title {
    color: var(--bs-primary);
    font-weight: 600;
    border-bottom: 2px solid var(--bs-primary);
    padding-bottom: 0.5rem;
    display: inline-block;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros avançados toggle
    const btnFiltrosAvancados = document.getElementById('filtros-avancados');
    const filtrosVideo = document.querySelector('.filtros-video');
    
    if (btnFiltrosAvancados && filtrosVideo) {
        // Verificar se há filtros de vídeo ativos
        const comVideo = document.getElementById('com_video').value;
        const plataforma = document.getElementById('plataforma').value;
        
        if (comVideo || plataforma) {
            filtrosVideo.style.display = 'block';
            btnFiltrosAvancados.classList.add('btn-filter-active');
        } else {
            filtrosVideo.style.display = 'none';
        }
        
        btnFiltrosAvancados.addEventListener('click', function() {
            if (filtrosVideo.style.display === 'none') {
                filtrosVideo.style.display = 'block';
                this.classList.add('btn-filter-active');
                this.innerHTML = '<i class="fas fa-filter me-1"></i>Ocultar Filtros';
            } else {
                filtrosVideo.style.display = 'none';
                this.classList.remove('btn-filter-active');
                this.innerHTML = '<i class="fas fa-filter me-1"></i>Filtros Avançados';
            }
        });
    }
    
    // Auto-submit em mudanças de filtro (opcional)
    const autoSubmitSelects = ['ordenacao', 'com_video', 'plataforma'];
    autoSubmitSelects.forEach(selectId => {
        const select = document.getElementById(selectId);
        if (select) {
            select.addEventListener('change', function() {
                // Opcional: auto-submit do formulário
                // this.form.submit();
            });
        }
    });
    
    // Contador de filtros ativos
    function updateFilterCounter() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input[value], select option:checked');
        let activeFilters = 0;
        
        inputs.forEach(input => {
            if (input.value && input.value !== '' && input.name !== '_token') {
                activeFilters++;
            }
        });
        
        const counter = document.getElementById('filter-counter');
        if (counter) {
            counter.textContent = activeFilters > 0 ? `(${activeFilters})` : '';
        }
    }
    
    // Atualizar contador ao carregar
    updateFilterCounter();
});
</script>
@endpush