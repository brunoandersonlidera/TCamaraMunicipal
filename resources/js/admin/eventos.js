// JavaScript para Admin/Eventos

// Funções globais para manipulação de eventos
window.EventosAdmin = {
    // Inicialização
    init: function() {
        this.initFormHandlers();
        this.initFileUpload();
        this.initColorPicker();
        this.initPreview();
        this.initValidation();
        this.initFilters();
    },

    // Manipuladores de formulário
    initFormHandlers: function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Atualizar preview em tempo real
            const campos = ['titulo', 'descricao', 'data_evento', 'hora_inicio', 'hora_fim', 'local', 'tipo', 'cor_destaque'];
            campos.forEach(campo => {
                const elemento = document.getElementById(campo);
                if (elemento) {
                    elemento.addEventListener('input', EventosAdmin.atualizarPreview);
                    elemento.addEventListener('change', EventosAdmin.atualizarPreview);
                }
            });
        });
    },

    // Upload de arquivos
    initFileUpload: function() {
        const anexoInput = document.getElementById('anexo');
        if (anexoInput) {
            anexoInput.addEventListener('change', function() {
                const arquivo = this.files[0];
                if (arquivo) {
                    const nomeArquivo = document.getElementById('nome-arquivo');
                    const arquivoSelecionado = document.getElementById('arquivo-selecionado');
                    if (nomeArquivo) nomeArquivo.textContent = arquivo.name;
                    if (arquivoSelecionado) arquivoSelecionado.style.display = 'block';
                } else {
                    const arquivoSelecionado = document.getElementById('arquivo-selecionado');
                    if (arquivoSelecionado) arquivoSelecionado.style.display = 'none';
                }
            });
        }

        // Drag and drop para upload
        const uploadArea = document.querySelector('.file-upload-area');
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const anexoInput = document.getElementById('anexo');
                    if (anexoInput) {
                        anexoInput.files = files;
                        anexoInput.dispatchEvent(new Event('change'));
                    }
                }
            });
        }
    },

    // Seletor de cores
    initColorPicker: function() {
        // Função já definida globalmente para compatibilidade
    },

    // Preview do evento
    initPreview: function() {
        document.addEventListener('DOMContentLoaded', function() {
            EventosAdmin.atualizarPreview();
        });
    },

    // Validação de formulários
    initValidation: function() {
        const horaFim = document.getElementById('hora_fim');
        if (horaFim) {
            horaFim.addEventListener('change', function() {
                const horaInicio = document.getElementById('hora_inicio');
                if (horaInicio && horaInicio.value && this.value && this.value <= horaInicio.value) {
                    alert('A hora de término deve ser posterior à hora de início.');
                    this.value = '';
                }
            });
        }
    },

    // Filtros automáticos
    initFilters: function() {
        const formFiltros = document.getElementById('form-filtros');
        if (formFiltros) {
            formFiltros.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', function() {
                    formFiltros.submit();
                });
            });
        }
    },

    // Atualizar preview do evento
    atualizarPreview: function() {
        const titulo = document.getElementById('titulo');
        const descricao = document.getElementById('descricao');
        const dataEvento = document.getElementById('data_evento');
        const horaInicio = document.getElementById('hora_inicio');
        const horaFim = document.getElementById('hora_fim');
        const local = document.getElementById('local');
        const tipo = document.getElementById('tipo');
        const cor = document.getElementById('cor_destaque');

        // Atualizar título e descrição
        const previewTitulo = document.getElementById('preview-titulo');
        const previewDescricao = document.getElementById('preview-descricao');
        
        if (previewTitulo && titulo) {
            previewTitulo.textContent = titulo.value || 'Título do Evento';
        }
        
        if (previewDescricao && descricao) {
            previewDescricao.textContent = descricao.value || 'Descrição do evento...';
        }

        // Atualizar cor
        const previewCor = document.getElementById('preview-cor');
        if (previewCor && cor) {
            previewCor.style.backgroundColor = cor.value;
        }

        // Atualizar data
        if (dataEvento && dataEvento.value) {
            const data = new Date(dataEvento.value + 'T00:00:00');
            const dia = data.getDate().toString().padStart(2, '0');
            const meses = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];
            const mes = meses[data.getMonth()];

            const previewDia = document.getElementById('preview-dia');
            const previewMes = document.getElementById('preview-mes');
            
            if (previewDia) previewDia.textContent = dia;
            if (previewMes) previewMes.textContent = mes;
        }

        // Atualizar tipo
        if (tipo && tipo.value) {
            const tipos = {
                'sessao': 'Sessão Plenária',
                'audiencia': 'Audiência Pública',
                'reuniao': 'Reunião',
                'licitacao': 'Licitação',
                'comemorativa': 'Data Comemorativa',
                'vereador': 'Agenda do Vereador',
                'esic': 'Prazo E-SIC'
            };
            
            const previewTipo = document.getElementById('preview-tipo');
            if (previewTipo) {
                previewTipo.textContent = tipos[tipo.value] || tipo.value;
            }
        }

        // Atualizar horário
        const previewHorario = document.getElementById('preview-horario');
        if (previewHorario && horaInicio) {
            if (horaInicio.value) {
                let horario = horaInicio.value;
                if (horaFim && horaFim.value) {
                    horario += ' às ' + horaFim.value;
                }
                previewHorario.textContent = horario;
                previewHorario.style.display = 'inline-block';
            } else {
                previewHorario.style.display = 'none';
            }
        }

        // Atualizar local
        const previewLocal = document.getElementById('preview-local');
        if (previewLocal && local) {
            if (local.value) {
                previewLocal.textContent = local.value;
                previewLocal.style.display = 'inline-block';
            } else {
                previewLocal.style.display = 'none';
            }
        }
    }
};

// Funções globais para compatibilidade com templates existentes
function selecionarCor(cor) {
    const corInput = document.getElementById('cor_destaque');
    if (corInput) {
        corInput.value = cor;
    }

    // Remover seleção anterior
    document.querySelectorAll('.color-preview').forEach(el => {
        el.classList.remove('selected');
        el.style.border = '2px solid #dee2e6';
    });

    // Adicionar seleção atual
    if (event && event.target) {
        event.target.classList.add('selected');
        event.target.style.border = '2px solid #007bff';
    }

    // Atualizar preview
    EventosAdmin.atualizarPreview();
}

function atualizarPreview() {
    EventosAdmin.atualizarPreview();
}

function salvarRascunho() {
    // Desativar evento temporariamente para salvar como rascunho
    const ativoInput = document.querySelector('input[name="ativo"]');
    if (ativoInput) {
        const ativoOriginal = ativoInput.checked;
        ativoInput.checked = false;

        // Submeter formulário
        const form = document.getElementById('form-evento');
        if (form) {
            form.submit();
        }
    }
}

function confirmarExclusao(eventoId, eventoNome) {
    const eventoNomeEl = document.getElementById('evento-nome');
    const formExclusao = document.getElementById('form-exclusao');
    
    if (eventoNomeEl && eventoNome) {
        eventoNomeEl.textContent = eventoNome;
    }
    
    if (formExclusao) {
        formExclusao.action = `/admin/eventos/${eventoId}`;
    }
    
    const modal = document.getElementById('modalExclusao');
    if (modal && typeof bootstrap !== 'undefined') {
        new bootstrap.Modal(modal).show();
    }
}

function toggleStatus(eventoId) {
    fetch(`/admin/eventos/${eventoId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao alterar status do evento');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao alterar status do evento');
    });
}

function toggleDestaque(eventoId) {
    fetch(`/admin/eventos/${eventoId}/toggle-destaque`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao alterar destaque do evento');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao alterar destaque do evento');
    });
}

function sincronizarEventos() {
    const btn = event.target;
    const originalText = btn.innerHTML;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sincronizando...';
    btn.disabled = true;

    fetch('/admin/eventos/sincronizar', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Erro na sincronização: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro na sincronização');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function removerAnexo() {
    if (confirm('Tem certeza que deseja remover o anexo atual?')) {
        const removerAnexoInput = document.getElementById('remover_anexo');
        const anexoAtual = document.querySelector('.anexo-atual');
        
        if (removerAnexoInput) {
            removerAnexoInput.value = '1';
        }
        
        if (anexoAtual) {
            anexoAtual.style.display = 'none';
        }
    }
}

// Inicializar quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    EventosAdmin.init();
    
    // Event listeners para botões de ação
    document.addEventListener('click', function(e) {
        const target = e.target.closest('[data-action]');
        if (!target) return;
        
        const action = target.dataset.action;
        const eventoId = target.dataset.eventoId;
        const eventoNome = target.dataset.eventoNome;
        
        switch(action) {
            case 'toggle-status':
                toggleStatus(eventoId);
                break;
            case 'toggle-destaque':
                toggleDestaque(eventoId);
                break;
            case 'confirmar-exclusao':
                confirmarExclusao(eventoId, eventoNome);
                break;
        }
    });
    
    // Event listener para botão de sincronização
    const btnSincronizar = document.getElementById('btn-sincronizar');
    if (btnSincronizar) {
        btnSincronizar.addEventListener('click', sincronizarEventos);
    }
});