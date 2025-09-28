<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjetoLei;
use App\Models\Vereador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjetoLeiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProjetoLei::with(['autor', 'coautores']);

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('numero', 'like', "%{$busca}%")
                  ->orWhere('titulo', 'like', "%{$busca}%")
                  ->orWhere('ementa', 'like', "%{$busca}%")
                  ->orWhereHas('autor', function ($q) use ($busca) {
                      $q->where('nome', 'like', "%{$busca}%");
                  });
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ano')) {
            $query->whereYear('data_protocolo', $request->ano);
        }

        if ($request->filled('autor_id')) {
            $query->where('autor_id', $request->autor_id);
        }

        // Ordenação
        $query->orderBy('numero', 'desc');

        $projetos = $query->paginate(15)->withQueryString();
        $vereadores = Vereador::where('status', 'ativo')->orderBy('nome')->get();
        $anos = ProjetoLei::selectRaw('YEAR(data_protocolo) as ano')
                          ->distinct()
                          ->orderBy('ano', 'desc')
                          ->pluck('ano');

        return view('admin.projetos-lei.index', compact('projetos', 'vereadores', 'anos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vereadores = Vereador::where('status', 'ativo')->orderBy('nome')->get();
        $proximoNumero = $this->getProximoNumero();
        
        return view('admin.projetos-lei.create', compact('vereadores', 'proximoNumero'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\ProjetoLeiRequest $request)
    {
        $validated = $request->validated();

        // Upload de arquivos
        if ($request->hasFile('arquivo_projeto')) {
            $validated['arquivo_projeto'] = $request->file('arquivo_projeto')->store('projetos-lei/projetos', 'public');
        }

        if ($request->hasFile('arquivo_lei')) {
            $validated['arquivo_lei'] = $request->file('arquivo_lei')->store('projetos-lei/leis', 'public');
        }

        // Processar tags
        if ($request->filled('tags')) {
            $validated['tags'] = collect(explode(',', $request->tags))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique()
                ->implode(',');
        }

        // Processar dados específicos por tipo de autoria
        $comiteId = null;
        
        switch ($request->tipo_autoria) {
            case 'vereador':
                // Para vereador, usar o autor_id normalmente
                break;
                
            case 'prefeito':
                // Para prefeito, definir autor_nome e limpar autor_id
                $validated['autor_nome'] = 'Prefeito Municipal';
                $validated['autor_id'] = null;
                break;
                
            case 'comissao':
                // Para comissão, usar autor_nome e limpar autor_id
                $validated['autor_id'] = null;
                break;
                
            case 'iniciativa_popular':
                // Para iniciativa popular, criar comitê e limpar autor_id
                $validated['autor_id'] = null;
                $validated['autor_nome'] = null;
                
                if ($request->filled('comite_nome')) {
                    $comite = \App\Models\ComiteIniciativaPopular::create([
                        'nome' => $request->comite_nome,
                        'email' => $request->comite_email,
                        'telefone' => $request->comite_telefone,
                        'numero_assinaturas' => $request->numero_assinaturas ?? 0,
                        'minimo_assinaturas' => $request->minimo_assinaturas ?? 1000,
                        'status' => 'ativo',
                    ]);
                    $comiteId = $comite->id;
                }
                break;
        }

        // Adicionar comite_iniciativa_popular_id se necessário
        if ($comiteId) {
            $validated['comite_iniciativa_popular_id'] = $comiteId;
        }

        $projeto = ProjetoLei::create($validated);

        // Sincronizar coautores
        if ($request->filled('coautores')) {
            $projeto->coautores()->sync($request->coautores);
        }

        return redirect()->route('admin.projetos-lei.index')
                        ->with('success', 'Projeto de lei criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjetoLei $projetoLei)
    {
        $projetoLei->load(['autor', 'coautores']);
        
        return view('admin.projetos-lei.show', compact('projetoLei'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjetoLei $projetoLei)
    {
        $projetoLei->load(['autor', 'coautores']);
        $vereadores = Vereador::where('status', 'ativo')->orderBy('nome')->get();
        
        return view('admin.projetos-lei.edit', compact('projetoLei', 'vereadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\ProjetoLeiRequest $request, ProjetoLei $projetoLei)
    {
        $validated = $request->validated();

        // Upload de arquivos
        if ($request->hasFile('arquivo_projeto')) {
            // Deletar arquivo anterior
            if ($projetoLei->arquivo_projeto) {
                Storage::disk('public')->delete($projetoLei->arquivo_projeto);
            }
            $validated['arquivo_projeto'] = $request->file('arquivo_projeto')->store('projetos-lei/projetos', 'public');
        }

        if ($request->hasFile('arquivo_lei')) {
            // Deletar arquivo anterior
            if ($projetoLei->arquivo_lei) {
                Storage::disk('public')->delete($projetoLei->arquivo_lei);
            }
            $validated['arquivo_lei'] = $request->file('arquivo_lei')->store('projetos-lei/leis', 'public');
        }

        // Processar tags
        if ($request->filled('tags')) {
            $validated['tags'] = collect(explode(',', $request->tags))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique()
                ->implode(',');
        } else {
            $validated['tags'] = null;
        }

        // Processar dados específicos por tipo de autoria
        $comiteId = null;
        
        switch ($request->tipo_autoria) {
            case 'vereador':
                // Para vereador, usar o autor_id normalmente
                $validated['autor_nome'] = null;
                $validated['comite_iniciativa_popular_id'] = null;
                break;
                
            case 'prefeito':
                // Para prefeito, definir autor_nome e limpar autor_id
                $validated['autor_nome'] = 'Prefeito Municipal';
                $validated['autor_id'] = null;
                $validated['comite_iniciativa_popular_id'] = null;
                break;
                
            case 'comissao':
                // Para comissão, usar autor_nome e limpar autor_id
                $validated['autor_id'] = null;
                $validated['comite_iniciativa_popular_id'] = null;
                break;
                
            case 'iniciativa_popular':
                // Para iniciativa popular, atualizar ou criar comitê
                $validated['autor_id'] = null;
                $validated['autor_nome'] = null;
                
                if ($request->filled('comite_nome')) {
                    // Se já existe um comitê, atualizar
                    if ($projetoLei->comiteIniciativaPopular) {
                        $projetoLei->comiteIniciativaPopular->update([
                            'nome' => $request->comite_nome,
                            'email' => $request->comite_email,
                            'telefone' => $request->comite_telefone,
                            'numero_assinaturas' => $request->numero_assinaturas ?? 0,
                            'minimo_assinaturas' => $request->minimo_assinaturas ?? 1000,
                        ]);
                        $comiteId = $projetoLei->comiteIniciativaPopular->id;
                    } else {
                        // Criar novo comitê
                        $comite = \App\Models\ComiteIniciativaPopular::create([
                            'nome' => $request->comite_nome,
                            'email' => $request->comite_email,
                            'telefone' => $request->comite_telefone,
                            'numero_assinaturas' => $request->numero_assinaturas ?? 0,
                            'minimo_assinaturas' => $request->minimo_assinaturas ?? 1000,
                            'status' => 'ativo',
                        ]);
                        $comiteId = $comite->id;
                    }
                }
                break;
        }

        // Adicionar comite_iniciativa_popular_id se necessário
        if ($comiteId) {
            $validated['comite_iniciativa_popular_id'] = $comiteId;
        }

        $projetoLei->update($validated);

        // Sincronizar coautores
        if ($request->filled('coautores')) {
            $projetoLei->coautores()->sync($request->coautores);
        } else {
            $projetoLei->coautores()->detach();
        }

        return redirect()->route('admin.projetos-lei.show', $projetoLei)
                        ->with('success', 'Projeto de lei atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjetoLei $projetoLei)
    {
        // Deletar arquivos associados
        if ($projetoLei->arquivo_projeto) {
            Storage::disk('public')->delete($projetoLei->arquivo_projeto);
        }
        
        if ($projetoLei->arquivo_lei) {
            Storage::disk('public')->delete($projetoLei->arquivo_lei);
        }

        // Remover relacionamentos
        $projetoLei->coautores()->detach();

        $projetoLei->delete();

        return redirect()->route('admin.projetos-lei.index')
                        ->with('success', 'Projeto de lei excluído com sucesso!');
    }

    /**
     * Toggle status do projeto
     */
    public function toggleStatus(Request $request, ProjetoLei $projetoLei)
    {
        $request->validate([
            'status' => 'required|in:tramitando,aprovado,rejeitado,retirado,arquivado'
        ]);

        $projetoLei->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'status' => $projetoLei->status
        ]);
    }

    /**
     * Download de arquivos
     */
    public function download(ProjetoLei $projetoLei, $tipo)
    {
        $arquivo = null;
        
        switch ($tipo) {
            case 'projeto':
                $arquivo = $projetoLei->arquivo_projeto;
                break;
            case 'lei':
                $arquivo = $projetoLei->arquivo_lei;
                break;
            default:
                abort(404);
        }

        if (!$arquivo || !Storage::disk('public')->exists($arquivo)) {
            abort(404, 'Arquivo não encontrado');
        }

        return Storage::disk('public')->download($arquivo);
    }

    /**
     * Gerar próximo número do projeto
     */
    private function getProximoNumero()
    {
        $ano = date('Y');
        $ultimoNumero = ProjetoLei::whereYear('data_protocolo', $ano)
                                  ->max('numero');
        
        if (!$ultimoNumero) {
            return "001/{$ano}";
        }

        // Extrair número da string (formato: 001/2024)
        $numero = (int) explode('/', $ultimoNumero)[0];
        $proximoNumero = str_pad($numero + 1, 3, '0', STR_PAD_LEFT);
        
        return "{$proximoNumero}/{$ano}";
    }
}