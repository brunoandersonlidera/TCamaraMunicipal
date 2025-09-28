// Sessões Index JavaScript Functions

// Toggle de visualização
function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const tableBtn = document.getElementById('tableViewBtn');
    const cardsBtn = document.getElementById('cardsViewBtn');
    
    // Verificar se os elementos existem antes de manipulá-los
    if (!tableView || !cardsView || !tableBtn || !cardsBtn) {
        console.warn('Elementos de visualização não encontrados');
        return;
    }
    
    if (view === 'table') {
        tableView.style.display = 'block';
        cardsView.style.display = 'none';
        
        // Verificação de segurança para classList
        if (tableBtn && tableBtn.classList) {
            try {
                tableBtn.classList.add('active');
            } catch (error) {
                console.warn('Erro ao adicionar classe active ao tableBtn:', error);
            }
        }
        
        if (cardsBtn && cardsBtn.classList) {
            try {
                cardsBtn.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do cardsBtn:', error);
            }
        }
        
        localStorage.setItem('sessoes_view', 'table');
    } else {
        tableView.style.display = 'none';
        cardsView.style.display = 'block';
        
        // Verificação de segurança para classList
        if (tableBtn && tableBtn.classList) {
            try {
                tableBtn.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do tableBtn:', error);
            }
        }
        
        if (cardsBtn && cardsBtn.classList) {
            try {
                cardsBtn.classList.add('active');
            } catch (error) {
                console.warn('Erro ao adicionar classe active ao cardsBtn:', error);
            }
        }
        
        localStorage.setItem('sessoes_view', 'cards');
    }
}

// Função para mostrar alertas
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.querySelector('.container-fluid');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-remover após 5 segundos
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Restaurar visualização salva
    const savedView = localStorage.getItem('sessoes_view') || 'cards';
    toggleView(savedView);

    // Modal de exclusão
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const sessaoId = this.dataset.id;
            const sessaoNumero = this.dataset.numero;
            
            document.getElementById('sessaoTitulo').textContent = `Sessão ${sessaoNumero}`;
            document.getElementById('deleteForm').action = `/admin/sessoes/${sessaoId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

// Export functions globally
window.toggleView = toggleView;
window.showAlert = showAlert;