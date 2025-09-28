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
                </div>
            </div>
        </div>
    </div>
</footer>