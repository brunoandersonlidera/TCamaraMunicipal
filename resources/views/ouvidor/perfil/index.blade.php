@extends('layouts.ouvidor')

@section('title', 'Meu Perfil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Meu Perfil</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('ouvidor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>
                        Informações Pessoais
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('ouvidor.perfil.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" 
                                           class="form-control @error('telefone') is-invalid @enderror" 
                                           id="telefone" 
                                           name="telefone" 
                                           value="{{ old('telefone', $user->telefone) }}"
                                           placeholder="(00) 00000-0000">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cargo" class="form-label">Cargo</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="cargo" 
                                           value="{{ $user->cargo }}" 
                                           readonly>
                                    <div class="form-text">Este campo é gerenciado pelo administrador</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">
                            <i class="fas fa-lock me-2"></i>
                            Alterar Senha
                        </h6>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Senha Atual</label>
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informações da Conta
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Usuário</label>
                        <div class="badge bg-primary fs-6">Ouvidor</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status da Conta</label>
                        <div class="badge bg-{{ $user->active ? 'success' : 'danger' }} fs-6">
                            {{ $user->active ? 'Ativa' : 'Inativa' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Último Login</label>
                        <p class="mb-0">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Membro desde</label>
                        <p class="mb-0">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>

                    @if($user->especialidade)
                        <div class="mb-3">
                            <label class="form-label">Especialidade</label>
                            <p class="mb-0">{{ $user->especialidade }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Permissões
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <i class="fas fa-{{ $user->pode_gerenciar_ouvidoria ? 'check text-success' : 'times text-danger' }} me-2"></i>
                        Gerenciar Ouvidoria
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-{{ $user->pode_responder_manifestacoes ? 'check text-success' : 'times text-danger' }} me-2"></i>
                        Responder Manifestações
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-{{ $user->pode_gerenciar_esic ? 'check text-success' : 'times text-danger' }} me-2"></i>
                        Gerenciar e-SIC
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-{{ $user->pode_visualizar_relatorios ? 'check text-success' : 'times text-danger' }} me-2"></i>
                        Visualizar Relatórios
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                if (value.length < 14) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
            }
            e.target.value = value;
        });
    }
});
</script>
@endsection