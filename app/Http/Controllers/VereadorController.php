<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vereador;

class VereadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vereadores = Vereador::ativos()
            ->orderBy('nome_parlamentar')
            ->get();
            
        return view('vereadores.index', compact('vereadores'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vereador = Vereador::findOrFail($id);
        
        return view('vereadores.show', compact('vereador'));
    }

    /**
     * Get vereadores for homepage
     */
    public function getForHomepage()
    {
        $presidente = Vereador::ativos()
            ->whereJsonContains('comissoes', 'presidente')
            ->first();
            
        $vereadores = Vereador::ativos()
            ->when($presidente, function($query) use ($presidente) {
                return $query->where('id', '!=', $presidente->id);
            })
            ->orderBy('nome_parlamentar')
            ->get();
            
        return [
            'presidente' => $presidente,
            'vereadores' => $vereadores
        ];
    }
}
