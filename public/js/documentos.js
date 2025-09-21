// Funcionalidades para gerenciamento de documentos
let currentView = 'table';

function toggleView() {
    const tableView = document.getElementById('tableView');
    const cardView = document.getElementById('cardView');
    const viewIcon = document.getElementById('viewIcon');
    const viewText = document.getElementById('viewText');

    if (currentView === 'table') {
        tableView.style.display = 'none';
        cardView.style.display = 'flex';
        viewIcon.className = 'fas fa-table me-2';
        viewText.textContent = 'Tabela';
        currentView = 'card';
    } else {
        tableView.style.display = 'block';
        cardView.style.display = 'none';
        viewIcon.className = 'fas fa-th-list me-2';
        viewText.textContent = 'Cards';
        currentView = 'table';
    }
}

function confirmDelete(id, nome) {
    document.getElementById('documentoNome').textContent = nome;
    document.getElementById('deleteForm').action = `/admin/documentos/${id}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Auto-submit do formulário de filtros quando os selects mudarem
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('#filtrosForm select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filtrosForm').submit();
        });
    });

    // Event listeners para botões de delete
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');
            confirmDelete(id, nome);
        });
    });
});