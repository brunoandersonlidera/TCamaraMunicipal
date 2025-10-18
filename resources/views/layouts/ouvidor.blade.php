<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ouvidor') - {{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/ouvidor.css') }}">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #3498db;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-ouvidor {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
            border-radius: 5px;
            margin: 0 5px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .dropdown-item {
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .sidebar {
            background: white;
            min-height: calc(100vh - 76px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(102, 126, 234, 0.1);
            border-left-color: var(--primary-color);
            color: var(--primary-color);
        }

        .sidebar-menu i {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
        }

        .main-content {
            padding: 0;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .page-title {
            color: var(--dark-color);
            margin: 0;
            font-weight: 600;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0.5rem 0 0 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 76px;
                left: -250px;
                width: 250px;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-ouvidor">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('ouvidor.dashboard') }}">
                <i class="fas fa-headset me-2"></i>
                Painel do Ouvidor
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ouvidor.dashboard') ? 'active' : '' }}" 
                           href="{{ route('ouvidor.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ouvidor.manifestacoes.*') ? 'active' : '' }}" 
                           href="{{ route('ouvidor.manifestacoes.index') }}">
                            <i class="fas fa-comments me-1"></i>
                            Manifestações
                            @if(isset($notificacoes['manifestacoes']) && $notificacoes['manifestacoes'] > 0)
                                <span class="notification-badge">{{ $notificacoes['manifestacoes'] }}</span>
                            @endif
                        </a>
                    </li>
                    @if(Auth::user()->canResponderEsic())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ouvidor.esic.*') ? 'active' : '' }}" 
                           href="{{ route('ouvidor.esic.index') }}">
                            <i class="fas fa-file-alt me-1"></i>
                            E-SIC
                            @if(isset($notificacoes['esic']) && $notificacoes['esic'] > 0)
                                <span class="notification-badge">{{ $notificacoes['esic'] }}</span>
                            @endif
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->canVisualizarRelatorios())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ouvidor.relatorios.*') ? 'active' : '' }}" 
                           href="{{ route('ouvidor.relatorios.index') }}">
                            <i class="fas fa-chart-bar me-1"></i>
                            Relatórios
                        </a>
                    </li>
                    @endif
                </ul>

                <ul class="navbar-nav">
                    <!-- Toggle Dark/Light Mode -->
                    <li class="nav-item">
                        <button class="nav-link btn btn-link border-0 p-2" id="themeToggle" title="Alternar tema">
                            <i class="fas fa-sun" id="themeIcon"></i>
                        </button>
                    </li>
                    
                    <!-- Notificações -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationsDropdown" 
                           role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            @if(isset($totalNotificacoes) && $totalNotificacoes > 0)
                                <span class="notification-badge">{{ $totalNotificacoes }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                            <li><h6 class="dropdown-header">Notificações</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            @if(isset($notificacoesRecentes) && $notificacoesRecentes->count() > 0)
                                @foreach($notificacoesRecentes->take(5) as $notificacao)
                                <li>
                                    <a class="dropdown-item" href="{{ $notificacao->link ?? '#' }}">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-{{ $notificacao->icon ?? 'info-circle' }} text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <div class="fw-bold">{{ $notificacao->titulo }}</div>
                                                <small class="text-muted">{{ $notificacao->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="{{ route('ouvidor.notificacoes.index') }}">Ver todas</a></li>
                            @else
                                <li><span class="dropdown-item text-muted">Nenhuma notificação</span></li>
                            @endif
                        </ul>
                    </li>

                    <!-- Usuário -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                           id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                            <li><small class="dropdown-item-text text-muted">{{ Auth::user()->email }}</small></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ouvidor.perfil.edit') }}">
                                    <i class="fas fa-user-cog me-2"></i>
                                    Meu Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ouvidor.configuracoes') }}">
                                    <i class="fas fa-cog me-2"></i>
                                    Configurações
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(Auth::user()->canAccessAdmin())
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Painel Admin
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar (opcional, pode ser removida se não necessária) -->
            @if(isset($showSidebar) && $showSidebar)
            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ route('ouvidor.dashboard') }}" 
                               class="{{ request()->routeIs('ouvidor.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ouvidor.manifestacoes.index') }}" 
                               class="{{ request()->routeIs('ouvidor.manifestacoes.*') ? 'active' : '' }}">
                                <i class="fas fa-comments"></i>
                                Manifestações
                            </a>
                        </li>
                        @if(Auth::user()->canResponderEsic())
                        <li>
                            <a href="{{ route('ouvidor.esic.index') }}" 
                               class="{{ request()->routeIs('ouvidor.esic.*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt"></i>
                                E-SIC
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->canVisualizarRelatorios())
                        <li>
                            <a href="{{ route('ouvidor.relatorios.index') }}" 
                               class="{{ request()->routeIs('ouvidor.relatorios.*') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar"></i>
                                Relatórios
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            @endif

            <!-- Content Area -->
            <div class="col-md-{{ isset($showSidebar) && $showSidebar ? '9' : '12' }} col-lg-{{ isset($showSidebar) && $showSidebar ? '10' : '12' }}">
                <div class="main-content">
                    @if(isset($showPageHeader) && $showPageHeader)
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                            @if(isset($breadcrumbs))
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @foreach($breadcrumbs as $breadcrumb)
                                        @if($loop->last)
                                            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </nav>
                            @endif
                        </div>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Ouvidor JS -->
    <script src="{{ asset('js/ouvidor.js') }}"></script>
    
    @stack('scripts')

    <script>
        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
        }

        // CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>