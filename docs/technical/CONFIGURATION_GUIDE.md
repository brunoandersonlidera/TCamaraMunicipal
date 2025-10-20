# 🔧 Guia de Configuração - TCamaraMunicipal

## 📋 Índice
1. [Configurações Básicas](#configurações-básicas)
2. [Configurações de Banco de Dados](#configurações-de-banco-de-dados)
3. [Configurações de Email](#configurações-de-email)
4. [Configurações de Cache](#configurações-de-cache)
5. [Configurações de Segurança](#configurações-de-segurança)
6. [Configurações de Upload](#configurações-de-upload)
7. [Configurações de Performance](#configurações-de-performance)
8. [Configurações Específicas do Sistema](#configurações-específicas-do-sistema)

## 🚀 Configurações Básicas

### Arquivo .env
O arquivo `.env` contém as configurações principais do sistema:

```env
# Configurações da Aplicação
APP_NAME="TCamaraMunicipal"
APP_ENV=production
APP_KEY=base64:sua_chave_aqui
APP_DEBUG=false
APP_URL=https://seudominio.com.br

# Configurações de Timezone
APP_TIMEZONE=America/Cuiaba

# Configurações de Locale
APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
```

### Configurações de Ambiente
- **Desenvolvimento**: `APP_ENV=local`, `APP_DEBUG=true`
- **Produção**: `APP_ENV=production`, `APP_DEBUG=false`
- **Teste**: `APP_ENV=testing`, `APP_DEBUG=true`

## 🗄️ Configurações de Banco de Dados

### MySQL (Recomendado)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tcamara_municipal
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### Configurações Avançadas de Banco
```env
# Pool de Conexões
DB_POOL_MIN=5
DB_POOL_MAX=20

# Timeout
DB_TIMEOUT=60

# Charset
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

## 📧 Configurações de Email

### SMTP
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=sua_senha_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@camara.gov.br
MAIL_FROM_NAME="Câmara Municipal"
```

### Configurações Específicas
```env
# Templates de Email
MAIL_TEMPLATE_OUVIDORIA=emails.ouvidoria
MAIL_TEMPLATE_ESIC=emails.esic
MAIL_TEMPLATE_NOTIFICACAO=emails.notificacao

# Limites de Email
MAIL_DAILY_LIMIT=1000
MAIL_HOURLY_LIMIT=100
```

## 🚀 Configurações de Cache

### Redis (Recomendado para Produção)
```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
```

### File Cache (Desenvolvimento)
```env
CACHE_DRIVER=file
```

### Configurações de Session
```env
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_PATH=/
SESSION_DOMAIN=null
```

## 🔒 Configurações de Segurança

### Autenticação
```env
# JWT (se implementado)
JWT_SECRET=sua_chave_jwt_secreta
JWT_TTL=60

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1,seudominio.com.br
```

### CORS
```env
# Configurações CORS
CORS_ALLOWED_ORIGINS=https://seudominio.com.br
CORS_ALLOWED_METHODS=GET,POST,PUT,DELETE,OPTIONS
CORS_ALLOWED_HEADERS=Content-Type,Authorization,X-Requested-With
```

### Rate Limiting
```env
# Limites de Taxa
RATE_LIMIT_API=60
RATE_LIMIT_WEB=1000
RATE_LIMIT_LOGIN=5
```

## 📁 Configurações de Upload

### Armazenamento de Arquivos
```env
FILESYSTEM_DISK=local
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### Limites de Upload
```env
# Tamanhos máximos (em MB)
MAX_FILE_SIZE=10
MAX_IMAGE_SIZE=5
MAX_DOCUMENT_SIZE=20

# Tipos permitidos
ALLOWED_IMAGE_TYPES=jpg,jpeg,png,gif,webp
ALLOWED_DOCUMENT_TYPES=pdf,doc,docx,xls,xlsx
```

## ⚡ Configurações de Performance

### Queue (Filas)
```env
QUEUE_CONNECTION=redis
QUEUE_FAILED_DRIVER=database-uuids
```

### Otimizações
```env
# Configurações de Performance
VIEW_CACHE_ENABLED=true
ROUTE_CACHE_ENABLED=true
CONFIG_CACHE_ENABLED=true

# Compressão
RESPONSE_COMPRESSION=true
ASSET_COMPRESSION=true
```

## 🏛️ Configurações Específicas do Sistema

### Câmara Municipal
```env
# Informações da Câmara
CAMARA_NOME="Câmara Municipal de Sua Cidade"
CAMARA_CNPJ="00.000.000/0001-00"
CAMARA_ENDERECO="Endereço da Câmara"
CAMARA_TELEFONE="(65) 0000-0000"
CAMARA_EMAIL="contato@camara.gov.br"
CAMARA_SITE="https://camara.gov.br"

# Configurações de Sessões
SESSAO_DURACAO_PADRAO=120
SESSAO_QUORUM_MINIMO=50

# Portal da Transparência
TRANSPARENCIA_ATIVO=true
TRANSPARENCIA_ATUALIZACAO_AUTOMATICA=true
TRANSPARENCIA_PERIODO_ATUALIZACAO=daily
```

### Ouvidoria
```env
# Configurações da Ouvidoria
OUVIDORIA_ATIVA=true
OUVIDORIA_PRAZO_RESPOSTA=20
OUVIDORIA_EMAIL_NOTIFICACAO=ouvidoria@camara.gov.br
OUVIDORIA_ANONIMA_PERMITIDA=true
```

### E-SIC
```env
# Configurações do E-SIC
ESIC_ATIVO=true
ESIC_PRAZO_RESPOSTA=20
ESIC_PRAZO_RECURSO=10
ESIC_EMAIL_NOTIFICACAO=esic@camara.gov.br
```

## 🔧 Comandos de Configuração

### Aplicar Configurações
```bash
# Limpar caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Recriar caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Otimizar para produção
php artisan optimize
```

### Verificar Configurações
```bash
# Verificar configuração atual
php artisan config:show

# Verificar conexão com banco
php artisan migrate:status

# Verificar configurações de email
php artisan tinker
>>> Mail::raw('Teste', function($msg) { $msg->to('teste@email.com')->subject('Teste'); });
```

## 🚨 Configurações de Monitoramento

### Logs
```env
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Configurações específicas
LOG_SLACK_WEBHOOK_URL=
LOG_PAPERTRAIL_URL=
LOG_STDERR_FORMATTER=
```

### Monitoramento de Performance
```env
# APM (Application Performance Monitoring)
APM_ENABLED=true
APM_SERVICE_NAME=tcamara-municipal
APM_ENVIRONMENT=production

# Métricas
METRICS_ENABLED=true
METRICS_ENDPOINT=/metrics
```

## 📋 Checklist de Configuração

### Pré-Produção
- [ ] Configurar `.env` com dados de produção
- [ ] Configurar banco de dados
- [ ] Configurar email SMTP
- [ ] Configurar cache Redis
- [ ] Configurar SSL/HTTPS
- [ ] Configurar backup automático
- [ ] Configurar monitoramento
- [ ] Testar todas as funcionalidades

### Pós-Deploy
- [ ] Verificar logs de erro
- [ ] Testar envio de emails
- [ ] Verificar performance
- [ ] Configurar cron jobs
- [ ] Configurar certificados SSL
- [ ] Configurar firewall
- [ ] Documentar configurações específicas

## 🆘 Solução de Problemas

### Problemas Comuns

**Erro de Conexão com Banco:**
```bash
php artisan migrate:status
php artisan config:clear
```

**Problemas de Cache:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**Problemas de Permissão:**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

## 📞 Suporte

Para suporte com configurações:
- **Email**: suporte@lideratecnologia.com.br
- **WhatsApp**: (65) 99920-5608
- **Documentação**: [Guia de Instalação](INSTALLATION_GUIDE.md)

---

**Última atualização**: Janeiro 2025  
**Versão**: 1.0.0