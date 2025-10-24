/**
 * JavaScript específico para o painel do Ouvidor
 */

// Configurações globais
const OuvidorApp = {
    config: {
        refreshInterval: 300000, // 5 minutos (era 30 segundos) - reduzido para evitar excesso de conexões
        notificationSound: true,
        autoRefresh: false // DESABILITADO TEMPORARIAMENTE para evitar excesso de conexões
    },
    
    charts: {},
    intervals: {},
    
    // Inicialização
    init() {
        this.initEventListeners();
        this.initCharts();
        this.initNotifications();
        this.initAutoRefresh();
        this.initTooltips();
        this.initModals();
        this.initThemeToggle();
        console.log('Ouvidor App inicializado');
    },
    
    // Event Listeners
    initEventListeners() {
        // Botões de ação rápida
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-action]')) {
                this.handleQuickAction(e.target.dataset.action, e.target);
            }
        });
        
        // Filtro de período
        const periodFilter = document.getElementById('periodFilter');
        if (periodFilter) {
            periodFilter.addEventListener('change', () => {
                this.updateDashboardData(periodFilter.value);
            });
        }
        
        // Filtros de manifestações
        const filtros = document.querySelectorAll('.filtro-manifestacao');
        filtros.forEach(filtro => {
            filtro.addEventListener('change', () => this.filtrarManifestacoes());
        });
        
        // Busca em tempo real
        const searchInput = document.getElementById('searchManifestacoes');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(() => {
                this.buscarManifestacoes(searchInput.value);
            }, 300));
        }
        
        // Configurações
        const configForm = document.getElementById('configForm');
        if (configForm) {
            configForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.salvarConfiguracoes(new FormData(configForm));
            });
        }
    },
    
    // Inicializar gráficos
    initCharts() {
        this.initPerformanceChart();
        this.initStatusChart();
        this.initTipoChart();
    },
    
    // Gráfico de performance
    initPerformanceChart() {
        const ctx = document.getElementById('performanceChart');
        if (!ctx) return;
        
        this.charts.performance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Manifestações Recebidas',
                    data: [],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Manifestações Respondidas',
                    data: [],
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Performance dos Últimos 30 Dias'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        
        this.loadPerformanceData();
    },
    
    // Gráfico de status
    initStatusChart() {
        const ctx = document.getElementById('statusChart');
        if (!ctx) return;
        
        this.charts.status = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pendentes', 'Em Andamento', 'Respondidas', 'Vencidas'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: [
                        '#f39c12',
                        '#3498db',
                        '#2ecc71',
                        '#e74c3c'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Status das Manifestações'
                    }
                }
            }
        });
        
        this.loadStatusData();
    },
    
    // Gráfico de tipos
    initTipoChart() {
        const ctx = document.getElementById('tipoChart');
        if (!ctx) return;
        
        this.charts.tipo = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Quantidade',
                    data: [],
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: '#667eea',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Manifestações por Tipo'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        
        this.loadTipoData();
    },
    
    // Carregar dados dos gráficos
    async loadPerformanceData(period = null) {
        try {
            const url = period ? `/ouvidor/api/performance-data?period=${period}` : '/ouvidor/api/performance-data';
            const response = await fetch(url);
            const data = await response.json();
            
            if (this.charts.performance) {
                this.charts.performance.data.labels = data.labels;
                this.charts.performance.data.datasets[0].data = data.recebidas;
                this.charts.performance.data.datasets[1].data = data.respondidas;
                this.charts.performance.update();
            }
        } catch (error) {
            console.error('Erro ao carregar dados de performance:', error);
        }
    },
    
    async loadStatusData(period = null) {
        try {
            const url = period ? `/ouvidor/api/status-data?period=${period}` : '/ouvidor/api/status-data';
            const response = await fetch(url);
            const data = await response.json();
            
            if (this.charts.status) {
                this.charts.status.data.datasets[0].data = [
                    data.pendentes,
                    data.em_andamento,
                    data.respondidas,
                    data.vencidas
                ];
                this.charts.status.update();
            }
        } catch (error) {
            console.error('Erro ao carregar dados de status:', error);
        }
    },
    
    async loadTipoData(period = null) {
        try {
            const url = period ? `/ouvidor/api/tipo-data?period=${period}` : '/ouvidor/api/tipo-data';
            const response = await fetch(url);
            const data = await response.json();
            
            if (this.charts.tipo) {
                this.charts.tipo.data.labels = data.labels;
                this.charts.tipo.data.datasets[0].data = data.valores;
                this.charts.tipo.update();
            }
        } catch (error) {
            console.error('Erro ao carregar dados de tipo:', error);
        }
    },
    
    // Atualizar dados do dashboard com filtro de período
    async updateDashboardData(period) {
        try {
            // Atualizar estatísticas/KPIs
            const url = period ? `/ouvidor/api/stats?period=${period}` : '/ouvidor/api/stats';
            const response = await fetch(url);
            const stats = await response.json();
            
            this.updateKPIs(stats);
            
            // Atualizar gráficos
            this.loadPerformanceData(period);
            this.loadStatusData(period);
            this.loadTipoData(period);
            
            console.log(`Dashboard atualizado para o período: ${period}`);
        } catch (error) {
            console.error('Erro ao atualizar dados do dashboard:', error);
            this.showAlert('Erro ao atualizar dados. Tente novamente.', 'danger');
        }
    },
    
    // Atualizar KPIs com mapeamento de objeto aninhado
    updateKPIs(stats) {
        const kpiMapping = {
            // Manifestações
            manifestacoesTotal: stats.manifestacoes?.total || 0,
            manifestacoesPendentes: stats.manifestacoes?.pendentes || 0,
            manifestacoesEmAndamento: stats.manifestacoes?.em_andamento || 0,
            manifestacoesRespondidas: stats.manifestacoes?.respondidas || 0,
            manifestacoesEncerradas: stats.manifestacoes?.encerradas || 0,
            
            // E-SIC
            esicTotal: stats.esic?.total || 0,
            esicPendentes: stats.esic?.pendentes || 0,
            esicEmAndamento: stats.esic?.em_andamento || 0,
            esicRespondidas: stats.esic?.respondidas || 0,
            
            // Performance
            respondidasMes: stats.performance?.respondidas_mes || 0,
            tempoMedioResposta: stats.performance?.tempo_medio_resposta || '0 dias',
            prazoVencido: stats.performance?.prazo_vencido || 0,
            
            // Alertas
            alertasTotal: stats.alertas?.total || 0,
            alertasVencidas: stats.alertas?.vencidas || 0,
            alertasVencendo: stats.alertas?.vencendo || 0
        };
        
        Object.keys(kpiMapping).forEach(kpiId => {
            const element = document.getElementById(kpiId);
            if (element) {
                element.textContent = kpiMapping[kpiId];
                element.classList.add('pulse');
                setTimeout(() => element.classList.remove('pulse'), 1000);
            }
        });
    },
    
    // Notificações
    initNotifications() {
        this.checkNotifications();
        
        // TEMPORARIAMENTE DESABILITADO para evitar excesso de conexões
        // Verificar notificações a cada 10 minutos (era 2 minutos)
        /*
        this.intervals.notifications = setInterval(() => {
            this.checkNotifications();
        }, 600000); // 10 minutos (era 120000 = 2 minutos)
        */
    },
    
    async checkNotifications() {
        try {
            const response = await fetch('/ouvidor/api/notifications');
            const notifications = await response.json();
            
            this.updateNotificationBadge(notifications.length);
            this.updateNotificationList(notifications);
            
            // Tocar som se houver novas notificações
            if (notifications.length > 0 && this.config.notificationSound) {
                this.playNotificationSound();
            }
        } catch (error) {
            console.error('Erro ao verificar notificações:', error);
        }
    },
    
    updateNotificationBadge(count) {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline' : 'none';
        }
    },
    
    updateNotificationList(notifications) {
        const list = document.getElementById('notificationList');
        if (!list) return;
        
        list.innerHTML = '';
        
        if (notifications.length === 0) {
            list.innerHTML = '<div class="dropdown-item text-muted">Nenhuma notificação</div>';
            return;
        }
        
        notifications.forEach(notification => {
            const item = document.createElement('div');
            item.className = 'dropdown-item notification-item';
            item.innerHTML = `
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${notification.titulo}</h6>
                        <p class="mb-1 text-muted small">${notification.mensagem}</p>
                        <small class="text-muted">${notification.tempo}</small>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="OuvidorApp.markAsRead(${notification.id})">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            `;
            list.appendChild(item);
        });
    },
    
    async markAsRead(notificationId) {
        try {
            await fetch(`/ouvidor/api/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            this.checkNotifications();
        } catch (error) {
            console.error('Erro ao marcar notificação como lida:', error);
        }
    },
    
    playNotificationSound() {
        // Criar um som simples usando Web Audio API
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    },
    
    // Theme Toggle (Dark/Light Mode)
    initThemeToggle() {
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        
        if (!themeToggle || !themeIcon) return;
        
        // Verificar tema salvo ou preferência do sistema
        const savedTheme = localStorage.getItem('ouvidor-theme');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const currentTheme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
        
        // Aplicar tema inicial
        this.setTheme(currentTheme);
        
        // Event listener para o botão
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            this.setTheme(newTheme);
        });
        
        // Escutar mudanças na preferência do sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('ouvidor-theme')) {
                this.setTheme(e.matches ? 'dark' : 'light');
            }
        });
    },
    
    setTheme(theme) {
        const themeIcon = document.getElementById('themeIcon');
        
        // Aplicar tema ao documento
        document.documentElement.setAttribute('data-theme', theme);
        
        // Atualizar ícone
        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-moon';
                themeIcon.parentElement.title = 'Alternar para modo claro';
            } else {
                themeIcon.className = 'fas fa-sun';
                themeIcon.parentElement.title = 'Alternar para modo escuro';
            }
        }
        
        // Salvar preferência
        localStorage.setItem('ouvidor-theme', theme);
        
        // Animação suave
        document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
        setTimeout(() => {
            document.body.style.transition = '';
        }, 300);
        
        console.log(`Tema alterado para: ${theme}`);
    },
    
    // Auto refresh
    initAutoRefresh() {
        if (this.config.autoRefresh) {
            this.intervals.refresh = setInterval(() => {
                this.refreshDashboard();
            }, this.config.refreshInterval);
        }
    },
    
    async refreshDashboard() {
        try {
            // Atualizar estatísticas
            const response = await fetch('/ouvidor/api/stats');
            const stats = await response.json();
            
            this.updateStats(stats);
            this.loadPerformanceData();
            this.loadStatusData();
            this.loadTipoData();
            
            // Mostrar indicador de atualização
            this.showRefreshIndicator();
        } catch (error) {
            console.error('Erro ao atualizar dashboard:', error);
        }
    },
    
    updateStats(stats) {
        Object.keys(stats).forEach(key => {
            const element = document.getElementById(`stat-${key}`);
            if (element) {
                element.textContent = stats[key];
                element.classList.add('pulse');
                setTimeout(() => element.classList.remove('pulse'), 1000);
            }
        });
    },
    
    showRefreshIndicator() {
        const indicator = document.getElementById('refreshIndicator');
        if (indicator) {
            indicator.style.display = 'block';
            setTimeout(() => {
                indicator.style.display = 'none';
            }, 2000);
        }
    },
    
    // Ações rápidas
    async handleQuickAction(action, button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
        button.disabled = true;
        
        try {
            switch (action) {
                case 'nova-manifestacao':
                    window.location.href = '/ouvidor/manifestacoes/create';
                    break;
                case 'relatorio-mensal':
                    await this.gerarRelatorio('mensal');
                    break;
                case 'exportar-dados':
                    await this.exportarDados();
                    break;
                case 'backup-dados':
                    await this.backupDados();
                    break;
                default:
                    console.warn('Ação não reconhecida:', action);
            }
        } catch (error) {
            console.error('Erro na ação rápida:', error);
            this.showAlert('Erro ao executar ação. Tente novamente.', 'danger');
        } finally {
            button.innerHTML = originalText;
            button.disabled = false;
        }
    },
    
    // Filtros e busca
    filtrarManifestacoes() {
        const filtros = {};
        document.querySelectorAll('.filtro-manifestacao').forEach(filtro => {
            if (filtro.value) {
                filtros[filtro.name] = filtro.value;
            }
        });
        
        const params = new URLSearchParams(filtros);
        window.location.search = params.toString();
    },
    
    async buscarManifestacoes(termo) {
        if (termo.length < 3) return;
        
        try {
            const response = await fetch(`/ouvidor/api/manifestacoes/search?q=${encodeURIComponent(termo)}`);
            const resultados = await response.json();
            
            this.exibirResultadosBusca(resultados);
        } catch (error) {
            console.error('Erro na busca:', error);
        }
    },
    
    exibirResultadosBusca(resultados) {
        const container = document.getElementById('resultadosBusca');
        if (!container) return;
        
        container.innerHTML = '';
        
        if (resultados.length === 0) {
            container.innerHTML = '<div class="alert alert-info">Nenhum resultado encontrado.</div>';
            return;
        }
        
        resultados.forEach(resultado => {
            const item = document.createElement('div');
            item.className = 'card mb-2';
            item.innerHTML = `
                <div class="card-body">
                    <h6 class="card-title">${resultado.titulo}</h6>
                    <p class="card-text text-muted">${resultado.resumo}</p>
                    <a href="/ouvidor/manifestacoes/${resultado.id}" class="btn btn-sm btn-ouvidor-primary">Ver Detalhes</a>
                </div>
            `;
            container.appendChild(item);
        });
    },
    
    // Utilitários
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer') || document.body;
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    },
    
    // Tooltips
    initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    },
    
    // Modais
    initModals() {
        // Configurar modais de confirmação
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-confirm]')) {
                e.preventDefault();
                this.showConfirmModal(e.target.dataset.confirm, () => {
                    if (e.target.href) {
                        window.location.href = e.target.href;
                    } else if (e.target.onclick) {
                        e.target.onclick();
                    }
                });
            }
        });
    },
    
    showConfirmModal(message, callback) {
        const modal = document.getElementById('confirmModal');
        if (!modal) {
            // Criar modal dinamicamente se não existir
            this.createConfirmModal();
        }
        
        document.getElementById('confirmMessage').textContent = message;
        document.getElementById('confirmButton').onclick = () => {
            callback();
            bootstrap.Modal.getInstance(modal).hide();
        };
        
        new bootstrap.Modal(modal).show();
    },
    
    createConfirmModal() {
        const modal = document.createElement('div');
        modal.id = 'confirmModal';
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p id="confirmMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmButton">Confirmar</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    },
    
    // Configurações
    async salvarConfiguracoes(formData) {
        try {
            const response = await fetch('/ouvidor/configuracoes', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) {
                this.showAlert('Configurações salvas com sucesso!', 'success');
                
                // Atualizar configurações locais
                const data = await response.json();
                Object.assign(this.config, data);
                
                // Reiniciar auto refresh se necessário
                if (this.config.autoRefresh) {
                    this.initAutoRefresh();
                } else {
                    clearInterval(this.intervals.refresh);
                }
            } else {
                throw new Error('Erro ao salvar configurações');
            }
        } catch (error) {
            console.error('Erro ao salvar configurações:', error);
            this.showAlert('Erro ao salvar configurações. Tente novamente.', 'danger');
        }
    },
    
    // Cleanup
    destroy() {
        Object.values(this.intervals).forEach(interval => {
            clearInterval(interval);
        });
        
        Object.values(this.charts).forEach(chart => {
            chart.destroy();
        });
        
        console.log('Ouvidor App destruído');
    }
};

// Inicializar quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    OuvidorApp.init();
});

// Cleanup ao sair da página
window.addEventListener('beforeunload', () => {
    OuvidorApp.destroy();
});

// Exportar para uso global
window.OuvidorApp = OuvidorApp;