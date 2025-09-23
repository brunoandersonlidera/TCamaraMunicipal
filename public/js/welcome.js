/**
 * JavaScript para a página Welcome (Página Inicial)
 * Responsável pela funcionalidade dos botões de acesso rápido
 */

document.addEventListener('DOMContentLoaded', function() {
    // Aplicar cores dinâmicas aos botões de acesso rápido
    const botoesAcesso = document.querySelectorAll('.btn-acesso-rapido');
    
    botoesAcesso.forEach(function(botao) {
        const bgColor = botao.getAttribute('data-bg-color') || '#007bff';
        const textColor = botao.getAttribute('data-text-color') || '#ffffff';
        
        // Aplicar estilos dinâmicos
        botao.style.backgroundColor = bgColor;
        botao.style.color = textColor;
        botao.style.border = '2px solid ' + bgColor;
        
        // Adicionar efeitos hover dinâmicos
        botao.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        });
        
        botao.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        });
    });
});