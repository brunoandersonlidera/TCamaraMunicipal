<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReceitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Receita::query();

        // Filtros
        if ($request->filled('ano')) {
            $query->where('ano_referencia', $request->ano);
        }

        if ($request->filled('mes')) {
            $query->where('mes_referencia', $request->mes);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('codigo_receita', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('fonte_recurso', 'like', "%{$busca}%");
            });
        }

        $receitas = $query->orderBy('data_arrecadacao', 'desc')
                         ->paginate(20);

        // Dados para filtros
        $anos = Receita::select('ano_referencia')
                      ->distinct()
                      ->orderBy('ano_referencia', 'desc')
                      ->pluck('ano_referencia');

        $categorias = Receita::select('categoria')
                            ->distinct()
                            ->whereNotNull('categoria')
                            ->orderBy('categoria')
                            ->pluck('categoria');

        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        return view('admin.receitas.index', compact('receitas', 'anos', 'categorias', 'meses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Receita::select('categoria')
                            ->distinct()
                            ->whereNotNull('categoria')
                            ->orderBy('categoria')
                            ->pluck('categoria');

        return view('admin.receitas.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|max:50|unique:receitas',
            'descricao' => 'required|string|max:500',
            'categoria' => 'required|string|max:100',
            'valor_previsto' => 'required|numeric|min:0',
            'valor_arrecadado' => 'nullable|numeric|min:0',
            'data_previsao' => 'required|date',
            'data_arrecadacao' => 'nullable|date',
            'fonte' => 'nullable|string|max:200',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|in:prevista,arrecadada,cancelada'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Receita::create($request->all());

        return redirect()->route('receitas.index')
                        ->with('success', 'Receita cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Receita $receita)
    {
        return view('admin.receitas.show', compact('receita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receita $receita)
    {
        $categorias = Receita::select('categoria')
                            ->distinct()
                            ->whereNotNull('categoria')
                            ->orderBy('categoria')
                            ->pluck('categoria');

        return view('admin.receitas.edit', compact('receita', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receita $receita)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|max:50|unique:receitas,codigo,' . $receita->id,
            'descricao' => 'required|string|max:500',
            'categoria' => 'required|string|max:100',
            'valor_previsto' => 'required|numeric|min:0',
            'valor_arrecadado' => 'nullable|numeric|min:0',
            'data_previsao' => 'required|date',
            'data_arrecadacao' => 'nullable|date',
            'fonte' => 'nullable|string|max:200',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|in:prevista,arrecadada,cancelada'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $receita->update($request->all());

        return redirect()->route('receitas.index')
                        ->with('success', 'Receita atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receita $receita)
    {
        $receita->delete();

        return redirect()->route('receitas.index')
                        ->with('success', 'Receita excluída com sucesso!');
    }
}
