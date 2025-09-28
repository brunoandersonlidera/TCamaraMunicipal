<!DOCTYPE html>
<html>
<head>
    <title>Debug Projetos</title>
</head>
<body>
    <h1>Debug Projetos de Lei</h1>
    <p>Total de projetos: {{ $totalProjetos }}</p>
    <p>Projetos carregados: {{ $projetos->count() }}</p>
    
    @if($projetos->count() > 0)
        <h2>Projetos:</h2>
        @foreach($projetos as $projeto)
            <div>
                <h3>{{ $projeto->titulo ?? 'Sem título' }}</h3>
                <p>Autor: {{ $projeto->autor->nome ?? 'Sem autor' }}</p>
                <p>Status: {{ $projeto->status ?? 'Sem status' }}</p>
            </div>
        @endforeach
    @else
        <p>Nenhum projeto encontrado.</p>
    @endif
</body>
</html>