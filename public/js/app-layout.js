/**
 * App Layout JavaScript
 * Funcionalidades gerais do layout público
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar funcionalidades do layout
    initializeSmoothScrolling();
    initializeScrollAnimations();
    initializeNavbarScroll();
    initializeDropdowns();
    initializeMobileAccordion();
    
    // Reinicializar dropdowns no redimensionamento da janela
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            initializeDropdowns();
            initializeMobileAccordion();
        }, 250);
    });
});

/**
 * Smooth scrolling for anchor links
 */
function initializeSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Add animation classes on scroll
 */
function initializeScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, observerOptions);

    // Observe all cards and sections
    document.querySelectorAll('.card-custom, .section-title').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Navbar background on scroll
 */
function initializeNavbarScroll() {
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar-custom');
        const navbarFallback = document.querySelector('.navbar');
        
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.style.background = 'linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(30, 64, 175, 0.95) 100%)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = 'linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%)';
                navbar.style.backdropFilter = 'none';
            }
        }
        
        if (navbarFallback) {
            if (window.scrollY > 50) {
                navbarFallback.style.backgroundColor = 'rgba(13, 110, 253, 0.95)';
            } else {
                navbarFallback.style.backgroundColor = 'rgba(13, 110, 253, 0.9)';
            }
        }
    });
}

/**
 * Initialize Bootstrap dropdowns with hover functionality
 */
function initializeDropdowns() {
    const dropdowns = document.querySelectorAll('.navbar-nav .dropdown');
    
    dropdowns.forEach(dropdown => {
        const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        let hoverTimeout;
        
        // Desabilitar o comportamento padrão de clique do Bootstrap
        if (dropdownToggle) {
            dropdownToggle.removeAttribute('data-bs-toggle');
            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                return false;
            });
        }
        
        // Implementar hover para mostrar dropdown
        dropdown.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            
            // Fechar outros dropdowns abertos
            dropdowns.forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    otherDropdown.classList.remove('show');
                    const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                    if (otherMenu) {
                        otherMenu.classList.remove('show');
                    }
                }
            });
            
            // Mostrar dropdown atual
            dropdown.classList.add('show');
            if (dropdownMenu) {
                dropdownMenu.classList.add('show');
            }
        });
        
        // Implementar hover para esconder dropdown com delay
        dropdown.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(() => {
                dropdown.classList.remove('show');
                if (dropdownMenu) {
                    dropdownMenu.classList.remove('show');
                }
            }, 150); // Pequeno delay para melhor UX
        });
        
        // Manter dropdown aberto quando hover sobre o menu
        if (dropdownMenu) {
            dropdownMenu.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
            });
            
            dropdownMenu.addEventListener('mouseleave', function() {
                hoverTimeout = setTimeout(() => {
                    dropdown.classList.remove('show');
                    dropdownMenu.classList.remove('show');
                }, 150);
            });
        }
    });
    
    // Para dispositivos móveis, manter comportamento de clique
    if (window.innerWidth <= 991.98) {
        dropdowns.forEach(dropdown => {
            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
            if (dropdownToggle) {
                dropdownToggle.setAttribute('data-bs-toggle', 'dropdown');
                dropdownToggle.removeEventListener('click', function(e) {
                    e.preventDefault();
                });
            }
        });
    }
}

/**
 * Inicializar funcionalidade do acordeão mobile
 */
function initializeMobileAccordion() {
    // Só executar em dispositivos móveis
    if (window.innerWidth > 991.98) {
        return;
    }
    
    const accordionButtons = document.querySelectorAll('.mobile-accordion-button');
    
    accordionButtons.forEach(button => {
        // Remover listeners existentes para evitar duplicação
        button.removeEventListener('click', handleAccordionClick);
        
        // Adicionar listener para clique
        button.addEventListener('click', handleAccordionClick);
        
        // Melhorar acessibilidade com teclado
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                handleAccordionClick.call(this, e);
            }
        });
    });
    
    // Fechar outros acordeões quando um for aberto (comportamento de acordeão)
    function handleAccordionClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const button = this;
        const targetId = button.getAttribute('data-bs-target');
        const targetCollapse = document.querySelector(targetId);
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        
        // Fechar todos os outros acordeões
        const allButtons = document.querySelectorAll('.mobile-accordion-button');
        const allCollapses = document.querySelectorAll('.mobile-accordion-collapse');
        
        allButtons.forEach(btn => {
            if (btn !== button) {
                btn.setAttribute('aria-expanded', 'false');
                btn.classList.remove('active');
            }
        });
        
        allCollapses.forEach(collapse => {
            if (collapse !== targetCollapse) {
                collapse.classList.remove('show');
            }
        });
        
        // Toggle do acordeão atual
        if (isExpanded) {
            // Fechar
            button.setAttribute('aria-expanded', 'false');
            button.classList.remove('active');
            targetCollapse.classList.remove('show');
        } else {
            // Abrir
            button.setAttribute('aria-expanded', 'true');
            button.classList.add('active');
            targetCollapse.classList.add('show');
        }
        
        // Adicionar animação suave
        if (targetCollapse) {
            targetCollapse.style.transition = 'all 0.3s ease';
        }
    }
    
    // Fechar acordeão quando clicar fora
    document.addEventListener('click', function(e) {
        const isAccordionClick = e.target.closest('.mobile-accordion-item');
        
        if (!isAccordionClick) {
            // Fechar todos os acordeões
            const allButtons = document.querySelectorAll('.mobile-accordion-button');
            const allCollapses = document.querySelectorAll('.mobile-accordion-collapse');
            
            allButtons.forEach(btn => {
                btn.setAttribute('aria-expanded', 'false');
                btn.classList.remove('active');
            });
            
            allCollapses.forEach(collapse => {
                collapse.classList.remove('show');
            });
        }
    });
    
    // Fechar acordeão quando o menu principal for fechado
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            // Se o menu está sendo fechado, fechar todos os acordeões
            if (navbarCollapse.classList.contains('show')) {
                setTimeout(() => {
                    const allButtons = document.querySelectorAll('.mobile-accordion-button');
                    const allCollapses = document.querySelectorAll('.mobile-accordion-collapse');
                    
                    allButtons.forEach(btn => {
                        btn.setAttribute('aria-expanded', 'false');
                        btn.classList.remove('active');
                    });
                    
                    allCollapses.forEach(collapse => {
                        collapse.classList.remove('show');
                    });
                }, 100);
            }
        });
    }
}