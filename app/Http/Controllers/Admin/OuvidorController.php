<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ouvidor;
use App\Models\User;
use App\Models\OuvidoriaManifestacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OuvidorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ouvidor::with(['user', 'manifestacoes'])
                        ->withCount(['manifestacoes', 'manifestacoes as manifestacoes_respondidas' => function($q) {
                            $q->where('status', 'respondida');
                        }]);

        // Filtros
        if ($request->filled('status')) {
            $query->where('ativo', $request->status === 'ativo');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('especialidade')) {
            $query->where('especialidade', $request->especialidade);
        }

        $ouvidores = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estatísticas
        $estatisticas = [
            'total' => Ouvidor::count(),
            'ativos' => Ouvidor::where('ativo', true)->count(),
            'inativos' => Ouvidor::where('ativo', false)->count(),
            'com_manifestacoes' => Ouvidor::has('manifestacoes')->count(),
        ];

        return view('admin.ouvidores.index', compact('ouvidores', 'estatisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = [
            'geral' => 'Geral',
            'saude' => 'Saúde',
            'educacao' => 'Educação',
            'transporte' => 'Transporte',
            'meio_ambiente' => 'Meio Ambiente',
            'seguranca' => 'Segurança',
            'assistencia_social' => 'Assistência Social',
            'obras' => 'Obras e Infraestrutura',
            'tributario' => 'Tributário',
            'juridico' => 'Jurídico',
        ];

        return view('admin.ouvidores.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|size:14|unique:ouvidores',
            'telefone' => 'required|string|max:20',
            'especialidade' => 'required|string',
            'bio' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ativo' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Criar usuário
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password, // O mutator do modelo já faz o hash
                'role' => 'ouvidor',
                'email_verified_at' => now(),
            ]);

            // Upload da foto se fornecida
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('ouvidores', 'public');
            }

            // Criar ouvidor
            $ouvidor = Ouvidor::create([
                'user_id' => $user->id,
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'especialidade' => $request->especialidade,
                'bio' => $request->bio,
                'foto' => $fotoPath,
                'ativo' => $request->boolean('ativo', true),
                'pode_gerenciar_esic' => $request->boolean('pode_gerenciar_esic'),
                'pode_gerenciar_ouvidoria' => $request->boolean('pode_gerenciar_ouvidoria'),
                'pode_visualizar_relatorios' => $request->boolean('pode_visualizar_relatorios'),
            ]);

            DB::commit();

            return redirect()->route('admin.ouvidores.index')
                           ->with('success', 'Ouvidor criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withErrors(['error' => 'Erro ao criar ouvidor: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ouvidor $ouvidor)
    {
        $ouvidor->load(['user', 'manifestacoes' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);

        return view('admin.ouvidores.show', compact('ouvidor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ouvidor $ouvidor)
    {
        $especialidades = [
            'geral' => 'Geral',
            'saude' => 'Saúde',
            'educacao' => 'Educação',
            'transporte' => 'Transporte',
            'meio_ambiente' => 'Meio Ambiente',
            'seguranca' => 'Segurança',
            'assistencia_social' => 'Assistência Social',
            'obras' => 'Obras e Infraestrutura',
            'tributario' => 'Tributário',
            'juridico' => 'Jurídico',
        ];

        return view('admin.ouvidores.edit', compact('ouvidor', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ouvidor $ouvidor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($ouvidor->user_id)],
            'password' => 'nullable|string|min:8|confirmed',
            'cpf' => ['required', 'string', 'size:14', Rule::unique('ouvidores')->ignore($ouvidor->id)],
            'telefone' => 'required|string|max:20',
            'especialidade' => 'required|string',
            'bio' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ativo' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Atualizar usuário
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = $request->password; // O mutator do modelo já faz o hash
            }

            $ouvidor->user->update($userData);

            // Upload da nova foto se fornecida
            $fotoPath = $ouvidor->foto;
            if ($request->hasFile('foto')) {
                // Deletar foto antiga se existir
                if ($ouvidor->foto) {
                    Storage::disk('public')->delete($ouvidor->foto);
                }
                $fotoPath = $request->file('foto')->store('ouvidores', 'public');
            }

            // Atualizar ouvidor
            $ouvidor->update([
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'especialidade' => $request->especialidade,
                'bio' => $request->bio,
                'foto' => $fotoPath,
                'ativo' => $request->boolean('ativo'),
                'pode_gerenciar_esic' => $request->boolean('pode_gerenciar_esic'),
                'pode_gerenciar_ouvidoria' => $request->boolean('pode_gerenciar_ouvidoria'),
                'pode_visualizar_relatorios' => $request->boolean('pode_visualizar_relatorios'),
            ]);

            DB::commit();

            return redirect()->route('admin.ouvidores.index')
                           ->with('success', 'Ouvidor atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withErrors(['error' => 'Erro ao atualizar ouvidor: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ouvidor $ouvidor)
    {
        try {
            DB::beginTransaction();

            // Deletar foto se existir
            if ($ouvidor->foto) {
                Storage::disk('public')->delete($ouvidor->foto);
            }

            // Deletar ouvidor e usuário
            $user = $ouvidor->user;
            $ouvidor->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('admin.ouvidores.index')
                           ->with('success', 'Ouvidor excluído com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.ouvidores.index')
                           ->with('error', 'Erro ao excluir ouvidor. Verifique se não há manifestações vinculadas.');
        }
    }

    /**
     * Toggle ouvidor status
     */
    public function toggleStatus(Ouvidor $ouvidor)
    {
        $ouvidor->update(['ativo' => !$ouvidor->ativo]);
        
        $status = $ouvidor->ativo ? 'ativado' : 'desativado';
        return redirect()->back()->with('success', "Ouvidor {$status} com sucesso!");
    }

    /**
     * Show reports page
     */
    public function relatorios()
    {
        return view('admin.ouvidores.relatorios');
    }

    /**
     * Export ouvidores data
     */
    public function exportar(Request $request)
    {
        // Implementar exportação (Excel, CSV, PDF)
        return redirect()->back()->with('info', 'Funcionalidade de exportação em desenvolvimento.');
    }
}