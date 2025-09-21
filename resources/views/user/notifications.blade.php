@extends('layouts.app')

@section('title', 'Minhas Notificações')

@push('styles')
<style>
    .notifications-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .notifications-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .notifications-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .notifications-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .header-title {
        display: flex;
        align-items: center;
        margin: 0;
    }
    
    .header-title i {
        margin-right: 1rem;
        font-size: 1.5rem;
    }
    
    .notifications-stats {
        text-align: right;
    }
    
    .notifications-body {
        padding: 2rem;
    }
    
    .notifications-filters {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 25px;
        color: #666;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }
    
    .filter-btn.active,
    .filter-btn:hover {
        border-color: #667eea;
        background: #667eea;
        color: white;
        text-decoration: none;
    }
    
    .notification-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .notification-item.unread {
        background: #fff;
        border-left-color: #667eea;
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.1);
    }
    
    .notification-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .notification-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .notification-type {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #333;
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.1rem;
    }
    
    .notification-icon.esic { background: linear-gradient(45deg, #4CAF50, #45a049); }
    .notification-icon.ouvidoria { background: linear-gradient(45deg, #2196F3, #1976D2); }
    .notification-icon.sistema { background: linear-gradient(45deg, #FF9800, #F57C00); }
    .notification-icon.geral { background: linear-gradient(45deg, #9C27B0, #7B1FA2); }
    
    .notification-date {
        color: #666;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
    }
    
    .notification-date i {
        margin-right: 0.5rem;
    }
    
    .notification-content {
        color: #333;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    .notification-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .notification-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .notification-btn {
        padding: 0.4rem 1rem;
        border: 1px solid #667eea;
        background: white;
        color: #667eea;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .notification-btn:hover {
        background: #667eea;
        color: white;
        text-decoration: none;
    }
    
    .notification-btn.primary {
        background: #667eea;
        color: white;
    }
    
    .notification-btn.primary:hover {
        background: #5a6fd8;
    }
    
    .unread-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        font-size: 0;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }
    
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="notifications-page">
    <div class="notifications-container">
        <div class="notifications-card">
            <!-- Header -->
            <div class="notifications-header">
                <h1 class="header-title">
                    <i class="fas fa-bell"></i>
                    Minhas Notificações
                </h1>
                <div class="notifications-stats">
                    <div><strong>{{ $totalNotifications ?? 0 }}</strong> Total</div>
                    <div><strong>{{ $unreadNotifications ?? 0 }}</strong> Não lidas</div>
                </div>
            </div>

            <!-- Body -->
            <div class="notifications-body">
                <!-- Filters -->
                <div class="notifications-filters">
                    <a href="{{ route('user.notifications') }}" 
                       class="filter-btn {{ request('type') ? '' : 'active' }}">
                        Todas
                    </a>
                    <a href="{{ route('user.notifications', ['type' => 'esic']) }}" 
                       class="filter-btn {{ request('type') == 'esic' ? 'active' : '' }}">
                        e-SIC
                    </a>
                    <a href="{{ route('user.notifications', ['type' => 'ouvidoria']) }}" 
                       class="filter-btn {{ request('type') == 'ouvidoria' ? 'active' : '' }}">
                        Ouvidoria
                    </a>
                    <a href="{{ route('user.notifications', ['type' => 'sistema']) }}" 
                       class="filter-btn {{ request('type') == 'sistema' ? 'active' : '' }}">
                        Sistema
                    </a>
                    <a href="{{ route('user.notifications', ['status' => 'unread']) }}" 
                       class="filter-btn {{ request('status') == 'unread' ? 'active' : '' }}">
                        Não lidas
                    </a>
                </div>

                <!-- Actions -->
                @if(isset($notifications) && count($notifications) > 0)
                <div class="mb-3">
                    <form action="{{ route('user.notifications.mark-all-read') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-check-double me-1"></i>
                            Marcar todas como lidas
                        </button>
                    </form>
                </div>
                @endif

                <!-- Notifications List -->
                @if(isset($notifications) && count($notifications) > 0)
                    @foreach($notifications as $notification)
                    <div class="notification-item {{ $notification['read_at'] ? '' : 'unread' }}">
                        @if(!$notification['read_at'])
                            <div class="unread-badge"></div>
                        @endif
                        
                        <div class="notification-header">
                            <div class="notification-type">
                                <div class="notification-icon {{ $notification['type'] }}">
                                    <i class="fas fa-{{ $notification['icon'] }}"></i>
                                </div>
                                {{ $notification['type_label'] }}
                            </div>
                            <div class="notification-date">
                                <i class="fas fa-clock"></i>
                                {{ $notification['created_at'] }}
                            </div>
                        </div>
                        
                        <div class="notification-content">
                            <div class="notification-title">{{ $notification['title'] }}</div>
                            <div>{{ $notification['message'] }}</div>
                        </div>
                        
                        @if(isset($notification['actions']) && count($notification['actions']) > 0)
                        <div class="notification-actions">
                            @foreach($notification['actions'] as $action)
                            <a href="{{ $action['url'] }}" 
                               class="notification-btn {{ $action['primary'] ? 'primary' : '' }}">
                                {{ $action['label'] }}
                            </a>
                            @endforeach
                            
                            @if(!$notification['read_at'])
                            <form action="{{ route('user.notifications.mark-read', $notification['id']) }}" 
                                  method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="notification-btn">
                                    Marcar como lida
                                </button>
                            </form>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                    
                    <!-- Pagination -->
                    @if(isset($notifications) && method_exists($notifications, 'links'))
                    <div class="pagination-wrapper">
                        {{ $notifications->links() }}
                    </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="fas fa-bell-slash"></i>
                        <h3>Nenhuma notificação encontrada</h3>
                        <p>Você não possui notificações {{ request('status') == 'unread' ? 'não lidas' : '' }} no momento.</p>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-arrow-left me-1"></i>
                            Voltar ao Dashboard
                        </a>
                    </div>
                @endif

                <!-- Back Button -->
                @if(isset($notifications) && count($notifications) > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Voltar ao Dashboard
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection