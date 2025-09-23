@props(['menu', 'isDropdown' => false])

@if($menu->tipo === 'divider')
    @if($isDropdown)
        <li><hr class="dropdown-divider"></li>
    @endif
@elseif($menu->tipo === 'dropdown' && $menu->children->count() > 0)
    <li class="nav-item dropdown">
        <!-- Desktop: Dropdown padrão do Bootstrap -->
        <a class="nav-link dropdown-toggle d-none d-lg-flex" href="#" id="dropdown{{ $menu->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if($menu->icone)
                <i class="{{ $menu->icone }} me-1"></i>
            @endif
            {{ $menu->titulo }}
        </a>
        <ul class="dropdown-menu d-none d-lg-block" aria-labelledby="dropdown{{ $menu->id }}">
            @foreach($menu->children()->where('ativo', true)->orderBy('ordem')->get() as $submenu)
                @if($submenu->podeExibir())
                    <x-menu-item :menu="$submenu" :isDropdown="true" />
                @endif
            @endforeach
        </ul>
        
        <!-- Mobile: Sistema de Acordeão -->
        <div class="mobile-accordion-item d-lg-none">
            <div class="mobile-accordion-header">
                <button class="mobile-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#mobileAccordion{{ $menu->id }}" aria-expanded="false" aria-controls="mobileAccordion{{ $menu->id }}">
                    @if($menu->icone)
                        <i class="{{ $menu->icone }} menu-icon"></i>
                    @endif
                    <span>{{ $menu->titulo }}</span>
                    <i class="fas fa-chevron-down accordion-icon"></i>
                </button>
            </div>
            <div class="mobile-accordion-collapse collapse" id="mobileAccordion{{ $menu->id }}">
                <div class="mobile-accordion-body">
                    @foreach($menu->children()->where('ativo', true)->orderBy('ordem')->get() as $submenu)
                        @if($submenu->podeExibir())
                            @if($submenu->tipo === 'divider')
                                <div class="mobile-accordion-divider"></div>
                            @else
                                <a class="dropdown-item" href="{{ $submenu->getUrlCompleta() }}" 
                                   @if($submenu->nova_aba) target="_blank" @endif>
                                    @if($submenu->icone)
                                        <i class="{{ $submenu->icone }}"></i>
                                    @endif
                                    {{ $submenu->titulo }}
                                </a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </li>
@else
    @if($isDropdown)
        <li>
            <a class="dropdown-item" href="{{ $menu->getUrlCompleta() }}" 
               @if($menu->nova_aba) target="_blank" @endif>
                @if($menu->icone)
                    <i class="{{ $menu->icone }} me-2"></i>
                @endif
                {{ $menu->titulo }}
            </a>
        </li>
    @else
        <li class="nav-item">
            @php
                $configuracoes = $menu->configuracoes;
                if (is_string($configuracoes)) {
                    $configuracoes = json_decode($configuracoes, true);
                }
                $classeCSS = isset($configuracoes['classe_css']) ? $configuracoes['classe_css'] : '';
            @endphp
            <a class="nav-link {{ $classeCSS }}" href="{{ $menu->getUrlCompleta() }}" 
               @if($menu->nova_aba) target="_blank" @endif>
                @if($menu->icone)
                    <i class="{{ $menu->icone }} me-1"></i>
                @endif
                {{ $menu->titulo }}
            </a>
        </li>
    @endif
@endif