/**
 * JavaScript para página de administração de Acesso Rápido
 * Funcionalidades: Sortable, AJAX para reordenação, feedback visual
 */

document.addEventListener('DOMContentLoaded', function() {
    try {
        initializeSortableTable();
        initializeColorPreviews();
        initializeFormFeedback();
        applyDynamicColors();
    } catch (error) {
        console.error('Erro na inicialização do acesso-rapido-admin.js:', error);
    }
});

/**
 * Inicializa a funcionalidade de arrastar e soltar para reordenar itens
 */
function initializeSortableTable() {
    const sortableTable = document.getElementById('sortable-table');
    
    if (!sortableTable) {
        return;
    }

    // Verifica se SortableJS está disponível
    if (typeof Sortable === 'undefined') {
        console.warn('SortableJS não está carregado. Funcionalidade de reordenação desabilitada.');
        return;
    }

    new Sortable(sortableTable, {
        animation: 150,
        handle: '.fa-grip-vertical',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        
        onStart: function(evt) {
            // Adiciona feedback visual ao iniciar o arraste
            evt.item.style.opacity = '0.8';
        },
        
        onEnd: function(evt) {
            // Remove feedback visual
            evt.item.style.opacity = '';
            
            // Coleta nova ordem dos itens
            const items = [];
            const rows = sortableTable.querySelectorAll('tr[data-id]');
            
            rows.forEach((row, index) => {
                items.push({
                    id: row.dataset.id,
                    ordem: index + 1
                });
            });

            // Envia nova ordem via AJAX
            updateItemOrder(items, rows);
        }
    });
}

/**
 * Envia a nova ordem dos itens para o servidor
 * @param {Array} items - Array com IDs e nova ordem
 * @param {NodeList} rows - Linhas da tabela para atualizar
 */
function updateItemOrder(items, rows) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        console.error('Token CSRF não encontrado');
        showErrorMessage('Erro de segurança. Recarregue a página.');
        return;
    }
    
    // Validação adicional dos items
    if (!items || !Array.isArray(items) || items.length === 0) {
        console.error('Items inválidos para atualização');
        return;
    }

    // Mostra indicador de carregamento
    showLoadingIndicator();

    fetch(getUpdateOrderUrl(), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        hideLoadingIndicator();
        
        if (data.success) {
            updateOrderBadges(rows);
            showSuccessMessage('Ordem atualizada com sucesso!');
        } else {
            throw new Error(data.message || 'Erro desconhecido');
        }
    })
    .catch(error => {
        hideLoadingIndicator();
        console.error('Erro ao atualizar ordem:', error);
        showErrorMessage('Erro ao atualizar a ordem dos itens.');
        
        // Recarrega a página em caso de erro crítico
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    });
}

/**
 * Atualiza os badges de ordem na tabela
 * @param {NodeList} rows - Linhas da tabela
 */
function updateOrderBadges(rows) {
    rows.forEach((row, index) => {
        const badge = row.querySelector('.badge');
        if (badge) {
            badge.textContent = index + 1;
            
            // Adiciona animação de feedback
            // Verificação de segurança para classList
            if (row && row.classList) {
                try {
                    row.classList.add('updated');
                    setTimeout(() => {
                        if (row && row.classList) {
                            try {
                                row.classList.remove('updated');
                            } catch (error) {
                                console.warn('Erro ao remover classe updated da row:', error);
                            }
                        }
                    }, 500);
                } catch (error) {
                    console.warn('Erro ao adicionar classe updated à row:', error);
                }
            }
        }
    });
}

/**
 * Inicializa funcionalidades dos previews de cor
 */
function initializeColorPreviews() {
    const colorPreviews = document.querySelectorAll('.color-preview');
    
    colorPreviews.forEach(preview => {
        // Adiciona tooltip com valor da cor
        const bgColor = preview.style.backgroundColor;
        if (bgColor && !preview.title) {
            preview.title = `Cor: ${bgColor}`;
        }
        
        // Adiciona evento de clique para copiar cor
        preview.addEventListener('click', function() {
            const color = this.style.backgroundColor;
            if (color) {
                copyToClipboard(color);
                showTooltip(this, 'Cor copiada!');
            }
        });
    });
}

/**
 * Inicializa feedback para formulários
 */
function initializeFormFeedback() {
    const forms = document.querySelectorAll('form[action*="toggle-status"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
            }
        });
    });
}

/**
 * Aplica cores dinamicamente usando atributos data-*
 */
function applyDynamicColors() {
    try {
        // Aplica cores de fundo para previews
        const colorPreviews = document.querySelectorAll('.color-preview[data-bg-color]');
        colorPreviews.forEach(preview => {
            const bgColor = preview.getAttribute('data-bg-color');
            if (bgColor && bgColor.trim() !== '') {
                preview.style.backgroundColor = bgColor;
            }
        });

        // Aplica cores para ícones de acesso
        const acessoIcons = document.querySelectorAll('.acesso-icon[data-color]');
        acessoIcons.forEach(icon => {
            const color = icon.getAttribute('data-color');
            if (color && color.trim() !== '') {
                icon.style.color = color;
            }
        });
    } catch (error) {
        console.error('Erro ao aplicar cores dinamicamente:', error);
    }
}

/**
 * Utilitários
 */

function getUpdateOrderUrl() {
    // Tenta encontrar a URL na página ou usa uma URL padrão
    const metaUrl = document.querySelector('meta[name="update-order-url"]');
    return metaUrl ? metaUrl.getAttribute('content') : '/admin/acesso-rapido/update-order';
}

function showLoadingIndicator() {
    const indicator = document.createElement('div');
    indicator.id = 'loading-indicator';
    indicator.className = 'position-fixed top-50 start-50 translate-middle bg-primary text-white p-3 rounded shadow';
    indicator.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Atualizando ordem...';
    document.body.appendChild(indicator);
}

function hideLoadingIndicator() {
    const indicator = document.getElementById('loading-indicator');
    if (indicator) {
        indicator.remove();
    }
}

function showSuccessMessage(message) {
    showMessage(message, 'success');
}

function showErrorMessage(message) {
    showMessage(message, 'danger');
}

function showMessage(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    // Remove automaticamente após 5 segundos
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

function showTooltip(element, message) {
    const tooltip = document.createElement('div');
    tooltip.className = 'position-absolute bg-dark text-white px-2 py-1 rounded small';
    tooltip.style.cssText = 'z-index: 1000; top: -30px; left: 50%; transform: translateX(-50%);';
    tooltip.textContent = message;
    
    element.style.position = 'relative';
    element.appendChild(tooltip);
    
    setTimeout(() => {
        if (tooltip.parentNode) {
            tooltip.remove();
        }
    }, 2000);
}

function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).catch(err => {
            console.error('Erro ao copiar para clipboard:', err);
        });
    } else {
        // Fallback para navegadores mais antigos
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
        } catch (err) {
            console.error('Erro ao copiar para clipboard:', err);
        }
        document.body.removeChild(textArea);
    }
}