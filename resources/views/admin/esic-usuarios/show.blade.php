@extends('layouts.admin')

@section('title', 'Visualizar Usuário E-SIC')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.esic-usuarios.index') }}">Usuários E-SIC</a></li>
        <li class="breadcrumb-item active">{{ $usuario->nome }}</li>
    </ol>
</nav>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
@endpush

@section('content')

<div class="container-fluid">
    <!-- Cabeçalho do Perfil -->
    <div class="user-profile-card">
        <div class="row align-items-center">
            <div class="col-md-3 text-center">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="mb-2">{{ $usuario->nome }}</h2>
                <p class="mb-2"><i class="fas fa-envelope me-2"></i>{{ $usuario->email }}</p>
                <p class="mb-0"><i class="fas fa-phone me-2"></i>{{ $usuario->telefone ?? 'Não informado' }}</p>
            </div>
            <div class="col-md-3 text-center">
                <span class="status-badge status-{{ $usuario->status }}">
                    {{ $usuario->status == 'ativo' ? 'Ativo' : 'Inativo' }}
                </span>
                <div class="mt-3">
                    <small class="text-light">Cadastrado em</small><br>
                    <strong>{{ $usuario->created_at->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informações Pessoais -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-user me-2"></i>Informações Pessoais</h5>
                
                <div class="info-row">
                    <span class="info-label">Nome Completo:</span>
                    <span class="info-value">{{ $usuario->nome }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">CPF:</span>
                    <span class="info-value">{{ $usuario->cpf ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">RG:</span>
                    <span class="info-value">{{ $usuario->rg ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Data de Nascimento:</span>
                    <span class="info-value">
                        {{ $usuario->data_nascimento ? $usuario->data_nascimento->format('d/m/Y') : 'Não informado' }}
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Profissão:</span>
                    <span class="info-value">{{ $usuario->profissao ?? 'Não informado' }}</span>
                </div>
            </div>
        </div>

        <!-- Informações de Contato -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-address-book me-2"></i>Informações de Contato</h5>
                
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $usuario->email }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Telefone:</span>
                    <span class="info-value">{{ $usuario->telefone ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">CEP:</span>
                    <span class="info-value">{{ $usuario->cep ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Endereço:</span>
                    <span class="info-value">{{ $usuario->endereco ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Cidade:</span>
                    <span class="info-value">{{ $usuario->cidade ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Estado:</span>
                    <span class="info-value">{{ $usuario->estado ?? 'Não informado' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informações do Sistema -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-cog me-2"></i>Informações do Sistema</h5>
                
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $usuario->status }}">
                            {{ $usuario->status == 'ativo' ? 'Ativo' : 'Inativo' }}
                        </span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Email Verificado:</span>
                    <span class="info-value">
                        @if($usuario->email_verified_at)
                            <i class="fas fa-check-circle text-success"></i> Verificado em {{ $usuario->email_verified_at->format('d/m/Y H:i') }}
                        @else
                            <i class="fas fa-times-circle text-danger"></i> Não verificado
                        @endif
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Cadastrado em:</span>
                    <span class="info-value">{{ $usuario->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Última Atualização:</span>
                    <span class="info-value">{{ $usuario->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Último Acesso:</span>
                    <span class="info-value">{{ $usuario->last_login_at ? $usuario->last_login_at->format('d/m/Y H:i') : 'Nunca acessou' }}</span>
                </div>
            </div>
        </div>

        <!-- Atividades Recentes -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-history me-2"></i>Atividades Recentes</h5>
                
                <div class="activity-timeline">
                    <div class="activity-item">
                        <div class="activity-date">{{ $usuario->updated_at->format('d/m/Y H:i') }}</div>
                        <div class="activity-description">Perfil atualizado</div>
                    </div>
                    
                    @if($usuario->last_login_at)
                    <div class="activity-item">
                        <div class="activity-date">{{ $usuario->last_login_at->format('d/m/Y H:i') }}</div>
                        <div class="activity-description">Último acesso ao sistema</div>
                    </div>
                    @endif
                    
                    @if($usuario->email_verified_at)
                    <div class="activity-item">
                        <div class="activity-date">{{ $usuario->email_verified_at->format('d/m/Y H:i') }}</div>
                        <div class="activity-description">Email verificado</div>
                    </div>
                    @endif
                    
                    <div class="activity-item">
                        <div class="activity-date">{{ $usuario->created_at->format('d/m/Y H:i') }}</div>
                        <div class="activity-description">Usuário cadastrado no sistema</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações -->
    <div class="row">
        <div class="col-12">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-tools me-2"></i>Ações</h5>
                
                <div class="action-buttons">
                    <a href="{{ route('admin.esic-usuarios.edit', $usuario) }}" class="btn-action btn-edit">
                        <i class="fas fa-edit me-2"></i>Editar Usuário
                    </a>
                    
                    <button type="button" class="btn-action btn-toggle" data-action="toggle-status" data-user-id="{{ $usuario->id }}">
                        <i class="fas fa-toggle-{{ $usuario->status == 'ativo' ? 'on' : 'off' }} me-2"></i>
                        {{ $usuario->status == 'ativo' ? 'Desativar' : 'Ativar' }}
                    </button>
                    
                    @if(!$usuario->email_verified_at)
                    <button type="button" class="btn-action btn-toggle" data-action="resend-verification" data-user-id="{{ $usuario->id }}">
                        <i class="fas fa-envelope me-2"></i>Reenviar Verificação
                    </button>
                    @endif
                    
                    <button type="button" class="btn-action btn-delete" data-action="delete-user" data-user-id="{{ $usuario->id }}">
                        <i class="fas fa-trash me-2"></i>Excluir Usuário
                    </button>
                    
                    <a href="{{ route('admin.esic-usuarios.index') }}" class="btn-action" style="background: #6c757d; color: white;">
                        <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/esic-usuarios.js') }}"></script>
@endpush
@endsection