@extends('layouts.app')

@section('title', 'Agenda Legislativa - Câmara Municipal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/public-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
    <style>
        /* Tooltip customizado */
        .tooltip-customizado {
            position: fixed;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            z-index: 10000;
            max-width: 300px;
            font-size: 14px;
            line-height: 1.4;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            pointer-events: none;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .tooltip-customizado.show {
            opacity: 1;
            transform: translateY(0);
        }

        .tooltip-customizado::before {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #2c3e50;
        }

        .tooltip-customizado[style*="--arrow-position: top"]::before {
            bottom: auto;
            top: -6px;
            border-top: none;
            border-bottom: 6px solid #2c3e50;
        }

        .tooltip-tipo {
            background: rgba(255,255,255,0.2);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .tooltip-titulo {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 8px;
            color: #ecf0f1;
        }

        .tooltip-info {
            margin-bottom: 6px;
            font-size: 13px;
            color: #bdc3c7;
        }

        .tooltip-info strong {
            color: #ecf0f1;
        }

        .tooltip-description {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-style: italic;
            color: #bdc3c7;
            font-size: 13px;
        }

        .tooltip-action {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 12px;
            color: #3498db;
            text-align: center;
        }
    </style>
@endpush

@section('content')
<div class="agenda-container">
    <!-- Header -->
    <div class="agenda-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-calendar-alt me-3"></i>
                        Agenda Legislativa
                    </h1>
                    <p class="lead mb-0">
                        Acompanhe todas as atividades da Câmara Municipal em um só lugar
                    </p>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('calendario.exportar.ics') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-download me-2"></i>
                        Exportar Agenda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Filtros -->
        <div class="agenda-filters">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tipo de Evento</label>
                    <select class="form-select" id="filtro-tipo">
                        <option value="">Todos os tipos</option>
                        <option value="sessao">Sessões Plenárias</option>
                        <option value="audiencia">Audiências Públicas</option>
                        <option value="reuniao">Reuniões</option>
                        <option value="licitacao">Licitações</option>
                        <option value="comemorativa">Datas Comemorativas</option>
                        <option value="vereador">Agenda dos Vereadores</option>
                        @auth
                        <option value="esic">Meus Prazos E-SIC</option>
                        @endauth
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Período</label>
                    <select class="form-select" id="filtro-periodo">
                        <option value="mes">Este mês</option>
                        <option value="semana">Esta semana</option>
                        <option value="hoje">Hoje</option>
                        <option value="proximos">Próximos 30 dias</option>
                        <option value="todos">Todos</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Buscar Evento</label>
                    <input type="text" class="form-control" id="busca-evento" placeholder="Digite o nome do evento...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">&nbsp;</label>
                    <div class="d-grid">
                        <button class="btn btn-primary" id="btn-filtrar">
                            <i class="fas fa-search me-2"></i>
                            Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Calendário -->
            <div class="col-lg-8">
                <div class="calendario-completo">
                    <div class="navegacao-mes">
                        <button class="btn-nav-mes" id="btn-mes-anterior">
                            <i class="fas fa-chevron-left me-2"></i>
                            Anterior
                        </button>
                        <div class="mes-atual" id="mes-atual">
                            {{ now()->format('F Y') }}
                        </div>
                        <button class="btn-nav-mes" id="btn-mes-proximo">
                            Próximo
                            <i class="fas fa-chevron-right ms-2"></i>
                        </button>
                    </div>

                    <div class="calendario-grid" id="calendario-grid">
                        <!-- Cabeçalho dos dias da semana -->
                        <div class="calendario-header-dia">Dom</div>
                        <div class="calendario-header-dia">Seg</div>
                        <div class="calendario-header-dia">Ter</div>
                        <div class="calendario-header-dia">Qua</div>
                        <div class="calendario-header-dia">Qui</div>
                        <div class="calendario-header-dia">Sex</div>
                        <div class="calendario-header-dia">Sáb</div>
                        
                        <!-- Dias do mês serão carregados via JavaScript -->
                    </div>

                    <!-- Legenda -->
                    <div class="legenda-tipos">
                        <div class="legenda-item">
                            <div class="legenda-cor" style="background: #dc3545;"></div>
                            <span>Sessões Plenárias</span>
                        </div>
                        <div class="legenda-item">
                            <div class="legenda-cor" style="background: #28a745;"></div>
                            <span>Audiências Públicas</span>
                        </div>
                        <div class="legenda-item">
                            <div class="legenda-cor" style="background: #007bff;"></div>
                            <span>Reuniões</span>
                        </div>
                        <div class="legenda-item">
                            <div class="legenda-cor" style="background: #ffc107;"></div>
                            <span>Licitações</span>
                        </div>
                        <div class="legenda-item">
                            <div class="legenda-cor" style="background: #6f42c1;"></div>
                            <span>Datas Comemorativas</span>
                        </div>
                        <div class="legenda-item">
                            <div class="legenda-cor" style="background: #20c997;"></div>
                            <span>Agenda dos Vereadores</span>
                        </div>
                        @auth
                        <div class="legenda-item">
                            <div class="legenda-cor" style="background: #fd7e14;"></div>
                            <span>Meus Prazos E-SIC</span>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Lista de Eventos -->
            <div class="col-lg-4">
                <div class="eventos-lista">
                    <h4 class="fw-bold mb-3">
                        <i class="fas fa-list me-2"></i>
                        Próximos Eventos
                    </h4>
                    <div id="lista-eventos">
                        <!-- Eventos serão carregados via JavaScript -->
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
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
<div class="modal fade modal-evento" id="modalEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-check me-2"></i>
                    Detalhes do Evento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modal-evento-conteudo">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <a href="javascript:void(0)" class="btn btn-primary" id="btn-ver-detalhes" style="display: none;">Ver Detalhes Completos</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variáveis globais
    let mesAtual = new Date().getMonth();
    let anoAtual = new Date().getFullYear();
    let eventos = [];
    
    // Inicializar calendário
    carregarCalendario();
    carregarEventos();
    
    // Event listeners
    document.getElementById('btn-mes-anterior').addEventListener('click', function() {
        mesAtual--;
        if (mesAtual < 0) {
            mesAtual = 11;
            anoAtual--;
        }
        carregarCalendario();
        carregarEventos();
    });
    
    document.getElementById('btn-mes-proximo').addEventListener('click', function() {
        mesAtual++;
        if (mesAtual > 11) {
            mesAtual = 0;
            anoAtual++;
        }
        carregarCalendario();
        carregarEventos();
    });
    
    document.getElementById('btn-filtrar').addEventListener('click', function() {
        carregarEventos();
    });
    
    // Busca em tempo real
    document.getElementById('busca-evento').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            carregarEventos();
        }, 500);
    });
    
    function carregarCalendario() {
        const ano = anoAtual;
        const mes = mesAtual;
        
        // Atualizar título do mês
        const meses = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        const mesAtualElement = document.getElementById('mes-atual');
        if (mesAtualElement) {
            mesAtualElement.textContent = `${meses[mes]} ${ano}`;
        }
        
        // Calcular primeiro dia do mês e quantos dias tem
        const primeiroDia = new Date(ano, mes, 1);
        const ultimoDia = new Date(ano, mes + 1, 0);
        const diasNoMes = ultimoDia.getDate();
        const diaSemanaInicio = primeiroDia.getDay();
        
        // Limpar apenas os dias do calendário (manter cabeçalhos)
        const calGrid = document.getElementById('calendario-grid');
        if (!calGrid) {
            console.error('❌ Elemento calendario-grid não encontrado!');
            return;
        }
        
        const diasExistentes = calGrid.querySelectorAll('.calendario-dia');
        diasExistentes.forEach(dia => dia.remove());
        
        // Adicionar dias do mês anterior (se necessário)
        const mesAnterior = new Date(ano, mes - 1, 0);
        for (let i = diaSemanaInicio - 1; i >= 0; i--) {
            const dia = mesAnterior.getDate() - i;
            const divDia = criarDivDia(dia, true);
            calGrid.appendChild(divDia);
        }
        
        // Adicionar dias do mês atual
        for (let dia = 1; dia <= diasNoMes; dia++) {
            const divDia = criarDivDia(dia, false);
            calGrid.appendChild(divDia);
        }
        
        // Adicionar dias do próximo mês (para completar a grade)
        const totalCelulas = calGrid.children.length - 7; // Subtrair cabeçalhos
        const celulasRestantes = 42 - totalCelulas; // 6 semanas * 7 dias
        for (let dia = 1; dia <= celulasRestantes; dia++) {
            const divDia = criarDivDia(dia, true);
            calGrid.appendChild(divDia);
        }
        
        // Carregar eventos para o mês
        carregarEventosCalendario();
    }
    
    function criarDivDia(numero, outroMes) {
        const div = document.createElement('div');
        div.className = `calendario-dia ${outroMes ? 'outro-mes' : ''}`;
        
        // Verificar se é o dia atual
        const hoje = new Date();
        if (!outroMes && 
            numero === hoje.getDate() && 
            mesAtual === hoje.getMonth() && 
            anoAtual === hoje.getFullYear()) {
            div.classList.add('hoje');
        }
        
        div.innerHTML = `
            <div class="dia-numero"><span class="numero-dia">${numero}</span></div>
            <div class="eventos-container"></div>
        `;
        
        // Adicionar evento de clique
        div.addEventListener('click', function() {
            if (!outroMes) {
                exibirEventosDoDia(numero);
            }
        });
        
        return div;
    }
    
    function carregarEventosCalendario() {
        const ano = anoAtual;
        const mes = mesAtual + 1; // JavaScript usa 0-11, backend usa 1-12
        
        fetch(`/calendario/eventos?ano=${ano}&mes=${mes}`)
            .then(response => response.json())
            .then(eventos => {
                
                // Limpar eventos existentes
                document.querySelectorAll('.evento-mini').forEach(el => el.remove());
                document.querySelectorAll('.contador-eventos').forEach(el => el.remove());
                document.querySelectorAll('.com-eventos').forEach(el => el.classList.remove('com-eventos'));
                
                // Adicionar eventos aos dias
                eventos.forEach(evento => {
                    // Garantir que temos uma data válida
                    const dataEvento = evento.data_evento || evento.start;
                    if (!dataEvento) {
                        console.warn('⚠️ Evento sem data:', evento);
                        return;
                    }
                    
                    // Para eventos de dia inteiro, usar apenas a parte da data para evitar problemas de fuso horário
                    let data;
                    if (evento.allDay || (!evento.hora_inicio && !evento.hora_fim)) {
                        // Para eventos de dia inteiro, criar data local sem conversão de fuso horário
                        const dateParts = dataEvento.split('T')[0].split('-');
                        data = new Date(parseInt(dateParts[0]), parseInt(dateParts[1]) - 1, parseInt(dateParts[2]));
                    } else {
                        // Para eventos com horário, usar o processamento normal
                        data = new Date(dataEvento);
                    }
                    
                    const dia = data.getDate();
                    const mesEvento = data.getMonth();
                    const anoEvento = data.getFullYear();
                    
                    // Verificar se o evento é do mês atual
                    if (mesEvento !== mesAtual || anoEvento !== anoAtual) {
                        return;
                    }
                    
                    // Encontrar o div do dia correto
                    const divDia = Array.from(document.querySelectorAll('.calendario-dia')).find(div => {
                        const numeroDia = div.querySelector('.numero-dia');
                        return numeroDia && 
                               parseInt(numeroDia.textContent) === dia && 
                               !div.classList.contains('outro-mes');
                    });
                    
                    if (divDia) {
                        console.log(`✅ Marcando evento "${evento.titulo || evento.title}" no dia ${dia}`);
                        
                        // Marcar o dia como tendo eventos
                        divDia.classList.add('com-eventos');
                        
                        // Criar elemento do evento (apenas indicador visual)
                        const eventoMini = document.createElement('div');
                        const tipoEvento = evento.tipo || 'evento';
                        eventoMini.className = `evento-mini ${tipoEvento}`;
                        
                        // Dados do evento para tooltip e clique
                        const horaInicio = evento.hora_inicio || '';
                        const horaFim = evento.hora_fim || '';
                        const local = evento.local || '';
                        const descricao = evento.descricao || evento.description || '';
                        const tipoLabel = getTipoLabel(tipoEvento);
                        const titulo = evento.titulo || evento.title || 'Evento';
                        
                        // Armazenar dados do evento no elemento
                        eventoMini.dataset.eventoId = evento.id;
                        eventoMini.dataset.eventoTitulo = titulo;
                        eventoMini.dataset.eventoTipo = tipoEvento;
                        eventoMini.dataset.eventoTipoLabel = tipoLabel;
                        eventoMini.dataset.eventoHora = horaInicio;
                        eventoMini.dataset.eventoHoraFim = horaFim;
                        eventoMini.dataset.eventoLocal = local;
                        eventoMini.dataset.eventoDescricao = descricao;
                        
                        // Eventos de mouse para tooltip customizado
                        eventoMini.addEventListener('mouseenter', function(e) {
                            mostrarTooltipEvento(e, this);
                        });
                        
                        eventoMini.addEventListener('mouseleave', function(e) {
                            esconderTooltipEvento();
                        });
                        
                        // Evento de clique - verificar se deve redirecionar ou mostrar modal
                        eventoMini.addEventListener('click', function(e) {
                            e.stopPropagation();
                            
                            // Determinar URL de redirecionamento baseado no tipo
                            let urlRedirecionamento = null;
                            
                            switch(tipoEvento) {
                                case 'licitacao':
                                    if (evento.licitacao_id) {
                                        urlRedirecionamento = `/licitacoes/${evento.licitacao_id}`;
                                    }
                                    break;
                                case 'sessao_plenaria':
                                case 'sessao':
                                    if (evento.sessao_id) {
                                        urlRedirecionamento = `/sessoes/${evento.sessao_id}`;
                                    }
                                    break;
                                case 'agenda_vereador':
                                case 'vereador':
                                    if (evento.vereador_id) {
                                        urlRedirecionamento = `/vereadores/${evento.vereador_id}`;
                                    }
                                    break;
                            }
                            
                            // Se há URL de redirecionamento, redirecionar; senão, mostrar modal
                            if (urlRedirecionamento) {
                                window.open(urlRedirecionamento, '_blank');
                            } else if (evento.id) {
                                mostrarDetalhesEvento(evento.id);
                            }
                        });
                        
                        // Adicionar ao container de eventos
                        const eventosContainer = divDia.querySelector('.eventos-container');
                        if (eventosContainer) {
                            eventosContainer.appendChild(eventoMini);
                        } else {
                            divDia.appendChild(eventoMini);
                        }
                        
                        // Atualizar contador de eventos
                        atualizarContadorEventos(divDia);
                    } else {
                        console.warn(`⚠️ Não foi possível encontrar o div para o dia ${dia}`);
                    }
                });
            })
            .catch(error => {
                console.error('❌ Erro ao carregar eventos do calendário:', error);
            });
    }
    
    function atualizarContadorEventos(divDia) {
        const eventos = divDia.querySelectorAll('.evento-mini');
        const totalEventos = eventos.length;
        
        // Remover contador existente
        const contadorExistente = divDia.querySelector('.contador-eventos');
        if (contadorExistente) {
            contadorExistente.remove();
        }
        
        // Adicionar novo contador se houver eventos
        if (totalEventos > 0) {
            const diaNumeroDivs = divDia.querySelector('.dia-numero');
            if (diaNumeroDivs) {
                const contador = document.createElement('span');
                contador.className = 'contador-eventos';
                contador.textContent = totalEventos;
                contador.title = `${totalEventos} evento(s) neste dia`;
                diaNumeroDivs.appendChild(contador);
            }
        }
    }
    
    function marcarEventosNoCalendario() {
        carregarEventosCalendario();
    }
    
    function exibirEventosDoDia(dia) {
        const data = new Date(anoAtual, mesAtual, dia);
        mostrarEventosDia(data);
    }
    
    function carregarEventos() {
        const filtros = {
            tipo: document.getElementById('filtro-tipo').value,
            periodo: document.getElementById('filtro-periodo').value,
            busca: document.getElementById('busca-evento').value
        };
        
        const params = new URLSearchParams(filtros);
        
        fetch(`/calendario/eventos?${params}`)
            .then(response => response.json())
            .then(eventos => {
                const lista = document.getElementById('lista-eventos');
                
                if (eventos.length === 0) {
                    lista.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p>Nenhum evento encontrado para os filtros selecionados.</p>
                        </div>
                    `;
                    return;
                }
                
                lista.innerHTML = eventos.map(evento => {
                    // Garantir que os valores não sejam undefined
                    const titulo = evento.titulo || evento.title || 'Evento sem título';
                    const dataEvento = evento.data_evento || evento.start || null;
                    const horaInicio = evento.hora_inicio || null;
                    const tipo = evento.tipo || 'evento';
                    const local = evento.local || '';
                    const descricao = evento.descricao || evento.description || '';
                    
                    return `
                        <div class="evento-card card" onclick="mostrarDetalhesEvento(${evento.id})">
                            <div class="evento-data">
                                <div class="fw-bold">${formatarData(dataEvento)}</div>
                                ${horaInicio ? `<small>${horaInicio}</small>` : ''}
                            </div>
                            <div class="evento-conteudo position-relative">
                                <span class="evento-tipo-badge ${tipo}">${getTipoLabel(tipo)}</span>
                                <h6 class="fw-bold mb-2">${titulo}</h6>
                                ${local ? `<p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i>${local}</p>` : ''}
                                ${descricao ? `<p class="text-muted small">${descricao.substring(0, 100)}${descricao.length > 100 ? '...' : ''}</p>` : ''}
                            </div>
                        </div>
                    `;
                }).join('');
            })
            .catch(error => {
                console.error('Erro ao carregar eventos:', error);
                document.getElementById('lista-eventos').innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                        <p>Erro ao carregar eventos. Tente novamente.</p>
                    </div>
                `;
            });
    }
    
    function mostrarDetalhesEvento(eventoId) {
        fetch(`/calendario/evento/${eventoId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(evento => {
                const conteudo = document.getElementById('modal-evento-conteudo');
                conteudo.innerHTML = `
                    <div class="mb-3">
                        <h5 class="fw-bold text-dark mb-3">${evento.titulo || evento.title || 'Evento'}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary"><i class="fas fa-calendar me-2"></i>Data e Hora</h6>
                            <p class="mb-2">${formatarData(evento.data_evento)}</p>
                            ${evento.hora_inicio ? `<p class="mb-3"><i class="fas fa-clock me-2 text-muted"></i>${evento.hora_inicio}${evento.hora_fim ? ` às ${evento.hora_fim}` : ''}</p>` : ''}
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary"><i class="fas fa-tag me-2"></i>Tipo</h6>
                            <p class="mb-2"><span class="badge bg-primary">${getTipoLabel(evento.tipo)}</span></p>
                            ${evento.local ? `<h6 class="fw-bold text-primary mt-3"><i class="fas fa-map-marker-alt me-2"></i>Local</h6><p class="mb-3">${evento.local}</p>` : ''}
                        </div>
                    </div>
                    ${evento.descricao ? `<div class="mt-3"><h6 class="fw-bold text-primary"><i class="fas fa-info-circle me-2"></i>Descrição</h6><p class="text-muted">${evento.descricao}</p></div>` : ''}
                    ${evento.observacoes ? `<div class="mt-3"><h6 class="fw-bold text-primary"><i class="fas fa-sticky-note me-2"></i>Observações</h6><p class="text-muted">${evento.observacoes}</p></div>` : ''}
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Informações do evento da agenda legislativa.
                        </small>
                    </div>
                `;
                
                // Configurar botão de detalhes
                const btnDetalhes = document.getElementById('btn-ver-detalhes');
                if (evento.url_detalhes) {
                    btnDetalhes.href = evento.url_detalhes;
                    btnDetalhes.style.display = 'inline-block';
                } else {
                    btnDetalhes.style.display = 'none';
                }
                
                // Mostrar modal
                new bootstrap.Modal(document.getElementById('modalEvento')).show();
            })
            .catch(error => {
                console.error('Erro ao carregar detalhes do evento:', error);
            });
    }
    
    function mostrarEventosDia(data) {
        // Implementar se necessário
    }
    
    function formatarData(dataString) {
        if (!dataString) {
            return 'Data não informada';
        }
        
        // Para evitar problemas de fuso horário, processar a data manualmente
        let data;
        try {
            // Se a data contém apenas YYYY-MM-DD, criar data local sem conversão de fuso horário
            if (dataString.match(/^\d{4}-\d{2}-\d{2}$/)) {
                const dateParts = dataString.split('-');
                data = new Date(parseInt(dateParts[0]), parseInt(dateParts[1]) - 1, parseInt(dateParts[2]));
            } else {
                // Para datas com horário, usar processamento normal
                data = new Date(dataString);
            }
        } catch (error) {
            return 'Data inválida';
        }
        
        // Verificar se a data é válida
        if (isNaN(data.getTime())) {
            return 'Data inválida';
        }
        
        return data.toLocaleDateString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }
    
    function getTipoLabel(tipo) {
        // Verificar se o tipo é válido
        if (!tipo || tipo === 'undefined' || tipo === 'null') {
            return 'Evento';
        }
        
        const tipos = {
            'sessao_plenaria': 'Sessão Plenária',
            'audiencia_publica': 'Audiência Pública',
            'reuniao_comissao': 'Reunião de Comissão',
            'agenda_vereador': 'Agenda do Vereador',
            'votacao': 'Votação',
            'data_comemorativa': 'Data Comemorativa',
            'licitacao': 'Licitação',
            'Licitação': 'Licitação',
            'sessao': 'Sessão Plenária',
            'audiencia': 'Audiência Pública',
            'reuniao': 'Reunião',
            'comemorativa': 'Data Comemorativa',
            'vereador': 'Agenda do Vereador',
            'esic': 'Prazo E-SIC',
            'evento': 'Evento'
        };
        
        return tipos[tipo] || (typeof tipo === 'string' ? tipo : 'Evento');
    }
    
    // Variável global para o tooltip
    let tooltipAtivo = null;
    
    function mostrarTooltipEvento(event, elemento) {
        // Remover tooltip existente
        esconderTooltipEvento();
        
        // Criar novo tooltip
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip-customizado';
        
        // Extrair dados do elemento
        const titulo = elemento.dataset.eventoTitulo || 'Evento';
        const tipoLabel = elemento.dataset.eventoTipoLabel || 'Evento';
        const hora = elemento.dataset.eventoHora || '';
        const horaFim = elemento.dataset.eventoHoraFim || '';
        const local = elemento.dataset.eventoLocal || '';
        const descricao = elemento.dataset.eventoDescricao || '';
        const tipo = elemento.dataset.eventoTipo || '';
        
        // Construir conteúdo do tooltip
        let conteudoTooltip = `
            <div class="tooltip-tipo">${tipoLabel}</div>
            <div class="tooltip-titulo">${titulo}</div>
        `;
        
        if (hora) {
            const horarioCompleto = horaFim ? `${hora} às ${horaFim}` : hora;
            conteudoTooltip += `<div class="tooltip-info"><strong>Horário:</strong> ${horarioCompleto}</div>`;
        }
        
        if (local) {
            conteudoTooltip += `<div class="tooltip-info"><strong>Local:</strong> ${local}</div>`;
        }
        
        if (descricao) {
            const descricaoLimitada = descricao.length > 80 ? descricao.substring(0, 80) + '...' : descricao;
            conteudoTooltip += `<div class="tooltip-description">${descricaoLimitada}</div>`;
        }
        
        // Adicionar ação baseada no tipo
        let acao = '🖱️ Clique para ver detalhes';
        switch(tipo) {
            case 'licitacao':
                acao = '🖱️ Clique para ver a licitação';
                break;
            case 'sessao_plenaria':
            case 'sessao':
                acao = '🖱️ Clique para ver a sessão';
                break;
            case 'agenda_vereador':
            case 'vereador':
                acao = '🖱️ Clique para ver o vereador';
                break;
        }
        
        conteudoTooltip += `<div class="tooltip-action">${acao}</div>`;
        
        tooltip.innerHTML = conteudoTooltip;
        
        // Adicionar ao DOM
        document.body.appendChild(tooltip);
        
        // Posicionar tooltip
        const rect = elemento.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();
        
        let left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
        let top = rect.top - tooltipRect.height - 10;
        
        // Ajustar se sair da tela
        if (left < 10) left = 10;
        if (left + tooltipRect.width > window.innerWidth - 10) {
            left = window.innerWidth - tooltipRect.width - 10;
        }
        if (top < 10) {
            top = rect.bottom + 10;
            // Inverter a seta
            tooltip.style.setProperty('--arrow-position', 'top');
        }
        
        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';
        
        // Mostrar tooltip com animação
        setTimeout(() => {
            tooltip.classList.add('show');
        }, 10);
        
        tooltipAtivo = tooltip;
    }
    
    function esconderTooltipEvento() {
        if (tooltipAtivo) {
            tooltipAtivo.classList.remove('show');
            setTimeout(() => {
                if (tooltipAtivo && tooltipAtivo.parentNode) {
                    tooltipAtivo.parentNode.removeChild(tooltipAtivo);
                }
                tooltipAtivo = null;
            }, 300);
        }
    }
    
    // Esconder tooltip ao rolar a página ou redimensionar
    window.addEventListener('scroll', esconderTooltipEvento);
    window.addEventListener('resize', esconderTooltipEvento);
    
    // Tornar funções globais para uso em onclick
    window.mostrarDetalhesEvento = mostrarDetalhesEvento;
    window.mostrarTooltipEvento = mostrarTooltipEvento;
    window.esconderTooltipEvento = esconderTooltipEvento;
});
</script>
@endpush