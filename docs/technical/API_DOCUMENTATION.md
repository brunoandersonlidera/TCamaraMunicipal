# Documentação da API - TCamaraMunicipal

## Visão Geral

O sistema TCamaraMunicipal oferece uma API REST para integração com sistemas externos e funcionalidades AJAX. A API está integrada às rotas web e utiliza autenticação baseada em sessão Laravel.

## Autenticação

### Tipos de Autenticação

1. **Sessão Web** - Para usuários logados no sistema
2. **Middleware de Permissões** - Para funcionalidades administrativas
3. **Acesso Público** - Para endpoints de consulta pública

### Middleware Utilizados

- `auth` - Requer autenticação
- `admin` - Requer permissões administrativas
- `ouvidor` - Requer permissões de ouvidor
- `permission:nome.permissao` - Requer permissão específica

## Endpoints da API

### 1. API de Busca

#### Busca Geral
```
GET /api/busca
```

**Parâmetros:**
- `q` (string, obrigatório) - Termo de busca
- `category` (string, opcional) - Categoria específica
  - Valores: `all`, `noticias`, `vereadores`, `projetos`, `documentos`, `sessoes`, `transparencia`, `keywords`
- `limit` (integer, opcional) - Limite de resultados (padrão: 10)

**Resposta:**
```json
{
  "results": [
    {
      "type": "noticia",
      "title": "Título da notícia",
      "url": "/noticias/slug-da-noticia",
      "description": "Descrição da notícia",
      "date": "2025-01-21"
    }
  ],
  "total": 25
}
```

**Controlador:** `SearchController@api`

### 2. API de Mídia

#### Listar Mídias
```
GET /admin/media-api
```

**Autenticação:** Requerida (admin)

**Parâmetros:**
- `category` (string, opcional) - Filtrar por categoria
- `type` (string, opcional) - Filtrar por tipo de arquivo
- `search` (string, opcional) - Buscar por nome ou título
- `page` (integer, opcional) - Página (padrão: 1)
- `per_page` (integer, opcional) - Itens por página (padrão: 20)

**Resposta:**
```json
{
  "success": true,
  "media": [
    {
      "id": 1,
      "original_name": "documento.pdf",
      "title": "Documento Importante",
      "file_path": "/storage/media/documento.pdf",
      "file_size": 1024000,
      "mime_type": "application/pdf",
      "created_at": "2025-01-21T10:00:00Z"
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 20,
    "total": 100,
    "from": 1,
    "to": 20
  }
}
```

**Controlador:** `MediaController@api`

### 3. API de Transparência

#### Evolução Mensal
```
GET /api/evolucao-mensal
```

**Acesso:** Público

**Resposta:**
```json
{
  "receitas": [
    {
      "mes": "2025-01",
      "valor": 150000.00
    }
  ],
  "despesas": [
    {
      "mes": "2025-01",
      "valor": 120000.00
    }
  ]
}
```

**Controlador:** `TransparenciaController@evolucaoMensalJson`

### 4. API de Leis

#### Buscar Leis (AJAX)
```
GET /api/leis/buscar
```

**Acesso:** Público

**Parâmetros:**
- `q` (string, opcional) - Termo de busca
- `tipo` (string, opcional) - Tipo de lei
- `exercicio` (integer, opcional) - Ano de exercício
- `page` (integer, opcional) - Página

**Resposta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "numero": "001/2025",
      "titulo": "Lei Municipal sobre...",
      "tipo": "Lei Ordinária",
      "data_publicacao": "2025-01-15",
      "url": "/leis/001-2025"
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 3,
    "total": 50
  }
}
```

**Controlador:** `LeisController@buscarAjax`

### 5. API do Ouvidor

#### Estatísticas do Dashboard
```
GET /ouvidor/stats
```

**Autenticação:** Requerida (ouvidor)

**Resposta:**
```json
{
  "total_manifestacoes": 150,
  "pendentes": 25,
  "em_andamento": 30,
  "respondidas": 95,
  "prazo_medio_resposta": 5.2
}
```

**Controlador:** `Ouvidor\DashboardController@getStats`

#### Dados de Performance
```
GET /ouvidor/performance-data
```

**Autenticação:** Requerida (ouvidor)

**Resposta:**
```json
{
  "labels": ["Jan", "Fev", "Mar"],
  "datasets": [
    {
      "label": "Manifestações Recebidas",
      "data": [45, 52, 38]
    },
    {
      "label": "Manifestações Respondidas",
      "data": [40, 48, 35]
    }
  ]
}
```

**Controlador:** `Ouvidor\DashboardController@getPerformanceData`

#### Dados por Status
```
GET /ouvidor/status-data
```

**Autenticação:** Requerida (ouvidor)

**Resposta:**
```json
{
  "labels": ["Pendente", "Em Andamento", "Respondida"],
  "data": [25, 30, 95]
}
```

**Controlador:** `Ouvidor\DashboardController@getStatusData`

#### Dados por Tipo
```
GET /ouvidor/tipo-data
```

**Autenticação:** Requerida (ouvidor)

**Resposta:**
```json
{
  "labels": ["Reclamação", "Sugestão", "Elogio"],
  "data": [80, 45, 25]
}
```

**Controlador:** `Ouvidor\DashboardController@getTipoData`

#### Notificações
```
GET /ouvidor/notifications
```

**Autenticação:** Requerida (ouvidor)

**Resposta:**
```json
{
  "notifications": [
    {
      "id": 1,
      "message": "Nova manifestação recebida",
      "type": "info",
      "read": false,
      "created_at": "2025-01-21T10:00:00Z"
    }
  ],
  "unread_count": 5
}
```

**Controlador:** `Ouvidor\DashboardController@getNotifications`

#### Marcar Notificação como Lida
```
POST /ouvidor/notifications/{id}/read
```

**Autenticação:** Requerida (ouvidor)

**Resposta:**
```json
{
  "success": true,
  "message": "Notificação marcada como lida"
}
```

**Controlador:** `Ouvidor\DashboardController@markNotificationAsRead`

#### Buscar Manifestações
```
GET /ouvidor/manifestacoes/search
```

**Autenticação:** Requerida (ouvidor)

**Parâmetros:**
- `q` (string, opcional) - Termo de busca
- `status` (string, opcional) - Filtrar por status
- `tipo` (string, opcional) - Filtrar por tipo
- `data_inicio` (date, opcional) - Data inicial
- `data_fim` (date, opcional) - Data final

**Resposta:**
```json
{
  "manifestacoes": [
    {
      "id": 1,
      "protocolo": "2025010001",
      "tipo": "reclamacao",
      "assunto": "Problema na iluminação",
      "status": "pendente",
      "created_at": "2025-01-21T10:00:00Z"
    }
  ],
  "total": 25
}
```

**Controlador:** `Ouvidor\DashboardController@searchManifestacoes`

### 6. API de Acesso Rápido (Admin)

#### Alterar Status
```
PATCH /admin/acesso-rapido/{id}/toggle-status
```

**Autenticação:** Requerida (admin)

**Resposta:**
```json
{
  "success": true,
  "message": "Status alterado com sucesso",
  "ativo": true
}
```

**Controlador:** `Admin\AcessoRapidoController@toggleStatus`

#### Atualizar Ordem
```
POST /admin/acesso-rapido/update-order
```

**Autenticação:** Requerida (admin)

**Parâmetros:**
- `items` (array, obrigatório) - Array com IDs na nova ordem

**Resposta:**
```json
{
  "success": true,
  "message": "Ordem atualizada com sucesso"
}
```

**Controlador:** `Admin\AcessoRapidoController@updateOrder`

## Códigos de Status HTTP

### Sucesso
- `200 OK` - Requisição bem-sucedida
- `201 Created` - Recurso criado com sucesso

### Erro do Cliente
- `400 Bad Request` - Dados inválidos
- `401 Unauthorized` - Não autenticado
- `403 Forbidden` - Sem permissão
- `404 Not Found` - Recurso não encontrado
- `422 Unprocessable Entity` - Erro de validação

### Erro do Servidor
- `500 Internal Server Error` - Erro interno do servidor

## Formato de Resposta de Erro

```json
{
  "success": false,
  "message": "Mensagem de erro",
  "errors": {
    "campo": ["Erro específico do campo"]
  }
}
```

## Headers Recomendados

### Requisições
```
Content-Type: application/json
Accept: application/json
X-Requested-With: XMLHttpRequest
```

### Respostas
```
Content-Type: application/json
Cache-Control: no-cache, private
```

## Paginação

A maioria dos endpoints que retornam listas utilizam paginação:

```json
{
  "data": [...],
  "pagination": {
    "current_page": 1,
    "last_page": 10,
    "per_page": 20,
    "total": 200,
    "from": 1,
    "to": 20
  }
}
```

## Rate Limiting

Atualmente não há rate limiting implementado, mas recomenda-se:
- Máximo 60 requisições por minuto para usuários autenticados
- Máximo 30 requisições por minuto para usuários não autenticados

## Versionamento

A API atual não possui versionamento. Futuras versões devem seguir o padrão:
- `/api/v1/endpoint`
- `/api/v2/endpoint`

## Exemplos de Uso

### JavaScript (Fetch API)

```javascript
// Busca geral
fetch('/api/busca?q=transparencia&category=all&limit=5')
  .then(response => response.json())
  .then(data => {
    console.log('Resultados:', data.results);
  });

// Upload de mídia (com autenticação)
const formData = new FormData();
formData.append('file', fileInput.files[0]);

fetch('/admin/media-api', {
  method: 'POST',
  body: formData,
  headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  }
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    console.log('Upload realizado:', data.media);
  }
});
```

### jQuery

```javascript
// Buscar leis
$.ajax({
  url: '/api/leis/buscar',
  method: 'GET',
  data: {
    q: 'orçamento',
    tipo: 'Lei Ordinária',
    exercicio: 2025
  },
  success: function(response) {
    if (response.success) {
      // Processar resultados
      response.data.forEach(function(lei) {
        console.log(lei.titulo);
      });
    }
  }
});
```

## Segurança

### CSRF Protection
Todas as requisições POST, PUT, PATCH e DELETE requerem token CSRF:

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

```javascript
headers: {
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
}
```

### Validação de Dados
- Todos os inputs são validados
- Sanitização automática de dados
- Proteção contra SQL Injection
- Proteção contra XSS

### Logs de Auditoria
- Todas as ações administrativas são logadas
- Logs incluem usuário, ação e timestamp
- Logs são armazenados em `storage/logs/`

## Monitoramento

### Métricas Recomendadas
- Tempo de resposta por endpoint
- Taxa de erro por endpoint
- Número de requisições por minuto
- Uso de recursos (CPU, memória)

### Logs
- Logs de aplicação: `storage/logs/laravel.log`
- Logs de erro: `storage/logs/error.log`
- Logs de acesso: configurar no servidor web

## Troubleshooting

### Problemas Comuns

1. **Erro 419 (CSRF Token Mismatch)**
   - Verificar se o token CSRF está sendo enviado
   - Verificar se a sessão não expirou

2. **Erro 401 (Unauthorized)**
   - Verificar autenticação
   - Verificar se o usuário tem as permissões necessárias

3. **Erro 500 (Internal Server Error)**
   - Verificar logs em `storage/logs/laravel.log`
   - Verificar configuração do banco de dados

### Debug

Para habilitar debug detalhado:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## Roadmap

### Funcionalidades Futuras
- [ ] API REST completa com versionamento
- [ ] Autenticação via API Token
- [ ] Rate limiting configurável
- [ ] Documentação OpenAPI/Swagger
- [ ] Webhooks para eventos
- [ ] GraphQL endpoint
- [ ] Cache inteligente de respostas

### Melhorias Planejadas
- [ ] Padronização de respostas JSON
- [ ] Middleware de transformação de dados
- [ ] Validação de schema JSON
- [ ] Compressão de respostas
- [ ] Suporte a CORS configurável

## Suporte

Para dúvidas sobre a API:
- Consulte os logs do sistema
- Verifique a documentação do Laravel
- Entre em contato com a equipe de desenvolvimento

---

**Última atualização:** 21 de Janeiro de 2025  
**Versão:** 1.0  
**Compatibilidade:** Laravel 12.0, PHP 8.2+