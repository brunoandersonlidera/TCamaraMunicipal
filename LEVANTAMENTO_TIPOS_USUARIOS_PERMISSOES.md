# 📋 LEVANTAMENTO DE TIPOS DE USUÁRIOS E PERMISSÕES
## Sistema TCamaraMunicipal

---

## 🎯 SITUAÇÃO ATUAL

### 📊 Estrutura Existente:
- **Tabela**: `users`
- **Campo de Role**: `role` (enum: 'user', 'admin')
- **Métodos de Verificação**: `isAdmin()`, `isUser()`, `canAccessAdmin()`, `canManageContent()`, `canManageUsers()`

### 🔐 Sistema de Autenticação Atual:
- **Middleware Admin**: Verifica autenticação + role 'admin'
- **Middleware Auth**: Apenas autenticação
- **Middleware Verified**: Email verificado

---

## 🏛️ ANÁLISE FUNCIONAL DO SISTEMA

### 📋 Áreas Funcionais Identificadas:

#### 1. **ÁREA PÚBLICA** (Sem autenticação)
- Portal institucional
- Notícias públicas
- Projetos de Lei (visualização)
- Vereadores (perfis públicos)
- Sessões (atas e pautas públicas)
- Transparência
- Licitações
- Cartas de Serviço

#### 2. **ÁREA DE USUÁRIO AUTENTICADO** (Role: 'user')
- Dashboard pessoal
- Solicitações e-SIC
- Manifestações de Ouvidoria
- Upload de documentos pessoais
- Acompanhamento de protocolos

#### 3. **ÁREA ADMINISTRATIVA** (Role: 'admin')
- Dashboard administrativo
- Gestão de usuários
- Gestão de conteúdo (notícias, documentos)
- Gestão de vereadores
- Gestão de sessões
- Gestão de projetos de lei
- Gestão de solicitações e-SIC
- Gestão de ouvidoria
- Configurações do sistema

---

## 🎯 TIPOS DE USUÁRIOS NECESSÁRIOS

### 📊 Análise Baseada nas Funcionalidades:

#### 1. **CIDADÃO** (user) - ✅ **EXISTENTE**
**Descrição**: Cidadão comum que acessa serviços públicos
**Permissões**:
- Fazer solicitações e-SIC
- Registrar manifestações na ouvidoria
- Acompanhar protocolos próprios
- Visualizar conteúdo público
- Gerenciar perfil pessoal

#### 2. **ADMINISTRADOR GERAL** (admin) - ✅ **EXISTENTE**
**Descrição**: Acesso total ao sistema
**Permissões**:
- Todas as funcionalidades
- Gestão de usuários e permissões
- Configurações do sistema
- Relatórios gerais

#### 3. **SECRETÁRIO/ASSESSOR** (secretario) - ⚠️ **NECESSÁRIO**
**Descrição**: Funcionário da câmara responsável por gestão de conteúdo
**Permissões**:
- Gestão de notícias
- Gestão de documentos
- Gestão de sessões (atas, pautas)
- Gestão de projetos de lei
- Upload de documentos oficiais
- **NÃO**: Gestão de usuários, configurações

#### 4. **RESPONSÁVEL e-SIC** (esic_responsavel) - ⚠️ **NECESSÁRIO**
**Descrição**: Servidor responsável por responder solicitações de informação
**Permissões**:
- Visualizar todas as solicitações e-SIC
- Responder solicitações
- Marcar como visualizada/arquivada
- Gerar relatórios de e-SIC
- **NÃO**: Outras áreas administrativas

#### 5. **OUVIDOR** (ouvidor) - ⚠️ **NECESSÁRIO**
**Descrição**: Responsável por tratar manifestações da ouvidoria
**Permissões**:
- Visualizar manifestações de ouvidoria
- Responder manifestações
- Atribuir manifestações
- Alterar status das manifestações
- Gerar relatórios de ouvidoria
- **NÃO**: Outras áreas administrativas

#### 6. **VEREADOR** (vereador) - ⚠️ **NECESSÁRIO**
**Descrição**: Vereador com acesso a área específica
**Permissões**:
- Visualizar projetos de lei próprios
- Acompanhar tramitações
- Visualizar sessões e presenças
- Área pessoal de vereador
- Visualizar documentos restritos
- **NÃO**: Gestão administrativa

#### 7. **PRESIDENTE DA CÂMARA** (presidente) - ⚠️ **NECESSÁRIO**
**Descrição**: Presidente com permissões especiais
**Permissões**:
- Todas as permissões de vereador
- Aprovar/rejeitar projetos de lei
- Convocar sessões extraordinárias
- Acesso a relatórios especiais
- Gestão de comissões
- **NÃO**: Configurações técnicas do sistema

#### 8. **EDITOR DE CONTEÚDO** (editor) - ⚠️ **NECESSÁRIO**
**Descrição**: Responsável apenas por conteúdo público
**Permissões**:
- Gestão de notícias
- Gestão de páginas institucionais
- Upload de imagens/documentos públicos
- Gestão de cartas de serviço
- **NÃO**: Documentos oficiais, usuários, configurações

#### 9. **PROTOCOLO** (protocolo) - ⚠️ **NECESSÁRIO**
**Descrição**: Responsável por protocolo e documentação
**Permissões**:
- Registrar protocolos
- Gestão de documentos oficiais
- Controle de tramitação
- Arquivo de documentos
- **NÃO**: Conteúdo público, configurações

#### 10. **CONTADOR/FINANCEIRO** (financeiro) - ⚠️ **NECESSÁRIO**
**Descrição**: Responsável por transparência e dados financeiros
**Permissões**:
- Gestão de dados de transparência
- Upload de relatórios financeiros
- Gestão de licitações
- Contratos e convênios
- **NÃO**: Outras áreas administrativas

---

## 🔐 MATRIZ DE PERMISSÕES PROPOSTA

### 📊 Tabela de Permissões por Funcionalidade:

| Funcionalidade | Cidadão | Admin | Secretário | e-SIC | Ouvidor | Vereador | Presidente | Editor | Protocolo | Financeiro |
|---|---|---|---|---|---|---|---|---|---|---|
| **GESTÃO DE USUÁRIOS** | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **CONFIGURAÇÕES SISTEMA** | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **NOTÍCIAS** | 👁️ | ✅ | ✅ | ❌ | ❌ | 👁️ | 👁️ | ✅ | ❌ | ❌ |
| **DOCUMENTOS OFICIAIS** | 👁️ | ✅ | ✅ | ❌ | ❌ | 👁️ | ✅ | ❌ | ✅ | 👁️ |
| **PROJETOS DE LEI** | 👁️ | ✅ | ✅ | ❌ | ❌ | 📝 | ✅ | ❌ | ✅ | ❌ |
| **SESSÕES** | 👁️ | ✅ | ✅ | ❌ | ❌ | 👁️ | ✅ | ❌ | ✅ | ❌ |
| **VEREADORES** | 👁️ | ✅ | ✅ | ❌ | ❌ | 📝 | ✅ | ✅ | ❌ | ❌ |
| **SOLICITAÇÕES e-SIC** | 📝 | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **OUVIDORIA** | 📝 | ✅ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **TRANSPARÊNCIA** | 👁️ | ✅ | ❌ | ❌ | ❌ | 👁️ | 👁️ | ❌ | ❌ | ✅ |
| **LICITAÇÕES** | 👁️ | ✅ | ❌ | ❌ | ❌ | 👁️ | 👁️ | ❌ | ❌ | ✅ |
| **CARTAS DE SERVIÇO** | 👁️ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| **PROTOCOLO** | 📝 | ✅ | ❌ | ❌ | ❌ | 👁️ | 👁️ | ❌ | ✅ | ❌ |

**Legenda**:
- ✅ = Acesso total (criar, editar, excluir)
- 👁️ = Apenas visualização
- 📝 = Criar/editar próprios
- ❌ = Sem acesso

---

## 🏗️ ESTRUTURA TÉCNICA PROPOSTA

### 📊 Alterações na Tabela `users`:

#### **OPÇÃO 1: Campo `role` expandido**
```sql
ALTER TABLE users MODIFY COLUMN role ENUM(
    'user', 
    'admin', 
    'secretario', 
    'esic_responsavel', 
    'ouvidor', 
    'vereador', 
    'presidente', 
    'editor', 
    'protocolo', 
    'financeiro'
) DEFAULT 'user';
```

#### **OPÇÃO 2: Sistema de Permissões com Tabelas (RECOMENDADO)**
```sql
-- Tabela de Roles
CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabela de Permissões
CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    description TEXT,
    module VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabela de Relacionamento Role-Permission
CREATE TABLE role_permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id BIGINT UNSIGNED NOT NULL,
    permission_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_role_permission (role_id, permission_id)
);

-- Relacionamento User-Role (Many-to-Many)
CREATE TABLE user_roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_role (user_id, role_id)
);
```

### 🔧 Métodos Propostos para o Model User:

```php
// Verificações de Role
public function hasRole($role): bool
public function hasAnyRole(array $roles): bool
public function hasAllRoles(array $roles): bool

// Verificações de Permissão
public function hasPermission($permission): bool
public function hasAnyPermission(array $permissions): bool
public function hasAllPermissions(array $permissions): bool

// Verificações Específicas
public function canManageContent(): bool
public function canManageUsers(): bool
public function canManageEsic(): bool
public function canManageOuvidoria(): bool
public function canManageFinanceiro(): bool
public function canManageProtocolo(): bool
public function isVereador(): bool
public function isPresidente(): bool
```

### 🛡️ Middlewares Propostos:

```php
// Middleware por Role
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rotas administrativas
});

Route::middleware(['auth', 'role:secretario,admin'])->group(function () {
    // Rotas de secretário
});

// Middleware por Permissão
Route::middleware(['auth', 'permission:manage_noticias'])->group(function () {
    // Rotas de gestão de notícias
});

// Middleware Combinado
Route::middleware(['auth', 'role:admin|permission:manage_esic'])->group(function () {
    // Rotas flexíveis
});
```

---

## 📋 PERMISSÕES DETALHADAS POR MÓDULO

### 🗞️ **MÓDULO: NOTÍCIAS**
- `noticias.view` - Visualizar notícias
- `noticias.create` - Criar notícias
- `noticias.edit` - Editar notícias
- `noticias.delete` - Excluir notícias
- `noticias.publish` - Publicar/despublicar

### 📄 **MÓDULO: DOCUMENTOS**
- `documentos.view` - Visualizar documentos
- `documentos.create` - Criar documentos
- `documentos.edit` - Editar documentos
- `documentos.delete` - Excluir documentos
- `documentos.download` - Download de documentos

### 🏛️ **MÓDULO: SESSÕES**
- `sessoes.view` - Visualizar sessões
- `sessoes.create` - Criar sessões
- `sessoes.edit` - Editar sessões
- `sessoes.delete` - Excluir sessões
- `sessoes.ata` - Gerenciar atas
- `sessoes.pauta` - Gerenciar pautas

### ⚖️ **MÓDULO: PROJETOS DE LEI**
- `projetos.view` - Visualizar projetos
- `projetos.create` - Criar projetos
- `projetos.edit` - Editar projetos
- `projetos.delete` - Excluir projetos
- `projetos.tramitar` - Tramitar projetos
- `projetos.aprovar` - Aprovar/rejeitar

### 👥 **MÓDULO: VEREADORES**
- `vereadores.view` - Visualizar vereadores
- `vereadores.create` - Criar vereadores
- `vereadores.edit` - Editar vereadores
- `vereadores.delete` - Excluir vereadores

### 📋 **MÓDULO: e-SIC**
- `esic.view` - Visualizar solicitações
- `esic.create` - Criar solicitações
- `esic.respond` - Responder solicitações
- `esic.manage` - Gerenciar solicitações
- `esic.reports` - Relatórios e-SIC

### 📢 **MÓDULO: OUVIDORIA**
- `ouvidoria.view` - Visualizar manifestações
- `ouvidoria.create` - Criar manifestações
- `ouvidoria.respond` - Responder manifestações
- `ouvidoria.manage` - Gerenciar manifestações
- `ouvidoria.assign` - Atribuir manifestações

### 💰 **MÓDULO: TRANSPARÊNCIA**
- `transparencia.view` - Visualizar dados
- `transparencia.manage` - Gerenciar transparência
- `transparencia.upload` - Upload de relatórios

### 📋 **MÓDULO: PROTOCOLO**
- `protocolo.view` - Visualizar protocolos
- `protocolo.create` - Criar protocolos
- `protocolo.manage` - Gerenciar protocolos
- `protocolo.archive` - Arquivar documentos

### 👤 **MÓDULO: USUÁRIOS**
- `users.view` - Visualizar usuários
- `users.create` - Criar usuários
- `users.edit` - Editar usuários
- `users.delete` - Excluir usuários
- `users.permissions` - Gerenciar permissões

### ⚙️ **MÓDULO: SISTEMA**
- `system.config` - Configurações do sistema
- `system.logs` - Visualizar logs
- `system.backup` - Backup do sistema
- `system.maintenance` - Modo manutenção

---

## 🎯 RECOMENDAÇÕES DE IMPLEMENTAÇÃO

### 📊 **FASE 1: Preparação**
1. Criar migrations para novas tabelas
2. Criar models para Role e Permission
3. Implementar traits para User
4. Criar seeders com dados iniciais

### 📊 **FASE 2: Middlewares**
1. Criar middlewares de role e permission
2. Atualizar rotas existentes
3. Implementar verificações nos controllers

### 📊 **FASE 3: Interface**
1. Criar interface de gestão de roles
2. Criar interface de gestão de permissões
3. Atualizar formulários de usuários
4. Implementar dashboards específicos

### 📊 **FASE 4: Migração**
1. Migrar usuários existentes
2. Atribuir roles padrão
3. Testar todas as funcionalidades
4. Documentar o sistema

---

## 🔍 CONSIDERAÇÕES ESPECIAIS

### 🏛️ **VEREADORES**
- Relacionamento com tabela `vereadores` existente
- Verificação de mandato ativo
- Permissões baseadas em cargo (presidente, vice, etc.)

### 📋 **PROTOCOLO**
- Integração com sistema de numeração
- Controle de tramitação
- Arquivo digital de documentos

### 💰 **TRANSPARÊNCIA**
- Compliance com Lei de Acesso à Informação
- Relatórios automáticos
- Integração com sistemas externos

### 🔐 **SEGURANÇA**
- Logs de auditoria para ações sensíveis
- Verificação de integridade de permissões
- Backup de configurações de acesso

---

## 📈 BENEFÍCIOS ESPERADOS

### ✅ **ORGANIZAÇÃO**
- Separação clara de responsabilidades
- Redução de conflitos de acesso
- Melhor controle de qualidade

### ✅ **SEGURANÇA**
- Princípio do menor privilégio
- Rastreabilidade de ações
- Controle granular de acesso

### ✅ **EFICIÊNCIA**
- Dashboards específicos por perfil
- Fluxos de trabalho otimizados
- Redução de erros operacionais

### ✅ **COMPLIANCE**
- Atendimento a normas legais
- Transparência nos processos
- Auditoria facilitada

---

**📅 Data do Levantamento**: Janeiro 2025  
**🔄 Status**: Proposta inicial para análise  
**👤 Responsável**: Análise técnica do sistema atual  

---

> **📝 PRÓXIMOS PASSOS**: Após aprovação deste levantamento, proceder com a implementação das melhorias propostas, começando pela estrutura de banco de dados e models.