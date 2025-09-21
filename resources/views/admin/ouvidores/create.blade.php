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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Funcionalidade em desenvolvimento.</strong>
                        <p class="mb-0">Esta página está sendo desenvolvida. Em breve você poderá cadastrar novos ouvidores.</p>
                    </div>

                    <form action="{{ route('admin.ouvidores.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo">Cargo</label>
                                    <input type="text" class="form-control" id="cargo" name="cargo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="setor">Setor</label>
                                    <input type="text" class="form-control" id="setor" name="setor">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Tipo *</label>
                                    <select class="form-control" id="tipo" name="tipo" required>
                                        <option value="">Selecione...</option>
                                        <option value="ouvidoria">Ouvidoria</option>
                                        <option value="esic">e-SIC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ativo">Status</label>
                                    <select class="form-control" id="ativo" name="ativo">
                                        <option value="1">Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar
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