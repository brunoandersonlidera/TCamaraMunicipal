<!-- Modal Consulta Pública -->
<div class="modal fade" id="modalConsultaPublica" tabindex="-1" aria-labelledby="modalConsultaPublicaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.projetos-lei.iniciar-consulta-publica', $projeto) }}" method="POST">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConsultaPublicaLabel">
                        <i class="fas fa-users me-2"></i>Iniciar Consulta Pública
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Consulta Pública</strong><br>
                        A consulta pública permitirá que os cidadãos opinem sobre este projeto de lei através do portal da transparência.
                    </div>
                    
                    <div class="mb-3">
                        <label for="data_inicio" class="form-label">Data de Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="data_prazo" class="form-label">Data de Encerramento</label>
                        <input type="date" class="form-control" id="data_prazo" name="data_prazo" 
                               value="{{ now()->addDays(30)->format('Y-m-d') }}" required>
                        <div class="form-text">Recomendamos um prazo mínimo de 15 dias</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao_consulta" class="form-label">Descrição da Consulta</label>
                        <textarea class="form-control" id="descricao_consulta" name="descricao_consulta" rows="4" 
                                  placeholder="Descreva o objetivo da consulta pública e como os cidadãos podem participar...">{{ $projeto->titulo }}

Esta consulta pública tem como objetivo coletar contribuições da sociedade sobre o projeto de lei em questão. 

Os cidadãos podem manifestar sua opinião, sugerir alterações e contribuir para o aperfeiçoamento da proposta legislativa.</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notificar_cidadaos" name="notificar_cidadaos" value="1" checked>
                            <label class="form-check-label" for="notificar_cidadaos">
                                Notificar cidadãos cadastrados por e-mail
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="publicar_redes_sociais" name="publicar_redes_sociais" value="1">
                            <label class="form-check-label" for="publicar_redes_sociais">
                                Publicar nas redes sociais da Câmara
                            </label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prazo_dias" class="form-label">Duração (dias)</label>
                                <input type="number" class="form-control" id="prazo_dias" name="prazo_dias" 
                                       value="30" min="7" max="90" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_participacao" class="form-label">Tipo de Participação</label>
                                <select class="form-select" id="tipo_participacao" name="tipo_participacao">
                                    <option value="comentarios">Comentários</option>
                                    <option value="enquete">Enquete (Favorável/Contrário)</option>
                                    <option value="ambos" selected>Comentários + Enquete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-play me-1"></i>Iniciar Consulta Pública
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataInicio = document.getElementById('data_inicio');
    const dataPrazo = document.getElementById('data_prazo');
    const prazoDias = document.getElementById('prazo_dias');
    
    function calcularPrazo() {
        if (dataInicio.value && dataPrazo.value) {
            const inicio = new Date(dataInicio.value);
            const prazo = new Date(dataPrazo.value);
            const diffTime = Math.abs(prazo - inicio);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            prazoDias.value = diffDays;
        }
    }
    
    dataInicio.addEventListener('change', calcularPrazo);
    dataPrazo.addEventListener('change', calcularPrazo);
    
    // Validar que a data de prazo é posterior à data de início
    dataPrazo.addEventListener('change', function() {
        if (dataInicio.value && dataPrazo.value) {
            const inicio = new Date(dataInicio.value);
            const prazo = new Date(dataPrazo.value);
            
            if (prazo <= inicio) {
                alert('A data de encerramento deve ser posterior à data de início.');
                dataPrazo.value = '';
            }
        }
    });
    
    // Calcular prazo inicial
    calcularPrazo();
});
</script>