// Cartas de Serviço - Inicialização da Visualização

document.addEventListener('DOMContentLoaded', function() {
    // Ler dados do elemento HTML
    const dataElement = document.getElementById('carta-servico-show-data');
    
    if (dataElement) {
        const cartaShowData = {
            id: dataElement.dataset.id || null,
            status: dataElement.dataset.status || 'ativo'
        };
        
        // Inicializar dados usando a função do cartas-servico-data.js
        if (window.initCartaServicoData) {
            window.initCartaServicoData(cartaShowData);
        }
        
        // Configurar variáveis globais para compatibilidade
        window.cartaServicoId = cartaShowData.id;
        window.cartaServicoStatus = cartaShowData.status;
        window.cartaServicoShowData = cartaShowData;
    }
});