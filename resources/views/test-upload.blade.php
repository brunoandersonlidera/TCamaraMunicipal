@extends('layouts.app')

@section('title', 'Teste de Upload de Imagens')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-upload me-2"></i>
                        Teste do Sistema de Upload de Imagens
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Upload Único</h5>
                            <p class="text-muted">Teste o upload de uma única imagem</p>
                            
                            <x-image-upload 
                                name="single_image"
                                :multiple="false"
                                label="Selecionar Uma Imagem"
                                help-text="Formatos: JPG, PNG, GIF. Máximo: 5MB"
                                :preview="true"
                                :required="false"
                            />
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Upload Múltiplo</h5>
                            <p class="text-muted">Teste o upload de múltiplas imagens</p>
                            
                            <x-image-upload 
                                name="multiple_images"
                                :multiple="true"
                                :max-files="5"
                                label="Selecionar Múltiplas Imagens"
                                help-text="Máximo 5 imagens. Formatos: JPG, PNG, GIF"
                                :preview="true"
                                :required="false"
                            />
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-12">
                            <h5>Instruções de Teste</h5>
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle me-2"></i>Como testar:</h6>
                                <ul class="mb-0">
                                    <li><strong>Drag & Drop:</strong> Arraste imagens diretamente para as áreas de upload</li>
                                    <li><strong>Clique:</strong> Clique nas áreas para abrir o seletor de arquivos</li>
                                    <li><strong>Pré-visualização:</strong> As imagens aparecerão automaticamente após seleção</li>
                                    <li><strong>Upload automático:</strong> O upload acontece automaticamente após seleção</li>
                                    <li><strong>Remoção:</strong> Clique no X para remover imagens</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <h5>Recursos Implementados</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Upload via drag & drop
                                        </div>
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Validação de tipo de arquivo
                                        </div>
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Validação de tamanho (5MB)
                                        </div>
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Pré-visualização de imagens
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Redimensionamento automático
                                        </div>
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Geração de thumbnails
                                        </div>
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Organização por data
                                        </div>
                                        <div class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Remoção de imagens
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.list-group-item {
    border: none;
    padding: 0.5rem 0;
}

.alert-info {
    background-color: #e3f2fd;
    border-color: #bbdefb;
    color: #0d47a1;
}
</style>
@endpush