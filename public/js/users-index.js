// Funcionalidades para gerenciamento de usuários (index)
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de status
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const isActive = this.checked;
            
            fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualizar label
                    const label = this.nextElementSibling;
                    label.textContent = data.active ? 'Ativo' : 'Inativo';
                    
                    // Mostrar mensagem de sucesso
                    showAlert('success', data.message);
                } else {
                    // Reverter o toggle
                    this.checked = !isActive;
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                // Reverter o toggle
                this.checked = !isActive;
                showAlert('error', 'Erro ao alterar status do usuário');
            });
        });
    });

    // Toggle de permissões
    document.querySelectorAll('.permission-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const permission = this.dataset.permission;
            const isEnabled = this.checked;
            
            fetch(`/admin/users/${userId}/toggle-permission`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    permission: permission,
                    enabled: isEnabled
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                } else {
                    // Reverter o toggle
                    this.checked = !isEnabled;
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                // Reverter o toggle
                this.checked = !isEnabled;
                showAlert('error', 'Erro ao alterar permissão do usuário');
            });
        });
    });

    // Modal de exclusão
    document.querySelectorAll('.delete-user').forEach(function(button) {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

// Função para verificar cidadão
function verificarCidadao(userId) {
    if (confirm('Tem certeza que deseja aprovar a verificação deste cidadão?')) {
        fetch(`/admin/users/${userId}/verificar`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                // Recarregar a página para atualizar a interface
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Erro ao verificar cidadão');
        });
    }
}

// Função para rejeitar cidadão
function rejeitarCidadao(userId) {
    const motivo = prompt('Informe o motivo da rejeição (opcional):');
    if (motivo !== null) { // null significa que o usuário cancelou
        fetch(`/admin/users/${userId}/rejeitar`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                motivo: motivo
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                // Recarregar a página para atualizar a interface
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Erro ao rejeitar cidadão');
        });
    }
}

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