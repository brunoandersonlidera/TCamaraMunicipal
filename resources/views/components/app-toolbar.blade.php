<!-- Barra de Ferramentas Fixa -->
<section class="fixed-toolbar-section">
    <div class="toolbar-wrapper">
        <div class="toolbar-bar-fixed">
            <div class="container">
                <div class="toolbar-content-fixed">
                    <!-- Campo de Busca -->
                    <div class="search-container-fixed">
                        <form action="{{ route('search') }}" method="GET" class="search-form-fixed">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control search-input-fixed" 
                                       placeholder="Buscar documentos, leis, notícias..." 
                                       value="{{ request('q') }}">
                                <button class="btn btn-search-fixed" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Botão e-SIC -->
                    <div class="esic-container-fixed">
                        <a href="{{ route('esic.create') }}" class="btn-esic-toolbar-fixed">
                            <div class="esic-icon-fixed">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="esic-text-fixed">
                                <span class="esic-title-fixed">e-SIC</span>
                                <span class="esic-subtitle-fixed">Acesso à Informação</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>