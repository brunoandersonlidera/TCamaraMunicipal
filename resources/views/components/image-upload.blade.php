@props([
    'name' => 'anexos',
    'multiple' => false,
    'maxFiles' => 10,
    'maxSize' => 10240, // KB (10MB)
    'accept' => 'image/*,.pdf',
    'preview' => true,
    'required' => false,
    'label' => 'Selecionar Arquivos',
    'helpText' => 'Formatos aceitos: JPG, PNG, GIF, PDF. Tamanho máximo: 10MB por arquivo.',
    'allowPdf' => true
])

<div class="file-upload-component" data-name="{{ $name }}" data-multiple="{{ $multiple ? 'true' : 'false' }}" data-max-files="{{ $maxFiles }}" data-max-size="{{ $maxSize }}" data-allow-pdf="{{ $allowPdf ? 'true' : 'false' }}">
    <div class="upload-area">
        <input 
            type="file" 
            id="file-input-{{ $name }}" 
            name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            {{ $required ? 'required' : '' }}
            class="file-input d-none"
        >
        
        <div class="upload-zone" onclick="document.getElementById('file-input-{{ $name }}').click()">
            <div class="upload-icon">
                <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
            </div>
            <div class="upload-text">
                <h5 class="mb-2 text-dark">{{ $label }}</h5>
                <p class="text-muted mb-2">{{ $helpText }}</p>
                <small class="text-muted">
                    <i class="fas fa-hand-pointer me-1"></i>
                    Clique aqui ou arraste {{ $multiple ? 'os arquivos' : 'o arquivo' }} para esta área
                </small>
            </div>
        </div>
    </div>

    @if($preview)
    <div class="preview-area mt-3" style="display: none;">
        <h6>Pré-visualização:</h6>
        <div class="preview-grid row g-2"></div>
    </div>
    @endif

    <div class="upload-progress mt-3" style="display: none;">
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
        </div>
        <small class="text-muted upload-status"></small>
    </div>

    <div class="upload-errors mt-2"></div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/image-upload.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/image-upload.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const component = document.querySelector('[data-name="{{ $name }}"]');
    if (component) {
        initFileUpload(component);
    }
});
</script>
@endpush