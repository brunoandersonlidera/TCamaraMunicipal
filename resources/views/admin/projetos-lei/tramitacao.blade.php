@extends('layouts.admin')

@section('page-title', 'Tramitação - Projeto de Lei')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.projetos-lei.index') }}">Projetos de Lei</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.projetos-lei.show', $projetoLei) }}">Projeto {{ $projetoLei->numero }}/{{ $projetoLei->ano }}</a></li>
        <li class="breadcrumb-item active">Tramitação</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-route me-2"></i>Tramitação - {{ ucfirst(str_replace('_', ' ', $projetoLei->tipo)) }} nº {{ $projetoLei->numero }}/{{ $projetoLei->ano }}
            </h1>
            <p class="text-muted mb-0">{{ $projetoLei->titulo }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.projetos-lei.show', $projetoLei) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Coluna Principal - Linha do Tempo -->
        <div class="col-lg-8">
            <!-- Status Atual -->
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status Atual</h5>
                    @if(!$projetoLei->protocolo_numero)
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#gerarProtocoloModal">
                            <i class="fas fa-barcode me-1"></i>Gerar Protocolo
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="status-icon mb-2">
                                    @php
                                        $statusConfig = [
                                            'protocolado' => ['icon' => 'fas fa-file-alt', 'color' => 'primary'],
                                            'distribuido' => ['icon' => 'fas fa-share-alt', 'color' => 'info'],
                                            'em_comissao' => ['icon' => 'fas fa-users', 'color' => 'warning'],
                                            'aprovado_1_turno' => ['icon' => 'fas fa-check-circle', 'color' => 'success'],
                                            'aprovado' => ['icon' => 'fas fa-check-double', 'color' => 'success'],
                                            'rejeitado' => ['icon' => 'fas fa-times-circle', 'color' => 'danger'],
                                            'enviado_executivo' => ['icon' => 'fas fa-paper-plane', 'color' => 'info'],
                                            'sancionado' => ['icon' => 'fas fa-stamp', 'color' => 'success'],
                                            'vetado' => ['icon' => 'fas fa-ban', 'color' => 'danger'],
                                            'promulgado' => ['icon' => 'fas fa-certificate', 'color' => 'success']
                                        ];
                                        $config = $statusConfig[$projetoLei->status] ?? ['icon' => 'fas fa-question', 'color' => 'secondary'];
                                    @endphp
                                    <i class="{{ $config['icon'] }} fa-3x text-{{ $config['color'] }}"></i>
                                </div>
                                <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $projetoLei->status)) }}</h6>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                @if($projetoLei->protocolo_numero)
                                    <div class="col-md-6">
                                        <strong>Protocolo:</strong><br>
                                        <span class="badge bg-primary">{{ $projetoLei->protocolo_numero }}</span>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <strong>Tempo de Tramitação:</strong><br>
                                    {{ $projetoLei->getTempoTramitacao() }}
                                </div>
                                @if($projetoLei->consulta_publica_ativa)
                                    <div class="col-md-12 mt-2">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-users me-2"></i>
                                            <strong>Consulta Pública Ativa</strong><br>
                                            Prazo: {{ $projetoLei->consulta_publica_prazo->format('d/m/Y') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Linha do Tempo -->
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Histórico de Tramitação</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#adicionarHistoricoModal">
                        <i class="fas fa-plus me-1"></i>Adicionar Entrada
                    </button>
                </div>
                <div class="card-body">
                    @if($historico->count() > 0)
                        <div class="timeline">
                            @foreach($historico as $entrada)
                                <div class="timeline-item">
                                    <div class="timeline-marker">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <h6 class="mb-1">{{ $entrada['acao'] }}</h6>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($entrada['data'])->format('d/m/Y H:i') }}
                                                @if(isset($entrada['usuario_nome']))
                                                    - por {{ $entrada['usuario_nome'] }}
                                                @endif
                                            </small>
                                        </div>
                                        @if(isset($entrada['observacao']) && $entrada['observacao'])
                                            <p class="mb-0 text-muted">{{ $entrada['observacao'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Nenhum histórico de tramitação registrado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Coluna Lateral - Ações -->
        <div class="col-lg-4">
            <!-- Ações Rápidas -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#atualizarStatusModal">
                            <i class="fas fa-edit me-2"></i>Atualizar Status
                        </button>
                        
                        @if(!$projetoLei->consulta_publica_ativa && in_array($projetoLei->status, ['protocolado', 'distribuido', 'em_comissao']))
                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#consultaPublicaModal">
                                <i class="fas fa-users me-2"></i>Iniciar Consulta Pública
                            </button>
                        @elseif($projetoLei->consulta_publica_ativa)
                            <form action="{{ route('admin.projetos-lei.finalizar-consulta-publica', $projetoLei) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-stop me-2"></i>Finalizar Consulta Pública
                                </button>
                            </form>
                        @endif

                        @if(in_array($projetoLei->status, ['em_comissao', 'distribuido']))
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#votacaoModal">
                                <i class="fas fa-vote-yea me-2"></i>Registrar Votação
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informações de Tramitação -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Informações de Tramitação</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @if($projetoLei->data_distribuicao)
                            <div class="col-12">
                                <small class="text-muted">Data de Distribuição:</small><br>
                                <strong>{{ $projetoLei->data_distribuicao->format('d/m/Y') }}</strong>
                            </div>
                        @endif
                        
                        @if($projetoLei->data_primeira_votacao)
                            <div class="col-12">
                                <small class="text-muted">Primeira Votação:</small><br>
                                <strong>{{ $projetoLei->data_primeira_votacao->format('d/m/Y') }}</strong>
                                @if($projetoLei->votos_favoraveis !== null)
                                    <div class="mt-1">
                                        <span class="badge bg-success">{{ $projetoLei->votos_favoraveis }} favoráveis</span>
                                        <span class="badge bg-danger">{{ $projetoLei->votos_contrarios }} contrários</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($projetoLei->data_segunda_votacao)
                            <div class="col-12">
                                <small class="text-muted">Segunda Votação:</small><br>
                                <strong>{{ $projetoLei->data_segunda_votacao->format('d/m/Y') }}</strong>
                            </div>
                        @endif

                        @if($projetoLei->data_aprovacao)
                            <div class="col-12">
                                <small class="text-muted">Data de Aprovação:</small><br>
                                <strong>{{ $projetoLei->data_aprovacao->format('d/m/Y') }}</strong>
                            </div>
                        @endif

                        @if($projetoLei->data_envio_executivo)
                            <div class="col-12">
                                <small class="text-muted">Envio ao Executivo:</small><br>
                                <strong>{{ $projetoLei->data_envio_executivo->format('d/m/Y') }}</strong>
                            </div>
                        @endif

                        @if($projetoLei->data_sancao)
                            <div class="col-12">
                                <small class="text-muted">Data de Sanção:</small><br>
                                <strong>{{ $projetoLei->data_sancao->format('d/m/Y') }}</strong>
                                @if($projetoLei->numero_lei)
                                    <br><span class="badge bg-success">Lei nº {{ $projetoLei->numero_lei }}</span>
                                @endif
                            </div>
                        @endif

                        @if($projetoLei->data_veto)
                            <div class="col-12">
                                <small class="text-muted">Data do Veto:</small><br>
                                <strong>{{ $projetoLei->data_veto->format('d/m/Y') }}</strong>
                                @if($projetoLei->tipo_veto)
                                    <br><span class="badge bg-warning">{{ ucfirst($projetoLei->tipo_veto) }}</span>
                                @endif
                            </div>
                        @endif

                        @if($projetoLei->data_promulgacao)
                            <div class="col-12">
                                <small class="text-muted">Data de Promulgação:</small><br>
                                <strong>{{ $projetoLei->data_promulgacao->format('d/m/Y') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Documentos -->
            @if($projetoLei->arquivo_projeto || $projetoLei->arquivo_lei)
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-pdf me-2"></i>Documentos</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($projetoLei->arquivo_projeto)
                                <a href="{{ route('admin.projetos-lei.download', [$projetoLei, 'projeto']) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-download me-2"></i>Baixar Projeto
                                </a>
                            @endif
                            @if($projetoLei->arquivo_lei)
                                <a href="{{ route('admin.projetos-lei.download', [$projetoLei, 'lei']) }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-download me-2"></i>Baixar Lei
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Gerar Protocolo -->
<div class="modal fade" id="gerarProtocoloModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gerar Protocolo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.projetos-lei.gerar-protocolo', $projetoLei) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Deseja gerar um protocolo automático para este projeto de lei?</p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        O protocolo será gerado automaticamente baseado no tipo e ano do projeto.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Gerar Protocolo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Atualizar Status -->
<div class="modal fade" id="atualizarStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.projetos-lei.atualizar-status', $projetoLei) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Novo Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Selecione um status</option>
                            <option value="protocolado" {{ $projetoLei->status === 'protocolado' ? 'selected' : '' }}>Protocolado</option>
                            <option value="distribuido" {{ $projetoLei->status === 'distribuido' ? 'selected' : '' }}>Distribuído</option>
                            <option value="em_comissao" {{ $projetoLei->status === 'em_comissao' ? 'selected' : '' }}>Em Comissão</option>
                            <option value="aprovado_1_turno" {{ $projetoLei->status === 'aprovado_1_turno' ? 'selected' : '' }}>Aprovado em 1º Turno</option>
                            <option value="aprovado" {{ $projetoLei->status === 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                            <option value="rejeitado" {{ $projetoLei->status === 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                            <option value="enviado_executivo" {{ $projetoLei->status === 'enviado_executivo' ? 'selected' : '' }}>Enviado ao Executivo</option>
                            <option value="sancionado" {{ $projetoLei->status === 'sancionado' ? 'selected' : '' }}>Sancionado</option>
                            <option value="vetado" {{ $projetoLei->status === 'vetado' ? 'selected' : '' }}>Vetado</option>
                            <option value="promulgado" {{ $projetoLei->status === 'promulgado' ? 'selected' : '' }}>Promulgado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observação (opcional)</label>
                        <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Adicione uma observação sobre a mudança de status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Consulta Pública -->
<div class="modal fade" id="consultaPublicaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Iniciar Consulta Pública</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.projetos-lei.iniciar-consulta-publica', $projetoLei) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="prazo_dias" class="form-label">Prazo (em dias)</label>
                        <input type="number" class="form-control" id="prazo_dias" name="prazo_dias" min="1" max="90" value="30" required>
                        <div class="form-text">Prazo para recebimento de contribuições da sociedade (máximo 90 dias).</div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        A consulta pública permitirá que a sociedade contribua com sugestões e comentários sobre este projeto de lei.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Iniciar Consulta Pública</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Adicionar Histórico -->
<div class="modal fade" id="adicionarHistoricoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Entrada ao Histórico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.projetos-lei.adicionar-historico', $projetoLei) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="acao" class="form-label">Ação</label>
                        <input type="text" class="form-control" id="acao" name="acao" required placeholder="Ex: Projeto distribuído para Comissão de Justiça">
                    </div>
                    <div class="mb-3">
                        <label for="observacao_historico" class="form-label">Observação (opcional)</label>
                        <textarea class="form-control" id="observacao_historico" name="observacao" rows="3" placeholder="Detalhes adicionais sobre a ação..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Registrar Votação -->
<div class="modal fade" id="votacaoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Votação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.projetos-lei.registrar-votacao', $projetoLei) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="turno" class="form-label">Turno de Votação</label>
                                <select class="form-select" id="turno" name="turno" required>
                                    <option value="">Selecione o turno</option>
                                    <option value="primeiro">Primeiro Turno</option>
                                    <option value="segundo">Segundo Turno</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="resultado" class="form-label">Resultado</label>
                                <select class="form-select" id="resultado" name="resultado" required>
                                    <option value="">Selecione o resultado</option>
                                    <option value="aprovado">Aprovado</option>
                                    <option value="rejeitado">Rejeitado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="votos_favoraveis" class="form-label">Votos Favoráveis</label>
                                <input type="number" class="form-control" id="votos_favoraveis" name="votos_favoraveis" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="votos_contrarios" class="form-label">Votos Contrários</label>
                                <input type="number" class="form-control" id="votos_contrarios" name="votos_contrarios" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="abstencoes" class="form-label">Abstenções</label>
                                <input type="number" class="form-control" id="abstencoes" name="abstencoes" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="ausencias" class="form-label">Ausências</label>
                                <input type="number" class="form-control" id="ausencias" name="ausencias" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observacao_votacao" class="form-label">Observação (opcional)</label>
                        <textarea class="form-control" id="observacao_votacao" name="observacao" rows="3" placeholder="Observações sobre a votação..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Registrar Votação</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 14px;
    height: 14px;
    background: #fff;
    border: 2px solid #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-marker i {
    font-size: 6px;
    color: #007bff;
}

.timeline-content {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-left: 15px;
}

.timeline-header h6 {
    color: #495057;
    font-weight: 600;
}

.status-icon {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 50%;
    display: inline-block;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calcular total de votos
    const votosInputs = ['votos_favoraveis', 'votos_contrarios', 'abstencoes', 'ausencias'];
    
    votosInputs.forEach(inputId => {
        document.getElementById(inputId)?.addEventListener('input', function() {
            calcularTotalVotos();
        });
    });
    
    function calcularTotalVotos() {
        let total = 0;
        votosInputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            if (input && input.value) {
                total += parseInt(input.value) || 0;
            }
        });
        
        // Você pode adicionar validação aqui se necessário
        console.log('Total de votos:', total);
    }
});
</script>
@endsection