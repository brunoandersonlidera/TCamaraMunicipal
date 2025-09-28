/**
 * Funções para gerenciamento de usuários
 */

document.addEventListener('DOMContentLoaded', function() {
    // Toggle de senha
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                if (icon && icon.classList) {
                    try {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } catch (error) {
                        console.warn('Erro ao alterar ícone de senha:', error);
                    }
                }
            } else {
                passwordField.type = 'password';
                if (icon && icon.classList) {
                    try {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } catch (error) {
                        console.warn('Erro ao alterar ícone de senha:', error);
                    }
                }
            }
        });
    }

    // Máscara para CPF
    const cpfField = document.getElementById('cpf');
    if (cpfField) {
        cpfField.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            this.value = value;
        });
    }

    // Máscara para telefone
    const telefoneField = document.getElementById('telefone');
    if (telefoneField) {
        telefoneField.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            this.value = value;
        });
    }

    // Contador de caracteres para observações
    const observacoesField = document.getElementById('observacoes');
    const observacoesCount = document.getElementById('observacoesCount');
    
    if (observacoesField && observacoesCount) {
        function updateObservacoesCount() {
            const count = observacoesField.value.length;
            observacoesCount.textContent = count;
            
            if (count > 1000) {
                observacoesCount.style.color = '#dc3545';
            } else {
                observacoesCount.style.color = '#6c757d';
            }
        }
        
        observacoesField.addEventListener('input', updateObservacoesCount);
        updateObservacoesCount(); // Inicializar
    }

    // Validação de confirmação de senha
    const passwordConfirmation = document.getElementById('password_confirmation');
    const password = document.getElementById('password');
    
    if (passwordConfirmation && password) {
        function validatePasswordConfirmation() {
            if (passwordConfirmation.value && password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('As senhas não coincidem');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        }
        
        password.addEventListener('input', validatePasswordConfirmation);
        passwordConfirmation.addEventListener('input', validatePasswordConfirmation);
    }

    // Validação do formulário
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    if (field && field.classList) {
                        try {
                            field.classList.add('is-invalid');
                        } catch (error) {
                            console.warn('Erro ao adicionar classe de validação:', error);
                        }
                    }
                    isValid = false;
                } else {
                    if (field && field.classList) {
                        try {
                            field.classList.remove('is-invalid');
                        } catch (error) {
                            console.warn('Erro ao remover classe de validação:', error);
                        }
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios.');
            }
        });
    }

    // Toggle de status (para show.blade.php)
    const statusToggle = document.querySelector('.status-toggle');
    if (statusToggle) {
        statusToggle.addEventListener('change', function() {
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
                    
                    // Recarregar página após 2 segundos para atualizar badges
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
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
    }

    // Modal de exclusão (para show.blade.php)
    const deleteButton = document.querySelector('.delete-user');
    if (deleteButton) {
        deleteButton.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    }
});

// Função para mostrar alertas (para show.blade.php)
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

// Export functions globally
window.showAlert = showAlert;