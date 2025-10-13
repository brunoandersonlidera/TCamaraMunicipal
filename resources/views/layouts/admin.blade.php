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
    
    <!-- CSS Direto -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tipos-sessao.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leis-formatacao.css') }}">
    
    <!-- JavaScript Direto -->
    <script src="{{ asset('js/admin-layout.js') }}" defer></script>
    
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
                    <a href="{{ route('admin.comites-iniciativa-popular.index') }}" class="nav-link {{ request()->routeIs('admin.comites-iniciativa-popular.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        Comitês de Iniciativa Popular
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.leis.index') }}" class="nav-link {{ request()->routeIs('admin.leis.*') ? 'active' : '' }}">
                        <i class="fas fa-balance-scale"></i>
                        Leis
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.documentos.index') }}" class="nav-link {{ request()->routeIs('admin.documentos.*') ? 'active' : '' }}">
                        <i class="fas fa-folder-open"></i>
                        Documentos
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.eventos.index') }}" class="nav-link {{ request()->routeIs('admin.eventos.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        Eventos/Agenda
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.paginas-conteudo.index') }}" class="nav-link {{ request()->routeIs('admin.paginas-conteudo.*') ? 'active' : '' }}">
                        <i class="fas fa-file-text"></i>
                        Páginas Institucionais
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                        <i class="fas fa-photo-video"></i>
                        Biblioteca de Mídia
                    </a>
                </div>
            </div>
            
            <!-- Tramitação -->
            <div class="nav-section">
                <div class="nav-section-title">Tramitação</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.tramitacao.index') }}" class="nav-link {{ request()->routeIs('admin.tramitacao.*') ? 'active' : '' }}">
                        <i class="fas fa-route"></i>
                        Tramitação de Projetos
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.protocolos.index') }}" class="nav-link {{ request()->routeIs('admin.protocolos.*') ? 'active' : '' }}">
                        <i class="fas fa-file-signature"></i>
                        Protocolos
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
                
                <div class="nav-item">
                    <a href="{{ route('admin.licitacoes.index') }}" class="nav-link {{ request()->routeIs('admin.licitacoes.*') ? 'active' : '' }}">
                        <i class="fas fa-gavel"></i>
                        Licitações
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.tipos-contrato.index') }}" class="nav-link {{ request()->routeIs('admin.tipos-contrato.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        Tipos de Contrato
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.contratos.index') }}" class="nav-link {{ request()->routeIs('admin.contratos.*') ? 'active' : '' }}">
                        <i class="fas fa-handshake"></i>
                        Contratos
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
                
                <div class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        Roles
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                        <i class="fas fa-key"></i>
                        Permissões
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                        <i class="fas fa-bars"></i>
                        Menus
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.configuracao-geral.index') }}" class="nav-link {{ request()->routeIs('admin.configuracao-geral.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i>
                        Configurações Gerais
                    </a>
                </div>
            </div>
            
            <!-- Site -->
            <div class="nav-section">
                <div class="nav-section-title">Site</div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.slides.index') }}" class="nav-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        Slides Hero
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.hero-config.index') }}" class="nav-link {{ request()->routeIs('admin.hero-config.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        Config. Hero
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.acesso-rapido.index') }}" class="nav-link {{ request()->routeIs('admin.acesso-rapido.*') ? 'active' : '' }}">
                        <i class="fas fa-bolt"></i>
                        Acesso Rápido
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.temas.index') }}" class="nav-link {{ request()->routeIs('admin.temas.*') ? 'active' : '' }}">
                        <i class="fas fa-palette"></i>
                        Temas do Site
                    </a>
                </div>
                
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
        <!-- Impersonation Banner -->
        @if(session('impersonate_admin_id'))
            <div class="alert alert-warning alert-dismissible fade show mb-0 rounded-0 border-0" role="alert" style="background: linear-gradient(45deg, #ff9800, #ffc107); color: #000;">
                <div class="container-fluid d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-secret me-2"></i>
                        <strong>Modo Impersonificação Ativo:</strong>
                        <span class="ms-2">Você está logado como <strong>{{ auth()->user()->name }}</strong></span>
                    </div>
                    <div>
                        <a href="{{ route('admin.users.stop-impersonate') }}" class="btn btn-dark btn-sm me-2">
                            <i class="fas fa-undo me-1"></i>
                            Voltar ao Admin Original
                        </a>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Header -->
        <header class="admin-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-link mobile-menu-btn me-3" data-action="toggle-sidebar">
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
                        @if(session('impersonate_admin_id'))
                            <i class="fas fa-user-secret me-2 text-warning"></i>
                        @else
                            <i class="fas fa-user-circle me-2"></i>
                        @endif
                        {{ auth()->user()->name }}
                        @if(session('impersonate_admin_id'))
                            <span class="badge bg-warning text-dark ms-1">Impersonificação</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if(session('impersonate_admin_id'))
                            <li>
                                <a class="dropdown-item text-warning" href="{{ route('admin.users.stop-impersonate') }}">
                                    <i class="fas fa-undo me-2"></i>
                                    Voltar ao Admin Original
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
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
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS (não processados pelo Vite) -->
    <script src="{{ asset('js/tipos-sessao.js') }}"></script>
    <script src="{{ asset('js/admin-events.js') }}"></script>
    <script src="{{ asset('js/admin-layout.js') }}"></script>
    <script src="{{ asset('js/admin-actions.js') }}"></script>
    
    @stack('scripts')
</body>
</html>