# Script de Deploy para Hostinger
$password = "L1d3r@t3cn0l0g1@"
$sshHost = "u700101648@82.180.159.124"
$sshPort = "65002"
$projectPath = "/home/u700101648/domains/lidera.srv.br/public_html/camara"

Write-Host "🚀 Iniciando deploy para Hostinger..." -ForegroundColor Green

# Comandos para executar no servidor
$commands = @(
    "cd /home/u700101648/domains/lidera.srv.br/public_html/",
    "if [ -d 'camara' ]; then mv camara camara_backup_$(date +%Y%m%d_%H%M%S); fi",
    "git clone https://github.com/brunoandersonlidera/TCamaraMunicipal.git camara",
    "cd camara",
    "cp ../camara_backup_*/\.env . 2>/dev/null || echo 'Arquivo .env não encontrado no backup'",
    "php artisan cache:clear",
    "php artisan config:clear",
    "php artisan migrate --force",
    "php artisan db:seed --force",
    "chmod -R 755 storage bootstrap/cache",
    "ls -la"
)

# Executar comandos via SSH
foreach ($cmd in $commands) {
    Write-Host "Executando: $cmd" -ForegroundColor Yellow
    $sshCommand = "ssh -p $sshPort -o StrictHostKeyChecking=no $sshHost `"$cmd`""
    
    # Usar plink se disponível, senão usar ssh padrão
    try {
        if (Get-Command plink -ErrorAction SilentlyContinue) {
            echo $password | plink -ssh -P $sshPort -pw $password $sshHost $cmd
        } else {
            # Fallback para ssh padrão
            Invoke-Expression $sshCommand
        }
    } catch {
        Write-Host "Erro ao executar comando: $_" -ForegroundColor Red
    }
}

Write-Host "✅ Deploy concluído!" -ForegroundColor Green