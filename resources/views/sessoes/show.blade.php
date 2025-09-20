@extends('layouts.app')

@section('title', 'Sessão ' . $sessao->numero_sessao . '/' . $sessao->legislatura)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sessoes.index') }}">Sessões</a></li>
            <li class="breadcrumb-item active">Sessão {{ $sessao->numero_sessao }}/{{ $sessao->legislatura }}</li>
        </ol>
    </nav>

    <div class="container">
        <!-- Cabeçalho da Sessão -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h1 class="h2 mb-3">
                                    Sessão {{ $sessao->numero_sessao }}/{{ $sessao->legislatura }}
                                    <span class="badge bg-{{ 
                                        $sessao->tipo === 'ordinaria' ? 'primary' : 
                                        ($sessao->tipo === 'extraordinaria' ? 'warning' : 'info') 
                                    }} ms-2">
                                        {{ ucfirst($sessao->tipo) }}
                                    </span>
                                </h1>
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Data</small>
                                                <strong>{{ $sessao->data_sessao ? \Carbon\Carbon::parse($sessao->data_sessao)->format('d/m/Y') : '-' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Horário</small>
                                                <strong>
                                                    @if($sessao->hora_inicio)
                                                        {{ \Carbon\Carbon::parse($sessao->hora_inicio)->format('H:i') }}
                                                        @if($sessao->hora_fim)
                                                            - {{ \Carbon\Carbon::parse($sessao->hora_fim)->format('H:i') }}
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Local</small>
                                                <strong>{{ $sessao->local ?? 'Plenário' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <span class="badge bg-{{ 
                                        $sessao->status === 'agendada' ? 'secondary' : 
                                        ($sessao->status === 'em_andamento' ? 'warning' : 
                                        ($sessao->status === 'finalizada' ? 'success' : 'danger')) 
                                    }} fs-6">
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
                            <div class="col-lg-4 text-end">
                                @if($sessao->transmissao_online && $sessao->status === 'em_andamento')
                                    <a href="{{ $sessao->transmissao_online }}" target="_blank" 
                                       class="btn btn-danger btn-lg mb-2 d-block">
                                        <i class="fas fa-play me-2"></i>Assistir Ao Vivo
                                    </a>
                                @endif
                                
                                <div class="btn-group d-block" role="group">
                                    @if($sessao->ata)
                                        <a href="{{ route('sessoes.download-ata', $sessao) }}" 
                                           class="btn btn-outline-info">
                                            <i class="fas fa-file-pdf me-1"></i>Baixar Ata
                                        </a>
                                    @endif
                                    @if($sessao->pauta)
                                        <a href="{{ route('sessoes.download-pauta', $sessao) }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="fas fa-file-alt me-1"></i>Baixar Pauta
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de Vídeo Gravado -->
        @if($sessao->video_disponivel && $sessao->video_url)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-video me-2"></i>
                            Vídeo da Sessão
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @include('components.video-player', [
                            'videoUrl' => $sessao->video_url,
                            'plataforma' => $sessao->plataforma_video,
                            'titulo' => 'Sessão ' . $sessao->numero_sessao . ' - ' . $sessao->tipo,
                            'descricao' => $sessao->descricao_video,
                            'duracao' => $sessao->duracao_video,
                            'dataGravacao' => $sessao->data_gravacao,
                            'thumbnailUrl' => $sessao->thumbnail_url
                        ])
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <!-- Coluna Principal -->
            <div class="col-lg-8">
                <!-- Pauta da Sessão -->
                @if($sessao->pauta)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-list-ul text-primary me-2"></i>
                            Pauta da Sessão
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="content-text">
                            {!! nl2br(e(is_string($sessao->pauta) ? $sessao->pauta : json_encode($sessao->pauta))) !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Ata da Sessão -->
                @if($sessao->ata && $sessao->status === 'finalizada')
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt text-primary me-2"></i>
                            Ata da Sessão
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="content-text">
                            {!! nl2br(e(is_string($sessao->ata) ? $sessao->ata : json_encode($sessao->ata))) !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Projetos de Lei -->
                @if($sessao->projetosLei && $sessao->projetosLei->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-balance-scale text-primary me-2"></i>
                            Projetos de Lei em Pauta
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($sessao->projetosLei as $projeto)
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $projeto->numero }}/{{ $projeto->ano }}</h6>
                                        <p class="mb-1">{{ $projeto->ementa }}</p>
                                        <small class="text-muted">
                                            Autor: {{ $projeto->autor }}
                                            @if($projeto->data_apresentacao)
                                                | Apresentado em {{ \Carbon\Carbon::parse($projeto->data_apresentacao)->format('d/m/Y') }}
                                            @endif
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ 
                                        $projeto->status === 'aprovado' ? 'success' : 
                                        ($projeto->status === 'rejeitado' ? 'danger' : 'warning') 
                                    }}">
                                        {{ ucfirst($projeto->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Observações -->
                @if($sessao->observacoes)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note text-primary me-2"></i>
                            Observações
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="content-text">
                            {!! nl2br(e($sessao->observacoes)) !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Mesa Diretora -->
                @if($sessao->presidente || $sessao->secretario)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-users text-primary me-2"></i>
                            Mesa Diretora
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($sessao->presidente)
                        <div class="mb-3">
                            <small class="text-muted d-block">Presidente</small>
                            <strong>{{ $sessao->presidente->nome }}</strong>
                        </div>
                        @endif
                        @if($sessao->secretario)
                        <div class="mb-0">
                            <small class="text-muted d-block">Secretário</small>
                            <strong>{{ $sessao->secretario->nome }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Vereadores Presentes -->
                @if($sessao->vereadoresPresentes && $sessao->vereadoresPresentes->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-user-check text-primary me-2"></i>
                            Vereadores Presentes
                            <span class="badge bg-primary ms-2">{{ $sessao->vereadoresPresentes->count() }}</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($sessao->vereadoresPresentes as $vereador)
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                        {{ substr($vereador->nome, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $vereador->nome }}</div>
                                        @if($vereador->partido)
                                            <small class="text-muted">{{ $vereador->partido }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Informações Adicionais -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informações
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <small class="text-muted d-block">Legislatura</small>
                                <strong>{{ $sessao->legislatura }}ª Legislatura</strong>
                            </div>
                            @if($sessao->sessao_legislativa)
                            <div class="col-12">
                                <small class="text-muted d-block">Sessão Legislativa</small>
                                <strong>{{ $sessao->sessao_legislativa }}ª Sessão</strong>
                            </div>
                            @endif
                            <div class="col-12">
                                <small class="text-muted d-block">Criado em</small>
                                <strong>{{ $sessao->created_at ? $sessao->created_at->format('d/m/Y H:i') : '-' }}</strong>
                            </div>
                            @if($sessao->updated_at && $sessao->updated_at != $sessao->created_at)
                            <div class="col-12">
                                <small class="text-muted d-block">Atualizado em</small>
                                <strong>{{ $sessao->updated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <a href="{{ route('sessoes.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar às Sessões
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 16px;
    font-weight: 600;
}

.content-text {
    line-height: 1.6;
    font-size: 1rem;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.badge {
    font-size: 0.75em;
}

.list-group-item:last-child {
    border-bottom: none !important;
}

@media (max-width: 768px) {
    .btn-group.d-block .btn {
        display: block !important;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .btn-group.d-block .btn:last-child {
        margin-bottom: 0;
    }
}
</style>
@endpush