# Documentação do Sistema TCamaraMunicipal

## Visão Geral

Este repositório contém toda a documentação do Sistema TCamaraMunicipal, uma plataforma completa para gestão de câmaras municipais desenvolvida em Laravel. A documentação está organizada em categorias para facilitar o acesso e uso por diferentes perfis de usuários.

## Estrutura da Documentação

### 📋 Documentação Técnica
Localizada em: `docs/technical/`

#### Instalação e Configuração
- **[Guia de Instalação](technical/INSTALLATION_GUIDE.md)** - Instruções completas para instalação do sistema
- **[Guia de Deploy](technical/DEPLOYMENT_GUIDE.md)** - Procedimentos para deploy em produção
- **[Guia de Configuração](technical/CONFIGURATION_GUIDE.md)** - Configurações detalhadas do sistema

#### Desenvolvimento
- **[Guia de Desenvolvimento](technical/DEVELOPMENT_GUIDE.md)** - Orientações para desenvolvedores
- **[Guia de Testes](technical/TESTING_GUIDE.md)** - Estratégias e execução de testes
- **[Guia de Contribuição](technical/CONTRIBUTING.md)** - Como contribuir para o projeto

#### Arquitetura e Segurança
- **[Documentação de Arquitetura](technical/ARCHITECTURE.md)** - Arquitetura completa do sistema
- **[Guia de Segurança](technical/SECURITY_GUIDE.md)** - Práticas e configurações de segurança

#### APIs e Integrações
- **[Documentação da API](technical/API_DOCUMENTATION.md)** - Endpoints e uso da API REST
- **[Guia de Backup](technical/BACKUP_GUIDE.md)** - Estratégias de backup e recuperação

### 👥 Manuais de Usuário
Localizada em: `docs/user-manuals/`

- **[Manual do Administrador](user-manuals/MANUAL_ADMINISTRADOR.md)** - Guia completo para administradores do sistema
- **[Manual do Cidadão](user-manuals/MANUAL_CIDADAO.md)** - Orientações para cidadãos que acessam o portal
- **[Manual do Vereador](user-manuals/MANUAL_VEREADOR.md)** - Instruções específicas para vereadores

### 📊 Documentação de Negócio
Localizada em: `docs/business/`

- **[Levantamento de Requisitos](business/LEVANTAMENTO_REQUISITOS.md)** - Requisitos funcionais e não funcionais
- **[Análise de Tipos de Usuários](business/LEVANTAMENTO_TIPOS_USUARIOS_PERMISSOES.md)** - Perfis de usuário e permissões
- **[Especificação do Projeto](business/projetocamara.MD)** - Especificação detalhada do projeto

## Guia de Navegação

### Para Desenvolvedores 👨‍💻
1. Comece com o [Guia de Instalação](technical/INSTALLATION_GUIDE.md)
2. Leia o [Guia de Desenvolvimento](technical/DEVELOPMENT_GUIDE.md)
3. Consulte a [Documentação de Arquitetura](technical/ARCHITECTURE.md)
4. Siga o [Guia de Contribuição](technical/CONTRIBUTING.md)

### Para Administradores de Sistema 🔧
1. Consulte o [Guia de Deploy](technical/DEPLOYMENT_GUIDE.md)
2. Configure seguindo o [Guia de Configuração](technical/CONFIGURATION_GUIDE.md)
3. Implemente as práticas do [Guia de Segurança](technical/SECURITY_GUIDE.md)
4. Configure o [Guia de Backup](technical/BACKUP_GUIDE.md)

### Para Usuários Finais 👤
1. **Administradores:** [Manual do Administrador](user-manuals/MANUAL_ADMINISTRADOR.md)
2. **Cidadãos:** [Manual do Cidadão](user-manuals/MANUAL_CIDADAO.md)
3. **Vereadores:** [Manual do Vereador](user-manuals/MANUAL_VEREADOR.md)

### Para Gestores de Projeto 📈
1. Revise o [Levantamento de Requisitos](business/LEVANTAMENTO_REQUISITOS.md)
2. Analise os [Tipos de Usuários e Permissões](business/LEVANTAMENTO_TIPOS_USUARIOS_PERMISSOES.md)
3. Consulte a [Especificação do Projeto](business/projetocamara.MD)

## Características do Sistema

### Tecnologias Principais
- **Backend:** Laravel 11 + PHP 8.2+
- **Frontend:** Blade Templates + Bootstrap + Vite
- **Banco de Dados:** MySQL/MariaDB
- **Cache:** Redis
- **Autenticação:** Laravel Sanctum

### Funcionalidades Principais
- ✅ Gestão de vereadores e usuários
- ✅ Tramitação de projetos de lei
- ✅ Sistema de sessões e atas
- ✅ Portal de transparência
- ✅ Sistema e-SIC (Acesso à Informação)
- ✅ Ouvidoria integrada
- ✅ Gestão de licitações
- ✅ Relatórios e dashboards
- ✅ API REST completa
- ✅ Sistema de backup automatizado

### Segurança
- 🔒 Autenticação de dois fatores (2FA)
- 🔒 Controle de acesso baseado em roles
- 🔒 Criptografia de dados sensíveis
- 🔒 Logs de auditoria
- 🔒 Proteção CSRF e XSS
- 🔒 Validação rigorosa de dados

## Requisitos do Sistema

### Servidor de Produção
- **SO:** Linux (Ubuntu 20.04+ recomendado)
- **Web Server:** Nginx ou Apache
- **PHP:** 8.2 ou superior
- **Banco:** MySQL 8.0+ ou MariaDB 10.6+
- **Cache:** Redis 6.0+
- **Memória:** Mínimo 2GB RAM
- **Armazenamento:** Mínimo 20GB SSD

### Desenvolvimento
- **PHP:** 8.2+ com extensões necessárias
- **Composer:** 2.0+
- **Node.js:** 18+ com NPM
- **Git:** Para controle de versão
- **IDE:** VS Code, PhpStorm ou similar

## Instalação Rápida

```bash
# 1. Clone o repositório
git clone [url-do-repositorio]
cd TCamaraMunicipal

# 2. Instale dependências PHP
composer install

# 3. Instale dependências Node.js
npm install

# 4. Configure ambiente
cp .env.example .env
php artisan key:generate

# 5. Configure banco de dados
php artisan migrate --seed

# 6. Compile assets
npm run build

# 7. Inicie o servidor
php artisan serve
```

Para instruções detalhadas, consulte o [Guia de Instalação](technical/INSTALLATION_GUIDE.md).

## Suporte e Contribuição

### Como Contribuir
1. Leia o [Guia de Contribuição](technical/CONTRIBUTING.md)
2. Faça fork do projeto
3. Crie uma branch para sua feature
4. Implemente seguindo os padrões
5. Execute os testes
6. Submeta um Pull Request

### Reportar Problemas
- Use as issues do GitHub
- Forneça informações detalhadas
- Inclua logs quando relevante
- Siga o template de issue

### Suporte
- **Documentação:** Consulte os manuais apropriados
- **Issues:** Para bugs e melhorias
- **Discussões:** Para dúvidas gerais
- **Email:** Para suporte direto

## Roadmap

### Versão Atual (1.0)
- ✅ Funcionalidades básicas implementadas
- ✅ Sistema de autenticação e autorização
- ✅ Portal público e área administrativa
- ✅ API REST básica

### Próximas Versões
- 🔄 **v1.1:** Melhorias de performance e UX
- 🔄 **v1.2:** Integração com sistemas externos
- 🔄 **v1.3:** App mobile
- 🔄 **v2.0:** Arquitetura de microserviços

## Licença

Este projeto está licenciado sob a [Licença MIT](../LICENSE). Consulte o arquivo de licença para mais detalhes.

## Equipe

### Desenvolvedores
- **Desenvolvedor Principal:** [Nome]
- **Equipe de Desenvolvimento:** [Nomes]
- **Arquiteto de Software:** [Nome]

### Colaboradores
- **Analistas de Negócio:** [Nomes]
- **Designers UX/UI:** [Nomes]
- **Testadores:** [Nomes]

## Agradecimentos

Agradecemos a todos que contribuíram para o desenvolvimento deste sistema, incluindo:
- Equipe de desenvolvimento
- Usuários que forneceram feedback
- Comunidade open source
- Câmaras municipais que testaram o sistema

## Changelog

### v1.0.0 (Janeiro 2024)
- 🎉 Lançamento inicial
- ✅ Todas as funcionalidades básicas implementadas
- ✅ Documentação completa criada
- ✅ Testes implementados
- ✅ Deploy em produção

Para histórico completo de mudanças, consulte o arquivo [CHANGELOG.md](../CHANGELOG.md).

---

## Contatos

- **Website:** [www.tcamaramunicipal.gov.br]
- **Email:** contato@tcamaramunicipal.gov.br
- **GitHub:** [github.com/tcamaramunicipal]
- **Documentação Online:** [docs.tcamaramunicipal.gov.br]

---

**Última Atualização:** Janeiro 2024  
**Versão da Documentação:** 1.0  
**Próxima Revisão:** Julho 2024