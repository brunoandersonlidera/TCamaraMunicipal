<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcessoRapido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcessoRapidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acessos = AcessoRapido::ordenados()->paginate(10);
        
        return view('admin.acesso-rapido.index', compact('acessos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.acesso-rapido.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'url' => 'required|string|max:255',
            'icone' => 'required|string|max:100',
            'cor_botao' => 'required|string|max:7',
            'cor_fonte' => 'required|string|max:7',
            'ordem' => 'required|integer|min:0',
            'ativo' => 'boolean',
            'abrir_nova_aba' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AcessoRapido::create($request->all());

        return redirect()->route('admin.acesso-rapido.index')
            ->with('success', 'Acesso rápido criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcessoRapido $acessoRapido)
    {
        return view('admin.acesso-rapido.show', compact('acessoRapido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcessoRapido $acessoRapido)
    {
        return view('admin.acesso-rapido.edit', compact('acessoRapido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcessoRapido $acessoRapido)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'url' => 'required|string|max:255',
            'icone' => 'required|string|max:100',
            'cor_botao' => 'required|string|max:7',
            'cor_fonte' => 'required|string|max:7',
            'ordem' => 'required|integer|min:0',
            'ativo' => 'boolean',
            'abrir_nova_aba' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $acessoRapido->update($request->all());

        return redirect()->route('admin.acesso-rapido.index')
            ->with('success', 'Acesso rápido atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcessoRapido $acessoRapido)
    {
        $acessoRapido->delete();

        return redirect()->route('admin.acesso-rapido.index')
            ->with('success', 'Acesso rápido removido com sucesso!');
    }

    /**
     * Atualizar ordem dos itens via AJAX
     */
    public function updateOrder(Request $request)
    {
        $items = $request->input('items');
        
        foreach ($items as $item) {
            AcessoRapido::where('id', $item['id'])
                ->update(['ordem' => $item['ordem']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle status ativo/inativo
     */
    public function toggleStatus(AcessoRapido $acessoRapido)
    {
        $acessoRapido->update(['ativo' => !$acessoRapido->ativo]);

        return redirect()->back()
            ->with('success', 'Status atualizado com sucesso!');
    }
}
