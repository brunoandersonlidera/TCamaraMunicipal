/**
 * JavaScript para o Calendário da Câmara Municipal
 * Funcionalidades interativas e filtros
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicialização do calendário
    initializeCalendar();
    
    // Inicialização dos filtros
    initializeFilters();
    
    // Inicialização dos modais
    initializeModals();
    
    // Inicialização das estatísticas
    updateStatistics();
});

/**
 * Inicializa o calendário FullCalendar
 */
function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        timeZone: 'local', // Forçar uso do fuso horário local
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
        events: function(fetchInfo, successCallback, failureCallback) {
            loadEvents(fetchInfo, successCallback, failureCallback);
        },
        eventClick: function(info) {
            showEventDetails(info.event);
        },
        eventMouseEnter: function(info) {
            showEventTooltip(info);
        },
        eventMouseLeave: function(info) {
            hideEventTooltip();
        },
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        eventDisplay: 'block',
        displayEventTime: false
    });

    calendar.render();
    
    // Armazenar referência global do calendário
    window.calendar = calendar;
}

/**
 * Carrega eventos do servidor
 */
function loadEvents(fetchInfo, successCallback, failureCallback) {
    const filtros = getActiveFilters();
    
    const params = new URLSearchParams({
        start: fetchInfo.startStr,
        end: fetchInfo.endStr,
        ...filtros
    });

    fetch(`/calendario/eventos?${params}`)
        .then(response => response.json())
        .then(data => {
            console.log('=== DEBUG CALENDARIO ===');
            console.log('Dados recebidos da API:', data);
            
            const events = data.map(evento => {
                console.log('Processando evento:', evento.titulo || evento.title);
                console.log('Data original:', evento.data_evento);
                console.log('Start original:', evento.start);
                console.log('End original:', evento.end);
                console.log('Hora inicio:', evento.hora_inicio);
                console.log('Hora fim:', evento.hora_fim);
                
                // Determinar se é evento de dia inteiro baseado na ausência de horários
                const isAllDay = !evento.hora_inicio && !evento.hora_fim;
                console.log('É evento de dia inteiro?', isAllDay);
                
                let startDate, endDate;
                
                if (isAllDay) {
                    // Para eventos de dia inteiro, usar apenas a data no formato YYYY-MM-DD
                    startDate = (evento.start || evento.data_evento).split('T')[0].split(' ')[0];
                    endDate = (evento.end || evento.data_evento).split('T')[0].split(' ')[0];
                } else {
                    // Para eventos com horário, usar o formato completo
                    startDate = evento.start || `${evento.data_evento} ${evento.hora_inicio}`;
                    endDate = evento.end || `${evento.data_evento} ${evento.hora_fim}`;
                }
                
                console.log('Start processado:', startDate);
                console.log('End processado:', endDate);
                console.log('AllDay final:', isAllDay);
                console.log('---');
                
                return {
                    id: evento.id,
                    title: evento.title || evento.titulo,
                    start: startDate,
                    end: endDate,
                    allDay: isAllDay,
                    backgroundColor: getEventColor(evento.tipo, evento.color || evento.cor),
                    borderColor: getEventColor(evento.tipo, evento.color || evento.cor),
                    className: `evento-${evento.tipo}${evento.destaque ? ' evento-destaque' : ''}`,
                    extendedProps: {
                        tipo: evento.tipo,
                        descricao: evento.description || evento.descricao,
                        local: evento.local,
                        observacoes: evento.observacoes,
                        destaque: evento.destaque,
                        prazo_dias: evento.prazo_dias
                    }
                };
            });
            
            console.log('Eventos finais para FullCalendar:', events);
            console.log('=== FIM DEBUG ===');
            
            successCallback(events);
            updateEventCount(events.length);
        })
        .catch(error => {
            console.error('Erro ao carregar eventos:', error);
            failureCallback(error);
        });
}

/**
 * Obtém filtros ativos
 */
function getActiveFilters() {
    const filtros = {};
    
    const tipoSelect = document.getElementById('filtro-tipo');
    if (tipoSelect && tipoSelect.value) {
        filtros.tipo = tipoSelect.value;
    }
    
    const destaqueCheckbox = document.getElementById('filtro-destaque');
    if (destaqueCheckbox && destaqueCheckbox.checked) {
        filtros.destaque = '1';
    }
    
    const searchInput = document.getElementById('filtro-busca');
    if (searchInput && searchInput.value.trim()) {
        filtros.busca = searchInput.value.trim();
    }
    
    return filtros;
}

/**
 * Inicializa os filtros
 */
function initializeFilters() {
    // Filtro por tipo
    const tipoSelect = document.getElementById('filtro-tipo');
    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            refreshCalendar();
        });
    }
    
    // Filtro por destaque
    const destaqueCheckbox = document.getElementById('filtro-destaque');
    if (destaqueCheckbox) {
        destaqueCheckbox.addEventListener('change', function() {
            refreshCalendar();
        });
    }
    
    // Filtro de busca
    const searchInput = document.getElementById('filtro-busca');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                refreshCalendar();
            }, 500);
        });
    }
    
    // Botão limpar filtros
    const clearButton = document.getElementById('limpar-filtros');
    if (clearButton) {
        clearButton.addEventListener('click', function() {
            clearFilters();
        });
    }
    
    // Filtros rápidos
    const quickFilters = document.querySelectorAll('.filtro-rapido');
    quickFilters.forEach(button => {
        button.addEventListener('click', function() {
            const tipo = this.dataset.tipo;
            setQuickFilter(tipo);
        });
    });
}

/**
 * Atualiza o calendário
 */
function refreshCalendar() {
    if (window.calendar) {
        window.calendar.refetchEvents();
    }
}

/**
 * Limpa todos os filtros
 */
function clearFilters() {
    const tipoSelect = document.getElementById('filtro-tipo');
    if (tipoSelect) tipoSelect.value = '';
    
    const destaqueCheckbox = document.getElementById('filtro-destaque');
    if (destaqueCheckbox) destaqueCheckbox.checked = false;
    
    const searchInput = document.getElementById('filtro-busca');
    if (searchInput) searchInput.value = '';
    
    // Remove filtros rápidos ativos
    document.querySelectorAll('.filtro-rapido.active').forEach(btn => {
        // Verificação de segurança para classList
        if (btn && btn.classList) {
            try {
                btn.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do btn:', error);
            }
        }
    });
    
    refreshCalendar();
}

/**
 * Define filtro rápido
 */
function setQuickFilter(tipo) {
    // Remove outros filtros rápidos ativos
    document.querySelectorAll('.filtro-rapido.active').forEach(btn => {
        // Verificação de segurança para classList
        if (btn && btn.classList) {
            try {
                btn.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do btn:', error);
            }
        }
    });
    
    // Ativa o filtro selecionado
    const button = document.querySelector(`[data-tipo="${tipo}"]`);
    if (button && button.classList) {
        try {
            button.classList.add('active');
        } catch (error) {
            console.warn('Erro ao adicionar classe active ao button:', error);
        }
    }
    
    // Define o filtro no select
    const tipoSelect = document.getElementById('filtro-tipo');
    if (tipoSelect) {
        tipoSelect.value = tipo;
    }
    
    refreshCalendar();
}

/**
 * Obtém cor do evento
 */
function getEventColor(tipo, corCustomizada) {
    if (corCustomizada) {
        return corCustomizada;
    }
    
    const cores = {
        'sessao_plenaria': '#dc3545',    // Vermelho - Sessões Plenárias
        'audiencia_publica': '#28a745',  // Verde - Audiências Públicas
        'reuniao_comissao': '#007bff',   // Azul - Reuniões
        'votacao': '#e83e8c',            // Rosa
        'licitacao': '#ffc107',          // Amarelo - Licitações
        'agenda_vereador': '#20c997',    // Verde água - Agenda dos Vereadores
        'ato_vereador': '#6610f2',       // Índigo
        'data_comemorativa': '#6f42c1',  // Roxo - Datas Comemorativas
        'prazo_esic': '#fd7e14',         // Laranja - Meus Prazos E-SIC
        'outro': '#6c757d'               // Cinza
    };
    
    return cores[tipo] || '#6c757d';
}

/**
 * Mostra detalhes do evento
 */
function showEventDetails(event) {
    const modal = document.getElementById('eventoModal');
    if (!modal) return;
    
    // Preenche os dados do modal
    document.getElementById('modal-titulo').textContent = event.title;
    document.getElementById('modal-tipo').textContent = formatTipoEvento(event.extendedProps.tipo);
    document.getElementById('modal-data').textContent = formatEventDate(event);
    document.getElementById('modal-descricao').textContent = event.extendedProps.descricao || 'Sem descrição';
    document.getElementById('modal-local').textContent = event.extendedProps.local || 'Não informado';
    
    // Observações
    const observacoes = document.getElementById('modal-observacoes');
    if (event.extendedProps.observacoes) {
        observacoes.textContent = event.extendedProps.observacoes;
        observacoes.parentElement.style.display = 'block';
    } else {
        observacoes.parentElement.style.display = 'none';
    }
    
    // Badge do tipo
    const tipoBadge = document.getElementById('modal-tipo-badge');
    tipoBadge.textContent = formatTipoEvento(event.extendedProps.tipo);
    tipoBadge.style.backgroundColor = getEventColor(event.extendedProps.tipo);
    tipoBadge.style.color = isLightColor(getEventColor(event.extendedProps.tipo)) ? '#000' : '#fff';
    
    // Alerta de prazo (se aplicável)
    const alertaPrazo = document.getElementById('modal-alerta-prazo');
    if (event.extendedProps.prazo_dias !== undefined) {
        const dias = event.extendedProps.prazo_dias;
        let classe = 'normal';
        let texto = '';
        
        if (dias < 0) {
            classe = 'urgente';
            texto = `Prazo vencido há ${Math.abs(dias)} dia(s)`;
        } else if (dias <= 3) {
            classe = 'urgente';
            texto = `Prazo vence em ${dias} dia(s)`;
        } else if (dias <= 7) {
            classe = 'atencao';
            texto = `Prazo vence em ${dias} dia(s)`;
        } else {
            classe = 'normal';
            texto = `Prazo vence em ${dias} dia(s)`;
        }
        
        alertaPrazo.className = `alerta-prazo ${classe}`;
        alertaPrazo.textContent = texto;
        alertaPrazo.style.display = 'block';
    } else {
        alertaPrazo.style.display = 'none';
    }
    
    // Mostra o modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

/**
 * Formata tipo de evento
 */
function formatTipoEvento(tipo) {
    const tipos = {
        'sessao_plenaria': 'Sessão Plenária',
        'audiencia_publica': 'Audiência Pública',
        'reuniao_comissao': 'Reunião de Comissão',
        'votacao': 'Votação',
        'licitacao': 'Licitação',
        'agenda_vereador': 'Agenda de Vereador',
        'ato_vereador': 'Ato de Vereador',
        'data_comemorativa': 'Data Comemorativa',
        'prazo_esic': 'Prazo E-SIC',
        'outro': 'Outro'
    };
    
    return tipos[tipo] || tipo;
}

/**
 * Formata data do evento
 */
function formatEventDate(event) {
    const start = new Date(event.start);
    const end = event.end ? new Date(event.end) : null;
    
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    let dateStr = start.toLocaleDateString('pt-BR', options);
    
    if (end && end.getTime() !== start.getTime()) {
        dateStr += ' até ' + end.toLocaleDateString('pt-BR', options);
    }
    
    return dateStr;
}

/**
 * Verifica se a cor é clara
 */
function isLightColor(color) {
    const hex = color.replace('#', '');
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);
    const brightness = ((r * 299) + (g * 587) + (b * 114)) / 1000;
    return brightness > 155;
}

/**
 * Inicializa modais
 */
function initializeModals() {
    // Modal de detalhes do evento já é inicializado na função showEventDetails
    
    // Outros modais podem ser inicializados aqui
}

/**
 * Mostra tooltip do evento
 */
function showEventTooltip(info) {
    // Implementar tooltip se necessário
}

/**
 * Esconde tooltip do evento
 */
function hideEventTooltip() {
    // Implementar esconder tooltip se necessário
}

/**
 * Atualiza estatísticas
 */
function updateStatistics() {
    fetch('/api/eventos/estatisticas')
        .then(response => response.json())
        .then(data => {
            updateStatisticCard('total-eventos', data.total || 0);
            updateStatisticCard('eventos-mes', data.este_mes || 0);
            updateStatisticCard('eventos-semana', data.esta_semana || 0);
            updateStatisticCard('prazos-vencendo', data.prazos_vencendo || 0);
        })
        .catch(error => {
            console.error('Erro ao carregar estatísticas:', error);
        });
}

/**
 * Atualiza card de estatística
 */
function updateStatisticCard(id, value) {
    const element = document.getElementById(id);
    if (element) {
        element.textContent = value;
    }
}

/**
 * Atualiza contador de eventos
 */
function updateEventCount(count) {
    const counter = document.getElementById('eventos-exibidos');
    if (counter) {
        counter.textContent = count;
    }
}

/**
 * Exporta eventos para PDF
 */
function exportToPDF() {
    const filtros = getActiveFilters();
    const params = new URLSearchParams(filtros);
    
    window.open(`/calendario/export/pdf?${params}`, '_blank');
}

/**
 * Exporta eventos para Excel
 */
function exportToExcel() {
    const filtros = getActiveFilters();
    const params = new URLSearchParams(filtros);
    
    window.open(`/calendario/export/excel?${params}`, '_blank');
}

/**
 * Imprime calendário
 */
function printCalendar() {
    window.print();
}

/**
 * Navega para data específica
 */
function goToDate(date) {
    if (window.calendar) {
        window.calendar.gotoDate(date);
    }
}

/**
 * Navega para hoje
 */
function goToToday() {
    if (window.calendar) {
        window.calendar.today();
    }
}

/**
 * Muda visualização do calendário
 */
function changeView(view) {
    if (window.calendar) {
        window.calendar.changeView(view);
    }
}

/**
 * Atualiza próximos eventos
 */
function updateProximosEventos() {
    fetch('/api/eventos/proximos')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('proximos-eventos-lista');
            if (!container) return;
            
            container.innerHTML = '';
            
            data.forEach(evento => {
                const item = createEventListItem(evento);
                container.appendChild(item);
            });
        })
        .catch(error => {
            console.error('Erro ao carregar próximos eventos:', error);
        });
}

/**
 * Cria item da lista de eventos
 */
function createEventListItem(evento) {
    const item = document.createElement('div');
    item.className = 'evento-item';
    
    // Para evitar problemas de fuso horário, processar a data manualmente
    const dataString = evento.data_inicio || evento.start;
    let data;
    
    if (dataString && dataString.match(/^\d{4}-\d{2}-\d{2}$/)) {
        // Para datas no formato YYYY-MM-DD, criar data local sem conversão de fuso horário
        const dateParts = dataString.split('-');
        data = new Date(parseInt(dateParts[0]), parseInt(dateParts[1]) - 1, parseInt(dateParts[2]));
    } else {
        // Para datas com horário, usar processamento normal
        data = new Date(dataString);
    }
    
    const dia = data.getDate().toString().padStart(2, '0');
    const mes = data.toLocaleDateString('pt-BR', { month: 'short' }).toUpperCase();
    
    item.innerHTML = `
        <div class="evento-data">
            <div class="evento-dia">${dia}</div>
            <div class="evento-mes">${mes}</div>
        </div>
        <div class="evento-conteudo">
            <div class="evento-titulo">${evento.titulo}</div>
            <div class="evento-meta">
                ${formatTipoEvento(evento.tipo)}
                ${evento.local ? ` • ${evento.local}` : ''}
            </div>
        </div>
    `;
    
    item.addEventListener('click', function() {
        goToDate(evento.data_inicio || evento.start);
    });
    
    return item;
}

// Funções utilitárias globais
window.CalendarioUtils = {
    refreshCalendar,
    clearFilters,
    setQuickFilter,
    exportToPDF,
    exportToExcel,
    printCalendar,
    goToDate,
    goToToday,
    changeView,
    updateStatistics,
    updateProximosEventos
};