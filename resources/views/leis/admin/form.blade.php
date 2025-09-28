@extends('layouts.admin')

@section('title', (isset($lei) ? 'Editar' : 'Nova') . ' Lei - Administração')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-balance-scale"></i>
                {{ isset($lei) ? 'Editar Lei' : 'Nova Lei' }}
            </h1>
            <p class="text-muted mb-0">
                {{ isset($lei) ? 'Edite as informações da lei ' . $lei->numero_formatado : 'Cadastre uma nova lei no acervo municipal' }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.leis.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>

    <form method="POST" 
          action="{{ isset($lei) ? route('admin.leis.update', $lei->id) : route('admin.leis.store') }}" 
          enctype="multipart/form-data"
          id="formLei">
        @csrf
        @if(isset($lei))
            @method('PUT')
        @endif

        <div class="row">
            <!-- Coluna Principal -->
            <div class="col-lg-8">
                <!-- Informações Básicas -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle"></i>
                            Informações Básicas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Número -->
                            <div class="col-md-3">
                                <label for="numero" class="form-label">
                                    Número <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('numero') is-invalid @enderror" 
                                       id="numero" 
                                       name="numero" 
                                       value="{{ old('numero', $lei->numero ?? '') }}"
                                       required
                                       min="1"
                                       placeholder="Ex: 1485">
                                @error('numero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Exercício -->
                            <div class="col-md-3">
                                <label for="exercicio" class="form-label">
                                    Exercício <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('exercicio') is-invalid @enderror" 
                                       id="exercicio" 
                                       name="exercicio" 
                                       value="{{ old('exercicio', $lei->exercicio ?? date('Y')) }}"
                                       required
                                       min="1900"
                                       max="{{ date('Y') + 5 }}"
                                       placeholder="{{ date('Y') }}">
                                @error('exercicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Data -->
                            <div class="col-md-3">
                                <label for="data" class="form-label">
                                    Data <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('data') is-invalid @enderror" 
                                       id="data" 
                                       name="data" 
                                       value="{{ old('data', isset($lei) ? $lei->data->format('Y-m-d') : '') }}"
                                       required>
                                @error('data')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo -->
                            <div class="col-md-3">
                                <label for="tipo" class="form-label">
                                    Tipo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" 
                                        name="tipo" 
                                        required>
                                    <option value="">Selecione...</option>
                                    @foreach(\App\Models\Lei::getTipos() as $tipo)
                                        <option value="{{ $tipo }}" 
                                                {{ old('tipo', $lei->tipo ?? '') == $tipo ? 'selected' : '' }}>
                                            {{ $tipo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Título -->
                            <div class="col-12">
                                <label for="titulo" class="form-label">
                                    Título <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" 
                                       name="titulo" 
                                       value="{{ old('titulo', $lei->titulo ?? '') }}"
                                       required
                                       maxlength="255"
                                       placeholder="Ex: LEI MUNICIPAL Nº 1.485 DE 16 DE SETEMBRO DE 2025">
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Autoria -->
                            <div class="col-md-6">
                                <label for="autoria" class="form-label">Autoria</label>
                                <input type="text" 
                                       class="form-control @error('autoria') is-invalid @enderror" 
                                       id="autoria" 
                                       name="autoria" 
                                       value="{{ old('autoria', $lei->autoria ?? '') }}"
                                       maxlength="255"
                                       placeholder="Ex: Poder Executivo Municipal">
                                @error('autoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="ativo" class="form-label">Status</label>
                                <select class="form-select @error('ativo') is-invalid @enderror" 
                                        id="ativo" 
                                        name="ativo">
                                    <option value="1" {{ old('ativo', $lei->ativo ?? 1) == 1 ? 'selected' : '' }}>
                                        Ativo
                                    </option>
                                    <option value="0" {{ old('ativo', $lei->ativo ?? 1) == 0 ? 'selected' : '' }}>
                                        Inativo
                                    </option>
                                </select>
                                @error('ativo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ementa -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-alt"></i>
                            Ementa
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ementa" class="form-label">
                                Ementa da Lei
                            </label>
                            <textarea class="form-control @error('ementa') is-invalid @enderror" 
                                      id="ementa" 
                                      name="ementa" 
                                      rows="3"
                                      placeholder="Resumo do objeto da lei...">{{ old('ementa', $lei->ementa ?? '') }}</textarea>
                            @error('ementa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Conteúdo -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-align-left"></i>
                            Conteúdo da Lei
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="descricao" class="form-label">
                                Descrição/Conteúdo <span class="text-danger">*</span>
                            </label>
                            
                            <!-- Barra de ferramentas para formatação de leis -->
                            <div class="lei-toolbar mb-2">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" onclick="inserirArtigo()" title="Inserir Artigo">
                                        <i class="fas fa-paragraph"></i> Art.
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="inserirParagrafo()" title="Inserir Parágrafo">
                                        <i class="fas fa-section"></i> §
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="inserirInciso()" title="Inserir Inciso">
                                        <i class="fas fa-list-ol"></i> I
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="inserirAlinea()" title="Inserir Alínea">
                                        <i class="fas fa-list"></i> a)
                                    </button>
                                </div>
                                <div class="btn-group btn-group-sm ms-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="inserirTemplate('lei')" title="Template Lei">
                                        <i class="fas fa-file-alt"></i> Lei
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="inserirTemplate('decreto')" title="Template Decreto">
                                        <i class="fas fa-stamp"></i> Decreto
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="inserirTemplate('resolucao')" title="Template Resolução">
                                        <i class="fas fa-gavel"></i> Resolução
                                    </button>
                                </div>
                            </div>
                            
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" 
                                      name="descricao" 
                                      rows="15"
                                      required
                                      placeholder="Digite o conteúdo completo da lei...">{{ old('descricao', $lei->descricao ?? '') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Use a barra de ferramentas acima para inserir elementos estruturais da lei (artigos, parágrafos, incisos, alíneas).
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sticky-note"></i>
                            Observações
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="observacoes" class="form-label">
                                Observações Adicionais
                            </label>
                            <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                      id="observacoes" 
                                      name="observacoes" 
                                      rows="4"
                                      placeholder="Informações adicionais, alterações, revogações, etc...">{{ old('observacoes', $lei->observacoes ?? '') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Arquivo PDF -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-pdf"></i>
                            Arquivo PDF
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($lei) && $lei->temArquivoPdf())
                            <div class="alert alert-info">
                                <i class="fas fa-file-pdf"></i>
                                <strong>Arquivo atual:</strong>
                                <br>
                                <a href="{{ route('leis.download', $lei->id) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-download"></i>
                                    Baixar PDF atual
                                </a>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="arquivo_pdf" class="form-label">
                                {{ isset($lei) && $lei->temArquivoPdf() ? 'Substituir arquivo PDF' : 'Upload do arquivo PDF' }}
                            </label>
                            <input type="file" 
                                   class="form-control @error('arquivo_pdf') is-invalid @enderror" 
                                   id="arquivo_pdf" 
                                   name="arquivo_pdf"
                                   accept=".pdf">
                            @error('arquivo_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Apenas arquivos PDF. Tamanho máximo: 10MB.
                            </div>
                        </div>

                        @if(isset($lei) && $lei->temArquivoPdf())
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="remover_pdf" 
                                       name="remover_pdf" 
                                       value="1">
                                <label class="form-check-label text-danger" for="remover_pdf">
                                    <i class="fas fa-trash"></i>
                                    Remover arquivo PDF atual
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Preview do Slug -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-link"></i>
                            URL da Lei
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="slug_preview" class="form-label">URL que será gerada:</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ url('/leis') }}/</span>
                                <input type="text" 
                                       class="form-control" 
                                       id="slug_preview" 
                                       readonly
                                       placeholder="sera-gerado-automaticamente">
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>
                                A URL é gerada automaticamente baseada no tipo, número e exercício.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                {{ isset($lei) ? 'Atualizar Lei' : 'Salvar Lei' }}
                            </button>
                            
                            @if(isset($lei))
                                <a href="{{ route('leis.show', $lei->slug) }}" 
                                   class="btn btn-outline-info"
                                   target="_blank">
                                    <i class="fas fa-eye"></i>
                                    Visualizar Lei
                                </a>
                            @endif
                            
                            <a href="{{ route('admin.leis.index') }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leis.css') }}">
@endpush

@push('scripts')
<!-- TinyMCE -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js"></script>

<script src="{{ asset('js/leis.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado, inicializando TinyMCE...');
    
    // Verificar se TinyMCE está disponível
    if (typeof tinymce === 'undefined') {
        console.warn('TinyMCE não carregou. Usando textarea padrão.');
        document.getElementById('descricao').style.display = 'block';
        return;
    }
    
    console.log('TinyMCE disponível, configurando...');
    
    // Remover instâncias existentes
    tinymce.remove('#descricao');
    
    // Inicializar TinyMCE com configuração simplificada
    tinymce.init({
        selector: '#descricao',
        height: 500,
        plugins: 'lists link code table wordcount',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link | code | forecolor backcolor',
        menubar: false,
        branding: false,
        statusbar: true,
        resize: true,
        color_map: [
            "000000", "Preto",
            "993300", "Marrom escuro", 
            "333300", "Verde escuro",
            "003300", "Verde muito escuro",
            "003366", "Azul escuro",
            "000080", "Azul marinho",
            "333399", "Azul acinzentado",
            "333333", "Cinza muito escuro",
            "800000", "Vermelho escuro",
            "FF6600", "Laranja",
            "808000", "Oliva",
            "008000", "Verde",
            "008080", "Verde azulado",
            "0000FF", "Azul",
            "666699", "Azul acinzentado",
            "808080", "Cinza",
            "FF0000", "Vermelho",
            "FF9900", "Âmbar",
            "99CC00", "Verde amarelado",
            "339966", "Verde mar",
            "33CCCC", "Turquesa",
            "3366FF", "Azul real",
            "800080", "Roxo",
            "999999", "Cinza médio",
            "FF00FF", "Magenta",
            "FFCC00", "Ouro",
            "FFFF00", "Amarelo",
            "00FF00", "Lima",
            "00FFFF", "Aqua",
            "00CCFF", "Azul céu",
            "993366", "Vermelho",
            "FFFFFF", "Branco"
        ],
        setup: function (editor) {
            editor.on('init', function () {
                console.log('Editor TinyMCE inicializado com sucesso');
                // Focar no editor após inicialização
                setTimeout(function() {
                    editor.focus();
                }, 100);
            });
        }
    }).catch(function(error) {
        console.error('Erro ao inicializar TinyMCE:', error);
        // Mostrar textarea padrão em caso de erro
        const textarea = document.getElementById('descricao');
        textarea.style.display = 'block';
        textarea.style.height = '500px';
        textarea.focus();
    });
    
    // Adicionar botão de teste para verificar se o editor está funcionando
    setTimeout(function() {
        const container = document.querySelector('.form-group:has(#descricao)');
        if (container && !document.getElementById('test-editor-btn')) {
            const testBtn = document.createElement('button');
            testBtn.id = 'test-editor-btn';
            testBtn.type = 'button';
            testBtn.className = 'btn btn-sm btn-info mt-2';
            testBtn.textContent = 'Testar Editor';
            testBtn.onclick = function() {
                const editor = tinymce.get('descricao');
                if (editor) {
                    editor.setContent('Teste de edição - ' + new Date().toLocaleString());
                    console.log('Conteúdo inserido no editor');
                } else {
                    console.log('Editor não encontrado');
                    document.getElementById('descricao').value = 'Teste de edição - ' + new Date().toLocaleString();
                }
            };
            container.appendChild(testBtn);
        }
    }, 1000);

    // Atualizar preview do slug
    function atualizarSlugPreview() {
        const tipo = document.getElementById('tipo').value;
        const numero = document.getElementById('numero').value;
        const exercicio = document.getElementById('exercicio').value;
        
        if (tipo && numero && exercicio) {
            const slug = `${tipo.toLowerCase().replace(/\s+/g, '-')}-${numero}-${exercicio}`;
            document.getElementById('slug_preview').value = slug;
        } else {
            document.getElementById('slug_preview').value = 'sera-gerado-automaticamente';
        }
    }
    
    // Eventos para atualizar o slug
    ['tipo', 'numero', 'exercicio'].forEach(id => {
        document.getElementById(id).addEventListener('input', atualizarSlugPreview);
        document.getElementById(id).addEventListener('change', atualizarSlugPreview);
    });
    
    // Atualizar na inicialização
    atualizarSlugPreview();
    
    // Validação do formulário
    document.getElementById('formLei').addEventListener('submit', function(e) {
        // Sincronizar conteúdo do TinyMCE
        tinymce.triggerSave();
        
        const numero = document.getElementById('numero').value;
        const exercicio = document.getElementById('exercicio').value;
        const data = document.getElementById('data').value;
        const tipo = document.getElementById('tipo').value;
        const titulo = document.getElementById('titulo').value;
        const descricao = document.getElementById('descricao').value;
        
        if (!numero || !exercicio || !data || !tipo || !titulo || !descricao) {
            e.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
            return false;
        }
    });
});

// Funções para inserir elementos estruturais de leis
function inserirArtigo() {
    const editor = tinymce.get('descricao');
    if (editor) {
        const conteudo = editor.getContent();
        const artigos = conteudo.match(/Art\.\s*(\d+)º?/g);
        const proximoNumero = artigos ? artigos.length + 1 : 1;
        
        // Formatação correta para números ordinais
        let numeroFormatado;
        if (proximoNumero === 1) {
            numeroFormatado = '1º';
        } else if (proximoNumero === 2) {
            numeroFormatado = '2º';
        } else if (proximoNumero === 3) {
            numeroFormatado = '3º';
        } else {
            numeroFormatado = proximoNumero + 'º';
        }
        
        const novoConteudo = `<p class="artigo"><strong>Art. ${numeroFormatado}</strong> </p>`;
        editor.insertContent(novoConteudo);
        editor.focus();
    }
}

function inserirParagrafo() {
    const editor = tinymce.get('descricao');
    if (editor) {
        const conteudo = editor.getContent();
        const paragrafos = conteudo.match(/§\s*(\d+)º?/g);
        const proximoNumero = paragrafos ? paragrafos.length + 1 : 1;
        
        // Formatação correta para números ordinais
        let numeroFormatado;
        if (proximoNumero === 1) {
            numeroFormatado = '1º';
        } else if (proximoNumero === 2) {
            numeroFormatado = '2º';
        } else if (proximoNumero === 3) {
            numeroFormatado = '3º';
        } else {
            numeroFormatado = proximoNumero + 'º';
        }
        
        const novoConteudo = `<p class="paragrafo"><strong>§ ${numeroFormatado}</strong> </p>`;
        editor.insertContent(novoConteudo);
        editor.focus();
    }
}

function inserirInciso() {
    const editor = tinymce.get('descricao');
    if (editor) {
        const conteudo = editor.getContent();
        // Busca por padrões de incisos romanos mais precisos
        const incisos = conteudo.match(/\b[IVX]+\s*[-–]/g);
        const proximoNumero = incisos ? incisos.length + 1 : 1;
        const numeroRomano = converterParaRomano(proximoNumero);
        
        const novoConteudo = `<p class="inciso"><strong>${numeroRomano} –</strong> </p>`;
        editor.insertContent(novoConteudo);
        editor.focus();
    }
}

function inserirAlinea() {
    const editor = tinymce.get('descricao');
    if (editor) {
        const conteudo = editor.getContent();
        // Busca por padrões de alíneas mais precisos
        const alineas = conteudo.match(/\b[a-z]\)\s/g);
        const proximoNumero = alineas ? alineas.length + 1 : 1;
        const letra = String.fromCharCode(96 + proximoNumero); // 'a', 'b', 'c'...
        
        const novoConteudo = `<p class="alinea"><strong>${letra})</strong> </p>`;
        editor.insertContent(novoConteudo);
        editor.focus();
    }
}

// Função auxiliar para converter números em romanos (melhorada)
function converterParaRomano(num) {
    if (num <= 0 || num > 3999) return num.toString();
    
    const valores = [1000, 900, 500, 400, 100, 90, 50, 40, 10, 9, 5, 4, 1];
    const simbolos = ['M', 'CM', 'D', 'CD', 'C', 'XC', 'L', 'XL', 'X', 'IX', 'V', 'IV', 'I'];
    
    let resultado = '';
    for (let i = 0; i < valores.length; i++) {
        while (num >= valores[i]) {
            resultado += simbolos[i];
            num -= valores[i];
        }
    }
    return resultado;
}

function inserirTemplate(tipo) {
    const editor = tinymce.get('descricao');
    if (!editor) return;
    
    const templates = {
        lei: `<p class="artigo"><strong>Art. 1º</strong> Esta Lei [descrever o objetivo principal da lei].</p>
<p class="paragrafo"><strong>§ 1º</strong> [Parágrafo explicativo, se necessário].</p>
<p class="paragrafo"><strong>§ 2º</strong> [Outro parágrafo, se necessário].</p>

<p class="artigo"><strong>Art. 2º</strong> [Segundo artigo da lei]:</p>
<p class="inciso"><strong>I</strong> – [primeiro inciso];</p>
<p class="inciso"><strong>II</strong> – [segundo inciso];</p>
<p class="inciso"><strong>III</strong> – [terceiro inciso].</p>

<p class="artigo"><strong>Art. 3º</strong> Esta Lei entra em vigor na data de sua publicação.</p>

<p class="artigo"><strong>Art. 4º</strong> Revogam-se as disposições em contrário.</p>`,

        decreto: `<p class="artigo"><strong>Art. 1º</strong> Fica [estabelecido/criado/regulamentado] [objeto do decreto].</p>

<p class="artigo"><strong>Art. 2º</strong> [Disposições específicas]:</p>
<p class="inciso"><strong>I</strong> – [primeiro item];</p>
<p class="inciso"><strong>II</strong> – [segundo item];</p>
<p class="inciso"><strong>III</strong> – [terceiro item].</p>

<p class="artigo"><strong>Art. 3º</strong> Este Decreto entra em vigor na data de sua publicação.</p>`,

        resolucao: `<p class="artigo"><strong>Art. 1º</strong> Fica [aprovado/estabelecido] [objeto da resolução].</p>

<p class="artigo"><strong>Art. 2º</strong> [Disposições específicas da resolução].</p>

<p class="artigo"><strong>Art. 3º</strong> Esta Resolução entra em vigor na data de sua publicação.</p>`
    };
    
    if (templates[tipo]) {
        editor.setContent(templates[tipo]);
        editor.focus();
    }
}
</script>
@endpush