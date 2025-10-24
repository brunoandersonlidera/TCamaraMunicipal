@extends('layouts.app')

@section('title', 'Detalhes do Comitê - ' . $comite->nome)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Cabeçalho do Comitê -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-users"></i> {{ $comite->nome }}
                        </h4>
                        <span class="badge bg-{{ $comite->getStatusBadgeClass() }} fs-6">
                            {{ $comite->getStatusFormatado() }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Descrição</h6>
                            <p>{{ $comite->descricao }}</p>
                            
                            <h6>Objetivo</h6>
                            <p>{{ $comite->objetivo }}</p>

                            @if(!empty($comite->ementa))
                            <h6>Ementa do Projeto de Lei</h6>
                            <div class="mb-3">
                                {!! $comite->ementa !!}
                            </div>
                            @endif

                            @if(!empty($comite->texto_projeto_html))
                            <h6>Texto Completo do Projeto de Lei</h6>
                            <div class="mb-3 border rounded p-3 bg-light">
                                {!! $comite->texto_projeto_html !!}
                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Responsável</h6>
                                    <p>{{ $comite->responsavel->nome_completo ?? $comite->responsavel->name ?? 'Não informado' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Contato</h6>
                                    <p>
                                        <i class="fas fa-envelope"></i> {{ $comite->email }}<br>
                                        <i class="fas fa-phone"></i> {{ $comite->telefone }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Progresso das Assinaturas -->
                            <div class="text-center">
                                <h6>Progresso das Assinaturas</h6>
                                <div class="position-relative d-inline-block">
                                    <canvas id="progressChart" width="150" height="150"></canvas>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <h4 class="mb-0">{{ number_format($progresso, 1) }}%</h4>
                                        <small class="text-muted">Concluído</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Atual:</span>
                                        <strong>{{ number_format($comite->numero_assinaturas) }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Meta:</span>
                                        <strong>{{ number_format($comite->minimo_assinaturas) }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Restam:</span>
                                        <strong>{{ number_format(max(0, $comite->minimo_assinaturas - $comite->numero_assinaturas)) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações de Prazo -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6>Data Limite para Coleta</h6>
                            <h4 class="text-primary">{{ $comite->data_fim_coleta ? $comite->data_fim_coleta->format('d/m/Y') : 'Não definida' }}</h4>
                            @if($comite->data_fim_coleta)
                                @php
                                    $diasRestantesDetalhado = calcularDiasRestantesDetalhado($comite->data_fim_coleta);
                                    $diasRestantes = floor($diasRestantesDetalhado);
                                @endphp
                                @if($diasRestantesDetalhado > 0)
                                    @php
                                        $tempoFormatado = formatarTempoRestante($diasRestantesDetalhado);
                                    @endphp
                                    <p class="text-success mb-0">{{ $tempoFormatado }} restantes</p>
                                @elseif($diasRestantes == 0)
                                    <p class="text-warning mb-0">Último dia!</p>
                                @else
                                    @php
                                        $tempoExpirado = formatarTempoRestante(abs($diasRestantesDetalhado));
                                    @endphp
                                    <p class="text-danger mb-0">Prazo expirado há {{ $tempoExpirado ?? abs($diasRestantes) . ' dias' }}</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6>Status da Meta</h6>
                            @if($comite->numero_assinaturas >= $comite->minimo_assinaturas)
                                <h4 class="text-success">
                                    <i class="fas fa-check-circle"></i> Meta Atingida!
                                </h4>
                                <p class="text-success mb-0">Parabéns! O comitê atingiu o número mínimo de assinaturas.</p>
                            @else
                                <h4 class="text-warning">
                                    <i class="fas fa-clock"></i> Em Andamento
                                </h4>
                                <p class="text-muted mb-0">Continue coletando assinaturas para atingir a meta.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ações</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if(!$jaAssinou && $comite->status === 'ativo' && (!$comite->data_fim_coleta || $comite->data_fim_coleta >= now()))
                                <button class="btn btn-success btn-lg w-100" onclick="assinarComite({{ $comite->id }})">
                                    <i class="fas fa-signature"></i> Assinar Este Comitê
                                </button>
                                <p class="text-muted small mt-2">Sua assinatura será validada pela equipe da Câmara.</p>
                            @elseif($jaAssinou)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Você já assinou este comitê!
                                </div>
                            @elseif($comite->status !== 'ativo')
                                <div class="alert alert-warning">
                                    <i class="fas fa-pause-circle"></i> Este comitê não está mais ativo para coleta de assinaturas.
                                </div>
                            @elseif($comite->data_fim_coleta && $comite->data_fim_coleta < now())
                                <div class="alert alert-danger">
                                    <i class="fas fa-times-circle"></i> O prazo para coleta de assinaturas expirou.
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary" onclick="compartilharComite()">
                                    <i class="fas fa-share-alt"></i> Compartilhar Comitê
                                </button>
                                <a href="{{ route('cidadao.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de progresso circular
    const ctx = document.getElementById('progressChart').getContext('2d');
    const progresso = {{ $progresso }};
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [progresso, 100 - progresso],
                backgroundColor: [
                    progresso >= 100 ? '#28a745' : '#007bff',
                    '#e9ecef'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        }
    });
});

function assinarComite(comiteId) {
    if (confirm('Deseja realmente assinar este comitê de iniciativa popular?')) {
        // Mostrar loading
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Assinando...';
        btn.disabled = true;
        
        fetch(`/cidadao/comites/${comiteId}/assinar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar sucesso e recarregar página
                alert(data.message);
                location.reload();
            } else {
                // Mostrar erro
                alert(data.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao processar assinatura. Tente novamente.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
}

function compartilharComite() {
    const url = window.location.href;
    const titulo = 'Assine o comitê: {{ $comite->nome }}';
    const texto = 'Ajude a apoiar esta iniciativa popular! {{ $comite->objetivo }}';
    
    if (navigator.share) {
        navigator.share({
            title: titulo,
            text: texto,
            url: url
        });
    } else {
        // Fallback para navegadores que não suportam Web Share API
        const shareText = `${titulo}\n\n${texto}\n\n${url}`;
        navigator.clipboard.writeText(shareText).then(() => {
            alert('Link copiado para a área de transferência!');
        }).catch(() => {
            // Fallback manual
            prompt('Copie o link abaixo:', url);
        });
    }
}
</script>
@endsection