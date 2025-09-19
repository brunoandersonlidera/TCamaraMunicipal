<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Documento::query();

        // Filtro por busca
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('numero', 'like', "%{$busca}%");
            });
        }

        // Filtro por categoria
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Filtro por status
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inativo') {
                $query->where('ativo', false);
            }
        }

        // Filtro por ano
        if ($request->filled('ano')) {
            $query->whereYear('data_documento', $request->ano);
        }

        // Filtro por data
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_documento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_documento', '<=', $request->data_fim);
        }

        $documentos = $query->orderBy('data_documento', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(15);

        // Dados para filtros
        $categorias = Documento::select('categoria')
                               ->distinct()
                               ->whereNotNull('categoria')
                               ->orderBy('categoria')
                               ->pluck('categoria');

        $anos = Documento::selectRaw('YEAR(data_documento) as ano')
                         ->distinct()
                         ->whereNotNull('data_documento')
                         ->orderBy('ano', 'desc')
                         ->pluck('ano');

        return view('admin.documentos.index', compact('documentos', 'categorias', 'anos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Categorias predefinidas
        $categorias = [
            'ata' => 'Ata',
            'decreto' => 'Decreto',
            'edital' => 'Edital',
            'lei' => 'Lei',
            'portaria' => 'Portaria',
            'regimento' => 'Regimento',
            'resolucao' => 'Resolução',
            'contrato' => 'Contrato',
            'convenio' => 'Convênio',
            'licitacao' => 'Licitação',
            'balanco' => 'Balanço',
            'relatorio' => 'Relatório',
            'outros' => 'Outros'
        ];

        return view('admin.documentos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'numero' => 'nullable|string|max:50',
            'data_documento' => 'required|date',
            'descricao' => 'nullable|string',
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
            'ativo' => 'boolean',
            'destaque' => 'boolean',
            'observacoes' => 'nullable|string'
        ]);

        $documento = new Documento();
        $documento->titulo = $request->titulo;
        $documento->categoria = $request->categoria;
        $documento->numero = $request->numero;
        $documento->data_documento = $request->data_documento;
        $documento->descricao = $request->descricao;
        $documento->ativo = $request->boolean('ativo', true);
        $documento->destaque = $request->boolean('destaque', false);
        $documento->observacoes = $request->observacoes;

        // Upload do arquivo
        if ($request->hasFile('arquivo')) {
            $arquivo = $request->file('arquivo');
            $nomeArquivo = time() . '_' . Str::slug($request->titulo) . '.' . $arquivo->getClientOriginalExtension();
            $caminhoArquivo = $arquivo->storeAs('documentos', $nomeArquivo, 'public');
            $documento->arquivo = $caminhoArquivo;
            $documento->nome_original = $arquivo->getClientOriginalName();
            $documento->tamanho = $arquivo->getSize();
            $documento->tipo_mime = $arquivo->getMimeType();
        }

        $documento->save();

        return redirect()->route('admin.documentos.index')
                        ->with('success', 'Documento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento)
    {
        return view('admin.documentos.show', compact('documento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento)
    {
        // Categorias predefinidas
        $categorias = [
            'ata' => 'Ata',
            'decreto' => 'Decreto',
            'edital' => 'Edital',
            'lei' => 'Lei',
            'portaria' => 'Portaria',
            'regimento' => 'Regimento',
            'resolucao' => 'Resolução',
            'contrato' => 'Contrato',
            'convenio' => 'Convênio',
            'licitacao' => 'Licitação',
            'balanco' => 'Balanço',
            'relatorio' => 'Relatório',
            'outros' => 'Outros'
        ];

        return view('admin.documentos.edit', compact('documento', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'numero' => 'nullable|string|max:50',
            'data_documento' => 'required|date',
            'descricao' => 'nullable|string',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
            'ativo' => 'boolean',
            'destaque' => 'boolean',
            'observacoes' => 'nullable|string'
        ]);

        $documento->titulo = $request->titulo;
        $documento->categoria = $request->categoria;
        $documento->numero = $request->numero;
        $documento->data_documento = $request->data_documento;
        $documento->descricao = $request->descricao;
        $documento->ativo = $request->boolean('ativo', true);
        $documento->destaque = $request->boolean('destaque', false);
        $documento->observacoes = $request->observacoes;

        // Upload do novo arquivo (se fornecido)
        if ($request->hasFile('arquivo')) {
            // Remove o arquivo antigo
            if ($documento->arquivo && Storage::disk('public')->exists($documento->arquivo)) {
                Storage::disk('public')->delete($documento->arquivo);
            }

            $arquivo = $request->file('arquivo');
            $nomeArquivo = time() . '_' . Str::slug($request->titulo) . '.' . $arquivo->getClientOriginalExtension();
            $caminhoArquivo = $arquivo->storeAs('documentos', $nomeArquivo, 'public');
            $documento->arquivo = $caminhoArquivo;
            $documento->nome_original = $arquivo->getClientOriginalName();
            $documento->tamanho = $arquivo->getSize();
            $documento->tipo_mime = $arquivo->getMimeType();
        }

        $documento->save();

        return redirect()->route('admin.documentos.index')
                        ->with('success', 'Documento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        // Remove o arquivo do storage
        if ($documento->arquivo && Storage::disk('public')->exists($documento->arquivo)) {
            Storage::disk('public')->delete($documento->arquivo);
        }

        $documento->delete();

        return redirect()->route('admin.documentos.index')
                        ->with('success', 'Documento excluído com sucesso!');
    }

    /**
     * Toggle the active status of the document.
     */
    public function toggleStatus(Documento $documento)
    {
        $documento->ativo = !$documento->ativo;
        $documento->save();

        $status = $documento->ativo ? 'ativado' : 'desativado';
        
        return redirect()->back()
                        ->with('success', "Documento {$status} com sucesso!");
    }

    /**
     * Download the document file.
     */
    public function download(Documento $documento)
    {
        if (!$documento->arquivo || !Storage::disk('public')->exists($documento->arquivo)) {
            return redirect()->back()
                           ->with('error', 'Arquivo não encontrado!');
        }

        $caminhoCompleto = Storage::disk('public')->path($documento->arquivo);
        $nomeDownload = $documento->nome_original ?: basename($documento->arquivo);

        return response()->download($caminhoCompleto, $nomeDownload);
    }

    /**
     * Get document statistics for dashboard.
     */
    public function getStats()
    {
        return [
            'total' => Documento::count(),
            'ativos' => Documento::where('ativo', true)->count(),
            'inativos' => Documento::where('ativo', false)->count(),
            'destaques' => Documento::where('destaque', true)->count(),
            'por_categoria' => Documento::selectRaw('categoria, COUNT(*) as total')
                                      ->groupBy('categoria')
                                      ->orderBy('total', 'desc')
                                      ->get(),
            'recentes' => Documento::where('ativo', true)
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get()
        ];
    }
}