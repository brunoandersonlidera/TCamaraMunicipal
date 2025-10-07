<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjetoLei;
use App\Models\Vereador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TramitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Dashboard de tramitação legislativa
     */
    public function index(Request $request)
    {
        $query = ProjetoLei::with(['autor', 'relator']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('urgencia')) {
            $query->where('urgencia', $request->urgencia);
        }

        if ($request->filled('consulta_publica')) {
            $query->where('consulta_publica_ativa', $request->boolean('consulta_publica'));
        }

        $projetos = $query->orderBy('data_protocolo', 'desc')->paginate(20);

        // Estatísticas - usando apenas status válidos do ENUM
        $estatisticas = [
            'total' => ProjetoLei::count(),
            'em_tramitacao' => ProjetoLei::where('status', 'em_tramitacao')->count(),
            'aprovados' => ProjetoLei::where('status', 'aprovado')->count(),
            'rejeitados' => ProjetoLei::where('status', 'rejeitado')->count(),
            'arquivados' => ProjetoLei::where('status', 'arquivado')->count(),
        ];

        return view('admin.tramitacao.index', compact('projetos', 'estatisticas'));
    }

    /**
     * Exibe detalhes da tramitação de um projeto
     */
    public function show(ProjetoLei $projeto)
    {
        $projeto->load(['autor', 'relator', 'coautores', 'sessoes', 'documentos']);
        
        $historico = collect($projeto->historico_tramitacao ?? [])
            ->sortByDesc('data')
            ->values();

        return view('admin.tramitacao.show', compact('projeto', 'historico'));
    }

    /**
     * Atualiza o status de tramitação
     */
    public function updateStatus(Request $request, ProjetoLei $projeto)
    {
        $request->validate([
            'status' => 'required|string',
            'observacao' => 'nullable|string|max:1000',
            'data_acao' => 'nullable|date'
        ]);

        $statusAnterior = $projeto->status;
        $projeto->status = $request->status;

        // Atualizar datas específicas baseadas no status
        $this->atualizarDatasPorStatus($projeto, $request->status, $request->data_acao);

        // Adicionar ao histórico
        $projeto->adicionarHistoricoTramitacao(
            "Status alterado de '{$statusAnterior}' para '{$request->status}'",
            $request->observacao,
            Auth::id()
        );

        $projeto->save();

        return redirect()->back()->with('success', 'Status de tramitação atualizado com sucesso!');
    }

    /**
     * Gera protocolo automático
     */
    public function gerarProtocolo(ProjetoLei $projeto)
    {
        if ($projeto->protocolo_numero) {
            return redirect()->back()->with('error', 'Este projeto já possui protocolo!');
        }

        $protocolo = $projeto->gerarProtocolo();
        $projeto->save();

        $projeto->adicionarHistoricoTramitacao(
            "Protocolo gerado: {$protocolo}",
            null,
            Auth::id()
        );

        return redirect()->back()->with('success', "Protocolo {$protocolo} gerado com sucesso!");
    }

    /**
     * Inicia consulta pública
     */
    public function iniciarConsultaPublica(Request $request, ProjetoLei $projeto)
    {
        $request->validate([
            'prazo_dias' => 'required|integer|min:1|max:90',
            'observacao' => 'nullable|string|max:500'
        ]);

        $projeto->iniciarConsultaPublica($request->prazo_dias);
        $projeto->save();

        return redirect()->back()->with('success', 'Consulta pública iniciada com sucesso!');
    }

    /**
     * Finaliza consulta pública
     */
    public function finalizarConsultaPublica(Request $request, ProjetoLei $projeto)
    {
        $request->validate([
            'observacao' => 'nullable|string|max:500'
        ]);

        $projeto->finalizarConsultaPublica();
        $projeto->save();

        return redirect()->back()->with('success', 'Consulta pública finalizada com sucesso!');
    }

    /**
     * Registra votação
     */
    public function registrarVotacao(Request $request, ProjetoLei $projeto)
    {
        $request->validate([
            'turno' => 'required|in:primeiro,segundo',
            'votos_favoraveis' => 'required|integer|min:0',
            'votos_contrarios' => 'required|integer|min:0',
            'abstencoes' => 'required|integer|min:0',
            'ausencias' => 'required|integer|min:0',
            'resultado' => 'required|in:aprovado,rejeitado',
            'observacao' => 'nullable|string|max:1000'
        ]);

        $dadosVotacao = [
            'votos_favoraveis' => $request->votos_favoraveis,
            'votos_contrarios' => $request->votos_contrarios,
            'abstencoes' => $request->abstencoes,
            'ausencias' => $request->ausencias,
            'resultado' => $request->resultado,
            'data_votacao' => now(),
            'observacao' => $request->observacao
        ];

        if ($request->turno === 'primeiro') {
            $projeto->votos_favoraveis = $request->votos_favoraveis;
            $projeto->votos_contrarios = $request->votos_contrarios;
            $projeto->abstencoes = $request->abstencoes;
            $projeto->ausencias = $request->ausencias;
            $projeto->resultado_primeira_votacao = $dadosVotacao;
            $projeto->data_primeira_votacao = now();

            if ($request->resultado === 'aprovado' && $projeto->exigeDoisTurnos()) {
                $projeto->status = ProjetoLei::STATUS_APROVADO_1_TURNO;
            } elseif ($request->resultado === 'aprovado') {
                $projeto->status = ProjetoLei::STATUS_APROVADO;
                $projeto->data_aprovacao = now();
            } else {
                $projeto->status = ProjetoLei::STATUS_REJEITADO;
            }
        } else {
            $projeto->resultado_segunda_votacao = $dadosVotacao;
            $projeto->data_segunda_votacao = now();

            if ($request->resultado === 'aprovado') {
                $projeto->status = ProjetoLei::STATUS_APROVADO;
                $projeto->data_aprovacao = now();
            } else {
                $projeto->status = ProjetoLei::STATUS_REJEITADO;
            }
        }

        $projeto->adicionarHistoricoTramitacao(
            "Votação em {$request->turno} turno: {$request->resultado}",
            "Favoráveis: {$request->votos_favoraveis}, Contrários: {$request->votos_contrarios}, Abstenções: {$request->abstencoes}",
            Auth::id()
        );

        $projeto->save();

        return redirect()->back()->with('success', 'Votação registrada com sucesso!');
    }

    /**
     * Registra veto
     */
    public function registrarVeto(Request $request, ProjetoLei $projeto)
    {
        $request->validate([
            'motivo_veto' => 'required|string|max:1000',
            'fundamentacao_veto' => 'required|string|max:5000',
            'data_veto' => 'required|date'
        ]);

        $projeto->update([
            'status' => ProjetoLei::STATUS_VETADO,
            'motivo_veto' => $request->motivo_veto,
            'fundamentacao_veto' => $request->fundamentacao_veto,
            'data_veto' => $request->data_veto
        ]);

        $projeto->adicionarHistoricoTramitacao(
            'Projeto vetado pelo Executivo',
            $request->motivo_veto,
            Auth::id()
        );

        return redirect()->back()->with('success', 'Veto registrado com sucesso!');
    }

    /**
     * Registra sanção
     */
    public function registrarSancao(Request $request, ProjetoLei $projeto)
    {
        $request->validate([
            'lei_numero' => 'required|string|max:50',
            'lei_data_sancao' => 'required|date',
            'observacao' => 'nullable|string|max:500'
        ]);

        $projeto->update([
            'status' => ProjetoLei::STATUS_SANCIONADO,
            'lei_numero' => $request->lei_numero,
            'lei_data_sancao' => $request->lei_data_sancao
        ]);

        $projeto->adicionarHistoricoTramitacao(
            "Projeto sancionado - Lei nº {$request->lei_numero}",
            $request->observacao,
            Auth::id()
        );

        return redirect()->back()->with('success', 'Sanção registrada com sucesso!');
    }

    /**
     * Adiciona parecer
     */
    public function adicionarParecer(Request $request, ProjetoLei $projeto)
    {
        $request->validate([
            'tipo_parecer' => 'required|in:juridico,tecnico',
            'parecer' => 'required|string|max:5000',
            'relator_id' => 'nullable|exists:vereadores,id'
        ]);

        if ($request->tipo_parecer === 'juridico') {
            $projeto->parecer_juridico = $request->parecer;
        } else {
            $projeto->parecer_tecnico = $request->parecer;
        }

        if ($request->relator_id) {
            $projeto->relator_id = $request->relator_id;
        }

        $projeto->adicionarHistoricoTramitacao(
            "Parecer {$request->tipo_parecer} adicionado",
            null,
            Auth::id()
        );

        $projeto->save();

        return redirect()->back()->with('success', 'Parecer adicionado com sucesso!');
    }

    /**
     * Relatório de tramitação
     */
    public function relatorio(Request $request)
    {
        $filtros = $request->only(['data_inicio', 'data_fim', 'status', 'tipo']);
        
        $query = ProjetoLei::with(['autor', 'relator']);

        if ($request->filled('data_inicio')) {
            $query->where('data_protocolo', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('data_protocolo', '<=', $request->data_fim);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $projetos = $query->orderBy('data_protocolo', 'desc')->get();

        // Estatísticas do relatório
        $estatisticas = [
            'total' => $projetos->count(),
            'por_status' => $projetos->groupBy('status')->map->count(),
            'por_tipo' => $projetos->groupBy('tipo')->map->count(),
            'tempo_medio_tramitacao' => $projetos->where('status', ProjetoLei::STATUS_APROVADO)
                ->avg(function ($projeto) {
                    return $projeto->data_protocolo->diffInDays($projeto->data_aprovacao);
                })
        ];

        return view('admin.tramitacao.relatorio', compact('projetos', 'estatisticas', 'filtros'));
    }

    /**
     * Atualiza datas específicas baseadas no status
     */
    private function atualizarDatasPorStatus(ProjetoLei $projeto, string $status, $dataAcao = null)
    {
        $data = $dataAcao ? Carbon::parse($dataAcao) : now();

        switch ($status) {
            case ProjetoLei::STATUS_DISTRIBUIDO:
                $projeto->data_distribuicao = $data;
                break;
            case ProjetoLei::STATUS_ENVIADO_EXECUTIVO:
                $projeto->data_envio_executivo = $data;
                break;
            case ProjetoLei::STATUS_PROMULGADO:
                $projeto->data_promulgacao = $data;
                break;
        }
    }
}