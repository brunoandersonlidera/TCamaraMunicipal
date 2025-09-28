@extends('layouts.admin')

@section('page-title', 'Novo Vereador')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.vereadores.index') }}">Vereadores</a></li>
        <li class="breadcrumb-item active">Novo</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Cadastrar Novo Vereador</h1>
    <a href="{{ route('admin.vereadores.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<form action="{{ route('admin.vereadores.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Dados Básicos -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-user"></i> Dados Básicos</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome') }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome_parlamentar" class="form-label">Nome Parlamentar *</label>
                        <input type="text" class="form-control @error('nome_parlamentar') is-invalid @enderror" 
                               id="nome_parlamentar" name="nome_parlamentar" value="{{ old('nome_parlamentar') }}" required>
                        @error('nome_parlamentar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="partido" class="form-label">Partido *</label>
                        <input type="text" class="form-control @error('partido') is-invalid @enderror" 
                               id="partido" name="partido" value="{{ old('partido') }}" required>
                        @error('partido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                               id="telefone" name="telefone" value="{{ old('telefone') }}">
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
                               id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}">
                        @error('data_nascimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Selecione...</option>
                            <option value="ativo" {{ old('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ old('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                       id="foto" name="foto" accept="image/*">
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</div>
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
                        <label for="profissao" class="form-label">Profissão</label>
                        <input type="text" class="form-control @error('profissao') is-invalid @enderror" 
                               id="profissao" name="profissao" value="{{ old('profissao') }}">
                        @error('profissao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="escolaridade" class="form-label">Escolaridade</label>
                        <input type="text" class="form-control @error('escolaridade') is-invalid @enderror" 
                               id="escolaridade" name="escolaridade" value="{{ old('escolaridade') }}">
                        @error('escolaridade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <textarea class="form-control @error('endereco') is-invalid @enderror" 
                          id="endereco" name="endereco" rows="2">{{ old('endereco') }}</textarea>
                @error('endereco')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="biografia" class="form-label">Biografia</label>
                <textarea class="form-control @error('biografia') is-invalid @enderror" 
                          id="biografia" name="biografia" rows="4">{{ old('biografia') }}</textarea>
                @error('biografia')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
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
                        <label for="inicio_mandato" class="form-label">Início do Mandato</label>
                        <input type="date" class="form-control @error('inicio_mandato') is-invalid @enderror" 
                               id="inicio_mandato" name="inicio_mandato" value="{{ old('inicio_mandato') }}">
                        @error('inicio_mandato')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="fim_mandato" class="form-label">Fim do Mandato</label>
                        <input type="date" class="form-control @error('fim_mandato') is-invalid @enderror" 
                               id="fim_mandato" name="fim_mandato" value="{{ old('fim_mandato') }}">
                        @error('fim_mandato')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="legislatura" class="form-label">Legislatura</label>
                        <input type="text" class="form-control @error('legislatura') is-invalid @enderror" 
                               id="legislatura" name="legislatura" value="{{ old('legislatura') }}" 
                               placeholder="Ex: 2021-2024">
                        @error('legislatura')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="comissoes" class="form-label">Comissões</label>
                <div id="comissoes-container">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="comissoes[]" placeholder="Nome da comissão">
                        <button type="button" class="btn btn-outline-success" onclick="addComissao()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Redes Sociais -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-share-alt"></i> Redes Sociais</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" class="form-control @error('redes_sociais.facebook') is-invalid @enderror" 
                               id="facebook" name="redes_sociais[facebook]" value="{{ old('redes_sociais.facebook') }}" 
                               placeholder="https://facebook.com/usuario ou @usuario">
                        @error('redes_sociais.facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" class="form-control @error('redes_sociais.instagram') is-invalid @enderror" 
                               id="instagram" name="redes_sociais[instagram]" value="{{ old('redes_sociais.instagram') }}" 
                               placeholder="https://instagram.com/usuario ou @usuario">
                        @error('redes_sociais.instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" class="form-control @error('redes_sociais.twitter') is-invalid @enderror" 
                               id="twitter" name="redes_sociais[twitter]" value="{{ old('redes_sociais.twitter') }}" 
                               placeholder="https://twitter.com/usuario ou @usuario">
                        @error('redes_sociais.twitter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="linkedin" class="form-label">LinkedIn</label>
                        <input type="text" class="form-control @error('redes_sociais.linkedin') is-invalid @enderror" 
                               id="linkedin" name="redes_sociais[linkedin]" value="{{ old('redes_sociais.linkedin') }}" 
                               placeholder="https://linkedin.com/in/usuario ou nome-usuario">
                        @error('redes_sociais.linkedin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Observações -->
    <div class="admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Observações</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações Gerais</label>
                <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                          id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
                @error('observacoes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Botões -->
    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('admin.vereadores.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Salvar Vereador
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('js/vereadores.js') }}"></script>
@endpush