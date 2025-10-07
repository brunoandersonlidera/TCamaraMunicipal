/**
 * Biblioteca de Mídia - JavaScript
 * Sistema TCamaraMunicipal
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elementos principais
    const uploadModal = document.getElementById('uploadModal');
    const viewModal = document.getElementById('viewModal');
    const editModal = document.getElementById('editModal');
    const uploadForm = document.getElementById('uploadForm');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    // Quick upload (em modal de seleção)
    const quickUploadForm = document.getElementById('mediaQuickUploadForm');
    const quickUploadFiles = document.getElementById('quickUploadFiles');
    const quickUploadCategory = document.getElementById('quickUploadCategory');
    const quickUploadBtn = document.getElementById('quickUploadBtn');

    // Fallback global: bloquear submissão nativa do formulário de Upload Rápido
    // Evita navegação para /admin/media e exibição de JSON, acionando o fluxo via AJAX
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form && form.id === 'mediaQuickUploadForm') {
            e.preventDefault();
            e.stopPropagation();
            try {
                handleQuickUpload(e);
            } catch (err) {
                console.error('Erro ao acionar upload rápido:', err);
            }
        }
    }, true);
    
    // Filtros
    const categoryFilter = document.getElementById('categoryFilter');
    const typeFilter = document.getElementById('typeFilter');
    const searchInput = document.getElementById('searchInput');
    
    // Botões
    const uploadBtn = document.getElementById('uploadBtn');

    /**
     * Inicialização
     */
    function init() {
        setupEventListeners();
        setupDragAndDrop();
        loadMedia();
    }

    /**
     * Configurar event listeners
     */
    function setupEventListeners() {
        // Upload de arquivos
        if (fileInput) {
            fileInput.addEventListener('change', handleFileSelect);
        }

        // Quick upload no modal de seleção
        if (quickUploadForm) {
            quickUploadForm.addEventListener('submit', handleQuickUpload);
        }
        // Evitar submit padrão: botão passa a ser "button" e dispara o flow via JS
        if (quickUploadBtn) {
            quickUploadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (quickUploadForm) {
                    quickUploadForm.dispatchEvent(new Event('submit', { cancelable: true }));
                }
            });
        }

        // Filtros
        if (categoryFilter) {
            categoryFilter.addEventListener('change', applyFilters);
        }
        if (typeFilter) {
            typeFilter.addEventListener('change', applyFilters);
        }
        if (searchInput) {
            searchInput.addEventListener('input', debounce(applyFilters, 300));
        }

        // Botões de ação
        if (uploadBtn) {
            uploadBtn.addEventListener('click', handleUpload);
        }

        // Formulário de upload
        if (uploadForm) {
            uploadForm.addEventListener('submit', handleUpload);
        }

        // Fechar modais ao clicar fora
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                closeModal(e.target);
            }
        });

        // Delegação de eventos para botões do grid renderizado via Blade
        document.addEventListener('click', function(e) {
            const viewBtn = e.target.closest('.view-media');
            if (viewBtn) {
                e.preventDefault();
                const id = viewBtn.getAttribute('data-id');
                if (id) window.viewMedia(id);
                return;
            }

            const editBtn = e.target.closest('.edit-media');
            if (editBtn) {
                e.preventDefault();
                const id = editBtn.getAttribute('data-id');
                if (id) window.editMedia(id);
                return;
            }

            const deleteBtn = e.target.closest('.delete-media');
            if (deleteBtn) {
                e.preventDefault();
                const id = deleteBtn.getAttribute('data-id');
                if (id) window.deleteMedia(id);
                return;
            }
        });
    }

    // Helper para obter CSRF de meta ou input hidden
    function getCsrfToken(formEl) {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta && meta.getAttribute('content')) return meta.getAttribute('content');
        const tokenInput = formEl ? formEl.querySelector('input[name="_token"]') : null;
        return tokenInput ? tokenInput.value : '';
    }

    /**
     * Configurar drag and drop
     */
    function setupDragAndDrop() {
        const dropZone = document.getElementById('dropZone');
        if (!dropZone) return;

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        dropZone.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            dropZone.classList.add('drag-over');
        }

        function unhighlight(e) {
            dropZone.classList.remove('drag-over');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
    }

    /**
     * Manipular seleção de arquivos
     */
    function handleFileSelect(e) {
        const files = e.target.files;
        handleFiles(files);
    }

    /**
     * Processar arquivos selecionados
     */
    function handleFiles(files) {
        if (!files || files.length === 0) return;

        filePreview.innerHTML = '';
        
        Array.from(files).forEach(file => {
            if (validateFile(file)) {
                createPreview(file);
            }
        });
    }

    /**
     * Validar arquivo
     */
    function validateFile(file) {
        const maxSize = 50 * 1024 * 1024; // 50MB
        const allowedTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/svg+xml',
            'application/pdf', 'text/plain', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // vídeos comuns
            'video/mp4', 'video/webm', 'video/ogg'
        ];

        if (file.size > maxSize) {
            showAlert('Arquivo muito grande. Tamanho máximo: 50MB por arquivo.', 'error');
            return false;
        }

        if (!allowedTypes.includes(file.type)) {
            showAlert('Tipo de arquivo não permitido', 'error');
            return false;
        }

        return true;
    }

    /**
     * Criar preview do arquivo
     */
    function createPreview(file) {
        const previewItem = document.createElement('div');
        previewItem.className = 'preview-item';

        const isImage = file.type.startsWith('image/');
        
        if (isImage) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);
            previewItem.appendChild(img);
        } else {
            const icon = document.createElement('div');
            icon.className = 'file-icon';
            icon.innerHTML = getFileIcon(file.type);
            previewItem.appendChild(icon);
        }

        const info = document.createElement('div');
        info.className = 'file-info';
        info.innerHTML = `
            <div class="file-name">${file.name}</div>
            <div class="file-size">${formatFileSize(file.size)}</div>
        `;
        previewItem.appendChild(info);

        filePreview.appendChild(previewItem);
    }

    /**
     * Obter ícone do arquivo
     */
    function getFileIcon(mimeType) {
        const icons = {
            'application/pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            'text/plain': '<i class="fas fa-file-alt text-secondary"></i>',
            'application/msword': '<i class="fas fa-file-word text-primary"></i>',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document': '<i class="fas fa-file-word text-primary"></i>'
        };

        return icons[mimeType] || '<i class="fas fa-file text-secondary"></i>';
    }

    /**
     * Formatar tamanho do arquivo
     */
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    /**
     * Manipular upload
     */
    function handleUpload(e) {
        e.preventDefault();
        const submitBtn = uploadBtn;

        // Validações de quantidade e tamanho por arquivo
        const files = fileInput ? fileInput.files : [];
        if (!files || files.length === 0) {
            showAlert('Selecione ao menos um arquivo para enviar.', 'error');
            return;
        }
        if (files.length > 20) {
            showAlert('Você pode enviar no máximo 20 arquivos por vez.', 'error');
            return;
        }
        const maxBytes = 50 * 1024 * 1024; // 50MB
        for (const file of files) {
            if (file.size > maxBytes) {
                showAlert(`O arquivo "${file.name}" excede o limite de 50MB.`, 'error');
                return;
            }
        }

        const formData = new FormData(uploadForm);
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';

        fetch('/admin/media', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(uploadForm),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            // Tentar interpretar como JSON; se falhar, coletar texto para diagnosticar
            let data;
            try {
                data = await response.json();
            } catch (e) {
                const text = await response.text();
                console.error('Resposta não-JSON no upload:', text);
                throw new Error(`Falha no upload (HTTP ${response.status}).`);
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                showAlert('Arquivo enviado com sucesso!', 'success');
                closeModal(uploadModal);
                loadMedia();
                uploadForm.reset();
                if (filePreview) {
                    filePreview.innerHTML = '';
                }
            } else {
                showAlert(data.message || 'Erro ao enviar arquivo', 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('Erro ao enviar arquivo', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-upload"></i> Enviar';
        });
    }

    /**
     * Upload rápido (modal de seleção)
     */
    function handleQuickUpload(e) {
        e.preventDefault();
        const files = quickUploadFiles ? quickUploadFiles.files : [];
        if (!files || files.length === 0) {
            showAlert('Selecione ao menos um arquivo para enviar.', 'error');
            return;
        }
        if (files.length > 20) {
            showAlert('Você pode enviar no máximo 20 arquivos por vez.', 'error');
            return;
        }
        const maxBytes = 50 * 1024 * 1024; // 50MB
        for (const file of files) {
            if (file.size > maxBytes) {
                showAlert(`O arquivo "${file.name}" excede o limite de 50MB.`, 'error');
                return;
            }
        }

        if (quickUploadCategory && !quickUploadCategory.value) {
            showAlert('Selecione uma categoria.', 'error');
            return;
        }

        const formData = new FormData(quickUploadForm);

        if (quickUploadBtn) {
            quickUploadBtn.disabled = true;
            quickUploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        }

        fetch('/admin/media', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(quickUploadForm),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            let data;
            try {
                data = await response.json();
            } catch (e) {
                const text = await response.text();
                console.error('Resposta não-JSON no upload rápido:', text);
                throw new Error(`Falha no upload (HTTP ${response.status}).`);
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                showAlert('Arquivo enviado com sucesso!', 'success');
                // Tentar atualizar a grid do modal de seleção, se disponível
                if (typeof window.loadMediaPage === 'function') {
                    try {
                        const categorySel = document.getElementById('mediaCategoryFilter');
                        const typeSel = document.getElementById('mediaTypeFilter');
                        const searchInp = document.getElementById('mediaSearchInput');
                        const category = categorySel ? categorySel.value : (quickUploadCategory ? quickUploadCategory.value : '');
                        const type = typeSel ? typeSel.value : '';
                        const search = searchInp ? searchInp.value : '';
                        window.loadMediaPage(1, { category, type, search });
                    } catch (e) {
                        console.warn('Falha ao atualizar grid do modal:', e);
                    }
                    // Manter o modal e o painel de upload rápido abertos
                    // (não fechar o collapse), permitindo novos envios em sequência
                    // Limpar seleção
                    if (quickUploadFiles) quickUploadFiles.value = '';
                } else if (typeof loadMedia === 'function') {
                    // Página da biblioteca
                    loadMedia();
                } else {
                    // Sem recarregar a página para evitar mostrar JSON
                    console.debug('Upload concluído, nenhuma UI de grid disponível para atualização.');
                }
            } else {
                showAlert(data.message || 'Erro ao enviar arquivo', 'error');
            }
        })
        .catch(error => {
            console.error('Erro (upload rápido):', error);
            showAlert('Erro ao enviar arquivo', 'error');
        })
        .finally(() => {
            if (quickUploadBtn) {
                quickUploadBtn.disabled = false;
                quickUploadBtn.innerHTML = '<i class="fas fa-cloud-upload-alt me-1"></i> Enviar';
            }
        });
    }

    /**
     * Aplicar filtros
     */
    function applyFilters() {
        const category = categoryFilter ? categoryFilter.value : '';
        const type = typeFilter ? typeFilter.value : '';
        const search = searchInput ? searchInput.value : '';

        const params = new URLSearchParams();
        if (category) params.append('category', category);
        if (type) params.append('type', type);
        if (search) params.append('search', search);

        loadMedia(params.toString());
    }

    /**
     * Carregar mídia
     */
    function loadMedia(queryString = '') {
        const url = '/admin/media-api' + (queryString ? '?' + queryString : '');
        
        fetch(url)
        .then(response => response.json())
        .then(data => {
            updateMediaGrid(data.media);
            updatePagination(data.pagination);
        })
        .catch(error => {
            console.error('Erro ao carregar mídia:', error);
            showAlert('Erro ao carregar arquivos', 'error');
        });
    }

    /**
     * Carregar página específica de mídia
     */
    function loadMediaPage(page) {
        const params = new URLSearchParams();
        
        if (categoryFilter.value) params.append('category', categoryFilter.value);
        if (typeFilter.value) params.append('type', typeFilter.value);
        if (searchInput.value) params.append('search', searchInput.value);
        params.append('page', page);

        fetch(`/admin/media-api?${params}`)
            .then(response => response.json())
            .then(data => {
                updateMediaGrid(data.media);
                updatePagination(data.pagination);
            })
            .catch(error => {
                console.error('Erro ao carregar mídia:', error);
            });
    }

    /**
     * Atualizar grid de mídia
     */
    function updateMediaGrid(media) {
        const grid = document.getElementById('mediaGrid');
        if (!grid) return;

        if (media.length === 0) {
            grid.innerHTML = `
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Nenhum arquivo encontrado</p>
                    </div>
                </div>
            `;
            return;
        }

        grid.innerHTML = media.map(item => createMediaCard(item)).join('');
    }

    /**
     * Atualizar paginação
     */
    function updatePagination(pagination) {
        const paginationContainer = document.getElementById('mediaPagination');
        if (!paginationContainer || !pagination) return;

        if (pagination.last_page <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let paginationHtml = '<nav aria-label="Navegação de páginas"><ul class="pagination pagination-sm justify-content-center">';
        
        // Botão Anterior
        if (pagination.current_page > 1) {
            paginationHtml += `<li class="page-item">
                <a class="page-link" href="#" data-page="${pagination.current_page - 1}" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;
        } else {
            paginationHtml += `<li class="page-item disabled">
                <span class="page-link" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                </span>
            </li>`;
        }

        // Páginas
        const startPage = Math.max(1, pagination.current_page - 2);
        const endPage = Math.min(pagination.last_page, pagination.current_page + 2);

        if (startPage > 1) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (startPage > 2) {
                paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === pagination.current_page) {
                paginationHtml += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
        }

        if (endPage < pagination.last_page) {
            if (endPage < pagination.last_page - 1) {
                paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.last_page}">${pagination.last_page}</a></li>`;
        }

        // Botão Próximo
        if (pagination.current_page < pagination.last_page) {
            paginationHtml += `<li class="page-item">
                <a class="page-link" href="#" data-page="${pagination.current_page + 1}" aria-label="Próximo">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;
        } else {
            paginationHtml += `<li class="page-item disabled">
                <span class="page-link" aria-label="Próximo">
                    <span aria-hidden="true">&raquo;</span>
                </span>
            </li>`;
        }

        paginationHtml += '</ul></nav>';
        paginationContainer.innerHTML = paginationHtml;

        // Adicionar event listeners para os links de paginação
        paginationContainer.querySelectorAll('a.page-link[data-page]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                loadMediaPage(page);
            });
        });
    }

    /**
     * Criar card de mídia
     */
    function createMediaCard(media) {
        const isImage = media.mime_type && media.mime_type.startsWith('image/');
        // Prefer backend-provided URL (appended accessor), fallback to public_url or route by file_name
        const thumbnail = isImage ? (media.url || media.public_url || `/media/${media.file_name}`) : getFileIcon(media.mime_type);

        return `
            <div class="col-md-3 col-sm-4 col-6 mb-4">
                <div class="media-card" data-id="${media.id}">
                    <div class="media-checkbox">
                        <input type="checkbox" class="form-check-input" value="${media.id}">
                    </div>
                    <div class="media-thumbnail">
                        ${isImage ? 
                            `<img src="${thumbnail}" alt="${media.alt_text || media.original_name}" class="img-fluid media-thumbnail" loading="lazy">` :
                            `<div class="file-icon-large">${thumbnail}</div>`
                        }
                    </div>
                    <div class="media-info">
                        <div class="media-title" title="${media.original_name || media.name || media.file_name || ''}">${media.original_name || media.name || media.file_name || ''}</div>
                        <div class="media-meta">
                            <small class="text-muted">${media.formatted_size || formatFileSize(media.size) || '-'}</small>
                            <small class="text-muted">${media.category || media.collection_name || '-'}</small>
                        </div>
                    </div>
                    <div class="media-actions">
                        <button class="btn btn-sm btn-outline-primary view-media" data-id="${media.id}" onclick="viewMedia(${media.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary edit-media" data-id="${media.id}" onclick="editMedia(${media.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-media" data-id="${media.id}" onclick="deleteMedia(${media.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Debounce function
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }



    /**
     * Fechar modal
     */
    // Bootstrap 5 modal helpers (no jQuery)
    function showBootstrapModal(modalEl) {
        if (!modalEl) return;
        const instance = bootstrap.Modal.getOrCreateInstance(modalEl);
        instance.show();
    }

    function hideBootstrapModal(modalEl) {
        if (!modalEl) return;
        const instance = bootstrap.Modal.getInstance(modalEl);
        if (instance) instance.hide();
    }

    function closeModal(modal) {
        if (modal) {
            hideBootstrapModal(modal);
        }
    }

    // Funções globais
    window.viewMedia = function(id) {
        console.log('viewMedia called with id:', id);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        console.log('CSRF Token:', csrfToken);
        
        // TESTE: Usar rota sem autenticação
        fetch(`/test-media-api/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(async response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                if (!response.ok) {
                    const text = await response.text();
                    console.error('Response error text:', text);
                    throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const media = data.data;
                    console.debug('Media (view):', media);
                    const modal = document.getElementById('viewModal');
                    
                    // Atualizar conteúdo do modal
                    const title = media.title || media.original_name || media.name || media.file_name || '-';
                    document.getElementById('viewTitle').textContent = title;
                    document.getElementById('viewFilename').textContent = media.file_name || media.filename || '-';
                    document.getElementById('viewSize').textContent = media.formatted_size || (media.size ? formatFileSize(media.size) : '-');
                    document.getElementById('viewType').textContent = media.mime_type || '-';
                    const createdAt = media.created_at ? new Date(media.created_at) : null;
                    document.getElementById('viewUploadDate').textContent = (createdAt && !isNaN(createdAt)) ? createdAt.toLocaleDateString('pt-BR') : '-';
                    document.getElementById('viewUploader').textContent = (media.uploader && media.uploader.name) ? media.uploader.name : 'N/A';

                    // URLs
                    const publicUrlEl = document.getElementById('viewPublicUrlLink');
                    const routeTextEl = document.getElementById('viewRouteText');
                    if (publicUrlEl) {
                        publicUrlEl.href = media.public_url || '#';
                        publicUrlEl.textContent = media.public_url || '-';
                    }
                    if (routeTextEl) {
                        routeTextEl.textContent = media.url || '-';
                    }
                    
                    const isImage = media.is_image || (media.mime_type && media.mime_type.startsWith('image/'));
                    if (isImage) {
                        // Usar rota interna (media.url) ou fallback da URL pública (media.public_url)
                        document.getElementById('viewImage').src = media.url || media.public_url || '';
                        const imgEl = document.getElementById('viewImage');
                        if (imgEl.src) {
                            imgEl.style.display = 'block';
                        } else {
                            imgEl.style.display = 'none';
                        }
                    } else {
                        document.getElementById('viewImage').style.display = 'none';
                    }
                    
                    showBootstrapModal(modal);
                }
            })
            .catch(error => {
                console.error('Erro ao carregar mídia:', error);
                showAlert('Erro ao carregar informações da mídia', 'danger');
            });
    };

    window.editMedia = function(id) {
        console.log('editMedia called with ID:', id);
        fetch(`/test-media-api/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const media = data.data;
                    console.debug('Media (edit):', media);
                    const modal = document.getElementById('editModal');
                    
                    // Preencher formulário
                    document.getElementById('editMediaId').value = media.id;
                    document.getElementById('editTitle').value = media.title || media.original_name || media.name || '';
                    document.getElementById('editAltText').value = media.alt_text || '';
                    document.getElementById('editDescription').value = media.description || '';
                    document.getElementById('editCategory').value = media.category || media.collection_name || '';
                    
                    showBootstrapModal(modal);
                }
            })
            .catch(error => {
                console.error('Erro ao carregar mídia:', error);
                showAlert('Erro ao carregar informações da mídia', 'danger');
            });
    };

    window.deleteMedia = function(id) {
        if (confirm('Tem certeza que deseja excluir este arquivo? Esta ação não pode ser desfeita.')) {
            fetch(`/admin/media/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    loadMedia(); // Recarregar lista
                } else {
                    showAlert(data.message || 'Erro ao excluir arquivo', 'danger');
                }
            })
            .catch(error => {
                console.error('Erro ao excluir mídia:', error);
                showAlert('Erro ao excluir arquivo', 'danger');
            });
        }
    };

    // Salvar edição
    const saveEditBtn = document.getElementById('saveEditBtn');
    if (saveEditBtn) {
        saveEditBtn.addEventListener('click', function() {
            const form = document.getElementById('editForm');
            const formData = new FormData(form);
            const id = document.getElementById('editMediaId').value;
            
            // Adicionar _method para Laravel reconhecer como PUT
            formData.append('_method', 'PUT');
            
            fetch(`/admin/media/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    hideBootstrapModal(document.getElementById('editModal'));
                    loadMedia(); // Recarregar lista
                } else {
                    showAlert(data.message || 'Erro ao salvar alterações', 'danger');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar mídia:', error);
                showAlert('Erro ao salvar alterações', 'danger');
            });
        });
    }

    // Função para mostrar alertas
    function showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-remover após 5 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Inicializar quando o DOM estiver pronto
    init();
});