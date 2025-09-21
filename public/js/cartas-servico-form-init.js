// Cartas de Serviço - Inicialização do Formulário

document.addEventListener('DOMContentLoaded', function() {
    // Ler dados do elemento HTML
    const dataElement = document.getElementById('carta-servico-data');
    
    if (dataElement) {
        const cartaData = {
            id: dataElement.dataset.id || null,
            nome: dataElement.dataset.nome || ''
        };
        
        // Inicializar dados usando a função do cartas-servico-data.js
        if (window.initCartaServicoData) {
            window.initCartaServicoData(cartaData);
        }
        
        // Configurar função de exclusão se existir um serviço
        const serviceId = cartaData.id;
        
        if (serviceId) {
            const deleteUrl = `/admin/cartas-servico/${serviceId}`;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (window.setupDeleteServiceFunction) {
                window.setupDeleteServiceFunction(serviceId, deleteUrl, csrfToken);
            }
        }
    }
});