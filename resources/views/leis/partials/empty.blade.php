<div class="estado-vazio">
    <div class="estado-vazio-icon">
        <i class="fas fa-search"></i>
    </div>
    <h3>Nenhuma lei encontrada</h3>
    <p>
        @if(request()->hasAny(['busca', 'tipo', 'exercicio']))
            Não encontramos leis que correspondam aos filtros aplicados.
            <br>
            <a href="{{ route('leis.index') }}" class="btn btn-outline-primary mt-3">
                <i class="fas fa-times"></i>
                Limpar filtros
            </a>
        @else
            Ainda não há leis cadastradas no sistema.
        @endif
    </p>
</div>