// Vereadores JavaScript Functions

function addComissao() {
    const container = document.getElementById('comissoes-container');
    if (!container) return;
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="comissoes[]" placeholder="Nome da comissão">
        <button type="button" class="btn btn-outline-danger remove-comissao-btn">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(div);
}

// Export functions globally (mantido por compatibilidade)
window.addComissao = addComissao;

// Bind de eventos sem inline handlers (evita problemas de CSP e escopo)
document.addEventListener('DOMContentLoaded', () => {
    // Botões de adicionar já presentes na página
    document.querySelectorAll('.add-comissao-btn').forEach(btn => {
        btn.addEventListener('click', addComissao);
    });

    // Delegação para remoção dentro do container
    const container = document.getElementById('comissoes-container');
    if (container) {
        container.addEventListener('click', (e) => {
            const btn = e.target.closest('.remove-comissao-btn');
            if (btn) {
                const group = btn.closest('.input-group');
                if (group) group.remove();
            }
        });
    }
});