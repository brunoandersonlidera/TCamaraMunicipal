<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receita;
use App\Models\Despesa;
use App\Models\Licitacao;
use App\Models\FolhaPagamento;
use Carbon\Carbon;

class TransparenciaController extends Controller
{
    /**
     * Exibe o dashboard principal do Portal da Transparência
     */
    public function index()
    {
        $anoAtual = Carbon::now()->year;
        $mesAtual = Carbon::now()->month;

        // Estatísticas gerais
        $totalReceitas = Receita::ano($anoAtual)->sum('valor_arrecadado');
        $totalDespesas = Despesa::ano($anoAtual)->sum('valor_pago');
        $totalLicitacoes = Licitacao::ano($anoAtual)->count();
        $totalServidores = FolhaPagamento::ano($anoAtual)->mes($mesAtual)->count();

        // Receitas por categoria (top 5)
        $receitasPorCategoria = Receita::ano($anoAtual)
            ->selectRaw('categoria, SUM(valor_arrecadado) as total')
            ->groupBy('categoria')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Despesas por categoria (top 5)
        $despesasPorCategoria = Despesa::ano($anoAtual)
            ->selectRaw('categoria, SUM(valor_pago) as total')
            ->groupBy('categoria')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Licitações recentes
        $licitacoesRecentes = Licitacao::orderByDesc('data_publicacao')
            ->limit(5)
            ->get();

        return view('transparencia.index', compact(
            'totalReceitas',
            'totalDespesas', 
            'totalLicitacoes',
            'totalServidores',
            'receitasPorCategoria',
            'despesasPorCategoria',
            'licitacoesRecentes',
            'anoAtual'
        ));
    }

    /**
     * Exibe página de receitas
     */
    public function receitas(Request $request)
    {
        $query = Receita::query();

        // Filtros
        if ($request->filled('ano')) {
            $query->ano($request->ano);
        }

        if ($request->filled('mes')) {
            $query->mes($request->mes);
        }

        if ($request->filled('categoria')) {
            $query->categoria($request->categoria);
        }

        if ($request->filled('busca')) {
            $query->where(function($q) use ($request) {
                $q->where('descricao', 'like', '%' . $request->busca . '%')
                  ->orWhere('codigo', 'like', '%' . $request->busca . '%');
            });
        }

        $receitas = $query->orderByDesc('data_arrecadacao')->paginate(20);

        // Dados para filtros
        $anos = Receita::selectRaw('DISTINCT ano_referencia')->orderByDesc('ano_referencia')->pluck('ano_referencia');
        $categorias = Receita::selectRaw('DISTINCT categoria')->orderBy('categoria')->pluck('categoria');

        return view('transparencia.receitas', compact('receitas', 'anos', 'categorias'));
    }

    /**
     * Exibe página de despesas
     */
    public function despesas(Request $request)
    {
        $query = Despesa::query();

        // Filtros
        if ($request->filled('ano')) {
            $query->ano($request->ano);
        }

        if ($request->filled('mes')) {
            $query->mes($request->mes);
        }

        if ($request->filled('categoria')) {
            $query->categoria($request->categoria);
        }

        if ($request->filled('credor')) {
            $query->credor($request->credor);
        }

        if ($request->filled('busca')) {
            $query->where(function($q) use ($request) {
                $q->where('descricao', 'like', '%' . $request->busca . '%')
                  ->orWhere('numero_empenho', 'like', '%' . $request->busca . '%');
            });
        }

        $despesas = $query->orderByDesc('data_empenho')->paginate(20);

        // Dados para filtros
        $anos = Despesa::selectRaw('DISTINCT ano_referencia')->orderByDesc('ano_referencia')->pluck('ano_referencia');
        $categorias = Despesa::selectRaw('DISTINCT categoria')->orderBy('categoria')->pluck('categoria');

        return view('transparencia.despesas', compact('despesas', 'anos', 'categorias'));
    }

    /**
     * Exibe página de licitações
     */
    public function licitacoes(Request $request)
    {
        $query = Licitacao::query();

        // Filtros
        if ($request->filled('ano')) {
            $query->ano($request->ano);
        }

        if ($request->filled('modalidade')) {
            $query->modalidade($request->modalidade);
        }

        if ($request->filled('situacao')) {
            $query->where('status', $request->situacao);
        }

        if ($request->filled('busca')) {
            $query->where(function($q) use ($request) {
                $q->where('objeto', 'like', '%' . $request->busca . '%')
                  ->orWhere('numero_processo', 'like', '%' . $request->busca . '%');
            });
        }

        $licitacoes = $query->orderByDesc('data_publicacao')->paginate(20);

        // Dados para filtros
        $anos = Licitacao::selectRaw('DISTINCT YEAR(data_publicacao) as ano')->orderByDesc('ano')->pluck('ano');
        $modalidades = Licitacao::selectRaw('DISTINCT modalidade')->orderBy('modalidade')->pluck('modalidade');
        $situacoes = Licitacao::selectRaw('DISTINCT status')->orderBy('status')->pluck('status');

        return view('transparencia.licitacoes', compact('licitacoes', 'anos', 'modalidades', 'situacoes'));
    }

    /**
     * Exibe página de folha de pagamento
     */
    public function folhaPagamento(Request $request)
    {
        $query = FolhaPagamento::query();

        // Filtros
        if ($request->filled('ano')) {
            $query->ano($request->ano);
        }

        if ($request->filled('mes')) {
            $query->mes($request->mes);
        }

        if ($request->filled('cargo')) {
            $query->cargo($request->cargo);
        }

        if ($request->filled('lotacao')) {
            $query->lotacao($request->lotacao);
        }

        if ($request->filled('vinculo')) {
            $query->vinculo($request->vinculo);
        }

        if ($request->filled('busca')) {
            $query->where(function($q) use ($request) {
                $q->where('nome_servidor', 'like', '%' . $request->busca . '%')
                  ->orWhere('cargo', 'like', '%' . $request->busca . '%');
            });
        }

        $folhaPagamento = $query->orderBy('nome_servidor')->paginate(20);

        // Dados para filtros
        $anos = FolhaPagamento::selectRaw('DISTINCT ano_referencia')->orderByDesc('ano_referencia')->pluck('ano_referencia');
        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];
        $cargos = FolhaPagamento::selectRaw('DISTINCT cargo')->orderBy('cargo')->pluck('cargo');
        $lotacoes = FolhaPagamento::selectRaw('DISTINCT lotacao')->orderBy('lotacao')->pluck('lotacao');
        $vinculos = FolhaPagamento::selectRaw('DISTINCT vinculo')->orderBy('vinculo')->pluck('vinculo');

        return view('transparencia.folha-pagamento', compact('folhaPagamento', 'anos', 'meses', 'cargos', 'lotacoes', 'vinculos'));
    }

    /**
     * Exporta dados em CSV
     */
    public function exportar(Request $request, $tipo)
    {
        $filename = "transparencia_{$tipo}_" . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($tipo, $request) {
            $file = fopen('php://output', 'w');
            
            switch ($tipo) {
                case 'receitas':
                    $this->exportarReceitas($file, $request);
                    break;
                case 'despesas':
                    $this->exportarDespesas($file, $request);
                    break;
                case 'licitacoes':
                    $this->exportarLicitacoes($file, $request);
                    break;
                case 'folha-pagamento':
                    $this->exportarFolhaPagamento($file, $request);
                    break;
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportarReceitas($file, $request)
    {
        // Cabeçalho CSV
        fputcsv($file, [
            'Código', 'Descrição', 'Categoria', 'Valor Previsto', 'Valor Arrecadado',
            'Data Previsão', 'Data Arrecadação', 'Mês', 'Ano', 'Status'
        ]);

        // Dados
        $query = Receita::query();
        if ($request->filled('ano')) $query->ano($request->ano);
        if ($request->filled('mes')) $query->mes($request->mes);
        
        $query->chunk(1000, function($receitas) use ($file) {
            foreach ($receitas as $receita) {
                fputcsv($file, [
                    $receita->codigo,
                    $receita->descricao,
                    $receita->categoria,
                    $receita->valor_previsto,
                    $receita->valor_arrecadado,
                    $receita->data_previsao?->format('d/m/Y'),
                    $receita->data_arrecadacao?->format('d/m/Y'),
                    $receita->mes_referencia,
                    $receita->ano_referencia,
                    $receita->status
                ]);
            }
        });
    }

    private function exportarDespesas($file, $request)
    {
        // Cabeçalho CSV
        fputcsv($file, [
            'Nº Empenho', 'Descrição', 'Categoria', 'Valor Empenhado', 'Valor Pago',
            'Data Empenho', 'Data Pagamento', 'Credor', 'Mês', 'Ano', 'Status'
        ]);

        // Dados
        $query = Despesa::query();
        if ($request->filled('ano')) $query->ano($request->ano);
        if ($request->filled('mes')) $query->mes($request->mes);
        
        $query->chunk(1000, function($despesas) use ($file) {
            foreach ($despesas as $despesa) {
                fputcsv($file, [
                    $despesa->numero_empenho,
                    $despesa->descricao,
                    $despesa->categoria,
                    $despesa->valor_empenhado,
                    $despesa->valor_pago,
                    $despesa->data_empenho?->format('d/m/Y'),
                    $despesa->data_pagamento?->format('d/m/Y'),
                    $despesa->favorecido,
                    $despesa->mes_referencia,
                    $despesa->ano_referencia,
                    $despesa->status
                ]);
            }
        });
    }

    private function exportarLicitacoes($file, $request)
    {
        // Cabeçalho CSV
        fputcsv($file, [
            'Nº Processo', 'Modalidade', 'Objeto', 'Valor Estimado', 'Valor Homologado',
            'Data Publicação', 'Data Abertura', 'Situação', 'Vencedor'
        ]);

        // Dados
        $query = Licitacao::query();
        if ($request->filled('ano')) $query->ano($request->ano);
        
        $query->chunk(1000, function($licitacoes) use ($file) {
            foreach ($licitacoes as $licitacao) {
                fputcsv($file, [
                    $licitacao->numero_processo,
                    $licitacao->modalidade,
                    $licitacao->objeto,
                    $licitacao->valor_estimado,
                    $licitacao->valor_homologado,
                    $licitacao->data_publicacao?->format('d/m/Y'),
                    $licitacao->data_abertura?->format('d/m/Y H:i'),
                    $licitacao->status,
                    $licitacao->vencedor
                ]);
            }
        });
    }

    private function exportarFolhaPagamento($file, $request)
    {
        // Cabeçalho CSV
        fputcsv($file, [
            'Nome', 'Cargo', 'Lotação', 'Vínculo', 'Remuneração Básica', 'Total Vantagens',
            'Total Descontos', 'Remuneração Líquida', 'Mês', 'Ano'
        ]);

        // Dados
        $query = FolhaPagamento::query();
        if ($request->filled('ano')) $query->ano($request->ano);
        if ($request->filled('mes')) $query->mes($request->mes);
        
        $query->chunk(1000, function($folhas) use ($file) {
            foreach ($folhas as $folha) {
                fputcsv($file, [
                    $folha->nome_servidor,
                    $folha->cargo,
                    $folha->lotacao,
                    $folha->vinculo,
                    $folha->remuneracao_basica,
                    $folha->total_vantagens,
                    $folha->total_descontos,
                    $folha->remuneracao_liquida,
                    $folha->mes_referencia,
                    $folha->ano_referencia
                ]);
            }
        });
    }

    /**
     * Retorna dados JSON para o gráfico de evolução mensal
     */
    public function evolucaoMensalJson()
    {
        $anoAtual = Carbon::now()->year;
        
        $evolucaoMensal = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $receita = Receita::ano($anoAtual)->mes($mes)->sum('valor_arrecadado');
            $despesa = Despesa::ano($anoAtual)->mes($mes)->sum('valor_pago');
            
            $evolucaoMensal[] = [
                'mes' => $mes,
                'mes_nome' => Carbon::create()->month($mes)->translatedFormat('F'),
                'receita' => $receita,
                'despesa' => $despesa
            ];
        }

        return response()->json($evolucaoMensal);
    }

    /**
     * Exibe detalhes de uma licitação específica
     */
    public function showLicitacao(Licitacao $licitacao)
    {
        // Carregar documentos públicos
        $licitacao->load(['documentos' => function($query) {
            $query->where('publico', true)->orderBy('ordem')->orderBy('created_at');
        }]);

        return view('transparencia.licitacao-show', compact('licitacao'));
    }

    /**
     * Download de documento público de licitação
     */
    public function downloadDocumento(Licitacao $licitacao, LicitacaoDocumento $documento)
    {
        // Verificar se o documento pertence à licitação e é público
        if ($documento->licitacao_id !== $licitacao->id || !$documento->publico) {
            abort(404, 'Documento não encontrado ou não é público.');
        }

        $caminhoArquivo = storage_path('app/public/licitacoes/documentos/' . $documento->arquivo);
        
        if (!file_exists($caminhoArquivo)) {
            abort(404, 'Arquivo não encontrado no servidor.');
        }

        return response()->download($caminhoArquivo, $documento->arquivo_original, [
            'Content-Type' => $documento->tipo_mime,
        ]);
    }
}
