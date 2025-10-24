@extends('layouts.ouvidor')

@section('title', 'Solicitação E-SIC #' . $solicitacao->protocolo)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/esic.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Cabeçalho -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('ouvidor.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('ouvidor.esic.index') }}">E-SIC</a>
                            </li>
                            <li class="breadcrumb-item active">Protocolo #{{ $solicitacao->protocolo }}</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-file-alt text-primary me-2"></i>
                        Solicitação E-SIC #{{ $solicitacao->protocolo }}
                    </h1>
                </div>
                <div>
                    @php
                        $statusClass = match($solicitacao->status) {
                            'pendente' => 'warning',
                            'em_analise' => 'info',
                            'aguardando_informacoes' => 'secondary',
                            'informacoes_recebidas' => 'primary',
                            'respondida' => 'success',
                            'negada' => 'danger',
                            'finalizada' => 'dark',
                            default => 'light'
                        };
                        $statusText = match($solicitacao->status) {
                            'pendente' => 'Pendente',
                            'em_analise' => 'Em Análise',
                            'aguardando_informacoes' => 'Aguardando Informações',
                            'informacoes_recebidas' => 'Informações Recebidas',
                            'respondida' => 'Respondida',
                            'negada' => 'Negada',
                            'finalizada' => 'Finalizada',
                            'arquivada' => 'Arquivada',
                            default => ucfirst($solicitacao->status)
                        };
                    @endphp
                    <span class="badge bg-{{ $statusClass }} fs-6 me-2">{{ $statusText }}</span>
                    
                    @if($solicitacao->aguardandoEncerramento())
                        <div class="status-encerramento-fixo mt-2 mb-0" style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 0.375rem; padding: 0.75rem 1rem; color: #856404;">
                            <i class="fas fa-clock me-2" style="color: #856404;"></i>
                            <strong>Aguardando Encerramento:</strong> 
                            Finalização solicitada em {{ $solicitacao->data_finalizacao_solicitada->format('d/m/Y H:i') }}. 
                            Encerramento automático em {{ $solicitacao->diasParaEncerramentoFormatado() }}.
                        </div>
                    @endif
                    

                </div>
            </div>

            <div class="row">
                <!-- Coluna Principal -->
                <div class="col-lg-8">
                    <!-- Informações da Solicitação -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informações da Solicitação
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Protocolo:</label>
                                        <div class="text-primary fw-bold">#{{ $solicitacao->protocolo }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Data da Solicitação:</label>
                                        <div>{{ $solicitacao->data_solicitacao->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Categoria:</label>
                                        <div>{{ ucfirst(str_replace('_', ' ', $solicitacao->categoria ?? 'Não informada')) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Prazo de Resposta:</label>
                                        @if($solicitacao->data_limite_resposta)
                                            @php
                                                $prazo = \Carbon\Carbon::parse($solicitacao->data_limite_resposta);
                                                $hoje = \Carbon\Carbon::now();
                                                $diasRestantes = $hoje->diffInDays($prazo, false);
                                            @endphp
                                            
                                            <div>
                                                {{ $prazo->format('d/m/Y') }}
                                                @if($diasRestantes < 0)
                                                    <span class="badge bg-danger ms-2">Vencida</span>
                                                @elseif($diasRestantes <= 3)
                                                    <span class="badge bg-warning ms-2">Vencendo</span>
                                                @else
                                                    <span class="badge bg-success ms-2">No Prazo</span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-muted">Não definido</div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Forma de Recebimento:</label>
                                        <div>{{ ucfirst($solicitacao->forma_recebimento ?? 'Sistema') }}</div>
                                    </div>
                                    @if($solicitacao->tags)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tags:</label>
                                            <div>
                                                @foreach($solicitacao->tags as $tag)
                                                    <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Assunto:</label>
                                <div class="bg-light p-3 rounded">{{ $solicitacao->assunto }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Descrição:</label>
                                <div class="bg-light p-3 rounded">{{ $solicitacao->descricao }}</div>
                            </div>

                            @if($solicitacao->anexos && count($solicitacao->anexos) > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Anexos da Solicitação:</label>
                                    <div class="list-group">
                                        @foreach($solicitacao->anexos as $anexo)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-paperclip me-2"></i>
                                                    {{ $anexo['nome_original'] ?? $anexo }}
                                                </div>
                                                <a href="{{ Storage::url($anexo['caminho'] ?? $anexo) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>





                    <!-- Comunicação -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-comments me-2"></i>
                                Comunicação
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Formulário de Nova Comunicação -->
                            @if(!in_array($solicitacao->status, ['finalizada', 'arquivada']))
                            <div class="communication-form mb-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Nova Comunicação
                                </h6>
                                <form id="chatForm" action="{{ route('ouvidor.esic.enviar-mensagem', $solicitacao) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="mensagem" class="form-label fw-bold">Mensagem</label>
                                        <textarea class="form-control" id="mensagem" name="mensagem" rows="4" 
                                                  placeholder="Digite sua mensagem ou resposta para o cidadão..." required></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="canal_comunicacao" class="form-label fw-bold">Canal de Comunicação</label>
                                        <select class="form-select" id="canal_comunicacao" name="canal_comunicacao" required>
                                            <option value="sistema">💬 Sistema</option>
                                            <option value="email">📧 E-mail</option>
                                            <option value="telefone">📞 Telefone</option>
                                            <option value="whatsapp">📱 WhatsApp</option>
                                            <option value="presencial">👥 Presencial</option>
                                            <option value="carta">📮 Carta</option>
                                            <option value="outro">🔧 Outro</option>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="anexos" class="form-label">Anexar Arquivos (opcional)</label>
                                                <input type="file" class="form-control" id="anexos" name="anexos[]" multiple>
                                                <small class="text-muted">Máximo 5 arquivos, 10MB cada</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tipo de Comunicação</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_comunicacao" id="mensagem_simples" value="mensagem" checked>
                                                    <label class="form-check-label" for="mensagem_simples">
                                                        <i class="fas fa-comment me-1"></i> Mensagem
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_comunicacao" id="resposta_oficial" value="resposta_oficial">
                                                    <label class="form-check-label" for="resposta_oficial">
                                                        <i class="fas fa-certificate me-1"></i> Resposta Oficial
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_comunicacao" id="comunicacao_interna" value="comunicacao_interna">
                                                    <label class="form-check-label" for="comunicacao_interna">
                                                        <i class="fas fa-lock me-1 text-warning"></i> <span class="text-warning">Comunicação Interna</span>
                                                        <small class="d-block text-muted">Não será enviada ao solicitante</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-1"></i>
                                            Enviar
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>
                                            Limpar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            @endif

                            <!-- Histórico Completo de Comunicação -->
                            <div class="communication-history">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">
                                        <i class="fas fa-history me-2"></i>
                                        Histórico Completo
                                    </h6>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <input type="radio" class="btn-check" name="ordenacao" id="ordem_asc" value="asc" checked>
                                        <label class="btn btn-outline-primary" for="ordem_asc" title="Mais antigo primeiro">
                                            <i class="fas fa-sort-amount-up"></i>
                                        </label>
                                        <input type="radio" class="btn-check" name="ordenacao" id="ordem_desc" value="desc">
                                        <label class="btn btn-outline-primary" for="ordem_desc" title="Mais recente primeiro">
                                            <i class="fas fa-sort-amount-down"></i>
                                        </label>
                                    </div>
                                </div>

                                @php
                                    $todasComunicacoes = collect();
                                    $isAdmin = auth()->user() && auth()->user()->hasRole(['admin', 'ouvidor']);
                                    
                                    // Resposta oficial (se existir)
                                    if($solicitacao->resposta) {
                                        $todasComunicacoes->push((object)[
                                            'tipo' => 'resposta',
                                            'data' => $solicitacao->data_resposta ?? $solicitacao->updated_at,
                                            'conteudo' => $solicitacao->resposta,
                                            'autor' => 'Ouvidor',
                                            'oficial' => true,
                                            'visivel_cidadao' => true,
                                            'categoria' => 'comunicacao'
                                        ]);
                                    }
                                    
                                    // Mensagens
                                    if($solicitacao->mensagens) {
                                        foreach($solicitacao->mensagens as $msg) {
                                            $isInterna = $msg->interna || $msg->tipo_comunicacao === 'comunicacao_interna';
                                            $todasComunicacoes->push((object)[
                                                'tipo' => 'mensagem',
                                                'data' => $msg->created_at,
                                                'conteudo' => $msg->mensagem,
                                                'autor' => $msg->tipo_remetente === 'ouvidor' ? 'Ouvidor' : 'Cidadão',
                                                'anexos' => $msg->anexos,
                                                'oficial' => $msg->tipo_comunicacao === 'resposta_oficial',
                                                'visivel_cidadao' => !$isInterna,
                                                'categoria' => $isInterna ? 'interna' : 'comunicacao',
                                                'objeto' => $msg
                                            ]);
                                        }
                                    }

                                    // Alterações de Status (apenas para administradores)
                                    if($isAdmin && $solicitacao->movimentacoes) {
                                        foreach($solicitacao->movimentacoes as $mov) {
                                            $todasComunicacoes->push((object)[
                                                'tipo' => 'status',
                                                'data' => $mov->created_at,
                                                'conteudo' => "Status alterado para: " . $mov->getStatusFormatado(),
                                                'autor' => 'Sistema',
                                                'oficial' => false,
                                                'visivel_cidadao' => false,
                                                'categoria' => 'sistema',
                                                'status_atual' => $mov->status,
                                                'observacoes' => $mov->descricao
                                            ]);
                                        }
                                    }


                                    
                                    $todasComunicacoes = $todasComunicacoes->sortBy('data');
                                @endphp

                                <div id="chatMessages" class="historico-comunicacao" style="max-height: 400px; overflow-y: auto;">
                                    @forelse($todasComunicacoes as $comunicacao)
                                        @if($isAdmin || $comunicacao->visivel_cidadao)
                                        <div class="message-item mb-3 {{ $comunicacao->autor === 'Ouvidor' ? 'message-ouvidor' : ($comunicacao->autor === 'Sistema' ? 'message-sistema' : 'message-cidadao') }}" 
                                             data-timestamp="{{ $comunicacao->data->timestamp }}">
                                            <div class="message-content">
                                                <div class="message-header d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <strong class="{{ $comunicacao->autor === 'Ouvidor' ? 'text-primary' : ($comunicacao->autor === 'Sistema' ? 'text-warning' : 'text-secondary') }}">
                                                            <i class="fas {{ $comunicacao->autor === 'Ouvidor' ? 'fa-user-tie' : ($comunicacao->autor === 'Sistema' ? 'fa-cog' : 'fa-user') }}"></i>
                                                            {{ $comunicacao->autor }}
                                                        </strong>
                                                        @if($comunicacao->oficial)
                                                            <span class="badge bg-success ms-2">
                                                                <i class="fas fa-certificate"></i> Resposta Oficial
                                                            </span>
                                                        @endif
                                                        @if($comunicacao->categoria === 'interna')
                                                            <span class="badge bg-warning ms-2">
                                                                <i class="fas fa-eye-slash"></i> Interno
                                                            </span>
                                                        @endif
                                                        @if($comunicacao->categoria === 'sistema')
                                                            <span class="badge bg-info ms-2">
                                                                <i class="fas fa-cog"></i> Sistema
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">{{ $comunicacao->data->format('d/m/Y H:i') }}</small>
                                                </div>
                                                
                                                <div class="message-text {{ $comunicacao->oficial ? 'message-success' : ($comunicacao->categoria === 'sistema' ? 'message-info' : ($comunicacao->categoria === 'interna' ? 'message-warning' : '')) }}">
                                                    {!! nl2br(e($comunicacao->conteudo)) !!}
                                                    
                                                    @if($comunicacao->tipo === 'status' && isset($comunicacao->observacoes) && $comunicacao->observacoes)
                                                        <div class="mt-2">
                                                            <strong>Observações:</strong> {{ $comunicacao->observacoes }}
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($comunicacao->tipo === 'mensagem' && isset($comunicacao->anexos) && $comunicacao->anexos)
                                                    @php
                                                        $anexos = is_string($comunicacao->anexos) ? json_decode($comunicacao->anexos, true) : $comunicacao->anexos;
                                                    @endphp
                                                    @if($anexos && count($anexos) > 0)
                                                    <div class="message-attachments mt-2">
                                                        <i class="fas fa-paperclip me-1"></i>
                                                        @foreach($anexos as $anexo)
                                                        <a href="{{ route('ouvidor.esic.download-anexo-mensagem', $comunicacao->objeto) }}?arquivo={{ urlencode($anexo['nome_original']) }}" 
                                                           class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="fas fa-download me-1"></i>{{ $anexo['nome_original'] }}
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Nenhuma comunicação registrada.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                                    
                </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Informações do Solicitante -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    Solicitante
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($solicitacao->anonima)
                                    <div class="text-center py-3">
                                        <i class="fas fa-user-secret fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">Solicitação Anônima</h6>
                                        <p class="text-muted small">
                                            Os dados do solicitante não foram fornecidos.
                                        </p>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nome:</label>
                                        <div>{{ $solicitacao->nome_solicitante }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">E-mail:</label>
                                        <div>
                                            <a href="mailto:{{ $solicitacao->email_solicitante }}">
                                                {{ $solicitacao->email_solicitante }}
                                            </a>
                                        </div>
                                    </div>
                                    @if($solicitacao->telefone_solicitante)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Telefone:</label>
                                            <div>{{ $solicitacao->telefone_solicitante }}</div>
                                        </div>
                                    @endif
                                    @if($solicitacao->cpf_solicitante)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">CPF:</label>
                                            <div>{{ $solicitacao->cpf_solicitante }}</div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Ações Essenciais -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-tools me-2"></i>
                                    Ações Essenciais
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#alterarStatusModal">
                                        <i class="fas fa-edit me-1"></i>
                                        Alterar Status
                                    </button>
                                    @if(in_array($solicitacao->status, ['respondida', 'parcialmente_respondida']) && !$solicitacao->aguardandoEncerramento())
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#solicitarFinalizacaoModal">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Finalizar
                                        </button>
                                    @endif
                                    @if(!in_array($solicitacao->status, ['arquivada', 'finalizada']))
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#arquivarModal">
                                            <i class="fas fa-archive me-1"></i>
                                            Arquivar
                                        </button>
                                    @endif
                                    <a href="{{ route('ouvidor.esic.index') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-arrow-left me-1"></i>
                                        Voltar à Lista
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Informações Técnicas -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info me-2"></i>
                                    Informações Técnicas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>Origem:</strong> {{ ucfirst($solicitacao->origem ?? 'Sistema') }}
                                </div>
                                @if($solicitacao->responsavel)
                                    <div class="mb-2">
                                        <strong>Responsável:</strong> {{ $solicitacao->responsavel->name }}
                                    </div>
                                @endif
                                <div class="mb-2">
                                    <strong>Criada em:</strong> {{ $solicitacao->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="mb-2">
                                    <strong>Atualizada em:</strong> {{ $solicitacao->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Alterar Status -->
<div class="modal fade" id="alterarStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('ouvidor.esic.alterar-status', $solicitacao) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Alterar Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_novo" class="form-label">Novo Status</label>
                        <select name="status" id="status_novo" class="form-select" required>
                            <option value="pendente" {{ $solicitacao->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="em_analise" {{ $solicitacao->status == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
                            <option value="aguardando_informacoes" {{ $solicitacao->status == 'aguardando_informacoes' ? 'selected' : '' }}>Aguardando Informações</option>
                            <option value="respondida" {{ $solicitacao->status == 'respondida' ? 'selected' : '' }}>Respondida</option>
                            <option value="negada" {{ $solicitacao->status == 'negada' ? 'selected' : '' }}>Negada</option>
                            <option value="finalizada" {{ $solicitacao->status == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes_status" class="form-label">Observações (opcional)</label>
                        <textarea name="observacoes" id="observacoes_status" class="form-control" rows="3" 
                                  placeholder="Motivo da alteração de status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>
                        Alterar Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Adicionar Tramitação -->
<div class="modal fade" id="tramitacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('ouvidor.esic.tramitacao', $solicitacao) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>
                        Adicionar Tramitação
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="acao" class="form-label">Ação</label>
                        <input type="text" name="acao" id="acao" class="form-control" required 
                               placeholder="Ex: Solicitação de informações adicionais">
                    </div>
                    <div class="mb-3">
                        <label for="descricao_tramitacao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao_tramitacao" class="form-control" rows="3" required 
                                  placeholder="Descreva a ação realizada..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes_tramitacao" class="form-label">Observações (opcional)</label>
                        <textarea name="observacoes" id="observacoes_tramitacao" class="form-control" rows="2" 
                                  placeholder="Observações adicionais..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-plus me-1"></i>
                        Adicionar Tramitação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Arquivar -->
<div class="modal fade" id="arquivarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('ouvidor.esic.arquivar', $solicitacao) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-archive me-2"></i>
                        Arquivar Solicitação
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção!</strong> Esta ação irá arquivar a solicitação. Você tem certeza?
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo do Arquivamento</label>
                        <textarea name="motivo" id="motivo" class="form-control" rows="3" required 
                                  placeholder="Informe o motivo do arquivamento..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-archive me-1"></i>
                        Arquivar Solicitação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Solicitar Finalização -->
@if(in_array($solicitacao->status, ['respondida', 'parcialmente_respondida']) && !$solicitacao->aguardandoEncerramento())
<div class="modal fade" id="solicitarFinalizacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('ouvidor.esic.solicitar-finalizacao', $solicitacao) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-flag-checkered me-2"></i>
                        Solicitar Finalização
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Atenção:</strong> Ao solicitar a finalização, será enviada uma mensagem ao solicitante 
                        informando que a solicitação foi atendida e solicitando que ele confirme o encerramento. 
                        Caso não haja manifestação em 10 dias corridos, a solicitação será encerrada automaticamente.
                    </div>
                    <div class="mb-3">
                        <label for="mensagem_finalizacao" class="form-label">Mensagem de Finalização</label>
                        <textarea name="mensagem_finalizacao" id="mensagem_finalizacao" class="form-control" rows="6" required 
                                  placeholder="Digite a mensagem que será enviada ao solicitante...">Prezado(a) solicitante,

Informamos que sua solicitação foi atendida conforme as informações fornecidas anteriormente.

Caso considere que sua solicitação foi adequadamente respondida, solicitamos que confirme o encerramento da mesma.

Se não houver manifestação em 10 (dez) dias corridos, a solicitação será automaticamente encerrada.

Atenciosamente,
Ouvidoria</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i>
                        Enviar Solicitação de Finalização
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
.status-encerramento-fixo {
    background-color: #fff3cd !important;
    border: 1px solid #ffeaa7 !important;
    border-radius: 0.375rem !important;
    padding: 0.75rem 1rem !important;
    color: #856404 !important;
    font-weight: 500 !important;
    position: relative !important;
    z-index: 1000 !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.status-encerramento-fixo i {
    color: #856404 !important;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 4px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.badge {
    font-size: 0.875rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.list-group-item {
    border: 1px solid #dee2e6;
}

.modal-header {
    background-color: #f8f9fa;
}

.form-text {
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/esic-show.js') }}"></script>
<script src="{{ asset('js/esic-chat.js') }}"></script>
<script>
// Proteção para a mensagem de encerramento fixo
document.addEventListener('DOMContentLoaded', function() {
    const statusEncerramento = document.querySelector('.status-encerramento-fixo');
    if (statusEncerramento) {
        // Proteger contra remoção
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.removedNodes.forEach(function(node) {
                        if (node.classList && node.classList.contains('status-encerramento-fixo')) {
                            // Recriar a mensagem se for removida
                            const parent = mutation.target;
                            parent.appendChild(node);
                        }
                    });
                }
            });
        });
        
        observer.observe(statusEncerramento.parentNode, {
            childList: true,
            subtree: true
        });
        
        // Proteger contra ocultação
        setInterval(function() {
            if (statusEncerramento.style.display === 'none' || 
                statusEncerramento.style.visibility === 'hidden' ||
                statusEncerramento.style.opacity === '0') {
                statusEncerramento.style.display = 'block';
                statusEncerramento.style.visibility = 'visible';
                statusEncerramento.style.opacity = '1';
            }
        }, 1000);
    }
});
</script>
@endpush