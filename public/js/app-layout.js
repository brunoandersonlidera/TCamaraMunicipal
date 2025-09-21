/**
 * App Layout JavaScript
 * Funcionalidades gerais do layout público
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar funcionalidades do layout
    initializeSmoothScrolling();
    initializeScrollAnimations();
    initializeNavbarScroll();
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