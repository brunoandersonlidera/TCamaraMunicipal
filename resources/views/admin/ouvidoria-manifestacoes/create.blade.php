@extends('layouts.admin')

@section('title', 'Nova Manifestação - Ouvidoria')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1>Nova Manifestação</h1>
        <p>Criar nova manifestação de ouvidoria</p>
    </div>
</div>

<div class="admin-content">
    <div class="card">
        <div class="card-header">
            <h3>Dados da Manifestação</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Esta funcionalidade está em desenvolvimento. Em breve será possível criar manifestações diretamente pelo painel administrativo.
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.ouvidoria-manifestacoes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar para Lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection