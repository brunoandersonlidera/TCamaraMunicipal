@props(['titulo', 'menus'])

<div class="col-lg-3 col-md-6 mb-4">
    <h5 class="footer-title">{{ $titulo }}</h5>
    <ul class="list-unstyled footer-menu">
        @foreach($menus as $menu)
            @if($menu->podeExibir())
                @if($menu->tipo === 'divider')
                    <li class="my-2"><hr class="border-light"></li>
                @else
                    <li>
                        <a href="{{ $menu->getUrlCompleta() }}" 
                           @if($menu->nova_aba) target="_blank" @endif>
                            @if($menu->icone)
                                <i class="{{ $menu->icone }} me-2"></i>
                            @endif
                            {{ $menu->titulo }}
                        </a>
                    </li>
                    @if($menu->children()->count() > 0)
                        @foreach($menu->children()->where('ativo', true)->orderBy('ordem')->get() as $submenu)
                            @if($submenu->podeExibir())
                                <li class="ms-3">
                                    <a href="{{ $submenu->getUrlCompleta() }}" 
                                       @if($submenu->nova_aba) target="_blank" @endif>
                                        @if($submenu->icone)
                                            <i class="{{ $submenu->icone }} me-2"></i>
                                        @endif
                                        {{ $submenu->titulo }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endif
            @endif
        @endforeach
    </ul>
</div>