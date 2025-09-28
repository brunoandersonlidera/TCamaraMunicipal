@if ($paginator->hasPages())
    <nav class="admin-pagination-wrapper">
        <div class="admin-pagination-container">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="admin-page-btn admin-page-disabled">
                    <i class="fas fa-chevron-left"></i> Anterior
                </span>
            @else
                <a class="admin-page-btn admin-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="fas fa-chevron-left"></i> Anterior
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="admin-page-btn admin-page-dots">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="admin-page-btn admin-page-active">{{ $page }}</span>
                        @else
                            <a class="admin-page-btn admin-page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="admin-page-btn admin-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    Próximo <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="admin-page-btn admin-page-disabled">
                    Próximo <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>

        {{-- Results info --}}
        <div class="admin-pagination-info mt-3">
            <p class="admin-pagination-text">
                Mostrando {{ $paginator->firstItem() }} a {{ $paginator->lastItem() }} 
                de {{ $paginator->total() }} resultados
            </p>
        </div>
    </nav>
@endif
