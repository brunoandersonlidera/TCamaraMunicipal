// Image Upload Component JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const uploadComponents = document.querySelectorAll('.image-upload-component');
    
    uploadComponents.forEach(function(component) {
        initImageUpload(component);
    });
});

function initImageUpload(component) {
    const fileInput = component.querySelector('.file-input');
    const uploadZone = component.querySelector('.upload-zone');
    const previewArea = component.querySelector('.preview-area');
    const previewGrid = component.querySelector('.preview-grid');
    const progressArea = component.querySelector('.upload-progress');
    const progressBar = component.querySelector('.progress-bar');
    const uploadStatus = component.querySelector('.upload-status');
    const errorsArea = component.querySelector('.upload-errors');
    
    const name = component.dataset.name;
    const multiple = component.dataset.multiple === 'true';
    const maxFiles = parseInt(component.dataset.maxFiles);
    const maxSize = parseInt(component.dataset.maxSize) * 1024; // Convert to bytes
    
    let selectedFiles = [];
    let uploadedFiles = [];

    // Drag and drop events
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    // File input change
    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        handleFiles(files);
    });

    function handleFiles(files) {
        clearErrors();
        
        // Validate files
        const validFiles = [];
        
        files.forEach(function(file) {
            if (validateFile(file)) {
                validFiles.push(file);
            }
        });
        
        if (validFiles.length === 0) return;
        
        // Add files to selection
        if (multiple) {
            // Check total files limit
            if (selectedFiles.length + validFiles.length > maxFiles) {
                showError(`Máximo de ${maxFiles} arquivos permitidos.`);
                return;
            }
            selectedFiles = selectedFiles.concat(validFiles);
        } else {
            selectedFiles = [validFiles[0]];
        }
        
        updatePreview();
        updateFileInput();
    }

    function validateFile(file) {
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            showError(`Tipo de arquivo não permitido: ${file.name}. Use apenas imagens (JPEG, PNG, GIF, WebP).`);
            return false;
        }
        
        // Check file size
        if (file.size > maxSize) {
            const maxSizeMB = maxSize / 1024;
            showError(`Arquivo muito grande: ${file.name}. Tamanho máximo: ${maxSizeMB}KB.`);
            return false;
        }
        
        return true;
    }

    function updatePreview() {
        previewGrid.innerHTML = '';
        
        selectedFiles.forEach(function(file, index) {
            const previewItem = createPreviewItem(file, index);
            previewGrid.appendChild(previewItem);
        });
        
        previewArea.style.display = selectedFiles.length > 0 ? 'block' : 'none';
    }

    function createPreviewItem(file, index) {
        const div = document.createElement('div');
        div.className = 'preview-item';
        
        const img = document.createElement('img');
        img.className = 'preview-image';
        
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn-remove';
        removeBtn.innerHTML = '×';
        removeBtn.onclick = function() {
            removeFile(index);
        };
        
        const fileName = document.createElement('div');
        fileName.className = 'file-name';
        fileName.textContent = file.name;
        
        div.appendChild(img);
        div.appendChild(removeBtn);
        div.appendChild(fileName);
        
        return div;
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        updatePreview();
        updateFileInput();
    }

    function updateFileInput() {
        // Create new FileList
        const dt = new DataTransfer();
        selectedFiles.forEach(function(file) {
            dt.items.add(file);
        });
        fileInput.files = dt.files;
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger alert-sm';
        errorDiv.textContent = message;
        errorsArea.appendChild(errorDiv);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            errorDiv.remove();
        }, 5000);
    }

    function clearErrors() {
        errorsArea.innerHTML = '';
    }
}

// Export functions globally
window.initImageUpload = initImageUpload;