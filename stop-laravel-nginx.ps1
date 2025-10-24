# Script para parar Laravel com Nginx + PHP-CGI
Write-Host "Parando ambiente Laravel..." -ForegroundColor Yellow

$nginxPath = "C:\nginx-1.28.0"

# Parar Nginx
Write-Host "Parando Nginx..." -ForegroundColor Yellow
try {
    Set-Location $nginxPath
    .\nginx.exe -s quit
    Start-Sleep -Seconds 2
    Write-Host "Nginx parado com sucesso!" -ForegroundColor Green
} catch {
    Write-Host "Erro ao parar Nginx: $_" -ForegroundColor Red
    
    # Tentar forcar parada
    $nginxProcess = Get-Process | Where-Object {$_.ProcessName -eq "nginx"}
    if ($nginxProcess) {
        try {
            $nginxProcess | Stop-Process -Force
            Write-Host "Nginx forcado a parar" -ForegroundColor Yellow
        } catch {
            Write-Host "Erro ao forcar parada do Nginx: $_" -ForegroundColor Red
        }
    }
}

# Parar PHP-CGI
Write-Host "Parando PHP-CGI..." -ForegroundColor Yellow
try {
    $phpProcess = Get-Process | Where-Object {$_.ProcessName -like "*php*"}
    if ($phpProcess) {
        $phpProcess | Stop-Process -Force
        Write-Host "PHP-CGI parado com sucesso!" -ForegroundColor Green
    } else {
        Write-Host "PHP-CGI nao estava rodando" -ForegroundColor Yellow
    }
} catch {
    Write-Host "Erro ao parar PHP-CGI: $_" -ForegroundColor Red
}

Write-Host "`nAmbiente Laravel parado!" -ForegroundColor Green
Write-Host "Para iniciar novamente: .\start-laravel-nginx.ps1" -ForegroundColor Cyan