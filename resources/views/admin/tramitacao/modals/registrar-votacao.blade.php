<!-- Modal Registrar Votação -->
<div class="modal fade" id="modalRegistrarVotacao" tabindex="-1" aria-labelledby="modalRegistrarVotacaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.projetos-lei.registrar-votacao', $projeto) }}" method="POST">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegistrarVotacaoLabel">
                        <i class="fas fa-vote-yea me-2"></i>Registrar Votação
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="turno" class="form-label">Turno da Votação</label>
                            <select class="form-select" id="turno" name="turno" required>
                                <option value="">Selecione o turno</option>
                                <option value="1">Primeiro Turno</option>
                                <option value="2">Segundo Turno</option>
                                <option value="unico">Turno Único</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="data_votacao" class="form-label">Data da Votação</label>
                            <input type="date" class="form-control" id="data_votacao" name="data_votacao" 
                                   value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="votos_favoraveis" class="form-label">Votos Favoráveis</label>
                            <input type="number" class="form-control" id="votos_favoraveis" name="votos_favoraveis" 
                                   min="0" value="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="votos_contrarios" class="form-label">Votos Contrários</label>
                            <input type="number" class="form-control" id="votos_contrarios" name="votos_contrarios" 
                                   min="0" value="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="abstencoes" class="form-label">Abstenções</label>
                            <input type="number" class="form-control" id="abstencoes" name="abstencoes" 
                                   min="0" value="0" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="total_presentes" class="form-label">Total de Presentes</label>
                            <input type="number" class="form-control" id="total_presentes" name="total_presentes" 
                                   min="1" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="resultado" class="form-label">Resultado</label>
                            <select class="form-select" id="resultado" name="resultado" required>
                                <option value="">Automático</option>
                                <option value="aprovado">Aprovado</option>
                                <option value="rejeitado">Rejeitado</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="quorum_necessario" class="form-label">Quórum Mínimo Necessário</label>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-select" id="tipo_quorum" name="tipo_quorum">
                                    <option value="maioria_simples">Maioria Simples</option>
                                    <option value="maioria_absoluta">Maioria Absoluta</option>
                                    <option value="dois_tercos">2/3 dos Membros</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" id="quorum_necessario" name="quorum_necessario" 
                                       readonly placeholder="Calculado automaticamente">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observacoes_votacao" class="form-label">Observações da Votação</label>
                        <textarea class="form-control" id="observacoes_votacao" name="observacoes_votacao" rows="3" 
                                  placeholder="Adicione observações sobre a votação (emendas, destaques, etc.)..."></textarea>
                    </div>
                    
                    <!-- Resumo da Votação -->
                    <div class="card bg-light">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Resumo da Votação</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-3">
                                    <div class="text-success">
                                        <i class="fas fa-thumbs-up fa-2x mb-2"></i>
                                        <div><strong id="resumo-favoraveis">0</strong></div>
                                        <small>Favoráveis</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="text-danger">
                                        <i class="fas fa-thumbs-down fa-2x mb-2"></i>
                                        <div><strong id="resumo-contrarios">0</strong></div>
                                        <small>Contrários</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="text-warning">
                                        <i class="fas fa-minus fa-2x mb-2"></i>
                                        <div><strong id="resumo-abstencoes">0</strong></div>
                                        <small>Abstenções</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="text-info">
                                        <i class="fas fa-users fa-2x mb-2"></i>
                                        <div><strong id="resumo-total">0</strong></div>
                                        <small>Total</small>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success" id="barra-favoraveis" style="width: 0%"></div>
                                    <div class="progress-bar bg-danger" id="barra-contrarios" style="width: 0%"></div>
                                    <div class="progress-bar bg-warning" id="barra-abstencoes" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <span class="badge bg-primary" id="resultado-automatico">Resultado será calculado automaticamente</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Registrar Votação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const votosFavoraveis = document.getElementById('votos_favoraveis');
    const votosContrarios = document.getElementById('votos_contrarios');
    const abstencoes = document.getElementById('abstencoes');
    const totalPresentes = document.getElementById('total_presentes');
    const tipoQuorum = document.getElementById('tipo_quorum');
    const quorumNecessario = document.getElementById('quorum_necessario');
    const resultado = document.getElementById('resultado');
    
    // Elementos do resumo
    const resumoFavoraveis = document.getElementById('resumo-favoraveis');
    const resumoContrarios = document.getElementById('resumo-contrarios');
    const resumoAbstencoes = document.getElementById('resumo-abstencoes');
    const resumoTotal = document.getElementById('resumo-total');
    const barraFavoraveis = document.getElementById('barra-favoraveis');
    const barraContrarios = document.getElementById('barra-contrarios');
    const barraAbstencoes = document.getElementById('barra-abstencoes');
    const resultadoAutomatico = document.getElementById('resultado-automatico');
    
    // Total de vereadores (assumindo 9 vereadores, ajustar conforme necessário)
    const totalVereadores = 9;
    
    function calcularTotais() {
        const favoraveis = parseInt(votosFavoraveis.value) || 0;
        const contrarios = parseInt(votosContrarios.value) || 0;
        const abstencoes_val = parseInt(abstencoes.value) || 0;
        const total = favoraveis + contrarios + abstencoes_val;
        
        // Atualizar campos
        totalPresentes.value = total;
        
        // Atualizar resumo
        resumoFavoraveis.textContent = favoraveis;
        resumoContrarios.textContent = contrarios;
        resumoAbstencoes.textContent = abstencoes_val;
        resumoTotal.textContent = total;
        
        // Atualizar barras de progresso
        if (total > 0) {
            const percFavoraveis = (favoraveis / total) * 100;
            const percContrarios = (contrarios / total) * 100;
            const percAbstencoes = (abstencoes_val / total) * 100;
            
            barraFavoraveis.style.width = percFavoraveis + '%';
            barraContrarios.style.width = percContrarios + '%';
            barraAbstencoes.style.width = percAbstencoes + '%';
        }
        
        // Calcular resultado automático
        calcularResultado(favoraveis, contrarios, total);
    }
    
    function calcularQuorum() {
        const tipo = tipoQuorum.value;
        let quorum = 0;
        
        switch(tipo) {
            case 'maioria_simples':
                quorum = Math.floor(totalVereadores / 2) + 1;
                break;
            case 'maioria_absoluta':
                quorum = Math.floor(totalVereadores / 2) + 1;
                break;
            case 'dois_tercos':
                quorum = Math.ceil((totalVereadores * 2) / 3);
                break;
        }
        
        quorumNecessario.value = quorum;
        return quorum;
    }
    
    function calcularResultado(favoraveis, contrarios, total) {
        const quorum = calcularQuorum();
        let resultadoTexto = '';
        let resultadoClasse = 'bg-secondary';
        
        if (total === 0) {
            resultadoTexto = 'Aguardando votos';
        } else if (favoraveis > contrarios) {
            if (favoraveis >= quorum) {
                resultadoTexto = 'APROVADO';
                resultadoClasse = 'bg-success';
            } else {
                resultadoTexto = 'REJEITADO (quórum insuficiente)';
                resultadoClasse = 'bg-danger';
            }
        } else {
            resultadoTexto = 'REJEITADO';
            resultadoClasse = 'bg-danger';
        }
        
        resultadoAutomatico.textContent = resultadoTexto;
        resultadoAutomatico.className = 'badge ' + resultadoClasse;
    }
    
    // Event listeners
    votosFavoraveis.addEventListener('input', calcularTotais);
    votosContrarios.addEventListener('input', calcularTotais);
    abstencoes.addEventListener('input', calcularTotais);
    tipoQuorum.addEventListener('change', calcularTotais);
    
    // Inicializar
    calcularTotais();
});
</script>