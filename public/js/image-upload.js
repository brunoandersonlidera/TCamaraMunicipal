// Image Upload Component JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const uploadComponents = document.querySelectorAll('.file-upload-component');
    
    uploadComponents.forEach(function(component) {
        initFileUpload(component);
    });
});

function initFileUpload(component) {
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
    const allowPdf = component.dataset.allowPdf === 'true';
    
    let selectedFiles = [];
    let uploadedFiles = [];

    // Drag and drop events
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        if (uploadZone && uploadZone.classList) {
            try {
                uploadZone.classList.add('dragover');
            } catch (error) {
                console.warn('Erro ao adicionar classe dragover:', error);
            }
        }
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        if (uploadZone && uploadZone.classList) {
            try {
                uploadZone.classList.remove('dragover');
            } catch (error) {
                console.warn('Erro ao remover classe dragover:', error);
            }
        }
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        if (uploadZone && uploadZone.classList) {
            try {
                uploadZone.classList.remove('dragover');
            } catch (error) {
                console.warn('Erro ao remover classe dragover:', error);
            }
        }
        
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
        let allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        let typeMessage = 'Use apenas imagens (JPEG, PNG, GIF, WebP)';
        
        if (allowPdf) {
            allowedTypes.push('application/pdf');
            typeMessage = 'Use apenas imagens (JPEG, PNG, GIF, WebP) ou arquivos PDF';
        }
        
        if (!allowedTypes.includes(file.type)) {
            showError(`Tipo de arquivo não permitido: ${file.name}. ${typeMessage}.`);
            return false;
        }
        
        // Check file size
        if (file.size > maxSize) {
            const maxSizeMB = (maxSize / (1024 * 1024)).toFixed(1);
            showError(`Arquivo muito grande: ${file.name}. Tamanho máximo: ${maxSizeMB}MB.`);
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
        div.className = 'preview-item col-md-4 col-sm-6';
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-btn';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.onclick = function() {
            removeFile(index);
        };
        
        const fileInfo = document.createElement('div');
        fileInfo.className = 'file-info';
        
        const fileName = document.createElement('div');
        fileName.className = 'file-name';
        fileName.textContent = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
        fileName.title = file.name;
        
        const fileSize = document.createElement('div');
        fileSize.className = 'file-size';
        fileSize.textContent = formatFileSize(file.size);
        
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.className = 'preview-image';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            div.appendChild(img);
        } else if (file.type === 'application/pdf') {
            const pdfIcon = document.createElement('div');
            pdfIcon.className = 'pdf-preview';
            pdfIcon.innerHTML = '<i class="fas fa-file-pdf fa-4x text-danger"></i>';
            div.appendChild(pdfIcon);
        }
        
        fileInfo.appendChild(fileName);
        fileInfo.appendChild(fileSize);
        
        div.appendChild(removeBtn);
        div.appendChild(fileInfo);
        
        return div;
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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
window.initFileUpload = initFileUpload;
window.initImageUpload = initFileUpload; // Backward compatibility