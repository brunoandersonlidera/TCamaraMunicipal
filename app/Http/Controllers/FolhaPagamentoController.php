<?php

namespace App\Http\Controllers;

use App\Models\FolhaPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FolhaPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FolhaPagamento::query();

        // Filtros
        if ($request->filled('ano')) {
            $query->where('ano', $request->ano);
        }

        if ($request->filled('mes')) {
            $query->where('mes', $request->mes);
        }

        if ($request->filled('cargo')) {
            $query->where('cargo', $request->cargo);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome_servidor', 'like', "%{$busca}%")
                  ->orWhere('matricula', 'like', "%{$busca}%")
                  ->orWhere('cargo', 'like', "%{$busca}%");
            });
        }

        $folhaPagamento = $query->orderBy('ano', 'desc')
                               ->orderBy('mes', 'desc')
                               ->orderBy('nome_servidor')
                               ->paginate(20);

        // Dados para filtros
        $anos = FolhaPagamento::select('ano')
                             ->distinct()
                             ->orderBy('ano', 'desc')
                             ->pluck('ano');

        $cargos = FolhaPagamento::select('cargo')
                               ->distinct()
                               ->whereNotNull('cargo')
                               ->orderBy('cargo')
                               ->pluck('cargo');

        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        return view('admin.folha-pagamento.index', compact('folhaPagamento', 'anos', 'cargos', 'meses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cargos = FolhaPagamento::select('cargo')
                               ->distinct()
                               ->whereNotNull('cargo')
                               ->orderBy('cargo')
                               ->pluck('cargo');

        return view('admin.folha-pagamento.create', compact('cargos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome_servidor' => 'required|string|max:200',
            'matricula' => 'nullable|string|max:20',
            'cargo' => 'required|string|max:100',
            'lotacao' => 'nullable|string|max:100',
            'ano' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'mes' => 'required|integer|min:1|max:12',
            'salario_base' => 'required|numeric|min:0',
            'gratificacoes' => 'nullable|numeric|min:0',
            'descontos' => 'nullable|numeric|min:0',
            'valor_liquido' => 'required|numeric|min:0',
            'situacao' => 'required|in:ativo,aposentado,pensionista,afastado'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Verificar se já existe registro para o mesmo servidor no mesmo período
        $existeRegistro = FolhaPagamento::where('nome_servidor', $request->nome_servidor)
                                       ->where('ano', $request->ano)
                                       ->where('mes', $request->mes)
                                       ->exists();

        if ($existeRegistro) {
            return redirect()->back()
                           ->withErrors(['nome_servidor' => 'Já existe um registro para este servidor neste período.'])
                           ->withInput();
        }

        FolhaPagamento::create($request->all());

        return redirect()->route('folha-pagamento.index')
                        ->with('success', 'Registro de folha de pagamento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FolhaPagamento $folhaPagamento)
    {
        return view('admin.folha-pagamento.show', compact('folhaPagamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FolhaPagamento $folhaPagamento)
    {
        $cargos = FolhaPagamento::select('cargo')
                               ->distinct()
                               ->whereNotNull('cargo')
                               ->orderBy('cargo')
                               ->pluck('cargo');

        return view('admin.folha-pagamento.edit', compact('folhaPagamento', 'cargos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FolhaPagamento $folhaPagamento)
    {
        $validator = Validator::make($request->all(), [
            'nome_servidor' => 'required|string|max:200',
            'matricula' => 'nullable|string|max:20',
            'cargo' => 'required|string|max:100',
            'lotacao' => 'nullable|string|max:100',
            'ano' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'mes' => 'required|integer|min:1|max:12',
            'salario_base' => 'required|numeric|min:0',
            'gratificacoes' => 'nullable|numeric|min:0',
            'descontos' => 'nullable|numeric|min:0',
            'valor_liquido' => 'required|numeric|min:0',
            'situacao' => 'required|in:ativo,aposentado,pensionista,afastado'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Verificar se já existe outro registro para o mesmo servidor no mesmo período
        $existeRegistro = FolhaPagamento::where('nome_servidor', $request->nome_servidor)
                                       ->where('ano', $request->ano)
                                       ->where('mes', $request->mes)
                                       ->where('id', '!=', $folhaPagamento->id)
                                       ->exists();

        if ($existeRegistro) {
            return redirect()->back()
                           ->withErrors(['nome_servidor' => 'Já existe um registro para este servidor neste período.'])
                           ->withInput();
        }

        $folhaPagamento->update($request->all());

        return redirect()->route('folha-pagamento.index')
                        ->with('success', 'Registro de folha de pagamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FolhaPagamento $folhaPagamento)
    {
        $folhaPagamento->delete();

        return redirect()->route('folha-pagamento.index')
                        ->with('success', 'Registro de folha de pagamento excluído com sucesso!');
    }
}
