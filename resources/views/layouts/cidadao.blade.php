<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Área do Cidadão - Câmara Municipal')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta-description', 'Área do Cidadão - Câmara Municipal. Acesse sua conta, crie comitês de iniciativa popular e assine projetos de lei.')">
    <meta name="keywords" content="@yield('meta-keywords', 'área do cidadão, comitês, iniciativa popular, projetos de lei, assinatura eletrônica')">
    <meta name="author" content="Câmara Municipal">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS Customizado -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/public-styles.css') }}" rel="stylesheet">
    
    <!-- Additional CSS -->
    @stack('styles')
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }
        
        .cidadao-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .cidadao-navbar .navbar-brand {
            color: white !important;
            font-weight: 600;
        }
        
        .cidadao-navbar .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .cidadao-navbar .nav-link:hover {
            color: white !important;
        }
        
        .cidadao-navbar .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .alert {
            border: none;
            border-radius: 10px;
        }
        
        .footer-cidadao {
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg cidadao-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('cidadao.dashboard') }}">
                <i class="fas fa-user-circle me-2"></i>
                Área do Cidadão
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cidadao.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cidadao.comites.create') }}">
                            <i class="fas fa-plus-circle me-1"></i>
                            Criar Comitê
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>
                            Portal Principal
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">
                                {{ substr(auth('cidadao')->user()->nome, 0, 1) }}
                            </div>
                            {{ auth('cidadao')->user()->nome }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="fas fa-user me-1"></i>
                                    Minha Conta
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('cidadao.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <span class="dropdown-item-text">
                                    <small class="text-muted">CPF: {{ auth('cidadao')->user()->cpf }}</small>
                                </span>
                            </li>
                            <li>
                                <span class="dropdown-item-text">
                                    <small class="text-muted">
                                        Status: 
                                        @if(auth('cidadao')->user()->status_verificacao === 'verificado')
                                            <span class="badge bg-success">Verificado</span>
                                        @else
                                            <span class="badge bg-warning">Pendente</span>
                                        @endif
                                    </small>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('cidadao.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-1"></i>
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
    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-cidadao">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-shield-alt me-2"></i>Área Segura do Cidadão</h6>
                    <p class="mb-0">
                        <small>
                            Seus dados são protegidos conforme a LGPD. 
                            Esta é uma área restrita para cidadãos cadastrados.
                        </small>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <small>
                            <i class="fas fa-building me-1"></i>
                            Câmara Municipal
                        </small>
                    </p>
                    <p class="mb-0">
                        <small>
                            <i class="fas fa-clock me-1"></i>
                            Conectado em {{ now()->format('d/m/Y H:i') }}
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>