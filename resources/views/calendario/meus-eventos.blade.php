@extends('layouts.app')

@section('title', 'Meus Eventos - Calendário')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Meus Eventos</h1>
                    <p class="text-muted mb-0">Calendário com seus eventos e prazos do E-SIC</p>
                </div>
                <div>
                    <a href="{{ route('calendario.agenda') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-calendar me-2"></i>Agenda Completa
                    </a>
                    <a href="{{ route('esic.minhas') }}" class="btn btn-primary">
                        <i class="fas fa-file-alt me-2"></i>Minhas Solicitações
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de Prazos Próximos -->
    <div class="row mb-4" id="alertas-prazos">
        <!-- Carregado via JavaScript -->
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="filtro-tipo" class="form-label">Tipo de Evento</label>
                            <select id="filtro-tipo" class="form-select">
                                <option value="">Todos os tipos</option>
                                <option value="prazo_esic">Prazos E-SIC</option>
                                <option value="sessao_plenaria">Sessões Plenárias</option>
                                <option value="audiencia_publica">Audiências Públicas</option>
                                <option value="licitacao">Licitações</option>
                                <option value="outro">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filtro-status" class="form-label">Status (E-SIC)</label>
                            <select id="filtro-status" class="form-select">
                                <option value="">Todos os status</option>
                                <option value="pendente">Pendente</option>
                                <option value="em_analise">Em Análise</option>
                                <option value="aguardando_informacoes">Aguardando Informações</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filtro-periodo" class="form-label">Período</label>
                            <select id="filtro-periodo" class="form-select">
                                <option value="todos">Todos</option>
                                <option value="hoje">Hoje</option>
                                <option value="amanha">Amanhã</option>
                                <option value="semana">Esta Semana</option>
                                <option value="mes">Este Mês</option>
                                <option value="vencidos">Vencidos</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-secondary w-100" id="btn-limpar-filtros">
                                <i class="fas fa-times me-2"></i>Limpar Filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendário -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Calendário
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-mes">Mês</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-semana">Semana</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-lista">Lista</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendario"></div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Próximos Eventos -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Próximos Eventos
                    </h6>
                </div>
                <div class="card-body">
                    <div id="proximos-eventos">
                        <div class="text-center">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Estatísticas
                    </h6>
                </div>
                <div class="card-body">
                    <div id="estatisticas">
                        <div class="text-center">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalhes do Evento -->
<div class="modal fade" id="modalEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEventoTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalEventoConteudo">
                <!-- Conteúdo carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <a href="#" class="btn btn-primary" id="modalEventoLink" target="_blank">Ver Detalhes</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
@push('styles')
@vite(['resources/css/calendario/meus-eventos.css'])
@endpush
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/pt-br.global.min.js"></script>
<script src="{{ asset('js/calendario.js') }}"></script>
@vite(['resources/js/calendario/meus-eventos.js'])
@endpush