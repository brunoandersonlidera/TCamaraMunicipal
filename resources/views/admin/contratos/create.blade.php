@extends('layouts.admin')

@section('title', 'Novo Contrato')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Novo Contrato</h3>
                    <a href="{{ route('admin.contratos.index') }}" class="btn btn-secondary-modern">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>

                <form action="{{ route('admin.contratos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @include('admin.contratos.form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success-modern">
                            <i class="fas fa-save"></i> Salvar Contrato
                        </button>
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