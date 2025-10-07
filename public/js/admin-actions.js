/**
 * Admin Actions - JavaScript centralizado para ações administrativas
 * Substitui JavaScript inline para resolver problemas de Content Security Policy (CSP)
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Função para confirmar exclusões
    window.confirmDelete = function(id = null, name = null) {
        const message = name ? 
            `Tem certeza que deseja excluir "${name}"? Esta ação não pode ser desfeita.` :
            'Tem certeza que deseja excluir este item? Esta ação não pode ser desfeita.';
        return confirm(message);
    };

    // Função para confirmar exclusão de leis
    window.confirmarExclusao = function(id, numero) {
        return confirm(`Tem certeza que deseja excluir a Lei ${numero}? Esta ação não pode ser desfeita.`);
    };

    // Função para confirmar exclusão de páginas
    window.confirmarExclusao = function() {
        return confirm('Tem certeza que deseja excluir esta página? Esta ação não pode ser desfeita.');
    };

    // Função para toggle de status
    window.toggleStatus = function(id = null) {
        const message = 'Tem certeza que deseja alterar o status deste item?';
        return confirm(message);
    };

    // Função para toggle de destaque
    window.toggleDestaque = function() {
        return confirm('Tem certeza que deseja alterar o destaque deste item?');
    };

    // Função para toggle de arquivo
    window.toggleArquivo = function() {
        return confirm('Tem certeza que deseja alterar o status de arquivo deste item?');
    };

    // Função para remover arquivos
    window.removeFile = function(fileName = null) {
        const message = fileName ? 
            `Tem certeza que deseja remover o arquivo "${fileName}"?` :
            'Tem certeza que deseja remover este arquivo?';
        return confirm(message);
    };

    // Função para verificar cidadão
    window.verificarCidadao = function(userId) {
        if (confirm('Tem certeza que deseja aprovar este cidadão?')) {
            // Implementar lógica de aprovação
            fetch(`/admin/users/${userId}/verificar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Erro ao aprovar cidadão');
                }
            });
        }
    };

    // Função para rejeitar cidadão
    window.rejeitarCidadao = function(userId) {
        if (confirm('Tem certeza que deseja rejeitar este cidadão?')) {
            // Implementar lógica de rejeição
            fetch(`/admin/users/${userId}/rejeitar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Erro ao rejeitar cidadão');
                }
            });
        }
    };

    // Função para imprimir
    window.imprimirLei = function() {
        window.print();
    };

    // Função para compartilhar
    window.compartilharLei = function() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            });
        } else {
            // Fallback para navegadores que não suportam Web Share API
            copyToClipboard(window.location.href);
            alert('Link copiado para a área de transferência!');
        }
    };

    // Função para copiar para clipboard
    window.copyToClipboard = function(text = null) {
        const textToCopy = text || window.location.href;
        navigator.clipboard.writeText(textToCopy).then(function() {
            alert('Link copiado para a área de transferência!');
        }, function(err) {
            console.error('Erro ao copiar: ', err);
        });
    };

    // Função para copiar URL
    window.copiarUrl = function() {
        copyToClipboard();
    };

    // Funções de compartilhamento social
    window.compartilharWhatsApp = function() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent(document.title);
        window.open(`https://wa.me/?text=${text} ${url}`, '_blank');
    };

    window.compartilharTwitter = function() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent(document.title);
        window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
    };

    window.compartilharFacebook = function() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    };

    window.compartilharEmail = function() {
        const url = encodeURIComponent(window.location.href);
        const subject = encodeURIComponent(document.title);
        const body = encodeURIComponent(`Confira: ${document.title}\n\n${window.location.href}`);
        window.location.href = `mailto:?subject=${subject}&body=${body}`;
    };

    // Função genérica de compartilhamento
    window.compartilhar = function() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            });
        } else {
            copyToClipboard();
        }
    };

    // Função para toggle de sidebar mobile
    window.toggleSidebar = function() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
    };

    // Função para toggle de visualização
    window.toggleView = function(viewType) {
        const tableView = document.getElementById('tableView');
        const cardsView = document.getElementById('cardsView');
        const tableBtn = document.getElementById('viewTable') || document.getElementById('btnTable') || document.getElementById('tableViewBtn');
        const cardsBtn = document.getElementById('viewCards') || document.getElementById('btnCards') || document.getElementById('cardsViewBtn');

        if (viewType === 'table') {
            if (tableView) tableView.style.display = 'block';
            if (cardsView) cardsView.style.display = 'none';
            if (tableBtn) tableBtn.classList.add('active');
            if (cardsBtn) cardsBtn.classList.remove('active');
        } else if (viewType === 'cards') {
            if (tableView) tableView.style.display = 'none';
            if (cardsView) cardsView.style.display = 'block';
            if (tableBtn) tableBtn.classList.remove('active');
            if (cardsBtn) cardsBtn.classList.add('active');
        }
    };

    // Event listeners para formulários de confirmação
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Event listener para links com confirmação
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[data-confirm]');
        
        if (link) {
            const confirmMessage = link.getAttribute('data-confirm');
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Event listeners para auto-submit em selects
    document.querySelectorAll('select[data-auto-submit]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Event listeners para botões de ação
    document.querySelectorAll('[data-action]').forEach(element => {
        const eventType = element.tagName.toLowerCase() === 'select' ? 'change' : 'click';
        
        element.addEventListener(eventType, function(e) {
            const action = this.getAttribute('data-action');
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            switch (action) {
                case 'delete':
                    if (!confirmDelete(id, name)) {
                        e.preventDefault();
                    }
                    break;
                case 'toggle-status':
                    if (!toggleStatus(id)) {
                        e.preventDefault();
                    }
                    break;
                case 'verify-citizen':
                    verificarCidadao(id);
                    break;
                case 'reject-citizen':
                    rejeitarCidadao(id);
                    break;
                case 'toggle-sidebar':
                    toggleSidebar();
                    break;
                case 'toggle-arquivo':
                    toggleArquivo();
                    break;
                case 'toggle-status':
                    if (!toggleStatus(id)) {
                        e.preventDefault();
                    }
                    break;
                case 'confirm-delete':
                    if (!confirmDelete(id)) {
                        e.preventDefault();
                    }
                    break;
                case 'toggle-destaque':
                    toggleDestaque();
                    break;
            }
        });
    });

});