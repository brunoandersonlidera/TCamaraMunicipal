@extends('layouts.admin')

@section('title', ($usuario->exists ? 'Editar' : 'Novo') . ' Usuário E-SIC - Câmara Municipal')
@section('page-title', ($usuario->exists ? 'Editar' : 'Novo') . ' Usuário E-SIC')

@section('breadcrumb')
    <li class="breadcrumb-item">Transparência</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.esic-usuarios.index') }}">Usuários E-SIC</a></li>
    <li class="breadcrumb-item active">{{ $usuario->exists ? 'Editar' : 'Novo' }}</li>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
@endpush

@section('content')

<form action="{{ $usuario->exists ? route('admin.esic-usuarios.update', $usuario) : route('admin.esic-usuarios.store') }}" 
      method="POST" id="userForm" novalidate>
    @csrf
    @if($usuario->exists)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Formulário Principal -->
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="card-body">
                    <!-- Dados Pessoais -->
                    <div class="section-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Dados Pessoais
                        </h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" name="nome" placeholder="Nome completo" 
                                       value="{{ old('nome', $usuario->nome) }}" required>
                                <label for="nome" class="required-field">Nome Completo</label>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                       id="cpf" name="cpf" placeholder="CPF" 
                                       value="{{ old('cpf', $usuario->cpf) }}" required>
                                <label for="cpf" class="required-field">CPF</label>
                                @error('cpf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" placeholder="E-mail" 
                                       value="{{ old('email', $usuario->email) }}" required>
                                <label for="email" class="required-field">E-mail</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control @error('telefone') is-invalid @enderror" 
                                       id="telefone" name="telefone" placeholder="Telefone" 
                                       value="{{ old('telefone', $usuario->telefone) }}">
                                <label for="telefone">Telefone</label>
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="section-header mt-4">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>Endereço
                        </h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                                       id="cep" name="cep" placeholder="CEP" 
                                       value="{{ old('cep', $usuario->cep) }}">
                                <label for="cep">CEP</label>
                                @error('cep')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('endereco') is-invalid @enderror" 
                                       id="endereco" name="endereco" placeholder="Endereço" 
                                       value="{{ old('endereco', $usuario->endereco) }}">
                                <label for="endereco">Endereço</label>
                                @error('endereco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                       id="numero" name="numero" placeholder="Número" 
                                       value="{{ old('numero', $usuario->numero) }}">
                                <label for="numero">Número</label>
                                @error('numero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('complemento') is-invalid @enderror" 
                                       id="complemento" name="complemento" placeholder="Complemento" 
                                       value="{{ old('complemento', $usuario->complemento) }}">
                                <label for="complemento">Complemento</label>
                                @error('complemento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('bairro') is-invalid @enderror" 
                                       id="bairro" name="bairro" placeholder="Bairro" 
                                       value="{{ old('bairro', $usuario->bairro) }}">
                                <label for="bairro">Bairro</label>
                                @error('bairro')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                       id="cidade" name="cidade" placeholder="Cidade" 
                                       value="{{ old('cidade', $usuario->cidade) }}">
                                <label for="cidade">Cidade</label>
                                @error('cidade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Senha (apenas para novo usuário) -->
                    @if(!$usuario->exists)
                    <div class="section-header mt-4">
                        <h5 class="mb-0">
                            <i class="fas fa-lock me-2"></i>Senha de Acesso
                        </h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Senha" required>
                                <label for="password" class="required-field">Senha</label>
                                <div class="password-strength" id="passwordStrength"></div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" placeholder="Confirmar Senha" required>
                                <label for="password_confirmation" class="required-field">Confirmar Senha</label>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status e Configurações -->
            <div class="card form-card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-cog me-2"></i>Configurações
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1"
                                   {{ old('ativo', $usuario->ativo ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo">
                                Usuário Ativo
                            </label>
                        </div>
                        <small class="text-muted">Usuários inativos não podem fazer login no sistema</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="email_verificado" name="email_verificado" value="1"
                                   {{ old('email_verificado', $usuario->email_verified_at) ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_verificado">
                                E-mail Verificado
                            </label>
                        </div>
                        <small class="text-muted">Marque se o e-mail já foi verificado</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notificacoes_email" name="notificacoes_email" value="1"
                                   {{ old('notificacoes_email', $usuario->notificacoes_email ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notificacoes_email">
                                Receber Notificações por E-mail
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações Adicionais -->
            @if($usuario->exists)
            <div class="card form-card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Informações
                    </h5>

                    <div class="mb-2">
                        <small class="text-muted">Cadastrado em:</small>
                        <div>{{ $usuario->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if($usuario->ultimo_acesso)
                    <div class="mb-2">
                        <small class="text-muted">Último acesso:</small>
                        <div>{{ $usuario->ultimo_acesso->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif

                    <div class="mb-2">
                        <small class="text-muted">Total de solicitações:</small>
                        <div>{{ $usuario->solicitacoes_count ?? 0 }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Ações -->
            <div class="card form-card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            {{ $usuario->exists ? 'Atualizar' : 'Cadastrar' }} Usuário
                        </button>
                        
                        <a href="{{ route('admin.esic-usuarios.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </a>

                        @if($usuario->exists)
                        <hr>
                        <button type="button" class="btn btn-outline-warning" 
                                data-action="reset-password" 
                                data-route="{{ route('admin.esic-usuarios.reset-password', $usuario) }}">
                            <i class="fas fa-key me-2"></i>Redefinir Senha
                        </button>
                        
                        <button type="button" class="btn btn-outline-danger" 
                                data-action="delete-user" 
                                data-route="{{ route('admin.esic-usuarios.destroy', $usuario) }}">
                            <i class="fas fa-trash me-2"></i>Excluir Usuário
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="{{ asset('js/esic-usuarios-form.js') }}"></script>
@endpush