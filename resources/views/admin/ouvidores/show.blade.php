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
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Informações do Usuário</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nome:</strong></td>
                                    <td>{{ $ouvidor->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $ouvidor->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>CPF:</strong></td>
                                    <td>{{ $ouvidor->cpf ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Telefone:</strong></td>
                                    <td>{{ $ouvidor->telefone ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Criado em:</strong></td>
                                    <td>{{ $ouvidor->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Última atualização:</strong></td>
                                    <td>{{ $ouvidor->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>

                            <hr class="my-4">
                            <h5>Informações do Ouvidor</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Cargo:</strong></td>
                                    <td>{{ $ouvidor->cargo_ouvidor ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Setor:</strong></td>
                                    <td>{{ $ouvidor->setor_ouvidor ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Especialidade:</strong></td>
                                    <td>
                                        @if($ouvidor->especialidade_ouvidor == 'ouvidoria')
                                            <span class="badge badge-primary">Ouvidoria</span>
                                        @elseif($ouvidor->especialidade_ouvidor == 'esic')
                                            <span class="badge badge-info">e-SIC</span>
                                        @elseif($ouvidor->especialidade_ouvidor == 'ambas')
                                            <span class="badge badge-success">Ambas</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $ouvidor->especialidade_ouvidor }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($ouvidor->ativo_ouvidor)
                                            <span class="badge badge-success">Ativo</span>
                                        @else
                                            <span class="badge badge-danger">Inativo</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pode Responder Manifestações:</strong></td>
                                    <td>
                                        @if($ouvidor->pode_responder_manifestacoes)
                                            <span class="badge badge-success">Sim</span>
                                        @else
                                            <span class="badge badge-warning">Não</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4 text-center">
                            @if($ouvidor->foto)
                                <img src="{{ asset('storage/' . $ouvidor->foto) }}" alt="Foto do ouvidor" class="img-fluid rounded-circle mb-3" style="max-width: 200px;">
                            @else
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 200px; height: 200px;">
                                    <i class="fas fa-user fa-5x text-muted"></i>
                                </div>
                            @endif
                            <h6>{{ $ouvidor->name }}</h6>
                            <p class="text-muted">{{ $ouvidor->cargo_ouvidor ?? 'Ouvidor' }}</p>
                            
                            <div class="mt-3">
                                <small class="text-muted d-block">Manifestações Responsável:</small>
                                <h4 class="text-primary">{{ $ouvidor->manifestacoes_responsavel_count ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection