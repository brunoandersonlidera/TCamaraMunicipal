// Dashboard JavaScript
// Configuração dos gráficos
const chartColors = {
    primary: '#667eea',
    secondary: '#764ba2',
    success: '#43e97b',
    info: '#4facfe',
    warning: '#fee140',
    danger: '#f5576c'
};

// Gráfico de solicitações por mês
function initMonthlyChart() {
    const monthlyCtx = document.getElementById('monthlyChart');
    if (!monthlyCtx) return;
    
    const monthlyChart = new Chart(monthlyCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                label: 'E-SIC',
                data: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45],
                borderColor: chartColors.primary,
                backgroundColor: chartColors.primary + '20',
                tension: 0.4,
                fill: true
            }, {
                label: 'Ouvidoria',
                data: [8, 15, 12, 18, 16, 22, 20, 25, 23, 28, 26, 32],
                borderColor: chartColors.danger,
                backgroundColor: chartColors.danger + '20',
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
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f3f4'
                    }
                },
                x: {
                    grid: {
                        color: '#f1f3f4'
                    }
                }
            }
        }
    });
}

// Gráfico de distribuição por tipo
function initTypeChart() {
    const typeCtx = document.getElementById('typeChart');
    if (!typeCtx) return;
    
    const typeChart = new Chart(typeCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['E-SIC', 'Reclamações', 'Sugestões', 'Elogios', 'Denúncias'],
            datasets: [{
                data: [45, 25, 15, 10, 5],
                backgroundColor: [
                    chartColors.primary,
                    chartColors.danger,
                    chartColors.success,
                    chartColors.info,
                    chartColors.warning
                ],
                borderWidth: 0
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

// Atualizar dados em tempo real (simulação)
function updateDashboard() {
    // Simular atualização de dados
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const currentValue = parseInt(stat.textContent);
        const change = Math.floor(Math.random() * 3) - 1; // -1, 0, ou 1
        if (change !== 0) {
            stat.textContent = currentValue + change;
        }
    });
}

// Animação de entrada dos cards
function animateCards() {
    const cards = document.querySelectorAll('.stat-card, .chart-card, .action-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Inicializar dashboard
function initDashboard() {
    initMonthlyChart();
    initTypeChart();
    animateCards();
    
    // Atualizar a cada 5 minutos (era 30 segundos) - reduzido para evitar excesso de conexões
    setInterval(updateDashboard, 300000); // 5 minutos
}

// Executar quando a página carregar
document.addEventListener('DOMContentLoaded', initDashboard);