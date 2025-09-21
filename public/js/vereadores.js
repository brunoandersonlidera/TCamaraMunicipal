// Vereadores JavaScript Functions

function addComissao() {
    const container = document.getElementById('comissoes-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="comissoes[]" placeholder="Nome da comissão">
        <button type="button" class="btn btn-outline-danger" onclick="removeComissao(this)">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeComissao(button) {
    button.parentElement.remove();
}

// Export functions globally
window.addComissao = addComissao;
window.removeComissao = removeComissao;