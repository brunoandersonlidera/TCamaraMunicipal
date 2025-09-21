@extends('layouts.admin')

@section('title', 'Dashboard - Administração')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="container-fluid">
        <div class="welcome-text">Bem-vindo ao Dashboard</div>
        <div class="welcome-subtitle">Visão geral do sistema da Câmara Municipal</div>
    </div>
</div>

<!-- Estatísticas Principais -->
<div class="stats-grid">
    <div class="stat-card esic">
        <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-number">{{ $stats['esic']['total'] ?? '127' }}</div>
        <div class="stat-label">Solicitações E-SIC</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +12% este mês
        </div>
    </div>
    
    <div class="stat-card ouvidoria">
        <div class="stat-icon">
            <i class="fas fa-comments"></i>
        </div>
        <div class="stat-number">{{ $stats['ouvidoria']['total'] ?? '89' }}</div>
        <div class="stat-label">Manifestações</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +8% este mês
        </div>
    </div>
    
    <div class="stat-card cartas">
        <div class="stat-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-number">{{ $stats['cartas']['total'] ?? '45' }}</div>
        <div class="stat-label">Cartas de Serviço</div>
        <div class="stat-change neutral">
            <i class="fas fa-minus"></i>
            Sem alteração
        </div>
    </div>
    
    <div class="stat-card usuarios">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-number">{{ $stats['usuarios']['total'] ?? '234' }}</div>
        <div class="stat-label">Usuários Ativos</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +15% este mês
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="charts-grid">
    <div class="chart-card">
        <h3 class="chart-title">
            <i class="fas fa-chart-line"></i>
            Solicitações por Mês
        </h3>
        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    
    <div class="chart-card">
        <h3 class="chart-title">
            <i class="fas fa-chart-pie"></i>
            Distribuição por Tipo
        </h3>
        <div class="chart-container">
            <canvas id="typeChart"></canvas>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="recent-activities">
    <h3 class="chart-title">
        <i class="fas fa-clock"></i>
        Atividades Recentes
    </h3>
    
    <div class="activity-item">
        <div class="activity-icon esic">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="activity-content">
            <div class="activity-title">Nova solicitação E-SIC recebida</div>
            <div class="activity-description">Protocolo #2024001234 - Solicitação de informações sobre licitações</div>
            <div class="activity-time">Há 15 minutos</div>
        </div>
    </div>
    
    <div class="activity-item">
        <div class="activity-icon ouvidoria">
            <i class="fas fa-comments"></i>
        </div>
        <div class="activity-content">
            <div class="activity-title">Manifestação respondida</div>
            <div class="activity-description">Protocolo #2024000987 - Reclamação sobre iluminação pública</div>
            <div class="activity-time">Há 1 hora</div>
        </div>
    </div>
    
    <div class="activity-item">
        <div class="activity-icon usuarios">
            <i class="fas fa-user-plus"></i>
        </div>
        <div class="activity-content">
            <div class="activity-title">Novo usuário cadastrado</div>
            <div class="activity-description">João Silva se cadastrou no sistema</div>
            <div class="activity-time">Há 2 horas</div>
        </div>
    </div>
    
    <div class="activity-item">
        <div class="activity-icon cartas">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="activity-content">
            <div class="activity-title">Carta de serviço atualizada</div>
            <div class="activity-description">Serviço "Certidão de Tempo de Serviço" foi modificado</div>
            <div class="activity-time">Há 3 horas</div>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="quick-actions">
    <a href="{{ route('admin.solicitacoes.index') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="action-title">Gerenciar E-SIC</div>
        <div class="action-description">Visualizar e responder solicitações</div>
    </a>
    
    <a href="{{ route('admin.ouvidoria-manifestacoes.index') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-comments"></i>
        </div>
        <div class="action-title">Gerenciar Ouvidoria</div>
        <div class="action-description">Acompanhar manifestações</div>
    </a>
    
    <a href="{{ route('admin.cartas-servico.index') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="action-title">Cartas de Serviço</div>
        <div class="action-description">Gerenciar serviços públicos</div>
    </a>
    
    <a href="{{ route('admin.esic-usuarios.index') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="action-title">Usuários</div>
        <div class="action-description">Administrar usuários do sistema</div>
    </a>
    
    <a href="{{ route('admin.relatorios.index') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="action-title">Relatórios</div>
        <div class="action-description">Gerar relatórios detalhados</div>
    </a>
    
    <a href="{{ route('admin.configuracoes.index') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-cog"></i>
        </div>
        <div class="action-title">Configurações</div>
        <div class="action-description">Ajustar configurações do sistema</div>
    </a>
</div>

<!-- Status do Sistema -->
<div class="system-status">
    <h3 class="chart-title">
        <i class="fas fa-server"></i>
        Status do Sistema
    </h3>
    
    <div class="status-item">
        <div class="status-label">Servidor Web</div>
        <div class="status-indicator online">
            <div class="status-dot online"></div>
            Online
        </div>
    </div>
    
    <div class="status-item">
        <div class="status-label">Banco de Dados</div>
        <div class="status-indicator online">
            <div class="status-dot online"></div>
            Online
        </div>
    </div>
    
    <div class="status-item">
        <div class="status-label">Sistema de E-mail</div>
        <div class="status-indicator warning">
            <div class="status-dot warning"></div>
            Lento
        </div>
    </div>
    
    <div class="status-item">
        <div class="status-label">Backup Automático</div>
        <div class="status-indicator online">
            <div class="status-dot online"></div>
            Funcionando
        </div>
    </div>
    
    <div class="status-item">
        <div class="status-label">Última Atualização</div>
        <div class="status-indicator online">
            <div class="status-dot online"></div>
            {{ date('d/m/Y H:i') }}
        </div>
    </div>
</div>

@push('scripts')
<!-- Scripts para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
@endsection