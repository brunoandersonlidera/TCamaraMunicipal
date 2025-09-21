@extends('layouts.app')

@section('title', 'Minha Área')

@push('styles')
<style>
    .user-dashboard {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .welcome-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    
    .stat-icon.esic { background: linear-gradient(45deg, #4CAF50, #45a049); }
    .stat-icon.ouvidoria { background: linear-gradient(45deg, #2196F3, #1976D2); }
    .stat-icon.carta { background: linear-gradient(45deg, #FF9800, #F57C00); }
    .stat-icon.notificacoes { background: linear-gradient(45deg, #9C27B0, #7B1FA2); }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #666;
        font-size: 0.9rem;
    }
    
    .quick-actions {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .action-btn {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background: #e9ecef;
        border-color: #667eea;
        color: #667eea;
        text-decoration: none;
    }
    
    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #667eea;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    
    .recent-activity {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: #667eea;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .activity-date {
        font-size: 0.85rem;
        color: #666;
    }
</style>
@endpush

@section('content')
<div class="user-dashboard">
    <div class="dashboard-container">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2">Olá, {{ auth()->user()->name }}!</h1>
                    <p class="text-muted mb-0">Bem-vindo à sua área pessoal. Aqui você pode acompanhar suas solicitações e gerenciar seu perfil.</p>
                </div>
                <div class="col-md-4 text-end">
                    <p class="mb-1"><strong>Último acesso:</strong></p>
                    <p class="text-muted">{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d/m/Y H:i') : 'Primeiro acesso' }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon esic">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-number">{{ $stats['esic'] ?? 0 }}</div>
                <div class="stat-label">Solicitações e-SIC</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon ouvidoria">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-number">{{ $stats['ouvidoria'] ?? 0 }}</div>
                <div class="stat-label">Manifestações Ouvidoria</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon carta">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">{{ $stats['avaliacoes'] ?? 0 }}</div>
                <div class="stat-label">Avaliações de Serviços</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon notificacoes">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="stat-number">{{ $stats['notificacoes'] ?? 0 }}</div>
                <div class="stat-label">Notificações</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3 class="mb-0">Ações Rápidas</h3>
            <div class="actions-grid">
                <a href="{{ route('user.profile') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>Meu Perfil</strong><br>
                        <small>Editar informações pessoais</small>
                    </div>
                </a>
                
                <a href="{{ route('esic.create') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <strong>Nova Solicitação e-SIC</strong><br>
                        <small>Solicitar informações</small>
                    </div>
                </a>
                
                <a href="{{ route('ouvidoria.create') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-comment-alt"></i>
                    </div>
                    <div>
                        <strong>Nova Manifestação</strong><br>
                        <small>Elogios, críticas ou sugestões</small>
                    </div>
                </a>
                
                <a href="{{ route('user.notifications') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div>
                        <strong>Notificações</strong><br>
                        <small>Ver todas as notificações</small>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        @if(isset($recentActivities) && count($recentActivities) > 0)
        <div class="recent-activity">
            <h3 class="mb-3">Atividades Recentes</h3>
            @foreach($recentActivities as $activity)
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-{{ $activity['icon'] }}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">{{ $activity['title'] }}</div>
                    <div class="activity-date">{{ $activity['date'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection