@extends('layouts.admin')

@section('title', 'Editar Tipo de Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Editar Tipo de Contrato</h3>
                    <div>
                        <a href="{{ route('admin.tipos-contrato.show', $tipoContrato) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('admin.tipos-contrato.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.tipos-contrato.update', $tipoContrato) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @include('admin.tipos-contrato.form')
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar
                        </button>
                        <a href="{{ route('admin.tipos-contrato.show', $tipoContrato) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
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