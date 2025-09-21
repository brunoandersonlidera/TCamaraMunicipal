<?php

namespace App\Http\Controllers;

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
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);

            // Processar foto se enviada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('ouvidores/fotos', 'public');
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
            ]);

            // Atribuir role de ouvidor
            $user->assignRole('ouvidor');

            DB::commit();

            return redirect()->route('admin.ouvidores.index')
                           ->with('success', 'Ouvidor cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Remover foto se foi enviada
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return back()->withInput()
                        ->with('error', 'Erro ao cadastrar ouvidor: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ouvidor $ouvidor)
    {
        $ouvidor->load(['user', 'manifestacoes.usuario']);

        // Estatísticas do ouvidor
        $estatisticas = [
            'total_manifestacoes' => $ouvidor->manifestacoes()->count(),
            'manifestacoes_respondidas' => $ouvidor->manifestacoes()->where('status', 'respondida')->count(),
            'manifestacoes_pendentes' => $ouvidor->manifestacoes()->whereIn('status', ['aberta', 'em_andamento'])->count(),
            'tempo_medio_resposta' => $ouvidor->manifestacoes()
                                            ->whereNotNull('data_resposta')
                                            ->selectRaw('AVG(DATEDIFF(data_resposta, created_at)) as media')
                                            ->value('media'),
            'manifestacoes_mes' => $ouvidor->manifestacoes()
                                          ->where('created_at', '>=', now()->startOfMonth())
                                          ->count(),
        ];

        // Manifestações recentes
        $manifestacoesRecentes = $ouvidor->manifestacoes()
                                        ->with('usuario')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(10)
                                        ->get();

        // Gráfico de manifestações por mês (últimos 6 meses)
        $manifestacoesPorMes = $ouvidor->manifestacoes()
                                      ->selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
                                      ->where('created_at', '>=', now()->subMonths(6))
                                      ->groupBy('ano', 'mes')
                                      ->orderBy('ano')
                                      ->orderBy('mes')
                                      ->get()
                                      ->mapWithKeys(function ($item) {
                                          return ["{$item->ano}-{$item->mes}" => $item->total];
                                      });

        return view('admin.ouvidores.show', compact(
            'ouvidor', 'estatisticas', 'manifestacoesRecentes', 'manifestacoesPorMes'
        ));
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
                $userData['password'] = Hash::make($request->password);
            }

            $ouvidor->user->update($userData);

            // Processar nova foto se enviada
            $fotoPath = $ouvidor->foto;
            if ($request->hasFile('foto')) {
                // Remover foto anterior
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                
                $fotoPath = $request->file('foto')->store('ouvidores/fotos', 'public');
            }

            // Atualizar ouvidor
            $ouvidor->update([
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'especialidade' => $request->especialidade,
                'bio' => $request->bio,
                'foto' => $fotoPath,
                'ativo' => $request->boolean('ativo', true),
            ]);

            DB::commit();

            return redirect()->route('admin.ouvidores.show', $ouvidor)
                           ->with('success', 'Ouvidor atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                        ->with('error', 'Erro ao atualizar ouvidor: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ouvidor $ouvidor)
    {
        try {
            DB::beginTransaction();

            // Verificar se tem manifestações ativas
            $manifestacoesAtivas = $ouvidor->manifestacoes()
                                          ->whereNotIn('status', ['respondida', 'fechada'])
                                          ->count();

            if ($manifestacoesAtivas > 0) {
                return back()->with('error', 
                    'Não é possível excluir o ouvidor pois ele possui manifestações ativas. ' .
                    'Transfira as manifestações para outro ouvidor primeiro.'
                );
            }

            // Remover foto se existir
            if ($ouvidor->foto && Storage::disk('public')->exists($ouvidor->foto)) {
                Storage::disk('public')->delete($ouvidor->foto);
            }

            // Desativar ao invés de excluir para manter histórico
            $ouvidor->update(['ativo' => false]);
            $ouvidor->user->update(['email_verified_at' => null]);

            DB::commit();

            return redirect()->route('admin.ouvidores.index')
                           ->with('success', 'Ouvidor desativado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erro ao desativar ouvidor: ' . $e->getMessage());
        }
    }

    /**
     * Ativar/Desativar ouvidor
     */
    public function toggleStatus(Ouvidor $ouvidor)
    {
        try {
            $novoStatus = !$ouvidor->ativo;
            
            $ouvidor->update(['ativo' => $novoStatus]);

            $mensagem = $novoStatus ? 'Ouvidor ativado com sucesso!' : 'Ouvidor desativado com sucesso!';

            return back()->with('success', $mensagem);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar status do ouvidor: ' . $e->getMessage());
        }
    }

    /**
     * Transferir manifestações
     */
    public function transferirManifestacoes(Request $request, Ouvidor $ouvidorOrigem)
    {
        $request->validate([
            'ouvidor_destino_id' => 'required|exists:ouvidores,id',
            'manifestacoes' => 'required|array',
            'manifestacoes.*' => 'exists:ouvidoria_manifestacoes,id',
        ]);

        try {
            DB::beginTransaction();

            $ouvidorDestino = Ouvidor::findOrFail($request->ouvidor_destino_id);

            // Verificar se ouvidor destino está ativo
            if (!$ouvidorDestino->ativo) {
                return back()->with('error', 'O ouvidor de destino deve estar ativo.');
            }

            // Transferir manifestações
            OuvidoriaManifestacao::whereIn('id', $request->manifestacoes)
                                ->where('ouvidor_responsavel_id', $ouvidorOrigem->id)
                                ->update([
                                    'ouvidor_responsavel_id' => $ouvidorDestino->id,
                                    'updated_at' => now(),
                                ]);

            DB::commit();

            $quantidade = count($request->manifestacoes);
            
            return back()->with('success', 
                "{$quantidade} manifestação(ões) transferida(s) com sucesso para {$ouvidorDestino->user->name}!"
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erro ao transferir manifestações: ' . $e->getMessage());
        }
    }

    /**
     * Relatório de performance
     */
    public function relatorioPerformance(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $ouvidores = Ouvidor::with('user')
                           ->withCount([
                               'manifestacoes',
                               'manifestacoes as manifestacoes_periodo' => function($q) use ($dataInicio) {
                                   $q->where('created_at', '>=', $dataInicio);
                               },
                               'manifestacoes as manifestacoes_respondidas' => function($q) {
                                   $q->where('status', 'respondida');
                               },
                               'manifestacoes as manifestacoes_prazo' => function($q) {
                                   $q->whereNotNull('data_resposta')
                                     ->whereRaw('data_resposta <= prazo_resposta');
                               }
                           ])
                           ->where('ativo', true)
                           ->get()
                           ->map(function($ouvidor) {
                               $tempoMedioResposta = $ouvidor->manifestacoes()
                                                           ->whereNotNull('data_resposta')
                                                           ->selectRaw('AVG(DATEDIFF(data_resposta, created_at)) as media')
                                                           ->value('media');

                               return [
                                   'ouvidor' => $ouvidor,
                                   'total_manifestacoes' => $ouvidor->manifestacoes_count,
                                   'manifestacoes_periodo' => $ouvidor->manifestacoes_periodo,
                                   'manifestacoes_respondidas' => $ouvidor->manifestacoes_respondidas,
                                   'manifestacoes_prazo' => $ouvidor->manifestacoes_prazo,
                                   'taxa_resposta' => $ouvidor->manifestacoes_count > 0 
                                                    ? round(($ouvidor->manifestacoes_respondidas / $ouvidor->manifestacoes_count) * 100, 1)
                                                    : 0,
                                   'taxa_prazo' => $ouvidor->manifestacoes_respondidas > 0
                                                 ? round(($ouvidor->manifestacoes_prazo / $ouvidor->manifestacoes_respondidas) * 100, 1)
                                                 : 0,
                                   'tempo_medio_resposta' => $tempoMedioResposta ? round($tempoMedioResposta, 1) : 0,
                               ];
                           });

        return view('admin.ouvidores.relatorio-performance', compact('ouvidores', 'periodo'));
    }

    /**
     * Exportar dados
     */
    public function exportar(Request $request)
    {
        $formato = $request->get('formato', 'csv');
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $ouvidores = Ouvidor::with(['user', 'manifestacoes' => function($q) use ($dataInicio) {
                                $q->where('created_at', '>=', $dataInicio);
                            }])
                           ->get();

        if ($formato === 'csv') {
            return $this->exportarCSV($ouvidores);
        }

        return back()->with('error', 'Formato não suportado.');
    }

    /**
     * Exportar para CSV
     */
    private function exportarCSV($ouvidores)
    {
        $filename = 'ouvidores_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($ouvidores) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Nome', 'E-mail', 'CPF', 'Telefone', 'Especialidade', 
                'Status', 'Total Manifestações', 'Data Cadastro'
            ]);

            foreach ($ouvidores as $ouvidor) {
                fputcsv($file, [
                    $ouvidor->user->name,
                    $ouvidor->user->email,
                    $ouvidor->cpf_formatado,
                    $ouvidor->telefone,
                    $ouvidor->especialidade_formatada,
                    $ouvidor->ativo ? 'Ativo' : 'Inativo',
                    $ouvidor->manifestacoes->count(),
                    $ouvidor->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
