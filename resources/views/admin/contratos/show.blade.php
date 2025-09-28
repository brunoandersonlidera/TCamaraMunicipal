@extends('layouts.admin')

@section('title', 'Contrato: ' . $contrato->numero)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        Contrato: {{ $contrato->numero }}
                        @if($contrato->publico)
                            <span class="badge badge-success ml-2">Público</span>
                        @else
                            <span class="badge badge-warning ml-2">Privado</span>
                        @endif
                        @if($contrato->isVencido())
                            <span class="badge badge-danger ml-2">Vencido</span>
                        @else
                            <span class="badge badge-info ml-2">Ativo</span>
                        @endif
                    </h3>
                    <div>
                        <a href="{{ route('admin.contratos.edit', $contrato) }}" class="btn btn-edit">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('admin.contratos.index') }}" class="btn btn-secondary-modern">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Informações Básicas -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações Básicas</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Número:</th>
                                    <td>{{ $contrato->numero }}</td>
                                </tr>
                                <tr>
                                    <th>Tipo:</th>
                                    <td>
                                        <span class="badge-contrato badge-contrato-tipo">
                                            {{ $contrato->tipoContrato->nome }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Contratado:</th>
                                    <td>{{ $contrato->contratado }}</td>
                                </tr>
                                @if($contrato->cnpj_cpf)
                                <tr>
                                    <th>CNPJ/CPF:</th>
                                    <td>{{ $contrato->cnpj_cpf }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $contrato->publico ? 'success' : 'warning' }}">
                                            {{ $contrato->publico ? 'Público' : 'Privado' }}
                                        </span>
                                        @if($contrato->isVencido())
                                            <span class="badge badge-danger ml-1">Vencido</span>
                                        @else
                                            <span class="badge badge-info ml-1">Ativo</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Valores e Datas</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Valor Inicial:</th>
                                    <td class="text-success font-weight-bold">
                                        R$ {{ number_format($contrato->valor_inicial, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Valor Atual:</th>
                                    <td class="text-success font-weight-bold">
                                        R$ {{ number_format($contrato->valor_atual, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Data Assinatura:</th>
                                    <td>{{ $contrato->data_assinatura ? $contrato->data_assinatura->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Início Vigência:</th>
                                    <td>{{ $contrato->data_inicio ? $contrato->data_inicio->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Fim Vigência:</th>
                                    <td>{{ $contrato->data_fim ? $contrato->data_fim->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Objeto do Contrato -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Objeto do Contrato</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $contrato->objeto }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($contrato->observacoes)
                    <!-- Observações -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Observações</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $contrato->observacoes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Arquivo do Contrato -->
                    @if($contrato->arquivo_contrato)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Arquivo do Contrato</h5>
                            <div class="card bg-light">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                                        <span>{{ $contrato->arquivo_original }}</span>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.contratos.download', $contrato) }}" 
                                           class="btn btn-success" target="_blank">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                onclick="removeFile()">
                                            <i class="fas fa-trash"></i> Remover
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Aditivos -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Aditivos ({{ $contrato->aditivos->count() }})</h5>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#aditivoModal">
                                    <i class="fas fa-plus"></i> Novo Aditivo
                                </button>
                            </div>
                            
                            @if($contrato->aditivos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Número</th>
                                            <th>Tipo</th>
                                            <th>Valor</th>
                                            <th>Data</th>
                                            <th>Descrição</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contrato->aditivos as $aditivo)
                                        <tr>
                                            <td>{{ $aditivo->numero }}</td>
                                            <td>
                                                @switch($aditivo->tipo)
                                                @case('valor')
                                                    <span class="badge-contrato badge-aditivo-valor">Valor</span>
                                                    @break
                                                @case('prazo')
                                                    <span class="badge-contrato badge-aditivo-prazo">Prazo</span>
                                                    @break
                                                @case('valor_prazo')
                                                    <span class="badge-contrato badge-aditivo-valor-prazo">Valor e Prazo</span>
                                                    @break
                                                @case('supressao')
                                                    <span class="badge-contrato badge-aditivo-supressao">Supressão</span>
                                                    @break
                                                @case('acrescimo')
                                                    <span class="badge-contrato badge-aditivo-acrescimo">Acréscimo</span>
                                                    @break
                                                @default
                                                    <span class="badge-contrato badge-aditivo-default">{{ ucfirst($aditivo->tipo) }}</span>
                                            @endswitch
                                            </td>
                                            <td>
                                                @if($aditivo->valor)
                                                    <span class="text-success">
                                                        R$ {{ number_format($aditivo->valor, 2, ',', '.') }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $aditivo->data_assinatura ? $aditivo->data_assinatura->format('d/m/Y') : 'N/A' }}</td>
                                            <td>{{ Str::limit($aditivo->objeto ?? $aditivo->justificativa, 50) }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <!-- Visualizar -->
                                                    <a href="{{ route('admin.contratos.aditivos.show', [$contrato, $aditivo]) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <!-- Download do anexo (se existir) -->
                                                    @if($aditivo->arquivo_aditivo)
                                                    <a href="{{ route('admin.contratos.aditivos.download', [$contrato, $aditivo]) }}" 
                                                       class="btn btn-sm btn-success" 
                                                       title="Download do anexo">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @endif
                                                    
                                                    <!-- Editar -->
                                                    <a href="{{ route('admin.contratos.aditivos.edit', [$contrato, $aditivo]) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <!-- Excluir -->
                                                    <form action="{{ route('admin.contratos.aditivos.destroy', [$contrato, $aditivo]) }}" 
                                                          method="POST" 
                                                          style="display: inline;"
                                                          onsubmit="return confirm('Tem certeza que deseja excluir este aditivo?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                title="Excluir">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhum aditivo cadastrado.</p>
                            </div>
                            @endif

                            <!-- Modais de Detalhes das Fiscalizações -->
                            @foreach($contrato->fiscalizacoes as $fiscalizacao)
                            <div class="modal fade" id="fiscalizacaoDetalhesModal{{ $fiscalizacao->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detalhes da Fiscalização</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="text-primary">Informações Básicas</h6>
                                                    <p><strong>Número do Relatório:</strong> {{ $fiscalizacao->numero_relatorio ?? 'Não informado' }}</p>
                                                    <p><strong>Data da Fiscalização:</strong> {{ $fiscalizacao->data_fiscalizacao ? $fiscalizacao->data_fiscalizacao->format('d/m/Y') : 'Não informada' }}</p>
                                                    <p><strong>Fim da Vigência:</strong> {{ $fiscalizacao->data_fim_vigencia ? $fiscalizacao->data_fim_vigencia->format('d/m/Y') : 'Não informado' }}</p>
                                                    <p><strong>Tipo:</strong> {{ $fiscalizacao->tipo_formatado }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-primary">Fiscal Responsável</h6>
                                                    <p><strong>Nome:</strong> {{ $fiscalizacao->fiscal_responsavel }}</p>
                                                    <p><strong>Número da Portaria:</strong> {{ $fiscalizacao->numero_portaria ?? 'Não informado' }}</p>
                                                    <p><strong>Data da Portaria:</strong> {{ $fiscalizacao->data_portaria ? $fiscalizacao->data_portaria->format('d/m/Y') : 'Não informada' }}</p>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="text-primary">Objeto da Fiscalização</h6>
                                                    <p>{{ $fiscalizacao->objeto_fiscalizacao ?? 'Não informado' }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="text-primary">Observações Encontradas</h6>
                                                    <p>{{ $fiscalizacao->observacoes_encontradas ?? 'Não informado' }}</p>
                                                </div>
                                            </div>
                                            
                                            @if($fiscalizacao->recomendacoes || $fiscalizacao->providencias_adotadas)
                                            <div class="row">
                                                @if($fiscalizacao->recomendacoes)
                                                <div class="col-md-6">
                                                    <h6 class="text-primary">Recomendações</h6>
                                                    <p>{{ $fiscalizacao->recomendacoes }}</p>
                                                </div>
                                                @endif
                                                @if($fiscalizacao->providencias_adotadas)
                                                <div class="col-md-6">
                                                    <h6 class="text-primary">Providências Adotadas</h6>
                                                    <p>{{ $fiscalizacao->providencias_adotadas }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                            
                                            <hr>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6 class="text-primary">Status de Execução</h6>
                                                    <span class="badge 
                                                        @if($fiscalizacao->status_execucao === 'conforme') bg-success
                                                        @elseif($fiscalizacao->status_execucao === 'nao_conforme') bg-danger
                                                        @else bg-warning
                                                        @endif">
                                                        {{ $fiscalizacao->status_execucao_formatado }}
                                                    </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6 class="text-primary">Status de Regularização</h6>
                                                    <span class="badge bg-secondary">{{ $fiscalizacao->status_regularizacao_formatado }}</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6 class="text-primary">Prazo de Regularização</h6>
                                                    <p>{{ $fiscalizacao->prazo_regularizacao ? $fiscalizacao->prazo_regularizacao->format('d/m/Y') : 'Não definido' }}</p>
                                                </div>
                                            </div>
                                            
                                            @if($fiscalizacao->arquivo_pdf)
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="text-primary">Documentação</h6>
                                                    <p><strong>Arquivo PDF:</strong> {{ $fiscalizacao->arquivo_pdf_original ?? $fiscalizacao->arquivo_pdf }}</p>
                                                    <p><strong>Acesso Público:</strong> 
                                                        @if($fiscalizacao->publico)
                                                            <span class="badge bg-success">Sim</span>
                                                        @else
                                                            <span class="badge bg-secondary">Não</span>
                                                        @endif
                                                    </p>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.contratos.fiscalizacoes.download', [$contrato, $fiscalizacao]) }}" 
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fas fa-download"></i> Download PDF
                                                        </a>
                                                        @if($fiscalizacao->publico)
                                                            <a href="{{ route('contratos.fiscalizacoes.pdf.publico', [$contrato, $fiscalizacao]) }}" 
                                                               class="btn btn-success btn-sm" target="_blank">
                                                                <i class="fas fa-external-link-alt"></i> Link Público
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Fiscalizações -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Fiscalizações ({{ $contrato->fiscalizacoes->count() }})</h5>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#fiscalizacaoModal">
                                    <i class="fas fa-plus"></i> Nova Fiscalização
                                </button>
                            </div>
                            
                            @if($contrato->fiscalizacoes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Relatório</th>
                                            <th>Data</th>
                                            <th>Fiscal</th>
                                            <th>Tipo</th>
                                            <th>Status</th>
                                            <th>PDF</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contrato->fiscalizacoes as $fiscalizacao)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $fiscalizacao->numero_relatorio ?? 'N/I' }}</strong>
                                                    @if($fiscalizacao->data_fim_vigencia)
                                                        <br><small class="text-muted">Vigência até: {{ $fiscalizacao->data_fim_vigencia->format('d/m/Y') }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $fiscalizacao->data_fiscalizacao ? $fiscalizacao->data_fiscalizacao->format('d/m/Y') : 'Data não informada' }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $fiscalizacao->fiscal_responsavel }}</strong>
                                                    @if($fiscalizacao->numero_portaria)
                                                        <br><small class="text-muted">{{ $fiscalizacao->numero_portaria }}</small>
                                                    @endif
                                                    @if($fiscalizacao->data_portaria)
                                                        <br><small class="text-muted">{{ $fiscalizacao->data_portaria->format('d/m/Y') }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $fiscalizacao->tipo_formatado }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="badge 
                                                        @if($fiscalizacao->status_execucao === 'conforme') bg-success
                                                        @elseif($fiscalizacao->status_execucao === 'nao_conforme') bg-danger
                                                        @else bg-warning
                                                        @endif">
                                                        {{ $fiscalizacao->status_execucao_formatado }}
                                                    </span>
                                                    @if($fiscalizacao->status_regularizacao && $fiscalizacao->status_regularizacao !== 'nao_aplicavel')
                                                        <br><small class="badge bg-secondary mt-1">{{ $fiscalizacao->status_regularizacao_formatado }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($fiscalizacao->arquivo_pdf)
                                                    <div class="d-flex flex-column gap-1">
                                                        <a href="{{ route('admin.contratos.fiscalizacoes.download', [$contrato, $fiscalizacao]) }}" 
                                                           class="btn btn-sm btn-outline-primary" title="Download PDF">
                                                            <i class="fas fa-download"></i> Admin
                                                        </a>
                                                        @if($fiscalizacao->publico)
                                                            <a href="{{ route('contratos.fiscalizacoes.pdf.publico', [$contrato, $fiscalizacao]) }}" 
                                                               class="btn btn-sm btn-outline-success" title="Link Público" target="_blank">
                                                                <i class="fas fa-external-link-alt"></i> Público
                                                            </a>
                                                        @else
                                                            <small class="text-muted">Privado</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <small class="text-muted">Sem PDF</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-info" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#fiscalizacaoDetalhesModal{{ $fiscalizacao->id }}"
                                                            title="Ver Detalhes">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="removeFiscalizacao({{ $fiscalizacao->id }})"
                                                            title="Excluir">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhuma fiscalização cadastrada.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informações do Sistema -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Informações do Sistema</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <small class="text-muted">ID:</small><br>
                                    <strong>{{ $contrato->id }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Criado em:</small><br>
                                    <strong>{{ $contrato->created_at ? $contrato->created_at->format('d/m/Y H:i') : 'N/A' }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Atualizado em:</small><br>
                                    <strong>{{ $contrato->updated_at ? $contrato->updated_at->format('d/m/Y H:i') : 'N/A' }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Dias até vencimento:</small><br>
                                    <strong class="{{ $contrato->isVencido() ? 'text-danger' : 'text-success' }}">
                                        @if($contrato->isVencido())
                                            Vencido
                                        @else
                                            @php
                                                $dataFim = $contrato->data_fim_atual ?? $contrato->data_fim;
                                            @endphp
                                            {{ $dataFim ? $dataFim->diffInDays(now()) . ' dias' : 'Data não definida' }}
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('admin.contratos.edit', $contrato) }}" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button type="button" 
                            class="btn btn-toggle"
                            onclick="toggleStatus()">
                        <i class="fas fa-{{ $contrato->publico ? 'eye-slash' : 'eye' }}"></i>
                        {{ $contrato->publico ? 'Tornar Privado' : 'Tornar Público' }}
                    </button>
                    <button type="button" 
                            class="btn btn-delete" 
                            onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Excluir
                    </button>
                    <a href="{{ route('admin.contratos.index') }}" class="btn btn-secondary-modern">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Novo Aditivo -->
<div class="modal fade" id="aditivoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Aditivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="aditivoForm" action="{{ route('admin.contratos.aditivos.store', $contrato) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="numero_aditivo" class="form-label">Número do Aditivo</label>
                                <input type="text" class="form-control" id="numero_aditivo" name="numero" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_aditivo" class="form-label">Tipo</label>
                                <select class="form-control" id="tipo_aditivo" name="tipo" required onchange="toggleAditivoFields()">
                                    <option value="">Selecione</option>
                                    <option value="prazo">Prazo</option>
                                    <option value="valor">Valor</option>
                                    <option value="valor_prazo">Valor e Prazo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="data_assinatura" class="form-label">Data de Assinatura</label>
                                <input type="date" class="form-control" id="data_assinatura" name="data_assinatura" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="data_inicio_vigencia" class="form-label">Data de Início da Vigência</label>
                                <input type="date" class="form-control" id="data_inicio_vigencia" name="data_inicio_vigencia">
                            </div>
                        </div>
                    </div>

                    <!-- Campos condicionais para Valor -->
                    <div id="campos_valor" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="valor_aditivo" class="form-label">Valor do Aditivo</label>
                                    <input type="text" class="form-control money" id="valor_aditivo" name="valor_aditivo" placeholder="R$ 0,00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos condicionais para Prazo -->
                    <div id="campos_prazo" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prazo_adicional_dias" class="form-label">Prazo Adicional (dias)</label>
                                    <input type="number" class="form-control" id="prazo_adicional_dias" name="prazo_adicional_dias" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_fim_vigencia" class="form-label">Nova Data de Fim da Vigência</label>
                                    <input type="date" class="form-control" id="data_fim_vigencia" name="data_fim_vigencia">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="objeto" class="form-label">Objeto do Aditivo</label>
                                <textarea class="form-control" id="objeto" name="objeto" rows="2" required placeholder="Descreva o objeto do aditivo"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="justificativa" class="form-label">Justificativa</label>
                                <textarea class="form-control" id="justificativa" name="justificativa" rows="3" required placeholder="Justificativa para o aditivo"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="observacoes" class="form-label">Observações</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="2" placeholder="Observações adicionais (opcional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="arquivo_aditivo" class="form-label">Arquivo PDF do Aditivo</label>
                                <input type="file" class="form-control" id="arquivo_aditivo" name="arquivo_aditivo" accept=".pdf">
                                <small class="form-text text-muted">Arquivo em formato PDF (máximo 10MB)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Visibilidade</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="publico" name="publico" value="1" checked>
                                    <label class="form-check-label" for="publico">
                                        Público (visível na transparência)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Aditivo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Nova Fiscalização -->
<div class="modal fade" id="fiscalizacaoModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Fiscalização</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="fiscalizacaoForm" action="{{ route('admin.contratos.fiscalizacoes.store', $contrato) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Informações Básicas -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">Informações Básicas</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="numero_relatorio" class="form-label">Número do Relatório</label>
                                <input type="text" class="form-control" id="numero_relatorio" name="numero_relatorio" placeholder="Ex: REL-001/2025">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="data_fiscalizacao" class="form-label">Data da Fiscalização <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="data_fiscalizacao" name="data_fiscalizacao" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="data_fim_vigencia" class="form-label">Fim da Vigência</label>
                                <input type="date" class="form-control" id="data_fim_vigencia" name="data_fim_vigencia">
                            </div>
                        </div>
                    </div>

                    <!-- Fiscal Responsável -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">Fiscal Responsável</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="fiscal_responsavel" class="form-label">Nome do Fiscal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fiscal_responsavel" name="fiscal_responsavel" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="numero_portaria" class="form-label">Número da Portaria</label>
                                <input type="text" class="form-control" id="numero_portaria" name="numero_portaria" placeholder="Ex: PORT-001/2025">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="data_portaria" class="form-label">Data da Portaria</label>
                                <input type="date" class="form-control" id="data_portaria" name="data_portaria">
                            </div>
                        </div>
                    </div>

                    <!-- Detalhes da Fiscalização -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">Detalhes da Fiscalização</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_fiscalizacao" class="form-label">Tipo de Fiscalização <span class="text-danger">*</span></label>
                                <select class="form-select" id="tipo_fiscalizacao" name="tipo_fiscalizacao" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="rotina">Rotina</option>
                                    <option value="especial">Especial</option>
                                    <option value="denuncia">Denúncia</option>
                                    <option value="auditoria">Auditoria</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_execucao" class="form-label">Status de Execução <span class="text-danger">*</span></label>
                                <select class="form-select" id="status_execucao" name="status_execucao" required>
                                    <option value="">Selecione o status</option>
                                    <option value="conforme">Conforme</option>
                                    <option value="nao_conforme">Não Conforme</option>
                                    <option value="parcialmente_conforme">Parcialmente Conforme</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Objeto e Observações -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="objeto_fiscalizacao" class="form-label">Objeto da Fiscalização <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="objeto_fiscalizacao" name="objeto_fiscalizacao" rows="2" required placeholder="Descreva o objeto da fiscalização..."></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="observacoes_encontradas" class="form-label">Observações Encontradas <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="observacoes_encontradas" name="observacoes_encontradas" rows="3" required placeholder="Descreva as observações encontradas durante a fiscalização..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Recomendações e Providências -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="recomendacoes" class="form-label">Recomendações</label>
                                <textarea class="form-control" id="recomendacoes" name="recomendacoes" rows="3" placeholder="Recomendações para melhoria..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="providencias_adotadas" class="form-label">Providências Adotadas</label>
                                <textarea class="form-control" id="providencias_adotadas" name="providencias_adotadas" rows="3" placeholder="Providências já adotadas..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Regularização -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">Regularização</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prazo_regularizacao" class="form-label">Prazo para Regularização</label>
                                <input type="date" class="form-control" id="prazo_regularizacao" name="prazo_regularizacao">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_regularizacao" class="form-label">Status de Regularização</label>
                                <select class="form-select" id="status_regularizacao" name="status_regularizacao">
                                    <option value="nao_aplicavel">Não Aplicável</option>
                                    <option value="pendente">Pendente</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="regularizado">Regularizado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Upload de Arquivo -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">Documentação</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="arquivo_pdf" class="form-label">Arquivo PDF da Fiscalização</label>
                                <input type="file" class="form-control" id="arquivo_pdf" name="arquivo_pdf" accept=".pdf">
                                <div class="form-text">Arquivo PDF com o relatório completo da fiscalização (máx. 10MB)</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Acesso Público</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="publico" name="publico" value="1">
                                    <label class="form-check-label" for="publico">
                                        Disponibilizar PDF para acesso público
                                    </label>
                                </div>
                                <div class="form-text">Se marcado, o PDF ficará disponível para download público</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-modern">Salvar Fiscalização</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este contrato?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita e excluirá também todos os aditivos e fiscalizações relacionados.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" action="{{ route('admin.contratos.destroy', $contrato) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-modern">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus() {
    fetch(`/admin/contratos/{{ $contrato->id }}/toggle-status`, {
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
            alert('Erro ao alterar status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao alterar status');
    });
}

function confirmDelete() {
    $('#deleteModal').modal('show');
}

function removeFile() {
    if (confirm('Tem certeza que deseja remover o arquivo do contrato?')) {
        fetch(`/admin/contratos/{{ $contrato->id }}/remove-file`, {
            method: 'DELETE',
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
                alert('Erro ao remover arquivo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao remover arquivo');
        });
    }
}

function removeAditivo(id) {
    if (confirm('Tem certeza que deseja remover este aditivo?')) {
        fetch(`/admin/contratos/{{ $contrato->id }}/aditivos/${id}`, {
            method: 'DELETE',
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
                alert('Erro ao remover aditivo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao remover aditivo');
        });
    }
}

function removeFiscalizacao(id) {
    if (confirm('Tem certeza que deseja remover esta fiscalização?')) {
        fetch(`/admin/contratos/{{ $contrato->id }}/fiscalizacoes/${id}`, {
            method: 'DELETE',
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
                alert('Erro ao remover fiscalização');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao remover fiscalização');
        });
    }
}

function toggleAditivoFields() {
    const tipo = document.getElementById('tipo_aditivo').value;
    const camposValor = document.getElementById('campos_valor');
    const camposPrazo = document.getElementById('campos_prazo');
    
    // Ocultar todos os campos primeiro
    camposValor.style.display = 'none';
    camposPrazo.style.display = 'none';
    
    // Mostrar campos baseado no tipo selecionado
    if (tipo === 'valor') {
        camposValor.style.display = 'block';
    } else if (tipo === 'prazo') {
        camposPrazo.style.display = 'block';
    } else if (tipo === 'valor_prazo') {
        camposValor.style.display = 'block';
        camposPrazo.style.display = 'block';
    }
}

$(document).ready(function() {
    // Máscara para valores monetários
    $('.money').mask('#.##0,00', {
        reverse: true,
        translation: {
            '#': {pattern: /[0-9]/}
        }
    });
});
</script>
@endpush