# 🚀 Guia de Instalação - Sistema TCamaraMunicipal

**Versão**: Laravel 12.0  
**PHP**: 8.2+  
**Banco de Dados**: SQLite (desenvolvimento) / MySQL (produção)  
**Data**: Janeiro 2025  

---

## 📋 Pré-requisitos

### 🖥️ **Requisitos do Sistema**
- **PHP**: 8.2 ou superior
- **Composer**: 2.0 ou superior
- **Node.js**: 18.0 ou superior
- **NPM**: 8.0 ou superior
- **Git**: Para controle de versão

### 🔧 **Extensões PHP Necessárias**
```bash
# Extensões obrigatórias
php-mbstring
php-xml
php-curl
php-zip
php-gd
php-sqlite3 (para desenvolvimento)
php-mysql (para produção)
php-bcmath
php-json
php-openssl
php-pdo
php-tokenizer
php-fileinfo
```

### 🗄️ **Banco de Dados**
- **Desenvolvimento**: SQLite (incluído)
- **Produção**: MySQL 8.0+ ou MariaDB 10.3+

---

## 🛠️ Instalação Local (Desenvolvimento)

### 1️⃣ **Clone do Repositório**
```bash
# Clone o repositório
git clone https://github.com/brunoandersonlidera/TCamaraMunicipal.git

# Entre no diretório
cd TCamaraMunicipal
```

### 2️⃣ **Instalação das Dependências**
```bash
# Instalar dependências PHP
composer install

# Instalar dependências Node.js
npm install
```

### 3️⃣ **Configuração do Ambiente**
```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4️⃣ **Configuração do Arquivo .env**
```env
# Configurações básicas
APP_NAME="TCamaraMunicipal"
APP_ENV=local
APP_KEY=base64:CHAVE_GERADA_AUTOMATICAMENTE
APP_DEBUG=true
APP_URL=http://localhost:8000

# Banco de dados (SQLite para desenvolvimento)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Cache e sessão
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Email (configurar conforme necessário)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Configurações da Câmara
CAMARA_NOME="Câmara Municipal"
CAMARA_CIDADE="Sua Cidade"
CAMARA_UF="UF"
CAMARA_ENDERECO="Endereço da Câmara"
CAMARA_TELEFONE="(00) 0000-0000"
CAMARA_EMAIL="contato@camara.gov.br"
```

### 5️⃣ **Preparação do Banco de Dados**
```bash
# Criar arquivo do banco SQLite
touch database/database.sqlite

# Executar migrations
php artisan migrate

# Executar seeders (dados iniciais)
php artisan db:seed
```

### 6️⃣ **Configuração de Permissões**
```bash
# Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 public/storage

# Windows (PowerShell como Administrador)
icacls storage /grant Everyone:F /T
icacls bootstrap\cache /grant Everyone:F /T
icacls public\storage /grant Everyone:F /T
```

### 7️⃣ **Link Simbólico para Storage**
```bash
php artisan storage:link
```

### 8️⃣ **Compilação dos Assets**
```bash
# Desenvolvimento
npm run dev

# Ou para watch (recompila automaticamente)
npm run watch

# Produção
npm run build
```

### 9️⃣ **Iniciar o Servidor**
```bash
# Servidor de desenvolvimento
php artisan serve

# Ou especificar host e porta
php artisan serve --host=0.0.0.0 --port=8000
```

### 🎉 **Acesso ao Sistema**
- **URL**: http://localhost:8000
- **Admin**: admin@camara.gov.br / admin123
- **Secretário**: secretario@camara.gov.br / secretario123

---

## 🏭 Instalação em Produção

### 1️⃣ **Preparação do Servidor**
```bash
# Atualizar sistema (Ubuntu/Debian)
sudo apt update && sudo apt upgrade -y

# Instalar PHP 8.2 e extensões
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-mbstring php8.2-bcmath php8.2-json php8.2-openssl

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### 2️⃣ **Configuração do MySQL**
```sql
-- Criar banco de dados
CREATE DATABASE tcamara_municipal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Criar usuário
CREATE USER 'tcamara_user'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT ALL PRIVILEGES ON tcamara_municipal.* TO 'tcamara_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3️⃣ **Deploy da Aplicação**
```bash
# Clone no servidor
git clone https://github.com/brunoandersonlidera/TCamaraMunicipal.git /var/www/tcamara

# Entrar no diretório
cd /var/www/tcamara

# Instalar dependências (sem dev)
composer install --no-dev --optimize-autoloader

# Instalar dependências Node.js
npm ci --production

# Compilar assets para produção
npm run build
```

### 4️⃣ **Configuração do .env (Produção)**
```env
APP_NAME="TCamaraMunicipal"
APP_ENV=production
APP_KEY=base64:CHAVE_GERADA
APP_DEBUG=false
APP_URL=https://camara.suacidade.gov.br

# Banco de dados MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tcamara_municipal
DB_USERNAME=tcamara_user
DB_PASSWORD=senha_segura

# Cache e sessão (Redis recomendado)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Email produção
MAIL_MAILER=smtp
MAIL_HOST=smtp.servidor.com
MAIL_PORT=587
MAIL_USERNAME=sistema@camara.gov.br
MAIL_PASSWORD=senha_email
MAIL_ENCRYPTION=tls
```

### 5️⃣ **Configuração de Permissões (Produção)**
```bash
# Definir proprietário
sudo chown -R www-data:www-data /var/www/tcamara

# Definir permissões
sudo find /var/www/tcamara -type f -exec chmod 644 {} \;
sudo find /var/www/tcamara -type d -exec chmod 755 {} \;

# Permissões especiais
sudo chmod -R 775 /var/www/tcamara/storage
sudo chmod -R 775 /var/www/tcamara/bootstrap/cache
```

### 6️⃣ **Configuração do Apache/Nginx**

#### **Apache Virtual Host**
```apache
<VirtualHost *:80>
    ServerName camara.suacidade.gov.br
    DocumentRoot /var/www/tcamara/public
    
    <Directory /var/www/tcamara/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/tcamara_error.log
    CustomLog ${APACHE_LOG_DIR}/tcamara_access.log combined
</VirtualHost>
```

#### **Nginx Virtual Host**
```nginx
server {
    listen 80;
    server_name camara.suacidade.gov.br;
    root /var/www/tcamara/public;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

### 7️⃣ **SSL/HTTPS (Certbot)**
```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-apache

# Obter certificado
sudo certbot --apache -d camara.suacidade.gov.br

# Renovação automática
sudo crontab -e
# Adicionar: 0 12 * * * /usr/bin/certbot renew --quiet
```

---

## 🔧 Comandos Úteis

### **Laravel Artisan**
```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Otimizar para produção
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh --seed

# Filas (se usar)
php artisan queue:work
php artisan queue:restart
```

### **Composer**
```bash
# Atualizar dependências
composer update

# Instalar nova dependência
composer require pacote/nome

# Autoload otimizado
composer dump-autoload --optimize
```

### **NPM**
```bash
# Instalar dependências
npm install

# Desenvolvimento
npm run dev
npm run watch

# Produção
npm run build
```

---

## 🐛 Troubleshooting

### **Problemas Comuns**

#### **Erro de Permissão**
```bash
# Verificar permissões
ls -la storage/
ls -la bootstrap/cache/

# Corrigir permissões
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

#### **Erro de Chave da Aplicação**
```bash
# Gerar nova chave
php artisan key:generate
```

#### **Erro de Storage Link**
```bash
# Remover link existente
rm public/storage

# Criar novo link
php artisan storage:link
```

#### **Erro de Banco de Dados**
```bash
# Verificar conexão
php artisan tinker
DB::connection()->getPdo();

# Recriar banco
php artisan migrate:fresh --seed
```

#### **Erro de Composer**
```bash
# Limpar cache do Composer
composer clear-cache

# Reinstalar dependências
rm -rf vendor/
composer install
```

### **Logs de Erro**
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Apache logs
tail -f /var/log/apache2/error.log

# Nginx logs
tail -f /var/log/nginx/error.log
```

---

## 📞 Suporte

### **Contatos**
- **Desenvolvedor**: Bruno Anderson Lidera
- **Email**: bruno@lidera.srv.br
- **GitHub**: https://github.com/brunoandersonlidera/TCamaraMunicipal

### **Recursos Úteis**
- **Documentação Laravel**: https://laravel.com/docs
- **Documentação PHP**: https://www.php.net/docs.php
- **Stack Overflow**: Para dúvidas técnicas

---

**Status**: ✅ Guia Completo  
**Última Atualização**: Janeiro 2025  
**Versão**: 1.0  

---

*Este guia fornece instruções completas para instalação e configuração do sistema TCamaraMunicipal em ambientes de desenvolvimento e produção.*