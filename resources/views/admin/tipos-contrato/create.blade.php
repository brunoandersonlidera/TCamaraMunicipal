@extends('layouts.admin')

@section('title', 'Novo Tipo de Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Novo Tipo de Contrato</h3>
                    <a href="{{ route('admin.tipos-contrato.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>

                <form action="{{ route('admin.tipos-contrato.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @include('admin.tipos-contrato.form')
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('admin.tipos-contrato.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection