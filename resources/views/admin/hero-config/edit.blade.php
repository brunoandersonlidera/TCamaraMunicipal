@extends('layouts.admin')

@section('page-title', 'Editar Configurações do Hero')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.hero-config.index') }}">Configurações Hero</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Editar Configurações do Hero Section</h1>
            <p class="text-muted">Configure o texto e comportamento da seção principal do site</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.hero-config.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <form action="{{ route('admin.hero-config.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Formulário Principal -->
            <div class="col-lg-8">
                <!-- Textos do Hero -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-font me-2"></i>
                            Textos do Hero Section
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título Principal</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" name="titulo" 
                                   value="{{ old('titulo', $heroConfig->titulo ?? 'Bem-vindo à Câmara Municipal') }}"
                                   placeholder="Ex: Bem-vindo à Câmara Municipal">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Este será o título principal exibido no hero section.</div>
                        </div>

                        <div class="mb-3">
                            <label for="subtitulo" class="form-label">Subtítulo/Descrição</label>
                            <textarea class="form-control @error('subtitulo') is-invalid @enderror" 
                                      id="subtitulo" name="subtitulo" rows="3"
                                      placeholder="Ex: Trabalhando pela transparência, representatividade e desenvolvimento do nosso município...">{{ old('subtitulo', $heroConfig->subtitulo ?? 'Trabalhando pela transparência, representatividade e desenvolvimento do nosso município. Acompanhe as atividades legislativas e participe da vida política da sua cidade.') }}</textarea>
                            @error('subtitulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Descrição que aparece abaixo do título principal.</div>
                        </div>
                    </div>
                </div>

                <!-- Configurações do Slider -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sliders-h me-2"></i>
                            Configurações do Slider
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="intervalo" class="form-label">Intervalo entre Slides (ms)</label>
                                    <input type="number" class="form-control @error('intervalo') is-invalid @enderror" 
                                           id="intervalo" name="intervalo" 
                                           value="{{ old('intervalo', $heroConfig->intervalo ?? 5000) }}"
                                           min="1000" max="30000" step="500">
                                    @error('intervalo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Tempo em milissegundos (1000ms = 1 segundo).</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="transicao" class="form-label">Tipo de Transição</label>
                                    <select class="form-select @error('transicao') is-invalid @enderror" 
                                            id="transicao" name="transicao">
                                        <option value="slide" {{ old('transicao', $heroConfig->transicao ?? 'slide') == 'slide' ? 'selected' : '' }}>Deslizar</option>
                                        <option value="fade" {{ old('transicao', $heroConfig->transicao ?? 'slide') == 'fade' ? 'selected' : '' }}>Fade</option>
                                        <option value="zoom" {{ old('transicao', $heroConfig->transicao ?? 'slide') == 'zoom' ? 'selected' : '' }}>Zoom</option>
                                    </select>
                                    @error('transicao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configurações Laterais -->
            <div class="col-lg-4">
                <!-- Opções de Comportamento -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-toggle-on me-2"></i>
                            Comportamento
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="autoplay" name="autoplay" value="1"
                                   {{ old('autoplay', $heroConfig->autoplay ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="autoplay">
                                Autoplay
                            </label>
                            <div class="form-text">Reproduzir slides automaticamente.</div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="pausar_hover" name="pausar_hover" value="1"
                                   {{ old('pausar_hover', $heroConfig->pausar_hover ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pausar_hover">
                                Pausar no Hover
                            </label>
                            <div class="form-text">Pausar quando o mouse estiver sobre o slider.</div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrar_indicadores" name="mostrar_indicadores" value="1"
                                   {{ old('mostrar_indicadores', $heroConfig->mostrar_indicadores ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="mostrar_indicadores">
                                Mostrar Indicadores
                            </label>
                            <div class="form-text">Exibir pontos indicadores na parte inferior.</div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrar_controles" name="mostrar_controles" value="1"
                                   {{ old('mostrar_controles', $heroConfig->mostrar_controles ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="mostrar_controles">
                                Mostrar Controles
                            </label>
                            <div class="form-text">Exibir setas de navegação.</div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-save me-2"></i>
                            Ações
                        </h5>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>
                            Salvar Configurações
                        </button>
                        
                        <a href="{{ route('admin.hero-config.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                        
                        <hr>
                        
                        <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-info w-100 mb-2">
                            <i class="fas fa-images me-2"></i>
                            Gerenciar Slides
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-success w-100" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Visualizar Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview em tempo real do intervalo
    const intervaloInput = document.getElementById('intervalo');
    const intervaloLabel = document.querySelector('label[for="intervalo"]');
    
    function updateIntervaloLabel() {
        const valor = parseInt(intervaloInput.value);
        const segundos = (valor / 1000).toFixed(1);
        intervaloLabel.textContent = `Intervalo entre Slides (${segundos}s)`;
    }
    
    intervaloInput.addEventListener('input', updateIntervaloLabel);
    updateIntervaloLabel(); // Inicializar
});
</script>
@endpush
@endsection