/**
 * JavaScript para a página Welcome (Página Inicial)
 * Responsável pela funcionalidade dos botões de acesso rápido
 */

document.addEventListener('DOMContentLoaded', function() {
    // Aplicar cores dinâmicas aos botões de acesso rápido
    const botoesAcesso = document.querySelectorAll('.btn-acesso-rapido');
    
    botoesAcesso.forEach(function(botao) {
        const bgColor = botao.getAttribute('data-bg-color') || '#007bff';
        const textColor = botao.getAttribute('data-text-color') || '#ffffff';
        
        // Aplicar estilos dinâmicos
        botao.style.backgroundColor = bgColor;
        botao.style.color = textColor;
        botao.style.border = '2px solid ' + bgColor;
        
        // Adicionar efeitos hover dinâmicos
        botao.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        });
        
        botao.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        });
    });

    // ========================================
    // FUNCIONALIDADES DO SLIDER DO HERO SECTION
    // ========================================
    
    const heroSlider = document.getElementById('heroSlider');
    
    if (heroSlider) {
        // Configurar o slider com base nos dados dos slides
        initializeHeroSlider();
    }
    
    function initializeHeroSlider() {
        const slides = heroSlider.querySelectorAll('.carousel-item');
        const sliderData = [];
        
        // Coletar dados de configuração de cada slide
        slides.forEach((slide, index) => {
            const interval = slide.getAttribute('data-bs-interval');
            sliderData.push({
                index: index,
                interval: parseInt(interval) || 5000,
                element: slide
            });
        });
        
        // Configurar transições personalizadas
        setupSliderTransitions();
        
        // Configurar controles de direção
        setupSliderDirection();
        
        // Configurar eventos do slider
        setupSliderEvents();
        
        // Inicializar o carousel do Bootstrap
        // Observação: o Bootstrap já suporta intervalos por slide via data-bs-interval em cada .carousel-item,
        // portanto não precisamos reinicializar o carousel manualmente ao trocar de slide.
        new bootstrap.Carousel(heroSlider, {
            interval: sliderData[0]?.interval || 5000,
            wrap: true,
            touch: true,
            pause: 'hover'
        });
    }
    
    function setupSliderTransitions() {
        // Verificar se heroSlider existe
        if (!heroSlider) return;
        
        // Aplicar efeitos de transição baseados nos dados do slide
        const slides = heroSlider.querySelectorAll('.carousel-item');
        
        // Verificar se existem slides
        if (!slides || slides.length === 0) return;
        
        slides.forEach(slide => {
            // Verificar se o slide existe
            if (!slide) return;
            
            // Adicionar classes de animação personalizadas se necessário
            slide.addEventListener('transitionend', function() {
                // Callback após transição completa
                console.log('Transição do slide concluída');
            });
        });
    }
    
    function setupSliderDirection() {
        // Verificar se heroSlider existe
        if (!heroSlider) return;
        
        try {
            // Configurar direção do slider (esquerda para direita ou direita para esquerda)
            const direction = heroSlider.getAttribute('data-direction') || 'ltr';
            
            if (direction === 'rtl') {
                // Inverter controles para direção RTL
                const prevBtn = heroSlider.querySelector('.carousel-control-prev');
                const nextBtn = heroSlider.querySelector('.carousel-control-next');
                
                if (prevBtn && nextBtn && prevBtn.nodeType === Node.ELEMENT_NODE && nextBtn.nodeType === Node.ELEMENT_NODE) {
                    // Trocar funcionalidades dos botões
                    prevBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const carousel = bootstrap.Carousel.getInstance(heroSlider);
                        if (carousel) carousel.next();
                    });
                    
                    nextBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const carousel = bootstrap.Carousel.getInstance(heroSlider);
                        if (carousel) carousel.prev();
                    });
                }
            }
        } catch (error) {
            console.warn('Erro ao configurar direção do slider:', error);
        }
    }
    
    function setupSliderEvents() {
        // Verificar se heroSlider existe
        if (!heroSlider) return;
        
        // Eventos personalizados do slider
        heroSlider.addEventListener('slid.bs.carousel', function(event) {
            // Callback após slide mudar
            const activeSlide = event.relatedTarget;
            if (!activeSlide) return;
            
            const slides = heroSlider.querySelectorAll('.carousel-item');
            if (!slides || slides.length === 0) return;
            
            const slideIndex = Array.from(slides).indexOf(activeSlide);
            
            // Atualizar indicadores personalizados se necessário
            updateSliderIndicators(slideIndex);
            
            // Log para debug
            console.log(`Slide ativo: ${slideIndex + 1}`);
        });
        
        // Pausar slider quando mouse está sobre ele
        heroSlider.addEventListener('mouseenter', function() {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (carousel) {
                carousel.pause();
            }
        });
        
        // Retomar slider quando mouse sai
        heroSlider.addEventListener('mouseleave', function() {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (carousel) {
                carousel.cycle();
            }
        });
        
        // Suporte aprimorado a gestos touch para dispositivos móveis
        let startX = 0;
        let endX = 0;
        let startY = 0;
        let endY = 0;
        let isScrolling = false;
        
        heroSlider.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            isScrolling = false;
        }, { passive: true });
        
        heroSlider.addEventListener('touchmove', function(e) {
            if (!startX || !startY) return;
            
            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;
            
            const diffX = Math.abs(startX - currentX);
            const diffY = Math.abs(startY - currentY);
            
            // Determinar se o usuário está fazendo scroll vertical
            if (diffY > diffX) {
                isScrolling = true;
            }
            
            // Prevenir scroll horizontal se estiver fazendo swipe horizontal no slider
            if (!isScrolling && diffX > 10) {
                e.preventDefault();
            }
        }, { passive: false });
        
        heroSlider.addEventListener('touchend', function(e) {
            if (isScrolling) return; // Não processar swipe se o usuário estava fazendo scroll
            
            endX = e.changedTouches[0].clientX;
            endY = e.changedTouches[0].clientY;
            handleSwipe();
        }, { passive: true });
        
        function handleSwipe() {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (!carousel) return;
            
            const swipeThreshold = window.innerWidth < 768 ? 30 : 50; // Threshold menor para mobile
            const diff = startX - endX;
            const verticalDiff = Math.abs(startY - endY);
            
            // Processar apenas swipes horizontais
            if (Math.abs(diff) > swipeThreshold && verticalDiff < 100) {
                if (diff > 0) {
                    // Swipe para esquerda - próximo slide
                    carousel.next();
                } else {
                    // Swipe para direita - slide anterior
                    carousel.prev();
                }
            }
            
            // Resetar valores
            startX = 0;
            endX = 0;
            startY = 0;
            endY = 0;
        }
    }
    
    function updateSliderIndicators(activeIndex) {
        // Verificar se heroSlider existe antes de buscar indicadores
        if (!heroSlider) return;
        
        try {
            const indicators = heroSlider.querySelectorAll('.carousel-indicators button');
            
            // Verificar se existem indicadores
            if (!indicators || indicators.length === 0) return;
            
            indicators.forEach((indicator, index) => {
                // Verificar se o indicador existe, é um elemento válido e tem classList
                if (!indicator || !indicator.nodeType || indicator.nodeType !== Node.ELEMENT_NODE || !indicator.classList) {
                    return;
                }
                
                try {
                    if (index === activeIndex) {
                        indicator.classList.add('active');
                        indicator.setAttribute('aria-current', 'true');
                    } else {
                        indicator.classList.remove('active');
                        indicator.setAttribute('aria-current', 'false');
                    }
                } catch (error) {
                    console.warn('Erro ao atualizar indicador do slider:', error, indicator);
                }
            });
        } catch (error) {
            console.warn('Erro ao buscar indicadores do slider:', error);
        }
    }
    
    // Função para controlar o slider externamente (se necessário)
    window.heroSliderControl = {
        next: function() {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (carousel) carousel.next();
        },
        prev: function() {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (carousel) carousel.prev();
        },
        goTo: function(index) {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (carousel) carousel.to(index);
        },
        pause: function() {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (carousel) carousel.pause();
        },
        play: function() {
            const carousel = bootstrap.Carousel.getInstance(heroSlider);
            if (carousel) carousel.cycle();
        }
    };

    // ========================================
    // Imagens da seção "Últimas Notícias"
    // Alterna entre contain/cover conforme orientação da imagem
    // ========================================
    try {
        const newsImages = document.querySelectorAll('.news-image');
        if (newsImages && newsImages.length > 0) {
            newsImages.forEach((img) => {
                const applyOrientationClass = () => {
                    if (!img || !img.naturalWidth || !img.naturalHeight) return;
                    const isPortrait = img.naturalHeight > img.naturalWidth;
                    img.classList.toggle('portrait', isPortrait);
                    img.classList.toggle('landscape', !isPortrait);
                };

                if (img.complete) {
                    applyOrientationClass();
                } else {
                    img.addEventListener('load', applyOrientationClass, { once: true });
                }
            });
        }
    } catch (e) {
        console.warn('Falha ao aplicar orientação em imagens de notícias:', e);
    }
});