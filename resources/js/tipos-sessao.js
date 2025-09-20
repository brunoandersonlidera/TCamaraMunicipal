/**
 * JavaScript para aplicar cores dinamicamente aos tipos de sessão
 * Evita misturar código PHP/Blade com CSS inline
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Função para aplicar cor de fundo aos badges de tipo de sessão
    function aplicarCoresTiposSessao() {
        // Seleciona todos os elementos com data-cor
        const elementos = document.querySelectorAll('[data-cor]');
        
        elementos.forEach(function(elemento) {
            const cor = elemento.getAttribute('data-cor');
            if (cor) {
                elemento.style.backgroundColor = cor;
            }
        });
    }
    
    // Função para aplicar cores aos previews de cor
    function aplicarCoresPreviews() {
        const previews = document.querySelectorAll('[data-preview-cor]');
        
        previews.forEach(function(preview) {
            const cor = preview.getAttribute('data-preview-cor');
            if (cor) {
                preview.style.backgroundColor = cor;
            }
        });
    }
    
    // Função para atualizar preview em tempo real (para formulários)
    function configurarPreviewDinamico() {
        const inputCor = document.getElementById('cor');
        const inputIcone = document.getElementById('icone');
        const inputNome = document.getElementById('nome');
        const badgePreview = document.getElementById('badge-preview');
        
        if (inputCor && badgePreview) {
            inputCor.addEventListener('input', function() {
                badgePreview.style.backgroundColor = this.value;
            });
        }
        
        if (inputIcone && badgePreview) {
            inputIcone.addEventListener('input', function() {
                const iconElement = badgePreview.querySelector('i');
                if (iconElement) {
                    iconElement.className = this.value;
                }
            });
        }
        
        if (inputNome && badgePreview) {
            inputNome.addEventListener('input', function() {
                const textElement = badgePreview.querySelector('#badge-text');
                if (textElement) {
                    textElement.textContent = this.value;
                }
            });
        }
    }
    
    // Função para configurar color picker personalizado
    function configurarColorPicker() {
        const colorInputs = document.querySelectorAll('input[type="color"]');
        
        colorInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                // Atualiza preview se existir
                const preview = document.querySelector('[data-preview-for="' + this.id + '"]');
                if (preview) {
                    preview.style.backgroundColor = this.value;
                }
            });
        });
    }
    
    // Função para adicionar efeitos hover suaves
    function adicionarEfeitosHover() {
        const badges = document.querySelectorAll('.tipo-badge, .badge-preview, .badge-preview-large');
        
        badges.forEach(function(badge) {
            badge.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'all 0.2s ease';
            });
            
            badge.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }
    
    // Executar todas as funções
    aplicarCoresTiposSessao();
    aplicarCoresPreviews();
    configurarPreviewDinamico();
    configurarColorPicker();
    adicionarEfeitosHover();
    
    // Observar mudanças no DOM para elementos carregados dinamicamente
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                aplicarCoresTiposSessao();
                aplicarCoresPreviews();
                adicionarEfeitosHover();
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

// Função global para atualizar cores (pode ser chamada externamente)
window.atualizarCoresTiposSessao = function() {
    const elementos = document.querySelectorAll('[data-cor]');
    elementos.forEach(function(elemento) {
        const cor = elemento.getAttribute('data-cor');
        if (cor) {
            elemento.style.backgroundColor = cor;
        }
    });
};