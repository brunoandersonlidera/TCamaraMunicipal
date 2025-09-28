/**
 * ===================================
 * SISTEMA DE LEIS - JAVASCRIPT
 * ===================================
 */

(function() {
    'use strict';

    // ===================================
    // VARIÁVEIS GLOBAIS
    // ===================================
    let filtrosForm = null;
    let loadingOverlay = null;
    let searchTimeout = null;
    let currentPage = 1;
    let isLoading = false;

    // ===================================
    // INICIALIZAÇÃO
    // ===================================
    document.addEventListener('DOMContentLoaded', function() {
        initializeComponents();
        initializeTooltips();
        initializeModals();
        
        // Verificar se há parâmetros de busca na URL
        checkUrlParameters();
    });

    // ===================================
    // INICIALIZAÇÃO DE COMPONENTES
    // ===================================
    function initializeComponents() {
        filtrosForm = document.getElementById('filtros-form');
        loadingOverlay = document.getElementById('loading-overlay');
        
        // Inicializar componentes específicos da página
        if (document.querySelector('.leis-grid')) {
            initializeListPage();
        }
        
        if (document.querySelector('.lei-detalhes-card')) {
            initializeDetailPage();
        }
        
        if (document.querySelector('.admin-leis-table')) {
            initializeAdminPage();
        }
    }

    // ===================================
    // PÁGINA DE LISTAGEM
    // ===================================
    function initializeListPage() {
        // Configurar busca em tempo real
        const searchInput = document.getElementById('busca');
        if (searchInput) {
            searchInput.addEventListener('input', debounce(handleSearch, 500));
        }

        // Configurar filtros
        const filtroTipo = document.getElementById('tipo');
        const filtroExercicio = document.getElementById('exercicio');
        const filtroOrdenacao = document.getElementById('ordenacao');

        if (filtroTipo) {
            filtroTipo.addEventListener('change', handleFilterChange);
        }
        
        if (filtroExercicio) {
            filtroExercicio.addEventListener('change', handleFilterChange);
        }
        
        if (filtroOrdenacao) {
            filtroOrdenacao.addEventListener('change', handleFilterChange);
        }

        // Configurar botão de limpar filtros
        const btnLimparFiltros = document.getElementById('btn-limpar-filtros');
        if (btnLimparFiltros) {
            btnLimparFiltros.addEventListener('click', clearFilters);
        }

        // Configurar paginação
        initializePagination();
    }

    // ===================================
    // PÁGINA DE DETALHES
    // ===================================
    function initializeDetailPage() {
        // Configurar botões de ação
        const btnCompartilhar = document.getElementById('btn-compartilhar');
        const btnImprimir = document.getElementById('btn-imprimir');
        const btnDownloadPdf = document.getElementById('btn-download-pdf');

        if (btnCompartilhar) {
            btnCompartilhar.addEventListener('click', openShareModal);
        }

        if (btnImprimir) {
            btnImprimir.addEventListener('click', printPage);
        }

        if (btnDownloadPdf) {
            btnDownloadPdf.addEventListener('click', downloadPdf);
        }

        // Configurar busca rápida na sidebar
        const buscaRapida = document.getElementById('busca-rapida');
        if (buscaRapida) {
            buscaRapida.addEventListener('input', debounce(handleQuickSearch, 300));
        }

        // Configurar navegação entre leis
        initializeNavigation();
    }

    // ===================================
    // PÁGINA ADMINISTRATIVA
    // ===================================
    function initializeAdminPage() {
        // Configurar busca administrativa
        const adminSearch = document.getElementById('admin-busca');
        if (adminSearch) {
            adminSearch.addEventListener('input', debounce(handleAdminSearch, 500));
        }

        // Configurar filtros administrativos
        const adminFiltros = document.querySelectorAll('.admin-filtro');
        adminFiltros.forEach(filtro => {
            filtro.addEventListener('change', handleAdminFilterChange);
        });

        // Configurar ações em lote
        initializeBulkActions();

        // Configurar confirmação de exclusão
        initializeDeleteConfirmation();

        // Configurar formulário de lei
        if (document.getElementById('lei-form')) {
            initializeLeiForm();
        }
    }

    // ===================================
    // BUSCA E FILTROS
    // ===================================
    function handleSearch(event) {
        if (isLoading) return;
        
        const searchTerm = event.target.value.trim();
        updateUrlParameter('busca', searchTerm);
        performSearch();
    }

    function handleFilterChange(event) {
        if (isLoading) return;
        
        const filterName = event.target.name;
        const filterValue = event.target.value;
        
        updateUrlParameter(filterName, filterValue);
        performSearch();
    }

    function performSearch() {
        if (isLoading) return;
        
        showLoading();
        
        const formData = new FormData(filtrosForm);
        const params = new URLSearchParams(formData);
        
        // Adicionar página atual
        params.set('page', currentPage);
        
        fetch(`${window.location.pathname}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateResultsSection(data.html);
                updateResultsInfo(data.info);
                updatePagination(data.pagination);
                updateUrl(params);
            } else {
                showError('Erro ao carregar resultados');
            }
        })
        .catch(error => {
            console.error('Erro na busca:', error);
            showError('Erro ao realizar busca');
        })
        .finally(() => {
            hideLoading();
        });
    }

    function clearFilters() {
        if (filtrosForm) {
            filtrosForm.reset();
            
            // Limpar URL
            const url = new URL(window.location);
            url.search = '';
            window.history.replaceState({}, '', url);
            
            // Recarregar resultados
            currentPage = 1;
            performSearch();
        }
    }

    // ===================================
    // BUSCA RÁPIDA (SIDEBAR)
    // ===================================
    function handleQuickSearch(event) {
        const searchTerm = event.target.value.trim();
        
        if (searchTerm.length < 2) {
            clearQuickSearchResults();
            return;
        }
        
        fetch(`/leis/busca-ajax?q=${encodeURIComponent(searchTerm)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateQuickSearchResults(data.leis);
            }
        })
        .catch(error => {
            console.error('Erro na busca rápida:', error);
        });
    }

    function updateQuickSearchResults(leis) {
        const resultsContainer = document.getElementById('busca-rapida-resultados');
        if (!resultsContainer) return;
        
        if (leis.length === 0) {
            resultsContainer.innerHTML = '<p class="text-muted small">Nenhuma lei encontrada</p>';
            return;
        }
        
        let html = '';
        leis.forEach(lei => {
            html += `
                <div class="lei-relacionada">
                    <a href="${lei.url}">
                        <div class="relacionada-tipo">
                            <span class="badge badge-tipo badge-${lei.tipo_slug}">${lei.tipo}</span>
                        </div>
                        <div class="relacionada-titulo">${lei.numero_formatado}</div>
                        <div class="relacionada-descricao">${lei.titulo}</div>
                        <div class="relacionada-data">${lei.data_formatada}</div>
                    </a>
                </div>
            `;
        });
        
        resultsContainer.innerHTML = html;
    }

    function clearQuickSearchResults() {
        const resultsContainer = document.getElementById('busca-rapida-resultados');
        if (resultsContainer) {
            resultsContainer.innerHTML = '';
        }
    }

    // ===================================
    // PAGINAÇÃO
    // ===================================
    function initializePagination() {
        document.addEventListener('click', function(event) {
            if (event.target.matches('.pagination a')) {
                event.preventDefault();
                
                const url = new URL(event.target.href);
                const page = url.searchParams.get('page');
                
                if (page && page !== currentPage.toString()) {
                    currentPage = parseInt(page);
                    updateUrlParameter('page', page);
                    performSearch();
                }
            }
        });
    }

    // ===================================
    // COMPARTILHAMENTO
    // ===================================
    function openShareModal() {
        const modal = document.getElementById('modal-compartilhar');
        if (modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            
            // Configurar links de compartilhamento
            setupSocialSharing();
        }
    }

    function setupSocialSharing() {
        const currentUrl = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        
        // Facebook
        const btnFacebook = document.getElementById('share-facebook');
        if (btnFacebook) {
            btnFacebook.href = `https://www.facebook.com/sharer/sharer.php?u=${currentUrl}`;
        }
        
        // Twitter
        const btnTwitter = document.getElementById('share-twitter');
        if (btnTwitter) {
            btnTwitter.href = `https://twitter.com/intent/tweet?url=${currentUrl}&text=${title}`;
        }
        
        // WhatsApp
        const btnWhatsapp = document.getElementById('share-whatsapp');
        if (btnWhatsapp) {
            btnWhatsapp.href = `https://wa.me/?text=${title}%20${currentUrl}`;
        }
        
        // Email
        const btnEmail = document.getElementById('share-email');
        if (btnEmail) {
            btnEmail.href = `mailto:?subject=${title}&body=${currentUrl}`;
        }
        
        // Copiar link
        const btnCopyLink = document.getElementById('copy-link');
        if (btnCopyLink) {
            btnCopyLink.addEventListener('click', copyToClipboard);
        }
    }

    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showSuccess('Link copiado para a área de transferência!');
        }).catch(() => {
            // Fallback para navegadores mais antigos
            const textArea = document.createElement('textarea');
            textArea.value = window.location.href;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showSuccess('Link copiado para a área de transferência!');
        });
    }

    // ===================================
    // IMPRESSÃO E DOWNLOAD
    // ===================================
    function printPage() {
        window.print();
    }

    function downloadPdf(event) {
        const url = event.target.getAttribute('data-url') || event.target.href;
        if (url) {
            window.open(url, '_blank');
        }
    }

    // ===================================
    // FORMULÁRIO DE LEI (ADMIN)
    // ===================================
    function initializeLeiForm() {
        const form = document.getElementById('lei-form');
        if (!form) return;
        
        // Configurar geração automática de slug
        const tituloInput = document.getElementById('titulo');
        const slugPreview = document.getElementById('slug-preview');
        
        if (tituloInput && slugPreview) {
            tituloInput.addEventListener('input', debounce(updateSlugPreview, 300));
        }
        
        // Configurar upload de arquivo
        const arquivoInput = document.getElementById('arquivo_pdf');
        if (arquivoInput) {
            arquivoInput.addEventListener('change', handleFileUpload);
        }
        
        // Configurar validação do formulário
        form.addEventListener('submit', validateLeiForm);
        
        // Configurar preview de dados
        initializeFormPreview();
    }

    function updateSlugPreview(event) {
        const titulo = event.target.value;
        const slug = generateSlug(titulo);
        const slugPreview = document.getElementById('slug-preview');
        
        if (slugPreview) {
            slugPreview.textContent = slug || 'slug-sera-gerado-automaticamente';
        }
    }

    function generateSlug(text) {
        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

    function handleFileUpload(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('arquivo-preview');
        
        if (!preview) return;
        
        if (file) {
            if (file.type !== 'application/pdf') {
                showError('Apenas arquivos PDF são permitidos');
                event.target.value = '';
                return;
            }
            
            if (file.size > 10 * 1024 * 1024) { // 10MB
                showError('O arquivo deve ter no máximo 10MB');
                event.target.value = '';
                return;
            }
            
            preview.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-file-pdf"></i>
                    Arquivo selecionado: ${file.name} (${formatFileSize(file.size)})
                </div>
            `;
        } else {
            preview.innerHTML = '';
        }
    }

    function validateLeiForm(event) {
        const form = event.target;
        let isValid = true;
        
        // Validar campos obrigatórios
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showFieldError(field, 'Este campo é obrigatório');
                isValid = false;
            } else {
                clearFieldError(field);
            }
        });
        
        // Validar número da lei
        const numeroInput = form.querySelector('#numero');
        if (numeroInput && numeroInput.value) {
            const numero = parseInt(numeroInput.value);
            if (numero <= 0) {
                showFieldError(numeroInput, 'O número deve ser maior que zero');
                isValid = false;
            }
        }
        
        // Validar exercício
        const exercicioInput = form.querySelector('#exercicio');
        if (exercicioInput && exercicioInput.value) {
            const exercicio = parseInt(exercicioInput.value);
            const currentYear = new Date().getFullYear();
            if (exercicio < 1900 || exercicio > currentYear + 1) {
                showFieldError(exercicioInput, `O exercício deve estar entre 1900 e ${currentYear + 1}`);
                isValid = false;
            }
        }
        
        if (!isValid) {
            event.preventDefault();
            showError('Por favor, corrija os erros no formulário');
        }
    }

    // ===================================
    // AÇÕES ADMINISTRATIVAS
    // ===================================
    function initializeBulkActions() {
        const selectAll = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const bulkActions = document.getElementById('bulk-actions');
        
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActionsVisibility();
            });
        }
        
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActionsVisibility);
        });
        
        // Configurar ações em lote
        const btnBulkDelete = document.getElementById('bulk-delete');
        if (btnBulkDelete) {
            btnBulkDelete.addEventListener('click', handleBulkDelete);
        }
    }

    function updateBulkActionsVisibility() {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        const bulkActions = document.getElementById('bulk-actions');
        
        if (bulkActions) {
            if (checkedItems.length > 0) {
                bulkActions.style.display = 'block';
                document.getElementById('selected-count').textContent = checkedItems.length;
            } else {
                bulkActions.style.display = 'none';
            }
        }
    }

    function handleBulkDelete() {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        const ids = Array.from(checkedItems).map(item => item.value);
        
        if (ids.length === 0) return;
        
        if (confirm(`Tem certeza que deseja excluir ${ids.length} lei(s) selecionada(s)?`)) {
            performBulkDelete(ids);
        }
    }

    function performBulkDelete(ids) {
        showLoading();
        
        fetch('/admin/leis/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                location.reload();
            } else {
                showError(data.message || 'Erro ao excluir leis');
            }
        })
        .catch(error => {
            console.error('Erro na exclusão em lote:', error);
            showError('Erro ao excluir leis');
        })
        .finally(() => {
            hideLoading();
        });
    }

    function initializeDeleteConfirmation() {
        document.addEventListener('click', function(event) {
            if (event.target.matches('.btn-delete') || event.target.closest('.btn-delete')) {
                event.preventDefault();
                
                const button = event.target.matches('.btn-delete') ? event.target : event.target.closest('.btn-delete');
                const form = button.closest('form');
                const leiTitulo = button.getAttribute('data-lei-titulo') || 'esta lei';
                
                if (confirm(`Tem certeza que deseja excluir "${leiTitulo}"?`)) {
                    form.submit();
                }
            }
        });
    }

    // ===================================
    // UTILITÁRIOS
    // ===================================
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

    function updateUrlParameter(key, value) {
        const url = new URL(window.location);
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
        window.history.replaceState({}, '', url);
    }

    function updateUrl(params) {
        const url = new URL(window.location);
        url.search = params.toString();
        window.history.replaceState({}, '', url);
    }

    function checkUrlParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Preencher formulário com parâmetros da URL
        if (filtrosForm) {
            urlParams.forEach((value, key) => {
                const input = filtrosForm.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = value;
                }
            });
        }
        
        // Definir página atual
        const page = urlParams.get('page');
        if (page) {
            currentPage = parseInt(page);
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // ===================================
    // LOADING E FEEDBACK
    // ===================================
    function showLoading() {
        isLoading = true;
        if (loadingOverlay) {
            loadingOverlay.classList.add('show');
        }
    }

    function hideLoading() {
        isLoading = false;
        if (loadingOverlay) {
            loadingOverlay.classList.remove('show');
        }
    }

    function showSuccess(message) {
        showToast(message, 'success');
    }

    function showError(message) {
        showToast(message, 'error');
    }

    function showToast(message, type = 'info') {
        // Criar toast se não existir
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        const toastId = 'toast-' + Date.now();
        const toastClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
        
        const toastHtml = `
            <div id="${toastId}" class="toast ${toastClass} text-white" role="alert">
                <div class="toast-header ${toastClass} text-white border-0">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    <strong class="me-auto">${type === 'success' ? 'Sucesso' : type === 'error' ? 'Erro' : 'Informação'}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: type === 'error' ? 5000 : 3000
        });
        
        toast.show();
        
        // Remover toast após ser ocultado
        toastElement.addEventListener('hidden.bs.toast', function() {
            toastElement.remove();
        });
    }

    function showFieldError(field, message) {
        clearFieldError(field);
        
        field.classList.add('is-invalid');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }

    function clearFieldError(field) {
        field.classList.remove('is-invalid');
        
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    // ===================================
    // INICIALIZAÇÃO DE COMPONENTES BOOTSTRAP
    // ===================================
    function initializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    function initializeModals() {
        // Modais são inicializados automaticamente pelo Bootstrap
        // Aqui podemos adicionar configurações específicas se necessário
    }

    // ===================================
    // NAVEGAÇÃO ENTRE LEIS
    // ===================================
    function initializeNavigation() {
        // Configurar teclas de atalho para navegação
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                switch(event.key) {
                    case 'ArrowLeft':
                        event.preventDefault();
                        const prevLink = document.getElementById('lei-anterior');
                        if (prevLink) prevLink.click();
                        break;
                    case 'ArrowRight':
                        event.preventDefault();
                        const nextLink = document.getElementById('lei-proxima');
                        if (nextLink) nextLink.click();
                        break;
                    case 'p':
                        event.preventDefault();
                        printPage();
                        break;
                }
            }
        });
    }

    // ===================================
    // ATUALIZAÇÃO DE RESULTADOS
    // ===================================
    function updateResultsSection(html) {
        const resultsContainer = document.querySelector('.leis-grid');
        if (resultsContainer) {
            resultsContainer.innerHTML = html;
        }
    }

    function updateResultsInfo(info) {
        const infoContainer = document.querySelector('.resultados-info');
        if (infoContainer && info) {
            infoContainer.innerHTML = info;
        }
    }

    function updatePagination(paginationHtml) {
        const paginationContainer = document.querySelector('.paginacao-section');
        if (paginationContainer && paginationHtml) {
            paginationContainer.innerHTML = paginationHtml;
        }
    }

    // ===================================
    // BUSCA ADMINISTRATIVA
    // ===================================
    function handleAdminSearch(event) {
        const searchTerm = event.target.value.trim();
        updateUrlParameter('busca', searchTerm);
        performAdminSearch();
    }

    function handleAdminFilterChange(event) {
        const filterName = event.target.name;
        const filterValue = event.target.value;
        updateUrlParameter(filterName, filterValue);
        performAdminSearch();
    }

    function performAdminSearch() {
        // Implementar busca administrativa similar à busca pública
        // mas com endpoint específico para admin
        const form = document.getElementById('admin-filtros-form');
        if (!form) return;
        
        showLoading();
        
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        fetch(`${window.location.pathname}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateAdminTable(data.html);
                updateUrl(params);
            } else {
                showError('Erro ao carregar resultados');
            }
        })
        .catch(error => {
            console.error('Erro na busca administrativa:', error);
            showError('Erro ao realizar busca');
        })
        .finally(() => {
            hideLoading();
        });
    }

    function updateAdminTable(html) {
        const tableContainer = document.querySelector('.admin-table-container');
        if (tableContainer) {
            tableContainer.innerHTML = html;
            // Reinicializar eventos após atualizar a tabela
            initializeBulkActions();
            initializeDeleteConfirmation();
        }
    }

    // ===================================
    // PREVIEW DO FORMULÁRIO
    // ===================================
    function initializeFormPreview() {
        const previewBtn = document.getElementById('btn-preview');
        if (previewBtn) {
            previewBtn.addEventListener('click', showFormPreview);
        }
    }

    function showFormPreview() {
        const form = document.getElementById('lei-form');
        if (!form) return;
        
        const formData = new FormData(form);
        const previewData = {
            numero: formData.get('numero'),
            exercicio: formData.get('exercicio'),
            data: formData.get('data'),
            tipo: formData.get('tipo'),
            titulo: formData.get('titulo'),
            autoria: formData.get('autoria'),
            ementa: formData.get('ementa'),
            descricao: formData.get('descricao'),
            observacoes: formData.get('observacoes')
        };
        
        // Criar modal de preview
        const previewModal = createPreviewModal(previewData);
        document.body.appendChild(previewModal);
        
        const modal = new bootstrap.Modal(previewModal);
        modal.show();
        
        // Remover modal após fechar
        previewModal.addEventListener('hidden.bs.modal', function() {
            previewModal.remove();
        });
    }

    function createPreviewModal(data) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-eye me-2"></i>
                            Preview da Lei
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="lei-preview">
                            <div class="text-center mb-4">
                                <span class="badge badge-tipo badge-${data.tipo?.toLowerCase().replace(/\s+/g, '-')}">${data.tipo || 'Tipo não definido'}</span>
                                <h4 class="mt-2">${data.tipo || 'Lei'} nº ${data.numero || '___'}/${data.exercicio || '____'}</h4>
                                <p class="text-muted">${data.data ? new Date(data.data).toLocaleDateString('pt-BR') : 'Data não definida'}</p>
                            </div>
                            
                            ${data.titulo ? `<h5>${data.titulo}</h5>` : ''}
                            ${data.autoria ? `<p><strong>Autoria:</strong> ${data.autoria}</p>` : ''}
                            ${data.ementa ? `<div class="mb-3"><strong>Ementa:</strong><br>${data.ementa}</div>` : ''}
                            ${data.descricao ? `<div class="mb-3"><strong>Descrição:</strong><br>${data.descricao.replace(/\n/g, '<br>')}</div>` : ''}
                            ${data.observacoes ? `<div class="mb-3"><strong>Observações:</strong><br>${data.observacoes.replace(/\n/g, '<br>')}</div>` : ''}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        `;
        
        return modal;
    }

    // ===================================
    // EXPORTAR FUNÇÕES GLOBAIS (se necessário)
    // ===================================
    window.LeisSystem = {
        showSuccess: showSuccess,
        showError: showError,
        showLoading: showLoading,
        hideLoading: hideLoading,
        performSearch: performSearch,
        clearFilters: clearFilters
    };

})();