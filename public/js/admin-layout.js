/**
 * Admin Layout JavaScript
 * Funcionalidades gerais do layout administrativo
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar funcionalidades do layout
    initializeSidebar();
});

/**
 * Toggle da sidebar
 */
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    sidebar.classList.toggle('show');
}

/**
 * Inicializar funcionalidades da sidebar
 */
function initializeSidebar() {
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('adminSidebar');
        const menuBtn = document.querySelector('.mobile-menu-btn');
        
        if (window.innerWidth <= 768 && 
            !sidebar.contains(event.target) && 
            !menuBtn.contains(event.target)) {
            sidebar.classList.remove('show');
        }
    });
}

// Exportar funções globalmente
window.toggleSidebar = toggleSidebar;