@extends('layouts.app')

@section('title', 'Consultar Solicitação - E-SIC')

@section('content')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 0;
    position: relative;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
}

.main-content {
    padding: 60px 0;
    background: #f8f9fa;
}

.search-section {
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.result-section {
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pendente {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-em_andamento {
    background: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.status-respondida {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-negada {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

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
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 40px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -23px;
    top: 5px;
    width: 16px;
    height: 16px;
    background: #667eea;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #667eea;
}

.timeline-item.current::before {
    background: #28a745;
    box-shadow: 0 0 0 2px #28a745;
}

.timeline-date {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 5px;
}

.timeline-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.timeline-description {
    color: #666;
    line-height: 1.5;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.info-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.info-label {
    font-size: 0.9rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.info-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
}

.response-section {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
    border: 1px solid #667eea;
    border-radius: 10px;
    padding: 30px;
    margin-top: 30px;
}

.response-title {
    color: #667eea;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.response-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #667eea;
    line-height: 1.6;
}

.attachments-section {
    margin-top: 30px;
}

.attachment-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.attachment-item:hover {
    background: #e9ecef;
}

.attachment-icon {
    width: 40px;
    height: 40px;
    background: #667eea;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.attachment-info {
    flex: 1;
}

.attachment-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.attachment-size {
    font-size: 0.9rem;
    color: #6c757d;
}

.btn-download {
    background: #667eea;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.btn-download:hover {
    background: #5a6fd8;
    color: white;
    transform: translateY(-1px);
}

.alert {
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 25px;
    border: none;
}

.alert-warning {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.1));
    color: #856404;
    border-left: 4px solid #ffc107;
}

.alert-info {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    color: #667eea;
    border-left: 4px solid #667eea;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 10px;
    padding: 12px 30px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    border: none;
    border-radius: 10px;
    padding: 12px 30px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 15px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
}

.progress-bar {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
    height: 8px;
    transition: width 0.3s ease;
}

.progress {
    background: #e9ecef;
    border-radius: 10px;
    height: 8px;
    margin: 20px 0;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .search-section, .result-section {
        padding: 25px 20px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .timeline {
        padding-left: 20px;
    }
    
    .timeline-item {
        padding-left: 30px;
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="hero-title">Consultar Solicitação</h1>
            <p class="hero-subtitle">Acompanhe o andamento da sua solicitação de informação</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Formulário de Busca -->
        <div class="search-section">
            <h3 class="mb-4"><i class="fas fa-search me-2"></i>Buscar Solicitação</h3>
            
            <form method="GET" action="{{ route('esic.consultar') }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="protocolo" class="form-label">Número do Protocolo</label>
                            <input type="text" class="form-control" id="protocolo" name="protocolo" 
                                   placeholder="Ex: 2024001234" value="{{ request('protocolo') }}" required>
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

        @if(isset($solicitacao))
            <!-- Resultado da Consulta -->
            <div class="result-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3><i class="fas fa-file-alt me-2"></i>Detalhes da Solicitação</h3>
                    <span class="status-badge status-{{ $solicitacao->status }}">
                        {{ ucfirst(str_replace('_', ' ', $solicitacao->status)) }}
                    </span>
                </div>

                <!-- Informações Básicas -->
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Protocolo</div>
                        <div class="info-value">{{ $solicitacao->protocolo }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Data da Solicitação</div>
                        <div class="info-value">{{ $solicitacao->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Categoria</div>
                        <div class="info-value">{{ ucfirst(str_replace('_', ' ', $solicitacao->categoria)) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Prazo de Resposta</div>
                        <div class="info-value">
                            {{ $solicitacao->prazo_resposta ? $solicitacao->prazo_resposta->format('d/m/Y') : 'A definir' }}
                        </div>
                    </div>
                </div>

                <!-- Progresso -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Progresso da Solicitação</span>
                        <span class="text-muted">
                            @php
                                $progress = match($solicitacao->status) {
                                    'pendente' => 25,
                                    'em_andamento' => 50,
                                    'respondida' => 100,
                                    'negada' => 100,
                                    default => 0
                                };
                                $progressClass = "progress-bar progress-bar-{$solicitacao->status}";
                            @endphp
                            {{ $progress }}%
                        </span>
                    </div>
                    <div class="progress">
                        <div class="{{ $progressClass }}"></div>
                    </div>
                </div>

                <!-- Assunto e Descrição -->
                <div class="mb-4">
                    <h5 class="mb-3">Assunto</h5>
                    <p class="mb-4">{{ $solicitacao->assunto }}</p>
                    
                    <h5 class="mb-3">Descrição da Solicitação</h5>
                    <div class="bg-light p-3 rounded">
                        {{ $solicitacao->descricao }}
                    </div>
                </div>

                <!-- Anexos da Solicitação -->
                @if($solicitacao->anexos && count($solicitacao->anexos) > 0)
                    <div class="attachments-section">
                        <h5 class="mb-3">Anexos da Solicitação</h5>
                        @foreach($solicitacao->anexos as $anexo)
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
                        @forelse($solicitacao->movimentacoes ?? [] as $movimentacao)
                            <div class="timeline-item {{ $loop->first ? 'current' : '' }}">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($movimentacao['data'])->format('d/m/Y H:i') }}
                                </div>
                                <div class="timeline-title">{{ $movimentacao['titulo'] }}</div>
                                <div class="timeline-description">{{ $movimentacao['descricao'] }}</div>
                            </div>
                        @empty
                            <div class="timeline-item current">
                                <div class="timeline-date">{{ $solicitacao->created_at->format('d/m/Y H:i') }}</div>
                                <div class="timeline-title">Solicitação Recebida</div>
                                <div class="timeline-description">Sua solicitação foi recebida e está sendo analisada.</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Resposta (se houver) -->
                @if($solicitacao->status === 'respondida' && $solicitacao->resposta)
                    <div class="response-section">
                        <h4 class="response-title">
                            <i class="fas fa-reply"></i>
                            Resposta da Solicitação
                        </h4>
                        <div class="response-content">
                            {{ $solicitacao->resposta }}
                        </div>
                        
                        @if($solicitacao->data_resposta)
                            <div class="mt-3 text-muted">
                                <small>
                                    <i class="fas fa-calendar me-1"></i>
                                    Respondido em {{ $solicitacao->data_resposta->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @endif

                        <!-- Anexos da Resposta -->
                        @if($solicitacao->anexos_resposta && count($solicitacao->anexos_resposta) > 0)
                            <div class="attachments-section">
                                <h6 class="mb-3 mt-4">Anexos da Resposta</h6>
                                @foreach($solicitacao->anexos_resposta as $anexo)
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

                <!-- Negativa (se houver) -->
                @if($solicitacao->status === 'negada' && $solicitacao->justificativa_negativa)
                    <div class="response-section" style="border-color: #dc3545; background: rgba(220, 53, 69, 0.05);">
                        <h4 class="response-title" style="color: #dc3545;">
                            <i class="fas fa-times-circle"></i>
                            Justificativa da Negativa
                        </h4>
                        <div class="response-content" style="border-left-color: #dc3545;">
                            {{ $solicitacao->justificativa_negativa }}
                        </div>
                        
                        @if($solicitacao->data_resposta)
                            <div class="mt-3 text-muted">
                                <small>
                                    <i class="fas fa-calendar me-1"></i>
                                    Negado em {{ $solicitacao->data_resposta->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Ações -->
                <div class="text-center mt-4">
                    <a href="{{ route('esic.index') }}" class="btn btn-secondary me-3">
                        <i class="fas fa-arrow-left me-2"></i>Nova Consulta
                    </a>
                    
                    @if($solicitacao->status === 'respondida')
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
                    O protocolo é fornecido no momento da solicitação e enviado por e-mail.
                </div>
                
                <div class="text-center">
                    <a href="{{ route('esic.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Fazer Nova Solicitação
                    </a>
                </div>
            </div>

        @else
            <!-- Instruções -->
            <div class="result-section">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Como consultar sua solicitação:</strong><br>
                    Digite o número do protocolo que você recebeu por e-mail após fazer sua solicitação. 
                    O protocolo tem o formato: 2024001234
                </div>
                
                <div class="text-center">
                    <a href="{{ route('esic.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Fazer Nova Solicitação
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
// Máscara para protocolo
document.getElementById('protocolo').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});

// Auto-focus no campo de protocolo
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('protocolo').focus();
});
</script>
@endsection