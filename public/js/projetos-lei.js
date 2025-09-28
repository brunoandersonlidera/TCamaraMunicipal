/**
 * Funções para gerenciamento de projetos de lei
 */

document.addEventListener('DOMContentLoaded', function() {
    // Atualizar coautores quando autor principal mudar
    const autorSelect = document.getElementById('autor_id');
    const coautoresCheckboxes = document.querySelectorAll('input[name="vereadores[]"]');
    
    if (autorSelect) {
        autorSelect.addEventListener('change', function() {
            const autorId = this.value;
            
            coautoresCheckboxes.forEach(checkbox => {
                if (checkbox.value === autorId) {
                    checkbox.checked = false;
                    checkbox.disabled = true;
                } else {
                    checkbox.disabled = false;
                }
            });
        });
        
        // Trigger inicial
        if (autorSelect.value) {
            autorSelect.dispatchEvent(new Event('change'));
        }
    }
    
    // Validação do formulário
    const form = document.getElementById('projetoForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Função de validação completa do formulário
    function validateForm() {
        const errors = [];
        
        // Validações básicas
        const titulo = document.getElementById('titulo');
        const ementa = document.getElementById('ementa');
        const tipoAutoria = document.getElementById('tipo_autoria');
        
        if (!titulo || !titulo.value.trim()) {
            errors.push('O título é obrigatório.');
        }
        
        if (!ementa || !ementa.value.trim()) {
            errors.push('A ementa é obrigatória.');
        }
        
        if (!tipoAutoria || !tipoAutoria.value) {
            errors.push('O tipo de autoria é obrigatório.');
        }
        
        // Validações específicas por tipo de autoria
        if (tipoAutoria && tipoAutoria.value) {
            switch (tipoAutoria.value) {
                case 'vereador':
                    const autorId = document.getElementById('autor_id');
                    if (!autorId || !autorId.value) {
                        errors.push('O vereador autor é obrigatório.');
                    }
                    break;
                    
                case 'comissao':
                    const autorNome = document.getElementById('autor_nome');
                    if (!autorNome || !autorNome.value.trim()) {
                        errors.push('O nome da comissão é obrigatório.');
                    }
                    break;
                    
                case 'iniciativa_popular':
                    const comiteNome = document.getElementById('comite_nome');
                    const numeroAssinaturas = document.getElementById('numero_assinaturas');
                    const minimoAssinaturas = document.getElementById('minimo_assinaturas');
                    const comiteEmail = document.getElementById('comite_email');
                    const comiteTelefone = document.getElementById('comite_telefone');
                    
                    if (!comiteNome || !comiteNome.value.trim()) {
                        errors.push('O nome do responsável/comitê é obrigatório.');
                    }
                    
                    if (!numeroAssinaturas || !numeroAssinaturas.value || parseInt(numeroAssinaturas.value) <= 0) {
                        errors.push('O número de assinaturas coletadas deve ser maior que zero.');
                    }
                    
                    if (!minimoAssinaturas || !minimoAssinaturas.value || parseInt(minimoAssinaturas.value) < 100) {
                        errors.push('O mínimo de assinaturas deve ser pelo menos 100.');
                    }
                    
                    if (numeroAssinaturas && minimoAssinaturas && 
                        parseInt(numeroAssinaturas.value) < parseInt(minimoAssinaturas.value)) {
                        errors.push('O número de assinaturas coletadas deve ser maior ou igual ao mínimo necessário.');
                    }
                    
                    if (comiteEmail && comiteEmail.value && !isValidEmail(comiteEmail.value)) {
                        errors.push('O email do comitê deve ser um endereço válido.');
                    }
                    
                    if (comiteTelefone && comiteTelefone.value && !isValidPhone(comiteTelefone.value)) {
                        errors.push('O telefone deve ter 10 ou 11 dígitos.');
                    }
                    break;
            }
        }
        
        // Exibir erros se houver
        if (errors.length > 0) {
            alert('Por favor, corrija os seguintes erros:\n\n' + errors.join('\n'));
            return false;
        }
        
        return true;
    }
    
    // Função para validar email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Função para validar telefone
    function isValidPhone(phone) {
        const phoneDigits = phone.replace(/[^0-9]/g, '');
        return phoneDigits.length >= 10 && phoneDigits.length <= 11;
    }
    
    // Habilitar/desabilitar campos baseado no status
    const statusSelect = document.getElementById('status');
    const dataAprovacao = document.getElementById('data_aprovacao');
    const numeroLei = document.getElementById('numero_lei');
    const arquivoLei = document.getElementById('arquivo_lei');
    
    function toggleAprovacaoFields() {
        if (!statusSelect) return; // Sair se não houver statusSelect
        
        const isAprovado = statusSelect.value === 'aprovado';
        
        if (isAprovado) {
            if (dataAprovacao) dataAprovacao.removeAttribute('disabled');
            if (numeroLei) numeroLei.removeAttribute('disabled');
            if (arquivoLei) arquivoLei.removeAttribute('disabled');
        } else {
            if (dataAprovacao) {
                dataAprovacao.value = '';
                dataAprovacao.setAttribute('disabled', 'disabled');
            }
            if (numeroLei) {
                numeroLei.value = '';
                numeroLei.setAttribute('disabled', 'disabled');
            }
            if (arquivoLei) {
                arquivoLei.setAttribute('disabled', 'disabled');
            }
        }
    }
    
    // Só executar se todos os elementos necessários existirem (página de edição/criação)
    if (statusSelect && dataAprovacao && numeroLei && arquivoLei) {
        statusSelect.addEventListener('change', toggleAprovacaoFields);
        toggleAprovacaoFields(); // Trigger inicial
    }

    // Restaurar visualização salva (para index)
    const savedView = localStorage.getItem('projetos_view') || 'table';
    if (typeof toggleView === 'function') {
        toggleView(savedView);
    }
});

// Funções para o index
function confirmDelete(projetoId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/projetos-lei/${projetoId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const tableBtn = document.getElementById('viewTable');
    const cardsBtn = document.getElementById('viewCards');
    
    // Verificar se os elementos existem antes de manipulá-los
    if (!tableView || !cardsView || !tableBtn || !cardsBtn) {
        console.warn('Elementos de visualização não encontrados');
        return;
    }
    
    if (view === 'table') {
        tableView.style.display = 'block';
        cardsView.style.display = 'none';
        
        // Verificação de segurança para classList
        if (tableBtn && tableBtn.classList) {
            try {
                tableBtn.classList.add('active');
            } catch (error) {
                console.warn('Erro ao adicionar classe active ao tableBtn:', error);
            }
        }
        
        if (cardsBtn && cardsBtn.classList) {
            try {
                cardsBtn.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do cardsBtn:', error);
            }
        }
        
        localStorage.setItem('projetos_view', 'table');
    } else {
        tableView.style.display = 'none';
        cardsView.style.display = 'block';
        
        // Verificação de segurança para classList
        if (tableBtn && tableBtn.classList) {
            try {
                tableBtn.classList.remove('active');
            } catch (error) {
                console.warn('Erro ao remover classe active do tableBtn:', error);
            }
        }
        
        if (cardsBtn && cardsBtn.classList) {
            try {
                cardsBtn.classList.add('active');
            } catch (error) {
                console.warn('Erro ao adicionar classe active ao cardsBtn:', error);
            }
        }
        
        localStorage.setItem('projetos_view', 'cards');
    }
}

// Export functions globally
window.confirmDelete = confirmDelete;
window.toggleView = toggleView;