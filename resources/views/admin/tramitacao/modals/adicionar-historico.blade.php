<!-- Modal Adicionar ao Histórico -->
<div class="modal fade" id="modalAdicionarHistorico" tabindex="-1" aria-labelledby="modalAdicionarHistoricoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.projetos-lei.adicionar-historico', $projeto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarHistoricoLabel">
                        <i class="fas fa-plus me-2"></i>Adicionar ao Histórico
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo_evento" class="form-label">Tipo de Evento</label>
                        <select class="form-select" id="tipo_evento" name="tipo_evento" required>
                            <option value="">Selecione o tipo de evento</option>
                            <option value="distribuicao">Distribuição para Comissão</option>
                            <option value="parecer">Parecer de Comissão</option>
                            <option value="emenda">Apresentação de Emenda</option>
                            <option value="substitutivo">Apresentação de Substitutivo</option>
                            <option value="audiencia_publica">Audiência Pública</option>
                            <option value="vista">Pedido de Vista</option>
                            <option value="retirada_pauta">Retirada de Pauta</option>
                            <option value="inclusao_pauta">Inclusão em Pauta</option>
                            <option value="discussao">Discussão</option>
                            <option value="votacao_adiada">Votação Adiada</option>
                            <option value="recurso">Interposição de Recurso</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="campo-outro" style="display: none;">
                        <label for="tipo_personalizado" class="form-label">Especifique o Tipo</label>
                        <input type="text" class="form-control" id="tipo_personalizado" name="tipo_personalizado" 
                               placeholder="Digite o tipo de evento...">
                    </div>
                    
                    <div class="mb-3">
                        <label for="titulo_evento" class="form-label">Título do Evento</label>
                        <input type="text" class="form-control" id="titulo_evento" name="titulo_evento" 
                               placeholder="Ex: Distribuído para Comissão de Justiça" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao_evento" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao_evento" name="descricao_evento" rows="4" 
                                  placeholder="Descreva detalhadamente o que aconteceu nesta etapa da tramitação..." required></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="data_evento" class="form-label">Data do Evento</label>
                            <input type="date" class="form-control" id="data_evento" name="data_evento" 
                                   value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hora_evento" class="form-label">Hora do Evento</label>
                            <input type="time" class="form-control" id="hora_evento" name="hora_evento" 
                                   value="{{ now()->format('H:i') }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="responsavel" class="form-label">Responsável/Relator</label>
                        <input type="text" class="form-control" id="responsavel" name="responsavel" 
                               placeholder="Nome do responsável ou relator (opcional)">
                    </div>
                    
                    <div class="mb-3">
                        <label for="comissao" class="form-label">Comissão</label>
                        <select class="form-select" id="comissao" name="comissao">
                            <option value="">Selecione a comissão (se aplicável)</option>
                            <option value="justica">Comissão de Justiça e Redação</option>
                            <option value="financas">Comissão de Finanças e Orçamento</option>
                            <option value="obras">Comissão de Obras e Serviços Públicos</option>
                            <option value="educacao">Comissão de Educação e Cultura</option>
                            <option value="saude">Comissão de Saúde e Assistência Social</option>
                            <option value="meio_ambiente">Comissão de Meio Ambiente</option>
                            <option value="direitos_humanos">Comissão de Direitos Humanos</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="anexos" class="form-label">Anexos</label>
                        <input type="file" class="form-control" id="anexos" name="anexos[]" multiple 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">
                            Você pode anexar documentos relacionados a este evento (pareceres, atas, etc.). 
                            Formatos aceitos: PDF, DOC, DOCX, JPG, PNG. Máximo 5MB por arquivo.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="evento_publico" name="evento_publico" value="1" checked>
                            <label class="form-check-label" for="evento_publico">
                                Evento público (visível no portal da transparência)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notificar_interessados" name="notificar_interessados" value="1">
                            <label class="form-check-label" for="notificar_interessados">
                                Notificar interessados por e-mail
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Adicionar ao Histórico
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoEvento = document.getElementById('tipo_evento');
    const campoOutro = document.getElementById('campo-outro');
    const tituloEvento = document.getElementById('titulo_evento');
    
    // Títulos sugeridos para cada tipo de evento
    const titulosSugeridos = {
        'distribuicao': 'Distribuído para Comissão',
        'parecer': 'Parecer da Comissão',
        'emenda': 'Apresentação de Emenda',
        'substitutivo': 'Apresentação de Substitutivo',
        'audiencia_publica': 'Realização de Audiência Pública',
        'vista': 'Pedido de Vista',
        'retirada_pauta': 'Retirada de Pauta',
        'inclusao_pauta': 'Inclusão em Pauta',
        'discussao': 'Discussão em Plenário',
        'votacao_adiada': 'Votação Adiada',
        'recurso': 'Interposição de Recurso'
    };
    
    tipoEvento.addEventListener('change', function() {
        // Mostrar/ocultar campo "Outro"
        if (this.value === 'outro') {
            campoOutro.style.display = 'block';
            document.getElementById('tipo_personalizado').required = true;
        } else {
            campoOutro.style.display = 'none';
            document.getElementById('tipo_personalizado').required = false;
        }
        
        // Sugerir título baseado no tipo
        if (titulosSugeridos[this.value]) {
            tituloEvento.value = titulosSugeridos[this.value];
        }
    });
    
    // Validação de arquivos
    const anexos = document.getElementById('anexos');
    anexos.addEventListener('change', function() {
        const files = this.files;
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png'];
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            if (file.size > maxSize) {
                alert(`O arquivo "${file.name}" excede o tamanho máximo de 5MB.`);
                this.value = '';
                return;
            }
            
            if (!allowedTypes.includes(file.type)) {
                alert(`O arquivo "${file.name}" não é de um tipo permitido.`);
                this.value = '';
                return;
            }
        }
    });
});
</script>