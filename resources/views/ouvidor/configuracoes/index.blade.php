@extends('layouts.ouvidor')

@section('title', 'Configurações')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Configurações</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('ouvidor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Configurações</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('ouvidor.configuracoes.update') }}">
                @csrf
                @method('PATCH')

                <!-- Notificações -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell me-2"></i>
                            Notificações
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="notificacoes_email" 
                                           name="notificacoes_email" 
                                           value="1"
                                           {{ old('notificacoes_email', $configuracoes['notificacoes_email']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notificacoes_email">
                                        <strong>Notificações por E-mail</strong>
                                        <div class="form-text">Receber notificações importantes por e-mail</div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="notificacoes_sistema" 
                                           name="notificacoes_sistema" 
                                           value="1"
                                           {{ old('notificacoes_sistema', $configuracoes['notificacoes_sistema']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notificacoes_sistema">
                                        <strong>Notificações do Sistema</strong>
                                        <div class="form-text">Exibir notificações no painel</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configurações de Trabalho -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-briefcase me-2"></i>
                            Configurações de Trabalho
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="auto_atribuicao" 
                                           name="auto_atribuicao" 
                                           value="1"
                                           {{ old('auto_atribuicao', $configuracoes['auto_atribuicao']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="auto_atribuicao">
                                        <strong>Auto-atribuição</strong>
                                        <div class="form-text">Receber automaticamente novas manifestações</div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prazo_padrao_resposta" class="form-label">
                                        Prazo Padrão de Resposta (dias) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('prazo_padrao_resposta') is-invalid @enderror" 
                                           id="prazo_padrao_resposta" 
                                           name="prazo_padrao_resposta" 
                                           value="{{ old('prazo_padrao_resposta', $configuracoes['prazo_padrao_resposta']) }}" 
                                           min="1" 
                                           max="365" 
                                           required>
                                    <div class="form-text">Prazo padrão para responder manifestações</div>
                                    @error('prazo_padrao_resposta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assinatura de E-mail -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-signature me-2"></i>
                            Assinatura de E-mail
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="assinatura_email" class="form-label">Assinatura</label>
                            <textarea class="form-control @error('assinatura_email') is-invalid @enderror" 
                                      id="assinatura_email" 
                                      name="assinatura_email" 
                                      rows="4" 
                                      placeholder="Digite sua assinatura para e-mails...">{{ old('assinatura_email', $configuracoes['assinatura_email']) }}</textarea>
                            <div class="form-text">Esta assinatura será incluída automaticamente nos e-mails enviados</div>
                            @error('assinatura_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Aparência -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-palette me-2"></i>
                            Aparência
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="tema_dashboard" class="form-label">Tema do Dashboard</label>
                            <select class="form-select @error('tema_dashboard') is-invalid @enderror" 
                                    id="tema_dashboard" 
                                    name="tema_dashboard" 
                                    required>
                                <option value="claro" {{ old('tema_dashboard', $configuracoes['tema_dashboard']) === 'claro' ? 'selected' : '' }}>
                                    Claro
                                </option>
                                <option value="escuro" {{ old('tema_dashboard', $configuracoes['tema_dashboard']) === 'escuro' ? 'selected' : '' }}>
                                    Escuro
                                </option>
                            </select>
                            @error('tema_dashboard')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Salvar Configurações
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informações
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-lightbulb me-2"></i>
                            Dicas
                        </h6>
                        <ul class="mb-0">
                            <li>As notificações por e-mail são enviadas para situações críticas</li>
                            <li>O prazo padrão pode ser ajustado conforme a complexidade das manifestações</li>
                            <li>A assinatura de e-mail aparecerá em todas as respostas enviadas</li>
                            <li>O tema escuro pode reduzir o cansaço visual</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estatísticas de Uso
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ auth()->user()->manifestacoesAtribuidas()->count() }}</h4>
                                <small class="text-muted">Manifestações Atribuídas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ auth()->user()->manifestacoesRespondidas()->count() }}</h4>
                            <small class="text-muted">Manifestações Respondidas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aplicar tema imediatamente quando alterado
    const temaSelect = document.getElementById('tema_dashboard');
    if (temaSelect) {
        temaSelect.addEventListener('change', function() {
            const tema = this.value;
            if (tema === 'escuro') {
                document.body.classList.add('dark-theme');
            } else {
                document.body.classList.remove('dark-theme');
            }
        });
    }
});
</script>
@endsection