// JavaScript para Calendário - Meus Eventos

// Namespace para organizar as funções
window.MeusEventos = {
    calendar: null,
    currentView: 'dayGridMonth',

    // Inicialização principal
    init: function() {
        this.initCalendar();
        this.loadInitialData();
        this.bindEvents();
        this.setupViewButtons();
    },

    // Inicializar calendário FullCalendar
    initCalendar: function() {
        const calendarEl = document.getElementById('calendario');
        if (!calendarEl) return;

        this.calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            buttonText: {
                today: 'Hoje',
                month: 'Mês',
                week: 'Semana',
                list: 'Lista'
            },
            height: 'auto',
            events: (fetchInfo, successCallback, failureCallback) => {
                this.carregarEventos(fetchInfo.startStr, fetchInfo.endStr, successCallback, failureCallback);
            },
            eventClick: (info) => {
                this.mostrarDetalhesEvento(info.event);
            },
            eventDidMount: (info) => {
                // Adicionar tooltip
                info.el.setAttribute('title', info.event.extendedProps.description || info.event.title);
            }
        });

        this.calendar.render();
    },

    // Carregar dados iniciais
    loadInitialData: function() {
        this.carregarProximosEventos();
        this.carregarEstatisticas();
        this.verificarPrazosProximos();
    },

    // Vincular eventos aos elementos
    bindEvents: function() {
        const filtroTipo = document.getElementById('filtro-tipo');
        const filtroStatus = document.getElementById('filtro-status');
        const filtroPeriodo = document.getElementById('filtro-periodo');
        const btnLimparFiltros = document.getElementById('btn-limpar-filtros');

        if (filtroTipo) filtroTipo.addEventListener('change', () => this.filtrarEventos());
        if (filtroStatus) filtroStatus.addEventListener('change', () => this.filtrarEventos());
        if (filtroPeriodo) filtroPeriodo.addEventListener('change', () => this.filtrarEventos());
        if (btnLimparFiltros) btnLimparFiltros.addEventListener('click', () => this.limparFiltros());
    },

    // Configurar botões de visualização
    setupViewButtons: function() {
        const btnMes = document.getElementById('btn-mes');
        const btnSemana = document.getElementById('btn-semana');
        const btnLista = document.getElementById('btn-lista');

        if (btnMes) btnMes.addEventListener('click', () => this.changeView('dayGridMonth'));
        if (btnSemana) btnSemana.addEventListener('click', () => this.changeView('timeGridWeek'));
        if (btnLista) btnLista.addEventListener('click', () => this.changeView('listWeek'));
    },

    // Carregar eventos do servidor
    carregarEventos: function(start, end, successCallback, failureCallback) {
        const filtros = this.obterFiltros();
        const baseUrl = document.querySelector('meta[name="meus-eventos-url"]')?.getAttribute('content') || '/calendario/meus-eventos';
        
        fetch(`${baseUrl}?start=${start}&end=${end}&${new URLSearchParams(filtros)}`)
            .then(response => response.json())
            .then(data => {
                successCallback(data);
            })
            .catch(error => {
                console.error('Erro ao carregar eventos:', error);
                failureCallback(error);
            });
    },

    // Obter filtros atuais
    obterFiltros: function() {
        const filtroTipo = document.getElementById('filtro-tipo');
        const filtroStatus = document.getElementById('filtro-status');
        const filtroPeriodo = document.getElementById('filtro-periodo');

        return {
            tipo: filtroTipo ? filtroTipo.value : '',
            status: filtroStatus ? filtroStatus.value : '',
            periodo: filtroPeriodo ? filtroPeriodo.value : 'todos'
        };
    },

    // Filtrar eventos
    filtrarEventos: function() {
        if (this.calendar) {
            this.calendar.refetchEvents();
        }
        this.carregarProximosEventos();
        this.carregarEstatisticas();
    },

    // Limpar filtros
    limparFiltros: function() {
        const filtroTipo = document.getElementById('filtro-tipo');
        const filtroStatus = document.getElementById('filtro-status');
        const filtroPeriodo = document.getElementById('filtro-periodo');

        if (filtroTipo) filtroTipo.value = '';
        if (filtroStatus) filtroStatus.value = '';
        if (filtroPeriodo) filtroPeriodo.value = 'todos';
        
        this.filtrarEventos();
    },

    // Mudar visualização do calendário
    changeView: function(viewName) {
        if (!this.calendar) return;

        this.calendar.changeView(viewName);
        this.currentView = viewName;

        // Atualizar botões ativos
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });

        const btnMap = {
            'dayGridMonth': 'btn-mes',
            'timeGridWeek': 'btn-semana',
            'listWeek': 'btn-lista'
        };

        const activeBtn = document.getElementById(btnMap[viewName]);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
    },

    // Carregar próximos eventos
    carregarProximosEventos: function() {
        const container = document.getElementById('proximos-eventos');
        if (!container) return;

        container.innerHTML = '<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div></div>';

        const filtros = this.obterFiltros();
        const baseUrl = document.querySelector('meta[name="meus-eventos-url"]')?.getAttribute('content') || '/calendario/meus-eventos';

        fetch(`${baseUrl}?proximos=5&${new URLSearchParams(filtros)}`)
            .then(response => response.json())
            .then(eventos => {
                if (eventos.length === 0) {
                    container.innerHTML = '<p class="text-muted text-center">Nenhum evento próximo</p>';
                    return;
                }

                let html = '';
                eventos.forEach(evento => {
                    const dataEvento = new Date(evento.start);
                    const hoje = new Date();
                    const diasRestantes = Math.ceil((dataEvento - hoje) / (1000 * 60 * 60 * 24));

                    let classeCard = 'normal';
                    if (diasRestantes < 0) classeCard = 'vencido';
                    else if (diasRestantes <= 3) classeCard = 'urgente';

                    html += `
                        <div class="evento-card ${classeCard} p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">${evento.title}</h6>
                                <span class="badge bg-secondary badge-status">${evento.tipo || 'N/A'}</span>
                            </div>
                            <p class="text-muted small mb-2">${evento.description || ''}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    ${dataEvento.toLocaleDateString('pt-BR')}
                                </small>
                                ${diasRestantes >= 0 ? 
                                    `<small class="text-muted">${diasRestantes} dias</small>` : 
                                    `<small class="text-danger">Vencido</small>`
                                }
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao carregar próximos eventos:', error);
                container.innerHTML = '<p class="text-danger text-center">Erro ao carregar eventos</p>';
            });
    },

    // Carregar estatísticas
    carregarEstatisticas: function() {
        const container = document.getElementById('estatisticas');
        if (!container) return;

        container.innerHTML = '<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div></div>';

        const baseUrl = document.querySelector('meta[name="meus-eventos-url"]')?.getAttribute('content') || '/calendario/meus-eventos';

        fetch(`${baseUrl}?estatisticas=1`)
            .then(response => response.json())
            .then(stats => {
                const html = `
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="estatistica-item">
                                <div class="estatistica-numero text-primary">${stats.total || 0}</div>
                                <div class="estatistica-label">Total</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="estatistica-item">
                                <div class="estatistica-numero text-warning">${stats.urgentes || 0}</div>
                                <div class="estatistica-label">Urgentes</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="estatistica-item">
                                <div class="estatistica-numero text-danger">${stats.vencidos || 0}</div>
                                <div class="estatistica-label">Vencidos</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="estatistica-item">
                                <div class="estatistica-numero text-success">${stats.proximos || 0}</div>
                                <div class="estatistica-label">Próximos</div>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao carregar estatísticas:', error);
                container.innerHTML = '<p class="text-danger text-center">Erro ao carregar estatísticas</p>';
            });
    },

    // Verificar prazos próximos
    verificarPrazosProximos: function() {
        const container = document.getElementById('alertas-prazos');
        if (!container) return;

        const baseUrl = document.querySelector('meta[name="meus-eventos-url"]')?.getAttribute('content') || '/calendario/meus-eventos';

        fetch(`${baseUrl}?alertas=1`)
            .then(response => response.json())
            .then(alertas => {
                if (alertas.length === 0) {
                    container.innerHTML = '';
                    return;
                }

                let html = '';
                alertas.forEach(alerta => {
                    const classe = alerta.vencido ? 'alerta-prazo' : 'alerta-prazo urgente';
                    const icone = alerta.vencido ? 'fas fa-exclamation-triangle' : 'fas fa-clock';
                    const titulo = alerta.vencido ? 'Prazo Vencido!' : 'Prazo Próximo!';

                    html += `
                        <div class="col-12">
                            <div class="alert ${classe} alert-dismissible fade show" role="alert">
                                <i class="${icone} me-2"></i>
                                <strong>${titulo}</strong> ${alerta.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao verificar prazos:', error);
            });
    },

    // Mostrar detalhes do evento
    mostrarDetalhesEvento: function(event) {
        const modalTitulo = document.getElementById('modalEventoTitulo');
        const modalConteudo = document.getElementById('modalEventoConteudo');
        const modalLink = document.getElementById('modalEventoLink');

        if (modalTitulo) {
            modalTitulo.textContent = event.title;
        }

        if (modalConteudo) {
            let conteudo = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tipo:</strong> ${event.extendedProps.tipo || 'N/A'}
                    </div>
                    <div class="col-md-6">
                        <strong>Data:</strong> ${new Date(event.start).toLocaleDateString('pt-BR')}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <strong>Descrição:</strong><br>
                        ${event.extendedProps.description || 'Sem descrição disponível'}
                    </div>
                </div>
            `;

            if (event.extendedProps.protocolo) {
                conteudo += `
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Protocolo:</strong> ${event.extendedProps.protocolo}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong> ${event.extendedProps.status}
                        </div>
                    </div>
                `;
            }

            modalConteudo.innerHTML = conteudo;
        }

        if (modalLink) {
            if (event.url) {
                modalLink.href = event.url;
                modalLink.style.display = 'inline-block';
            } else {
                modalLink.style.display = 'none';
            }
        }

        const modal = document.getElementById('modalEvento');
        if (modal && typeof bootstrap !== 'undefined') {
            new bootstrap.Modal(modal).show();
        }
    }
};

// Inicializar quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se as dependências estão disponíveis
    if (typeof FullCalendar === 'undefined') {
        console.error('FullCalendar não está carregado');
        return;
    }

    // Inicializar o módulo
    MeusEventos.init();
});

// Exportar para uso global (compatibilidade)
window.carregarEventos = function(start, end, successCallback, failureCallback) {
    MeusEventos.carregarEventos(start, end, successCallback, failureCallback);
};

window.filtrarEventos = function() {
    MeusEventos.filtrarEventos();
};

window.limparFiltros = function() {
    MeusEventos.limparFiltros();
};

window.mostrarDetalhesEvento = function(event) {
    MeusEventos.mostrarDetalhesEvento(event);
};