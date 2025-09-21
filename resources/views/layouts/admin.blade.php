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
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tipos-sessao.css') }}">
    
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
                    <a href="{{ route('admin.tipos-sessao.index') }}" class="nav-link {{ request()->routeIs('admin.tipos-sessao.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        Tipos de Sessão
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.projetos-lei.index') }}" class="nav-link {{ request()->routeIs('admin.projetos-lei.*') ? 'active' : '' }}">
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
                    <a href="{{ route('admin.solicitacoes.index') }}" class="nav-link {{ request()->routeIs('admin.solicitacoes.*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle"></i>
                        Solicitações e-SIC
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.esic-usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.esic-usuarios.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        Usuários E-SIC
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.cartas-servico.index') }}" class="nav-link {{ request()->routeIs('admin.cartas-servico.*') ? 'active' : '' }}">
                        <i class="fas fa-file-contract"></i>
                        Carta de Serviços
                    </a>
                </div>
            </div>
            
            <!-- Ouvidoria -->
            <div class="nav-section">
                <div class="nav-section-title">Ouvidoria</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.ouvidoria-manifestacoes.index') }}" class="nav-link {{ request()->routeIs('admin.ouvidoria-manifestacoes.*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i>
                        Manifestações
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.ouvidores.index') }}" class="nav-link {{ request()->routeIs('admin.ouvidores.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        Ouvidores
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
    
    <!-- Custom JS -->
    <script src="{{ asset('js/tipos-sessao.js') }}"></script>
    <script src="{{ asset('js/admin-events.js') }}"></script>
    <script src="{{ asset('js/admin-layout.js') }}"></script>
    
    @stack('scripts')
</body>
</html>