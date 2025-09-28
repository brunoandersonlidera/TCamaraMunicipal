/**
 * Cartas de Serviço - JavaScript Principal
 * Sistema de gerenciamento de cartas de serviço da Câmara Municipal
 */

document.addEventListener('DOMContentLoaded', function() {
    initCartasServico();
});

/**
 * Inicialização principal do sistema
 */
function initCartasServico() {
    initFilters();
    initSearch();
    initCards();
    initPagination();
    initAnimations();
    initAccessibility();
}

/**
 * Inicialização dos filtros
 */
function initFilters() {
    const filterForm = document.getElementById('filter-form');
    const searchInput = document.getElementById('search-input');
    const categoriaSelect = document.getElementById('categoria-filter');
    const statusSelect = document.getElementById('status-filter');
    const ordenacaoSelect = document.getElementById('ordenacao-filter');

    if (!filterForm) return;

    // Aplicar filtros em tempo real
    [searchInput, categoriaSelect, statusSelect, ordenacaoSelect].forEach(element => {
        if (element) {
            element.addEventListener('change', debounce(applyFilters, 300));
            element.addEventListener('input', debounce(applyFilters, 300));
        }
    });

    // Botão de limpar filtros
    const clearFiltersBtn = document.getElementById('clear-filters');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', clearFilters);
    }
}

/**
 * Aplicar filtros
 */
function applyFilters() {
    const searchTerm = document.getElementById('search-input')?.value.toLowerCase() || '';
    const categoria = document.getElementById('categoria-filter')?.value || '';
    const status = document.getElementById('status-filter')?.value || '';
    const ordenacao = document.getElementById('ordenacao-filter')?.value || 'nome';

    const cards = document.querySelectorAll('.servico-card');
    let visibleCards = [];

    cards.forEach(card => {
        const title = card.querySelector('.servico-title')?.textContent.toLowerCase() || '';
        const description = card.querySelector('.servico-description')?.textContent.toLowerCase() || '';
        const cardCategoria = card.dataset.categoria || '';
        const cardStatus = card.dataset.status || '';

        const matchesSearch = !searchTerm || title.includes(searchTerm) || description.includes(searchTerm);
        const matchesCategoria = !categoria || cardCategoria === categoria;
        const matchesStatus = !status || cardStatus === status;

        const isVisible = matchesSearch && matchesCategoria && matchesStatus;

        if (isVisible) {
            card.style.display = 'block';
            visibleCards.push(card);
        } else {
            card.style.display = 'none';
        }
    });

    // Aplicar ordenação
    sortCards(visibleCards, ordenacao);

    // Mostrar/ocultar estado vazio
    toggleEmptyState(visibleCards.length === 0);

    // Atualizar contador
    updateResultsCounter(visibleCards.length, cards.length);
}

/**
 * Ordenar cards
 */
function sortCards(cards, ordenacao) {
    const container = document.querySelector('.servicos-grid');
    if (!container) return;

    cards.sort((a, b) => {
        switch (ordenacao) {
            case 'nome':
                return a.querySelector('.servico-title').textContent.localeCompare(
                    b.querySelector('.servico-title').textContent
                );
            case 'categoria':
                return (a.dataset.categoria || '').localeCompare(b.dataset.categoria || '');
            case 'data_criacao':
                return new Date(b.dataset.dataCriacao || 0) - new Date(a.dataset.dataCriacao || 0);
            case 'visualizacoes':
                return (parseInt(b.dataset.visualizacoes) || 0) - (parseInt(a.dataset.visualizacoes) || 0);
            default:
                return 0;
        }
    });

    // Reordenar no DOM
    cards.forEach(card => container.appendChild(card));
}

/**
 * Limpar filtros
 */
function clearFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('categoria-filter').value = '';
    document.getElementById('status-filter').value = '';
    document.getElementById('ordenacao-filter').value = 'nome';
    
    applyFilters();
}

/**
 * Mostrar/ocultar estado vazio
 */
function toggleEmptyState(show) {
    let emptyState = document.querySelector('.empty-state');
    
    if (show && !emptyState) {
        emptyState = createEmptyState();
        document.querySelector('.servicos-grid').appendChild(emptyState);
    } else if (!show && emptyState) {
        emptyState.remove();
    }
}

/**
 * Criar elemento de estado vazio
 */
function createEmptyState() {
    const emptyState = document.createElement('div');
    emptyState.className = 'empty-state col-12';
    emptyState.innerHTML = `
        <i class="fas fa-search"></i>
        <h3>Nenhum serviço encontrado</h3>
        <p>Tente ajustar os filtros ou termos de busca</p>
        <button class="btn btn-primary" onclick="clearFilters()">
            <i class="fas fa-refresh me-2"></i>
            Limpar Filtros
        </button>
    `;
    return emptyState;
}

/**
 * Atualizar contador de resultados
 */
function updateResultsCounter(visible, total) {
    const counter = document.getElementById('results-counter');
    if (counter) {
        counter.textContent = `Mostrando ${visible} de ${total} serviços`;
    }
}

/**
 * Inicialização da busca
 */
function initSearch() {
    const searchInput = document.getElementById('search-input');
    if (!searchInput) return;

    // Adicionar ícone de busca
    const searchContainer = searchInput.parentElement;
    if (searchContainer && !searchContainer.querySelector('.search-icon')) {
        const icon = document.createElement('i');
        icon.className = 'fas fa-search search-icon';
        searchContainer.appendChild(icon);
        searchContainer.classList.add('search-container');
    }

    // Placeholder dinâmico
    const placeholders = [
        'Buscar por nome do serviço...',
        'Ex: Certidão de nascimento',
        'Ex: Licença para construir',
        'Ex: Registro de empresa'
    ];
    
    let placeholderIndex = 0;
    setInterval(() => {
        if (!searchInput.value && document.activeElement !== searchInput) {
            searchInput.placeholder = placeholders[placeholderIndex];
            placeholderIndex = (placeholderIndex + 1) % placeholders.length;
        }
    }, 3000);
}

/**
 * Inicialização dos cards
 */
function initCards() {
    const cards = document.querySelectorAll('.servico-card');
    
    cards.forEach(card => {
        // Hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });

        // Click tracking
        const viewButton = card.querySelector('.btn-primary-servico');
        if (viewButton) {
            viewButton.addEventListener('click', function(e) {
                const cardId = card.dataset.id;
                if (cardId) {
                    trackCardView(cardId);
                }
            });
        }

        // Lazy loading para imagens (se houver)
        const images = card.querySelectorAll('img[data-src]');
        images.forEach(img => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            });
            observer.observe(img);
        });
    });
}

/**
 * Rastrear visualização de card
 */
function trackCardView(cardId) {
    // Incrementar contador local
    const card = document.querySelector(`[data-id="${cardId}"]`);
    if (card) {
        const viewsElement = card.querySelector('.views-count');
        if (viewsElement) {
            const currentViews = parseInt(viewsElement.textContent) || 0;
            viewsElement.textContent = currentViews + 1;
        }
    }

    // Enviar para o servidor (opcional)
    fetch(`/cartas-servico/${cardId}/view`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    }).catch(error => {
        console.log('Erro ao rastrear visualização:', error);
    });
}

/**
 * Inicialização da paginação
 */
function initPagination() {
    const paginationLinks = document.querySelectorAll('.pagination a');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = this.href;
            if (url) {
                loadPage(url);
            }
        });
    });
}

/**
 * Carregar página via AJAX
 */
function loadPage(url) {
    const container = document.querySelector('.servicos-container');
    if (!container) return;

    // Mostrar loading
    showLoading(container);

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newContent = doc.querySelector('.servicos-container');
        
        if (newContent) {
            container.innerHTML = newContent.innerHTML;
            initCards();
            initPagination();
            
            // Scroll suave para o topo
            container.scrollIntoView({ behavior: 'smooth' });
        }
    })
    .catch(error => {
        console.error('Erro ao carregar página:', error);
        hideLoading(container);
    });
}

/**
 * Mostrar loading
 */
function showLoading(container) {
    const loading = document.createElement('div');
    loading.className = 'loading-overlay';
    loading.innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
            <p>Carregando...</p>
        </div>
    `;
    container.appendChild(loading);
}

/**
 * Ocultar loading
 */
function hideLoading(container) {
    const loading = container.querySelector('.loading-overlay');
    if (loading) {
        loading.remove();
    }
}

/**
 * Inicialização das animações
 */
function initAnimations() {
    // Animação de entrada dos cards
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.servico-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Animação do hero
    const hero = document.querySelector('.cartas-hero');
    if (hero) {
        hero.style.opacity = '0';
        hero.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            hero.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            hero.style.opacity = '1';
            hero.style.transform = 'translateY(0)';
        }, 100);
    }
}

/**
 * Inicialização da acessibilidade
 */
function initAccessibility() {
    // Navegação por teclado
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Fechar modais ou limpar busca
            const searchInput = document.getElementById('search-input');
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                applyFilters();
                searchInput.focus();
            }
        }
    });

    // Melhorar foco nos cards
    const cards = document.querySelectorAll('.servico-card');
    cards.forEach(card => {
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'article');
        
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const link = this.querySelector('.btn-primary-servico');
                if (link) {
                    link.click();
                }
            }
        });
    });

    // Anunciar mudanças para leitores de tela
    const resultsContainer = document.querySelector('.servicos-grid');
    if (resultsContainer) {
        resultsContainer.setAttribute('aria-live', 'polite');
        resultsContainer.setAttribute('aria-label', 'Lista de serviços');
    }
}

/**
 * Função debounce para otimizar performance
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Utilitários para compartilhamento
 */
window.compartilharServico = function(titulo, descricao, url) {
    if (navigator.share) {
        navigator.share({
            title: titulo,
            text: descricao,
            url: url
        }).catch(error => {
            console.log('Erro ao compartilhar:', error);
            copiarLink(url);
        });
    } else {
        copiarLink(url);
    }
};

/**
 * Copiar link para área de transferência
 */
function copiarLink(url) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            mostrarNotificacao('Link copiado para a área de transferência!', 'success');
        }).catch(() => {
            fallbackCopyText(url);
        });
    } else {
        fallbackCopyText(url);
    }
}

/**
 * Fallback para copiar texto
 */
function fallbackCopyText(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        mostrarNotificacao('Link copiado para a área de transferência!', 'success');
    } catch (err) {
        mostrarNotificacao('Não foi possível copiar o link', 'error');
    }
    
    document.body.removeChild(textArea);
}

/**
 * Mostrar notificação
 */
function mostrarNotificacao(mensagem, tipo = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${tipo}`;
    notification.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check' : tipo === 'error' ? 'times' : 'info'}-circle"></i>
        <span>${mensagem}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Mostrar notificação
    setTimeout(() => {
        // Verificação de segurança para classList
        if (notification && notification.classList) {
            try {
                notification.classList.add('show');
            } catch (error) {
                console.warn('Erro ao adicionar classe show à notification:', error);
            }
        }
    }, 100);
    
    // Remover notificação
    setTimeout(() => {
        // Verificação de segurança para classList
        if (notification && notification.classList) {
            try {
                notification.classList.remove('show');
            } catch (error) {
                console.warn('Erro ao remover classe show da notification:', error);
            }
        }
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

/**
 * Função para imprimir página
 */
window.imprimirPagina = function() {
    window.print();
};

/**
 * Função para voltar ao topo
 */
window.voltarAoTopo = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

// Adicionar botão "Voltar ao topo" quando necessário
window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    let backToTopBtn = document.getElementById('back-to-top');
    
    if (scrollTop > 300) {
        if (!backToTopBtn) {
            backToTopBtn = document.createElement('button');
            backToTopBtn.id = 'back-to-top';
            backToTopBtn.className = 'btn-back-to-top';
            backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            backToTopBtn.onclick = voltarAoTopo;
            backToTopBtn.setAttribute('aria-label', 'Voltar ao topo');
            document.body.appendChild(backToTopBtn);
        }
        backToTopBtn.style.display = 'block';
    } else if (backToTopBtn) {
        backToTopBtn.style.display = 'none';
    }
});

// CSS para notificações e botão voltar ao topo
const style = document.createElement('style');
style.textContent = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-radius: 8px;
        padding: 15px 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        z-index: 9999;
        border-left: 4px solid #007bff;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification-success {
        border-left-color: #28a745;
        color: #155724;
    }
    
    .notification-error {
        border-left-color: #dc3545;
        color: #721c24;
    }
    
    .btn-back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--cs-primary, #007bff);
        color: white;
        border: none;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        z-index: 1000;
    }
    
    .btn-back-to-top:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }
    
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
    }
    
    .loading-spinner {
        text-align: center;
        color: var(--cs-primary, #007bff);
    }
    
    .search-container {
        position: relative;
    }
    
    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }
`;
document.head.appendChild(style);