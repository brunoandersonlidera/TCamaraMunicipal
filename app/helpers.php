<?php

if (!function_exists('formatarTempoRestante')) {
    /**
     * Formata o tempo restante de forma amigável
     * 
     * @param float $diasRestantes Número de dias restantes (pode ter decimais)
     * @return string Tempo formatado (ex: "67 dias e 8 horas")
     */
    function formatarTempoRestante($diasRestantes)
    {
        if ($diasRestantes <= 0) {
            return null; // Não formatar se não há tempo restante
        }

        $dias = floor($diasRestantes);
        $horasDecimais = ($diasRestantes - $dias) * 24;
        $horas = floor($horasDecimais);
        $minutos = floor(($horasDecimais - $horas) * 60);

        $resultado = [];

        if ($dias > 0) {
            $resultado[] = $dias . ($dias == 1 ? ' dia' : ' dias');
        }

        if ($horas > 0) {
            $resultado[] = $horas . ($horas == 1 ? ' hora' : ' horas');
        }

        // Se não há dias e há menos de 1 hora, mostrar minutos
        if ($dias == 0 && $horas == 0 && $minutos > 0) {
            $resultado[] = $minutos . ($minutos == 1 ? ' minuto' : ' minutos');
        }

        // Se não há nada significativo, mostrar "menos de 1 minuto"
        if (empty($resultado)) {
            return 'menos de 1 minuto';
        }

        return implode(' e ', $resultado);
    }
}

if (!function_exists('calcularDiasRestantesDetalhado')) {
    /**
     * Calcula os dias restantes com precisão de horas
     * 
     * @param \Carbon\Carbon $dataFim Data final
     * @return float Número de dias restantes com decimais
     */
    function calcularDiasRestantesDetalhado($dataFim)
    {
        return now()->diffInSeconds($dataFim, false) / 86400; // 86400 segundos = 1 dia
    }
}