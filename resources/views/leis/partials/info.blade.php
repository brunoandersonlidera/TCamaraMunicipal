<div class="d-flex justify-content-between align-items-center">
    <div>
        <span class="resultados-count">
            {{ $leis->total() }} {{ $leis->total() == 1 ? 'lei encontrada' : 'leis encontradas' }}
        </span>
        @if(request()->hasAny(['busca', 'tipo', 'exercicio']))
            <span class="filtros-ativos">
                (filtros aplicados)
            </span>
        @endif
    </div>
    <div class="resultados-paginacao-info">
        Página {{ $leis->currentPage() }} de {{ $leis->lastPage() }}
    </div>
</div>