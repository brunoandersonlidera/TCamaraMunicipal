/**
 * E-SIC Form JavaScript - Versão Simplificada
 * Funcionalidades básicas para o formulário de solicitação E-SIC
 */

document.addEventListener('DOMContentLoaded', function() {
    // Função para logs (temporariamente apenas console)
    function logToFile(message, data = null) {
        console.log(message, data);
    }
    
    logToFile('🚀 E-SIC Form JavaScript carregado');
    
    // Elementos do formulário
    const form = document.getElementById('esicForm');
    const formaRecebimento = document.querySelectorAll('input[name="forma_recebimento"]');
    const enderecoSection = document.getElementById('endereco_section');
    const enderecoField = document.getElementById('endereco_solicitante');
    const cpfField = document.getElementById('cpf_solicitante');
    const telefoneField = document.getElementById('telefone_solicitante');
    const descricaoField = document.getElementById('descricao');
    const aceiteTernosField = document.getElementById('aceita_termos');

    // Verificar se o formulário existe
    if (!form) {
        logToFile('❌ Formulário E-SIC não encontrado!');
        return;
    }

    logToFile('✅ Formulário encontrado', {formId: form.id, formAction: form.action});

    // DEBUG: Adicionar múltiplos listeners para capturar todos os eventos
    logToFile('DEBUG: Adicionando listeners de debug...');
    
    // Override preventDefault para detectar quem está cancelando
    const originalPreventDefault = Event.prototype.preventDefault;
    Event.prototype.preventDefault = function() {
        if (this.type === 'submit' && this.target === form) {
            logToFile('🚨 ALERTA: preventDefault() foi chamado no formulário!', {
                stackTrace: new Error().stack
            });
        }
        return originalPreventDefault.call(this);
    };
    
    // Listener para submit (com prioridade máxima)
    form.addEventListener('submit', function(e) {
        logToFile('=== DEBUG SUBMIT EVENT ===');
        logToFile('Event details', {
            type: e.type,
            target: e.target.tagName,
            defaultPrevented: e.defaultPrevented,
            formAction: form.action,
            formMethod: form.method,
            formEnctype: form.enctype
        });
        
        // Verificar dados do formulário
        const formData = new FormData(form);
        const formDataObj = {};
        for (let [key, value] of formData.entries()) {
            formDataObj[key] = value;
        }
        logToFile('Form data entries', formDataObj);
        
        // Verificar campos obrigatórios
        const requiredFields = form.querySelectorAll('[required]');
        let hasErrors = false;
        const requiredFieldsStatus = {};
        
        requiredFields.forEach(field => {
            const isEmpty = !field.value.trim();
            requiredFieldsStatus[field.name || field.id] = {
                isEmpty: isEmpty,
                value: field.value
            };
            if (isEmpty) hasErrors = true;
        });
        
        logToFile('Checking required fields', requiredFieldsStatus);
        logToFile('Has validation errors', hasErrors);
        
        // Verificar validação HTML5
        const isValidHTML5 = form.checkValidity();
        logToFile('HTML5 validation passed', isValidHTML5);
        
        if (!isValidHTML5) {
            const invalidFields = form.querySelectorAll(':invalid');
            const invalidFieldsData = {};
            invalidFields.forEach(field => {
                invalidFieldsData[field.name || field.id] = field.validationMessage;
            });
            logToFile('HTML5 validation errors', invalidFieldsData);
        }
        
        // Verificar se o evento será cancelado
        if (e.defaultPrevented) {
            logToFile('ATENÇÃO: Submit foi cancelado por preventDefault()');
        } else {
            logToFile('Submit deve prosseguir normalmente');
        }
        
        // Forçar submissão se não houver erros
        if (!hasErrors && isValidHTML5 && !e.defaultPrevented) {
            logToFile('🚀 Tentando forçar submissão...');
            // Não fazer preventDefault aqui para deixar o submit natural acontecer
        }
        
        logToFile('=== FIM DEBUG SUBMIT ===');
    }, true); // Usar capture para pegar antes de outros listeners
    
    // Listener adicional para capturar se alguém está cancelando
    form.addEventListener('submit', function(e) {
        logToFile('DEBUG: Submit listener secundário', {defaultPrevented: e.defaultPrevented});
    }, false);
    
    // Debug para botão de submit
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        logToFile('DEBUG: Submit button encontrado', {
            id: submitButton.id,
            type: submitButton.type,
            disabled: submitButton.disabled
        });
        
        submitButton.addEventListener('click', function(e) {
            logToFile('=== DEBUG BUTTON CLICK ===', {
                target: e.target.tagName,
                type: e.target.type,
                disabled: e.target.disabled,
                defaultPrevented: e.defaultPrevented
            });
        });
    } else {
        logToFile('DEBUG: Submit button NÃO encontrado!');
    }
    
    // Debug para todos os inputs
    const allInputs = form.querySelectorAll('input, select, textarea');
    logToFile(`DEBUG: Total de campos encontrados: ${allInputs.length}`);
    
    // Adicionar listener para beforeunload para ver se a página está sendo recarregada
    window.addEventListener('beforeunload', function(e) {
        logToFile('DEBUG: Página sendo descarregada/recarregada');
    });

    // Inicialização
    init();

    function init() {
        setupFormaRecebimento();
        setupMasks();
        setupValidation();
        setupCharacterCount();
        
        // Log para debug
        console.log('Inicialização completa');
    }

    /**
     * Configurar forma de recebimento
     */
    function setupFormaRecebimento() {
        if (formaRecebimento.length > 0) {
            formaRecebimento.forEach(radio => {
                radio.addEventListener('change', toggleEnderecoSection);
            });
            
            // Verificar estado inicial
            toggleEnderecoSection();
        }
    }

    function toggleEnderecoSection() {
        const selectedValue = document.querySelector('input[name="forma_recebimento"]:checked')?.value;
        
        if (enderecoSection && enderecoField) {
            if (selectedValue === 'correio') {
                enderecoSection.style.display = 'block';
                enderecoField.required = true;
            } else {
                enderecoSection.style.display = 'none';
                enderecoField.required = false;
                enderecoField.value = '';
            }
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
                if (this.value) {
                    validateCPF(this);
                }
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

    /**
     * Configurar contador de caracteres
     */
    function setupCharacterCount() {
        if (descricaoField) {
            const maxLength = descricaoField.getAttribute('maxlength') || 2000;
            const counter = document.createElement('div');
            counter.className = 'character-counter text-muted small mt-1';
            counter.textContent = `0/${maxLength} caracteres`;
            
            descricaoField.parentNode.appendChild(counter);
            
            descricaoField.addEventListener('input', function() {
                const currentLength = this.value.length;
                counter.textContent = `${currentLength}/${maxLength} caracteres`;
                
                if (currentLength > maxLength * 0.9) {
                    counter.classList.add('text-warning');
                } else {
                    counter.classList.remove('text-warning');
                }
                
                if (currentLength >= maxLength) {
                    counter.classList.add('text-danger');
                } else {
                    counter.classList.remove('text-danger');
                }
            });
        }
    }

    /**
     * Funções de validação
     */
    function validateRequired(field) {
        const isValid = field.value.trim() !== '';
        toggleFieldError(field, isValid, 'Este campo é obrigatório.');
        return isValid;
    }

    function validateEmail(field) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValid = emailRegex.test(field.value);
        toggleFieldError(field, isValid, 'Por favor, insira um email válido.');
        return isValid;
    }

    function validateCPF(field) {
        const cpf = field.value.replace(/\D/g, '');
        const isValid = isValidCPF(cpf);
        toggleFieldError(field, isValid, 'Por favor, insira um CPF válido.');
        return isValid;
    }

    function isValidCPF(cpf) {
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
            return false;
        }

        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        return remainder === parseInt(cpf.charAt(10));
    }

    function toggleFieldError(field, isValid, message) {
        const errorElement = field.parentNode.querySelector('.invalid-feedback');
        
        if (isValid) {
            field.classList.remove('is-invalid');
            if (errorElement) {
                errorElement.remove();
            }
        } else {
            field.classList.add('is-invalid');
            if (!errorElement) {
                showFieldError(field, message);
            }
        }
    }

    function showFieldError(field, message) {
        // Remove erro anterior se existir
        const existingError = field.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }

        // Criar elemento de erro
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        
        // Inserir após o campo
        field.parentNode.appendChild(errorDiv);
        field.classList.add('is-invalid');
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

    // SISTEMA DE RASCUNHO DESABILITADO TEMPORARIAMENTE
    // Para evitar interferência na submissão do formulário
    
    /*
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
        localStorage.removeItem('esic_form_draft');
    });
    */
});