// JavaScript para listagem de Cartas de Serviço

// Auto-submit do formulário de filtros
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#filterForm select').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Event listeners para botões com data-action
    document.addEventListener('click', function(e) {
        const button = e.target.closest('[data-action]');
        if (!button) return;

        const action = button.getAttribute('data-action');
        const serviceId = button.getAttribute('data-service-id');

        if (action === 'toggle-status') {
            toggleStatus(serviceId);
        } else if (action === 'delete-service') {
            deleteService(serviceId);
        }
    });
});

// Função para alterar status
function toggleStatus(serviceId) {
    if (confirm('Tem certeza que deseja alterar o status deste serviço?')) {
        fetch(`/admin/cartas-servico/${serviceId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao alterar status do serviço');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao alterar status do serviço');
        });
    }
}

// Função para excluir serviço
function deleteService(serviceId) {
    if (confirm('ATENÇÃO: Esta ação não pode ser desfeita. Tem certeza que deseja excluir este serviço?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/cartas-servico/${serviceId}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}