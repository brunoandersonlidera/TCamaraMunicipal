/**
 * E-SIC FAQ JavaScript
 * Funcionalidades para a página de perguntas frequentes
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elementos da página
    const searchInput = document.getElementById('faq-search');
    const categoryButtons = document.querySelectorAll('.category-btn');
    const faqItems = document.querySelectorAll('.faq-item');
    const clearSearchBtn = document.getElementById('clear-search');
    const noResultsDiv = document.getElementById('no-results');

    // Inicialização
    init();

    function init() {
        setupSearch();
        setupCategoryFilter();
        setupAccordion();
        setupScrollToTop();
        loadFAQData();
    }

    /**
     * Configurar busca
     */
    function setupSearch() {
        if (searchInput) {
            searchInput.addEventListener('input', debounce(performSearch, 300));
            
            // Limpar busca
            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    performSearch();
                    searchInput.focus();
                });
            }

            // Enter para buscar
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });
        }
    }

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
            const category = item.dataset.category || '';

            const matches = question.includes(searchTerm) || 
                          answer.includes(searchTerm) || 
                          category.toLowerCase().includes(searchTerm);

            if (searchTerm === '' || matches) {
                item.style.display = 'block';
                visibleCount++;
                
                // Destacar termo de busca
                if (searchTerm !== '') {
                    highlightSearchTerm(item, searchTerm);
                } else {
                    removeHighlight(item);
                }
            } else {
                item.style.display = 'none';
            }
        });

        // Mostrar/ocultar mensagem de "nenhum resultado"
        toggleNoResults(visibleCount === 0 && searchTerm !== '');

        // Atualizar botão de limpar
        if (clearSearchBtn) {
            clearSearchBtn.style.display = searchTerm ? 'block' : 'none';
        }

        // Atualizar contadores de categoria
        updateCategoryCounters();
    }

    function highlightSearchTerm(item, term) {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        [question, answer].forEach(element => {
            if (element) {
                const originalText = element.dataset.originalText || element.textContent;
                element.dataset.originalText = originalText;

                const regex = new RegExp(`(${escapeRegex(term)})`, 'gi');
                const highlightedText = originalText.replace(regex, '<mark>$1</mark>');
                element.innerHTML = highlightedText;
            }
        });
    }

    function removeHighlight(item) {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        [question, answer].forEach(element => {
            if (element && element.dataset.originalText) {
                element.textContent = element.dataset.originalText;
                delete element.dataset.originalText;
            }
        });
    }

    function escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    /**
     * Configurar filtro por categoria
     */
    function setupCategoryFilter() {
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.dataset.category;
                filterByCategory(category);
                updateActiveCategory(this);
            });
        });
    }

    function filterByCategory(category) {
        let visibleCount = 0;

        faqItems.forEach(item => {
            const itemCategory = item.dataset.category;
            
            if (category === 'all' || itemCategory === category) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Limpar busca ao filtrar por categoria
        if (searchInput) {
            searchInput.value = '';
            removeAllHighlights();
        }

        toggleNoResults(visibleCount === 0);
        updateCategoryCounters();
    }

    function updateActiveCategory(activeButton) {
        categoryButtons.forEach(btn => btn.classList.remove('active'));
        activeButton.classList.add('active');
    }

    function removeAllHighlights() {
        faqItems.forEach(item => removeHighlight(item));
    }

    /**
     * Configurar accordion
     */
    function setupAccordion() {
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');

            if (question && answer) {
                question.addEventListener('click', function() {
                    toggleAccordionItem(item, answer, icon);
                });

                // Permitir navegação por teclado
                question.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleAccordionItem(item, answer, icon);
                    }
                });
            }
        });
    }

    function toggleAccordionItem(item, answer, icon) {
        const isOpen = item.classList.contains('active');

        if (isOpen) {
            // Fechar
            item.classList.remove('active');
            answer.style.maxHeight = null;
            if (icon) icon.style.transform = 'rotate(0deg)';
        } else {
            // Fechar outros itens (comportamento accordion)
            closeAllAccordionItems();
            
            // Abrir este item
            item.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            if (icon) icon.style.transform = 'rotate(180deg)';

            // Scroll suave para o item
            setTimeout(() => {
                item.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'nearest' 
                });
            }, 100);
        }

        // Salvar estado no localStorage
        saveFAQState();
    }

    function closeAllAccordionItems() {
        faqItems.forEach(item => {
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');
            
            item.classList.remove('active');
            if (answer) answer.style.maxHeight = null;
            if (icon) icon.style.transform = 'rotate(0deg)';
        });
    }

    /**
     * Configurar scroll to top
     */
    function setupScrollToTop() {
        const scrollTopBtn = document.getElementById('scroll-top');
        
        if (scrollTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.style.display = 'block';
                } else {
                    scrollTopBtn.style.display = 'none';
                }
            });

            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    }

    /**
     * Utilitários
     */
    function toggleNoResults(show) {
        if (noResultsDiv) {
            noResultsDiv.style.display = show ? 'block' : 'none';
        }
    }

    function updateCategoryCounters() {
        categoryButtons.forEach(button => {
            const category = button.dataset.category;
            const counter = button.querySelector('.category-counter');
            
            if (counter) {
                let count = 0;
                
                if (category === 'all') {
                    count = Array.from(faqItems).filter(item => 
                        item.style.display !== 'none'
                    ).length;
                } else {
                    count = Array.from(faqItems).filter(item => 
                        item.dataset.category === category && 
                        item.style.display !== 'none'
                    ).length;
                }
                
                counter.textContent = count;
            }
        });
    }

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
     * Salvar/Restaurar estado
     */
    function saveFAQState() {
        const openItems = Array.from(faqItems)
            .filter(item => item.classList.contains('active'))
            .map(item => item.dataset.id || Array.from(faqItems).indexOf(item));
        
        localStorage.setItem('faq_open_items', JSON.stringify(openItems));
    }

    function restoreFAQState() {
        const savedState = localStorage.getItem('faq_open_items');
        
        if (savedState) {
            try {
                const openItems = JSON.parse(savedState);
                
                openItems.forEach(itemId => {
                    let item;
                    
                    if (typeof itemId === 'string') {
                        item = document.querySelector(`[data-id="${itemId}"]`);
                    } else {
                        item = faqItems[itemId];
                    }
                    
                    if (item) {
                        const answer = item.querySelector('.faq-answer');
                        const icon = item.querySelector('.faq-icon');
                        
                        item.classList.add('active');
                        if (answer) answer.style.maxHeight = answer.scrollHeight + 'px';
                        if (icon) icon.style.transform = 'rotate(180deg)';
                    }
                });
            } catch (e) {
                console.error('Erro ao restaurar estado do FAQ:', e);
            }
        }
    }

    /**
     * Carregar dados do FAQ
     */
    function loadFAQData() {
        // Atualizar contadores iniciais
        updateCategoryCounters();
        
        // Restaurar estado salvo
        restoreFAQState();
        
        // Configurar tooltips se Bootstrap estiver disponível
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    /**
     * Funcionalidades adicionais
     */
    
    // Expandir/Colapsar todos
    const expandAllBtn = document.getElementById('expand-all');
    const collapseAllBtn = document.getElementById('collapse-all');
    
    if (expandAllBtn) {
        expandAllBtn.addEventListener('click', function() {
            faqItems.forEach(item => {
                if (item.style.display !== 'none') {
                    const answer = item.querySelector('.faq-answer');
                    const icon = item.querySelector('.faq-icon');
                    
                    item.classList.add('active');
                    if (answer) answer.style.maxHeight = answer.scrollHeight + 'px';
                    if (icon) icon.style.transform = 'rotate(180deg)';
                }
            });
            saveFAQState();
        });
    }
    
    if (collapseAllBtn) {
        collapseAllBtn.addEventListener('click', function() {
            closeAllAccordionItems();
            saveFAQState();
        });
    }

    // Compartilhar pergunta específica
    function shareQuestion(questionId) {
        const url = `${window.location.origin}${window.location.pathname}#faq-${questionId}`;
        
        if (navigator.share) {
            navigator.share({
                title: 'Pergunta Frequente - E-SIC',
                url: url
            });
        } else {
            // Fallback: copiar para clipboard
            navigator.clipboard.writeText(url).then(() => {
                showToast('Link copiado para a área de transferência!');
            });
        }
    }

    function showToast(message) {
        // Criar toast simples
        const toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Adicionar CSS para animações
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .faq-answer {
            transition: max-height 0.3s ease;
            overflow: hidden;
        }
        
        .faq-icon {
            transition: transform 0.3s ease;
        }
        
        mark {
            background-color: #fff3cd;
            padding: 0 2px;
            border-radius: 2px;
        }
    `;
    document.head.appendChild(style);

    // Expor funções globalmente se necessário
    window.ESICFaq = {
        shareQuestion: shareQuestion,
        expandAll: () => expandAllBtn?.click(),
        collapseAll: () => collapseAllBtn?.click()
    };
});