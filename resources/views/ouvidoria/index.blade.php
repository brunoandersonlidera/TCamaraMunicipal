@extends('layouts.app')

@section('title', 'Ouvidoria - Câmara Municipal')

@section('content')
<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.3rem;
    margin-bottom: 30px;
    opacity: 0.95;
    line-height: 1.6;
}

/* Search Section */
.search-section {
    background: white;
    padding: 40px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.search-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
}

.search-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.search-form {
    display: flex;
    gap: 15px;
    align-items: end;
}

.search-input {
    flex: 1;
}

.search-input input {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-input input:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.btn-search {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
}

.btn-new-manifestation {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-new-manifestation:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    color: white;
    text-decoration: none;
}

/* Dashboard Section */
.dashboard-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 600;
    color: #333;
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 2px;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin-bottom: 50px;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border-left: 5px solid #28a745;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.stat-card.warning {
    border-left-color: #ffc107;
}

.stat-card.danger {
    border-left-color: #dc3545;
}

.stat-card.info {
    border-left-color: #17a2b8;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Charts Section */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.chart-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.chart-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.chart-container {
    position: relative;
    height: 300px;
}

/* Action Cards */
.action-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.action-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    text-align: center;
    border: 1px solid #e9ecef;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.action-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    margin: 0 auto 20px;
}

.action-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.action-text {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.action-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    color: white;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .search-form {
        flex-direction: column;
        gap: 15px;
    }
    
    .charts-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title">Ouvidoria Municipal</h1>
            <p class="hero-subtitle">
                Sua voz é importante! Registre reclamações, sugestões, elogios e denúncias.<br>
                Acompanhe o andamento da sua manifestação de forma transparente.
            </p>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="search-card">
                    <h3 class="search-title">
                        <i class="fas fa-search me-2"></i>
                        Acompanhe sua Manifestação
                    </h3>
                    <div class="search-form">
                        <a href="{{ route('ouvidoria.consultar') }}" class="btn btn-search">
                            <i class="fas fa-search me-2"></i>
                            Consultar Manifestação
                        </a>
                        <a href="{{ route('ouvidoria.create') }}" class="btn btn-new-manifestation">
                            <i class="fas fa-plus me-2"></i>
                            Nova Manifestação
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Section -->
<section class="dashboard-section">
    <div class="container">
        <h2 class="section-title">Painel de Atendimentos</h2>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $estatisticas['total_manifestacoes'] }}</div>
                <div class="stat-label">Total de Manifestações</div>
            </div>
            <div class="stat-card info">
                <div class="stat-number">{{ $estatisticas['manifestacoes_mes'] }}</div>
                <div class="stat-label">Este Mês</div>
            </div>
            <div class="stat-card warning">
                <div class="stat-number">{{ $estatisticas['prazo_vencido'] }}</div>
                <div class="stat-label">Prazo Vencido</div>
            </div>
            <div class="stat-card danger">
                <div class="stat-number">{{ $estatisticas['prazo_vencendo_hoje'] }}</div>
                <div class="stat-label">Vence Hoje</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <!-- Status Chart -->
            <div class="chart-card">
                <h4 class="chart-title">Manifestações por Status</h4>
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Type Chart -->
            <div class="chart-card">
                <h4 class="chart-title">Manifestações por Tipo</h4>
                <div class="chart-container">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>

            <!-- Monthly Chart -->
            <div class="chart-card">
                <h4 class="chart-title">Manifestações por Mês</h4>
                <div class="chart-container">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="action-cards">
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <h4 class="action-title">Nova Manifestação</h4>
                <p class="action-text">
                    Registre sua reclamação, sugestão, elogio ou denúncia de forma rápida e segura.
                </p>
                <a href="{{ route('ouvidoria.create') }}" class="action-btn">
                    Criar Manifestação
                </a>
            </div>

            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4 class="action-title">Consultar Manifestação</h4>
                <p class="action-text">
                    Acompanhe o andamento da sua manifestação usando o número do protocolo.
                </p>
                <a href="{{ route('ouvidoria.consultar') }}" class="action-btn">
                    Consultar Protocolo
                </a>
            </div>

            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-secret"></i>
                </div>
                <h4 class="action-title">Manifestação Anônima</h4>
                <p class="action-text">
                    Faça sua manifestação de forma anônima. Seus dados serão protegidos por sigilo.
                </p>
                <a href="{{ route('ouvidoria.create', ['anonima' => 1]) }}" class="action-btn">
                    Manifestação Anônima
                </a>
            </div>

            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h4 class="action-title">Como Funciona</h4>
                <p class="action-text">
                    Saiba como funciona o processo de atendimento e acompanhamento das manifestações.
                </p>
                <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#infoModal">
                    Saiba Mais
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Como Funciona a Ouvidoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-edit text-primary me-2"></i>1. Registre sua Manifestação</h6>
                        <p>Preencha o formulário com suas informações e descreva sua manifestação.</p>
                        
                        <h6><i class="fas fa-clock text-warning me-2"></i>2. Acompanhe o Andamento</h6>
                        <p>Use o número do protocolo para acompanhar o status da sua manifestação.</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-reply text-success me-2"></i>3. Receba a Resposta</h6>
                        <p>Você será notificado quando houver atualizações ou resposta final.</p>
                        
                        <h6><i class="fas fa-star text-info me-2"></i>4. Avalie o Atendimento</h6>
                        <p>Após a resposta, você pode avaliar a qualidade do atendimento.</p>
                    </div>
                </div>
                <hr>
                <h6>Prazos de Resposta:</h6>
                <ul>
                    <li><strong>Reclamações:</strong> até 30 dias</li>
                    <li><strong>Sugestões:</strong> até 60 dias</li>
                    <li><strong>Denúncias:</strong> até 60 dias</li>
                    <li><strong>Elogios:</strong> até 30 dias</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dados do PHP para JavaScript
    const statusData = @json($estatisticas['por_status']);
    const typeData = @json($estatisticas['por_tipo']);
    const monthlyData = @json($estatisticas['por_mes']);

    // Configurações comuns dos gráficos
    const commonOptions = {
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
    };

    // Gráfico de Status (Pizza)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Nova', 'Em Análise', 'Em Tramitação', 'Aguardando Info', 'Respondida', 'Finalizada', 'Arquivada'],
            datasets: [{
                data: [
                    statusData.nova,
                    statusData.em_analise,
                    statusData.em_tramitacao,
                    statusData.aguardando_informacoes,
                    statusData.respondida,
                    statusData.finalizada,
                    statusData.arquivada
                ],
                backgroundColor: [
                    '#17a2b8',
                    '#ffc107',
                    '#fd7e14',
                    '#6f42c1',
                    '#28a745',
                    '#20c997',
                    '#6c757d'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            ...commonOptions,
            cutout: '50%'
        }
    });

    // Gráfico de Tipos (Pizza)
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: ['Reclamação', 'Sugestão', 'Elogio', 'Denúncia', 'Informação'],
            datasets: [{
                data: [
                    typeData.reclamacao,
                    typeData.sugestao,
                    typeData.elogio,
                    typeData.denuncia,
                    typeData.informacao
                ],
                backgroundColor: [
                    '#dc3545',
                    '#007bff',
                    '#28a745',
                    '#fd7e14',
                    '#6f42c1'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: commonOptions
    });

    // Gráfico Mensal (Linha)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.mes),
            datasets: [{
                label: 'Manifestações',
                data: monthlyData.map(item => item.total),
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
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            }
        }
    });
});
</script>
@endsection