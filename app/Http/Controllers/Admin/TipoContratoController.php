<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoContrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiposContrato = TipoContrato::orderBy('nome')->paginate(15);
        
        return view('admin.tipos-contrato.index', compact('tiposContrato'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tipos-contrato.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:tipo_contratos,nome',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean'
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.unique' => 'Já existe um tipo de contrato com este nome.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        TipoContrato::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('admin.tipos-contrato.index')
            ->with('success', 'Tipo de contrato criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoContrato $tiposContrato)
    {
        return view('admin.tipos-contrato.show', compact('tiposContrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoContrato $tiposContrato)
    {
        return view('admin.tipos-contrato.edit', compact('tiposContrato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoContrato $tiposContrato)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:tipo_contratos,nome,' . $tiposContrato->id,
            'descricao' => 'nullable|string',
            'ativo' => 'boolean'
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.unique' => 'Já existe um tipo de contrato com este nome.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tiposContrato->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('admin.tipos-contrato.index')
            ->with('success', 'Tipo de contrato atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoContrato $tiposContrato)
    {
        // Verifica se há contratos vinculados
        if ($tiposContrato->contratos()->count() > 0) {
            return redirect()->route('admin.tipos-contrato.index')
                ->with('error', 'Não é possível excluir este tipo de contrato pois há contratos vinculados a ele.');
        }

        $tiposContrato->delete();

        return redirect()->route('admin.tipos-contrato.index')
            ->with('success', 'Tipo de contrato excluído com sucesso!');
    }

    /**
     * Toggle status ativo/inativo
     */
    public function toggleStatus(TipoContrato $tiposContrato)
    {
        $tiposContrato->update([
            'ativo' => !$tiposContrato->ativo
        ]);

        $status = $tiposContrato->ativo ? 'ativado' : 'desativado';
        
        return redirect()->route('admin.tipos-contrato.index')
            ->with('success', "Tipo de contrato {$status} com sucesso!");
    }
}
