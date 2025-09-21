@extends('layouts.admin')

@section('page-title', 'Novo Usuário')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuários</a></li>
        <li class="breadcrumb-item active">Novo Usuário</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Novo Usuário</h1>
                    <p class="text-muted">Cadastre um novo usuário no sistema</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
                @csrf

                <!-- Dados Básicos -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Dados Básicos</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" name="cpf" value="{{ old('cpf') }}" 
                                           placeholder="000.000.000-00">
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                           id="telefone" name="telefone" value="{{ old('telefone') }}" 
                                           placeholder="(00) 00000-0000">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados Profissionais -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Dados Profissionais</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cargo" class="form-label">Cargo</label>
                                    <input type="text" class="form-control @error('cargo') is-invalid @enderror" 
                                           id="cargo" name="cargo" value="{{ old('cargo') }}" 
                                           placeholder="Ex: Secretário, Assessor...">
                                    @error('cargo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="setor" class="form-label">Setor</label>
                                    <input type="text" class="form-control @error('setor') is-invalid @enderror" 
                                           id="setor" name="setor" value="{{ old('setor') }}" 
                                           placeholder="Ex: Secretaria, Gabinete...">
                                    @error('setor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acesso e Permissões -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-key me-2"></i>Acesso e Permissões</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" required>
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Mínimo de 8 caracteres</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Senha <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Tipo de Usuário <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" 
                                            id="role" name="role" required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                            Administrador
                                        </option>
                                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>
                                            Usuário
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" 
                                               id="active" name="active" value="1" 
                                               {{ old('active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Usuário Ativo
                                        </label>
                                    </div>
                                    <div class="form-text">Usuários inativos não podem fazer login</div>
                                </div>
                            </div>
                        </div>

                        <!-- Descrição dos tipos de usuário -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Tipos de Usuário:</h6>
                            <ul class="mb-0">
                                <li><strong>Administrador:</strong> Acesso total ao sistema, pode gerenciar usuários, conteúdo e configurações</li>
                                <li><strong>Usuário:</strong> Acesso limitado, pode visualizar e editar conteúdo básico</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações Internas</label>
                            <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" name="observacoes" rows="3" 
                                      placeholder="Informações adicionais sobre o usuário...">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <span id="observacoesCount">0</span>/1000 caracteres
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Usuário
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-label {
    font-weight: 600;
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}

.input-group .btn {
    border-color: #ced4da;
}

.alert-info {
    background-color: #e7f3ff;
    border-color: #b8daff;
    color: #004085;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-text {
    font-size: 0.875em;
    color: #6c757d;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/users.js') }}"></script>
@endpush