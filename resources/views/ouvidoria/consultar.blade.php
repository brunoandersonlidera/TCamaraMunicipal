@extends('layouts.app')

@section('title', 'Consultar Manifestação - Ouvidoria')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ouvidoria.css') }}">
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="hero-title">Consultar Manifestação</h1>
            <p class="hero-subtitle">Acompanhe o andamento da sua manifestação na Ouvidoria</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Formulário de Busca -->
        <div class="search-section">
            <h3 class="mb-4"><i class="fas fa-search me-2"></i>Buscar Manifestação</h3>
            
            <form method="GET" action="{{ route('ouvidoria.consultar') }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="protocolo" class="form-label">Número do Protocolo</label>
                            <input type="text" class="form-control" id="protocolo" name="protocolo" 
                                   placeholder="Ex: OUV2024001234" value="{{ request('protocolo') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Consultar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(isset($manifestacao))
            <!-- Resultado da Consulta -->
            <div class="result-section">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h3><i class="fas fa-comments me-2"></i>Detalhes da Manifestação</h3>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="type-badge type-{{ $manifestacao->tipo }}">
                            {{ ucfirst($manifestacao->tipo) }}
                        </span>
                        <span class="priority-badge priority-{{ $manifestacao->prioridade }}">
                            {{ ucfirst($manifestacao->prioridade) }}
                        </span>
                        <span class="status-badge status-{{ $manifestacao->status }}">
                            {{ ucfirst(str_replace('_', ' ', $manifestacao->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Informações Básicas -->
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Protocolo</div>
                        <div class="info-value">{{ $manifestacao->protocolo }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Data da Manifestação</div>
                        <div class="info-value">{{ $manifestacao->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Setor Responsável</div>
                        <div class="info-value">{{ $manifestacao->setor_responsavel ?? 'A definir' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Prazo de Resposta</div>
                        <div class="info-value">
                            {{ $manifestacao->prazo_resposta ? $manifestacao->prazo_resposta->format('d/m/Y') : 'A definir' }}
                        </div>
                    </div>
                </div>

                <!-- Alerta de Prazo -->
                @if($manifestacao->prazo_resposta)
                    @php
                        $diasRestantes = now()->diffInDays($manifestacao->prazo_resposta, false);
                    @endphp
                    @if($diasRestantes < 0)
                        <div class="deadline-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Prazo vencido!</strong> O prazo para resposta venceu há {{ abs($diasRestantes) }} dia(s).
                        </div>
                    @elseif($diasRestantes <= 3)
                        <div class="deadline-warning">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Prazo próximo do vencimento!</strong> Restam {{ $diasRestantes }} dia(s) para resposta.
                        </div>
                    @else
                        <div class="deadline-ok">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Dentro do prazo.</strong> Restam {{ $diasRestantes }} dia(s) para resposta.
                        </div>
                    @endif
                @endif

                <!-- Progresso -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Progresso da Manifestação</span>
                        <span class="text-muted">
                            @php
                                $progress = match($manifestacao->status) {
                                    'pendente' => 25,
                                    'em_andamento' => 50,
                                    'respondida' => 100,
                                    'arquivada' => 100,
                                    default => 0
                                };
                            @endphp
                            {{ $progress }}%
                        </span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-dynamic" data-progress="{{ $progress }}"></div>
                    </div>
                </div>

                <!-- Assunto e Descrição -->
                <div class="mb-4">
                    <h5 class="mb-3">Assunto</h5>
                    <p class="mb-4">{{ $manifestacao->assunto }}</p>
                    
                    <h5 class="mb-3">Descrição da Manifestação</h5>
                    <div class="bg-light p-3 rounded">
                        {{ $manifestacao->descricao }}
                    </div>
                </div>

                <!-- Informações do Manifestante -->
                @if(!$manifestacao->anonima)
                    <div class="mb-4">
                        <h5 class="mb-3">Dados do Manifestante</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Nome</div>
                                    <div class="info-value">{{ $manifestacao->nome }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">E-mail</div>
                                    <div class="info-value">{{ $manifestacao->email }}</div>
                                </div>
                            </div>
                            @if($manifestacao->telefone)
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Telefone</div>
                                        <div class="info-value">{{ $manifestacao->telefone }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-user-secret me-2"></i>
                        <strong>Manifestação Anônima</strong><br>
                        Esta manifestação foi enviada de forma anônima, conforme solicitado pelo manifestante.
                    </div>
                @endif

                <!-- Anexos da Manifestação -->
                @if($manifestacao->anexos && count($manifestacao->anexos) > 0)
                    <div class="attachments-section">
                        <h5 class="mb-3">Anexos da Manifestação</h5>
                        @foreach($manifestacao->anexos as $anexo)
                            <div class="attachment-item">
                                <div class="attachment-icon">
                                    <i class="fas fa-file"></i>
                                </div>
                                <div class="attachment-info">
                                    <div class="attachment-name">{{ $anexo['nome'] }}</div>
                                    <div class="attachment-size">{{ $anexo['tamanho'] ?? 'N/A' }}</div>
                                </div>
                                <a href="{{ $anexo['url'] }}" class="btn-download" target="_blank">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Timeline de Movimentações -->
                <div class="mt-5">
                    <h5 class="mb-4">Histórico de Movimentações</h5>
                    <div class="timeline">
                        @forelse($manifestacao->movimentacoes ?? [] as $movimentacao)
                            <div class="timeline-item {{ $loop->first ? 'current' : '' }}">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($movimentacao['data'])->format('d/m/Y H:i') }}
                                </div>
                                <div class="timeline-title">{{ $movimentacao['titulo'] }}</div>
                                <div class="timeline-description">{{ $movimentacao['descricao'] }}</div>
                            </div>
                        @empty
                            <div class="timeline-item current">
                                <div class="timeline-date">{{ $manifestacao->created_at->format('d/m/Y H:i') }}</div>
                                <div class="timeline-title">Manifestação Recebida</div>
                                <div class="timeline-description">Sua manifestação foi recebida e está sendo analisada pelo setor competente.</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Resposta (se houver) -->
                @if($manifestacao->status === 'respondida' && $manifestacao->resposta)
                    <div class="response-section">
                        <h4 class="response-title">
                            <i class="fas fa-reply"></i>
                            Resposta da Ouvidoria
                        </h4>
                        <div class="response-content">
                            {{ $manifestacao->resposta }}
                        </div>
                        
                        @if($manifestacao->respondida_em)
                            <div class="mt-3 text-muted">
                                <small>
                                    <i class="fas fa-calendar me-1"></i>
                                    Respondido em {{ $manifestacao->respondida_em->format('d/m/Y H:i') }}
                                    @if($manifestacao->responsavel)
                                        por {{ $manifestacao->responsavel }}
                                    @endif
                                </small>
                            </div>
                        @endif

                        <!-- Anexos da Resposta -->
                        @if($manifestacao->anexos_resposta && count($manifestacao->anexos_resposta) > 0)
                            <div class="attachments-section">
                                <h6 class="mb-3 mt-4">Anexos da Resposta</h6>
                                @foreach($manifestacao->anexos_resposta as $anexo)
                                    <div class="attachment-item">
                                        <div class="attachment-icon">
                                            <i class="fas fa-file"></i>
                                        </div>
                                        <div class="attachment-info">
                                            <div class="attachment-name">{{ $anexo['nome'] }}</div>
                                            <div class="attachment-size">{{ $anexo['tamanho'] ?? 'N/A' }}</div>
                                        </div>
                                        <a href="{{ $anexo['url'] }}" class="btn-download" target="_blank">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Avaliação da Resposta -->
                @if($manifestacao->status === 'respondida' && !$manifestacao->avaliacao)
                    <div class="mt-4 p-4 bg-light rounded">
                        <h6 class="mb-3">Avalie nossa resposta</h6>
                        <p class="text-muted mb-3">Sua opinião é importante para melhorarmos nossos serviços.</p>
                        
                        <form method="POST" action="{{ route('ouvidoria.avaliar', $manifestacao->protocolo) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nota (1 a 5)</label>
                                        <select name="nota" class="form-control" required>
                                            <option value="">Selecione uma nota</option>
                                            <option value="1">1 - Muito Insatisfeito</option>
                                            <option value="2">2 - Insatisfeito</option>
                                            <option value="3">3 - Regular</option>
                                            <option value="4">4 - Satisfeito</option>
                                            <option value="5">5 - Muito Satisfeito</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Comentário (opcional)</label>
                                        <textarea name="comentario" class="form-control" rows="3" 
                                                  placeholder="Deixe seu comentário sobre o atendimento..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fas fa-star me-2"></i>Enviar Avaliação
                            </button>
                        </form>
                    </div>
                @elseif($manifestacao->avaliacao)
                    <div class="mt-4 p-4 bg-success bg-opacity-10 border border-success rounded">
                        <h6 class="text-success mb-2">
                            <i class="fas fa-check-circle me-2"></i>Avaliação Enviada
                        </h6>
                        <p class="mb-1">
                            <strong>Nota:</strong> {{ $manifestacao->avaliacao['nota'] }}/5
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $manifestacao->avaliacao['nota'] ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </p>
                        @if($manifestacao->avaliacao['comentario'])
                            <p class="mb-0"><strong>Comentário:</strong> {{ $manifestacao->avaliacao['comentario'] }}</p>
                        @endif
                    </div>
                @endif

                <!-- Ações -->
                <div class="text-center mt-4">
                    <a href="{{ route('ouvidoria.index') }}" class="btn btn-secondary me-3">
                        <i class="fas fa-arrow-left me-2"></i>Nova Consulta
                    </a>
                    
                    @if($manifestacao->status === 'respondida')
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Imprimir Resposta
                        </button>
                    @endif
                </div>
            </div>

        @elseif(request('protocolo'))
            <!-- Protocolo não encontrado -->
            <div class="result-section">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Protocolo não encontrado!</strong><br>
                    Verifique se o número do protocolo foi digitado corretamente. 
                    O protocolo é fornecido no momento da manifestação e enviado por e-mail.
                </div>
                
                <div class="text-center">
                    <a href="{{ route('ouvidoria.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Fazer Nova Manifestação
                    </a>
                </div>
            </div>

        @else
            <!-- Instruções -->
            <div class="result-section">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Como consultar sua manifestação:</strong><br>
                    Digite o número do protocolo que você recebeu por e-mail após fazer sua manifestação. 
                    O protocolo tem o formato: OUV2024001234
                </div>
                
                <div class="text-center">
                    <a href="{{ route('ouvidoria.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Fazer Nova Manifestação
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
// Máscara para protocolo
document.getElementById('protocolo').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^A-Z0-9]/g, '');
    e.target.value = value;
});

// Auto-focus no campo de protocolo
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('protocolo').focus();
});
</script>
@endsection