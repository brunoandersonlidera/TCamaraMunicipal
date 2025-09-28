<?php

namespace App\Http\Controllers;

use App\Models\ProjetoLei;
use App\Models\Vereador;
use Illuminate\Http\Request;

class ProjetoLeiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Query base para projetos
            $query = ProjetoLei::with(['autor', 'comiteIniciativaPopular'])
                ->where('status', '!=', 'arquivado');

            // Filtro de busca
            if ($request->filled('busca')) {
                $busca = $request->busca;
                $query->where(function ($q) use ($busca) {
                    $q->where('numero', 'like', "%{$busca}%")
                      ->orWhere('titulo', 'like', "%{$busca}%")
                      ->orWhere('ementa', 'like', "%{$busca}%")
                      ->orWhereHas('autor', function ($q) use ($busca) {
                          $q->where('nome', 'like', "%{$busca}%");
                      });
                });
            }

            // Filtro por tipo
            if ($request->filled('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            // Filtro por status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filtro por ano
            if ($request->filled('ano')) {
                $query->whereYear('data_protocolo', $request->ano);
            }

            // Ordenação
            $ordenacao = $request->get('ordenacao', 'data_desc');
            switch ($ordenacao) {
                case 'data_asc':
                    $query->orderBy('data_protocolo', 'asc');
                    break;
                case 'numero_asc':
                    $query->orderBy('numero', 'asc');
                    break;
                case 'numero_desc':
                    $query->orderBy('numero', 'desc');
                    break;
                case 'data_desc':
                default:
                    $query->orderBy('data_protocolo', 'desc');
                    break;
            }

            // Paginação
            $projetos = $query->paginate(12)->withQueryString();
            
            // Buscar projetos em destaque
            $projetosDestaque = ProjetoLei::with(['autor', 'comiteIniciativaPopular'])
                ->where('destaque', true)
                ->where('status', '!=', 'arquivado')
                ->limit(3)
                ->get();
            
            return view('public.projetos-lei.index', compact('projetos', 'projetosDestaque'));
            
        } catch (\Exception $e) {
            \Log::error('Erro no ProjetoLeiController: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjetoLei $projetoLei)
    {
        // Carregar relacionamentos
        $projetoLei->load(['autor', 'coautores']);

        // Projetos relacionados (mesmo autor ou tipo)
        $projetosRelacionados = ProjetoLei::with(['autor'])
            ->where('id', '!=', $projetoLei->id)
            ->where('status', '!=', 'arquivado')
            ->where(function($q) use ($projetoLei) {
                $q->where('autor_id', $projetoLei->autor_id)
                  ->orWhere('tipo', $projetoLei->tipo);
            })
            ->orderBy('data_protocolo', 'desc')
            ->take(4)
            ->get();

        // Histórico de tramitação (simulado - pode ser expandido)
        $tramitacao = [
            [
                'data' => $projetoLei->data_protocolo ? $projetoLei->data_protocolo->format('d/m/Y') : '',
                'titulo' => 'Protocolo',
                'descricao' => 'Projeto protocolado na Câmara Municipal',
                'icone' => 'file-alt',
                'status' => 'concluido'
            ]
        ];

        if ($projetoLei->data_publicacao) {
            $tramitacao[] = [
                'data' => $projetoLei->data_publicacao->format('d/m/Y'),
                'titulo' => 'Publicação',
                'descricao' => 'Projeto publicado no Diário Oficial',
                'icone' => 'newspaper',
                'status' => 'concluido'
            ];
        }

        if ($projetoLei->data_aprovacao) {
            $tramitacao[] = [
                'data' => $projetoLei->data_aprovacao->format('d/m/Y'),
                'titulo' => 'Aprovação',
                'descricao' => 'Projeto aprovado em sessão plenária',
                'icone' => 'check-circle',
                'status' => 'concluido'
            ];
        }

        // Ordenar tramitação por data
        usort($tramitacao, function($a, $b) {
            return strtotime($a['data']) - strtotime($b['data']);
        });

        return view('public.projetos-lei.show', compact(
            'projetoLei', 
            'projetosRelacionados'
        ))->with([
            'projeto' => $projetoLei,
            'historicoTramitacao' => $tramitacao
        ]);
    }

    /**
     * Download do arquivo do projeto
     */
    public function download(ProjetoLei $projetoLei, $tipo)
    {
        if ($tipo === 'projeto' && $projetoLei->arquivo_projeto) {
            return response()->download(storage_path('app/public/' . $projetoLei->arquivo_projeto));
        }

        if ($tipo === 'lei' && $projetoLei->arquivo_lei) {
            return response()->download(storage_path('app/public/' . $projetoLei->arquivo_lei));
        }

        abort(404, 'Arquivo não encontrado');
    }
}