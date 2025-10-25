# Script completo para iniciar Laravel com Nginx + PHP-CGI
Write-Host "Iniciando ambiente Laravel com Nginx..." -ForegroundColor Green

# Verificar se está executando como Administrador (necessário para porta 80)
$currentUser = [Security.Principal.WindowsIdentity]::GetCurrent()
$principal = New-Object Security.Principal.WindowsPrincipal($currentUser)
$isAdmin = $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "ATENÇÃO: Para usar a porta 80, execute como Administrador!" -ForegroundColor Red
    Write-Host "Clique com botão direito no PowerShell e selecione 'Executar como administrador'" -ForegroundColor Yellow
    Write-Host "Pressione qualquer tecla para continuar mesmo assim..." -ForegroundColor Yellow
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
}

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

# Parar processos existentes
Write-Host "Parando processos existentes..." -ForegroundColor Yellow

# Parar Nginx
$nginxProcess = Get-Process | Where-Object {$_.ProcessName -eq "nginx"}
if ($nginxProcess) {
    try {
        Set-Location $nginxPath
        .\nginx.exe -s quit
        Start-Sleep -Seconds 2
        Write-Host "Nginx parado" -ForegroundColor Green
    } catch {
        Write-Host "Erro ao parar Nginx: $_" -ForegroundColor Yellow
    }
}

# Parar PHP-CGI
$phpProcess = Get-Process | Where-Object {$_.ProcessName -like "*php*"}
if ($phpProcess) {
    try {
        $phpProcess | Stop-Process -Force
        Write-Host "PHP-CGI parado" -ForegroundColor Green
    } catch {
        Write-Host "Erro ao parar PHP-CGI: $_" -ForegroundColor Yellow
    }
}

# Iniciar PHP-CGI
Write-Host "Iniciando PHP-CGI na porta 9000..." -ForegroundColor Yellow
try {
    Set-Location $projectPath
    Start-Process "php-cgi" -ArgumentList "-b", "127.0.0.1:9000" -WindowStyle Hidden
    Start-Sleep -Seconds 3
    
    # Verificar se PHP-CGI iniciou
    $phpRunning = netstat -an | findstr ":9000"
    if ($phpRunning) {
        Write-Host "PHP-CGI iniciado com sucesso!" -ForegroundColor Green
    } else {
        Write-Host "Falha ao iniciar PHP-CGI" -ForegroundColor Red
        exit 1
    }
} catch {
    Write-Host "Erro ao iniciar PHP-CGI: $_" -ForegroundColor Red
    exit 1
}

# Verificar se a porta 80 já está em uso
Write-Host "Verificando disponibilidade da porta 80..." -ForegroundColor Yellow
$port80InUse = netstat -an | findstr ":80.*LISTENING"
if ($port80InUse) {
    Write-Host "ATENÇÃO: A porta 80 já está em uso!" -ForegroundColor Red
    Write-Host "Serviços usando a porta 80:" -ForegroundColor Yellow
    netstat -ano | findstr ":80.*LISTENING"
    Write-Host "Deseja continuar mesmo assim? (s/N)" -ForegroundColor Yellow
    $response = Read-Host
    if ($response -ne "s" -and $response -ne "S") {
        Write-Host "Operação cancelada pelo usuário." -ForegroundColor Yellow
        exit 1
    }
}

# Iniciar Nginx
Write-Host "Iniciando Nginx..." -ForegroundColor Yellow
try {
    Set-Location $nginxPath
    Start-Process "nginx.exe" -WindowStyle Hidden
    Start-Sleep -Seconds 2
    
    # Verificar se Nginx iniciou
    $nginxRunning = Get-Process | Where-Object {$_.ProcessName -eq "nginx"}
    $port80Running = netstat -an | findstr ":80"
    
    if ($nginxRunning -and $port80Running) {
        Write-Host "Nginx iniciado com sucesso!" -ForegroundColor Green
        Write-Host "Acesse: http://localhost" -ForegroundColor Cyan
        Write-Host "Ou pelo IP da máquina na rede local" -ForegroundColor Cyan
        Write-Host "Para parar tudo: .\stop-laravel-nginx.ps1" -ForegroundColor Yellow
    } else {
        Write-Host "Falha ao iniciar Nginx na porta 80. Verifique:" -ForegroundColor Red
        Write-Host "- Se está executando como Administrador" -ForegroundColor Yellow
        Write-Host "- Se a porta 80 não está sendo usada por outro serviço" -ForegroundColor Yellow
        Write-Host "- Logs em $nginxPath\logs\" -ForegroundColor Yellow
        exit 1
    }
} catch {
    Write-Host "Erro ao iniciar Nginx: $_" -ForegroundColor Red
    exit 1
}

Write-Host "`nAmbiente Laravel iniciado com sucesso!" -ForegroundColor Green
Write-Host "URL: http://localhost" -ForegroundColor Cyan
Write-Host "Nginx: Rodando na porta 80 (IP público 0.0.0.0)" -ForegroundColor White
Write-Host "PHP-CGI: Rodando na porta 9000" -ForegroundColor White