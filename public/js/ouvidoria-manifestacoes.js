// Funcionalidades para gerenciamento de manifestações da ouvidoria
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit do formulário de filtros
    document.querySelectorAll('#filterForm select').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Event listeners para botões com data-action
    document.addEventListener('click', function(e) {
        const button = e.target.closest('[data-action]');
        if (!button) return;

        const action = button.getAttribute('data-action');
        const manifestacaoId = button.getAttribute('data-manifestacao-id');

        if (action === 'open-response-modal') {
            openResponseModal(manifestacaoId);
        } else if (action === 'archive-manifestacao') {
            archiveManifestacao(manifestacaoId);
        }
    });

    // Envio da resposta (para index.blade.php)
    const responseForm = document.getElementById('responseForm');
    if (responseForm) {
        responseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const manifestacaoId = this.getAttribute('data-manifestacao-id');
            const formData = new FormData(this);
            
            // Se não tem manifestacaoId no atributo, pega da URL ou elemento da página
            let url;
            if (manifestacaoId) {
                url = `/admin/ouvidoria-manifestacoes/${manifestacaoId}/responder`;
            } else {
                // Para show.blade.php, pega o ID da URL atual ou de um elemento hidden
                const currentUrl = window.location.pathname;
                const match = currentUrl.match(/\/admin\/ouvidoria-manifestacoes\/(\d+)/);
                if (match) {
                    url = `/admin/ouvidoria-manifestacoes/${match[1]}/responder`;
                } else {
                    alert('Erro: ID da manifestação não encontrado');
                    return;
                }
            }
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Resposta não é JSON válido');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('responseModal')).hide();
                    location.reload();
                } else {
                    alert(data.message || 'Erro ao enviar resposta');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao enviar resposta: ' + error.message);
            });
        });
    }
});

// Função para abrir modal de resposta (para index.blade.php)
function openResponseModal(manifestacaoId) {
    if (manifestacaoId) {
        document.getElementById('responseForm').setAttribute('data-manifestacao-id', manifestacaoId);
    }
    new bootstrap.Modal(document.getElementById('responseModal')).show();
}

// Função para arquivar manifestação
function archiveManifestacao(manifestacaoId) {
    if (confirm('Tem certeza que deseja arquivar esta manifestação?')) {
        fetch(`/admin/ouvidoria-manifestacoes/${manifestacaoId}/archive`, {
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
                alert('Erro ao arquivar manifestação');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao arquivar manifestação');
        });
    }
}