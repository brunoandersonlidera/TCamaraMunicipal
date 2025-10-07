@extends('layouts.app')

@section('title', 'Criar Comitê de Iniciativa Popular')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-users"></i> Criar Comitê de Iniciativa Popular
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Informações importantes -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Informações Importantes</h6>
                        <ul class="mb-0 small">
                            <li>Você será o responsável por este comitê</li>
                            <li>É necessário coletar pelo menos <strong>{{ number_format($minimo_assinaturas) }}</strong> assinaturas válidas</li>
                            <li>Sua assinatura será automaticamente incluída como a primeira</li>
                            <li>O comitê ficará ativo para coleta até a data limite definida</li>
                        </ul>
                    </div>

                    <form action="{{ route('cidadao.comites.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Nome do Comitê -->
                            <div class="col-md-12 mb-3">
                                <label for="nome" class="form-label">Nome do Comitê <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" 
                                       name="nome" 
                                       value="{{ old('nome') }}"
                                       placeholder="Ex: Comitê Pró-Ciclovias"
                                       maxlength="255"
                                       required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descrição -->
                            <div class="col-md-12 mb-3">
                                <label for="descricao" class="form-label">Descrição do Comitê <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                          id="descricao" 
                                          name="descricao" 
                                          rows="4"
                                          placeholder="Descreva detalhadamente o que o comitê pretende alcançar..."
                                          maxlength="1000"
                                          required>{{ old('descricao') }}</textarea>
                                <div class="form-text">Máximo 1000 caracteres</div>
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Objetivo -->
                            <div class="col-md-12 mb-3">
                                <label for="objetivo" class="form-label">Objetivo Principal <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('objetivo') is-invalid @enderror" 
                                          id="objetivo" 
                                          name="objetivo" 
                                          rows="3"
                                          placeholder="Qual o principal objetivo que o comitê busca atingir?"
                                          maxlength="500"
                                          required>{{ old('objetivo') }}</textarea>
                                <div class="form-text">Máximo 500 caracteres</div>
                                @error('objetivo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ementa do Projeto de Lei -->
                            <div class="col-md-12 mb-3">
                                <label for="editorEmenta" class="form-label">Ementa do Projeto de Lei <span class="text-danger">*</span></label>
                                <div class="d-flex justify-content-end gap-2 mb-2">
                                    <button type="button" id="toggleHtmlEmenta" class="btn btn-sm btn-outline-secondary">Modo HTML</button>
                                </div>
                                <!-- Editor visual (Quill) -->
                                <div id="editorEmentaWrapper" class="quill-wrapper">
                                    <div id="editorEmenta">{!! old('ementa') !!}</div>
                                </div>
                                <!-- Editor HTML (texto bruto) -->
                                <textarea id="ementaHtmlEditor" class="form-control" style="display:none; min-height: 220px;">{!! old('ementa') !!}</textarea>
                                <!-- Campo real para submissão -->
                                <textarea class="form-control d-none @error('ementa') is-invalid @enderror" id="ementa" name="ementa" required>{!! old('ementa') !!}</textarea>
                                <div class="form-text">Você pode formatar o texto e inserir links e listas. Use “Modo HTML” para editar o código-fonte.</div>
                                @error('ementa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Texto Completo do Projeto de Lei (Editor Rico) -->
                            <div class="col-md-12 mb-3">
                                <label for="editorTextoProjeto" class="form-label">Texto Completo do Projeto de Lei <span class="text-danger">*</span></label>
                                <div class="d-flex justify-content-end gap-2 mb-2">
                                    <button type="button" id="toggleHtmlTexto" class="btn btn-sm btn-outline-secondary">Modo HTML</button>
                                </div>
                                <!-- Editor visual (Quill) -->
                                <div id="editorTextoProjetoWrapper" class="quill-wrapper">
                                    <div id="editorTextoProjeto">{!! old('texto_projeto_html') !!}</div>
                                </div>
                                <!-- Editor HTML (texto bruto) -->
                                <textarea id="textoProjetoHtmlEditor" class="form-control" style="display:none; min-height: 360px;">{!! old('texto_projeto_html') !!}</textarea>
                                <!-- Campo real para submissão -->
                                <textarea class="form-control d-none @error('texto_projeto_html') is-invalid @enderror" id="texto_projeto_html" name="texto_projeto_html" required>{!! old('texto_projeto_html') !!}</textarea>
                                <div class="form-text">Edite com formatação rica; o conteúdo será salvo como HTML. Use “Modo HTML” para editar o código-fonte.</div>
                                @error('texto_projeto_html')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email de Contato -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email de Contato <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', auth('cidadao')->user()->email) }}"
                                       placeholder="contato@exemplo.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telefone de Contato -->
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone de Contato <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('telefone') is-invalid @enderror" 
                                       id="telefone" 
                                       name="telefone" 
                                       value="{{ old('telefone') }}"
                                       placeholder="(11) 99999-9999"
                                       required>
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Data Fim da Coleta -->
                            <div class="col-md-6 mb-3">
                                <label for="data_fim_coleta" class="form-label">Data Limite para Coleta <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('data_fim_coleta') is-invalid @enderror" 
                                       id="data_fim_coleta" 
                                       name="data_fim_coleta" 
                                       value="{{ old('data_fim_coleta') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       required>
                                <div class="form-text">Data limite para coletar as assinaturas necessárias</div>
                                @error('data_fim_coleta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Termos e Condições -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aceito_termos" required>
                                <label class="form-check-label" for="aceito_termos">
                                    Declaro que as informações fornecidas são verdadeiras e aceito os 
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#termosModal">termos e condições</a> 
                                    para criação de comitê de iniciativa popular.
                                </label>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cidadao.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Criar Comitê
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Termos e Condições -->
<div class="modal fade" id="termosModal" tabindex="-1" aria-labelledby="termosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termosModalLabel">Termos e Condições - Comitê de Iniciativa Popular</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Responsabilidades do Responsável pelo Comitê</h6>
                <p>Ao criar um comitê de iniciativa popular, você se compromete a:</p>
                <ul>
                    <li>Fornecer informações verdadeiras e atualizadas</li>
                    <li>Conduzir a coleta de assinaturas de forma ética e legal</li>
                    <li>Respeitar a privacidade dos signatários</li>
                    <li>Não utilizar o comitê para fins eleitorais ou partidários</li>
                </ul>

                <h6>2. Coleta de Assinaturas</h6>
                <p>A coleta de assinaturas deve seguir as seguintes diretrizes:</p>
                <ul>
                    <li>Apenas eleitores do município podem assinar</li>
                    <li>Cada pessoa pode assinar apenas uma vez por comitê</li>
                    <li>As assinaturas serão validadas pela equipe da Câmara</li>
                    <li>Informações falsas podem resultar na invalidação do comitê</li>
                </ul>

                <h6>3. Prazo e Validade</h6>
                <p>O comitê terá validade até a data limite definida. Após esse prazo, não será possível coletar novas assinaturas.</p>

                <h6>4. Privacidade e Proteção de Dados</h6>
                <p>Todos os dados coletados serão tratados conforme a Lei Geral de Proteção de Dados (LGPD).</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone');
    telefoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    });

    // Contador de caracteres
    const descricaoTextarea = document.getElementById('descricao');
    const objetivoTextarea = document.getElementById('objetivo');
    
    function updateCharCount(element, maxLength) {
        const remaining = maxLength - element.value.length;
        const helpText = element.nextElementSibling;
        if (helpText && helpText.classList.contains('form-text')) {
            helpText.textContent = `${remaining} caracteres restantes`;
            if (remaining < 50) {
                helpText.classList.add('text-warning');
            } else {
                helpText.classList.remove('text-warning');
            }
        }
    }
    
    descricaoTextarea.addEventListener('input', function() {
        updateCharCount(this, 1000);
    });
    
    objetivoTextarea.addEventListener('input', function() {
        updateCharCount(this, 500);
    });
});
</script>

<!-- Quill Editor (Open Source, gratuito) -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<style>
/* Ajustes de estilo para evitar sobreposição da toolbar pelo editor */
.quill-wrapper {
    border: 1px solid #ced4da;
    border-radius: .375rem;
    background: #fff;
}
.quill-wrapper .ql-toolbar.ql-snow {
    border: none;
    border-bottom: 1px solid #ced4da;
    background: #f8f9fa;
    border-radius: .375rem .375rem 0 0;
    position: relative;
    z-index: 1;
}
.quill-wrapper .ql-container.ql-snow {
    border: none;
    min-height: 220px;
    border-radius: 0 0 .375rem .375rem;
}
#editorEmenta .ql-editor {
    min-height: 220px;
}
#editorTextoProjeto .ql-editor {
    min-height: 380px;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Flags de modo
    let modoHtmlEmenta = false;
    let modoHtmlTexto = false;

    // Configuração básica para a Ementa
    var quillEmenta = new Quill('#editorEmenta', {
        theme: 'snow',
        placeholder: 'Adicione a ementa com formatação de texto (negrito, listas, links etc.).',
        modules: {
            toolbar: [
                [{ 'header': [false, 2, 3] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link']
            ]
        }
    });
    // Sincronizar com o textarea oculto
    quillEmenta.on('text-change', function() {
        if (!modoHtmlEmenta) {
            document.getElementById('ementa').value = quillEmenta.root.innerHTML.trim();
        }
    });

    // Configuração para o Texto Completo
    var quillTexto = new Quill('#editorTextoProjeto', {
        theme: 'snow',
        placeholder: 'Escreva ou cole o texto completo do projeto de lei com formatação rica.',
        modules: {
            toolbar: [
                [{ 'header': [false, 1, 2, 3, 4] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'blockquote', 'code-block'],
                ['clean']
            ]
        }
    });
    quillTexto.on('text-change', function() {
        if (!modoHtmlTexto) {
            document.getElementById('texto_projeto_html').value = quillTexto.root.innerHTML.trim();
        }
    });

    // Alternar modos: Ementa
    const toggleHtmlEmentaBtn = document.getElementById('toggleHtmlEmenta');
    const ementaHtmlEditor = document.getElementById('ementaHtmlEditor');
    const ementaWrapper = document.getElementById('editorEmentaWrapper');
    toggleHtmlEmentaBtn.addEventListener('click', function() {
        if (!modoHtmlEmenta) {
            // Ir para modo HTML
            ementaHtmlEditor.value = quillEmenta.root.innerHTML.trim();
            ementaWrapper.style.display = 'none';
            ementaHtmlEditor.style.display = 'block';
            toggleHtmlEmentaBtn.textContent = 'Voltar ao modo visual';
            modoHtmlEmenta = true;
        } else {
            // Voltar ao modo Visual
            const html = ementaHtmlEditor.value;
            quillEmenta.root.innerHTML = html;
            ementaHtmlEditor.style.display = 'none';
            ementaWrapper.style.display = 'block';
            toggleHtmlEmentaBtn.textContent = 'Modo HTML';
            modoHtmlEmenta = false;
        }
    });

    // Alternar modos: Texto Completo
    const toggleHtmlTextoBtn = document.getElementById('toggleHtmlTexto');
    const textoHtmlEditor = document.getElementById('textoProjetoHtmlEditor');
    const textoWrapper = document.getElementById('editorTextoProjetoWrapper');
    toggleHtmlTextoBtn.addEventListener('click', function() {
        if (!modoHtmlTexto) {
            textoHtmlEditor.value = quillTexto.root.innerHTML.trim();
            textoWrapper.style.display = 'none';
            textoHtmlEditor.style.display = 'block';
            toggleHtmlTextoBtn.textContent = 'Voltar ao modo visual';
            modoHtmlTexto = true;
        } else {
            const html = textoHtmlEditor.value;
            quillTexto.root.innerHTML = html;
            textoHtmlEditor.style.display = 'none';
            textoWrapper.style.display = 'block';
            toggleHtmlTextoBtn.textContent = 'Modo HTML';
            modoHtmlTexto = false;
        }
    });

    // Garantir sincronização ao enviar o formulário
    var form = document.querySelector('form[action="{{ route('cidadao.comites.store') }}"]');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('ementa').value = modoHtmlEmenta ? ementaHtmlEditor.value.trim() : quillEmenta.root.innerHTML.trim();
            document.getElementById('texto_projeto_html').value = modoHtmlTexto ? textoHtmlEditor.value.trim() : quillTexto.root.innerHTML.trim();
        });
    }
});
</script>
@endsection