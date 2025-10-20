# Documentação de Arquitetura - TCamaraMunicipal

## Visão Geral

O sistema TCamaraMunicipal é uma aplicação web desenvolvida em Laravel 11 para gestão de câmaras municipais, oferecendo funcionalidades para transparência pública, gestão legislativa, ouvidoria e e-SIC (Sistema Eletrônico do Serviço de Informação ao Cidadão).

### Características Principais

- **Framework:** Laravel 11.x
- **PHP:** 8.2+
- **Frontend:** Blade Templates + Bootstrap 5 + Vite
- **Banco de Dados:** MySQL/MariaDB (SQLite para desenvolvimento)
- **Cache:** Redis (opcional)
- **Arquitetura:** MVC (Model-View-Controller)
- **Padrão:** Repository Pattern (parcial)

## Arquitetura do Sistema

### 1. Arquitetura de Alto Nível

```
┌─────────────────────────────────────────────────────────────┐
│                    FRONTEND (Blade + JS)                    │
├─────────────────────────────────────────────────────────────┤
│                    MIDDLEWARE LAYER                         │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────────┐ │
│  │    Auth     │ │ Permission  │ │    CSRF/Throttle        │ │
│  └─────────────┘ └─────────────┘ └─────────────────────────┘ │
├─────────────────────────────────────────────────────────────┤
│                   CONTROLLER LAYER                          │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────────┐ │
│  │   Public    │ │    Admin    │ │       API               │ │
│  └─────────────┘ └─────────────┘ └─────────────────────────┘ │
├─────────────────────────────────────────────────────────────┤
│                    SERVICE LAYER                            │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────────┐ │
│  │   Business  │ │   Validation│ │    File Management      │ │
│  │    Logic    │ │   Services  │ │                         │ │
│  └─────────────┘ └─────────────┘ └─────────────────────────┘ │
├─────────────────────────────────────────────────────────────┤
│                     MODEL LAYER                             │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────────┐ │
│  │  Eloquent   │ │ Relationships│ │    Scopes/Mutators     │ │
│  │   Models    │ │              │ │                         │ │
│  └─────────────┘ └─────────────┘ └─────────────────────────┘ │
├─────────────────────────────────────────────────────────────┤
│                   DATABASE LAYER                            │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────────┐ │
│  │   MySQL     │ │   Redis     │ │    File Storage         │ │
│  │  (Primary)  │ │  (Cache)    │ │                         │ │
│  └─────────────┘ └─────────────┘ └─────────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

### 2. Estrutura de Diretórios

```
TCamaraMunicipal/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controladores da aplicação
│   │   │   ├── Admin/            # Controladores administrativos
│   │   │   ├── Ouvidor/          # Controladores da ouvidoria
│   │   │   └── ...               # Controladores públicos
│   │   ├── Middleware/           # Middlewares customizados
│   │   └── Requests/             # Form Requests (validação)
│   ├── Models/                   # Models Eloquent
│   ├── Providers/                # Service Providers
│   └── Services/                 # Serviços de negócio
├── config/                       # Configurações do sistema
├── database/
│   ├── migrations/               # Migrações do banco
│   ├── seeders/                  # Seeders para dados iniciais
│   └── factories/                # Factories para testes
├── resources/
│   ├── views/                    # Templates Blade
│   │   ├── admin/                # Views administrativas
│   │   ├── public/               # Views públicas
│   │   └── layouts/              # Layouts base
│   ├── js/                       # JavaScript/TypeScript
│   └── css/                      # Estilos CSS/SCSS
├── routes/
│   ├── web.php                   # Rotas web
│   └── api.php                   # Rotas API
├── storage/
│   ├── app/                      # Arquivos da aplicação
│   ├── logs/                     # Logs do sistema
│   └── framework/                # Cache do framework
└── public/                       # Arquivos públicos
```

## Camadas da Aplicação

### 1. Camada de Apresentação (Frontend)

#### Tecnologias
- **Blade Templates:** Sistema de templates do Laravel
- **Bootstrap 5:** Framework CSS responsivo
- **Vite:** Build tool para assets
- **JavaScript:** Funcionalidades interativas
- **Chart.js:** Gráficos e dashboards

#### Estrutura de Views
```
resources/views/
├── layouts/
│   ├── app.blade.php             # Layout principal
│   ├── admin.blade.php           # Layout administrativo
│   └── public.blade.php          # Layout público
├── components/                   # Componentes reutilizáveis
├── admin/                        # Views administrativas
│   ├── dashboard.blade.php
│   ├── users/
│   ├── noticias/
│   └── ...
└── public/                       # Views públicas
    ├── home.blade.php
    ├── noticias/
    └── ...
```

### 2. Camada de Controle (Controllers)

#### Estrutura de Controladores
```php
// Controlador Base
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

// Controladores Administrativos
namespace App\Http\Controllers\Admin;

// Controladores Públicos
namespace App\Http\Controllers;

// Controladores de API
namespace App\Http\Controllers\Api;
```

#### Principais Controladores
- **AdminController:** Dashboard administrativo
- **NoticiaController:** Gestão de notícias
- **VereadorController:** Gestão de vereadores
- **SessaoController:** Gestão de sessões
- **ProjetoLeiController:** Gestão de projetos de lei
- **EsicController:** Sistema e-SIC
- **OuvidoriaController:** Sistema de ouvidoria
- **SearchController:** Sistema de busca

### 3. Camada de Middleware

#### Middlewares de Segurança
```php
// Autenticação
'auth' => \App\Http\Middleware\Authenticate::class,

// Autorização por Role
'admin' => \App\Http\Middleware\AdminMiddleware::class,
'role' => \App\Http\Middleware\RoleMiddleware::class,

// Autorização por Permissão
'permission' => \App\Http\Middleware\PermissionMiddleware::class,

// Ouvidoria
'ouvidor' => \App\Http\Middleware\OuvidorMiddleware::class,

// Validação de Dados
'validate.autoria' => \App\Http\Middleware\ValidateAutoriaType::class,
```

#### Fluxo de Middleware
```
Request → CSRF → Throttle → Auth → Role/Permission → Controller
```

### 4. Camada de Modelo (Models)

#### Principais Models

##### User (Usuário)
```php
class User extends Authenticatable
{
    // Relacionamentos
    public function vereador(): HasOne
    public function noticias(): HasMany
    public function documentos(): HasMany
    
    // Métodos de Autorização
    public function isAdmin(): bool
    public function canAccessAdmin(): bool
    public function hasRole(string $role): bool
    public function hasPermission(string $permission): bool
}
```

##### Vereador
```php
class Vereador extends Model
{
    // Relacionamentos
    public function projetosLei(): HasMany
    public function noticias(): HasMany
    public function sessoes(): BelongsToMany
    
    // Scopes
    public function scopeAtivos($query)
    public function scopePresidente($query)
}
```

##### Sessao
```php
class Sessao extends Model
{
    // Relacionamentos
    public function tipoSessao(): BelongsTo
    public function presidenteSessao(): BelongsTo
    public function vereadores(): BelongsToMany
    public function projetosLei(): BelongsToMany
    
    // Métodos de Negócio
    public function podeSerEditada(): bool
    public function adicionarItemPauta($item): void
    public function registrarPresenca($vereadorId, $presente): void
}
```

##### Noticia
```php
class Noticia extends Model
{
    // Relacionamentos
    public function autor(): BelongsTo
    public function vereadorAutor(): BelongsTo
    
    // Scopes
    public function scopePublicadas($query)
    public function scopeFeatured($query)
}
```

#### Relacionamentos Principais
```
User (1) ←→ (0..1) Vereador
User (1) ←→ (0..*) Noticia
Vereador (1) ←→ (0..*) ProjetoLei
Sessao (0..*) ←→ (0..*) Vereador
Sessao (0..*) ←→ (0..*) ProjetoLei
```

### 5. Camada de Dados

#### Banco de Dados Principal (MySQL)
```sql
-- Tabelas Principais
users                    -- Usuários do sistema
vereadores              -- Dados dos vereadores
sessoes                 -- Sessões plenárias
projetos_lei            -- Projetos de lei
noticias                -- Notícias e publicações
documentos              -- Documentos oficiais
esic_solicitacoes       -- Solicitações e-SIC
ouvidoria_manifestacoes -- Manifestações da ouvidoria
carta_servicos          -- Cartas de serviço
menus                   -- Sistema de menus dinâmicos
```

#### Cache (Redis)
```php
// Configuração de Cache
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),
    'default' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_DB', '0'),
    ],
    'cache' => [
        'database' => env('REDIS_CACHE_DB', '1'),
    ],
    'session' => [
        'database' => env('REDIS_SESSION_DB', '2'),
    ],
]
```

## Sistema de Autenticação e Autorização

### 1. Autenticação

#### Configuração
```php
// config/auth.php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],
```

#### Tipos de Usuário
```php
// Roles disponíveis
'roles' => [
    'super_admin'     => 'Super Administrador',
    'admin'           => 'Administrador',
    'secretario'      => 'Secretário',
    'esic_responsavel'=> 'Responsável e-SIC',
    'ouvidor'         => 'Ouvidor',
    'vereador'        => 'Vereador',
    'presidente'      => 'Presidente',
    'editor'          => 'Editor',
    'protocolo'       => 'Protocolo',
    'contador'        => 'Contador',
    'cidadao'         => 'Cidadão',
]
```

### 2. Sistema de Permissões

#### Estrutura de Permissões
```php
// Formato: módulo.ação
'permissions' => [
    // Sistema
    'system.admin'           => 'Administração do Sistema',
    'system.users'           => 'Gerenciar Usuários',
    'system.permissions'     => 'Gerenciar Permissões',
    
    // Conteúdo
    'noticias.create'        => 'Criar Notícias',
    'noticias.edit'          => 'Editar Notícias',
    'noticias.delete'        => 'Excluir Notícias',
    'noticias.publish'       => 'Publicar Notícias',
    
    // Legislativo
    'sessoes.create'         => 'Criar Sessões',
    'sessoes.edit'           => 'Editar Sessões',
    'projetos.create'        => 'Criar Projetos',
    'projetos.tramitar'      => 'Tramitar Projetos',
    
    // Transparência
    'transparency.view'      => 'Visualizar Transparência',
    'transparency.manage'    => 'Gerenciar Transparência',
    
    // Ouvidoria
    'ouvidor.view'          => 'Visualizar Manifestações',
    'ouvidor.respond'       => 'Responder Manifestações',
    
    // E-SIC
    'esic.view'             => 'Visualizar Solicitações',
    'esic.respond'          => 'Responder Solicitações',
]
```

## APIs e Integrações

### 1. API REST

#### Endpoints Principais
```php
// Busca Geral
GET /api/busca?q={termo}&category={categoria}&limit={limite}

// Mídia
GET /admin/media-api?category={categoria}&type={tipo}&search={busca}

// Transparência
GET /api/transparencia/evolucao-mensal?ano={ano}

// Ouvidoria (Autenticado)
GET /ouvidor/api/stats
GET /ouvidor/api/performance-data
GET /ouvidor/api/manifestacoes
```

#### Autenticação da API
```php
// Middleware de autenticação
'api' => [
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

// Autenticação por sessão (web)
Route::middleware(['auth', 'permission:api.access'])->group(function () {
    // Rotas protegidas
});
```

### 2. Integrações Externas

#### E-mail
```php
// Configuração SMTP
'smtp' => [
    'transport' => 'smtp',
    'host' => env('MAIL_HOST', '127.0.0.1'),
    'port' => env('MAIL_PORT', 2525),
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
],
```

#### Backup
```php
// Spatie Laravel Backup
'backup' => [
    'name' => env('APP_NAME', 'laravel-backup'),
    'source' => [
        'files' => [
            'include' => [
                base_path(),
            ],
            'exclude' => [
                base_path('vendor'),
                base_path('node_modules'),
            ],
        ],
        'databases' => [
            'mysql',
        ],
    ],
],
```

## Performance e Otimização

### 1. Cache

#### Estratégias de Cache
```php
// Cache de Views
php artisan view:cache

// Cache de Rotas
php artisan route:cache

// Cache de Configuração
php artisan config:cache

// Cache de Dados (Redis)
Cache::remember('noticias.featured', 3600, function () {
    return Noticia::featured()->limit(5)->get();
});
```

#### Cache de Consultas
```php
// Cache de relacionamentos
$vereador = Vereador::with(['projetosLei' => function($query) {
    $query->remember(3600);
}])->find($id);

// Cache de contadores
$stats = Cache::remember('dashboard.stats', 1800, function () {
    return [
        'total_noticias' => Noticia::count(),
        'total_projetos' => ProjetoLei::count(),
        'total_sessoes' => Sessao::count(),
    ];
});
```

### 2. Otimização de Banco de Dados

#### Índices Importantes
```sql
-- Índices de performance
CREATE INDEX idx_noticias_status_published ON noticias(status, data_publicacao);
CREATE INDEX idx_sessoes_data_status ON sessoes(data_sessao, status);
CREATE INDEX idx_projetos_status_autor ON projetos_lei(status, autor_id);
CREATE INDEX idx_users_role_active ON users(role, active);
```

#### Eager Loading
```php
// Evitar N+1 queries
$noticias = Noticia::with(['autor', 'vereadorAutor'])
    ->publicadas()
    ->paginate(10);

$sessoes = Sessao::with(['presidenteSessao', 'vereadores', 'projetosLei'])
    ->orderBy('data_sessao', 'desc')
    ->get();
```

### 3. Otimização de Assets

#### Vite Configuration
```javascript
// vite.config.js
export default defineConfig({
    plugins: [laravel({
        input: [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/css/admin.css',
            'resources/js/admin.js',
        ],
        refresh: true,
    })],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['bootstrap', 'jquery'],
                    charts: ['chart.js'],
                }
            }
        }
    }
});
```

## Segurança

### 1. Proteções Implementadas

#### CSRF Protection
```php
// Middleware CSRF ativo por padrão
'web' => [
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
],
```

#### XSS Protection
```php
// Sanitização automática via Blade
{{ $content }} // Escapado automaticamente
{!! $content !!} // HTML não escapado (usar com cuidado)

// Validação de entrada
$request->validate([
    'content' => 'required|string|max:10000',
    'title' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-_.,!?]+$/',
]);
```

#### SQL Injection Protection
```php
// Eloquent ORM protege automaticamente
User::where('email', $email)->first(); // Seguro

// Query Builder com bindings
DB::select('SELECT * FROM users WHERE email = ?', [$email]); // Seguro
```

### 2. Validação de Dados

#### Form Requests
```php
class StoreNoticiaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'status' => 'required|in:rascunho,publicado,arquivado',
            'data_publicacao' => 'nullable|date|after_or_equal:today',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
```

#### Middleware de Validação
```php
class ValidateAutoriaType
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('POST') || $request->isMethod('PUT')) {
            $this->validateAutoriaType($request);
        }
        return $next($request);
    }
}
```

## Monitoramento e Logs

### 1. Sistema de Logs

#### Configuração de Logs
```php
// config/logging.php
'channels' => [
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
    ],
    'security' => [
        'driver' => 'daily',
        'path' => storage_path('logs/security.log'),
        'level' => 'info',
        'days' => 30,
    ],
],
```

#### Logs de Auditoria
```php
// Log de ações administrativas
Log::channel('security')->info('User action', [
    'user_id' => auth()->id(),
    'action' => 'create_noticia',
    'resource_id' => $noticia->id,
    'ip' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

### 2. Monitoramento de Performance

#### Métricas Importantes
- Tempo de resposta das páginas
- Uso de memória
- Queries por requisição
- Taxa de erro
- Uptime do sistema

#### Health Checks
```php
// Route para health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::store()->getStore()->connection()->ping() ? 'connected' : 'disconnected',
        'timestamp' => now()->toISOString(),
    ]);
});
```

## Deployment e DevOps

### 1. Ambientes

#### Desenvolvimento
```env
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

#### Produção
```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 2. CI/CD Pipeline

#### Processo de Deploy
```bash
# 1. Backup
php artisan backup:run

# 2. Manutenção
php artisan down

# 3. Atualização
git pull origin main
composer install --no-dev --optimize-autoloader

# 4. Migrações
php artisan migrate --force

# 5. Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Assets
npm ci
npm run build

# 7. Permissões
chmod -R 755 storage bootstrap/cache

# 8. Volta online
php artisan up
```

## Escalabilidade

### 1. Estratégias de Escala

#### Horizontal Scaling
- Load balancer (Nginx/Apache)
- Múltiplas instâncias da aplicação
- Banco de dados com read replicas
- CDN para assets estáticos

#### Vertical Scaling
- Aumento de recursos do servidor
- Otimização de queries
- Cache mais agressivo
- Compressão de assets

### 2. Otimizações Futuras

#### Queue System
```php
// Jobs assíncronos
dispatch(new ProcessDocumentJob($document));
dispatch(new SendEmailNotificationJob($user, $message));
```

#### Microserviços
- Separação do sistema de documentos
- API Gateway
- Service discovery
- Event-driven architecture

## Manutenção e Suporte

### 1. Rotinas de Manutenção

#### Diárias
- Backup automático
- Limpeza de logs antigos
- Verificação de saúde do sistema

#### Semanais
- Análise de performance
- Revisão de logs de segurança
- Atualização de dependências

#### Mensais
- Backup completo
- Análise de uso
- Planejamento de melhorias

### 2. Documentação Técnica

- **API Documentation:** `/docs/technical/API_DOCUMENTATION.md`
- **Security Guide:** `/docs/technical/SECURITY_GUIDE.md`
- **Deployment Guide:** `/docs/technical/DEPLOYMENT_GUIDE.md`
- **Testing Guide:** `/docs/technical/TESTING_GUIDE.md`

## Conclusão

A arquitetura do TCamaraMunicipal foi projetada para ser:

- **Escalável:** Suporta crescimento de usuários e dados
- **Segura:** Implementa as melhores práticas de segurança
- **Manutenível:** Código organizado e bem documentado
- **Performática:** Otimizada para resposta rápida
- **Flexível:** Permite extensões e modificações

O sistema utiliza padrões consolidados do Laravel e segue as melhores práticas de desenvolvimento web, garantindo uma base sólida para o crescimento e evolução contínua da plataforma.