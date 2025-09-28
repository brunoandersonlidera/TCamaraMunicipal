/**
 * Script para administração de eventos
 * Aplica cores dinamicamente aos elementos com data-cor
 */

document.addEventListener('DOMContentLoaded', function() {
    // Aplicar cores dinamicamente aos elementos com data-cor
    aplicarCoresDinamicas();
    
    // Observar mudanças no DOM para aplicar cores em elementos adicionados dinamicamente
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                aplicarCoresDinamicas();
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

/**
 * Aplica cores de fundo aos elementos com a classe evento-cor-dinamica
 */
function aplicarCoresDinamicas() {
    const elementosComCor = document.querySelectorAll('.evento-cor-dinamica[data-cor]');
    
    elementosComCor.forEach(function(elemento) {
        const cor = elemento.getAttribute('data-cor');
        if (cor && cor.trim() !== '') {
            elemento.style.backgroundColor = cor;
            
            // Para elementos de preview de cor, também aplicar min-width se necessário
            if (elemento.classList.contains('preview-cor-evento')) {
                elemento.style.minWidth = '60px';
            }
        }
    });
}

/**
 * Função para atualizar a cor do preview quando uma nova cor é selecionada
 * @param {string} novaCor - A nova cor selecionada
 */
function atualizarPreviewCor(novaCor) {
    const previewCor = document.getElementById('preview-cor');
    if (previewCor) {
        previewCor.style.backgroundColor = novaCor;
        previewCor.setAttribute('data-cor', novaCor);
    }
}

// Tornar a função disponível globalmente para uso em outros scripts
window.atualizarPreviewCor = atualizarPreviewCor;
window.aplicarCoresDinamicas = aplicarCoresDinamicas;