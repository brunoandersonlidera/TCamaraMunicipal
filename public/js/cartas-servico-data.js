/**
 * Cartas de Serviço - Gerenciamento de Dados
 * Arquivo responsável por gerenciar os dados das cartas de serviço
 */

// Função para inicializar os dados da carta de serviço
function initCartaServicoData(data) {
    window.cartaServicoData = data || {};
    
    // Disparar evento personalizado quando os dados estiverem prontos
    const event = new CustomEvent('cartaServicoDataReady', {
        detail: window.cartaServicoData
    });
    document.dispatchEvent(event);
}

// Função para obter os dados da carta de serviço
function getCartaServicoData() {
    return window.cartaServicoData || {};
}

// Função para atualizar os dados da carta de serviço
function updateCartaServicoData(newData) {
    window.cartaServicoData = { ...window.cartaServicoData, ...newData };
    
    // Disparar evento de atualização
    const event = new CustomEvent('cartaServicoDataUpdated', {
        detail: window.cartaServicoData
    });
    document.dispatchEvent(event);
}

// Exportar funções para uso global
window.initCartaServicoData = initCartaServicoData;
window.getCartaServicoData = getCartaServicoData;
window.updateCartaServicoData = updateCartaServicoData;