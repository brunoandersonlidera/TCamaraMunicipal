@extends('layouts.admin')

@section('title', 'Carta de Serviço: ' . ($cartaServico->nome ?? 'Protocolo de Documentos'))

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.cartas-servico.index') }}">Cartas de Serviços</a></li>
        <li class="breadcrumb-item active">{{ $cartaServico->nome ?? 'Protocolo de Documentos' }}</li>
    </ol>
</nav>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cartas-servico.css') }}">
@endpush

@section('content')

<div class="container-fluid">
    <div class="service-container">
        <!-- Cabeçalho do Serviço -->
        <div class="service-header">
            <div class="service-header-content">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="service-icon-large">
                            <i class="fas fa-{{ $cartaServico->icone ?? 'file-alt' }}"></i>
                        </div>
                        
                        <h1 class="service-title">{{ $cartaServico->nome ?? 'Protocolo de Documentos' }}</h1>
                        
                        <p class="service-subtitle">
                            {{ $cartaServico->descricao ?? 'Serviço para protocolo de documentos, petições e requerimentos dirigidos à Câmara Municipal. Atendimento presencial ou digital conforme a necessidade do cidadão.' }}
                        </p>
                        
                        <div class="service-meta-header">
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <span>{{ ucfirst($cartaServico->categoria ?? 'Protocolo') }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <i class="fas fa-users"></i>
                                <span>{{ $cartaServico->publico_alvo ?? 'Cidadãos, Empresas, Advogados' }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $cartaServico->prazo_atendimento ?? '5 dias úteis' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-md-end">
                        <div class="service-status status-{{ $cartaServico->status ?? 'ativo' }}">
                            {{ ucfirst($cartaServico->status ?? 'Ativo') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Corpo do Serviço -->
        <div class="service-body">
            <!-- Informações Gerais -->
            <div class="section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Informações Gerais
                </h3>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Custo</div>
                        <div class="info-value">{{ $cartaServico->custo ?? 'Gratuito' }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Base Legal</div>
                        <div class="info-value">{{ $cartaServico->base_legal ?? 'Lei Municipal nº 123/2020' }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Última Atualização</div>
                        <div class="info-value">{{ ($cartaServico->updated_at ?? now())->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Criado em</div>
                        <div class="info-value">{{ ($cartaServico->created_at ?? now())->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Etapas do Processo -->
            <div class="section">
                <h3 class="section-title">
                    <i class="fas fa-list-ol"></i>
                    Como Solicitar o Serviço
                </h3>
                
                <div class="etapas-timeline">
                    @if(isset($cartaServico) && $cartaServico->etapas)
                        @foreach(json_decode($cartaServico->etapas, true) as $index => $etapa)
                        <div class="etapa-item">
                            <div class="etapa-number">{{ $index + 1 }}</div>
                            <h4 class="etapa-title">{{ $etapa['titulo'] }}</h4>
                            <p class="etapa-description">{{ $etapa['descricao'] }}</p>
                        </div>
                        @endforeach
                    @else
                    <!-- Etapas de exemplo -->
                    <div class="etapa-item">
                        <div class="etapa-number">1</div>
                        <h4 class="etapa-title">Preparar Documentação</h4>
                        <p class="etapa-description">Reúna todos os documentos necessários listados abaixo. Certifique-se de que estão atualizados e legíveis.</p>
                    </div>
                    
                    <div class="etapa-item">
                        <div class="etapa-number">2</div>
                        <h4 class="etapa-title">Comparecer ao Protocolo</h4>
                        <p class="etapa-description">Dirija-se ao setor de protocolo da Câmara Municipal no horário de atendimento ou utilize o canal online.</p>
                    </div>
                    
                    <div class="etapa-item">
                        <div class="etapa-number">3</div>
                        <h4 class="etapa-title">Receber Comprovante</h4>
                        <p class="etapa-description">Após o protocolo, você receberá um número de protocolo para acompanhar o andamento da sua solicitação.</p>
                    </div>
                    
                    <div class="etapa-item">
                        <div class="etapa-number">4</div>
                        <h4 class="etapa-title">Acompanhar Processo</h4>
                        <p class="etapa-description">Utilize o número de protocolo para consultar o status da sua solicitação através dos canais disponíveis.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Documentos Necessários -->
            <div class="section">
                <h3 class="section-title">
                    <i class="fas fa-folder-open"></i>
                    Documentos Necessários
                </h3>
                
                @if(isset($cartaServico) && $cartaServico->documentos)
                <div class="documentos-list">
                    @foreach(json_decode($cartaServico->documentos, true) as $documento)
                    <div class="documento-item">
                        <i class="fas fa-file-alt documento-icon"></i>
                        <span class="documento-text">{{ $documento }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <!-- Documentos de exemplo -->
                <div class="documentos-list">
                    <div class="documento-item">
                        <i class="fas fa-id-card documento-icon"></i>
                        <span class="documento-text">RG (Registro Geral)</span>
                    </div>
                    
                    <div class="documento-item">
                        <i class="fas fa-id-card documento-icon"></i>
                        <span class="documento-text">CPF (Cadastro de Pessoa Física)</span>
                    </div>
                    
                    <div class="documento-item">
                        <i class="fas fa-home documento-icon"></i>
                        <span class="documento-text">Comprovante de Residência</span>
                    </div>
                    
                    <div class="documento-item">
                        <i class="fas fa-file-alt documento-icon"></i>
                        <span class="documento-text">Documento a ser protocolado</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Canais de Atendimento -->
            <div class="section">
                <h3 class="section-title">
                    <i class="fas fa-phone"></i>
                    Canais de Atendimento
                </h3>
                
                <div class="canais-grid">
                    @if(isset($cartaServico) && $cartaServico->canais)
                        @php $canaisAtivos = json_decode($cartaServico->canais, true); @endphp
                        
                        <div class="canal-card {{ in_array('presencial', $canaisAtivos) ? 'ativo' : '' }}">
                            <i class="fas fa-building canal-icon"></i>
                            <div class="canal-name">Presencial</div>
                        </div>
                        
                        <div class="canal-card {{ in_array('telefone', $canaisAtivos) ? 'ativo' : '' }}">
                            <i class="fas fa-phone canal-icon"></i>
                            <div class="canal-name">Telefone</div>
                        </div>
                        
                        <div class="canal-card {{ in_array('email', $canaisAtivos) ? 'ativo' : '' }}">
                            <i class="fas fa-envelope canal-icon"></i>
                            <div class="canal-name">E-mail</div>
                        </div>
                        
                        <div class="canal-card {{ in_array('online', $canaisAtivos) ? 'ativo' : '' }}">
                            <i class="fas fa-globe canal-icon"></i>
                            <div class="canal-name">Online</div>
                        </div>
                    @else
                    <!-- Canais de exemplo -->
                    <div class="canal-card ativo">
                        <i class="fas fa-building canal-icon"></i>
                        <div class="canal-name">Presencial</div>
                    </div>
                    
                    <div class="canal-card ativo">
                        <i class="fas fa-phone canal-icon"></i>
                        <div class="canal-name">Telefone</div>
                    </div>
                    
                    <div class="canal-card ativo">
                        <i class="fas fa-envelope canal-icon"></i>
                        <div class="canal-name">E-mail</div>
                    </div>
                    
                    <div class="canal-card ativo">
                        <i class="fas fa-globe canal-icon"></i>
                        <div class="canal-name">Online</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Observações -->
            @if((isset($cartaServico) && $cartaServico->observacoes) || !isset($cartaServico))
            <div class="section">
                <h3 class="section-title">
                    <i class="fas fa-exclamation-circle"></i>
                    Observações Importantes
                </h3>
                
                <div class="description-text">
                    {{ $cartaServico->observacoes ?? 'Horário de atendimento: Segunda a sexta-feira, das 8h às 17h. Para atendimento online, acesse o portal da Câmara Municipal. Em caso de dúvidas, entre em contato através dos canais disponíveis.' }}
                </div>
            </div>
            @endif
        </div>

        <!-- Barra de Ações -->
        <div class="actions-bar">
            <div>
                <a href="{{ route('admin.cartas-servico.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar à Lista
                </a>
            </div>
            
            <div class="btn-group">
                <a href="{{ route('admin.cartas-servico.edit', $cartaServico->id ?? 1) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                
                <button type="button" class="btn btn-warning" onclick="toggleStatus()">
                    <i class="fas fa-toggle-{{ ($cartaServico->status ?? 'ativo') == 'ativo' ? 'on' : 'off' }}"></i>
                    {{ ($cartaServico->status ?? 'ativo') == 'ativo' ? 'Desativar' : 'Ativar' }}
                </button>
                
                <button type="button" class="btn btn-success" onclick="duplicateService()">
                    <i class="fas fa-copy"></i>
                    Duplicar
                </button>
                
                <button type="button" class="btn btn-outline-danger" onclick="deleteService()">
                    <i class="fas fa-trash"></i>
                    Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Dados da carta de serviço para JavaScript -->
<div id="carta-servico-show-data" 
     data-id="{{ $cartaServico->id ?? 1 }}"
     data-status="{{ $cartaServico->status ?? 'ativo' }}"
     style="display: none;"></div>

@push('scripts')
<script src="{{ asset('js/cartas-servico-data.js') }}"></script>
<script src="{{ asset('js/cartas-servico-show.js') }}"></script>
<script src="{{ asset('js/cartas-servico-show-init.js') }}"></script>
@endpush
@endsection