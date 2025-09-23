/**
 * JavaScript para gráficos das estatísticas E-SIC
 * Utiliza Chart.js para renderizar os gráficos
 */

document.addEventListener('DOMContentLoaded', function() {
    // Configurações gerais dos gráficos
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.color = '#6c757d';

    // Função para inicializar o gráfico de status
    function initStatusChart(statusData) {
        const statusCtx = document.getElementById('statusChart');
        if (!statusCtx) return;

        const statusLabels = Object.keys(statusData).map(status => {
            const statusMap = {
                'pendente': 'Pendente',
                'em_analise': 'Em Análise',
                'respondida': 'Respondida',
                'finalizada': 'Finalizada',
                'negada': 'Negada'
            };
            return statusMap[status] || 'Outros';
        });
        const statusValues = Object.values(statusData);
        const statusColors = ['#ffc107', '#17a2b8', '#28a745', '#007bff', '#dc3545'];

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: statusColors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    // Função para inicializar o gráfico de categorias
    function initCategoriaChart(categoriaData, categorias) {
        const categoriaCtx = document.getElementById('categoriaChart');
        if (!categoriaCtx) return;

        const categoriaLabels = Object.keys(categoriaData).map(cat => categorias[cat] || 'Outros');
        const categoriaValues = Object.values(categoriaData);

        new Chart(categoriaCtx, {
            type: 'bar',
            data: {
                labels: categoriaLabels,
                datasets: [{
                    label: 'Solicitações',
                    data: categoriaValues,
                    backgroundColor: '#007bff',
                    borderColor: '#0056b3',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Função para inicializar o gráfico de evolução mensal
    function initEvolucaoChart(evolucaoData) {
        const evolucaoCtx = document.getElementById('evolucaoChart');
        if (!evolucaoCtx) return;

        const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        const evolucaoLabels = Object.keys(evolucaoData).map(mes => meses[parseInt(mes) - 1]);
        const evolucaoValues = Object.values(evolucaoData);

        new Chart(evolucaoCtx, {
            type: 'line',
            data: {
                labels: evolucaoLabels,
                datasets: [{
                    label: 'Solicitações por Mês',
                    data: evolucaoValues,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#28a745',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Função principal para inicializar todos os gráficos
    function initEsicCharts(statusData, categoriaData, categorias, evolucaoData) {
        initStatusChart(statusData);
        initCategoriaChart(categoriaData, categorias);
        initEvolucaoChart(evolucaoData);
    }

    // Função para inicializar automaticamente com dados dos atributos HTML
    function autoInitCharts() {
        const container = document.getElementById('esic-charts-container');
        if (!container) return;

        try {
            const statusData = JSON.parse(container.dataset.statusData || '{}');
            const categoriaData = JSON.parse(container.dataset.categoriaData || '{}');
            const categorias = JSON.parse(container.dataset.categorias || '{}');
            const evolucaoData = JSON.parse(container.dataset.evolucaoData || '[]');

            initEsicCharts(statusData, categoriaData, categorias, evolucaoData);
        } catch (error) {
            console.error('Erro ao inicializar gráficos E-SIC:', error);
        }
    }

    // Inicializar automaticamente quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', autoInitCharts);

    // Expor as funções globalmente para compatibilidade
    window.initEsicCharts = initEsicCharts;
    window.autoInitCharts = autoInitCharts;
});