<?php

namespace App\Http\Controllers;

use App\Models\CartaServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartaServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CartaServico::query();

        // Filtros
        if ($request->filled('status')) {
            if ($request->status === 'ativa') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inativa') {
                $query->where('ativo', false);
            }
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('orgao_responsavel', 'like', "%{$search}%");
            });
        }

        $cartasServico = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estatísticas
        $estatisticas = [
            'total' => CartaServico::count(),
            'ativas' => CartaServico::where('ativo', true)->count(),
            'inativas' => CartaServico::where('ativo', false)->count(),
            'em_revisao' => 0, // Removido pois não existe mais
        ];

        // Categorias para filtro
        $categorias = CartaServico::select('categoria')
                                 ->distinct()
                                 ->whereNotNull('categoria')
                                 ->pluck('categoria')
                                 ->sort();

        return view('admin.cartas-servico.index', compact('cartasServico', 'estatisticas', 'categorias'));
    }

    /**
     * Exibição pública das cartas de serviço
     */
    public function indexPublico(Request $request)
    {
        $query = CartaServico::where('ativo', true)->where('publicado', true);

        // Filtros públicos
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('orgao_responsavel', 'like', "%{$search}%");
            });
        }

        $cartasServico = $query->orderBy('nome')->paginate(12);

        // Categorias disponíveis
        $categorias = CartaServico::where('ativo', true)
                                 ->where('publicado', true)
                                 ->select('categoria')
                                 ->distinct()
                                 ->whereNotNull('categoria')
                                 ->pluck('categoria')
                                 ->sort();

        return view('public.cartas-servico.index', compact('cartasServico', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = [
            'administrativo' => 'Administrativo',
            'tributario' => 'Tributário',
            'obras' => 'Obras e Infraestrutura',
            'saude' => 'Saúde',
            'educacao' => 'Educação',
            'assistencia_social' => 'Assistência Social',
            'meio_ambiente' => 'Meio Ambiente',
            'transporte' => 'Transporte',
            'seguranca' => 'Segurança',
            'cultura' => 'Cultura',
            'esporte' => 'Esporte',
            'turismo' => 'Turismo',
        ];

        $canaisAtendimento = [
            'presencial' => 'Presencial',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
            'site' => 'Site',
            'aplicativo' => 'Aplicativo',
            'whatsapp' => 'WhatsApp',
        ];

        return view('admin.cartas-servico.create', compact('categorias', 'canaisAtendimento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string',
            'orgao_responsavel' => 'required|string|max:255',
            'publico_alvo' => 'required|string',
            'requisitos' => 'required|string',
            'documentos_necessarios' => 'required|string',
            'etapas_processo' => 'required|string',
            'prazo_atendimento' => 'required|string|max:100',
            'custo' => 'nullable|string|max:100',
            'canais_atendimento' => 'required|array',
            'canais_atendimento.*' => 'string',
            'horario_funcionamento' => 'required|string',
            'legislacao_base' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:ativa,inativa,em_revisao',
            'anexos.*' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // Processar anexos
            $anexos = [];
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $path = $arquivo->store('cartas-servico/anexos', 'public');
                    $anexos[] = [
                        'nome' => $arquivo->getClientOriginalName(),
                        'path' => $path,
                        'tamanho' => $arquivo->getSize(),
                    ];
                }
            }

            $cartaServico = CartaServico::create([
                'nome' => $request->nome,
                'slug' => Str::slug($request->nome),
                'descricao' => $request->descricao,
                'categoria' => $request->categoria,
                'orgao_responsavel' => $request->orgao_responsavel,
                'publico_alvo' => $request->publico_alvo,
                'requisitos' => $request->requisitos,
                'documentos_necessarios' => $request->documentos_necessarios,
                'etapas_processo' => $request->etapas_processo,
                'prazo_atendimento' => $request->prazo_atendimento,
                'custo' => $request->custo,
                'canais_atendimento' => $request->canais_atendimento,
                'horario_funcionamento' => $request->horario_funcionamento,
                'legislacao_base' => $request->legislacao_base,
                'observacoes' => $request->observacoes,
                'anexos' => $anexos,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.cartas-servico.index')
                           ->with('success', 'Carta de serviço criada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Remover anexos se houve erro
            foreach ($anexos as $anexo) {
                if (Storage::disk('public')->exists($anexo['path'])) {
                    Storage::disk('public')->delete($anexo['path']);
                }
            }

            return back()->withInput()
                        ->with('error', 'Erro ao criar carta de serviço: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CartaServico $cartaServico)
    {
        return view('admin.cartas-servico.show', compact('cartaServico'));
    }

    /**
     * Exibição pública de uma carta de serviço
     */
    public function showPublico($slug)
    {
        $cartaServico = CartaServico::where('slug', $slug)
                                   ->where('ativo', true)
                                   ->where('publicado', true)
                                   ->firstOrFail();

        // Incrementar visualizações
        $cartaServico->increment('visualizacoes');

        return view('public.cartas-servico.show', compact('cartaServico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartaServico $cartaServico)
    {
        $categorias = [
            'administrativo' => 'Administrativo',
            'tributario' => 'Tributário',
            'obras' => 'Obras e Infraestrutura',
            'saude' => 'Saúde',
            'educacao' => 'Educação',
            'assistencia_social' => 'Assistência Social',
            'meio_ambiente' => 'Meio Ambiente',
            'transporte' => 'Transporte',
            'seguranca' => 'Segurança',
            'cultura' => 'Cultura',
            'esporte' => 'Esporte',
            'turismo' => 'Turismo',
        ];

        $canaisAtendimento = [
            'presencial' => 'Presencial',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
            'site' => 'Site',
            'aplicativo' => 'Aplicativo',
            'whatsapp' => 'WhatsApp',
        ];

        return view('admin.cartas-servico.edit', compact('cartaServico', 'categorias', 'canaisAtendimento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartaServico $cartaServico)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string',
            'orgao_responsavel' => 'required|string|max:255',
            'publico_alvo' => 'required|string',
            'requisitos' => 'required|string',
            'documentos_necessarios' => 'required|string',
            'etapas_processo' => 'required|string',
            'prazo_atendimento' => 'required|string|max:100',
            'custo' => 'nullable|string|max:100',
            'canais_atendimento' => 'required|array',
            'canais_atendimento.*' => 'string',
            'horario_funcionamento' => 'required|string',
            'legislacao_base' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'ativo' => 'required|boolean',
            'publicado' => 'required|boolean',
            'anexos.*' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remover_anexos' => 'nullable|array',
            'remover_anexos.*' => 'integer',
        ]);

        try {
            DB::beginTransaction();

            // Processar remoção de anexos
            $anexosAtuais = $cartaServico->anexos ?? [];
            if ($request->filled('remover_anexos')) {
                foreach ($request->remover_anexos as $indice) {
                    if (isset($anexosAtuais[$indice])) {
                        // Remover arquivo do storage
                        if (Storage::disk('public')->exists($anexosAtuais[$indice]['path'])) {
                            Storage::disk('public')->delete($anexosAtuais[$indice]['path']);
                        }
                        unset($anexosAtuais[$indice]);
                    }
                }
                $anexosAtuais = array_values($anexosAtuais); // Reindexar array
            }

            // Processar novos anexos
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $arquivo) {
                    $path = $arquivo->store('cartas-servico/anexos', 'public');
                    $anexosAtuais[] = [
                        'nome' => $arquivo->getClientOriginalName(),
                        'path' => $path,
                        'tamanho' => $arquivo->getSize(),
                    ];
                }
            }

            $cartaServico->update([
                'nome' => $request->nome,
                'slug' => Str::slug($request->nome),
                'descricao' => $request->descricao,
                'categoria' => $request->categoria,
                'orgao_responsavel' => $request->orgao_responsavel,
                'publico_alvo' => $request->publico_alvo,
                'requisitos' => $request->requisitos,
                'documentos_necessarios' => $request->documentos_necessarios,
                'etapas_processo' => $request->etapas_processo,
                'prazo_atendimento' => $request->prazo_atendimento,
                'custo' => $request->custo,
                'canais_atendimento' => $request->canais_atendimento,
                'horario_funcionamento' => $request->horario_funcionamento,
                'legislacao_base' => $request->legislacao_base,
                'observacoes' => $request->observacoes,
                'anexos' => $anexosAtuais,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.cartas-servico.show', $cartaServico)
                           ->with('success', 'Carta de serviço atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                        ->with('error', 'Erro ao atualizar carta de serviço: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartaServico $cartaServico)
    {
        try {
            DB::beginTransaction();

            // Remover anexos
            if ($cartaServico->anexos) {
                foreach ($cartaServico->anexos as $anexo) {
                    if (Storage::disk('public')->exists($anexo['path'])) {
                        Storage::disk('public')->delete($anexo['path']);
                    }
                }
            }

            $cartaServico->delete();

            DB::commit();

            return redirect()->route('admin.cartas-servico.index')
                           ->with('success', 'Carta de serviço excluída com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erro ao excluir carta de serviço: ' . $e->getMessage());
        }
    }

    /**
     * Alterar status da carta de serviço
     */
    public function alterarStatus(Request $request, CartaServico $cartaServico)
    {
        $request->validate([
            'status' => 'required|in:ativa,inativa,em_revisao',
        ]);

        try {
            $cartaServico->update(['status' => $request->status]);

            $statusTexto = [
                'ativa' => 'ativada',
                'inativa' => 'desativada',
                'em_revisao' => 'marcada para revisão',
            ];

            return back()->with('success', 
                "Carta de serviço {$statusTexto[$request->status]} com sucesso!"
            );

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }

    /**
     * Download de anexo
     */
    public function downloadAnexo(CartaServico $cartaServico, $indice)
    {
        if (!isset($cartaServico->anexos[$indice])) {
            abort(404, 'Anexo não encontrado.');
        }

        $anexo = $cartaServico->anexos[$indice];
        
        if (!Storage::disk('public')->exists($anexo['path'])) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($anexo['path'], $anexo['nome']);
    }

    /**
     * Duplicar carta de serviço
     */
    public function duplicar(CartaServico $cartaServico)
    {
        try {
            DB::beginTransaction();

            $novaCartaServico = $cartaServico->replicate();
            $novaCartaServico->nome = $cartaServico->nome . ' (Cópia)';
            $novaCartaServico->slug = Str::slug($novaCartaServico->nome);
            $novaCartaServico->ativo = false;
            $novaCartaServico->publicado = false;
            $novaCartaServico->visualizacoes = 0;
            $novaCartaServico->created_at = now();
            $novaCartaServico->updated_at = now();

            // Duplicar anexos
            $novosAnexos = [];
            if ($cartaServico->anexos) {
                foreach ($cartaServico->anexos as $anexo) {
                    if (Storage::disk('public')->exists($anexo['path'])) {
                        $novoPath = 'cartas-servico/anexos/' . Str::random(40) . '.' . pathinfo($anexo['path'], PATHINFO_EXTENSION);
                        Storage::disk('public')->copy($anexo['path'], $novoPath);
                        
                        $novosAnexos[] = [
                            'nome' => $anexo['nome'],
                            'path' => $novoPath,
                            'tamanho' => $anexo['tamanho'],
                        ];
                    }
                }
            }

            $novaCartaServico->anexos = $novosAnexos;
            $novaCartaServico->save();

            DB::commit();

            return redirect()->route('admin.cartas-servico.edit', $novaCartaServico)
                           ->with('success', 'Carta de serviço duplicada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erro ao duplicar carta de serviço: ' . $e->getMessage());
        }
    }

    /**
     * Relatório de cartas de serviço
     */
    public function relatorio(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $dados = [
            'periodo' => $periodo,
            'data_inicio' => $dataInicio,
            'estatisticas' => [
                'total' => CartaServico::count(),
                'ativas' => CartaServico::where('ativo', true)->count(),
                'inativas' => CartaServico::where('ativo', false)->count(),
                'em_revisao' => 0, // Removido pois não existe mais
                'mais_visualizadas' => CartaServico::where('ativo', true)
                                                  ->where('publicado', true)
                                                  ->orderBy('visualizacoes', 'desc')
                                                  ->limit(10)
                                                  ->get(),
                'por_categoria' => CartaServico::selectRaw('categoria, COUNT(*) as total')
                                              ->groupBy('categoria')
                                              ->pluck('total', 'categoria'),
                'criadas_periodo' => CartaServico::where('created_at', '>=', $dataInicio)->count(),
                'atualizadas_periodo' => CartaServico::where('updated_at', '>=', $dataInicio)
                                                    ->where('updated_at', '!=', DB::raw('created_at'))
                                                    ->count(),
            ],
        ];

        return view('admin.cartas-servico.relatorio', compact('dados'));
    }

    /**
     * Exportar cartas de serviço
     */
    public function exportar(Request $request)
    {
        $formato = $request->get('formato', 'csv');
        $status = $request->get('status');

        $query = CartaServico::query();
        
        if ($status) {
            $query->where('status', $status);
        }

        $cartasServico = $query->orderBy('nome')->get();

        if ($formato === 'csv') {
            return $this->exportarCSV($cartasServico);
        }

        return back()->with('error', 'Formato não suportado.');
    }

    /**
     * Exportar para CSV
     */
    private function exportarCSV($cartasServico)
    {
        $filename = 'cartas_servico_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($cartasServico) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Nome', 'Categoria', 'Órgão Responsável', 'Status', 
                'Prazo Atendimento', 'Custo', 'Visualizações', 'Data Criação'
            ]);

            foreach ($cartasServico as $carta) {
                fputcsv($file, [
                    $carta->nome,
                    $carta->categoria_formatada,
                    $carta->orgao_responsavel,
                    $carta->status_formatado,
                    $carta->prazo_atendimento,
                    $carta->custo ?? 'Gratuito',
                    $carta->visualizacoes,
                    $carta->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
