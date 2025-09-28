<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Vereador;
use App\Models\Sessao;
use App\Models\Licitacao;
use App\Models\EsicSolicitacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CalendarioController extends Controller
{
    /**
     * Exibe o mini calendário para a página inicial
     */
    public function miniCalendario(Request $request)
    {
        try {
            $ano = $request->get('ano', now()->year);
            $mes = $request->get('mes', now()->month);
            
            // Buscar eventos do mês com relacionamentos otimizados
            $eventosRaw = Evento::where('ativo', true)
                ->whereYear('data_evento', $ano)
                ->whereMonth('data_evento', $mes)
                ->with(['vereador:id,nome', 'sessao:id,numero_sessao,tipo', 'licitacao:id,titulo'])
                ->select(['id', 'titulo', 'tipo', 'data_evento', 'hora_inicio', 'hora_fim', 'cor_destaque', 'local', 'descricao', 'vereador_id', 'sessao_id', 'licitacao_id'])
                ->get();

            // Formatar eventos para o calendário
            $eventos = $eventosRaw->groupBy(function($evento) {
                return $evento->data_evento->day;
            })->map(function($eventosDay) {
                return $eventosDay->map(function($evento) {
                    return [
                        'id' => $evento->id,
                        'titulo' => $evento->titulo,
                        'tipo' => $evento->tipo,
                        'tipo_label' => $evento->tipo_label,
                        'data_evento' => $evento->data_evento->format('Y-m-d'),
                        'data_formatada' => $evento->data_formatada,
                        'horario_formatado' => $evento->horario_formatado,
                        'cor' => $evento->cor,
                        'local' => $evento->local,
                        'descricao' => $evento->descricao
                    ];
                });
            });

            // Próximos 5 eventos com relacionamentos otimizados
            $proximosEventosRaw = Evento::where('ativo', true)
                ->where('data_evento', '>=', now()->toDateString())
                ->with(['vereador:id,nome', 'sessao:id,numero_sessao,tipo', 'licitacao:id,titulo'])
                ->select(['id', 'titulo', 'tipo', 'data_evento', 'hora_inicio', 'hora_fim', 'cor_destaque', 'local', 'descricao', 'vereador_id', 'sessao_id', 'licitacao_id'])
                ->orderBy('data_evento')
                ->orderBy('hora_inicio')
                ->limit(5)
                ->get();

            // Formatar próximos eventos
            $proximosEventos = $proximosEventosRaw->map(function($evento) {
                return [
                    'id' => $evento->id,
                    'titulo' => $evento->titulo,
                    'tipo' => $evento->tipo,
                    'tipo_label' => $evento->tipo_label,
                    'data_evento' => $evento->data_evento->format('Y-m-d'),
                    'data_formatada' => $evento->data_formatada,
                    'horario_formatado' => $evento->horario_formatado,
                    'cor' => $evento->cor,
                    'local' => $evento->local,
                    'descricao' => $evento->descricao
                ];
            });

            // Dados do calendário
            $dataAtual = Carbon::create($ano, $mes, 1);
            $diasMes = $dataAtual->daysInMonth;
            $primeiroDiaSemana = $dataAtual->dayOfWeek; // 0 = domingo
            
            return response()->json([
                'eventos' => $eventos,
                'proximosEventos' => $proximosEventos,
                'calendario' => [
                    'ano' => $ano,
                    'mes' => $mes,
                    'mesNome' => $dataAtual->translatedFormat('F'),
                    'diasMes' => $diasMes,
                    'primeiroDiaSemana' => $primeiroDiaSemana,
                    'hoje' => now()->day
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro no miniCalendario: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno do servidor'], 500);
        }
    }

    /**
     * Exibe a página completa da agenda
     */
    public function agenda(Request $request)
    {
        $filtros = $request->only(['tipo', 'mes', 'ano', 'vereador_id']);
        $visualizacao = $request->get('view', 'calendario'); // calendario, lista, timeline
        
        $query = Evento::ativos()->with(['vereador', 'sessao', 'licitacao', 'esicSolicitacao']);
        
        // Aplicar filtros
        if (!empty($filtros['tipo'])) {
            $query->porTipo($filtros['tipo']);
        }
        
        if (!empty($filtros['vereador_id'])) {
            $query->where('vereador_id', $filtros['vereador_id']);
        }
        
        if (!empty($filtros['ano']) && !empty($filtros['mes'])) {
            $query->porMes($filtros['ano'], $filtros['mes']);
        } else {
            // Padrão: próximos 3 meses
            $query->where('data_evento', '>=', now()->startOfMonth())
                  ->where('data_evento', '<=', now()->addMonths(3)->endOfMonth());
        }
        
        // Adicionar eventos do E-SIC se usuário logado
        if (Auth::check()) {
            $eventosEsic = $this->getEventosEsicPorUsuario(Auth::id());
            // Aqui você pode mesclar os eventos ou tratá-los separadamente
        }
        
        $eventos = $query->orderBy('data_evento')->orderBy('hora_inicio')->get();
        
        // Dados auxiliares
        $vereadores = Vereador::ativos()->orderBy('nome')->get();
        $tipos = Evento::getTipos();
        
        return view('calendario.agenda', compact(
            'eventos', 
            'vereadores', 
            'tipos', 
            'filtros', 
            'visualizacao'
        ));
    }

    /**
     * API para buscar eventos por período
     */
    public function buscarEventos(Request $request)
    {
        $dataInicio = $request->get('start');
        $dataFim = $request->get('end');
        $tipos = $request->get('tipos', []);
        $tipo = $request->get('tipo'); // Filtro individual
        $periodo = $request->get('periodo');
        $busca = $request->get('busca');
        $ano = $request->get('ano');
        $mes = $request->get('mes');
        
        $query = Evento::ativos();
        
        // Filtrar por ano e mês específicos (usado pelo calendário)
        if ($ano && $mes) {
            $query->whereYear('data_evento', $ano)
                  ->whereMonth('data_evento', $mes);
        }
        // Filtrar por data se fornecido
        elseif ($dataInicio && $dataFim) {
            $query->whereBetween('data_evento', [$dataInicio, $dataFim]);
        }
        // Filtrar por período
        elseif ($periodo) {
            switch ($periodo) {
                case 'hoje':
                    $query->whereDate('data_evento', now()->toDateString());
                    break;
                case 'semana':
                    $query->whereBetween('data_evento', [
                        now()->startOfWeek()->toDateString(),
                        now()->endOfWeek()->toDateString()
                    ]);
                    break;
                case 'mes':
                    $query->whereBetween('data_evento', [
                        now()->startOfMonth()->toDateString(),
                        now()->endOfMonth()->toDateString()
                    ]);
                    break;
                case 'proximos':
                default:
                    $query->where('data_evento', '>=', now()->toDateString());
                    break;
            }
        } else {
            // Se não especificado, mostrar próximos eventos
            $query->where('data_evento', '>=', now()->toDateString());
        }
        
        // Filtrar por tipos se fornecido
        if (!empty($tipos)) {
            $query->whereIn('tipo', $tipos);
        }
        
        // Filtro individual por tipo
        if ($tipo) {
            $query->where('tipo', $tipo);
        }
        
        // Filtro por busca
        if ($busca) {
            $query->where(function($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('local', 'like', "%{$busca}%");
            });
        }
        
        $eventos = $query->select([
                'id', 'titulo', 'data_evento', 'hora_inicio', 'hora_fim', 
                'cor_destaque', 'descricao', 'tipo', 'local', 'destaque'
            ])
            ->orderBy('data_evento')
            ->orderBy('hora_inicio')
            ->limit(50) // Limitar para performance
            ->get()
            ->map(function($evento) {
                $isAllDay = !$evento->hora_inicio && !$evento->hora_fim;
                
                // Para eventos de dia inteiro, o FullCalendar precisa que end seja o dia seguinte
                $startDate = $evento->data_evento ? $evento->data_evento->format('Y-m-d') : null;
                $endDate = null;
                
                if ($isAllDay && $evento->data_evento) {
                    // Para eventos de dia inteiro, end deve ser o dia seguinte
                    $endDate = $evento->data_evento->addDay()->format('Y-m-d');
                } elseif ($evento->data_evento) {
                    // Para eventos com horário
                    $endDate = $evento->data_evento->format('Y-m-d') . 
                              ($evento->hora_fim ? ' ' . $evento->hora_fim->format('H:i:s') : '');
                }
                
                return [
                    'id' => $evento->id,
                    'titulo' => $evento->titulo ?? 'Evento sem título',
                    'data_evento' => $evento->data_evento ? $evento->data_evento->format('Y-m-d') : null,
                    'hora_inicio' => $evento->hora_inicio ? $evento->hora_inicio->format('H:i') : null,
                    'hora_fim' => $evento->hora_fim ? $evento->hora_fim->format('H:i') : null,
                    'tipo' => $evento->tipo ?? 'evento',
                    'local' => $evento->local ?? '',
                    'descricao' => $evento->descricao ?? '',
                    'cor' => $evento->cor_destaque ?? '#007bff',
                    'destaque' => $evento->destaque ?? false,
                    // Campos para compatibilidade com FullCalendar
                    'title' => $evento->titulo ?? 'Evento sem título',
                    'start' => $startDate . ($evento->hora_inicio ? ' ' . $evento->hora_inicio->format('H:i:s') : ''),
                    'end' => $endDate,
                    'allDay' => $isAllDay,
                    'color' => $evento->cor_destaque ?? '#007bff',
                    'description' => $evento->descricao ?? ''
                ];
            });
        
        return response()->json($eventos);
    }

    /**
     * Buscar eventos do E-SIC para usuário específico (função auxiliar)
     */
    private function getEventosEsicPorUsuario($userId, $dataInicio = null, $dataFim = null)
    {
        if (!$userId) {
            return collect();
        }

        $query = EsicSolicitacao::where('user_id', $userId)
            ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
            ->whereNotNull('data_limite_resposta');
            
        if ($dataInicio && $dataFim) {
            $query->whereBetween('data_limite_resposta', [$dataInicio, $dataFim]);
        }
        
        $eventos = $query->get()->map(function($solicitacao) {
            $diasRestantes = now()->diffInDays($solicitacao->data_limite_resposta, false);
            $cor = '#fd7e14'; // Laranja padrão
            
            // Definir cor baseada nos dias restantes
            if ($diasRestantes < 0) {
                $cor = '#dc3545'; // Vermelho - vencido
            } elseif ($diasRestantes <= 3) {
                $cor = '#ffc107'; // Amarelo - urgente
            } elseif ($diasRestantes <= 7) {
                $cor = '#fd7e14'; // Laranja - atenção
            } else {
                $cor = '#28a745'; // Verde - normal
            }
            
            return [
                'id' => 'esic_' . $solicitacao->id,
                'title' => 'Prazo E-SIC: ' . Str::limit($solicitacao->assunto, 30),
                'start' => $solicitacao->data_limite_resposta->format('Y-m-d'),
                'color' => $cor,
                'tipo' => 'prazo_esic',
                'description' => 'Prazo para resposta da solicitação E-SIC - Protocolo: ' . $solicitacao->protocolo,
                'url' => route('esic.minhas-solicitacoes') . '#solicitacao-' . $solicitacao->id,
                'extendedProps' => [
                    'protocolo' => $solicitacao->protocolo,
                    'status' => $solicitacao->status,
                    'dias_restantes' => $diasRestantes,
                    'vencido' => $diasRestantes < 0
                ]
            ];
        });

        return $eventos;
    }

    /**
     * Exibe detalhes de um evento
     */
    public function show(Request $request, $id)
    {
        $evento = Evento::with(['vereador', 'sessao', 'licitacao', 'esicSolicitacao'])
            ->findOrFail($id);
        
        // Se for uma requisição AJAX, retornar JSON
        if ($request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'id' => $evento->id,
                'titulo' => $evento->titulo,
                'tipo' => $evento->tipo,
                'tipo_label' => $evento->tipo_label,
                'data_evento' => $evento->data_evento->format('Y-m-d'),
                'data_formatada' => $evento->data_formatada,
                'hora_inicio' => $evento->hora_inicio,
                'hora_fim' => $evento->hora_fim,
                'horario_formatado' => $evento->horario_formatado,
                'local' => $evento->local,
                'descricao' => $evento->descricao,
                'observacoes' => $evento->observacoes,
                'cor' => $evento->cor,
                'vereador' => $evento->vereador ? [
                    'id' => $evento->vereador->id,
                    'nome' => $evento->vereador->nome,
                    'nome_parlamentar' => $evento->vereador->nome_parlamentar
                ] : null,
                'sessao' => $evento->sessao ? [
                    'id' => $evento->sessao->id,
                    'numero_sessao' => $evento->sessao->numero_sessao,
                    'tipo' => $evento->sessao->tipo
                ] : null,
                'licitacao' => $evento->licitacao ? [
                    'id' => $evento->licitacao->id,
                    'titulo' => $evento->licitacao->titulo
                ] : null,
                'url_detalhes' => route('calendario.evento.show', $evento->id)
            ]);
        }
        
        // Se for uma requisição normal, retornar a view
        return view('calendario.evento-detalhes', compact('evento'));
    }

    /**
     * Busca eventos por texto
     */
    public function buscar(Request $request)
    {
        $termo = $request->get('q');
        
        if (strlen($termo) < 3) {
            return response()->json([]);
        }
        
        $eventos = Evento::ativos()
            ->where(function($query) use ($termo) {
                $query->where('titulo', 'like', "%{$termo}%")
                      ->orWhere('descricao', 'like', "%{$termo}%")
                      ->orWhere('local', 'like', "%{$termo}%");
            })
            ->with(['vereador'])
            ->orderBy('data_evento')
            ->limit(10)
            ->get();
            
        return response()->json($eventos->map(function($evento) {
            return [
                'id' => $evento->id,
                'titulo' => $evento->titulo,
                'data' => $evento->data_formatada,
                'tipo' => $evento->tipo_label,
                'vereador' => $evento->vereador ? $evento->vereador->nome : null,
                'url' => route('calendario.evento', $evento->id)
            ];
        }));
    }

    /**
     * Exportar agenda em formato ICS (iCalendar)
     */
    public function exportarIcs(Request $request)
    {
        $eventos = Evento::ativos()
            ->where('data_evento', '>=', now())
            ->orderBy('data_evento')
            ->get();
            
        $ics = $this->gerarIcs($eventos);
        
        return response($ics)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="agenda-camara.ics"');
    }

    /**
     * Buscar eventos do E-SIC para usuário logado
     */
    public function getEventosEsicUsuario(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $userId = auth()->id();
        $dataInicio = $request->get('start');
        $dataFim = $request->get('end');

        $query = EsicSolicitacao::where('user_id', $userId)
            ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
            ->whereNotNull('data_limite_resposta');
            
        if ($dataInicio && $dataFim) {
            $query->whereBetween('data_limite_resposta', [$dataInicio, $dataFim]);
        }
        
        $eventos = $query->get()->map(function($solicitacao) {
            $diasRestantes = now()->diffInDays($solicitacao->data_limite_resposta, false);
            $cor = '#fd7e14'; // Laranja padrão
            
            // Definir cor baseada nos dias restantes
            if ($diasRestantes < 0) {
                $cor = '#dc3545'; // Vermelho - vencido
            } elseif ($diasRestantes <= 3) {
                $cor = '#ffc107'; // Amarelo - urgente
            } elseif ($diasRestantes <= 7) {
                $cor = '#fd7e14'; // Laranja - atenção
            } else {
                $cor = '#28a745'; // Verde - normal
            }
            
            return [
                'id' => 'esic_' . $solicitacao->id,
                'title' => 'Prazo E-SIC: ' . Str::limit($solicitacao->assunto, 30),
                'start' => $solicitacao->data_limite_resposta->format('Y-m-d'),
                'color' => $cor,
                'tipo' => 'prazo_esic',
                'description' => 'Prazo para resposta da solicitação E-SIC - Protocolo: ' . $solicitacao->protocolo,
                'url' => route('esic.minhas-solicitacoes') . '#solicitacao-' . $solicitacao->id,
                'extendedProps' => [
                    'protocolo' => $solicitacao->protocolo,
                    'status' => $solicitacao->status,
                    'dias_restantes' => $diasRestantes,
                    'vencido' => $diasRestantes < 0
                ]
            ];
        });

        return response()->json($eventos);
    }

    /**
     * Gerar URL específica para cada tipo de evento
     */
    private function getUrlEvento($evento)
    {
        switch ($evento->tipo) {
            case 'sessao_plenaria':
                return $evento->sessao_id ? route('sessoes.show', $evento->sessao_id) : null;
            case 'licitacao':
                return $evento->licitacao_id ? route('licitacoes.show', $evento->licitacao_id) : null;
            case 'agenda_vereador':
            case 'ato_vereador':
                return $evento->vereador_id ? route('vereadores.show', $evento->vereador_id) : null;
            default:
                return route('calendario.evento', $evento->id);
        }
    }

    /**
     * Gerar arquivo ICS para exportação
     */
    private function gerarIcs($eventos)
    {
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//Câmara Municipal//Agenda Legislativa//PT\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        
        foreach ($eventos as $evento) {
            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:" . $evento->id . "@camara.legislativo\r\n";
            $ics .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
            $ics .= "DTSTART:" . $evento->data_evento->format('Ymd') . "\r\n";
            $ics .= "SUMMARY:" . $this->escaparIcs($evento->titulo) . "\r\n";
            
            if ($evento->descricao) {
                $ics .= "DESCRIPTION:" . $this->escaparIcs($evento->descricao) . "\r\n";
            }
            
            if ($evento->local) {
                $ics .= "LOCATION:" . $this->escaparIcs($evento->local) . "\r\n";
            }
            
            $ics .= "END:VEVENT\r\n";
        }
        
        $ics .= "END:VCALENDAR\r\n";
        
        return $ics;
    }

    /**
     * Escapar caracteres especiais para formato ICS
     */
    private function escaparIcs($texto)
    {
        return str_replace([',', ';', '\\', "\n"], ['\\,', '\\;', '\\\\', '\\n'], $texto);
    }

    /**
     * Sincronizar eventos automáticos (chamado por jobs/cron)
     */
    public function sincronizarEventos()
    {
        // Sincronizar sessões
        $sessoes = Sessao::where('data', '>=', now())
            ->whereDoesntHave('eventos')
            ->get();
            
        foreach ($sessoes as $sessao) {
            Evento::criarEventoAutomatico('sessao_plenaria', [
                'id' => $sessao->id,
                'tipo' => $sessao->tipo_sessao->nome ?? 'Sessão',
                'data' => $sessao->data,
                'hora_inicio' => $sessao->hora_inicio
            ]);
        }
        
        // Sincronizar licitações
        $licitacoes = Licitacao::where('data_abertura', '>=', now())
            ->whereDoesntHave('eventos')
            ->get();
            
        foreach ($licitacoes as $licitacao) {
            Evento::criarEventoAutomatico('licitacao', [
                'id' => $licitacao->id,
                'objeto' => $licitacao->objeto,
                'data_abertura' => $licitacao->data_abertura,
                'hora_abertura' => $licitacao->hora_abertura
            ]);
        }
        
        return response()->json(['message' => 'Eventos sincronizados com sucesso']);
    }

    /**
     * Página de eventos do usuário logado
     */
    public function meusEventos(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Se for uma requisição AJAX, retornar dados
        if ($request->ajax() || $request->expectsJson()) {
            return $this->getMeusEventosData($request);
        }

        // Renderizar a página
        return view('calendario.meus-eventos');
    }

    /**
     * Obter dados dos eventos do usuário para AJAX
     */
    private function getMeusEventosData(Request $request)
    {
        $user = auth()->user();
        
        // Verificar se é requisição para estatísticas
        if ($request->has('estatisticas')) {
            return $this->getEstatisticasEventos($user);
        }
        
        // Verificar se é requisição para alertas
        if ($request->has('alertas')) {
            return $this->getAlertasPrazos($user);
        }
        
        // Verificar se é requisição para próximos eventos
        if ($request->has('proximos')) {
            return $this->getProximosEventos($user, $request->get('proximos', 5));
        }
        
        // Buscar eventos do E-SIC
        $eventosEsic = $this->getEventosEsicUsuario($request)->getData();
        
        // Buscar eventos públicos relevantes (opcional)
        $eventosPublicos = [];
        if (!$request->has('tipo') || $request->get('tipo') !== 'prazo_esic') {
            $start = $request->get('start', now()->startOfMonth()->format('Y-m-d'));
            $end = $request->get('end', now()->endOfMonth()->format('Y-m-d'));
            
            $query = Evento::where('ativo', true)
                ->whereBetween('data_inicio', [$start, $end]);
                
            if ($request->has('tipo') && $request->get('tipo')) {
                $query->where('tipo', $request->get('tipo'));
            }
            
            $eventosPublicos = $query->get()->map(function ($evento) {
                return [
                    'id' => $evento->id,
                    'title' => $evento->titulo,
                    'start' => $evento->data_inicio->format('Y-m-d H:i:s'),
                    'end' => $evento->data_fim ? $evento->data_fim->format('Y-m-d H:i:s') : null,
                    'color' => $evento->cor ?? '#007bff',
                    'tipo' => $evento->tipo,
                    'description' => $evento->descricao,
                    'url' => $this->getUrlEvento($evento),
                    'extendedProps' => [
                        'local' => $evento->local,
                        'observacoes' => $evento->observacoes
                    ]
                ];
            });
        }
        
        // Combinar eventos
        $todosEventos = collect($eventosEsic)->merge($eventosPublicos);
        
        return response()->json($todosEventos);
    }
    
    /**
     * Obter estatísticas dos eventos do usuário
     */
    private function getEstatisticasEventos($user)
    {
        $solicitacoes = EsicSolicitacao::where('user_id', $user->id)
            ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
            ->whereNotNull('data_limite_resposta')
            ->get();
            
        $hoje = now();
        $total = $solicitacoes->count();
        $vencidos = $solicitacoes->filter(function ($s) use ($hoje) {
            return $s->data_limite_resposta < $hoje;
        })->count();
        
        $urgentes = $solicitacoes->filter(function ($s) use ($hoje) {
            $dias = $hoje->diffInDays($s->data_limite_resposta, false);
            return $dias >= 0 && $dias <= 3;
        })->count();
        
        $proximos = $solicitacoes->filter(function ($s) use ($hoje) {
            $dias = $hoje->diffInDays($s->data_limite_resposta, false);
            return $dias > 3 && $dias <= 7;
        })->count();
        
        return response()->json([
            'total' => $total,
            'vencidos' => $vencidos,
            'urgentes' => $urgentes,
            'proximos' => $proximos
        ]);
    }
    
    /**
     * Obter alertas de prazos próximos
     */
    private function getAlertasPrazos($user)
    {
        $solicitacoes = EsicSolicitacao::where('user_id', $user->id)
            ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
            ->whereNotNull('data_limite_resposta')
            ->get();
            
        $hoje = now();
        $alertas = [];
        
        foreach ($solicitacoes as $solicitacao) {
            $dias = $hoje->diffInDays($solicitacao->data_limite_resposta, false);
            
            if ($dias < 0) {
                // Vencido
                $alertas[] = [
                    'vencido' => true,
                    'message' => "Solicitação {$solicitacao->protocolo} venceu há " . abs($dias) . " dia(s)."
                ];
            } elseif ($dias <= 3) {
                // Próximo do vencimento
                $alertas[] = [
                    'vencido' => false,
                    'message' => "Solicitação {$solicitacao->protocolo} vence em {$dias} dia(s)."
                ];
            }
        }
        
        return response()->json($alertas);
    }
    
    /**
     * Obter próximos eventos do usuário
     */
    private function getProximosEventos($user, $limite = 5)
    {
        $solicitacoes = EsicSolicitacao::where('user_id', $user->id)
            ->whereIn('status', ['pendente', 'em_analise', 'aguardando_informacoes'])
            ->whereNotNull('data_limite_resposta')
            ->where('data_limite_resposta', '>=', now())
            ->orderBy('data_limite_resposta')
            ->limit($limite)
            ->get();
            
        $eventos = $solicitacoes->map(function ($solicitacao) {
            return [
                'title' => 'Prazo E-SIC: ' . Str::limit($solicitacao->assunto, 30),
                'start' => $solicitacao->data_limite_resposta->format('Y-m-d'),
                'tipo' => 'prazo_esic',
                'description' => 'Protocolo: ' . $solicitacao->protocolo,
                'protocolo' => $solicitacao->protocolo,
                'status' => $solicitacao->status
            ];
        });
        
        return response()->json($eventos);
    }

    /**
     * Retorna estatísticas dos eventos para o dashboard
     */
    public function estatisticas()
    {
        $hoje = now();
        $inicioMes = $hoje->copy()->startOfMonth();
        $fimMes = $hoje->copy()->endOfMonth();
        $inicioSemana = $hoje->copy()->startOfWeek();
        $fimSemana = $hoje->copy()->endOfWeek();

        // Total de eventos
        $total = Evento::ativos()->count();

        // Eventos deste mês
        $esteMes = Evento::ativos()
            ->whereBetween('data_evento', [$inicioMes, $fimMes])
            ->count();

        // Eventos desta semana
        $estaSemana = Evento::ativos()
            ->whereBetween('data_evento', [$inicioSemana, $fimSemana])
            ->count();

        // Prazos E-SIC vencendo (próximos 7 dias)
        $prazosVencendo = 0;
        if (auth()->check()) {
            $prazosVencendo = EsicSolicitacao::where('usuario_id', auth()->id())
                ->whereIn('status', ['em_analise', 'aguardando_resposta'])
                ->where('data_limite_resposta', '>=', $hoje)
                ->where('data_limite_resposta', '<=', $hoje->copy()->addDays(7))
                ->count();
        }

        return response()->json([
            'total' => $total,
            'este_mes' => $esteMes,
            'esta_semana' => $estaSemana,
            'prazos_vencendo' => $prazosVencendo
        ]);
    }

    /**
     * Retorna os próximos eventos
     */
    public function proximosEventos(Request $request)
    {
        $limite = $request->get('limite', 5);
        
        $eventos = Evento::ativos()
            ->where('data_evento', '>=', now()->toDateString())
            ->orderBy('data_evento')
            ->orderBy('hora_inicio')
            ->limit($limite)
            ->with(['vereador', 'sessao', 'licitacao'])
            ->get();

        $eventosFormatados = $eventos->map(function($evento) {
            return [
                'id' => $evento->id,
                'titulo' => $evento->titulo,
                'data_inicio' => $evento->data_evento->format('Y-m-d') . 
                               ($evento->hora_inicio ? ' ' . $evento->hora_inicio->format('H:i:s') : ''),
                'data_fim' => $evento->data_evento->format('Y-m-d') . 
                             ($evento->hora_fim ? ' ' . $evento->hora_fim->format('H:i:s') : ''),
                'tipo' => $evento->tipo,
                'local' => $evento->local,
                'descricao' => $evento->descricao,
                'cor' => $evento->cor
            ];
        });

        return response()->json($eventosFormatados);
    }

    /**
     * Exibe a agenda específica de um vereador
     */
    public function agendaVereador(Request $request, Vereador $vereador)
    {
        $filtros = $request->only(['mes', 'ano']);
        $visualizacao = $request->get('view', 'calendario'); // calendario, lista, timeline
        
        $query = Evento::ativos()
            ->where('vereador_id', $vereador->id)
            ->with(['vereador', 'sessao', 'licitacao', 'esicSolicitacao']);
        
        // Aplicar filtros de data
        if (!empty($filtros['ano']) && !empty($filtros['mes'])) {
            $query->porMes($filtros['ano'], $filtros['mes']);
        } else {
            // Padrão: próximos 3 meses
            $query->where('data_evento', '>=', now()->startOfMonth())
                  ->where('data_evento', '<=', now()->addMonths(3)->endOfMonth());
        }
        
        $eventos = $query->orderBy('data_evento')->orderBy('hora_inicio')->get();
        
        // Dados auxiliares
        $tipos = Evento::getTipos();
        
        return view('calendario.agenda-vereador', compact(
            'eventos', 
            'vereador',
            'tipos', 
            'filtros', 
            'visualizacao'
        ));
    }
}
