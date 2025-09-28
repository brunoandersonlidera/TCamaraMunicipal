@extends('layouts.admin')

@section('title', 'Editar Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Editar Contrato: {{ $contrato->numero }}</h3>
                    <div>
                        <a href="{{ route('admin.contratos.show', $contrato) }}" class="btn btn-view">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('admin.contratos.index') }}" class="btn btn-secondary-modern">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.contratos.update', $contrato) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @include('admin.contratos.form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success-modern">
                            <i class="fas fa-save"></i> Atualizar Contrato
                        </button>
                        <a href="{{ route('admin.contratos.show', $contrato) }}" class="btn btn-view">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('admin.contratos.index') }}" class="btn btn-secondary-modern">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection