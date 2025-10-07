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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" 
                                           id="data_nascimento" name="data_nascimento" 
                                           value="{{ old('data_nascimento', $user->data_nascimento ? $user->data_nascimento->format('Y-m-d') : '') }}">
                                    @error('data_nascimento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control @error('endereco') is-invalid @enderror" 
                                           id="endereco" name="endereco" value="{{ old('endereco', $user->endereco) }}" 
                                           placeholder="Rua, Avenida, etc.">
                                    @error('endereco')
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

                <!-- Dados do Cidadão -->
                <div class="admin-card mb-4" id="cidadaoSection" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Dados do Cidadão</h5>
                    </div>
                    <div class="card-body">
                        <!-- Dados Pessoais -->
                        <h6 class="mb-3"><i class="fas fa-user me-2"></i>Dados Pessoais</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome_completo" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control @error('nome_completo') is-invalid @enderror" 
                                           id="nome_completo" name="nome_completo" 
                                           value="{{ old('nome_completo', $user->nome_completo ?? '') }}">
                                    @error('nome_completo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rg" class="form-label">RG</label>
                                    <input type="text" class="form-control @error('rg') is-invalid @enderror" 
                                           id="rg" name="rg" value="{{ old('rg', $user->rg ?? '') }}">
                                    @error('rg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <select class="form-select @error('sexo') is-invalid @enderror" id="sexo" name="sexo">
                                        <option value="">Selecione</option>
                                        <option value="M" {{ old('sexo', $user->sexo ?? '') === 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ old('sexo', $user->sexo ?? '') === 'F' ? 'selected' : '' }}>Feminino</option>
                                        <option value="Outro" {{ old('sexo', $user->sexo ?? '') === 'Outro' ? 'selected' : '' }}>Outro</option>
                                    </select>
                                    @error('sexo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="estado_civil" class="form-label">Estado Civil</label>
                                    <select class="form-select @error('estado_civil') is-invalid @enderror" id="estado_civil" name="estado_civil">
                                        <option value="">Selecione</option>
                                        <option value="Solteiro(a)" {{ old('estado_civil', $user->estado_civil ?? '') === 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                        <option value="Casado(a)" {{ old('estado_civil', $user->estado_civil ?? '') === 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="Divorciado(a)" {{ old('estado_civil', $user->estado_civil ?? '') === 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                        <option value="Viúvo(a)" {{ old('estado_civil', $user->estado_civil ?? '') === 'Viúvo(a)' ? 'selected' : '' }}>Viúvo(a)</option>
                                        <option value="União Estável" {{ old('estado_civil', $user->estado_civil ?? '') === 'União Estável' ? 'selected' : '' }}>União Estável</option>
                                    </select>
                                    @error('estado_civil')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="profissao" class="form-label">Profissão</label>
                                    <input type="text" class="form-control @error('profissao') is-invalid @enderror" 
                                           id="profissao" name="profissao" value="{{ old('profissao', $user->profissao ?? '') }}">
                                    @error('profissao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contatos -->
                        <hr>
                        <h6 class="mb-3"><i class="fas fa-phone me-2"></i>Contatos</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone_cidadao" class="form-label">Telefone Fixo</label>
                                    <input type="text" class="form-control @error('telefone_cidadao') is-invalid @enderror" 
                                           id="telefone_cidadao" name="telefone_cidadao" 
                                           value="{{ old('telefone_cidadao', $user->telefone ?? '') }}"
                                           placeholder="(00) 0000-0000">
                                    @error('telefone_cidadao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="celular" class="form-label">Celular</label>
                                    <input type="text" class="form-control @error('celular') is-invalid @enderror" 
                                           id="celular" name="celular" value="{{ old('celular', $user->celular ?? '') }}"
                                           placeholder="(00) 00000-0000">
                                    @error('celular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Endereço Completo -->
                        <hr>
                        <h6 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Endereço Completo</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                                           id="cep" name="cep" value="{{ old('cep', $user->cep ?? '') }}"
                                           placeholder="00000-000">
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endereco_cidadao" class="form-label">Endereço</label>
                                    <input type="text" class="form-control @error('endereco_cidadao') is-invalid @enderror" 
                                           id="endereco_cidadao" name="endereco_cidadao" 
                                           value="{{ old('endereco_cidadao', $user->endereco ?? '') }}"
                                           placeholder="Rua, Avenida, etc.">
                                    @error('endereco_cidadao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                           id="numero" name="numero" value="{{ old('numero', $user->numero ?? '') }}">
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text" class="form-control @error('complemento') is-invalid @enderror" 
                                           id="complemento" name="complemento" value="{{ old('complemento', $user->complemento ?? '') }}"
                                           placeholder="Apto, Bloco, etc.">
                                    @error('complemento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control @error('bairro') is-invalid @enderror" 
                                           id="bairro" name="bairro" value="{{ old('bairro', $user->bairro ?? '') }}">
                                    @error('bairro')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                           id="cidade" name="cidade" value="{{ old('cidade', $user->cidade ?? '') }}">
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado">
                                        <option value="">Selecione o Estado</option>
                                        <option value="AC" {{ old('estado', $user->estado ?? '') === 'AC' ? 'selected' : '' }}>Acre</option>
                                        <option value="AL" {{ old('estado', $user->estado ?? '') === 'AL' ? 'selected' : '' }}>Alagoas</option>
                                        <option value="AP" {{ old('estado', $user->estado ?? '') === 'AP' ? 'selected' : '' }}>Amapá</option>
                                        <option value="AM" {{ old('estado', $user->estado ?? '') === 'AM' ? 'selected' : '' }}>Amazonas</option>
                                        <option value="BA" {{ old('estado', $user->estado ?? '') === 'BA' ? 'selected' : '' }}>Bahia</option>
                                        <option value="CE" {{ old('estado', $user->estado ?? '') === 'CE' ? 'selected' : '' }}>Ceará</option>
                                        <option value="DF" {{ old('estado', $user->estado ?? '') === 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                        <option value="ES" {{ old('estado', $user->estado ?? '') === 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                        <option value="GO" {{ old('estado', $user->estado ?? '') === 'GO' ? 'selected' : '' }}>Goiás</option>
                                        <option value="MA" {{ old('estado', $user->estado ?? '') === 'MA' ? 'selected' : '' }}>Maranhão</option>
                                        <option value="MT" {{ old('estado', $user->estado ?? '') === 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                        <option value="MS" {{ old('estado', $user->estado ?? '') === 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                        <option value="MG" {{ old('estado', $user->estado ?? '') === 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                        <option value="PA" {{ old('estado', $user->estado ?? '') === 'PA' ? 'selected' : '' }}>Pará</option>
                                        <option value="PB" {{ old('estado', $user->estado ?? '') === 'PB' ? 'selected' : '' }}>Paraíba</option>
                                        <option value="PR" {{ old('estado', $user->estado ?? '') === 'PR' ? 'selected' : '' }}>Paraná</option>
                                        <option value="PE" {{ old('estado', $user->estado ?? '') === 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                        <option value="PI" {{ old('estado', $user->estado ?? '') === 'PI' ? 'selected' : '' }}>Piauí</option>
                                        <option value="RJ" {{ old('estado', $user->estado ?? '') === 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                        <option value="RN" {{ old('estado', $user->estado ?? '') === 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                        <option value="RS" {{ old('estado', $user->estado ?? '') === 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                        <option value="RO" {{ old('estado', $user->estado ?? '') === 'RO' ? 'selected' : '' }}>Rondônia</option>
                                        <option value="RR" {{ old('estado', $user->estado ?? '') === 'RR' ? 'selected' : '' }}>Roraima</option>
                                        <option value="SC" {{ old('estado', $user->estado ?? '') === 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                        <option value="SP" {{ old('estado', $user->estado ?? '') === 'SP' ? 'selected' : '' }}>São Paulo</option>
                                        <option value="SE" {{ old('estado', $user->estado ?? '') === 'SE' ? 'selected' : '' }}>Sergipe</option>
                                        <option value="TO" {{ old('estado', $user->estado ?? '') === 'TO' ? 'selected' : '' }}>Tocantins</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Dados Eleitorais -->
                        <hr>
                        <h6 class="mb-3"><i class="fas fa-vote-yea me-2"></i>Dados Eleitorais</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="titulo_eleitor" class="form-label">Título de Eleitor</label>
                                    <input type="text" class="form-control @error('titulo_eleitor') is-invalid @enderror" 
                                           id="titulo_eleitor" name="titulo_eleitor" 
                                           value="{{ old('titulo_eleitor', $user->titulo_eleitor ?? '') }}">
                                    @error('titulo_eleitor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="zona_eleitoral" class="form-label">Zona Eleitoral</label>
                                    <input type="text" class="form-control @error('zona_eleitoral') is-invalid @enderror" 
                                           id="zona_eleitoral" name="zona_eleitoral" 
                                           value="{{ old('zona_eleitoral', $user->zona_eleitoral ?? '') }}">
                                    @error('zona_eleitoral')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="secao_eleitoral" class="form-label">Seção Eleitoral</label>
                                    <input type="text" class="form-control @error('secao_eleitoral') is-invalid @enderror" 
                                           id="secao_eleitoral" name="secao_eleitoral" 
                                           value="{{ old('secao_eleitoral', $user->secao_eleitoral ?? '') }}">
                                    @error('secao_eleitoral')
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
                                        @foreach($roles as $role)
                                            @php
                                                $currentUserRole = $user->roles->first()?->name ?? $user->role;
                                                $displayName = match($role->name) {
                                                    'admin' => 'Administrador',
                                                    'super-admin' => 'Super Administrador',
                                                    'secretario' => 'Secretário',
                                                    'responsavel_esic' => 'Responsável e-SIC',
                                                    'ouvidor' => 'Ouvidor',
                                                    'vereador' => 'Vereador',
                                                    'presidente' => 'Presidente',
                                                    'editor' => 'Editor',
                                                    'protocolo' => 'Protocolo',
                                                    'contador' => 'Contador',
                                                    'cidadao' => 'Cidadão',
                                                    default => ucfirst(str_replace(['_', '-'], ' ', $role->name))
                                                };
                                            @endphp
                                            <option value="{{ $role->name }}" 
                                                {{ old('role', $currentUserRole) === $role->name ? 'selected' : '' }}>
                                                {{ $displayName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($user->id === auth()->id())
                                        <input type="hidden" name="role" value="{{ $user->roles->first()?->name ?? $user->role }}">
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
                                       data-confirm="Tem certeza que deseja resetar a senha deste usuário?">
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
<script src="{{ asset('js/users.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const cidadaoSection = document.getElementById('cidadaoSection');
    
    function toggleCidadaoSection() {
        if (roleSelect.value === 'cidadao') {
            cidadaoSection.style.display = 'block';
        } else {
            cidadaoSection.style.display = 'none';
        }
    }
    
    // Verificar role inicial
    toggleCidadaoSection();
    
    // Escutar mudanças na role
    roleSelect.addEventListener('change', toggleCidadaoSection);
    
    // Contador de caracteres para observações
    const observacoesTextarea = document.getElementById('observacoes');
    const observacoesCount = document.getElementById('observacoesCount');
    
    if (observacoesTextarea && observacoesCount) {
        function updateCount() {
            const count = observacoesTextarea.value.length;
            observacoesCount.textContent = count;
            
            if (count > 1000) {
                observacoesCount.style.color = '#dc3545';
            } else if (count > 800) {
                observacoesCount.style.color = '#ffc107';
            } else {
                observacoesCount.style.color = '#6c757d';
            }
        }
        
        updateCount();
        observacoesTextarea.addEventListener('input', updateCount);
    }
    
    // Toggle de senha
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endpush
