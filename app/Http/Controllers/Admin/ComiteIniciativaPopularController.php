<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComiteIniciativaPopular;
use App\Http\Requests\ComiteIniciativaPopularRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComiteIniciativaPopularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ComiteIniciativaPopular::query();

        // Filtro por busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nome', 'like', "%{$search}%");
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por assinaturas
        if ($request->filled('assinaturas')) {
            if ($request->assinaturas === 'atingiu') {
                $query->whereRaw('numero_assinaturas >= minimo_assinaturas');
            } elseif ($request->assinaturas === 'nao_atingiu') {
                $query->whereRaw('numero_assinaturas < minimo_assinaturas');
            }
        }

        $comites = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.comites-iniciativa-popular.index', compact('comites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.comites-iniciativa-popular.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComiteIniciativaPopularRequest $request)
    {
        $validated = $request->validated();

        // Processar documentos JSON se fornecido
        if ($request->hasFile('documentos_upload')) {
            $documentos = [];
            foreach ($request->file('documentos_upload') as $key => $file) {
                if ($file) {
                    $path = $file->store('comites-iniciativa-popular', 'public');
                    $documentos[$key] = $path;
                }
            }
            $validated['documentos'] = $documentos;
        }

        $comite = ComiteIniciativaPopular::create($validated);

        return redirect()
            ->route('admin.comites-iniciativa-popular.index')
            ->with('success', 'Comitê de iniciativa popular criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComiteIniciativaPopular $comite)
    {
        return view('admin.comites-iniciativa-popular.show', compact('comite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComiteIniciativaPopular $comite)
    {
        return view('admin.comites-iniciativa-popular.edit', compact('comite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ComiteIniciativaPopularRequest $request, ComiteIniciativaPopular $comite)
    {
        $validated = $request->validated();

        // Processar documentos JSON se fornecido
        if ($request->hasFile('documentos_upload')) {
            $documentos = $comite->documentos ?? [];
            
            foreach ($request->file('documentos_upload') as $key => $file) {
                if ($file) {
                    // Remover arquivo anterior se existir
                    if (isset($documentos[$key])) {
                        Storage::disk('public')->delete($documentos[$key]);
                    }
                    
                    $path = $file->store('comites-iniciativa-popular', 'public');
                    $documentos[$key] = $path;
                }
            }
            $validated['documentos'] = $documentos;
        }

        $comite->update($validated);

        return redirect()
            ->route('admin.comites-iniciativa-popular.show', $comite)
            ->with('success', 'Comitê de iniciativa popular atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComiteIniciativaPopular $comite)
    {
        // Remover arquivos de documentos se existirem
        if ($comite->documentos && is_array($comite->documentos)) {
            foreach ($comite->documentos as $documento) {
                if ($documento) {
                    Storage::disk('public')->delete($documento);
                }
            }
        }

        $comite->delete();

        return redirect()
            ->route('admin.comites-iniciativa-popular.index')
            ->with('success', 'Comitê de iniciativa popular excluído com sucesso!');
    }

    /**
     * Toggle status do comitê
     */
    public function toggleStatus(ComiteIniciativaPopular $comite)
    {
        $novoStatus = $comite->status === 'ativo' ? 'arquivado' : 'ativo';
        $comite->update(['status' => $novoStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Status alterado com sucesso!',
            'status' => $novoStatus
        ]);
    }

    /**
     * Download do arquivo de documento específico
     */
    public function download(ComiteIniciativaPopular $comite, $documento)
    {
        if (!$comite->documentos || !is_array($comite->documentos) || !isset($comite->documentos[$documento])) {
            abort(404, 'Documento não encontrado.');
        }

        $path = $comite->documentos[$documento];
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Arquivo não encontrado no servidor.');
        }

        $nomeArquivo = $comite->nome . '_' . $documento . '.' . pathinfo($path, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($path, $nomeArquivo);
    }

    /**
     * Validar comitê
     */
    public function validar(ComiteIniciativaPopular $comite)
    {
        if (!$comite->atingiuMinimoAssinaturas()) {
            return redirect()
                ->back()
                ->with('error', 'Comitê não atingiu o mínimo de assinaturas necessárias para validação.');
        }

        $comite->update(['status' => 'validado']);

        return redirect()
            ->back()
            ->with('success', 'Comitê validado com sucesso!');
    }

    /**
     * Rejeitar comitê
     */
    public function rejeitar(Request $request, ComiteIniciativaPopular $comite)
    {
        $request->validate([
            'observacoes' => 'required|string|max:1000'
        ]);

        $comite->update([
            'status' => 'rejeitado',
            'observacoes' => $request->observacoes
        ]);

        return redirect()
            ->back()
            ->with('success', 'Comitê rejeitado com sucesso!');
    }

    /**
     * Arquivar comitê
     */
    public function arquivar(ComiteIniciativaPopular $comite)
    {
        $comite->update(['status' => 'arquivado']);

        return redirect()
            ->back()
            ->with('success', 'Comitê arquivado com sucesso!');
    }
}
