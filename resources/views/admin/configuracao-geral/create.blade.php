@extends('layouts.admin')

@section('page-title', 'Nova Configuração')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.configuracao-geral.index') }}">Configurações Gerais</a></li>
        <li class="breadcrumb-item active">Nova Configuração</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Nova Configuração</h1>
            <p class="text-muted">Adicione uma nova configuração do sistema</p>
        </div>
        <a href="{{ route('admin.configuracao-geral.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <!-- Formulário -->
    <div class="admin-card">
        <div class="card-body">
            <form action="{{ route('admin.configuracao-geral.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.configuracao-geral.form')
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.configuracao-geral.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection