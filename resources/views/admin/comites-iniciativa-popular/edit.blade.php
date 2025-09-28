@extends('layouts.admin')

@section('title', 'Editar Comitê de Iniciativa Popular')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Editar Comitê: {{ $comite->nome }}</h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.comites-iniciativa-popular.show', $comite) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('admin.comites-iniciativa-popular.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.comites-iniciativa-popular.update', $comite) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6>Corrija os seguintes erros:</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Informações Básicas -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Informações do Comitê</h5>
                                
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome do Comitê <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" name="nome" value="{{ old('nome', $comite->nome) }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cpf" class="form-label">CPF do Responsável <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" name="cpf" value="{{ old('cpf', $comite->cpf) }}" 
                                           placeholder="000.000.000-00" maxlength="14" required>
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $comite->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                           id="telefone" name="telefone" value="{{ old('telefone', $comite->telefone) }}" 
                                           placeholder="(00) 00000-0000" maxlength="15" required>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <textarea class="form-control @error('endereco') is-invalid @enderror" 
                                              id="endereco" name="endereco" rows="3">{{ old('endereco', $comite->endereco) }}</textarea>
                                    @error('endereco')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Informações de Coleta -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Informações de Coleta de Assinaturas</h5>
                                
                                <div class="mb-3">
                                    <label for="minimo_assinaturas" class="form-label">Mínimo de Assinaturas <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('minimo_assinaturas') is-invalid @enderror" 
                                           id="minimo_assinaturas" name="minimo_assinaturas" 
                                           value="{{ old('minimo_assinaturas', $comite->minimo_assinaturas) }}" min="1" required>
                                    @error('minimo_assinaturas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="numero_assinaturas" class="form-label">Número Atual de Assinaturas</label>
                                    <input type="number" class="form-control @error('numero_assinaturas') is-invalid @enderror" 
                                           id="numero_assinaturas" name="numero_assinaturas" 
                                           value="{{ old('numero_assinaturas', $comite->numero_assinaturas) }}" min="0">
                                    @error('numero_assinaturas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="data_inicio_coleta" class="form-label">Data de Início da Coleta</label>
                                    <input type="date" class="form-control @error('data_inicio_coleta') is-invalid @enderror" 
                                           id="data_inicio_coleta" name="data_inicio_coleta" 
                                           value="{{ old('data_inicio_coleta', $comite->data_inicio_coleta?->format('Y-m-d')) }}">
                                    @error('data_inicio_coleta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="data_fim_coleta" class="form-label">Data de Fim da Coleta</label>
                                    <input type="date" class="form-control @error('data_fim_coleta') is-invalid @enderror" 
                                           id="data_fim_coleta" name="data_fim_coleta" 
                                           value="{{ old('data_fim_coleta', $comite->data_fim_coleta?->format('Y-m-d')) }}">
                                    @error('data_fim_coleta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Selecione o status</option>
                                        <option value="ativo" {{ old('status', $comite->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                        <option value="validado" {{ old('status', $comite->status) == 'validado' ? 'selected' : '' }}>Validado</option>
                                        <option value="rejeitado" {{ old('status', $comite->status) == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                        <option value="arquivado" {{ old('status', $comite->status) == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Documentos -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Documentos (JSON)</h5>
                                <div class="mb-3">
                                    <label for="documentos" class="form-label">Documentos em formato JSON</label>
                                    <textarea class="form-control @error('documentos') is-invalid @enderror" 
                                              id="documentos" name="documentos" rows="5" 
                                              placeholder='{"ata_constituicao": "ata.pdf", "estatuto": "estatuto.pdf", "lista_membros": "membros.pdf"}'>{{ old('documentos', is_array($comite->documentos) ? json_encode($comite->documentos, JSON_PRETTY_PRINT) : $comite->documentos) }}</textarea>
                                    @error('documentos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Exemplo: {"ata_constituicao": "ata.pdf", "estatuto": "estatuto.pdf", "lista_membros": "membros.pdf"}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Observações</h5>
                                <div class="mb-3">
                                    <label for="observacoes" class="form-label">Observações</label>
                                    <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                              id="observacoes" name="observacoes" rows="4" 
                                              maxlength="2000">{{ old('observacoes', $comite->observacoes) }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Máximo de 2000 caracteres</small>
                                </div>
                            </div>
                        </div>

                        <!-- Informações de Progresso -->
                        @if($comite->numero_assinaturas > 0 || $comite->minimo_assinaturas > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Progresso da Coleta</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <h4 class="text-primary">{{ number_format($comite->numero_assinaturas) }}</h4>
                                                    <small class="text-muted">Assinaturas Coletadas</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <h4 class="text-info">{{ number_format($comite->minimo_assinaturas) }}</h4>
                                                    <small class="text-muted">Mínimo Necessário</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <h4 class="{{ $comite->atingiuMinimoAssinaturas() ? 'text-success' : 'text-warning' }}">
                                                        {{ number_format($comite->getPercentualAssinaturas(), 1) }}%
                                                    </h4>
                                                    <small class="text-muted">Progresso</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="progress mt-3">
                                            <div class="progress-bar {{ $comite->atingiuMinimoAssinaturas() ? 'bg-success' : 'bg-warning' }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min(100, $comite->getPercentualAssinaturas()) }}%">
                                            </div>
                                        </div>
                                        
                                        @if($comite->atingiuMinimoAssinaturas())
                                            <div class="alert alert-success mt-3 mb-0">
                                                <i class="fas fa-check-circle"></i> Meta de assinaturas atingida!
                                            </div>
                                        @else
                                            <div class="alert alert-warning mt-3 mb-0">
                                                <i class="fas fa-exclamation-triangle"></i> 
                                                Faltam {{ number_format($comite->minimo_assinaturas - $comite->numero_assinaturas) }} assinaturas para atingir a meta.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.comites-iniciativa-popular.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Atualizar Comitê
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    }

    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });
    }
});
</script>
@endsection