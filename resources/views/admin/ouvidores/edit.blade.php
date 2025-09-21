@extends('layouts.admin')

@section('title', 'Editar Ouvidor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Ouvidor</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.ouvidores.show', $ouvidor) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('admin.ouvidores.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Funcionalidade em desenvolvimento.</strong>
                        <p class="mb-0">Esta página está sendo desenvolvida. Em breve você poderá editar os dados do ouvidor.</p>
                    </div>

                    <form action="{{ route('admin.ouvidores.update', $ouvidor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $ouvidor->nome) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $ouvidor->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo">Cargo</label>
                                    <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo', $ouvidor->cargo) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="setor">Setor</label>
                                    <input type="text" class="form-control" id="setor" name="setor" value="{{ old('setor', $ouvidor->setor) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Tipo *</label>
                                    <select class="form-control" id="tipo" name="tipo" required>
                                        <option value="">Selecione...</option>
                                        <option value="ouvidoria" {{ old('tipo', $ouvidor->tipo) == 'ouvidoria' ? 'selected' : '' }}>Ouvidoria</option>
                                        <option value="esic" {{ old('tipo', $ouvidor->tipo) == 'esic' ? 'selected' : '' }}>e-SIC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ativo">Status</label>
                                    <select class="form-control" id="ativo" name="ativo">
                                        <option value="1" {{ old('ativo', $ouvidor->ativo) == '1' ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ old('ativo', $ouvidor->ativo) == '0' ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Atualizar
                            </button>
                            <a href="{{ route('admin.ouvidores.show', $ouvidor) }}" class="btn btn-secondary">
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