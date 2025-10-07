<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Vereador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class VereadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vereador::query();
        
        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('nome_parlamentar', 'like', "%{$search}%")
                  ->orWhere('partido', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('partido')) {
            $query->where('partido', $request->partido);
        }
        
        $vereadores = $query->orderBy('nome_parlamentar')->paginate(15);
        
        // Para os filtros
        $partidos = Vereador::distinct()->pluck('partido')->filter()->sort();
        
        return view('admin.vereadores.index', compact('vereadores', 'partidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vereadores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'nome_parlamentar' => 'required|string|max:255',
            'partido' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_existing' => 'nullable|string',
            'biografia' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'profissao' => 'nullable|string|max:255',
            'escolaridade' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
            'redes_sociais' => 'nullable|array',
            'status' => 'required|in:ativo,inativo',
            'inicio_mandato' => 'nullable|date',
            'fim_mandato' => 'nullable|date|after_or_equal:inicio_mandato',
            'legislatura' => 'nullable|string|max:50',
            'comissoes' => 'nullable|array',
            'projetos_apresentados' => 'nullable|integer|min:0',
            'votos_favoraveis' => 'nullable|integer|min:0',
            'votos_contrarios' => 'nullable|integer|min:0',
            'abstencoes' => 'nullable|integer|min:0',
            'presencas_sessoes' => 'nullable|integer|min:0',
            'observacoes' => 'nullable|string',
            // Novos campos presidente/vice
            'presidente' => 'nullable|boolean',
            'vice_presidente' => 'nullable|boolean',
            'presidente_inicio' => 'nullable|date',
            'presidente_fim' => 'nullable|date|after_or_equal:presidente_inicio',
            'vice_inicio' => 'nullable|date',
            'vice_fim' => 'nullable|date|after_or_equal:vice_inicio'
        ]);
        
        // Upload da foto OU seleção existente
        $fotoPath = null;
        $uploadedFile = null;
        if ($request->hasFile('foto')) {
            $uploadedFile = $request->file('foto');
            $fotoPath = $uploadedFile->store('vereadores', 'public');
            $validated['foto'] = $fotoPath;
        } elseif (!empty($validated['foto_existing'])) {
            // Seleção da biblioteca: usar caminho local existente
            $validated['foto'] = $validated['foto_existing'];
        }
        
        // Filtrar redes sociais vazias
        if (isset($validated['redes_sociais'])) {
            $validated['redes_sociais'] = array_filter($validated['redes_sociais']);
        }
        
        // Filtrar comissões vazias
        if (isset($validated['comissoes'])) {
            $validated['comissoes'] = array_filter($validated['comissoes']);
        }
        
        // Regras de limite máximo 2 anos consecutivos (presidente/vice)
        if (!empty($validated['presidente_inicio']) && !empty($validated['presidente_fim'])) {
            $inicio = Carbon::parse($validated['presidente_inicio']);
            $fim = Carbon::parse($validated['presidente_fim']);
            if ($fim->gt($inicio->copy()->addYears(2))) {
                return back()->withInput()->withErrors(['presidente_fim' => 'O mandato de presidente não pode exceder 2 anos consecutivos.']);
            }
        }
        if (!empty($validated['vice_inicio']) && !empty($validated['vice_fim'])) {
            $vinicio = Carbon::parse($validated['vice_inicio']);
            $vfim = Carbon::parse($validated['vice_fim']);
            if ($vfim->gt($vinicio->copy()->addYears(2))) {
                return back()->withInput()->withErrors(['vice_fim' => 'O mandato de vice-presidente não pode exceder 2 anos consecutivos.']);
            }
        }

        // Criar vereador
        $vereador = Vereador::create($validated);

        // Unicidade com auto-encerramento: presidente
        if (!empty($validated['presidente']) && $validated['presidente']) {
            $dataInicioPresidente = !empty($validated['presidente_inicio']) ? Carbon::parse($validated['presidente_inicio']) : Carbon::now()->startOfDay();
            $presidenteAtivo = Vereador::where('id', '!=', $vereador->id)
                ->where('presidente', true)
                ->where(function($q){
                    $q->whereNull('presidente_fim');
                })
                ->first();
            if ($presidenteAtivo) {
                // Encerrar um dia antes do novo início
                $presidenteAtivo->update(['presidente_fim' => $dataInicioPresidente->copy()->subDay()->toDateString()]);
            }
        }

        // Unicidade com auto-encerramento: vice-presidente
        if (!empty($validated['vice_presidente']) && $validated['vice_presidente']) {
            $dataInicioVice = !empty($validated['vice_inicio']) ? Carbon::parse($validated['vice_inicio']) : Carbon::now()->startOfDay();
            $viceAtivo = Vereador::where('id', '!=', $vereador->id)
                ->where('vice_presidente', true)
                ->where(function($q){
                    $q->whereNull('vice_fim');
                })
                ->first();
            if ($viceAtivo) {
                $viceAtivo->update(['vice_fim' => $dataInicioVice->copy()->subDay()->toDateString()]);
            }
        }

        // Registrar mídia na biblioteca de mídia
        if (!empty($fotoPath)) {
            try {
                Media::create([
                    'file_name' => basename($fotoPath),
                    'original_name' => $uploadedFile?->getClientOriginalName() ?? basename($fotoPath),
                    'mime_type' => $uploadedFile?->getMimeType() ?? 'image/jpeg',
                    'size' => $uploadedFile?->getSize() ?? (Storage::disk('public')->exists($fotoPath) ? Storage::disk('public')->size($fotoPath) : null),
                    'path' => $fotoPath,
                    'alt_text' => $vereador->nome_parlamentar,
                    'title' => "Foto do Vereador {$vereador->nome_parlamentar}",
                    'category' => 'foto',
                    'uploaded_by' => Auth::id(),
                    'model_type' => Vereador::class,
                    'model_id' => $vereador->id,
                    'collection_name' => 'vereadores',
                    'disk' => 'public',
                    'name' => pathinfo($uploadedFile?->getClientOriginalName() ?? basename($fotoPath), PATHINFO_FILENAME),
                ]);
            } catch (\Throwable $e) {
                Log::warning('Falha ao registrar mídia de vereador (store): ' . $e->getMessage(), [
                    'vereador_id' => $vereador->id ?? null,
                    'path' => $fotoPath,
                ]);
            }
        }
        
        return redirect()->route('admin.vereadores.index')
                        ->with('success', 'Vereador cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vereador $vereador)
    {
        return view('admin.vereadores.show', compact('vereador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vereador $vereador)
    {
        return view('admin.vereadores.edit', compact('vereador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vereador $vereador)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'nome_parlamentar' => 'required|string|max:255',
            'partido' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_existing' => 'nullable|string',
            'biografia' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'profissao' => 'nullable|string|max:255',
            'escolaridade' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
            'redes_sociais' => 'nullable|array',
            'status' => 'required|in:ativo,inativo',
            'inicio_mandato' => 'nullable|date',
            'fim_mandato' => 'nullable|date|after_or_equal:inicio_mandato',
            'legislatura' => 'nullable|string|max:50',
            'comissoes' => 'nullable|array',
            'projetos_apresentados' => 'nullable|integer|min:0',
            'votos_favoraveis' => 'nullable|integer|min:0',
            'votos_contrarios' => 'nullable|integer|min:0',
            'abstencoes' => 'nullable|integer|min:0',
            'presencas_sessoes' => 'nullable|integer|min:0',
            'observacoes' => 'nullable|string',
            // Novos campos presidente/vice
            'presidente' => 'nullable|boolean',
            'vice_presidente' => 'nullable|boolean',
            'presidente_inicio' => 'nullable|date',
            'presidente_fim' => 'nullable|date|after_or_equal:presidente_inicio',
            'vice_inicio' => 'nullable|date',
            'vice_fim' => 'nullable|date|after_or_equal:vice_inicio'
        ]);
        
        // Upload da nova foto OU seleção existente
        $novoFotoPath = null;
        $novoUploadedFile = null;
        if ($request->hasFile('foto')) {
            // Deletar foto antiga se existir e for arquivo local
            if (!empty($vereador->foto) && Storage::disk('public')->exists($vereador->foto)) {
                Storage::disk('public')->delete($vereador->foto);
            }
            $novoUploadedFile = $request->file('foto');
            $novoFotoPath = $novoUploadedFile->store('vereadores', 'public');
            $validated['foto'] = $novoFotoPath;
        } elseif (!empty($validated['foto_existing'])) {
            // Seleção da biblioteca: atualiza para caminho existente
            $novoFotoPath = $validated['foto_existing'];
            // Se a foto anterior era arquivo local diferente da nova seleção, remove com segurança
            if (!empty($vereador->foto) && $vereador->foto !== $novoFotoPath && Storage::disk('public')->exists($vereador->foto)) {
                Storage::disk('public')->delete($vereador->foto);
            }
            $validated['foto'] = $novoFotoPath;
        }
        
        // Filtrar redes sociais vazias
        if (isset($validated['redes_sociais'])) {
            $validated['redes_sociais'] = array_filter($validated['redes_sociais']);
        }
        
        // Filtrar comissões vazias
        if (isset($validated['comissoes'])) {
            $validated['comissoes'] = array_filter($validated['comissoes']);
        }
        
        // Limite de 2 anos consecutivos
        if (!empty($validated['presidente_inicio']) && !empty($validated['presidente_fim'])) {
            $inicio = Carbon::parse($validated['presidente_inicio']);
            $fim = Carbon::parse($validated['presidente_fim']);
            if ($fim->gt($inicio->copy()->addYears(2))) {
                return back()->withInput()->withErrors(['presidente_fim' => 'O mandato de presidente não pode exceder 2 anos consecutivos.']);
            }
        }
        if (!empty($validated['vice_inicio']) && !empty($validated['vice_fim'])) {
            $vinicio = Carbon::parse($validated['vice_inicio']);
            $vfim = Carbon::parse($validated['vice_fim']);
            if ($vfim->gt($vinicio->copy()->addYears(2))) {
                return back()->withInput()->withErrors(['vice_fim' => 'O mandato de vice-presidente não pode exceder 2 anos consecutivos.']);
            }
        }

        // Atualiza os dados
        $vereador->update($validated);

        // Unicidade com auto-encerramento (se este vereador foi marcado como presidente)
        if (!empty($validated['presidente']) && $validated['presidente']) {
            $dataInicioPresidente = !empty($validated['presidente_inicio']) ? Carbon::parse($validated['presidente_inicio']) : Carbon::now()->startOfDay();
            $presidenteAtivo = Vereador::where('id', '!=', $vereador->id)
                ->where('presidente', true)
                ->where(function($q){
                    $q->whereNull('presidente_fim');
                })
                ->first();
            if ($presidenteAtivo) {
                $presidenteAtivo->update(['presidente_fim' => $dataInicioPresidente->copy()->subDay()->toDateString()]);
            }
        }

        // Unicidade com auto-encerramento para vice
        if (!empty($validated['vice_presidente']) && $validated['vice_presidente']) {
            $dataInicioVice = !empty($validated['vice_inicio']) ? Carbon::parse($validated['vice_inicio']) : Carbon::now()->startOfDay();
            $viceAtivo = Vereador::where('id', '!=', $vereador->id)
                ->where('vice_presidente', true)
                ->where(function($q){
                    $q->whereNull('vice_fim');
                })
                ->first();
            if ($viceAtivo) {
                $viceAtivo->update(['vice_fim' => $dataInicioVice->copy()->subDay()->toDateString()]);
            }
        }

        // Registrar nova mídia na biblioteca, se houver novo upload (não registrar para seleção existente)
        if (!empty($novoUploadedFile) && !empty($novoFotoPath)) {
            try {
                Media::create([
                    'file_name' => basename($novoFotoPath),
                    'original_name' => $novoUploadedFile?->getClientOriginalName() ?? basename($novoFotoPath),
                    'mime_type' => $novoUploadedFile?->getMimeType() ?? 'image/jpeg',
                    'size' => $novoUploadedFile?->getSize() ?? (Storage::disk('public')->exists($novoFotoPath) ? Storage::disk('public')->size($novoFotoPath) : null),
                    'path' => $novoFotoPath,
                    'alt_text' => $vereador->nome_parlamentar,
                    'title' => "Foto do Vereador {$vereador->nome_parlamentar}",
                    'category' => 'foto',
                    'uploaded_by' => Auth::id(),
                    'model_type' => Vereador::class,
                    'model_id' => $vereador->id,
                    'collection_name' => 'vereadores',
                    'disk' => 'public',
                    'name' => pathinfo($novoUploadedFile?->getClientOriginalName() ?? basename($novoFotoPath), PATHINFO_FILENAME),
                ]);
            } catch (\Throwable $e) {
                Log::warning('Falha ao registrar mídia de vereador (update): ' . $e->getMessage(), [
                    'vereador_id' => $vereador->id ?? null,
                    'path' => $novoFotoPath,
                ]);
            }
        }
        
        return redirect()->route('admin.vereadores.index')
                        ->with('success', 'Vereador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vereador $vereador)
    {
        // Deletar foto se existir
        if ($vereador->foto) {
            Storage::disk('public')->delete($vereador->foto);
        }
        
        $vereador->delete();
        
        return redirect()->route('admin.vereadores.index')
                        ->with('success', 'Vereador removido com sucesso!');
    }
    
    /**
     * Toggle status do vereador
     */
    public function toggleStatus(Vereador $vereador)
    {
        $vereador->update([
            'status' => $vereador->status === 'ativo' ? 'inativo' : 'ativo'
        ]);
        
        $status = $vereador->status === 'ativo' ? 'ativado' : 'desativado';
        
        return redirect()->back()
                        ->with('success', "Vereador {$status} com sucesso!");
    }
}