# 🏛️ TCamaraMunicipal

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-12.0-red?style=for-the-badge&logo=laravel" alt="Laravel 12.0">
    <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/Status-Em%20Desenvolvimento-yellow?style=for-the-badge" alt="Status">
</p>

## 📋 Sobre o Projeto

Sistema web moderno para Câmara Municipal desenvolvido em Laravel, oferecendo transparência e facilidade de acesso às informações públicas para os cidadãos.

### 🎯 Objetivos
- Modernizar a presença digital da Câmara Municipal
- Facilitar o acesso às informações públicas
- Promover transparência e participação cidadã
- Otimizar processos administrativos internos

## 🚀 Funcionalidades Implementadas

### ✅ **Seção de Vereadores**
- **Página Inicial**: Apresentação dos vereadores com destaque para o presidente
- **Grid Responsivo**: Layout adaptável para diferentes dispositivos
- **Perfis Individuais**: Páginas detalhadas de cada vereador com:
  - Informações pessoais e profissionais
  - Biografia e trajetória política
  - Comissões e cargos ocupados
  - Proposições e projetos de lei
  - Redes sociais e contatos

### 🔄 **Em Desenvolvimento**
- Sistema de Sessões Plenárias
- Gestão de Projetos de Lei
- Portal da Transparência
- Sistema de Documentos
- E-SIC (Sistema de Informação ao Cidadão)

## 🛠️ Tecnologias Utilizadas

- **Framework**: Laravel 12.0
- **PHP**: 8.2+
- **Frontend**: Blade Templates + Vite
- **Banco de Dados**: MySQL (Produção) / SQLite (Desenvolvimento)
- **Hospedagem**: Hostinger
- **Versionamento**: Git + GitHub

## 🌐 Ambientes

### 🔴 **Produção**
- **URL**: https://camara.lidera.srv.br/
- **Servidor**: Hostinger
- **Deploy**: Via SSH

### 💻 **Desenvolvimento**
- **Local**: `c:\inetpub\LIDERA\TCamaraMunicipal`
- **Servidor**: `php artisan serve`
- **URL**: http://127.0.0.1:8000

## 📁 Estrutura do Projeto

```
TCamaraMunicipal/
├── app/
│   ├── Http/Controllers/
│   │   └── VereadorController.php
│   └── Models/
│       ├── Vereador.php
│       ├── Sessao.php
│       ├── ProjetoLei.php
│       └── ...
├── database/
│   ├── migrations/
│   └── seeders/
│       └── VereadorSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       ├── vereadores/
│       └── welcome.blade.php
└── routes/
    └── web.php
```

## 🚀 Instalação e Configuração

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js & NPM

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

4. **Execute as migrations e seeders**
```bash
php artisan migrate
php artisan db:seed --class=VereadorSeeder
```

5. **Inicie o servidor de desenvolvimento**
```bash
php artisan serve
```

## 📦 Deploy

### Deploy para Produção (Hostinger)

1. **Conecte via SSH**
```bash
ssh -i hostinger_rsa -p 65002 u700101648@82.180.159.124
cd /home/u700101648/domains/lidera.srv.br/public_html/camara/
```

2. **Atualize o código**
```bash
git pull origin main
```

3. **Execute migrations e seeders**
```bash
php artisan migrate
php artisan db:seed --class=VereadorSeeder
```

4. **Limpe o cache**
```bash
php artisan cache:clear
php artisan config:clear
```

## 👥 Dados de Exemplo

O sistema vem com dados de exemplo de 3 vereadores:
- **João Carlos Santos** (Presidente)
- **Ana Paula Rodrigues** (Vereadora)
- **Roberto Silva Mendes** (Vereador)

## 🔧 Comandos Úteis

```bash
# Desenvolvimento
php artisan serve                    # Servidor local
php artisan migrate                  # Executar migrations
php artisan db:seed                  # Popular dados

# Cache
php artisan cache:clear              # Limpar cache
php artisan config:clear             # Limpar config
php artisan view:clear               # Limpar views

# Criação de componentes
php artisan make:controller NomeController
php artisan make:model NomeModel
php artisan make:migration create_nome_table
```

## 📝 Próximas Funcionalidades

- [ ] Sistema de Autenticação para Administradores
- [ ] Gestão de Sessões Plenárias
- [ ] Portal da Transparência
- [ ] Sistema de Documentos Públicos
- [ ] E-SIC (Serviço de Informação ao Cidadão)
- [ ] Sistema de Notícias
- [ ] Agenda de Eventos
- [ ] Transmissão ao Vivo das Sessões

## 🤝 Contribuição

Para contribuir com o projeto:

1. Faça um fork do repositório
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT).

## 📞 Contato

- **Repositório**: https://github.com/brunoandersonlidera/TCamaraMunicipal
- **Site**: https://camara.lidera.srv.br/
- **Desenvolvedor**: Bruno Anderson Lidera

---

**Desenvolvido com ❤️ para modernizar a gestão pública municipal**
