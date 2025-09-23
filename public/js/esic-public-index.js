/**
 * E-SIC Public Index Page JavaScript
 * Handles charts and interactive elements for the public E-SIC page
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts if data containers exist
    initializeCharts();
});

function initializeCharts() {
    const chartsContainer = document.getElementById('esic-public-charts-container');
    if (!chartsContainer) return;

    try {
        // Get data from HTML attributes
        const categoriaData = JSON.parse(chartsContainer.dataset.categoriaData || '[]');
        const mesData = JSON.parse(chartsContainer.dataset.mesData || '[]');

        // Initialize categoria chart if data exists
        if (categoriaData.length > 0) {
            initializeCategoriaChart(categoriaData);
        }

        // Initialize mes chart if data exists
        if (mesData.length > 0) {
            initializeMesChart(mesData);
        }
    } catch (error) {
        console.error('Error initializing E-SIC public charts:', error);
    }
}

function initializeCategoriaChart(categoriaData) {
    const categoriaCtx = document.getElementById('categoriaChart');
    if (!categoriaCtx) return;

    new Chart(categoriaCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: categoriaData.map(item => item.categoria),
            datasets: [{
                data: categoriaData.map(item => item.total),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function initializeMesChart(mesData) {
    const mesCtx = document.getElementById('mesChart');
    if (!mesCtx) return;

    new Chart(mesCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: mesData.map(item => item.mes),
            datasets: [{
                label: 'Solicitações',
                data: mesData.map(item => item.total),
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}