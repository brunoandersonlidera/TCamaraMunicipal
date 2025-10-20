# 💾 Guia de Backup - TCamaraMunicipal

## 📋 Índice
1. [Visão Geral](#visão-geral)
2. [Estratégias de Backup](#estratégias-de-backup)
3. [Backup do Banco de Dados](#backup-do-banco-de-dados)
4. [Backup de Arquivos](#backup-de-arquivos)
5. [Backup Automatizado](#backup-automatizado)
6. [Restauração](#restauração)
7. [Monitoramento](#monitoramento)
8. [Boas Práticas](#boas-práticas)

## 🎯 Visão Geral

### Importância do Backup
O sistema TCamaraMunicipal gerencia dados críticos da administração pública, incluindo:
- Informações de vereadores e funcionários
- Documentos legislativos
- Manifestações da ouvidoria
- Solicitações E-SIC
- Dados financeiros e de transparência

### Tipos de Backup
- **Completo**: Backup de todos os dados
- **Incremental**: Apenas dados alterados desde o último backup
- **Diferencial**: Dados alterados desde o último backup completo

### Frequência Recomendada
- **Banco de Dados**: Diário (automático)
- **Arquivos**: Semanal
- **Backup Completo**: Mensal
- **Teste de Restauração**: Trimestral

## 🗄️ Backup do Banco de Dados

### Backup Manual via MySQL
```bash
# Backup completo
mysqldump -u usuario -p tcamara_municipal > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup com compressão
mysqldump -u usuario -p tcamara_municipal | gzip > backup_$(date +%Y%m%d_%H%M%S).sql.gz

# Backup de tabelas específicas
mysqldump -u usuario -p tcamara_municipal vereadores sessoes_plenarias > backup_essencial.sql
```

### Backup via Laravel Artisan
```bash
# Comando customizado (se implementado)
php artisan backup:database

# Usando pacote spatie/laravel-backup
php artisan backup:run
php artisan backup:run --only-db
```

### Script de Backup Automatizado
```bash
#!/bin/bash
# backup_database.sh

# Configurações
DB_USER="usuario"
DB_PASS="senha"
DB_NAME="tcamara_municipal"
BACKUP_DIR="/var/backups/tcamara"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=30

# Criar diretório se não existir
mkdir -p $BACKUP_DIR

# Realizar backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# Verificar se backup foi criado
if [ $? -eq 0 ]; then
    echo "Backup realizado com sucesso: db_backup_$DATE.sql.gz"
    
    # Remover backups antigos
    find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +$RETENTION_DAYS -delete
    
    # Log do backup
    echo "$(date): Backup database realizado com sucesso" >> $BACKUP_DIR/backup.log
else
    echo "Erro ao realizar backup do banco de dados"
    echo "$(date): ERRO - Backup database falhou" >> $BACKUP_DIR/backup.log
fi
```

## 📁 Backup de Arquivos

### Estrutura de Arquivos Importantes
```
TCamaraMunicipal/
├── storage/app/           # Uploads e arquivos do sistema
├── public/uploads/        # Arquivos públicos
├── .env                   # Configurações
├── config/               # Configurações do sistema
└── database/             # Migrations e seeders
```

### Script de Backup de Arquivos
```bash
#!/bin/bash
# backup_files.sh

# Configurações
PROJECT_DIR="/var/www/tcamara"
BACKUP_DIR="/var/backups/tcamara"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=30

# Criar diretório se não existir
mkdir -p $BACKUP_DIR

# Backup de arquivos importantes
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz \
    -C $PROJECT_DIR \
    storage/app \
    public/uploads \
    .env \
    config

# Verificar se backup foi criado
if [ $? -eq 0 ]; then
    echo "Backup de arquivos realizado com sucesso: files_backup_$DATE.tar.gz"
    
    # Remover backups antigos
    find $BACKUP_DIR -name "files_backup_*.tar.gz" -mtime +$RETENTION_DAYS -delete
    
    # Log do backup
    echo "$(date): Backup arquivos realizado com sucesso" >> $BACKUP_DIR/backup.log
else
    echo "Erro ao realizar backup de arquivos"
    echo "$(date): ERRO - Backup arquivos falhou" >> $BACKUP_DIR/backup.log
fi
```

## 🤖 Backup Automatizado

### Configuração do Cron
```bash
# Editar crontab
crontab -e

# Adicionar tarefas de backup
# Backup diário do banco às 2:00
0 2 * * * /var/backups/scripts/backup_database.sh

# Backup semanal de arquivos aos domingos às 3:00
0 3 * * 0 /var/backups/scripts/backup_files.sh

# Backup completo mensal no primeiro dia do mês às 4:00
0 4 1 * * /var/backups/scripts/backup_complete.sh
```

### Usando Laravel Scheduler
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Backup diário do banco
    $schedule->command('backup:database')
             ->daily()
             ->at('02:00');
    
    // Backup semanal completo
    $schedule->command('backup:run')
             ->weekly()
             ->sundays()
             ->at('03:00');
    
    // Limpeza de backups antigos
    $schedule->command('backup:clean')
             ->daily()
             ->at('04:00');
}
```

### Comando Artisan Customizado
```php
// app/Console/Commands/BackupDatabase.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database {--compress}';
    protected $description = 'Backup do banco de dados';

    public function handle()
    {
        $this->info('Iniciando backup do banco de dados...');
        
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $compress = $this->option('compress');
        
        if ($compress) {
            $filename .= '.gz';
        }
        
        $command = sprintf(
            'mysqldump -u%s -p%s %s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            $compress ? '| gzip' : '',
            storage_path('backups/' . $filename)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            $this->info("Backup realizado com sucesso: {$filename}");
        } else {
            $this->error('Erro ao realizar backup');
        }
    }
}
```

## 🔄 Restauração

### Restauração do Banco de Dados
```bash
# Restaurar backup não comprimido
mysql -u usuario -p tcamara_municipal < backup_20250121_120000.sql

# Restaurar backup comprimido
gunzip < backup_20250121_120000.sql.gz | mysql -u usuario -p tcamara_municipal

# Restaurar com criação de novo banco
mysql -u usuario -p -e "CREATE DATABASE tcamara_municipal_restore;"
mysql -u usuario -p tcamara_municipal_restore < backup_20250121_120000.sql
```

### Restauração de Arquivos
```bash
# Extrair backup de arquivos
tar -xzf files_backup_20250121_120000.tar.gz -C /var/www/tcamara/

# Restaurar permissões
chown -R www-data:www-data /var/www/tcamara/storage
chmod -R 755 /var/www/tcamara/storage
```

### Script de Restauração Completa
```bash
#!/bin/bash
# restore.sh

BACKUP_FILE=$1
PROJECT_DIR="/var/www/tcamara"

if [ -z "$BACKUP_FILE" ]; then
    echo "Uso: $0 <arquivo_backup>"
    exit 1
fi

echo "Iniciando restauração..."

# Parar serviços
systemctl stop nginx
systemctl stop php8.2-fpm

# Restaurar banco de dados
echo "Restaurando banco de dados..."
gunzip < $BACKUP_FILE | mysql -u usuario -p tcamara_municipal

# Restaurar arquivos (se fornecido)
if [ -f "${BACKUP_FILE%.*}.tar.gz" ]; then
    echo "Restaurando arquivos..."
    tar -xzf "${BACKUP_FILE%.*}.tar.gz" -C $PROJECT_DIR
fi

# Ajustar permissões
chown -R www-data:www-data $PROJECT_DIR
chmod -R 755 $PROJECT_DIR/storage

# Limpar caches
cd $PROJECT_DIR
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Reiniciar serviços
systemctl start php8.2-fpm
systemctl start nginx

echo "Restauração concluída!"
```

## 📊 Monitoramento

### Verificação de Integridade
```bash
#!/bin/bash
# check_backup_integrity.sh

BACKUP_DIR="/var/backups/tcamara"
LOG_FILE="$BACKUP_DIR/integrity.log"

# Verificar backups do banco
for backup in $BACKUP_DIR/db_backup_*.sql.gz; do
    if [ -f "$backup" ]; then
        # Testar integridade do arquivo
        if gunzip -t "$backup" 2>/dev/null; then
            echo "$(date): OK - $backup" >> $LOG_FILE
        else
            echo "$(date): ERRO - $backup corrompido" >> $LOG_FILE
        fi
    fi
done

# Verificar backups de arquivos
for backup in $BACKUP_DIR/files_backup_*.tar.gz; do
    if [ -f "$backup" ]; then
        # Testar integridade do arquivo
        if tar -tzf "$backup" >/dev/null 2>&1; then
            echo "$(date): OK - $backup" >> $LOG_FILE
        else
            echo "$(date): ERRO - $backup corrompido" >> $LOG_FILE
        fi
    fi
done
```

### Notificações por Email
```php
// app/Console/Commands/BackupNotification.php
public function handle()
{
    $backupStatus = $this->checkBackupStatus();
    
    if (!$backupStatus['success']) {
        Mail::to(config('backup.notification_email'))
            ->send(new BackupFailedMail($backupStatus));
    }
}
```

## 🛡️ Boas Práticas

### Segurança
- **Criptografia**: Criptografar backups sensíveis
- **Acesso**: Restringir acesso aos arquivos de backup
- **Localização**: Armazenar backups em local seguro e separado
- **Teste**: Testar restauração regularmente

### Armazenamento
```bash
# Backup com criptografia
mysqldump -u usuario -p tcamara_municipal | gzip | gpg --cipher-algo AES256 --compress-algo 1 --symmetric --output backup_encrypted.sql.gz.gpg

# Backup para nuvem (AWS S3)
aws s3 cp backup_20250121.sql.gz s3://meu-bucket-backup/tcamara/
```

### Configuração de Retenção
```bash
# Política de retenção
# Diários: 7 dias
# Semanais: 4 semanas
# Mensais: 12 meses
# Anuais: 5 anos

# Script de limpeza
find /var/backups/tcamara/daily -mtime +7 -delete
find /var/backups/tcamara/weekly -mtime +28 -delete
find /var/backups/tcamara/monthly -mtime +365 -delete
```

### Checklist de Backup
- [ ] Backup automático configurado
- [ ] Testes de restauração realizados
- [ ] Monitoramento ativo
- [ ] Notificações configuradas
- [ ] Documentação atualizada
- [ ] Acesso seguro aos backups
- [ ] Política de retenção definida
- [ ] Backup offsite configurado

## 🚨 Recuperação de Desastres

### Plano de Contingência
1. **Identificação do Problema**
2. **Avaliação do Impacto**
3. **Decisão de Restauração**
4. **Execução da Restauração**
5. **Verificação da Integridade**
6. **Comunicação aos Usuários**

### Cenários de Recuperação
- **Corrupção de Dados**: Restaurar backup mais recente
- **Falha de Hardware**: Migrar para novo servidor
- **Ataque Malicioso**: Restaurar backup limpo anterior
- **Erro Humano**: Restauração seletiva de dados

## 📞 Suporte

Para suporte com backup e recuperação:
- **Email**: backup@lideratecnologia.com.br
- **WhatsApp**: (65) 99920-5608
- **Emergência**: Disponível 24/7

---

**Última atualização**: Janeiro 2025  
**Versão**: 1.0.0