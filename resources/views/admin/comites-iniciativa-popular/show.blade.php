@extends('layouts.admin')

@section('title', 'Visualizar Comitê de Iniciativa Popular')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $comite->nome }}</h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.comites-iniciativa-popular.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <a href="{{ route('admin.comites-iniciativa-popular.edit', $comite) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-{{ $comite->status == 'ativo' ? 'secondary' : 'success' }}" 
                                onclick="toggleStatus({{ $comite->id }})">
                            <i class="fas fa-{{ $comite->status == 'ativo' ? 'pause' : 'play' }}"></i> 
                            {{ $comite->status == 'ativo' ? 'Desativar' : 'Ativar' }}
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Informações do Comitê -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informações do Comitê</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nome:</strong></td>
                                    <td>{{ $comite->nome }}</td>
                                </tr>
                                <tr>
                                    <td><strong>CPF:</strong></td>
                                    <td>{{ $comite->cpf }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>
                                        <a href="mailto:{{ $comite->email }}">{{ $comite->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Telefone:</strong></td>
                                    <td>
                                        <a href="tel:{{ $comite->telefone }}">{{ $comite->telefone }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Endereço:</strong></td>
                                    <td>{{ $comite->endereco ?: 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $comite->status == 'ativo' ? 'success' : ($comite->status == 'validado' ? 'primary' : ($comite->status == 'rejeitado' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($comite->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Cadastrado em:</strong></td>
                                    <td>{{ $comite->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Última atualização:</strong></td>
                                    <td>{{ $comite->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informações das Assinaturas -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Coleta de Assinaturas</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Assinaturas Coletadas:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $comite->atingiuMinimoAssinaturas() ? 'success' : 'warning' }} fs-6">
                                            {{ number_format($comite->numero_assinaturas, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Mínimo Necessário:</strong></td>
                                    <td>{{ number_format($comite->minimo_assinaturas, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Percentual Atingido:</strong></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $comite->atingiuMinimoAssinaturas() ? 'success' : 'warning' }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min(100, $comite->getPercentualAssinaturas()) }}%">
                                                {{ number_format($comite->getPercentualAssinaturas(), 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Data Início Coleta:</strong></td>
                                    <td>{{ $comite->data_inicio_coleta ? $comite->data_inicio_coleta->format('d/m/Y') : 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Data Fim Coleta:</strong></td>
                                    <td>{{ $comite->data_fim_coleta ? $comite->data_fim_coleta->format('d/m/Y') : 'Não informado' }}</td>
                                </tr>
                                @if($comite->data_inicio_coleta && $comite->data_fim_coleta)
                                <tr>
                                    <td><strong>Período de Coleta:</strong></td>
                                    <td>
                                        @php
                                            $dias = $comite->data_inicio_coleta->diffInDays($comite->data_fim_coleta);
                                        @endphp
                                        {{ $dias }} dias
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Documentos -->
                    @if($comite->documentos && is_array($comite->documentos) && count($comite->documentos) > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Documentos</h5>
                                
                                <div class="row">
                                    @foreach($comite->documentos as $tipo => $arquivo)
                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                                                    <h6>{{ ucfirst(str_replace('_', ' ', $tipo)) }}</h6>
                                                    @if($arquivo)
                                                        <a href="{{ route('admin.comites-iniciativa-popular.download', [$comite, $tipo]) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Não enviado</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Observações -->
                    @if($comite->observacoes)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Observações</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {!! nl2br(e($comite->observacoes)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Estatísticas -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Estatísticas</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <h4>{{ number_format($comite->numero_assinaturas, 0, ',', '.') }}</h4>
                                            <p class="mb-0">Assinaturas Coletadas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-target fa-2x mb-2"></i>
                                            <h4>{{ number_format($comite->minimo_assinaturas, 0, ',', '.') }}</h4>
                                            <p class="mb-0">Meta de Assinaturas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-{{ $comite->atingiuMinimoAssinaturas() ? 'success' : 'warning' }} text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-percentage fa-2x mb-2"></i>
                                            <h4>{{ number_format($comite->getPercentualAssinaturas(), 1) }}%</h4>
                                            <p class="mb-0">Percentual Atingido</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-{{ $comite->isValidado() ? 'success' : 'secondary' }} text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-{{ $comite->isValidado() ? 'check-circle' : 'clock' }} fa-2x mb-2"></i>
                                            <h4>{{ $comite->isValidado() ? 'Sim' : 'Não' }}</h4>
                                            <p class="mb-0">Validado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id) {
    if (confirm('Tem certeza que deseja alterar o status deste comitê?')) {
        fetch(`/admin/comites-iniciativa-popular/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao alterar status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao alterar status');
        });
    }
}
</script>
@endpush