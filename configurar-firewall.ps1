# Script para configurar Firewall do Windows para Laravel/Nginx na porta 80
Write-Host "Configurando Firewall do Windows para Laravel/Nginx..." -ForegroundColor Green

# Verificar se está executando como Administrador
$currentUser = [Security.Principal.WindowsIdentity]::GetCurrent()
$principal = New-Object Security.Principal.WindowsPrincipal($currentUser)
$isAdmin = $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "ERRO: Este script deve ser executado como Administrador!" -ForegroundColor Red
    Write-Host "Clique com botão direito no PowerShell e selecione 'Executar como administrador'" -ForegroundColor Yellow
    exit 1
}

Write-Host "Criando regras de firewall..." -ForegroundColor Yellow

try {
    # Remover regras existentes (se houver)
    Write-Host "Removendo regras existentes..." -ForegroundColor Yellow
    netsh advfirewall firewall delete rule name="Laravel Nginx HTTP" 2>$null
    netsh advfirewall firewall delete rule name="Laravel PHP-CGI" 2>$null
    
    # Criar regra para HTTP (porta 80) - Entrada
    Write-Host "Criando regra para HTTP (porta 80)..." -ForegroundColor Yellow
    netsh advfirewall firewall add rule name="Laravel Nginx HTTP" dir=in action=allow protocol=TCP localport=80
    
    # Criar regra para PHP-CGI (porta 9000) - apenas local
    Write-Host "Criando regra para PHP-CGI (porta 9000)..." -ForegroundColor Yellow
    netsh advfirewall firewall add rule name="Laravel PHP-CGI" dir=in action=allow protocol=TCP localport=9000 remoteip=127.0.0.1
    
    Write-Host "Regras de firewall criadas com sucesso!" -ForegroundColor Green
    Write-Host "- Porta 80: Aberta para conexões externas (HTTP)" -ForegroundColor White
    Write-Host "- Porta 9000: Aberta apenas para localhost (PHP-CGI)" -ForegroundColor White
    
} catch {
    Write-Host "Erro ao configurar firewall: $_" -ForegroundColor Red
    Write-Host "Tente executar manualmente:" -ForegroundColor Yellow
    Write-Host "netsh advfirewall firewall add rule name=`"Laravel Nginx HTTP`" dir=in action=allow protocol=TCP localport=80" -ForegroundColor White
    exit 1
}

Write-Host "`nConfiguração concluída!" -ForegroundColor Green
Write-Host "Agora você pode executar: .\start-laravel-nginx.ps1" -ForegroundColor Cyan