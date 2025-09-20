<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoSessao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TipoSessaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TipoSessao::query();

        // Filtro por nome
        if ($request->filled('search')) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('ativo', $request->status === 'ativo');
        }

        $tiposSessao = $query->ordenado()->paginate(15);

        return view('admin.tipos-sessao.index', compact('tiposSessao'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tipos-sessao.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:tipo_sessaos,nome',
            'descricao' => 'nullable|string',
            'cor' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icone' => 'required|string|max:50',
            'ativo' => 'boolean',
            'ordem' => 'required|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nome);
        $data['ativo'] = $request->has('ativo');

        TipoSessao::create($data);

        return redirect()->route('admin.tipos-sessao.index')
            ->with('success', 'Tipo de sessão criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoSessao $tipoSessao)
    {
        $tipoSessao->load('sessoes');
        return view('admin.tipos-sessao.show', compact('tipoSessao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoSessao $tipoSessao)
    {
        return view('admin.tipos-sessao.edit', compact('tipoSessao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoSessao $tipoSessao)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:tipo_sessaos,nome,' . $tipoSessao->id,
            'descricao' => 'nullable|string',
            'cor' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icone' => 'required|string|max:50',
            'ativo' => 'boolean',
            'ordem' => 'required|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nome);
        $data['ativo'] = $request->has('ativo');

        $tipoSessao->update($data);

        return redirect()->route('admin.tipos-sessao.index')
            ->with('success', 'Tipo de sessão atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoSessao $tipoSessao)
    {
        // Verificar se há sessões usando este tipo
        if ($tipoSessao->sessoes()->count() > 0) {
            return redirect()->route('admin.tipos-sessao.index')
                ->with('error', 'Não é possível excluir este tipo de sessão pois existem sessões vinculadas a ele.');
        }

        $tipoSessao->delete();

        return redirect()->route('admin.tipos-sessao.index')
            ->with('success', 'Tipo de sessão excluído com sucesso!');
    }
}
