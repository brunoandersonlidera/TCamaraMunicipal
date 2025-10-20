@extends('layouts.admin')

@section('title', 'Configuração de Favicon')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>Configuração de Favicon
                    </h3>
                    <a href="{{ route('admin.configuracao-geral.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Sobre o Favicon:</strong> O favicon é o pequeno ícone que aparece na aba do navegador, favoritos e outros locais. 
                        Configure diferentes tamanhos para garantir a melhor qualidade em todos os dispositivos.
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Erro:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.configuracao-geral.favicon.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Favicon Principal -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-globe me-2"></i>Favicon Principal
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            @if($faviconConfigs['favicon_site'])
                                                <img src="{{ asset($faviconConfigs['favicon_site']) }}" 
                                                     alt="Favicon Principal" 
                                                     class="img-thumbnail"
                                                     style="max-width: 64px; max-height: 64px;">
                                            @else
                                                <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 64px; height: 64px; margin: 0 auto;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="favicon_site" class="form-label">Arquivo (ICO, PNG, SVG)</label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="favicon_site" 
                                                   name="favicon_site" 
                                                   accept=".ico,.png,.svg">
                                            <div class="form-text">Recomendado: 32x32px ou maior</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Apple Touch Icon -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fab fa-apple me-2"></i>Apple Touch Icon
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            @if($faviconConfigs['favicon_apple_touch'])
                                                <img src="{{ asset($faviconConfigs['favicon_apple_touch']) }}" 
                                                     alt="Apple Touch Icon" 
                                                     class="img-thumbnail"
                                                     style="max-width: 64px; max-height: 64px;">
                                            @else
                                                <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 64px; height: 64px; margin: 0 auto;">
                                                    <i class="fab fa-apple text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="favicon_apple_touch" class="form-label">Arquivo (PNG, SVG)</label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="favicon_apple_touch" 
                                                   name="favicon_apple_touch" 
                                                   accept=".png,.svg">
                                            <div class="form-text">Recomendado: 180x180px</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Favicon 32x32 -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-desktop me-2"></i>Favicon 32x32
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            @if($faviconConfigs['favicon_32x32'])
                                                <img src="{{ asset($faviconConfigs['favicon_32x32']) }}" 
                                                     alt="Favicon 32x32" 
                                                     class="img-thumbnail"
                                                     style="max-width: 32px; max-height: 32px;">
                                            @else
                                                <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 32px; height: 32px; margin: 0 auto;">
                                                    <i class="fas fa-image text-muted" style="font-size: 12px;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="favicon_32x32" class="form-label">Arquivo (ICO, PNG, SVG)</label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="favicon_32x32" 
                                                   name="favicon_32x32" 
                                                   accept=".ico,.png,.svg">
                                            <div class="form-text">Tamanho: 32x32px</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Favicon 16x16 -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-mobile-alt me-2"></i>Favicon 16x16
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            @if($faviconConfigs['favicon_16x16'])
                                                <img src="{{ asset($faviconConfigs['favicon_16x16']) }}" 
                                                     alt="Favicon 16x16" 
                                                     class="img-thumbnail"
                                                     style="max-width: 16px; max-height: 16px;">
                                            @else
                                                <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 16px; height: 16px; margin: 0 auto;">
                                                    <i class="fas fa-image text-muted" style="font-size: 8px;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="favicon_16x16" class="form-label">Arquivo (ICO, PNG, SVG)</label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="favicon_16x16" 
                                                   name="favicon_16x16" 
                                                   accept=".ico,.png,.svg">
                                            <div class="form-text">Tamanho: 16x16px</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Informações Técnicas
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6><i class="fas fa-file-image me-2"></i>Formatos Suportados:</h6>
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-check text-success me-2"></i>ICO (recomendado para compatibilidade)</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>PNG (boa qualidade)</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>SVG (escalável)</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6><i class="fas fa-ruler me-2"></i>Tamanhos Recomendados:</h6>
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-globe me-2"></i>Principal: 32x32px ou maior</li>
                                                    <li><i class="fab fa-apple me-2"></i>Apple Touch: 180x180px</li>
                                                    <li><i class="fas fa-desktop me-2"></i>Desktop: 32x32px</li>
                                                    <li><i class="fas fa-mobile-alt me-2"></i>Mobile: 16x16px</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Configurações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview de imagens ao selecionar arquivo
    const fileInputs = ['favicon_site', 'favicon_apple_touch', 'favicon_32x32', 'favicon_16x16'];
    
    fileInputs.forEach(function(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = input.closest('.card-body').querySelector('img');
                        if (img) {
                            img.src = e.target.result;
                        } else {
                            // Criar nova imagem se não existir
                            const placeholder = input.closest('.card-body').querySelector('.bg-light');
                            if (placeholder) {
                                const newImg = document.createElement('img');
                                newImg.src = e.target.result;
                                newImg.alt = 'Preview';
                                newImg.className = 'img-thumbnail';
                                newImg.style.maxWidth = placeholder.style.width;
                                newImg.style.maxHeight = placeholder.style.height;
                                placeholder.parentNode.replaceChild(newImg, placeholder);
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
});
</script>
@endsection