// Solicitações Index JavaScript Functions

// Controle de visualização
function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const btnTable = document.getElementById('btnTable');
    const btnCards = document.getElementById('btnCards');

    // Verificar se os elementos existem antes de manipulá-los
    if (!tableView || !cardsView || !btnTable || !btnCards) {
        console.warn('Elementos de visualização não encontrados');
        return;
    }

    if (view === 'table') {
        tableView.style.display = 'block';
        cardsView.style.display = 'none';
        
        // Verificação de segurança para classList
        if (btnTable && btnTable.classList) {
            try {
                btnTable.classList.add('active');
            } catch (error) {
                console.warn('Erro ao adicionar classe active ao btnTable:', error);
            }
        }
        
        if (btnCards && btnCards.classList) {
            try {
                btnCards.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do btnCards:', error);
            }
        }
        
        localStorage.setItem('solicitacoes_view', 'table');
    } else {
        tableView.style.display = 'none';
        cardsView.style.display = 'block';
        
        // Verificação de segurança para classList
        if (btnCards && btnCards.classList) {
            try {
                btnCards.classList.add('active');
            } catch (error) {
                console.warn('Erro ao adicionar classe active ao btnCards:', error);
            }
        }
        
        if (btnTable && btnTable.classList) {
            try {
                btnTable.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do btnTable:', error);
            }
        }
        
        localStorage.setItem('solicitacoes_view', 'cards');
    }
}

// Confirmação de exclusão
function confirmDelete(id) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/solicitacoes/${id}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Atualizar estatísticas
function atualizarEstatisticas() {
    // Recarregar a página para atualizar as estatísticas
    window.location.reload();
}

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Restaurar visualização salva
    const savedView = localStorage.getItem('solicitacoes_view') || 'table';
    toggleView(savedView);

    // Auto-submit do formulário de filtros
    const statusSelect = document.getElementById('status');
    const tipoSelect = document.getElementById('tipo');
    const filtrosForm = document.getElementById('filtrosForm');

    if (statusSelect && filtrosForm) {
        statusSelect.addEventListener('change', function() {
            filtrosForm.submit();
        });
    }

    if (tipoSelect && filtrosForm) {
        tipoSelect.addEventListener('change', function() {
            filtrosForm.submit();
        });
    }
});

// Export functions globally
window.toggleView = toggleView;
window.confirmDelete = confirmDelete;
window.atualizarEstatisticas = atualizarEstatisticas;