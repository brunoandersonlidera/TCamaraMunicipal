@extends('layouts.admin')

@section('title', 'Novo Ouvidor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar Novo Ouvidor</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.ouvidores.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.ouvidores.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <h5 class="mb-3">Informações do Usuário</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nome Completo *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email *</label>
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
                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" name="cpf" value="{{ old('cpf') }}" 
                                           placeholder="000.000.000-00" maxlength="14">
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                           id="telefone" name="telefone" value="{{ old('telefone') }}" 
                                           placeholder="(00) 00000-0000">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Senha *</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required minlength="8">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Senha *</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required minlength="8">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3">Informações do Ouvidor</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo_ouvidor">Cargo</label>
                                    <input type="text" class="form-control @error('cargo_ouvidor') is-invalid @enderror" 
                                           id="cargo_ouvidor" name="cargo_ouvidor" value="{{ old('cargo_ouvidor') }}">
                                    @error('cargo_ouvidor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="setor_ouvidor">Setor</label>
                                    <input type="text" class="form-control @error('setor_ouvidor') is-invalid @enderror" 
                                           id="setor_ouvidor" name="setor_ouvidor" value="{{ old('setor_ouvidor') }}">
                                    @error('setor_ouvidor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="especialidade_ouvidor">Especialidade *</label>
                                    <select class="form-control @error('especialidade_ouvidor') is-invalid @enderror" 
                                            id="especialidade_ouvidor" name="especialidade_ouvidor" required>
                                        <option value="">Selecione...</option>
                                        <option value="ouvidoria" {{ old('especialidade_ouvidor') == 'ouvidoria' ? 'selected' : '' }}>Ouvidoria</option>
                                        <option value="esic" {{ old('especialidade_ouvidor') == 'esic' ? 'selected' : '' }}>e-SIC</option>
                                        <option value="ambas" {{ old('especialidade_ouvidor') == 'ambas' ? 'selected' : '' }}>Ambas</option>
                                    </select>
                                    @error('especialidade_ouvidor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ativo_ouvidor">Status</label>
                                    <select class="form-control @error('ativo_ouvidor') is-invalid @enderror" 
                                            id="ativo_ouvidor" name="ativo_ouvidor">
                                        <option value="1" {{ old('ativo_ouvidor', '1') == '1' ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ old('ativo_ouvidor') == '0' ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                    @error('ativo_ouvidor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pode_responder_manifestacoes">Pode Responder Manifestações</label>
                                    <select class="form-control @error('pode_responder_manifestacoes') is-invalid @enderror" 
                                            id="pode_responder_manifestacoes" name="pode_responder_manifestacoes">
                                        <option value="1" {{ old('pode_responder_manifestacoes', '1') == '1' ? 'selected' : '' }}>Sim</option>
                                        <option value="0" {{ old('pode_responder_manifestacoes') == '0' ? 'selected' : '' }}>Não</option>
                                    </select>
                                    @error('pode_responder_manifestacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="foto">Foto do Perfil</label>
                                    <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
                                           id="foto" name="foto" accept="image/*">
                                    <small class="form-text text-muted">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</small>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cadastrar Ouvidor
                            </button>
                            <a href="{{ route('admin.ouvidores.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection