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
        $vereadores = Vereador::all();
            
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
        $hoje = now()->toDateString();
        $presidente = Vereador::ativos()
            ->where('presidente', true)
            ->where(function($q) use ($hoje) {
                $q->whereNull('presidente_inicio')->orWhereDate('presidente_inicio', '<=', $hoje);
            })
            ->where(function($q) use ($hoje) {
                $q->whereNull('presidente_fim')->orWhereDate('presidente_fim', '>=', $hoje);
            })
            ->orderBy('nome_parlamentar')
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
