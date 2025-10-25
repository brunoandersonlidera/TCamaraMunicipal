# 🔧 IMPLEMENTAÇÃO PRÁTICA - ACESSIBILIDADE DIGITAL

## 📋 Guia de Implementação para TCamaraMunicipal

Este documento complementa o `ACESSIBILIDADE_DIGITAL.md` com exemplos práticos e código específico para implementação no sistema da Câmara Municipal.

---

## 🎯 Widget de Acessibilidade - Código Completo

### 📁 **Estrutura de Arquivos:**
```
public/js/
├── accessibility-widget.js
├── screen-reader.js
└── keyboard-navigation.js

public/css/
├── accessibility.css
└── high-contrast.css

resources/views/components/
└── accessibility-widget.blade.php
```

### 🎨 **HTML - Widget de Acessibilidade**

```html
<!-- resources/views/components/accessibility-widget.blade.php -->
<div id="accessibility-widget" class="accessibility-widget" role="region" aria-label="Opções de Acessibilidade">
    <!-- Botão de Ativação -->
    <button 
        id="accessibility-toggle" 
        class="accessibility-toggle"
        aria-expanded="false"
        aria-controls="accessibility-panel"
        aria-label="Abrir painel de acessibilidade"
        title="Opções de Acessibilidade (Alt + A)">
        <span class="icon" aria-hidden="true">♿</span>
        <span class="text">Acessibilidade</span>
    </button>

    <!-- Painel de Opções -->
    <div 
        id="accessibility-panel" 
        class="accessibility-panel" 
        hidden
        role="dialog"
        aria-labelledby="accessibility-title"
        aria-modal="false">
        
        <div class="panel-header">
            <h2 id="accessibility-title">Opções de Acessibilidade</h2>
            <button 
                id="accessibility-close"
                class="close-btn"
                aria-label="Fechar painel de acessibilidade"
                title="Fechar (Esc)">
                ✕
            </button>
        </div>

        <div class="panel-content">
            <!-- Tamanho da Fonte -->
            <fieldset class="option-group">
                <legend>Tamanho da Fonte</legend>
                <div class="button-group" role="group" aria-label="Controles de tamanho da fonte">
                    <button data-action="font-size" data-value="small" aria-label="Diminuir fonte">A-</button>
                    <button data-action="font-size" data-value="normal" aria-label="Fonte normal" class="active">A</button>
                    <button data-action="font-size" data-value="large" aria-label="Aumentar fonte">A+</button>
                    <button data-action="font-size" data-value="extra-large" aria-label="Fonte extra grande">A++</button>
                </div>
            </fieldset>

            <!-- Contraste -->
            <fieldset class="option-group">
                <legend>Contraste</legend>
                <div class="button-group" role="group" aria-label="Controles de contraste">
                    <button data-action="contrast" data-value="normal" class="active">Normal</button>
                    <button data-action="contrast" data-value="high">Alto Contraste</button>
                    <button data-action="contrast" data-value="inverted">Invertido</button>
                </div>
            </fieldset>

            <!-- Tema -->
            <fieldset class="option-group">
                <legend>Tema</legend>
                <div class="button-group" role="group" aria-label="Controles de tema">
                    <button data-action="theme" data-value="light" class="active">Claro</button>
                    <button data-action="theme" data-value="dark">Escuro</button>
                </div>
            </fieldset>

            <!-- Animações -->
            <fieldset class="option-group">
                <legend>Animações</legend>
                <div class="toggle-group">
                    <label class="toggle-label">
                        <input type="checkbox" data-action="animations" checked>
                        <span class="toggle-slider"></span>
                        <span class="toggle-text">Ativar animações</span>
                    </label>
                </div>
            </fieldset>

            <!-- Navegação -->
            <fieldset class="option-group">
                <legend>Navegação</legend>
                <div class="toggle-group">
                    <label class="toggle-label">
                        <input type="checkbox" data-action="focus-outline">
                        <span class="toggle-slider"></span>
                        <span class="toggle-text">Destacar foco do teclado</span>
                    </label>
                    <label class="toggle-label">
                        <input type="checkbox" data-action="skip-links">
                        <span class="toggle-slider"></span>
                        <span class="toggle-text">Mostrar links de pular</span>
                    </label>
                </div>
            </fieldset>

            <!-- Reset -->
            <div class="panel-footer">
                <button id="accessibility-reset" class="reset-btn">
                    Restaurar Padrões
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Links de Pular (Skip Links) -->
<div id="skip-links" class="skip-links" hidden>
    <a href="#main-content" class="skip-link">Pular para conteúdo principal</a>
    <a href="#main-navigation" class="skip-link">Pular para navegação</a>
    <a href="#footer" class="skip-link">Pular para rodapé</a>
</div>
```

### 🎨 **CSS - Estilos de Acessibilidade**

```css
/* public/css/accessibility.css */

/* Widget de Acessibilidade */
.accessibility-widget {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    font-family: Arial, sans-serif;
}

.accessibility-toggle {
    background: #0066cc;
    color: white;
    border: none;
    border-radius: 25px;
    padding: 12px 20px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.accessibility-toggle:hover,
.accessibility-toggle:focus {
    background: #0052a3;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.accessibility-toggle:focus {
    outline: 3px solid #ffff00;
    outline-offset: 2px;
}

/* Painel de Opções */
.accessibility-panel {
    position: absolute;
    top: 60px;
    right: 0;
    width: 320px;
    background: white;
    border: 2px solid #0066cc;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    max-height: 80vh;
    overflow-y: auto;
}

.panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #e0e0e0;
    background: #f8f9fa;
}

.panel-header h2 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.close-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
}

.close-btn:hover,
.close-btn:focus {
    background: #e0e0e0;
    outline: 2px solid #0066cc;
}

/* Grupos de Opções */
.option-group {
    border: none;
    margin: 0;
    padding: 16px 20px;
    border-bottom: 1px solid #e0e0e0;
}

.option-group legend {
    font-weight: bold;
    font-size: 14px;
    color: #333;
    margin-bottom: 12px;
    padding: 0;
}

/* Grupos de Botões */
.button-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.button-group button {
    padding: 8px 16px;
    border: 2px solid #ddd;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s ease;
}

.button-group button:hover {
    border-color: #0066cc;
    background: #f0f8ff;
}

.button-group button:focus {
    outline: 2px solid #0066cc;
    outline-offset: 2px;
}

.button-group button.active {
    background: #0066cc;
    color: white;
    border-color: #0066cc;
}

/* Toggles */
.toggle-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.toggle-label {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    font-size: 14px;
}

.toggle-label input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: relative;
    width: 44px;
    height: 24px;
    background: #ccc;
    border-radius: 24px;
    transition: background 0.3s ease;
}

.toggle-slider::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    top: 2px;
    left: 2px;
    transition: transform 0.3s ease;
}

.toggle-label input:checked + .toggle-slider {
    background: #0066cc;
}

.toggle-label input:checked + .toggle-slider::before {
    transform: translateX(20px);
}

.toggle-label input:focus + .toggle-slider {
    outline: 2px solid #0066cc;
    outline-offset: 2px;
}

/* Skip Links */
.skip-links {
    position: fixed;
    top: -100px;
    left: 0;
    z-index: 10000;
    transition: top 0.3s ease;
}

.skip-links.visible {
    top: 0;
}

.skip-link {
    display: block;
    background: #000;
    color: #fff;
    padding: 8px 16px;
    text-decoration: none;
    font-size: 14px;
    border-bottom: 1px solid #333;
}

.skip-link:focus {
    top: 0;
    outline: 3px solid #ffff00;
}

/* Estados de Acessibilidade */
body.font-small { font-size: 14px; }
body.font-normal { font-size: 16px; }
body.font-large { font-size: 18px; }
body.font-extra-large { font-size: 22px; }

body.high-contrast {
    filter: contrast(150%);
}

body.inverted-contrast {
    filter: invert(1) hue-rotate(180deg);
}

body.dark-theme {
    background: #121212;
    color: #ffffff;
}

body.no-animations * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
}

body.focus-outline *:focus {
    outline: 3px solid #ffff00 !important;
    outline-offset: 2px !important;
}

/* Responsividade */
@media (max-width: 768px) {
    .accessibility-widget {
        top: 10px;
        right: 10px;
    }
    
    .accessibility-panel {
        width: calc(100vw - 20px);
        right: -10px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .accessibility-toggle,
    .button-group button,
    .toggle-slider,
    .toggle-slider::before {
        transition: none;
    }
}
```

### ⚡ **JavaScript - Funcionalidade**

```javascript
// public/js/accessibility-widget.js

class AccessibilityWidget {
    constructor() {
        this.settings = {
            fontSize: 'normal',
            contrast: 'normal',
            theme: 'light',
            animations: true,
            focusOutline: false,
            skipLinks: false
        };
        
        this.init();
        this.loadSettings();
    }

    init() {
        this.bindEvents();
        this.setupKeyboardShortcuts();
        this.announceToScreenReader('Widget de acessibilidade carregado');
    }

    bindEvents() {
        const toggle = document.getElementById('accessibility-toggle');
        const panel = document.getElementById('accessibility-panel');
        const closeBtn = document.getElementById('accessibility-close');
        const resetBtn = document.getElementById('accessibility-reset');

        // Toggle do painel
        toggle.addEventListener('click', () => this.togglePanel());
        closeBtn.addEventListener('click', () => this.closePanel());
        resetBtn.addEventListener('click', () => this.resetSettings());

        // Clique fora do painel
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.accessibility-widget')) {
                this.closePanel();
            }
        });

        // Escape para fechar
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closePanel();
            }
        });

        // Botões de ação
        panel.addEventListener('click', (e) => {
            const button = e.target.closest('[data-action]');
            if (button) {
                this.handleAction(button);
            }
        });

        // Checkboxes
        panel.addEventListener('change', (e) => {
            if (e.target.type === 'checkbox') {
                this.handleToggle(e.target);
            }
        });
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Alt + A = Abrir widget
            if (e.altKey && e.key === 'a') {
                e.preventDefault();
                this.togglePanel();
            }
            
            // Alt + R = Reset
            if (e.altKey && e.key === 'r') {
                e.preventDefault();
                this.resetSettings();
            }
        });
    }

    togglePanel() {
        const toggle = document.getElementById('accessibility-toggle');
        const panel = document.getElementById('accessibility-panel');
        const isOpen = !panel.hidden;

        if (isOpen) {
            this.closePanel();
        } else {
            this.openPanel();
        }
    }

    openPanel() {
        const toggle = document.getElementById('accessibility-toggle');
        const panel = document.getElementById('accessibility-panel');
        
        panel.hidden = false;
        toggle.setAttribute('aria-expanded', 'true');
        
        // Foco no primeiro elemento
        const firstFocusable = panel.querySelector('button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (firstFocusable) {
            firstFocusable.focus();
        }
        
        this.announceToScreenReader('Painel de acessibilidade aberto');
    }

    closePanel() {
        const toggle = document.getElementById('accessibility-toggle');
        const panel = document.getElementById('accessibility-panel');
        
        panel.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
        
        this.announceToScreenReader('Painel de acessibilidade fechado');
    }

    handleAction(button) {
        const action = button.dataset.action;
        const value = button.dataset.value;

        switch (action) {
            case 'font-size':
                this.setFontSize(value);
                break;
            case 'contrast':
                this.setContrast(value);
                break;
            case 'theme':
                this.setTheme(value);
                break;
        }

        // Atualizar botão ativo
        const group = button.closest('.button-group');
        if (group) {
            group.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        }

        this.saveSettings();
    }

    handleToggle(checkbox) {
        const action = checkbox.dataset.action;
        const checked = checkbox.checked;

        switch (action) {
            case 'animations':
                this.setAnimations(checked);
                break;
            case 'focus-outline':
                this.setFocusOutline(checked);
                break;
            case 'skip-links':
                this.setSkipLinks(checked);
                break;
        }

        this.saveSettings();
    }

    setFontSize(size) {
        document.body.className = document.body.className.replace(/font-\w+/g, '');
        document.body.classList.add(`font-${size}`);
        this.settings.fontSize = size;
        
        this.announceToScreenReader(`Tamanho da fonte alterado para ${size}`);
    }

    setContrast(contrast) {
        document.body.className = document.body.className.replace(/(high|inverted)-contrast/g, '');
        if (contrast !== 'normal') {
            document.body.classList.add(`${contrast}-contrast`);
        }
        this.settings.contrast = contrast;
        
        this.announceToScreenReader(`Contraste alterado para ${contrast}`);
    }

    setTheme(theme) {
        document.body.classList.toggle('dark-theme', theme === 'dark');
        this.settings.theme = theme;
        
        this.announceToScreenReader(`Tema alterado para ${theme}`);
    }

    setAnimations(enabled) {
        document.body.classList.toggle('no-animations', !enabled);
        this.settings.animations = enabled;
        
        this.announceToScreenReader(`Animações ${enabled ? 'ativadas' : 'desativadas'}`);
    }

    setFocusOutline(enabled) {
        document.body.classList.toggle('focus-outline', enabled);
        this.settings.focusOutline = enabled;
        
        this.announceToScreenReader(`Destaque de foco ${enabled ? 'ativado' : 'desativado'}`);
    }

    setSkipLinks(enabled) {
        const skipLinks = document.getElementById('skip-links');
        skipLinks.hidden = !enabled;
        this.settings.skipLinks = enabled;
        
        this.announceToScreenReader(`Links de pular ${enabled ? 'ativados' : 'desativados'}`);
    }

    resetSettings() {
        // Remover todas as classes
        document.body.className = document.body.className.replace(/(font-\w+|high-contrast|inverted-contrast|dark-theme|no-animations|focus-outline)/g, '');
        
        // Resetar checkboxes
        document.querySelectorAll('#accessibility-panel input[type="checkbox"]').forEach(cb => {
            cb.checked = cb.dataset.action === 'animations';
        });
        
        // Resetar botões ativos
        document.querySelectorAll('#accessibility-panel .button-group button').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.value === 'normal' || btn.dataset.value === 'light') {
                btn.classList.add('active');
            }
        });
        
        // Resetar configurações
        this.settings = {
            fontSize: 'normal',
            contrast: 'normal',
            theme: 'light',
            animations: true,
            focusOutline: false,
            skipLinks: false
        };
        
        this.saveSettings();
        this.announceToScreenReader('Configurações de acessibilidade restauradas');
    }

    saveSettings() {
        localStorage.setItem('accessibility-settings', JSON.stringify(this.settings));
    }

    loadSettings() {
        const saved = localStorage.getItem('accessibility-settings');
        if (saved) {
            this.settings = { ...this.settings, ...JSON.parse(saved) };
            this.applySettings();
        }
    }

    applySettings() {
        this.setFontSize(this.settings.fontSize);
        this.setContrast(this.settings.contrast);
        this.setTheme(this.settings.theme);
        this.setAnimations(this.settings.animations);
        this.setFocusOutline(this.settings.focusOutline);
        this.setSkipLinks(this.settings.skipLinks);
        
        // Atualizar interface
        this.updateInterface();
    }

    updateInterface() {
        // Atualizar botões ativos
        Object.entries(this.settings).forEach(([key, value]) => {
            const button = document.querySelector(`[data-action="${key.replace(/([A-Z])/g, '-$1').toLowerCase()}"][data-value="${value}"]`);
            if (button) {
                const group = button.closest('.button-group');
                if (group) {
                    group.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                }
            }
        });
        
        // Atualizar checkboxes
        document.querySelector('[data-action="animations"]').checked = this.settings.animations;
        document.querySelector('[data-action="focus-outline"]').checked = this.settings.focusOutline;
        document.querySelector('[data-action="skip-links"]').checked = this.settings.skipLinks;
    }

    announceToScreenReader(message) {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        
        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    }
}

// Inicializar quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    new AccessibilityWidget();
});

// Classe para elementos apenas para screen readers
const style = document.createElement('style');
style.textContent = `
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
`;
document.head.appendChild(style);
```

---

## 🎯 Integração com Laravel

### 📝 **Blade Component**

```php
// app/View/Components/AccessibilityWidget.php
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AccessibilityWidget extends Component
{
    public function render()
    {
        return view('components.accessibility-widget');
    }
}
```

### 🎨 **Layout Principal**

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Câmara Municipal')</title>
    
    {{-- CSS de Acessibilidade --}}
    <link rel="stylesheet" href="{{ asset('css/accessibility.css') }}">
    
    @stack('styles')
</head>
<body>
    {{-- Widget de Acessibilidade --}}
    <x-accessibility-widget />
    
    {{-- Conteúdo Principal --}}
    <main id="main-content" role="main">
        @yield('content')
    </main>
    
    {{-- JavaScript de Acessibilidade --}}
    <script src="{{ asset('js/accessibility-widget.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
```

---

## 📱 Responsividade e Mobile

### 📱 **Adaptações Mobile**

```css
/* Adaptações para dispositivos móveis */
@media (max-width: 768px) {
    .accessibility-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        top: auto;
    }
    
    .accessibility-toggle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        padding: 0;
        justify-content: center;
    }
    
    .accessibility-toggle .text {
        display: none;
    }
    
    .accessibility-panel {
        position: fixed;
        bottom: 80px;
        right: 20px;
        left: 20px;
        width: auto;
        max-height: 60vh;
    }
}

/* Melhorias para toque */
@media (pointer: coarse) {
    .button-group button,
    .toggle-label {
        min-height: 44px;
        min-width: 44px;
    }
}
```

---

## 🧪 Testes Automatizados

### 🔍 **Teste com Jest**

```javascript
// tests/accessibility.test.js
describe('Accessibility Widget', () => {
    let widget;
    
    beforeEach(() => {
        document.body.innerHTML = `
            <div id="accessibility-widget">
                <!-- HTML do widget -->
            </div>
        `;
        widget = new AccessibilityWidget();
    });
    
    test('should toggle panel visibility', () => {
        const toggle = document.getElementById('accessibility-toggle');
        const panel = document.getElementById('accessibility-panel');
        
        toggle.click();
        expect(panel.hidden).toBe(false);
        expect(toggle.getAttribute('aria-expanded')).toBe('true');
    });
    
    test('should change font size', () => {
        widget.setFontSize('large');
        expect(document.body.classList.contains('font-large')).toBe(true);
    });
    
    test('should save settings to localStorage', () => {
        widget.setFontSize('large');
        const saved = JSON.parse(localStorage.getItem('accessibility-settings'));
        expect(saved.fontSize).toBe('large');
    });
});
```

---

## 📊 Métricas e Monitoramento

### 📈 **Analytics de Acessibilidade**

```javascript
// Rastreamento de uso das funcionalidades
class AccessibilityAnalytics {
    static track(action, value) {
        // Google Analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', 'accessibility_action', {
                'action': action,
                'value': value
            });
        }
        
        // Enviar para backend
        fetch('/api/accessibility-metrics', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                action: action,
                value: value,
                timestamp: new Date().toISOString(),
                user_agent: navigator.userAgent
            })
        });
    }
}
```

---

## ✅ Checklist de Implementação

### 🎯 **Fase 1: Estrutura Base**
- [ ] Criar widget de acessibilidade
- [ ] Implementar navegação por teclado
- [ ] Adicionar skip links
- [ ] Configurar ARIA labels
- [ ] Testar com screen readers

### 🎨 **Fase 2: Personalização Visual**
- [ ] Controles de fonte
- [ ] Opções de contraste
- [ ] Tema escuro/claro
- [ ] Controle de animações
- [ ] Responsividade mobile

### 🧪 **Fase 3: Testes e Validação**
- [ ] Testes automatizados
- [ ] Validação WCAG 2.1
- [ ] Testes com usuários reais
- [ ] Auditoria de acessibilidade
- [ ] Certificação de conformidade

---

*Este documento fornece uma implementação completa e prática do sistema de acessibilidade para o TCamaraMunicipal, seguindo as melhores práticas e padrões internacionais.*