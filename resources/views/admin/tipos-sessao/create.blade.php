@extends('layouts.admin')

@section('title', 'Novo Tipo de Sessão')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Novo Tipo de Sessão</h3>
                    <a href="{{ route('admin.tipos-sessao.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>

                <form action="{{ route('admin.tipos-sessao.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome">Nome <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" 
                                           name="nome" 
                                           value="{{ old('nome') }}" 
                                           required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cor">Cor <span class="text-danger">*</span></label>
                                    <input type="color" 
                                           class="form-control @error('cor') is-invalid @enderror" 
                                           id="cor" 
                                           name="cor" 
                                           value="{{ old('cor', '#007bff') }}" 
                                           required>
                                    @error('cor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ordem">Ordem <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('ordem') is-invalid @enderror" 
                                           id="ordem" 
                                           name="ordem" 
                                           value="{{ old('ordem', 0) }}" 
                                           min="0" 
                                           required>
                                    @error('ordem')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="icone">Ícone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i id="icone-preview" class="fas fa-gavel"></i>
                                            </span>
                                        </div>
                                        <input type="text" 
                                               class="form-control @error('icone') is-invalid @enderror" 
                                               id="icone" 
                                               name="icone" 
                                               value="{{ old('icone', 'fas fa-gavel') }}" 
                                               placeholder="Ex: fas fa-gavel"
                                               required>
                                        @error('icone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">
                                        Use classes do Font Awesome. Ex: fas fa-gavel, fas fa-users, fas fa-calendar
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="ativo" 
                                               name="ativo" 
                                               value="1" 
                                               {{ old('ativo', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ativo">
                                            Tipo ativo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" 
                                      name="descricao" 
                                      rows="3" 
                                      placeholder="Descrição opcional do tipo de sessão">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div class="form-group">
                            <label>Preview</label>
                            <div class="card" style="max-width: 300px;">
                                <div class="card-body text-center">
                                    <span id="badge-preview" class="badge" style="background-color: #007bff; color: white; font-size: 14px;">
                                        <i id="badge-icon" class="fas fa-gavel"></i>
                                        <span id="badge-text">Novo Tipo</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('admin.tipos-sessao.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/tipos-sessao.js') }}"></script>
@endpush