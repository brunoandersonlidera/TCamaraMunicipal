@extends('layouts.app')

@section('title', 'Agenda de ' . $vereador->nome_parlamentar . ' - Câmara Municipal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/public-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
    <style>
        .vereador-header {
            background: linear-gradient(135deg, var(--theme-primary-dark, #2c3e50) 0%, var(--theme-primary, #34495e) 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .vereador-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .vereador-foto {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.2);
        }
        
        .vereador-detalhes h1 {
            margin: 0 0 0.5rem 0;
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .vereador-detalhes .cargo {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 1rem;
        }
        
        .vereador-detalhes .partido {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            display: inline-block;
            font-weight: 600;
        }
        
        .agenda-stats {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: var(--theme-light, #f8f9fa);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--theme-heading, #2c3e50);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--theme-text-muted, #6c757d);
            font-size: 0.9rem;
        }
        
        .voltar-btn {
            background: var(--theme-primary, #3498db);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .voltar-btn:hover {
            background: var(--theme-primary-dark, #2980b9);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
<div class="vereador-header">
    <div class="container">
        <div class="vereador-info">
            <img src="{{ $vereador->foto_url }}" alt="{{ $vereador->nome_parlamentar }}" class="vereador-foto">
            <div class="vereador-detalhes">
                <h1>{{ $vereador->nome_parlamentar }}</h1>
                <div class="cargo">{{ $vereador->cargo ?? 'Vereador' }}</div>
                @if($vereador->partido)
                    <div class="partido">{{ $vereador->partido }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container">
    <a href="{{ route('home') }}" class="voltar-btn">
        <i class="fas fa-arrow-left"></i>
        Voltar à Página Inicial
    </a>
    
    <div class="agenda-stats">
        <h3 class="mb-3">Estatísticas da Agenda</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $eventos->count() }}</div>
                <div class="stat-label">Eventos Próximos</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $eventos->where('tipo', 'reuniao')->count() }}</div>
                <div class="stat-label">Reuniões</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $eventos->where('tipo', 'sessao')->count() }}</div>
                <div class="stat-label">Sessões</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $eventos->where('tipo', 'audiencia')->count() }}</div>
                <div class="stat-label">Audiências</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        Agenda de {{ $vereador->nome_parlamentar }}
                    </h4>
                    
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="visualizacao" id="view-calendario" value="calendario" {{ $visualizacao == 'calendario' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="view-calendario">
                            <i class="fas fa-calendar"></i> Calendário
                        </label>
                        
                        <input type="radio" class="btn-check" name="visualizacao" id="view-lista" value="lista" {{ $visualizacao == 'lista' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="view-lista">
                            <i class="fas fa-list"></i> Lista
                        </label>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($eventos->count() > 0)
                        <div id="calendario-container" class="{{ $visualizacao == 'calendario' ? '' : 'd-none' }}">
                            <div id="calendario"></div>
                        </div>
                        
                        <div id="lista-container" class="{{ $visualizacao == 'lista' ? '' : 'd-none' }}">
                            <div class="eventos-lista">
                                @foreach($eventos->groupBy(function($evento) { return $evento->data_evento->format('Y-m-d'); }) as $data => $eventosData)
                                    <div class="data-grupo mb-4">
                                        <h5 class="data-titulo">
                                            <i class="fas fa-calendar-day text-primary me-2"></i>
                                            {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($data)->locale('pt_BR')->isoFormat('dddd') }}
                                        </h5>
                                        
                                        <div class="eventos-data">
                                            @foreach($eventosData as $evento)
                                                <div class="evento-item card mb-2">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div class="evento-info">
                                                                <h6 class="evento-titulo mb-1">
                                                                    <span class="badge badge-{{ $evento->tipo }} me-2">{{ $evento->tipo_label }}</span>
                                                                    {{ $evento->titulo }}
                                                                </h6>
                                                                
                                                                @if($evento->horario_formatado)
                                                                    <p class="evento-horario mb-1">
                                                                        <i class="fas fa-clock text-muted me-1"></i>
                                                                        {{ $evento->horario_formatado }}
                                                                    </p>
                                                                @endif
                                                                
                                                                @if($evento->local)
                                                                    <p class="evento-local mb-1">
                                                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                                        {{ $evento->local }}
                                                                    </p>
                                                                @endif
                                                                
                                                                @if($evento->descricao)
                                                                    <p class="evento-descricao text-muted mb-0">
                                                                        {{ Str::limit($evento->descricao, 150) }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            
                                                            <div class="evento-acoes">
                                                                <a href="{{ route('calendario.evento.show', $evento) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye"></i> Ver Detalhes
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhum evento encontrado</h5>
                            <p class="text-muted">{{ $vereador->nome_parlamentar }} não possui eventos agendados no período selecionado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/pt-br.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Alternar visualização
    document.querySelectorAll('input[name="visualizacao"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const view = this.value;
            
            if (view === 'calendario') {
                document.getElementById('calendario-container').classList.remove('d-none');
                document.getElementById('lista-container').classList.add('d-none');
                initCalendario();
            } else {
                document.getElementById('calendario-container').classList.add('d-none');
                document.getElementById('lista-container').classList.remove('d-none');
            }
            
            // Atualizar URL
            const url = new URL(window.location);
            url.searchParams.set('view', view);
            window.history.pushState({}, '', url);
        });
    });
    
    // Inicializar calendário se necessário
    if (document.querySelector('input[name="visualizacao"]:checked').value === 'calendario') {
        initCalendario();
    }
    
    function initCalendario() {
        const calendarEl = document.getElementById('calendario');
        if (!calendarEl || calendarEl.hasChildNodes()) return;
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: function(info, successCallback, failureCallback) {
                fetch(`{{ route('calendario.eventos') }}?start=${info.startStr}&end=${info.endStr}&vereador_id={{ $vereador->id }}`)
                    .then(response => response.json())
                    .then(data => {
                        const events = data.map(evento => ({
                            id: evento.id,
                            title: evento.titulo,
                            start: evento.data_inicio,
                            end: evento.data_fim,
                            backgroundColor: evento.cor || '#3498db',
                            borderColor: evento.cor || '#3498db',
                            url: `{{ route('calendario.evento.show', '') }}/${evento.id}`
                        }));
                        successCallback(events);
                    })
                    .catch(error => {
                        console.error('Erro ao carregar eventos:', error);
                        failureCallback(error);
                    });
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                window.open(info.event.url, '_blank');
            }
        });
        
        calendar.render();
    }
});
</script>
@endpush