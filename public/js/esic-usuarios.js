/**
 * Funções para gerenciamento de usuários ESIC
 */

// Função para alternar status do usuário
function toggleStatus(userId) {
    if (confirm('Tem certeza que deseja alterar o status deste usuário?')) {
        fetch(`/admin/esic-usuarios/${userId}/toggle-status`, {
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
                alert('Erro ao alterar status do usuário');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao alterar status do usuário');
        });
    }
}

// Função para reenviar verificação de email
function resendVerification(userId) {
    if (confirm('Deseja reenviar o email de verificação para este usuário?')) {
        fetch(`/admin/esic-usuarios/${userId}/resend-verification`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email de verificação reenviado com sucesso!');
            } else {
                alert('Erro ao reenviar email de verificação');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao reenviar email de verificação');
        });
    }
}

// Função para excluir usuário
function deleteUser(userId) {
    if (confirm('ATENÇÃO: Esta ação não pode ser desfeita. Tem certeza que deseja excluir este usuário?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/esic-usuarios/${userId}`;
        
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

// Event listeners para botões com data attributes
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar event listeners para todos os botões com data-action
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
            case 'resend-verification':
                resendVerification(userId);
                break;
            case 'delete-user':
                deleteUser(userId);
                break;
        }
    });
});

// Manter funções globalmente disponíveis para compatibilidade
window.toggleStatus = toggleStatus;
window.resendVerification = resendVerification;
window.deleteUser = deleteUser;