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
                {{ $nomeCamara }}
            @endif
        </a>
        <!-- Ribbon de campanha (ex.: Outubro Rosa). Visível em telas md+ -->
        @php
            $now = \Illuminate\Support\Carbon::now()->toDateString();
            $previewSlug = request()->query('theme_preview');
            if ($previewSlug) {
                $__theme = \App\Models\Theme::where('slug', $previewSlug)->first();
            } else {
                $__theme = \App\Models\Theme::query()
                    ->where(function ($q) use ($now) {
                        $q->where('is_active', true)
                          ->orWhere(function ($q2) use ($now) {
                              $q2->where('is_scheduled', true)
                                 ->whereDate('start_date', '<=', $now)
                                 ->whereDate('end_date', '>=', $now);
                          });
                    })
                    ->orderByDesc('updated_at')
                    ->first();
            }
            $showRibbon = optional($__theme)->ribbon_enabled ?? false;
            $showMourning = optional($__theme)->mourning_enabled ?? false;
        @endphp
        @php
            // Novos campos separados por lacinho (campanha vs luto)
            $campaignDefaultLabel = match(optional($__theme)->ribbon_variant) {
                'october_pink' => 'Outubro Rosa',
                'september_yellow' => 'Setembro Amarelo',
                'november_blue' => 'Novembro Azul',
                default => null,
            };
            $campaignLabel = optional($__theme)->ribbon_campaign_label ?: $campaignDefaultLabel;
            $campaignLinkUrl = optional($__theme)->ribbon_campaign_link_url;
            $campaignLinkExternal = (bool) (optional($__theme)->ribbon_campaign_link_external);

            $mourningDefaultLabel = 'Luto Oficial';
            $mourningLabel = optional($__theme)->ribbon_mourning_label ?: $mourningDefaultLabel;
            $mourningLinkUrl = optional($__theme)->ribbon_mourning_link_url;
            $mourningLinkExternal = (bool) (optional($__theme)->ribbon_mourning_link_external);
        @endphp
        @php
            // Texto dinâmico abaixo do lacinho
            $defaultLabel = match(optional($__theme)->ribbon_variant) {
                'october_pink' => 'Outubro Rosa',
                'september_yellow' => 'Setembro Amarelo',
                'november_blue' => 'Novembro Azul',
                'mourning_black' => 'Luto Oficial',
                default => null,
            };
            $ribbonLabel = optional($__theme)->ribbon_label ?: $defaultLabel;
            $ribbonLinkUrl = optional($__theme)->ribbon_link_url;
            $ribbonLinkExternal = (bool) (optional($__theme)->ribbon_link_external);
        @endphp
        @if($showRibbon || $showMourning)
            <style>
                .ribbon-scale-on-hover { transition: transform .15s ease-in-out; }
                .ribbon-scale-on-hover:hover { transform: scale(1.08); }
            </style>
            @php
                $containerClasses = 'd-none d-md-flex flex-column align-items-center ms-2';
            @endphp
            <div class="{{ $containerClasses }}">
                <div class="d-flex align-items-center">
                    @if($showRibbon)
                        @if($campaignLinkUrl)
                            <a href="{{ $campaignLinkUrl }}" @if($campaignLinkExternal) target="_blank" rel="noopener" @endif class="ribbon-scale-on-hover text-decoration-none" title="{{ $campaignLabel }}">
                                <x-ribbon width="28" height="52" />
                            </a>
                        @else
                            <span class="ribbon-scale-on-hover" title="{{ $campaignLabel }}">
                                <x-ribbon width="28" height="52" />
                            </span>
                        @endif
                    @endif
                    @if($showMourning)
                        @if($mourningLinkUrl)
                            <a href="{{ $mourningLinkUrl }}" @if($mourningLinkExternal) target="_blank" rel="noopener" @endif class="ribbon-scale-on-hover ms-2 text-decoration-none" title="{{ $mourningLabel }}">
                                <x-ribbon width="28" height="52" fillPrimary="#000000" fillBase="#FEFEFE" stroke="#FEFEFE" />
                            </a>
                        @else
                            <span class="ribbon-scale-on-hover ms-2" title="{{ $mourningLabel }}">
                                <x-ribbon width="28" height="52" fillPrimary="#000000" fillBase="#FEFEFE" stroke="#FEFEFE" />
                            </span>
                        @endif
                    @endif
                </div>
                
            </div>
        @endif
        
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
                <!-- Ribbon compacto para mobile dentro do menu colapsado -->
                @if($showRibbon || $showMourning)
                    <li class="nav-item d-flex d-md-none align-items-start flex-column">
                        <style>
                            .ribbon-scale-on-hover { transition: transform .15s ease-in-out; }
                            .ribbon-scale-on-hover:hover { transform: scale(1.08); }
                            .ribbon-label { font-size: .85rem; line-height: 1; }
                        </style>
                        <div class="d-flex align-items-center">
                            @if($showRibbon)
                                @if($campaignLinkUrl)
                                    <a href="{{ $campaignLinkUrl }}" @if($campaignLinkExternal) target="_blank" rel="noopener" @endif class="ribbon-scale-on-hover me-2 text-decoration-none" title="{{ $campaignLabel }}">
                                        <x-ribbon width="22" height="40" />
                                    </a>
                                @else
                                    <span class="ribbon-scale-on-hover me-2" title="{{ $campaignLabel }}">
                                        <x-ribbon width="22" height="40" />
                                    </span>
                                @endif
                            @endif
                            @if($showMourning)
                                @if($mourningLinkUrl)
                                    <a href="{{ $mourningLinkUrl }}" @if($mourningLinkExternal) target="_blank" rel="noopener" @endif class="ribbon-scale-on-hover me-2 text-decoration-none" title="{{ $mourningLabel }}">
                                        <x-ribbon width="22" height="40" fillPrimary="#000000" fillBase="#FEFEFE" stroke="#FEFEFE" />
                                    </a>
                                @else
                                    <span class="ribbon-scale-on-hover me-2" title="{{ $mourningLabel }}">
                                        <x-ribbon width="22" height="40" fillPrimary="#000000" fillBase="#FEFEFE" stroke="#FEFEFE" />
                                    </span>
                                @endif
                            @endif
                        </div>
                        
                    </li>
                @endif
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
                            <li><a class="dropdown-item" href="{{ route('cidadao.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard do Cidadão
                            </a></li>
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