@extends('layouts.app')

@section('title', 'Meu Perfil')

@push('styles')
<style>
    .profile-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .profile-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2.5rem;
    }
    
    .profile-body {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .section-subtitle {
        color: #495057;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    
    .section-subtitle i {
        margin-right: 0.5rem;
        color: #667eea;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .form-control[readonly] {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
    }
    
    .required-field {
        color: #dc3545;
    }
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    .password-section {
        border-top: 1px solid #e9ecef;
        margin-top: 2rem;
        padding-top: 2rem;
    }
    
    .section-title {
        color: #333;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }
    
    .info-text {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .password-requirements {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    
    .password-requirements ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    
    .password-requirements li {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="profile-page">
    <div class="profile-container">
        <div class="profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="mb-1">{{ auth()->user()->name }}</h2>
                <p class="mb-0 opacity-75">{{ auth()->user()->email }}</p>
            </div>

            <!-- Profile Body -->
            <div class="profile-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Erro:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Profile Form -->
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="section-title">
                        <i class="fas fa-user-edit"></i>
                        Informações Básicas do Usuário
                    </h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone" class="form-label">Telefone *</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', auth()->user()->celular ?? auth()->user()->phone) }}" 
                                       placeholder="(00) 00000-0000" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_date" class="form-label">Data de Nascimento *</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" 
                                       value="{{ old('birth_date', auth()->user()->data_nascimento ? auth()->user()->data_nascimento->format('Y-m-d') : (auth()->user()->birth_date ? auth()->user()->birth_date->format('Y-m-d') : '')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role" class="form-label">Tipo de Usuário</label>
                                <input type="text" class="form-control" id="role" name="role" 
                                       value="{{ ucfirst(auth()->user()->role) }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="cargo" name="cargo" 
                                       value="{{ old('cargo', auth()->user()->cargo) }}" 
                                       placeholder="Ex: Vereador, Secretário, etc.">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="setor" class="form-label">Setor/Departamento</label>
                                <input type="text" class="form-control" id="setor" name="setor" 
                                       value="{{ old('setor', auth()->user()->setor) }}" 
                                       placeholder="Ex: Gabinete, Secretaria, etc.">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Endereço *</label>
                        <textarea class="form-control" id="address" name="address" rows="2" 
                                  placeholder="Endereço completo" required>{{ old('address', auth()->user()->role === 'cidadao' && auth()->user()->endereco ? (auth()->user()->endereco . ', ' . auth()->user()->numero . (auth()->user()->complemento ? ', ' . auth()->user()->complemento : '') . ' - ' . auth()->user()->bairro . ', ' . auth()->user()->cidade . '/' . auth()->user()->estado . ' - CEP: ' . auth()->user()->cep) : auth()->user()->address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="2" 
                                  placeholder="Observações adicionais">{{ old('observacoes', auth()->user()->observacoes) }}</textarea>
                    </div>

                    @if(auth()->user()->role === 'cidadao')
                    <!-- Dados Específicos do Cidadão -->
                    <div class="section-divider">
                        <h3 class="section-title">
                            <i class="fas fa-id-card"></i>
                            Dados do Cidadão
                        </h3>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" 
                                       value="{{ old('cpf', auth()->user()->cpf_formatted ?? '') }}" 
                                       placeholder="000.000.000-00">
                                <small class="form-text text-muted">Digite o CPF no formato 000.000.000-00</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rg" class="form-label">RG</label>
                                <input type="text" class="form-control" id="rg" name="rg" 
                                       value="{{ old('rg', auth()->user()->rg ?? '') }}" 
                                       placeholder="00.000.000-0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-control" id="sexo" name="sexo">
                                    <option value="">Selecione</option>
                                    <option value="M" {{ old('sexo', auth()->user()->sexo ?? '') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo', auth()->user()->sexo ?? '') == 'F' ? 'selected' : '' }}>Feminino</option>
                                    <option value="O" {{ old('sexo', auth()->user()->sexo ?? '') == 'O' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado_civil" class="form-label">Estado Civil</label>
                                <select class="form-control" id="estado_civil" name="estado_civil">
                                    <option value="">Selecione</option>
                                    <option value="solteiro" {{ old('estado_civil', auth()->user()->estado_civil ?? '') == 'solteiro' ? 'selected' : '' }}>Solteiro(a)</option>
                                    <option value="casado" {{ old('estado_civil', auth()->user()->estado_civil ?? '') == 'casado' ? 'selected' : '' }}>Casado(a)</option>
                                    <option value="divorciado" {{ old('estado_civil', auth()->user()->estado_civil ?? '') == 'divorciado' ? 'selected' : '' }}>Divorciado(a)</option>
                                    <option value="viuvo" {{ old('estado_civil', auth()->user()->estado_civil ?? '') == 'viuvo' ? 'selected' : '' }}>Viúvo(a)</option>
                                    <option value="uniao_estavel" {{ old('estado_civil', auth()->user()->estado_civil ?? '') == 'uniao_estavel' ? 'selected' : '' }}>União Estável</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="profissao" class="form-label">Profissão</label>
                                <input type="text" class="form-control" id="profissao" name="profissao" 
                                       value="{{ old('profissao', auth()->user()->profissao ?? '') }}" 
                                       placeholder="Ex: Advogado, Professor, etc.">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefone_fixo" class="form-label">Telefone Fixo</label>
                                <input type="text" class="form-control" id="telefone_fixo" name="telefone_fixo" 
                                       value="{{ old('telefone_fixo', auth()->user()->telefone ?? '') }}" 
                                       placeholder="(00) 0000-0000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="text" class="form-control" id="celular" name="celular" 
                                       value="{{ old('celular', auth()->user()->celular ?? '') }}" 
                                       placeholder="(00) 00000-0000">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="cep" name="cep" 
                                       value="{{ old('cep', auth()->user()->cep ?? '') }}" 
                                       placeholder="00000-000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="endereco_detalhado" class="form-label">Endereço Detalhado</label>
                                <input type="text" class="form-control" id="endereco_detalhado" name="endereco_detalhado" 
                                       value="{{ old('endereco_detalhado', auth()->user()->endereco ?? '') }}" 
                                       placeholder="Rua, Avenida, etc.">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" 
                                       value="{{ old('numero', auth()->user()->numero ?? '') }}" 
                                       placeholder="123">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento" 
                                       value="{{ old('complemento', auth()->user()->complemento ?? '') }}" 
                                       placeholder="Apto, Bloco, etc.">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" 
                                       value="{{ old('bairro', auth()->user()->bairro ?? '') }}" 
                                       placeholder="Nome do bairro">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" 
                                       value="{{ old('cidade', auth()->user()->cidade ?? '') }}" 
                                       placeholder="Nome da cidade">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="">Selecione o Estado</option>
                                    <option value="AC" {{ old('estado', auth()->user()->estado ?? '') == 'AC' ? 'selected' : '' }}>Acre</option>
                                    <option value="AL" {{ old('estado', auth()->user()->estado ?? '') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                    <option value="AP" {{ old('estado', auth()->user()->estado ?? '') == 'AP' ? 'selected' : '' }}>Amapá</option>
                                    <option value="AM" {{ old('estado', auth()->user()->estado ?? '') == 'AM' ? 'selected' : '' }}>Amazonas</option>
                                    <option value="BA" {{ old('estado', auth()->user()->estado ?? '') == 'BA' ? 'selected' : '' }}>Bahia</option>
                                    <option value="CE" {{ old('estado', auth()->user()->estado ?? '') == 'CE' ? 'selected' : '' }}>Ceará</option>
                                    <option value="DF" {{ old('estado', auth()->user()->estado ?? '') == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                    <option value="ES" {{ old('estado', auth()->user()->estado ?? '') == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                    <option value="GO" {{ old('estado', auth()->user()->estado ?? '') == 'GO' ? 'selected' : '' }}>Goiás</option>
                                    <option value="MA" {{ old('estado', auth()->user()->estado ?? '') == 'MA' ? 'selected' : '' }}>Maranhão</option>
                                    <option value="MT" {{ old('estado', auth()->user()->estado ?? '') == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                    <option value="MS" {{ old('estado', auth()->user()->estado ?? '') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                    <option value="MG" {{ old('estado', auth()->user()->estado ?? '') == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                    <option value="PA" {{ old('estado', auth()->user()->estado ?? '') == 'PA' ? 'selected' : '' }}>Pará</option>
                                    <option value="PB" {{ old('estado', auth()->user()->estado ?? '') == 'PB' ? 'selected' : '' }}>Paraíba</option>
                                    <option value="PR" {{ old('estado', auth()->user()->estado ?? '') == 'PR' ? 'selected' : '' }}>Paraná</option>
                                    <option value="PE" {{ old('estado', auth()->user()->estado ?? '') == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                    <option value="PI" {{ old('estado', auth()->user()->estado ?? '') == 'PI' ? 'selected' : '' }}>Piauí</option>
                                    <option value="RJ" {{ old('estado', auth()->user()->estado ?? '') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                    <option value="RN" {{ old('estado', auth()->user()->estado ?? '') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                    <option value="RS" {{ old('estado', auth()->user()->estado ?? '') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                    <option value="RO" {{ old('estado', auth()->user()->estado ?? '') == 'RO' ? 'selected' : '' }}>Rondônia</option>
                                    <option value="RR" {{ old('estado', auth()->user()->estado ?? '') == 'RR' ? 'selected' : '' }}>Roraima</option>
                                    <option value="SC" {{ old('estado', auth()->user()->estado ?? '') == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                    <option value="SP" {{ old('estado', auth()->user()->estado ?? '') == 'SP' ? 'selected' : '' }}>São Paulo</option>
                                    <option value="SE" {{ old('estado', auth()->user()->estado ?? '') == 'SE' ? 'selected' : '' }}>Sergipe</option>
                                    <option value="TO" {{ old('estado', auth()->user()->estado ?? '') == 'TO' ? 'selected' : '' }}>Tocantins</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="titulo_eleitor" class="form-label">Título de Eleitor</label>
                                <input type="text" class="form-control" id="titulo_eleitor" name="titulo_eleitor" 
                                       value="{{ old('titulo_eleitor', auth()->user()->titulo_eleitor ?? '') }}" 
                                       placeholder="0000 0000 0000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="zona_eleitoral" class="form-label">Zona Eleitoral</label>
                                <input type="text" class="form-control" id="zona_eleitoral" name="zona_eleitoral" 
                                       value="{{ old('zona_eleitoral', auth()->user()->zona_eleitoral ?? '') }}" 
                                       placeholder="000">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="secao_eleitoral" class="form-label">Seção Eleitoral</label>
                        <input type="text" class="form-control" id="secao_eleitoral" name="secao_eleitoral" 
                               value="{{ old('secao_eleitoral', auth()->user()->secao_eleitoral ?? '') }}" 
                               placeholder="0000">
                    </div>

                    <!-- Status de Verificação -->
                    <div class="section-divider">
                        <h3 class="section-title">
                            <i class="fas fa-check-circle"></i>
                            Status de Verificação
                        </h3>
                    </div>

                    <div class="verification-status">
                        @if(auth()->user()->status_verificacao)
                            <div class="status-badge status-{{ auth()->user()->status_verificacao }}">
                                @if(auth()->user()->status_verificacao === 'verificado')
                                    <i class="fas fa-check-circle"></i>
                                    Verificado
                                @elseif(auth()->user()->status_verificacao === 'pendente')
                                    <i class="fas fa-clock"></i>
                                    Pendente de Verificação
                                @else
                                    <i class="fas fa-times-circle"></i>
                                    Rejeitado
                                @endif
                            </div>

                            @if(auth()->user()->verificado_em)
                                <p class="verification-date">
                                    <strong>Data da Verificação:</strong> 
                                    {{ auth()->user()->verificado_em->format('d/m/Y H:i') }}
                                </p>
                            @endif

                            @if(auth()->user()->status_verificacao === 'rejeitado' && auth()->user()->motivo_rejeicao)
                                <div class="rejection-reason">
                                    <strong>Motivo da Rejeição:</strong>
                                    <p>{{ auth()->user()->motivo_rejeicao }}</p>
                                </div>
                            @endif
                        @else
                            <div class="status-badge status-pendente">
                                <i class="fas fa-clock"></i>
                                Aguardando Verificação
                            </div>
                        @endif
                    </div>
                    @endif



                    <div class="text-end">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>
                            Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>

                <!-- Password Change Section -->
                <div class="password-section">
                    <h3 class="section-title">
                        <i class="fas fa-lock"></i>
                        Alterar Senha
                    </h3>
                    
                    <p class="info-text">
                        Para sua segurança, você precisa informar sua senha atual para definir uma nova senha.
                    </p>

                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control" id="current_password" 
                                   name="current_password" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control" id="password" 
                                           name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="password-requirements">
                            <strong>Requisitos da senha:</strong>
                            <ul>
                                <li>Mínimo de 8 caracteres</li>
                                <li>Pelo menos uma letra maiúscula</li>
                                <li>Pelo menos uma letra minúscula</li>
                                <li>Pelo menos um número</li>
                                <li>Pelo menos um caractere especial (!@#$%^&*)</li>
                            </ul>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-1"></i>
                                Alterar Senha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para telefone principal
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                if (value.length < 14) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = value;
            }
        });
    }

    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        // Aplicar máscara ao valor inicial
        function formatCPF(value) {
            value = value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }
            return value;
        }
        
        // Aplicar máscara ao valor inicial se existir
        if (cpfInput.value) {
            cpfInput.value = formatCPF(cpfInput.value);
        }
        
        cpfInput.addEventListener('input', function(e) {
            e.target.value = formatCPF(e.target.value);
        });
    }

    // Máscara para telefone fixo
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                e.target.value = value;
            }
        });
    }

    // Máscara para celular
    const celularInput = document.getElementById('celular');
    if (celularInput) {
        celularInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                if (value.length < 14) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = value;
            }
        });
    }
});
</script>
@endsection