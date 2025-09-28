@extends('layouts.admin')

@section('title', 'Editar Aditivo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Aditivo {{ $aditivo->numero_aditivo }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.contratos.aditivos.show', [$contrato, $aditivo]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Informações do Contrato -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-muted">Contrato Relacionado</h5>
                            <p><strong>{{ $contrato->numero_contrato }}</strong> - {{ $contrato->objeto }}</p>
                        </div>
                    </div>

                    <hr>

                    <form action="{{ route('admin.contratos.aditivos.update', [$contrato, $aditivo]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_aditivo">Número do Aditivo <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('numero_aditivo') is-invalid @enderror" 
                                           id="numero_aditivo" 
                                           name="numero_aditivo" 
                                           value="{{ old('numero_aditivo', $aditivo->numero_aditivo) }}" 
                                           required>
                                    @error('numero_aditivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Tipo <span class="text-danger">*</span></label>
                                    <select class="form-control @error('tipo') is-invalid @enderror" 
                                            id="tipo" 
                                            name="tipo" 
                                            required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="valor" {{ old('tipo', $aditivo->tipo) == 'valor' ? 'selected' : '' }}>Valor</option>
                                        <option value="prazo" {{ old('tipo', $aditivo->tipo) == 'prazo' ? 'selected' : '' }}>Prazo</option>
                                        <option value="valor_prazo" {{ old('tipo', $aditivo->tipo) == 'valor_prazo' ? 'selected' : '' }}>Valor e Prazo</option>
                                        <option value="supressao" {{ old('tipo', $aditivo->tipo) == 'supressao' ? 'selected' : '' }}>Supressão</option>
                                        <option value="acrescimo" {{ old('tipo', $aditivo->tipo) == 'acrescimo' ? 'selected' : '' }}>Acréscimo</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_assinatura">Data de Assinatura <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('data_assinatura') is-invalid @enderror" 
                                           id="data_assinatura" 
                                           name="data_assinatura" 
                                           value="{{ old('data_assinatura', $aditivo->data_assinatura ? $aditivo->data_assinatura->format('Y-m-d') : '') }}" 
                                           required>
                                    @error('data_assinatura')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="valor_aditivo">Valor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" 
                                               class="form-control @error('valor_aditivo') is-invalid @enderror" 
                                               id="valor_aditivo" 
                                               name="valor_aditivo" 
                                               value="{{ old('valor_aditivo', $aditivo->valor_aditivo ? number_format($aditivo->valor_aditivo, 2, ',', '.') : '') }}" 
                                               placeholder="0,00">
                                    </div>
                                    @error('valor_aditivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_inicio_vigencia">Data de Início da Vigência</label>
                                    <input type="date" 
                                           class="form-control @error('data_inicio_vigencia') is-invalid @enderror" 
                                           id="data_inicio_vigencia" 
                                           name="data_inicio_vigencia" 
                                           value="{{ old('data_inicio_vigencia', $aditivo->data_inicio_vigencia ? $aditivo->data_inicio_vigencia->format('Y-m-d') : '') }}">
                                    @error('data_inicio_vigencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_fim_vigencia">Data de Fim da Vigência</label>
                                    <input type="date" 
                                           class="form-control @error('data_fim_vigencia') is-invalid @enderror" 
                                           id="data_fim_vigencia" 
                                           name="data_fim_vigencia" 
                                           value="{{ old('data_fim_vigencia', $aditivo->data_fim_vigencia ? $aditivo->data_fim_vigencia->format('Y-m-d') : '') }}">
                                    @error('data_fim_vigencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="objeto">Objeto</label>
                                    <textarea class="form-control @error('objeto') is-invalid @enderror" 
                                              id="objeto" 
                                              name="objeto" 
                                              rows="3">{{ old('objeto', $aditivo->objeto) }}</textarea>
                                    @error('objeto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="justificativa">Justificativa</label>
                                    <textarea class="form-control @error('justificativa') is-invalid @enderror" 
                                              id="justificativa" 
                                              name="justificativa" 
                                              rows="4">{{ old('justificativa', $aditivo->justificativa) }}</textarea>
                                    @error('justificativa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="arquivo_aditivo">Arquivo do Aditivo</label>
                                    @if($aditivo->arquivo_aditivo)
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                Arquivo atual: 
                                                <i class="fas fa-file-pdf text-danger"></i>
                                                {{ basename($aditivo->arquivo_aditivo) }}
                                                <a href="{{ route('admin.contratos.aditivos.download', [$contrato, $aditivo]) }}" 
                                                   class="btn btn-sm btn-outline-success ml-2">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </small>
                                        </div>
                                    @endif
                                    <input type="file" 
                                           class="form-control-file @error('arquivo_aditivo') is-invalid @enderror" 
                                           id="arquivo_aditivo" 
                                           name="arquivo_aditivo" 
                                           accept=".pdf,.doc,.docx">
                                    <small class="form-text text-muted">
                                        Formatos aceitos: PDF, DOC, DOCX. Máximo 10MB.
                                        @if($aditivo->arquivo_aditivo)
                                            <br><strong>Nota:</strong> Selecionar um novo arquivo substituirá o arquivo atual.
                                        @endif
                                    </small>
                                    @error('arquivo_aditivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Salvar Alterações
                                    </button>
                                    <a href="{{ route('admin.contratos.aditivos.show', [$contrato, $aditivo]) }}" 
                                       class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para valor monetário
    const valorInput = document.getElementById('valor_aditivo');
    if (valorInput) {
        valorInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2) + '';
            value = value.replace(".", ",");
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            e.target.value = value;
        });
    }
});
</script>
@endsection