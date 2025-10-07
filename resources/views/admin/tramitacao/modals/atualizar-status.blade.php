<!-- Modal Atualizar Status -->
<div class="modal fade" id="modalAtualizarStatus" tabindex="-1" aria-labelledby="modalAtualizarStatusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.projetos-lei.atualizar-status', $projeto) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAtualizarStatusLabel">
                        <i class="fas fa-arrow-right me-2"></i>Atualizar Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Novo Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Selecione o status</option>
                            <option value="protocolado" {{ $projeto->status === 'protocolado' ? 'selected' : '' }}>Protocolado</option>
                            <option value="distribuido" {{ $projeto->status === 'distribuido' ? 'selected' : '' }}>Distribuído</option>
                            <option value="em_comissao" {{ $projeto->status === 'em_comissao' ? 'selected' : '' }}>Em Comissão</option>
                            <option value="aprovado_1_turno" {{ $projeto->status === 'aprovado_1_turno' ? 'selected' : '' }}>Aprovado 1º Turno</option>
                            <option value="aprovado" {{ $projeto->status === 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                            <option value="rejeitado" {{ $projeto->status === 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                            <option value="enviado_executivo" {{ $projeto->status === 'enviado_executivo' ? 'selected' : '' }}>Enviado ao Executivo</option>
                            <option value="sancionado" {{ $projeto->status === 'sancionado' ? 'selected' : '' }}>Sancionado</option>
                            <option value="vetado" {{ $projeto->status === 'vetado' ? 'selected' : '' }}>Vetado</option>
                            <option value="promulgado" {{ $projeto->status === 'promulgado' ? 'selected' : '' }}>Promulgado</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3" 
                                  placeholder="Adicione observações sobre esta mudança de status..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="data_status" class="form-label">Data do Status</label>
                        <input type="datetime-local" class="form-control" id="data_status" name="data_status" 
                               value="{{ now()->format('Y-m-d\TH:i') }}">
                        <div class="form-text">Deixe em branco para usar a data/hora atual</div>
                    </div>
                    
                    <!-- Campos específicos por status -->
                    <div id="campos-especificos">
                        <!-- Campos para sanção -->
                        <div id="campos-sancao" class="d-none">
                            <div class="mb-3">
                                <label for="numero_lei" class="form-label">Número da Lei</label>
                                <input type="text" class="form-control" id="numero_lei" name="numero_lei" 
                                       placeholder="Ex: 123">
                            </div>
                            <div class="mb-3">
                                <label for="data_sancao" class="form-label">Data da Sanção</label>
                                <input type="date" class="form-control" id="data_sancao" name="data_sancao" 
                                       value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <!-- Campos para veto -->
                        <div id="campos-veto" class="d-none">
                            <div class="mb-3">
                                <label for="motivo_veto" class="form-label">Motivo do Veto</label>
                                <textarea class="form-control" id="motivo_veto" name="motivo_veto" rows="3" 
                                          placeholder="Descreva o motivo do veto..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="data_veto" class="form-label">Data do Veto</label>
                                <input type="date" class="form-control" id="data_veto" name="data_veto" 
                                       value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <!-- Campos para promulgação -->
                        <div id="campos-promulgacao" class="d-none">
                            <div class="mb-3">
                                <label for="data_promulgacao" class="form-label">Data da Promulgação</label>
                                <input type="date" class="form-control" id="data_promulgacao" name="data_promulgacao" 
                                       value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Atualizar Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const camposEspecificos = document.getElementById('campos-especificos');
    
    statusSelect.addEventListener('change', function() {
        // Ocultar todos os campos específicos
        camposEspecificos.querySelectorAll('.mb-3').forEach(campo => {
            campo.classList.add('d-none');
        });
        
        // Mostrar campos específicos baseado no status
        switch(this.value) {
            case 'sancionado':
                document.getElementById('campos-sancao').classList.remove('d-none');
                break;
            case 'vetado':
                document.getElementById('campos-veto').classList.remove('d-none');
                break;
            case 'promulgado':
                document.getElementById('campos-promulgacao').classList.remove('d-none');
                break;
        }
    });
});
</script>