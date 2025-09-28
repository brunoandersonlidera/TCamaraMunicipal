/**
 * Portal da Transparência - Scripts JavaScript
 */

// Configuração global do Chart.js
Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.color = '#6c757d';

// Classe principal do Portal da Transparência
class PortalTransparencia {
    constructor() {
        this.evolucaoChart = null;
        this.evolucaoData = [];
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.loadEvolucaoData();
            this.initAnimations();
            this.initTooltips();
            this.initCounters();
        });
    }

    /**
     * Carrega os dados de evolução mensal via AJAX
     */
    async loadEvolucaoData() {
        try {
            const response = await fetch('/transparencia/api/evolucao-mensal');
            if (response.ok) {
                this.evolucaoData = await response.json();
                this.initEvolucaoChart();
            } else {
                console.error('Erro ao carregar dados de evolução mensal');
                this.evolucaoData = [];
                this.initEvolucaoChart();
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            this.evolucaoData = [];
            this.initEvolucaoChart();
        }
    }

    /**
     * Inicializa o gráfico de evolução mensal
     */
    initEvolucaoChart() {
        const chartElement = document.getElementById('evolucaoChart');
        if (!chartElement) return;

        const ctx = chartElement.getContext('2d');

        this.evolucaoChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.evolucaoData.map(item => item.mes_nome),
                datasets: [{
                    label: 'Receitas',
                    data: this.evolucaoData.map(item => item.receita),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#28a745',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }, {
                    label: 'Despesas',
                    data: this.evolucaoData.map(item => item.despesa),
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#dc3545',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#007bff',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': R$ ' + 
                                       new Intl.NumberFormat('pt-BR', {
                                           minimumFractionDigits: 2,
                                           maximumFractionDigits: 2
                                       }).format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Período',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Valor (R$)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + new Intl.NumberFormat('pt-BR', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }).format(value);
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    /**
     * Inicializa animações de entrada
     */
    initAnimations() {
        // Animação dos cards de estatísticas
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach((card, index) => {
            setTimeout(() => {
                // Verificação de segurança para classList
                if (card && card.classList) {
                    try {
                        card.classList.add('fade-in-up');
                    } catch (error) {
                        console.warn('Erro ao adicionar classe fade-in-up ao card:', error);
                    }
                }
            }, index * 200);
        });

        // Animação dos botões de navegação
        const navButtons = document.querySelectorAll('.nav-quick-access .btn');
        navButtons.forEach((btn, index) => {
            setTimeout(() => {
                // Verificação de segurança para classList
                if (btn && btn.classList) {
                    try {
                        btn.classList.add('fade-in-up');
                    } catch (error) {
                        console.warn('Erro ao adicionar classe fade-in-up ao btn:', error);
                    }
                }
            }, (index * 100) + 800);
        });
    }

    /**
     * Inicializa tooltips do Bootstrap
     */
    initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    /**
     * Inicializa contadores animados
     */
    initCounters() {
        const counters = document.querySelectorAll('.counter');
        
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = Math.floor(current).toLocaleString('pt-BR');
            }, 16);
        };

        // Observador de interseção para animar quando visível
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        counters.forEach(counter => {
            observer.observe(counter);
        });
    }

    /**
     * Formata valores monetários
     */
    static formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    }

    /**
     * Formata números
     */
    static formatNumber(value) {
        return new Intl.NumberFormat('pt-BR').format(value);
    }

    /**
     * Atualiza dados do gráfico
     */
    updateChartData(newData) {
        if (!this.evolucaoChart) return;

        this.evolucaoChart.data.labels = newData.map(item => item.mes_nome);
        this.evolucaoChart.data.datasets[0].data = newData.map(item => item.receita);
        this.evolucaoChart.data.datasets[1].data = newData.map(item => item.despesa);
        this.evolucaoChart.update('active');
    }

    /**
     * Exporta dados do gráfico
     */
    exportChartData() {
        if (!this.evolucaoChart) return;

        const canvas = this.evolucaoChart.canvas;
        const url = canvas.toDataURL('image/png');
        
        const link = document.createElement('a');
        link.download = 'evolucao-mensal-transparencia.png';
        link.href = url;
        link.click();
    }
}

// Utilitários globais
window.TransparenciaUtils = {
    /**
     * Copia texto para a área de transferência
     */
    copyToClipboard: function(text) {
        navigator.clipboard.writeText(text).then(() => {
            this.showToast('Texto copiado para a área de transferência!', 'success');
        });
    },

    /**
     * Exibe toast de notificação
     */
    showToast: function(message, type = 'info') {
        // Implementação básica de toast
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 5000);
    },

    /**
     * Valida CPF
     */
    validateCPF: function(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || !!cpf.match(/(\d)\1{10}/)) return false;
        
        const digits = cpf.split('').map(el => +el);
        const rest = (count) => (digits.slice(0, count-12)
            .reduce((soma, el, index) => (soma + el * (count-index)), 0) * 10) % 11 % 10;
        
        return rest(10) === digits[9] && rest(11) === digits[10];
    }
};

// Inicializa o Portal da// Inicialização global
const portalTransparencia = new PortalTransparencia();

// Exportar para uso global
window.PortalTransparencia = PortalTransparencia;
window.portalTransparencia = portalTransparencia;