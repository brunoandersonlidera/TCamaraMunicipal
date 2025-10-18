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
        // Não carregar automaticamente via AJAX - preservar conteúdo renderizado pelo servidor
        // loadMedia() será chamado apenas quando filtros forem aplicados
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
            'application/pdf': '<i class="fas fa-file-pdf text-danger fa-3x"></i>',
            'text/plain': '<i class="fas fa-file-alt text-secondary fa-3x"></i>',
            'application/msword': '<i class="fas fa-file-word text-primary fa-3x"></i>',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document': '<i class="fas fa-file-word text-primary fa-3x"></i>',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': '<i class="fas fa-file-excel text-success fa-3x"></i>',
            'application/vnd.ms-excel': '<i class="fas fa-file-excel text-success fa-3x"></i>',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation': '<i class="fas fa-file-powerpoint text-warning fa-3x"></i>',
            'application/vnd.ms-powerpoint': '<i class="fas fa-file-powerpoint text-warning fa-3x"></i>',
            'application/zip': '<i class="fas fa-file-archive text-info fa-3x"></i>',
            'application/x-rar-compressed': '<i class="fas fa-file-archive text-info fa-3x"></i>',
            'video/mp4': '<i class="fas fa-file-video text-purple fa-3x"></i>',
            'video/avi': '<i class="fas fa-file-video text-purple fa-3x"></i>',
            'audio/mp3': '<i class="fas fa-file-audio text-success fa-3x"></i>',
            'audio/wav': '<i class="fas fa-file-audio text-success fa-3x"></i>'
        };

        return icons[mimeType] || '<i class="fas fa-file text-secondary fa-3x"></i>';
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
        const thumbnail = media.url || media.public_url || `/media/${media.file_name}`;
        const title = media.title || media.original_name || media.name || media.file_name || '';
        const categoryName = media.mediaCategory ? media.mediaCategory.name : 'Outros';

        return `
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                <div class="media-item card h-100" data-id="${media.id}">
                    <div class="media-preview">
                        ${isImage ? 
                            `<img src="${thumbnail}" alt="${media.alt_text || title}" class="card-img-top media-thumbnail">` :
                            `<div class="card-img-top media-icon d-flex align-items-center justify-content-center" style="height: 150px;">
                                ${getFileIcon(media.mime_type)}
                            </div>`
                        }
                        <div class="media-overlay">
                            <div class="media-actions">
                                <button class="btn btn-sm btn-primary view-media" data-id="${media.id}" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-info edit-media" data-id="${media.id}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-media" data-id="${media.id}" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <h6 class="card-title text-truncate mb-1" title="${title}">
                            ${title}
                        </h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">${media.formatted_size || '-'}</small>
                            <small class="badge bg-primary text-white">${categoryName}</small>
                        </div>
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
        // Redirecionar para a página de edição
        window.location.href = `/admin/media/${id}/edit`;
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
        console.log('BOTÃO SALVAR ENCONTRADO E LISTENER ADICIONADO');
        saveEditBtn.addEventListener('click', function() {
            console.log('BOTÃO SALVAR CLICADO!');
            alert('Botão salvar foi clicado! Vamos verificar os dados...');
            
            const form = document.getElementById('editForm');
            const formData = new FormData(form);
            const id = document.getElementById('editMediaId').value;
            
            alert('ID encontrado: ' + id);
            
            // Adicionar _method para Laravel reconhecer como PUT
            formData.append('_method', 'PUT');
            
            // Adicionar o campo de descrição que está fora do formulário
            const description = document.getElementById('editDescription').value;
            formData.append('description', description);
            
            // Verificar se a categoria foi selecionada
            const categoryId = document.getElementById('editCategory').value;
            if (!categoryId) {
                showAlert('Por favor, selecione uma categoria', 'warning');
                return;
            }
            
            // Adicionar informações de debug
            formData.append('debug_info', JSON.stringify({
                'browser': navigator.userAgent,
                'timestamp': new Date().toISOString(),
                'form_fields': {
                    'title': document.getElementById('editTitle')?.value,
                    'category_id': categoryId,
                    'alt_text': document.getElementById('editAltText')?.value,
                    'has_description': !!description
                }
            }));
            
            // Mostrar informações no console para debug
            console.log('=== DEBUG MEDIA UPDATE ===');
            console.log('ID do campo editMediaId:', id);
            console.log('Tipo do ID:', typeof id);
            console.log('ID é válido?', id && id !== '');
            console.log('URL da requisição:', `/admin/media/${id}`);
            console.log('Campos do formulário:', {
                'title': document.getElementById('editTitle')?.value,
                'category_id': categoryId,
                'alt_text': document.getElementById('editAltText')?.value,
                'description': description?.substring(0, 50) + (description?.length > 50 ? '...' : '')
            });
            
            // Verificar se o ID é válido antes de enviar
            if (!id || id === '') {
                showAlert('Erro: ID da mídia não encontrado', 'danger');
                return;
            }
            
            // Desabilitar botão durante o envio
            saveEditBtn.disabled = true;
            saveEditBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Salvando...';
            
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
                console.log('Resposta recebida:', response.status, response.statusText);
                
                if (!response.ok) {
                    const text = await response.text();
                    console.error('Erro na resposta:', text);
                    throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
                }
                
                try {
                    return response.json();
                } catch (e) {
                    console.error('Erro ao processar JSON:', e);
                    const text = await response.text();
                    console.log('Resposta não-JSON:', text.substring(0, 500));
                    throw new Error('Resposta inválida do servidor');
                }
            })
            .then(data => {
                console.log('Dados recebidos:', data);
                
                if (data.success) {
                    showAlert(data.message, 'success');
                    hideBootstrapModal(document.getElementById('editModal'));
                    loadMedia(); // Recarregar lista
                } else {
                    console.error('Erro reportado pelo servidor:', data);
                    showAlert(data.message || 'Erro ao salvar alterações', 'danger');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar mídia:', error);
                showAlert('Erro ao salvar alterações: ' + error.message, 'danger');
            })
            .finally(() => {
                // Reabilitar botão após o envio
                saveEditBtn.disabled = false;
                saveEditBtn.innerHTML = '<i class="fas fa-save me-1"></i>Salvar Alterações';
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

    /**
     * Funcionalidade de arrastar modais
     */
    function makeDraggable(modal) {
        if (!modal) return;
        
        const modalDialog = modal.querySelector('.modal-dialog');
        const modalHeader = modal.querySelector('.modal-header');
        
        if (!modalDialog || !modalHeader) return;
        
        let isDragging = false;
        let startX = 0;
        let startY = 0;
        let currentX = 0;
        let currentY = 0;
        
        // Adicionar classe CSS para indicar que é arrastável
        modalHeader.classList.add('draggable-header');
        modalDialog.classList.add('draggable-modal');
        
        function getEventPos(e) {
            return {
                x: e.type.includes('touch') ? e.touches[0].clientX : e.clientX,
                y: e.type.includes('touch') ? e.touches[0].clientY : e.clientY
            };
        }
        
        function dragStart(e) {
            // Verificar se o clique foi no cabeçalho e não em botões
            if (e.target.closest('.btn-close') || e.target.closest('button') || e.target.closest('.btn')) {
                return;
            }
            
            // Verificar se o clique foi realmente no cabeçalho
            if (!modalHeader.contains(e.target)) {
                return;
            }
            
            const pos = getEventPos(e);
            startX = pos.x - currentX;
            startY = pos.y - currentY;
            
            isDragging = true;
            modalDialog.style.transition = 'none';
            modalHeader.style.cursor = 'grabbing';
            document.body.style.userSelect = 'none';
            
            e.preventDefault();
        }
        
        function dragEnd(e) {
            if (!isDragging) return;
            
            isDragging = false;
            modalDialog.style.transition = '';
            modalHeader.style.cursor = 'grab';
            document.body.style.userSelect = '';
        }
        
        function drag(e) {
            if (!isDragging) return;
            
            e.preventDefault();
            
            const pos = getEventPos(e);
            let newX = pos.x - startX;
            let newY = pos.y - startY;
            
            // Obter dimensões da janela e do modal
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            const modalRect = modalDialog.getBoundingClientRect();
            
            // Limitar movimento para manter o modal visível
            const minX = -(modalRect.width - 100); // Deixar pelo menos 100px visível
            const maxX = windowWidth - 100;
            const minY = 0; // Não deixar subir acima do topo
            const maxY = windowHeight - 100; // Deixar pelo menos 100px visível
            
            newX = Math.max(minX, Math.min(maxX, newX));
            newY = Math.max(minY, Math.min(maxY, newY));
            
            currentX = newX;
            currentY = newY;
            
            modalDialog.style.transform = `translate(${currentX}px, ${currentY}px)`;
        }
        
        // Event listeners para mouse
        modalHeader.addEventListener('mousedown', dragStart, { passive: false });
        document.addEventListener('mouseup', dragEnd);
        document.addEventListener('mousemove', drag, { passive: false });
        
        // Event listeners para touch (dispositivos móveis)
        modalHeader.addEventListener('touchstart', dragStart, { passive: false });
        document.addEventListener('touchend', dragEnd);
        document.addEventListener('touchmove', drag, { passive: false });
        
        // Reset position quando o modal é fechado
        modal.addEventListener('hidden.bs.modal', function() {
            currentX = 0;
            currentY = 0;
            modalDialog.style.transform = '';
            modalDialog.style.transition = '';
            modalHeader.style.cursor = 'grab';
            document.body.style.userSelect = '';
        });
        
        // Reset position quando o modal é aberto
        modal.addEventListener('shown.bs.modal', function() {
            currentX = 0;
            currentY = 0;
            modalDialog.style.transform = '';
            modalHeader.style.cursor = 'grab';
        });
    }
    
    /**
     * Inicializar funcionalidade de arrastar para todos os modais
     */
    function initDraggableModals() {
        // Modais da biblioteca de mídia
        const modals = [
            document.getElementById('uploadModal'),
            document.getElementById('viewModal'),
            document.getElementById('editModal'),
            document.getElementById('mediaSelectModal'),
            document.getElementById('mediaSelectorModal')
        ];
        
        modals.forEach(modal => {
            if (modal) {
                makeDraggable(modal);
            }
        });
        
        // Observer para novos modais que possam ser criados dinamicamente
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && node.classList && node.classList.contains('modal')) {
                        makeDraggable(node);
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    // Inicializar quando o DOM estiver pronto
    init();
    initDraggableModals();

    /**
     * Função para abrir a biblioteca de mídia (exportada globalmente)
     */
    window.openMediaLibrary = function(options = {}) {
        const modal = document.getElementById('mediaSelectModal');
        if (!modal) {
            console.error('Modal mediaSelectModal não encontrado');
            return;
        }

        // Configurar opções
        window.mediaLibraryOptions = {
            multiple: options.multiple || false,
            type: options.type || 'all',
            onSelect: options.onSelect || function() {}
        };

        // Abrir modal
        showBootstrapModal(modal);
    };
});