<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vereador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VereadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vereador::query();
        
        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('nome_parlamentar', 'like', "%{$search}%")
                  ->orWhere('partido', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('partido')) {
            $query->where('partido', $request->partido);
        }
        
        $vereadores = $query->orderBy('nome_parlamentar')->paginate(15);
        
        // Para os filtros
        $partidos = Vereador::distinct()->pluck('partido')->filter()->sort();
        
        return view('admin.vereadores.index', compact('vereadores', 'partidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vereadores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'nome_parlamentar' => 'required|string|max:255',
            'partido' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biografia' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'profissao' => 'nullable|string|max:255',
            'escolaridade' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
            'redes_sociais' => 'nullable|array',
            'status' => 'required|in:ativo,inativo',
            'inicio_mandato' => 'nullable|date',
            'fim_mandato' => 'nullable|date|after_or_equal:inicio_mandato',
            'legislatura' => 'nullable|string|max:50',
            'comissoes' => 'nullable|array',
            'projetos_apresentados' => 'nullable|integer|min:0',
            'votos_favoraveis' => 'nullable|integer|min:0',
            'votos_contrarios' => 'nullable|integer|min:0',
            'abstencoes' => 'nullable|integer|min:0',
            'presencas_sessoes' => 'nullable|integer|min:0',
            'observacoes' => 'nullable|string'
        ]);
        
        // Upload da foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('vereadores', 'public');
        }
        
        // Filtrar redes sociais vazias
        if (isset($validated['redes_sociais'])) {
            $validated['redes_sociais'] = array_filter($validated['redes_sociais']);
        }
        
        // Filtrar comissões vazias
        if (isset($validated['comissoes'])) {
            $validated['comissoes'] = array_filter($validated['comissoes']);
        }
        
        Vereador::create($validated);
        
        return redirect()->route('admin.vereadores.index')
                        ->with('success', 'Vereador cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vereador $vereador)
    {
        return view('admin.vereadores.show', compact('vereador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vereador $vereador)
    {
        return view('admin.vereadores.edit', compact('vereador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vereador $vereador)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'nome_parlamentar' => 'required|string|max:255',
            'partido' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biografia' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'profissao' => 'nullable|string|max:255',
            'escolaridade' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
            'redes_sociais' => 'nullable|array',
            'status' => 'required|in:ativo,inativo',
            'inicio_mandato' => 'nullable|date',
            'fim_mandato' => 'nullable|date|after_or_equal:inicio_mandato',
            'legislatura' => 'nullable|string|max:50',
            'comissoes' => 'nullable|array',
            'projetos_apresentados' => 'nullable|integer|min:0',
            'votos_favoraveis' => 'nullable|integer|min:0',
            'votos_contrarios' => 'nullable|integer|min:0',
            'abstencoes' => 'nullable|integer|min:0',
            'presencas_sessoes' => 'nullable|integer|min:0',
            'observacoes' => 'nullable|string'
        ]);
        
        // Upload da nova foto
        if ($request->hasFile('foto')) {
            // Deletar foto antiga se existir
            if ($vereador->foto) {
                Storage::disk('public')->delete($vereador->foto);
            }
            $validated['foto'] = $request->file('foto')->store('vereadores', 'public');
        }
        
        // Filtrar redes sociais vazias
        if (isset($validated['redes_sociais'])) {
            $validated['redes_sociais'] = array_filter($validated['redes_sociais']);
        }
        
        // Filtrar comissões vazias
        if (isset($validated['comissoes'])) {
            $validated['comissoes'] = array_filter($validated['comissoes']);
        }
        
        $vereador->update($validated);
        
        return redirect()->route('admin.vereadores.index')
                        ->with('success', 'Vereador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vereador $vereador)
    {
        // Deletar foto se existir
        if ($vereador->foto) {
            Storage::disk('public')->delete($vereador->foto);
        }
        
        $vereador->delete();
        
        return redirect()->route('admin.vereadores.index')
                        ->with('success', 'Vereador removido com sucesso!');
    }
    
    /**
     * Toggle status do vereador
     */
    public function toggleStatus(Vereador $vereador)
    {
        $vereador->update([
            'status' => $vereador->status === 'ativo' ? 'inativo' : 'ativo'
        ]);
        
        $status = $vereador->status === 'ativo' ? 'ativado' : 'desativado';
        
        return redirect()->back()
                        ->with('success', "Vereador {$status} com sucesso!");
    }
}