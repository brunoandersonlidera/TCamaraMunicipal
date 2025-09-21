// Funcionalidades para gerenciamento de notícias
document.addEventListener('DOMContentLoaded', function() {
    
    // Preview da imagem de destaque
    const imagemDestaque = document.getElementById('imagem_destaque');
    if (imagemDestaque) {
        imagemDestaque.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview-destaque');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
    }

    // Preview da galeria
    const galeriaImagens = document.getElementById('galeria_imagens');
    if (galeriaImagens) {
        galeriaImagens.addEventListener('change', function(e) {
            const files = e.target.files;
            const preview = document.getElementById('preview-galeria');
            preview.innerHTML = '';
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-4 mb-2';
                    col.innerHTML = `<img src="${e.target.result}" class="preview-image w-100" alt="Preview ${i+1}">`;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Contador de caracteres para resumo
    const resumo = document.getElementById('resumo');
    if (resumo) {
        resumo.addEventListener('input', function() {
            const maxLength = 500;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            let helpText = this.nextElementSibling;
            if (helpText && helpText.classList.contains('form-text')) {
                helpText.textContent = `${remaining} caracteres restantes`;
                helpText.className = remaining < 0 ? 'form-text text-danger' : 'form-text';
            }
        });
    }

    // Contador de caracteres para meta description
    const metaDescription = document.getElementById('meta_description');
    if (metaDescription) {
        metaDescription.addEventListener('input', function() {
            const maxLength = 160;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            let helpText = this.nextElementSibling;
            if (helpText && helpText.classList.contains('form-text')) {
                helpText.textContent = `${remaining} caracteres restantes`;
                helpText.className = remaining < 0 ? 'form-text text-danger' : 'form-text';
            }
        });
    }

    // Adicionar tag com Enter
    document.addEventListener('keydown', function(e) {
        if (e.target.name === 'tags[]' && e.key === 'Enter') {
            e.preventDefault();
            if (e.target.value.trim()) {
                addTag();
                e.target.focus();
            }
        }
    });
});

// Gerenciamento de tags
function addTag() {
    const container = document.getElementById('tags-container');
    const newTag = document.createElement('div');
    newTag.className = 'input-group mb-2';
    newTag.innerHTML = `
        <input type="text" class="form-control" name="tags[]" placeholder="Digite uma tag">
        <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(newTag);
}

function removeTag(button) {
    button.closest('.input-group').remove();
}