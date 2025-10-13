<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Câmara Municipal')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta-description', 'Câmara Municipal - Portal oficial com informações sobre vereadores, sessões, projetos de lei, transparência e serviços ao cidadão.')">
    <meta name="keywords" content="@yield('meta-keywords', 'câmara municipal, vereadores, transparência, licitações, projetos de lei, sessões, ouvidoria, e-sic')">
    <meta name="author" content="Câmara Municipal">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og-type', 'website')">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('og-title', 'Câmara Municipal')">
    <meta property="og:description" content="@yield('og-description', 'Portal oficial da Câmara Municipal com informações sobre vereadores, sessões, projetos de lei e transparência.')">
    <meta property="og:image" content="@yield('og-image', asset('images/logo-camara-og.png'))">
    <meta property="og:site_name" content="Câmara Municipal">
    <meta property="og:locale" content="pt_BR">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="@yield('twitter-title', 'Câmara Municipal')">
    <meta property="twitter:description" content="@yield('twitter-description', 'Portal oficial da Câmara Municipal')">
    <meta property="twitter:image" content="@yield('twitter-image', asset('images/logo-camara-og.png'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', request()->url())">
    
    <!-- Additional SEO -->
    <meta name="theme-color" content="#0d6efd">
    <meta name="msapplication-TileColor" content="#0d6efd">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS Customizado (deve vir DEPOIS do Bootstrap para sobrescrever) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/public-styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/leis-formatacao.css') }}" rel="stylesheet">
    <!-- CSS dinâmico de tema (carregado por último para sobrescrever cores/gradientes) -->
    @php $themePreview = request()->query('theme_preview'); @endphp
    <link href="{{ $themePreview ? route('theme.css', ['theme_preview' => $themePreview]) : route('theme.css') }}" rel="stylesheet">
    
    <!-- JavaScript Direto -->
    <script src="{{ asset('js/app-layout.js') }}" defer></script>
    
    <!-- Additional CSS -->
    @stack('styles')
    
    <!-- Schema.org Structured Data - Temporariamente removido para debug -->
    
    @stack('structured-data')
</head>
<body>
    <!-- Navigation -->
    <x-app-header />

    <!-- Container Principal -->
    <div class="main-content-wrapper">
        <!-- Barra de Ferramentas Fixa -->
    <x-app-toolbar />

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <x-app-footer />

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS (não processados pelo Vite) -->
    <script src="{{ asset('js/app-layout.js') }}"></script>
    
    @stack('scripts')
</body>
</html>