@extends('layouts.admin')

@section('page-title', 'Visualizar Vereador')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.vereadores.index') }}">Vereadores</a></li>
        <li class="breadcrumb-item active">{{ $vereador->nome_parlamentar }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">{{ $vereador->nome_parlamentar }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.vereadores.edit', $vereador) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Editar
        </a>
        <form action="{{ route('admin.vereadores.toggle-status', $vereador) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-{{ $vereador->status === 'ativo' ? 'warning' : 'success' }}">
                <i class="fas fa-{{ $vereador->status === 'ativo' ? 'pause' : 'play' }}"></i>
                {{ $vereador->status === 'ativo' ? 'Desativar' : 'Ativar' }}
            </button>
        </form>
        <a href="{{ route('admin.vereadores.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <!-- Coluna Principal -->
    <div class="col-lg-8">
        <!-- Dados Básicos -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user"></i> Dados Básicos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome Completo:</label>
                            <p class="mb-0">{{ $vereador->nome }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome Parlamentar:</label>
                            <p class="mb-0">{{ $vereador->nome_parlamentar }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Partido:</label>
                            <p class="mb-0">
                                <span class="badge bg-info fs-6">{{ $vereador->partido }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status:</label>
                            <p class="mb-0">
                                <span class="badge {{ $vereador->status === 'ativo' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ ucfirst($vereador->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Data de Nascimento:</label>
                            <p class="mb-0">
                                {{ $vereador->data_nascimento ? $vereador->data_nascimento->format('d/m/Y') : 'Não informado' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail:</label>
                            <p class="mb-0">
                                @if($vereador->email)
                                    <a href="mailto:{{ $vereador->email }}">{{ $vereador->email }}</a>
                                @else
                                    <span class="text-muted">Não informado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Telefone:</label>
                            <p class="mb-0">
                                @if($vereador->telefone)
                                    <a href="tel:{{ $vereador->telefone }}">{{ $vereador->telefone }}</a>
                                @else
                                    <span class="text-muted">Não informado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dados Profissionais -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-briefcase"></i> Dados Profissionais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Profissão:</label>
                            <p class="mb-0">{{ $vereador->profissao ?: 'Não informado' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Escolaridade:</label>
                            <p class="mb-0">{{ $vereador->escolaridade ?: 'Não informado' }}</p>
                        </div>
                    </div>
                </div>
                
                @if($vereador->endereco)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Endereço:</label>
                        <p class="mb-0">{{ $vereador->endereco }}</p>
                    </div>
                @endif
                
                @if($vereador->biografia)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Biografia:</label>
                        <p class="mb-0">{{ $vereador->biografia }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Mandato -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar"></i> Informações do Mandato</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Início do Mandato:</label>
                            <p class="mb-0">
                                {{ $vereador->inicio_mandato ? $vereador->inicio_mandato->format('d/m/Y') : 'Não informado' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Fim do Mandato:</label>
                            <p class="mb-0">
                                {{ $vereador->fim_mandato ? $vereador->fim_mandato->format('d/m/Y') : 'Não informado' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Legislatura:</label>
                            <p class="mb-0">{{ $vereador->legislatura ?: 'Não informado' }}</p>
                        </div>
                    </div>
                </div>
                
                @php
                    $comissoes = $vereador->comissoes;
                    if (is_string($comissoes)) {
                        $comissoes = json_decode($comissoes, true) ?? [];
                    } elseif (!is_array($comissoes)) {
                        $comissoes = [];
                    }
                @endphp
                @if($comissoes && count($comissoes) > 0)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Comissões:</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($comissoes as $comissao)
                                <span class="badge bg-secondary">{{ $comissao }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Redes Sociais -->
        @php
            $redes_sociais = $vereador->redes_sociais;
            // Garantir que seja sempre um array
            if (is_string($redes_sociais)) {
                $redes_sociais = json_decode($redes_sociais, true) ?? [];
            } elseif (!is_array($redes_sociais)) {
                $redes_sociais = [];
            }
        @endphp
        @if($redes_sociais && count(array_filter($redes_sociais)) > 0)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-share-alt"></i> Redes Sociais</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        @if(!empty($redes_sociais['facebook']))
                            <a href="{{ $redes_sociais['facebook'] }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                        @endif
                        @if(!empty($redes_sociais['instagram']))
                            <a href="{{ $redes_sociais['instagram'] }}" target="_blank" class="btn btn-outline-danger">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                        @endif
                        @if(!empty($redes_sociais['twitter']))
                            <a href="{{ $redes_sociais['twitter'] }}" target="_blank" class="btn btn-outline-info">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        @endif
                        @if(!empty($redes_sociais['linkedin']))
                            <a href="{{ $redes_sociais['linkedin'] }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Observações -->
        @if($vereador->observacoes)
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Observações</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $vereador->observacoes }}</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Coluna Lateral -->
    <div class="col-lg-4">
        <!-- Foto -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-image"></i> Foto</h5>
            </div>
            <div class="card-body text-center">
                @if($vereador->foto)
                    <img src="{{ asset('storage/' . $vereador->foto) }}" 
                         alt="{{ $vereador->nome_parlamentar }}" 
                         class="img-fluid rounded">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                        <div class="text-center">
                            <i class="fas fa-user fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Sem foto</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Estatísticas -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Estatísticas</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary mb-0">{{ $vereador->projetos_apresentados ?? 0 }}</h4>
                            <small class="text-muted">Projetos</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-0">{{ $vereador->presencas_sessoes ?? 0 }}</h4>
                        <small class="text-muted">Presenças</small>
                    </div>
                </div>
                
                @if($vereador->votos_favoraveis || $vereador->votos_contrarios || $vereador->abstencoes)
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="text-success mb-0">{{ $vereador->votos_favoraveis ?? 0 }}</h6>
                                <small class="text-muted">Favoráveis</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h6 class="text-danger mb-0">{{ $vereador->votos_contrarios ?? 0 }}</h6>
                                <small class="text-muted">Contrários</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h6 class="text-warning mb-0">{{ $vereador->abstencoes ?? 0 }}</h6>
                            <small class="text-muted">Abstenções</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Ações -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Ações</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.vereadores.edit', $vereador) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar Dados
                    </a>
                    
                    <form action="{{ route('admin.vereadores.toggle-status', $vereador) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $vereador->status === 'ativo' ? 'warning' : 'success' }} w-100">
                            <i class="fas fa-{{ $vereador->status === 'ativo' ? 'pause' : 'play' }}"></i>
                            {{ $vereador->status === 'ativo' ? 'Desativar' : 'Ativar' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.vereadores.destroy', $vereador) }}" method="POST" 
                          onsubmit="return confirm('Tem certeza que deseja excluir este vereador? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection