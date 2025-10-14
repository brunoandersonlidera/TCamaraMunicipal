@extends('layouts.admin')

@section('title', 'Novo Tema')
@section('page-title', 'Novo Tema')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.temas.index') }}">Temas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Novo</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.temas.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome do Tema</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Cor Primária</label>
                        <input type="color" name="primary_color" class="form-control form-control-color" value="{{ old('primary_color', '#0057b7') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cor Secundária</label>
                        <input type="color" name="secondary_color" class="form-control form-control-color" value="{{ old('secondary_color', '#ffd700') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Cor de Acento</label>
                        <input type="color" name="accent_color" class="form-control form-control-color" value="{{ old('accent_color', '#ff5722') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fundo do Menu</label>
                        <input type="text" name="menu_bg" class="form-control" value="{{ old('menu_bg', 'linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%)') }}" placeholder="#000000 ou linear-gradient(...)" />
                        <small class="text-muted">Aceita hex (#000000) ou CSS gradient (linear-gradient(...)).</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fundo do Rodapé</label>
                        <input type="text" name="footer_bg" class="form-control" value="{{ old('footer_bg', 'linear-gradient(135deg, #1f2937 0%, #374151 100%)') }}" placeholder="#000000 ou linear-gradient(...)" />
                        <small class="text-muted">Aceita hex (#000000) ou CSS gradient (linear-gradient(...)).</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fundo de Seções</label>
                        <input type="text" name="section_bg" class="form-control" value="{{ old('section_bg', '#f5f5f5') }}" placeholder="#f5f5f5, transparent ou linear-gradient(...)" />
                    </div>

                    <div class="col-12 mt-3">
                        <h6 class="text-muted">Cores adicionais</h6>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Primária (Dark)</label>
                        <input type="color" name="primary_dark" class="form-control form-control-color" value="{{ old('primary_dark', '#1e3a5f') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Light</label>
                        <input type="color" name="light" class="form-control form-control-color" value="{{ old('light', '#f8f9fa') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Borda</label>
                        <input type="color" name="border" class="form-control form-control-color" value="{{ old('border', '#e9ecef') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Texto Muted</label>
                        <input type="color" name="text_muted" class="form-control form-control-color" value="{{ old('text_muted', '#6c757d') }}">
                    </div>

                    <div class="col-12 mt-3">
                        <h6 class="text-muted">Estados (BG / Texto)</h6>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Success (BG)</label>
                        <input type="color" name="success_bg" class="form-control form-control-color" value="{{ old('success_bg', '#d1e7dd') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Success (Texto)</label>
                        <input type="color" name="success_text" class="form-control form-control-color" value="{{ old('success_text', '#0f5132') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Info (BG)</label>
                        <input type="color" name="info_bg" class="form-control form-control-color" value="{{ old('info_bg', '#cff4fc') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Info (Texto)</label>
                        <input type="color" name="info_text" class="form-control form-control-color" value="{{ old('info_text', '#055160') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Warning (BG)</label>
                        <input type="color" name="warning_bg" class="form-control form-control-color" value="{{ old('warning_bg', '#fff3cd') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Warning (Texto)</label>
                        <input type="color" name="warning_text" class="form-control form-control-color" value="{{ old('warning_text', '#664d03') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Danger (BG)</label>
                        <input type="color" name="danger_bg" class="form-control form-control-color" value="{{ old('danger_bg', '#f8d7da') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Danger (Texto)</label>
                        <input type="color" name="danger_text" class="form-control form-control-color" value="{{ old('danger_text', '#842029') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Secondary (BG)</label>
                        <input type="color" name="secondary_bg" class="form-control form-control-color" value="{{ old('secondary_bg', '#e2e3e5') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Secondary (Texto)</label>
                        <input type="color" name="secondary_text" class="form-control form-control-color" value="{{ old('secondary_text', '#41464b') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Início (Opcional)</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fim (Opcional)</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_scheduled" value="1" {{ old('is_scheduled') ? 'checked' : '' }}>
                            <label class="form-check-label">Agendar este tema</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-4">
                    <div class="col-12">
                        <h6 class="text-muted">Lacinho (Campanhas e Comemorativos)</h6>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="ribbon_enabled" value="1" {{ old('ribbon_enabled') ? 'checked' : '' }}>
                            <label class="form-check-label">Exibir lacinho no cabeçalho</label>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="mourning_enabled" value="1" {{ old('mourning_enabled') ? 'checked' : '' }}>
                            <label class="form-check-label">Exibir lacinho de luto?</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Campanha</label>
                        <select name="ribbon_variant" class="form-select">
                            <option value="" {{ old('ribbon_variant') === null ? 'selected' : '' }}>Usar cores do tema</option>
                            <option value="october_pink" {{ old('ribbon_variant') === 'october_pink' ? 'selected' : '' }}>Outubro Rosa</option>
                            <option value="september_yellow" {{ old('ribbon_variant') === 'september_yellow' ? 'selected' : '' }}>Setembro Amarelo</option>
                            <option value="november_blue" {{ old('ribbon_variant') === 'november_blue' ? 'selected' : '' }}>Novembro Azul</option>
                            <option value="mourning_black" {{ old('ribbon_variant') === 'mourning_black' ? 'selected' : '' }}>Luto Oficial</option>
                        </select>
                        <small class="text-muted">Se vazio, o lacinho usa as cores do tema (accent/light).</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lacinho (Primária)</label>
                        <input type="color" name="ribbon_primary" class="form-control form-control-color" value="{{ old('ribbon_primary', '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lacinho (Base)</label>
                        <input type="color" name="ribbon_base" class="form-control form-control-color" value="{{ old('ribbon_base', '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lacinho (Stroke)</label>
                        <input type="color" name="ribbon_stroke" class="form-control form-control-color" value="{{ old('ribbon_stroke', '') }}">
                        <small class="text-muted">Cor do traço/contorno do lacinho.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Texto (lacinho de campanha)</label>
                        <input type="text" name="ribbon_campaign_label" class="form-control" value="{{ old('ribbon_campaign_label', '') }}" placeholder="Ex.: Outubro Rosa, Novembro Azul">
                        <small class="text-muted">Se vazio, será usado um texto padrão conforme a campanha selecionada.</small>
                        <label class="form-label mt-3">Link (lacinho de campanha)</label>
                        <input type="text" name="ribbon_campaign_link_url" class="form-control" value="{{ old('ribbon_campaign_link_url', '') }}" placeholder="Ex.: /minha-pagina ou https://exemplo.com">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="ribbon_campaign_link_external" value="1" {{ old('ribbon_campaign_link_external') ? 'checked' : '' }}>
                            <label class="form-check-label">Abrir em nova aba (link externo)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Texto (lacinho de luto)</label>
                        <input type="text" name="ribbon_mourning_label" class="form-control" value="{{ old('ribbon_mourning_label', '') }}" placeholder="Ex.: Luto Oficial por Fulano">
                        <small class="text-muted">Se vazio, será usado “Luto Oficial”.</small>
                        <label class="form-label mt-3">Link (lacinho de luto)</label>
                        <input type="text" name="ribbon_mourning_link_url" class="form-control" value="{{ old('ribbon_mourning_link_url', '') }}" placeholder="Ex.: /nota-de-luto ou https://exemplo.com">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="ribbon_mourning_link_external" value="1" {{ old('ribbon_mourning_link_external') ? 'checked' : '' }}>
                            <label class="form-check-label">Abrir em nova aba (link externo)</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.temas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Salvar Tema
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection