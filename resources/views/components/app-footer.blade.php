@php
    $menusFooter = \App\Models\Menu::getMenusFooter();
    $gruposFooter = $menusFooter->groupBy('grupo_footer');
    
    // Configurações dinâmicas
    $logoFooter = \App\Models\ConfiguracaoGeral::obterLogoFooter();
    $endereco = \App\Models\ConfiguracaoGeral::obterEndereco();
    $telefone = \App\Models\ConfiguracaoGeral::obterTelefone();
    $email = \App\Models\ConfiguracaoGeral::obterEmail();
    $direitosAutorais = \App\Models\ConfiguracaoGeral::obterDireitosAutorais();
    $nomeCamara = \App\Models\ConfiguracaoGeral::obterValor('nome_camara', 'Câmara Municipal');
@endphp

<!-- Footer -->
<footer class="footer-custom">
    <div class="container">
    <style>
        .ribbon-scale-on-hover { transition: transform .15s ease-in-out; }
        .ribbon-scale-on-hover:hover { transform: scale(1.08); }
        .ribbon-label { font-size: .85rem; line-height: 1; }
    </style>
        @php
            // Determinar tema ativo ou de preview para exibir lacinhos no rodapé
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
        <div class="row">
            <!-- Logo e Informações da Câmara -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-brand">
                    @if($logoFooter)
                        <img src="{{ $logoFooter }}" alt="Logo {{ $nomeCamara }}" class="logo-footer mb-3">
                    @else
                        <div class="logo-placeholder mb-3">
                            <i class="fas fa-landmark"></i>
                        </div>
                    @endif
                    <h5 class="footer-title">{{ $nomeCamara }}</h5>
                    <p class="footer-description">
                        Representando os interesses da população com transparência e compromisso.
                    </p>
                </div>
            </div>
            
            <!-- Menus Dinâmicos do Footer -->
            @foreach($gruposFooter as $grupo => $menus)
                <x-footer-menu :titulo="$grupo ?: 'Links'" :menus="$menus" />
            @endforeach
            
            @if($gruposFooter->isEmpty())
                <!-- Fallback caso não haja menus -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Links Rápidos</h5>
                    <ul class="footer-menu">
                        <li><a href="{{ route('home') }}">Início</a></li>
                        <li><a href="{{ route('esic.create') }}">e-SIC</a></li>
                    </ul>
                </div>
            @endif
            
            <!-- Informações de Contato -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-contact">
                    <h5 class="footer-title">
                        <i class="fas fa-phone me-2"></i>
                        Contato
                    </h5>
                    <div class="contact-info">
                        @if($endereco)
                            <p class="contact-item">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <strong>Endereço:</strong><br>
                                {!! nl2br(e($endereco)) !!}
                            </p>
                        @endif
                        
                        @if($telefone)
                            <p class="contact-item">
                                <i class="fas fa-phone me-2"></i>
                                <strong>Telefone:</strong><br>
                                {{ $telefone }}
                            </p>
                        @endif
                        
                        @if($email)
                            <p class="contact-item">
                                <i class="fas fa-envelope me-2"></i>
                                <strong>E-mail:</strong><br>
                                <a href="mailto:{{ $email }}" class="text-light">{{ $email }}</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="row">
            <div class="col-12">
                <div class="footer-bottom">
                    <div class="copyright">
                        <p>
                            @if($direitosAutorais)
                                {!! $direitosAutorais !!}
                            @else
                                &copy; {{ date('Y') }} {{ $nomeCamara }}. Todos os direitos reservados.
                            @endif
                        </p>
                    </div>
                    @if($showRibbon || $showMourning)
                        <div class="footer-ribbons d-flex align-items-center justify-content-end">
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
                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>