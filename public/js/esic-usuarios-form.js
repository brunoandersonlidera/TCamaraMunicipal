// Funcionalidades para formulário de usuários ESIC
$(document).ready(function() {
    // Máscaras
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 00000-0000');
    $('#cep').mask('00000-000');

    // Buscar endereço pelo CEP
    $('#cep').on('blur', function() {
        const cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            buscarCep(cep);
        }
    });

    // Validação de força da senha
    $('#password').on('input', function() {
        const password = $(this).val();
        const strength = checkPasswordStrength(password);
        updatePasswordStrength(strength);
    });

    // Validação de confirmação de senha
    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmation = $(this).val();
        
        if (confirmation && password !== confirmation) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Event listeners para botões com data-action
    $(document).on('click', '[data-action]', function(e) {
        e.preventDefault();
        
        const action = $(this).data('action');
        const route = $(this).data('route');
        
        if (!route) return;
        
        switch(action) {
            case 'reset-password':
                resetPassword(route);
                break;
            case 'delete-user':
                deleteUser(route);
                break;
        }
    });
});

function buscarCep(cep) {
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                $('#endereco').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.localidade);
                $('#numero').focus();
            }
        })
        .catch(error => console.error('Erro ao buscar CEP:', error));
}

function checkPasswordStrength(password) {
    let score = 0;
    
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    return score;
}

function updatePasswordStrength(score) {
    const strengthBar = $('#passwordStrength');
    
    if (score < 3) {
        strengthBar.removeClass().addClass('password-strength strength-weak');
        strengthBar.css('width', '33%');
    } else if (score < 5) {
        strengthBar.removeClass().addClass('password-strength strength-medium');
        strengthBar.css('width', '66%');
    } else {
        strengthBar.removeClass().addClass('password-strength strength-strong');
        strengthBar.css('width', '100%');
    }
}

function resetPassword(resetPasswordRoute) {
    if (confirm('Tem certeza que deseja redefinir a senha deste usuário? Uma nova senha será enviada por e-mail.')) {
        fetch(resetPasswordRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Nova senha enviada por e-mail com sucesso!');
            } else {
                alert('Erro ao redefinir senha');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao redefinir senha');
        });
    }
}

function deleteUser(destroyRoute) {
    if (confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = destroyRoute;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}