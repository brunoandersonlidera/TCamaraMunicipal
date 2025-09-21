@extends('layouts.admin')

@section('title', 'Visualizar Ouvidor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalhes do Ouvidor</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.ouvidores.edit', $ouvidor) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
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
                        <p class="mb-0">Esta página está sendo desenvolvida. Em breve você poderá visualizar todos os detalhes do ouvidor.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações Pessoais</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nome:</th>
                                    <td>{{ $ouvidor->nome ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $ouvidor->email ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>CPF:</th>
                                    <td>{{ $ouvidor->cpf_formatado ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Telefone:</th>
                                    <td>{{ $ouvidor->telefone ?? 'Não informado' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Informações Profissionais</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Cargo:</th>
                                    <td>{{ $ouvidor->cargo ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Setor:</th>
                                    <td>{{ $ouvidor->setor ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Tipo:</th>
                                    <td>
                                        <span class="badge badge-{{ $ouvidor->tipo == 'ouvidoria' ? 'primary' : 'info' }}">
                                            {{ ucfirst($ouvidor->tipo ?? 'Não definido') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $ouvidor->ativo ? 'success' : 'danger' }}">
                                            {{ $ouvidor->ativo ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection