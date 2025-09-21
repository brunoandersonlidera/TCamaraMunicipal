// Cartas de Serviço - Formulário JavaScript

// Configurar função de exclusão específica para um serviço
function setupDeleteServiceFunction(serviceId, deleteUrl, csrfToken) {
    document.addEventListener('DOMContentLoaded', function() {
        window.deleteServiceCurrent = function() {
            deleteService(serviceId, deleteUrl, csrfToken);
        };
    });
}

// Exportar função globalmente
window.setupDeleteServiceFunction = setupDeleteServiceFunction;