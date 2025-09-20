@extends('layouts.app')

@section('title', 'Calendário de Sessões')

@section('content')
<div class="container my-4">
    <!-- Cabeçalho -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-2">
                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                Calendário de Sessões
            </h1>
            <p class="text-muted mb-0">Acompanhe a agenda das sessões da Câmara Municipal</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('sessoes.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-list me-2"></i>Ver Lista
            </a>
        </div>
    </div>

    <!-- Navegação do Calendário -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('sessoes.calendario', ['ano' => $ano, 'mes' => $mes - 1 < 1 ? 12 : $mes - 1]) }}" 
                           class="btn btn-outline-secondary btn-sm me-2">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <h4 class="mb-0 mx-3">
                            {{ \Carbon\Carbon::createFromDate($ano, $mes, 1)->locale('pt_BR')->isoFormat('MMMM [de] YYYY') }}
                        </h4>
                        <a href="{{ route('sessoes.calendario', ['ano' => $ano, 'mes' => $mes + 1 > 12 ? 1 : $mes + 1]) }}" 
                           class="btn btn-outline-secondary btn-sm ms-2">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <form method="GET" class="row g-2">
                        <div class="col-auto">
                            <select name="mes" class="form-select form-select-sm">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $mes == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->locale('pt_BR')->isoFormat('MMMM') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto">
                            <select name="ano" class="form-select form-select-sm">
                                @for($a = date('Y') - 2; $a <= date('Y') + 2; $a++)
                                    <option value="{{ $a }}" {{ $ano == $a ? 'selected' : '' }}>{{ $a }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendário -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 calendario-table">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3">Domingo</th>
                            <th class="text-center py-3">Segunda</th>
                            <th class="text-center py-3">Terça</th>
                            <th class="text-center py-3">Quarta</th>
                            <th class="text-center py-3">Quinta</th>
                            <th class="text-center py-3">Sexta</th>
                            <th class="text-center py-3">Sábado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $primeiroDia = \Carbon\Carbon::createFromDate($ano, $mes, 1);
                            $ultimoDia = $primeiroDia->copy()->endOfMonth();
                            $inicioCalendario = $primeiroDia->copy()->startOfWeek();
                            $fimCalendario = $ultimoDia->copy()->endOfWeek();
                            $dataAtual = $inicioCalendario->copy();
                        @endphp

                        @while($dataAtual <= $fimCalendario)
                            <tr>
                                @for($i = 0; $i < 7; $i++)
                                    @php
                                        $dataFormatada = $dataAtual->format('Y-m-d');
                                        $sessoesNoDia = $sessoesPorDia[$dataFormatada] ?? collect();
                                        $isCurrentMonth = $dataAtual->month == $mes;
                                        $isToday = $dataAtual->isToday();
                                    @endphp
                                    <td class="calendario-dia {{ !$isCurrentMonth ? 'text-muted bg-light' : '' }} {{ $isToday ? 'hoje' : '' }}" 
                                        style="height: 120px; vertical-align: top;">
                                        <div class="p-2">
                                            <div class="fw-bold mb-1 {{ $isToday ? 'text-primary' : '' }}">
                                                {{ $dataAtual->day }}
                                            </div>
                                            
                                            @if($sessoesNoDia->count() > 0)
                                                @foreach($sessoesNoDia as $sessao)
                                                    <div class="sessao-item mb-1">
                                                        <a href="{{ route('sessoes.show', $sessao) }}" 
                                                           class="text-decoration-none">
                                                            <div class="badge bg-{{ $sessao->status === 'em_andamento' ? 'danger' : ($sessao->status === 'finalizada' ? 'success' : 'primary') }} 
                                                                        d-block text-start p-1 small mb-1">
                                                                <div class="fw-bold">{{ $sessao->hora_inicio }}</div>
                                                                <div class="small">
                                                                    Sessão {{ $sessao->numero_sessao }}
                                                                    @if($sessao->status === 'em_andamento')
                                                                        <i class="fas fa-circle pulse ms-1"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                    @php $dataAtual->addDay(); @endphp
                                @endfor
                            </tr>
                        @endwhile
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Legenda -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Legenda
                    </h6>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-2">●</span>
                            <small>Agendada</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2">●</span>
                            <small>Em Andamento</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2">●</span>
                            <small>Finalizada</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-calendar-check me-2"></i>Resumo do Mês
                    </h6>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="fw-bold text-primary">{{ $sessoesPorDia->flatten()->count() }}</div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-success">{{ $sessoesPorDia->flatten()->where('status', 'finalizada')->count() }}</div>
                            <small class="text-muted">Finalizadas</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-warning">{{ $sessoesPorDia->flatten()->where('status', 'agendada')->count() }}</div>
                            <small class="text-muted">Agendadas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.calendario-table {
    font-size: 0.9rem;
}

.calendario-dia {
    position: relative;
}

.calendario-dia.hoje {
    background-color: rgba(13, 110, 253, 0.1) !important;
    border: 2px solid var(--bs-primary) !important;
}

.sessao-item .badge {
    font-size: 0.7rem;
    line-height: 1.2;
}

.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

@media (max-width: 768px) {
    .calendario-table {
        font-size: 0.8rem;
    }
    
    .calendario-dia {
        height: 80px !important;
    }
    
    .sessao-item .badge {
        font-size: 0.6rem;
    }
}
</style>
@endsection