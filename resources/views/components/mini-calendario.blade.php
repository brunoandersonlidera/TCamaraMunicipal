{{-- Mini Calendário para Página Inicial --}}
<div class="mini-calendario-container">
    <div class="mini-calendario-header">
        <h5 class="mb-0">
            <i class="fas fa-calendar-alt me-2"></i>
            Agenda Legislativa
        </h5>
        <div class="calendario-navegacao">
            <button type="button" class="btn btn-sm btn-outline-primary" id="mesAnterior">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span id="mesAnoAtual" class="mx-2 fw-bold"></span>
            <button type="button" class="btn btn-sm btn-outline-primary" id="proximoMes">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="mini-calendario-grid">
        <div class="calendario-dias-semana">
            <div class="dia-semana">Dom</div>
            <div class="dia-semana">Seg</div>
            <div class="dia-semana">Ter</div>
            <div class="dia-semana">Qua</div>
            <div class="dia-semana">Qui</div>
            <div class="dia-semana">Sex</div>
            <div class="dia-semana">Sáb</div>
        </div>
        <div class="calendario-dias" id="calendarioDias">
            {{-- Dias serão preenchidos via JavaScript --}}
        </div>
    </div>

    <div class="proximos-eventos">
        <h6 class="mb-2">
            <i class="fas fa-clock me-1"></i>
            Próximos Eventos
        </h6>
        <div id="listaProximosEventos" class="lista-eventos">
            {{-- Eventos serão carregados via JavaScript --}}
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('calendario.agenda') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-calendar me-1"></i>
                Ver Agenda Completa
            </a>
        </div>
    </div>

    {{-- Loading --}}
    <div id="calendarioLoading" class="text-center py-3" style="display: none;">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <small class="d-block mt-2 text-muted">Carregando eventos...</small>
    </div>
</div>

{{-- Modal para detalhes do evento --}}
<div class="modal fade" id="eventoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="eventoModalBody">
                {{-- Conteúdo será preenchido via JavaScript --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <a href="#" id="eventoModalLink" class="btn btn-primary" style="display: none;">
                    Ver Detalhes
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.mini-calendario-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 20px;
    height: fit-content;
}

.mini-calendario-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
}

.mini-calendario-header h5 {
    color: #2c3e50;
    font-weight: 600;
}

.calendario-navegacao {
    display: flex;
    align-items: center;
}

.calendario-navegacao button {
    width: 30px;
    height: 30px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

#mesAnoAtual {
    font-size: 0.9rem;
    color: #495057;
    min-width: 120px;
    text-align: center;
}

.mini-calendario-grid {
    margin-bottom: 20px;
}

.calendario-dias-semana {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    margin-bottom: 5px;
}

.dia-semana {
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6c757d;
    padding: 5px 0;
}

.calendario-dias {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
}

.calendario-dia {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    background: #f8f9fa;
}

.calendario-dia:hover {
    background: #e9ecef;
}

.calendario-dia.hoje {
    background: #007bff;
    color: white;
    font-weight: 600;
}

.calendario-dia.com-evento {
    background: #28a745;
    color: white;
    font-weight: 500;
}

.calendario-dia.com-evento.hoje {
    background: #dc3545;
}

.calendario-dia.outro-mes {
    color: #adb5bd;
    background: transparent;
}

.calendario-dia.com-evento::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    background: currentColor;
    border-radius: 50%;
}

.proximos-eventos h6 {
    color: #2c3e50;
    font-weight: 600;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 8px;
}

.lista-eventos {
    max-height: 200px;
    overflow-y: auto;
}

.evento-item {
    display: flex;
    align-items: flex-start;
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
    cursor: pointer;
    transition: background 0.2s ease;
}

.evento-item:hover {
    background: #f8f9fa;
    border-radius: 6px;
    padding-left: 8px;
    padding-right: 8px;
}

.evento-item:last-child {
    border-bottom: none;
}

.evento-cor {
    width: 4px;
    height: 100%;
    border-radius: 2px;
    margin-right: 10px;
    flex-shrink: 0;
    min-height: 40px;
}

.evento-info {
    flex: 1;
}

.evento-titulo {
    font-size: 0.85rem;
    font-weight: 500;
    color: #2c3e50;
    margin-bottom: 2px;
    line-height: 1.3;
}

.evento-data {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 1px;
}

.evento-tipo {
    font-size: 0.7rem;
    color: #868e96;
}

.evento-vazio {
    text-align: center;
    color: #6c757d;
    font-size: 0.85rem;
    padding: 20px 0;
}

@media (max-width: 768px) {
    .mini-calendario-container {
        padding: 15px;
    }
    
    .mini-calendario-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .calendario-dia {
        font-size: 0.75rem;
    }
    
    #mesAnoAtual {
        font-size: 0.85rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const miniCalendario = new MiniCalendario();
    miniCalendario.init();
});

class MiniCalendario {
    constructor() {
        this.anoAtual = new Date().getFullYear();
        this.mesAtual = new Date().getMonth() + 1;
        this.eventos = {};
        this.proximosEventos = [];
    }

    init() {
        this.setupEventListeners();
        this.carregarCalendario();
    }

    setupEventListeners() {
        document.getElementById('mesAnterior').addEventListener('click', () => {
            this.navegarMes(-1);
        });

        document.getElementById('proximoMes').addEventListener('click', () => {
            this.navegarMes(1);
        });
    }

    navegarMes(direcao) {
        this.mesAtual += direcao;
        
        if (this.mesAtual > 12) {
            this.mesAtual = 1;
            this.anoAtual++;
        } else if (this.mesAtual < 1) {
            this.mesAtual = 12;
            this.anoAtual--;
        }
        
        this.carregarCalendario();
    }

    async carregarCalendario() {
        this.mostrarLoading(true);
        
        try {
            const response = await fetch(`/calendario/mini?ano=${this.anoAtual}&mes=${this.mesAtual}`);
            const data = await response.json();
            
            this.eventos = data.eventos;
            this.proximosEventos = data.proximosEventos;
            
            this.renderizarCalendario(data.calendario);
            this.renderizarProximosEventos();
            
        } catch (error) {
            console.error('Erro ao carregar calendário:', error);
        } finally {
            this.mostrarLoading(false);
        }
    }

    renderizarCalendario(calendario) {
        // Atualizar cabeçalho
        document.getElementById('mesAnoAtual').textContent = 
            `${calendario.mesNome} ${calendario.ano}`;

        // Limpar dias
        const containerDias = document.getElementById('calendarioDias');
        containerDias.innerHTML = '';

        // Adicionar dias vazios do início
        for (let i = 0; i < calendario.primeiroDiaSemana; i++) {
            const diaVazio = document.createElement('div');
            diaVazio.className = 'calendario-dia outro-mes';
            containerDias.appendChild(diaVazio);
        }

        // Adicionar dias do mês
        const hoje = new Date();
        const isHoje = (dia) => {
            return hoje.getFullYear() === calendario.ano && 
                   hoje.getMonth() + 1 === calendario.mes && 
                   hoje.getDate() === dia;
        };

        for (let dia = 1; dia <= calendario.diasMes; dia++) {
            const elementoDia = document.createElement('div');
            elementoDia.className = 'calendario-dia';
            elementoDia.textContent = dia;
            
            if (isHoje(dia)) {
                elementoDia.classList.add('hoje');
            }
            
            if (this.eventos[dia]) {
                elementoDia.classList.add('com-evento');
                elementoDia.addEventListener('click', () => {
                    this.mostrarEventosDia(dia);
                });
            }
            
            containerDias.appendChild(elementoDia);
        }
    }

    renderizarProximosEventos() {
        const container = document.getElementById('listaProximosEventos');
        
        if (this.proximosEventos.length === 0) {
            container.innerHTML = `
                <div class="evento-vazio">
                    <i class="fas fa-calendar-times mb-2"></i><br>
                    Nenhum evento próximo
                </div>
            `;
            return;
        }

        container.innerHTML = this.proximosEventos.map(evento => `
            <div class="evento-item" onclick="miniCalendario.mostrarDetalhesEvento(${evento.id})">
                <div class="evento-cor" style="background-color: ${evento.cor || '#007bff'}"></div>
                <div class="evento-info">
                    <div class="evento-titulo">${evento.titulo}</div>
                    <div class="evento-data">${evento.data_formatada}</div>
                    <div class="evento-tipo">${evento.tipo_label}</div>
                </div>
            </div>
        `).join('');
    }

    mostrarEventosDia(dia) {
        const eventosDay = this.eventos[dia];
        if (!eventosDay || eventosDay.length === 0) return;

        const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
        const modalTitle = document.getElementById('eventoModalTitle');
        const modalBody = document.getElementById('eventoModalBody');

        modalTitle.textContent = `Eventos do dia ${dia}`;
        
        modalBody.innerHTML = eventosDay.map(evento => `
            <div class="mb-3 p-3 border rounded">
                <h6 class="mb-2" style="color: ${evento.cor || '#007bff'}">
                    ${evento.titulo}
                </h6>
                <p class="mb-1"><strong>Tipo:</strong> ${evento.tipo_label}</p>
                ${evento.horario_formatado ? `<p class="mb-1"><strong>Horário:</strong> ${evento.horario_formatado}</p>` : ''}
                ${evento.local ? `<p class="mb-1"><strong>Local:</strong> ${evento.local}</p>` : ''}
                ${evento.descricao ? `<p class="mb-0"><small>${evento.descricao}</small></p>` : ''}
            </div>
        `).join('');

        modal.show();
    }

    mostrarDetalhesEvento(eventoId) {
        // Implementar modal com detalhes do evento
        window.location.href = `/calendario/evento/${eventoId}`;
    }

    mostrarLoading(mostrar) {
        const loading = document.getElementById('calendarioLoading');
        const calendario = document.querySelector('.mini-calendario-grid');
        const eventos = document.querySelector('.proximos-eventos');
        
        if (mostrar) {
            loading.style.display = 'block';
            calendario.style.opacity = '0.5';
            eventos.style.opacity = '0.5';
        } else {
            loading.style.display = 'none';
            calendario.style.opacity = '1';
            eventos.style.opacity = '1';
        }
    }
}

// Instância global para acesso
let miniCalendario;
</script>