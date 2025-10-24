@extends('layouts.app')

@section('title', 'Solicitação #' . $solicitacao->protocolo . ' - E-SIC')

@section('content')
<div class="esic-chat-page">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <!-- Header Compacto -->
                <div class="chat-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="header-info">
                            <h4 class="mb-1">
                                <i class="fas fa-comments me-2 text-primary"></i>
                                {{ $solicitacao->protocolo }}
                            </h4>
                            <small class="text-muted">E-SIC - Câmara Municipal</small>
                        </div>
                        <div class="status-indicator">
                            <span class="badge badge-{{ $solicitacao->status }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $solicitacao->status)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informações da Solicitação - Compacta -->
                <div class="request-summary">
                    <div class="summary-header" data-bs-toggle="collapse" data-bs-target="#requestDetails" aria-expanded="false">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-file-alt me-2"></i>
                                    {{ $solicitacao->assunto }}
                                </h6>
                                <small class="text-muted">
                                    {{ $solicitacao->created_at->format('d/m/Y H:i') }} • 
                                    {{ ucfirst(str_replace('_', ' ', $solicitacao->categoria)) }}
                                    @if($solicitacao->data_resposta)
                                        • Respondida em {{ \Carbon\Carbon::parse($solicitacao->data_resposta)->format('d/m/Y') }}
                                    @else
                                        • Prazo: {{ $solicitacao->created_at->addDays(20)->format('d/m/Y') }}
                                    @endif
                                </small>
                            </div>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                    </div>
                    
                    <div class="collapse" id="requestDetails">
                        <div class="summary-content">
                            <div class="request-description">
                                <strong>Descrição:</strong>
                                <p class="mb-2">{!! nl2br(e($solicitacao->descricao)) !!}</p>
                            </div>
                            
                            <div class="request-meta">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Solicitante</small>
                                        <span class="fw-medium">{{ $solicitacao->anonima ? 'Anônimo' : $solicitacao->nome_solicitante }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Recebimento</small>
                                        <span class="fw-medium">{{ ucfirst($solicitacao->forma_recebimento) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações do Usuário -->
                @if(auth()->check() && auth()->user()->email === $solicitacao->email_solicitante)
                    @if($solicitacao->aguardandoEncerramento())
                    <div class="user-actions mb-4">
                        <div class="alert alert-warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="fas fa-clock me-2"></i>
                                        Solicitação Aguardando Encerramento
                                    </h6>
                                    <p class="mb-0 small">
                                        Sua solicitação foi processada e está aguardando seu encerramento. 
                                        Você pode encerrá-la agora ou aguardar o encerramento automático.
                                    </p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#finalizarModal">
                                        <i class="fas fa-check me-1"></i>
                                        Encerrar Solicitação
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

                <!-- Chat de Comunicação -->
                @if(auth()->check() && auth()->user()->email === $solicitacao->email_solicitante)
                <div class="chat-container">
                    @php
                        // Coletar todas as comunicações visíveis ao cidadão
                        $todasComunicacoes = collect();
                        
                        // Adicionar resposta oficial antiga (se existir)
                        if($solicitacao->resposta) {
                            $todasComunicacoes->push((object)[
                                'id' => 'resposta-oficial',
                                'tipo' => 'resposta_oficial',
                                'remetente' => 'Câmara Municipal',
                                'conteudo' => $solicitacao->resposta,
                                'data' => $solicitacao->data_resposta ? \Carbon\Carbon::parse($solicitacao->data_resposta) : $solicitacao->updated_at,
                                'anexos' => null,
                                'canal' => 'oficial',
                                'timestamp' => $solicitacao->data_resposta ? \Carbon\Carbon::parse($solicitacao->data_resposta)->timestamp : $solicitacao->updated_at->timestamp
                            ]);
                        }
                        
                        // Adicionar mensagens do sistema (apenas as visíveis ao cidadão)
                        foreach($solicitacao->mensagens as $mensagem) {
                            if (!$mensagem->interna) { // Apenas mensagens não internas
                                $tipo = $mensagem->tipo_remetente === 'cidadao' ? 'mensagem_cidadao' : 
                                       ($mensagem->tipo_comunicacao === 'resposta_oficial' ? 'resposta_oficial' : 'mensagem_ouvidor');
                                
                                $todasComunicacoes->push((object)[
                                    'id' => 'mensagem-' . $mensagem->id,
                                    'tipo' => $tipo,
                                    'remetente' => $mensagem->tipo_remetente === 'cidadao' ? 'Você' : ($mensagem->usuario->name ?? 'Câmara Municipal'),
                                    'conteudo' => $mensagem->mensagem,
                                    'data' => $mensagem->created_at,
                                    'anexos' => $mensagem->anexos,
                                    'canal' => $mensagem->canal_comunicacao ?? 'sistema',
                                    'timestamp' => $mensagem->created_at->timestamp,
                                    'mensagem_obj' => $mensagem
                                ]);
                            }
                        }
                        
                        // Ordenar por data (mais antigo primeiro por padrão)
                        $todasComunicacoes = $todasComunicacoes->sortBy('timestamp');
                    @endphp

                    <!-- Chat Input (Formulário no Topo) -->
                    @if(!in_array($solicitacao->status, ['finalizada', 'arquivada']))
                    <div class="chat-input">
                        <form method="POST" action="{{ route('esic.enviar-mensagem', $solicitacao->protocolo) }}" 
                              enctype="multipart/form-data" id="chatForm">
                            @csrf
                            <div class="input-group">
                                <textarea class="form-control chat-textarea" id="mensagem" name="mensagem" 
                                          placeholder="Digite sua mensagem..." rows="1" required maxlength="5000"></textarea>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-send" id="sendBtn">
                                        <i class="fas fa-paper-plane"></i>
                                        <span class="btn-text">Enviar</span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Contador de caracteres -->
                            <div class="char-counter mt-2">
                                <small class="text-muted">
                                    <span id="charCount">0</span>/5000 caracteres
                                </small>
                            </div>
                            
                            <!-- Seção de Anexos -->
                            <div class="mt-3">
                                <div class="mb-3">
                                    <label for="anexos" class="form-label">Anexar Arquivos (opcional)</label>
                                    <input type="file" class="form-control" id="anexos" name="anexos[]" multiple
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt">
                                    <small class="text-muted">Máximo 5 arquivos, 10MB cada</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="chat-disabled">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Chat desabilitado devido ao status da solicitação.
                        </div>
                    </div>
                    @endif

                    <!-- Chat Messages (Histórico Abaixo) -->
                    <div class="chat-messages" id="chatMessages">
                        @forelse($todasComunicacoes as $comunicacao)
                        <div class="chat-message {{ $comunicacao->tipo === 'mensagem_cidadao' ? 'sent' : 'received' }}" data-timestamp="{{ $comunicacao->timestamp }}">
                            <div class="message-bubble">
                                <div class="message-header">
                                    <span class="sender-name">
                                        @if($comunicacao->tipo === 'mensagem_cidadao')
                                            <i class="fas fa-user me-1"></i>Você
                                        @elseif($comunicacao->tipo === 'resposta_oficial')
                                            <i class="fas fa-stamp me-1"></i>{{ $comunicacao->remetente }}
                                            <span class="badge bg-warning text-dark ms-1">Oficial</span>
                                        @else
                                            <i class="fas fa-user-tie me-1"></i>{{ $comunicacao->remetente }}
                                        @endif
                                    </span>
                                    <span class="message-time">{{ $comunicacao->data->format('d/m H:i') }}</span>
                                </div>
                                
                                <div class="message-content">
                                    {!! nl2br(e($comunicacao->conteudo)) !!}
                                </div>
                                
                                @if($comunicacao->canal && $comunicacao->canal !== 'sistema' && $comunicacao->canal !== 'oficial')
                                <div class="message-channel">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Via {{ ucfirst($comunicacao->canal) }}
                                </div>
                                @endif
                                
                                @if($comunicacao->anexos && isset($comunicacao->mensagem_obj))
                                    @php
                                        $anexos = is_string($comunicacao->anexos) ? json_decode($comunicacao->anexos, true) : $comunicacao->anexos;
                                    @endphp
                                    @if($anexos && count($anexos) > 0)
                                    <div class="message-attachments">
                                        @foreach($anexos as $anexo)
                                        <a href="{{ route('esic.download-anexo-mensagem', $comunicacao->mensagem_obj) }}?arquivo={{ urlencode($anexo['nome_original']) }}" 
                                           class="attachment-link">
                                            <i class="fas fa-paperclip me-1"></i>{{ $anexo['nome_original'] }}
                                        </a>
                                        @endforeach
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="chat-empty">
                            <div class="empty-state">
                                <i class="fas fa-comments"></i>
                                <h6>Nenhuma mensagem ainda</h6>
                                <p>Envie uma mensagem para iniciar a conversa com a equipe responsável.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                @endif

                <!-- Status Timeline Compacta -->
                <div class="status-timeline">
                    <div class="timeline-header">
                        <h6><i class="fas fa-route me-2"></i>Andamento</h6>
                    </div>
                    <div class="timeline-steps">
                        <div class="step completed">
                            <div class="step-icon"><i class="fas fa-check"></i></div>
                            <div class="step-content">
                                <span class="step-title">Recebida</span>
                                <small>{{ $solicitacao->created_at->format('d/m') }}</small>
                            </div>
                        </div>
                        
                        <div class="step {{ in_array($solicitacao->status, ['em_analise', 'aguardando_informacoes', 'respondida', 'negada']) ? 'completed' : 'pending' }}">
                            <div class="step-icon">
                                <i class="fas {{ in_array($solicitacao->status, ['em_analise', 'aguardando_informacoes', 'respondida', 'negada']) ? 'fa-check' : 'fa-clock' }}"></i>
                            </div>
                            <div class="step-content">
                                <span class="step-title">Em Análise</span>
                                <small>{{ $solicitacao->status !== 'pendente' ? $solicitacao->updated_at->format('d/m') : 'Aguardando' }}</small>
                            </div>
                        </div>
                        
                        <div class="step {{ in_array($solicitacao->status, ['respondida', 'negada']) ? 'completed' : 'pending' }}">
                            <div class="step-icon">
                                <i class="fas {{ in_array($solicitacao->status, ['respondida', 'negada']) ? 'fa-check' : 'fa-clock' }}"></i>
                            </div>
                            <div class="step-content">
                                <span class="step-title">
                                    {{ $solicitacao->status === 'negada' ? 'Negada' : 'Respondida' }}
                                </span>
                                <small>
                                    {{ in_array($solicitacao->status, ['respondida', 'negada']) && $solicitacao->data_resposta 
                                        ? \Carbon\Carbon::parse($solicitacao->data_resposta)->format('d/m') 
                                        : 'Aguardando' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="actions-section">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('esic.consultar') }}" class="btn btn-outline-primary">
                                <i class="fas fa-search me-2"></i>
                                Consultar Outra Solicitação
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('esic.public') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>
                                Voltar ao E-SIC
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informações de Recurso -->
                @if($solicitacao->status === 'negada')
                <div class="alert alert-info mt-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Direito de Recurso</h5>
                    <p>
                        Caso não concorde com a negativa, você tem o direito de apresentar recurso no prazo de 10 dias 
                        a partir da ciência da decisão. Entre em contato conosco através dos canais oficiais.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Encerramento -->
@if(auth()->check() && auth()->user()->email === $solicitacao->email_solicitante && $solicitacao->aguardandoEncerramento())
<div class="modal fade" id="finalizarModal" tabindex="-1" aria-labelledby="finalizarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarModalLabel">
                    <i class="fas fa-check-circle me-2 text-success"></i>
                    Encerrar Solicitação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('esic.finalizar', $solicitacao->protocolo) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Protocolo:</strong> {{ $solicitacao->protocolo }}
                    </div>
                    
                    <p>Tem certeza de que deseja encerrar esta solicitação?</p>
                    
                    <div class="mb-3">
                        <label for="mensagem_finalizacao" class="form-label">
                            Mensagem de encerramento (opcional)
                        </label>
                        <textarea 
                            class="form-control" 
                            id="mensagem_finalizacao" 
                            name="mensagem_finalizacao" 
                            rows="3" 
                            placeholder="Digite uma mensagem de encerramento se desejar..."
                        ></textarea>
                        <div class="form-text">
                            Esta mensagem será registrada no histórico da solicitação.
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção:</strong> Após o encerramento, não será mais possível enviar mensagens ou fazer alterações nesta solicitação.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>
                        Confirmar Encerramento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/esic.css') }}?v={{ time() }}">
<style>
/* Força cor branca para mensagens do cidadão - MÁXIMA PRIORIDADE */
.esic-chat-page .chat-message.sent,
.esic-chat-page .chat-message.sent *,
.esic-chat-page .chat-message.sent .message-bubble,
.esic-chat-page .chat-message.sent .message-bubble *,
.esic-chat-page .chat-message.sent .message-content,
.esic-chat-page .chat-message.sent .message-header,
.esic-chat-page .chat-message.sent .sender-name,
.esic-chat-page .chat-message.sent .message-time,
.esic-chat-page .chat-message.sent .message-channel {
    color: #ffffff !important;
    text-shadow: none !important;
}

.esic-chat-page .chat-message.sent .message-bubble {
    background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%) !important;
    color: #ffffff !important;
}

/* Força especificamente o conteúdo da mensagem */
.esic-chat-page .chat-messages .chat-message.sent .message-content {
    color: #ffffff !important;
    background: transparent !important;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/esic-show.js') }}"></script>
<script src="{{ asset('js/esic-chat.js') }}"></script>
@endpush