@extends('layouts.admin')

@section('title', 'Manifestação #' . ($manifestacao->protocolo ?? 'OUV000001'))

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.ouvidoria-manifestacoes.index') }}">Manifestações</a></li>
        <li class="breadcrumb-item active">#{{ $manifestacao->protocolo ?? 'OUV000001' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<style>
.manifestacao-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.protocol-badge {
    background: rgba(255,255,255,0.2);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 15px;
}

.status-timeline {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 20px;
    margin-top: 20px;
}

.timeline-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 15px;
    flex-shrink: 0;
}

.timeline-dot.active {
    background: #28a745;
}

.timeline-dot.inactive {
    background: rgba(255,255,255,0.3);
}

.info-card {
    background: white;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-left: 4px solid #667eea;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #555;
    min-width: 150px;
    flex-shrink: 0;
}

.info-value {
    color: #333;
    flex: 1;
    text-align: right;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pendente {
    background: #fff3cd;
    color: #856404;
}

.status-em-andamento {
    background: #cce5ff;
    color: #004085;
}

.status-respondida {
    background: #d4edda;
    color: #155724;
}

.status-arquivada {
    background: #f8d7da;
    color: #721c24;
}

.tipo-badge {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
}

.tipo-reclamacao {
    background: #ffebee;
    color: #c62828;
}

.tipo-sugestao {
    background: #e8f5e8;
    color: #2e7d32;
}

.tipo-elogio {
    background: #fff3e0;
    color: #ef6c00;
}

.tipo-denuncia {
    background: #fce4ec;
    color: #ad1457;
}

.tipo-solicitacao {
    background: #e3f2fd;
    color: #1565c0;
}

.priority-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
}

.priority-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.priority-baixa {
    background: #4caf50;
}

.priority-media {
    background: #ff9800;
}

.priority-alta {
    background: #f44336;
}

.priority-urgente {
    background: #9c27b0;
    animation: pulse 2s infinite;
}

.content-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin: 15px 0;
    border-left: 4px solid #667eea;
}

.attachments-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.attachment-item {
    background: white;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.attachment-item:hover {
    transform: translateY(-2px);
}

.attachment-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    color: #667eea;
}

.response-section {
    background: #e8f5e8;
    border-radius: 8px;
    padding: 20px;
    margin: 15px 0;
    border-left: 4px solid #28a745;
}

.action-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.btn-action {
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-respond {
    background: #007bff;
    color: white;
}

.btn-respond:hover {
    background: #0056b3;
    color: white;
}

.btn-edit {
    background: #28a745;
    color: white;
}

.btn-edit:hover {
    background: #218838;
    color: white;
}

.btn-archive {
    background: #6c757d;
    color: white;
}

.btn-archive:hover {
    background: #545b62;
    color: white;
}

.btn-print {
    background: #17a2b8;
    color: white;
}

.btn-print:hover {
    background: #138496;
    color: white;
}

.history-timeline {
    position: relative;
    padding-left: 30px;
}

.history-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.history-item {
    position: relative;
    padding: 15px 0;
}

.history-item::before {
    content: '';
    position: absolute;
    left: -23px;
    top: 20px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #667eea;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.history-date {
    font-size: 12px;
    color: #6c757d;
    margin-bottom: 5px;
}

.history-description {
    color: #495057;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .manifestacao-header {
        padding: 20px;
        text-align: center;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .info-value {
        text-align: left;
    }
    
    .action-buttons {
        justify-content: center;
    }
    
    .attachments-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="container-fluid">
    <!-- Cabeçalho da Manifestação -->
    <div class="manifestacao-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="protocol-badge">
                    Protocolo: {{ $manifestacao->protocolo ?? 'OUV000001' }}
                </div>
                <h2 class="mb-2">{{ $manifestacao->assunto ?? 'Problema com atendimento na recepção' }}</h2>
                <p class="mb-0">
                    <i class="fas fa-user me-2"></i>{{ $manifestacao->nome_manifestante ?? 'Manifestante' }} • 
                    <i class="fas fa-calendar me-2"></i>{{ ($manifestacao->created_at ?? now())->format('d/m/Y H:i') }}
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="mb-2">
                    <span class="tipo-badge tipo-{{ $manifestacao->tipo ?? 'reclamacao' }}">
                        {{ ucfirst($manifestacao->tipo ?? 'Reclamação') }}
                    </span>
                </div>
                <div class="mb-2">
                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($manifestacao->status ?? 'pendente')) }}">
                        {{ $manifestacao->status ?? 'Pendente' }}
                    </span>
                </div>
                <div class="priority-indicator">
                    <span class="priority-dot priority-{{ $manifestacao->prioridade ?? 'media' }}"></span>
                    <span>Prioridade {{ ucfirst($manifestacao->prioridade ?? 'Média') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Timeline de Status -->
        <div class="status-timeline">
            <h6 class="mb-3">Progresso da Manifestação</h6>
            <div class="timeline-item">
                <div class="timeline-dot active"></div>
                <span>Manifestação Recebida</span>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot {{ in_array($manifestacao->status ?? 'pendente', ['em_andamento', 'respondida', 'arquivada']) ? 'active' : 'inactive' }}"></div>
                <span>Em Análise</span>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot {{ in_array($manifestacao->status ?? 'pendente', ['respondida', 'arquivada']) ? 'active' : 'inactive' }}"></div>
                <span>Respondida</span>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot {{ ($manifestacao->status ?? 'pendente') == 'arquivada' ? 'active' : 'inactive' }}"></div>
                <span>Arquivada</span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informações do Manifestante -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-user me-2"></i>Dados do Manifestante</h5>
                
                <div class="info-row">
                    <span class="info-label">Nome:</span>
                    <span class="info-value">{{ $manifestacao->nome_manifestante ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $manifestacao->email_manifestante ?? 'Não informado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Telefone:</span>
                    <span class="info-value">{{ $manifestacao->telefone_manifestante ?? 'Não informado' }}</span>
                </div>
                

                
                <div class="info-row">
                    <span class="info-label">Deseja Identificação:</span>
                    <span class="info-value">
                        @if($manifestacao->manifestacao_anonima ?? false)
                            <i class="fas fa-times-circle text-danger"></i> Anônimo
                        @else
                            <i class="fas fa-check-circle text-success"></i> Identificado
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Informações da Manifestação -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-file-alt me-2"></i>Dados da Manifestação</h5>
                
                <div class="info-row">
                    <span class="info-label">Protocolo:</span>
                    <span class="info-value">{{ $manifestacao->protocolo ?? 'OUV000001' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Tipo:</span>
                    <span class="info-value">
                        <span class="tipo-badge tipo-{{ $manifestacao->tipo ?? 'reclamacao' }}">
                            {{ ucfirst($manifestacao->tipo ?? 'Reclamação') }}
                        </span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($manifestacao->status ?? 'pendente')) }}">
                            {{ $manifestacao->status ?? 'Pendente' }}
                        </span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Prioridade:</span>
                    <span class="info-value">
                        <div class="priority-indicator">
                            <span class="priority-dot priority-{{ $manifestacao->prioridade ?? 'media' }}"></span>
                            <span>{{ ucfirst($manifestacao->prioridade ?? 'Média') }}</span>
                        </div>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Órgão Responsável:</span>
                    <span class="info-value">{{ $manifestacao->orgao ?? 'Secretaria de Administração' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Data de Recebimento:</span>
                    <span class="info-value">{{ ($manifestacao->created_at ?? now())->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Prazo de Resposta:</span>
                    <span class="info-value">
                        @php
                            $prazo = ($manifestacao->created_at ?? now())->addDays(20);
                            $diasRestantes = now()->diffInDays($prazo, false);
                        @endphp
                        {{ $prazo->format('d/m/Y') }}
                        <br>
                        <small class="text-{{ $diasRestantes < 0 ? 'danger' : ($diasRestantes <= 5 ? 'warning' : 'muted') }}">
                            @if($diasRestantes < 0)
                                {{ abs($diasRestantes) }} dias em atraso
                            @elseif($diasRestantes == 0)
                                Vence hoje
                            @else
                                {{ $diasRestantes }} dias restantes
                            @endif
                        </small>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo da Manifestação -->
    <div class="row">
        <div class="col-12">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-comment me-2"></i>Conteúdo da Manifestação</h5>
                
                <div class="content-section">
                    <h6>Assunto:</h6>
                    <p><strong>{{ $manifestacao->assunto ?? 'Problema com atendimento na recepção' }}</strong></p>
                    
                    <h6>Descrição:</h6>
                    <p>{{ $manifestacao->descricao ?? 'Gostaria de relatar um problema que ocorreu durante meu atendimento na recepção da Câmara Municipal. O funcionário foi muito mal educado e não soube me orientar adequadamente sobre os procedimentos necessários para protocolar minha solicitação. Espero que providências sejam tomadas para melhorar o atendimento ao público.' }}</p>
                    
                    @if($manifestacao->local_fato ?? false)
                    <h6>Local do Fato:</h6>
                    <p>{{ $manifestacao->local_fato }}</p>
                    @endif
                    
                    @if($manifestacao->data_fato ?? false)
                    <h6>Data do Fato:</h6>
                    <p>{{ $manifestacao->data_fato->format('d/m/Y') }}</p>
                    @endif
                </div>
                
                <!-- Anexos -->
                @if($manifestacao->anexos && $manifestacao->anexos->count() > 0)
                <h6 class="mt-4">Anexos:</h6>
                <div class="attachments-grid">
                    @foreach($manifestacao->anexos as $anexo)
                    <div class="attachment-item">
                        <div class="attachment-icon">
                            @if(str_contains($anexo->tipo_mime, 'image'))
                                <i class="fas fa-image"></i>
                            @elseif(str_contains($anexo->tipo_mime, 'pdf'))
                                <i class="fas fa-file-pdf"></i>
                            @else
                                <i class="fas fa-file"></i>
                            @endif
                        </div>
                        <div>
                            <strong>{{ $anexo->nome_original }}</strong><br>
                            <small class="text-muted">{{ $anexo->tamanho_formatado }}</small>
                        </div>
                        <a href="{{ route('ouvidoria.download-anexo', ['protocolo' => $manifestacao->protocolo, 'arquivo' => $anexo->nome_arquivo]) }}" class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                            <i class="fas fa-download me-1"></i>Baixar
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Resposta (se houver) -->
    @if(($manifestacao->status ?? 'pendente') == 'respondida' && isset($manifestacao->resposta))
    <div class="row">
        <div class="col-12">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-reply me-2"></i>Resposta da Ouvidoria</h5>
                
                <div class="response-section">
                    <div class="mb-3">
                        <strong>Data da Resposta:</strong> {{ ($manifestacao->respondida_em ?? now())->format('d/m/Y H:i') }}<br>
                        <strong>Responsável:</strong> {{ $manifestacao->responsavel_resposta ?? 'Ouvidor Municipal' }}
                    </div>
                    
                    <h6>Resposta:</h6>
                    <p>{{ $manifestacao->resposta ?? 'Agradecemos sua manifestação. Informamos que as providências necessárias foram tomadas junto ao setor responsável para melhorar o atendimento ao público. Sua contribuição é muito importante para aprimorarmos nossos serviços.' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Histórico -->
    <div class="row">
        <div class="col-12">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-history me-2"></i>Histórico de Movimentações</h5>
                
                <div class="history-timeline">
                    @if(($manifestacao->status ?? 'pendente') == 'respondida')
                    <div class="history-item">
                        <div class="history-date">{{ ($manifestacao->respondida_em ?? now())->format('d/m/Y H:i') }}</div>
                        <div class="history-description">
                            <strong>Manifestação respondida</strong><br>
                            Resposta enviada para o manifestante por {{ $manifestacao->responsavel_resposta ?? 'Ouvidor Municipal' }}
                        </div>
                    </div>
                    @endif
                    
                    @if(in_array($manifestacao->status ?? 'pendente', ['em_andamento', 'respondida', 'arquivada']))
                    <div class="history-item">
                        <div class="history-date">{{ ($manifestacao->data_inicio_analise ?? now()->subDays(2))->format('d/m/Y H:i') }}</div>
                        <div class="history-description">
                            <strong>Manifestação em análise</strong><br>
                            Manifestação encaminhada para análise do órgão responsável
                        </div>
                    </div>
                    @endif
                    
                    <div class="history-item">
                        <div class="history-date">{{ ($manifestacao->created_at ?? now())->format('d/m/Y H:i') }}</div>
                        <div class="history-description">
                            <strong>Manifestação recebida</strong><br>
                            Protocolo {{ $manifestacao->protocolo ?? 'OUV000001' }} gerado automaticamente
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tramitação Interna -->
    <div class="row">
        <div class="col-12">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-cogs me-2"></i>Tramitação Interna</h5>
                
                <!-- Observações Internas Atuais -->
                @if($manifestacao->observacoes_internas)
                <div class="content-section mb-3">
                    <h6>Observações Internas:</h6>
                    <p>{{ $manifestacao->observacoes_internas }}</p>
                </div>
                @endif
                
                <!-- Formulário para Nova Tramitação -->
                <form id="tramitacaoForm" action="{{ route('admin.ouvidoria-manifestacoes.tramitacao', $manifestacao->id ?? 1) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="setor_destino" class="form-label">Encaminhar para Setor</label>
                                <select class="form-select" id="setor_destino" name="setor_destino">
                                    <option value="">Selecione um setor...</option>
                                    <option value="Secretaria de Administração">Secretaria de Administração</option>
                                    <option value="Secretaria de Obras">Secretaria de Obras</option>
                                    <option value="Secretaria de Saúde">Secretaria de Saúde</option>
                                    <option value="Secretaria de Educação">Secretaria de Educação</option>
                                    <option value="Gabinete do Prefeito">Gabinete do Prefeito</option>
                                    <option value="Procuradoria Jurídica">Procuradoria Jurídica</option>
                                    <option value="Controladoria">Controladoria</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prioridade_tramitacao" class="form-label">Prioridade</label>
                                <select class="form-select" id="prioridade_tramitacao" name="prioridade">
                                    <option value="normal">Normal</option>
                                    <option value="alta">Alta</option>
                                    <option value="urgente">Urgente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observacoes_tramitacao" class="form-label">Observações da Tramitação</label>
                        <textarea class="form-control" id="observacoes_tramitacao" name="observacoes" rows="4" 
                                  placeholder="Digite observações internas sobre esta tramitação (não visível ao cidadão)..."></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Tramitar
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('tramitacaoForm').reset()">
                            <i class="fas fa-undo me-1"></i>Limpar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ações -->
    <div class="row">
        <div class="col-12">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-tools me-2"></i>Ações</h5>
                
                <div class="action-buttons">
                    @if(($manifestacao->status ?? 'pendente') != 'arquivada')
                    <button type="button" class="btn-action btn-respond" onclick="openResponseModal({{ $manifestacao->id ?? 1 }})">
                        <i class="fas fa-reply me-2"></i>Responder Manifestação
                    </button>
                    @endif
                    
                    <button type="button" class="btn-action btn-archive" onclick="archiveManifestacao()">
                        <i class="fas fa-archive me-2"></i>
                        {{ ($manifestacao->status ?? 'pendente') == 'arquivada' ? 'Desarquivar' : 'Arquivar' }}
                    </button>
                    
                    <button type="button" class="btn-action btn-print" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Imprimir
                    </button>
                    
                    <a href="{{ route('admin.ouvidoria-manifestacoes.index') }}" class="btn-action" style="background: #6c757d; color: white;">
                        <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Resposta -->
<div class="modal fade" id="responseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Responder Manifestação #{{ $manifestacao->protocolo ?? 'OUV000001' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="responseForm" action="{{ route('admin.ouvidoria-manifestacoes.responder', $manifestacao->id ?? 1) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="response_status" class="form-label">Novo Status</label>
                        <select class="form-select" id="response_status" name="status" required>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="respondida">Respondida</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="response_text" class="form-label">Resposta</label>
                        <textarea class="form-control" id="response_text" name="resposta" rows="6" 
                                  placeholder="Digite a resposta para o manifestante..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="orgao_responsavel" class="form-label">Órgão Responsável</label>
                        <select class="form-select" id="orgao_responsavel" name="orgao_responsavel">
                            <option value="Secretaria de Administração">Secretaria de Administração</option>
                            <option value="Secretaria de Obras">Secretaria de Obras</option>
                            <option value="Secretaria de Saúde">Secretaria de Saúde</option>
                            <option value="Secretaria de Educação">Secretaria de Educação</option>
                            <option value="Gabinete do Prefeito">Gabinete do Prefeito</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="send_email" name="send_email" checked>
                            <label class="form-check-label" for="send_email">
                                Enviar resposta por email para o manifestante
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Resposta</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/ouvidoria-manifestacoes.js') }}"></script>
<script>
// Função específica para show.blade.php - arquivar manifestação
function archiveManifestacao() {
    const isArchived = '{{ $manifestacao->status ?? "pendente" }}' === 'arquivada';
    const action = isArchived ? 'desarquivar' : 'arquivar';
    
    if (confirm(`Tem certeza que deseja ${action} esta manifestação?`)) {
        fetch(`/admin/ouvidoria-manifestacoes/{{ $manifestacao->id ?? 1 }}/archive`, {
            method: 'POST',
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
                alert(`Erro ao ${action} manifestação`);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert(`Erro ao ${action} manifestação`);
        });
    }
}
</script>
@endpush
@endsection