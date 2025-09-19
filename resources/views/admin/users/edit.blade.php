@extends('layouts.admin')

@section('page-title', 'Editar Usuário')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuários</a></li>
        <li class="breadcrumb-item active">Editar: {{ $user->name }}</li>
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
                    <h1 class="h3 mb-0">Editar Usuário</h1>
                    <p class="text-muted">Atualize as informações de {{ $user->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info me-2">
                        <i class="fas fa-eye me-2"></i>Visualizar
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" id="userForm">
                @csrf
                @method('PUT')

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
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
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
                                           id="cpf" name="cpf" value="{{ old('cpf', $user->cpf) }}" 
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
                                           id="telefone" name="telefone" value="{{ old('telefone', $user->telefone) }}" 
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
                                           id="cargo" name="cargo" value="{{ old('cargo', $user->cargo) }}" 
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
                                           id="setor" name="setor" value="{{ old('setor', $user->setor) }}" 
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
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Deixe em branco para manter a senha atual. Mínimo de 8 caracteres.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Tipo de Usuário <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" 
                                            id="role" name="role" required
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <option value="">Selecione o tipo</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                            Administrador
                                        </option>
                                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                            Usuário
                                        </option>
                                    </select>
                                    @if($user->id === auth()->id())
                                        <input type="hidden" name="role" value="{{ $user->role }}">
                                        <div class="form-text text-warning">Você não pode alterar seu próprio tipo de usuário</div>
                                    @endif
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
                                               {{ old('active', $user->active) ? 'checked' : '' }}
                                               {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Usuário Ativo
                                        </label>
                                    </div>
                                    @if($user->id === auth()->id())
                                        <input type="hidden" name="active" value="1">
                                        <div class="form-text text-warning">Você não pode desativar seu próprio usuário</div>
                                    @else
                                        <div class="form-text">Usuários inativos não podem fazer login</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Informações de último acesso -->
                        <div class="alert alert-light">
                            <h6><i class="fas fa-info-circle me-2"></i>Informações de Acesso:</h6>
                            <ul class="mb-0">
                                <li><strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
                                <li><strong>Último login:</strong> 
                                    @if($user->last_login_at)
                                        {{ $user->last_login_at->format('d/m/Y H:i') }}
                                    @else
                                        Nunca fez login
                                    @endif
                                </li>
                                <li><strong>Email verificado:</strong> 
                                    @if($user->email_verified_at)
                                        <span class="text-success">Sim ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                                    @else
                                        <span class="text-warning">Não verificado</span>
                                    @endif
                                </li>
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
                                      placeholder="Informações adicionais sobre o usuário...">{{ old('observacoes', $user->observacoes) }}</textarea>
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
                            <div>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                @if($user->id !== auth()->id())
                                    <a href="{{ route('admin.users.reset-password', $user) }}" 
                                       class="btn btn-warning ms-2" 
                                       onclick="return confirm('Tem certeza que deseja resetar a senha deste usuário?')">
                                        <i class="fas fa-key me-2"></i>Resetar Senha
                                    </a>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Alterações
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

.alert-light {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-text {
    font-size: 0.875em;
    color: #6c757d;
}

.form-text.text-warning {
    color: #856404 !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de senha
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Máscara para CPF
    const cpfField = document.getElementById('cpf');
    cpfField.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = value;
    });

    // Máscara para telefone
    const telefoneField = document.getElementById('telefone');
    telefoneField.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length <= 10) {
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
        }
        this.value = value;
    });

    // Contador de caracteres para observações
    const observacoesField = document.getElementById('observacoes');
    const observacoesCount = document.getElementById('observacoesCount');
    
    function updateObservacoesCount() {
        const count = observacoesField.value.length;
        observacoesCount.textContent = count;
        
        if (count > 1000) {
            observacoesCount.style.color = '#dc3545';
        } else {
            observacoesCount.style.color = '#6c757d';
        }
    }
    
    observacoesField.addEventListener('input', updateObservacoesCount);
    updateObservacoesCount(); // Inicializar

    // Validação de confirmação de senha
    const passwordConfirmation = document.getElementById('password_confirmation');
    const password = document.getElementById('password');
    
    function validatePasswordConfirmation() {
        if (passwordConfirmation.value && password.value !== passwordConfirmation.value) {
            passwordConfirmation.setCustomValidity('As senhas não coincidem');
        } else {
            passwordConfirmation.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePasswordConfirmation);
    passwordConfirmation.addEventListener('input', validatePasswordConfirmation);

    // Validação do formulário
    document.getElementById('userForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]:not([disabled])');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
        }
    });
});
</script>
@endpush