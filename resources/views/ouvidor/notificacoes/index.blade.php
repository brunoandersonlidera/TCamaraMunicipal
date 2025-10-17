@extends('layouts.ouvidor')

@section('title', 'Notificações')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Notificações</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('ouvidor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notificações</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>
                        Central de Notificações
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="marcarTodasLidas">
                            <i class="fas fa-check-double me-1"></i>
                            Marcar Todas como Lidas
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="atualizarNotificacoes">
                            <i class="fas fa-sync-alt me-1"></i>
                            Atualizar
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="notificacoes-container">
                        <!-- As notificações serão carregadas aqui via AJAX -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                            <p class="mt-2 text-muted">Carregando notificações...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template para notificação -->
<template id="notificacao-template">
    <div class="notification-item border-bottom" data-id="">
        <div class="d-flex align-items-start p-3">
            <div class="notification-icon me-3">
                <i class="fas fa-circle text-primary"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="notification-title mb-1"></h6>
                        <p class="notification-message text-muted mb-2"></p>
                        <small class="notification-time text-muted">
                            <i class="fas fa-clock me-1"></i>
                            <span class="time-text"></span>
                        </small>
                    </div>
                    <div class="notification-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary me-2 btn-marcar-lida">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-ver-detalhes">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Template para notificação vazia -->
<template id="notificacao-vazia-template">
    <div class="text-center py-5">
        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Nenhuma notificação</h5>
        <p class="text-muted">Você está em dia com todas as suas notificações!</p>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificacoesContainer = document.getElementById('notificacoes-container');
    const btnMarcarTodasLidas = document.getElementById('marcarTodasLidas');
    const btnAtualizar = document.getElementById('atualizarNotificacoes');

    // Carregar notificações
    function carregarNotificacoes() {
        fetch('{{ route("ouvidor.api.notificacoes") }}')
            .then(response => response.json())
            .then(data => {
                renderizarNotificacoes(data.notificacoes);
            })
            .catch(error => {
                console.error('Erro ao carregar notificações:', error);
                mostrarErro('Erro ao carregar notificações');
            });
    }

    // Renderizar notificações
    function renderizarNotificacoes(notificacoes) {
        notificacoesContainer.innerHTML = '';

        if (notificacoes.length === 0) {
            const template = document.getElementById('notificacao-vazia-template');
            const clone = template.content.cloneNode(true);
            notificacoesContainer.appendChild(clone);
            return;
        }

        notificacoes.forEach(notificacao => {
            const template = document.getElementById('notificacao-template');
            const clone = template.content.cloneNode(true);

            // Preencher dados
            clone.querySelector('.notification-item').setAttribute('data-id', notificacao.id);
            clone.querySelector('.notification-title').textContent = notificacao.titulo;
            clone.querySelector('.notification-message').textContent = notificacao.mensagem;
            clone.querySelector('.time-text').textContent = formatarTempo(notificacao.created_at);

            // Definir ícone baseado no tipo
            const icon = clone.querySelector('.notification-icon i');
            switch (notificacao.tipo) {
                case 'vencida':
                    icon.className = 'fas fa-exclamation-triangle text-danger';
                    break;
                case 'vencendo':
                    icon.className = 'fas fa-clock text-warning';
                    break;
                case 'nova':
                    icon.className = 'fas fa-plus-circle text-success';
                    break;
                default:
                    icon.className = 'fas fa-bell text-primary';
            }

            // Marcar como lida se necessário
            if (notificacao.lida_em) {
                clone.querySelector('.notification-item').classList.add('read');
                clone.querySelector('.btn-marcar-lida').style.display = 'none';
            }

            // Adicionar event listeners
            const btnMarcarLida = clone.querySelector('.btn-marcar-lida');
            const btnVerDetalhes = clone.querySelector('.btn-ver-detalhes');

            btnMarcarLida.addEventListener('click', () => marcarComoLida(notificacao.id));
            btnVerDetalhes.addEventListener('click', () => verDetalhes(notificacao));

            notificacoesContainer.appendChild(clone);
        });
    }

    // Marcar notificação como lida
    function marcarComoLida(id) {
        fetch(`{{ route("ouvidor.notificacoes.marcar-lida", ":id") }}`.replace(':id', id), {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-id="${id}"]`);
                item.classList.add('read');
                item.querySelector('.btn-marcar-lida').style.display = 'none';
                
                // Atualizar contador no header se existir
                atualizarContadorNotificacoes();
            }
        })
        .catch(error => {
            console.error('Erro ao marcar como lida:', error);
            mostrarErro('Erro ao marcar notificação como lida');
        });
    }

    // Marcar todas como lidas
    function marcarTodasComoLidas() {
        fetch('{{ route("ouvidor.notificacoes.marcar-todas-lidas") }}', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                carregarNotificacoes();
                atualizarContadorNotificacoes();
                mostrarSucesso('Todas as notificações foram marcadas como lidas');
            }
        })
        .catch(error => {
            console.error('Erro ao marcar todas como lidas:', error);
            mostrarErro('Erro ao marcar todas as notificações como lidas');
        });
    }

    // Ver detalhes da notificação
    function verDetalhes(notificacao) {
        if (notificacao.manifestacao_id) {
            window.open(`{{ route("admin.manifestacoes.show", ":id") }}`.replace(':id', notificacao.manifestacao_id), '_blank');
        }
    }

    // Atualizar contador de notificações no header
    function atualizarContadorNotificacoes() {
        const contador = document.querySelector('.notification-count');
        if (contador) {
            fetch('{{ route("ouvidor.api.notificacoes") }}')
                .then(response => response.json())
                .then(data => {
                    const naoLidas = data.notificacoes.filter(n => !n.lida_em).length;
                    contador.textContent = naoLidas;
                    contador.style.display = naoLidas > 0 ? 'inline' : 'none';
                });
        }
    }

    // Formatar tempo relativo
    function formatarTempo(timestamp) {
        const agora = new Date();
        const data = new Date(timestamp);
        const diff = agora - data;
        const minutos = Math.floor(diff / 60000);
        const horas = Math.floor(minutos / 60);
        const dias = Math.floor(horas / 24);

        if (minutos < 1) return 'Agora mesmo';
        if (minutos < 60) return `${minutos} min atrás`;
        if (horas < 24) return `${horas}h atrás`;
        if (dias < 7) return `${dias} dias atrás`;
        
        return data.toLocaleDateString('pt-BR');
    }

    // Mostrar mensagens
    function mostrarSucesso(mensagem) {
        // Implementar toast ou alert de sucesso
        console.log('Sucesso:', mensagem);
    }

    function mostrarErro(mensagem) {
        // Implementar toast ou alert de erro
        console.error('Erro:', mensagem);
    }

    // Event listeners
    btnMarcarTodasLidas.addEventListener('click', marcarTodasComoLidas);
    btnAtualizar.addEventListener('click', carregarNotificacoes);

    // Carregar notificações inicialmente
    carregarNotificacoes();

    // Atualizar automaticamente a cada 30 segundos
    setInterval(carregarNotificacoes, 30000);
});
</script>

<style>
.notification-item {
    transition: all 0.3s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.read {
    opacity: 0.7;
    background-color: #f8f9fa;
}

.notification-item.read .notification-title {
    font-weight: normal;
}

.notification-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.notification-item:hover .notification-actions {
    opacity: 1;
}

.notification-icon {
    width: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .notification-actions {
        opacity: 1;
    }
    
    .btn-group .btn {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endsection