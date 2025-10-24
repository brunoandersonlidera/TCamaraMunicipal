/**
 * E-SIC Show Page JavaScript
 * Funcionalidades para a página de detalhes da solicitação E-SIC
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('E-SIC Show JavaScript carregado');
    
    // Funcionalidade de ordenação do histórico
    initHistoricoOrdenacao();
    
    // Debug: verificar se o modal existe no DOM
    const allModals = document.querySelectorAll('.modal');
    console.log('Todos os modais encontrados:', allModals);
    
    // Elementos do formulário de resposta
    const responderModal = document.getElementById('responderModal');
    console.log('Modal encontrado:', responderModal);
    
    if (!responderModal) {
        console.warn('Modal de resposta não encontrado - provavelmente a solicitação não permite resposta no momento');
        
        // Verificar se existem botões que tentam abrir o modal
        const responderButtons = document.querySelectorAll('[data-bs-target="#responderModal"]');
        if (responderButtons.length > 0) {
            console.error('ERRO: Existem botões tentando abrir o modal, mas o modal não existe!');
            responderButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Erro: Modal de resposta não disponível. Recarregue a página.');
                });
            });
        }
        return;
    }
    
    const responderForm = responderModal.querySelector('form');
    console.log('Formulário encontrado:', responderForm);
    
    const submitButton = responderForm ? responderForm.querySelector('button[type="submit"]') : null;
    
    if (!responderForm) {
        console.error('Formulário de resposta não encontrado dentro do modal');
        return;
    }
    
    console.log('Formulário de resposta encontrado:', {
        formId: responderForm.id,
        formAction: responderForm.action,
        formMethod: responderForm.method
    });
    
    // Event listener para o submit do formulário
    responderForm.addEventListener('submit', function(e) {
        console.log('=== SUBMIT DO FORMULÁRIO DE RESPOSTA ===');
        console.log('Event:', e);
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);
        
        // Validação específica do campo resposta
        const respostaField = this.querySelector('#resposta');
        const respostaValue = respostaField ? respostaField.value.trim() : '';
        
        console.log('Valor do campo resposta:', respostaValue);
        console.log('Tamanho da resposta:', respostaValue.length);
        
        if (!respostaValue || respostaValue.length < 10) {
            e.preventDefault();
            console.error('ERRO: Campo resposta inválido');
            
            // Destacar o campo com erro
            if (respostaField) {
                respostaField.classList.add('is-invalid');
                respostaField.focus();
            }
            
            // Mostrar mensagem de erro específica
            const mensagemErro = respostaValue.length === 0 
                ? 'O campo "Resposta" é obrigatório!' 
                : `O campo "Resposta" deve ter pelo menos 10 caracteres. Você digitou apenas ${respostaValue.length} caracteres.`;
            
            alert('❌ ERRO DE VALIDAÇÃO:\n\n' + mensagemErro + '\n\nPor favor, preencha o campo "Resposta" com uma resposta adequada (mínimo 10 caracteres).');
            return false;
        }
        
        // Verificar se o formulário é válido
        if (!this.checkValidity()) {
            console.log('Formulário inválido - parando submit');
            e.preventDefault();
            this.reportValidity();
            return;
        }
        
        // Coletar dados do formulário
        const formData = new FormData(this);
        const formDataObj = {};
        for (let [key, value] of formData.entries()) {
            formDataObj[key] = value;
        }
        console.log('Dados do formulário:', formDataObj);
        
        // Verificar token CSRF
        const csrfToken = formData.get('_token');
        console.log('CSRF Token:', csrfToken);
        
        if (!csrfToken) {
            console.error('Token CSRF não encontrado!');
            e.preventDefault();
            alert('❌ ERRO: Token CSRF não encontrado.\n\nRecarregue a página e tente novamente.');
            return;
        }
        
        // Confirmar envio
        const confirmacao = confirm('✅ CONFIRMAR ENVIO DA RESPOSTA?\n\n' + 
            `Resposta: ${respostaValue.substring(0, 100)}${respostaValue.length > 100 ? '...' : ''}\n\n` +
            'Tem certeza que deseja enviar esta resposta?');
        
        if (!confirmacao) {
            e.preventDefault();
            console.log('Envio cancelado pelo usuário');
            return false;
        }
        
        // Desabilitar botão de submit para evitar duplo clique
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        }
        
        console.log('✅ Formulário válido - prosseguindo com submit');
        console.log('=== FIM SUBMIT ===');
        
        // Permitir que o formulário seja enviado normalmente
        return true;
    });
    
    // Event listener para quando o modal é aberto
    if (responderModal) {
        responderModal.addEventListener('shown.bs.modal', function() {
            console.log('Modal de resposta aberto');
            
            // Focar no primeiro campo do formulário
            const firstInput = responderForm.querySelector('select, textarea, input');
            if (firstInput) {
                firstInput.focus();
            }
        });
        
        // Event listener para quando o modal é fechado
        responderModal.addEventListener('hidden.bs.modal', function() {
            console.log('Modal de resposta fechado');
            
            // Reabilitar botão de submit
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Resposta';
            }
        });
    }
    
    // Debug: Verificar se há erros de validação
    const invalidFields = responderForm.querySelectorAll(':invalid');
    if (invalidFields.length > 0) {
        console.log('Campos inválidos encontrados:', invalidFields);
    }
    
    // Debug: Verificar todos os campos obrigatórios
    const requiredFields = responderForm.querySelectorAll('[required]');
    console.log('Campos obrigatórios:', requiredFields);
    
    // Event listener para mudanças nos campos
    const formFields = responderForm.querySelectorAll('input, select, textarea');
    formFields.forEach(field => {
        field.addEventListener('change', function() {
            console.log(`Campo ${this.name} alterado para:`, this.value);
        });
    });
    
    // Validação em tempo real para o campo resposta
    const respostaField = responderForm.querySelector('#resposta');
    if (respostaField) {
        // Criar elemento para mostrar contador de caracteres
        const contadorDiv = document.createElement('div');
        contadorDiv.className = 'form-text mt-1';
        contadorDiv.id = 'contador-resposta';
        respostaField.parentNode.appendChild(contadorDiv);
        
        function atualizarContador() {
            const valor = respostaField.value.trim();
            const tamanho = valor.length;
            const minimo = 10;
            
            // Remover classes anteriores
            respostaField.classList.remove('is-valid', 'is-invalid');
            
            if (tamanho === 0) {
                contadorDiv.innerHTML = `<span class="text-muted">Digite sua resposta (mínimo ${minimo} caracteres)</span>`;
            } else if (tamanho < minimo) {
                contadorDiv.innerHTML = `<span class="text-danger">⚠️ ${tamanho}/${minimo} caracteres - Precisa de mais ${minimo - tamanho} caracteres</span>`;
                respostaField.classList.add('is-invalid');
            } else {
                contadorDiv.innerHTML = `<span class="text-success">✅ ${tamanho} caracteres - Resposta válida!</span>`;
                respostaField.classList.add('is-valid');
            }
        }
        
        // Atualizar contador em tempo real
        respostaField.addEventListener('input', atualizarContador);
        respostaField.addEventListener('keyup', atualizarContador);
        respostaField.addEventListener('paste', function() {
            setTimeout(atualizarContador, 10);
        });
        
        // Inicializar contador
        atualizarContador();
    }
});

/**
 * Inicializa a funcionalidade de ordenação do histórico de comunicação
 */
function initHistoricoOrdenacao() {
    const ordenacaoInputs = document.querySelectorAll('input[name="ordenacao"]');
    const historicoContainer = document.getElementById('chatMessages');
    
    if (!historicoContainer || ordenacaoInputs.length === 0) {
        console.log('Elementos de ordenação não encontrados');
        return;
    }
    
    console.log('Inicializando ordenação do histórico');
    
    // Event listeners para os botões de ordenação
    ordenacaoInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                ordenarHistorico(this.value);
            }
        });
    });
    
    /**
     * Ordena o histórico de comunicação
     * @param {string} ordem - 'asc' para crescente, 'desc' para decrescente
     */
    function ordenarHistorico(ordem) {
        const messageItems = Array.from(historicoContainer.querySelectorAll('.message-item'));
        
        if (messageItems.length === 0) {
            console.log('Nenhuma mensagem encontrada para ordenar');
            return;
        }
        
        console.log(`Ordenando histórico: ${ordem}`);
        
        // Ordenar os elementos baseado no timestamp
        messageItems.sort((a, b) => {
            const timestampA = parseInt(a.dataset.timestamp) || 0;
            const timestampB = parseInt(b.dataset.timestamp) || 0;
            
            if (ordem === 'desc') {
                return timestampB - timestampA; // Mais recente primeiro
            } else {
                return timestampA - timestampB; // Mais antigo primeiro
            }
        });
        
        // Criar um fragment para reorganizar os elementos sem removê-los do DOM
        const fragment = document.createDocumentFragment();
        
        // Mover os elementos ordenados para o fragment
        messageItems.forEach(item => {
            fragment.appendChild(item);
        });
        
        // Adicionar todos os elementos ordenados de volta ao container
        historicoContainer.appendChild(fragment);
        
        // Adicionar efeito visual de atualização
        historicoContainer.style.opacity = '0.7';
        setTimeout(() => {
            historicoContainer.style.opacity = '1';
        }, 200);
        
        console.log(`Histórico reordenado com ${messageItems.length} itens`);
    }
}