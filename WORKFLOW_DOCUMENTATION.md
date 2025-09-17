# 📋 DOCUMENTAÇÃO DO FLUXO DE TRABALHO - TCamaraMunicipal

## 🎯 VISÃO GERAL DO PROJETO
**Sistema para Câmara Municipal desenvolvido em Laravel**

### 📍 Ambientes e URLs:
- **🌐 Produção**: `https://camara.lidera.srv.br/` (Hostinger)
- **💻 Desenvolvimento**: Máquina local (Windows)
- **📦 Repositório**: `https://github.com/brunoandersonlidera/TCamaraMunicipal.git`

---

## 🔄 FLUXO DE TRABALHO ESTABELECIDO

### 📋 Processo de Desenvolvimento:
```
1. Desenvolvimento Local → 2. GitHub → 3. Hostinger → 4. Teste em Produção
   (máquina local)      (repositório)   (deploy)     (camara.lidera.srv.br)
```

### 🚀 Etapas Detalhadas:

#### 1️⃣ **Desenvolvimento Local**
- Trabalhar na máquina local: `c:\inetpub\LIDERA\TCamaraMunicipal`
- Fazer todas as melhorias e implementações
- Testar localmente antes de enviar

#### 2️⃣ **Versionamento (GitHub)**
```bash
# Comandos para sincronizar
git add .
git commit -m "Descrição das alterações"
git push origin main

# Para puxar atualizações
git pull origin main
```

#### 3️⃣ **Deploy (Hostinger)**
- Atualizar pasta da Hostinger via SSH
- Sincronizar código do GitHub para servidor

#### 4️⃣ **Validação**
- Testar funcionalidades em: `https://camara.lidera.srv.br/`
- Validar em ambiente de produção real

---

## 🏗️ ESTRUTURA TÉCNICA ATUAL

### 📊 Configurações Base:
- **Framework**: Laravel 12.0
- **PHP**: 8.2+
- **Banco de Dados**: SQLite (padrão)
- **Frontend**: Vite (CSS/JS)
- **Ambiente**: Produção

### 📁 Estrutura de Arquivos:
```
TCamaraMunicipal/
├── app/                    # Lógica da aplicação
│   ├── Http/Controllers/   # Controladores
│   ├── Models/            # Modelos de dados
│   └── Providers/         # Provedores de serviços
├── database/              # Banco de dados
│   ├── migrations/        # Migrações
│   ├── seeders/          # Seeders
│   └── factories/        # Factories
├── resources/            # Recursos frontend
│   ├── views/           # Templates Blade
│   ├── css/            # Estilos
│   └── js/             # JavaScript
├── routes/              # Definição de rotas
├── config/             # Configurações
└── public/             # Arquivos públicos
```

---

## 🎯 DIRETRIZES DE DESENVOLVIMENTO

### 📝 Padrões de Código:
1. **Seguir convenções Laravel**
2. **Manter consistência de estilo**
3. **Usar bibliotecas existentes**
4. **Seguir padrões de nomenclatura**

### 🔒 Segurança:
- Nunca expor chaves/secrets
- Seguir melhores práticas de segurança
- Validar todas as entradas de dados

### 🗄️ Banco de Dados:
- **⚠️ CRÍTICO**: NÃO alterar configurações de banco no código
- **Hostinger gerencia**: Todas as configurações de produção
- **Local**: Usar SQLite para desenvolvimento
- **Migrations**: Podem ser criadas normalmente
- **Models**: Desenvolver sem se preocupar com conexão

### 🎨 Interface:
- Design moderno e responsivo
- UX otimizada para usuários da câmara
- Interface institucional apropriada

---

## 📋 COMANDOS ÚTEIS

### SSH (Deploy Hostinger):
```bash
# Conectar via SSH (com chave)
ssh -p 65002 -i ~/.ssh/hostinger_tcamara u700101648@82.180.159.124

# Conectar via SSH (com senha)
ssh -p 65002 u700101648@82.180.159.124

# Navegar para projeto
cd /home/u700101648/domains/camara.lidera.srv.br/public_html/camara/

# Deploy completo
git pull origin main
php artisan cache:clear
php artisan config:clear

# Verificar status
git status
php artisan --version
```

### ✅ Teste SSH (Realizado)
```bash
# Conexão SSH: ✅ SUCESSO
# Caminho correto: /home/u700101648/domains/lidera.srv.br/public_html/camara/
# PHP: 8.2.29 ✅
# Laravel: 12.12.0 ✅
# Git: Não inicializado (projeto atual não é repositório Git)
```

### Git:
```bash
# Status do repositório
git status

# Ver repositórios remotos
git remote -v

# Histórico de commits
git log --oneline -5

# Sincronizar com GitHub
git pull origin main
git add .
git commit -m "Mensagem do commit"
git push origin main
```

### Laravel:
```bash
# Servidor de desenvolvimento
php artisan serve

# Migrations
php artisan migrate
php artisan migrate:fresh

# Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Criar componentes
php artisan make:controller NomeController
php artisan make:model NomeModel
php artisan make:migration create_nome_table
```

---

## 🎯 PRÓXIMOS PASSOS SUGERIDOS

### 🏛️ Funcionalidades para Câmara Municipal:
1. **Sistema de Vereadores**
   - Cadastro e perfis
   - Histórico de mandatos

2. **Gestão de Sessões**
   - Plenárias ordinárias/extraordinárias
   - Atas e registros

3. **Legislação**
   - Projetos de lei
   - Leis aprovadas
   - Tramitação

4. **Transparência**
   - Portal da transparência
   - Documentos públicos

5. **Área Administrativa**
   - Dashboard administrativo
   - Gestão de conteúdo

---

## 🔧 CONFIGURAÇÕES IMPORTANTES

### 🔐 ACESSO SSH - HOSTINGER

#### 📋 Credenciais SSH:
```
IP: 82.180.159.124
Porta: 65002
Usuário: u700101648
Senha: L1d3r@t3cn0l0g1@
```

#### 🖥️ Comando de Conexão:
```bash
ssh -p 65002 u700101648@82.180.159.124
```

#### 📁 Caminho do Projeto na Hostinger:
```
/home/u700101648/domains/lidera.srv.br/public_html/camara/
```

#### 🔑 Autenticação Recomendada - Chave SSH:
**⚠️ RECOMENDADO**: Usar chaves SSH ao invés de senha para maior segurança.

**Processo para configurar chave SSH:**
1. Gerar chave SSH local:
   ```bash
   ssh-keygen -t rsa -b 4096 -C "seu-email@exemplo.com"
   ```
2. Copiar chave pública:
   ```bash
   cat ~/.ssh/id_rsa.pub
   ```
3. Adicionar no hPanel da Hostinger:
   - Ir em "Chaves SSH"
   - Clicar em "Adicionar chave SSH"
   - Inserir nome e colar a chave pública
   - Salvar

#### 🚀 Comandos de Deploy via SSH:
```bash
# Conectar via SSH
ssh -p 65002 u700101648@82.180.159.124

# Navegar para o diretório do projeto
cd /home/u700101648/domains/lidera.srv.br/public_html/camara/

# Atualizar código do GitHub
git pull origin main

# Limpar cache (se necessário)
php artisan cache:clear
php artisan config:clear
```

### ⚠️ ATENÇÃO - Configurações de Banco de Dados:
**🚨 IMPORTANTE**: As configurações de conexão com banco de dados estão no arquivo `.env` da Hostinger.
- **NÃO alterar** as configurações de banco localmente
- **NÃO modificar** rotas de conexão no código
- **Manter** as configurações padrão do Laravel para desenvolvimento local
- **Produção**: Hostinger gerencia as configurações via `.env` próprio

### Arquivo .env (Desenvolvimento Local):
```
APP_NAME="Câmara Municipal"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Manter SQLite para desenvolvimento local
DB_CONNECTION=sqlite
# Não alterar configurações de banco - Hostinger gerencia isso
```

### Arquivo .env (Produção - Hostinger):
```
APP_NAME="Câmara Municipal"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://camara.lidera.srv.br

# ⚠️ CONFIGURAÇÕES GERENCIADAS PELA HOSTINGER
# NÃO ALTERAR - Hostinger configura automaticamente:
# DB_CONNECTION=mysql
# DB_HOST=localhost
# DB_PORT=3306
# DB_DATABASE=nome_do_banco_hostinger
# DB_USERNAME=usuario_hostinger
# DB_PASSWORD=senha_hostinger
```

---

## 📞 INFORMAÇÕES DE CONTATO

### Repositório GitHub:
- **URL**: https://github.com/brunoandersonlidera/TCamaraMunicipal.git
- **Owner**: brunoandersonlidera

### Hosting:
- **Provedor**: Hostinger
- **Domínio**: camara.lidera.srv.br

---

## 📝 NOTAS IMPORTANTES

1. **Sempre testar localmente** antes de fazer push
2. **Fazer commits descritivos** para facilitar o histórico
3. **Manter backup** através do GitHub
4. **Validar em produção** após cada deploy
5. **Seguir padrões de código** estabelecidos no projeto

---

**Última atualização**: $(date)
**Versão do Laravel**: 12.0
**Status**: Projeto em desenvolvimento inicial

Chave SSH:
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQDNXQAwNRyC3tqto2aZffEisznd2ZsDDIpg+LCSnb/QDApBQIRtJffqc1qANUkyRS2Gz4+ixrWfbVR3QLecWjZhcebUlUHAJDOnhqtXra3f3zOh0L5gS0YJynZqrrQ6yTqCAVm9g7k8JMVD+gdoANyE47Zfuexy1Y58Ap8X8iZFqoKbt/h5Ksw7hIKmRAkwZfMoToScGyyN/NHDIDINLqGuTt+UK3j0nFHYZXjuF5si3Z/B+ELQ3KUg2CiCM4gC+5tDjG+Gq5ccOW/xMM17GI1dC/E/5bth0EU6xNxOccLM0tRgPAJyCquCUczXUJFPmlY9a5dVGvbx3cP9Cw4Bno9SoyMoy9ENxpPiBNeeKuTtbztp19IeRH6QYXHVLbfLgppKvJGUizCfqUukjc3GKpFK5/5QHTcWFtzj2PAHrZk6SQ9dXwUn1xI0CdGS0yb5OAbvym97ve/3jKTeXDQ+JUscbN6/jTTdotyzbEnCdAUhwuh7zUvjgPib0tb9eeQg4Y6DYl6/9w887+8ZyOOwSNoh8u8I/QWoRGAx1c7NvLnDgL0xOoFgyfXIs0XFt0KE46nZBxWHu/tefvhzIo3RagjSxwTL+LV5gjTqPxkSHdSn62xNDxNaBnSux1NnYT0mkdnhMZGEJN0fmeiebqJGMM/cXS9CSkz35xeoSr9tXhLGoQ== tcamara@lidera.srv.br