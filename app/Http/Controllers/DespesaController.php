<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Despesa::query();

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

        if ($request->filled('favorecido')) {
            $query->where('favorecido', 'like', "%{$request->favorecido}%");
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('numero_empenho', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('favorecido', 'like', "%{$busca}%");
            });
        }

        $despesas = $query->orderBy('data_empenho', 'desc')
                         ->paginate(20);

        // Dados para filtros
        $anos = Despesa::select('ano_referencia')
                      ->distinct()
                      ->orderBy('ano', 'desc')
                      ->pluck('ano');

        $categorias = Despesa::select('categoria')
                            ->distinct()
                            ->whereNotNull('categoria')
                            ->orderBy('categoria')
                            ->pluck('categoria');

        $credores = Despesa::select('credor')
                          ->distinct()
                          ->whereNotNull('credor')
                          ->orderBy('credor')
                          ->pluck('credor');

        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        return view('admin.despesas.index', compact('despesas', 'anos', 'categorias', 'credores', 'meses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Despesa::select('categoria')
                            ->distinct()
                            ->whereNotNull('categoria')
                            ->orderBy('categoria')
                            ->pluck('categoria');

        $credores = Despesa::select('credor')
                          ->distinct()
                          ->whereNotNull('credor')
                          ->orderBy('credor')
                          ->pluck('credor');

        return view('admin.despesas.create', compact('categorias', 'credores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_empenho' => 'required|string|max:50|unique:despesas',
            'descricao' => 'required|string|max:500',
            'categoria' => 'required|string|max:100',
            'credor' => 'required|string|max:200',
            'cnpj_cpf_credor' => 'nullable|string|max:20',
            'valor_empenhado' => 'required|numeric|min:0',
            'valor_liquidado' => 'nullable|numeric|min:0',
            'valor_pago' => 'nullable|numeric|min:0',
            'data_empenho' => 'required|date',
            'data_liquidacao' => 'nullable|date',
            'data_pagamento' => 'nullable|date',
            'periodo_inicio' => 'nullable|date',
            'periodo_fim' => 'nullable|date',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|in:empenhada,liquidada,paga,cancelada'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Despesa::create($request->all());

        return redirect()->route('despesas.index')
                        ->with('success', 'Despesa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Despesa $despesa)
    {
        return view('admin.despesas.show', compact('despesa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Despesa $despesa)
    {
        $categorias = Despesa::select('categoria')
                            ->distinct()
                            ->whereNotNull('categoria')
                            ->orderBy('categoria')
                            ->pluck('categoria');

        $credores = Despesa::select('credor')
                          ->distinct()
                          ->whereNotNull('credor')
                          ->orderBy('credor')
                          ->pluck('credor');

        return view('admin.despesas.edit', compact('despesa', 'categorias', 'credores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Despesa $despesa)
    {
        $validator = Validator::make($request->all(), [
            'numero_empenho' => 'required|string|max:50|unique:despesas,numero_empenho,' . $despesa->id,
            'descricao' => 'required|string|max:500',
            'categoria' => 'required|string|max:100',
            'credor' => 'required|string|max:200',
            'cnpj_cpf_credor' => 'nullable|string|max:20',
            'valor_empenhado' => 'required|numeric|min:0',
            'valor_liquidado' => 'nullable|numeric|min:0',
            'valor_pago' => 'nullable|numeric|min:0',
            'data_empenho' => 'required|date',
            'data_liquidacao' => 'nullable|date',
            'data_pagamento' => 'nullable|date',
            'periodo_inicio' => 'nullable|date',
            'periodo_fim' => 'nullable|date',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|in:empenhada,liquidada,paga,cancelada'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $despesa->update($request->all());

        return redirect()->route('despesas.index')
                        ->with('success', 'Despesa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Despesa $despesa)
    {
        $despesa->delete();

        return redirect()->route('despesas.index')
                        ->with('success', 'Despesa excluída com sucesso!');
    }
}
