/**
 * Cartas de Serviço - JavaScript para Página de Detalhes
 * Funcionalidades específicas para a visualização de uma carta de serviço
 */

document.addEventListener('DOMContentLoaded', function() {
    initCartaServicoShow();
});

/**
 * Inicialização da página de detalhes
 */
function initCartaServicoShow() {
    initAccordions();
    initShareButtons();
    initPrintButton();
    initScrollSpy();
    initStickyNavigation();
    initImageModal();
    initCopyButtons();
    initFeedback();
    initAccessibility();
}

/**
 * Inicialização dos accordions
 */
function initAccordions() {
    const accordionButtons = document.querySelectorAll('.accordion-button');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Fechar outros accordions se necessário
            if (!isExpanded) {
                accordionButtons.forEach(otherButton => {
                    if (otherButton !== this) {
                        const otherTargetId = otherButton.getAttribute('data-bs-target');
                        const otherTarget = document.querySelector(otherTargetId);
                        
                        otherButton.setAttribute('aria-expanded', 'false');
                        // Verificação de segurança para classList
                        if (otherButton && otherButton.classList) {
                            try {
                                otherButton.classList.add('collapsed');
                            } catch (error) {
                                console.warn('Erro ao adicionar classe collapsed ao otherButton:', error);
                            }
                        }
                        if (otherTarget && otherTarget.classList) {
                            try {
                                otherTarget.classList.remove('show');
                            } catch (error) {
                                console.warn('Erro ao remover classe show do otherTarget:', error);
                            }
                        }
                    }
                });
            }
            
            // Toggle do accordion atual
            this.setAttribute('aria-expanded', !isExpanded);
            // Verificação de segurança para classList
            if (this && this.classList) {
                try {
                    this.classList.toggle('collapsed', isExpanded);
                } catch (error) {
                    console.warn('Erro ao alternar classe collapsed:', error);
                }
            }
            
            if (target && target.classList) {
                try {
                    target.classList.toggle('show', !isExpanded);
                } catch (error) {
                    console.warn('Erro ao alternar classe show do target:', error);
                }
            }
        });
    });
}

/**
 * Inicialização dos botões de compartilhamento
 */
function initShareButtons() {
    const shareButtons = document.querySelectorAll('[data-share]');
    
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const shareType = this.dataset.share;
            const title = document.querySelector('h1')?.textContent || 'Carta de Serviço';
            const description = document.querySelector('.servico-description')?.textContent || '';
            const url = window.location.href;
            
            switch (shareType) {
                case 'whatsapp':
                    shareWhatsApp(title, url);
                    break;
                case 'facebook':
                    shareFacebook(url);
                    break;
                case 'twitter':
                    shareTwitter(title, url);
                    break;
                case 'email':
                    shareEmail(title, description, url);
                    break;
                case 'copy':
                    copyToClipboard(url);
                    break;
                case 'native':
                    shareNative(title, description, url);
                    break;
            }
        });
    });
}

/**
 * Compartilhar no WhatsApp
 */
function shareWhatsApp(title, url) {
    const text = encodeURIComponent(`${title}\n\n${url}`);
    window.open(`https://wa.me/?text=${text}`, '_blank');
}

/**
 * Compartilhar no Facebook
 */
function shareFacebook(url) {
    const shareUrl = encodeURIComponent(url);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`, '_blank');
}

/**
 * Compartilhar no Twitter
 */
function shareTwitter(title, url) {
    const text = encodeURIComponent(title);
    const shareUrl = encodeURIComponent(url);
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${shareUrl}`, '_blank');
}

/**
 * Compartilhar por email
 */
function shareEmail(title, description, url) {
    const subject = encodeURIComponent(`Carta de Serviço: ${title}`);
    const body = encodeURIComponent(`${description}\n\nAcesse: ${url}`);
    window.location.href = `mailto:?subject=${subject}&body=${body}`;
}

/**
 * Compartilhamento nativo
 */
function shareNative(title, description, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: description,
            url: url
        }).catch(error => {
            console.log('Erro ao compartilhar:', error);
            copyToClipboard(url);
        });
    } else {
        copyToClipboard(url);
    }
}

/**
 * Copiar para área de transferência
 */
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Link copiado para a área de transferência!', 'success');
        }).catch(() => {
            fallbackCopyText(text);
        });
    } else {
        fallbackCopyText(text);
    }
}

/**
 * Fallback para copiar texto
 */
function fallbackCopyText(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showNotification('Link copiado para a área de transferência!', 'success');
    } catch (err) {
        showNotification('Não foi possível copiar o link', 'error');
    }
    
    document.body.removeChild(textArea);
}

/**
 * Inicialização do botão de impressão
 */
function initPrintButton() {
    const printButton = document.querySelector('[data-action="print"]');
    
    if (printButton) {
        printButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Preparar página para impressão
            // Verificação de segurança para classList
            if (document.body && document.body.classList) {
                try {
                    document.body.classList.add('printing');
                } catch (error) {
                    console.warn('Erro ao adicionar classe printing ao body:', error);
                }
            }
            
            // Imprimir
            window.print();
            
            // Remover classe após impressão
            setTimeout(() => {
                // Verificação de segurança para classList
                if (document.body && document.body.classList) {
                    try {
                        document.body.classList.remove('printing');
                    } catch (error) {
                        console.warn('Erro ao remover classe printing do body:', error);
                    }
                }
            }, 1000);
        });
    }
}

/**
 * Inicialização do scroll spy
 */
function initScrollSpy() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    
    if (sections.length === 0 || navLinks.length === 0) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const id = entry.target.getAttribute('id');
            
            // Verifica se o ID não está vazio antes de usar no querySelector
            if (!id || id.trim() === '') return;
            
            const navLink = document.querySelector(`.nav-link[href="#${id}"]`);
            
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    // Verificação de segurança para classList
                    if (link && link.classList) {
                        try {
                            link.classList.remove('active');
                        } catch (error) {
                            console.warn('Erro ao remover classe active do link:', error);
                        }
                    }
                });
                if (navLink && navLink.classList) {
                    try {
                        navLink.classList.add('active');
                    } catch (error) {
                        console.warn('Erro ao adicionar classe active ao navLink:', error);
                    }
                }
            }
        });
    }, {
        rootMargin: '-20% 0px -80% 0px'
    });
    
    sections.forEach(section => observer.observe(section));
    
    // Smooth scroll para links de navegação
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Inicialização da navegação sticky
 */
function initStickyNavigation() {
    const stickyNav = document.querySelector('.sticky-nav');
    
    if (!stickyNav) return;
    
    const observer = new IntersectionObserver(
        ([entry]) => {
            // Verificação de segurança para classList
            if (stickyNav && stickyNav.classList) {
                try {
                    stickyNav.classList.toggle('visible', !entry.isIntersecting);
                } catch (error) {
                    console.warn('Erro ao alternar classe visible do stickyNav:', error);
                }
            }
        },
        { threshold: 0 }
    );
    
    const target = document.querySelector('.servico-header') || document.querySelector('main');
    if (target) {
        observer.observe(target);
    }
}

/**
 * Inicialização do modal de imagens
 */
function initImageModal() {
    const images = document.querySelectorAll('.servico-content img, .anexo-preview img');
    
    images.forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            openImageModal(this.src, this.alt || 'Imagem');
        });
    });
}

/**
 * Abrir modal de imagem
 */
function openImageModal(src, alt) {
    const modal = document.createElement('div');
    modal.className = 'image-modal';
    modal.innerHTML = `
        <div class="image-modal-backdrop">
            <div class="image-modal-content">
                <button class="image-modal-close" aria-label="Fechar">
                    <i class="fas fa-times"></i>
                </button>
                <img src="${src}" alt="${alt}" class="image-modal-img">
                <div class="image-modal-caption">${alt}</div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Fechar modal
    const closeBtn = modal.querySelector('.image-modal-close');
    const backdrop = modal.querySelector('.image-modal-backdrop');
    
    [closeBtn, backdrop].forEach(element => {
        element.addEventListener('click', function(e) {
            if (e.target === this) {
                document.body.removeChild(modal);
            }
        });
    });
    
    // Fechar com ESC
    document.addEventListener('keydown', function escHandler(e) {
        if (e.key === 'Escape') {
            document.body.removeChild(modal);
            document.removeEventListener('keydown', escHandler);
        }
    });
    
    // Mostrar modal
    setTimeout(() => {
        // Verificação de segurança para classList
        if (modal && modal.classList) {
            try {
                modal.classList.add('show');
            } catch (error) {
                console.warn('Erro ao adicionar classe show ao modal:', error);
            }
        }
    }, 10);
}

/**
 * Inicialização dos botões de cópia
 */
function initCopyButtons() {
    const copyButtons = document.querySelectorAll('[data-copy]');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const textToCopy = this.dataset.copy || this.textContent;
            copyToClipboard(textToCopy);
        });
    });
}

/**
 * Inicialização do sistema de feedback
 */
function initFeedback() {
    const feedbackButtons = document.querySelectorAll('.feedback-btn');
    
    feedbackButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isHelpful = this.dataset.helpful === 'true';
            submitFeedback(isHelpful);
        });
    });
}

/**
 * Enviar feedback
 */
function submitFeedback(isHelpful) {
    const servicoId = document.querySelector('[data-servico-id]')?.dataset.servicoId;
    
    if (!servicoId) return;
    
    fetch('/cartas-servico/feedback', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        body: JSON.stringify({
            servico_id: servicoId,
            helpful: isHelpful
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Obrigado pelo seu feedback!', 'success');
            
            // Desabilitar botões de feedback
            document.querySelectorAll('.feedback-btn').forEach(btn => {
                btn.disabled = true;
                // Verificação de segurança para classList
                if (btn && btn.classList) {
                    try {
                        btn.classList.add('disabled');
                    } catch (error) {
                        console.warn('Erro ao adicionar classe disabled ao btn:', error);
                    }
                }
            });
        }
    })
    .catch(error => {
        console.error('Erro ao enviar feedback:', error);
        showNotification('Erro ao enviar feedback', 'error');
    });
}

/**
 * Inicialização da acessibilidade
 */
function initAccessibility() {
    // Melhorar navegação por teclado
    const interactiveElements = document.querySelectorAll('button, a, [tabindex]');
    
    interactiveElements.forEach(element => {
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                if (this.tagName === 'BUTTON' || this.getAttribute('role') === 'button') {
                    e.preventDefault();
                    this.click();
                }
            }
        });
    });
    
    // Anunciar mudanças para leitores de tela
    const dynamicContent = document.querySelector('.servico-content');
    if (dynamicContent) {
        dynamicContent.setAttribute('aria-live', 'polite');
    }
    
    // Melhorar foco visível
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            // Verificação de segurança para classList
            if (document.body && document.body.classList) {
                try {
                    document.body.classList.add('keyboard-navigation');
                } catch (error) {
                    console.warn('Erro ao adicionar classe keyboard-navigation ao body:', error);
                }
            }
        }
    });
    
    document.addEventListener('mousedown', function() {
        // Verificação de segurança para classList
        if (document.body && document.body.classList) {
            try {
                document.body.classList.remove('keyboard-navigation');
            } catch (error) {
                console.warn('Erro ao remover classe keyboard-navigation do body:', error);
            }
        }
    });
}

/**
 * Mostrar notificação
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        // Verificação de segurança para classList
        if (notification && notification.classList) {
            try {
                notification.classList.add('show');
            } catch (error) {
                console.warn('Erro ao adicionar classe show à notification:', error);
            }
        }
    }, 100);
    
    setTimeout(() => {
        // Verificação de segurança para classList
        if (notification && notification.classList) {
            try {
                notification.classList.remove('show');
            } catch (error) {
                console.warn('Erro ao remover classe show da notification:', error);
            }
        }
        setTimeout(() => {
            if (notification.parentNode) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

/**
 * Função para voltar ao topo
 */
window.voltarAoTopo = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

// Adicionar botão "Voltar ao topo"
window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    let backToTopBtn = document.getElementById('back-to-top');
    
    if (scrollTop > 300) {
        if (!backToTopBtn) {
            backToTopBtn = document.createElement('button');
            backToTopBtn.id = 'back-to-top';
            backToTopBtn.className = 'btn-back-to-top';
            backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            backToTopBtn.onclick = voltarAoTopo;
            backToTopBtn.setAttribute('aria-label', 'Voltar ao topo');
            document.body.appendChild(backToTopBtn);
        }
        backToTopBtn.style.display = 'flex';
    } else if (backToTopBtn) {
        backToTopBtn.style.display = 'none';
    }
});

// CSS específico para a página de detalhes
const style = document.createElement('style');
style.textContent = `
    .image-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .image-modal.show {
        opacity: 1;
    }
    
    .image-modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .image-modal-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        text-align: center;
    }
    
    .image-modal-close {
        position: absolute;
        top: -40px;
        right: -40px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        transition: background 0.3s ease;
    }
    
    .image-modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .image-modal-img {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 8px;
    }
    
    .image-modal-caption {
        color: white;
        margin-top: 15px;
        font-size: 16px;
    }
    
    .sticky-nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        transform: translateY(-100%);
        transition: transform 0.3s ease;
        padding: 10px 0;
    }
    
    .sticky-nav.visible {
        transform: translateY(0);
    }
    
    .feedback-section {
        border-top: 1px solid #e9ecef;
        padding-top: 20px;
        margin-top: 30px;
        text-align: center;
    }
    
    .feedback-btn {
        margin: 0 10px;
        padding: 10px 20px;
        border: 2px solid #dee2e6;
        background: white;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .feedback-btn:hover {
        border-color: var(--cs-primary, #007bff);
        color: var(--cs-primary, #007bff);
    }
    
    .feedback-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .keyboard-navigation *:focus {
        outline: 2px solid var(--cs-primary, #007bff);
        outline-offset: 2px;
    }
    
    @media print {
        .printing .no-print,
        .printing .btn,
        .printing .sidebar,
        .printing .share-buttons {
            display: none !important;
        }
        
        .printing .container {
            max-width: none !important;
            padding: 0 !important;
        }
    }
`;
document.head.appendChild(style);