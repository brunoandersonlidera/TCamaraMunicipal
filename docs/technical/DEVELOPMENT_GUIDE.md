# 👨‍💻 Guia de Desenvolvimento - TCamaraMunicipal

## 📋 Índice
1. [Configuração do Ambiente](#configuração-do-ambiente)
2. [Padrões de Código](#padrões-de-código)
3. [Estrutura do Projeto](#estrutura-do-projeto)
4. [Convenções de Nomenclatura](#convenções-de-nomenclatura)
5. [Desenvolvimento de Features](#desenvolvimento-de-features)
6. [Testes](#testes)
7. [Git Workflow](#git-workflow)
8. [Debugging](#debugging)

## 🚀 Configuração do Ambiente

### Pré-requisitos
- **PHP**: 8.2 ou superior
- **Composer**: 2.x
- **Node.js**: 18.x ou superior
- **MySQL**: 8.0 ou superior
- **Git**: 2.x

### Setup Inicial
```bash
# Clone o repositório
git clone https://github.com/brunoandersonlidera/TCamaraMunicipal.git
cd TCamaraMunicipal

# Instale dependências
composer install
npm install

# Configure ambiente
cp .env.example .env
php artisan key:generate

# Configure banco de dados
php artisan migrate
php artisan db:seed

# Compile assets
npm run dev
```

### Ferramentas Recomendadas
- **IDE**: VS Code, PhpStorm
- **Extensions**: PHP Intelephense, Laravel Extension Pack
- **Database**: MySQL Workbench, phpMyAdmin
- **API Testing**: Postman, Insomnia

## 📝 Padrões de Código

### PSR Standards
O projeto segue os padrões PSR:
- **PSR-1**: Basic Coding Standard
- **PSR-2**: Coding Style Guide
- **PSR-4**: Autoloader Standard
- **PSR-12**: Extended Coding Style

### Laravel Conventions
```php
// Nomes de Classes (PascalCase)
class VereadorController extends Controller
{
    // Métodos (camelCase)
    public function criarSessao()
    {
        // Variáveis (camelCase)
        $sessaoPlenaria = new SessaoPlenaria();
        
        // Constantes (UPPER_CASE)
        const STATUS_ATIVO = 'ativo';
    }
}
```

### Estrutura de Controllers
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vereador;
use App\Http\Requests\VereadorRequest;
use Illuminate\Http\Request;

class VereadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vereadores = Vereador::paginate(15);
        return view('admin.vereadores.index', compact('vereadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vereadores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VereadorRequest $request)
    {
        $vereador = Vereador::create($request->validated());
        
        return redirect()
            ->route('admin.vereadores.index')
            ->with('success', 'Vereador criado com sucesso!');
    }

    // ... outros métodos
}
```

### Estrutura de Models
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vereador extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'partido',
        'foto',
        'biografia',
        'ativo'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'ativo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function sessoes()
    {
        return $this->belongsToMany(SessaoPlenaria::class);
    }

    /**
     * Scopes
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Accessors
     */
    public function getNomeCompletoAttribute()
    {
        return $this->nome;
    }
}
```

## 🏗️ Estrutura do Projeto

### Organização de Diretórios
```
app/
├── Console/Commands/          # Comandos Artisan customizados
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # Controllers administrativos
│   │   ├── Api/              # Controllers da API
│   │   └── Public/           # Controllers públicos
│   ├── Middleware/           # Middlewares customizados
│   ├── Requests/             # Form Requests
│   └── Resources/            # API Resources
├── Models/                   # Models Eloquent
├── Services/                 # Services/Business Logic
└── Traits/                   # Traits reutilizáveis

resources/
├── views/
│   ├── admin/               # Views administrativas
│   ├── public/              # Views públicas
│   ├── components/          # Componentes Blade
│   └── layouts/             # Layouts base
├── css/                     # Estilos CSS
└── js/                      # JavaScript

database/
├── migrations/              # Migrações
├── seeders/                # Seeders
└── factories/              # Factories
```

### Namespaces
```php
// Controllers Administrativos
App\Http\Controllers\Admin\VereadorController

// Controllers Públicos
App\Http\Controllers\Public\HomeController

// Controllers da API
App\Http\Controllers\Api\V1\VereadorController

// Services
App\Services\VereadorService

// Requests
App\Http\Requests\VereadorRequest
```

## 🏷️ Convenções de Nomenclatura

### Banco de Dados
```sql
-- Tabelas (plural, snake_case)
vereadores
sessoes_plenarias
projetos_lei

-- Colunas (snake_case)
nome_completo
data_nascimento
created_at

-- Índices
idx_vereadores_ativo
idx_sessoes_data
```

### Rotas
```php
// Rotas administrativas
Route::prefix('admin')->group(function () {
    Route::resource('vereadores', VereadorController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

// Rotas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('vereadores', [VereadorController::class, 'index'])->name('vereadores.index');

// Rotas da API
Route::prefix('api/v1')->group(function () {
    Route::apiResource('vereadores', VereadorController::class);
});
```

### Views
```
admin/
├── vereadores/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── dashboard.blade.php

public/
├── home.blade.php
├── vereadores/
│   ├── index.blade.php
│   └── show.blade.php
```

## 🔧 Desenvolvimento de Features

### Workflow de Desenvolvimento
1. **Análise**: Entender o requisito
2. **Design**: Planejar a implementação
3. **Migration**: Criar/alterar tabelas
4. **Model**: Criar/atualizar models
5. **Controller**: Implementar lógica
6. **Views**: Criar interfaces
7. **Routes**: Definir rotas
8. **Tests**: Escrever testes
9. **Documentation**: Documentar

### Exemplo: Nova Feature "Comissões"

#### 1. Migration
```php
// database/migrations/create_comissoes_table.php
public function up()
{
    Schema::create('comissoes', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->text('descricao')->nullable();
        $table->boolean('ativa')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });
}
```

#### 2. Model
```php
// app/Models/Comissao.php
class Comissao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'descricao', 'ativa'];
    protected $casts = ['ativa' => 'boolean'];

    public function vereadores()
    {
        return $this->belongsToMany(Vereador::class);
    }
}
```

#### 3. Controller
```php
// app/Http/Controllers/Admin/ComissaoController.php
class ComissaoController extends Controller
{
    public function index()
    {
        $comissoes = Comissao::paginate(15);
        return view('admin.comissoes.index', compact('comissoes'));
    }
    
    // ... outros métodos
}
```

#### 4. Request
```php
// app/Http/Requests/ComissaoRequest.php
class ComissaoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativa' => 'boolean'
        ];
    }
}
```

#### 5. Routes
```php
// routes/web.php
Route::prefix('admin')->group(function () {
    Route::resource('comissoes', ComissaoController::class);
});
```

## 🧪 Testes

### Estrutura de Testes
```
tests/
├── Feature/                 # Testes de integração
│   ├── Admin/
│   │   └── VereadorTest.php
│   └── Public/
│       └── HomeTest.php
├── Unit/                    # Testes unitários
│   ├── Models/
│   │   └── VereadorTest.php
│   └── Services/
│       └── VereadorServiceTest.php
```

### Exemplo de Teste
```php
// tests/Feature/Admin/VereadorTest.php
class VereadorTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pode_listar_vereadores()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $vereadores = Vereador::factory(3)->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.vereadores.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.vereadores.index');
        $response->assertViewHas('vereadores');
    }

    public function test_admin_pode_criar_vereador()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $dadosVereador = [
            'nome' => 'João Silva',
            'email' => 'joao@email.com',
            'partido' => 'PT',
            'ativo' => true
        ];

        $response = $this->actingAs($admin)
            ->post(route('admin.vereadores.store'), $dadosVereador);

        $response->assertRedirect(route('admin.vereadores.index'));
        $this->assertDatabaseHas('vereadores', $dadosVereador);
    }
}
```

### Executar Testes
```bash
# Todos os testes
php artisan test

# Testes específicos
php artisan test --filter VereadorTest

# Com coverage
php artisan test --coverage
```

## 🌿 Git Workflow

### Branch Strategy
```
main                    # Produção
├── develop            # Desenvolvimento
│   ├── feature/nova-funcionalidade
│   ├── bugfix/correcao-bug
│   └── hotfix/correcao-urgente
```

### Convenções de Commit
```bash
# Formato
tipo(escopo): descrição

# Tipos
feat: nova funcionalidade
fix: correção de bug
docs: documentação
style: formatação
refactor: refatoração
test: testes
chore: tarefas de manutenção

# Exemplos
feat(vereadores): adicionar filtro por partido
fix(ouvidoria): corrigir envio de email
docs(readme): atualizar instruções de instalação
```

### Workflow
```bash
# Criar nova feature
git checkout develop
git pull origin develop
git checkout -b feature/nova-funcionalidade

# Desenvolver e commitar
git add .
git commit -m "feat(funcionalidade): implementar nova funcionalidade"

# Push e Pull Request
git push origin feature/nova-funcionalidade
# Criar PR no GitHub/GitLab

# Merge para develop
git checkout develop
git pull origin develop
git branch -d feature/nova-funcionalidade
```

## 🐛 Debugging

### Laravel Debugbar
```bash
# Instalar (apenas desenvolvimento)
composer require barryvdh/laravel-debugbar --dev
```

### Logs
```php
// Usar logs para debugging
Log::info('Dados do vereador', ['vereador' => $vereador]);
Log::error('Erro ao salvar vereador', ['error' => $e->getMessage()]);

// Debug específico
logger('Debug info', ['data' => $data]);
```

### Tinker
```bash
# Acessar console interativo
php artisan tinker

# Testar código
>>> $vereador = App\Models\Vereador::first()
>>> $vereador->nome
```

### Debugging Tools
```php
// dd() - Dump and Die
dd($variable);

// dump() - Dump sem parar execução
dump($variable);

// Xdebug (configurar no IDE)
xdebug_break();
```

## 📚 Recursos Adicionais

### Documentação
- [Laravel Documentation](https://laravel.com/docs)
- [PHP The Right Way](https://phptherightway.com/)
- [PSR Standards](https://www.php-fig.org/psr/)

### Ferramentas
- [Laravel Telescope](https://laravel.com/docs/telescope) - Debugging
- [Laravel Horizon](https://laravel.com/docs/horizon) - Queue monitoring
- [Larastan](https://github.com/nunomaduro/larastan) - Static analysis

### Comunidade
- [Laravel Brasil](https://github.com/laravelbrasil)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel)
- [Laravel News](https://laravel-news.com/)

## 📞 Suporte

Para dúvidas sobre desenvolvimento:
- **Email**: dev@lideratecnologia.com.br
- **WhatsApp**: (65) 99920-5608
- **Documentação**: [Guia de Contribuição](CONTRIBUTING.md)

---

**Última atualização**: Janeiro 2025  
**Versão**: 1.0.0