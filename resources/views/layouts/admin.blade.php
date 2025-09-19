<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel Administrativo') - Câmara Municipal</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --header-height: 70px;
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --text-muted: #64748b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #334155;
        }
        
        .sidebar-brand {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            margin-bottom: 2rem;
        }
        
        .nav-section-title {
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .nav-item {
            margin-bottom: 0.25rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
        }
        
        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1rem;
        }
        
        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .admin-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 2rem;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .admin-content {
            padding: 2rem;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
        }
        
        .mobile-menu-btn {
            display: none;
        }
        
        /* Cards */
        .admin-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Tables */
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table th {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 0.5rem;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: var(--text-muted);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-landmark me-2"></i>
                Câmara Municipal
            </a>
        </div>
        
        <div class="sidebar-nav">
            <!-- Dashboard -->
            <div class="nav-section">
                <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>
            </div>
            
            <!-- Gestão de Conteúdo -->
            <div class="nav-section">
                <div class="nav-section-title">Gestão de Conteúdo</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.vereadores.index') }}" class="nav-link {{ request()->routeIs('admin.vereadores.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        Vereadores
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.noticias.index') }}" class="nav-link {{ request()->routeIs('admin.noticias.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i>
                        Notícias
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.sessoes.index') }}" class="nav-link {{ request()->routeIs('admin.sessoes.*') ? 'active' : '' }}">
                        <i class="fas fa-gavel"></i>
                        Sessões
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.projetos.index') }}" class="nav-link {{ request()->routeIs('admin.projetos.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        Projetos de Lei
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.documentos.index') }}" class="nav-link {{ request()->routeIs('admin.documentos.*') ? 'active' : '' }}">
                        <i class="fas fa-folder-open"></i>
                        Documentos
                    </a>
                </div>
            </div>
            
            <!-- Transparência -->
            <div class="nav-section">
                <div class="nav-section-title">Transparência</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.esic.index') }}" class="nav-link {{ request()->routeIs('admin.esic.*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle"></i>
                        Solicitações e-SIC
                    </a>
                </div>
            </div>
            
            <!-- Administração -->
            <div class="nav-section">
                <div class="nav-section-title">Administração</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i>
                        Usuários
                    </a>
                </div>
            </div>
            
            <!-- Site -->
            <div class="nav-section">
                <div class="nav-section-title">Site</div>
                
                <div class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        Ver Site
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-link mobile-menu-btn me-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div>
                    <h1 class="h4 mb-0">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('breadcrumb')
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 mt-1">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    @endif
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-home me-2"></i>
                                Ver Site
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <div class="admin-content">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Erro de validação:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            sidebar.classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('adminSidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuBtn.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>