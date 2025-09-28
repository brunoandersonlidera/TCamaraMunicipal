<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracaoGeral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ConfiguracaoGeralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ConfiguracaoGeral::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('chave', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('valor', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('ativo', $request->status);
        }

        $configuracoes = $query->orderBy('chave')->paginate(15);
        
        return view('admin.configuracao-geral.index', compact('configuracoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.configuracao-geral.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chave' => 'required|string|max:255|unique:configuracao_gerais,chave',
            'valor' => 'nullable|string',
            'tipo' => 'required|in:texto,imagem,email,telefone',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $valor = $request->valor;

        // Se for tipo imagem e houver upload
        if ($request->tipo === 'imagem' && $request->hasFile('imagem')) {
            $arquivo = $request->file('imagem');
            $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
            $caminho = $arquivo->storeAs('configuracoes', $nomeArquivo, 'public');
            $valor = $caminho;
        }

        ConfiguracaoGeral::create([
            'chave' => $request->chave,
            'valor' => $valor,
            'tipo' => $request->tipo,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('admin.configuracao-geral.index')
            ->with('success', 'Configuração criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ConfiguracaoGeral $configuracao)
    {
        return view('admin.configuracao-geral.show', compact('configuracao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfiguracaoGeral $configuracao)
    {
        return view('admin.configuracao-geral.edit', compact('configuracao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConfiguracaoGeral $configuracao)
    {
        $validator = Validator::make($request->all(), [
            'chave' => 'required|string|max:255|unique:configuracao_gerais,chave,' . $configuracao->id,
            'valor' => 'nullable|string',
            'tipo' => 'required|in:texto,imagem,email,telefone',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $valor = $request->valor;

        // Se for tipo imagem e houver upload
        if ($request->tipo === 'imagem' && $request->hasFile('imagem')) {
            // Deletar imagem anterior se existir
            if ($configuracao->valor && Storage::disk('public')->exists($configuracao->valor)) {
                Storage::disk('public')->delete($configuracao->valor);
            }

            $arquivo = $request->file('imagem');
            $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
            $caminho = $arquivo->storeAs('configuracoes', $nomeArquivo, 'public');
            $valor = $caminho;
        } elseif ($request->tipo === 'imagem' && !$request->hasFile('imagem')) {
            // Manter valor atual se for imagem e não houver novo upload
            $valor = $configuracao->valor;
        }

        $configuracao->update([
            'chave' => $request->chave,
            'valor' => $valor,
            'tipo' => $request->tipo,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('admin.configuracao-geral.index')
            ->with('success', 'Configuração atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConfiguracaoGeral $configuracao)
    {
        // Deletar arquivo de imagem se existir
        if ($configuracao->tipo === 'imagem' && $configuracao->valor && Storage::disk('public')->exists($configuracao->valor)) {
            Storage::disk('public')->delete($configuracao->valor);
        }

        $configuracao->delete();

        return redirect()->route('admin.configuracao-geral.index')
            ->with('success', 'Configuração removida com sucesso!');
    }
}
