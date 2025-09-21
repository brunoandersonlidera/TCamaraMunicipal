<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Câmara Municipal')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app-layout.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Additional CSS -->
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-landmark me-2"></i>
                Câmara Municipal
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @php
                        $menusHeader = \App\Models\Menu::header()->ativos()->ordenados()->get();
                    @endphp
                    
                    @foreach($menusHeader as $menu)
                        @if($menu->podeExibir())
                            <x-menu-item :menu="$menu" />
                        @endif
                    @endforeach
                </ul>
                    
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Minha Área
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="fas fa-user-edit me-2"></i>Meu Perfil
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('user.notifications') }}">
                                <i class="fas fa-bell me-2"></i>Notificações
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Entrar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>
                            Cadastrar
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>
                        <i class="fas fa-landmark me-2"></i>
                        Câmara Municipal
                    </h5>
                    <p class="mb-3">
                        Trabalhando pela transparência, representatividade e desenvolvimento do nosso município.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                @php
                    $menusFooter = \App\Models\Menu::footer()->ativos()->ordenados()->get();
                    $menusGrouped = $menusFooter->groupBy('grupo_footer');
                @endphp
                
                @foreach($menusGrouped as $grupo => $menus)
                    @if($grupo && $menus->count() > 0)
                        <x-footer-menu :titulo="$grupo" :menus="$menus" />
                    @endif
                @endforeach
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contato</h5>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Endereço da Câmara Municipal
                        </li>
                        <li>
                            <i class="fas fa-phone me-2"></i>
                            (XX) XXXX-XXXX
                        </li>
                        <li>
                            <i class="fas fa-envelope me-2"></i>
                            contato@camara.gov.br
                        </li>
                        <li>
                            <i class="fas fa-clock me-2"></i>
                            Seg-Sex: 8h às 17h
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Câmara Municipal. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/app-layout.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    
    @stack('scripts')
</body>
</html>