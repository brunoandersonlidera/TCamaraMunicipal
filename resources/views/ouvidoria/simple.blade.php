<!DOCTYPE html>
<html>
<head>
    <title>Ouvidoria - Teste</title>
</head>
<body>
    <h1>Ouvidoria</h1>
    <p>Total de manifestações: {{ $estatisticas['total_manifestacoes'] }}</p>
    <p>Manifestações este mês: {{ $estatisticas['manifestacoes_mes'] }}</p>
    <p>Tempo médio de resposta: {{ $estatisticas['tempo_medio_resposta'] }} dias</p>
    <p>Taxa de atendimento: {{ $estatisticas['taxa_atendimento'] }}%</p>
</body>
</html>