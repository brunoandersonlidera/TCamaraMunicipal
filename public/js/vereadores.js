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

// Integração com Biblioteca de Mídia
function openMediaSelector() {
    if (typeof window.openMediaLibrary === 'function') {
        window.openMediaLibrary({
            multiple: false,
            type: 'image',
            onSelect: function(selectedMedia) {
                if (selectedMedia && selectedMedia.length > 0) {
                    const media = selectedMedia[0];
                    
                    // Atualizar campo hidden
                    const hiddenInput = document.getElementById('foto_existing_input');
                    if (hiddenInput) {
                        hiddenInput.value = `media:${media.id}`;
                    }
                    
                    // Mostrar preview
                    const preview = document.getElementById('fotoSelectedPreview');
                    const previewImg = document.getElementById('fotoSelectedPreviewImg');
                    
                    if (preview && previewImg) {
                        previewImg.src = media.url;
                        previewImg.alt = media.title || 'Imagem selecionada';
                        preview.style.display = 'block';
                    }
                }
            }
        });
    } else {
        alert('Biblioteca de mídia não disponível. Verifique se a página foi carregada corretamente.');
    }
}

function clearSelectedMedia() {
    // Limpar campo hidden
    const hiddenInput = document.getElementById('foto_existing_input');
    if (hiddenInput) {
        hiddenInput.value = '';
    }
    
    // Ocultar preview
    const preview = document.getElementById('fotoSelectedPreview');
    if (preview) {
        preview.style.display = 'none';
    }
}

// Export functions globally (mantido por compatibilidade)
window.addComissao = addComissao;
window.openMediaSelector = openMediaSelector;
window.clearSelectedMedia = clearSelectedMedia;

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
    
    // Botões da Biblioteca de Mídia
    const openMediaBtn = document.getElementById('openMediaSelectorBtn');
    if (openMediaBtn) {
        openMediaBtn.addEventListener('click', openMediaSelector);
    }
    
    const clearMediaBtn = document.getElementById('clearSelectedMediaBtn');
    if (clearMediaBtn) {
        clearMediaBtn.addEventListener('click', clearSelectedMedia);
    }
});