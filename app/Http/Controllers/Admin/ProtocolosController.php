<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjetoLei;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProtocolosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProjetoLei::query();

        // Filtros
        if ($request->filled('numero_protocolo')) {
            $query->where('numero_protocolo', 'like', '%' . $request->numero_protocolo . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data_protocolo', [
                $request->data_inicio,
                $request->data_fim
            ]);
        }

        $protocolos = $query->orderBy('data_protocolo', 'desc')
                           ->paginate(20);

        // Estatísticas
        $estatisticas = [
            'total' => ProjetoLei::count(),
            'protocolados_hoje' => ProjetoLei::whereDate('data_protocolo', today())->count(),
            'em_tramitacao' => ProjetoLei::where('status', 'em_tramitacao')->count(),
            'aprovados' => ProjetoLei::where('status', 'aprovado')->count(),
        ];

        return view('admin.protocolos.index', compact('protocolos', 'estatisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.protocolos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ementa' => 'required|string',
            'tipo' => 'required|in:projeto_lei,projeto_resolucao,projeto_decreto,indicacao,requerimento,mocao',
            'autor' => 'required|string|max:255',
            'justificativa' => 'nullable|string',
        ]);

        // Gerar número de protocolo automático
        $ano = date('Y');
        $ultimoNumero = ProjetoLei::where('tipo', $validated['tipo'])
                                 ->whereYear('data_protocolo', $ano)
                                 ->max('numero_sequencial') ?? 0;
        
        $numeroSequencial = $ultimoNumero + 1;
        $numeroProtocolo = $this->gerarNumeroProtocolo($validated['tipo'], $numeroSequencial, $ano);

        $validated['numero_protocolo'] = $numeroProtocolo;
        $validated['numero_sequencial'] = $numeroSequencial;
        $validated['data_protocolo'] = now();
        $validated['status'] = 'protocolado';

        ProjetoLei::create($validated);

        return redirect()->route('admin.protocolos.index')
                        ->with('success', 'Protocolo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $protocolo = ProjetoLei::findOrFail($id);
        return view('admin.protocolos.show', compact('protocolo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $protocolo = ProjetoLei::findOrFail($id);
        return view('admin.protocolos.edit', compact('protocolo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $protocolo = ProjetoLei::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ementa' => 'required|string',
            'tipo' => 'required|in:projeto_lei,projeto_resolucao,projeto_decreto,indicacao,requerimento,mocao',
            'autor' => 'required|string|max:255',
            'justificativa' => 'nullable|string',
            'status' => 'required|in:protocolado,em_tramitacao,aprovado,rejeitado,arquivado',
        ]);

        $protocolo->update($validated);

        return redirect()->route('admin.protocolos.index')
                        ->with('success', 'Protocolo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $protocolo = ProjetoLei::findOrFail($id);
        $protocolo->delete();

        return redirect()->route('admin.protocolos.index')
                        ->with('success', 'Protocolo excluído com sucesso!');
    }

    /**
     * Gerar número de protocolo automático baseado no tipo
     */
    private function gerarNumeroProtocolo($tipo, $numeroSequencial, $ano)
    {
        $prefixos = [
            'projeto_lei' => 'PL',
            'projeto_resolucao' => 'PR',
            'projeto_decreto' => 'PD',
            'indicacao' => 'IND',
            'requerimento' => 'REQ',
            'mocao' => 'MOC',
        ];

        $prefixo = $prefixos[$tipo] ?? 'DOC';
        
        return sprintf('%s %03d/%d', $prefixo, $numeroSequencial, $ano);
    }
}
