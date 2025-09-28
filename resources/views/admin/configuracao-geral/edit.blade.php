@extends('layouts.admin')

@section('page-title', 'Editar Configuração')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.configuracao-geral.index') }}">Configurações Gerais</a></li>
        <li class="breadcrumb-item active">Editar: {{ $configuracao->chave }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Editar Configuração</h1>
            <p class="text-muted">{{ $configuracao->descricao }}</p>
        </div>
        <a href="{{ route('admin.configuracao-geral.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <!-- Formulário -->
    <div class="admin-card">
        <div class="card-body">
            <form action="{{ route('admin.configuracao-geral.update', $configuracao) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.configuracao-geral.form')
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.configuracao-geral.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection