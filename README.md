# 🏛️ TCamaraMunicipal

Sistema web para gestão de Câmara Municipal desenvolvido em Laravel.

## 🚀 Tecnologias Utilizadas

- **Framework**: Laravel 12.0
- **PHP**: 8.2+
- **Banco de Dados**: MySQL
- **Frontend**: Blade Templates + Vite
- **CSS**: Bootstrap + CSS customizado
- **JavaScript**: Vanilla JS + componentes interativos

## 📋 Funcionalidades Implementadas

### 🔐 Sistema de Autenticação e Autorização
- Login/logout de usuários
- Sistema de roles e permissões (Spatie Laravel Permission)
- Middleware de autorização
- Gestão de usuários e permissões

### 👥 Gestão de Usuários
- Cadastro e edição de usuários
- Atribuição de roles (Admin, Vereador, Funcionário, Cidadão)
- Interface administrativa para gerenciamento

### 🏛️ Módulos da Câmara
- **Vereadores**: Cadastro e gestão de vereadores
- **Sessões**: Controle de sessões plenárias
- **Legislação**: Gestão de projetos de lei e leis
- **Ouvidoria**: Sistema de ouvidoria municipal
- **Transparência**: Portal da transparência

### 📊 Dashboard Administrativo
- Painel de controle com estatísticas
- Gestão de conteúdo
- Relatórios e métricas

## 🏗️ Estrutura do Projeto

```
TCamaraMunicipal/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   ├── Console/Commands/    # Comandos Artisan customizados
│   └── Http/Middleware/     # Middlewares
├── database/
│   ├── migrations/          # Migrações do banco
│   ├── seeders/            # Seeders
│   └── factories/          # Factories
├── resources/
│   ├── views/              # Templates Blade
│   ├── css/               # Estilos CSS
│   └── js/                # JavaScript
├── routes/                 # Definição de rotas
├── config/                # Configurações
└── public/                # Arquivos públicos
```

## ⚙️ Instalação e Configuração

### Pré-requisitos
- PHP 8.2 ou superior
- Composer
- MySQL
- Node.js e NPM

### Passos para Instalação

1. **Clone o repositório**
   ```bash
   git clone https://github.com/brunoandersonlidera/TCamaraMunicipal.git
   cd TCamaraMunicipal
   ```

2. **Instale as dependências**
   ```bash
   composer install
   npm install
   ```

3. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure o banco de dados**
   - Edite o arquivo `.env` com suas credenciais de banco
   - Execute as migrações:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Compile os assets**
   ```bash
   npm run build
   ```

6. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

## 🔧 Comandos Úteis

### Laravel Artisan
```bash
# Servidor de desenvolvimento
php artisan serve

# Migrações
php artisan migrate
php artisan migrate:fresh --seed

# Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Criar componentes
php artisan make:controller NomeController
php artisan make:model NomeModel
php artisan make:migration create_nome_table
```

### Git
```bash
# Status do repositório
git status

# Sincronizar alterações
git add .
git commit -m "Descrição das alterações"
git push origin main
```

## 📚 Documentação Completa

### 📖 **Documentação Técnica**
Localizada em: `docs/technical/`

- **[Guia de Instalação](docs/technical/INSTALLATION_GUIDE.md)** - Instalação completa e configuração
- **[Guia de Deploy](docs/technical/DEPLOYMENT_GUIDE.md)** - Deploy em produção
- **[Guia de Configuração](docs/technical/CONFIGURATION_GUIDE.md)** - Configurações avançadas
- **[Guia de Desenvolvimento](docs/technical/DEVELOPMENT_GUIDE.md)** - Padrões e práticas
- **[Guia de Testes](docs/technical/TESTING_GUIDE.md)** - Estratégias de teste
- **[Guia de Segurança](docs/technical/SECURITY_GUIDE.md)** - Práticas de segurança
- **[Documentação de Arquitetura](docs/technical/ARCHITECTURE.md)** - Arquitetura do sistema
- **[Guia de Contribuição](docs/technical/CONTRIBUTING.md)** - Como contribuir
- **[Documentação da API](docs/technical/API_DOCUMENTATION.md)** - Endpoints e uso da API

### 👥 **Manuais de Usuário**
Localizada em: `docs/user-manuals/`

- **[Manual do Administrador](docs/user-manuals/MANUAL_ADMINISTRADOR.md)** - Guia completo para administradores
- **[Manual do Cidadão](docs/user-manuals/MANUAL_CIDADAO.md)** - Orientações para cidadãos
- **[Manual do Vereador](docs/user-manuals/MANUAL_VEREADOR.md)** - Instruções para vereadores

### 📋 **Planejamento e Análise**
Localizada em: `docs/`

- **[Recursos Pendentes](docs/RECURSOS_PENDENTES.md)** - Lista completa de funcionalidades a desenvolver
- **[Status do Projeto](docs/STATUS.MD)** - Status atual das funcionalidades
- **[Documentação Completa](docs/README.md)** - Índice geral da documentação

### 🔧 **Operações e Manutenção**
Localizada em: `docs/technical/`

- **[Guia de Backup](docs/technical/BACKUP_GUIDE.md)** - Estratégias de backup e recuperação

## 🎯 Funcionalidades Futuras

### 📋 Roadmap Detalhado
Para uma visão completa dos recursos pendentes, consulte: **[Recursos Pendentes](docs/RECURSOS_PENDENTES.md)**

**Prioridade Crítica:**
- [ ] Portal da Transparência - Dados Financeiros
- [ ] Views Administrativas Ausentes
- [ ] Melhorias E-SIC

**Alta Prioridade:**
- [ ] Sistema de Sessões Avançadas
- [ ] Sistema de Permissões Completo
- [ ] Melhorias na Ouvidoria

**Funcionalidades Futuras:**
- [ ] Sistema de votações eletrônicas
- [ ] API REST completa
- [ ] Aplicativo mobile
- [ ] Participação cidadã online
- [ ] Integrações externas

## 📊 Estatísticas do Projeto

- **Controladores**: 15+
- **Modelos**: 10+
- **Migrações**: 20+
- **Views**: 50+
- **Rotas**: 100+

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📞 Contato

**Desenvolvedor**: Bruno Anderson  
**Email**: bruno@lideratecnologia.com.br
**WhatsApp**: (65) 99920-5608
**GitHub**: [@brunoandersonlidera](https://github.com/brunoandersonlidera)

## 🏛️ Sobre o Projeto

Sistema desenvolvido para modernizar e digitalizar os processos de uma Câmara Municipal, proporcionando maior transparência, eficiência e acessibilidade aos cidadãos.

### Objetivos
- Digitalizar processos legislativos
- Aumentar a transparência pública
- Facilitar o acesso à informação
- Modernizar a gestão municipal
- Promover a participação cidadã

---

**Versão**: 1.0.0  
**Laravel**: 12.0  
**Status**: Em desenvolvimento ativo, há diversos bugs a serem corrigidos.
