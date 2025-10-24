# Script para configurar e iniciar Nginx com Laravel
Write-Host "Configurando Nginx para Laravel..." -ForegroundColor Green

# Caminhos
$nginxPath = "C:\nginx-1.28.0"
$projectPath = "D:\APLIC\TCamaraMunicipal"

# Verificar se Nginx existe
if (!(Test-Path $nginxPath)) {
    Write-Host "Nginx nao encontrado em $nginxPath" -ForegroundColor Red
    exit 1
}

Write-Host "Copiando arquivos de configuracao..." -ForegroundColor Yellow

# Copiar configurações
try {
    Copy-Item "$projectPath\nginx.conf" "$nginxPath\conf\nginx.conf" -Force
    Copy-Item "$projectPath\nginx-laravel.conf" "$nginxPath\conf\laravel-camara.conf" -Force
    Write-Host "Configuracoes copiadas com sucesso!" -ForegroundColor Green
} catch {
    Write-Host "Erro ao copiar configuracoes: $_" -ForegroundColor Red
    Write-Host "Execute como Administrador ou copie manualmente:" -ForegroundColor Yellow
    Write-Host "   - $projectPath\nginx.conf -> $nginxPath\conf\nginx.conf" -ForegroundColor White
    Write-Host "   - $projectPath\nginx-laravel.conf -> $nginxPath\conf\laravel-camara.conf" -ForegroundColor White
    exit 1
}

# Verificar se PHP-FPM está rodando (necessário para Nginx + PHP)
Write-Host "Verificando PHP-FPM..." -ForegroundColor Yellow
$phpFpm = Get-Process | Where-Object {$_.ProcessName -like "*php*"}
if (!$phpFpm) {
    Write-Host "PHP-FPM nao esta rodando. Voce precisa iniciar o PHP-FPM primeiro." -ForegroundColor Yellow
    Write-Host "Para Windows, voce pode usar: php-cgi.exe -b 127.0.0.1:9000" -ForegroundColor Cyan
}

# Parar Nginx se estiver rodando
Write-Host "Parando Nginx se estiver rodando..." -ForegroundColor Yellow
$nginxProcess = Get-Process | Where-Object {$_.ProcessName -eq "nginx"}
if ($nginxProcess) {
    Stop-Process -Name "nginx" -Force
    Start-Sleep -Seconds 2
}

# Iniciar Nginx
Write-Host "Iniciando Nginx..." -ForegroundColor Green
try {
    Set-Location $nginxPath
    Start-Process "nginx.exe" -WindowStyle Hidden
    Start-Sleep -Seconds 2
    
    # Verificar se iniciou
    $nginxRunning = Get-Process | Where-Object {$_.ProcessName -eq "nginx"}
    if ($nginxRunning) {
        Write-Host "Nginx iniciado com sucesso!" -ForegroundColor Green
        Write-Host "Acesse: http://localhost:8080" -ForegroundColor Cyan
        Write-Host "Para parar: nginx -s quit" -ForegroundColor Yellow
    } else {
        Write-Host "Falha ao iniciar Nginx. Verifique os logs em $nginxPath\logs\" -ForegroundColor Red
    }
} catch {
    Write-Host "Erro ao iniciar Nginx: $_" -ForegroundColor Red
}

Write-Host "`nProximos passos:" -ForegroundColor Cyan
Write-Host "1. Certifique-se que o PHP-FPM esta rodando na porta 9000" -ForegroundColor White
Write-Host "2. Acesse http://localhost para testar" -ForegroundColor White
Write-Host "3. Para parar: nginx -s quit" -ForegroundColor White