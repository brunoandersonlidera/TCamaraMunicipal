<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ThemeCssController extends Controller
{
    public function css(Request $request)
    {
        $now = Carbon::now()->toDateString();

        // Preview opcional via query (?theme_preview=slug)
        $previewSlug = $request->query('theme_preview');
        if ($previewSlug) {
            $theme = Theme::where('slug', $previewSlug)->first();
        } else {
            $theme = Theme::query()
                ->where(function ($q) use ($now) {
                    $q->where('is_active', true)
                        ->orWhere(function ($q2) use ($now) {
                            $q2->where('is_scheduled', true)
                                ->whereDate('start_date', '<=', $now)
                                ->whereDate('end_date', '>=', $now);
                        });
                })
                ->orderByDesc('updated_at')
                ->first();
        }

        $primary = optional($theme)->primary_color ?? '#6f42c1';
        $secondary = optional($theme)->secondary_color ?? '#e83e8c';
        $accent = optional($theme)->accent_color ?? '#e83e8c';
        $menuBg = optional($theme)->menu_bg ?? 'linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-secondary) 100%)';
        $footerBg = optional($theme)->footer_bg ?? 'linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-secondary) 100%)';
        $sectionBg = optional($theme)->section_bg ?? 'transparent';

        // Variáveis adicionais para tematização completa (com fallbacks)
        $primaryDark    = optional($theme)->primary_dark    ?? '#1e3a5f';
        $light          = optional($theme)->light           ?? '#f8f9fa';
        $border         = optional($theme)->border          ?? '#e9ecef';
        $textMuted      = optional($theme)->text_muted      ?? '#6c757d';

        // Paleta de estados (BG/TEXT)
        $successBg   = optional($theme)->success_bg   ?? '#d1e7dd';
        $successText = optional($theme)->success_text ?? '#0f5132';
        $infoBg      = optional($theme)->info_bg      ?? '#cff4fc';
        $infoText    = optional($theme)->info_text    ?? '#055160';
        $warningBg   = optional($theme)->warning_bg   ?? '#fff3cd';
        $warningText = optional($theme)->warning_text ?? '#664d03';
        $dangerBg    = optional($theme)->danger_bg    ?? '#f8d7da';
        $dangerText  = optional($theme)->danger_text  ?? '#842029';
        $secondaryBg = optional($theme)->secondary_bg ?? '#e2e3e5';
        $secondaryText = optional($theme)->secondary_text ?? '#41464b';

        // Configurações do lacinho (cores dinâmicas por tema/campanha)
        $ribbonEnabled = optional($theme)->ribbon_enabled ?? false;
        $ribbonVariant = optional($theme)->ribbon_variant;
        $ribbonPrimary = optional($theme)->ribbon_primary; // pode sobrescrever a cor principal
        $ribbonBase = optional($theme)->ribbon_base;       // fundo/base do ribbon
        $ribbonStroke = optional($theme)->ribbon_stroke;   // cor do traço

        // Defaults por campanha
        $variantDefaults = [
            'october_pink'    => ['primary' => '#FF6699', 'base' => '#FEFEFE', 'stroke' => '#FEFEFE'],
            'september_yellow'=> ['primary' => '#FFCC00', 'base' => '#FEFEFE', 'stroke' => '#FEFEFE'],
            'november_blue'   => ['primary' => '#1E90FF', 'base' => '#FEFEFE', 'stroke' => '#FEFEFE'],
            'mourning_black'  => ['primary' => '#000000', 'base' => '#FFFFFF', 'stroke' => '#FFFFFF'],
        ];

        $defaults = $variantDefaults[$ribbonVariant] ?? ['primary' => $accent, 'base' => $light, 'stroke' => $light];
        $ribbonFillPrimary = $ribbonPrimary ?: $defaults['primary'];
        $ribbonFillBase    = $ribbonBase    ?: $defaults['base'];
        $ribbonStrokeColor = $ribbonStroke  ?: $defaults['stroke'];

        $css = ":root{"
            . "--theme-primary: {$primary};"
            . "--theme-secondary: {$secondary};"
            . "--theme-accent: {$accent};"
            . "--theme-primary-dark: {$primaryDark};"
            . "--theme-light: {$light};"
            . "--theme-border: {$border};"
            . "--theme-text-muted: {$textMuted};"
            . "--theme-success-bg: {$successBg};"
            . "--theme-success-text: {$successText};"
            . "--theme-info-bg: {$infoBg};"
            . "--theme-info-text: {$infoText};"
            . "--theme-warning-bg: {$warningBg};"
            . "--theme-warning-text: {$warningText};"
            . "--theme-danger-bg: {$dangerBg};"
            . "--theme-danger-text: {$dangerText};"
            . "--theme-secondary-bg: {$secondaryBg};"
            . "--theme-secondary-text: {$secondaryText};"
            . "--menu-bg: {$menuBg};"
            . "--footer-bg: {$footerBg};"
            . "--section-bg: {$sectionBg};"
            . "--ribbon-fill-primary: {$ribbonFillPrimary};"
            . "--ribbon-fill-base: {$ribbonFillBase};"
            . "--ribbon-stroke: {$ribbonStrokeColor};"
            . "}\n";

        // Overrides para elementos comuns
        $css .= ".hero-section{background: linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-secondary) 100%) !important;}\n";
        $css .= ".navbar, .navbar-custom{background: var(--menu-bg) !important;}\n";
        $css .= ".footer, .footer-custom{background: var(--footer-bg) !important;}\n";
        $css .= ".section-bg-custom{background: var(--section-bg) !important;}\n";
        $css .= ".btn-primary{background-color: var(--theme-primary) !important; border-color: var(--theme-primary) !important;}\n";
        $css .= ".btn-accent{background-color: var(--theme-accent) !important; border-color: var(--theme-accent) !important;}\n";

        return response($css, 200)->header('Content-Type', 'text/css');
    }
}