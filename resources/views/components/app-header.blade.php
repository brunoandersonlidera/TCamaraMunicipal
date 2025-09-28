@php
    $menusHeader = \App\Models\Menu::getMenusHeader();
    $brasao = \App\Models\ConfiguracaoGeral::obterBrasao();
    $nomeCamara = \App\Models\ConfiguracaoGeral::obterValor('nome_camara', 'Câmara Municipal');
@endphp

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if($brasao)
                <img src="{{ $brasao }}" alt="Brasão" class="brasao-header me-2">
            @else
                <i class="fas fa-landmark me-2"></i>
            @endif
            {{ $nomeCamara }}
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @foreach($menusHeader as $menu)
                    @if($menu->podeExibir())
                        <x-menu-item :menu="$menu" />
                    @endif
                @endforeach
            </ul>
            
            <ul class="navbar-nav">
                @auth
                    <!-- Usuário logado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Painel Admin
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('esic.dashboard') }}">
                                <i class="fas fa-file-alt me-2"></i>Meus Pedidos e-SIC
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">
                                 <i class="fas fa-user-edit me-2"></i>Meu Perfil
                             </a></li>
                             <li><hr class="dropdown-divider"></li>
                             <li>
                                 <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                     @csrf
                                     <button type="submit" class="dropdown-item">
                                         <i class="fas fa-sign-out-alt me-2"></i>Sair
                                     </button>
                                 </form>
                             </li>
                         </ul>
                     </li>
                 @else
                     <!-- Usuário não logado -->
                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" id="guestDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="fas fa-user me-1"></i>
                             Área do Cidadão
                         </a>
                         <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                             <li><a class="dropdown-item" href="{{ route('login') }}">
                                 <i class="fas fa-sign-in-alt me-2"></i>Entrar
                             </a></li>
                             <li><a class="dropdown-item" href="{{ route('register') }}">
                                 <i class="fas fa-user-plus me-2"></i>Cadastrar-se
                             </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('esic.create') }}">
                                <i class="fas fa-file-alt me-2"></i>Solicitar Informação
                            </a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>