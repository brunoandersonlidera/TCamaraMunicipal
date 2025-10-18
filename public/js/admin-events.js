// Admin Events Handler
document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile menu toggle
    window.toggleSidebar = function() {
        const sidebar = document.querySelector('.admin-sidebar');
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
    };

    // Generic confirmation delete
    window.confirmDelete = function(id = null) {
        if (confirm('Tem certeza que deseja excluir este item? Esta ação não pode ser desfeita.')) {
            if (id) {
                // If ID is provided, submit specific form
                const form = document.querySelector(`form[data-delete-id="${id}"]`);
                if (form) {
                    form.submit();
                }
            } else {
                // Submit the closest form
                const form = event.target.closest('form');
                if (form) {
                    form.submit();
                }
            }
        }
        return false;
    };

    // Toggle status functions
    window.toggleStatus = function(id = null) {
        if (confirm('Tem certeza que deseja alterar o status?')) {
            // Implementation depends on specific context
            console.log('Toggle status for ID:', id);
        }
    };

    // Print function
    window.printPage = function() {
        window.print();
    };

    // Share function
    window.compartilhar = function() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            });
        } else {
            // Fallback for browsers that don't support Web Share API
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copiado para a área de transferência!');
            });
        }
    };

    // View toggle functions
    window.toggleView = function(view) {
        const tableView = document.querySelector('.table-view');
        const cardsView = document.querySelector('.cards-view');
        const tableBtn = document.querySelector('#tableViewBtn, #btnTable, #viewTable');
        const cardsBtn = document.querySelector('#cardsViewBtn, #btnCards, #viewCards');

        if (view === 'table') {
            if (tableView) tableView.style.display = 'block';
            if (cardsView) cardsView.style.display = 'none';
            if (tableBtn) tableBtn.classList.add('active');
            if (cardsBtn) cardsBtn.classList.remove('active');
        } else if (view === 'cards') {
            if (tableView) tableView.style.display = 'none';
            if (cardsView) cardsView.style.display = 'block';
            if (cardsBtn) cardsBtn.classList.add('active');
            if (tableBtn) tableBtn.classList.remove('active');
        }
    };

    // Tag management for news
    window.addTag = function() {
        const container = document.querySelector('.tags-container');
        if (container) {
            const tagHtml = `
                <div class="tag-item mb-2">
                    <div class="input-group">
                        <input type="text" name="tags[]" class="form-control" placeholder="Digite a tag">
                        <button type="button" class="btn btn-outline-danger remove-tag">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', tagHtml);
        }
    };

    window.removeTag = function(button) {
        const tagItem = button.closest('.tag-item');
        if (tagItem) {
            tagItem.remove();
        }
    };

    // Etapa management for cartas de serviço
    window.addEtapa = function() {
        const container = document.querySelector('.etapas-container');
        if (container) {
            const etapaCount = container.children.length + 1;
            const etapaHtml = `
                <div class="etapa-item mb-3 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Etapa ${etapaCount}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-etapa">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Título da Etapa</label>
                        <input type="text" name="etapas[${etapaCount}][titulo]" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Descrição</label>
                        <textarea name="etapas[${etapaCount}][descricao]" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', etapaHtml);
        }
    };

    window.removeEtapa = function(button) {
        const etapaItem = button.closest('.etapa-item');
        if (etapaItem) {
            etapaItem.remove();
        }
    };

    // Document management for cartas de serviço
    window.addDocumento = function() {
        const container = document.querySelector('.documentos-container');
        if (container) {
            const docCount = container.children.length + 1;
            const docHtml = `
                <div class="documento-item mb-2">
                    <div class="input-group">
                        <input type="text" name="documentos[]" class="form-control" placeholder="Nome do documento">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-documento">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', docHtml);
        }
    };

    window.removeDocumento = function(button) {
        const docItem = button.closest('.documento-item');
        if (docItem) {
            docItem.remove();
        }
    };

    // Comissão management for vereadores
    window.addComissao = function() {
        const container = document.querySelector('.comissoes-container');
        if (container) {
            const comissaoHtml = `
                <div class="comissao-item mb-2">
                    <div class="input-group">
                        <input type="text" name="comissoes[]" class="form-control" placeholder="Nome da comissão">
                        <button type="button" class="btn btn-outline-danger remove-comissao">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', comissaoHtml);
        }
    };

    window.removeComissao = function(button) {
        const comissaoItem = button.closest('.comissao-item');
        if (comissaoItem) {
            comissaoItem.remove();
        }
    };

    // Vereadores selection for sessions
    window.selectAllVereadores = function() {
        const checkboxes = document.querySelectorAll('input[name="vereadores[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
    };

    window.deselectAllVereadores = function() {
        const checkboxes = document.querySelectorAll('input[name="vereadores[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    };

    // Form utilities
    window.limparFormulario = function() {
        if (confirm('Tem certeza que deseja limpar todos os campos?')) {
            const form = document.querySelector('form');
            if (form) {
                form.reset();
            }
        }
    };

    window.submitForm = function() {
        const form = document.querySelector('form');
        if (form) {
            form.submit();
        }
    };

    // Statistics update
    window.atualizarEstatisticas = function() {
        // Implementation for updating statistics
        console.log('Atualizando estatísticas...');
    };

    // Archive functions
    window.toggleArquivo = function() {
        // Implementation for archive toggle
        console.log('Toggle arquivo');
    };

    // Status change functions
    window.alterarStatus = function(status) {
        // Implementation for status change
        console.log('Alterar status para:', status);
    };

    window.salvarStatus = function() {
        // Implementation for saving status
        console.log('Salvar status');
    };

    // Service specific functions
    window.deleteService = function(id) {
        if (confirm('Tem certeza que deseja excluir este serviço?')) {
            // Implementation for service deletion
            console.log('Delete service:', id);
        }
    };

    window.deleteServiceCurrent = function() {
        if (confirm('Tem certeza que deseja excluir este serviço?')) {
            // Implementation for current service deletion
            console.log('Delete current service');
        }
    };

    window.duplicateService = function() {
        if (confirm('Tem certeza que deseja duplicar este serviço?')) {
            // Implementation for service duplication
            console.log('Duplicate service');
        }
    };

    window.toggleDestaque = function() {
        if (confirm('Tem certeza que deseja alterar o destaque?')) {
            // Implementation for highlight toggle
            console.log('Toggle destaque');
        }
    };

    // User management functions
    window.resetPassword = function() {
        if (confirm('Tem certeza que deseja resetar a senha?')) {
            // Implementation for password reset
            console.log('Reset password');
        }
    };

    window.deleteUser = function(id = null) {
        if (confirm('Tem certeza que deseja excluir este usuário?')) {
            // Implementation for user deletion
            console.log('Delete user:', id);
        }
    };

    window.resendVerification = function(id) {
        if (confirm('Tem certeza que deseja reenviar o email de verificação?')) {
            // Implementation for resending verification
            console.log('Resend verification for user:', id);
        }
    };

    // Manifestação functions removed - implemented in ouvidoria-manifestacoes.js

    // File management
    window.removeFile = function(fileName) {
        // Implementation for file removal
        console.log('Remove file:', fileName);
    };

    // Event delegation for dynamically added elements
    document.addEventListener('click', function(e) {
        // Handle remove tag buttons
        if (e.target.closest('.remove-tag')) {
            removeTag(e.target.closest('.remove-tag'));
        }
        
        // Handle remove etapa buttons
        if (e.target.closest('.remove-etapa')) {
            removeEtapa(e.target.closest('.remove-etapa'));
        }
        
        // Handle remove documento buttons
        if (e.target.closest('.remove-documento')) {
            removeDocumento(e.target.closest('.remove-documento'));
        }
        
        // Handle remove comissao buttons
        if (e.target.closest('.remove-comissao')) {
            removeComissao(e.target.closest('.remove-comissao'));
        }
    });

    // Handle form submissions with confirmation
    document.addEventListener('submit', function(e) {
        if (e.target.hasAttribute('data-confirm')) {
            const message = e.target.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Handle file input clicks for image upload
    document.addEventListener('click', function(e) {
        if (e.target.closest('.upload-zone')) {
            const uploadZone = e.target.closest('.upload-zone');
            const fileInput = uploadZone.querySelector('input[type="file"]') || 
                             document.querySelector(`#file-input-${uploadZone.dataset.name}`);
            if (fileInput) {
                fileInput.click();
            }
        }
    });
});