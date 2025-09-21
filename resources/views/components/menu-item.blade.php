@props(['menu', 'isDropdown' => false])

@if($menu->tipo === 'divider')
    @if($isDropdown)
        <li><hr class="dropdown-divider"></li>
    @endif
@elseif($menu->tipo === 'dropdown' && $menu->children->count() > 0)
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown{{ $menu->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if($menu->icone)
                <i class="{{ $menu->icone }} me-1"></i>
            @endif
            {{ $menu->titulo }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdown{{ $menu->id }}">
            @foreach($menu->children()->where('ativo', true)->orderBy('ordem')->get() as $submenu)
                @if($submenu->podeExibir())
                    <x-menu-item :menu="$submenu" :isDropdown="true" />
                @endif
            @endforeach
        </ul>
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
            <a class="nav-link" href="{{ $menu->getUrlCompleta() }}" 
               @if($menu->nova_aba) target="_blank" @endif>
                @if($menu->icone)
                    <i class="{{ $menu->icone }} me-1"></i>
                @endif
                {{ $menu->titulo }}
            </a>
        </li>
    @endif
@endif