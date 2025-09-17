# Projeto: Portal da Câmara Municipal — Especificação Completa

> Documento de especificação, arquitetura técnica, modelo de dados, endpoints, requisitos não-funcionais, e fluxograma para implantação de portal de câmara municipal usando **Laravel + MySQL**. O ambiente Laravel já está rodando — este plano explica como integrar e desenvolver o portal completo, padronizado e escalável.

---

## 1. Resumo executivo

Objetivo: Construir um portal público e administrativo para uma câmara municipal que garanta:

* Transparência e fácil acesso a documentos legislativos, pautas, votações e vídeos;
* Notícias, perfis de vereadores e corpo administrativo;
* Consulta e download de acervos digitais (atas, leis, projetos, decretos);
* Funcionalidades de e-SIC e ouvidoria com protocolo e acompanhamento;
* Ferramentas de busca e APIs para terceiros;
* Segurança, acessibilidade (WCAG), escalabilidade e padrão visual institucional.

Público-alvo: cidadãos, servidores, imprensa, pesquisadores e órgãos integradores.

---

## 2. Principais módulos (visão funcional)

1. Portal público (site institucional)

   * Home com destaques (notícias, agenda, última sessão, canais ao vivo)
   * Notícias / Comunicados
   * Calendar (agenda de sessões, audiências públicas)
   * Páginas dos vereadores (biografia, gabinete, redes sociais, projetos)
   * Corpo administrativo (secretarias, contatos)
   * Comissões (membros, relatórios, reuniões)
   * Atas e vídeos das sessões (playback e downloads)
   * Documentos legislativos (projetos de lei, pareceres, leis aprovadas)
   * Acervo digital pesquisável (PDFs, imagens, multimídia)
   * Ferramenta de busca (full-text e filtros por tipo, data, autor)
   * Transparência (despesas, licitações, contratos — links ou integrações)
   * FAQ e Glossário jurídico

2. Área administrativa (intranets dos servidores)

   * Gestão de conteúdo (CMS para notícias, páginas, banners)
   * Gestão de vereadores / cargos / comissões
   * Upload e indexação de documentos (metadados e OCR opcional)
   * Workflow de publicação (rascunho, revisão, publicação)
   * Gerenciamento de sessões e pautas
   * Relatórios e estatísticas de acessos

3. Sistema de Protocolo / e-SIC e Ouvidoria

   * Protocolo com geração de número único (ex: CMS-2025-000123)
   * Formulário público com anexos e anexação segura
   * Painel administrativo para tramitar e responder pedidos
   * SLA, notificações por e‑mail e rastreamento por cidadão

4. Transparência ativa e passiva

   * Integração de pagamentos, balanços, contratos
   * Exportação de dados em formatos abertos (CSV/JSON)

5. APIs públicas

   * Endpoints para notícias, vereadores, leis e sessões (caching)

6. Segurança, auditoria e logs

   * Logs de alteração de conteúdo, histórico de versões
   * Controle de acesso baseado em papéis (RBAC)

---

## 3. Requisitos não-funcionais

* **Acessibilidade:** Compatibilidade com WCAG 2.1 AA.
* **Internacionalização (i18n):** PT-BR (possibilidade de outras línguas).
* **Performance:** Páginas principais <= 1 seg (cache em CDN + Redis).
* **Escalabilidade:** Stateless app; sessão em Redis; storage em S3/compatível.
* **Disponibilidade:** Redundância de webservers, backups diários de BD e arquivos.
* **Segurança:** HTTPS estrito, CSP, HSTS, rate-limiting, OWASP Top10 mitigations.
* **Conformidade legal:** manutenção de prazos de armazenamento, LGPD observada.

---

## 4. Stack técnica recomendada (base)

* Backend: Laravel (8/9/10+) — já em execução
* DB: MySQL 8.x
* Cache / Session: Redis
* File Storage: S3 (ou S3-compatível) para acervos; local em dev
* Busca Full-Text: ElasticSearch / Meilisearch / MySQL fulltext (Meilisearch recomendado para UX)
* Queue: Redis + Laravel Queue (horizon opcional)
* Filas de mídia (transcoding): FFmpeg em workers
* Autenticação: Laravel Sanctum (APIs) + OAuth2 (se integrar SSO municipal)
* Deploy: Docker + docker-compose; or Kubernetes para alta escala
* CI/CD: GitHub Actions / GitLab CI (migrate, test, build image, deploy)
* Observabilidade: Sentry (erros), Prometheus + Grafana (métricas), Loki (logs)

---

## 5. Arquitetura proposta (camadas)

* **Edge / CDN**: CloudFront ou Cloudflare (cache estático, WAF)
* **Load Balancer** -> **App Servers (Laravel, stateless)** -> **Redis** (cache/sessions) -> **MySQL (R/W)**
* **Workers** para jobs (media processing, OCR, envio de e-mails)
* **Object Storage** (S3) para documentos e mídia
* **Search Service** (Meilisearch) indexando conteúdo e metadados
* **Backup Service**: snapshots MySQL + versionamento S3

---

## 6. Modelo de dados principal (ERD resumido)

> Abaixo está o conjunto de tabelas essenciais e campos principais. Ajuste campos e índices conforme necessidade.

### Tabelas principais (resumo)

1. **users** (id, name, email, password\_hash, role\_id, phone, active, created\_at, updated\_at)
2. **roles** (id, name, permissions JSON)
3. **vereadores** (id, user\_id nullable, nome, partido, foto\_path, gabinete, contatos JSON, biografia TEXT, mandato\_inicio, mandato\_fim)
4. **noticias** (id, title, slug, summary, content, author\_id, status, featured\_image, published\_at)
5. **pages** (id, slug, title, content, meta\_tags JSON, status)
6. **comissoes** (id, nome, descricao, membros JSON, presidente\_id)
7. **sessoes** (id, data\_hora, tipo, pauta JSON, ata\_document\_id, video\_url, duracao)
8. **projetos\_lei** (id, numero, ano, autor\_id, status, ementa, texto\_original\_doc\_id, pareceres JSON, votacoes JSON)
9. **documents** (id, uuid, title, description, file\_path, mime, size, tags JSON, indexed BOOL, created\_by)
10. **attachments** (id, document\_id, model\_type, model\_id)
11. **esic\_requests** (id, protocolo, tipo, solicitante\_nome, email, status, message\_text, attachments JSON, created\_at, answered\_at)
12. **ouvidoria\_msgs** (id, protocolo, nome, contato, assunto, texto, resposta, status, created\_at)
13. **logs\_audit** (id, user\_id, action, model\_type, model\_id, diff JSON, ip, created\_at)
14. **visits\_stats** (id, path, hits, date)
15. **settings** (key, value JSON)

---

## 7. Índices e otimizações MySQL

* Índices em `slug`, `published_at`, `author_id`, `numero+ano` (projetos\_lei).
* Use `InnoDB` e particionamento por data para tabelas massivas (ex.: visitas, logs).
* Full-text: usar Meilisearch/Elastic para conteúdo grande; MySQL fulltext apenas como fallback.
* Armazenar metadados e tags em colunas JSON para extensibilidade — indexar com generated columns quando precisar filtrar.

---

## 8. Endpoints REST (públicos e administrativos)

### Públicos (GET)

* `GET /api/v1/noticias` — listagem (filtros: q, tag, date\_from, author)
* `GET /api/v1/noticias/{slug}`
* `GET /api/v1/vereadores` — lista
* `GET /api/v1/vereadores/{id}`
* `GET /api/v1/sessoes` — agenda e atas
* `GET /api/v1/projetos` — projetos de lei
* `GET /api/v1/documents/{uuid}` — download (signed URL)
* `GET /api/v1/search?q=...` — busca universal

### Autenticados/Admin (POST/PUT/DELETE) — via JWT/Sanctum

* `POST /api/v1/admin/noticias` — criar
* `PUT /api/v1/admin/noticias/{id}` — editar
* `DELETE /api/v1/admin/noticias/{id}` — excluir
* `POST /api/v1/admin/documents` — upload
* `POST /api/v1/esic` — abrir protocolo (público)
* `POST /api/v1/ouvidoria` — mensagem pública

> Sugestão: rotas `admin/*` agrupadas e protegidas por middleware `role:editor|admin`.

---

## 9. UI: Estrutura de páginas e componentes

### Páginas públicas

* Home (carrossel, notícias, próxima sessão, atalho e-SIC)
* Notícias (lista), Página de notícia
* Vereadores (lista), Perfil de vereador
* Sessões (agenda), Página da sessão (atas e vídeo)
* Projetos de Lei (lista + ficha com histórico de tramitação)
* Comissões (detalhe e atas)
* Documentos / Biblioteca digital (filtros avançados)
* Transparência (separado ou integrado)
* e-SIC / Ouvidoria (forms e consulta de protocolo)
* Busca avançada

### Painel/Admin

* Dashboard (indicadores: protocolos pendentes, últimas publicações)
* CMS (Editor WYSIWYG/Markdown com upload de mídia)
* Gestão de vereadores/comissões
* Gestão de sessões/pautas
* Gestão documental (indexação e versionamento)
* Protocolo e Ouvidoria (workflow)

---

## 10. Fluxo de publicação (workflow)

1. Criação (Editor) → 2. Revisão (Chefia) → 3. Aprovação (Admin) → 4. Publicação (ambientação em cache/CDN)

* Cada etapa registra `logs_audit` e e-mails de notificação.

---

## 11. Fluxograma: Visão geral do sistema

```text
[Visitante] --> [Portal Publico]
[Portal Publico] -->|consulta| [Search Service]
[Portal Publico] -->|download| [Object Storage (S3)]
[Editor] --> [Painel Admin] --> [Workflow: rascunho->revisão->publicar]
[Painel Admin] -->|cria doc| [Documents Table] --> (index) --> [Search Service]
[Usuario Publico] -->|abre protocolo| [e-SIC Service] --> [Admin Tramitação]
[Sessions] --> [Video Storage] + [Transcoding Workers]
App Servers <--> Redis (session/cache)
App Servers <--> MySQL (dados mestres)
Workers --> Processos Pesados (OCR, Transcoding, Notificações)

```

Também incluo um **PlantUML** simplificado (copiar/colar em um editor PlantUML):

```
@startuml
actor Visitante
actor Editor
node "Portal Público" as Portal
node "Painel Admin" as Admin
database MySQL
queue Redis
storage S3
Visitante --> Portal: consulta
Portal --> MySQL: get conteúdo
Portal --> Redis: cache check
Editor --> Admin: editar
Admin --> MySQL: salvar
Admin -> S3: upload documento
Admin --> Redis: invalidate cache
@enduml
```

---

## 12. Migração de conteúdo (passo-a-passo)

1. Inventariar arquivo atual (listar URLs, PDFs, metadados).
2. Mapear campos para a tabela `documents` e `noticias`.
3. Padronizar nomes, slugs e datas; criar CSVs de importação.
4. Script de import (Laravel Artisan command) que:

   * grava registros em `documents`, transfere arquivos para S3,
   * cria `noticias` e vincula `attachments`.
5. Rodar em staging, validar links e integridade, depois em produção.

**Exemplo de comando artisan de import**: `php artisan import:legacy --source=legacy.csv`

---

## 13. Segurança e LGPD

* Criptografia de arquivos sensíveis em repouso (S3 + KMS).
* Consentimento em formulários (cookies e e-SIC/ouvidoria)
* Retenção: políticas de purge para dados pessoais (ex.: logs, anexos temporários)
* Revisão de permissões e scanning de vulnerabilidades em CI
* Proteção contra upload malicioso (verificar MIME, abrir arquivos em workers seguros)

---

## 14. Testes e QA

* Testes automatizados: unitários (PHPUnit), feature tests (Laravel), integração de API.
* Testes de usabilidade com amostra de cidadãos.
* Auditoria de acessibilidade (axe, Lighthouse)

---

## 15. Deploy, infraestrutura mínima recomendada (produção)

* 2+ app instances (Docker) atrás de LB
* RDS MySQL (primário + réplica leitura)
* Redis (clustered)
* S3 (storage) + CloudFront
* Workers (2+) para filas
* Certbot/ACM para TLS e WAF (Cloudflare/Cloudfront)

---

## 16. Observabilidade e monitoramento

* Métricas: requisições, latência, jobs pendentes
* Logs centralizados (Loki/ELK)
* Alertas: erros 5xx, filas com backlog, falha de backups

---

## 17. Boas práticas de desenvolvimento e pacotes Laravel sugeridos

* Spatie packages: `spatie/laravel-permission`, `spatie/laravel-medialibrary`, `spatie/laravel-activitylog`.
* `laravel/scout` + `meilisearch` driver
* `laravel/horizon` para monitorar filas Redis
* `laravel/sanctum` para APIs
* `barryvdh/laravel-dompdf` para geração de PDFs de atas
* `spatie/laravel-backup` para rotinas de backup

---

## 18. Exemplo de migration (exemplo mínimo: `documents`)

```php
Schema::create('documents', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('file_path');
    $table->string('mime', 100);
    $table->bigInteger('size')->unsigned();
    $table->json('tags')->nullable();
    $table->boolean('indexed')->default(false);
    $table->foreignId('created_by')->constrained('users');
    $table->timestamps();
});
```

---

## 19. Checklist de entrega mínima (MVP)

* [ ] Home público com notícias, agenda e busca básica
* [ ] Páginas de vereadores e comissões
* [ ] Upload e listagem de documentos
* [ ] e-SIC com protocolo e painel de tramitação
* [ ] Painel administrativo com workflow básico
* [ ] API pública com endpoints principais
* [ ] Logs de auditoria e backups automáticos

---

## 20. Próximos passos recomendados (prioritização)

1. Definir modelo visual / identidade (wireframes)
2. Fazer inventário de conteúdo atual (import)
3. Implementar DB e migrations para entidades principais
4. Construir endpoints públicos e CMS de notícias
5. Implantar e-SIC e testes de processo
6. Indexação search + otimizações

---

### Contato e acompanhamento

Se quiser, eu posso:

* Gerar migrations completas e skeleton controllers/routes para o Laravel; ou
* Criar comandos artisan para importação do acervo legado; ou
* Gerar um draft de frontend (Blade / Inertia / Vue) com layout padrão inspirado nos sites mencionados.

---
