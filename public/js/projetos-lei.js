/**
 * Funções para gerenciamento de projetos de lei
 */

document.addEventListener('DOMContentLoaded', function() {
    // Atualizar coautores quando autor principal mudar
    const autorSelect = document.getElementById('autor_id');
    const coautoresCheckboxes = document.querySelectorAll('input[name="vereadores[]"]');
    
    if (autorSelect) {
        autorSelect.addEventListener('change', function() {
            const autorId = this.value;
            
            coautoresCheckboxes.forEach(checkbox => {
                if (checkbox.value === autorId) {
                    checkbox.checked = false;
                    checkbox.disabled = true;
                } else {
                    checkbox.disabled = false;
                }
            });
        });
        
        // Trigger inicial
        if (autorSelect.value) {
            autorSelect.dispatchEvent(new Event('change'));
        }
    }
    
    // Validação do formulário
    const form = document.getElementById('projetoForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const titulo = document.getElementById('titulo').value.trim();
            const ementa = document.getElementById('ementa').value.trim();
            const autorId = document.getElementById('autor_id').value;
            
            if (!titulo || !ementa || !autorId) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios.');
                return false;
            }
        });
    }
    
    // Habilitar/desabilitar campos baseado no status
    const statusSelect = document.getElementById('status');
    const dataAprovacao = document.getElementById('data_aprovacao');
    const numeroLei = document.getElementById('numero_lei');
    const arquivoLei = document.getElementById('arquivo_lei');
    
    function toggleAprovacaoFields() {
        const isAprovado = statusSelect.value === 'aprovado';
        
        if (isAprovado) {
            dataAprovacao.removeAttribute('disabled');
            numeroLei.removeAttribute('disabled');
            arquivoLei.removeAttribute('disabled');
        } else {
            dataAprovacao.value = '';
            numeroLei.value = '';
            dataAprovacao.setAttribute('disabled', 'disabled');
            numeroLei.setAttribute('disabled', 'disabled');
            arquivoLei.setAttribute('disabled', 'disabled');
        }
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', toggleAprovacaoFields);
        toggleAprovacaoFields(); // Trigger inicial
    }

    // Restaurar visualização salva (para index)
    const savedView = localStorage.getItem('projetos_view') || 'table';
    if (typeof toggleView === 'function') {
        toggleView(savedView);
    }
});

// Funções para o index
function confirmDelete(projetoId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/projetos-lei/${projetoId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const tableBtn = document.getElementById('viewTable');
    const cardsBtn = document.getElementById('viewCards');
    
    // Verificar se os elementos existem antes de manipulá-los
    if (!tableView || !cardsView || !tableBtn || !cardsBtn) {
        console.warn('Elementos de visualização não encontrados');
        return;
    }
    
    if (view === 'table') {
        tableView.style.display = 'block';
        cardsView.style.display = 'none';
        tableBtn.classList.add('active');
        cardsBtn.classList.remove('active');
        localStorage.setItem('projetos_view', 'table');
    } else {
        tableView.style.display = 'none';
        cardsView.style.display = 'block';
        tableBtn.classList.remove('active');
        cardsBtn.classList.add('active');
        localStorage.setItem('projetos_view', 'cards');
    }
}

// Export functions globally
window.confirmDelete = confirmDelete;
window.toggleView = toggleView;