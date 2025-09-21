// Funcionalidades para gerenciamento de usuários ESIC (index)
function toggleStatus(userId) {
    if (confirm('Tem certeza que deseja alterar o status deste usuário?')) {
        fetch(`/admin/esic-usuarios/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao alterar status do usuário');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao alterar status do usuário');
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit do formulário de filtros quando mudar o status
    const statusSelect = document.getElementById('status');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Event listeners para botões com data-action
    document.addEventListener('click', function(e) {
        const button = e.target.closest('[data-action]');
        if (!button) return;
        
        const action = button.getAttribute('data-action');
        const userId = button.getAttribute('data-user-id');
        
        if (!userId) return;
        
        switch(action) {
            case 'toggle-status':
                toggleStatus(userId);
                break;
        }
    });
});