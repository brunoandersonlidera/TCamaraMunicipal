@extends('layouts.admin')

@section('title', 'Slides do Hero Section')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-images me-2"></i>
                        Slides do Hero Section
                    </h3>
                    <a href="{{ route('admin.slides.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Novo Slide
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($slides->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="80">Imagem</th>
                                        <th>Título</th>
                                        <th width="100">Ordem</th>
                                        <th width="120">Velocidade</th>
                                        <th width="100">Transição</th>
                                        <th width="100">Direção</th>
                                        <th width="80">Status</th>
                                        <th width="150">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($slides as $slide)
                                        <tr>
                                            <td>
                                                @if($slide->url_imagem)
                                                    <img src="{{ $slide->url_imagem }}" 
                                                         alt="{{ $slide->titulo }}" 
                                                         class="img-thumbnail" 
                                                         style="width: 60px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 60px; height: 40px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $slide->titulo }}</strong>
                                                @if($slide->descricao)
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($slide->descricao, 50) }}</small>
                                                @endif
                                                @if($slide->link)
                                                    <br>
                                                    <small>
                                                        <i class="fas fa-link me-1"></i>
                                                        <a href="{{ $slide->link }}" target="_blank" class="text-decoration-none">
                                                            {{ Str::limit($slide->link, 30) }}
                                                        </a>
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $slide->ordem }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $slide->velocidade }}ms</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ ucfirst($slide->transicao) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ ucfirst($slide->direcao) }}</span>
                                            </td>
                                            <td>
                                                <button type="button" 
                                                        class="btn btn-sm toggle-status {{ $slide->ativo ? 'btn-success' : 'btn-danger' }}"
                                                        data-slide-id="{{ $slide->id }}"
                                                        data-status="{{ $slide->ativo ? 'ativo' : 'inativo' }}">
                                                    <i class="fas {{ $slide->ativo ? 'fa-check' : 'fa-times' }}"></i>
                                                    {{ $slide->ativo ? 'Ativo' : 'Inativo' }}
                                                </button>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.slides.show', $slide) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.slides.edit', $slide) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger delete-slide" 
                                                            data-slide-id="{{ $slide->id }}"
                                                            data-slide-title="{{ $slide->titulo }}"
                                                            title="Excluir">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $slides->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhum slide encontrado</h5>
                            <p class="text-muted">Comece criando seu primeiro slide para o hero section.</p>
                            <a href="{{ route('admin.slides.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Criar Primeiro Slide
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o slide <strong id="slideTitle"></strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const slideId = this.dataset.slideId;
            const currentStatus = this.dataset.status;
            
            fetch(`/admin/slides/${slideId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualizar botão
                    const newStatus = data.ativo ? 'ativo' : 'inativo';
                    this.dataset.status = newStatus;
                    this.className = `btn btn-sm toggle-status ${data.ativo ? 'btn-success' : 'btn-danger'}`;
                    this.innerHTML = `<i class="fas ${data.ativo ? 'fa-check' : 'fa-times'}"></i> ${data.ativo ? 'Ativo' : 'Inativo'}`;
                    
                    // Mostrar mensagem de sucesso
                    showAlert('success', data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('danger', 'Erro ao alterar status do slide.');
            });
        });
    });

    // Delete Slide
    document.querySelectorAll('.delete-slide').forEach(button => {
        button.addEventListener('click', function() {
            const slideId = this.dataset.slideId;
            const slideTitle = this.dataset.slideTitle;
            
            document.getElementById('slideTitle').textContent = slideTitle;
            document.getElementById('deleteForm').action = `/admin/slides/${slideId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    // Função para mostrar alertas
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        const container = document.querySelector('.card-body');
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-remover após 5 segundos
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>
@endpush