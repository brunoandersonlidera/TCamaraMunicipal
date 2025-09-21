/**
 * E-SIC Form JavaScript
 * Funcionalidades para o formulário de solicitação E-SIC
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elementos do formulário
    const form = document.getElementById('esicForm');
    const formaRecebimento = document.querySelectorAll('input[name="forma_recebimento"]');
    const enderecoSection = document.getElementById('endereco_section');
    const enderecoField = document.getElementById('endereco_solicitante');
    const cpfField = document.getElementById('cpf_solicitante');
    const telefoneField = document.getElementById('telefone_solicitante');
    const descricaoField = document.getElementById('descricao');
    const aceiteTernosField = document.getElementById('aceite_termos');

    // Inicialização
    init();

    function init() {
        setupFormaRecebimento();
        setupMasks();
        setupValidation();
        setupCharacterCount();
        setupFormSubmission();
    }

    /**
     * Configurar forma de recebimento
     */
    function setupFormaRecebimento() {
        formaRecebimento.forEach(radio => {
            radio.addEventListener('change', function() {
                toggleEnderecoSection();
            });
        });

        // Verificar estado inicial
        toggleEnderecoSection();
    }

    function toggleEnderecoSection() {
        const selectedValue = document.querySelector('input[name="forma_recebimento"]:checked')?.value;
        
        if (selectedValue === 'correio') {
            enderecoSection.style.display = 'block';
            enderecoField.required = true;
            
            // Animação suave
            enderecoSection.style.opacity = '0';
            setTimeout(() => {
                enderecoSection.style.transition = 'opacity 0.3s ease';
                enderecoSection.style.opacity = '1';
            }, 10);
        } else {
            enderecoSection.style.display = 'none';
            enderecoField.required = false;
            enderecoField.value = '';
        }
    }

    /**
     * Configurar máscaras de entrada
     */
    function setupMasks() {
        // Máscara para CPF
        if (cpfField) {
            cpfField.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            });
        }

        // Máscara para telefone
        if (telefoneField) {
            telefoneField.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                
                e.target.value = value;
            });
        }
    }

    /**
     * Configurar validação em tempo real
     */
    function setupValidation() {
        // Validação de email
        const emailField = document.getElementById('email_solicitante');
        if (emailField) {
            emailField.addEventListener('blur', function() {
                validateEmail(this);
            });
        }

        // Validação de CPF
        if (cpfField) {
            cpfField.addEventListener('blur', function() {
                validateCPF(this);
            });
        }

        // Validação de campos obrigatórios
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                validateRequired(this);
            });
        });
    }

    function validateEmail(field) {
        const email = field.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            showFieldError(field, 'Por favor, insira um e-mail válido.');
            return false;
        } else {
            clearFieldError(field);
            return true;
        }
    }

    function validateCPF(field) {
        const cpf = field.value.replace(/\D/g, '');
        
        if (cpf && !isValidCPF(cpf)) {
            showFieldError(field, 'CPF inválido.');
            return false;
        } else {
            clearFieldError(field);
            return true;
        }
    }

    function validateRequired(field) {
        if (!field.value.trim()) {
            showFieldError(field, 'Este campo é obrigatório.');
            return false;
        } else {
            clearFieldError(field);
            return true;
        }
    }

    function isValidCPF(cpf) {
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
            return false;
        }

        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let remainder = 11 - (sum % 11);
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        remainder = 11 - (sum % 11);
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(10))) return false;

        return true;
    }

    function showFieldError(field, message) {
        clearFieldError(field);
        
        field.classList.add('is-invalid');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }

    function clearFieldError(field) {
        field.classList.remove('is-invalid');
        
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    /**
     * Configurar contador de caracteres
     */
    function setupCharacterCount() {
        if (descricaoField) {
            const maxLength = 2000;
            const counterDiv = document.createElement('div');
            counterDiv.className = 'character-counter text-muted small mt-1';
            descricaoField.parentNode.appendChild(counterDiv);

            function updateCounter() {
                const currentLength = descricaoField.value.length;
                const remaining = maxLength - currentLength;
                
                counterDiv.textContent = `${currentLength}/${maxLength} caracteres`;
                
                if (remaining < 100) {
                    counterDiv.classList.add('text-warning');
                    counterDiv.classList.remove('text-muted');
                } else {
                    counterDiv.classList.add('text-muted');
                    counterDiv.classList.remove('text-warning');
                }
            }

            descricaoField.addEventListener('input', updateCounter);
            updateCounter();
        }
    }

    /**
     * Configurar submissão do formulário
     */
    function setupFormSubmission() {
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    showFormErrors();
                } else {
                    showSubmissionLoader();
                }
            });
        }
    }

    function validateForm() {
        let isValid = true;
        
        // Validar campos obrigatórios
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!validateRequired(field)) {
                isValid = false;
            }
        });

        // Validar email
        const emailField = document.getElementById('email_solicitante');
        if (emailField && !validateEmail(emailField)) {
            isValid = false;
        }

        // Validar CPF se preenchido
        if (cpfField && cpfField.value && !validateCPF(cpfField)) {
            isValid = false;
        }

        // Validar aceite de termos
        if (aceiteTernosField && !aceiteTernosField.checked) {
            showFieldError(aceiteTernosField, 'Você deve aceitar os termos de uso.');
            isValid = false;
        }

        return isValid;
    }

    function showFormErrors() {
        // Scroll para o primeiro erro
        const firstError = form.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            firstError.focus();
        }

        // Mostrar alerta geral
        showAlert('Por favor, corrija os erros no formulário antes de continuar.', 'danger');
    }

    function showSubmissionLoader() {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
        }
    }

    function showAlert(message, type = 'info') {
        // Remove alertas existentes
        const existingAlerts = document.querySelectorAll('.dynamic-alert');
        existingAlerts.forEach(alert => alert.remove());

        // Cria novo alerta
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show dynamic-alert`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insere no topo do formulário
        form.insertBefore(alertDiv, form.firstChild);

        // Auto-remove após 5 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    /**
     * Utilitários
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Salvar rascunho automaticamente
    const saveFormData = debounce(function() {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        localStorage.setItem('esic_form_draft', JSON.stringify(data));
    }, 2000);

    // Restaurar rascunho
    function restoreFormData() {
        const savedData = localStorage.getItem('esic_form_draft');
        if (savedData) {
            try {
                const data = JSON.parse(savedData);
                
                Object.keys(data).forEach(key => {
                    const field = form.querySelector(`[name="${key}"]`);
                    if (field) {
                        if (field.type === 'radio' || field.type === 'checkbox') {
                            if (field.value === data[key]) {
                                field.checked = true;
                            }
                        } else {
                            field.value = data[key];
                        }
                    }
                });

                // Atualizar estado da forma de recebimento
                toggleEnderecoSection();
                
                showAlert('Rascunho restaurado automaticamente.', 'info');
            } catch (e) {
                console.error('Erro ao restaurar rascunho:', e);
            }
        }
    }

    // Configurar salvamento automático
    const formFields = form.querySelectorAll('input, select, textarea');
    formFields.forEach(field => {
        field.addEventListener('input', saveFormData);
        field.addEventListener('change', saveFormData);
    });

    // Restaurar dados ao carregar
    restoreFormData();

    // Limpar rascunho ao enviar com sucesso
    form.addEventListener('submit', function() {
        if (validateForm()) {
            localStorage.removeItem('esic_form_draft');
        }
    });
});