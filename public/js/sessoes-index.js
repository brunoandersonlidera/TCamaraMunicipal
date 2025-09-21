// Sessões Index JavaScript Functions

// Toggle de visualização
function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const tableBtn = document.getElementById('tableViewBtn');
    const cardsBtn = document.getElementById('cardsViewBtn');
    
    if (view === 'table') {
        tableView.style.display = 'block';
        cardsView.style.display = 'none';
        tableBtn.classList.add('active');
        cardsBtn.classList.remove('active');
        localStorage.setItem('sessoes_view', 'table');
    } else {
        tableView.style.display = 'none';
        cardsView.style.display = 'block';
        tableBtn.classList.remove('active');
        cardsBtn.classList.add('active');
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