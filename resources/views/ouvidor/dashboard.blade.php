@extends('layouts.ouvidor')

@section('title', 'Dashboard - Ouvidor')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
.ouvidor-dashboard {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.dashboard-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stat-card.manifestacoes {
    border-left: 5px solid #3498db;
}

.stat-card.esic {
    border-left: 5px solid #e74c3c;
}

.stat-card.performance {
    border-left: 5px solid #2ecc71;
}

.stat-card.alertas {
    border-left: 5px solid #f39c12;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.stat-card.manifestacoes .stat-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.stat-card.esic .stat-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.stat-card.performance .stat-icon {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
}

.stat-card.alertas .stat-icon {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #7f8c8d;
    font-size: 1rem;
    margin-bottom: 1rem;
}

.stat-details {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
}

.stat-detail {
    text-align: center;
}

.stat-detail-number {
    font-weight: bold;
    color: #2c3e50;
}

.stat-detail-label {
    color: #95a5a6;
    font-size: 0.8rem;
}

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.content-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.content-card h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.manifestacao-item, .solicitacao-item {
    padding: 1rem;
    border-left: 4px solid #3498db;
    background: #f8f9fa;
    margin-bottom: 1rem;
    border-radius: 0 8px 8px 0;
    transition: all 0.3s ease;
}

.manifestacao-item:hover, .solicitacao-item:hover {
    background: #e3f2fd;
    transform: translateX(5px);
}

.item-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.item-protocolo {
    font-weight: bold;
    color: #2c3e50;
}

.item-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.status-pendente {
    background: #fff3cd;
    color: #856404;
}

.status-em_andamento {
    background: #d1ecf1;
    color: #0c5460;
}

.item-assunto {
    color: #495057;
    margin-bottom: 0.5rem;
}

.item-prazo {
    font-size: 0.9rem;
    color: #6c757d;
}

.alert-item {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-warning {
    background: #fff3cd;
    border-left: 4px solid #ffc107;
}

.alert-danger {
    background: #f8d7da;
    border-left: 4px solid #dc3545;
}

.alert-icon {
    font-size: 1.5rem;
}

.alert-warning .alert-icon {
    color: #ffc107;
}

.alert-danger .alert-icon {
    color: #dc3545;
}

.chart-container {
    height: 300px;
    margin-top: 1rem;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 2rem;
}

.action-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem;
    border-radius: 10px;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.action-btn i {
    font-size: 2rem;
}

@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="ouvidor-dashboard">
    <div class="container-fluid py-4">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-2">Bem-vindo, {{ Auth::user()->name }}!</h1>
                    <p class="mb-0">Painel do Ouvidor - Gerencie manifestações e solicitações</p>
                </div>
                <div class="col-md-3">
                    <div class="mb-2">
                        <label for="periodFilter" class="form-label text-white-50 small">Filtrar por período:</label>
                        <select id="periodFilter" class="form-select form-select-sm">
                            <option value="all">Todos os períodos</option>
                            <option value="today">Hoje</option>
                            <option value="7days">Últimos 7 dias</option>
                            <option value="30days" selected>Últimos 30 dias</option>
                            <option value="month">Este mês</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <div class="text-white-50">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ now()->format('d/m/Y - H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas Principais -->
        <div class="stats-grid">
            <!-- Manifestações -->
            <div class="stat-card manifestacoes">
                <div class="stat-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-number" id="manifestacoesTotal">{{ $stats['manifestacoes']['total'] }}</div>
                <div class="stat-label">Manifestações Atribuídas</div>
                <div class="stat-details">
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="manifestacoesPendentes">{{ $stats['manifestacoes']['pendentes'] }}</div>
                        <div class="stat-detail-label">Pendentes</div>
                    </div>
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="manifestacoesEmAndamento">{{ $stats['manifestacoes']['em_andamento'] }}</div>
                        <div class="stat-detail-label">Em Andamento</div>
                    </div>
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="manifestacoesRespondidas">{{ $stats['manifestacoes']['respondidas'] }}</div>
                        <div class="stat-detail-label">Respondidas</div>
                    </div>
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="manifestacoesEncerradas">{{ $stats['manifestacoes']['finalizadas'] ?? 0 }}</div>
                        <div class="stat-detail-label">Encerradas</div>
                    </div>
                </div>
            </div>

            @if(isset($stats['esic']))
            <!-- E-SIC -->
            <div class="stat-card esic">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-number" id="esicTotal">{{ $stats['esic']['total'] }}</div>
                <div class="stat-label">Solicitações E-SIC</div>
                <div class="stat-details">
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="esicPendentes">{{ $stats['esic']['pendentes'] }}</div>
                        <div class="stat-detail-label">Pendentes</div>
                    </div>
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="esicEmAndamento">{{ $stats['esic']['em_andamento'] }}</div>
                        <div class="stat-detail-label">Em Andamento</div>
                    </div>
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="esicRespondidas">{{ $stats['esic']['respondidas'] }}</div>
                        <div class="stat-detail-label">Respondidas</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Performance -->
            <div class="stat-card performance">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number" id="respondidasMes">{{ $stats['performance']['respondidas_mes'] }}</div>
                <div class="stat-label">Respondidas este Mês</div>
                <div class="stat-details">
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="tempoMedioResposta">{{ $stats['performance']['tempo_medio_resposta'] }}</div>
                        <div class="stat-detail-label">Dias Médios</div>
                    </div>
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="prazoVencido">{{ $stats['performance']['prazo_vencido'] }}</div>
                        <div class="stat-detail-label">Vencidas</div>
                    </div>
                </div>
            </div>

            <!-- Alertas -->
            <div class="stat-card alertas">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-number" id="alertasTotal">{{ $alertasPrazo->count() }}</div>
                <div class="stat-label">Alertas de Prazo</div>
                <div class="stat-details">
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="alertasVencidas">{{ $stats['performance']['prazo_vencido'] }}</div>
                        <div class="stat-detail-label">Vencidas</div>
                    </div>
                    <div class="stat-detail">
                        <div class="stat-detail-number" id="alertasVencendo">{{ $stats['performance']['proximo_vencimento'] }}</div>
                        <div class="stat-detail-label">Vencendo</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="content-grid">
            <!-- Manifestações Recentes -->
            <div class="content-card">
                <h3>
                    <i class="fas fa-comments text-primary"></i>
                    Manifestações Recentes
                </h3>
                
                @forelse($manifestacoesRecentes as $manifestacao)
                <div class="manifestacao-item">
                    <div class="item-header">
                        <span class="item-protocolo">Protocolo #{{ $manifestacao->protocolo }}</span>
                        <span class="item-status status-{{ $manifestacao->status }}">
                            {{ ucfirst(str_replace('_', ' ', $manifestacao->status)) }}
                        </span>
                    </div>
                    <div class="item-assunto">{{ Str::limit($manifestacao->assunto, 60) }}</div>
                    <div class="item-prazo">
                        <i class="fas fa-clock me-1"></i>
                        Prazo: {{ Carbon\Carbon::parse($manifestacao->prazo_resposta)->format('d/m/Y') }}
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Nenhuma manifestação pendente</p>
                </div>
                @endforelse

                @if($manifestacoesRecentes->count() > 0)
                <div class="text-center mt-3">
                    <a href="{{ route('ouvidor.manifestacoes.index') }}" class="btn btn-outline-primary">
                        Ver Todas as Manifestações
                    </a>
                </div>
                @endif
            </div>

            <!-- Sidebar com Alertas e E-SIC -->
            <div>
                <!-- Alertas de Prazo -->
                @if($alertasPrazo->count() > 0)
                <div class="content-card mb-3">
                    <h3>
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Alertas de Prazo
                    </h3>
                    
                    @foreach($alertasPrazo->take(5) as $alerta)
                    <div class="alert-item alert-{{ $alerta['urgencia'] }}">
                        <div class="alert-icon">
                            <i class="fas fa-{{ $alerta['urgencia'] === 'danger' ? 'exclamation-circle' : 'clock' }}"></i>
                        </div>
                        <div>
                            <strong>{{ $alerta['titulo'] }}</strong><br>
                            <small>{{ $alerta['descricao'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Solicitações E-SIC -->
                @if(Auth::user()->canResponderEsic() && $solicitacoesEsic->count() > 0)
                <div class="content-card">
                    <h3>
                        <i class="fas fa-file-alt text-danger"></i>
                        Solicitações E-SIC
                    </h3>
                    
                    @foreach($solicitacoesEsic->take(5) as $solicitacao)
                    <div class="solicitacao-item">
                        <div class="item-header">
                            <span class="item-protocolo">Protocolo #{{ $solicitacao->protocolo }}</span>
                            <span class="item-status status-{{ $solicitacao->status }}">
                                {{ ucfirst(str_replace('_', ' ', $solicitacao->status)) }}
                            </span>
                        </div>
                        <div class="item-assunto">{{ Str::limit($solicitacao->assunto, 60) }}</div>
                        <div class="item-prazo">
                            <i class="fas fa-clock me-1"></i>
                            Prazo: {{ Carbon\Carbon::parse($solicitacao->prazo_resposta)->format('d/m/Y') }}
                        </div>
                    </div>
                    @endforeach

                    <div class="text-center mt-3">
                        <a href="{{ route('ouvidor.esic.index') }}" class="btn btn-outline-danger btn-sm">
                            Ver Todas as Solicitações
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Gráfico de Performance -->
        <div class="content-card">
            <h3>
                <i class="fas fa-chart-area text-success"></i>
                Performance dos Últimos 6 Meses
            </h3>
            <div class="chart-container">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="quick-actions">
            <a href="{{ route('ouvidor.manifestacoes.index') }}" class="action-btn">
                <i class="fas fa-comments"></i>
                <span>Manifestações</span>
            </a>
            
            @if(Auth::user()->canResponderEsic())
            <a href="{{ route('ouvidor.esic.index') }}" class="action-btn">
                <i class="fas fa-file-alt"></i>
                <span>Solicitações E-SIC</span>
            </a>
            @endif
            
            @if(Auth::user()->canVisualizarRelatorios())
            <a href="{{ route('ouvidor.relatorios.index') }}" class="action-btn">
                <i class="fas fa-chart-bar"></i>
                <span>Relatórios</span>
            </a>
            @endif
            
            <a href="{{ route('ouvidor.perfil.edit') }}" class="action-btn">
                <i class="fas fa-user-cog"></i>
                <span>Meu Perfil</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush