# Guia de Deploy - TCamaraMunicipal

## Visão Geral

Este guia detalha o processo completo de deploy do sistema TCamaraMunicipal em ambiente de produção, incluindo configurações de servidor, banco de dados, segurança e monitoramento.

## Pré-requisitos

### Servidor de Produção

#### Especificações Mínimas
- **CPU:** 2 cores (recomendado: 4 cores)
- **RAM:** 4GB (recomendado: 8GB)
- **Armazenamento:** 50GB SSD (recomendado: 100GB)
- **Largura de banda:** 100 Mbps

#### Sistema Operacional
- Ubuntu 22.04 LTS (recomendado)
- CentOS 8/9
- Debian 11/12
- Windows Server 2019/2022

#### Software Necessário
- **PHP:** 8.2 ou superior
- **Servidor Web:** Apache 2.4+ ou Nginx 1.18+
- **Banco de Dados:** MySQL 8.0+ ou MariaDB 10.6+
- **Node.js:** 18+ (para compilação de assets)
- **Composer:** 2.0+
- **Git:** Para deploy automatizado

## Preparação do Ambiente

### 1. Configuração do Servidor (Ubuntu 22.04)

```bash
# Atualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar dependências básicas
sudo apt install -y software-properties-common curl wget unzip git

# Adicionar repositório PHP
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Instalar PHP e extensões
sudo apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl \
    php8.2-gd php8.2-mbstring php8.2-zip php8.2-intl php8.2-bcmath \
    php8.2-soap php8.2-redis php8.2-imagick

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2. Configuração do MySQL

```bash
# Instalar MySQL
sudo apt install -y mysql-server

# Configurar MySQL
sudo mysql_secure_installation

# Criar banco de dados e usuário
sudo mysql -u root -p
```

```sql
CREATE DATABASE tcamara_municipal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'tcamara_user'@'localhost' IDENTIFIED BY 'senha_segura_aqui';
GRANT ALL PRIVILEGES ON tcamara_municipal.* TO 'tcamara_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Configuração do Apache

```bash
# Instalar Apache
sudo apt install -y apache2

# Habilitar módulos necessários
sudo a2enmod rewrite ssl headers

# Criar virtual host
sudo nano /etc/apache2/sites-available/tcamara.conf
```

```apache
<VirtualHost *:80>
    ServerName seu-dominio.com.br
    ServerAlias www.seu-dominio.com.br
    DocumentRoot /var/www/tcamara/public
    
    <Directory /var/www/tcamara/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/tcamara_error.log
    CustomLog ${APACHE_LOG_DIR}/tcamara_access.log combined
    
    # Redirecionamento para HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

<VirtualHost *:443>
    ServerName seu-dominio.com.br
    ServerAlias www.seu-dominio.com.br
    DocumentRoot /var/www/tcamara/public
    
    <Directory /var/www/tcamara/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    # Configurações SSL (será configurado com Certbot)
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/seu-dominio.com.br/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/seu-dominio.com.br/privkey.pem
    
    # Headers de segurança
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    
    ErrorLog ${APACHE_LOG_DIR}/tcamara_ssl_error.log
    CustomLog ${APACHE_LOG_DIR}/tcamara_ssl_access.log combined
</VirtualHost>
```

```bash
# Habilitar site e desabilitar default
sudo a2ensite tcamara.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

## Deploy da Aplicação

### 1. Preparação do Diretório

```bash
# Criar diretório da aplicação
sudo mkdir -p /var/www/tcamara
sudo chown -R www-data:www-data /var/www/tcamara

# Clonar repositório (como www-data)
sudo -u www-data git clone https://github.com/seu-usuario/TCamaraMunicipal.git /var/www/tcamara
cd /var/www/tcamara
```

### 2. Configuração da Aplicação

```bash
# Instalar dependências PHP
sudo -u www-data composer install --no-dev --optimize-autoloader

# Instalar dependências Node.js
sudo -u www-data npm ci --production

# Compilar assets para produção
sudo -u www-data npm run build

# Copiar arquivo de configuração
sudo -u www-data cp .env.example .env
```

### 3. Configuração do .env

```bash
sudo -u www-data nano .env
```

```env
# Configurações básicas
APP_NAME="TCâmara Municipal"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br

# Banco de dados
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tcamara_municipal
DB_USERNAME=tcamara_user
DB_PASSWORD=senha_segura_aqui

# Cache e sessões
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Email (configurar conforme provedor)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seu-dominio.com.br
MAIL_FROM_NAME="${APP_NAME}"

# Filesystem
FILESYSTEM_DISK=public

# Logs
LOG_CHANNEL=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Configurações de segurança
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# Configurações específicas da aplicação
BACKUP_ENABLED=true
BACKUP_SCHEDULE="0 2 * * *"
MAINTENANCE_MODE=false
```

### 4. Finalização da Configuração

```bash
# Gerar chave da aplicação
sudo -u www-data php artisan key:generate

# Executar migrations
sudo -u www-data php artisan migrate --force

# Executar seeders (se necessário)
sudo -u www-data php artisan db:seed --force

# Criar link simbólico para storage
sudo -u www-data php artisan storage:link

# Limpar e otimizar cache
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan event:cache

# Configurar permissões
sudo chown -R www-data:www-data /var/www/tcamara
sudo chmod -R 755 /var/www/tcamara
sudo chmod -R 775 /var/www/tcamara/storage
sudo chmod -R 775 /var/www/tcamara/bootstrap/cache
```

## Configuração de SSL/HTTPS

### Usando Certbot (Let's Encrypt)

```bash
# Instalar Certbot
sudo apt install -y certbot python3-certbot-apache

# Obter certificado SSL
sudo certbot --apache -d seu-dominio.com.br -d www.seu-dominio.com.br

# Configurar renovação automática
sudo crontab -e
```

Adicionar linha no crontab:
```
0 12 * * * /usr/bin/certbot renew --quiet
```

## Configuração de Cache (Redis)

```bash
# Instalar Redis
sudo apt install -y redis-server

# Configurar Redis
sudo nano /etc/redis/redis.conf
```

Configurações importantes:
```
# Bind apenas localhost para segurança
bind 127.0.0.1

# Configurar senha (opcional mas recomendado)
requirepass sua_senha_redis_aqui

# Configurar persistência
save 900 1
save 300 10
save 60 10000
```

```bash
# Reiniciar Redis
sudo systemctl restart redis-server
sudo systemctl enable redis-server
```

## Configuração de Backup

### 1. Script de Backup

```bash
sudo nano /usr/local/bin/backup-tcamara.sh
```

```bash
#!/bin/bash

# Configurações
APP_DIR="/var/www/tcamara"
BACKUP_DIR="/var/backups/tcamara"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="tcamara_municipal"
DB_USER="tcamara_user"
DB_PASS="senha_segura_aqui"

# Criar diretório de backup
mkdir -p $BACKUP_DIR

# Backup do banco de dados
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/database_$DATE.sql

# Backup dos arquivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz -C $APP_DIR storage/app/public

# Backup da configuração
cp $APP_DIR/.env $BACKUP_DIR/env_$DATE.backup

# Remover backups antigos (manter últimos 7 dias)
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
find $BACKUP_DIR -name "*.backup" -mtime +7 -delete

echo "Backup concluído: $DATE"
```

```bash
# Tornar executável
sudo chmod +x /usr/local/bin/backup-tcamara.sh

# Configurar cron para backup diário
sudo crontab -e
```

Adicionar linha:
```
0 2 * * * /usr/local/bin/backup-tcamara.sh >> /var/log/backup-tcamara.log 2>&1
```

## Monitoramento

### 1. Logs do Sistema

```bash
# Configurar logrotate para logs da aplicação
sudo nano /etc/logrotate.d/tcamara
```

```
/var/www/tcamara/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
    postrotate
        /bin/systemctl reload apache2 > /dev/null 2>&1 || true
    endscript
}
```

### 2. Monitoramento de Performance

```bash
# Instalar htop para monitoramento
sudo apt install -y htop iotop

# Configurar monitoramento de espaço em disco
sudo nano /usr/local/bin/check-disk-space.sh
```

```bash
#!/bin/bash
THRESHOLD=80
USAGE=$(df / | grep -vE '^Filesystem|tmpfs|cdrom' | awk '{ print $5 }' | sed 's/%//g')

if [ $USAGE -gt $THRESHOLD ]; then
    echo "ALERTA: Uso de disco em ${USAGE}%" | mail -s "Alerta de Espaço em Disco" admin@seu-dominio.com.br
fi
```

## Deploy Automatizado

### 1. Script de Deploy

```bash
sudo nano /usr/local/bin/deploy-tcamara.sh
```

```bash
#!/bin/bash

APP_DIR="/var/www/tcamara"
BACKUP_DIR="/var/backups/tcamara"
DATE=$(date +%Y%m%d_%H%M%S)

echo "Iniciando deploy: $DATE"

# Entrar no diretório da aplicação
cd $APP_DIR

# Fazer backup antes do deploy
echo "Criando backup..."
/usr/local/bin/backup-tcamara.sh

# Colocar aplicação em modo de manutenção
sudo -u www-data php artisan down --message="Sistema em atualização. Voltamos em breve."

# Atualizar código
echo "Atualizando código..."
sudo -u www-data git pull origin main

# Atualizar dependências
echo "Atualizando dependências..."
sudo -u www-data composer install --no-dev --optimize-autoloader

# Atualizar assets
echo "Compilando assets..."
sudo -u www-data npm ci --production
sudo -u www-data npm run build

# Executar migrations
echo "Executando migrations..."
sudo -u www-data php artisan migrate --force

# Limpar cache
echo "Limpando cache..."
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan cache:clear

# Recriar cache
echo "Recriando cache..."
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Configurar permissões
sudo chown -R www-data:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage
sudo chmod -R 775 $APP_DIR/bootstrap/cache

# Tirar aplicação do modo de manutenção
sudo -u www-data php artisan up

echo "Deploy concluído: $DATE"
```

```bash
# Tornar executável
sudo chmod +x /usr/local/bin/deploy-tcamara.sh
```

### 2. Deploy via Git Hooks (Opcional)

```bash
# No servidor, configurar hook post-receive
cd /var/www/tcamara/.git/hooks
sudo nano post-receive
```

```bash
#!/bin/bash
cd /var/www/tcamara
/usr/local/bin/deploy-tcamara.sh
```

## Configurações de Segurança

### 1. Firewall (UFW)

```bash
# Configurar firewall
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 'Apache Full'
sudo ufw enable
```

### 2. Fail2Ban

```bash
# Instalar Fail2Ban
sudo apt install -y fail2ban

# Configurar para Apache
sudo nano /etc/fail2ban/jail.local
```

```ini
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 5

[apache-auth]
enabled = true
port = http,https
filter = apache-auth
logpath = /var/log/apache2/*error.log
maxretry = 3

[apache-badbots]
enabled = true
port = http,https
filter = apache-badbots
logpath = /var/log/apache2/*access.log
maxretry = 2

[apache-noscript]
enabled = true
port = http,https
filter = apache-noscript
logpath = /var/log/apache2/*access.log
maxretry = 6
```

```bash
sudo systemctl restart fail2ban
```

### 3. Configurações PHP de Produção

```bash
sudo nano /etc/php/8.2/fpm/php.ini
```

```ini
# Configurações de segurança
expose_php = Off
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

# Configurações de performance
memory_limit = 256M
max_execution_time = 60
max_input_time = 60
upload_max_filesize = 10M
post_max_size = 10M

# Configurações de sessão
session.cookie_secure = 1
session.cookie_httponly = 1
session.use_strict_mode = 1
```

## Otimização de Performance

### 1. Configuração do OPcache

```bash
sudo nano /etc/php/8.2/fpm/conf.d/10-opcache.ini
```

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
opcache.enable_cli=1
opcache.validate_timestamps=0
```

### 2. Configuração do Apache para Performance

```bash
sudo nano /etc/apache2/mods-available/deflate.conf
```

```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>
```

```bash
sudo a2enmod deflate expires headers
sudo systemctl restart apache2
```

## Troubleshooting

### Problemas Comuns

1. **Erro 500 - Internal Server Error**
   ```bash
   # Verificar logs
   sudo tail -f /var/log/apache2/tcamara_error.log
   sudo tail -f /var/www/tcamara/storage/logs/laravel.log
   
   # Verificar permissões
   sudo chown -R www-data:www-data /var/www/tcamara
   sudo chmod -R 775 /var/www/tcamara/storage
   ```

2. **Erro de Conexão com Banco de Dados**
   ```bash
   # Testar conexão
   mysql -u tcamara_user -p tcamara_municipal
   
   # Verificar configurações no .env
   grep DB_ /var/www/tcamara/.env
   ```

3. **Assets não carregam**
   ```bash
   # Recompilar assets
   cd /var/www/tcamara
   sudo -u www-data npm run build
   sudo -u www-data php artisan storage:link
   ```

4. **Cache não funciona**
   ```bash
   # Verificar Redis
   redis-cli ping
   
   # Limpar cache
   sudo -u www-data php artisan cache:clear
   sudo -u www-data php artisan config:clear
   ```

### Comandos Úteis

```bash
# Status dos serviços
sudo systemctl status apache2
sudo systemctl status mysql
sudo systemctl status redis-server

# Logs em tempo real
sudo tail -f /var/log/apache2/tcamara_error.log
sudo tail -f /var/www/tcamara/storage/logs/laravel.log

# Verificar uso de recursos
htop
df -h
free -h

# Testar configuração do Apache
sudo apache2ctl configtest

# Recarregar configurações
sudo systemctl reload apache2
sudo systemctl restart php8.2-fpm
```

## Checklist de Deploy

### Pré-Deploy
- [ ] Backup do banco de dados atual
- [ ] Backup dos arquivos de configuração
- [ ] Verificar espaço em disco disponível
- [ ] Notificar usuários sobre manutenção

### Durante o Deploy
- [ ] Ativar modo de manutenção
- [ ] Atualizar código fonte
- [ ] Instalar/atualizar dependências
- [ ] Executar migrations
- [ ] Compilar assets
- [ ] Limpar e recriar cache
- [ ] Verificar permissões de arquivos

### Pós-Deploy
- [ ] Desativar modo de manutenção
- [ ] Testar funcionalidades principais
- [ ] Verificar logs de erro
- [ ] Monitorar performance
- [ ] Confirmar funcionamento do backup

## Manutenção Contínua

### Tarefas Diárias
- Verificar logs de erro
- Monitorar uso de recursos
- Verificar status dos backups

### Tarefas Semanais
- Atualizar sistema operacional
- Verificar certificados SSL
- Analisar logs de acesso

### Tarefas Mensais
- Atualizar dependências PHP
- Revisar configurações de segurança
- Testar procedimentos de restore

## Suporte

Para problemas durante o deploy:
1. Consulte os logs do sistema
2. Verifique a documentação do Laravel
3. Entre em contato com a equipe de desenvolvimento
4. Mantenha backups sempre atualizados

---

**Última atualização:** 21 de Janeiro de 2025  
**Versão:** 1.0  
**Compatibilidade:** Ubuntu 22.04, Apache 2.4, PHP 8.2, MySQL 8.0