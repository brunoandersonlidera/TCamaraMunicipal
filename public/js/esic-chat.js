/**
 * E-SIC Chat System JavaScript
 * Funcionalidades para o sistema de mensagens/chat do E-SIC
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('E-SIC Chat JavaScript carregado');
    
    // Elementos principais
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const mensagemTextarea = document.getElementById('mensagem');
    const anexosInput = document.getElementById('anexos');
    const canalSelect = document.getElementById('canal_comunicacao');
    
    // Inicializar funcionalidades
    initAutoScroll();
    initFormValidation();
    initFileUpload();
    initAttachButton();
    initAutoRefresh();
    initTextareaAutoResize();
    initCharacterCounter();
    
    /**
     * Auto-scroll para a última mensagem
     */
    function initAutoScroll() {
        if (chatMessages) {
            // Scroll para o final ao carregar a página
            scrollToBottom();
            
            // Observer para novas mensagens
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        scrollToBottom();
                    }
                });
            });
            
            observer.observe(chatMessages, {
                childList: true,
                subtree: true
            });
        }
    }
    
    /**
     * Scroll suave para o final das mensagens
     */
    function scrollToBottom() {
        if (chatMessages) {
            setTimeout(() => {
                chatMessages.scrollTo({
                    top: chatMessages.scrollHeight,
                    behavior: 'smooth'
                });
            }, 100);
        }
    }
    
    /**
     * Validação do formulário de chat
     */
    function initFormValidation() {
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                const mensagem = mensagemTextarea.value.trim();
                
                if (!mensagem) {
                    e.preventDefault();
                    showAlert('Por favor, digite uma mensagem antes de enviar.', 'warning');
                    mensagemTextarea.focus();
                    return false;
                }
                
                if (mensagem.length > 5000) {
                    e.preventDefault();
                    showAlert('A mensagem não pode ter mais de 5000 caracteres.', 'warning');
                    mensagemTextarea.focus();
                    return false;
                }
                
                // Validar anexos
                if (anexosInput && anexosInput.files.length > 0) {
                    if (!validateFiles()) {
                        e.preventDefault();
                        return false;
                    }
                }
                
                // Mostrar loading e permitir envio normal do formulário
                showLoading();
                // Não fazer preventDefault aqui - deixar o formulário ser enviado normalmente
                return true;
            });
        }
    }
    
    /**
     * Validação de upload de arquivos
     */
    function initFileUpload() {
        if (anexosInput) {
            anexosInput.addEventListener('change', function() {
                console.log('Arquivos selecionados:', anexosInput.files.length);
                if (validateFiles()) {
                    updateFileList();
                }
            });
        }
    }
    
    /**
     * Inicialização do botão de anexar (removido - agora usa input visível)
     */
    function initAttachButton() {
        // Função removida - agora o input de anexos é visível
        console.log('initAttachButton: Função removida - input de anexos agora é visível');
    }
    
    /**
     * Validar arquivos selecionados
     */
    function validateFiles() {
        const files = anexosInput.files;
        const maxFiles = 5;
        const maxSize = 10 * 1024 * 1024; // 10MB
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg',
            'image/jpg',
            'image/png',
            'text/plain'
        ];
        
        if (files.length > maxFiles) {
            showAlert(`Máximo de ${maxFiles} arquivos permitidos.`, 'warning');
            anexosInput.value = '';
            return false;
        }
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            if (file.size > maxSize) {
                showAlert(`O arquivo "${file.name}" excede o tamanho máximo de 10MB.`, 'warning');
                anexosInput.value = '';
                return false;
            }
            
            if (!allowedTypes.includes(file.type)) {
                showAlert(`O arquivo "${file.name}" não é de um tipo permitido.`, 'warning');
                anexosInput.value = '';
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Atualizar lista de arquivos selecionados
     */
    function updateFileList() {
        console.log('updateFileList chamada, arquivos:', anexosInput.files.length);
        
        let fileListContainer = document.getElementById('fileList');
        
        if (!fileListContainer) {
            fileListContainer = document.createElement('div');
            fileListContainer.id = 'fileList';
            fileListContainer.className = 'file-list mt-2';
            
            // Inserir após o input-group principal
            const inputGroup = document.querySelector('.input-group');
            if (inputGroup && inputGroup.parentNode) {
                inputGroup.parentNode.insertBefore(fileListContainer, inputGroup.nextSibling);
            } else {
                anexosInput.parentNode.appendChild(fileListContainer);
            }
            console.log('Container de lista de arquivos criado');
        }
        
        fileListContainer.innerHTML = '';
        
        if (anexosInput.files.length > 0) {
            console.log('Criando lista visual para', anexosInput.files.length, 'arquivos');
            
            // Adicionar título
            const title = document.createElement('div');
            title.className = 'file-list-title mb-2';
            title.innerHTML = `
                <small class="text-muted">
                    <i class="fas fa-paperclip me-1"></i>
                    Arquivos selecionados (${anexosInput.files.length}/5):
                </small>
            `;
            fileListContainer.appendChild(title);
            
            const fileList = document.createElement('div');
            fileList.className = 'selected-files';
            
            for (let i = 0; i < anexosInput.files.length; i++) {
                const file = anexosInput.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item d-flex justify-content-between align-items-center p-2 bg-light border rounded mb-1';
                fileItem.style.fontSize = '0.9em';
                fileItem.innerHTML = `
                    <span class="file-name">
                        <i class="fas fa-file me-2 text-primary"></i>
                        <strong>${file.name}</strong>
                        <small class="text-muted ms-1">(${formatFileSize(file.size)})</small>
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-file" data-index="${i}" title="Remover arquivo">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                fileList.appendChild(fileItem);
            }
            
            fileListContainer.appendChild(fileList);
            
            // Adicionar eventos para remover arquivos
            fileListContainer.querySelectorAll('.remove-file').forEach(button => {
                button.addEventListener('click', function() {
                    removeFile(parseInt(this.dataset.index));
                });
            });
            
            console.log('Lista visual criada com sucesso');
        } else {
            console.log('Nenhum arquivo selecionado, lista limpa');
        }
    }
    
    /**
     * Remover arquivo da seleção
     */
    function removeFile(index) {
        console.log('Removendo arquivo no índice:', index);
        const dt = new DataTransfer();
        const files = anexosInput.files;
        
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
            }
        }
        
        anexosInput.files = dt.files;
        console.log('Arquivos restantes:', anexosInput.files.length);
        updateFileList();
    }
    
    /**
     * Formatar tamanho do arquivo
     */
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    /**
     * Auto-resize do textarea
     */
    function initTextareaAutoResize() {
        if (mensagemTextarea) {
            mensagemTextarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    }
    
    /**
     * Auto-refresh das mensagens (opcional)
     */
    function initAutoRefresh() {
        // Implementar apenas se necessário
        // setInterval(refreshMessages, 30000); // 30 segundos
    }
    
    /**
     * Mostrar alerta
     */
    function showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer') || createAlertContainer();
        
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto-remover após 5 segundos
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
    
    /**
     * Criar container de alertas
     */
    function createAlertContainer() {
        const container = document.createElement('div');
        container.id = 'alertContainer';
        container.className = 'alert-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    }
    
    /**
     * Mostrar loading
     */
    function showLoading() {
        const submitButton = chatForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
        }
    }
    
    /**
     * Esconder loading
     */
    function hideLoading() {
        const submitButton = chatForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Mensagem';
        }
    }
    
    /**
     * Limpar formulário após envio bem-sucedido
     */
    function clearForm() {
        if (mensagemTextarea) {
            mensagemTextarea.value = '';
            mensagemTextarea.style.height = 'auto';
        }
        
        if (anexosInput) {
            anexosInput.value = '';
            updateFileList();
        }
        
        if (canalSelect) {
            canalSelect.value = 'sistema';
        }
        
        const internaCheckbox = document.getElementById('interna');
        if (internaCheckbox) {
            internaCheckbox.checked = false;
        }
        
        updateCharacterCount();
    }
    

    
    /**
     * Inicializar funcionalidades do chat moderno
     */
    function initChatModerno() {
        const chatTextarea = document.querySelector('.chat-textarea');
        const sendBtn = document.getElementById('sendBtn');
        const toggleOptionsBtn = document.getElementById('toggleOptionsBtn');
        const chatOptions = document.querySelector('.chat-options');
        const toggleSummaryBtn = document.getElementById('toggleSummary');
        const summaryDetails = document.getElementById('summaryDetails');
        
        // Auto-resize do textarea do chat
        if (chatTextarea) {
            chatTextarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
            
            // Envio com Enter (Shift+Enter para nova linha)
            chatTextarea.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (sendBtn && !sendBtn.disabled) {
                        sendBtn.click();
                    }
                }
            });
        }
        
        // Toggle das opções avançadas
        if (toggleOptionsBtn && chatOptions) {
            toggleOptionsBtn.addEventListener('click', function() {
                const isVisible = chatOptions.style.display !== 'none';
                chatOptions.style.display = isVisible ? 'none' : 'block';
                
                const icon = this.querySelector('i');
                if (icon) {
                    icon.className = isVisible ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
                }
            });
            
            // Inicialmente oculto
            chatOptions.style.display = 'none';
        }
        
        // Expandir/colapsar resumo da solicitação
        if (toggleSummaryBtn && summaryDetails) {
            toggleSummaryBtn.addEventListener('click', function() {
                const isExpanded = summaryDetails.style.display !== 'none';
                summaryDetails.style.display = isExpanded ? 'none' : 'block';
                
                const icon = this.querySelector('i');
                if (icon) {
                    icon.className = isExpanded ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
                }
                
                this.setAttribute('aria-expanded', !isExpanded);
            });
        }
        
        // Scroll automático para mensagens do chat
        const chatMessagesContainer = document.querySelector('.chat-messages');
        if (chatMessagesContainer) {
            scrollChatToBottom();
        }
        
        function scrollChatToBottom() {
            if (chatMessagesContainer) {
                chatMessagesContainer.scrollTo({
                    top: chatMessagesContainer.scrollHeight,
                    behavior: 'smooth'
                });
            }
        }
        
        // Adicionar funcionalidade de typing indicator (simulado)
        function showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'chat-message received typing-indicator';
            typingDiv.innerHTML = `
                <div class="message-bubble">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            `;
            
            if (chatMessagesContainer) {
                chatMessagesContainer.appendChild(typingDiv);
                scrollChatToBottom();
            }
            
            return typingDiv;
        }
        
        function hideTypingIndicator(indicator) {
            if (indicator && indicator.parentNode) {
                indicator.parentNode.removeChild(indicator);
            }
        }
        
        // Expor funções do chat moderno
        window.ChatModerno = {
            scrollChatToBottom,
            showTypingIndicator,
            hideTypingIndicator
        };
    }
    
    // Inicializar chat moderno
    initChatModerno();
    
    /**
     * Inicializar contador de caracteres
     */
    function initCharacterCounter() {
        const mensagemTextarea = document.getElementById('mensagem');
        
        // Remover qualquer contador duplicado que possa ter sido criado dinamicamente
        const duplicateCounters = document.querySelectorAll('.character-counter, #charCounter, [class*="char-counter"]:not(.char-counter)');
        duplicateCounters.forEach(counter => {
            if (counter.textContent && counter.textContent.includes('5000 caracteres')) {
                counter.remove();
            }
        });
        
        const charCountElement = document.getElementById('charCount');
        const charCounterContainer = document.querySelector('.char-counter');

        if (mensagemTextarea && charCountElement) {
            console.log('Inicializando contador de caracteres');
            
            // Função para atualizar o contador
            function updateCharCount() {
                const currentLength = mensagemTextarea.value.length;
                const maxLength = 5000;
                
                charCountElement.textContent = currentLength;
                
                // Remover classes anteriores
                charCounterContainer.classList.remove('warning', 'danger');
                
                // Adicionar classes baseadas na porcentagem
                const percentage = (currentLength / maxLength) * 100;
                
                if (percentage >= 90) {
                    charCounterContainer.classList.add('danger');
                } else if (percentage >= 75) {
                    charCounterContainer.classList.add('warning');
                }
                
                // Log para debug
                console.log(`Caracteres: ${currentLength}/${maxLength} (${percentage.toFixed(1)}%)`);
            }
            
            // Event listeners
            mensagemTextarea.addEventListener('input', updateCharCount);
            mensagemTextarea.addEventListener('keyup', updateCharCount);
            mensagemTextarea.addEventListener('paste', function() {
                // Aguardar o paste ser processado
                setTimeout(updateCharCount, 10);
            });
            
            // Inicializar contador
            updateCharCount();
        } else {
            console.warn('Elementos do contador de caracteres não encontrados');
        }
    }

    // Expor funções globalmente se necessário
    window.EsicChat = {
        scrollToBottom,
        clearForm,
        showAlert,
        hideLoading
    };
});