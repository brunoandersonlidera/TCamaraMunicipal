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
     * Aprovar comitê (aguardando_validacao -> ativo)
     */
    public function aprovar(Request $request, ComiteIniciativaPopular $comite)
    {
        if (!$comite->isAguardandoValidacao()) {
            return response()->json([
                'success' => false,
                'message' => 'Comitê não está aguardando validação.'
            ], 400);
        }

        $comite->aprovar(auth()->id(), $request->observacoes);

        return response()->json([
            'success' => true,
            'message' => 'Comitê aprovado com sucesso!',
            'status' => $comite->status
        ]);
    }

    /**
     * Solicitar alterações no comitê
     */
    public function solicitarAlteracoes(Request $request, ComiteIniciativaPopular $comite)
    {
        $request->validate([
            'motivo' => 'required|string|max:1000'
        ]);

        if (!in_array($comite->status, ['aguardando_validacao', 'ativo'])) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível solicitar alterações para este comitê.'
            ], 400);
        }

        $comite->solicitarAlteracoes($request->motivo, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Solicitação de alterações enviada com sucesso!',
            'status' => $comite->status
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
     * Validar comitê (ativo -> validado)
     */
    public function validar(Request $request, ComiteIniciativaPopular $comite)
    {
        if (!$comite->atingiuMinimoAssinaturas()) {
            return response()->json([
                'success' => false,
                'message' => 'Comitê não atingiu o mínimo de assinaturas necessárias para validação.'
            ], 400);
        }

        if (!$comite->isAtivo()) {
            return response()->json([
                'success' => false,
                'message' => 'Apenas comitês ativos podem ser validados.'
            ], 400);
        }

        $comite->validar(auth()->id(), $request->observacoes);

        return response()->json([
            'success' => true,
            'message' => 'Comitê validado com sucesso!',
            'status' => $comite->status
        ]);
    }

    /**
     * Rejeitar comitê definitivamente
     */
    public function rejeitar(Request $request, ComiteIniciativaPopular $comite)
    {
        $request->validate([
            'motivo' => 'required|string|max:1000'
        ]);

        if (!in_array($comite->status, ['aguardando_validacao', 'aguardando_alteracoes', 'ativo'])) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível rejeitar este comitê no status atual.'
            ], 400);
        }

        $comite->rejeitar($request->motivo, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Comitê rejeitado com sucesso!',
            'status' => $comite->status
        ]);
    }

    /**
     * Arquivar comitê
     */
    public function arquivar(Request $request, ComiteIniciativaPopular $comite)
    {
        $motivo = $request->motivo ?? 'Arquivado pela administração';
        
        $comite->arquivar($motivo, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Comitê arquivado com sucesso!',
            'status' => $comite->status
        ]);
    }
}
